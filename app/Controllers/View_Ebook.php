<?php

namespace App\Controllers;
use App\Models\EbookModel;
use Config\Services;

class View_Ebook extends BaseController
{
	public function view($id_ebook)
	{
		$request = Services::request();
		$ebook = new EbookModel($request);

    $id = $id_ebook;
		$data['id_ebook'] = $id;
		$data['judul_ebook'] = implode(" ",$ebook->select('judul_ebook')->where(['id_ebook' => $id])->first());
		$data['file_ebook'] = implode(" ",$ebook->select('file_ebook')->where(['id_ebook' => $id])->first());

		return view('homepage/view_ebook', $data);
	}
}
