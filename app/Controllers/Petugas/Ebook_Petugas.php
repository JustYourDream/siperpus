<?php
namespace App\Controllers\Petugas;
require ('../vendor/autoload.php');
use Mpdf\Mpdf;
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
use App\Models\PetugasModel;
use Config\Services;

class Ebook_Petugas extends Controller{

  public function index()
  {
    $data['title'] = 'Data E-book';
    if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Petugas"){
				return view('petugas/ebook_petugas', $data);
			}else{
				return view('access_denied');
			}
		}
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

    $this->_validate();

    //Create QR code
    $qrCode = QrCode::create(''.$request->getPost('NoEbook').'')
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

    $logo = Logo::create('../public/assets/img/brand/amgalogo.png')
    ->setResizeToWidth(80);

    //Save QR
    $result = $writer->write($qrCode, $logo);
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
      $nama_ebook = strtoupper($request->getPost('NoEbook'))."-Ebook.pdf";
      $ebook_file->move(WRITEPATH . '../public/assets/eBook/PDF/',$nama_ebook);
    }

    if(!$validate_cover){
      $sampul = "Default-Cover.png";
    }
    else{
      //Generate nama file
      $cover = $this->request->getFile('sampul');
      $sampul = strtoupper($request->getPost('NoEbook'))."-Cover";
      $cover->move(WRITEPATH . '../public/assets/eBook/Cover/',$sampul);

      //Crop image
      $cropped_img = \Config\Services::image()->withFile('../public/assets/eBook/Cover/'.$sampul)->fit(348,400, 'center')->save('../public/assets/eBook/Cover/'.$sampul);
    }

    $data = array(
      'id_ebook' => strtoupper($request->getPost('NoEbook')),
      'judul_ebook' => $request->getPost('Judul'),
      'pengarang' => $request->getPost('Pengarang'),
      'penerbit' => $request->getPost('Penerbit'),
      'kategori_ebook' => $request->getPost('Kategori'),
      'cover_ebook' => $sampul,
      'file_ebook' => $nama_ebook,
      'qr_ebook' => ''.strtoupper($request->getPost('NoEbook')).'-QR.png',
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

    $this->_validate();

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
      $nama_ebook = strtoupper($request->getPost('NoEbook'))."-Ebook.pdf";

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
      $sampul = strtoupper($request->getPost('NoEbook'))."-Cover";

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

  private function _validate(){
    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = TRUE;

    if($this->request->getPost('NoEbook') == ''){
      $data['error_string'][] = 'NoEbook';
      $data['inputerror'][] = 'No E-Book harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('Penerbit') == ''){
      $data['error_string'][] = 'Penerbit';
      $data['inputerror'][] = 'Penerbit harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('Judul') == ''){
      $data['error_string'][] = 'Judul';
      $data['inputerror'][] = 'Judul harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('Pengarang') == ''){
      $data['error_string'][] = 'Pengarang';
      $data['inputerror'][] = 'Pengarang harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('Kategori') == ''){
      $data['error_string'][] = 'Kategori';
      $data['inputerror'][] = 'Kategori harus dipilih';
      $data['status'] = FALSE;
    }
    if($data['status'] === FALSE){
      echo json_encode($data);
      exit();
    }
  }

  public function cetak_list(){
    $request = Services::request();
    $ebook = new EbookModel($request);
    $petugas = new PetugasModel($request);
    $hasil = $ebook->get();
    $table = '';
    $no = 1;

    $mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'format' => 'A4-L']);
    $mpdf->curlAllowUnsafeSslRequests = true;

    $footer = '';
		$nama_ketua = implode(" ",$petugas->select('nama_petugas')->where(['jabatan_petugas' => 'Ketua'])->first());
		$id_ketua = implode(" ",$petugas->select('id_petugas')->where(['jabatan_petugas' => 'Ketua'])->first());
		$footer .= '<div style="margin-top: 20px;">
                  <table width="100%">
                    <tr>
                      <td rowspan="5" width="60%"></td>
                      <td class="ttd">Ampelgading, '.date('d-m-Y').'</td>
                    </tr>
                    <tr>
                      <td class="ttd">Ketua Perpustakaan "Inti Gading"</td>
                    </tr>
                    <tr>
                      <td height="80px"></td>
                    </tr>
                    <tr>
                      <td class="ttd"><b><u>'.$nama_ketua.'</u></b></td>
                    </tr>
                    <tr>
                      <td class="ttd">NIP : '.$id_ketua.'</td>
                    </tr>
                  </table>
                </div>';

    foreach ($hasil->getResult('array') as $row) {
      $table .='<tr>
                  <td align="center">'.$no++.'</td>
                  <td>'.$row['id_ebook'].'</td>
                  <td>'.$row['judul_ebook'].'</td>
                  <td>'.$row['pengarang'].'</td>
                  <td>'.$row['penerbit'].'</td>
                  <td>'.$row['kategori_ebook'].'</td>
                </tr>';
    }

    $mpdf->WriteHTML('
    <style>
      .title{
        text-align: center;
      }
      .ttd{
        text-align: center;
      }
    </style>
    <div style="text-align: center;">
      <hr><width="100" height="75"></hr>
        <table width="100%" cellspacing="10px">
          <tr>
            <td rowspan="3" align="center">
              <img src="'.base_url('assets/img/brand/amgalogo.png').'" height="100px" width="100px">
            </td>
            <td align="center">
              <h1><font size="5" face="times new roman">PERPUSTAKAAN "INTI GADING"</font></h1>
            </td>
            <td rowspan="3" align="center">
              <img src="'.base_url('assets/img/brand/pendidikan.png').'" height="100px" width="100px">
            </td>
          </tr>
          <tr>
            <td align="center">
              <b><font size="6" face="Times New Roman">SMK NEGERI 1 AMPELGADING</font></b>
            </td>
          </tr>
          <tr>
            <td align="center">
              <b>Jl. Raya Ujunggede (Pantura), Ampelgading, Kabupaten Pemalang, 52364<b>
            </td>
          </tr>
        </table>
      <hr><width="100" height="75"></hr>
    </div>
    <div style="margin-top: 10px;">
      <table style="margin-bottom: 20px;">
        <tr>
          <td>Nomor</td>
          <td>:</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/</td>
        </tr>
        <tr>
          <td>Lamp.</td>
          <td>:</td>
          <td> -</td>
        </tr>
        <tr>
          <td>Hal</td>
          <td>:</td>
          <td> Data Buku Digital Perpustakaan "Inti Gading"</td>
        </tr>
      </table>
      <p>Diberitahukan dengan hormat bahwa di bawah ini adalah data buku digital perpustakaan "Inti Gading" :</p>
      <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
          <tr>
            <th>No.</th>
            <th>No. Ebook</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Kategori</th>
          </tr>
        </thead>
        <tbody>
            '.$table.'
        </tbody>
      </table>
    </div>
    <div style="margin-top: 20px;">
      '.$footer.'
    </div>
    ');

    $mpdf->Output('Daftar_Ebook.pdf','I');
    exit;
  }
}

?>
