<?php
namespace App\Controllers\Petugas;
require ('../vendor/autoload.php');
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
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
        $qr = base_url('assets/qr_code/'.$list->qr_code);
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
        $row[] = '<img src="'."".$qr."".'" width="50px" height="50px">';
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

    $writer = new PngWriter();

    // Create QR code
    $qrCode = QrCode::create(''.$request->getPost('NoInduk').'')
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

    $result = $writer->write($qrCode);
    $result->saveToFile('../public/assets/qr_code/'.$request->getPost('NoInduk').'-QR.png');

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
      'qr_code' => ''.$request->getPost('NoInduk').'-QR.png',
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

    //Hapus QR Code
    $qr = implode(" ",$buku->select('qr_code')->where(['no_induk' => $id])->first());
    $target_qr = "assets/qr_code/{$qr}";
    unlink($target_qr);

    $lists = $buku->delete_by_id($id);

    echo json_encode(array("status" => TRUE));
  }
}
?>
