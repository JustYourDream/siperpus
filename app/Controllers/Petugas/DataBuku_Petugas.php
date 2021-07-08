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
use App\Models\ModelBuku;
use App\Models\PetugasModel;
use Config\Services;

class DataBuku_Petugas extends Controller{

  public function index()
  {
    $data['title'] = 'Data Buku';
    if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Petugas"){
				return view('petugas/data_buku', $data);
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
        $qr = base_url('assets/qr_code/'.$list->qr_code);
        $label = base_url('Petugas/DataBuku_Petugas/cetak_label/'.$list->no_induk);
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
        $row[] = '<a class="btn btn-sm btn-primary btn-block" href="javascript:void(0)" title="Edit" onclick="edit_buku('."'".$list->no_induk."'".')"><i class="ni ni-active-40"></i> Ubah</a>
                  <a class="btn btn-sm btn-danger btn-block" href="javascript:void(0)" title="Hapus" onclick="hapus_buku('."'".$list->no_induk."'".')"><i class="ni ni-scissors"></i> Hapus</a>
                  <a href="'.$label.'" target="_blank" class="btn btn-sm btn-default btn-block" id="cetak_list"><i class="fas fa-tags"></i> Cetak</a>';
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

    $this->_validate();
    // Create QR code
    $qrCode = QrCode::create(''.$request->getPost('NoInduk').'')
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

    $logo = Logo::create('../public/assets/img/brand/amgalogo.png')
    ->setResizeToWidth(80);

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
    $result = $writer->write($qrCode, $logo);
    $result->saveToFile('../public/assets/qr_code/'.$request->getPost('NoInduk').'-QR.png');
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
    $this->_validate();
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
  private function _validate(){
    $request = Services::request();
    $buku = new ModelBuku($request);

    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = TRUE;

    if($this->request->getPost('NoInduk') == ''){
      $data['error_string'][] = 'NoInduk';
      $data['inputerror'][] = 'No Induk harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('Isbn') == ''){
      $data['error_string'][] = 'Isbn';
      $data['inputerror'][] = 'ISBN harus diisi';
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
    if($this->request->getPost('KotaTerbit') == ''){
      $data['error_string'][] = 'KotaTerbit';
      $data['inputerror'][] = 'Kota Terbit harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('Penerbit') == ''){
      $data['error_string'][] = 'Penerbit';
      $data['inputerror'][] = 'Penerbit harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('TahunTerbit') == ''){
      $data['error_string'][] = 'TahunTerbit';
      $data['inputerror'][] = 'Tahun Terbit harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('Eksemplar') == ''){
      $data['error_string'][] = 'Eksemplar';
      $data['inputerror'][] = 'Eksemplar harus diisi';
      $data['status'] = FALSE;
    }
    if($this->request->getPost('Rak') == ''){
      $data['error_string'][] = 'Rak';
      $data['inputerror'][] = 'No rak harus diisi';
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
    $buku = new ModelBuku($request);
    $petugas = new PetugasModel($request);
    $hasil = $buku->get();
    $table = '';
    $footer = '';
    $no = 1;

    $mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'format' => [210, 330], 'orientation' => 'L']);
    $mpdf->curlAllowUnsafeSslRequests = true;

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
                  <td align="center">'.$row['no_induk'].'</td>
                  <td>'.$row['isbn'].'</td>
                  <td>'.$row['judul_buku'].'</td>
                  <td>'.$row['pengarang_buku'].'</td>
                  <td>'.$row['kota_dibuat'].'</td>
                  <td>'.$row['penerbit_buku'].'</td>
                  <td align="center">'.$row['tahun_buku'].'</td>
                  <td align="center">'.$row['eksemplar_buku'].'</td>
                  <td>'.$row['kategori_buku'].'</td>
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
          <td> Data Buku Perpustakaan "Inti Gading"</td>
        </tr>
      </table>
      <p>Diberitahukan dengan hormat bahwa di bawah ini adalah data buku perpustakaan "Inti Gading" :</p>
      <table border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
          <tr>
            <th>No.</th>
            <th>No. Induk</th>
            <th>ISBN</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Kota</th>
            <th>Penerbit</th>
            <th>Tahun</th>
            <th>Jml. Eksemplar</th>
            <th>Kategori</th>
          </tr>
        </thead>
        <tbody>
            '.$table.'
        </tbody>
      </table>
    </div>
    '.$footer.'
    ');

    $mpdf->Output('Daftar_Buku.pdf','I');
    exit;
  }

  public function cetak_label($id){
    $request = Services::request();
    $buku = new ModelBuku($request);
    $hasil = $buku->where(['no_induk' => $id])->get();
    $table = '';

    $mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'orientation' => 'P', 'format' => [210,330]]);
    $mpdf->curlAllowUnsafeSslRequests = true;

    foreach ($hasil->getResult('array') as $row) {
      $qr = base_url('assets/qr_code/'.$row['qr_code']);
      for ($i=1; $i <= $row['eksemplar_buku'] ; $i++) {
        $table .= '<tr>
                    <td>
                      <div class="label">
                        <table border="1" cellpadding="5" cellspacing="0">
                          <tr>
                            <td colspan="2" align="center">PERPUSTAKAAN "INTI GADING"</td>
                          </tr>
                          <tr>
                            <td rowspan="4"><img src="'.$qr.'" height="80px" width="80px"></td>
                            <td align="center">'.$row['no_induk'].'</td>
                          </tr>
                          <tr>
                            <td align="center">'.$row['judul_buku'].'</td>
                          </tr>
                          <tr>
                            <td align="center">'.$row['kategori_buku'].'</td>
                          </tr>
                          <tr>
                            <td align="center">'.$i.'/'.$row['eksemplar_buku'].'</td>
                          </tr>
                        </table>
                      </div>
                    </td>
                  </tr>';
      }
      $mpdf->WriteHTML('
      <table cellspacing = "10">
        <tbody>
          '.$table.'
        </tbody>
      </table>
      ');
      }

    $mpdf->Output('Label_Buku_'.$id.'.pdf','I');
    exit;
  }
}
?>
