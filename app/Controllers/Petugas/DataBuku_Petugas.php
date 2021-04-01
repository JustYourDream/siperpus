<?php
namespace App\Controllers\Petugas;
use CodeIgniter\Controller;
use App\Models\ModelBuku;
use Config\Services;

class DataBuku_Petugas extends Controller{

  public function index()
  {
    echo view('/petugas/data_buku');
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
        $row[] = $list->eksemplar_buku;
        $row[] = $list->no_rak;
        $row[] = $list->kategori_buku;
        $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_buku('."'".$list->no_induk."'".')"><i class="ni ni-active-40"></i> Ubah</a>
        <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus_buku('."'".$list->no_induk."'".')"><i class="ni ni-scissors"></i> Hapus</a>';
        $data[] = $row;
      }

      $output = ["draw" => $request->getPost('draw'),
      "recordsTotal" => $buku->count_all(),
      "recordsFiltered" => $buku->count_filtered(),
      "data" => $data];
      echo json_encode($output);
    }
  }

  public function ajax_add()
  {
    $request = Services::request();
    $buku = new ModelBuku($request);
    $data = array(
      'no_induk' => $request->getPost('NoInduk'),
      'isbn' => $request->getPost('Isbn'),
      'judul_buku' => $request->getPost('Judul'),
      'pengarang_buku' => $request->getPost('Pengarang'),
      'kota_dibuat' => $request->getPost('KotaTerbit'),
      'penerbit_buku' => $request->getPost('Penerbit'),
      'tahun_buku' => $request->getPost('TahunTerbit'),
      'eksemplar_buku' => $request->getPost('Eksemplar'),
      'no_rak' => $request->getPost('Rak'),
      'kategori_buku' => $request->getPost('Kategori'),
    );
    $insert = $buku->save_buku($data);
    echo json_encode(array("status" => TRUE));
  }

  public function ajax_edit($id)
  {
    $request = Services::request();
    $buku = new ModelBuku($request);
    $lists = $buku->get_by_id($id);
    echo json_encode($lists);
  }

  public function ajax_update()
  {
    $request = Services::request();
    $buku = new ModelBuku($request);
    $data = array(
      'isbn' => $request->getPost('Isbn'),
      'judul_buku' => $request->getPost('Judul'),
      'pengarang_buku' => $request->getPost('Pengarang'),
      'kota_dibuat' => $request->getPost('KotaTerbit'),
      'penerbit_buku' => $request->getPost('Penerbit'),
      'tahun_buku' => $request->getPost('TahunTerbit'),
      'eksemplar_buku' => $request->getPost('Eksemplar'),
      'no_rak' => $request->getPost('Rak'),
      'kategori_buku' => $request->getPost('Kategori'),
    );
    $buku->buku_update(array('no_induk' => $request->getPost('NoInduk')), $data);
    echo json_encode(array("status" => TRUE));
  }
  public function ajax_delete($id)
  {
    $request = Services::request();
    $buku = new ModelBuku($request);
    $lists = $buku->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }
}
?>
