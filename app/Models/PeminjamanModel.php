<?php

namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class PeminjamanModel extends Model {

  protected $table = "data_peminjaman";
  protected $column_order = array('id_peminjaman','tanggal_pinjam','tanggal_kembali','id_buku','jml_pinjam','id_anggota','status');
  protected $column_search = array('id_peminjaman','tanggal_pinjam','tanggal_kembali','id_buku','jml_pinjam','id_anggota','status');
  protected $order = array('id_peminjaman' => 'asc');
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
    $query = $this->dt->get();
    return $query->getResult();
  }

  function get_datatables_anggota(){
    $this->_get_datatables_query();
    if($this->request->getPost('length') != -1)
    $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
    $id = session()->get('id');
    $query = $this->dt->where('id_anggota', $id)->get();
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

  public function save_pinjam($data)
  {
    $query = $this->dt->insert($data);
    return $query;
  }

  public function update_stok_minus($where, $data){
    $db = \Config\Database::connect();
    $builder = $db->table('data_buku');
    $builder->set('eksemplar_buku', 'eksemplar_buku -'.$data, false)->where($where);
    $query = $builder->update();
    return $query;
  }

  public function update_stok_plus($where1, $data1){
    $db = \Config\Database::connect();
    $builder = $db->table('data_buku');
    $builder->set('eksemplar_buku', 'eksemplar_buku +'.$data1, false)->where($where1);
    $query = $builder->update();
    return $query;
  }

  public function delete_by_id($id, $induk)
  {
    $db = \Config\Database::connect();
    $builder = $db->table('data_peminjaman');
    $builder->where('id_peminjaman', $id)->where('id_buku', $induk);
    $query = $builder->delete();
    return $query;
  }

  public function konfirmasi_pinjam($id){
    $db = \Config\Database::connect();
    $builder = $db->table('data_peminjaman');
    $builder->set('status','Dipinjam');
    $builder->where('id_peminjaman',$id);
    $builder->update();
  }

  public function dikembalikan($id, $induk){
    $db = \Config\Database::connect();
    $builder = $db->table('data_peminjaman');
    $builder->set('status','Dikembalikan');
    $builder->where('id_peminjaman',$id)->where('id_buku', $induk);
    $builder->update();
  }

  public function insert_tabel_kembali($data){
    $db = \Config\Database::connect();
    $builder = $db->table('data_pengembalian');
    $builder->insert($data);
  }

  public function delete_pengembalian($id){
    $db = \Config\Database::connect();
    $builder = $db->table('data_pengembalian');
    $builder->where('id_peminjaman', $id);
    $query = $builder->delete();
    return $query;
  }

}
?>
