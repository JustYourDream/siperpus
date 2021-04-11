<?php

namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class KunjunganModel extends Model {

  protected $table = "data_pengunjung";
  protected $column_order = array('no','no_anggota','nama','tanggal_kunjungan');
  protected $column_search = array('no_anggota','nama');
  protected $order = array('no_anggota' => 'asc');
  protected $request;
  protected $db;
  protected $dt;

  function __construct(RequestInterface $request){
    parent::__construct();
    $this->db = db_connect();
    $this->request = $request;
    $this->dt = $this->db->table($this->table);
  }

  public function save_kunjungan($data)
  {
    $db = \Config\Database::connect();
    $builder = $db->table('data_pengunjung');
    $builder->insert($data);
  }
}

?>
