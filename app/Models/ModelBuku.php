<?php

namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ModelBuku extends Model {

protected $table = "data_buku";
protected $column_order = array('no_induk','isbn','judul_buku','pengarang_buku','kota_dibuat','penerbit_buku','tahun_buku','eksemplar_buku','no_rak','kategori_buku','qr_code');
protected $column_search = array('no_induk','isbn','judul_buku','pengarang_buku','kota_dibuat','penerbit_buku','tahun_buku','eksemplar_buku','no_rak','kategori_buku','qr_code');
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

public function save_buku($data)
{
  $query = $this->dt->insert($data);
  return $query;
}

public function get_by_id($id)
{
    $this->dt->from($this->data_buku);
    $this->dt->where('no_induk',$id);
    $query = $this->dt->get();
    return $query->getResult();
}

public function buku_update($where, $data)
{
    $this->dt->update($data, $where);
    $query = $this->dt->get();
    return $query->getResult();
}

public function delete_by_id($id)
{
  $query = $this->dt->delete(array('no_induk' => $id));
  return $query;
}

function count_filtered(){
    $this->_get_datatables_query();
    return $this->dt->countAllResults();
}

public function count_all(){
    $tbl_storage = $this->db->table($this->table);
    return $tbl_storage->countAllResults();
}

}
