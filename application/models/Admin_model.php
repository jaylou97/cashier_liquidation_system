<?php

class Admin_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->db2 = $this->load->database('pis', TRUE);
    $this->load->database();
  }

  public function get_bunit_model()
  {
    $this->db2->select('*');
    $this->db2->from('locate_business_unit');
    // $this->db2->where_in('bcode', array('0201','0202','0203','0204','0205','0206','0223','0301'));
    $this->db2->where('bcode <>', '0701');
    $this->db2->where('bcode <>', '0702');
    $this->db2->where('bcode <>', '0703');
    $this->db2->where('bcode <>', '0202');
    $this->db2->where('bcode <>', '0219');
    $this->db2->where('bcode <>', '1112');
    $this->db2->where('bcode <>', '1205');
    $this->db2->where('bcode <>', '1302');
    $this->db2->where('bcode <>', '1902');
    $this->db2->where('bcode <>', '0221');
    $this->db2->where('bcode <>', '0801');
    $this->db2->order_by('business_unit', 'asc');

    $query = $this->db2->get();
    return $query->result_array();
  }

  public function get_bunit_model_v2()
  {
    $this->db2->select('bcode, business_unit');
    $this->db2->from('locate_business_unit');
    $this->db2->order_by('business_unit', 'asc');
    $query = $this->db2->get();
    return $query->result_array();
  }

  public function get_emp_name_model($emp_name)
  {
    $this->db2->select('*');
    $this->db2->from('employee3');
    $this->db2->where('current_status', 'active');
    $this->db2->like('name', $emp_name);
    $this->db2->order_by('name', 'asc');
    $this->db2->limit(5);

    $query = $this->db2->get();
    return $query->result_array();
  }

  public function get_empid_model($emp_name)
  {
    $this->db2->select('*');
    $this->db2->from('employee3');
    $this->db2->like('name', $emp_name);
    $this->db2->limit(1);

    $query = $this->db2->get();
    return $query->result_array();
  }

  public function addpayment_user_model($emp_id)
  {
    $this->db->set('emp_id', $emp_id);
    $this->db->insert('cs_addpayment_user');
  }

  public function validate_empid_model($emp_id)
  {
    $this->db->select('*');
    $this->db->from('cs_addpayment_user');
    $this->db->where('emp_id', $emp_id);

    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_users_model()
  {
    $this->db->select('*');
    $this->db->from('cs_addpayment_user');

    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_empname_model($emp_id)
  {
    $this->db2->select('*');
    $this->db2->from('employee3');
    $this->db2->where('emp_id', $emp_id);

    $query = $this->db2->get();
    return $query->result_array();
  }

  public function delete_user_model($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('cs_addpayment_user');
  }


}

