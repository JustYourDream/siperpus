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
    echo view('/anggota/info_peminjaman');
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
          $row[] = '<button class="btn btn-sm btn-success btn-block" style="pointer-events: none;">Dikembalikan</button>';
        }elseif ($list->status == "Menunggu") {
          $row[] = '<button class="btn btn-sm btn-warning btn-block" style="pointer-events: none;">Menunggu</button>';
        }elseif ($list->status == "Dipinjam") {
          $row[] = '<button class="btn btn-sm btn-info btn-block" style="pointer-events: none;">Dipinjam</button>';
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
