<?php
namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class PetugasModel extends Model{

  protected $table = "petugas";
  protected $column_order = array('id_petugas','nama_petugas','jabatan_petugas','no_telp_petugas','alamat_petugas','foto_petugas');
  protected $column_search = array('id_petugas','nama_petugas');
  protected $order = array('id_petugas' => 'asc');
  protected $request;
  protected $db;
  protected $dt;

  function __construct(RequestInterface $request){
    parent::__construct();
    $this->db = db_connect();
    $this->request = $request;
    $this->dt = $this->db->table($this->table);
  }

  private function _get_datatables_query(){
    $i = 0;
    foreach ($this->column_search as $item){
      if($this->request->getPost('search')['value']){
        if($i===0){
          $this->dt->groupStart();
          $this->dt->like($item, $this->request->getPost('search')['value']);
        }
        else{
          $this->dt->orLike($item, $this->request->getPost('search')['value']);
        }
        if(count($this->column_search) - 1 == $i)
        $this->dt->groupEnd();
      }
      $i++;
    }

    if($this->request->getPost('order')){
      $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
    }
    else if(isset($this->order)){
      $order = $this->order;
      $this->dt->orderBy(key($order), $order[key($order)]);
    }
  }

  function get_datatables(){
    $this->_get_datatables_query();
    if($this->request->getPost('length') != -1)
    $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
    $query = $this->dt->where(['jabatan_petugas' => 'Petugas'])->get();
    return $query->getResult();
  }

  function count_filtered(){
    $this->_get_datatables_query();
    return $this->dt->countAllResults();
  }

  public function count_all(){
    $tbl_storage = $this->db->table($this->table);
    return $tbl_storage->countAllResults();
  }

  public function petugas_id($id)
  {
    $this->dt->where('id_petugas',$id);
    $query = $this->dt->get();
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

  public function save_petugas($data)
  {
    $query = $this->dt->insert($data);
    return $query;
  }

  public function save_pengguna($data)
  {
    $db = \Config\Database::connect();
    $builder = $db->table('pengguna');
    $builder->insert($data);
  }

  public function update_petugas($where, $data)
  {
    $this->dt->update($data, $where);
    $query = $this->dt->get();
    return $query->getResult();
  }

  public function update_akun_petugas($where, $data)
  {
    $db = \Config\Database::connect();
    $builder = $db->table('pengguna');
    $builder->update($data, $where);
  }

  public function delete_by_id($id)
  {
    $query = $this->dt->delete(array('id_petugas' => $id));
    return $query;
  }

  public function delete_akun($id)
  {
    $db = \Config\Database::connect();
    $builder = $db->table('pengguna');
    $builder->delete(array('id' => $id));
  }
}
?>
