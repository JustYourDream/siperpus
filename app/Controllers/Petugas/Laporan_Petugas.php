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
		return view('petugas/laporan_petugas');
	}
	public function penambahan_bulanan()
	{
		$request = Services::request();
		$db = \Config\Database::connect();
		$buku = new InsertBukuModel($request);

    $mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'orientation' => 'P', 'format' => [210,330]]);
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
      <h1><font size="5" face="times new roman">PERPUSTAKAAN "INTI GADING"</font></h1>
      <b><font size="4" face="Courier New">SMK NEGERI 1 AMPELGADING</font></b><br/>
      <b>Jl. Raya Ujunggede (Pantura), Ampelgading, Kabupaten Pemalang, 52364<b><br/><br/>
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
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Karya Umum'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).' Jdl</td>
			</tr>
			<tr>
				<td align="center">2</td>
				<td>Filsafat</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Filsafat'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Filsafat'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Filsafat'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Filsafat'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Filsafat'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Filsafat'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).' Jdl</td>
			</tr>
			<tr>
				<td align="center">3</td>
				<td>Agama</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Agama'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Agama'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Agama'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Agama'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Agama'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Agama'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).' Jdl</td>
			</tr>
			<tr>
				<td align="center">4</td>
				<td>Ilmu Sosial</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu Sosial'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu Sosial'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu Sosial'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu Sosial'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu Sosial'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu Sosial'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).' Jdl</td>
			</tr>
			<tr>
				<td align="center">5</td>
				<td>Bahasa</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Bahasa'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Bahasa'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Bahasa'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Bahasa'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Bahasa'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Bahasa'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).' Jdl</td>
			</tr>
			<tr>
				<td align="center">6</td>
				<td>Ilmu-ilmu & Matematika</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Ilmu-ilmu & Matematika'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).' Jdl</td>
			</tr>
			<tr>
				<td align="center">7</td>
				<td>Teknologi & Ilmu Terapan</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Teknologi & Ilmu Terapan'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).' Jdl</td>
			</tr>
			<tr>
				<td align="center">8</td>
				<td>Kesenian, Hiburan & Olahraga</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesenian, Hiburan & Olahraga'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).' Jdl</td>
			</tr>
			<tr>
				<td align="center">9</td>
				<td>Kesusastraan</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesusastraan'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesusastraan'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesusastraan'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesusastraan'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Kesusastraan'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Kesusastraan'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).' Jdl</td>
			</tr>
			<tr>
				<td align="center">10</td>
				<td>Sejarah Biografi</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Sejarah Biografi'])->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Sejarah Biografi'])->where('DATE(tanggal_insert) <', $date_awal)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Sejarah Biografi'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Sejarah Biografi'])->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</td>
				<td align="center">'.$db->table('insert_buku')->selectCount('no_induk')->where(['kategori_buku' => 'Sejarah Biografi'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</td>
				<td align="center">'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where(['kategori_buku' => 'Sejarah Biografi'])->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).' Jdl</td>
			</tr>
			<tr>
			<td colspan="2" align="center"><b>Total</b></td>
			<td align="center"><b>'.$db->table('insert_buku')->selectCount('no_induk')->where('DATE(tanggal_insert) <', $date_awal)->countAllResults().'</b></td>
			<td align="center"><b>'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where('DATE(tanggal_insert) <', $date_awal)->first()).'</b></td>
			<td align="center"><b>'.$db->table('insert_buku')->selectCount('no_induk')->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->countAllResults().'</b></td>
			<td align="center"><b>'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where('MONTH(tanggal_insert) =', $bulan)->where('YEAR(tanggal_insert) =', $tahun)->first()).'</b></td>
			<td align="center"><b>'.$db->table('insert_buku')->selectCount('no_induk')->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->countAllResults().'</b></td>
			<td align="center"><b>'.implode(" ",$buku->select('COALESCE(SUM(eksemplar_buku),0)')->where('DATE(tanggal_insert) <= LAST_DAY("'.$date_awal.'")')->first()).' Jdl</b></td>
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
}