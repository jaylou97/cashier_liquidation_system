<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_controller extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model("main_model");
		$this->load->model("liquidation_model");
		$this->load->model("login_model");
		$this->load->helper('text');
	}

	public function login_ctrl()
	{
		$this->load->view('login_side/login_form');
		$this->load->view('login_side/login_js');
	}

	public function logout_ctrl()
	{
		session_destroy();

		$this->load->view('login_side/login_form');
		$this->load->view('login_side/login_js');
	}

	public function validate_user_ctrl()
	{
		$front = $_POST['front'];
		$back = $_POST['back'];
		$user = $this->login_model->validate_user_model($front,$back);
        
        if(empty($user))
        {
        	$front2 = $front * 1;
        	$back2 = $back * 1;
        	$user2 = $this->login_model->validate_user_model($front2,$back2);

        	if(empty($user2))
        	{
        		$message = 'INVALID USER';
        		$route = '';
				$emp_id = '';
        	}
        	else
	        {
	        	$message = 'CONFIRMED USER';

	        	$route = '';
				$emp_id = '';
	        	foreach($user2 as $u2)
	        	{
	        		$route = $u2['cashier_path'];
	        		$emp_id = $u2['emp_id'];

	        		$_SESSION['emp_id'] = $emp_id;
	        	}

				$emp_data = $this->login_model->get_pisdata_model($emp_id);
				$data['name'] = $emp_data->name;

				$info = $this->main_model->info_mod($emp_id);
				$path = base_url();
				$path = str_replace('/EBS/cebo_cs_liquidation', '', $path);
				$data['photo_url'] = $path . "/hrms/" . substr($info->photo, 3);
	        }

        }
        else
        {
        	$message = 'CONFIRMED USER';

        	$route = '';
			$emp_id = '';
        	foreach($user as $u)
        	{
        		$route = $u['cashier_path'];
        		$emp_id = $u['emp_id'];

        		$_SESSION['emp_id'] = $emp_id;
        	}

			$emp_data = $this->login_model->get_pisdata_model($emp_id);
			$data['name'] = $emp_data->name;
			
			$info = $this->main_model->info_mod($emp_id);
			$path = base_url();
			$path = str_replace('/EBS/cebo_cs_liquidation', '', $path);
			$data['photo_url'] = $path . "/hrms/" . substr($info->photo, 3);
        }
		

        $data['message']=$message;                      
        $data['route']=$route;                      
        echo json_encode($data);
	}

}
