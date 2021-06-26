<?php
namespace App\Controllers\Petugas;
use CodeIgniter\Controller;
use App\Models\PengembalianModel;
use Config\Services;

class DataPengembalian_Petugas extends Controller{

  public function index()
  {
    $data['title'] = 'Data Pengembalian';
    if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Petugas"){
				return view('petugas/data_pengembalian', $data);
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
      $lists = $kembali->get_datatables();
      $data = [];
      $no = $request->getPost("start");
      foreach ($lists as $list) {
        $no++;
        $row = [];
        $row[] = $no;
        $row[] = $list->id_peminjaman;
        $row[] = date("d-m-Y", strtotime($list->tanggal_pinjam));
        $row[] = date("d-m-Y", strtotime($list->tanggal_kembali));
        $row[] = '<a href="#modal_detail" data-toggle="modal" data-target="#modal_detail" onclick="showDetail('.$list->no_anggota.')">'.$list->no_anggota.'</a>';
        $row[] = date("d-m-Y", strtotime($list->tgl_dikembalikan));
        $row[] = "Rp ".number_format($list->denda,0,',','.');
        $row[] = $list->status_pembayaran;
        if($list->status_pembayaran == "Belum Dibayar"){
          $row[] = '<a class="btn btn-sm btn-primary btn-block" href="javascript:void(0)" title="Bayar" onclick="konfirmasi_bayar('."'".$list->id_peminjaman."'".')"><i class="fas fa-cash-register"></i> Bayar Denda</a>';
        }else if($list->status_pembayaran == "Dibayar"){
          $row[] = '<button class="btn btn-sm btn-success btn-block" disabled><i class="fas fa-money-bill-wave"></i> Denda Dibayar</button>';
        }else if($list->status_pembayaran == "Tidak Ada"){
          $row[] = '<button class="btn btn-sm btn-primary btn-block" style="background-color: grey; border-color: grey;" disabled>Tidak Ada Denda</button>';
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
  public function ajax_bayar($id){
    $request = Services::request();
    $kembali = new PengembalianModel($request);
    $konfirmasi = $kembali->konfirmasi_bayar($id);
    echo json_encode(array("status" => TRUE));
  }
}
