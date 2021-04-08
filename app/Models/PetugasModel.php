<?php
namespace App\Models;
use CodeIgniter\Model;

/**
 *
 */
class PetugasModel extends Model{
  protected $table = "petugas";

  public function petugas_id($id)
  {
    $db = \Config\Database::connect();
    $builder = $db->table('petugas');
    $builder->from($this->petugas);
    $builder->where('id_petugas', $id);
    $query = $builder->get();
    return $query->getResult();
  }
  public function akun_update($where, $data)
  {
    $db = \Config\Database::connect();
    $builder = $db->table('petugas');
    $builder->update($data, $where);
    $query = $builder->get();
    return $query->getResult();
  }
  public function akun_login_update($where1, $data1){
    $db = \Config\Database::connect();
    $builder = $db->table('pengguna');
    $builder->update($data1, $where1);
    $query = $builder->get();
    return $query->getResult();
  }
  public function ganti_pw($id, $data2){
    $db = \Config\Database::connect();
    $builder = $db->table('pengguna');
    $builder->update($data2, array('id' => $id));
    $query = $builder->get();
    return $query->getResult();
  }
  public function simpan_gambar($where, $data){
    $db = \Config\Database::connect();
    $builder = $db->table('petugas');
    $builder->update($data, $where);
  }
}
?>
