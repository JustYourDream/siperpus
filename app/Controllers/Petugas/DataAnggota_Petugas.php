<?php
namespace App\Controllers\Petugas;
require ('../vendor/autoload.php');
use Mpdf\Mpdf;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use CodeIgniter\Controller;
use App\Models\AnggotaModel;
use Config\Services;

class DataAnggota_Petugas extends Controller{

  public function index()
  {
    echo view('/petugas/data_anggota');
  }
  public function ajax_list()
  {
    $request = Services::request();
    $anggota = new AnggotaModel($request);
    if($request->getMethod(true)=='POST'){
      $lists = $anggota->get_datatables();
      $data = [];
      $no = $request->getPost("start");
      foreach ($lists as $list) {
        $qr = base_url('assets/qr_anggota/'.$list->qr_anggota);
        $foto = base_url('assets/img/profile_pic/'.$list->foto_anggota);
        $url_cetak = base_url('Petugas/DataAnggota_Petugas/cetak_id_satuan/'.$list->no_anggota);
        $no++;
        $row = [];
        $row[] = $no;
        $row[] = $list->no_anggota;
        $row[] = '<img src="'."".$foto."".'" width="100px" height="100px">';
        $row[] = $list->nama_anggota;
        $row[] = $list->tempat_lahir.', '.date('d-m-Y',strtotime($list->tanggal_lahir));
        $row[] = $list->jurusan_anggota;
        $row[] = $list->alamat_anggota;
        $row[] = $list->agama_anggota;
        $row[] = $list->jkel_anggota;
        $row[] = '<img src="'."".$qr."".'" width="50px" height="50px">';
        $row[] = '<a class="btn btn-sm btn-primary btn-block" href="javascript:void(0)" title="Edit" onclick="edit_anggota('."'".$list->no_anggota."'".')"><i class="ni ni-active-40"></i> Ubah</a>
                  <a class="btn btn-sm btn-danger btn-block" href="javascript:void(0)" title="Hapus" onclick="hapus_anggota('."'".$list->no_anggota."'".')"><i class="ni ni-scissors"></i> Hapus</a>
                  <a class="btn btn-sm btn-default btn-block" href="'.$url_cetak.'" title="Cetak" target="_blank"><i class="ni ni-credit-card"></i> Cetak</a>';
        $data[] = $row;
      }

      $output = ["draw" => $request->getPost('draw'),
      "recordsTotal" => $anggota->count_all(),
      "recordsFiltered" => $anggota->count_filtered(),
      "data" => $data];
      echo json_encode($output);
    }
  }

  public function ajax_add()
  {
    helper(['form', 'url']);
    $request = Services::request();
    $anggota = new AnggotaModel($request);
    $writer = new PngWriter();

    $foto = null;

    //Create QR code
    $qrCode = QrCode::create(''.$request->getPost('NoAnggota').'')
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

    //Save QR
    $result = $writer->write($qrCode);
    $result->saveToFile('../public/assets/qr_anggota/'.$request->getPost('NoAnggota').'-QR.png');

    $input = $this->validate([
      'file' => [
              'uploaded[file]',
              'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
              'max_size[file,4096]',
          ],
		]);

    if(!$input){
      if($request->getPost('Jkel') == "Laki-laki"){
        $foto = "MALE-PIC";
      }elseif ($request->getPost('Jkel') == "Perempuan") {
        $foto = "FEMALE-PIC";
      }
    }
    else{
      //Generate nama file
      $random = date('s');
      $file = $this->request->getFile('file');
      $foto = $request->getPost('NoAnggota')."-PIC-".$random;
      $file->move(WRITEPATH . '../public/assets/img/profile_pic/',$foto);

      //Crop image
      $cropped_img = \Config\Services::image()->withFile('../public/assets/img/profile_pic/'.$foto)->fit(512,512, 'center')->save('../public/assets/img/profile_pic/'.$foto);
    }

    $data = array(
      'no_anggota' => $request->getPost('NoAnggota'),
      'nama_anggota' => $request->getPost('Nama'),
      'tempat_lahir' => $request->getPost('Tempat'),
      'tanggal_lahir' => $request->getPost('Tanggal'),
      'jurusan_anggota' => $request->getPost('Jurusan'),
      'alamat_anggota' => $request->getPost('Alamat'),
      'agama_anggota' => $request->getPost('Agama'),
      'jkel_anggota' => $request->getPost('Jkel'),
      'foto_anggota' => $foto,
      'qr_anggota' => ''.$request->getPost('NoAnggota').'-QR.png',
    );

    $data_akun = array(
      'nama' => $request->getPost('Nama'),
      'role' => "Anggota",
      'id' => $request->getPost('NoAnggota'),
      'password' => md5('12345678'),
    );

    $insert = $anggota->save_anggota($data);
    $insert_akun = $anggota->save_pengguna($data_akun);
    echo json_encode(array("status" => TRUE));
  }

