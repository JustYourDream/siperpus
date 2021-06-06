<?php
namespace App\Controllers\Anggota;
use CodeIgniter\Controller;
use App\Models\PeminjamanModel;
use App\Models\ModelBuku;
use App\Models\AnggotaModel;
use Config\Services;

class Info_Peminjaman extends Controller{

  public function index()
  {
    $data['title'] = 'Info Peminjaman';
    if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Anggota"){
				return view('anggota/info_peminjaman', $data);
			}else{
				return view('access_denied');
			}
		}
  }

  public function ajax_list()
  {
    $request = Services::request();
    $pinjam = new PeminjamanModel($request);
    if($request->getMethod(true)=='POST'){
      $lists = $pinjam->get_datatables_anggota();
      $data = [];
      $no = $request->getPost("start");
      foreach ($lists as $list) {
        $no++;
        $row = [];
        $row[] = $no;
        $row[] = $list->id_peminjaman;
        $row[] = $list->tanggal_pinjam;
        $row[] = $list->tanggal_kembali;
        $row[] = $list->id_buku;
        $row[] = $list->jml_pinjam;
        $row[] = $list->no_anggota;
        if ($list->status == "Dikembalikan"){
          $row[] = '<span class="badge badge-success">Dikembalikan</span>';
        }elseif ($list->status == "Menunggu") {
          $row[] = '<span class="badge badge-default">Menunggu</span>';
        }elseif ($list->status == "Dipinjam") {
          $row[] = '<span class="badge badge-primary">Dipinjam</span>';
        }
        $data[] = $row;
      }

      $output = ["draw" => $request->getPost('draw'),
      "recordsTotal" => $pinjam->count_all(),
      "recordsFiltered" => $pinjam->count_filtered(),
      "data" => $data];
      echo json_encode($output);
    }
  }
}
?>
