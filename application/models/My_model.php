<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_model extends CI_Model {

     public function __construct(){
          parent::__construct();
     }
     public function getSQL($query, $result = '')
    {
        $query = $this->db->query($query);

        if ($query->num_rows() > 0) {
            if (!empty($result) && $result == 'row') {
                return $query->row_array();
            } else {
                return $query->result_array();
            }
        } else {
            return false;
        }
    }
    public function getRows($table,$options = array(),$result = 'array'){

        (!empty($options['select'])) ? $this->db->select($options['select']) : $this->db->select("*");

        (!empty($options['where'])) ? $this->db->where($options['where']) : null;

        (!empty($options['or_where'])) ? $this->db->or_where($options['or_where']) : null;


        if (!empty($options['or_where_group'])) {
            $this->db->group_start();
            foreach ($options['or_where_group'] as $key => $value) {
                $this->db->or_where(array($key => $value));
            }
            $this->db->group_end();
        }

        (!empty($options['where_not_in'])) ? $this->db->where_not_in($options['where_not_in']['col'],$options['where_not_in']['value']) : null;

        (!empty($options['where_in'])) ? $this->db->where_in($options['where_in']['col'],$options['where_in']['value']) : null;

        if(!empty($options['join'])){
            foreach($options['join'] as $key => $value){
                if(strpos($value,':') !== false){
                    $joiner = explode(":",$value);
                    $this->db->join($key,$joiner[0],$joiner[1]);
                } else {
                    $this->db->join($key,$value);
                }
            }
        }

        (!empty($options['group'])) ? $this->db->group_by($options['group']) : null;

        (!empty($options['limit'])) ? $this->db->limit($options['limit'][0], $options['limit'][1]) : null;

        (!empty($options['order'])) ? $this->db->order_by($options['order'], $options['order_option']) : null;

        $query = $this->db->get($table);

        switch ($result) {
            case 'array':
                return $query->result_array();
            break;
            case 'obj':
                return $query->result();
            break;
            case 'row':
                return $query->row();
            break;
            case 'row_array':
                return $query->row_array();
            break;
            case 'count':
                return $query->num_rows();
            break;
            default:
                return $query->result_array();
            break;
        }

    }
    public function get_datatables2($table, $column_order, $select = "*", $where = "", $join = array(), $limit, $offset, $search, $order,$group = ''){
	  	$this->db->from($table);
	  	$columns = $this->db->list_fields($table);
	  	if($select){ $this->db->select($select); }
	  	if($where){ $this->db->where($where); }
      // echo $where;exit;
	  	if($join){
            foreach($join as $key => $value){
                if(strpos($value,':') !== false){
                    $joiner = explode(":",$value);
                    $this->db->join($key,$joiner[0],$joiner[1]);
                } else {
                    $this->db->join($key,$value);
                }
            }
	  	}
	  	if($search){
	  		$this->db->group_start();
	  		foreach ($column_order as $item)
	  		{
	  			$this->db->or_like($item, $search['value']);
	  		}
	  		$this->db->group_end();
	  	}
      // $this->db->last_query();exit;
	  	if($group)
	  		$this->db->group_by($group);

	  	if($order)
	  		// $this->db->order_by($column_order[$order['0']['column']], $order['0']['dir']);
        $this->db->order_by($order['0']['column'], $order['0']['dir']);
        // echo "<pre>";print_r($order);exit;
	    	$temp = clone $this->db;
	    	$data['count'] = $temp->count_all_results();

	  	if($limit != -1)
	  		$this->db->limit($limit, $offset);

	  	$query = $this->db->get();
	  	$data['data'] = $query->result();

	  	$this->db->from($table);
	  	$data['count_all'] = $this->db->count_all_results();
	  	return $data;
	}
    public function get_datatables($table, $column_order, $select = "*", $where = "", $join = array(), $limit, $offset, $search, $order,$group = ''){
	  	$this->db->from($table);
	  	$columns = $this->db->list_fields($table);
	  	if($select){ $this->db->select($select); }
	  	if($where){ $this->db->where($where); }
      // echo $where;exit;
	  	if($join){
            foreach($join as $key => $value){
                if(strpos($value,':') !== false){
                    $joiner = explode(":",$value);
                    $this->db->join($key,$joiner[0],$joiner[1]);
                } else {
                    $this->db->join($key,$value);
                }
            }
	  	}
	  	if($search){
	  		$this->db->group_start();
	  		foreach ($column_order as $item)
	  		{
	  			$this->db->or_like($item, $search['value']);
	  		}
	  		$this->db->group_end();
	  	}
      // $this->db->last_query();exit;
	  	if($group)
	  		$this->db->group_by($group);

	  	if($order)
	  		$this->db->order_by($column_order[$order['0']['column']], $order['0']['dir']);

	    	$temp = clone $this->db;
	    	$data['count'] = $temp->count_all_results();

	  	if($limit != -1)
	  		$this->db->limit($limit, $offset);

	  	$query = $this->db->get();
	  	$data['data'] = $query->result();

	  	$this->db->from($table);
	  	$data['count_all'] = $this->db->count_all_results();
	  	return $data;
	}

    public function insert($table,$data){
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    public function insert_batch($table,$set){
        $this->db->insert_batch($table,$set);
        return true;
    }

    public function update($table,$set,$where = array()){
        $this->db->where($where);
        $this->db->update($table,$set);
        return true;
    }

    public function delete($table,$where = array()){
        $this->db->where($where);
        $this->db->delete($table);
        return true;
    }
}
