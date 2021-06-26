<?php
namespace App\Controllers\Petugas;
use CodeIgniter\Controller;
use App\Models\KunjunganModel;
use Mpdf\Mpdf;
use Config\Services;

class DataPengunjung_Petugas extends Controller{

  public function index()
  {
    $request = Services::request();
    $pengunjung = new KunjunganModel($request);
    $jurusan = $pengunjung->get_list_jurusan();
    $tahun = $pengunjung->get_list_tahun();

    $data['form_jurusan'] = $jurusan;
    $data['form_tahun'] = $tahun;
    $data['title'] = 'Data Pengunjung';

    if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Petugas"){
				return view('petugas/data_pengunjung', $data);
			}else{
				return view('access_denied');
			}
		}
  }

  public function ajax_list()
  {
    $request = Services::request();
    $pengunjung = new KunjunganModel($request);
    if($request->getMethod(true)=='POST'){
      $lists = $pengunjung->get_datatables();
      $data = [];
      $no = $request->getPost("start");
      foreach ($lists as $list) {
        $no++;
        $row = [];
        $row[] = $no;
        $row[] = $list->no_anggota;
        $row[] = $list->nama;
        $row[] = $list->jurusan_anggota;
        $row[] = date("d-m-Y", strtotime($list->tanggal_kunjungan));
        $data[] = $row;
      }

      $output = ["draw" => $request->getPost('draw'),
      "recordsTotal" => $pengunjung->count_all(),
      "recordsFiltered" => $pengunjung->count_filtered(),
      "data" => $data];
      echo json_encode($output);
    }
  }

  public function cetak_data(){
    $request = Services::request();
    $pengunjung = new KunjunganModel($request);
    $table = '';
    $tabel_kunjungan = '';
    $header = '';
    $footer = '';
    $no = 1;
    $jurusan = $request->getPost('Jurusan');
    $bulan = $request->getPost('Bulan');
    $tahun = $request->getPost('Tahun');

    $mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'format' => [210, 330], 'orientation' => 'P']);
    $mpdf->curlAllowUnsafeSslRequests = true;

    $header .= '<div style="text-align: center;">
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
                </div>';

    $footer .= '<div style="margin-top: 20px;">
                  <table width="100%">
                    <tr>
                      <td rowspan="5" width="60%"></td>
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
                </div>';

    if($jurusan == NULL){
      $hasil = $pengunjung->where(['MONTH(tanggal_kunjungan)' => $bulan])->where(['YEAR(tanggal_kunjungan)' => $tahun])->get();
      foreach ($hasil->getResult('array') as $row) {
        $table .='<tr>
                    <td align="center">'.$no++.'</td>
                    <td align="center">'.$row['no_anggota'].'</td>
                    <td>'.$row['nama'].'</td>
                    <td>'.$row['jurusan_anggota'].'</td>
                    <td align="center">'.date('d-m-Y', strtotime($row['tanggal_kunjungan'])).'</td>
                  </tr>';
      }
      $kunjungan_terbanyak = $pengunjung->select('no_anggota, nama, jurusan_anggota, COUNT(no_anggota) AS jumlah')->groupBy('no_anggota')->orderBy('jumlah', 'DESC')->where(['MONTH(tanggal_kunjungan)' => $bulan])->where(['YEAR(tanggal_kunjungan)' => $tahun])->get(3);
      foreach ($kunjungan_terbanyak->getResult('array') as $row) {
        $tabel_kunjungan .='<tr>
                              <td align="center">'.$row['no_anggota'].'</td>
                              <td align="center">'.$row['nama'].'</td>
                              <td align="center">'.$row['jurusan_anggota'].'</td>
                              <td align="center">'.$row['jumlah'].' Kali</td>
                            </tr>';
      }
      $mpdf->WriteHTML('
      <style>
        .title{
          text-align: center;
        }
        .ttd{
          text-align: center;
        }
      </style>
      '.$header.'
      <div style="margin-top: 10px;">
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
            <td> Data Pengunjung Perpustakaan "Inti Gading"</td>
          </tr>
        </table>
        <p>Diberitahukan dengan hormat bahwa di bawah ini adalah data pengunjung perpustakaan "Inti Gading" pada tanggal '.$bulan.'/'.$tahun.' :</p>
        <table border="1" cellspacing="0" cellpadding="5" width="100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>No. Anggota</th>
              <th>Nama</th>
              <th>Jurusan</th>
              <th>Tgl. Kunjungan</th>
            </tr>
          </thead>
          <tbody>
              '.$table.'
          </tbody>
        </table>
      </div>
      <div style="margin-top: 10px; margin-bottom: 30px;">
        <p>3 Siswa dengan kunjungan terbanyak periode '.$bulan.'/'.$tahun.'</p>
        <table border="1" cellspacing="0" cellpadding="5px" width="100%">
          <thead>
            <tr>
              <th>No. Anggota</th>
              <th>Nama</th>
              <th>Jurusan</th>
              <th>Jml. Kunjungan</th>
            </tr>
          </thead>
          <tbody>
            '.$tabel_kunjungan.'
          </tbody>
        </table>
      </div>
      '.$footer.'
      ');

      $mpdf->Output('Daftar_Pengunjung_('.$bulan.'-'.$tahun.').pdf','I');
    } elseif ($jurusan != NULL) {
      $hasil = $pengunjung->where(['jurusan_anggota' => $jurusan])->where(['MONTH(tanggal_kunjungan)' => $bulan])->where(['YEAR(tanggal_kunjungan)' => $tahun])->get();
      foreach ($hasil->getResult('array') as $row) {
        $table .='<tr>
                    <td align="center">'.$no++.'</td>
                    <td align="center">'.$row['no_anggota'].'</td>
                    <td>'.$row['nama'].'</td>
                    <td align="center">'.date('d-m-Y', strtotime($row['tanggal_kunjungan'])).'</td>
                  </tr>';
      }
      $kunjungan_terbanyak = $pengunjung->select('no_anggota, nama, jurusan_anggota, COUNT(no_anggota) AS jumlah')->groupBy('no_anggota')->orderBy('jumlah','DESC')->where(['jurusan_anggota' => $jurusan])->where(['MONTH(tanggal_kunjungan)' => $bulan])->where(['YEAR(tanggal_kunjungan)' => $tahun])->get(1);
      foreach ($kunjungan_terbanyak->getResult('array') as $row) {
        $tabel_kunjungan .='<tr>
                              <td align="center">'.$row['no_anggota'].'</td>
                              <td align="center">'.$row['nama'].'</td>
                              <td align="center">'.$row['jumlah'].' Kali</td>
                            </tr>';
      }
      $mpdf->WriteHTML('
      <style>
        .title{
          text-align: center;
        }
        .ttd{
          text-align: center;
        }
      </style>
      '.$header.'
      <div style="margin-top: 10px;">
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
            <td> Data Pengunjung Perpustakaan "Inti Gading"</td>
          </tr>
        </table>
        <p>Diberitahukan dengan hormat bahwa di bawah ini adalah data pengunjung perpustakaan "Inti Gading" pada tanggal '.$bulan.'/'.$tahun.' jurusan '.$jurusan.' :</p>
        <table border="1" cellspacing="0" cellpadding="5" width="100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>No. Anggota</th>
              <th>Nama</th>
              <th>Tgl. Kunjungan</th>
            </tr>
          </thead>
          <tbody>
              '.$table.'
          </tbody>
        </table>
      </div>
      <div style="margin-top: 10px; margin-bottom: 30px;">
        <p>Siswa dengan kunjungan terbanyak periode '.$bulan.'/'.$tahun.'</p>
        <table border="1" cellspacing="0" cellpadding="5px" width="100%">
          <thead>
            <tr>
              <th>No. Anggota</th>
              <th>Nama</th>
              <th>Jml. Kunjungan</th>
            </tr>
          </thead>
          <tbody>
            '.$tabel_kunjungan.'
          </tbody>
        </table>
      </div>
      '.$footer.'
      ');

      $mpdf->Output('Pengunjung_('.$jurusan.')_('.$bulan.'-'.$tahun.').pdf','I');
    }
    exit;
  }
}
