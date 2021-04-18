<?php

namespace App\Controllers;
use App\Models\EbookModel;
use Config\Services;

class Ebook extends BaseController
{
	public function index()
	{
		helper('form');
		$request = Services::request();
		$pager = \Config\Services::pager();
		$ebook = new EbookModel($request);

    $keyword            = $this->request->getGet('keyword');

    $data['keyword']    = $keyword;

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

		return view('homepage/ebook', $data);
	}
}
