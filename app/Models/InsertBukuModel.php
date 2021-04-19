<?php

namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class InsertBukuModel extends Model {

  protected $table = "insert_buku";
  protected $column_order = array('no_induk','judul_buku','kategori_buku','eksemplar_buku','tanggal_insert');
  protected $column_search = array('no_induk','judul_buku');
  protected $order = array('no_induk' => 'asc');
  protected $request;
  protected $db;
  protected $dt;

  function __construct(RequestInterface $request){
    parent::__construct();
    $this->db = db_connect();
    $this->request = $request;
    $this->dt = $this->db->table($this->table);
  }
}
