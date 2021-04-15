<?php

namespace App\Controllers;
use App\Models\ModelBuku;
use Config\Services;

class Home extends BaseController
{
	public function index()
	{
		return view('homepage/home');
	}

	public function cari_buku($query)
	{
		$request = Services::request();
    $buku = new ModelBuku($request);
		$buku->select("*");
		if($query != '')
		{
			$buku->like('no_induk', $query);
			$buku->orLike('isbn', $query);
			$buku->orLike('judul_buku', $query);
			$buku->orLike('pengarang_buku', $query);
			$buku->orLike('penerbit_buku', $query);
			$buku->orLike('kategori_buku', $query);
		}
		$buku->orderBy('no_induk', 'DESC');
		$hasil = $buku->get();

		$output = '';
		$output .= '
  	<div class="table-responsive">
     <table class="table table-bordered table-striped">
      <tr>
				<th>No. Induk</th>
				<th>Judul Buku</th>
				<th>Pengarang</th>
				<th>Penerbit</th>
				<th>Eksemplar</th>
				<th>No. Rak</th>
				<th>Kategori</th>
      </tr>
  	';
		if($buku->countAllResults() > 0)
		{
			foreach($hasil->getResult() as $row)
			{
				$output .= '
				<tr>
					<td>'.$row->no_induk.'</td>
					<td>'.$row->judul_buku.'</td>
					<td>'.$row->pengarang_buku.'</td>
					<td>'.$row->penerbit_buku.'</td>
					<td>'.$row->eksemplar_buku.'</td>
					<td>'.$row->no_rak.'</td>
					<td>'.$row->kategori_buku.'</td>
				</tr>
				';
			}
		}
		$output .= '</table></div>';
		echo $output;

	}
}
