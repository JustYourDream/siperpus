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
          $row[] = '<a class="btn btn-sm btn-warning btn-block" style="pointer-events: none;"><i class="fas fa-cash-register"></i> Bayar Denda</a>';
        }else if($list->status_pembayaran == "Dibayar"){
          $row[] = '<button class="btn btn-sm btn-success btn-block" style="pointer-events: none;"><i class="fas fa-money-bill-wave"></i> Denda Dibayar</button>';
        }else if($list->status_pembayaran == "Tidak Ada"){
          $row[] = '<button class="btn btn-sm btn-primary btn-block" style="background-color: grey; border-color: grey; pointer-events: none;">Tidak Ada Denda</button>';
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
