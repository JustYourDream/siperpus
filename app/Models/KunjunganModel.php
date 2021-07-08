<?php

namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class KunjunganModel extends Model {

  protected $table = "data_pengunjung";
  protected $column_order = array('no','no_anggota','nama','tanggal_kunjungan','jurusan_anggota');
  protected $column_search = array('no_anggota','nama','jurusan_anggota','tanggal_kunjungan');
  protected $order = array('tanggal_kunjungan' => 'asc');
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

  function count_filtered(){
    $this->_get_datatables_query();
    return $this->dt->countAllResults();
  }

  public function count_all(){
    $tbl_storage = $this->db->table($this->table);
    return $tbl_storage->countAllResults();
  }

  public function get_list_jurusan()
  {
    $db = \Config\Database::connect();
    $builder = $db->table('data_pengunjung');
    $builder->select('jurusan_anggota')->groupBy('jurusan_anggota')->orderBy('jurusan_anggota','asc');
    $query = $builder->get();
    $result = $query->getResult();

    $jurusan = array();
    foreach ($result as $row)
    {
      $jurusan[] = $row->jurusan_anggota;
    }
    return $jurusan;
  }

  public function get_list_tahun()
  {
    $db = \Config\Database::connect();
    $builder = $db->table('data_pengunjung');
    $builder->select('YEAR(tanggal_kunjungan) AS Tahun')->groupBy('YEAR(tanggal_kunjungan)')->orderBy('tanggal_kunjungan','asc');
    $query = $builder->get();
    $result = $query->getResult();

    $tahun = array();
    foreach ($result as $row)
    {
      $tahun[] = $row->Tahun;
    }
    return $tahun;
  }

  public function save_kunjungan($data)
  {
    $db = \Config\Database::connect();
    $builder = $db->table('data_pengunjung');
    $builder->insert($data);
  }
}

?>
