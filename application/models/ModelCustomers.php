<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
class ModelCustomers extends CI_Model {
	protected $_table = "customers";
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getList($selectColumns = "*", $whereCondition = array(), $orderBy="id", $limit = 50, $offset = 0) {
		$this->db->select($selectColumns);
		foreach($whereCondition as $column => $condition) {
			$this->db->where($column, $condition);
		}
		$this->db->order_by($orderBy);
		$this->db->limit($limit , $offset);
		$this->db->from($this->_table);
        return $this->db->get()->result_array();
	}
	
	public function search($selectColumns = "*", $likeCondition = array(), $orderBy="id", $limit = 50, $offset = 0) {
		$this->db->select($selectColumns);
		foreach($likeCondition as $column => $condition) {
			$this->db->like($column, $condition);
		}
		$this->db->order_by($orderBy);
		$this->db->limit($limit , $offset);
		$this->db->from($this->_table);
        return $this->db->get()->result_array();
	}
	
	public function getCount($whereCondition = array()) {
		$this->db->from($this->_table);
		foreach($whereCondition as $column => $condition) {
			$this->db->where($column, $condition);
		}
		return $this->db->count_all_results(); 
	}
	
	public function getCountSearch($likeCondition = array()) {
		$this->db->from($this->_table);
		foreach($likeCondition as $column => $condition) {
			$this->db->like($column, $condition);
		}
		return $this->db->count_all_results(); 
	}
	
	public function update($data, $whereCondition) {
		foreach($whereCondition as $column => $condition) {
			$this->db->where($column, $condition);
		}
		return $this->db->update($this->_table, $data);
	}
	
	public function insert($data) {
		return $this->db->insert($this->_table, $data);
	}
	
	public function delete($whereCondition) {
		foreach($whereCondition as $column => $condition) {
			$this->db->where($column, $condition);
		}
		return $this->db->delete($this->_table);
	}
}
?>