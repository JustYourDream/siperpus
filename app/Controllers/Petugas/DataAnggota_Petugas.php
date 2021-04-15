<?php
namespace App\Controllers\Petugas;
require ('../vendor/autoload.php');
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
        $no++;
        $row = [];
        $row[] = $no;
        $row[] = $list->no_anggota;
        $row[] = '<img src="'."".$foto."".'" width="100px" height="100px">';
        $row[] = $list->nama_anggota;
        $row[] = $list->tempat_lahir;
        $row[] = $list->tanggal_lahir;
        $row[] = $list->alamat_anggota;
        $row[] = $list->agama_anggota;
        $row[] = $list->jkel_anggota;
        $row[] = '<img src="'."".$qr."".'" width="50px" height="50px">';
        $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_anggota('."'".$list->no_anggota."'".')"><i class="ni ni-active-40"></i> Ubah</a>
        <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus_anggota('."'".$list->no_anggota."'".')"><i class="ni ni-scissors"></i> Hapus</a>';
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
}

?>
