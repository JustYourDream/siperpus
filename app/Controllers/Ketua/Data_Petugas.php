<?php
namespace App\Controllers\Ketua;
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
use App\Models\PetugasModel;
use Config\Services;

class Data_Petugas extends Controller{

  public function index()
  {
    $data['title'] = 'Data Petugas';
    if(session()->get('logged_in') !== TRUE){
      session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
      return view('login/login');
    }else{
      if(session()->get('role') == "Ketua"){
        return view('ketua/data_petugas', $data);
      }else{
        return view('access_denied');
      }
    }
  }
  public function ajax_list()
  {
    $request = Services::request();
    $petugas = new PetugasModel($request);
    if($request->getMethod(true)=='POST'){
      $lists = $petugas->get_datatables();
      $data = [];
      $no = $request->getPost("start");
      foreach ($lists as $list) {
        $foto = base_url('assets/img/profile_pic/'.$list->foto_petugas);
        $no++;
        $row = [];
        $row[] = $no;
        $row[] = $list->id_petugas;
        $row[] = '<img src="'."".$foto."".'" width="100px" height="100px">';
        $row[] = $list->nama_petugas;
        $row[] = $list->jabatan_petugas;
        $row[] = $list->no_telp_petugas;
        $row[] = $list->alamat_petugas;
        $row[] = '<a class="btn btn-sm btn-primary btn-block" href="javascript:void(0)" title="Edit" onclick="edit_petugas('."'".$list->id_petugas."'".')"><i class="ni ni-active-40"></i> Ubah</a>
                  <a class="btn btn-sm btn-danger btn-block" href="javascript:void(0)" title="Hapus" onclick="hapus_petugas('."'".$list->id_petugas."'".')"><i class="ni ni-scissors"></i> Hapus</a>';
        $data[] = $row;
      }

      $output = ["draw" => $request->getPost('draw'),
      "recordsTotal" => $petugas->count_all(),
      "recordsFiltered" => $petugas->count_filtered(),
      "data" => $data];
      echo json_encode($output);
    }
  }

  public function ajax_add()
  {
    helper(['form', 'url']);
    $request = Services::request();
    $petugas = new PetugasModel($request);
    $foto = null;

    $this->_validate();

    $input = $this->validate([
      'file' => [
              'uploaded[file]',
              'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
              'max_size[file,4096]',
          ],
		]);

    if(!$input){
      $foto = "DEFAULT-PIC";
    }
    else{
      //Generate nama file
      $random = date('s');
      $file = $this->request->getFile('file');
      $foto = $request->getPost('IdPetugas')."-PIC-".$random;
      $file->move(WRITEPATH . '../public/assets/img/profile_pic/',$foto);

      //Crop image
      $cropped_img = \Config\Services::image()->withFile('../public/assets/img/profile_pic/'.$foto)->fit(512,512, 'center')->save('../public/assets/img/profile_pic/'.$foto);
    }

    $data = array(
      'id_petugas' => $request->getPost('IdPetugas'),
      'nama_petugas' => $request->getPost('Nama'),
      'jabatan_petugas' => "Petugas",
      'no_telp_petugas' => $request->getPost('Telp'),
      'alamat_petugas' => $request->getPost('Alamat'),
      'foto_petugas' => $foto,
    );

    $data_akun = array(
      'nama' => $request->getPost('Nama'),
      'role' => "Petugas",
      'id' => $request->getPost('IdPetugas'),
      'password' => md5('12345678'),
    );

    $insert = $petugas->save_petugas($data);
    $insert_akun = $petugas->save_pengguna($data_akun);
    echo json_encode(array("status" => TRUE));
  }

  public function ajax_edit($id)
  {
    $request = Services::request();
    $petugas = new PetugasModel($request);
    $lists = $petugas->petugas_id($id);
    echo json_encode($lists);
  }

  public function ajax_update()
  {
    helper(['form', 'url']);
    $request = Services::request();
    $petugas = new PetugasModel($request);
    $foto = null;

    $this->_validate();

    $input = $this->validate([
      'file' => [
              'uploaded[file]',
              'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
              'max_size[file,4096]',
          ],
		]);

    if(!$input){
      $foto = implode(" ",$petugas->select('foto_petugas')->where(['id_petugas' => $request->getPost('IdPetugas')])->first());
    }
    else{
      //Generate nama file
      $random = date('s');
			$nama_foto_before = implode(" ",$petugas->select('foto_petugas')->where(['id_petugas' => $request->getPost('IdPetugas')])->first());
      $file = $this->request->getFile('file');
      $foto = $request->getPost('IdPetugas')."-PIC-".$random;

      //Hapus Foto Sebelumnya
			$target_foto = "../public/assets/img/profile_pic/{$nama_foto_before}";
			if(is_file($target_foto) == TRUE){
				if(!($nama_foto_before == "DEFAULT-PIC")){
					unlink($target_foto);
				}
			}

      $file->move(WRITEPATH . '../public/assets/img/profile_pic/',$foto);

      //Crop image
      $cropped_img = \Config\Services::image()->withFile('../public/assets/img/profile_pic/'.$foto)->fit(512,512, 'center')->save('../public/assets/img/profile_pic/'.$foto);
    }

    $data = array(
      'nama_petugas' => $request->getPost('Nama'),
      'no_telp_petugas' => $request->getPost('Telp'),
      'alamat_petugas' => $request->getPost('Alamat'),
      'foto_petugas' => $foto,
    );

    //Data pengguna
    $data1 = array(
      'nama' => $request->getPost('Nama'),
    );

    $petugas->update_petugas(array('id_petugas' => $request->getPost('IdPetugas')), $data);
    $petugas->update_akun_petugas(array('id' => $request->getPost('IdPetugas')), $data1);
    echo json_encode(array("status" => TRUE));
  }

  public function ajax_delete($id)
  {
    $request = Services::request();
    $petugas = new PetugasModel($request);

    //Hapus Foto
    $foto = implode(" ",$petugas->select('foto_petugas')->where(['id_petugas' => $id])->first());
    $target_foto = "../public/assets/img/profile_pic/{$foto}";
    if(is_file($target_foto) == TRUE){
      unlink($target_foto);
    }

    $petugas->delete_by_id($id);
    $petugas->delete_akun($id);
    echo json_encode(array("status" => TRUE));
  }

  private function _validate(){
    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = TRUE;

    if($this->request->getPost('IdPetugas') == ''){
      $data['error_string'][] = 'IdPetugas';
      $data['inputerror'][] = 'ID Petugas harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('Nama') == ''){
      $data['error_string'][] = 'Nama';
      $data['inputerror'][] = 'Nama harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('Telp') == ''){
      $data['error_string'][] = 'Telp';
      $data['inputerror'][] = 'No. Telp harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('Alamat') == ''){
      $data['error_string'][] = 'Alamat';
      $data['inputerror'][] = 'Alamat harus diisi';
      $data['status'] = FALSE;
    }
    if($data['status'] === FALSE){
      echo json_encode($data);
      exit();
    }
  }
}

?>
