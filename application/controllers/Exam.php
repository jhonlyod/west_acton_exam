<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Exam extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('My_model','mm');
      $this->load->library('encrypt');
  }

  function index(){
    $this->my_data['product_list'] = $this->mm->getRows('products');

    $options = array('where' => 'qty != 0', );
    $this->my_data['product_list_dropdown'] = $this->mm->getRows('products',$options);
    $this->_show_view('exam/index');
  }
  function sales(){
    $this->my_data['sales'] = $this->mm->getRows('sales');
    $this->_show_view('exam/sales');
  }

  function get_product_per_id(){
    // echo "string";exit;
    $id = $this->encrypt->decode($this->input->post('id'));
    $options = array('where' => 'id='.$id.'', );
    $res = $this->mm->getRows('products',$options,'row');
    if ($res) {
      echo json_encode(array('error' => '','data'=>$res));
    }else {
        echo json_encode(array('error' => 'error',));
    }
  }

  function saveproduct(){
    $data = $this->input->post();
    $data = array(
      'name'  => $data['name'],
      'price' => $data['price'],
      'qty'   => $data['qty'],
    );
    $qry = $this->mm->insert('products',$data);
    if ($qry) {
      $id = $this->db->insert_id();
      $this->session->set_flashdata('item',$id);
    }else {
      $this->session->set_flashdata('error','error');
    }
    redirect(base_url());
  }

  function update_price_per_product(){
    $product_id = $this->input->post('product_id');
    $price = $this->input->post('price');
    $res = $this->db->query("UPDATE products SET price = $price WHERE id = $product_id");
    if ($res) {
      echo "success";
    }else {
        echo "error";
    }
  }
  function update_qty_per_product(){
    $product_id = $this->input->post('product_id');
    $qty = $this->input->post('qty');
    $res = $this->db->query("UPDATE products SET qty = $qty WHERE id = $product_id");
    if ($res) {
      echo "success";
    }else {
        echo "error";
    }
  }

  function stock_update_in_sale($product_id='',$qty){
    $res = $this->db->query("UPDATE products SET qty = qty - $qty WHERE id = $product_id");
    if ($res) {
      return TRUE;
    }else {
      return FALSE;
    }
  }
  function get_sale_id(){
    $maxid = $this->db->query('SELECT MAX(sale_ref_id) AS `maxid` FROM `sales_ref_id`')->row()->maxid;
    return $maxid;
  }
  function update_sale_id($newid=''){
    $this->db->query('Update sales_ref_id SET sale_ref_id = '.$newid.'');
    $maxid = $this->get_sale_id();
    return $maxid;
  }
  function sellproduct(){
    $sale_id = $this->get_sale_id();
    $data_post = $this->input->post();
    $newsailid = $this->update_sale_id($sale_id+1);
    foreach ($data_post['product_id'] as $key => $data) {
      $stupdate = $this->stock_update_in_sale($data_post['product_id'][$key],$data_post['qty'][$key]);
      if ($stupdate == TRUE) {
        $post= array(
            'product_id' => $data_post['product_id'][$key],
            'date_added' => date('Y-m-d'),
            'qty'        => $data_post['qty'][$key],
            'name'       => $data_post['name'][$key],
            'price'      => $data_post['price'][$key],
            'sale_id'    => $newsailid
            );
            $res = $this->db->insert('sales', $post);
            $id = $this->db->insert_id();
      }else {
          $this->session->set_flashdata('error','error');
      }
    }

    if ($res) {
      $this->session->set_flashdata('stupdate',$id);
    }else {
      $this->session->set_flashdata('error','error');
    }
    redirect(base_url());
    // $this->mm->insert('products',);
  }

  function _show_view($content){
    $this->load->view('exam/header', @$this->my_data);
    $this->load->view('exam/nav');
    $this->load->view('exam/sidebar');

    if ( ! empty($content)){
      $this->load->view($content, @$this->my_data);
    }
    $this->load->view('exam/footer');
  }
}
