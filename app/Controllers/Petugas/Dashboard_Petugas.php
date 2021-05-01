<?php

namespace App\Controllers\Petugas;
use CodeIgniter\Controller;

class Dashboard_Petugas extends Controller
{
	public function index()
	{
		$data['title'] = 'Dashboard';
		if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Petugas"){
				return view('petugas/petugas', $data);
			}else{
				return view('access_denied');
			}
		}
	}
}