  public function ajax_edit($id)
  {
    $request = Services::request();
    $anggota = new AnggotaModel($request);
    $lists = $anggota->get_by_id($id);
    echo json_encode($lists);
  }

  public function ajax_update()
  {
    helper(['form', 'url']);
    $request = Services::request();
    $anggota = new AnggotaModel($request);
    $foto = null;

    $input = $this->validate([
      'file' => [
              'uploaded[file]',
              'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
              'max_size[file,4096]',
          ],
		]);

    if(!$input){
      $foto = implode(" ",$anggota->select('foto_anggota')->where(['no_anggota' => $request->getPost('NoAnggota')])->first());
    }
    else{
      //Generate nama file
      $random = date('s');
			$nama_foto_before = implode(" ",$anggota->select('foto_anggota')->where(['no_anggota' => $request->getPost('NoAnggota')])->first());
      $file = $this->request->getFile('file');
      $foto = $request->getPost('NoAnggota')."-PIC-".$random;

      //Hapus Foto Sebelumnya
			$target_foto = "../public/assets/img/profile_pic/{$nama_foto_before}";
			if(is_file($target_foto) == TRUE){
				if(!($nama_foto_before == "FEMALE-PIC" || $nama_foto_before == "MALE-PIC")){
					unlink($target_foto);
				}
			}

      $file->move(WRITEPATH . '../public/assets/img/profile_pic/',$foto);

      //Crop image
      $cropped_img = \Config\Services::image()->withFile('../public/assets/img/profile_pic/'.$foto)->fit(512,512, 'center')->save('../public/assets/img/profile_pic/'.$foto);
    }

    $data = array(
      'nama_anggota' => $request->getPost('Nama'),
      'tempat_lahir' => $request->getPost('Tempat'),
      'tanggal_lahir' => $request->getPost('Tanggal'),
      'jurusan_anggota' => $request->getPost('Jurusan'),
      'alamat_anggota' => $request->getPost('Alamat'),
      'agama_anggota' => $request->getPost('Agama'),
      'jkel_anggota' => $request->getPost('Jkel'),
      'foto_anggota' => $foto,
    );

    //Data pengguna
    $data1 = array(
      'nama' => $request->getPost('Nama'),
    );

    $anggota->update_anggota(array('no_anggota' => $request->getPost('NoAnggota')), $data);
    $anggota->update_akun_anggota(array('id' => $request->getPost('NoAnggota')), $data1);
    echo json_encode(array("status" => TRUE));
  }

  public function ajax_delete($id)
  {
    $request = Services::request();
    $anggota = new AnggotaModel($request);

    //Hapus QR Code
    $qr = implode(" ",$anggota->select('qr_anggota')->where(['no_anggota' => $id])->first());
    $target_qr = "assets/qr_anggota/{$qr}";
    unlink($target_qr);

    //Hapus Foto
    $random = date('s');
    $foto = implode(" ",$anggota->select('no_anggota')->where(['no_anggota' => $id])->first()).'-PIC-'.$random;
    $target_foto = "../public/assets/img/profile_pic/{$foto}";
    if(is_file($target_foto) == TRUE){
      unlink($target_foto);
    }

    $anggota->delete_by_id($id);
    $anggota->delete_akun($id);
    echo json_encode(array("status" => TRUE));
  }

