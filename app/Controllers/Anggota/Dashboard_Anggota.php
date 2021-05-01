<?php

namespace App\Controllers\Anggota;
use CodeIgniter\Controller;

class Dashboard_Anggota extends Controller
{
	public function index()
	{
		$data['title'] = 'Dashboard';
		if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Anggota"){
				return view('anggota/dashboard', $data);
			}else{
				return view('access_denied');
			}
		}
	}
}
