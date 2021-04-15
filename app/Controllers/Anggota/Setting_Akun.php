<?php

namespace App\Controllers\Anggota;
use CodeIgniter\Controller;
use App\Models\AnggotaModel;
use App\Models\UsersModel;
use Config\Services;

class Setting_Akun extends Controller
{
	public function index()
	{
		return view('anggota/setting_akun');
	}
	public function showdata(){
		$request = Services::request();
		$id = session()->get('id');
    $anggota = new AnggotaModel($request);
    $lists = $anggota->get_by_id($id);
    echo json_encode($lists);
	}
	public function update_akun()
  {
		//Tabel Petugas
		$request = Services::request();
		$anggota = new AnggotaModel($request);
    $data = array(
    	'nama_anggota' => $this->request->getPost('nama'),
			'tempat_lahir' => $this->request->getPost('tempat'),
			'tanggal_lahir' => $this->request->getPost('tanggal'),
			'alamat_anggota' => $this->request->getPost('alamat'),
			'agama_anggota' => $this->request->getPost('agama'),
			'jkel_anggota' => $this->request->getPost('jkel'),
    );
    $anggota->update_anggota(array('no_anggota' => $this->request->getPost('id')), $data);

		//Tabel Pengguna
		$data1 = array(
			'nama' => $this->request->getPost('nama'),
		);
		$anggota->update_akun_anggota(array('id' => $this->request->getPost('id')), $data1);
		echo json_encode(array("status" => TRUE));
  }
	public function ganti_pass(){
		$request = Services::request();
		$anggota = new AnggotaModel($request);
		$user = new UsersModel();
		$id = session()->get('id');
		$currpass= implode(" ",$user->select('password')->where(['id' => $id])->first());
		$oldpass = md5($this->request->getPost('old'));

		$data2 = array(
			'password' => md5($this->request->getPost('new'))
		);

		if(md5($this->request->getPost('old')) == $currpass){
			$anggota->update_pw($id, $data2);
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
		$anggota = new AnggotaModel($request);
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
			$nama_foto_before = implode(" ",$anggota->select('foto_anggota')->where(['no_anggota' => $id])->first());
			$nama_foto_baru = $id."-PIC-".$random;

			//Hapus Foto Sebelumnya
			$target_foto = "../public/assets/img/profile_pic/{$nama_foto_before}";
			if(is_file($target_foto) == TRUE){
				if(!($nama_foto_before == "FEMALE-PIC" || $nama_foto_before == "MALE-PIC")){
					unlink($target_foto);
				}
			}

			//Upload
			$upload->move(WRITEPATH . '../public/assets/img/profile_pic/',$nama_foto_baru);

			//Crop image
			$cropped_img = \Config\Services::image()->withFile('../public/assets/img/profile_pic/'.$nama_foto_baru)->fit(512,512, 'center')->save('../public/assets/img/profile_pic/'.$nama_foto_baru);

			$data = array(
				'foto_anggota' => $nama_foto_baru,
			);
			$anggota->update_anggota(array('no_anggota' => $id), $data);
			return redirect()->back()->with('success', '<span class="alert-text"><strong>Sukses!</strong> Foto profil berhasil diubah</span>
																									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																									  <span aria-hidden="true">&times;</span>
																									</button>');
		}
	}
	public function hapus_foto(){
		$request = Services::request();
		$anggota = new AnggotaModel($request);
		$id = session()->get('id');
		$gender = implode(" ",$anggota->select('jkel_anggota')->where(['no_anggota' => $id])->first());
		$data = null;

		if($gender == "Laki-laki"){
			$data = array(
				'foto_anggota' => "MALE-PIC",
			);
		} elseif ($gender == "Perempuan") {
			$data = array(
				'foto_anggota' => "FEMALE-PIC",
			);
		}

		//Generate nama file
		$nama_foto_before = implode(" ",$anggota->select('foto_anggota')->where(['no_anggota' => $id])->first());

		//Hapus Foto Sebelumnya
		$target_foto = "../public/assets/img/profile_pic/{$nama_foto_before}";
		if(is_file($target_foto) == TRUE){
			if(!($nama_foto_before == "FEMALE-PIC" || $nama_foto_before == "MALE-PIC")){
				unlink($target_foto);
			}
		}

		$anggota->update_anggota(array('no_anggota' => $id), $data);

		return redirect()->back()->with('success', '<span class="alert-text"><strong>Sukses!</strong> Berhasil hapus foto</span>
																								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																									<span aria-hidden="true">&times;</span>
																								</button>');
	}
}
