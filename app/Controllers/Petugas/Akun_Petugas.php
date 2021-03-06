<?php

namespace App\Controllers\Petugas;
use CodeIgniter\Controller;
use App\Models\PetugasModel;
use App\Models\UsersModel;
use Config\Services;

class Akun_Petugas extends Controller
{
	public function index()
	{
		$data['title'] = 'Pengaturan Akun';
		if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Petugas"){
				return view('petugas/setting_akun', $data);
			}else{
				return view('access_denied');
			}
		}
	}
	public function showdata(){
		$request = Services::request();
		$id = session()->get('id');
    $petugas = new PetugasModel($request);
    $data = $petugas->petugas_id($id);
		echo json_encode($data);
	}
	public function update_akun()
  {
		//Tabel Petugas
		$request = Services::request();
		$petugas = new PetugasModel($request);

		$this->_validate();

    $data = array(
    	'nama_petugas' => $this->request->getPost('nama'),
			'jabatan_petugas' => $this->request->getPost('role'),
			'no_telp_petugas' => $this->request->getPost('telp'),
			'alamat_petugas' => $this->request->getPost('address'),
    );
    $petugas->akun_update(array('id_petugas' => $this->request->getPost('id')), $data);

		//Tabel Pengguna
		$data1 = array(
			'nama' => $this->request->getPost('nama'),
		);
		$petugas->akun_login_update(array('id' => $this->request->getPost('id')), $data1);
		echo json_encode(array("status" => TRUE));
  }
	public function ganti_pass(){
		$request = Services::request();
		$pengguna = new PetugasModel($request);
		$user = new UsersModel();
		$id = session()->get('id');
		$currpass= implode(" ",$user->select('password')->where(['id' => $id])->first());
		$oldpass = md5($this->request->getPost('old'));

		$data2 = array(
			'password' => md5($this->request->getPost('new'))
		);

		if(md5($this->request->getPost('old')) == $currpass){
			$pengguna->ganti_pw($id, $data2);
			session()->setFlashdata('success',
							 '<span class="alert-text"><strong>Sukses!</strong> Password berhasil diubah</span>
			 				 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				 			   <span aria-hidden="true">&times;</span>
			 				 </button>');
			return redirect()->back();
		}else{
			session()->setFlashdata('error',
							 '<span class="alert-text"><strong>Gagal!</strong> Password lama salah!</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>');
			return redirect()->back();
		}
	}
	public function upload_foto() {
		helper(['form', 'url']);
		$request = Services::request();
		$petugas = new PetugasModel($request);
		$id = session()->get('id');
		if ($this->request->getMethod() !== 'post') {
			return redirect()->back();
		}
		$input = $this->validate([
				'file' => [
									'uploaded[file]',
									'mime_in[file,image/jpg,image/jpeg,image/png]',
									'max_size[file,2048]',
				]
		]);

		if (!$input) {
			return redirect()->back()->with('error', '<span class="alert-text"><strong>Gagal!</strong> Gagal mengganti foto profil!</span>
			 																					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				 																			   <span aria-hidden="true">&times;</span>
			 																				 	</button>');
		} else {
			//Ambil data gambar
			$upload = $this->request->getFile('file');

			//Generate nama file
			$random = date('s');
			$nama_foto_before = implode(" ",$petugas->select('foto_petugas')->where(['id_petugas' => $id])->first());
			$nama_foto_baru = $id."-PIC-".$random;

			//Hapus Foto Sebelumnya
			$target_foto = "../public/assets/img/profile_pic/{$nama_foto_before}";
			if(is_file($target_foto) == TRUE){
				if(!($nama_foto_before == "DEFAULT-PIC")){
					unlink($target_foto);
				}
			}

			//Upload
			$upload->move(WRITEPATH . '../public/assets/img/profile_pic/',$nama_foto_baru);

			//Crop image
			$cropped_img = \Config\Services::image()->withFile('../public/assets/img/profile_pic/'.$nama_foto_baru)->fit(512,512, 'center')->save('../public/assets/img/profile_pic/'.$nama_foto_baru);

			$data = array(
				'foto_petugas' => $nama_foto_baru,
			);
			$petugas->simpan_gambar(array('id_petugas' => $id), $data);
			return redirect()->back()->with('success', '<span class="alert-text"><strong>Sukses!</strong> Foto profil berhasil diubah</span>
																									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																									  <span aria-hidden="true">&times;</span>
																									</button>');
		}
	}
	public function hapus_foto(){
		$request = Services::request();
		$petugas = new PetugasModel($request);
		$id = session()->get('id');
		$data = array(
			'foto_petugas' => "DEFAULT-PIC",
		);

		//Generate nama file
		$random = date('s');
		$nama_foto_before = implode(" ",$petugas->select('foto_petugas')->where(['id_petugas' => $id])->first());
		$nama_foto_baru = $id."-PIC-".$random;

		//Hapus Foto Sebelumnya
		$target_foto = "../public/assets/img/profile_pic/{$nama_foto_before}";
		if(is_file($target_foto) == TRUE){
			if(!($nama_foto_before == "DEFAULT-PIC")){
				unlink($target_foto);
			}
		}
		$petugas->simpan_gambar(array('id_petugas' => $id), $data);
		return redirect()->back()->with('success', '<span class="alert-text"><strong>Sukses!</strong> Berhasil hapus foto</span>
																								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																									<span aria-hidden="true">&times;</span>
																								</button>');
	}

	private function _validate(){
    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = TRUE;

    if($this->request->getPost('telp') == ''){
      $data['error_string'][] = 'telp';
      $data['inputerror'][] = 'No Telepon harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('nama') == ''){
      $data['error_string'][] = 'nama';
      $data['inputerror'][] = 'Nama harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('address') == ''){
      $data['error_string'][] = 'address';
      $data['inputerror'][] = 'Alamat harus diisi';
      $data['status'] = FALSE;
    }
    if($data['status'] === FALSE){
      echo json_encode($data);
      exit();
    }
  }
}
