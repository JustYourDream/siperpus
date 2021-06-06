<?php
namespace App\Controllers\Anggota;
use CodeIgniter\Controller;
use App\Models\PengembalianModel;
use Config\Services;

class Info_Pengembalian extends Controller{

  public function index()
  {
    $data['title'] = 'Info Pengembalian';
    if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Anggota"){
				return view('anggota/info_pengembalian', $data);
			}else{
				return view('access_denied');
			}
		}
  }

  public function ajax_list()
  {
    $request = Services::request();
    $kembali = new PengembalianModel($request);
    if($request->getMethod(true)=='POST'){
      $lists = $kembali->get_datatables_anggota();
      $data = [];
      $no = $request->getPost("start");
      foreach ($lists as $list) {
        $no++;
        $row = [];
        $row[] = $no;
        $row[] = $list->id_peminjaman;
        $row[] = $list->tanggal_pinjam;
        $row[] = $list->tanggal_kembali;
        $row[] = $list->no_anggota;
        $row[] = $list->tgl_dikembalikan;
        $row[] = "Rp ".number_format($list->denda,0,',','.');
        if($list->status_pembayaran == "Belum Dibayar"){
          $row[] = '<span class="badge badge-warning">Belum Dibayar</span>';
        }else if($list->status_pembayaran == "Dibayar"){
          $row[] = '<span class="badge badge-success">Sudah Dibayar</span>';
        }else if($list->status_pembayaran == "Tidak Ada"){
          $row[] = '<span class="badge badge-primary">Tidak Ada Denda</span>';
        }
        $data[] = $row;
      }

      $output = ["draw" => $request->getPost('draw'),
      "recordsTotal" => $kembali->count_all(),
      "recordsFiltered" => $kembali->count_filtered(),
      "data" => $data];
      echo json_encode($output);
    }
  }
}
