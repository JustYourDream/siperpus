<?php
namespace App\Controllers\Petugas;
use CodeIgniter\Controller;
use App\Models\PeminjamanModel;
use App\Models\ModelBuku;
use Config\Services;

class DataPeminjaman_Petugas extends Controller{

  public function index()
  {
    echo view('/petugas/data_peminjaman');
  }

  public function ajax_list()
  {
    $request = Services::request();
    $pinjam = new PeminjamanModel($request);
    if($request->getMethod(true)=='POST'){
      $lists = $pinjam->get_datatables();
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
        $row[] = $list->id_anggota;
        $row[] = $list->status;
        if($list->status == "Dipinjam"){
          $row[] = '<button class="btn btn-sm btn-primary btn-block" style="background-color: grey; border-color: grey;" title="Confirm" disabled><i class="fas fa-thumbs-up"></i> Konfirmasi</button>
                    <a class="btn btn-sm btn-success btn-block" href="javascript:void(0)" title="Back" onclick="dikembalikan('."'".$list->id_peminjaman."'".','."'".$list->id_buku."'".')"><i class="fas fa-check-double"></i> Kembali</a>
                    <a class="btn btn-sm btn-danger btn-block" href="javascript:void(0)" title="Del" onclick="hapus_peminjaman('."'".$list->id_peminjaman."'".','."'".$list->id_buku."'".')"><i class="fas fa-trash-alt"></i> Hapus</a>';
        }else if($list->status == "Dikembalikan"){
          $row[] = '<button class="btn btn-sm btn-primary btn-block" style="background-color: grey; border-color: grey;" title="Confirm" disabled><i class="fas fa-thumbs-up"></i> Konfirmasi</button>
                    <button class="btn btn-sm btn-success btn-block" style="background-color: grey; border-color: grey;" title="Back" disabled><i class="fas fa-check-double"></i> Kembali</button>
                    <a class="btn btn-sm btn-danger btn-block" href="javascript:void(0)" title="Del" onclick="hapus_peminjaman('."'".$list->id_peminjaman."'".','."'".$list->id_buku."'".')"><i class="fas fa-trash-alt"></i> Hapus</a>';
        }
        else if($list->status == "Menunggu"){
          $row[] = '<a class="btn btn-sm btn-primary btn-block" href="javascript:void(0)" title="Confirm" onclick="konfirmasi_pinjam('."'".$list->id_peminjaman."'".')"><i class="fas fa-thumbs-up"></i> Konfirmasi</a>
                    <button class="btn btn-sm btn-success btn-block" style="background-color: grey; border-color: grey;" title="Back disabled" ><i class="fas fa-check-double"></i> Kembali</a>
                    <a class="btn btn-sm btn-danger btn-block" href="javascript:void(0)" title="Del" onclick="hapus_peminjaman('."'".$list->id_peminjaman."'".','."'".$list->id_buku."'".')"><i class="fas fa-trash-alt"></i> Hapus</a>';
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

  public function cari_buku($id){
    $request = Services::request();
    $buku = new ModelBuku($request);
    $lists = $buku->get_by_id($id);
    echo json_encode($lists);
  }

  public function ajax_add()
  {
    $request = Services::request();
    $pinjam = new PeminjamanModel($request);
    $status = "Dipinjam";
    $data = array(
      'id_peminjaman' => $request->getPost('no'),
      'tanggal_pinjam' => $request->getPost('pinjam'),
      'tanggal_kembali' => $request->getPost('kembali'),
      'id_buku' => $request->getPost('buku'),
      'jml_pinjam' => $request->getPost('jml'),
      'id_anggota' => $request->getPost('anggota'),
      'status' => $status,
    );
    $insert = $pinjam->save_pinjam($data);

    //Update Stok Buku//
    $data1 = (int)$request->getPost('jml');

    $update_stok = $pinjam->update_stok_minus(array('no_induk' => $request->getPost('buku')), $data1);
    echo json_encode(array("status" => TRUE));
  }

  public function ajax_delete($id, $induk)
  {
    $request = Services::request();
    $pinjam = new PeminjamanModel($request);

    //Update Stok Buku//
    $stok_kembali = implode(" ",$pinjam->select('jml_pinjam')->where(['id_peminjaman' => $id])->first());
    $update_stok = $pinjam->update_stok_plus(array('no_induk' => $induk), $stok_kembali);

    //Hapus Data
    $lists = $pinjam->delete_by_id($id, $induk);

    echo json_encode(array("status" => TRUE));
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

  public function ajax_confirm($id){
    $request = Services::request();
    $pinjam = new PeminjamanModel($request);
    $konfirmasi = $pinjam->konfirmasi_pinjam($id);
    echo json_encode(array("status" => TRUE));
  }

  public function ajax_kembali($id, $induk){
    $request = Services::request();
    $pinjam = new PeminjamanModel($request);
    $konfirmasi = $pinjam->dikembalikan($id, $induk);

    //Stok update
    $stok_kembali = implode(" ",$pinjam->select('jml_pinjam')->where(['id_peminjaman' => $id])->first());
    $update_stok = $pinjam->update_stok_plus(array('no_induk' => $induk), $stok_kembali);
    echo json_encode(array("status" => TRUE));
  }
}
?>
