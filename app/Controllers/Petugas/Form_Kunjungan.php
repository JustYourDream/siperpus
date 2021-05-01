<?php

namespace App\Controllers\Petugas;
use CodeIgniter\Controller;
use App\Models\AnggotaModel;
use App\Models\KunjunganModel;
use Config\Services;

class Form_Kunjungan extends Controller
{
	public function index()
	{
		$data['title'] = 'Form Kunjungan';
		if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Petugas"){
				return view('petugas/form_kunjungan', $data);
			}else{
				return view('access_denied');
			}
		}
	}

	public function welcome()
	{
		$data['title'] = 'Kunjungan Sukses';
		if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Petugas"){
				return view('petugas/kunjungan_sukses', $data);
			}else{
				return view('access_denied');
			}
		}
	}

	public function absensi($id){
		$request = Services::request();
    $anggota = new AnggotaModel($request);
    $list = $anggota->get_by_id($id);
    echo json_encode($list);
	}

	public function insert_kunjungan($insertedId){
		$request = Services::request();
    $kunjungan = new KunjunganModel($request);
		$anggota = new AnggotaModel($request);

		$namaAnggota = implode(" ", $anggota->select('nama_anggota')->where(['no_anggota' => $insertedId])->first());
		$jurusanAnggota = implode(" ", $anggota->select('jurusan_anggota')->where(['no_anggota' => $insertedId])->first());
		$dateNow = date('Y-m-d');
		$no = implode(" ",$kunjungan->selectMax('no')->first());

    if($no != null){
      $no_urut = (int)$no + 1;
    }else if($no == null){
      $no_urut = 1;
    }

		$data = array(
			'no' => $no_urut,
			'no_anggota' => $insertedId,
			'nama' => $namaAnggota,
			'jurusan_anggota' => $jurusanAnggota,
			'tanggal_kunjungan' => $dateNow,
			'title' => 'Kunjungan Sukses'
		);

		$insert = $kunjungan->save_kunjungan(array('no' => $no_urut, 'no_anggota' => $insertedId, 'nama' => $namaAnggota, 'jurusan_anggota' => $jurusanAnggota, 'tanggal_kunjungan' => $dateNow));
		echo view('petugas/kunjungan_sukses', $data);
	}
}

?>
