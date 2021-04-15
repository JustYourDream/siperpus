<?php

namespace App\Controllers\Anggota;
use CodeIgniter\Controller;

class Dashboard_Anggota extends Controller
{
	public function index()
	{
		return view('anggota/dashboard');
	}
}
