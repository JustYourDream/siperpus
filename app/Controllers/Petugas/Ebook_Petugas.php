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
use App\Models\EbookModel;
use Config\Services;

class Ebook_Petugas extends Controller{

  public function index()
  {
    echo view('/petugas/ebook_petugas');
  }

  public function ajax_list()
  {
    $request = Services::request();
    $ebook = new EbookModel($request);
    if($request->getMethod(true)=='POST'){
      $lists = $ebook->get_datatables();
      $data = [];
      $no = $request->getPost("start");
      foreach ($lists as $list) {
        $qr = base_url('assets/eBook/QR/'.$list->qr_ebook);
        $sampul = base_url('assets/eBook/Cover/'.$list->cover_ebook);
        $pdf = base_url('assets/eBook/PDF/'.$list->file_ebook);
        $no++;
        $row = [];
        $row[] = $no;
        $row[] = $list->id_ebook;
        $row[] = '<img src="'."".$sampul."".'" width="87px" height="100px">';
        $row[] = $list->judul_ebook;
        $row[] = $list->pengarang;
        $row[] = $list->penerbit;
        $row[] = $list->kategori_ebook;
        $row[] = '<img src="'."".$qr."".'" width="50px" height="50px">';
        $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_ebook('."'".$list->id_ebook."'".')"><i class="ni ni-active-40"></i> Ubah</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus_ebook('."'".$list->id_ebook."'".')"><i class="ni ni-scissors"></i> Hapus</a>';
        $data[] = $row;
      }

      $output = ["draw" => $request->getPost('draw'),
      "recordsTotal" => $ebook->count_all(),
      "recordsFiltered" => $ebook->count_filtered(),
      "data" => $data];
      echo json_encode($output);
    }
  }

  public function id_otomatis(){
    $request = Services::request();
    $ebook = new EbookModel($request);
    $id_prev = implode(" ",$ebook->selectMax('id_ebook')->first());

    if($id_prev != null){
      $no_urut = substr($id_prev, 3, 4);
      $id_now = "EB".sprintf("%05d", $no_urut + 1);
    }else if($id_prev == null){
      $no_urut = 1;
      $id_now = "EB".sprintf("%05d", $no_urut);
    }
    echo json_encode("$id_now");
  }

  public function ajax_edit($id)
  {
    $request = Services::request();
    $ebook = new EbookModel($request);
    $lists = $ebook->get_by_id($id);
    echo json_encode($lists);
  }

  public function ajax_add()
  {
    helper(['form', 'url']);
    $request = Services::request();
    $ebook = new EbookModel($request);
    $writer = new PngWriter();

    $sampul = null;

    //Create QR code
    $qrCode = QrCode::create(''.$request->getPost('NoEbook').'')
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

    //Save QR
    $result = $writer->write($qrCode);
    $result->saveToFile('../public/assets/eBook/QR/'.$request->getPost('NoEbook').'-QR.png');

    //Validasi File & Sampul
    $validate_file = $this->validate([
                            'ebook' => [
                                        'uploaded[ebook]',
                                        'mime_in[ebook,application/pdf]',
                                        'ext_in[ebook,pdf]',
                                        'max_size[ebook,10240]'
                                      ],
    ]);

    $validate_cover = $this->validate([
                            'sampul' => [
                                        'uploaded[sampul]',
                                        'mime_in[sampul,image/jpg,image/jpeg,image/gif,image/png]',
                                        'max_size[sampul,4096]',
                                      ],
		]);

    if(!$validate_file){
      echo "ERROR";
    }
    else{
      $ebook_file = $this->request->getFile('ebook');
      $nama_ebook = $request->getPost('NoEbook')."-Ebook.pdf";
      $ebook_file->move(WRITEPATH . '../public/assets/eBook/PDF/',$nama_ebook);
    }

    if(!$validate_cover){
      $sampul = "Default-Cover.png";
    }
    else{
      //Generate nama file
      $cover = $this->request->getFile('sampul');
      $sampul = $request->getPost('NoEbook')."-Cover";
      $cover->move(WRITEPATH . '../public/assets/eBook/Cover/',$sampul);

      //Crop image
      $cropped_img = \Config\Services::image()->withFile('../public/assets/eBook/Cover/'.$sampul)->fit(348,400, 'center')->save('../public/assets/eBook/Cover/'.$sampul);
    }

    $data = array(
      'id_ebook' => $request->getPost('NoEbook'),
      'judul_ebook' => $request->getPost('Judul'),
      'pengarang' => $request->getPost('Pengarang'),
      'penerbit' => $request->getPost('Penerbit'),
      'kategori_ebook' => $request->getPost('Kategori'),
      'cover_ebook' => $sampul,
      'file_ebook' => $nama_ebook,
      'qr_ebook' => ''.$request->getPost('NoEbook').'-QR.png',
    );

    $insert = $ebook->save_ebook($data);
    echo json_encode(array("status" => TRUE));
  }

