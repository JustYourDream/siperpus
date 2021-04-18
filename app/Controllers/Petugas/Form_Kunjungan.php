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
		return view('petugas/form_kunjungan');
	}

	public function welcome()
	{
		return view('petugas/kunjungan_sukses');
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
			'tanggal_kunjungan' => $dateNow
		);

		$insert = $kunjungan->save_kunjungan($data);
		echo view('petugas/kunjungan_sukses', $data);
	}
}

?>
