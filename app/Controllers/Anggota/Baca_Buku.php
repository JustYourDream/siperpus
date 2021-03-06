<?php

namespace App\Controllers\Anggota;
use CodeIgniter\Controller;
use App\Models\EbookModel;
use Config\Services;

class Baca_Buku extends Controller
{
	public function index()
	{
		helper('form');
		$request = Services::request();
		$pager = \Config\Services::pager();
		$ebook = new EbookModel($request);

    $keyword            = $this->request->getGet('keyword');

    $data['keyword']    = $keyword;
		$data['title'] 			= 'Baca Buku';

    // filter
    $like       = [];
    $or_like    = [];

    if(!empty($keyword)){
        $like   = ['data_ebook.judul_ebook' => $keyword];
        $or_like   = ['data_ebook.pengarang' => $keyword, 'data_ebook.penerbit' => $keyword, 'data_ebook.kategori_ebook' => $keyword];
    }
    // end filter
		$data['ebook'] = $ebook->select('*')->like($like)->orLike($or_like)->paginate(8, 'ebook');
		$data['pager'] = $ebook->pager;

		if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Anggota"){
				return view('anggota/baca_buku', $data);
			}else{
				return view('access_denied');
			}
		}
	}
	public function view_buku($id_ebook){
		$request = Services::request();
		$ebook = new EbookModel($request);

		$id = $id_ebook;
		$data['title'] = 'Baca Buku Digital';
		$data['id_ebook'] = $id;
		$data['judul_ebook'] = implode(" ",$ebook->select('judul_ebook')->where(['id_ebook' => $id])->first());
		$data['file_ebook'] = implode(" ",$ebook->select('file_ebook')->where(['id_ebook' => $id])->first());

		echo view('anggota/view_buku', $data);
	}
}
