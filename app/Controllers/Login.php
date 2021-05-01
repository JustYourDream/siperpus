<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsersModel;

class Login extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        if(session()->get('logged_in') !== TRUE){
          return view('login/login');
        }else{
          if(session()->get('role') == "Petugas"){
            return view('petugas/petugas', $data);
          }elseif(session()->get('role') == "Anggota"){
            return view('anggota/dashboard', $data);
          }
        }
    }
    public function process()
    {
        $users = new UsersModel();
        $id = $this->request->getVar('id');
        $password = md5($this->request->getVar('password'));
        $dataUser = $users->where([
            'id' => $id,
        ])->first();
        if ($dataUser) {
            $pass = $dataUser['password'];
            if ($pass == $password) {
              session()->set([
                'id' => $dataUser['id'],
                'nama' => $dataUser['nama'],
                'role' => $dataUser['role'],
                'password' => $dataUser['password'],
                'logged_in' => TRUE,
              ]);
              $role = session()->get('role');
              if($role == "Petugas"){
                return redirect()->to(base_url('petugas/dashboard_petugas'));
              }elseif ($role == "Anggota") {
                return redirect()->to(base_url('anggota/dashboard_anggota'));
              }
            } else {
                session()->setFlashdata('error', '<center>Password Salah!</center>');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', '<center>Username Salah!</center>');
            return redirect()->back();
        }
    }
    function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
?>
