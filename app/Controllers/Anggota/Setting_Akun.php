<?php

namespace App\Controllers\Anggota;
use CodeIgniter\Controller;
use App\Models\AnggotaModel;
use App\Models\UsersModel;
use Mpdf\Mpdf;
use Config\Services;

class Setting_Akun extends Controller
{
	public function index()
	{
		$data['title'] = 'Pengaturan Akun';
		if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Anggota"){
				return view('anggota/setting_akun', $data);
			}else{
				return view('access_denied');
			}
		}
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

		$this->_validate();
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

	private function _validate(){
    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = TRUE;

    if($this->request->getPost('jkel') == ''){
      $data['error_string'][] = 'jkel';
      $data['inputerror'][] = 'Jenis Kelamin harus dipilih';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('nama') == ''){
      $data['error_string'][] = 'nama';
      $data['inputerror'][] = 'Nama harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('tempat') == ''){
      $data['error_string'][] = 'tempat';
      $data['inputerror'][] = 'Tempat harus diisi';
      $data['status'] = FALSE;
    }
		if($this->request->getPost('tanggal') == ''){
      $data['error_string'][] = 'tanggal';
      $data['inputerror'][] = 'Tanggal harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('alamat') == ''){
      $data['error_string'][] = 'alamat';
      $data['inputerror'][] = 'Alamat harus diisi';
      $data['status'] = FALSE;
    }
		if($this->request->getPost('agama') == ''){
      $data['error_string'][] = 'agama';
      $data['inputerror'][] = 'Agama harus dipilih';
      $data['status'] = FALSE;
    }
    if($data['status'] === FALSE){
      echo json_encode($data);
      exit();
    }
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
}
