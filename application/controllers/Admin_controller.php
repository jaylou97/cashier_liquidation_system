<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_controller extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model("main_model");
        $this->load->model("cashier_model");
		$this->load->model("liquidation_model");
		$this->load->model("cfscashier_model");
		$this->load->model("treasury_model");
		$this->load->model("supervisor_model");
        $this->load->model("admin_model");
		$this->load->helper('text');
	}

	public function admin_dashboard_ctrl()
	{
		$data['emp_id'] = $_SESSION['emp_id'];
		$data['username'] = $_SESSION['username'];

        if(empty($_SESSION['emp_id']))
        {
            redirect('http://'.$_SERVER['HTTP_HOST'].'/hrms/employee/');
        }
        else
        {
            $info = $this->main_model->info_mod($_SESSION['emp_id']);

            $data['photo_url'] =  $_SERVER['HTTP_HOST'] . "/hrms/" . substr($info->photo, 3);
         
            $this->load->view('admin_side/dashboard', $data);
        }
	}

	public function adduser_access_ctrl()
	{
		$data['emp_id'] = $_SESSION['emp_id'];
		$data['username'] = $_SESSION['username'];

        if(empty($_SESSION['emp_id']))
        {
            redirect('http://'.$_SERVER['HTTP_HOST'].'/hrms/employee/');
        }
        else
        {
            $info = $this->main_model->info_mod($_SESSION['emp_id']);

            $data['photo_url'] =  $_SERVER['HTTP_HOST'] . "/hrms/" . substr($info->photo, 3);
         
            $this->load->view('admin_side/addpayment_user_form', $data);
        }
	}

	public function admin_add_mop_ctrl()
    {
        $data['emp_id'] = $_SESSION['emp_id'];
        $data['username'] = $_SESSION['username'];

        if(empty($_SESSION['emp_id']))
        {
            redirect('http://'.$_SERVER['HTTP_HOST'].'/hrms/employee/');
        }
        else
        {
            $info = $this->main_model->info_mod($_SESSION['emp_id']);

            $data['photo_url'] =  $_SERVER['HTTP_HOST'] . "/hrms/" . substr($info->photo, 3);
         
            $this->load->view('admin_side/add_bu_mop', $data);
        }
    }

	public function display_bunit_ctrl()
	{
		$bunit_data = $this->admin_model->get_bunit_model();
		// var_dump($bunit_data);
		
		$bunit_name = '';
		foreach($bunit_data as $data)
		{
			$bunit_name.='
						<option value="'.$data['bcode'].'">'.$data['business_unit'].'</option>
						';
		}

		$data['bunit_name'] = $bunit_name;
		echo json_encode($data);
	}

	public function search_emp_ctrl()
	{
		if(empty($_SESSION['emp_id']))
        {
            $message = "EXPIRED SESSION";
            echo json_encode($message);
        }
        else
        {
			$emp_data = $this->admin_model->get_emp_name_model($_POST['emp_name']);
			
			$emp_name = '';
			foreach($emp_data as $data)
			{
				$emp_name .= $data['name']."^";
			}
			// var_dump($emp_name);
			
			$data['emp_name'] = $emp_name;
			echo json_encode($data);
		}
	}

	public function addpayment_user_ctrl()
	{
		if(empty($_SESSION['emp_id']))
        {
            $message = "EXPIRED SESSION";
            echo json_encode($message);
        }
        else
        {
			$emp_data = $this->admin_model->get_empid_model($_POST['emp_name']);

			if(empty($emp_data))
			{
				$message = "INVALID EMPLOYEE";
            	echo json_encode($message);
			}
			else
			{	
				$emp_id = '';
				foreach($emp_data as $data)
				{
					$emp_id = $data['emp_id'];
				}
				
				$validate = $this->admin_model->validate_empid_model($emp_id);

				if(empty($validate))
				{
					$message = 'success';
					$this->admin_model->addpayment_user_model($emp_id);

					echo json_encode($message);
				}
				else
				{
					$message = "ALREADY EXIST";
            		echo json_encode($message);	
				}
			}
		}
	}

	public function display_user_ctrl()
	{
		$user_data = $this->admin_model->get_users_model();

		$html = '
				 <table class="table table-striped table-bordered table-hover display" id="addpayment_user_table" style="color: black; font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>EMPLOYEE NAME
                                            </th>
                                            <th>
                                                <center>ACTION
                                            </th>
                                        </tr>
                                    </thead>
                                    <form name="addpayment_user_viewing_form" id="addpayment_user_viewing_form">
                                        <tbody id="addpayment_user_viewing_tbody">
				';
		foreach($user_data as $data)
		{
			$emp_data = $this->admin_model->get_empname_model($data['emp_id']);
			
			$name = '';
			foreach($emp_data as $emp)
			{
				$name = $emp['name'];
			}

			$html.=' 
                        <tr>
                          <td>'.$name.'</td>
                          <td>
                            <input type="button" style="background-color: red; border: 0px; color: white;" onclick="delete_user_js('.$data['id'].', '."'".$name."'".')" value="DELETE">
                          </td>
                        </tr>
                      ';
		}

		$html.='
                            </tbody>
                        </form>
                    </table>

                    ';
                    // var_dump($html);
		$data['html'] = $html;
		echo json_encode($data);
	}

	public function delete_user_ctrl()
	{
		if(empty($_SESSION['emp_id']))
        {
            $message = "EXPIRED SESSION";
            echo json_encode($message);
        }
        else
        {
        	$message = 'success';
        	$this->admin_model->delete_user_model($_POST['id']);

        	echo json_encode($message);
        }
	}

	public function admin_get_bunit_ctrl()
    {
        $bunit_data = $this->liquidation_model->get_bunit_model_v2();
        $bunit_name = '';
        foreach($bunit_data as $bunit)
        {
            $bunit_name .= '
                            <option value="'.$bunit['bcode'].'">'.$bunit['business_unit'].'</option>
                            ';
        }

        $data['bunit_name'] = $bunit_name;
        echo json_encode($data);
    }

	public function display_payment_list_ctrl()
    {
        $payment_list = $this->supervisor_model->get_payment_list_model($_SESSION['emp_id']);
        $html='
                <table class="table table-striped table-bordered table-hover display" id="payment_list_table" style="color: black; font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>MODE OF PAYMENT
                                        </th>
                                        <th>
                                            <center>TYPE
                                        </th>
                                        <th>
                                            <center>B.U / DEPT.
                                        </th>
                                        <th>
                                            <center>ACTION
                                        </th>
                                    </tr>
                                </thead>
                                <form name="payment_list_viewing_form" id="payment_list_viewing_form">
                                    <tbody id="payment_list_viewing_tbody">
                ';

        foreach($payment_list as $list)
        {   
            
            $bunitname_data = $this->supervisor_model->get_bunitname_model($list['bunit_code']);

            $bunit_name = '';
            foreach($bunitname_data as $bname)
            {
                $bunit_name = $bname['business_unit'];
            }


            $deptname_data = $this->supervisor_model->get_deptname_model($list['dept_code']);

            $dept_name = '';
            foreach($deptname_data as $dname)
            {
                $dept_name = $dname['dept_name'];
            }

            $html.=' 
                    <tr>
                      <td style="vertical-align: middle;">'.$list['mop'].'</td>
                      <td style="vertical-align: middle;">'.$list['type'].'</td>
                      <td style="vertical-align: middle;">'.$bunit_name.'<br>'.$dept_name.'</td>
                      <td style="vertical-align: middle; font-size: large;">
                        <a id="" onclick="delete_mop_js('.$list['id'].','."'".$list['type']."'".','."'".$list['mop']."'".','."'".$list['dept_code']."'".','."'".$bunit_name."'".','."'".$dept_name."'".')">❌</a>
                      </td>
                    </tr>
                  ';
        } 
     
        $html.='
                        </tbody>
                    </form>
                </table>

                ';
        

        $data['html']=$html;                      
        echo json_encode($data);
    }


}
