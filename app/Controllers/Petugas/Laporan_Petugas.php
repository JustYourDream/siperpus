<?php

namespace App\Controllers\Petugas;
use Mpdf\Mpdf;
use CodeIgniter\Controller;
use App\Models\InsertBukuModel;
use Config\Services;

class Laporan_Petugas extends Controller
{
	public function index()
	{
		$data['title'] = 'Buat Laporan';
		if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Petugas"){
				return view('petugas/laporan_petugas', $data);
			}else{
				return view('access_denied');
			}
		}
	}
	public function penambahan_bulanan()
	{
		$request = Services::request();
		$db = \Config\Database::connect();
		$buku = new InsertBukuModel($request);

    $mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'orientation' => 'P', 'format' => [210,330]]);
    $mpdf->curlAllowUnsafeSslRequests = true;

		$bulan = $request->getPost('Bulan');
		$tahun = $request->getPost('year');
		$date_awal = $tahun.'-'.$bulan.'-'.'1';

		$mpdf->WriteHTML('
		<style>
      .title{
        text-align: center;
      }
      .ttd{
        text-align: center;
      }
    </style>
		<div style="text-align: center;">
      <hr><width="100" height="75"></hr>
			<table width="100%" cellspacing="10px">
				<tr>
					<td rowspan="3" align="center">
						<img src="'.base_url('assets/img/brand/amgalogo.png').'" height="80px" width="80px">
					</td>
					<td align="center">
						<h1><font size="4" face="times new roman">PERPUSTAKAAN "INTI GADING"</font></h1>
					</td>
					<td rowspan="3" align="center">
						<img src="'.base_url('assets/img/brand/pendidikan.png').'" height="80px" width="80px">
					</td>
				</tr>
				<tr>
					<td align="center">
						<b><font size="5" face="Times New Roman">SMK NEGERI 1 AMPELGADING</font></b>
					</td>
				</tr>
				<tr>
					<td align="center">
						<b><font size="2" face="Times New Roman">Jl. Raya Ujunggede (Pantura), Ampelgading, Kabupaten Pemalang, 52364</font><b>
					</td>
				</tr>
			</table>
      <hr><width="100" height="75"></hr>
    </div>
		<div>
		<table style="margin-bottom: 20px;">
			<tr>
				<td>Nomor</td>
				<td>:</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/</td>
			</tr>
			<tr>
				<td>Lamp.</td>
				<td>:</td>
				<td> -</td>
			</tr>
			<tr>
				<td>Hal</td>
				<td>:</td>
				<td> Rekap Penambahan Bulanan</td>
			</tr>
		</table>
		<p>Diberitahukan dengan hormat bahwa di bawah ini adalah laporan penambahan pustaka bulan '.$bulan.'/'.$tahun.' perpustakaan "Inti Gading" :</p>
		<table border="1" cellspacing="0" cellpadding="5" width="100%">
			<tr>
				<td rowspan="2">No.</td>
				<td rowspan="2" align="center">Jenis</td>
				<td colspan="2" align="center">Awal '.$bulan.'/'.$tahun.'</td>
				<td colspan="2" align="center">Penambahan</td>
				<td colspan="2" align="center">Akhir '.$bulan.'/'.$tahun.'</td>
			</tr>
			<tr>
				<td>Judul</td>
				<td>Eksemplar</td>
				<td>Judul</td>
				<td>Eksemplar</td>
				<td>Judul</td>
				<td>Eksemplar</td>
			</tr>
			<tr>
				<td align="center">1</td>
				<td>Karya Umum</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Karya Umum'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Karya Umum'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Karya Umum'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Karya Umum'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Karya Umum'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Karya Umum'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
			</tr>
			<tr>
				<td align="center">2</td>
				<td>Filsafat</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Filsafat'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Filsafat'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Filsafat'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Filsafat'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Filsafat'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Filsafat'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
			</tr>
			<tr>
				<td align="center">3</td>
				<td>Agama</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Agama'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Agama'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Agama'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Agama'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Agama'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Agama'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
			</tr>
			<tr>
				<td align="center">4</td>
				<td>Ilmu Sosial</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu Sosial'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu Sosial'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu Sosial'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu Sosial'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu Sosial'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu Sosial'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
			</tr>
			<tr>
				<td align="center">5</td>
				<td>Bahasa</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Bahasa'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Bahasa'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Bahasa'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Bahasa'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Bahasa'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Bahasa'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
			</tr>
			<tr>
				<td align="center">6</td>
				<td>Ilmu-ilmu & Matematika</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
			</tr>
			<tr>
				<td align="center">7</td>
				<td>Teknologi & Ilmu Terapan</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
			</tr>
			<tr>
				<td align="center">8</td>
				<td>Kesenian, Hiburan & Olahraga</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
			</tr>
			<tr>
				<td align="center">9</td>
				<td>Kesusastraan</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesusastraan'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesusastraan'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesusastraan'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesusastraan'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesusastraan'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesusastraan'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
			</tr>
			<tr>
				<td align="center">10</td>
				<td>Sejarah Biografi</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Sejarah Biografi'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Sejarah Biografi'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Sejarah Biografi'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Sejarah Biografi'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Sejarah Biografi'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Sejarah Biografi'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
			</tr>
			<tr>
			<td colspan="2" align="center"><b>Total</b></td>
			<td align="center"><b>'.$db->table('insert_buku')->selectCount('no_induk')->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</b></td>
			<td align="center"><b>'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where('DATE(tanggal_insert) <', $date_awal)->first()).'</b></td>
			<td align="center"><b>'.$db->table('insert_buku')->selectCount('no_induk')->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</b></td>
			<td align="center"><b>'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</b></td>
			<td align="center"><b>'.$db->table('insert_buku')->selectCount('no_induk')->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</b></td>
			<td align="center"><b>'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</b></td>
			</tr>
		</table>
		</div>
		<div style="margin-top: 40px;">
      <table width="100%">
        <tr>
          <td rowspan="5" width="65%"></td>
          <td class="ttd">Ampelgading, '.date('d-m-Y').'</td>
        </tr>
        <tr>
          <td class="ttd">Ketua Perpustakaan "Inti Gading"</td>
        </tr>
        <tr>
          <td height="80px"></td>
        </tr>
        <tr>
          <td class="ttd"><b><u>Alfian Maulana</u></b></td>
        </tr>
        <tr>
          <td class="ttd">NIP : 18.110.0018</td>
        </tr>
      </table>
    </div>
		');

    $mpdf->Output('Penambahan_Bulanan_('.$bulan.'-'.$tahun.').pdf','I');
    exit;
	}
	public function peminjaman_bulanan()
	{
		$request = Services::request();
		$db = \Config\Database::connect();
		$buku = new InsertBukuModel($request);

    $mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'orientation' => 'P', 'format' => [210,330]]);
    $mpdf->curlAllowUnsafeSslRequests = true;

		$bulan = $request->getPost('monthRent');
		$tahun = $request->getPost('yearRent');
		$date_awal = $tahun.'-'.$bulan.'-'.'1';

		$mpdf->WriteHTML('
		<style>
      .title{
        text-align: center;
      }
      .ttd{
        text-align: center;
      }
    </style>
		<div style="text-align: center;">
      <hr><width="100" height="75"></hr>
			<table width="100%" cellspacing="10px">
				<tr>
					<td rowspan="3" align="center">
						<img src="'.base_url('assets/img/brand/amgalogo.png').'" height="80px" width="80px">
					</td>
					<td align="center">
						<h1><font size="4" face="times new roman">PERPUSTAKAAN "INTI GADING"</font></h1>
					</td>
					<td rowspan="3" align="center">
						<img src="'.base_url('assets/img/brand/pendidikan.png').'" height="80px" width="80px">
					</td>
				</tr>
				<tr>
					<td align="center">
						<b><font size="5" face="Times New Roman">SMK NEGERI 1 AMPELGADING</font></b>
					</td>
				</tr>
				<tr>
					<td align="center">
						<b><font size="2" face="Times New Roman">Jl. Raya Ujunggede (Pantura), Ampelgading, Kabupaten Pemalang, 52364</font><b>
					</td>
				</tr>
			</table>
      <hr><width="100" height="75"></hr>
    </div>
		<div>
		<table style="margin-bottom: 20px;">
			<tr>
				<td>Nomor</td>
				<td>:</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/</td>
			</tr>
			<tr>
				<td>Lamp.</td>
				<td>:</td>
				<td> -</td>
			</tr>
			<tr>
				<td>Hal</td>
				<td>:</td>
				<td> Rekap Peminjaman Bulanan</td>
			</tr>
		</table>
		<p>Diberitahukan dengan hormat bahwa di bawah ini adalah laporan peminjaman buku bulan '.$bulan.'/'.$tahun.' perpustakaan "Inti Gading" :</p>
		<table border="1" cellspacing="0" cellpadding="5" width="100%">
			<tr>
				<td align="center">No.</td>
				<td align="center">Jenis</td>
				<td align="center">Jumlah Pinjam Bulan '.$bulan.'-'.$tahun.'</td>
			</tr>
			<tr>
				<td align="center">1</td>
				<td>Karya Umum</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Karya Umum")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">2</td>
				<td>Filsafat</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Filsafat")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">3</td>
				<td>Agama</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Agama")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">4</td>
				<td>Ilmu Sosial</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Ilmu Sosial")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">5</td>
				<td>Bahasa</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Bahasa")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">6</td>
				<td>Ilmu-ilmu & Matematika</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Ilmu-ilmu & Matematika")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">7</td>
				<td>Teknologi & Ilmu Terapan</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Teknologi & Ilmu Terapan")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">8</td>
				<td>Kesenian, Hiburan & Olahraga</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Kesenian, Hiburan & Olahraga")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">9</td>
				<td>Kesusastraan</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Kesusastraan")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">10</td>
				<td>Sejarah Biografi</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Sejarah Biografi")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
			  <td colspan="2" align="center"><b>Total</b></td>
			  <td align="center"><b>'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</b></td>
			</tr>
		</table>
		</div>
		<div style="margin-top: 40px;">
      <table width="100%">
        <tr>
          <td rowspan="5" width="65%"></td>
          <td class="ttd">Ampelgading, '.date('d-m-Y').'</td>
        </tr>
        <tr>
          <td class="ttd">Ketua Perpustakaan "Inti Gading"</td>
        </tr>
        <tr>
          <td height="80px"></td>
        </tr>
        <tr>
          <td class="ttd"><b><u>Alfian Maulana</u></b></td>
        </tr>
        <tr>
          <td class="ttd">NIP : 18.110.0018</td>
        </tr>
      </table>
    </div>
		');

    $mpdf->Output('Peminjaman_Bulanan_('.$bulan.'-'.$tahun.').pdf','I');
    exit;
	}
	public function keseluruhan_bulanan()
	{
		$request = Services::request();
		$db = \Config\Database::connect();
		$buku = new InsertBukuModel($request);

    $mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'orientation' => 'P', 'format' => [210,330]]);
    $mpdf->curlAllowUnsafeSslRequests = true;

		$bulan = $request->getPost('monthAll');
		$tahun = $request->getPost('years');
		$date_awal = $tahun.'-'.$bulan.'-'.'1';

		$mpdf->WriteHTML('
		<style>
      .title{
        text-align: center;
      }
      .ttd{
        text-align: center;
      }
    </style>
		<div style="text-align: center;">
      <hr><width="100" height="75"></hr>
			<table width="100%" cellspacing="10px">
				<tr>
					<td rowspan="3" align="center">
						<img src="'.base_url('assets/img/brand/amgalogo.png').'" height="80px" width="80px">
					</td>
					<td align="center">
						<h1><font size="4" face="times new roman">PERPUSTAKAAN "INTI GADING"</font></h1>
					</td>
					<td rowspan="3" align="center">
						<img src="'.base_url('assets/img/brand/pendidikan.png').'" height="80px" width="80px">
					</td>
				</tr>
				<tr>
					<td align="center">
						<b><font size="5" face="Times New Roman">SMK NEGERI 1 AMPELGADING</font></b>
					</td>
				</tr>
				<tr>
					<td align="center">
						<b><font size="2" face="Times New Roman">Jl. Raya Ujunggede (Pantura), Ampelgading, Kabupaten Pemalang, 52364</font><b>
					</td>
				</tr>
			</table>
      <hr><width="100" height="75"></hr>
    </div>
		<div>
		<table style="margin-bottom: 20px;">
			<tr>
				<td>Nomor</td>
				<td>:</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/</td>
			</tr>
			<tr>
				<td>Lamp.</td>
				<td>:</td>
				<td> -</td>
			</tr>
			<tr>
				<td>Hal</td>
				<td>:</td>
				<td> Rekap Penambahan & Peminjaman Bulanan</td>
			</tr>
		</table>
		<p>Diberitahukan dengan hormat bahwa di bawah ini adalah laporan penambahan dan peminjaman bulan '.$bulan.'/'.$tahun.' perpustakaan "Inti Gading" :</p>
		<table border="1" cellspacing="0" cellpadding="5" width="100%">
			<tr>
				<td rowspan="2">No.</td>
				<td rowspan="2" align="center">Jenis</td>
				<td colspan="2" align="center">Awal '.$bulan.'/'.$tahun.'</td>
				<td colspan="2" align="center">Penambahan</td>
				<td colspan="2" align="center">Akhir '.$bulan.'/'.$tahun.'</td>
				<td rowspan="2" align="center">Jml. Pinj '.$bulan.'-'.$tahun.'</td>
			</tr>
			<tr>
				<td>Judul</td>
				<td>Eksp.</td>
				<td>Judul</td>
				<td>Eksp.</td>
				<td>Judul</td>
				<td>Eksp.</td>
			</tr>
			<tr>
				<td align="center">1</td>
				<td>Karya Umum</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Karya Umum'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Karya Umum'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Karya Umum'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Karya Umum'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Karya Umum'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Karya Umum'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Karya Umum")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">2</td>
				<td>Filsafat</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Filsafat'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Filsafat'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Filsafat'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Filsafat'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Filsafat'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Filsafat'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Filsafat")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">3</td>
				<td>Agama</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Agama'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Agama'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Agama'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Agama'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Agama'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Agama'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Agama")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">4</td>
				<td>Ilmu Sosial</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu Sosial'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu Sosial'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu Sosial'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu Sosial'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu Sosial'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu Sosial'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Ilmu Sosial")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">5</td>
				<td>Bahasa</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Bahasa'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Bahasa'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Bahasa'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Bahasa'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Bahasa'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Bahasa'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Bahasa")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">6</td>
				<td>Ilmu-ilmu & Matematika</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Ilmu-ilmu & Matematika")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">7</td>
				<td>Teknologi & Ilmu Terapan</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Teknologi & Ilmu Terapan")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">8</td>
				<td>Kesenian, Hiburan & Olahraga</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Kesenian, Hiburan & Olahraga")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">9</td>
				<td>Kesusastraan</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesusastraan'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesusastraan'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesusastraan'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesusastraan'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesusastraan'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesusastraan'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Kesusastraan")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">10</td>
				<td>Sejarah Biografi</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Sejarah Biografi'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Sejarah Biografi'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Sejarah Biografi'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Sejarah Biografi'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Sejarah Biografi'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Sejarah Biografi'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Sejarah Biografi")->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
			<td colspan="2" align="center"><b>Total</b></td>
			<td align="center"><b>'.$db->table('insert_buku')->selectCount('no_induk')->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</b></td>
			<td align="center"><b>'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where('DATE(tanggal_insert) <', $date_awal)->first()).'</b></td>
			<td align="center"><b>'.$db->table('insert_buku')->selectCount('no_induk')->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</b></td>
			<td align="center"><b>'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</b></td>
			<td align="center"><b>'.$db->table('insert_buku')->selectCount('no_induk')->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</b></td>
			<td align="center"><b>'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).'</b></td>
			<td align="center"><b>'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('MONTH(dp.tanggal_pinjam) =', $bulan)->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</b></td>
			</tr>
		</table>
		</div>
		<div style="margin-top: 40px;">
      <table width="100%">
        <tr>
          <td rowspan="5" width="65%"></td>
          <td class="ttd">Ampelgading, '.date('d-m-Y').'</td>
        </tr>
        <tr>
          <td class="ttd">Ketua Perpustakaan "Inti Gading"</td>
        </tr>
        <tr>
          <td height="80px"></td>
        </tr>
        <tr>
          <td class="ttd"><b><u>Alfian Maulana</u></b></td>
        </tr>
        <tr>
          <td class="ttd">NIP : 18.110.0018</td>
        </tr>
      </table>
    </div>
		');

    $mpdf->Output('Penambahan_Bulanan_('.$bulan.'-'.$tahun.').pdf','I');
    exit;
	}
	public function keseluruhan_tahunan()
	{
		$request = Services::request();
		$db = \Config\Database::connect();
		$buku = new InsertBukuModel($request);

    $mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'orientation' => 'P', 'format' => [210,330]]);
    $mpdf->curlAllowUnsafeSslRequests = true;

		$tahun = $request->getPost('yearAll');

		$mpdf->WriteHTML('
		<style>
      .title{
        text-align: center;
      }
      .ttd{
        text-align: center;
      }
    </style>
		<div style="text-align: center;">
      <hr><width="100" height="75"></hr>
			<table width="100%" cellspacing="10px">
				<tr>
					<td rowspan="3" align="center">
						<img src="'.base_url('assets/img/brand/amgalogo.png').'" height="80px" width="80px">
					</td>
					<td align="center">
						<h1><font size="4" face="times new roman">PERPUSTAKAAN "INTI GADING"</font></h1>
					</td>
					<td rowspan="3" align="center">
						<img src="'.base_url('assets/img/brand/pendidikan.png').'" height="80px" width="80px">
					</td>
				</tr>
				<tr>
					<td align="center">
						<b><font size="5" face="Times New Roman">SMK NEGERI 1 AMPELGADING</font></b>
					</td>
				</tr>
				<tr>
					<td align="center">
						<b><font size="2" face="Times New Roman">Jl. Raya Ujunggede (Pantura), Ampelgading, Kabupaten Pemalang, 52364</font><b>
					</td>
				</tr>
			</table>
      <hr><width="100" height="75"></hr>
    </div>
		<div>
		<table style="margin-bottom: 20px;">
			<tr>
				<td>Nomor</td>
				<td>:</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/</td>
			</tr>
			<tr>
				<td>Lamp.</td>
				<td>:</td>
				<td> -</td>
			</tr>
			<tr>
				<td>Hal</td>
				<td>:</td>
				<td> Rekap Penambahan & Peminjaman Tahunan</td>
			</tr>
		</table>
		<p>Diberitahukan dengan hormat bahwa di bawah ini adalah laporan penambahan dan peminjaman tahun '.$tahun.' perpustakaan "Inti Gading" :</p>
		<table border="1" cellspacing="0" cellpadding="5" width="100%">
			<tr>
				<td rowspan="2">No.</td>
				<td rowspan="2" align="center">Jenis</td>
				<td colspan="2" align="center">Awal '.$tahun.'</td>
				<td colspan="2" align="center">Penambahan</td>
				<td colspan="2" align="center">Akhir '.$tahun.'</td>
				<td rowspan="2" align="center">Jml. Pinj '.$tahun.'</td>
			</tr>
			<tr>
				<td>Judul</td>
				<td>Eksp.</td>
				<td>Judul</td>
				<td>Eksp.</td>
				<td>Judul</td>
				<td>Eksp.</td>
			</tr>
			<tr>
				<td align="center">1</td>
				<td>Karya Umum</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Karya Umum'])->where('YEAR(tanggal_insert) <', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Karya Umum'])->where('YEAR(tanggal_insert) <', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Karya Umum'])->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Karya Umum'])->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Karya Umum'])->where('YEAR(tanggal_insert) <=', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Karya Umum'])->where('YEAR(tanggal_insert) <=', $tahun)->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Karya Umum")->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">2</td>
				<td>Filsafat</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Filsafat'])->where('YEAR(tanggal_insert) <', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Filsafat'])->where('YEAR(tanggal_insert) <', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Filsafat'])->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Filsafat'])->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Filsafat'])->where('YEAR(tanggal_insert) <=', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Filsafat'])->where('YEAR(tanggal_insert) <=', $tahun)->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Filsafat")->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">3</td>
				<td>Agama</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Agama'])->where('YEAR(tanggal_insert) <', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Agama'])->where('YEAR(tanggal_insert) <', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Agama'])->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Agama'])->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Agama'])->where('YEAR(tanggal_insert) <=', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Agama'])->where('YEAR(tanggal_insert) <=', $tahun)->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Agama")->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">4</td>
				<td>Ilmu Sosial</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu Sosial'])->where('YEAR(tanggal_insert) <', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu Sosial'])->where('YEAR(tanggal_insert) <', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu Sosial'])->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu Sosial'])->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu Sosial'])->where('YEAR(tanggal_insert) <=', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu Sosial'])->where('YEAR(tanggal_insert) <=', $tahun)->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Ilmu Sosial")->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">5</td>
				<td>Bahasa</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Bahasa'])->where('YEAR(tanggal_insert) <', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Bahasa'])->where('YEAR(tanggal_insert) <', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Bahasa'])->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Bahasa'])->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Karya Umum'])->where('YEAR(tanggal_insert) <=', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Bahasa'])->where('YEAR(tanggal_insert) <=', $tahun)->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Bahasa")->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">6</td>
				<td>Ilmu-ilmu & Matematika</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('YEAR(tanggal_insert) <', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('YEAR(tanggal_insert) <', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('YEAR(tanggal_insert) <=', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('YEAR(tanggal_insert) <=', $tahun)->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Ilmu-ilmu & Matematika")->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">7</td>
				<td>Teknologi & Ilmu Terapan</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('YEAR(tanggal_insert) <', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('YEAR(tanggal_insert) <', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('YEAR(tanggal_insert) <=', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('YEAR(tanggal_insert) <=', $tahun)->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Teknologi & Ilmu Terapan")->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">8</td>
				<td>Kesenian, Hiburan & Olahraga</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('YEAR(tanggal_insert) <', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('YEAR(tanggal_insert) <', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('YEAR(tanggal_insert) <=', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('YEAR(tanggal_insert) <=', $tahun)->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Kesenian, Hiburan & Olahraga")->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">9</td>
				<td>Kesusastraan</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesusastraan'])->where('YEAR(tanggal_insert) <', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesusastraan'])->where('YEAR(tanggal_insert) <', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesusastraan'])->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesusastraan'])->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesusastraan'])->where('YEAR(tanggal_insert) <=', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesusastraan'])->where('YEAR(tanggal_insert) <=', $tahun)->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Kesusastraan")->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
				<td align="center">10</td>
				<td>Sejarah Biografi</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Sejarah Biografi'])->where('YEAR(tanggal_insert) <', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Sejarah Biografi'])->where('YEAR(tanggal_insert) <', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Sejarah Biografi'])->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Sejarah Biografi'])->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Sejarah Biografi'])->where('YEAR(tanggal_insert) <=', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Sejarah Biografi'])->where('YEAR(tanggal_insert) <=', $tahun)->first()).'</td>
				<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('db.kategori_buku =', "Sejarah Biografi")->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
			<tr>
			<td colspan="2" align="center"><b>Total</b></td>
			<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where('YEAR(tanggal_insert) <', $tahun)->countAllResults().'</td>
			<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where('YEAR(tanggal_insert) <', $tahun)->first()).'</td>
			<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
			<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
			<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where('YEAR(tanggal_insert) <=', $tahun)->countAllResults().'</td>
			<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where('YEAR(tanggal_insert) <=', $tahun)->first()).'</td>
			<td align="center">'.$db->table('data_peminjaman dp, data_buku db')->select('COUNT(dp.id_buku)')->where('dp.id_buku = db.no_induk')->where('YEAR(dp.tanggal_pinjam) =', $tahun)->countAllResults().'</td>
			</tr>
		</table>
		</div>
		<div style="margin-top: 40px;">
      <table width="100%">
        <tr>
          <td rowspan="5" width="65%"></td>
          <td class="ttd">Ampelgading, '.date('d-m-Y').'</td>
        </tr>
        <tr>
          <td class="ttd">Ketua Perpustakaan "Inti Gading"</td>
        </tr>
        <tr>
          <td height="80px"></td>
        </tr>
        <tr>
          <td class="ttd"><b><u>Alfian Maulana</u></b></td>
        </tr>
        <tr>
          <td class="ttd">NIP : 18.110.0018</td>
        </tr>
      </table>
    </div>
		');

    $mpdf->Output('Penambahan_Tahunan_('.$tahun.').pdf','I');
    exit;
	}
}
