<?php

namespace App\Controllers\Ketua;
use CodeIgniter\Controller;

class Dashboard_Ketua extends Controller
{
	public function index()
	{
		$data['title'] = 'Dashboard';
		if(session()->get('logged_in') !== TRUE){
			session()->setFlashdata('error', '<center>Silahkan login dulu!</center>');
			return view('login/login');
		}else{
			if(session()->get('role') == "Ketua"){
				return view('ketua/dashboard', $data);
			}else{
				return view('access_denied');
			}
		}
	}
}
