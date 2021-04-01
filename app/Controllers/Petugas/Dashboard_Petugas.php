<?php

namespace App\Controllers\Petugas;
use CodeIgniter\Controller;

class Dashboard_Petugas extends Controller
{
	public function index()
	{
		return view('petugas/petugas');
	}
}
