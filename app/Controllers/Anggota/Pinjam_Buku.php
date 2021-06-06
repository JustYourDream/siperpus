<?php
namespace App\Controllers\Anggota;
use CodeIgniter\Controller;
use App\Models\ModelBuku;
use App\Models\PeminjamanModel;
use Config\Services;

class Pinjam_Buku extends Controller{

  public function index()
  {
    $data['title'] = 'Pinjam Buku';
    if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Anggota"){
				return view('anggota/data_buku', $data);
			}else{
				return view('access_denied');
			}
		}
  }

  public function ajax_list()
  {
    $request = Services::request();
    $buku = new ModelBuku($request);
    if($request->getMethod(true)=='POST'){
      $lists = $buku->get_datatables();
      $data = [];
      $no = $request->getPost("start");
      foreach ($lists as $list) {
        $no++;
        $row = [];
        $row[] = $no;
        $row[] = $list->no_induk;
        $row[] = $list->isbn;
        $row[] = $list->judul_buku;
        $row[] = $list->pengarang_buku;
        $row[] = $list->kota_dibuat;
        $row[] = $list->penerbit_buku;
        $row[] = $list->tahun_buku;
        if($list->eksemplar_buku == 0){
          $row[] = '<span class="badge badge-danger">Stok Kosong</span>';
        }elseif ($list->eksemplar_buku >= 1) {
          $row[] = $list->eksemplar_buku;
        }
        $row[] = $list->no_rak;
        $row[] = $list->kategori_buku;
        if($list->eksemplar_buku == 0){
          $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Pinjam" style="background-color: grey; border-color: grey; pointer-events: none;"><i class="fas fa-shopping-cart"></i> Pinjam</a>';
        }elseif ($list->eksemplar_buku >= 1) {
          $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Pinjam" onclick="pinjam_buku('."'".$list->no_induk."'".')"><i class="fas fa-shopping-cart"></i> Pinjam</a>';
        }
        $data[] = $row;
      }

      $output = ["draw" => $request->getPost('draw'),
      "recordsTotal" => $buku->count_all(),
      "recordsFiltered" => $buku->count_filtered(),
      "data" => $data];
      echo json_encode($output);
    }
  }

  public function id_otomatis(){
    $request = Services::request();
    $pinjam = new PeminjamanModel($request);
    $id_prev = implode(" ",$pinjam->selectMax('id_peminjaman','id')->first());

    if($id_prev != null){
      $no_urut = substr($id_prev, 3, 4);
      $id_now = "PJ".sprintf("%05d", $no_urut + 1);
    }else if($id_prev == null){
      $no_urut = 1;
      $id_now = "PJ".sprintf("%05d", $no_urut);
    }
    echo json_encode("$id_now");
  }

  public function ajax_pinjam($id)
  {
    $request = Services::request();
    $buku = new ModelBuku($request);
    $lists = $buku->get_by_id($id);
    echo json_encode($lists);
  }

  public function save_pinjam(){
    $request = Services::request();
    $pinjam = new PeminjamanModel($request);
    $status = "Menunggu";
    $data = array(
      'id_peminjaman' => $request->getPost('no'),
      'tanggal_pinjam' => $request->getPost('pinjam'),
      'tanggal_kembali' => $request->getPost('kembali'),
      'id_buku' => $request->getPost('buku'),
      'jml_pinjam' => $request->getPost('jml'),
      'no_anggota' => $request->getPost('anggota'),
      'status' => $status,
    );
    $insert = $pinjam->save_pinjam($data);

    //Update Stok Buku//
    $data1 = (int)$request->getPost('jml');

    $update_stok = $pinjam->update_stok_minus(array('no_induk' => $request->getPost('buku')), $data1);
    echo json_encode(array("status" => TRUE));
  }
}
?>