  public function cetak_id(){
    $request = Services::request();
    $anggota = new AnggotaModel($request);
    $hasil = $anggota->get();

    $mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'orientation' => 'L']);
    $mpdf->curlAllowUnsafeSslRequests = true;

    foreach ($hasil->getResult('array') as $row) {
      $foto = base_url('assets/img/profile_pic/'.$row['foto_anggota']);
      $qr = base_url('assets/qr_anggota/'.$row['qr_anggota']);
      $cover = base_url('assets/img/template_id/cover.jpg');
      $logo = base_url('assets/img/template_id/logo.png');
      $tgl = $row['tanggal_lahir'];
      $tgl_convert = date('d-m-Y', strtotime($tgl));
      $mpdf->WriteHTML('
          <style>
            .title{
              text-align: center;
              font-size: 13px;
            }
            .idCard{
              width: 380px;
              height: 210px;
              background-image: url("'.$cover.'");
              padding:10px;
              float: left;
              margin: 5px;
              border: 1px solid black;
              border-radius: 10px;
            }
            .alert{
              font-size: 11px;
            }
          </style>

          <div class="idCard">
            <table style="width: 100%; font-size: 12px" cellpadding="0" cellspacing="3">
              <tr>
                <td rowspan="3"><img src="'.$logo.'" height"60px" width="60px"></td>
                <td class="title" colspan="3">KARTU PERPUSTAKAAN</td>
              </tr>
              <tr>
                <td class="title" colspan="3"><b>"INTI GADING"</b></td>
              </tr>
              <tr>
                <td class="title" colspan="3" style="border-bottom: 2px solid black;">SMK NEGERI 1 AMPELGADING</td>
              </tr>
              <!-- Content -->
              <tr></tr>
              <tr>
                <td rowspan="7" width="90px"><img src="'.$foto.'" height="80px" width="80px"></td>
                <td width="80px">Nama</td>
                <td width="20px">:</td>
                <td>'.$row['nama_anggota'].'</td>
              </tr>
              <tr>
                <td>No. Anggota</td>
                <td>:</td>
                <td>'.$row['no_anggota'].'</td>
              </tr>
              <tr>
                <td>Jurusan</td>
                <td>:</td>
                <td>'.$row['jurusan_anggota'].'</td>
              </tr>
              <tr>
                <td>TTL</td>
                <td>:</td>
                <td>'.$row['tempat_lahir'].', '.$tgl_convert.'</td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>'.$row['alamat_anggota'].'</td>
              </tr>
              <tr>
                <td>Agama</td>
                <td>:</td>
                <td>'.$row['agama_anggota'].'</td>
              </tr>
              <tr>
                <td>Kelamin</td>
                <td>:</td>
                <td>'.$row['jkel_anggota'].'</td>
              </tr>
            </table>
          </div>

          <div class="idCard">
            <table style="width: 100%;" cellpadding="0" cellspacing="3">
              <tr>
                <td colspan="2" class="title">PERATURAN PERPUSTAKAAN</td>
              </tr>
              <tr>
                <td colspan="2" class="title" style="border-bottom: 2px solid black">"INTI GADING" SMK NEGERI 1 AMPELGADING</td>
              </tr>
              <tr>
                <td class="alert">1. </td>
                <td class="alert">Kartu ini digunakan untuk melakukan peminjaman buku</td>
              </tr>
              <tr>
                <td class="alert">2. </td>
                <td class="alert">Penyalahgunaan kartu ini akan dikenakan sanksi sesuai pelanggaran</td>
              </tr>
              <tr>
                <td class="alert">3. </td>
                <td class="alert">Jika kartu ini hilang atau rusak akan dikenakan biaya penggantian</td>
              </tr>
              <tr>
                <td class="alert">4. </td>
                <td class="alert">Kartu ini berlaku sejak menjadi siswa sampai selesai atau lulus</td>
              </tr>
              <tr>
                <td class="alert">5. </td>
                <td class="alert">Apabila kartu ini hilang/rusak, segera lapor ke petugas perpustakaan</td>
              </tr>
              <tr>
                <td colspan="2" style="text-align: right;"><img src="'.$qr.'" height="75px" width="75px"></td>
              </tr>
            </table>
          </div>
          ');
    }

    $mpdf->Output('Kartu_Anggota.pdf','I');
    exit;
  }

  public function cetak_id_satuan($id){
    $request = Services::request();
    $anggota = new AnggotaModel($request);
    $hasil = $anggota->where(['no_anggota' => $id])->get();

    $mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'orientation' => 'L']);
    $mpdf->curlAllowUnsafeSslRequests = true;

    foreach ($hasil->getResult('array') as $row) {
      $foto = base_url('assets/img/profile_pic/'.$row['foto_anggota']);
      $qr = base_url('assets/qr_anggota/'.$row['qr_anggota']);
      $cover = base_url('assets/img/template_id/cover.jpg');
      $logo = base_url('assets/img/template_id/logo.png');
      $tgl = $row['tanggal_lahir'];
      $tgl_convert = date('d-m-Y', strtotime($tgl));
      $mpdf->WriteHTML('
          <style>
            .title{
              text-align: center;
              font-size: 13px;
            }
            .idCard{
              width: 380px;
              height: 210px;
              background-image: url("'.$cover.'");
              padding:10px;
              float: left;
              margin: 5px;
              border: 1px solid black;
              border-radius: 10px;
            }
            .alert{
              font-size: 11px;
            }
          </style>

          <div class="idCard">
            <table style="width: 100%; font-size: 12px" cellpadding="0" cellspacing="3">
              <tr>
                <td rowspan="3"><img src="'.$logo.'" height"60px" width="60px"></td>
                <td class="title" colspan="3">KARTU PERPUSTAKAAN</td>
              </tr>
              <tr>
                <td class="title" colspan="3"><b>"INTI GADING"</b></td>
              </tr>
              <tr>
                <td class="title" colspan="3" style="border-bottom: 2px solid black;">SMK NEGERI 1 AMPELGADING</td>
              </tr>
              <!-- Content -->
              <tr></tr>
              <tr>
                <td rowspan="7" width="90px"><img src="'.$foto.'" height="80px" width="80px"></td>
                <td width="80px">Nama</td>
                <td width="20px">:</td>
                <td>'.$row['nama_anggota'].'</td>
              </tr>
              <tr>
                <td>No. Anggota</td>
                <td>:</td>
                <td>'.$row['no_anggota'].'</td>
              </tr>
              <tr>
                <td>Jurusan</td>
                <td>:</td>
                <td>'.$row['jurusan_anggota'].'</td>
              </tr>
              <tr>
                <td>TTL</td>
                <td>:</td>
                <td>'.$row['tempat_lahir'].', '.$tgl_convert.'</td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>'.$row['alamat_anggota'].'</td>
              </tr>
              <tr>
                <td>Agama</td>
                <td>:</td>
                <td>'.$row['agama_anggota'].'</td>
              </tr>
              <tr>
                <td>Kelamin</td>
                <td>:</td>
                <td>'.$row['jkel_anggota'].'</td>
              </tr>
            </table>
          </div>

          <div class="idCard">
            <table style="width: 100%;" cellpadding="0" cellspacing="3">
              <tr>
                <td colspan="2" class="title">PERATURAN PERPUSTAKAAN</td>
              </tr>
              <tr>
                <td colspan="2" class="title" style="border-bottom: 2px solid black">"INTI GADING" SMK NEGERI 1 AMPELGADING</td>
              </tr>
              <tr>
                <td class="alert">1. </td>
                <td class="alert">Kartu ini digunakan untuk melakukan peminjaman buku</td>
              </tr>
              <tr>
                <td class="alert">2. </td>
                <td class="alert">Penyalahgunaan kartu ini akan dikenakan sanksi sesuai pelanggaran</td>
              </tr>
              <tr>
                <td class="alert">3. </td>
                <td class="alert">Jika kartu ini hilang atau rusak akan dikenakan biaya penggantian</td>
              </tr>
              <tr>
                <td class="alert">4. </td>
                <td class="alert">Kartu ini berlaku sejak menjadi siswa sampai selesai atau lulus</td>
              </tr>
              <tr>
                <td class="alert">5. </td>
                <td class="alert">Apabila kartu ini hilang/rusak, segera lapor ke petugas perpustakaan</td>
              </tr>
              <tr>
                <td colspan="2" style="text-align: right;"><img src="'.$qr.'" height="75px" width="75px"></td>
              </tr>
            </table>
          </div>
          ');
    }

    $mpdf->Output('Kartu_Anggota_'.$id.'.pdf','I');
    exit;
  }

  public function cetak_list(){
    $request = Services::request();
    $anggota = new AnggotaModel($request);
    $hasil = $anggota->get();
    $table = '';
    $no = 1;

    $mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'format' => 'A4-L']);
    $mpdf->curlAllowUnsafeSslRequests = true;

    foreach ($hasil->getResult('array') as $row) {
      $tgl = $row['tanggal_lahir'];
      $tgl_convert = date('d-m-Y', strtotime($tgl));
      $table .='<tr>
                  <td align="center">'.$no++.'</td>
                  <td>'.$row['no_anggota'].'</td>
                  <td>'.$row['nama_anggota'].'</td>
                  <td>'.$row['jurusan_anggota'].'</td>
                  <td>'.$row['tempat_lahir'].', '.$tgl_convert.'</td>
                  <td>'.$row['alamat_anggota'].'</td>
                  <td>'.$row['agama_anggota'].'</td>
                  <td>'.$row['jkel_anggota'].'</td>
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
    <div style="text-align: center;">
      <hr><width="100" height="75"></hr>
      <h1><font size="5" face="times new roman">PERPUSTAKAAN "INTI GADING"</font></h1>
      <b><font size="4" face="Courier New">SMK NEGERI 1 AMPELGADING</font></b><br/>
      <b>Jl. Raya Ujunggede (Pantura), Ampelgading, Kabupaten Pemalang, 52364<b><br/><br/>
      <hr><width="100" height="75"></hr>
    </div>
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
          <td> Data Anggota Perpustakaan "Inti Gading"</td>
        </tr>
      </table>
      <p>Diberitahukan dengan hormat bahwa di bawah ini adalah data anggota perpustakaan "Inti Gading" :</p>
      <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
          <tr>
            <th>No.</th>
            <th>No Anggota</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Tempat & Tanggal Lahir</th>
            <th>Alamat</th>
            <th>Agama</th>
            <th>Jenis Kelamin</th>
          </tr>
        </thead>
        <tbody>
            '.$table.'
        </tbody>
      </table>
    </div>
    <div style="margin-top: 20px;">
      <table width="100%">
        <tr>
          <td rowspan="5" width="75%"></td>
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

    $mpdf->Output('Daftar_Anggota.pdf','I');
    exit;
  }
}

?>