  public function ajax_update()
  {
    helper(['form', 'url']);
    $request = Services::request();
    $ebook = new EbookModel($request);
    $nama_ebook = null;
    $sampul = null;

    //Validasi File & Sampul
    $validate_file = $this->validate([
                            'ebook' => [
                                        'uploaded[ebook]',
                                        'mime_in[ebook,application/pdf]',
                                        'ext_in[ebook,pdf]',
                                        'max_size[ebook,10240]'
                                      ],
    ]);

    $validate_cover = $this->validate([
                            'sampul' => [
                                        'uploaded[sampul]',
                                        'mime_in[sampul,image/jpg,image/jpeg,image/gif,image/png]',
                                        'max_size[sampul,4096]',
                                      ],
		]);

    if(!$validate_file){
      $nama_ebook = implode(" ", $ebook->select('file_ebook')->where(['id_ebook' => $request->getPost('NoEbook')])->first());
    }
    else{
      $ebook_file = $this->request->getFile('ebook');
      $nama_ebook = $request->getPost('NoEbook')."-Ebook.pdf";

      //Hapus PDF Sebelumnya
			$target_file = "../public/assets/eBook/PDF/{$nama_ebook}";
			if(is_file($target_file) == TRUE){
				unlink($target_file);
			}

      $ebook_file->move(WRITEPATH . '../public/assets/eBook/PDF/',$nama_ebook);
    }

    if(!$validate_cover){
      $sampul = implode(" ",$ebook->select('cover_ebook')->where(['id_ebook' => $request->getPost('NoEbook')])->first());
    }
    else{
      //Generate nama file
      $cover = $this->request->getFile('sampul');
      $sampul = $request->getPost('NoEbook')."-Cover";

      //Hapus Foto Sebelumnya
			$target_cover = "../public/assets/eBook/Cover/{$sampul}";
			if(is_file($target_cover) == TRUE){
				unlink($target_cover);
			}

      $cover->move(WRITEPATH . '../public/assets/eBook/Cover/',$sampul);

      //Crop image
      $cropped_img = \Config\Services::image()->withFile('../public/assets/eBook/Cover/'.$sampul)->fit(348,400, 'center')->save('../public/assets/eBook/Cover/'.$sampul);
    }

    $data = array(
      'judul_ebook' => $request->getPost('Judul'),
      'pengarang' => $request->getPost('Pengarang'),
      'penerbit' => $request->getPost('Penerbit'),
      'kategori_ebook' => $request->getPost('Kategori'),
      'cover_ebook' => $sampul,
      'file_ebook' => $nama_ebook,
    );

    $ebook->update_ebook(array('id_ebook' => $request->getPost('NoEbook')), $data);
    echo json_encode(array("status" => TRUE));
  }

  public function ajax_delete($id)
  {
    $request = Services::request();
    $ebook = new EbookModel($request);

    //Hapus QR Code
    $qr = implode(" ",$ebook->select('qr_ebook')->where(['id_ebook' => $id])->first());
    $target_qr = "../public/assets/eBook/QR/{$qr}";
    unlink($target_qr);

    //Hapus Cover
    $cover = implode(" ",$ebook->select('id_ebook')->where(['id_ebook' => $id])->first()).'-Cover';
    $target_cover = "../public/assets/eBook/Cover/{$cover}";
    if(is_file($target_cover) == TRUE){
      unlink($target_cover);
    }

    //Hapus File Ebook
    $file_ebook = implode(" ",$ebook->select('file_ebook')->where(['id_ebook' => $id])->first());
    $target_file = "../public/assets/eBook/PDF/{$file_ebook}";
    if(is_file($target_file) == TRUE){
      unlink($target_file);
    }

    $ebook->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }
}

?>
