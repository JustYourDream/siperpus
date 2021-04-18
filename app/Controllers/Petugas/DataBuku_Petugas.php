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
  public function cetak_list(){
    $request = Services::request();
    $buku = new ModelBuku($request);
    $hasil = $buku->get();
    $table = '';
    $no = 1;

    $mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'format' => [210, 330], 'orientation' => 'L']);

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
      <h1><font size="5" face="times new roman">PERPUSTAKAAN "INTI GADING"</font></h1>
      <b><font size="4" face="Courier New">SMK NEGERI 1 AMPELGADING</font></b><br/>
      <b>Jl. Raya Ujunggede (Pantura), Ampelgading, Kabupaten Pemalang, 52364<b><br/><br/>
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
    <div style="margin-top: 20px;">
      <table width="100%">
        <tr>
          <td rowspan="5" width="75%"></td>
          <td class="ttd">Ampelgading, '.date('d-m-Y').'</td>
        </tr>
        <tr>
          <td class="ttd">Ketua Perpustakaan "Inti Gading"</td>
        </tr>
        <tr>
          <td height="80px"></td>
        </tr>
        <tr>
          <td class="ttd"><b><u>Alfian Maulana</u></b></td>
        </tr>
        <tr>
          <td class="ttd">NIP : 18.110.0018</td>
        </tr>
      </table>
    </div>
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
      <table>
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
