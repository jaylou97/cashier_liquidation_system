<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accounting_controller extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model("main_model");
        $this->load->model("cashier_model");
		$this->load->model("liquidation_model");
		$this->load->model("cfscashier_model");
		$this->load->model("treasury_model");
		$this->load->model("accounting_model");
		$this->load->helper('text');
        $this->load->library('ppdf');
	}

    public function accounting_dashboard_ctrl()
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
         
            $this->load->view('accounting_side/dashboard', $data);
        }
    }

    public function unadjusted_navcls_ctrl()
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
         
            $this->load->view('accounting_side/view_variance_loader');
            $this->load->view('accounting_side/unadjusted_nav_vs_cls_v2', $data);
            $this->load->view('accounting_side/loader');
            $this->load->view('accounting_side/adjustment_modal');
            $this->load->view('accounting_side/attached_file_modal');
        }
    }

    public function adjusted_navcls_ctrl()
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
         
            $this->load->view('accounting_side/view_variance_loader');
            $this->load->view('accounting_side/adjusted_nav_vs_cls', $data);
            $this->load->view('accounting_side/loader2');
            $this->load->view('accounting_side/adjustment_modal2');
        }
    }

    public function adjustment_history_ctrl()
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
         
            $this->load->view('accounting_side/adjustment_history', $data);
        }
    }

    public function view_navcls_variance_ctrl()
    {
        if(empty($_SESSION['emp_id']))
		{
			$message = "EXPIRED SESSION";
			echo json_encode($message);
		}
		else
		{
            $html='
                    <form>
                        <table class="table table-bordered table-hover table-condensed display" id="navcls_variance_table">
                            <thead>
                                <tr>                                                            
                                    <th style="vertical-align: middle;" rowspan="2">
                                        <center>CASHIER\'S NAME</center>
                                    </th>
                                    <th style="vertical-align: middle;" rowspan="2">
                                        <center>SALES DATE</center>
                                    </th>
                                    <th colspan="3" scope="colgroup">
                                        <center>CASH</center>
                                    </th>        
                                    <th colspan="3" scope="colgroup">
                                        <center>NON CASH</center>
                                    </th>  
                                    <th colspan="3" scope="colgroup">
                                        <center>GRAND TOTAL</center>
                                    </th>                   
                                </tr>
                                <tr style="border-top: outset;">
                                    <th scope="col"><center>NAVISION</center></th>
                                    <th scope="col"><center>CLS</center></th>
                                    <th scope="col"><center>VARIANCE</center></th>
                                    <th scope="col"><center>NAVISION</center></th>
                                    <th scope="col"><center>CLS</center></th>
                                    <th scope="col"><center>VARIANCE</center></th>
                                    <th scope="col"><center>NAVISION</center></th>
                                    <th scope="col"><center>CLS</center></th>
                                    <th scope="col"><center>VARIANCE</center></th>
                                </tr>
                            </thead>
                    ';

                $html.=' 
                        <tr style="word-wrap:break-word;">
                            <td style="vertical-align: middle;"></td>
                            <td></td>
                            <td style="vertical-align: middle;"></td>
                            <td style="vertical-align: middle;"></td>
                            <td style="vertical-align: middle;"></td>
                            <td style="vertical-align: middle;"></td>
                            <td style="vertical-align: middle;"></td>
                            <td style="vertical-align: middle;"></td>
                            <td style="vertical-align: middle;"></td>
                            <td style="vertical-align: middle;"></td>
                            <td style="vertical-align: middle;"></td>
                        </tr>
                        '; 
    
            
            $html.='                      
                            </table>
                        </form> 
                        ';

            $data['html']=$html;         
            echo json_encode($data);
        }
    }



    public function get_hml_file_ctrl()
	{
        if(empty($_SESSION['emp_id']))
		{
			$message = "EXPIRED SESSION";
			echo json_encode($message);
		}
		else
		{
            $html='
                <form>
                    <table class="table table-bordered table-hover table-condensed display" id="navcls_variance_table">
                        <thead>
                            <tr>                                                            
                                <th style="vertical-align: middle;" rowspan="2">
                                    <center>CASHIER\'S NAME</center>
                                </th>
                                <th style="vertical-align: middle;" colspan="12" scope="colgroup">
                                    <center>NAVISION VS CASHIER\'S LIQUIDATION SYSTEM</center>
                                </th>                    
                            </tr>
                            <tr style="border-top: outset;">
                                <th style="vertical-align: middle;" scope="col"><center>CASH</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>BANK CARD</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>GIFT CHECKS</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>TENDER REMOVE<br>/ FLOAT</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>CRM Redeem</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>A.T.P</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>EMP CHARGE<br>/ CREDIT</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>PO<br>(Credit)</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>IHCC<br>(Credit)</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>OTHER PAYMENTS</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>TOTAL</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>VARIANCE</center></th>
                            </tr>
                        </thead>
                    ';

            // $employees = ''; 
            for($i=0; $i<count($_FILES['files']['name']); $i++)
            {
                $pop_up = "";
                unset($RESS2);/*clear ang sulod sa array para inig loop sa sunod textfile dili mu sumpay ang sulod*/
                if(!empty($_FILES['files']['tmp_name'])):
                    
                    $fileName = $_FILES['files']['tmp_name'][$i];
            
                    $file = fopen($fileName,"r") or exit("Unable to open file!");
                
                    while(!feof($file)) {
                        @$RESS2 .= fgets($file). "";
                    }
                endif;

                $kuhag_double_qoute=preg_replace('/Helvetica/', "^", $RESS2);
                $kuhag_double_qoute=preg_replace('/<BR>/', "", $kuhag_double_qoute);
                $kuhag_double_qoute=preg_replace('/">/', "", $kuhag_double_qoute);
                $kuhag_double_qoute=preg_replace('</FONT>', "", $kuhag_double_qoute);
                $kuhag_double_qoute=preg_replace('/<>/', "^", $kuhag_double_qoute);

                $result_array = preg_split('/["^^<]/', $kuhag_double_qoute);
                $strdate = strtotime($result_array[70]);
                $newformat_date = date('Y-m-d',$strdate);
                // =================================================================================================================
                $kuhag_double_qoute_arr = explode("^",$kuhag_double_qoute);
                $nav_cashtotal = '';
                $cls_finalcash_total = '';
                $nav_bankcard_total = '';
                $cls_bankcard_total = '';
                $nav_giftcheck_total = '';
                $cls_giftcheck_total = '';
                $nav_partialcash_total = '';
                $cls_partialcash_total = '';
                $nav_crmredeem_total = '';
                $cls_crmredeem_total = '';
                $nav_atp_total = '';
                $cls_atp_total = '';
                $nav_empcredit_total = '';
                $cls_empcredit_total = '';
                $nav_po_total = '';
                $cls_po_total = '';
                $nav_ihcc_total = '';
                $cls_ihcc_total = '';
                $nav_otherpayment_total = '';
                $cls_otherpayment_total = '';
                $nav_overall_total = '';
                $cls_overall_total = '';
                for($a=0;$a<count($kuhag_double_qoute_arr);$a++)
                {
                    if(is_numeric($kuhag_double_qoute_arr[$a]))
                    { 
                        $result = $this->accounting_model->get_emp($kuhag_double_qoute_arr[$a]);     
                        $answer =substr($kuhag_double_qoute_arr[$a],1) ;
                        if(empty($result))
                        {
                            $result = $this->accounting_model->get_emp($answer);         
                        }
                        
                        $cashier_name = '';
                        $cashier_id = '';
                        $nav_cash = '';
                        $nav_noncash = '';
                        $nav_gtotal = '';
                        $cls_gtotal = '';
                        $tr_no = '';
                        $cls_finalcash = '';
                        $cls_bankcard = '';
                        $nav_bankcard_compress = '';
                        $cls_bankcard_compress = '';
                        $bankcard_variance = '';
                        $bankcard_txt = '';
                        $br = '';
                        $variance_txt = '';
                        $nav_giftcheck = '';
                        $cls_giftcheck = '';
                        $nav_partialcash = '';
                        $cls_partialcash = '';
                        $nav_crmredeem = '';
                        $cls_crmredeem = '';
                        $nav_atp = '';
                        $cls_atp = '';
                        $nav_empcredit = '';
                        $cls_empcredit = '';
                        $nav_po = '';
                        $cls_po = '';
                        $nav_ihcc = '';
                        $cls_ihcc = '';
                        $nav_otherpayment = '';
                        $cls_otherpayment = '';
                        $exclude = '';
                        $bankcard_variance_color = 'style="vertical-align: middle; color: limegreen;"';
                        $variance_color = 'style="vertical-align: middle; color: limegreen;"';
                        if(!empty($result))
                        {
                            // $employees .= $answer."--".$result[0]['name']."----".$kuhag_double_qoute_arr[$a+6]."--".$kuhag_double_qoute_arr[$a+9]."--".$kuhag_double_qoute_arr[$a+12]."--".$kuhag_double_qoute_arr[$a+15]."--".$kuhag_double_qoute_arr[$a+18]."--".$kuhag_double_qoute_arr[$a+21]."--".$kuhag_double_qoute_arr[$a+24]."--".$kuhag_double_qoute_arr[$a+27]."--".$kuhag_double_qoute_arr[$a+30]."--".$kuhag_double_qoute_arr[$a+32]."--".$kuhag_double_qoute_arr[$a+35]."--".$kuhag_double_qoute_arr[$a+38]."--".$kuhag_double_qoute_arr[$a+41]."<br>";
                            $cashier_name = $result[0]['name'];
                            $cashier_id = $result[0]['emp_id'];
                            $cebo_cs_denomination = $this->accounting_model->get_cebo_cs_data_model($cashier_id,$newformat_date);
                            if(!empty($cebo_cs_denomination))
                            {
                                $cls_gtotal = $cebo_cs_denomination->total_denomination;
                                $cls_gtotal = number_format($cls_gtotal, 2);
                                $cls_overall_total += $cebo_cs_denomination->total_denomination;
                                $tr_no = $cebo_cs_denomination->tr_no;
                            }
                            // =================================================================================================
                            if($tr_no != '')
                            {
                                $cashnoncashden = $this->accounting_model->get_cs_cashier_cashnoncashden_model($tr_no,$cashier_id);
                                $exclude2 = array();
                                $bankcard_exclude = array();
                                $giftcheck_exclude = array();
                                $crmredeem_exclude = array();
                                $atp_exclude = array();
                                $empcredit_exclude = array();
                                $po_exclude = array();
                                $ihcc_exclude = array();
                                foreach($cashnoncashden as $den)
                                {
                                    if($den['mop_name'] == 'COMMERCIAL CARDS')
                                    { 
                                        $cls_bankcard = number_format($den['noncash_amount'], 2);
                                        $cls_bankcard_compress = $den['noncash_amount'];
                                        if(!in_array($den['tr_no'],$bankcard_exclude))
                                        { 
                                            $cls_bankcard_total += $den['noncash_amount'];
                                            array_push($bankcard_exclude,$den['tr_no']);
                                        }
                                    }
                                    if($den['mop_name'] == 'CORPORATE GIFT CHECK')
                                    { 
                                        $cls_giftcheck = number_format($den['noncash_amount'], 2);
                                        if(!in_array($den['tr_no'],$giftcheck_exclude))
                                        { 
                                            $cls_giftcheck_total += $den['noncash_amount'];
                                            array_push($giftcheck_exclude,$den['tr_no']);
                                        }
                                    }
                                    if($den['mop_name'] == 'CRM REDEEM')
                                    { 
                                        $cls_crmredeem = number_format($den['noncash_amount'], 2);
                                        if(!in_array($den['tr_no'],$crmredeem_exclude))
                                        { 
                                            $cls_crmredeem_total += $den['noncash_amount'];
                                            array_push($crmredeem_exclude,$den['tr_no']);
                                        }
                                    }
                                    if($den['mop_name'] == 'CHECK EXCHANGE (ATP)')
                                    { 
                                        $cls_atp = number_format($den['noncash_amount'], 2);
                                        if(!in_array($den['tr_no'],$atp_exclude))
                                        { 
                                            $cls_atp_total += $den['noncash_amount'];
                                            array_push($atp_exclude,$den['tr_no']);
                                        }
                                    }
                                    if($den['mop_name'] == 'EMPLOYEES CREDIT')
                                    { 
                                        $cls_empcredit = number_format($den['noncash_amount'], 2);
                                        if(!in_array($den['tr_no'],$empcredit_exclude))
                                        { 
                                            $cls_empcredit_total += $den['noncash_amount'];
                                            array_push($empcredit_exclude,$den['tr_no']);
                                        }
                                    }
                                    if($den['mop_name'] == 'P.O')
                                    { 
                                        $cls_po = number_format($den['noncash_amount'], 2);
                                        if(!in_array($den['tr_no'],$po_exclude))
                                        { 
                                            $cls_po_total += $den['noncash_amount'];
                                            array_push($po_exclude,$den['tr_no']);
                                        }
                                    }
                                    if($den['mop_name'] == 'IHCC')
                                    { 
                                        $cls_ihcc = number_format($den['noncash_amount'], 2);
                                        if(!in_array($den['tr_no'],$ihcc_exclude))
                                        { 
                                            $cls_ihcc_total += $den['noncash_amount'];
                                            array_push($ihcc_exclude,$den['tr_no']);
                                        }
                                    }

                                    
                                    $exclude = array('COMMERCIAL CARDS','CORPORATE GIFT CHECK','CRM REDEEM','CHECK EXCHANGE (ATP)','EMPLOYEES CREDIT','P.O','IHCC');
                                    if(!in_array($den['mop_name'],$exclude))
                                    { 
                                        if(!in_array($den['mop_name'],$exclude2))
                                        { 
                                            $cls_otherpayment .= '&nbsp;('.$den['mop_name'].' - '.number_format($den['noncash_amount'], 2).')&nbsp;'.'<br>';
                                            $cls_otherpayment_total += $den['noncash_amount'];
                                            array_push($exclude2,$den['mop_name']);
                                        }
                                    }
                                }
                                
                                $partial_cash = $this->accounting_model->get_partial_cash_model($tr_no,$cashier_id);
                                if(!empty($partial_cash))
                                {
                                    $cls_partialcash = $partial_cash->total_pcash;
                                    $cls_partialcash = number_format($cls_partialcash, 2);
                                    // ========================================================================================
                                    $cls_partialcash_total += $partial_cash->total_pcash;
                                }

                                $final_cash = $this->accounting_model->get_final_cash_model($tr_no,$cashier_id);
                                if(!empty($final_cash))
                                {
                                    $cls_finalcash = $final_cash->total_cash;
                                    $cls_finalcash = number_format($cls_finalcash, 2);
                                    // =========================================================================================
                                    $cls_finalcash_total += $final_cash->total_cash;
                                }
                            }
                            // =================================================================================================
                            $nav_cash = $kuhag_double_qoute_arr[$a+6];
                            $nav_bankcard = $kuhag_double_qoute_arr[$a+12];
                            $nav_giftcheck = $kuhag_double_qoute_arr[$a+18];
                            $nav_partialcash = $kuhag_double_qoute_arr[$a+21];
                            $nav_crmredeem = $kuhag_double_qoute_arr[$a+24];
                            $nav_atp = $kuhag_double_qoute_arr[$a+27];
                            $nav_empcredit = $kuhag_double_qoute_arr[$a+30];
                            $nav_po = $kuhag_double_qoute_arr[$a+32];
                            $nav_ihcc = $kuhag_double_qoute_arr[$a+35];
                            $nav_otherpayment = $kuhag_double_qoute_arr[$a+38];
                            $nav_gtotal = $kuhag_double_qoute_arr[$a+41];
                            // =================================================================================================
                            $navcash_explode = explode(",",$nav_cash);
                            $navcash_implode = implode("",$navcash_explode);
                            $nav_cashtotal += $navcash_implode;
                            // =================================================================================================
                            $nav_bankcard_explode = explode(",",$nav_bankcard);
                            $nav_bankcard_implode = implode("",$nav_bankcard_explode);
                            $nav_bankcard_total += $nav_bankcard_implode;
                            // =================================================================================================
                            $nav_giftcheck_total_explode = explode(",",$nav_giftcheck);
                            $nav_giftcheck_total_implode = implode("",$nav_giftcheck_total_explode);
                            $nav_giftcheck_total += $nav_giftcheck_total_implode;
                            // =================================================================================================
                            $nav_partialcash_total_explode = explode(",",$nav_partialcash);
                            $nav_partialcash_total_implode = implode("",$nav_partialcash_total_explode);
                            $nav_partialcash_total += $nav_partialcash_total_implode;
                            // =================================================================================================
                            $nav_crmredeem_total_explode = explode(",",$nav_crmredeem);
                            $nav_crmredeem_total_implode = implode("",$nav_crmredeem_total_explode);
                            $nav_crmredeem_total += $nav_crmredeem_total_implode;
                            // =================================================================================================
                            $nav_atp_total_explode = explode(",",$nav_atp);
                            $nav_atp_total_implode = implode("",$nav_atp_total_explode);
                            $nav_atp_total += $nav_atp_total_implode;
                            // =================================================================================================
                            $nav_empcredit_total_explode = explode(",",$nav_empcredit);
                            $nav_empcredit_total_implode = implode("",$nav_empcredit_total_explode);
                            $nav_empcredit_total += $nav_empcredit_total_implode;
                            // =================================================================================================
                            $nav_po_total_explode = explode(",",$nav_po);
                            $nav_po_total_implode = implode("",$nav_po_total_explode);
                            $nav_po_total += $nav_po_total_implode;
                            // =================================================================================================
                            $nav_ihcc_total_explode = explode(",",$nav_ihcc);
                            $nav_ihcc_total_implode = implode("",$nav_ihcc_total_explode);
                            $nav_ihcc_total += $nav_ihcc_total_implode;
                            // =================================================================================================
                            $nav_otherpayment_total_explode = explode(",",$nav_otherpayment);
                            $nav_otherpayment_total_implode = implode("",$nav_otherpayment_total_explode);
                            $nav_otherpayment_total += $nav_otherpayment_total_implode;
                            // =================================================================================================
                            $nav_overall_total_explode = explode(",",$nav_gtotal);
                            $nav_overall_total_implode = implode("",$nav_overall_total_explode);
                            $nav_overall_total += $nav_overall_total_implode;
                            // =================================================================================================
                            $nav_bankcard_compress = explode(",",$nav_bankcard);
                            $nav_bankcard_compress = implode("",$nav_bankcard_compress);
                            if($cls_bankcard_compress != '')
                            {
                                $bankcard_variance = $cls_bankcard_compress - $nav_bankcard_compress;
                            }
                            if($bankcard_variance != '')
                            {
                                if($bankcard_variance < 0)
                                {
                                    $bankcard_variance = explode("-",$bankcard_variance);
                                    $bankcard_variance = implode("",$bankcard_variance);
                                    $bankcard_variance = number_format($bankcard_variance, 2);
                                    $bankcard_txt = 'SHORT';
                                    $bankcard_variance_color = 'style="vertical-align: middle; color: red;"';
                                    $br = '<br>';
                                }
                                else if($bankcard_variance > 0)
                                {
                                    $bankcard_variance = number_format($bankcard_variance, 2);
                                    $bankcard_txt = 'OVER';
                                    $br = '<br>';
                                }
                            }
                            // =================================================================================================
                            $navgtotal_explode = explode(",",$nav_gtotal);
                            $navgtotal_implode = implode("",$navgtotal_explode);
                            // =================================================================================================
                            $nav_noncash = $navgtotal_implode - $navcash_implode;
                            $gtotal_variance = $cls_gtotal - $navgtotal_implode;
                            $gtotal_variance = number_format($gtotal_variance, 2);
                            if($gtotal_variance < 0)
                            {
                                $gtotal_variance = explode("-",$gtotal_variance);
                                $gtotal_variance = implode("",$gtotal_variance);
                                $variance_color = 'style="vertical-align: middle; color: red;"';
                                $variance_txt = 'SHORT';
                            }
                            else if($gtotal_variance > 0)
                            {
                                $variance_txt = 'OVER';
                            }
                            else if($gtotal_variance == 0)
                            {
                                $variance_txt = 'PERFECT';
                            }
                            $html.=' 
                                    <tr style="word-wrap:break-word;">
                                        <td style="vertical-align: middle;">'.$cashier_name.'</td>
                                        <td style="vertical-align: middle;">
                                            '.$nav_cash.'
                                            '.$cls_finalcash.'
                                        </td>
                                        <td style="vertical-align: middle;">
                                            '.$nav_bankcard.'<br>
                                            '.$cls_bankcard.'<br>
                                            <lable '.$bankcard_variance_color.'>
                                            '.$bankcard_txt.'
                                            '.$br.'
                                            '.$bankcard_variance.'
                                            </lable>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            '.$nav_giftcheck.'<br>
                                            '.$cls_giftcheck.'
                                        </td>
                                        <td style="vertical-align: middle;">
                                            '.$nav_partialcash.'<br>
                                            '.$cls_partialcash.'
                                        </td>
                                        <td style="vertical-align: middle;">
                                            '.$nav_crmredeem.'<br>
                                            '.$cls_crmredeem.'
                                        </td>
                                        <td style="vertical-align: middle;">
                                            '.$nav_atp.'<br>
                                            '.$cls_atp.'
                                        </td>
                                        <td style="vertical-align: middle;">
                                            '.$nav_empcredit.'<br>
                                            '.$cls_empcredit.'
                                        </td>
                                        <td style="vertical-align: middle;">
                                            '.$nav_po.'<br>
                                            '.$cls_po.'
                                        </td>
                                        <td style="vertical-align: middle;">
                                            '.$nav_ihcc.'<br>
                                            '.$cls_ihcc.'
                                        </td>
                                        <td style="vertical-align: middle;">
                                            '.$nav_otherpayment.'<br>
                                            '.$cls_otherpayment.'
                                        </td>
                                        <td style="vertical-align: middle;">
                                            '.$nav_gtotal.'<br>
                                            '.$cls_gtotal.'
                                        </td>
                                        <td style="vertical-align: middle;">
                                            '.$variance_txt.'<br>
                                            <label '.$variance_color.'>'.$gtotal_variance.'</label>
                                        </td>
                                    </tr>
                                    '; 
                        }
                    }
                }
            }

            $nav_cashtotal = number_format($nav_cashtotal);
            $cls_finalcash_total = number_format($cls_finalcash_total, 2);
            $nav_bankcard_total = number_format($nav_bankcard_total, 2);
            $cls_bankcard_total = number_format($cls_bankcard_total, 2);
            $nav_giftcheck_total = number_format($nav_giftcheck_total, 2);
            $cls_giftcheck_total = number_format($cls_giftcheck_total, 2);
            $nav_partialcash_total = number_format($nav_partialcash_total, 2);
            $cls_partialcash_total = number_format($cls_partialcash_total, 2);
            $nav_crmredeem_total = number_format($nav_crmredeem_total, 2);
            $cls_crmredeem_total = number_format($cls_crmredeem_total, 2);
            $nav_atp_total = number_format($nav_atp_total, 2);
            $cls_atp_total = number_format($cls_atp_total, 2);
            $nav_empcredit_total = number_format($nav_empcredit_total, 2);
            $cls_empcredit_total = number_format($cls_empcredit_total, 2);
            $nav_po_total = number_format($nav_po_total, 2);
            $cls_po_total = number_format($cls_po_total, 2);
            $nav_ihcc_total = number_format($nav_ihcc_total, 2);
            $cls_ihcc_total = number_format($cls_ihcc_total, 2);
            $nav_otherpayment_total = number_format($nav_otherpayment_total, 2);
            $cls_otherpayment_total = number_format($cls_otherpayment_total, 2);
            $nav_overall_total = number_format($nav_overall_total, 2);
            $cls_overall_total = number_format($cls_overall_total, 2);
            $html.=' 
                            <tfoot>
                                <tr style="word-wrap:break-word;">
                                    <td style="vertical-align: middle;">
                                        TOTAL
                                    </td>
                                    <td style="vertical-align: middle;">
                                        '.$nav_cashtotal.'<br>
                                        '.$cls_finalcash_total.'
                                    </td>
                                    <td style="vertical-align: middle;">
                                        '.$nav_bankcard_total.'<br>
                                        '.$cls_bankcard_total.'
                                    </td>
                                    <td style="vertical-align: middle;">
                                        '.$nav_giftcheck_total.'<br>
                                        '.$cls_giftcheck_total.'
                                    </td>
                                    <td style="vertical-align: middle;">
                                        '.$nav_partialcash_total.'<br>
                                        '.$cls_partialcash_total.'
                                    </td>
                                    <td style="vertical-align: middle;">
                                        '.$nav_crmredeem_total.'<br>
                                        '.$cls_crmredeem_total.'
                                    </td>
                                    <td style="vertical-align: middle;">
                                        '.$nav_atp_total.'<br>
                                        '.$cls_atp_total.'<br>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        '.$nav_empcredit_total.'<br>
                                        '.$cls_empcredit_total.'
                                    </td>
                                    <td style="vertical-align: middle;">
                                        '.$nav_po_total.'<br>
                                        '.$cls_po_total.'
                                    </td>
                                    <td style="vertical-align: middle;">
                                        '.$nav_ihcc_total.'<br>
                                        '.$cls_ihcc_total.'
                                    </td>
                                    <td style="vertical-align: middle;">
                                        '.$nav_otherpayment_total.'<br>
                                        '.$cls_otherpayment_total.'
                                    </td>
                                    <td style="vertical-align: middle;">
                                        '.$nav_overall_total.'<br>
                                        '.$cls_overall_total.'
                                    </td>
                                    <td style="vertical-align: middle;">
                                    
                                    </td>
                                </tr>    
                            </tfoot>             
                        </table>
                    </form> 
                    ';

            $title = '
                        <form>
                            <center>
                                <label>NAVISION VS CASHIER\'S LIQUIDATION SYSTEM</label><br>
                                <label>'.$kuhag_double_qoute_arr[4].'</label><br>
                                <label>'.$kuhag_double_qoute_arr[6].'</label><br>
                                <label>'.$kuhag_double_qoute_arr[8].'</label>
                            </center>
                        </form>
                    ';
            // var_dump($nav_bankcard_total);s
            $data['navcls_title']=$title;              
            $data['bu_dept']=$result_array[56];              
            $data['sales_date']=$result_array[70];              
            $data['html']=$html;              
            echo json_encode($data);
        }
    }

    public function upload_file_ctrl()
    {
        if(empty($_SESSION['emp_id']))
		{
			$message = "EXPIRED SESSION";
			echo json_encode($message);
		}
		else
		{   
            $file_counter = '';
            for($i=0; $i<count($_FILES['files']['name']); $i++)
            {
                if (count($_FILES['files']['name']) == 1) // validate file selected limit only 1 file selected because uploading it takes a lot of time.
                {
                    $pop_up = "";
                    unset($RESS2);/*clear ang sulod sa array para inig loop sa sunod textfile dili mu sumpay ang sulod*/ 
                    if(!empty($_FILES['files']['tmp_name'])):
                        
                        $fileName = $_FILES['files']['tmp_name'][$i];
                
                        $file = fopen($fileName,"r") or exit("Unable to open file!");
                    
                        while(!feof($file)) {
                            @$RESS2 .= fgets($file). "";
                        }
                    endif;

                    $ress_sanitize = explode(PHP_EOL, $RESS2);
                    $RESS2=preg_replace('/","/', "^", $RESS2);
                    $RESS2=preg_replace('/"/', "@", $RESS2);
                    $RESS2 = explode('@',$RESS2);
                    $RESS2 =  array_map('trim', $RESS2);
                    // $RESS2 = array_filter($RESS2, 'strlen'); // remove empty array elements

                    $validation_explode = '';
                    $validation_originalDate = '';
                    $validation_year = '';
                    $validation_newDate = '';
                    $validation_textfile = '';
                    for($b=0; $b<count($RESS2); $b++)
                    {
                        if(!empty($RESS2[$b]))
                        {
                            $validation_explode = explode('^',$RESS2[$b]);
                            if (count($validation_explode) == 11)
                            {
                                if(is_numeric($validation_explode[6]))
                                {
                                    $validation_textfile = 'INVALID TEXT FILE';
                                    break;
                                }
                                else if(!strtotime($validation_explode[6])){
                                    $validation_textfile = 'INVALID TEXT FILE';
                                    break;
                                }
                                else
                                {
                                    $validation_originalDate = explode('/', $validation_explode[6]);
                                    $validation_year = DateTime::createFromFormat('y', $validation_originalDate[2]); // convert 2 digit year to 4 digit year
                                    $validation_year = $validation_year->format('Y'); 
                                    $validation_newDate = $validation_year.'-'.$validation_originalDate[0].'-'.$validation_originalDate[1]; // format date Y-m-d 
                                    $val_staff_id = $validation_explode[8] * 1;
                                    $validate_duplicate_textfile = $this->accounting_model->get_duplicate_textfile_model($val_staff_id,$validation_newDate,$validation_explode[9],$validation_explode[10]);
                                    if(empty($validate_duplicate_textfile))
                                    {
                                        $validation_textfile = 'EMPTY';
                                        break;
                                    }
                                    else
                                    {   
                                        $validation_textfile = 'DUPLICATE TEXT FILE';
                                        break;
                                    }
                                }
                            }
                            else
                            {   
                                $validation_textfile = 'INVALID TEXT FILE';
                                break;
                            }
                        }
                    }
                    
                    if($validation_textfile == 'EMPTY')
                    {
                        $row_explode = '';
                        $originalDate = '';
                        $amount_tendered = '';
                        $bu_name = '';
                        $dept_name = '';
                        $bu_code = '';
                        $dept_code = '';
                        $year = '';
                        $newDate = '';
                        for($a=0; $a<count($RESS2); $a++)
                        {
                            if(!empty($RESS2[$a]))
                            {
                                $row_explode = explode('^',$RESS2[$a]);
                                $originalDate = explode('/', $row_explode[6]);
                                $amount_tendered = explode(',', $row_explode[4]);
                                $amount_tendered = implode('', $amount_tendered);
                                // =========================================================================================================================
                                $bu_name = explode('-', $row_explode[9]);
                                if($bu_name[0] == 'ICM')
                                {
                                    $bu_name = 'ISLAND CITY MALL';
                                }
                                else if($bu_name[0] == 'ASC')
                                {
                                    $bu_name = 'ASC: MAIN';
                                }
                                else if($bu_name[0] == 'PM')
                                {
                                    $bu_name = 'PLAZA MARCELA';
                                }
                                $bu_data = $this->accounting_model->get_bcode_model($bu_name);
                                if(!empty($bu_data))
                                {
                                    $bu_code = $bu_data->bcode;
                                }
                                // =========================================================================================================================
                                $dept_name = explode('-', $row_explode[10]);
                                if($dept_name[0] == 'SM' || $dept_name[0] == 'CM')
                                {
                                    $dept_name = 'SUPERMARKET';
                                }
                                $dept_data = $this->accounting_model->get_dcode_model($bu_code,$dept_name);
                                if(!empty($dept_data))
                                {
                                    $dept_code = $dept_data->dcode;
                                }
                                // =========================================================================================================================
                                $year = DateTime::createFromFormat('y', $originalDate[2]); // convert 2 digit year to 4 digit year
                                $year = $year->format('Y'); 
                                $newDate = $year.'-'.$originalDate[0].'-'.$originalDate[1]; // format date Y-m-d 
                                
                                $tender_type = $row_explode[3];
                                if(!is_numeric($tender_type))
                                {
                                    $tender_type_data = $this->accounting_model->get_wholesale_tender_type_model($bu_code,$tender_type);
                                    if(!empty($tender_type_data))
                                    {
                                        $tender_type = $tender_type_data->mop_code;
                                    }
                                    else
                                    {
                                        $tender_type = '500';
                                    }
                                }

                                $staff_id = $row_explode[8] * 1;
                                $this->accounting_model->upload_file_model($row_explode[0],$row_explode[1],$row_explode[2],$tender_type,$amount_tendered,$row_explode[5],$newDate,$row_explode[7],$staff_id,$row_explode[9],$row_explode[10],$bu_code,$dept_code);
                            }
                        }
                                
                        $message = "success";
                        echo json_encode($message);
                    }
                    else if($validation_textfile == 'DUPLICATE TEXT FILE')
                    {
                        $message = "DUPLICATE TEXT FILE";
                        echo json_encode($message);
                    }
                    else
                    {
                        $message = "INVALID TEXT FILE";
                        echo json_encode($message);
                    }
                }
                else
                {
                    $file_counter = "MULTIPLE FILE";
                }
            }

            if($file_counter == "MULTIPLE FILE")
            {
                $message = "MULTIPLE FILE";
                echo json_encode($message);
            }
        }
    }

    public function display_sales_date_uploaded_ctrl()
    {
        $sales_date = $this->accounting_model->get_sales_date_model($_SESSION['emp_id']);

        $sales_date_html = '';
        $bname = '';
        $bname2 = '';
        $dname = '';
        $dname2 = '';
        $bcode = '';
        $dcode = '';
        foreach($sales_date as $sales)
        {
            $bcode = $sales['bcode'];
            $bu_data = $this->accounting_model->get_bname_model($bcode);
            if(!empty($bu_data))
            {
                $bname = $bu_data->acroname;
                $bname2 = $bu_data->business_unit;
            }
            // =================================================================================================================
            $dcode = $sales['dcode'];
            $dept_data = $this->accounting_model->get_dname_model($dcode);
            if(!empty($dept_data))
            {
                $dname = $dept_data->dept_name;
                $dname2 = $dept_data->dept_name;
                if($dname == 'SUPERMARKET')
                {
                    $dname = 'SM';
                }
            }
            // =================================================================================================================

            $sales_date_html.='
                                <option id="" style="text-align: center;" value="'.$sales['sales_date'].','.$sales['store_no'].','.$bname2.','.$dname2.'">'.'('.$bname.'-'.$dname.')&nbsp;'.$sales['sales_date'].'</option>
                            ';
        }
        $data['sales_date_html'] = $sales_date_html;
        echo json_encode($data);
    }

    public function display_sales_date_uploaded_ctrl_v2()
    {
        $sales_date = $this->accounting_model->get_sales_date_model($_SESSION['emp_id']);
        $sales_date_html = '';
        $bcode = '';
        $dcode = '';
        foreach($sales_date as $sales)
        {
            $bcode = $sales['bcode'];
            $bname = '';
            $bname2 = '';
            $bu_data = $this->accounting_model->get_bname_model($bcode);
            if(!empty($bu_data))
            {
                $bname = $bu_data->acroname;
                $bname2 = $bu_data->business_unit;
            }
            // =================================================================================================================
            if($bname == 'Plaza Marcela')
            {
                $bname = 'PM';
            }
            // =================================================================================================================
            $dcode = $sales['dcode'];
            $dname = '';
            $dname2 = '';
            $dept_data = $this->accounting_model->get_dname_model($dcode);
            if(!empty($dept_data))
            {
                $dname = $dept_data->dept_name;
                $dname2 = $dept_data->dept_name;
                if($dname == 'SUPERMARKET')
                {
                    $dname = 'SM';
                }
            }
            // =================================================================================================================
            $get_store_no = $this->accounting_model->get_store_no_model($sales['sales_date'],$sales['dcode'],$sales['store_no']);
            $store_no_array = array($sales['store_no']);
            foreach($get_store_no as $store)
            {
                array_push($store_no_array, $store['store_no']);
            }
            $store_no_array = implode("|", $store_no_array);
            // =================================================================================================================
            $sales_date_html.='
                                <option id="" style="text-align: center;" value="'.$sales['sales_date'].','.$store_no_array.','.$dcode.','.$bname2.','.$dname2.'">'.'('.$bname.'-'.$dname.')&nbsp;'.$sales['sales_date'].'</option>
                            ';
        }
        $data['sales_date_html'] = $sales_date_html;
        echo json_encode($data);
    }

    public function display_sales_date_uploaded_ctrl2()
    {
        $sales_date = $this->accounting_model->get_sales_date_model2($_SESSION['emp_id']);
        $sales_date_html = '';
        $bcode = '';
        $dcode = '';
        foreach($sales_date as $sales)
        {
            $bcode = $sales['bcode'];
            $bname = '';
            $bname2 = '';
            $bu_data = $this->accounting_model->get_bname_model($bcode);
            if(!empty($bu_data))
            {
                $bname = $bu_data->acroname;
                $bname2 = $bu_data->business_unit;
            }
            // =================================================================================================================
            if($bname == 'Plaza Marcela')
            {
                $bname = 'PM';
            }
            // =================================================================================================================
            $dcode = $sales['dcode'];
            $dname = '';
            $dname2 = '';
            $dept_data = $this->accounting_model->get_dname_model($dcode);
            if(!empty($dept_data))
            {
                $dname = $dept_data->dept_name;
                $dname2 = $dept_data->dept_name;
                if($dname == 'SUPERMARKET')
                {
                    $dname = 'SM';
                }
            }
            // =================================================================================================================
            $get_store_no = $this->accounting_model->get_store_no_model($sales['sales_date'],$sales['dcode'],$sales['store_no']);
            $store_no_array = array($sales['store_no']);
            foreach($get_store_no as $store)
            {
                array_push($store_no_array, $store['store_no']);
            }
            $store_no_array = implode("|", $store_no_array);
            // =================================================================================================================
            $sales_date_html.='
                                <option id="" style="text-align: center;" value="'.$sales['sales_date'].','.$store_no_array.','.$dcode.','.$bname2.','.$dname2.'">'.'('.$bname.'-'.$dname.')&nbsp;'.$sales['sales_date'].'</option>
                            ';
        }
        $data['sales_date_html'] = $sales_date_html;
        echo json_encode($data);
    }

    public function view_variance_navcls_ctrl()
    {
        if(empty($_SESSION['emp_id']))
		{
			$message = "EXPIRED SESSION";
			echo json_encode($message);
		}
		else
        {
            $html='
                    <table class="table table-bordered table-hover table-condensed display" id="navcls_variance_table">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;" rowspan="2">
                                    <center>TERMINAL & COUNTER NO.</center>
                                </th>                                                            
                                <th style="vertical-align: middle;" rowspan="2">
                                    <center>CASHIER\'S NAME</center>
                                </th>
                                <th style="vertical-align: middle;" colspan="13" scope="colgroup">
                                    <center>NAVISION VS CASHIER\'S LIQUIDATION SYSTEM</center>
                                </th>                    
                            </tr>
                            <tr style="border-top: outset;">
                                <th style="vertical-align: middle;" scope="col"><center>CASH</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>BANK CARD</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>GIFT CHECKS</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>TENDER REMOVE<br>/ FLOAT</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>CRM Redeem</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>A.T.P</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>EMP CHARGE<br>/ CREDIT</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>PO<br>(Credit)</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>IHCC<br>(Credit)</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>OTHER PAYMENTS</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>TOTAL</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>VARIANCE</center></th>
                                <th class="action" style="vertical-align: middle;" scope="col"><center>ACTION</center></th>
                            </tr>
                        </thead>
                    ';
            $nav_data = $this->accounting_model->get_uploaded_navdata_model($_POST['sales_date'],$_POST['store_no']);
            $terminal_counter_no = '';
            $tr_no = '';
            $bcode = '';
            $dcode = '';
            $staff_name = '';
            $staff_emp_id = '';
            $staff_id = '';
            $net_amount = 0;
            $net_amount2 = 0;
            $overall_amount = 0;
            $nav_cash = 0;
            $nav_cash2 = 0;
            $nav_bankcard = 0;
            $nav_bankcard2 = 0;
            $nav_bankcard3 = 0;
            $nav_giftcheck = 0;
            $nav_giftcheck2 = 0;
            $nav_partialcash = 0;
            $nav_partialcash2 = 0;
            $nav_crmredeem = 0;
            $nav_crmredeem2 = 0;
            $nav_atp = 0;
            $nav_atp2 = 0;
            $nav_emp_chargeCredit = 0;
            $nav_emp_chargeCredit2 = 0;
            $nav_po = 0;
            $nav_po2 = 0;
            $nav_ihcc = 0;
            $nav_ihcc2 = 0;
            $nav_otherpayment = 0;
            $nav_otherpayment2 = 0;
            $nav_color = 'style="color: blue;"';
            // =================================================================================
            $cls_finalcash2 = 0;
            $cls_bankcard2 = 0;
            $cls_giftcheck2 = 0;
            $cls_partialcash2 = 0;
            $cls_crmredeem2 = 0;
            $cls_atp2 = 0;
            $cls_empcredit2 = 0;
            $cls_po2 = 0;
            $cls_ihcc2 = 0;
            $cls_otherpayment2 = 0;
            $cls_netAmount2 = 0;
            $cls_netAmount3 = 0;
            foreach($nav_data as $nav)
            {
                $staff_terminal_counter = $this->accounting_model->get_staff_terminal_counter_model($_POST['sales_date'],$nav['staff_id']);
                $store_no = '';
                $terminal_amount = '';
                $pos_terminal_no = array();
                foreach($staff_terminal_counter as $tcno)
                {
                    $store_no = $tcno['store_no'];
                    $terminal_counter_amount = $this->accounting_model->get_terminal_counter_amount_model($_POST['sales_date'],$nav['staff_id'],$tcno['pos_terminal_no']);
                    $terminal_amount = number_format($terminal_counter_amount, 2);
                    array_push($pos_terminal_no, $tcno['pos_terminal_no'].' | '.$terminal_amount.'<br>');
                }
                // ==============================================================================================================================================
                $staff_info = $this->accounting_model->get_staff_info_model($nav['staff_id']);
                if(empty($staff_info))
                {
                    $staff_id = $nav['staff_id'] * 1;
                    $staff_info2 = $this->accounting_model->get_staff_info_model($staff_id);
                    if(!empty($staff_info2))
                    {
                        $staff_name = $staff_info2->name;
                        $staff_emp_id = $staff_info2->emp_id;
                    }
                }
                else
                {
                    $staff_name = $staff_info->name;
                }
                // ==============================================================================================================================================
                $staff_net_amount = $this->accounting_model->get_staff_net_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($staff_net_amount))
                {
                    $net_amount2 = $staff_net_amount->amount;
                    $net_amount = $staff_net_amount->amount;
                    $net_amount = number_format($net_amount, 2);
                    $overall_amount += $staff_net_amount->amount;
                }
                // ==============================================================================================================================================
                $navcash_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],1);
                if(!empty($navcash_tender_type))
                {
                    $nav_cash2 += $navcash_tender_type->type_amount;
                    $nav_cash = $navcash_tender_type->type_amount;
                    $nav_cash = number_format($nav_cash, 2);
                }
                // ==============================================================================================================================================
                $nav_bankcard_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],3);
                if(!empty($nav_bankcard_tender_type))
                {
                    $nav_bankcard3 += $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard2 = $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard = $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard = number_format($nav_bankcard, 2);
                }
                // ==============================================================================================================================================
                $nav_giftcheck_tender_type = $this->accounting_model->get_giftcheck_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($nav_giftcheck_tender_type))
                {
                    $nav_giftcheck2 += $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck = $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck = number_format($nav_giftcheck, 2);
                }
                // ==============================================================================================================================================
                $nav_partialcash_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],9);
                if(!empty($nav_partialcash_tender_type))
                {
                    $nav_partialcash2 += $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash = $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash = number_format($nav_partialcash, 2);
                }
                // ==============================================================================================================================================
                $nav_crmredeem_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],28);
                if(!empty($nav_crmredeem_tender_type))
                {
                    $nav_crmredeem2 = $nav_crmredeem_tender_type->type_amount;
                    $nav_crmredeem = $nav_crmredeem_tender_type->type_amount;
                    $nav_crmredeem = number_format($nav_crmredeem, 2);
                }
                // ==============================================================================================================================================
                $nav_atp_tender_type = $this->accounting_model->get_atp_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($nav_atp_tender_type))
                {
                    $nav_atp2 += $nav_atp_tender_type->type_amount;
                    $nav_atp = $nav_atp_tender_type->type_amount;
                    $nav_atp = number_format($nav_atp, 2);
                }
                // ==============================================================================================================================================
                $nav_emp_chargeCredit_tender_type = $this->accounting_model->get_empChargeCredit_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($nav_emp_chargeCredit_tender_type))
                {
                    $nav_emp_chargeCredit2 += $nav_emp_chargeCredit_tender_type->type_amount;
                    $nav_emp_chargeCredit = $nav_emp_chargeCredit_tender_type->type_amount;
                    $nav_emp_chargeCredit = number_format($nav_emp_chargeCredit, 2);
                }
                // ==============================================================================================================================================
                $nav_po_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],14);
                if(!empty($nav_po_tender_type))
                {
                    $nav_po2 += $nav_po_tender_type->type_amount;
                    $nav_po = $nav_po_tender_type->type_amount;
                    $nav_po = number_format($nav_po, 2);
                }
                // ==============================================================================================================================================
                $nav_ihcc_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],15);
                if(!empty($nav_ihcc_tender_type))
                {
                    $nav_ihcc2 += $nav_ihcc_tender_type->type_amount;
                    $nav_ihcc = $nav_ihcc_tender_type->type_amount;
                    $nav_ihcc = number_format($nav_ihcc, 2);
                }
                // ==============================================================================================================================================
                $nav_otherpayment_tender_type = $this->accounting_model->get_otherpayment_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($nav_otherpayment_tender_type))
                {
                    $nav_otherpayment2 += $nav_otherpayment_tender_type->type_amount;
                    $nav_otherpayment = $nav_otherpayment_tender_type->type_amount;
                    $nav_otherpayment = number_format($nav_otherpayment, 2);
                }
                $nav_other_tender_type = $this->accounting_model->get_other_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                $paymentTypeAndAmount = '';
                $br = '';
                if(!empty($nav_other_tender_type))
                {
                    $nav_othertype_array = array();
                    $nav_othertype = '';
                    $store = '';
                    $tenderTypeName = '';
                    foreach($nav_other_tender_type as $othertype)
                    {
                        $store = explode('-', $_POST['store_no']);
                        if($store[0] == 'ICM')
                        {
                            $icm_tenderTypeName = $this->accounting_model->get_icm_tender_name_model($othertype['other_type']);
                            if(!empty($icm_tenderTypeName))
                            {
                                $tenderTypeName = $icm_tenderTypeName->icm_payment_name;
                            }
                        }
                        else if($store[0] == 'ASC')
                        {
                            $asc_tenderTypeName = $this->accounting_model->get_asc_tender_name_model($othertype['other_type']);
                            if(!empty($asc_tenderTypeName))
                            {
                                $tenderTypeName = $asc_tenderTypeName->asc_payment_name;
                            }
                        }
                        else if($store[0] == 'PM')
                        {
                            $pm_tenderTypeName = $this->accounting_model->get_pm_tender_name_model($othertype['other_type']);
                            if(!empty($pm_tenderTypeName))
                            {
                                $tenderTypeName = $pm_tenderTypeName->pm_payment_name;
                            }
                        }

                        $nav_othertype_data = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],$othertype['other_type']);
                        $nav_othertype = $nav_othertype_data->type_amount;
                        if($nav_othertype > 0)
                        {
                            $nav_othertype = $tenderTypeName.'|'.$nav_othertype;
                            array_push($nav_othertype_array, $nav_othertype);
                        }
                    }

                    if(!empty($nav_othertype_array))
                    {
                        $br = '<br>';
                        $paymentTypeAndAmount = implode('<br>', $nav_othertype_array);
                        $paymentTypeAndAmount = '('.$paymentTypeAndAmount.')';
                    }
                }
                // ===================================================================================================================================================
                $bu_data = $this->accounting_model->get_bcode_model($_POST['bname']);
                if(!empty($bu_data))
                {
                    $bcode = $bu_data->bcode;
                }
                $dept_data = $this->accounting_model->get_dcode_model($bcode,$_POST['dname']);
                if(!empty($dept_data))
                {
                    $dcode = $dept_data->dcode;
                }
                $cebo_cs_denomination_data = $this->accounting_model->get_cebo_cs_denomination_model($staff_emp_id,$_POST['sales_date'],$dcode);
                $cls_netAmount = '<br> 0.00';
                if(!empty($cebo_cs_denomination_data))
                {
                    $tr_no = $cebo_cs_denomination_data->tr_no;
                    $cls_netAmount3 += $cebo_cs_denomination_data->total_denomination;
                    $cls_netAmount2 = $cebo_cs_denomination_data->total_denomination;
                    $cls_netAmount = $cebo_cs_denomination_data->total_denomination;
                    $cls_netAmount = '<br>'.number_format($cls_netAmount, 2);
                } 
                // ===============================================================================================
                $cls_bankcard = '<br> 0.00';
                $bankcard_color = 'style="color: green;"';
                $cls_giftcheck = '<br> 0.00';
                $cls_crmredeem = '<br> 0.00';
                $cls_atp = '<br> 0.00';
                $cls_empcredit = '<br> 0.00';
                $cls_po = '<br> 0.00';
                $cls_ihcc = '<br> 0.00';
                $cls_finalcash = '<br> 0.00';
                $cls_partialcash = '<br> 0.00';
                $cls_otherpayment = '';
                $cls_otherpayment_total = 0;
                $bankcard_variance = '';
                $netAmount_variance = 0;
                $netAmount_variance_color = '';
                if($tr_no != '')
                {
                    $final_cash = $this->accounting_model->get_final_cash_model($tr_no,$staff_emp_id);
                    if(!empty($final_cash))
                    {
                        $cls_finalcash2 += $final_cash->total_cash;
                        $cls_finalcash = $final_cash->total_cash;
                        $cls_finalcash = '<br>'.number_format($cls_finalcash, 2);
                    }
                    $partial_cash = $this->accounting_model->get_partial_cash_model($tr_no,$staff_emp_id);
                    if(!empty($partial_cash))
                    {
                        $cls_partialcash2 += $partial_cash->total_pcash;
                        $cls_partialcash = $partial_cash->total_pcash;
                        $cls_partialcash = '<br>'.number_format($cls_partialcash, 2);
                    }
                    $cls_cashier_noncash_data = $this->accounting_model->get_cs_cashier_noncashden_model($tr_no,$staff_emp_id);
                    foreach($cls_cashier_noncash_data as $noncash)
                    {
                        if($noncash['mop_name'] == 'COMMERCIAL CARDS')
                        {
                            $cls_bankcard2 += $noncash['noncash_amount'];
                            $cls_bankcard = '<br>'.number_format($noncash['noncash_amount'], 2);
                            $bankcard_variance = $noncash['noncash_amount'] - $nav_bankcard2;
                            if($bankcard_variance < 0)
                            {
                                $bankcard_variance = explode("-",$bankcard_variance);
                                $bankcard_variance = implode("",$bankcard_variance);
                                $bankcard_color = 'style="color: red;"';
                            }
                            $bankcard_variance = '<br>'.'<label '.$bankcard_color.'>('.number_format($bankcard_variance, 2).')</label>';
                        }
                        if($noncash['mop_name'] == 'CORPORATE GIFT CHECK')
                        {
                            $cls_giftcheck2 += $noncash['noncash_amount'];
                            $cls_giftcheck = '<br>'.number_format($noncash['noncash_amount'], 2);
                        }
                        if($noncash['mop_name'] == 'CRM REDEEM')
                        {
                            $cls_crmredeem2 += $noncash['noncash_amount'];
                            $cls_crmredeem = '<br>'.number_format($noncash['noncash_amount'], 2);
                        }
                        $atp_array = array('CHECK EXCHANGE (ATP)','ATP');
                        if(in_array($noncash['mop_name'], $atp_array))
                        {
                            $cls_atp2 += $noncash['noncash_amount'];
                            $cls_atp = '<br>'.number_format($noncash['noncash_amount'], 2);
                        }
                        if($noncash['mop_name'] == 'EMPLOYEES CREDIT')
                        {
                            $cls_empcredit2 += $noncash['noncash_amount'];
                            $cls_empcredit = '<br>'.number_format($noncash['noncash_amount'], 2);
                        }
                        $po_array = array('P.O','PO','P.O CARD','PO CARD');
                        if(in_array($noncash['mop_name'], $po_array))
                        {
                            $cls_po2 += $noncash['noncash_amount'];
                            $cls_po = '<br>'.number_format($noncash['noncash_amount'], 2);
                        }
                        if($noncash['mop_name'] == 'IHCC')
                        {
                            $cls_ihcc2 += $noncash['noncash_amount'];
                            $cls_ihcc = '<br>'.number_format($noncash['noncash_amount'], 2);
                        }
                        $exclude = array('COMMERCIAL CARDS','CORPORATE GIFT CHECK','CRM REDEEM','CHECK EXCHANGE (ATP)','ATP','EMPLOYEES CREDIT','P.O','PO','P.O CARD','PO CARD','IHCC');
                        if(!in_array($noncash['mop_name'], $exclude))
                        { 
                            $cls_otherpayment2 += $noncash['noncash_amount'];  
                            $cls_otherpayment .= $noncash['mop_name'].'|'.number_format($noncash['noncash_amount'], 2).'<br>';
                            $cls_otherpayment_total += $noncash['noncash_amount'];  
                        }
                    }
                }
                // =============================================================================================================
                if($cls_bankcard == '<br> 0.00')
                {
                    $bankcard_color = 'style="color: red;"';
                    $bankcard_variance = '<br>'.'<label '.$bankcard_color.'>('.number_format($nav_bankcard2, 2).')</label>';
                }
                // ====================================================================================================================
                if($cls_otherpayment == '')
                {
                    $cls_otherpayment = '';
                    $cls_otherpayment_total = '<br> 0.00';
                }
                else
                {
                    $cls_otherpayment = substr_replace($cls_otherpayment ,"",-4);
                    $cls_otherpayment = '<br>('.$cls_otherpayment.')';
                    $cls_otherpayment_total = '<br>'.number_format($cls_otherpayment_total, 2);
                }
                // =============================================================================================================================
                if($cls_netAmount == '<br> 0.00')
                {
                    $netAmount_variance = 'NO CLS DATA';
                    $netAmount_variance_color = 'style="color: blue;"';
                }
                else
                {
                    $netAmount_variance = $cls_netAmount2 - $net_amount2;
                    if($netAmount_variance < 0)
                    {
                        $netAmount_variance = preg_replace('/-/', "", $netAmount_variance);
                        $netAmount_variance = 'SHORT<br>'.number_format($netAmount_variance, 2);
                        $netAmount_variance_color = 'style="color: red;"';
                    }
                    else if($netAmount_variance > 0)
                    {
                        $netAmount_variance = 'OVER<br>'.number_format($netAmount_variance, 2);
                        $netAmount_variance_color = 'style="color: green;"';
                    }
                    else
                    {
                        $netAmount_variance = 'PERFECT<br>'.number_format($netAmount_variance, 2);
                        $netAmount_variance_color = 'style="color: green;"';
                    }
                }
                // ==================================================================================================================================================
                $terminal_counter_no = implode('', $pos_terminal_no);
                $terminal_counter_no = substr_replace($terminal_counter_no ,"",-4);
                $terminal_counter_no = $store_no.'<br>'.$terminal_counter_no;
                // ===================================================================================================================================================
                $html.=' 
                        <tr style="word-wrap:break-word;">
                            <td style="vertical-align: middle; text-align: center;">
                                '.$terminal_counter_no.'
                            </td>
                            <td style="vertical-align: middle; text-align: left;">
                                '.$staff_name.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_cash.'</span>'.$cls_finalcash.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_bankcard.'</span>'.$cls_bankcard.$bankcard_variance.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_giftcheck.'</span>'.$cls_giftcheck.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_partialcash.'</span>'.$cls_partialcash.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_crmredeem.'</span>'.$cls_crmredeem.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_atp.'</span>'.$cls_atp.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_emp_chargeCredit.'</span>'.$cls_empcredit.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_po.'</span>'.$cls_po.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_ihcc.'</span>'.$cls_ihcc.'
                            </td>
                            <td style="vertical-align: middle; text-align: center; font-size: 11px;">
                                '.'<span '.$nav_color.'>'.$paymentTypeAndAmount.$br.$nav_otherpayment.'</span>'.'
                                '.$cls_otherpayment.$cls_otherpayment_total.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$net_amount.'</span>'.$cls_netAmount.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                <lable '.$netAmount_variance_color.'>'.$netAmount_variance.'</label>
                            </td>
                            <td class="action" style="vertical-align: middle; text-align: center;">
                                <button type="button" class="btn" style="background-color: antiquewhite;" onclick="adjustment_js('."'".$_POST['sales_date']."','".$nav['staff_id']."'".')">✏️</button>
                            </td>
                        </tr>
                        '; 
            }
            $nav_cash2 = number_format($nav_cash2, 2);
            $nav_bankcard3 = number_format($nav_bankcard3, 2);
            $nav_giftcheck2 = number_format($nav_giftcheck2, 2);
            $nav_partialcash2 = number_format($nav_partialcash2, 2);
            $nav_crmredeem2 = number_format($nav_crmredeem2, 2);
            $nav_atp2 = number_format($nav_atp2, 2);
            $nav_emp_chargeCredit2 = number_format($nav_emp_chargeCredit2, 2);
            $nav_po2 = number_format($nav_po2, 2);
            $nav_ihcc2 = number_format($nav_ihcc2, 2);
            $nav_otherpayment2 = number_format($nav_otherpayment2, 2);
            $cls_finalcash2 = '<br>'.number_format($cls_finalcash2, 2);
            $cls_bankcard2 = '<br>'.number_format($cls_bankcard2, 2);
            $cls_giftcheck2 = '<br>'.number_format($cls_giftcheck2, 2);
            $cls_partialcash2 = '<br>'.number_format($cls_partialcash2, 2);
            $cls_crmredeem2 = '<br>'.number_format($cls_crmredeem2, 2);
            $cls_atp2 = '<br>'.number_format($cls_atp2, 2);
            $cls_empcredit2 = '<br>'.number_format($cls_empcredit2, 2);
            $cls_po2 = '<br>'.number_format($cls_po2, 2);
            $cls_ihcc2 = '<br>'.number_format($cls_ihcc2, 2);
            $cls_otherpayment2 = '<br>'.number_format($cls_otherpayment2, 2);
            $cls_netAmount3 = '<br>'.number_format($cls_netAmount3, 2);
            $overall_amount = number_format($overall_amount, 2);
            $html.=' 
                                <tr style="word-wrap:break-word;">
                                    <td style="vertical-align: middle; text-align: center;">
                                    
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <span hidden>zzzzzzzz</span>TOTAL
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_cash2.'</span>'.$cls_finalcash2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_bankcard3.'</span>'.$cls_bankcard2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_giftcheck2.'</span>'.$cls_giftcheck2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_partialcash2.'</span>'.$cls_partialcash2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_crmredeem2.'</span>'.$cls_crmredeem2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_atp2.'</span>'.$cls_atp2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_emp_chargeCredit2.'</span>'.$cls_empcredit2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_po2.'</span>'.$cls_po2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_ihcc2.'</span>'.$cls_ihcc2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_otherpayment2.'</span>'.$cls_otherpayment2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: left;">
                                        '.'<span '.$nav_color.'>'.$overall_amount.'</span>'.$cls_netAmount3.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                    
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                    
                                    </td>
                                </tr>          
                        </table>
                    ';

            $title = '
                    <form>
                        <center>
                            <label>NAVISION VS CASHIER\'S LIQUIDATION SYSTEM</label>
                        </center>
                    </form>
                    ';
            
            $data['navcls_title']=$title;               
            $data['buDeptName']=$_POST['bname'].'&nbsp;/&nbsp;'.$_POST['dname'] ;               
            $data['sales_date']=$_POST['sales_date'];               
            $data['html']=$html;              
            echo json_encode($data);
        }
    }

    public function view_variance_navcls_ctrl_v2()
    {
        if(empty($_SESSION['emp_id']))
		{
			$message = "EXPIRED SESSION";
			echo json_encode($message);
		}
		else
        {
            $other_noncash_mop_array = array();
            $default_noncash_mop = array('Cards','Internal GC','CRM Redeem','ATP','Employee\'s Credit','PO Card','PO','IHCC');
            $cls_other_noncash = $this->accounting_model->get_cls_other_noncash_mop_model($_POST['sales_date'],$_POST['dcode'],$default_noncash_mop);
            foreach($cls_other_noncash as $cls_mop)
            {
                if(!in_array($cls_mop['mop_name'], $other_noncash_mop_array))
                { 
                    array_push($other_noncash_mop_array, $cls_mop['mop_name']);
                }
            }
            // ======================================================================================================================================
            $nav_other_noncash = $this->accounting_model->get_nav_other_noncash_mop_model($_POST['sales_date'],$_POST['store_no'],$_POST['dcode']);
            $header_store = '';
            $header_tenderTypeName = '';
            foreach($nav_other_noncash as $nav_mop)
            {
                $header_store = explode('-', $_POST['store_no']);
                if($header_store[0] == 'ICM')
                {
                    $icm_tenderTypeName = $this->accounting_model->get_icm_tender_name_model($nav_mop['tender_type']);
                    if(!empty($icm_tenderTypeName))
                    {
                        $header_tenderTypeName = $icm_tenderTypeName->icm_payment_name;
                    }
                }
                else if($header_store[0] == 'ASC')
                {
                    $asc_tenderTypeName = $this->accounting_model->get_asc_tender_name_model($nav_mop['tender_type']);
                    if(!empty($asc_tenderTypeName))
                    {
                        $header_tenderTypeName = $asc_tenderTypeName->asc_payment_name;
                    }
                }
                else if($header_store[0] == 'PM')
                {
                    $pm_tenderTypeName = $this->accounting_model->get_pm_tender_name_model($nav_mop['tender_type']);
                    if(!empty($pm_tenderTypeName))
                    {
                        $header_tenderTypeName = $pm_tenderTypeName->pm_payment_name;
                    }
                }
                if(!in_array($header_tenderTypeName, $other_noncash_mop_array))
                { 
                    array_push($other_noncash_mop_array, $header_tenderTypeName);
                }
            }
            // ==========================================================================================================================
            sort($other_noncash_mop_array);
            $additional_header_html = array();
            $additional_sub_header_html = array();
            for($i=0; $i<count($other_noncash_mop_array); $i++) 
            {
                array_push($additional_header_html, '<th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                                        <center>'.$other_noncash_mop_array[$i].'</center>
                                                    </th>');
                // ========================================================================================================================
                array_push($additional_sub_header_html, '<th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                                        <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                                        <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>');
            }
            $additional_header_html = implode("",$additional_header_html);
            $additional_sub_header_html = implode("",$additional_sub_header_html);
            // =========================================================================================================================
            $html='
                    <table class="table table-bordered table-hover table-condensed display tablesorter" id="navcls_variance_table">
                        <thead>
                            <tr>                                                          
                                <th style="vertical-align: middle;" rowspan="3">
                                    <center>CASHIER\'S NAME</center>
                                </th>
                                <th style="vertical-align: middle;" colspan="2" scope="colgroup">
                                    <center>TERMINAL NO.</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="7" scope="colgroup">
                                    <center>CASH</center>
                                </th>      
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>COMMERCIAL CARD\'S</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>INTERNAL GIFT CHECK</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>CRM Redeem</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>A.T.P</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>EMPLOYEE\'S CREDIT</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>PO CARD</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>IHCC</center>
                                </th>   
                                '.$additional_header_html.'
                                <th style="vertical-align: middle;" colspan="2" scope="colgroup">
                                    <center>TOTAL</center>
                                </th>   
                                <th style="vertical-align: middle;" rowspan="3">
                                    <center>VARIANCE</center>
                                </th>   
                                <th style="vertical-align: middle;" rowspan="3">
                                    <center>ACTION</center>
                                </th>                 
                            </tr>
                            <tr style="border-top: outset;">
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup"><center>CLS</center></th>
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                '.$additional_sub_header_html.'
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle; border-right: 1px solid;" scope="col" rowspan="2"><center>NAV</center></th>
                            </tr>
                            <tr style="border-top: outset;">
                                <th style="vertical-align: middle;" scope="col"><center>PARTIAL</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>FINAL</center></th>
                                <th style="vertical-align: middle; border-right: solid 1px;" scope="col"><center>TOTAL</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>PARTIAL</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>FINAL</center></th>
                                <th style="vertical-align: middle; border-right: solid 1px;" scope="col"><center>TOTAL</center></th>
                            </tr>
                        </thead>
                    ';
            // ============================================================================================================================================
            $nav_data = $this->accounting_model->get_uploaded_navdata_model($_POST['sales_date'],$_POST['store_no']);
            $terminal_counter_no = '';
            $bcode = '';
            $dcode = '';
            $staff_name = '';
            $staff_emp_id = '';
            $staff_id = '';
            $net_amount = 0;
            $net_amount2 = 0;
            $nav_total_amount = 0;
            $nav_cash = 0;
            $nav_cash2 = 0;
            $nav_cash3 = 0;
            $nav_bankcard = 0;
            $nav_bankcard2 = 0;
            $nav_bankcard3 = 0;
            $nav_giftcheck = 0;
            $nav_giftcheck2 = 0;
            $nav_giftcheck3 = 0;
            $nav_partialcash = 0;
            $nav_partialcash2 = 0;
            $nav_crmredeem = 0;
            $nav_crmredeem2 = 0;
            $nav_atp = 0;
            $nav_atp2 = 0;
            $nav_emp_chargeCredit = 0;
            $nav_emp_chargeCredit2 = 0;
            $nav_po = 0;
            $nav_po2 = 0;
            $nav_ihcc = 0;
            $nav_ihcc2 = 0;
            $nav_otherpayment = 0;
            $nav_otherpayment2 = 0;
            // =================================================================================
            $cls_finalcash2 = 0;
            $cls_bankcard2 = 0;
            $cls_giftcheck2 = 0;
            $cls_partialcash2 = 0;
            $cls_crmredeem2 = 0;
            $cls_atp2 = 0;
            $cls_empcredit2 = 0;
            $cls_po2 = 0;
            $cls_ihcc2 = 0;
            $cls_otherpayment2 = 0;
            $cls_netAmount2 = 0;
            $cls_netAmount3 = 0;
            foreach($nav_data as $nav)
            {
                $staff_terminal_counter = $this->accounting_model->get_staff_terminal_counter_model($_POST['sales_date'],$nav['staff_id']);
                $store_no = '';
                $terminal_amount = '';
                $pos_terminal_no = array();
                foreach($staff_terminal_counter as $tcno)
                {
                    $store_no = $tcno['store_no'];
                    $terminal_counter_amount = $this->accounting_model->get_terminal_counter_amount_model($_POST['sales_date'],$nav['staff_id'],$tcno['pos_terminal_no']);
                    $terminal_amount = number_format($terminal_counter_amount, 2);
                    array_push($pos_terminal_no, $tcno['pos_terminal_no'].' | '.$terminal_amount.'<br>');
                }
                // ==============================================================================================================================================
                $staff_info = $this->accounting_model->get_staff_info_model($nav['staff_id']);
                if(empty($staff_info))
                {
                    $staff_id = $nav['staff_id'] * 1;
                    $staff_info2 = $this->accounting_model->get_staff_info_model($staff_id);
                    if(!empty($staff_info2))
                    {
                        $staff_name = $staff_info2->name;
                        $staff_emp_id = $staff_info2->emp_id;
                    }
                }
                else
                {
                    $staff_name = $staff_info->name;
                }
                // ==============================================================================================================================================
                $staff_net_amount = $this->accounting_model->get_staff_net_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($staff_net_amount))
                {
                    $net_amount2 = $staff_net_amount->amount;
                    $net_amount = $staff_net_amount->amount;
                    $nav_total_amount += $staff_net_amount->amount;
                }
                // ==============================================================================================================================================
                $navcash_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],1);
                if(!empty($navcash_tender_type))
                {
                    $nav_cash3 = $navcash_tender_type->type_amount;
                    $nav_cash2 += $navcash_tender_type->type_amount;
                    $nav_cash = $navcash_tender_type->type_amount;
                    $nav_cash = number_format($nav_cash, 2);
                }
                // ==============================================================================================================================================
                $nav_bankcard_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],3);
                if(!empty($nav_bankcard_tender_type))
                {
                    $nav_bankcard3 += $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard2 = $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard = $nav_bankcard_tender_type->type_amount;
                }
                // ==============================================================================================================================================
                $nav_giftcheck_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],35);
                if(!empty($nav_giftcheck_tender_type))
                {
                    $nav_giftcheck3 = $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck2 += $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck = $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck = number_format($nav_giftcheck, 2);
                }
                // ==============================================================================================================================================
                $nav_partialcash_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],9);
                if(!empty($nav_partialcash_tender_type))
                {
                    $nav_partialcash3 = $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash2 += $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash = $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash = number_format($nav_partialcash, 2);
                }
                // ==============================================================================================================================================
                $nav_crmredeem_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],28);
                if(!empty($nav_crmredeem_tender_type))
                {
                    $nav_crmredeem2 += $nav_crmredeem_tender_type->type_amount;
                    $nav_crmredeem = $nav_crmredeem_tender_type->type_amount;
                }
                // ==============================================================================================================================================
                $nav_atp_tender_type = $this->accounting_model->get_atp_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($nav_atp_tender_type))
                {
                    $nav_atp2 += $nav_atp_tender_type->type_amount;
                    $nav_atp = $nav_atp_tender_type->type_amount;
                }
                // ==============================================================================================================================================
                $nav_emp_chargeCredit_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],36);
                if(!empty($nav_emp_chargeCredit_tender_type))
                {
                    $nav_emp_chargeCredit2 += $nav_emp_chargeCredit_tender_type->type_amount;
                    $nav_emp_chargeCredit = $nav_emp_chargeCredit_tender_type->type_amount;
                }
                // ==============================================================================================================================================
                $nav_po_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],14);
                if(!empty($nav_po_tender_type))
                {
                    $nav_po2 += $nav_po_tender_type->type_amount;
                    $nav_po = $nav_po_tender_type->type_amount;
                }
                // ==============================================================================================================================================
                $nav_ihcc_tender_type = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],15);
                if(!empty($nav_ihcc_tender_type))
                {
                    $nav_ihcc2 += $nav_ihcc_tender_type->type_amount;
                    $nav_ihcc = $nav_ihcc_tender_type->type_amount;
                }
                // ==============================================================================================================================================
                $nav_otherpayment_tender_type = $this->accounting_model->get_otherpayment_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($nav_otherpayment_tender_type))
                {
                    $nav_otherpayment2 += $nav_otherpayment_tender_type->type_amount;
                    $nav_otherpayment = $nav_otherpayment_tender_type->type_amount;
                    $nav_otherpayment = number_format($nav_otherpayment, 2);
                }
                $nav_other_tender_type = $this->accounting_model->get_other_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                $paymentTypeAndAmount = '';
                $br = '';
                if(!empty($nav_other_tender_type))
                {
                    $nav_othertype_array = array();
                    $nav_othertype = '';
                    $store = '';
                    $tenderTypeName = '';
                    foreach($nav_other_tender_type as $othertype)
                    {
                        $store = explode('-', $_POST['store_no']);
                        if($store[0] == 'ICM')
                        {
                            $icm_tenderTypeName = $this->accounting_model->get_icm_tender_name_model($othertype['other_type']);
                            if(!empty($icm_tenderTypeName))
                            {
                                $tenderTypeName = $icm_tenderTypeName->icm_payment_name;
                            }
                        }
                        else if($store[0] == 'ASC')
                        {
                            $asc_tenderTypeName = $this->accounting_model->get_asc_tender_name_model($othertype['other_type']);
                            if(!empty($asc_tenderTypeName))
                            {
                                $tenderTypeName = $asc_tenderTypeName->asc_payment_name;
                            }
                        }
                        else if($store[0] == 'PM')
                        {
                            $pm_tenderTypeName = $this->accounting_model->get_pm_tender_name_model($othertype['other_type']);
                            if(!empty($pm_tenderTypeName))
                            {
                                $tenderTypeName = $pm_tenderTypeName->pm_payment_name;
                            }
                        }

                        $nav_othertype_data = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],$othertype['other_type']);
                        $nav_othertype = $nav_othertype_data->type_amount;
                        if($nav_othertype > 0)
                        {
                            $nav_othertype = $tenderTypeName.'|'.$nav_othertype;
                            array_push($nav_othertype_array, $nav_othertype);
                        }
                    }

                    if(!empty($nav_othertype_array))
                    {
                        $br = '<br>';
                        $paymentTypeAndAmount = implode('<br>', $nav_othertype_array);
                        $paymentTypeAndAmount = '('.$paymentTypeAndAmount.')';
                    }
                }
                // ===================================================================================================================================================
                $bu_data = $this->accounting_model->get_bcode_model($_POST['bname']);
                if(!empty($bu_data))
                {
                    $bcode = $bu_data->bcode;
                }
                $dept_data = $this->accounting_model->get_dcode_model($bcode,$_POST['dname']);
                if(!empty($dept_data))
                {
                    $dcode = $dept_data->dcode;
                }
                $cebo_cs_denomination_data = $this->accounting_model->get_cebo_cs_denomination_model_v2($staff_emp_id,$_POST['sales_date'],$dcode);
                $tr_no_array = array();
                $cls_netAmount = 0;
                foreach($cebo_cs_denomination_data as $data)
                {
                    if(!in_array($data['tr_no'], $tr_no_array))
                    {  
                        array_push($tr_no_array, $data['tr_no']);
                    }
                    $cls_netAmount += $data['total'];
                    $cls_netAmount3 += $data['total'];
                }
                // ===============================================================================================
                $cls_terminal_no_array = array();
                $cls_bankcard = 0;
                $cls_giftcheck = 0;
                $cls_crmredeem = 0;
                $cls_atp = 0;
                $cls_empcredit = 0;
                $cls_po = 0;
                $cls_ihcc = 0;
                $cls_finalcash = 0;
                $cls_partialcash = 0;
                $cls_otherpayment_total = 0;
                $netAmount_variance = 0;
                $additional_body_html = array();
                if(!empty($tr_no_array))
                {
                    $cash_noncash_terminal_no_array = array();
                    $cls_cash_terminal_no = $this->accounting_model->get_cls_cash_terminal_no_model($tr_no_array,$staff_emp_id);
                    foreach($cls_cash_terminal_no as $cash)
                    {
                        if(!in_array($cash['pos_name'], $cash_noncash_terminal_no_array))
                        {  
                            array_push($cash_noncash_terminal_no_array, $cash['pos_name']);
                        }
                    }
                    // ========================================================================================================================
                    $cls_noncash_terminal_no = $this->accounting_model->get_cls_noncash_terminal_no_model($tr_no_array,$staff_emp_id);
                    foreach($cls_noncash_terminal_no as $noncash)
                    {
                        if(!in_array($noncash['pos_name'], $cash_noncash_terminal_no_array))
                        {  
                            array_push($cash_noncash_terminal_no_array, $noncash['pos_name']);
                        }
                    }
                    // ========================================================================================================================
                    for($a=0; $a<count($cash_noncash_terminal_no_array); $a++) 
                    {
                        $cls_cash_terminal_no_total = $this->accounting_model->get_cls_cash_terminal_no_total_model($tr_no_array,$staff_emp_id,$cash_noncash_terminal_no_array[$a]);
                        // ===============================================================================================================================
                        $cls_noncash_terminal_no_total = $this->accounting_model->get_cls_noncash_terminal_no_total_model($tr_no_array,$staff_emp_id,$cash_noncash_terminal_no_array[$a]);
                        // =============================================================================================================================
                        $cls_terminal_no_and_total = $cls_cash_terminal_no_total + $cls_noncash_terminal_no_total;
                        $cls_terminal_no_and_total = number_format($cls_terminal_no_and_total, 2);
                        array_push($cls_terminal_no_array, $cash_noncash_terminal_no_array[$a].' | '.$cls_terminal_no_and_total.'<br>');
                    }
                    // ========================================================================================================================
                    $final_cash = $this->accounting_model->get_final_cash_model($tr_no_array,$staff_emp_id);
                    if(!empty($final_cash))
                    {
                        $cls_finalcash = $final_cash->total;
                        $cls_finalcash2 += $final_cash->total;
                    }
                    $partial_cash = $this->accounting_model->get_partial_cash_model($tr_no_array,$staff_emp_id);
                    if(!empty($partial_cash))
                    {
                        $cls_partialcash = $partial_cash->total;
                        $cls_partialcash2 += $partial_cash->total;
                    }
                    $cls_cashier_noncash_data = $this->accounting_model->get_cs_cashier_noncashden_model($tr_no_array,$staff_emp_id);
                    foreach($cls_cashier_noncash_data as $noncash)
                    {
                        if($noncash['mop_name'] == 'Cards')
                        {
                            $cls_bankcard2 += $noncash['noncash_amount'];
                            $cls_bankcard += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'Internal GC')
                        {
                            $cls_giftcheck2 += $noncash['noncash_amount'];
                            $cls_giftcheck += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'CRM Redeem')
                        {
                            $cls_crmredeem2 += $noncash['noncash_amount'];
                            $cls_crmredeem += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'ATP')
                        {
                            $cls_atp2 += $noncash['noncash_amount'];
                            $cls_atp += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'Employee\'s Credit')
                        {
                            $cls_empcredit2 += $noncash['noncash_amount'];
                            $cls_empcredit += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'PO Card' || $noncash['mop_name'] == 'PO')
                        {
                            $cls_po2 += $noncash['noncash_amount'];
                            $cls_po += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'IHCC')
                        {
                            $cls_ihcc2 += $noncash['noncash_amount'];
                            $cls_ihcc += $noncash['noncash_amount'];
                        }
                    }
                    // ================================================================================================================================================
                    $body_store = '';
                    $body_tenderType = '';
                    for($a=0; $a<count($other_noncash_mop_array); $a++) 
                    {
                        $cls_other_mop_data = $this->accounting_model->get_cls_other_mop_model($tr_no_array,$staff_emp_id,$other_noncash_mop_array[$a]);
                        $cls_other_mop_amount = 0;
                        if(!empty($cls_other_mop_data))
                        {
                            $cls_other_mop_amount = $cls_other_mop_data->amount;
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">'.number_format($cls_other_mop_data->amount, 2).'</td>');
                        }
                        else
                        {
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">0.00</td>');
                        }
                        // ==============================================================================================================================================
                        $body_store = explode('-', $_POST['store_no']);
                        $nav_tender_code = array();
                        if($body_store[0] == 'ICM')
                        {
                            $icm_tenderType = $this->accounting_model->get_icm_tender_type_model($other_noncash_mop_array[$a]);
                            foreach($icm_tenderType as $code)
                            {
                                array_push($nav_tender_code, $code['code']);
                            }
                        }
                        else if($body_store[0] == 'ASC')
                        {
                            $asc_tenderType = $this->accounting_model->get_asc_tender_type_model($other_noncash_mop_array[$a]);
                            foreach($asc_tenderType as $code)
                            {
                                array_push($nav_tender_code, $code['code']);
                            }
                        }
                        else if($body_store[0] == 'PM')
                        {
                            $pm_tenderType = $this->accounting_model->get_pm_tender_type_model($other_noncash_mop_array[$a]);
                            foreach($pm_tenderType as $code)
                            {
                                array_push($nav_tender_code, $code['code']);
                            }
                        }
                        // ===========================================================================================================================================
                        $nav_other_mop_data = $this->accounting_model->get_nav_other_mop_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],$nav_tender_code);
                        $nav_other_mop_amount = 0;
                        if(!empty($nav_other_mop_data->amount))
                        {
                            $nav_other_mop_amount = $nav_other_mop_data->amount;
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">'.number_format($nav_other_mop_data->amount, 2).'</td>');
                            // ========================================================================================================================================
                            $variance_other_mop_amount = $cls_other_mop_amount - $nav_other_mop_amount;
                            if($variance_other_mop_amount < 0)
                            {
                                $variance_other_mop_amount = preg_replace('/-/', "", $variance_other_mop_amount);
                                $variance_other_mop_amount = '('.number_format($variance_other_mop_amount, 2).')';
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: red;">'.$variance_other_mop_amount.'</td>');
                            }
                            else
                            {
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: green;">'.number_format($variance_other_mop_amount, 2).'</td>');
                            }
                        }
                        else
                        {
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">0.00</td>');
                            // ========================================================================================================================================
                            $variance_other_mop_amount = $cls_other_mop_amount - $nav_other_mop_amount;
                            if($variance_other_mop_amount < 0)
                            {
                                $variance_other_mop_amount = preg_replace('/-/', "", $variance_other_mop_amount);
                                $variance_other_mop_amount = '('.number_format($variance_other_mop_amount, 2).')';
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: red;">'.$variance_other_mop_amount.'</td>');
                            }
                            else
                            {
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: green;">'.number_format($variance_other_mop_amount, 2).'</td>');
                            }
                        }
                    }
                }
                else
                {
                    $body_store = '';
                    $body_tenderType = '';
                    for($a=0; $a<count($other_noncash_mop_array); $a++) 
                    {
                        $body_store = explode('-', $_POST['store_no']);
                        $nav_tender_code = array();
                        if($body_store[0] == 'ICM')
                        {
                            $icm_tenderType = $this->accounting_model->get_icm_tender_type_model($other_noncash_mop_array[$a]);
                            foreach($icm_tenderType as $code)
                            {
                                array_push($nav_tender_code, $code['code']);
                            }
                        }
                        else if($body_store[0] == 'ASC')
                        {
                            $asc_tenderType = $this->accounting_model->get_asc_tender_type_model($other_noncash_mop_array[$a]);
                            foreach($asc_tenderType as $code)
                            {
                                array_push($nav_tender_code, $code['code']);
                            }
                        }
                        else if($body_store[0] == 'PM')
                        {
                            $pm_tenderType = $this->accounting_model->get_pm_tender_type_model($other_noncash_mop_array[$a]);
                            foreach($pm_tenderType as $code)
                            {
                                array_push($nav_tender_code, $code['code']);
                            }
                        }
                        // ===========================================================================================================================================
                        $nav_other_mop_data = $this->accounting_model->get_nav_other_mop_amount_model($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],$nav_tender_code);
                        $cls_other_mop_amount = 0;
                        $nav_other_mop_amount = 0;
                        if(!empty($nav_other_mop_data->amount))
                        {
                            $nav_other_mop_amount = $nav_other_mop_data->amount;
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">0.00</td>
                                                                <td style="vertical-align: middle; text-align: center;">'.number_format($nav_other_mop_data->amount, 2).'</td>');
                            // =======================================================================================================================================
                            $variance_other_mop_amount = $cls_other_mop_amount - $nav_other_mop_amount;
                            if($variance_other_mop_amount < 0)
                            {
                                $variance_other_mop_amount = preg_replace('/-/', "", $variance_other_mop_amount);
                                $variance_other_mop_amount = '('.number_format($variance_other_mop_amount, 2).')';
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: red;">'.$variance_other_mop_amount.'</td>');
                            }
                            else
                            {
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: green;">'.number_format($variance_other_mop_amount, 2).'</td>');
                            }
                        }
                        else
                        {
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">0.00</td>
                                                               <td style="vertical-align: middle; text-align: center;">0.00</td>');
                            // =======================================================================================================================================
                            $variance_other_mop_amount = $cls_other_mop_amount - $nav_other_mop_amount;
                            if($variance_other_mop_amount < 0)
                            {
                                $variance_other_mop_amount = preg_replace('/-/', "", $variance_other_mop_amount);
                                $variance_other_mop_amount = '('.number_format($variance_other_mop_amount, 2).')';
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: red;">'.$variance_other_mop_amount.'</td>');
                            }
                            else
                            {
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: green;">'.number_format($variance_other_mop_amount, 2).'</td>');
                            }
                        }
                    }
                }
                // ==================================================================================================================================================
                $cls_terminal_no_array = implode("", $cls_terminal_no_array);
                $cls_terminal_no_array = substr_replace($cls_terminal_no_array ,"",-4);
                $cls_terminal_no_array = $cls_terminal_no_array;
                // ==================================================================================================================================================
                $terminal_counter_no = implode("", $pos_terminal_no);
                $terminal_counter_no = substr_replace($terminal_counter_no ,"",-4);
                $terminal_counter_no = $terminal_counter_no;
                // ===================================================================================================================================================
                $variance_color = 'color: green;';
                $cls_total_cash = $cls_partialcash + $cls_finalcash;
                $nav_total_cash = $nav_partialcash3 + $nav_cash3;
                $cash_variance = bcsub($cls_total_cash, $nav_total_cash, 4);
                if($cash_variance < 0)
                {
                    $variance_color = 'color: red;';
                    $cash_variance = preg_replace('/-/', "", $cash_variance);
                    $cash_variance = '('.number_format($cash_variance, 2).')';
                }
                else
                {
                    $cash_variance = number_format($cash_variance, 2);
                }
                
                $cls_partialcash = number_format($cls_partialcash, 2);
                $cls_finalcash = number_format($cls_finalcash, 2);
                $cls_total_cash = number_format($cls_total_cash, 2);
                $nav_total_cash = number_format($nav_total_cash, 2);
                // ==================================================================================================================
                $bc_variance_color = 'color: green;';
                $bc_variance = bcsub($cls_bankcard, $nav_bankcard, 4);
                if($bc_variance < 0)
                {
                    $bc_variance_color = 'color: red;';
                    $bc_variance = preg_replace('/-/', "", $bc_variance);
                    $bc_variance = '('.number_format($bc_variance, 2).')';
                }
                else
                {
                    $bc_variance = number_format($bc_variance, 2);
                }
                $nav_bankcard = number_format($nav_bankcard, 2);
                $cls_bankcard = number_format($cls_bankcard, 2);
                // ==================================================================================================================
                $gc_variance_color = 'color: green;';
                $giftcheck_variance = bcsub($cls_giftcheck, $nav_giftcheck3, 4);
                if($giftcheck_variance < 0)
                {
                    $gc_variance_color = 'color: red;';
                    $giftcheck_variance = preg_replace('/-/', "", $giftcheck_variance);
                    $giftcheck_variance = '('.number_format($giftcheck_variance, 2).')';
                }
                else
                {
                    $giftcheck_variance = number_format($giftcheck_variance, 2);
                }
                $cls_giftcheck = number_format($cls_giftcheck, 2);
                // ========================================================================================================================
                $crmredeem_variance_color = 'color: green;';
                $crmredeem_variance = bcsub($cls_crmredeem, $nav_crmredeem, 4);
                if($crmredeem_variance < 0)
                {
                    $crmredeem_variance_color = 'color: red;';
                    $crmredeem_variance = preg_replace('/-/', "", $crmredeem_variance);
                    $crmredeem_variance = '('.number_format($crmredeem_variance, 2).')';
                }
                else
                {
                    $crmredeem_variance = number_format($crmredeem_variance, 2);
                }
                $nav_crmredeem = number_format($nav_crmredeem, 2);
                $cls_crmredeem = number_format($cls_crmredeem, 2);
                // ========================================================================================================================
                $atp_variance_color = 'color: green;';
                $atp_variance = bcsub($cls_atp, $nav_atp, 4);
                if($atp_variance < 0)
                {
                    $atp_variance_color = 'color: red;';
                    $atp_variance = preg_replace('/-/', "", $atp_variance);
                    $atp_variance = '('.number_format($atp_variance, 2).')';
                }
                else
                {
                    $atp_variance = number_format($atp_variance, 2);
                }
                $cls_atp = number_format($cls_atp, 2);
                $nav_atp = number_format($nav_atp, 2);
                // ========================================================================================================================
                $empcredit_variance_color = 'color: green;';
                $empcredit_variance = bcsub($cls_empcredit, $nav_emp_chargeCredit, 4);
                if($empcredit_variance < 0)
                {
                    $empcredit_variance_color = 'color: red;';
                    $empcredit_variance = preg_replace('/-/', "", $empcredit_variance);
                    $empcredit_variance = '('.number_format($empcredit_variance, 2).')';
                }
                else
                {
                    $empcredit_variance = number_format($empcredit_variance, 2);
                }
                $cls_empcredit = number_format($cls_empcredit, 2);
                $nav_emp_chargeCredit = number_format($nav_emp_chargeCredit, 2);
                // ========================================================================================================================
                $po_variance_color = 'color: green;';
                $po_variance = bcsub($cls_po, $nav_po, 4);
                if($po_variance < 0)
                {
                    $po_variance_color = 'color: red;';
                    $po_variance = preg_replace('/-/', "", $po_variance);
                    $po_variance = '('.number_format($po_variance, 2).')';
                }
                else
                {
                    $po_variance = number_format($po_variance, 2);
                }
                $cls_po = number_format($cls_po, 2);
                $nav_po = number_format($nav_po, 2);
                // ========================================================================================================================
                $ihcc_variance_color = 'color: green;';
                $ihcc_variance = bcsub($cls_ihcc, $nav_ihcc, 4);
                if($ihcc_variance < 0)
                {
                    $ihcc_variance_color = 'color: red;';
                    $ihcc_variance = preg_replace('/-/', "", $ihcc_variance);
                    $ihcc_variance = '('.number_format($ihcc_variance, 2).')';
                }
                else
                {
                    $ihcc_variance = number_format($ihcc_variance, 2);
                }
                $cls_ihcc = number_format($cls_ihcc, 2);
                $nav_ihcc = number_format($nav_ihcc, 2);
                // ========================================================================================================================
                $total_variance_color = 'color: green;';
                $total_variance = bcsub($cls_netAmount, $net_amount, 4);
                if($total_variance < 0)
                {
                    $total_variance_color = 'color: red;';
                    $total_variance = preg_replace('/-/', "", $total_variance);
                    $total_variance = '('.number_format($total_variance, 2).')';
                }
                else
                {
                    $total_variance = number_format($total_variance, 2);
                }
                $cls_netAmount = number_format($cls_netAmount, 2);
                $net_amount = number_format($net_amount, 2);
                // ========================================================================================================================
                $additional_body_html = implode("",$additional_body_html);
                // ========================================================================================================================
                $html.=' 
                        <tr style="word-wrap:break-word;">
                            <td style="vertical-align: middle; text-align: left;">'.$staff_name.'</td>
                            <td style="vertical-align: middle; text-align: center; white-space:nowrap;">'.$cls_terminal_no_array.'</td>
                            <td style="vertical-align: middle; text-align: center; white-space:nowrap;">'.$terminal_counter_no.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_partialcash.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_finalcash.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_total_cash.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_partialcash.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_cash.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_total_cash.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$variance_color.'">'.$cash_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_bankcard.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_bankcard.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$bc_variance_color.'">'.$bc_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_giftcheck.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_giftcheck.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$gc_variance_color.'">'.$giftcheck_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_crmredeem.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_crmredeem.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$crmredeem_variance_color.'">'.$crmredeem_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_atp.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_atp.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$atp_variance_color.'">'.$atp_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_empcredit.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_emp_chargeCredit.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$empcredit_variance_color.'">'.$empcredit_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_po.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_po.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$po_variance_color.'">'.$po_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_ihcc.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_ihcc.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$ihcc_variance_color.'">'.$ihcc_variance.'</td>
                            '.$additional_body_html.'
                            <td style="vertical-align: middle; text-align: center;">'.$cls_netAmount.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$net_amount.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$total_variance_color.'">'.$total_variance.'</td>
                            <td class="action" style="vertical-align: middle; text-align: center;">
                                <button type="button" class="btn" style="background-color: antiquewhite;" onclick="adjustment_js('."'".$_POST['sales_date']."','".$nav['staff_id']."'".')">✏️</button>
                            </td>
                        </tr>
                        '; 
            }
            // =============================================================================================================================================
            $additional_footer_html = array(); 
            $footer_store = '';
            for($b=0; $b<count($other_noncash_mop_array); $b++) 
            {
                $cls_other_noncash = $this->accounting_model->get_cls_other_noncash_total_model($_POST['sales_date'],$_POST['dcode'],$other_noncash_mop_array[$b]);
                $cls_other_mop_total = 0;
                if(!empty($cls_other_noncash))
                {
                    $cls_other_mop_total = $cls_other_noncash;
                }
                // ===========================================================================================================================================
                $footer_tenderType = '';
                $footer_store = explode('-', $_POST['store_no']);
                if($footer_store[0] == 'ICM')
                {
                    $icm_tenderType = $this->accounting_model->get_icm_tender_code_model($other_noncash_mop_array[$b]);
                    if(!empty($icm_tenderType))
                    {
                        $footer_tenderType = $icm_tenderType->icm_payment_code;
                    }
                }
                else if($footer_store[0] == 'ASC')
                {
                    $asc_tenderType = $this->accounting_model->get_asc_tender_code_model($other_noncash_mop_array[$b]);
                    if(!empty($asc_tenderType))
                    {
                        $footer_tenderType = $asc_tenderType->asc_payment_code;
                    }
                }
                else if($footer_store[0] == 'PM')
                {
                    $pm_tenderType = $this->accounting_model->get_pm_tender_code_model($other_noncash_mop_array[$b]);
                    if(!empty($pm_tenderType))
                    {
                        $footer_tenderType = $pm_tenderType->pm_payment_code;
                    }
                }
                // =================================================================================================================================================
                $nav_other_noncash = $this->accounting_model->get_nav_other_noncash_total_model($_POST['sales_date'],$_POST['store_no'],$_POST['dcode'],$footer_tenderType);
                $nav_other_mop_total = 0;
                if(!empty($nav_other_noncash))
                {
                    $nav_other_mop_total = $nav_other_noncash;
                }
                // ===================================================================================================================================
                $navcls_other_mop_total_variance_color = 'color: green;';
                $navcls_other_mop_total_variance = $cls_other_mop_total - $nav_other_mop_total;
                if($navcls_other_mop_total_variance < 0)
                {
                    $navcls_other_mop_total_variance_color = 'color: red;';
                    $navcls_other_mop_total_variance = preg_replace('/-/', "", $navcls_other_mop_total_variance);
                    $navcls_other_mop_total_variance = '('.number_format($navcls_other_mop_total_variance, 2).')';
                }
                else
                {
                    $navcls_other_mop_total_variance = number_format($navcls_other_mop_total_variance, 2);
                }
                $cls_other_mop_total = number_format($cls_other_mop_total, 2); 
                $nav_other_mop_total = number_format($nav_other_mop_total, 2); 
                // ============================================================================================================================================
                array_push($additional_footer_html, '<td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_other_mop_total.'</td>
                                                     <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_other_mop_total.'</td>
                                                     <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_other_mop_total_variance_color.'">'.$navcls_other_mop_total_variance.'</td>');
            }
            $additional_footer_html = implode("",$additional_footer_html);
            // ================================================================================================================================================
            $cls_cash_total = $cls_partialcash2 + $cls_finalcash2;
            $nav_cash_total = $nav_partialcash2 + $nav_cash2;
            $navcls_total_variance_color = 'color: green;';
            $navcls_total_variance = $cls_cash_total - $nav_cash_total;
            if($navcls_total_variance < 0)
            {
                $navcls_total_variance_color = 'color: red;';
                $navcls_total_variance = preg_replace('/-/', "", $navcls_total_variance);
                $navcls_total_variance = '('.number_format($navcls_total_variance, 2).')';
            }
            else
            {
                $navcls_total_variance = number_format($navcls_total_variance, 2);
            }
            $cls_cash_total = number_format($cls_cash_total, 2);
            $nav_cash_total = number_format($nav_cash_total, 2);
            $cls_partialcash2 = number_format($cls_partialcash2, 2);
            $cls_finalcash2 = number_format($cls_finalcash2, 2);
            $nav_partialcash2 = number_format($nav_partialcash2, 2);
            $nav_cash2 = number_format($nav_cash2, 2);
            // ==================================================================================================================================================
            $navcls_bankcard_total_variance_color = 'color: green;';
            $navcls_bankcard_total_variance = $cls_bankcard2 - $nav_bankcard3;
            if($navcls_bankcard_total_variance < 0)
            {
                $navcls_bankcard_total_variance_color = 'color: red;';
                $navcls_bankcard_total_variance = preg_replace('/-/', "", $navcls_bankcard_total_variance);
                $navcls_bankcard_total_variance = '('.number_format($navcls_bankcard_total_variance, 2).')';
            }
            else
            {
                $navcls_bankcard_total_variance = number_format($navcls_bankcard_total_variance, 2);
            }
            $cls_bankcard2 = number_format($cls_bankcard2, 2); 
            $nav_bankcard3 = number_format($nav_bankcard3, 2); 
            // ==================================================================================================================================================
            $navcls_giftcheck_total_variance_color = 'color: green;';
            $navcls_giftcheck_total_variance = $cls_giftcheck2 - $nav_giftcheck2;
            if($navcls_giftcheck_total_variance < 0)
            {
                $navcls_giftcheck_total_variance_color = 'color: red;';
                $navcls_giftcheck_total_variance = preg_replace('/-/', "", $navcls_giftcheck_total_variance);
                $navcls_giftcheck_total_variance = '('.number_format($navcls_giftcheck_total_variance, 2).')';
            }
            else
            {
                $navcls_giftcheck_total_variance = number_format($navcls_giftcheck_total_variance, 2);
            }
            $cls_giftcheck2 = number_format($cls_giftcheck2, 2); 
            $nav_giftcheck2 = number_format($nav_giftcheck2, 2); 
            // ==================================================================================================================================================
            $navcls_crmredeem_total_variance_color = 'color: green;';
            $navcls_crmredeem_total_variance = $cls_crmredeem2 - $nav_crmredeem2;
            if($navcls_crmredeem_total_variance < 0)
            {
                $navcls_crmredeem_total_variance_color = 'color: red;';
                $navcls_crmredeem_total_variance = preg_replace('/-/', "", $navcls_crmredeem_total_variance);
                $navcls_crmredeem_total_variance = '('.number_format($navcls_crmredeem_total_variance, 2).')';
            }
            else
            {
                $navcls_crmredeem_total_variance = number_format($navcls_crmredeem_total_variance, 2);
            }
            $cls_crmredeem2 = number_format($cls_crmredeem2, 2); 
            $nav_crmredeem2 = number_format($nav_crmredeem2, 2); 
            // ==================================================================================================================================================
            $navcls_atp_total_variance_color = 'color: green;';
            $navcls_atp_total_variance = $cls_atp2 - $nav_atp2;
            if($navcls_atp_total_variance < 0)
            {
                $navcls_atp_total_variance_color = 'color: red;';
                $navcls_atp_total_variance = preg_replace('/-/', "", $navcls_atp_total_variance);
                $navcls_atp_total_variance = '('.number_format($navcls_atp_total_variance, 2).')';
            }
            else
            {
                $navcls_atp_total_variance = number_format($navcls_atp_total_variance, 2);
            }
            $cls_atp2 = number_format($cls_atp2, 2); 
            $nav_atp2 = number_format($nav_atp2, 2); 
            // ==================================================================================================================================================
            $navcls_empcredit_total_variance_color = 'color: green;';
            $navcls_empcredit_total_variance = $cls_empcredit2 - $nav_emp_chargeCredit2;
            if($navcls_empcredit_total_variance < 0)
            {
                $navcls_empcredit_total_variance_color = 'color: red;';
                $navcls_empcredit_total_variance = preg_replace('/-/', "", $navcls_empcredit_total_variance);
                $navcls_empcredit_total_variance = '('.number_format($navcls_empcredit_total_variance, 2).')';
            }
            else
            {
                $navcls_empcredit_total_variance = number_format($navcls_empcredit_total_variance, 2);
            }
            $cls_empcredit2 = number_format($cls_empcredit2, 2); 
            $nav_emp_chargeCredit2 = number_format($nav_emp_chargeCredit2, 2); 
            // ==================================================================================================================================================
            $navcls_po_total_variance_color = 'color: green;';
            $navcls_po_total_variance = $cls_po2 - $nav_po2;
            if($navcls_po_total_variance < 0)
            {
                $navcls_po_total_variance_color = 'color: red;';
                $navcls_po_total_variance = preg_replace('/-/', "", $navcls_po_total_variance);
                $navcls_po_total_variance = '('.number_format($navcls_po_total_variance, 2).')';
            }
            else
            {
                $navcls_po_total_variance = number_format($navcls_po_total_variance, 2);
            }
            $cls_po2 = number_format($cls_po2, 2); 
            $nav_po2 = number_format($nav_po2, 2); 
            // ==================================================================================================================================================
            $navcls_ihcc_total_variance_color = 'color: green;';
            $navcls_ihcc_total_variance = $cls_ihcc2 - $nav_ihcc2;
            if($navcls_ihcc_total_variance < 0)
            {
                $navcls_ihcc_total_variance_color = 'color: red;';
                $navcls_ihcc_total_variance = preg_replace('/-/', "", $navcls_ihcc_total_variance);
                $navcls_ihcc_total_variance = '('.number_format($navcls_ihcc_total_variance, 2).')';
            }
            else
            {
                $navcls_ihcc_total_variance = number_format($navcls_ihcc_total_variance, 2);
            }
            $cls_ihcc2 = number_format($cls_ihcc2, 2); 
            $nav_ihcc2 = number_format($nav_ihcc2, 2); 
            // ==================================================================================================================================================
            $navcls_footer_total_variance_color = 'color: green;';
            $navcls_footer_total_variance = $cls_netAmount3 - $nav_total_amount;
            if($navcls_footer_total_variance < 0)
            {
                $navcls_footer_total_variance_color = 'color: red;';
                $navcls_footer_total_variance = preg_replace('/-/', "", $navcls_footer_total_variance);
                $navcls_footer_total_variance = '('.number_format($navcls_footer_total_variance, 2).')';
            }
            else
            {
                $navcls_footer_total_variance = number_format($navcls_footer_total_variance, 2);
            }
            $cls_netAmount3 = number_format($cls_netAmount3, 2); 
            $nav_total_amount = number_format($nav_total_amount, 2); 
            // ==================================================================================================================================================
            $html.=' 
                        <tr style="word-wrap:break-word;">
                            <td style="vertical-align: middle; text-align: center;"><span hidden>zzzzzzzzzzzzzzzz</span></td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;"></td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">TOTAL</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_partialcash2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_finalcash2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_cash_total.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_partialcash2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_cash2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_cash_total.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_total_variance_color.'">'.$navcls_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_bankcard2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_bankcard3.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_bankcard_total_variance_color.'">'.$navcls_bankcard_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_giftcheck2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_giftcheck2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_giftcheck_total_variance_color.'">'.$navcls_giftcheck_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_crmredeem2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_crmredeem2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_crmredeem_total_variance_color.'">'.$navcls_crmredeem_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_atp2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_atp2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_atp_total_variance_color.'">'.$navcls_atp_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_empcredit2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_emp_chargeCredit2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_empcredit_total_variance_color.'">'.$navcls_empcredit_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_po2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_po2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_po_total_variance_color.'">'.$navcls_po_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_ihcc2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_ihcc2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_ihcc_total_variance_color.'">'.$navcls_ihcc_total_variance.'</td>
                            '.$additional_footer_html.'
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_netAmount3.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_total_amount.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_footer_total_variance_color.'">'.$navcls_footer_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;"></td>
                        </tr>          
                    </table>
                    ';
            // ============================================================================================================================================
            $sales_date_str = strtotime($_POST['sales_date']);
            $sales_date_str = date("F d, Y",$sales_date_str);

            $data['buDeptName']=$_POST['bname'].'&nbsp;/&nbsp;'.$_POST['dname'] ;                        
            $data['sales_date']=$sales_date_str;               
            $data['html']=$html;              
            echo json_encode($data);
        }
    }

    public function view_variance_navcls_ctrl_v3()
    {
        if(empty($_SESSION['emp_id']))
		{
			$message = "EXPIRED SESSION";
			echo json_encode($message);
		}
		else
        {
            $other_noncash_mop_array = array();
            $default_noncash_mop = array('Cards','Internal GC','CRM Redeem','ATP','Employee\'s Credit','PO Card','PO','IHCC');
            $cls_other_noncash = $this->accounting_model->get_cls_other_noncash_mop_model($_POST['sales_date'],$_POST['dcode'],$default_noncash_mop);
            foreach($cls_other_noncash as $cls_mop)
            {
                if(!in_array($cls_mop['mop_name'], $other_noncash_mop_array))
                { 
                    array_push($other_noncash_mop_array, $cls_mop['mop_name']);
                }
            }
            // ======================================================================================================================================
            $store_no_array = explode("|", $_POST['store_no']);
            $nav_mop_data = $this->accounting_model->get_nav_mop_model_v2($_POST['sales_date'],$store_no_array,$_POST['dcode']);
            $mop_bcode = substr($_POST['dcode'], 0, -2);
            $mop_name_array = array();
            foreach($nav_mop_data as $mop)
            {
                $mop_data = $this->accounting_model->get_mop_name_model($mop['tender_type'],$mop_bcode);
                if(!empty($mop_data))
                {
                    array_push($mop_name_array, $mop_data->mop_name);
                }
            }
            // ======================================================================================================================================
            $cls_mop_data = $this->accounting_model->get_cls_mop_model($_POST['sales_date'],$_POST['dcode']);
            foreach($cls_mop_data as $mop)
            {
                if(!in_array($mop['mop_name'], $mop_name_array))
                {
                    array_push($mop_name_array, $mop['mop_name']);
                }
            }
            sort($mop_name_array);
            $mop_html_array = array();
            for($a=0; $a<count($mop_name_array); $a++)
            {
                $mop_name_data = $this->accounting_model->get_mop_code_model($mop_name_array[$a],$mop_bcode);
                if(!empty($mop_name_data))
                {
                    array_push($mop_html_array, '<option value="'.$mop_name_data->mop_code.'">'.$mop_name_array[$a].'</option>');
                }
            }
            array_push($mop_html_array, '<option value="total_var">TOTAL VARIANCE</option>');
            $mop_html_array = implode("", $mop_html_array);
            // ======================================================================================================================================
            $cash_colspan = 7;
            $nav_colspan = 3;
            $cash_wholesale_th_html = '';
            $cash_wholesale_data = $this->accounting_model->validate_cash_wholesale_model($_POST['sales_date'],$store_no_array,$_POST['dcode']);
            if(!is_null($cash_wholesale_data->cash_wholesale))
            {
                $cash_colspan = 8;
                $nav_colspan = 4;
                $cash_wholesale_th_html = '<th style="vertical-align: middle;" scope="col"><center>CASH<br>WHOLESALE</center></th>';
            }
            // ======================================================================================================================================
            $nav_other_noncash = $this->accounting_model->get_nav_other_noncash_mop_model_v2($_POST['sales_date'],$store_no_array,$_POST['dcode']);
            $header_store = '';
            $header_tenderTypeName = '';
            foreach($nav_other_noncash as $nav_mop)
            {
                $header_store = explode('-', $_POST['store_no']);
                if($header_store[0] == 'ICM')
                {
                    $icm_tenderTypeName = $this->accounting_model->get_icm_tender_name_model_v2($nav_mop['tender_type']);
                    if(!empty($icm_tenderTypeName))
                    {
                        $header_tenderTypeName = $icm_tenderTypeName->mop_name;
                    }
                }
                else if($header_store[0] == 'ASC')
                {
                    $asc_tenderTypeName = $this->accounting_model->get_asc_tender_name_model_v2($nav_mop['tender_type']);
                    if(!empty($asc_tenderTypeName))
                    {
                        $header_tenderTypeName = $asc_tenderTypeName->mop_name;
                    }
                }
                else if($header_store[0] == 'PM')
                {
                    $pm_tenderTypeName = $this->accounting_model->get_pm_tender_name_model_v2($nav_mop['tender_type']);
                    if(!empty($pm_tenderTypeName))
                    {
                        $header_tenderTypeName = $pm_tenderTypeName->mop_name;
                    }
                }
                if(!in_array($header_tenderTypeName, $other_noncash_mop_array))
                { 
                    array_push($other_noncash_mop_array, $header_tenderTypeName);
                }
            }
            // ==========================================================================================================================
            sort($other_noncash_mop_array);
            $additional_header_html = array();
            $additional_sub_header_html = array();
            for($i=0; $i<count($other_noncash_mop_array); $i++) 
            {
                array_push($additional_header_html, '<th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                                        <center>'.$other_noncash_mop_array[$i].'</center>
                                                    </th>');
                // ========================================================================================================================
                array_push($additional_sub_header_html, '<th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                                        <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                                        <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>');
            }
            $additional_header_html = implode("",$additional_header_html);
            $additional_sub_header_html = implode("",$additional_sub_header_html);
            // =========================================================================================================================
            $html='
                    <table class="table table-bordered table-hover table-condensed display tablesorter" id="navcls_variance_table">
                        <thead>
                            <tr>                                                          
                                <th style="vertical-align: middle;" rowspan="3">
                                    <center>CASHIER\'S NAME</center>
                                </th>                                                      
                                <th style="vertical-align: middle;" rowspan="3">
                                    <center>LOCATION</center>
                                </th>
                                <th style="vertical-align: middle;" colspan="2" scope="colgroup">
                                    <center>TERMINAL NO.</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="'.$cash_colspan.'" scope="colgroup">
                                    <center>CASH</center>
                                </th>      
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>COMMERCIAL CARD\'S</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>INTERNAL GIFT CHECK</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>CRM Redeem</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>A.T.P</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>EMPLOYEE\'S CREDIT</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>PO CARD</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>IHCC</center>
                                </th>   
                                '.$additional_header_html.'
                                <th style="vertical-align: middle;" colspan="2" scope="colgroup">
                                    <center>TOTAL</center>
                                </th>   
                                <th style="vertical-align: middle;" rowspan="3">
                                    <center>VARIANCE</center>
                                </th>   
                                <th style="vertical-align: middle;" rowspan="3">
                                    <center>ACTION</center>
                                </th>                 
                            </tr>
                            <tr style="border-top: outset;">
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup"><center>CLS</center></th>
                                <th style="vertical-align: middle;" colspan="'.$nav_colspan.'" scope="colgroup"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                '.$additional_sub_header_html.'
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle; border-right: 1px solid;" scope="col" rowspan="2"><center>NAV</center></th>
                            </tr>
                            <tr style="border-top: outset;">
                                <th style="vertical-align: middle;" scope="col"><center>PARTIAL</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>FINAL</center></th>
                                <th style="vertical-align: middle; border-right: solid 1px;" scope="col"><center>TOTAL</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>PARTIAL</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>FINAL</center></th>
                                '.$cash_wholesale_th_html.'
                                <th style="vertical-align: middle; border-right: solid 1px;" scope="col"><center>TOTAL</center></th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 12px;">
                    ';
            // ============================================================================================================================================
            $nav_data = $this->accounting_model->get_uploaded_navdata_model_v2($_POST['sales_date'],$store_no_array);
            $terminal_counter_no = '';
            $bcode = '';
            $dcode = '';
            $staff_name = '';
            $staff_id = '';
            $net_amount = 0;
            $net_amount2 = 0;
            $nav_total_amount = 0;
            $nav_cash = 0;
            $nav_cash2 = 0;
            $nav_cash3 = 0;
            $nav_bankcard = 0;
            $nav_bankcard2 = 0;
            $nav_bankcard3 = 0;
            $nav_giftcheck = 0;
            $nav_giftcheck2 = 0;
            $nav_giftcheck3 = 0;
            $nav_partialcash = 0;
            $nav_partialcash2 = 0;
            $nav_crmredeem = 0;
            $nav_crmredeem2 = 0;
            $nav_atp = 0;
            $nav_atp2 = 0;
            $nav_emp_chargeCredit = 0;
            $nav_emp_chargeCredit2 = 0;
            $nav_po = 0;
            $nav_po2 = 0;
            $nav_ihcc = 0;
            $nav_ihcc2 = 0;
            $nav_otherpayment = 0;
            $nav_otherpayment2 = 0;
            $total_nav_cash_wholesale = 0;
            // =================================================================================
            $cls_finalcash2 = 0;
            $cls_bankcard2 = 0;
            $cls_giftcheck2 = 0;
            $cls_partialcash2 = 0;
            $cls_crmredeem2 = 0;
            $cls_atp2 = 0;
            $cls_empcredit2 = 0;
            $cls_po2 = 0;
            $cls_ihcc2 = 0;
            $cls_otherpayment2 = 0;
            $cls_netAmount2 = 0;
            $cls_netAmount3 = 0;
            foreach($nav_data as $nav)
            {
                $staff_terminal_counter = $this->accounting_model->get_staff_terminal_counter_model($_POST['sales_date'],$nav['staff_id']);
                $store_no = '';
                $terminal_amount = '';
                $pos_terminal_no = array();
                foreach($staff_terminal_counter as $tcno)
                {
                    $store_no = $tcno['store_no'];
                    $terminal_counter_amount = $this->accounting_model->get_terminal_counter_amount_model($_POST['sales_date'],$nav['staff_id'],$tcno['pos_terminal_no']);
                    $terminal_amount = number_format($terminal_counter_amount, 2);
                    array_push($pos_terminal_no, $tcno['pos_terminal_no'].' | '.$terminal_amount.'<br>');
                }
                // ==============================================================================================================================================
                $staff_info = $this->accounting_model->get_staff_info_model($nav['staff_id']);
                $staff_emp_id = '';
                if(empty($staff_info))
                {
                    $staff_id = $nav['staff_id'] * 1;
                    $staff_info2 = $this->accounting_model->get_staff_info_model($staff_id);
                    if(!empty($staff_info2))
                    {
                        $staff_name = $staff_info2->name;
                        $staff_emp_id = $staff_info2->emp_id;
                    }
                }
                else
                {
                    $staff_name = $staff_info->name;
                    $staff_emp_id = $staff_info->emp_id;
                }
                // ==============================================================================================================================================
                $staff_net_amount = $this->accounting_model->get_staff_net_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id']);
                if(!empty($staff_net_amount))
                {
                    $net_amount2 = $staff_net_amount->amount;
                    $net_amount = $staff_net_amount->amount;
                    $nav_total_amount += $staff_net_amount->amount;
                }
                // ==============================================================================================================================================
                $navcash_tender_type = $this->accounting_model->get_nav_cash_amount_model($_POST['sales_date'],$store_no_array,$nav['staff_id']);
                if(!empty($navcash_tender_type))
                {
                    $nav_cash3 = $navcash_tender_type->type_amount;
                    $nav_cash2 += $navcash_tender_type->type_amount;
                    $nav_cash = $navcash_tender_type->type_amount;
                }
                // ==============================================================================================================================================
                $nav_bankcard_tender_type = $this->accounting_model->get_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],3);
                if(!empty($nav_bankcard_tender_type))
                {
                    $nav_bankcard3 += $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard2 = $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard = $nav_bankcard_tender_type->type_amount;
                }
                // ==============================================================================================================================================
                $nav_giftcheck_tender_type = $this->accounting_model->get_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],35);
                if(!empty($nav_giftcheck_tender_type))
                {
                    $nav_giftcheck3 = $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck2 += $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck = $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck = number_format($nav_giftcheck, 2);
                }
                // ==============================================================================================================================================
                $nav_partialcash_tender_type = $this->accounting_model->get_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],9);
                if(!empty($nav_partialcash_tender_type))
                {
                    $nav_partialcash3 = $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash2 += $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash = $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash = number_format($nav_partialcash, 2);
                }
                // ==============================================================================================================================================
                $nav_crmredeem_tender_type = $this->accounting_model->get_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],28);
                if(!empty($nav_crmredeem_tender_type))
                {
                    $nav_crmredeem2 += $nav_crmredeem_tender_type->type_amount;
                    $nav_crmredeem = $nav_crmredeem_tender_type->type_amount;
                }
                // ==============================================================================================================================================
                $nav_atp_tender_type = $this->accounting_model->get_atp_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id']);
                if(!empty($nav_atp_tender_type))
                {
                    $nav_atp2 += $nav_atp_tender_type->type_amount;
                    $nav_atp = $nav_atp_tender_type->type_amount;
                }
                // ==============================================================================================================================================
                $nav_emp_chargeCredit_tender_type = $this->accounting_model->get_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],36);
                if(!empty($nav_emp_chargeCredit_tender_type))
                {
                    $nav_emp_chargeCredit2 += $nav_emp_chargeCredit_tender_type->type_amount;
                    $nav_emp_chargeCredit = $nav_emp_chargeCredit_tender_type->type_amount;
                }
                // ==============================================================================================================================================
                $nav_po_tender_type = $this->accounting_model->get_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],14);
                if(!empty($nav_po_tender_type))
                {
                    $nav_po2 += $nav_po_tender_type->type_amount;
                    $nav_po = $nav_po_tender_type->type_amount;
                }
                // ==============================================================================================================================================
                $nav_ihcc_tender_type = $this->accounting_model->get_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],15);
                if(!empty($nav_ihcc_tender_type))
                {
                    $nav_ihcc2 += $nav_ihcc_tender_type->type_amount;
                    $nav_ihcc = $nav_ihcc_tender_type->type_amount;
                }
                // ==============================================================================================================================================
                $nav_otherpayment_tender_type = $this->accounting_model->get_otherpayment_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id']);
                if(!empty($nav_otherpayment_tender_type))
                {
                    $nav_otherpayment2 += $nav_otherpayment_tender_type->type_amount;
                    $nav_otherpayment = $nav_otherpayment_tender_type->type_amount;
                    $nav_otherpayment = number_format($nav_otherpayment, 2);
                }
                $nav_other_tender_type = $this->accounting_model->get_other_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id']);
                $paymentTypeAndAmount = '';
                $br = '';
                if(!empty($nav_other_tender_type))
                {
                    $nav_othertype_array = array();
                    $nav_othertype = '';
                    $store = '';
                    $tenderTypeName = '';
                    foreach($nav_other_tender_type as $othertype)
                    {
                        $store = explode('-', $_POST['store_no']);
                        if($store[0] == 'ICM')
                        {
                            $icm_tenderTypeName = $this->accounting_model->get_icm_tender_name_model_v2($othertype['other_type']);
                            if(!empty($icm_tenderTypeName))
                            {
                                $tenderTypeName = $icm_tenderTypeName->mop_name;
                            }
                        }
                        else if($store[0] == 'ASC')
                        {
                            $asc_tenderTypeName = $this->accounting_model->get_asc_tender_name_model_v2($othertype['other_type']);
                            if(!empty($asc_tenderTypeName))
                            {
                                $tenderTypeName = $asc_tenderTypeName->mop_name;
                            }
                        }
                        else if($store[0] == 'PM')
                        {
                            $pm_tenderTypeName = $this->accounting_model->get_pm_tender_name_model_v2($othertype['other_type']);
                            if(!empty($pm_tenderTypeName))
                            {
                                $tenderTypeName = $pm_tenderTypeName->mop_name;
                            }
                        }

                        $nav_othertype_data = $this->accounting_model->get_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],$othertype['other_type']);
                        $nav_othertype = $nav_othertype_data->type_amount;
                        if($nav_othertype > 0)
                        {
                            $nav_othertype = $tenderTypeName.'|'.$nav_othertype;
                            array_push($nav_othertype_array, $nav_othertype);
                        }
                    }

                    if(!empty($nav_othertype_array))
                    {
                        $br = '<br>';
                        $paymentTypeAndAmount = implode('<br>', $nav_othertype_array);
                        $paymentTypeAndAmount = '('.$paymentTypeAndAmount.')';
                    }
                }
                // ===================================================================================================================================================
                $bu_data = $this->accounting_model->get_bcode_model($_POST['bname']);
                if(!empty($bu_data))
                {
                    $bcode = $bu_data->bcode;
                }
                $dept_data = $this->accounting_model->get_dcode_model($bcode,$_POST['dname']);
                if(!empty($dept_data))
                {
                    $dcode = $dept_data->dcode;
                }
                $cebo_cs_denomination_data = $this->accounting_model->get_cebo_cs_denomination_model_v2($staff_emp_id,$_POST['sales_date'],$dcode);
                $tr_no_array = array(); 
                $cls_netAmount = 0;
                $cls_discount = 0;
                foreach($cebo_cs_denomination_data as $data)
                {
                    if(!in_array($data['tr_no'], $tr_no_array))
                    {  
                        array_push($tr_no_array, $data['tr_no']);
                    }
                    $cls_netAmount += $data['total'] + $data['discount'];
                    $cls_netAmount3 += $data['total'] + $data['discount'];
                    $cls_discount += $data['discount'];
                }
                // ===============================================================================================
                $cls_terminal_no_array = array();
                $cls_location_array = array();
                $cls_bankcard = 0;
                $cls_giftcheck = 0;
                $cls_crmredeem = 0;
                $cls_atp = 0;
                $cls_empcredit = 0;
                $cls_po = 0;
                $cls_ihcc = 0;
                $cls_finalcash = 0;
                $cls_partialcash = 0;
                $cls_otherpayment_total = 0;
                $netAmount_variance = 0;
                $additional_body_html = array();
                if(!empty($tr_no_array))
                {
                    $cash_noncash_terminal_no_array = array();
                    $cls_cash_terminal_no = $this->accounting_model->get_cls_cash_terminal_no_model($tr_no_array,$staff_emp_id);
                    foreach($cls_cash_terminal_no as $cash)
                    {
                        if(!in_array($cash['tr_no'].'|'.$cash['pos_name'], $cash_noncash_terminal_no_array))
                        {  
                            array_push($cash_noncash_terminal_no_array, $cash['tr_no'].'|'.$cash['pos_name']);
                        }
                        // ========================================================================================
                        if(!in_array($cash['location'], $cls_location_array))
                        {  
                            array_push($cls_location_array, $cash['location']);
                        }
                    }
                    // ========================================================================================================================
                    $cls_noncash_terminal_no = $this->accounting_model->get_cls_noncash_terminal_no_model($tr_no_array,$staff_emp_id);
                    foreach($cls_noncash_terminal_no as $noncash)
                    {
                        if(!in_array($noncash['tr_no'].'|'.$noncash['pos_name'], $cash_noncash_terminal_no_array))
                        {  
                            array_push($cash_noncash_terminal_no_array, $noncash['tr_no'].'|'.$noncash['pos_name']);
                        }
                        // ========================================================================================
                        if(!in_array($noncash['location'], $cls_location_array))
                        {  
                            array_push($cls_location_array, $noncash['location']);
                        }
                    }
                    // ========================================================================================================================
                    for($a=0; $a<count($cash_noncash_terminal_no_array); $a++) 
                    {
                        $trno_pos = explode('|',$cash_noncash_terminal_no_array[$a]);
                        $pos_cash_discount = $this->accounting_model->get_pos_cash_discount_model($trno_pos[0],$staff_emp_id);
                        $pos_discount = 0;
                        if(!empty($pos_cash_discount))
                        {
                            $pos_discount = $pos_cash_discount->discount;
                        }
                        // ====================================================================================================================================
                        $cls_cash_terminal_no_total = $this->accounting_model->get_cls_cash_terminal_no_total_model($tr_no_array,$staff_emp_id,$trno_pos[1]);
                        // ====================================================================================================================================
                        $cls_noncash_terminal_no_total = $this->accounting_model->get_cls_noncash_terminal_no_total_model($tr_no_array,$staff_emp_id,$trno_pos[1]);
                        // ====================================================================================================================================
                        $cls_terminal_no_and_total = $cls_cash_terminal_no_total + $cls_noncash_terminal_no_total + $pos_discount;
                        $cls_terminal_no_and_total = number_format($cls_terminal_no_and_total, 2);
                        if(!in_array($trno_pos[1].' | '.$cls_terminal_no_and_total.'<br>', $cls_terminal_no_array))
                        {  
                            array_push($cls_terminal_no_array, $trno_pos[1].' | '.$cls_terminal_no_and_total.'<br>');
                        }
                    }
                    // ========================================================================================================================
                    $final_cash = $this->accounting_model->get_final_cash_model($tr_no_array,$staff_emp_id);
                    if(!empty($final_cash))
                    {
                        $cls_finalcash = $final_cash->total + $cls_discount;
                        $cls_finalcash2 += $final_cash->total + $cls_discount;
                    }
                    $partial_cash = $this->accounting_model->get_partial_cash_model($tr_no_array,$staff_emp_id);
                    if(!empty($partial_cash))
                    {
                        $cls_partialcash = $partial_cash->total;
                        $cls_partialcash2 += $partial_cash->total;
                    }
                    $cls_cashier_noncash_data = $this->accounting_model->get_cs_cashier_noncashden_model($tr_no_array,$staff_emp_id);
                    foreach($cls_cashier_noncash_data as $noncash)
                    {
                        if($noncash['mop_name'] == 'Cards')
                        {
                            $cls_bankcard2 += $noncash['noncash_amount'];
                            $cls_bankcard += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'Internal GC')
                        {
                            $cls_giftcheck2 += $noncash['noncash_amount'];
                            $cls_giftcheck += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'CRM Redeem')
                        {
                            $cls_crmredeem2 += $noncash['noncash_amount'];
                            $cls_crmredeem += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'ATP')
                        {
                            $cls_atp2 += $noncash['noncash_amount'];
                            $cls_atp += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'Employee\'s Credit')
                        {
                            $cls_empcredit2 += $noncash['noncash_amount'];
                            $cls_empcredit += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'PO Card' || $noncash['mop_name'] == 'PO')
                        {
                            $cls_po2 += $noncash['noncash_amount'];
                            $cls_po += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'IHCC')
                        {
                            $cls_ihcc2 += $noncash['noncash_amount'];
                            $cls_ihcc += $noncash['noncash_amount'];
                        }
                    }
                    // ================================================================================================================================================
                    $body_store = '';
                    $body_tenderType = '';
                    for($a=0; $a<count($other_noncash_mop_array); $a++) 
                    {
                        $cls_other_mop_data = $this->accounting_model->get_cls_other_mop_model($tr_no_array,$staff_emp_id,$other_noncash_mop_array[$a]);
                        $cls_other_mop_amount = 0;
                        if(!empty($cls_other_mop_data))
                        {
                            $cls_other_mop_amount = $cls_other_mop_data->amount;
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">'.number_format($cls_other_mop_data->amount, 2).'</td>');
                        }
                        else
                        {
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">0.00</td>');
                        }
                        // ==============================================================================================================================================
                        $body_store = explode('-', $_POST['store_no']);
                        $nav_tender_code = '';
                        if($body_store[0] == 'ICM')
                        {
                            $icm_tenderTypeName = $this->accounting_model->get_icm_tender_code_model_v2($other_noncash_mop_array[$a]);
                            if(!empty($icm_tenderTypeName))
                            {
                                $nav_tender_code = $icm_tenderTypeName->mop_code;
                            }
                        }
                        else if($body_store[0] == 'ASC')
                        {
                            $asc_tenderTypeName = $this->accounting_model->get_asc_tender_code_model_v2($other_noncash_mop_array[$a]);
                            if(!empty($asc_tenderTypeName))
                            {
                                $nav_tender_code = $asc_tenderTypeName->mop_code;
                            }
                        }
                        else if($body_store[0] == 'PM')
                        {
                            $pm_tenderTypeName = $this->accounting_model->get_pm_tender_code_model_v2($other_noncash_mop_array[$a]);
                            if(!empty($pm_tenderTypeName))
                            {
                                $nav_tender_code = $pm_tenderTypeName->mop_code;
                            }
                        }
                        // ===========================================================================================================================================
                        $nav_other_mop_data = $this->accounting_model->get_nav_other_mop_amount_model_v3($_POST['sales_date'],$store_no_array,$nav['staff_id'],$nav_tender_code);
                        $nav_other_mop_amount = 0;
                        if(!empty($nav_other_mop_data->amount))
                        {
                            $nav_other_mop_amount = $nav_other_mop_data->amount;
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">'.number_format($nav_other_mop_data->amount, 2).'</td>');
                            // ========================================================================================================================================
                            $variance_other_mop_amount = bcsub($cls_other_mop_amount, $nav_other_mop_amount, 4);
                            if($variance_other_mop_amount < 0)
                            {
                                $variance_other_mop_amount = preg_replace('/-/', "", $variance_other_mop_amount);
                                $variance_other_mop_amount = '('.number_format($variance_other_mop_amount, 2).')';
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: red;">'.$variance_other_mop_amount.'</td>');
                            }
                            else
                            {
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: green;">'.number_format($variance_other_mop_amount, 2).'</td>');
                            }
                        }
                        else
                        {
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">0.00</td>');
                            // ========================================================================================================================================
                            $variance_other_mop_amount = bcsub($cls_other_mop_amount, $nav_other_mop_amount, 4);
                            if($variance_other_mop_amount < 0)
                            {
                                $variance_other_mop_amount = preg_replace('/-/', "", $variance_other_mop_amount);
                                $variance_other_mop_amount = '('.number_format($variance_other_mop_amount, 2).')';
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: red;">'.$variance_other_mop_amount.'</td>');
                            }
                            else
                            {
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: green;">'.number_format($variance_other_mop_amount, 2).'</td>');
                            }
                        }
                    }
                }
                else
                {
                    $body_store = '';
                    $body_tenderType = '';
                    for($a=0; $a<count($other_noncash_mop_array); $a++) 
                    {
                        $body_store = explode('-', $_POST['store_no']);
                        $nav_tender_code = '';
                        if($body_store[0] == 'ICM')
                        {
                            $icm_tenderTypeName = $this->accounting_model->get_icm_tender_code_model_v2($other_noncash_mop_array[$a]);
                            if(!empty($icm_tenderTypeName))
                            {
                                $nav_tender_code = $icm_tenderTypeName->mop_code;
                            }
                        }
                        else if($body_store[0] == 'ASC')
                        {
                            $asc_tenderTypeName = $this->accounting_model->get_asc_tender_code_model_v2($other_noncash_mop_array[$a]);
                            if(!empty($asc_tenderTypeName))
                            {
                                $nav_tender_code = $asc_tenderTypeName->mop_code;
                            }
                        }
                        else if($body_store[0] == 'PM')
                        {
                            $pm_tenderTypeName = $this->accounting_model->get_pm_tender_code_model_v2($other_noncash_mop_array[$a]);
                            if(!empty($pm_tenderTypeName))
                            {
                                $nav_tender_code = $pm_tenderTypeName->mop_code;
                            }
                        }
                        // ===========================================================================================================================================
                        $nav_other_mop_data = $this->accounting_model->get_nav_other_mop_amount_model_v3($_POST['sales_date'],$store_no_array,$nav['staff_id'],$nav_tender_code);
                        $cls_other_mop_amount = 0;
                        $nav_other_mop_amount = 0;
                        if(!empty($nav_other_mop_data->amount))
                        {
                            $nav_other_mop_amount = $nav_other_mop_data->amount;
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">0.00</td>
                                                                <td style="vertical-align: middle; text-align: center;">'.number_format($nav_other_mop_data->amount, 2).'</td>');
                            // =======================================================================================================================================
                            $variance_other_mop_amount = $cls_other_mop_amount - $nav_other_mop_amount;
                            if($variance_other_mop_amount < 0)
                            {
                                $variance_other_mop_amount = preg_replace('/-/', "", $variance_other_mop_amount);
                                $variance_other_mop_amount = '('.number_format($variance_other_mop_amount, 2).')';
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: red;">'.$variance_other_mop_amount.'</td>');
                            }
                            else
                            {
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: green;">'.number_format($variance_other_mop_amount, 2).'</td>');
                            }
                        }
                        else
                        {
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">0.00</td>
                                                               <td style="vertical-align: middle; text-align: center;">0.00</td>');
                            // =======================================================================================================================================
                            $variance_other_mop_amount = $cls_other_mop_amount - $nav_other_mop_amount;
                            if($variance_other_mop_amount < 0)
                            {
                                $variance_other_mop_amount = preg_replace('/-/', "", $variance_other_mop_amount);
                                $variance_other_mop_amount = '('.number_format($variance_other_mop_amount, 2).')';
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: red;">'.$variance_other_mop_amount.'</td>');
                            }
                            else
                            {
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: green;">'.number_format($variance_other_mop_amount, 2).'</td>');
                            }
                        }
                    }
                }
                // ==================================================================================================================================================
                $cls_terminal_no_array = implode("", $cls_terminal_no_array);
                $cls_terminal_no_array = substr_replace($cls_terminal_no_array ,"",-4);
                $cls_terminal_no_array = $cls_terminal_no_array;
                // ==================================================================================================================================================
                $terminal_counter_no = implode("", $pos_terminal_no);
                $terminal_counter_no = substr_replace($terminal_counter_no ,"",-4);
                $terminal_counter_no = $terminal_counter_no;
                // ===================================================================================================================================================
                $location_array = array();
                for($a=0; $a<count($cls_location_array); $a++)
                {
                    $code_length = strlen($cls_location_array[$a]);
                    if($code_length == 10)
                    {
                        $ss_data = $this->accounting_model->get_ssname_model($cls_location_array[$a]);
                        if(!empty($ss_data))
                        {
                            array_push($location_array, $ss_data->sub_section_name.'<br>');
                        }
                    }
                    else if($code_length == 8)
                    {
                        $s_data = $this->accounting_model->get_sname_model($cls_location_array[$a]);
                        if(!empty($s_data))
                        {
                            array_push($location_array, $s_data->section_name.'<br>');
                        }
                    }
                    else if($code_length == 6)
                    {
                        $d_data = $this->accounting_model->get_dname_model($cls_location_array[$a]);
                        if(!empty($d_data))
                        {
                            array_push($location_array, $d_data->dept_name.'<br>');
                        }
                    }
                }
                $location_array = implode("", $location_array);
                $location_array = substr_replace($location_array, "", -4);
                // ===================================================================================================================================================
                $variance_color = 'color: green;';
                $cls_total_cash = $cls_partialcash + $cls_finalcash;
                $nav_total_cash = $nav_partialcash3 + $nav_cash3;
                $cash_variance = bcsub($cls_total_cash, $nav_total_cash, 4);
                if($cash_variance < 0)
                {
                    $variance_color = 'color: red;';
                    $cash_variance = preg_replace('/-/', "", $cash_variance);
                    $cash_variance = '('.number_format($cash_variance, 2).')';
                }
                else
                {
                    $cash_variance = number_format($cash_variance, 2);
                }

                $cls_partialcash = number_format($cls_partialcash, 2);
                $cls_finalcash = number_format($cls_finalcash, 2);
                $cls_total_cash = number_format($cls_total_cash, 2);
                $nav_total_cash = number_format($nav_total_cash, 2);
                // ==================================================================================================================
                $bc_variance_color = 'color: green;';
                $nav_bankcard = floatval($nav_bankcard);
                $bc_variance = bcsub($cls_bankcard, $nav_bankcard, 4); 
                if($bc_variance < 0)
                {
                    $bc_variance_color = 'color: red;';
                    $bc_variance = preg_replace('/-/', "", $bc_variance);
                    $bc_variance = '('.number_format($bc_variance, 2).')';
                }
                else
                {
                    $bc_variance = number_format($bc_variance, 2);
                }
                $nav_bankcard = number_format($nav_bankcard, 2);
                $cls_bankcard = number_format($cls_bankcard, 2);
                // ==================================================================================================================
                $gc_variance_color = 'color: green;';
                $nav_giftcheck3 = floatval($nav_giftcheck3);
                $giftcheck_variance = bcsub($cls_giftcheck, $nav_giftcheck3, 4); 
                if($giftcheck_variance < 0)
                {
                    $gc_variance_color = 'color: red;';
                    $giftcheck_variance = preg_replace('/-/', "", $giftcheck_variance);
                    $giftcheck_variance = '('.number_format($giftcheck_variance, 2).')';
                }
                else
                {
                    $giftcheck_variance = number_format($giftcheck_variance, 2);
                }
                $cls_giftcheck = number_format($cls_giftcheck, 2);
                // ========================================================================================================================
                $crmredeem_variance_color = 'color: green;';
                $nav_crmredeem = floatval($nav_crmredeem);
                $crmredeem_variance = bcsub($cls_crmredeem, $nav_crmredeem, 4); 
                if($crmredeem_variance < 0)
                {
                    $crmredeem_variance_color = 'color: red;';
                    $crmredeem_variance = preg_replace('/-/', "", $crmredeem_variance);
                    $crmredeem_variance = '('.number_format($crmredeem_variance, 2).')';
                }
                else
                {
                    $crmredeem_variance = number_format($crmredeem_variance, 2);
                }
                $nav_crmredeem = number_format($nav_crmredeem, 2);
                $cls_crmredeem = number_format($cls_crmredeem, 2);
                // ========================================================================================================================
                $atp_variance_color = 'color: green;';
                $nav_atp = floatval($nav_atp);
                $atp_variance = bcsub($cls_atp, $nav_atp, 4); 
                if($atp_variance < 0)
                {
                    $atp_variance_color = 'color: red;';
                    $atp_variance = preg_replace('/-/', "", $atp_variance);
                    $atp_variance = '('.number_format($atp_variance, 2).')';
                }
                else
                {
                    $atp_variance = number_format($atp_variance, 2);
                }
                $cls_atp = number_format($cls_atp, 2);
                $nav_atp = number_format($nav_atp, 2);
                // ========================================================================================================================
                $empcredit_variance_color = 'color: green;';
                $nav_emp_chargeCredit = floatval($nav_emp_chargeCredit);
                $empcredit_variance = bcsub($cls_empcredit, $nav_emp_chargeCredit, 4); 
                if($empcredit_variance < 0)
                {
                    $empcredit_variance_color = 'color: red;';
                    $empcredit_variance = preg_replace('/-/', "", $empcredit_variance);
                    $empcredit_variance = '('.number_format($empcredit_variance, 2).')';
                }
                else
                {
                    $empcredit_variance = number_format($empcredit_variance, 2);
                }
                $cls_empcredit = number_format($cls_empcredit, 2);
                $nav_emp_chargeCredit = number_format($nav_emp_chargeCredit, 2);
                // ========================================================================================================================
                $po_variance_color = 'color: green;';
                $nav_po = floatval($nav_po);
                $po_variance = bcsub($cls_po, $nav_po, 4); 
                if($po_variance < 0)
                {
                    $po_variance_color = 'color: red;';
                    $po_variance = preg_replace('/-/', "", $po_variance);
                    $po_variance = '('.number_format($po_variance, 2).')';
                }
                else
                {
                    $po_variance = number_format($po_variance, 2);
                }
                $cls_po = number_format($cls_po, 2);
                $nav_po = number_format($nav_po, 2);
                // ========================================================================================================================
                $ihcc_variance_color = 'color: green;';
                $nav_ihcc = floatval($nav_ihcc);
                $ihcc_variance = bcsub($cls_ihcc, $nav_ihcc, 4);
                if($ihcc_variance < 0)
                {
                    $ihcc_variance_color = 'color: red;';
                    $ihcc_variance = preg_replace('/-/', "", $ihcc_variance);
                    $ihcc_variance = '('.number_format($ihcc_variance, 2).')';
                }
                else
                {
                    $ihcc_variance = number_format($ihcc_variance, 2);
                }
                $cls_ihcc = number_format($cls_ihcc, 2);
                $nav_ihcc = number_format($nav_ihcc, 2);
                // ========================================================================================================================
                $total_variance_color = 'color: green;';
                $net_amount = floatval($net_amount);
                $total_variance = bcsub($cls_netAmount, $net_amount, 4);
                if($total_variance < 0)
                {
                    $total_variance_color = 'color: red;';
                    $total_variance = preg_replace('/-/', "", $total_variance);
                    $total_variance = '('.number_format($total_variance, 2).')';
                }
                else
                {
                    $total_variance = number_format($total_variance, 2);
                }
                $cls_netAmount = number_format($cls_netAmount, 2);
                $net_amount = number_format($net_amount, 2);
                // ========================================================================================================================
                $additional_body_html = implode("",$additional_body_html);
                // ========================================================================================================================
                $cash_wholesale_td_html = '';
                if($nav_colspan == 4)
                {
                    $cash_wholesale_data = $this->accounting_model->get_cash_wholesale_amount_model($_POST['sales_date'],$store_no_array,$_POST['dcode'],$nav['staff_id']);
                    $nav_cash_wholesale = 0;
                    if(!is_null($cash_wholesale_data->cash_wholesale))
                    {
                        $nav_cash_wholesale = $cash_wholesale_data->cash_wholesale;
                        $nav_cash = bcsub($nav_cash, $nav_cash_wholesale, 4);
                        $total_nav_cash_wholesale += $cash_wholesale_data->cash_wholesale;
                    }
                    $cash_wholesale_td_html = '<td style="vertical-align: middle; text-align: center;">'.number_format($nav_cash_wholesale, 2).'</td>';
                }
                // ========================================================================================================================
                $html.=' 
                        <tr style="word-wrap:break-word;">
                            <td style="vertical-align: middle; text-align: left;">'.$staff_name.'</td>
                            <td style="vertical-align: middle; text-align: left;">'.$location_array.'</td>
                            <td style="vertical-align: middle; text-align: center; white-space:nowrap;">'.$cls_terminal_no_array.'</td>
                            <td style="vertical-align: middle; text-align: center; white-space:nowrap;">'.$terminal_counter_no.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_partialcash.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_finalcash.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_total_cash.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_partialcash.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.number_format($nav_cash, 2).'</td>
                            '.$cash_wholesale_td_html.'
                            <td style="vertical-align: middle; text-align: center;">'.$nav_total_cash.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$variance_color.'">'.$cash_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_bankcard.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_bankcard.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$bc_variance_color.'">'.$bc_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_giftcheck.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_giftcheck.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$gc_variance_color.'">'.$giftcheck_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_crmredeem.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_crmredeem.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$crmredeem_variance_color.'">'.$crmredeem_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_atp.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_atp.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$atp_variance_color.'">'.$atp_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_empcredit.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_emp_chargeCredit.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$empcredit_variance_color.'">'.$empcredit_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_po.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_po.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$po_variance_color.'">'.$po_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_ihcc.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$nav_ihcc.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$ihcc_variance_color.'">'.$ihcc_variance.'</td>
                            '.$additional_body_html.'
                            <td style="vertical-align: middle; text-align: center;">'.$cls_netAmount.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$net_amount.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$total_variance_color.'">'.$total_variance.'</td>
                            <td class="action" style="vertical-align: middle; text-align: center;">
                                <button type="button" class="btn" style="background-color: antiquewhite;" onclick="adjustment_js('."'".$_POST['sales_date']."','".$nav['staff_id']."'".')">✏️</button>
                            </td>
                        </tr>
                        '; 
            }
            // =============================================================================================================================================
            $additional_footer_html = array(); 
            $footer_store = '';
            for($b=0; $b<count($other_noncash_mop_array); $b++) 
            {
                $cls_other_noncash = $this->accounting_model->get_cls_other_noncash_total_model($_POST['sales_date'],$_POST['dcode'],$other_noncash_mop_array[$b]);
                $cls_other_mop_total = 0;
                if(!empty($cls_other_noncash))
                {
                    $cls_other_mop_total = $cls_other_noncash;
                }
                // ===========================================================================================================================================
                $footer_tenderType = '';
                $footer_store = explode('-', $_POST['store_no']);
                if($footer_store[0] == 'ICM')
                {
                    $icm_tenderType = $this->accounting_model->get_icm_tender_code_model_v2($other_noncash_mop_array[$b]);
                    if(!empty($icm_tenderType))
                    {
                        $footer_tenderType = $icm_tenderType->mop_code;
                    }
                }
                else if($footer_store[0] == 'ASC')
                {
                    $asc_tenderType = $this->accounting_model->get_asc_tender_code_model_v2($other_noncash_mop_array[$b]);
                    if(!empty($asc_tenderType))
                    {
                        $footer_tenderType = $asc_tenderType->mop_code;
                    }
                }
                else if($footer_store[0] == 'PM')
                {
                    $pm_tenderType = $this->accounting_model->get_pm_tender_code_model_v2($other_noncash_mop_array[$b]);
                    if(!empty($pm_tenderType))
                    {
                        $footer_tenderType = $pm_tenderType->mop_code;
                    }
                }
                // =================================================================================================================================================
                $nav_other_noncash = $this->accounting_model->get_nav_other_noncash_total_model_v2($_POST['sales_date'],$store_no_array,$_POST['dcode'],$footer_tenderType);
                $nav_other_mop_total = 0;
                if(!empty($nav_other_noncash))
                {
                    $nav_other_mop_total = $nav_other_noncash;
                }
                // ===================================================================================================================================
                $navcls_other_mop_total_variance_color = 'color: green;';
                $navcls_other_mop_total_variance = bcsub($cls_other_mop_total, $nav_other_mop_total, 4);
                if($navcls_other_mop_total_variance < 0)
                {
                    $navcls_other_mop_total_variance_color = 'color: red;';
                    $navcls_other_mop_total_variance = preg_replace('/-/', "", $navcls_other_mop_total_variance);
                    $navcls_other_mop_total_variance = '('.number_format($navcls_other_mop_total_variance, 2).')';
                }
                else
                {
                    $navcls_other_mop_total_variance = number_format($navcls_other_mop_total_variance, 2);
                }
                $cls_other_mop_total = number_format($cls_other_mop_total, 2); 
                $nav_other_mop_total = number_format($nav_other_mop_total, 2); 
                // ============================================================================================================================================
                array_push($additional_footer_html, '<td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_other_mop_total.'</td>
                                                     <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_other_mop_total.'</td>
                                                     <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_other_mop_total_variance_color.'">'.$navcls_other_mop_total_variance.'</td>');
            }
            $additional_footer_html = implode("",$additional_footer_html);
            // ================================================================================================================================================
            $cls_cash_total = $cls_partialcash2 + $cls_finalcash2;
            $nav_cash_total = $nav_partialcash2 + $nav_cash2;
            $navcls_total_variance_color = 'color: green;';
            $navcls_total_variance = $cls_cash_total - $nav_cash_total;
            if($navcls_total_variance < 0)
            {
                $navcls_total_variance_color = 'color: red;';
                $navcls_total_variance = preg_replace('/-/', "", $navcls_total_variance);
                $navcls_total_variance = '('.number_format($navcls_total_variance, 2).')';
            }
            else
            {
                $navcls_total_variance = number_format($navcls_total_variance, 2);
            }
            $cls_cash_total = number_format($cls_cash_total, 2);
            $nav_cash_total = number_format($nav_cash_total, 2);
            $cls_partialcash2 = number_format($cls_partialcash2, 2);
            $cls_finalcash2 = number_format($cls_finalcash2, 2);
            $nav_partialcash2 = number_format($nav_partialcash2, 2);
            // ==================================================================================================================================================
            $navcls_bankcard_total_variance_color = 'color: green;';
            $navcls_bankcard_total_variance = bcsub($cls_bankcard2, $nav_bankcard3, 4);
            if($navcls_bankcard_total_variance < 0)
            {
                $navcls_bankcard_total_variance_color = 'color: red;';
                $navcls_bankcard_total_variance = preg_replace('/-/', "", $navcls_bankcard_total_variance);
                $navcls_bankcard_total_variance = '('.number_format($navcls_bankcard_total_variance, 2).')';
            }
            else
            {
                $navcls_bankcard_total_variance = number_format($navcls_bankcard_total_variance, 2);
            }
            $cls_bankcard2 = number_format($cls_bankcard2, 2); 
            $nav_bankcard3 = number_format($nav_bankcard3, 2); 
            // ==================================================================================================================================================
            $navcls_giftcheck_total_variance_color = 'color: green;';
            $navcls_giftcheck_total_variance = bcsub($cls_giftcheck2, $nav_giftcheck2, 4);
            if($navcls_giftcheck_total_variance < 0)
            {
                $navcls_giftcheck_total_variance_color = 'color: red;';
                $navcls_giftcheck_total_variance = preg_replace('/-/', "", $navcls_giftcheck_total_variance);
                $navcls_giftcheck_total_variance = '('.number_format($navcls_giftcheck_total_variance, 2).')';
            }
            else
            {
                $navcls_giftcheck_total_variance = number_format($navcls_giftcheck_total_variance, 2);
            }
            $cls_giftcheck2 = number_format($cls_giftcheck2, 2); 
            $nav_giftcheck2 = number_format($nav_giftcheck2, 2); 
            // ==================================================================================================================================================
            $navcls_crmredeem_total_variance_color = 'color: green;';
            $navcls_crmredeem_total_variance = bcsub($cls_crmredeem2, $nav_crmredeem2, 4);
            if($navcls_crmredeem_total_variance < 0)
            {
                $navcls_crmredeem_total_variance_color = 'color: red;';
                $navcls_crmredeem_total_variance = preg_replace('/-/', "", $navcls_crmredeem_total_variance);
                $navcls_crmredeem_total_variance = '('.number_format($navcls_crmredeem_total_variance, 2).')';
            }
            else
            {
                $navcls_crmredeem_total_variance = number_format($navcls_crmredeem_total_variance, 2);
            }
            $cls_crmredeem2 = number_format($cls_crmredeem2, 2); 
            $nav_crmredeem2 = number_format($nav_crmredeem2, 2); 
            // ==================================================================================================================================================
            $navcls_atp_total_variance_color = 'color: green;';
            $navcls_atp_total_variance = bcsub($cls_atp2, $nav_atp2, 4);
            if($navcls_atp_total_variance < 0)
            {
                $navcls_atp_total_variance_color = 'color: red;';
                $navcls_atp_total_variance = preg_replace('/-/', "", $navcls_atp_total_variance);
                $navcls_atp_total_variance = '('.number_format($navcls_atp_total_variance, 2).')';
            }
            else
            {
                $navcls_atp_total_variance = number_format($navcls_atp_total_variance, 2);
            }
            $cls_atp2 = number_format($cls_atp2, 2); 
            $nav_atp2 = number_format($nav_atp2, 2); 
            // ==================================================================================================================================================
            $navcls_empcredit_total_variance_color = 'color: green;';
            $navcls_empcredit_total_variance = bcsub($cls_empcredit2, $nav_emp_chargeCredit2, 4);
            if($navcls_empcredit_total_variance < 0)
            {
                $navcls_empcredit_total_variance_color = 'color: red;';
                $navcls_empcredit_total_variance = preg_replace('/-/', "", $navcls_empcredit_total_variance);
                $navcls_empcredit_total_variance = '('.number_format($navcls_empcredit_total_variance, 2).')';
            }
            else
            {
                $navcls_empcredit_total_variance = number_format($navcls_empcredit_total_variance, 2);
            }
            $cls_empcredit2 = number_format($cls_empcredit2, 2); 
            $nav_emp_chargeCredit2 = number_format($nav_emp_chargeCredit2, 2); 
            // ==================================================================================================================================================
            $navcls_po_total_variance_color = 'color: green;';
            $navcls_po_total_variance = bcsub($cls_po2, $nav_po2, 4);
            if($navcls_po_total_variance < 0)
            {
                $navcls_po_total_variance_color = 'color: red;';
                $navcls_po_total_variance = preg_replace('/-/', "", $navcls_po_total_variance);
                $navcls_po_total_variance = '('.number_format($navcls_po_total_variance, 2).')';
            }
            else
            {
                $navcls_po_total_variance = number_format($navcls_po_total_variance, 2);
            }
            $cls_po2 = number_format($cls_po2, 2); 
            $nav_po2 = number_format($nav_po2, 2); 
            // ==================================================================================================================================================
            $navcls_ihcc_total_variance_color = 'color: green;';
            $navcls_ihcc_total_variance = bcsub($cls_ihcc2, $nav_ihcc2, 4);
            if($navcls_ihcc_total_variance < 0)
            {
                $navcls_ihcc_total_variance_color = 'color: red;';
                $navcls_ihcc_total_variance = preg_replace('/-/', "", $navcls_ihcc_total_variance);
                $navcls_ihcc_total_variance = '('.number_format($navcls_ihcc_total_variance, 2).')';
            }
            else
            {
                $navcls_ihcc_total_variance = number_format($navcls_ihcc_total_variance, 2);
            }
            $cls_ihcc2 = number_format($cls_ihcc2, 2); 
            $nav_ihcc2 = number_format($nav_ihcc2, 2); 
            // ==================================================================================================================================================
            $navcls_footer_total_variance_color = 'color: green;';
            $navcls_footer_total_variance = bcsub($cls_netAmount3, $nav_total_amount, 4);
            if($navcls_footer_total_variance < 0)
            {
                $navcls_footer_total_variance_color = 'color: red;';
                $navcls_footer_total_variance = preg_replace('/-/', "", $navcls_footer_total_variance);
                $navcls_footer_total_variance = '('.number_format($navcls_footer_total_variance, 2).')';
            }
            else
            {
                $navcls_footer_total_variance = number_format($navcls_footer_total_variance, 2);
            }
            $cls_netAmount3 = number_format($cls_netAmount3, 2); 
            $nav_total_amount = number_format($nav_total_amount, 2); 
            // ==================================================================================================================================================
            $cash_wholesale_ft_html = '';
            if($nav_colspan == 4)
            {
                $nav_cash2 = bcsub($nav_cash2, $total_nav_cash_wholesale, 4);
                $cash_wholesale_ft_html = '<td style="vertical-align: middle; text-align: center; font-weight: bold;">'.number_format($total_nav_cash_wholesale, 2).'</td>';
            }
            // ==================================================================================================================================================
            $html.=' 
                        <tr style="word-wrap:break-word;">
                            <td style="vertical-align: middle; text-align: center;"><span hidden>zzzzzzzzzzzzzzzz</span></td>
                            <td style="vertical-align: middle; text-align: center;"></td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;"></td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">TOTAL</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_partialcash2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_finalcash2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_cash_total.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_partialcash2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.number_format($nav_cash2, 2).'</td>
                            '.$cash_wholesale_ft_html.'
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_cash_total.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_total_variance_color.'">'.$navcls_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_bankcard2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_bankcard3.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_bankcard_total_variance_color.'">'.$navcls_bankcard_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_giftcheck2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_giftcheck2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_giftcheck_total_variance_color.'">'.$navcls_giftcheck_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_crmredeem2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_crmredeem2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_crmredeem_total_variance_color.'">'.$navcls_crmredeem_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_atp2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_atp2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_atp_total_variance_color.'">'.$navcls_atp_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_empcredit2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_emp_chargeCredit2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_empcredit_total_variance_color.'">'.$navcls_empcredit_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_po2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_po2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_po_total_variance_color.'">'.$navcls_po_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_ihcc2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_ihcc2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_ihcc_total_variance_color.'">'.$navcls_ihcc_total_variance.'</td>
                            '.$additional_footer_html.'
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_netAmount3.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_total_amount.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_footer_total_variance_color.'">'.$navcls_footer_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;"></td>
                        </tr>   
                        </tbody>       
                    </table>
                    ';
            // ============================================================================================================================================
            $sales_date_str = strtotime($_POST['sales_date']);
            $sales_date_str = date("F d, Y",$sales_date_str);

            $data['buDeptName']=$_POST['bname'].'&nbsp;/&nbsp;'.$_POST['dname'] ;                        
            $data['sales_date']=$sales_date_str;                
            $data['mop_html']=$mop_html_array;             
            $data['html']=$html;              
            echo json_encode($data);
        }
    }
 
    public function view_adjusted_variance_navcls_ctrl()
    {
        if(empty($_SESSION['emp_id']))
		{
			$message = "EXPIRED SESSION";
			echo json_encode($message);
		}
		else
        {
            $other_noncash_mop_array = array();
            $default_noncash_mop = array('Cards','Internal GC','CRM Redeem','ATP','Employee\'s Credit','PO Card','PO','IHCC');
            $cls_other_noncash = $this->accounting_model->get_cls_other_noncash_mop_model($_POST['sales_date'],$_POST['dcode'],$default_noncash_mop);
            foreach($cls_other_noncash as $cls_mop)
            {
                if(!in_array($cls_mop['mop_name'], $other_noncash_mop_array))
                { 
                    array_push($other_noncash_mop_array, $cls_mop['mop_name']);
                }
            }
            // ======================================================================================================================================
            $store_no_array = explode("|", $_POST['store_no']);
            $nav_mop_data = $this->accounting_model->get_adjusted_nav_mop_model_v2($_POST['sales_date'],$store_no_array,$_POST['dcode']);
            $mop_bcode = substr($_POST['dcode'], 0, -2);
            $mop_name_array = array();
            foreach($nav_mop_data as $mop)
            {
                $mop_data = $this->accounting_model->get_mop_name_model($mop['tender_type'],$mop_bcode);
                if(!empty($mop_data))
                {
                    array_push($mop_name_array, $mop_data->mop_name);
                }
            }
            // ======================================================================================================================================
            $cls_mop_data = $this->accounting_model->get_cls_mop_model($_POST['sales_date'],$_POST['dcode']);
            foreach($cls_mop_data as $mop)
            {
                if(!in_array($mop['mop_name'], $mop_name_array))
                {
                    array_push($mop_name_array, $mop['mop_name']);
                }
            }
            sort($mop_name_array);
            $mop_html_array = array();
            for($a=0; $a<count($mop_name_array); $a++)
            {
                $mop_name_data = $this->accounting_model->get_mop_code_model($mop_name_array[$a],$mop_bcode);
                if(!empty($mop_name_data))
                {
                    array_push($mop_html_array, '<option value="'.$mop_name_data->mop_code.'">'.$mop_name_array[$a].'</option>');
                }
            }
            array_push($mop_html_array, '<option value="total_var">TOTAL VARIANCE</option>');
            $mop_html_array = implode("", $mop_html_array);
            // ======================================================================================================================================
            $cash_colspan = 7;
            $nav_colspan = 3;
            $cash_wholesale_th_html = '';
            $cash_wholesale_data = $this->accounting_model->validate_adjsuted_cash_wholesale_model($_POST['sales_date'],$store_no_array,$_POST['dcode']);
            if(!is_null($cash_wholesale_data->cash_wholesale))
            {
                $cash_colspan = 8;
                $nav_colspan = 4;
                $cash_wholesale_th_html = '<th style="vertical-align: middle;" scope="col"><center>CASH<br>WHOLESALE</center></th>';
            }
            // ======================================================================================================================================
            $nav_other_noncash = $this->accounting_model->get_adjusted_nav_other_noncash_mop_model_v2($_POST['sales_date'],$store_no_array,$_POST['dcode']);
            $header_store = '';
            $header_tenderTypeName = '';
            foreach($nav_other_noncash as $nav_mop)
            {
                $header_store = explode('-', $_POST['store_no']);
                if($header_store[0] == 'ICM')
                {
                    $icm_tenderTypeName = $this->accounting_model->get_icm_tender_name_model_v2($nav_mop['tender_type']);
                    if(!empty($icm_tenderTypeName))
                    {
                        $header_tenderTypeName = $icm_tenderTypeName->mop_name;
                    }
                }
                else if($header_store[0] == 'ASC')
                {
                    $asc_tenderTypeName = $this->accounting_model->get_asc_tender_name_model_v2($nav_mop['tender_type']);
                    if(!empty($asc_tenderTypeName))
                    {
                        $header_tenderTypeName = $asc_tenderTypeName->mop_name;
                    }
                }
                else if($header_store[0] == 'PM')
                {
                    $pm_tenderTypeName = $this->accounting_model->get_pm_tender_name_model_v2($nav_mop['tender_type']);
                    if(!empty($pm_tenderTypeName))
                    {
                        $header_tenderTypeName = $pm_tenderTypeName->mop_name;
                    }
                }
                if(!in_array($header_tenderTypeName, $other_noncash_mop_array))
                { 
                    array_push($other_noncash_mop_array, $header_tenderTypeName);
                }
            }
            // ==========================================================================================================================
            sort($other_noncash_mop_array);
            $additional_header_html = array();
            $additional_sub_header_html = array();
            for($i=0; $i<count($other_noncash_mop_array); $i++) 
            {
                array_push($additional_header_html, '<th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                                        <center>'.$other_noncash_mop_array[$i].'</center>
                                                    </th>');
                // ========================================================================================================================
                array_push($additional_sub_header_html, '<th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                                        <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                                        <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>');
            }
            $additional_header_html = implode("",$additional_header_html);
            $additional_sub_header_html = implode("",$additional_sub_header_html);
            // =========================================================================================================================
            $html='
                    <table class="table table-bordered table-hover table-condensed display tablesorter" id="navcls_variance_table">
                        <thead>
                            <tr>                                                          
                                <th style="vertical-align: middle;" rowspan="3">
                                    <center>CASHIER\'S NAME</center>
                                </th>                                                  
                                <th style="vertical-align: middle;" rowspan="3">
                                    <center>LOCATION</center>
                                </th>
                                <th style="vertical-align: middle;" colspan="2" scope="colgroup">
                                    <center>TERMINAL NO.</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="'.$cash_colspan.'" scope="colgroup">
                                    <center>CASH</center>
                                </th>      
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>COMMERCIAL CARD\'S</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>INTERNAL GIFT CHECK</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>CRM Redeem</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>A.T.P</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>EMPLOYEE\'S CREDIT</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>PO CARD</center>
                                </th>  
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup">
                                    <center>IHCC</center>
                                </th>   
                                '.$additional_header_html.'
                                <th style="vertical-align: middle;" colspan="2" scope="colgroup">
                                    <center>TOTAL</center>
                                </th>   
                                <th style="vertical-align: middle;" rowspan="3">
                                    <center>VARIANCE</center>
                                </th>                   
                            </tr>
                            <tr style="border-top: outset;">
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" colspan="3" scope="colgroup"><center>CLS</center></th>
                                <th style="vertical-align: middle;" colspan="'.$nav_colspan.'" scope="colgroup"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>NAV</center></th>
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>VARIANCE</center></th>
                                '.$additional_sub_header_html.'
                                <th style="vertical-align: middle;" scope="col" rowspan="2"><center>CLS</center></th>
                                <th style="vertical-align: middle; border-right: 1px solid;" scope="col" rowspan="2"><center>NAV</center></th>
                            </tr>
                            <tr style="border-top: outset;">
                                <th style="vertical-align: middle;" scope="col"><center>PARTIAL</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>FINAL</center></th>
                                <th style="vertical-align: middle; border-right: solid 1px;" scope="col"><center>TOTAL</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>PARTIAL</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>FINAL</center></th>
                                '.$cash_wholesale_th_html.'
                                <th style="vertical-align: middle; border-right: solid 1px;" scope="col"><center>TOTAL</center></th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 12px;">
                    ';
            // ============================================================================================================================================
            $nav_data = $this->accounting_model->get_adjusted_uploaded_navdata_model_v2($_POST['sales_date'],$store_no_array);
            $terminal_counter_no = '';
            $bcode = '';
            $dcode = '';
            $staff_name = '';
            $staff_id = '';
            $net_amount = 0;
            $net_amount2 = 0;
            $nav_total_amount = 0;
            $nav_cash = 0;
            $nav_cash2 = 0;
            $nav_cash3 = 0;
            $nav_bankcard = 0;
            $nav_bankcard2 = 0;
            $nav_bankcard3 = 0;
            $nav_giftcheck = 0;
            $nav_giftcheck2 = 0;
            $nav_giftcheck3 = 0;
            $nav_partialcash = 0;
            $nav_partialcash2 = 0;
            $nav_crmredeem = 0;
            $nav_crmredeem2 = 0;
            $nav_atp = 0;
            $nav_atp2 = 0;
            $nav_emp_chargeCredit = 0;
            $nav_emp_chargeCredit2 = 0;
            $nav_po = 0;
            $nav_po2 = 0;
            $nav_ihcc = 0;
            $nav_ihcc2 = 0;
            $nav_otherpayment = 0;
            $nav_otherpayment2 = 0;
            $total_nav_cash_wholesale = 0;
            // =================================================================================
            $cls_finalcash2 = 0;
            $cls_bankcard2 = 0;
            $cls_giftcheck2 = 0;
            $cls_partialcash2 = 0;
            $cls_crmredeem2 = 0;
            $cls_atp2 = 0;
            $cls_empcredit2 = 0;
            $cls_po2 = 0;
            $cls_ihcc2 = 0;
            $cls_otherpayment2 = 0;
            $cls_netAmount2 = 0;
            $cls_netAmount3 = 0;
            foreach($nav_data as $nav)
            {
                $staff_terminal_counter = $this->accounting_model->get_adjusted_staff_terminal_counter_model($_POST['sales_date'],$nav['staff_id']);
                $store_no = '';
                $terminal_amount = '';
                $pos_terminal_no = array();
                foreach($staff_terminal_counter as $tcno)
                {
                    $store_no = $tcno['store_no'];
                    $terminal_counter_amount = $this->accounting_model->get_adjusted_terminal_counter_amount_model($_POST['sales_date'],$nav['staff_id'],$tcno['pos_terminal_no']);
                    $terminal_amount = number_format($terminal_counter_amount, 2);
                    array_push($pos_terminal_no, $tcno['pos_terminal_no'].' | '.$terminal_amount.'<br>');
                }
                // ==============================================================================================================================================
                $staff_info = $this->accounting_model->get_staff_info_model($nav['staff_id']);
                $staff_emp_id = '';
                if(empty($staff_info))
                {
                    $staff_id = $nav['staff_id'] * 1;
                    $staff_info2 = $this->accounting_model->get_staff_info_model($staff_id);
                    if(!empty($staff_info2))
                    {
                        $staff_name = $staff_info2->name;
                        $staff_emp_id = $staff_info2->emp_id;
                    }
                }
                else
                {
                    $staff_name = $staff_info->name;
                    $staff_emp_id = $staff_info->emp_id;
                }
                // ==============================================================================================================================================
                $staff_net_amount = $this->accounting_model->get_adjusted_staff_net_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id']);
                if(!empty($staff_net_amount))
                {
                    $net_amount2 = $staff_net_amount->amount;
                    $net_amount = $staff_net_amount->amount;
                    $nav_total_amount += $staff_net_amount->amount;
                }
                // ==============================================================================================================================================
                $navcash_tender_type = $this->accounting_model->get_adjusted_nav_cash_amount_model($_POST['sales_date'],$store_no_array,$nav['staff_id']);
                $nav_cash_color = '';
                if(!empty($navcash_tender_type))
                {
                    $nav_cash3 = $navcash_tender_type->type_amount;
                    $nav_cash2 += $navcash_tender_type->type_amount;
                    $nav_cash = $navcash_tender_type->type_amount;
                    if($navcash_tender_type->status == 'ADJUSTED')
                    {
                        $nav_cash_color = 'color: magenta;';
                    }
                }
                // ==============================================================================================================================================
                $nav_bankcard_tender_type = $this->accounting_model->get_adjusted_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],3);
                $nav_bankcard_color = '';
                if(!empty($nav_bankcard_tender_type))
                {
                    $nav_bankcard3 += $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard2 = $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard = $nav_bankcard_tender_type->type_amount;
                    if($nav_bankcard_tender_type->status == 'ADJUSTED')
                    {
                        $nav_bankcard_color = 'color: magenta;';
                    }
                }
                // ==============================================================================================================================================
                $nav_giftcheck_tender_type = $this->accounting_model->get_adjusted_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],35);
                $nav_giftcheck_color = '';
                if(!empty($nav_giftcheck_tender_type))
                {
                    $nav_giftcheck3 = $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck2 += $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck = $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck = number_format($nav_giftcheck, 2);
                    if($nav_giftcheck_tender_type->status == 'ADJUSTED')
                    {
                        $nav_giftcheck_color = 'color: magenta;';
                    }
                }
                // ==============================================================================================================================================
                $nav_partialcash_tender_type = $this->accounting_model->get_adjusted_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],9);
                $nav_partialcash_color = '';
                if(!empty($nav_partialcash_tender_type))
                {
                    $nav_partialcash3 = $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash2 += $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash = $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash = number_format($nav_partialcash, 2);
                    if($nav_partialcash_tender_type->status == 'ADJUSTED')
                    {
                        $nav_partialcash_color = 'color: magenta;';
                    }
                }
                // ==============================================================================================================================================
                $nav_crmredeem_tender_type = $this->accounting_model->get_adjusted_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],28);
                $nav_crmredeem_color = '';
                if(!empty($nav_crmredeem_tender_type))
                {
                    $nav_crmredeem2 += $nav_crmredeem_tender_type->type_amount;
                    $nav_crmredeem = $nav_crmredeem_tender_type->type_amount;
                    if($nav_crmredeem_tender_type->status == 'ADJUSTED')
                    {
                        $nav_crmredeem_color = 'color: magenta;';
                    }
                }
                // ==============================================================================================================================================
                $nav_atp_tender_type = $this->accounting_model->get_adjusted_atp_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id']);
                $nav_atp_color = '';
                if(!empty($nav_atp_tender_type))
                {
                    $nav_atp2 += $nav_atp_tender_type->type_amount;
                    $nav_atp = $nav_atp_tender_type->type_amount;
                    if($nav_atp_tender_type->status == 'ADJUSTED')
                    {
                        $nav_atp_color = 'color: magenta;';
                    }
                }
                // ==============================================================================================================================================
                $nav_emp_chargeCredit_tender_type = $this->accounting_model->get_adjusted_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],36);
                $nav_emp_credit_color = '';
                if(!empty($nav_emp_chargeCredit_tender_type))
                {
                    $nav_emp_chargeCredit2 += $nav_emp_chargeCredit_tender_type->type_amount;
                    $nav_emp_chargeCredit = $nav_emp_chargeCredit_tender_type->type_amount;
                    if($nav_emp_chargeCredit_tender_type->status == 'ADJUSTED')
                    {
                        $nav_emp_credit_color = 'color: magenta;';
                    }
                }
                // ==============================================================================================================================================
                $nav_po_tender_type = $this->accounting_model->get_adjusted_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],14);
                $nav_po_color = '';
                if(!empty($nav_po_tender_type))
                {
                    $nav_po2 += $nav_po_tender_type->type_amount;
                    $nav_po = $nav_po_tender_type->type_amount;
                    if($nav_po_tender_type->status == 'ADJUSTED')
                    {
                        $nav_po_color = 'color: magenta;';
                    }
                }
                // ==============================================================================================================================================
                $nav_ihcc_tender_type = $this->accounting_model->get_adjusted_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],15);
                $nav_ihcc_color = '';
                if(!empty($nav_ihcc_tender_type))
                {
                    $nav_ihcc2 += $nav_ihcc_tender_type->type_amount;
                    $nav_ihcc = $nav_ihcc_tender_type->type_amount;
                    if($nav_ihcc_tender_type->status == 'ADJUSTED')
                    {
                        $nav_ihcc_color = 'color: magenta;';
                    }
                }
                // ==============================================================================================================================================
                $nav_otherpayment_tender_type = $this->accounting_model->get_adjusted_otherpayment_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id']);
                if(!empty($nav_otherpayment_tender_type))
                {
                    $nav_otherpayment2 += $nav_otherpayment_tender_type->type_amount;
                    $nav_otherpayment = $nav_otherpayment_tender_type->type_amount;
                    $nav_otherpayment = number_format($nav_otherpayment, 2);
                }
                $nav_other_tender_type = $this->accounting_model->get_adjusted_other_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id']);
                $paymentTypeAndAmount = '';
                $br = '';
                if(!empty($nav_other_tender_type))
                {
                    $nav_othertype_array = array();
                    $nav_othertype = '';
                    $store = '';
                    $tenderTypeName = '';
                    foreach($nav_other_tender_type as $othertype)
                    {
                        $store = explode('-', $_POST['store_no']);
                        if($store[0] == 'ICM')
                        {
                            $icm_tenderTypeName = $this->accounting_model->get_icm_tender_name_model_v2($othertype['other_type']);
                            if(!empty($icm_tenderTypeName))
                            {
                                $tenderTypeName = $icm_tenderTypeName->mop_name;
                            }
                        }
                        else if($store[0] == 'ASC')
                        {
                            $asc_tenderTypeName = $this->accounting_model->get_asc_tender_name_model_v2($othertype['other_type']);
                            if(!empty($asc_tenderTypeName))
                            {
                                $tenderTypeName = $asc_tenderTypeName->mop_name;
                            }
                        }
                        else if($store[0] == 'PM')
                        {
                            $pm_tenderTypeName = $this->accounting_model->get_pm_tender_name_model_v2($othertype['other_type']);
                            if(!empty($pm_tenderTypeName))
                            {
                                $tenderTypeName = $pm_tenderTypeName->mop_name;
                            }
                        }

                        $nav_othertype_data = $this->accounting_model->get_adjusted_tender_type_amount_model_v2($_POST['sales_date'],$store_no_array,$nav['staff_id'],$othertype['other_type']);
                        $nav_othertype = $nav_othertype_data->type_amount;
                        if($nav_othertype > 0)
                        {
                            $nav_othertype = $tenderTypeName.'|'.$nav_othertype;
                            array_push($nav_othertype_array, $nav_othertype);
                        }
                    }

                    if(!empty($nav_othertype_array))
                    {
                        $br = '<br>';
                        $paymentTypeAndAmount = implode('<br>', $nav_othertype_array);
                        $paymentTypeAndAmount = '('.$paymentTypeAndAmount.')';
                    }
                }
                // ===================================================================================================================================================
                $bu_data = $this->accounting_model->get_bcode_model($_POST['bname']);
                if(!empty($bu_data))
                {
                    $bcode = $bu_data->bcode;
                }
                $dept_data = $this->accounting_model->get_dcode_model($bcode,$_POST['dname']);
                if(!empty($dept_data))
                {
                    $dcode = $dept_data->dcode;
                }
                $cebo_cs_denomination_data = $this->accounting_model->get_cebo_cs_denomination_model_v2($staff_emp_id,$_POST['sales_date'],$dcode);
                $tr_no_array = array();
                $cls_netAmount = 0;
                $cls_discount = 0;
                foreach($cebo_cs_denomination_data as $data)
                {
                    if(!in_array($data['tr_no'], $tr_no_array))
                    {  
                        array_push($tr_no_array, $data['tr_no']);
                    }
                    $cls_netAmount += $data['total'] + $data['discount'];
                    $cls_netAmount3 += $data['total'] + $data['discount'];
                    $cls_discount += $data['discount'];
                }
                // ===============================================================================================
                $cls_terminal_no_array = array();
                $cls_location_array = array();
                $cls_bankcard = 0;
                $cls_giftcheck = 0;
                $cls_crmredeem = 0;
                $cls_atp = 0;
                $cls_empcredit = 0;
                $cls_po = 0;
                $cls_ihcc = 0;
                $cls_finalcash = 0;
                $cls_partialcash = 0;
                $cls_otherpayment_total = 0;
                $netAmount_variance = 0;
                $additional_body_html = array();
                if(!empty($tr_no_array))
                {
                    $cash_noncash_terminal_no_array = array();
                    $cls_cash_terminal_no = $this->accounting_model->get_cls_cash_terminal_no_model($tr_no_array,$staff_emp_id);
                    foreach($cls_cash_terminal_no as $cash)
                    {
                        if(!in_array($cash['tr_no'].'|'.$cash['pos_name'], $cash_noncash_terminal_no_array))
                        {  
                            array_push($cash_noncash_terminal_no_array, $cash['tr_no'].'|'.$cash['pos_name']);
                        }
                        // ========================================================================================
                        if(!in_array($cash['location'], $cls_location_array))
                        {  
                            array_push($cls_location_array, $cash['location']);
                        }
                    }
                    // ========================================================================================================================
                    $cls_noncash_terminal_no = $this->accounting_model->get_cls_noncash_terminal_no_model($tr_no_array,$staff_emp_id);
                    foreach($cls_noncash_terminal_no as $noncash)
                    {
                        if(!in_array($noncash['tr_no'].'|'.$noncash['pos_name'], $cash_noncash_terminal_no_array))
                        {  
                            array_push($cash_noncash_terminal_no_array, $noncash['tr_no'].'|'.$noncash['pos_name']);
                        }
                        // ========================================================================================
                        if(!in_array($noncash['location'], $cls_location_array))
                        {  
                            array_push($cls_location_array, $noncash['location']);
                        }
                    }
                    // ========================================================================================================================
                    for($a=0; $a<count($cash_noncash_terminal_no_array); $a++) 
                    {
                        $trno_pos = explode('|',$cash_noncash_terminal_no_array[$a]);
                        $pos_cash_discount = $this->accounting_model->get_pos_cash_discount_model($trno_pos[0],$staff_emp_id);
                        $pos_discount = 0;
                        if(!empty($pos_cash_discount))
                        {
                            $pos_discount = $pos_cash_discount->discount;
                        }
                        // ==============================================================================================================================
                        $cls_cash_terminal_no_total = $this->accounting_model->get_cls_cash_terminal_no_total_model($tr_no_array,$staff_emp_id,$trno_pos[1]);
                        // ===============================================================================================================================
                        $cls_noncash_terminal_no_total = $this->accounting_model->get_cls_noncash_terminal_no_total_model($tr_no_array,$staff_emp_id,$trno_pos[1]);
                        // =============================================================================================================================
                        $cls_terminal_no_and_total = $cls_cash_terminal_no_total + $cls_noncash_terminal_no_total + $pos_discount;
                        $cls_terminal_no_and_total = number_format($cls_terminal_no_and_total, 2);
                        if(!in_array($trno_pos[1].' | '.$cls_terminal_no_and_total.'<br>', $cls_terminal_no_array))
                        {  
                            array_push($cls_terminal_no_array, $trno_pos[1].' | '.$cls_terminal_no_and_total.'<br>');
                        }
                    }
                    // ========================================================================================================================
                    $final_cash = $this->accounting_model->get_final_cash_model($tr_no_array,$staff_emp_id);
                    if(!empty($final_cash))
                    {
                        $cls_finalcash = $final_cash->total + $cls_discount;
                        $cls_finalcash2 += $final_cash->total + $cls_discount;
                    }
                    $partial_cash = $this->accounting_model->get_partial_cash_model($tr_no_array,$staff_emp_id);
                    if(!empty($partial_cash))
                    {
                        $cls_partialcash = $partial_cash->total;
                        $cls_partialcash2 += $partial_cash->total;
                    }
                    $cls_cashier_noncash_data = $this->accounting_model->get_cs_cashier_noncashden_model($tr_no_array,$staff_emp_id);
                    foreach($cls_cashier_noncash_data as $noncash)
                    {
                        if($noncash['mop_name'] == 'Cards')
                        {
                            $cls_bankcard2 += $noncash['noncash_amount'];
                            $cls_bankcard += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'Internal GC')
                        {
                            $cls_giftcheck2 += $noncash['noncash_amount'];
                            $cls_giftcheck += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'CRM Redeem')
                        {
                            $cls_crmredeem2 += $noncash['noncash_amount'];
                            $cls_crmredeem += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'ATP')
                        {
                            $cls_atp2 += $noncash['noncash_amount'];
                            $cls_atp += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'Employee\'s Credit')
                        {
                            $cls_empcredit2 += $noncash['noncash_amount'];
                            $cls_empcredit += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'PO Card' || $noncash['mop_name'] == 'PO')
                        {
                            $cls_po2 += $noncash['noncash_amount'];
                            $cls_po += $noncash['noncash_amount'];
                        }
                        if($noncash['mop_name'] == 'IHCC')
                        {
                            $cls_ihcc2 += $noncash['noncash_amount'];
                            $cls_ihcc += $noncash['noncash_amount'];
                        }
                    }
                    // ================================================================================================================================================
                    $body_store = '';
                    $body_tenderType = '';
                    for($a=0; $a<count($other_noncash_mop_array); $a++) 
                    {
                        $cls_other_mop_data = $this->accounting_model->get_cls_other_mop_model($tr_no_array,$staff_emp_id,$other_noncash_mop_array[$a]);
                        $cls_other_mop_amount = 0;
                        if(!empty($cls_other_mop_data))
                        {
                            $cls_other_mop_amount = $cls_other_mop_data->amount;
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">'.number_format($cls_other_mop_data->amount, 2).'</td>');
                        }
                        else
                        {
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">0.00</td>');
                        }
                        // ==============================================================================================================================================
                        $body_store = explode('-', $_POST['store_no']);
                        $nav_tender_code = '';
                        if($body_store[0] == 'ICM')
                        {
                            $icm_tenderTypeName = $this->accounting_model->get_icm_tender_code_model_v2($other_noncash_mop_array[$a]);
                            if(!empty($icm_tenderTypeName))
                            {
                                $nav_tender_code = $icm_tenderTypeName->mop_code;
                            }
                        }
                        else if($body_store[0] == 'ASC')
                        {
                            $asc_tenderTypeName = $this->accounting_model->get_asc_tender_code_model_v2($other_noncash_mop_array[$a]);
                            if(!empty($asc_tenderTypeName))
                            {
                                $nav_tender_code = $asc_tenderTypeName->mop_code;
                            }
                        }
                        else if($body_store[0] == 'PM')
                        {
                            $pm_tenderTypeName = $this->accounting_model->get_pm_tender_code_model_v2($other_noncash_mop_array[$a]);
                            if(!empty($pm_tenderTypeName))
                            {
                                $nav_tender_code = $pm_tenderTypeName->mop_code;
                            }
                        }
                        // ===========================================================================================================================================
                        $nav_other_mop_data = $this->accounting_model->get_adjusted_nav_other_mop_amount_model_v3($_POST['sales_date'],$store_no_array,$nav['staff_id'],$nav_tender_code);
                        $nav_other_mop_color = '';
                        $nav_other_mop_amount = 0;
                        if(!empty($nav_other_mop_data->amount))
                        {
                            if($nav_other_mop_data->status == 'ADJUSTED')
                            {
                                $nav_other_mop_color = 'color: magenta';
                            }
                            $nav_other_mop_amount = $nav_other_mop_data->amount;
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; '.$nav_other_mop_color.'">'.number_format($nav_other_mop_data->amount, 2).'</td>');
                            // ========================================================================================================================================
                            $variance_other_mop_amount = bcsub($cls_other_mop_amount, $nav_other_mop_amount, 4);
                            if($variance_other_mop_amount < 0)
                            {
                                $variance_other_mop_amount = preg_replace('/-/', "", $variance_other_mop_amount);
                                $variance_other_mop_amount = '('.number_format($variance_other_mop_amount, 2).')';
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: red;">'.$variance_other_mop_amount.'</td>');
                            }
                            else
                            {
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: green;">'.number_format($variance_other_mop_amount, 2).'</td>');
                            }
                        }
                        else
                        {
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">0.00</td>');
                            // ========================================================================================================================================
                            $variance_other_mop_amount = bcsub($cls_other_mop_amount, $nav_other_mop_amount, 4);
                            if($variance_other_mop_amount < 0)
                            {
                                $variance_other_mop_amount = preg_replace('/-/', "", $variance_other_mop_amount);
                                $variance_other_mop_amount = '('.number_format($variance_other_mop_amount, 2).')';
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: red;">'.$variance_other_mop_amount.'</td>');
                            }
                            else
                            {
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: green;">'.number_format($variance_other_mop_amount, 2).'</td>');
                            }
                        }
                    }
                }
                else
                {
                    $body_store = '';
                    $body_tenderType = '';
                    for($a=0; $a<count($other_noncash_mop_array); $a++) 
                    {
                        $body_store = explode('-', $_POST['store_no']);
                        $nav_tender_code = '';
                        if($body_store[0] == 'ICM')
                        {
                            $icm_tenderTypeName = $this->accounting_model->get_icm_tender_code_model_v2($other_noncash_mop_array[$a]);
                            if(!empty($icm_tenderTypeName))
                            {
                                $nav_tender_code = $icm_tenderTypeName->mop_code;
                            }
                        }
                        else if($body_store[0] == 'ASC')
                        {
                            $asc_tenderTypeName = $this->accounting_model->get_asc_tender_code_model_v2($other_noncash_mop_array[$a]);
                            if(!empty($asc_tenderTypeName))
                            {
                                $nav_tender_code = $asc_tenderTypeName->mop_code;
                            }
                        }
                        else if($body_store[0] == 'PM')
                        {
                            $pm_tenderTypeName = $this->accounting_model->get_pm_tender_code_model_v2($other_noncash_mop_array[$a]);
                            if(!empty($pm_tenderTypeName))
                            {
                                $nav_tender_code = $pm_tenderTypeName->mop_code;
                            }
                        }
                        // ===========================================================================================================================================
                        $nav_other_mop_data = $this->accounting_model->get_adjusted_nav_other_mop_amount_model_v3($_POST['sales_date'],$store_no_array,$nav['staff_id'],$nav_tender_code);
                        $nav_other_mop_color = '';
                        $cls_other_mop_amount = 0;
                        $nav_other_mop_amount = 0;
                        if(!empty($nav_other_mop_data->amount))
                        {
                            if($nav_other_mop_data->status == 'ADJUSTED')
                            {
                                $nav_other_mop_color = 'color: magenta';
                            }
                            $nav_other_mop_amount = $nav_other_mop_data->amount;
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">0.00</td>
                                                                <td style="vertical-align: middle; text-align: center; '.$nav_other_mop_color.'">'.number_format($nav_other_mop_data->amount, 2).'</td>');
                            // =======================================================================================================================================
                            $variance_other_mop_amount = bcsub($cls_other_mop_amount, $nav_other_mop_amount, 4);
                            if($variance_other_mop_amount < 0)
                            {
                                $variance_other_mop_amount = preg_replace('/-/', "", $variance_other_mop_amount);
                                $variance_other_mop_amount = '('.number_format($variance_other_mop_amount, 2).')';
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: red;">'.$variance_other_mop_amount.'</td>');
                            }
                            else
                            {
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: green;">'.number_format($variance_other_mop_amount, 2).'</td>');
                            }
                        }
                        else
                        {
                            array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center;">0.00</td>
                                                               <td style="vertical-align: middle; text-align: center;">0.00</td>');
                            // =======================================================================================================================================
                            $variance_other_mop_amount = bcsub($cls_other_mop_amount, $nav_other_mop_amount, 4);
                            if($variance_other_mop_amount < 0)
                            {
                                $variance_other_mop_amount = preg_replace('/-/', "", $variance_other_mop_amount);
                                $variance_other_mop_amount = '('.number_format($variance_other_mop_amount, 2).')';
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: red;">'.$variance_other_mop_amount.'</td>');
                            }
                            else
                            {
                                array_push($additional_body_html, '<td style="vertical-align: middle; text-align: center; color: green;">'.number_format($variance_other_mop_amount, 2).'</td>');
                            }
                        }
                    }
                }
                // ==================================================================================================================================================
                $cls_terminal_no_array = implode("", $cls_terminal_no_array);
                $cls_terminal_no_array = substr_replace($cls_terminal_no_array ,"",-4);
                $cls_terminal_no_array = $cls_terminal_no_array;
                // ==================================================================================================================================================
                $terminal_counter_no = implode("", $pos_terminal_no);
                $terminal_counter_no = substr_replace($terminal_counter_no ,"",-4);
                $terminal_counter_no = $terminal_counter_no;
                // ===================================================================================================================================================
                $location_array = array();
                for($a=0; $a<count($cls_location_array); $a++)
                {
                    $code_length = strlen($cls_location_array[$a]);
                    if($code_length == 10)
                    {
                        $ss_data = $this->accounting_model->get_ssname_model($cls_location_array[$a]);
                        if(!empty($ss_data))
                        {
                            array_push($location_array, $ss_data->sub_section_name.'<br>');
                        }
                    }
                    else if($code_length == 8)
                    {
                        $s_data = $this->accounting_model->get_sname_model($cls_location_array[$a]);
                        if(!empty($s_data))
                        {
                            array_push($location_array, $s_data->section_name.'<br>');
                        }
                    }
                    else if($code_length == 6)
                    {
                        $d_data = $this->accounting_model->get_dname_model($cls_location_array[$a]);
                        if(!empty($d_data))
                        {
                            array_push($location_array, $d_data->dept_name.'<br>');
                        }
                    }
                }
                $location_array = implode("", $location_array);
                $location_array = substr_replace($location_array, "", -4);
                // ===================================================================================================================================================
                $variance_color = 'color: green;';
                $cls_total_cash = $cls_partialcash + $cls_finalcash;
                $nav_total_cash = $nav_partialcash3 + $nav_cash3;
                $cash_variance = bcsub($cls_total_cash, $nav_total_cash, 4);
                if($cash_variance < 0)
                {
                    $variance_color = 'color: red;';
                    $cash_variance = preg_replace('/-/', "", $cash_variance);
                    $cash_variance = '('.number_format($cash_variance, 2).')';
                }
                else
                {
                    $cash_variance = number_format($cash_variance, 2);
                }
                $cls_partialcash = number_format($cls_partialcash, 2);
                $cls_finalcash = number_format($cls_finalcash, 2);
                $cls_total_cash = number_format($cls_total_cash, 2);
                $nav_total_cash = number_format($nav_total_cash, 2);
                // ==================================================================================================================
                $bc_variance_color = 'color: green;';
                $bc_variance = bcsub($cls_bankcard, $nav_bankcard, 4);
                if($bc_variance < 0)
                {
                    $bc_variance_color = 'color: red;';
                    $bc_variance = preg_replace('/-/', "", $bc_variance);
                    $bc_variance = '('.number_format($bc_variance, 2).')';
                }
                else
                {
                    $bc_variance = number_format($bc_variance, 2);
                }
                $nav_bankcard = number_format($nav_bankcard, 2);
                $cls_bankcard = number_format($cls_bankcard, 2);
                // ==================================================================================================================
                $gc_variance_color = 'color: green;';
                $giftcheck_variance = bcsub($cls_giftcheck, $nav_giftcheck3, 4);
                if($giftcheck_variance < 0)
                {
                    $gc_variance_color = 'color: red;';
                    $giftcheck_variance = preg_replace('/-/', "", $giftcheck_variance);
                    $giftcheck_variance = '('.number_format($giftcheck_variance, 2).')';
                }
                else
                {
                    $giftcheck_variance = number_format($giftcheck_variance, 2);
                }
                $cls_giftcheck = number_format($cls_giftcheck, 2);
                // ========================================================================================================================
                $crmredeem_variance_color = 'color: green;';
                $crmredeem_variance = bcsub($cls_crmredeem, $nav_crmredeem, 4);
                if($crmredeem_variance < 0)
                {
                    $crmredeem_variance_color = 'color: red;';
                    $crmredeem_variance = preg_replace('/-/', "", $crmredeem_variance);
                    $crmredeem_variance = '('.number_format($crmredeem_variance, 2).')';
                }
                else
                {
                    $crmredeem_variance = number_format($crmredeem_variance, 2);
                }
                $nav_crmredeem = number_format($nav_crmredeem, 2);
                $cls_crmredeem = number_format($cls_crmredeem, 2);
                // ========================================================================================================================
                $atp_variance_color = 'color: green;';
                $atp_variance = bcsub($cls_atp, $nav_atp, 4);
                if($atp_variance < 0)
                {
                    $atp_variance_color = 'color: red;';
                    $atp_variance = preg_replace('/-/', "", $atp_variance);
                    $atp_variance = '('.number_format($atp_variance, 2).')';
                }
                else
                {
                    $atp_variance = number_format($atp_variance, 2);
                }
                $cls_atp = number_format($cls_atp, 2);
                $nav_atp = number_format($nav_atp, 2);
                // ========================================================================================================================
                $empcredit_variance_color = 'color: green;';
                $empcredit_variance = bcsub($cls_empcredit, $nav_emp_chargeCredit, 4);
                if($empcredit_variance < 0)
                {
                    $empcredit_variance_color = 'color: red;';
                    $empcredit_variance = preg_replace('/-/', "", $empcredit_variance);
                    $empcredit_variance = '('.number_format($empcredit_variance, 2).')';
                }
                else
                {
                    $empcredit_variance = number_format($empcredit_variance, 2);
                }
                $cls_empcredit = number_format($cls_empcredit, 2);
                $nav_emp_chargeCredit = number_format($nav_emp_chargeCredit, 2);
                // ========================================================================================================================
                $po_variance_color = 'color: green;';
                $po_variance = bcsub($cls_po, $nav_po, 4);
                if($po_variance < 0)
                {
                    $po_variance_color = 'color: red;';
                    $po_variance = preg_replace('/-/', "", $po_variance);
                    $po_variance = '('.number_format($po_variance, 2).')';
                }
                else
                {
                    $po_variance = number_format($po_variance, 2);
                }
                $cls_po = number_format($cls_po, 2);
                $nav_po = number_format($nav_po, 2);
                // ========================================================================================================================
                $ihcc_variance_color = 'color: green;';
                $ihcc_variance = bcsub($cls_ihcc, $nav_ihcc, 4);
                if($ihcc_variance < 0)
                {
                    $ihcc_variance_color = 'color: red;';
                    $ihcc_variance = preg_replace('/-/', "", $ihcc_variance);
                    $ihcc_variance = '('.number_format($ihcc_variance, 2).')';
                }
                else
                {
                    $ihcc_variance = number_format($ihcc_variance, 2);
                }
                $cls_ihcc = number_format($cls_ihcc, 2);
                $nav_ihcc = number_format($nav_ihcc, 2);
                // ========================================================================================================================
                $total_variance_color = 'color: green;';
                $total_variance = bcsub($cls_netAmount, $net_amount, 4);
                if($total_variance < 0)
                {
                    $total_variance_color = 'color: red;';
                    $total_variance = preg_replace('/-/', "", $total_variance);
                    $total_variance = '('.number_format($total_variance, 2).')';
                }
                else
                {
                    $total_variance = number_format($total_variance, 2);
                }
                $cls_netAmount = number_format($cls_netAmount, 2);
                $net_amount = number_format($net_amount, 2);
                // ========================================================================================================================
                $additional_body_html = implode("",$additional_body_html);
                // ========================================================================================================================
                $cash_wholesale_td_html = '';
                if($nav_colspan == 4)
                {
                    $cash_wholesale_data = $this->accounting_model->ge_adjusted_cash_wholesale_amount_model($_POST['sales_date'],$store_no_array,$_POST['dcode'],$nav['staff_id']);
                    $nav_cash_wholesale = 0;
                    if(!is_null($cash_wholesale_data->cash_wholesale))
                    {
                        $nav_cash_wholesale = $cash_wholesale_data->cash_wholesale;
                        $nav_cash = bcsub($nav_cash, $nav_cash_wholesale, 4);
                        $total_nav_cash_wholesale += $cash_wholesale_data->cash_wholesale;
                    }
                    $cash_wholesale_td_html = '<td style="vertical-align: middle; text-align: center;">'.number_format($nav_cash_wholesale, 2).'</td>';
                }
                // ========================================================================================================================
                $html.=' 
                        <tr style="word-wrap:break-word;">
                            <td style="vertical-align: middle; text-align: left;">'.$staff_name.'</td>
                            <td style="vertical-align: middle; text-align: left;">'.$location_array.'</td>
                            <td style="vertical-align: middle; text-align: center; white-space:nowrap;">'.$cls_terminal_no_array.'</td>
                            <td style="vertical-align: middle; text-align: center; white-space:nowrap;">'.$terminal_counter_no.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_partialcash.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_finalcash.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_total_cash.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$nav_partialcash_color.'">'.$nav_partialcash.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$nav_cash_color.'">'.number_format($nav_cash, 2).'</td>
                            '.$cash_wholesale_td_html.'
                            <td style="vertical-align: middle; text-align: center;">'.$nav_total_cash.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$variance_color.'">'.$cash_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_bankcard.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$nav_bankcard_color.'">'.$nav_bankcard.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$bc_variance_color.'">'.$bc_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_giftcheck.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$nav_giftcheck_color.'">'.$nav_giftcheck.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$gc_variance_color.'">'.$giftcheck_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_crmredeem.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$nav_crmredeem_color.'">'.$nav_crmredeem.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$crmredeem_variance_color.'">'.$crmredeem_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_atp.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$nav_atp_color.'">'.$nav_atp.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$atp_variance_color.'">'.$atp_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_empcredit.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$nav_emp_credit_color.'">'.$nav_emp_chargeCredit.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$empcredit_variance_color.'">'.$empcredit_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_po.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$nav_po_color.'">'.$nav_po.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$po_variance_color.'">'.$po_variance.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$cls_ihcc.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$nav_ihcc_color.'">'.$nav_ihcc.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$ihcc_variance_color.'">'.$ihcc_variance.'</td>
                            '.$additional_body_html.'
                            <td style="vertical-align: middle; text-align: center;">'.$cls_netAmount.'</td>
                            <td style="vertical-align: middle; text-align: center;">'.$net_amount.'</td>
                            <td style="vertical-align: middle; text-align: center; '.$total_variance_color.'">'.$total_variance.'</td>
                        </tr>
                        '; 
            }
            // =============================================================================================================================================
            $additional_footer_html = array(); 
            $footer_store = '';
            for($b=0; $b<count($other_noncash_mop_array); $b++) 
            {
                $cls_other_noncash = $this->accounting_model->get_cls_other_noncash_total_model($_POST['sales_date'],$_POST['dcode'],$other_noncash_mop_array[$b]);
                $cls_other_mop_total = 0;
                if(!empty($cls_other_noncash))
                {
                    $cls_other_mop_total = $cls_other_noncash;
                }
                // ===========================================================================================================================================
                $footer_tenderType = '';
                $footer_store = explode('-', $_POST['store_no']);
                if($footer_store[0] == 'ICM')
                {
                    $icm_tenderType = $this->accounting_model->get_icm_tender_code_model_v2($other_noncash_mop_array[$b]);
                    if(!empty($icm_tenderType))
                    {
                        $footer_tenderType = $icm_tenderType->mop_code;
                    }
                }
                else if($footer_store[0] == 'ASC')
                {
                    $asc_tenderType = $this->accounting_model->get_asc_tender_code_model_v2($other_noncash_mop_array[$b]);
                    if(!empty($asc_tenderType))
                    {
                        $footer_tenderType = $asc_tenderType->mop_code;
                    }
                }
                else if($footer_store[0] == 'PM')
                {
                    $pm_tenderType = $this->accounting_model->get_pm_tender_code_model_v2($other_noncash_mop_array[$b]);
                    if(!empty($pm_tenderType))
                    {
                        $footer_tenderType = $pm_tenderType->mop_code;
                    }
                }
                // =================================================================================================================================================
                $nav_other_noncash = $this->accounting_model->get_adjusted_nav_other_noncash_total_model_v2($_POST['sales_date'],$store_no_array,$_POST['dcode'],$footer_tenderType);
                $nav_other_mop_total = 0;
                if(!empty($nav_other_noncash))
                {
                    $nav_other_mop_total = $nav_other_noncash;
                }
                // ===================================================================================================================================
                $navcls_other_mop_total_variance_color = 'color: green;';
                $navcls_other_mop_total_variance = bcsub($cls_other_mop_total, $nav_other_mop_total, 4);
                if($navcls_other_mop_total_variance < 0)
                {
                    $navcls_other_mop_total_variance_color = 'color: red;';
                    $navcls_other_mop_total_variance = preg_replace('/-/', "", $navcls_other_mop_total_variance);
                    $navcls_other_mop_total_variance = '('.number_format($navcls_other_mop_total_variance, 2).')';
                }
                else
                {
                    $navcls_other_mop_total_variance = number_format($navcls_other_mop_total_variance, 2);
                }
                $cls_other_mop_total = number_format($cls_other_mop_total, 2); 
                $nav_other_mop_total = number_format($nav_other_mop_total, 2); 
                // ============================================================================================================================================
                array_push($additional_footer_html, '<td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_other_mop_total.'</td>
                                                     <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_other_mop_total.'</td>
                                                     <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_other_mop_total_variance_color.'">'.$navcls_other_mop_total_variance.'</td>');
            }
            $additional_footer_html = implode("",$additional_footer_html);
            // ================================================================================================================================================
            $cls_cash_total = $cls_partialcash2 + $cls_finalcash2;
            $nav_cash_total = $nav_partialcash2 + $nav_cash2;
            $navcls_total_variance_color = 'color: green;';
            $navcls_total_variance = bcsub($cls_cash_total, $nav_cash_total, 4);
            if($navcls_total_variance < 0)
            {
                $navcls_total_variance_color = 'color: red;';
                $navcls_total_variance = preg_replace('/-/', "", $navcls_total_variance);
                $navcls_total_variance = '('.number_format($navcls_total_variance, 2).')';
            }
            else
            {
                $navcls_total_variance = number_format($navcls_total_variance, 2);
            }
            $cls_cash_total = number_format($cls_cash_total, 2);
            $nav_cash_total = number_format($nav_cash_total, 2);
            $cls_partialcash2 = number_format($cls_partialcash2, 2);
            $cls_finalcash2 = number_format($cls_finalcash2, 2);
            $nav_partialcash2 = number_format($nav_partialcash2, 2);
            // ==================================================================================================================================================
            $navcls_bankcard_total_variance_color = 'color: green;';
            $navcls_bankcard_total_variance = bcsub($cls_bankcard2, $nav_bankcard3, 4);
            if($navcls_bankcard_total_variance < 0)
            {
                $navcls_bankcard_total_variance_color = 'color: red;';
                $navcls_bankcard_total_variance = preg_replace('/-/', "", $navcls_bankcard_total_variance);
                $navcls_bankcard_total_variance = '('.number_format($navcls_bankcard_total_variance, 2).')';
            }
            else
            {
                $navcls_bankcard_total_variance = number_format($navcls_bankcard_total_variance, 2);
            }
            $cls_bankcard2 = number_format($cls_bankcard2, 2); 
            $nav_bankcard3 = number_format($nav_bankcard3, 2); 
            // ==================================================================================================================================================
            $navcls_giftcheck_total_variance_color = 'color: green;';
            $navcls_giftcheck_total_variance = bcsub($cls_giftcheck2, $nav_giftcheck2, 4);
            if($navcls_giftcheck_total_variance < 0)
            {
                $navcls_giftcheck_total_variance_color = 'color: red;';
                $navcls_giftcheck_total_variance = preg_replace('/-/', "", $navcls_giftcheck_total_variance);
                $navcls_giftcheck_total_variance = '('.number_format($navcls_giftcheck_total_variance, 2).')';
            }
            else
            {
                $navcls_giftcheck_total_variance = number_format($navcls_giftcheck_total_variance, 2);
            }
            $cls_giftcheck2 = number_format($cls_giftcheck2, 2); 
            $nav_giftcheck2 = number_format($nav_giftcheck2, 2); 
            // ==================================================================================================================================================
            $navcls_crmredeem_total_variance_color = 'color: green;';
            $navcls_crmredeem_total_variance = bcsub($cls_crmredeem2, $nav_crmredeem2, 4);
            if($navcls_crmredeem_total_variance < 0)
            {
                $navcls_crmredeem_total_variance_color = 'color: red;';
                $navcls_crmredeem_total_variance = preg_replace('/-/', "", $navcls_crmredeem_total_variance);
                $navcls_crmredeem_total_variance = '('.number_format($navcls_crmredeem_total_variance, 2).')';
            }
            else
            {
                $navcls_crmredeem_total_variance = number_format($navcls_crmredeem_total_variance, 2);
            }
            $cls_crmredeem2 = number_format($cls_crmredeem2, 2); 
            $nav_crmredeem2 = number_format($nav_crmredeem2, 2); 
            // ==================================================================================================================================================
            $navcls_atp_total_variance_color = 'color: green;';
            $navcls_atp_total_variance = bcsub($cls_atp2, $nav_atp2, 4);
            if($navcls_atp_total_variance < 0)
            {
                $navcls_atp_total_variance_color = 'color: red;';
                $navcls_atp_total_variance = preg_replace('/-/', "", $navcls_atp_total_variance);
                $navcls_atp_total_variance = '('.number_format($navcls_atp_total_variance, 2).')';
            }
            else
            {
                $navcls_atp_total_variance = number_format($navcls_atp_total_variance, 2);
            }
            $cls_atp2 = number_format($cls_atp2, 2); 
            $nav_atp2 = number_format($nav_atp2, 2); 
            // ==================================================================================================================================================
            $navcls_empcredit_total_variance_color = 'color: green;';
            $navcls_empcredit_total_variance = bcsub($cls_empcredit2, $nav_emp_chargeCredit2, 4);
            if($navcls_empcredit_total_variance < 0)
            {
                $navcls_empcredit_total_variance_color = 'color: red;';
                $navcls_empcredit_total_variance = preg_replace('/-/', "", $navcls_empcredit_total_variance);
                $navcls_empcredit_total_variance = '('.number_format($navcls_empcredit_total_variance, 2).')';
            }
            else
            {
                $navcls_empcredit_total_variance = number_format($navcls_empcredit_total_variance, 2);
            }
            $cls_empcredit2 = number_format($cls_empcredit2, 2); 
            $nav_emp_chargeCredit2 = number_format($nav_emp_chargeCredit2, 2); 
            // ==================================================================================================================================================
            $navcls_po_total_variance_color = 'color: green;';
            $navcls_po_total_variance = bcsub($cls_po2, $nav_po2, 4);
            if($navcls_po_total_variance < 0)
            {
                $navcls_po_total_variance_color = 'color: red;';
                $navcls_po_total_variance = preg_replace('/-/', "", $navcls_po_total_variance);
                $navcls_po_total_variance = '('.number_format($navcls_po_total_variance, 2).')';
            }
            else
            {
                $navcls_po_total_variance = number_format($navcls_po_total_variance, 2);
            }
            $cls_po2 = number_format($cls_po2, 2); 
            $nav_po2 = number_format($nav_po2, 2); 
            // ==================================================================================================================================================
            $navcls_ihcc_total_variance_color = 'color: green;';
            $navcls_ihcc_total_variance = bcsub($cls_ihcc2, $nav_ihcc2, 4);
            if($navcls_ihcc_total_variance < 0)
            {
                $navcls_ihcc_total_variance_color = 'color: red;';
                $navcls_ihcc_total_variance = preg_replace('/-/', "", $navcls_ihcc_total_variance);
                $navcls_ihcc_total_variance = '('.number_format($navcls_ihcc_total_variance, 2).')';
            }
            else
            {
                $navcls_ihcc_total_variance = number_format($navcls_ihcc_total_variance, 2);
            }
            $cls_ihcc2 = number_format($cls_ihcc2, 2); 
            $nav_ihcc2 = number_format($nav_ihcc2, 2); 
            // ==================================================================================================================================================
            $navcls_footer_total_variance_color = 'color: green;';
            $navcls_footer_total_variance = bcsub($cls_netAmount3, $nav_total_amount, 4);
            if($navcls_footer_total_variance < 0)
            {
                $navcls_footer_total_variance_color = 'color: red;';
                $navcls_footer_total_variance = preg_replace('/-/', "", $navcls_footer_total_variance);
                $navcls_footer_total_variance = '('.number_format($navcls_footer_total_variance, 2).')';
            }
            else
            {
                $navcls_footer_total_variance = number_format($navcls_footer_total_variance, 2);
            }
            $cls_netAmount3 = number_format($cls_netAmount3, 2); 
            $nav_total_amount = number_format($nav_total_amount, 2); 
            // ==================================================================================================================================================
            $cash_wholesale_ft_html = '';
            if($nav_colspan == 4)
            {
                $nav_cash2 = bcsub($nav_cash2, $total_nav_cash_wholesale, 4);
                $cash_wholesale_ft_html = '<td style="vertical-align: middle; text-align: center; font-weight: bold;">'.number_format($total_nav_cash_wholesale, 2).'</td>';
            }
            // ==================================================================================================================================================
            $html.=' 
                        <tr style="word-wrap:break-word;">
                            <td style="vertical-align: middle; text-align: center;"><span hidden>zzzzzzzzzzzzzzzz</span></td>
                            <td style="vertical-align: middle; text-align: center;"></td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;"></td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">TOTAL</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_partialcash2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_finalcash2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_cash_total.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_partialcash2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.number_format($nav_cash2, 2).'</td>
                            '.$cash_wholesale_ft_html.'
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_cash_total.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_total_variance_color.'">'.$navcls_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_bankcard2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_bankcard3.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_bankcard_total_variance_color.'">'.$navcls_bankcard_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_giftcheck2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_giftcheck2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_giftcheck_total_variance_color.'">'.$navcls_giftcheck_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_crmredeem2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_crmredeem2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_crmredeem_total_variance_color.'">'.$navcls_crmredeem_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_atp2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_atp2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_atp_total_variance_color.'">'.$navcls_atp_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_empcredit2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_emp_chargeCredit2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_empcredit_total_variance_color.'">'.$navcls_empcredit_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_po2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_po2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_po_total_variance_color.'">'.$navcls_po_total_variance.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_ihcc2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_ihcc2.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_ihcc_total_variance_color.'">'.$navcls_ihcc_total_variance.'</td>
                            '.$additional_footer_html.'
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$cls_netAmount3.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold;">'.$nav_total_amount.'</td>
                            <td style="vertical-align: middle; text-align: center; font-weight: bold; '.$navcls_footer_total_variance_color.'">'.$navcls_footer_total_variance.'</td>
                        </tr>  
                        </tbody>        
                    </table>
                    ';
            // ============================================================================================================================================
            $sales_date_str = strtotime($_POST['sales_date']);
            $sales_date_str = date("F d, Y",$sales_date_str);

            $data['buDeptName']=$_POST['bname'].'&nbsp;/&nbsp;'.$_POST['dname'] ;                        
            $data['sales_date']=$sales_date_str;                   
            $data['mop_html']=$mop_html_array;            
            $data['html']=$html;              
            echo json_encode($data);
        }
    }

    public function view_variance_navcls_ctrl2()
    {
        if(empty($_SESSION['emp_id']))
		{
			$message = "EXPIRED SESSION";
			echo json_encode($message);
		}
		else
        {
            $html='
                    <table class="table table-bordered table-hover table-condensed display" id="navcls_variance_table">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;" rowspan="2">
                                    <center>TERMINAL & COUNTER NO.</center>
                                </th>                                                            
                                <th style="vertical-align: middle;" rowspan="2">
                                    <center>CASHIER\'S NAME</center>
                                </th>
                                <th style="vertical-align: middle;" colspan="12" scope="colgroup">
                                    <center>NAVISION VS CASHIER\'S LIQUIDATION SYSTEM</center>
                                </th>                    
                            </tr>
                            <tr style="border-top: outset;">
                                <th style="vertical-align: middle;" scope="col"><center>CASH</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>BANK CARD</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>GIFT CHECKS</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>TENDER REMOVE<br>/ FLOAT</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>CRM Redeem</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>A.T.P</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>EMP CHARGE<br>/ CREDIT</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>PO<br>(Credit)</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>IHCC<br>(Credit)</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>OTHER PAYMENTS</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>TOTAL</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>VARIANCE</center></th>
                            </tr>
                        </thead>
                    ';
            $nav_data = $this->accounting_model->get_uploaded_navdata_model2($_POST['sales_date'],$_POST['store_no']);
            $terminal_counter_no = '';
            $tr_no = '';
            $bcode = '';
            $dcode = '';
            $staff_name = '';
            $staff_emp_id = '';
            $staff_id = '';
            $net_amount = 0;
            $net_amount2 = 0;
            $overall_amount = 0;
            $nav_cash = 0;
            $nav_cash2 = 0;
            $nav_bankcard = 0;
            $nav_bankcard2 = 0;
            $nav_bankcard3 = 0;
            $nav_giftcheck = 0;
            $nav_giftcheck2 = 0;
            $nav_partialcash = 0;
            $nav_partialcash2 = 0;
            $nav_crmredeem = 0;
            $nav_crmredeem2 = 0;
            $nav_atp = 0;
            $nav_atp2 = 0;
            $nav_emp_chargeCredit = 0;
            $nav_emp_chargeCredit2 = 0;
            $nav_po = 0;
            $nav_po2 = 0;
            $nav_ihcc = 0;
            $nav_ihcc2 = 0;
            $nav_otherpayment = 0;
            $nav_otherpayment2 = 0;
            $nav_color = 'style="color: blue;"';
            // =================================================================================
            $cls_finalcash2 = 0;
            $cls_bankcard2 = 0;
            $cls_giftcheck2 = 0;
            $cls_partialcash2 = 0;
            $cls_crmredeem2 = 0;
            $cls_atp2 = 0;
            $cls_empcredit2 = 0;
            $cls_po2 = 0;
            $cls_ihcc2 = 0;
            $cls_otherpayment2 = 0;
            $cls_netAmount2 = 0;
            $cls_netAmount3 = 0;
            foreach($nav_data as $nav)
            {
                $staff_terminal_counter = $this->accounting_model->get_staff_terminal_counter_model2($_POST['sales_date'],$nav['staff_id']);
                $store_no = '';
                $terminal_amount = '';
                $pos_terminal_no = array();
                foreach($staff_terminal_counter as $tcno)
                {
                    $store_no = $tcno['store_no'];
                    $terminal_counter_amount = $this->accounting_model->get_terminal_counter_amount_model2($_POST['sales_date'],$nav['staff_id'],$tcno['pos_terminal_no']);
                    $terminal_amount = number_format($terminal_counter_amount, 2);
                    array_push($pos_terminal_no, $tcno['pos_terminal_no'].' | '.$terminal_amount.'<br>');
                }
                // ==============================================================================================================================================
                $staff_info = $this->accounting_model->get_staff_info_model($nav['staff_id']);
                if(empty($staff_info))
                {
                    $staff_id = $nav['staff_id'] * 1;
                    $staff_info2 = $this->accounting_model->get_staff_info_model($staff_id);
                    if(!empty($staff_info2))
                    {
                        $staff_name = $staff_info2->name;
                        $staff_emp_id = $staff_info2->emp_id;
                    }
                }
                else
                {
                    $staff_name = $staff_info->name;
                }
                // ==============================================================================================================================================
                $staff_net_amount = $this->accounting_model->get_staff_net_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($staff_net_amount))
                {
                    $net_amount2 = $staff_net_amount->amount;
                    $net_amount = $staff_net_amount->amount;
                    $net_amount = number_format($net_amount, 2);
                    $overall_amount += $staff_net_amount->amount;
                }
                // ==============================================================================================================================================
                $navcash_tender_type = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],1);
                if(!empty($navcash_tender_type))
                {
                    $nav_cash2 += $navcash_tender_type->type_amount;
                    $nav_cash = $navcash_tender_type->type_amount;
                    $nav_cash = number_format($nav_cash, 2);
                }
                // ==============================================================================================================================================
                $nav_bankcard_tender_type = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],3);
                $nav_bankcard_color = 'style="color: blue;"';
                if(!empty($nav_bankcard_tender_type))
                {
                    $nav_bankcard3 += $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard2 = $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard = $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard = number_format($nav_bankcard, 2);
                    // ============================================================
                    if($nav_bankcard_tender_type->status == 'ADJUSTED')
                    {
                        $nav_bankcard_color = 'style="color: magenta;"';
                    }
                }
                // ==============================================================================================================================================
                $nav_giftcheck_tender_type = $this->accounting_model->get_giftcheck_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                $nav_giftcheck_color = 'style="color: blue;"';
                if(!empty($nav_giftcheck_tender_type))
                {
                    $nav_giftcheck2 += $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck = $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck = number_format($nav_giftcheck, 2);
                    // ============================================================
                    if($nav_giftcheck_tender_type->status == 'ADJUSTED')
                    {
                        $nav_giftcheck_color = 'style="color: magenta;"';
                    }
                }
                // ==============================================================================================================================================
                $nav_partialcash_tender_type = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],9);
                if(!empty($nav_partialcash_tender_type))
                {
                    $nav_partialcash2 += $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash = $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash = number_format($nav_partialcash, 2);
                }
                // ==============================================================================================================================================
                $nav_crmredeem_tender_type = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],28);
                $nav_crmredeem_color = 'style="color: blue;"';
                if(!empty($nav_crmredeem_tender_type))
                {
                    $nav_crmredeem2 = $nav_crmredeem_tender_type->type_amount;
                    $nav_crmredeem = $nav_crmredeem_tender_type->type_amount;
                    $nav_crmredeem = number_format($nav_crmredeem, 2);
                    // ============================================================
                    if($nav_crmredeem_tender_type->status == 'ADJUSTED')
                    {
                        $nav_crmredeem_color = 'style="color: magenta;"';
                    }
                }
                // ==============================================================================================================================================
                $nav_atp_tender_type = $this->accounting_model->get_atp_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                $nav_atp_color = 'style="color: blue;"';
                if(!empty($nav_atp_tender_type))
                {
                    $nav_atp2 += $nav_atp_tender_type->type_amount;
                    $nav_atp = $nav_atp_tender_type->type_amount;
                    $nav_atp = number_format($nav_atp, 2);
                    // ============================================================
                    if($nav_atp_tender_type->status == 'ADJUSTED')
                    {
                        $nav_atp_color = 'style="color: magenta;"';
                    }
                }
                // ==============================================================================================================================================
                $nav_emp_chargeCredit_tender_type = $this->accounting_model->get_empChargeCredit_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                $nav_emp_chargeCredit_color = 'style="color: blue;"';
                if(!empty($nav_emp_chargeCredit_tender_type))
                {
                    $nav_emp_chargeCredit2 += $nav_emp_chargeCredit_tender_type->type_amount;
                    $nav_emp_chargeCredit = $nav_emp_chargeCredit_tender_type->type_amount;
                    $nav_emp_chargeCredit = number_format($nav_emp_chargeCredit, 2);
                    // ============================================================
                    if($nav_emp_chargeCredit_tender_type->status == 'ADJUSTED')
                    {
                        $nav_emp_chargeCredit_color = 'style="color: magenta;"';
                    }
                }
                // ==============================================================================================================================================
                $nav_po_tender_type = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],14);
                $nav_po_color = 'style="color: blue;"';
                if(!empty($nav_po_tender_type))
                {
                    $nav_po2 += $nav_po_tender_type->type_amount;
                    $nav_po = $nav_po_tender_type->type_amount;
                    $nav_po = number_format($nav_po, 2);
                    // ============================================================
                    if($nav_po_tender_type->status == 'ADJUSTED')
                    {
                        $nav_po_color = 'style="color: magenta;"';
                    }
                }
                // ==============================================================================================================================================
                $nav_ihcc_tender_type = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],15);
                $nav_ihcc_color = 'style="color: blue;"';
                if(!empty($nav_ihcc_tender_type))
                {
                    $nav_ihcc2 += $nav_ihcc_tender_type->type_amount;
                    $nav_ihcc = $nav_ihcc_tender_type->type_amount;
                    $nav_ihcc = number_format($nav_ihcc, 2);
                    // ============================================================
                    if($nav_ihcc_tender_type->status == 'ADJUSTED')
                    {
                        $nav_ihcc_color = 'style="color: magenta;"';
                    }
                }
                // ==============================================================================================================================================
                $nav_otherpayment_tender_type = $this->accounting_model->get_otherpayment_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                $nav_otherpayment_color = 'style="color: blue;"';
                if(!empty($nav_otherpayment_tender_type))
                {
                    $nav_otherpayment2 += $nav_otherpayment_tender_type->type_amount;
                    $nav_otherpayment = $nav_otherpayment_tender_type->type_amount;
                    $nav_otherpayment = number_format($nav_otherpayment, 2);
                    // ============================================================
                    if($nav_otherpayment_tender_type->status == 'ADJUSTED')
                    {
                        $nav_otherpayment_color = 'style="color: magenta;"';
                    }
                }
                $nav_other_tender_type = $this->accounting_model->get_other_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                $paymentTypeAndAmount = '';
                $br = '';
                if(!empty($nav_other_tender_type))
                {
                    $nav_othertype_array = array();
                    $nav_othertype = '';
                    $store = '';
                    $tenderTypeName = '';
                    foreach($nav_other_tender_type as $othertype)
                    {
                        $store = explode('-', $_POST['store_no']);
                        if($store[0] == 'ICM')
                        {
                            $icm_tenderTypeName = $this->accounting_model->get_icm_tender_name_model($othertype['other_type']);
                            if(!empty($icm_tenderTypeName))
                            {
                                $tenderTypeName = $icm_tenderTypeName->icm_payment_name;
                            }
                        }
                        else if($store[0] == 'ASC')
                        {
                            $asc_tenderTypeName = $this->accounting_model->get_asc_tender_name_model($othertype['other_type']);
                            if(!empty($asc_tenderTypeName))
                            {
                                $tenderTypeName = $asc_tenderTypeName->asc_payment_name;
                            }
                        }
                        else if($store[0] == 'PM')
                        {
                            $pm_tenderTypeName = $this->accounting_model->get_pm_tender_name_model($othertype['other_type']);
                            if(!empty($pm_tenderTypeName))
                            {
                                $tenderTypeName = $pm_tenderTypeName->pm_payment_name;
                            }
                        }

                        $nav_othertype_data = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],$othertype['other_type']);
                        $nav_othertype = $nav_othertype_data->type_amount;
                        if($nav_othertype > 0)
                        {
                            $nav_othertype = $tenderTypeName.'|'.$nav_othertype;
                            array_push($nav_othertype_array, $nav_othertype);
                        }
                    }

                    if(!empty($nav_othertype_array))
                    {
                        $br = '<br>';
                        $paymentTypeAndAmount = implode('<br>', $nav_othertype_array);
                        $paymentTypeAndAmount = '('.$paymentTypeAndAmount.')';
                    }
                }
                // ===================================================================================================================================================
                $bu_data = $this->accounting_model->get_bcode_model($_POST['bname']);
                if(!empty($bu_data))
                {
                    $bcode = $bu_data->bcode;
                }
                $dept_data = $this->accounting_model->get_dcode_model($bcode,$_POST['dname']);
                if(!empty($dept_data))
                {
                    $dcode = $dept_data->dcode;
                }
                $cebo_cs_denomination_data = $this->accounting_model->get_cebo_cs_denomination_model($staff_emp_id,$_POST['sales_date'],$dcode);
                $cls_netAmount = '<br> 0.00';
                if(!empty($cebo_cs_denomination_data))
                {
                    $tr_no = $cebo_cs_denomination_data->tr_no;
                    $cls_netAmount3 += $cebo_cs_denomination_data->total_denomination;
                    $cls_netAmount2 = $cebo_cs_denomination_data->total_denomination;
                    $cls_netAmount = $cebo_cs_denomination_data->total_denomination;
                    $cls_netAmount = '<br>'.number_format($cls_netAmount, 2);
                }
                // ===============================================================================================
                $cls_bankcard = '<br> 0.00';
                $bankcard_color = 'style="color: green;"';
                $cls_giftcheck = '<br> 0.00';
                $cls_crmredeem = '<br> 0.00';
                $cls_atp = '<br> 0.00';
                $cls_empcredit = '<br> 0.00';
                $cls_po = '<br> 0.00';
                $cls_ihcc = '<br> 0.00';
                $cls_finalcash = '<br> 0.00';
                $cls_partialcash = '<br> 0.00';
                $cls_otherpayment = '';
                $cls_otherpayment_total = 0;
                $netAmount_variance = 0;
                $bankcard_variance = '';
                $netAmount_variance_color = '';
                if($tr_no != '')
                {
                    $final_cash = $this->accounting_model->get_final_cash_model($tr_no,$staff_emp_id);
                    if(!empty($final_cash))
                    {
                        $cls_finalcash2 += $final_cash->total_cash;
                        $cls_finalcash = $final_cash->total_cash;
                        $cls_finalcash = '<br>'.number_format($cls_finalcash, 2);
                    }
                    $partial_cash = $this->accounting_model->get_partial_cash_model($tr_no,$staff_emp_id);
                    if(!empty($partial_cash))
                    {
                        $cls_partialcash2 += $partial_cash->total_pcash;
                        $cls_partialcash = $partial_cash->total_pcash;
                        $cls_partialcash = '<br>'.number_format($cls_partialcash, 2);
                    }
                    $cls_cashier_noncash_data = $this->accounting_model->get_cs_cashier_noncashden_model($tr_no,$staff_emp_id);
                    foreach($cls_cashier_noncash_data as $noncash)
                    {
                        if($noncash['mop_name'] == 'COMMERCIAL CARDS')
                        {
                            $cls_bankcard2 += $noncash['noncash_amount'];
                            $cls_bankcard = '<br>'.number_format($noncash['noncash_amount'], 2);
                            $bankcard_variance = $noncash['noncash_amount'] - $nav_bankcard2;
                            if($bankcard_variance < 0)
                            {
                                $bankcard_variance = explode("-",$bankcard_variance);
                                $bankcard_variance = implode("",$bankcard_variance);
                                $bankcard_color = 'style="color: red;"';
                            }
                            $bankcard_variance = '<br>'.'<label '.$bankcard_color.'>('.number_format($bankcard_variance, 2).')</label>';
                        }
                        if($noncash['mop_name'] == 'CORPORATE GIFT CHECK')
                        {
                            $cls_giftcheck2 += $noncash['noncash_amount'];
                            $cls_giftcheck = '<br>'.number_format($noncash['noncash_amount'], 2);
                        }
                        if($noncash['mop_name'] == 'CRM REDEEM')
                        {
                            $cls_crmredeem2 += $noncash['noncash_amount'];
                            $cls_crmredeem = '<br>'.number_format($noncash['noncash_amount'], 2);
                        }
                        $atp_array = array('CHECK EXCHANGE (ATP)','ATP');
                        if(in_array($noncash['mop_name'], $atp_array))
                        {
                            $cls_atp2 += $noncash['noncash_amount'];
                            $cls_atp = '<br>'.number_format($noncash['noncash_amount'], 2);
                        }
                        if($noncash['mop_name'] == 'EMPLOYEES CREDIT')
                        {
                            $cls_empcredit2 += $noncash['noncash_amount'];
                            $cls_empcredit = '<br>'.number_format($noncash['noncash_amount'], 2);
                        }
                        $po_array = array('P.O','PO','P.O CARD','PO CARD');
                        if(in_array($noncash['mop_name'], $po_array))
                        {
                            $cls_po2 += $noncash['noncash_amount'];
                            $cls_po = '<br>'.number_format($noncash['noncash_amount'], 2);
                        }
                        if($noncash['mop_name'] == 'IHCC')
                        {
                            $cls_ihcc2 += $noncash['noncash_amount'];
                            $cls_ihcc = '<br>'.number_format($noncash['noncash_amount'], 2);
                        }
                        $exclude = array('COMMERCIAL CARDS','CORPORATE GIFT CHECK','CRM REDEEM','CHECK EXCHANGE (ATP)','ATP','EMPLOYEES CREDIT','P.O','PO','P.O CARD','PO CARD','IHCC');
                        if(!in_array($noncash['mop_name'], $exclude))
                        { 
                            $cls_otherpayment2 += $noncash['noncash_amount'];  
                            $cls_otherpayment .= $noncash['mop_name'].'|'.number_format($noncash['noncash_amount'], 2).'<br>';
                            $cls_otherpayment_total += $noncash['noncash_amount'];  
                        }
                    }
                }
                // ===========================================================================================================================
                if($cls_bankcard == '<br> 0.00')
                {
                    $bankcard_color = 'style="color: red;"';
                    $bankcard_variance = '<br>'.'<label '.$bankcard_color.'>('.number_format($nav_bankcard2, 2).')</label>';
                }
                // ============================================================================================================================
                if($cls_otherpayment == '')
                {
                    $cls_otherpayment = '';
                    $cls_otherpayment_total = '<br> 0.00';
                }
                else
                {
                    $cls_otherpayment = substr_replace($cls_otherpayment ,"",-4);
                    $cls_otherpayment = '<br>('.$cls_otherpayment.')';
                    $cls_otherpayment_total = '<br>'.number_format($cls_otherpayment_total, 2);
                }
                // =============================================================================================================================
                if($cls_netAmount == '<br> 0.00')
                {
                    $netAmount_variance = 'NO CLS DATA';
                    $netAmount_variance_color = 'style="color: blue;"';
                }
                else
                {
                    $netAmount_variance = $cls_netAmount2 - $net_amount2;
                    if($netAmount_variance < 0)
                    {
                        $netAmount_variance = preg_replace('/-/', "", $netAmount_variance);
                        $netAmount_variance = 'SHORT<br>'.number_format($netAmount_variance, 2);
                        $netAmount_variance_color = 'style="color: red;"';
                    }
                    else if($netAmount_variance > 0)
                    {
                        $netAmount_variance = 'OVER<br>'.number_format($netAmount_variance, 2);
                        $netAmount_variance_color = 'style="color: green;"';
                    }
                    else
                    {
                        $netAmount_variance = 'PERFECT<br>'.number_format($netAmount_variance, 2);
                        $netAmount_variance_color = 'style="color: green;"';
                    }
                }
                // ==================================================================================================================================================
                $terminal_counter_no = implode('', $pos_terminal_no);
                $terminal_counter_no = substr_replace($terminal_counter_no ,"",-4);
                $terminal_counter_no = $store_no.'<br>'.$terminal_counter_no;
                // ===================================================================================================================================================
                $html.=' 
                        <tr style="word-wrap:break-word;">
                            <td style="vertical-align: middle; text-align: center;">
                                '.$terminal_counter_no.'
                            </td>
                            <td style="vertical-align: middle; text-align: left;">
                                '.$staff_name.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_cash.'</span>'.$cls_finalcash.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_bankcard_color.'>'.$nav_bankcard.'</span>'.$cls_bankcard.$bankcard_variance.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_giftcheck_color.'>'.$nav_giftcheck.'</span>'.$cls_giftcheck.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_partialcash.'</span>'.$cls_partialcash.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_crmredeem_color.'>'.$nav_crmredeem.'</span>'.$cls_crmredeem.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_atp_color.'>'.$nav_atp.'</span>'.$cls_atp.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_emp_chargeCredit_color.'>'.$nav_emp_chargeCredit.'</span>'.$cls_empcredit.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_po_color.'>'.$nav_po.'</span>'.$cls_po.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_ihcc_color.'>'.$nav_ihcc.'</span>'.$cls_ihcc.'
                            </td>
                            <td style="vertical-align: middle; text-align: center; font-size: 11px;">
                                '.'<span '.$nav_otherpayment_color.'>'.$paymentTypeAndAmount.$br.$nav_otherpayment.'</span>'.'
                                '.$cls_otherpayment.$cls_otherpayment_total.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$net_amount.'</span>'.$cls_netAmount.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                <lable '.$netAmount_variance_color.'>'.$netAmount_variance.'</label>
                            </td>
                        </tr>
                        '; 
            }
            $nav_cash2 = number_format($nav_cash2, 2);
            $nav_bankcard3 = number_format($nav_bankcard3, 2);
            $nav_giftcheck2 = number_format($nav_giftcheck2, 2);
            $nav_partialcash2 = number_format($nav_partialcash2, 2);
            $nav_crmredeem2 = number_format($nav_crmredeem2, 2);
            $nav_atp2 = number_format($nav_atp2, 2);
            $nav_emp_chargeCredit2 = number_format($nav_emp_chargeCredit2, 2);
            $nav_po2 = number_format($nav_po2, 2);
            $nav_ihcc2 = number_format($nav_ihcc2, 2);
            $nav_otherpayment2 = number_format($nav_otherpayment2, 2);
            $cls_finalcash2 = '<br>'.number_format($cls_finalcash2, 2);
            $cls_bankcard2 = '<br>'.number_format($cls_bankcard2, 2);
            $cls_giftcheck2 = '<br>'.number_format($cls_giftcheck2, 2);
            $cls_partialcash2 = '<br>'.number_format($cls_partialcash2, 2);
            $cls_crmredeem2 = '<br>'.number_format($cls_crmredeem2, 2);
            $cls_atp2 = '<br>'.number_format($cls_atp2, 2);
            $cls_empcredit2 = '<br>'.number_format($cls_empcredit2, 2);
            $cls_po2 = '<br>'.number_format($cls_po2, 2);
            $cls_ihcc2 = '<br>'.number_format($cls_ihcc2, 2);
            $cls_otherpayment2 = '<br>'.number_format($cls_otherpayment2, 2);
            $cls_netAmount3 = '<br>'.number_format($cls_netAmount3, 2);
            $overall_amount = number_format($overall_amount, 2);
            $html.=' 
                                <tr style="word-wrap:break-word;">
                                    <td style="vertical-align: middle; text-align: center;">
                                    
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <span hidden>zzzzzzzz</span>TOTAL
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_cash2.'</span>'.$cls_finalcash2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_bankcard3.'</span>'.$cls_bankcard2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_giftcheck2.'</span>'.$cls_giftcheck2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_partialcash2.'</span>'.$cls_partialcash2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_crmredeem2.'</span>'.$cls_crmredeem2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_atp2.'</span>'.$cls_atp2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_emp_chargeCredit2.'</span>'.$cls_empcredit2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_po2.'</span>'.$cls_po2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_ihcc2.'</span>'.$cls_ihcc2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_otherpayment2.'</span>'.$cls_otherpayment2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: left;">
                                        '.'<span '.$nav_color.'>'.$overall_amount.'</span>'.$cls_netAmount3.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                    
                                    </td>
                                </tr>          
                        </table>
                    ';

            $title = '
                    <form>
                        <center>
                            <label>NAVISION VS CASHIER\'S LIQUIDATION SYSTEM</label>
                        </center>
                    </form>
                    ';
            
            $data['navcls_title']=$title;               
            $data['buDeptName']=$_POST['bname'].'&nbsp;/&nbsp;'.$_POST['dname'] ;               
            $data['sales_date']=$_POST['sales_date'];               
            $data['html']=$html;              
            echo json_encode($data);
        }
    }

    public function view_variance_navcls_ctrl2_old_V()
    {
        if(empty($_SESSION['emp_id']))
		{
			$message = "EXPIRED SESSION";
			echo json_encode($message);
		}
		else
        {
            $html='
                    <table class="table table-bordered table-hover table-condensed display" id="navcls_variance_table">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;" rowspan="2">
                                    <center>TERMINAL & COUNTER NO.</center>
                                </th>                                                            
                                <th style="vertical-align: middle;" rowspan="2">
                                    <center>CASHIER\'S NAME</center>
                                </th>
                                <th style="vertical-align: middle;" colspan="12" scope="colgroup">
                                    <center>NAVISION VS CASHIER\'S LIQUIDATION SYSTEM</center>
                                </th>                    
                            </tr>
                            <tr style="border-top: outset;">
                                <th style="vertical-align: middle;" scope="col"><center>CASH</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>BANK CARD</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>GIFT CHECKS</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>TENDER REMOVE<br>/ FLOAT</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>CRM Redeem</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>A.T.P</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>EMP CHARGE<br>/ CREDIT</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>PO<br>(Credit)</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>IHCC<br>(Credit)</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>OTHER PAYMENTS</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>TOTAL</center></th>
                                <th style="vertical-align: middle;" scope="col"><center>VARIANCE</center></th>
                            </tr>
                        </thead>
                    ';
            $nav_data = $this->accounting_model->get_uploaded_navdata_model2($_POST['sales_date'],$_POST['store_no']);
            $terminal_counter_no = '';
            $tr_no = '';
            $bcode = '';
            $dcode = '';
            $staff_name = '';
            $staff_emp_id = '';
            $staff_id = '';
            $net_amount = '';
            $net_amount2 = '';
            $overall_amount = '';
            $nav_cash = '';
            $nav_cash2 = '';
            $nav_bankcard = '';
            $nav_bankcard2 = '';
            $nav_bankcard3 = '';
            $nav_giftcheck = '';
            $nav_giftcheck2 = '';
            $nav_partialcash = '';
            $nav_partialcash2 = '';
            $nav_crmredeem = '';
            $nav_crmredeem2 = '';
            $nav_atp = '';
            $nav_atp2 = '';
            $nav_emp_chargeCredit = '';
            $nav_emp_chargeCredit2 = '';
            $nav_po = '';
            $nav_po2 = '';
            $nav_ihcc = '';
            $nav_ihcc2 = '';
            $nav_otherpayment = '';
            $nav_otherpayment2 = '';
            $nav_color = 'style="color: blue;"';
            $cls_finalcash = '<br> 0.00';
            $cls_finalcash2 = '';
            $cls_bankcard2 = '';
            $cls_giftcheck2 = '';
            $cls_partialcash = '<br> 0.00';
            $cls_partialcash2 = '';
            $cls_crmredeem2 = '';
            $cls_atp2 = '';
            $cls_empcredit2 = '';
            $cls_po2 = '';
            $cls_ihcc2 = '';
            $cls_otherpayment2 = '';
            $cls_netAmount = '<br> 0.00';
            $cls_netAmount2 = '';
            $cls_netAmount3 = '';
            $bankcard_variance = '';
            $netAmount_variance = '';
            $netAmount_variance_color = '';
            foreach($nav_data as $nav)
            {
                $staff_terminal_counter = $this->accounting_model->get_staff_terminal_counter_model2($_POST['sales_date'],$nav['staff_id']);
                $store_no = '';
                $terminal_amount = '';
                $pos_terminal_no = array();
                foreach($staff_terminal_counter as $tcno)
                {
                    $store_no = $tcno['store_no'];
                    $terminal_counter_amount = $this->accounting_model->get_terminal_counter_amount_model2($_POST['sales_date'],$nav['staff_id'],$tcno['pos_terminal_no']);
                    $terminal_amount = number_format($terminal_counter_amount, 2);
                    array_push($pos_terminal_no, $tcno['pos_terminal_no'].' | '.$terminal_amount.'<br>');
                }
                // ==============================================================================================================================================
                $staff_info = $this->accounting_model->get_staff_info_model($nav['staff_id']);
                if(empty($staff_info))
                {
                    $staff_id = $nav['staff_id'] * 1;
                    $staff_info2 = $this->accounting_model->get_staff_info_model($staff_id);
                    if(!empty($staff_info2))
                    {
                        $staff_name = $staff_info2->name;
                        $staff_emp_id = $staff_info2->emp_id;
                    }
                }
                else
                {
                    $staff_name = $staff_info->name;
                }
                // ==============================================================================================================================================
                $staff_net_amount = $this->accounting_model->get_staff_net_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($staff_net_amount))
                {
                    $net_amount2 = $staff_net_amount->amount;
                    $net_amount = $staff_net_amount->amount;
                    $net_amount = number_format($net_amount, 2);
                    $overall_amount += $staff_net_amount->amount;
                }
                // ==============================================================================================================================================
                $navcash_tender_type = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],1);
                if(!empty($navcash_tender_type))
                {
                    $nav_cash2 += $navcash_tender_type->type_amount;
                    $nav_cash = $navcash_tender_type->type_amount;
                    $nav_cash = number_format($nav_cash, 2);
                }
                // ==============================================================================================================================================
                $nav_bankcard_tender_type = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],3);
                if(!empty($nav_bankcard_tender_type))
                {
                    $nav_bankcard3 += $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard2 = $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard = $nav_bankcard_tender_type->type_amount;
                    $nav_bankcard = number_format($nav_bankcard, 2);
                }
                // ==============================================================================================================================================
                $nav_giftcheck_tender_type = $this->accounting_model->get_giftcheck_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($nav_giftcheck_tender_type))
                {
                    $nav_giftcheck2 += $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck = $nav_giftcheck_tender_type->type_amount;
                    $nav_giftcheck = number_format($nav_giftcheck, 2);
                }
                // ==============================================================================================================================================
                $nav_partialcash_tender_type = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],9);
                if(!empty($nav_partialcash_tender_type))
                {
                    $nav_partialcash2 += $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash = $nav_partialcash_tender_type->type_amount;
                    $nav_partialcash = number_format($nav_partialcash, 2);
                }
                // ==============================================================================================================================================
                $nav_crmredeem_tender_type = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],28);
                if(!empty($nav_crmredeem_tender_type))
                {
                    $nav_crmredeem2 = $nav_crmredeem_tender_type->type_amount;
                    $nav_crmredeem = $nav_crmredeem_tender_type->type_amount;
                    $nav_crmredeem = number_format($nav_crmredeem, 2);
                }
                // ==============================================================================================================================================
                $nav_atp_tender_type = $this->accounting_model->get_atp_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($nav_atp_tender_type))
                {
                    $nav_atp2 += $nav_atp_tender_type->type_amount;
                    $nav_atp = $nav_atp_tender_type->type_amount;
                    $nav_atp = number_format($nav_atp, 2);
                }
                // ==============================================================================================================================================
                $nav_emp_chargeCredit_tender_type = $this->accounting_model->get_empChargeCredit_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($nav_emp_chargeCredit_tender_type))
                {
                    $nav_emp_chargeCredit2 += $nav_emp_chargeCredit_tender_type->type_amount;
                    $nav_emp_chargeCredit = $nav_emp_chargeCredit_tender_type->type_amount;
                    $nav_emp_chargeCredit = number_format($nav_emp_chargeCredit, 2);
                }
                // ==============================================================================================================================================
                $nav_po_tender_type = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],14);
                if(!empty($nav_po_tender_type))
                {
                    $nav_po2 += $nav_po_tender_type->type_amount;
                    $nav_po = $nav_po_tender_type->type_amount;
                    $nav_po = number_format($nav_po, 2);
                }
                // ==============================================================================================================================================
                $nav_ihcc_tender_type = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],15);
                if(!empty($nav_ihcc_tender_type))
                {
                    $nav_ihcc2 += $nav_ihcc_tender_type->type_amount;
                    $nav_ihcc = $nav_ihcc_tender_type->type_amount;
                    $nav_ihcc = number_format($nav_ihcc, 2);
                }
                // ==============================================================================================================================================
                $nav_otherpayment_tender_type = $this->accounting_model->get_otherpayment_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                if(!empty($nav_otherpayment_tender_type))
                {
                    $nav_otherpayment2 += $nav_otherpayment_tender_type->type_amount;
                    $nav_otherpayment = $nav_otherpayment_tender_type->type_amount;
                    $nav_otherpayment = number_format($nav_otherpayment, 2);
                }
                $nav_other_tender_type = $this->accounting_model->get_other_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id']);
                $paymentTypeAndAmount = '';
                $br = '';
                if(!empty($nav_other_tender_type))
                {
                    $nav_othertype_array = array();
                    $nav_othertype = '';
                    $store = '';
                    $tenderTypeName = '';
                    foreach($nav_other_tender_type as $othertype)
                    {
                        $store = explode('-', $_POST['store_no']);
                        if($store[0] == 'ICM')
                        {
                            $icm_tenderTypeName = $this->accounting_model->get_icm_tender_name_model($othertype['other_type']);
                            if(!empty($icm_tenderTypeName))
                            {
                                $tenderTypeName = $icm_tenderTypeName->icm_payment_name;
                            }
                        }
                        else if($store[0] == 'ASC')
                        {
                            $asc_tenderTypeName = $this->accounting_model->get_asc_tender_name_model($othertype['other_type']);
                            if(!empty($asc_tenderTypeName))
                            {
                                $tenderTypeName = $asc_tenderTypeName->asc_payment_name;
                            }
                        }
                        else if($store[0] == 'PM')
                        {
                            $pm_tenderTypeName = $this->accounting_model->get_pm_tender_name_model($othertype['other_type']);
                            if(!empty($pm_tenderTypeName))
                            {
                                $tenderTypeName = $pm_tenderTypeName->pm_payment_name;
                            }
                        }

                        $nav_othertype_data = $this->accounting_model->get_tender_type_amount_model2($_POST['sales_date'],$_POST['store_no'],$nav['staff_id'],$othertype['other_type']);
                        $nav_othertype = $nav_othertype_data->type_amount;
                        if($nav_othertype > 0)
                        {
                            $nav_othertype = $tenderTypeName.'|'.$nav_othertype;
                            array_push($nav_othertype_array, $nav_othertype);
                        }
                    }

                    if(!empty($nav_othertype_array))
                    {
                        $br = '<br>';
                        $paymentTypeAndAmount = implode('<br>', $nav_othertype_array);
                        $paymentTypeAndAmount = '('.$paymentTypeAndAmount.')';
                    }
                }
                // ===================================================================================================================================================
                $bu_data = $this->accounting_model->get_bcode_model($_POST['bname']);
                if(!empty($bu_data))
                {
                    $bcode = $bu_data->bcode;
                }
                $dept_data = $this->accounting_model->get_dcode_model($bcode,$_POST['dname']);
                if(!empty($dept_data))
                {
                    $dcode = $dept_data->dcode;
                }
                $cebo_cs_denomination_data = $this->accounting_model->get_cebo_cs_denomination_model($staff_emp_id,$_POST['sales_date'],$dcode);
                if(!empty($cebo_cs_denomination_data))
                {
                    $tr_no = $cebo_cs_denomination_data->tr_no;
                    $cls_netAmount3 += $cebo_cs_denomination_data->total_denomination;
                    $cls_netAmount2 = $cebo_cs_denomination_data->total_denomination;
                    $cls_netAmount = $cebo_cs_denomination_data->total_denomination;
                    $cls_netAmount = '<br>'.number_format($cls_netAmount, 2);
                }
                $final_cash = $this->accounting_model->get_final_cash_model($tr_no,$staff_emp_id);
                if(!empty($final_cash))
                {
                    $cls_finalcash2 += $final_cash->total_cash;
                    $cls_finalcash = $final_cash->total_cash;
                    $cls_finalcash = '<br>'.number_format($cls_finalcash, 2);
                }
                $partial_cash = $this->accounting_model->get_partial_cash_model($tr_no,$staff_emp_id);
                if(!empty($partial_cash))
                {
                    $cls_partialcash2 += $partial_cash->total_pcash;
                    $cls_partialcash = $partial_cash->total_pcash;
                    $cls_partialcash = '<br>'.number_format($cls_partialcash, 2);
                }
                $cls_cashier_noncash_data = $this->accounting_model->get_cs_cashier_noncashden_model($tr_no,$staff_emp_id);
                $cls_bankcard = '<br> 0.00';
                $bankcard_color = 'style="color: green;"';
                $cls_giftcheck = '<br> 0.00';
                $cls_crmredeem = '<br> 0.00';
                $cls_atp = '<br> 0.00';
                $cls_empcredit = '<br> 0.00';
                $cls_po = '<br> 0.00';
                $cls_ihcc = '<br> 0.00';
                $cls_otherpayment = '';
                $cls_otherpayment_total = '';
                foreach($cls_cashier_noncash_data as $noncash)
                {
                    if($noncash['mop_name'] == 'COMMERCIAL CARDS')
                    {
                        $cls_bankcard2 += $noncash['noncash_amount'];
                        $cls_bankcard = '<br>'.number_format($noncash['noncash_amount'], 2);
                        $bankcard_variance = $noncash['noncash_amount'] - $nav_bankcard2;
                        if($bankcard_variance < 0)
                        {
                            $bankcard_variance = explode("-",$bankcard_variance);
                            $bankcard_variance = implode("",$bankcard_variance);
                            $bankcard_color = 'style="color: red;"';
                        }
                        $bankcard_variance = '<br>'.'<label '.$bankcard_color.'>('.number_format($bankcard_variance, 2).')</label>';
                    }
                    if($noncash['mop_name'] == 'CORPORATE GIFT CHECK')
                    {
                        $cls_giftcheck2 += $noncash['noncash_amount'];
                        $cls_giftcheck = '<br>'.number_format($noncash['noncash_amount'], 2);
                    }
                    if($noncash['mop_name'] == 'CRM REDEEM')
                    {
                        $cls_crmredeem2 += $noncash['noncash_amount'];
                        $cls_crmredeem = '<br>'.number_format($noncash['noncash_amount'], 2);
                    }
                    $atp_array = array('CHECK EXCHANGE (ATP)','ATP');
                    if(in_array($noncash['mop_name'], $atp_array))
                    {
                        $cls_atp2 += $noncash['noncash_amount'];
                        $cls_atp = '<br>'.number_format($noncash['noncash_amount'], 2);
                    }
                    if($noncash['mop_name'] == 'EMPLOYEES CREDIT')
                    {
                        $cls_empcredit2 += $noncash['noncash_amount'];
                        $cls_empcredit = '<br>'.number_format($noncash['noncash_amount'], 2);
                    }
                    $po_array = array('P.O','PO','P.O CARD','PO CARD');
                    if(in_array($noncash['mop_name'], $po_array))
                    {
                        $cls_po2 += $noncash['noncash_amount'];
                        $cls_po = '<br>'.number_format($noncash['noncash_amount'], 2);
                    }
                    if($noncash['mop_name'] == 'IHCC')
                    {
                        $cls_ihcc2 += $noncash['noncash_amount'];
                        $cls_ihcc = '<br>'.number_format($noncash['noncash_amount'], 2);
                    }
                    $exclude = array('COMMERCIAL CARDS','CORPORATE GIFT CHECK','CRM REDEEM','CHECK EXCHANGE (ATP)','ATP','EMPLOYEES CREDIT','P.O','PO','P.O CARD','PO CARD','IHCC');
                    if(!in_array($noncash['mop_name'], $exclude))
                    { 
                        $cls_otherpayment2 += $noncash['noncash_amount'];  
                        $cls_otherpayment .= $noncash['mop_name'].'|'.number_format($noncash['noncash_amount'], 2).'<br>';
                        $cls_otherpayment_total += $noncash['noncash_amount'];  
                    }
                }
                if($cls_otherpayment == '')
                {
                    $cls_otherpayment = '<br> 0.00';
                }
                else
                {
                    $cls_otherpayment = substr_replace($cls_otherpayment ,"",-4);
                    $cls_otherpayment = '<br>('.$cls_otherpayment.')';
                }
                $cls_otherpayment_total = '<br>'.number_format($cls_otherpayment_total, 2);
                $netAmount_variance = $cls_netAmount2 - $net_amount2;
                $netAmount_variance = number_format($netAmount_variance, 2);
                if($netAmount_variance < 0)
                {
                    $netAmount_variance = preg_replace('/-/', "", $netAmount_variance);
                    $netAmount_variance = 'SHORT<br>'.number_format($netAmount_variance, 2);
                    $netAmount_variance_color = 'style="color: red;"';
                }
                else if($netAmount_variance > 0)
                {
                    $netAmount_variance = 'OVER<br>'.number_format($netAmount_variance, 2);
                    $netAmount_variance_color = 'style="color: green;"';
                }
                else
                {
                    $netAmount_variance = 'PERFECT<br>'.number_format($netAmount_variance, 2);
                    $netAmount_variance_color = 'style="color: green;"';
                }
                // ==================================================================================================================================================
                $terminal_counter_no = implode('', $pos_terminal_no);
                $terminal_counter_no = substr_replace($terminal_counter_no ,"",-4);
                $terminal_counter_no = $store_no.'<br>'.$terminal_counter_no;
                // var_dump($terminal_counter_no);
                // ===================================================================================================================================================
                $html.=' 
                        <tr style="word-wrap:break-word;">
                            <td style="vertical-align: middle; text-align: center;">
                                '.$terminal_counter_no.'
                            </td>
                            <td style="vertical-align: middle; text-align: left;">
                                '.$staff_name.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_cash.'</span>'.$cls_finalcash.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_bankcard.'</span>'.$cls_bankcard.$bankcard_variance.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_giftcheck.'</span>'.$cls_giftcheck.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_partialcash.'</span>'.$cls_partialcash.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_crmredeem.'</span>'.$cls_crmredeem.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_atp.'</span>'.$cls_atp.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_emp_chargeCredit.'</span>'.$cls_empcredit.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_po.'</span>'.$cls_po.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$nav_ihcc.'</span>'.$cls_ihcc.'
                            </td>
                            <td style="vertical-align: middle; text-align: center; font-size: 11px;">
                                '.'<span '.$nav_color.'>'.$paymentTypeAndAmount.$br.$nav_otherpayment.'</span>'.'
                                '.$cls_otherpayment.$cls_otherpayment_total.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                '.'<span '.$nav_color.'>'.$net_amount.'</span>'.$cls_netAmount.'
                            </td>
                            <td style="vertical-align: middle; text-align: center;">
                                <lable '.$netAmount_variance_color.'>'.$netAmount_variance.'</label>
                            </td>
                        </tr>
                        '; 
            }
            $nav_cash2 = number_format($nav_cash2, 2);
            $nav_bankcard3 = number_format($nav_bankcard3, 2);
            $nav_giftcheck2 = number_format($nav_giftcheck2, 2);
            $nav_partialcash2 = number_format($nav_partialcash2, 2);
            $nav_crmredeem2 = number_format($nav_crmredeem2, 2);
            $nav_atp2 = number_format($nav_atp2, 2);
            $nav_emp_chargeCredit2 = number_format($nav_emp_chargeCredit2, 2);
            $nav_po2 = number_format($nav_po2, 2);
            $nav_ihcc2 = number_format($nav_ihcc2, 2);
            $nav_otherpayment2 = number_format($nav_otherpayment2, 2);
            $cls_finalcash2 = '<br>'.number_format($cls_finalcash2, 2);
            $cls_bankcard2 = '<br>'.number_format($cls_bankcard2, 2);
            $cls_giftcheck2 = '<br>'.number_format($cls_giftcheck2, 2);
            $cls_partialcash2 = '<br>'.number_format($cls_partialcash2, 2);
            $cls_crmredeem2 = '<br>'.number_format($cls_crmredeem2, 2);
            $cls_atp2 = '<br>'.number_format($cls_atp2, 2);
            $cls_empcredit2 = '<br>'.number_format($cls_empcredit2, 2);
            $cls_po2 = '<br>'.number_format($cls_po2, 2);
            $cls_ihcc2 = '<br>'.number_format($cls_ihcc2, 2);
            $cls_otherpayment2 = '<br>'.number_format($cls_otherpayment2, 2);
            $cls_netAmount3 = '<br>'.number_format($cls_netAmount3, 2);
            $overall_amount = number_format($overall_amount, 2);
            $html.=' 
                            <tfoot>
                                <tr style="word-wrap:break-word;">
                                    <td style="vertical-align: middle; text-align: center;">
                                    
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        TOTAL
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_cash2.'</span>'.$cls_finalcash2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_bankcard3.'</span>'.$cls_bankcard2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_giftcheck2.'</span>'.$cls_giftcheck2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_partialcash2.'</span>'.$cls_partialcash2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_crmredeem2.'</span>'.$cls_crmredeem2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_atp2.'</span>'.$cls_atp2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_emp_chargeCredit2.'</span>'.$cls_empcredit2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_po2.'</span>'.$cls_po2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_ihcc2.'</span>'.$cls_ihcc2.'
                                    </td>
                                    <td style="vertical-align: middle; text-align: center;">
                                        '.'<span '.$nav_color.'>'.$nav_otherpayment2.'</span>'.$cls_otherpayment2.'
                                    </td>
                                    <td colspan="2" style="vertical-align: middle; text-align: left;">
                                        '.'<span '.$nav_color.'>'.$overall_amount.'</span>'.$cls_netAmount3.'
                                    </td>
                                </tr>    
                            </tfoot>             
                        </table>
                    ';

            $title = '
                    <form>
                        <center>
                            <label>NAVISION VS CASHIER\'S LIQUIDATION SYSTEM</label>
                        </center>
                    </form>
                    ';
        
            $data['navcls_title']=$title;               
            $data['buDeptName']=$_POST['bname'].'&nbsp;/&nbsp;'.$_POST['dname'] ;               
            $data['sales_date']=$_POST['sales_date'];               
            $data['html']=$html;              
            echo json_encode($data);
        }
    }

    public function nav_adjustment_ctrl()
    {
        $staff_info = $this->accounting_model->get_staff_info_model($_POST['staff_id']);
        $staff_name = '';
        if(empty($staff_info))
        {
            $staff_id = $_POST['staff_id'] * 1;
            $staff_info2 = $this->accounting_model->get_staff_info_model($staff_id);
            if(!empty($staff_info2))
            {
                $staff_name = $staff_info2->name;
            }
        }
        else
        {
            $staff_name = $staff_info->name;
        }
        // ===============================================================================================================================
        $tender_type_data = $this->accounting_model->get_noncash_tender_type_model($_POST['sales_date'],$_POST['staff_id']);
        $tenderTypeNameArray = array();
        $tenderTypeName = '';
        $tenderAmount = '';
        $store = '';
        foreach($tender_type_data as $tender)
        {
            $store = explode('-', $tender['store_no']);
            if($store[0] == 'ICM')
            {
                $icm_tenderTypeName = $this->accounting_model->get_icm_tender_name_model($tender['tender_type']);
                if(!empty($icm_tenderTypeName))
                {
                    $tenderTypeName = $icm_tenderTypeName->icm_payment_name;
                }
            }
            else if($store[0] == 'ASC')
            {
                $asc_tenderTypeName = $this->accounting_model->get_asc_tender_name_model($tender['tender_type']);
                if(!empty($asc_tenderTypeName))
                {
                    $tenderTypeName = $asc_tenderTypeName->asc_payment_name;
                }
            }
            else if($store[0] == 'PM')
            {
                $pm_tenderTypeName = $this->accounting_model->get_pm_tender_name_model($tender['tender_type']);
                if(!empty($pm_tenderTypeName))
                {
                    $tenderTypeName = $pm_tenderTypeName->pm_payment_name;
                }
            }

            $tender_amount_data = $this->accounting_model->get_tender_type_amount_model($_POST['sales_date'],$tender['store_no'],$_POST['staff_id'],$tender['tender_type']);
            if(!empty($tender_amount_data))
            {
                $tenderAmount = $tender_amount_data->type_amount;
            }
            array_push($tenderTypeNameArray, $tenderTypeName.'|'.number_format($tenderAmount, 2).'|'.$tender['tender_type'].'|'.$_POST['sales_date'].'|'.$_POST['staff_id'].'|'.$tender['store_no'].'|'.$tender['dept_code']);
        }

        $tender_name = '
                        <option class="select_mop" readonly>SELECT MOP</option>
                        ';
        $tender_explode = '';
        sort($tenderTypeNameArray);
        for($b=0; $b<count($tenderTypeNameArray); $b++)
        {
            $tender_explode = explode('|', $tenderTypeNameArray[$b]);
            $tender_name .= '
                            <option value="'.$tender_explode[1].'|'.$tender_explode[2].'|'.$tender_explode[3].'|'.$tender_explode[4].'|'.$tender_explode[5].'|'.$tender_explode[6].'">'.$tender_explode[0].'</option>
                            ';
        }
        
        $data['staff_name'] = $staff_name;
        $data['tender_name'] = $tender_name;
        echo json_encode($data);
    }

    public function get_all_mop_ctrl()
    {
        $allTenderTypeName = '
                            <option class="select_mop" readonly>SELECT MOP</option>
                            ';
        if($_POST['store'] == 'ICM')
        {
            $icm_AllTenderTypeName = $this->accounting_model->get_icm_alltender_name_model($_POST['tender_type']);
            foreach($icm_AllTenderTypeName as $icm)
            {
                $allTenderTypeName .= '
                                        <option value="'.$icm['code'].'">'.$icm['name'].'</option>
                                    ';
            }
        }
        else if($_POST['store'] == 'ASC')
        {
            $asc_AllTenderTypeName = $this->accounting_model->get_asc_alltender_name_model($_POST['tender_type']);
            foreach($asc_AllTenderTypeName as $asc)
            {
                $allTenderTypeName .= '
                                        <option value="'.$asc['code'].'">'.$asc['name'].'</option>
                                    ';
            }
        }
        else if($_POST['store'] == 'PM')
        {
            $pm_AllTenderTypeName = $this->accounting_model->get_pm_alltender_name_model($_POST['tender_type']);
            foreach($pm_AllTenderTypeName as $pm)
            {
                $allTenderTypeName .= '
                                        <option value="'.$pm['code'].'">'.$pm['name'].'</option>
                                    ';
            }
        }
        
        // ========================================================================================================================================================
        $adjustment_list_data = $this->accounting_model->get_adjustment_list_model($_POST['origin_code'],$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
        $hide = '';
        $status_array = array();
        foreach($adjustment_list_data as $adlist)
        {
            if($adlist['status'] == 'ADJUSTED')
            {
                $hide = 'hidden';
            }
            // ========================================================================================================================
            if(!in_array($adlist['status'],$status_array))
            { 
                array_push($status_array,$adlist['status']);
            }
        }
        $status = 'EMPTY';
        if(!empty($status_array))
        {
            if(in_array('PENDING',$status_array))
            { 
                $status = 'PENDING';
            }
            else if(in_array('APPROVED',$status_array))
            { 
                $status = 'APPROVED';
            }
        }
        // ===========================================================================================================================================================
        $adjustment_list = '
                            <table class="table table-bordered table-hover table-condensed display id="adjustment_data_tbl">
                                <tr>
                                    <th><center>ORIGIN</center></th>
                                    <th><center>TRANSFER TO</center></th>
                                    <th><center>TRANSFER AMT.</center></th>
                                    <th><center>REASON</center></th>
                                    <th><center>STATUS</center></th>
                                    <th '.$hide.'><center>ACTION</center></th>
                                </tr>
                            ';
        // ================================================================================================================================================================
        $total = 0;
        foreach($adjustment_list_data as $list)
        {
            $total += $list['transfer_amount'];
            $adjustment_list .= '
                                    <tr>
                                        <td><center>'.$list['origin_name'].'</center></td>
                                        <td><center>'.$list['transfer_name'].'</center></td>
                                        <td><center>'.number_format($list['transfer_amount'], 2).'</center></td>
                                        <td><center>'.$list['reason'].'</center></td>
                                        <td><center>'.$list['status'].'</center></td>
                                        <td '.$hide.'>
                                            <center>
                                                <a onclick="view_attached_file_js('."'".$list['attached_file']."'".')">👁️</a>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <a onclick="delete_adjustment_js('."'".$list['id']."','".$list['origin_code']."','".$list['sales_date']."','".$list['staff_id']."','".$list['store_no']."'".')">❌</a>
                                            </center>
                                        </td>
                                    </tr>
                                ';
        }
        // ==========================================================================================================================================================
        $adjustment_list .= '
                                <tr>
                                    <td></td>
                                    <td style="font-weight: bold;"><center>TOTAL</center></td>
                                    <td style="font-weight: bold;"><center>'.number_format($total, 2).'</center></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                            ';
        
        $data['hide'] = $hide;
        $data['status'] = $status;
        $data['all_tender_name'] = $allTenderTypeName;
        $data['total'] = number_format($total, 2);
        $data['adjustment_list'] = $adjustment_list;
        echo json_encode($data);
    }

    public function sumbmit_adjustment_ctrl()
    {
        if(empty($_SESSION['emp_id']))
		{
			$message = "EXPIRED SESSION";
			echo json_encode($message);
		}
		else
        {
            $store = explode('-',$_POST['store_no']);
            $transfer_tender_array = array();
            $transfer_tender_array2 = '';
            if($store[0] == 'ICM')
            {
                $icm_TenderTypeName = $this->accounting_model->get_icmtender_type_model($_POST['transfer_tender_name']);
                foreach($icm_TenderTypeName as $icm)
                {
                    array_push($transfer_tender_array, $icm['code']);
                }
            }
            else if($store[0] == 'ASC')
            {
                $asc_TenderTypeName = $this->accounting_model->get_asctender_type_model($_POST['transfer_tender_name']);
                foreach($asc_TenderTypeName as $asc)
                {
                    array_push($transfer_tender_array, $asc['code']);
                }
            }
            else if($store[0] == 'PM')
            {
                $pm_TenderTypeName = $this->accounting_model->get_pmtender_type_model($_POST['transfer_tender_name']);
                foreach($pm_TenderTypeName as $pm)
                {
                    array_push($transfer_tender_array, $pm['code']);
                }
            }
            $transfer_tender_array2 = $transfer_tender_array;
            array_push($transfer_tender_array, $_POST['origin_tender']);
            $transfer_tender_array = array_map('intval', $transfer_tender_array);
            $this->accounting_model->update_navtextfile_upload_model($transfer_tender_array,$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
            // =============================================================================================================================================
            $updated_data = $this->accounting_model->get_updated_navtextfile_model($_POST['origin_tender'],$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
            $tr_no = '';
            $receipt_no = '';
            $card_no = '';
            $origin_tender_type = $_POST['origin_tender'];
            $transfer_tender_type = $_POST['transfer_tender_code'];
            $origin_amount = $_POST['origin_amount'];
            $transfer_amount = $_POST['transfer_amount'];
            $card_or_account = '';
            $sales_date = $_POST['sales_date'];
            $sales_time = '';
            $staff_id = $_POST['staff_id'];
            $store_no = $_POST['store_no'];
            $pos_terminal_no = '';
            $bu_code = '';
            $dept_code = '';
            $status = 'ADJUSTED';
            foreach($updated_data as $data)
            {
                $tr_no = $data['tr_no'];
                $receipt_no = $data['receipt_no'];
                $card_no = $data['card_no'];
                $card_or_account = $data['card_or_account'];
                $sales_time = $data['sales_time'];
                $pos_terminal_no = $data['pos_terminal_no'];
                $bu_code = $data['bu_code'];
                $dept_code = $data['dept_code'];
            }
            // =========================================================VALIDATE INSERT================================================================================
            $validate_origin_update = $this->accounting_model->validate_origin_update_model($_POST['origin_tender'],$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
            $validate_transfer_update = $this->accounting_model->validate_transfer_update_model($_POST['transfer_tender_code'],$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
            if(empty($validate_origin_update))
            {
                // =========================================================INSERT ADJUSTED ORIGIN=========================================================================
                $this->accounting_model->insert_adjusted_model($tr_no,$receipt_no,$card_no,$origin_tender_type,$origin_amount,$card_or_account,$sales_date,$sales_time,$staff_id,$store_no,$pos_terminal_no,$bu_code,$dept_code,$status);

                if(empty($validate_transfer_update))
                {
                    // =========================================================INSERT ADJUSTED TRANSFER===================================================================
                    $adjusted_transfer_amount = '';
                    $transfer_data = $this->accounting_model->get_amount_transfer_tender_model($transfer_tender_array2,$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
                    if(!empty($transfer_data))
                    {
                        $adjusted_transfer_amount = $transfer_data->amount;
                        $adjusted_transfer_amount = $adjusted_transfer_amount + $transfer_amount;
                    }
                    $this->accounting_model->insert_adjusted_model($tr_no,$receipt_no,$card_no,$transfer_tender_type,$adjusted_transfer_amount,$card_or_account,$sales_date,$sales_time,$staff_id,$store_no,$pos_terminal_no,$bu_code,$dept_code,$status);
                }
                else
                {
                    // =========================================================UPDATE ADJUSTED TRANSFER====================================================================
                    $adjusted_transfer_amount = '';
                    $transfer_data = $this->accounting_model->get_amount_transfer_tender_model($transfer_tender_array2,$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
                    if(!empty($transfer_data))
                    {
                        $adjusted_transfer_amount = $transfer_data->amount;
                        $adjusted_transfer_amount = $adjusted_transfer_amount + $transfer_amount;
                    }
                    $this->accounting_model->update_adjusted_model($transfer_tender_type,$adjusted_transfer_amount,$sales_date,$staff_id,$store_no);
                }
            }
            else
            {
                // =========================================================UPDATE ADJUSTED ORIGIN==========================================================================
                $this->accounting_model->update_adjusted_model($origin_tender_type,$origin_amount,$sales_date,$staff_id,$store_no);

                if(empty($validate_transfer_update))
                {
                    // =========================================================INSERT ADJUSTED TRANSFER========================================================================
                    $adjusted_transfer_amount = '';
                    $transfer_data = $this->accounting_model->get_amount_transfer_tender_model($transfer_tender_array2,$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
                    if(!empty($transfer_data))
                    {
                        $adjusted_transfer_amount = $transfer_data->amount;
                        $adjusted_transfer_amount = $adjusted_transfer_amount + $transfer_amount;
                    }
                    $this->accounting_model->insert_adjusted_model($tr_no,$receipt_no,$card_no,$transfer_tender_type,$adjusted_transfer_amount,$card_or_account,$sales_date,$sales_time,$staff_id,$store_no,$pos_terminal_no,$bu_code,$dept_code,$status);
                }
                else
                {
                    // =========================================================UPDATE ADJUSTED TRANSFER====================================================================
                    $adjusted_transfer_amount = '';
                    $transfer_data = $this->accounting_model->get_amount_transfer_tender_model($transfer_tender_array2,$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
                    if(!empty($transfer_data))
                    {
                        $adjusted_transfer_amount = $transfer_data->amount;
                        $adjusted_transfer_amount = $adjusted_transfer_amount + $transfer_amount;
                    }
                    $this->accounting_model->update_adjusted_model($transfer_tender_type,$adjusted_transfer_amount,$sales_date,$staff_id,$store_no);
                }
            }
            
            $data['sales_date'] = $sales_date;
            $data['staff_id'] = $staff_id;
            echo json_encode($data);
        }
    }

    public function add_adjustment_ctrl()
    {
        if(empty($_SESSION['emp_id']))
		{
			$message = "EXPIRED SESSION";
			echo json_encode($message);
		}
		else
        {
            $validate_mop = $this->accounting_model->validate_mop_adjustment_model($_POST['origin_code'],$_POST['transfer_code'],$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no'],$_POST['dcode']);
            if(empty($validate_mop))
            {
                $message = 'success';
                $this->accounting_model->add_adjustment_model($_POST['origin_code'],$_POST['origin_name'],$_POST['transfer_code'],$_POST['transfer_name'],$_POST['transfer_amount'],$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no'],$_POST['dcode'],$_POST['reason'],$_POST['file_data']);
    
                echo json_encode($message);
            }
            else
            {
                $message = 'DUPLICATE';
                echo json_encode($message);
            }
        }
    }

    public function upload_attached_file_ctrl()
    {
        if(empty($_SESSION['emp_id']))
		{
			$message = "EXPIRED SESSION";
			echo json_encode($message);
		}
		else
        {
            // Count total files
            $countfiles = count($_FILES['files']['name']);
            // Loop all files
            for($index = 0;$index < $countfiles;$index++){

                if(isset($_FILES['files']['name'][$index]) && $_FILES['files']['name'][$index] != ''){
                    // File name
                    $filename = $_FILES['files']['name'][$index];
                    // Get extension
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    // Valid image extension
                    $valid_ext = array("png","jpeg","jpg","PNG","JPEG","JPG");
                    // Check extension
                    if(in_array($ext, $valid_ext)){
                        // File path
                        $destination_path = getcwd()."/accounting_attached_file/";
                        // Upload Location
                        $target_path = $destination_path . basename( $_FILES["files"]["name"][$index]); 
                        // Upload file
                        move_uploaded_file($_FILES['files']['tmp_name'][$index],$target_path);
                    }
                }
            }
        }
    }

    public function pending_adjustment_ctrl()
    {
        $adjustment_list_data = $this->accounting_model->get_adjustment_list_model($_POST['origin_code'],$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
        $hide = '';        
        $status_array = array();
        foreach($adjustment_list_data as $adlist)
        {
            if($adlist['status'] == 'ADJUSTED')
            {
                $hide = 'hidden';
            }
            // ========================================================================================================================
            if(!in_array($adlist['status'],$status_array))
            { 
                array_push($status_array,$adlist['status']);
            }
        }
        $status = '';
        if(!empty($status_array))
        {
            if(in_array('PENDING',$status_array))
            { 
                $status = 'PENDING';
            }
            else if(in_array('APPROVED',$status_array))
            { 
                $status = 'APPROVED';
            }
        }
        // ===========================================================================================================================================================
        $adjustment_list = '
                            <table class="table table-bordered table-hover table-condensed display id="adjustment_data_tbl">
                                <tr>
                                    <th><center>ORIGIN</center></th>
                                    <th><center>TRANSFER TO</center></th>
                                    <th><center>TRANSFER AMT.</center></th>
                                    <th><center>REASON</center></th>
                                    <th><center>STATUS</center></th>
                                    <th '.$hide.'><center>ACTION</center></th>
                                </tr>
                            ';
        // ============================================================================================================================================================
        $total = 0;
        foreach($adjustment_list_data as $list)
        {
            $total += $list['transfer_amount'];
            $adjustment_list .= '
                                    <tr>
                                        <td><center>'.$list['origin_name'].'</center></td>
                                        <td><center>'.$list['transfer_name'].'</center></td>
                                        <td><center>'.number_format($list['transfer_amount'], 2).'</center></td>
                                        <td><center>'.$list['reason'].'</center></td>
                                        <td><center>'.$list['status'].'</center></td>
                                        <td '.$hide.'><center><span><a onclick="delete_adjustment_js('."'".$list['id']."','".$list['origin_code']."','".$list['sales_date']."','".$list['staff_id']."','".$list['store_no']."'".')">❌</a></span></center></td>
                                    </tr>
                                ';
        }
        // ======================================================================================================================================================
        $adjustment_list .= '
                                <tr>
                                    <td></td>
                                    <td style="font-weight: bold;"><center>TOTAL</center></td>
                                    <td style="font-weight: bold;"><center>'.number_format($total, 2).'</center></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                            ';

        $data['hide'] = $hide;
        $data['status'] = $status;
        $data['total'] = number_format($total, 2);
        $data['adjustment_list'] = $adjustment_list;
        echo json_encode($data);
    }

    public function delete_adjustment_ctrl()
    {
        $message = 'success';
        $this->accounting_model->delete_adjustment_model($_POST['id']);

        echo json_encode($message);
    }

    public function sumbmit_adjustment_ctrl_v2()
    {
        if(empty($_SESSION['emp_id']))
		{
			$message = "EXPIRED SESSION";
			echo json_encode($message);
		}
		else
        {
            $updated_data = $this->accounting_model->get_updated_navtextfile_model($_POST['origin_code'],$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
            $tr_no = '';
            $receipt_no = '';
            $card_no = '';
            $origin_tender_type = $_POST['origin_code'];
            $origin_adjusted_amount = $_POST['origin_adjusted_amount'];
            $card_or_account = '';
            $sales_date = $_POST['sales_date'];
            $sales_time = '';
            $sales_time2 = '';
            $staff_id = $_POST['staff_id'];
            $store_no = $_POST['store_no'];
            $pos_terminal_no = '';
            $pos_terminal_no2 = '';
            $bu_code = '';
            $bu_code2 = '';
            $dept_code = '';
            $dept_code2 = '';
            $status = 'ADJUSTED';
            foreach($updated_data as $data)
            {
                $tr_no = $data['tr_no'];
                $receipt_no = $data['receipt_no'];
                $card_no = $data['card_no'];
                $card_or_account = $data['card_or_account'];
                $sales_time = $data['sales_time'];
                $sales_time2 = $data['sales_time'];
                $pos_terminal_no = $data['pos_terminal_no'];
                $pos_terminal_no2 = $data['pos_terminal_no'];
                $bu_code = $data['bu_code'];
                $bu_code2 = $data['bu_code'];
                $dept_code = $data['dept_code'];
                $dept_code2 = $data['dept_code'];
            }
            // =========================================================INSERT ADJUSTED ORIGIN=========================================================================
            $this->accounting_model->insert_adjusted_model($tr_no,$receipt_no,$card_no,$origin_tender_type,$origin_adjusted_amount,$card_or_account,$sales_date,$sales_time,$staff_id,$store_no,$pos_terminal_no,$bu_code,$dept_code,$status);
            // =============================================================================================================================================
            $adjusted_data = $this->accounting_model->get_adjusted_navtextfile_model($_POST['origin_code'],$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
            $store = explode('-',$_POST['store_no']);
            $transfer_tender_array = array();
            foreach($adjusted_data as $adjusted)
            {
                if($store[0] == 'ICM')
                {
                    $icm_TenderTypeName = $this->accounting_model->get_icmtender_type_model($adjusted['transfer_name']);
                    $transfer_tender_array2 = array();
                    foreach($icm_TenderTypeName as $icm)
                    {
                        array_push($transfer_tender_array, $icm['code']);
                        array_push($transfer_tender_array2, $icm['code']);
                    }
                }
                else if($store[0] == 'ASC')
                {
                    $asc_TenderTypeName = $this->accounting_model->get_asctender_type_model($adjusted['transfer_name']);
                    $transfer_tender_array2 = array();
                    foreach($asc_TenderTypeName as $asc)
                    {
                        array_push($transfer_tender_array, $asc['code']);
                        array_push($transfer_tender_array2, $asc['code']);
                    }
                }
                else if($store[0] == 'PM')
                {
                    $pm_TenderTypeName = $this->accounting_model->get_pmtender_type_model($adjusted['transfer_name']);
                    $transfer_tender_array2 = array();
                    foreach($pm_TenderTypeName as $pm)
                    {
                        array_push($transfer_tender_array, $pm['code']);
                        array_push($transfer_tender_array2, $pm['code']);
                    }
                }

                // =========================================================INSERT ADJUSTED TRANSFER===================================================================
                $updated_data = $this->accounting_model->get_updated_navtextfile_model2($transfer_tender_array2,$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
                $tr_no = '';
                $receipt_no = '';
                $card_no = '';
                $transfer_tender_type = $adjusted['transfer_code'];
                $card_or_account = '';
                $sales_date = $_POST['sales_date'];
                $sales_time = '';
                $staff_id = $_POST['staff_id'];
                $store_no = $_POST['store_no'];
                $pos_terminal_no = '';
                $bu_code = '';
                $dept_code = '';
                $status = 'ADJUSTED';
                foreach($updated_data as $data)
                {
                    $tr_no = $data['tr_no'];
                    $receipt_no = $data['receipt_no'];
                    $card_no = $data['card_no'];
                    $card_or_account = $data['card_or_account'];
                    $sales_time = $data['sales_time'];
                    $pos_terminal_no = $data['pos_terminal_no'];
                    $bu_code = $data['bu_code'];
                    $dept_code = $data['dept_code'];
                }
                // ==========================================================================================================================================================
                if($sales_time == '')
                {
                    $sales_time = $sales_time2;
                }
                if($pos_terminal_no == '')
                {
                    $pos_terminal_no = $pos_terminal_no2;
                }
                if($bu_code == '')
                {
                    $bu_code = $bu_code2;
                }
                if($dept_code == '')
                {
                    $dept_code = $dept_code2;
                }
                $adjusted_transfer_amount = '';
                $transfer_data = $this->accounting_model->get_amount_transfer_tender_model($transfer_tender_array2,$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
                if(!empty($transfer_data))
                {
                    $adjusted_transfer_amount = $transfer_data->amount;
                    $adjusted_transfer_amount = $adjusted_transfer_amount + $adjusted['transfer_amount'];
                }
                else
                {
                    $adjusted_transfer_amount = $adjusted['transfer_amount'];
                }
                $this->accounting_model->insert_adjusted_model($tr_no,$receipt_no,$card_no,$transfer_tender_type,$adjusted_transfer_amount,$card_or_account,$sales_date,$sales_time,$staff_id,$store_no,$pos_terminal_no,$bu_code,$dept_code,$status);
            }

            $message = 'success';
            array_push($transfer_tender_array, $_POST['origin_code']);
            $transfer_tender_array = array_map('intval', $transfer_tender_array);
            $this->accounting_model->update_navtextfile_upload_model($transfer_tender_array,$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
            $this->accounting_model->update_nav_adjustment_model($_POST['origin_code'],$_POST['sales_date'],$_POST['staff_id'],$_POST['store_no']);
            
            echo json_encode($message);
        }
    }

    public function validate_mop_transfer_ctrl()
    {
        $validated_data = $this->accounting_model->validate_mop_transfer_model($_POST['sales_date'],$_POST['staff_id'],$_POST['store_no'],$_POST['origin_name'],$_POST['transfer_name']);
        $message = '';
        if($validated_data == 'ADJUSTED')
        {
            $message = 'ADJUSTED';
        }
        else if($validated_data == 'PENDING')
        {
            $message = 'PENDING';
        }
        else
        {
            $message = 'NO RECORD';
        }
        
        echo json_encode($message);
    }

    public function display_adjustment_history_ctrl()
    {
        $html = '
                <table class="table table-bordered table-hover table-condensed display" id="adjustment_history_table">
                    <thead>
                        <tr>
                            <th>CASHIER NAME</th>
                            <th>ORIGIN</th>
                            <th>TRANSFER TO</th>
                            <th>TRANSFER AMOUNT</th>
                            <th>SALES DATE</th>
                            <th>ADJUSTED DATE/TIME</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                ';

        $adjustment_data = $this->accounting_model->get_adjustment_history_model($_SESSION['emp_id']);
        foreach($adjustment_data as $data)
        {
            $staff_info = $this->accounting_model->get_staff_info_model($data['staff_id']);
            $staff_id = '';
            $staff_name = '';
            if(empty($staff_info))
            {
                $staff_id = $data['staff_id'] * 1;
                $staff_info2 = $this->accounting_model->get_staff_info_model($staff_id);
                if(!empty($staff_info2))
                {
                    $staff_name = $staff_info2->name;
                }
            }
            else
            {
                $staff_name = $staff_info->name;
            }
            // ==========================================================================================================================================
            $html .= '
                <tr>
                    <td>'.$staff_name.'</td>
                    <td>'.$data['origin_name'].'</td>
                    <td>'.$data['transfer_name'].'</td>
                    <td>'.$data['transfer_amount'].'</td>
                    <td>'.$data['sales_date'].'</td>
                    <td>'.$data['date_adjusted'].'</td>
                    <td>'.$data['status'].'</td>
                </tr>
                ';
        }
        
        $html .= '
                </table>
                ';

        $data['html'] = $html;
        echo json_encode($data);
    }

    public function print_unadjusted_navcls_ctrl()
    { 
        $store_no_array = explode("|", $_POST['store_no']);
        $cash_colspan = 7;
        $nav_colspan = 3;
        $cash_wholesale_data = $this->accounting_model->validate_cash_wholesale_model($_POST['sales_date'],$store_no_array,$_POST['dcode']);
        $cash_wholesale_th_html = '';
        $cash_wholesale_total = 0;
        if(!is_null($cash_wholesale_data->cash_wholesale))
        {
            $cash_colspan = 8;
            $nav_colspan = 4;
            $cash_wholesale_total = $cash_wholesale_data->cash_wholesale;
            $cash_wholesale_th_html = '<th style="vertical-align: middle;" scope="col"><center>CASH<br>WHOLESALE</center></th>';
        }
        // ======================================================================================================================================
        $cash_html = '
                        <table border="1" cellpadding="3">
                            <thead>
                                <tr>                                                          
                                    <th style="vertical-align: middle; text-align: center;" width="15%" rowspan="3">
                                        <center><br><br><br>CASHIER\'S NAME</center>
                                    </th>                                                        
                                    <th style="vertical-align: middle; text-align: center;" width="11%" rowspan="3">
                                        <center><br><br><br>LOCATION</center>
                                    </th>
                                    <th style="vertical-align: middle; text-align: center;" width="24%" colspan="2" scope="colgroup">
                                        <center>TERMINAL NO.</center>
                                    </th>  
                                    <th style="vertical-align: middle; text-align: center;" width="50%" colspan="'.$cash_colspan.'" scope="colgroup">
                                        <center>CASH</center>
                                    </th>        
                                </tr>
                                <tr style="border-top: outset; text-align: center;">
                                    <th style="vertical-align: middle;" scope="col" rowspan="2"><center><br><br>CLS</center></th>
                                    <th style="vertical-align: middle;" scope="col" rowspan="2"><center><br><br>NAV</center></th>
                                    <th style="vertical-align: middle;" colspan="3" scope="colgroup"><center>CLS</center></th>
                                    <th style="vertical-align: middle;" colspan="'.$nav_colspan.'" scope="colgroup"><center>NAV</center></th>
                                    <th style="vertical-align: middle;" scope="col" rowspan="2"><center><br><br>VARIANCE</center></th>
                                </tr>
                                <tr style="border-top: outset; text-align: center;">
                                    <th style="vertical-align: middle;" scope="col"><center>PARTIAL</center></th>
                                    <th style="vertical-align: middle;" scope="col"><center>FINAL</center></th>
                                    <th style="vertical-align: middle;" scope="col"><center>TOTAL</center></th>
                                    <th style="vertical-align: middle;" scope="col"><center>PARTIAL</center></th>
                                    <th style="vertical-align: middle;" scope="col"><center>FINAL</center></th>
                                    '.$cash_wholesale_th_html.'
                                    <th style="vertical-align: middle;" scope="col"><center>TOTAL</center></th>
                                </tr>
                            </thead>
                        <tbody>
                        ';
        // =============================================================================================================================================
        $noncash_html = '
                        <table border="1" cellpadding="3">
                            <thead>
                                <tr>                                                          
                                    <th style="vertical-align: middle; text-align: center;" width="20%" rowspan="2">
                                        <center><br><br>CASHIER\'S NAME</center>
                                    </th>                                                        
                                    <th style="vertical-align: middle; text-align: center;" width="15%" rowspan="2">
                                        <center><br><br>LOCATION</center>
                                    </th>
                                    <th style="vertical-align: middle; text-align: center;" width="30%" colspan="2" scope="colgroup">
                                        <center>TERMINAL NO.</center>
                                    </th>  
                                    <th style="vertical-align: middle; text-align: center;" width="35%" colspan="3" scope="colgroup">
                                        <center>'.$_POST['mop_name'].'</center>
                                    </th>        
                                </tr>
                                <tr style="border-top: outset; text-align: center;">
                                    <th style="vertical-align: middle;" scope="col"><center>CLS</center></th>
                                    <th style="vertical-align: middle;" scope="col"><center>NAV</center></th>
                                    <th style="vertical-align: middle;" scope="col" width="12%"><center>CLS</center></th>
                                    <th style="vertical-align: middle;" scope="col" width="12%"><center>NAV</center></th>
                                    <th style="vertical-align: middle;" scope="col" width="11%"><center>VARIANCE</center></th>
                                </tr>
                            </thead>
                        <tbody>
                        ';
        // =============================================================================================================================================
        $total_variance_html = '
                        <table border="1" cellpadding="3">
                            <thead>
                                <tr>                                                          
                                    <th style="vertical-align: middle; text-align: center;" width="20%" rowspan="2">
                                        <center><br><br>CASHIER\'S NAME</center>
                                    </th>                                                        
                                    <th style="vertical-align: middle; text-align: center;" width="15%" rowspan="2">
                                        <center><br><br>LOCATION</center>
                                    </th>
                                    <th style="vertical-align: middle; text-align: center;" width="30%" colspan="2" scope="colgroup">
                                        <center>TERMINAL NO.</center>
                                    </th>  
                                    <th style="vertical-align: middle; text-align: center;" width="35%" colspan="3" scope="colgroup">
                                        <center>TOTAL</center>
                                    </th>        
                                </tr>
                                <tr style="border-top: outset; text-align: center;">
                                    <th style="vertical-align: middle;" scope="col"><center>CLS</center></th>
                                    <th style="vertical-align: middle;" scope="col"><center>NAV</center></th>
                                    <th style="vertical-align: middle;" scope="col" width="12%"><center>CLS</center></th>
                                    <th style="vertical-align: middle;" scope="col" width="12%"><center>NAV</center></th>
                                    <th style="vertical-align: middle;" scope="col" width="11%"><center>VARIANCE</center></th>
                                </tr>
                            </thead>
                        <tbody>
                        ';
        // =============================================================================================================================================
        $nav_data = $this->accounting_model->get_uploaded_navdata_model_v2($_POST['sales_date'],$store_no_array);
        $staff_info_array = array();
        foreach($nav_data as $nav)
        {
            $staff_id_array = array($nav['staff_id'],'0'.$nav['staff_id']);
            $staff_data = $this->accounting_model->get_staff_data_model($staff_id_array);
            if(!empty($staff_data))
            {
                array_push($staff_info_array, $staff_data->name.'|'.$nav['staff_id'].'|'.$staff_data->emp_id);
            }
        }
        // ======================================================================================================================================
        $mop_code = '';
        if($_POST['mop_code'] == 11 || $_POST['mop_code'] == 33)
        {
            $mop_code = array(11,33);
        }
        else
        {
            $mop_code = array($_POST['mop_code']);
        }
        // ======================================================================================================================================

        // ============================================START OF TD LOOP CODE========================================================================
        sort($staff_info_array);
        $cls_total_partial_cash = 0;
        $cls_total_final_cash = 0;
        $cls_grand_total_cash = 0;
        $cls_total_mop_amount = 0;
        $cls_grand_total_sales = 0;
        for($a=0; $a<count($staff_info_array); $a++)
        {
            $staff = explode("|", $staff_info_array[$a]);
            // ============================================START OF LOCATION CODE================================================================
            $cls_cash_location_data = $this->accounting_model->get_cls_cash_location_data_model($staff[2],$_POST['sales_date']);
            $cls_noncash_location_data = $this->accounting_model->get_cls_noncash_location_data_model($staff[2],$_POST['sales_date']);
            $location_code_array = array();
            foreach($cls_cash_location_data as $location)
            {
                if(!in_array($location['sscode'], $location_code_array))
                {
                    array_push($location_code_array, $location['sscode']);
                }
            }
            // ==================================================================================================================================
            foreach($cls_noncash_location_data as $location)
            {
                if(!in_array($location['sscode'], $location_code_array))
                {
                    array_push($location_code_array, $location['sscode']);
                }
            }
            // ==================================================================================================================================
            $location_name_array = array();
            for($b=0; $b<count($location_code_array); $b++)
            {
                $code_length = strlen($location_code_array[$b]);
                if($code_length == 10)
                {
                    $ss_data = $this->accounting_model->get_ssname_model($location_code_array[$b]);
                    if(!empty($ss_data))
                    {
                        array_push($location_name_array, $ss_data->sub_section_name.'<br>');
                    }
                }
                else if($code_length == 8)
                {
                    $s_data = $this->accounting_model->get_sname_model($location_code_array[$b]);
                    if(!empty($s_data))
                    {
                        array_push($location_name_array, $s_data->section_name.'<br>');
                    }
                }
                else if($code_length == 6)
                {
                    $d_data = $this->accounting_model->get_dname_model($location_code_array[$b]);
                    if(!empty($d_data))
                    {
                        array_push($location_name_array, $d_data->dept_name.'<br>');
                    }
                }
            }
            $location_name_array = implode("", $location_name_array);
            $location_name_array = substr_replace($location_name_array, "", -4);
            // ============================================END OF LOCATION CODE=================================================================

            // ==========================================START OF CLS TERMINAL CODE=============================================================
            $cls_terminal_data = $this->accounting_model->get_cls_terminal_data_model($staff[2],$_POST['sales_date']);
            $cls_terminal_array = array();
            foreach($cls_terminal_data as $terminal)
            {
                $terminal_sales = number_format($terminal['total_denomination'] + $terminal['discount'], 2);
                $cls_cash_terminal = $this->accounting_model->get_cls_cash_terminal_model($terminal['tr_no'],$staff[2]);
                $cls_noncash_terminal = $this->accounting_model->get_cls_noncash_terminal_model($terminal['tr_no'],$staff[2]);
                foreach($cls_cash_terminal as $cash)
                {
                   array_push($cls_terminal_array, $cash['pos_name'].' | '.$terminal_sales.'<br>');
                }
                // ==============================================================================================================
                foreach($cls_noncash_terminal as $noncash)
                {
                    if(!in_array($noncash['pos_name'].' | '.$terminal_sales.'<br>', $cls_terminal_array))
                    {
                        array_push($cls_terminal_array, $noncash['pos_name'].' | '.$terminal_sales.'<br>');
                    }
                }
            }
            // sort($cls_terminal_array);
            $cls_terminal_array = implode("", $cls_terminal_array);
            $cls_terminal_array = substr_replace($cls_terminal_array, "", -4);
            // ==========================================END OF CLS TERMINAL CODE=============================================================

            // ==========================================START OF NAV TERMINAL CODE=============================================================
            $nav_terminal_data = $this->accounting_model->get_nav_terminal_data_model_v2($staff[1],$_POST['sales_date'],$store_no_array,$_POST['dcode']);
            $nav_terminal_array = array();
            foreach($nav_terminal_data as $nav)
            {
                array_push($nav_terminal_array, $nav['pos_terminal_no'].' | '.number_format($nav['terminal_sales'], 2).'<br>');
            }
            $nav_terminal_array = implode("", $nav_terminal_array);
            $nav_terminal_array = substr_replace($nav_terminal_array, "", -4);
            // ==========================================END OF NAV TERMINAL CODE=============================================================

            if($_POST['mop_code'] == 1)
            {
                // ==========================================START OF CLS PARTIAL CASH CODE=========================================================
                $cls_partial_cash_data = $this->accounting_model->get_cls_partial_cash_data_model($staff[2],$_POST['sales_date']);
                $cls_partial_cash = 0;
                if(!empty($cls_partial_cash_data))
                {
                    $cls_partial_cash = $cls_partial_cash_data->partial_cash;
                    $cls_total_partial_cash += $cls_partial_cash_data->partial_cash;
                }
                // ==========================================END OF CLS PARTIAL CASH CODE===========================================================
                
                // ==========================================START OF CLS FINAL CASH CODE===========================================================
                $cls_final_cash_data = $this->accounting_model->get_cls_final_cash_data_model($staff[2],$_POST['sales_date']);
                $cls_final_cash = 0;
                if(!empty($cls_final_cash_data))
                {
                    $cls_discount_data = $this->accounting_model->get_cls_discount_data_model($staff[2],$_POST['sales_date']);
                    $cls_discount = 0;
                    if(!empty($cls_discount_data))
                    {
                        $cls_discount = $cls_discount_data->discount;
                    }
                    // ================================================================================================================
                    $cls_final_cash = $cls_final_cash_data->final_cash + $cls_discount;
                    $cls_total_final_cash += $cls_final_cash_data->final_cash + $cls_discount;
                }
                // ==========================================END OF CLS FINAL CASH CODE=============================================================
    
                // ==========================================START OF CLS TOTAL CASH CODE===========================================================
                $cls_total_cash = $cls_partial_cash + $cls_final_cash;
                $cls_grand_total_cash += $cls_partial_cash + $cls_final_cash;
                // ==========================================END OF CLS TOTAL CASH CODE=============================================================
    
                // ==========================================START OF NAV PARTIAL CASH CODE===========================================================
                $nav_partial_cash_data = $this->accounting_model->get_nav_partial_cash_data_model_v2($staff[1],$_POST['sales_date'],$store_no_array,$_POST['dcode']);
                $nav_partial_cash = 0;
                if(!empty($nav_partial_cash_data))
                {
                    $nav_partial_cash = $nav_partial_cash_data->partial_cash;
                }
                // ==========================================END OF NAV PARTIAL CASH CODE=============================================================
    
                // ==========================================START OF NAV FINAL CASH CODE=============================================================
                $nav_final_cash_data = $this->accounting_model->get_nav_final_cash_data_model_v2($staff[1],$_POST['sales_date'],$store_no_array,$_POST['dcode']);
                $nav_final_cash = 0;
                if(!empty($nav_final_cash_data))
                {
                    $nav_final_cash = $nav_final_cash_data->final_cash;
                }
                // ==========================================END OF NAV FINAL CASH CODE=============================================================
    
                // ==========================================START OF NAV TOTAL CASH CODE===========================================================
                $nav_total_cash = $nav_partial_cash + $nav_final_cash;
                // ==========================================END OF NAV TOTAL CASH CODE=============================================================
    
                // ==========================================START OF NAV VS CLS CASH VARIANCE CODE===========================================================
                $cash_variance = bcsub($cls_total_cash, $nav_total_cash, 4);
                if($cash_variance < 0)
                {
                    $cash_variance = ltrim($cash_variance, '-');
                    $cash_variance = '('.number_format($cash_variance, 2).')';
                }
                else
                {
                    $cash_variance = number_format($cash_variance, 2);
                }
                // ==========================================END OF NAV VS CLS CASH VARIANCE CODE=============================================================
                
                // ==================================================================================================================================
                $width1 = 7.1;
                $width2 = 7.2;
                $width3 = 7.1;
                $width4 = 7.2;
                $width5 = 7.1;
                $width6 = 7.2;
                $width7 = 7.1;
                $cash_wholesale_td_html = '';
                if($nav_colspan == 4)
                {
                    $width1 = 6.2;
                    $width2 = 6.3;
                    $width3 = 6.3;
                    $width4 = 6.2;
                    $width5 = 6.2;
                    $width6 = 6.3;
                    $width7 = 6.2;
                    $cash_wholesale_data = $this->accounting_model->get_cash_wholesale_amount_model($_POST['sales_date'],$store_no_array,$_POST['dcode'],$staff[1]);
                    $cash_wholesale_amount = 0;
                    if(!is_null($cash_wholesale_data->cash_wholesale))
                    {
                        $nav_final_cash = bcsub($nav_final_cash, $cash_wholesale_data->cash_wholesale, 4);
                        $cash_wholesale_amount = $cash_wholesale_data->cash_wholesale;
                    }
                    $cash_wholesale_td_html = '<td style="text-align: right;" width="6.3%">'.number_format($cash_wholesale_amount, 2).'</td>';
                }
                // ==================================================================================================================================
                $cash_html .= '
                                <tr>
                                    <td width="15%">'.$staff[0].'</td>
                                    <td style="font-size: 6.5px;" width="11%">'.$location_name_array.'</td>
                                    <td width="12%">'.$cls_terminal_array.'</td>
                                    <td width="12%">'.$nav_terminal_array.'</td>
                                    <td style="text-align: right;" width="'.$width1.'%">'.number_format($cls_partial_cash, 2).'</td>
                                    <td style="text-align: right;" width="'.$width2.'%">'.number_format($cls_final_cash, 2).'</td>
                                    <td style="text-align: right;" width="'.$width3.'%">'.number_format($cls_total_cash, 2).'</td>
                                    <td style="text-align: right;" width="'.$width4.'%">'.number_format($nav_partial_cash, 2).'</td>
                                    <td style="text-align: right;" width="'.$width5.'%">'.number_format($nav_final_cash, 2).'</td>
                                    '.$cash_wholesale_td_html.'
                                    <td style="text-align: right;" width="'.$width6.'%">'.number_format($nav_total_cash, 2).'</td>
                                    <td style="text-align: right;" width="'.$width7.'%">'.$cash_variance.'</td>
                                </tr>
                                ';
            }

            // ============================================START OF NONCASH CODE=====================================================================
            $excluded_mop_code = array(1,'total_var');
            if(!in_array($_POST['mop_code'], $excluded_mop_code))
            {
                $mop_bcode = substr($_POST['dcode'], 0, -2);
                $mop_data = $this->accounting_model->get_mop_name_model($_POST['mop_code'],$mop_bcode);
                $mop_name = '';
                if(!empty($mop_data))
                {
                    $mop_name = $mop_data->mop_name;
                }
                $cls_noncash_data = $this->accounting_model->get_cls_noncash_data_model($staff[2],$mop_name,$_POST['sales_date']);
                $cls_mop_amount = 0;
                if(!empty($cls_noncash_data))
                {
                    $cls_mop_amount = $cls_noncash_data->noncash_amount;
                    $cls_total_mop_amount += $cls_noncash_data->noncash_amount;
                }
                // ======================================================================================================================================
                $nav_noncash_data = $this->accounting_model->get_nav_noncash_data_model_v2($mop_code,$staff[1],$_POST['sales_date'],$store_no_array,$_POST['dcode']);
                $nav_mop_amount = 0;
                if(!empty($nav_noncash_data))
                {
                    $nav_mop_amount = $nav_noncash_data->noncash_amount;
                }
                // ======================================================================================================================================
                $noncash_mop_variance = bcsub($cls_mop_amount, $nav_mop_amount, 4);
                if($noncash_mop_variance < 0)
                {
                    $noncash_mop_variance = ltrim($noncash_mop_variance, '-');
                    $noncash_mop_variance = '('.number_format($noncash_mop_variance, 2).')';
                }
                else
                {
                    $noncash_mop_variance = number_format($noncash_mop_variance, 2);
                }
                // ======================================================================================================================================
                $noncash_html .= '
                                <tr>
                                    <td width="20%">'.$staff[0].'</td>
                                    <td width="15%">'.$location_name_array.'</td>
                                    <td width="15%">'.$cls_terminal_array.'</td>
                                    <td width="15%">'.$nav_terminal_array.'</td>
                                    <td width="12%" style="text-align: right;">'.number_format($cls_mop_amount, 2).'</td>
                                    <td width="12%" style="text-align: right;">'.number_format($nav_mop_amount, 2).'</td>
                                    <td width="11%" style="text-align: right;">'.$noncash_mop_variance.'</td>
                                </tr>
                            ';
            }

            // ==============================================START OF TOTAL CODE=====================================================================
            if($_POST['mop_code'] == 'total_var')
            {
                $cls_total_sales_data = $this->accounting_model->get_cls_total_sales_data_model($staff[2],$_POST['sales_date']);
                $cls_total_sales = 0;
                if(!empty($cls_total_sales_data))
                {
                    $cls_total_sales = $cls_total_sales_data->total_sales + $cls_total_sales_data->discount;
                    $cls_grand_total_sales += $cls_total_sales_data->total_sales + $cls_total_sales_data->discount;
                }
                // ===================================================================================================================================
                $nav_total_sales_data = $this->accounting_model->get_nav_total_sales_data_model_v2($staff[1],$_POST['sales_date'],$store_no_array,$_POST['dcode']);
                $nav_total_sales = 0;
                if(!empty($nav_total_sales_data))
                {
                    $nav_total_sales = $nav_total_sales_data->total_sales;
                }
                // ===================================================================================================================================
                $total_sales_variance = bcsub($cls_total_sales, $nav_total_sales, 4);
                if($total_sales_variance < 0)
                {
                    $total_sales_variance = ltrim($total_sales_variance, '-');
                    $total_sales_variance = '('.number_format($total_sales_variance, 2).')';
                }
                else
                {
                    $total_sales_variance = number_format($total_sales_variance, 2);
                }
                // ===================================================================================================================================
                $total_variance_html .= '
                                <tr>
                                    <td width="20%">'.$staff[0].'</td>
                                    <td width="15%">'.$location_name_array.'</td>
                                    <td width="15%">'.$cls_terminal_array.'</td>
                                    <td width="15%">'.$nav_terminal_array.'</td>
                                    <td width="12%" style="text-align: right;">'.number_format($cls_total_sales, 2).'</td>
                                    <td width="12%" style="text-align: right;">'.number_format($nav_total_sales, 2).'</td>
                                    <td width="11%" style="text-align: right;">'.$total_sales_variance.'</td>
                                </tr>
                            ';
            }
        }
        // ========================================================================================================================================
        $nav_total_partial_cash_data = $this->accounting_model->get_nav_total_partial_cash_data_model_v2($_POST['sales_date'],$store_no_array,$_POST['dcode']);
        $nav_total_partial_cash = 0;
        if(!empty($nav_total_partial_cash_data))
        {
            $nav_total_partial_cash = $nav_total_partial_cash_data->total_partial_cash;
        }
        // ========================================================================================================================================
        $nav_total_final_cash_data = $this->accounting_model->get_nav_total_final_cash_data_model_v2($_POST['sales_date'],$store_no_array,$_POST['dcode']);
        $nav_total_final_cash = 0;
        if(!empty($nav_total_final_cash_data))
        {
            $nav_total_final_cash = $nav_total_final_cash_data->total_final_cash;
        }
        // ======================================================================================================================================
        $nav_grand_total_cash = $nav_total_partial_cash + $nav_total_final_cash;
        $total_cash_variance = bcsub($cls_grand_total_cash, $nav_grand_total_cash, 4);
        // ======================================================================================================================================
        if($total_cash_variance < 0)
        {
            $total_cash_variance = ltrim($total_cash_variance, '-');
            $total_cash_variance = '('.number_format($total_cash_variance, 2).')';
        }
        else
        {
            $total_cash_variance = number_format($total_cash_variance, 2);
        }
        // ========================================================================================================================================
        $cash_wholesale_ft_html = '';
        if($nav_colspan == 4)
        {
            $nav_total_final_cash = bcsub($nav_total_final_cash, $cash_wholesale_total, 4);
            $cash_wholesale_ft_html = '<td style="text-align: right;">'.number_format($cash_wholesale_total, 2).'</td>';
        }
        // ========================================================================================================================================
        $cash_html .= '
                        <tr>
                            <td style="text-align: right; font-weight: bold;" colspan="4">TOTAL &nbsp;&nbsp;&nbsp;</td>
                            <td style="text-align: right;">'.number_format($cls_total_partial_cash, 2).'</td>
                            <td style="text-align: right;">'.number_format($cls_total_final_cash, 2).'</td>
                            <td style="text-align: right;">'.number_format($cls_grand_total_cash, 2).'</td>
                            <td style="text-align: right;">'.number_format($nav_total_partial_cash, 2).'</td>
                            <td style="text-align: right;">'.number_format($nav_total_final_cash, 2).'</td>
                            '.$cash_wholesale_ft_html.'
                            <td style="text-align: right;">'.number_format($nav_grand_total_cash, 2).'</td>
                            <td style="text-align: right;">'.$total_cash_variance.'</td>
                        </tr>
                    ';
        $cash_html .= '
                        </tbody>
                    </table>
                    ';
        // =======================================================================================================================================
        $nav_total_noncash_data = $this->accounting_model->get_total_nav_noncash_data_model_v2($mop_code,$_POST['sales_date'],$store_no_array,$_POST['dcode']);
        $nav_total_noncash = 0;
        if(!empty($nav_total_noncash_data))
        {
            $nav_total_noncash = $nav_total_noncash_data->total_noncash_amount;
        }
        // ======================================================================================================================================
        $noncash_total_mop_variance = bcsub($cls_total_mop_amount, $nav_total_noncash, 4);
        if($noncash_total_mop_variance < 0)
        {
            $noncash_total_mop_variance = ltrim($noncash_total_mop_variance, '-');
            $noncash_total_mop_variance = '('.number_format($noncash_total_mop_variance, 2).')';
        }
        else
        {
            $noncash_total_mop_variance = number_format($noncash_total_mop_variance, 2);
        }
        // ======================================================================================================================================
        $noncash_html .= '
                            <tr>
                                <td style="text-align: right; font-weight: bold;" colspan="4">TOTAL &nbsp;&nbsp;&nbsp;</td>
                                <td style="text-align: right;">'.number_format($cls_total_mop_amount, 2).'</td>
                                <td style="text-align: right;">'.number_format($nav_total_noncash, 2).'</td>
                                <td style="text-align: right;">'.$noncash_total_mop_variance.'</td>
                            </tr>
                        ';
        $noncash_html .= '
                            </tbody>
                        </table>
                        ';

        // ======================================================================================================================================
        $nav_grand_total_sales_data = $this->accounting_model->get_nav_grand_total_sales_data_model_v2($_POST['sales_date'],$store_no_array,$_POST['dcode']);
        $nav_grand_total_sales = 0;
        if(!empty($nav_grand_total_sales_data))
        {
            $nav_grand_total_sales = $nav_grand_total_sales_data->total_sales;
        }
        // ======================================================================================================================================
        $grand_total_sales_variance = bcsub($cls_grand_total_sales, $nav_grand_total_sales, 4);
        if($grand_total_sales_variance < 0)
        {
            $grand_total_sales_variance = ltrim($grand_total_sales_variance, '-');
            $grand_total_sales_variance = '('.number_format($grand_total_sales_variance, 2).')';
        }
        else
        {
            $grand_total_sales_variance = number_format($grand_total_sales_variance, 2);
        }
        // ======================================================================================================================================
        $total_variance_html .= '
                            <tr>
                                <td style="text-align: right; font-weight: bold;" colspan="4">TOTAL &nbsp;&nbsp;&nbsp;</td>
                                <td style="text-align: right;">'.number_format($cls_grand_total_sales, 2).'</td>
                                <td style="text-align: right;">'.number_format($nav_grand_total_sales, 2).'</td>
                                <td style="text-align: right;">'.$grand_total_sales_variance.'</td>
                            </tr>
                        ';
        $total_variance_html .= '
                            </tbody>
                        </table>
                        ';
        // ============================================END OF TD LOOP CODE=======================================================================

        // ============================================START OF SELECTING TABLE TO PRINT CODE====================================================
        $tbl_html = '';
        if($_POST['mop_code'] == 1)
        {
            $tbl_html = $cash_html;
        }
        else if($_POST['mop_code'] == 'total_var')
        {
            $tbl_html = $total_variance_html;
        }
        else
        {
            $tbl_html = $noncash_html;
        }
        // =============================================END OF SELECTING TABLE TO PRINT CODE=====================================================

        // ======================================================================================================================================
        $this->ppdf = new TCPDF();
        $this->ppdf->SetTitle("NAV VS CLS VARIANCE");
        $this->ppdf->SetPrintHeader(true);
        $this->ppdf->SetFont('', '', 8, '', true); 
        $this->ppdf->SetMargins(5, 10, 5);
        $this->ppdf->AddPage("L","LETTER");
        $this->ppdf->SetFooterMargin(15);
        $this->ppdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        // $this->ppdf->SetAutoPageBreak(true, PDF_MARGIN_FOOTER);

        $pages = "Page: ".$this->ppdf->getAliasNumPage().'/'.$this->ppdf->getAliasNbPages();
        
        $tbl = '
                <p>
                    UNADJUSTED NAVISION VS CASHIER LIQUIDATION SYSTEM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$pages.'<br>
                    '.$_POST['bname'].'&nbsp;&nbsp;/&nbsp;&nbsp;'.$_POST['dname'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SALES DATE: '.date('F d, Y', strtotime($_POST['sales_date'])).'
                </p>
            ';

        $tbl .= $tbl_html;
  
        $this->ppdf->writeHTML($tbl, true, false, false, false, '');
        ob_end_clean();
        $this->ppdf->Output();  
    }

    public function print_adjusted_navcls_ctrl()
    { 
        $store_no_array = explode("|", $_POST['store_no']);
        $cash_colspan = 7;
        $nav_colspan = 3;
        $cash_wholesale_data = $this->accounting_model->validate_adjsuted_cash_wholesale_model($_POST['sales_date'],$store_no_array,$_POST['dcode']);
        $cash_wholesale_th_html = '';
        $cash_wholesale_total = 0;
        if(!is_null($cash_wholesale_data->cash_wholesale))
        {
            $cash_colspan = 8;
            $nav_colspan = 4;
            $cash_wholesale_total = $cash_wholesale_data->cash_wholesale;
            $cash_wholesale_th_html = '<th style="vertical-align: middle;" scope="col"><center>CASH<br>WHOLESALE</center></th>';
        }
        // ======================================================================================================================================
        $cash_html = '
                        <table border="1" cellpadding="3">
                            <thead>
                                <tr>                                                          
                                    <th style="vertical-align: middle; text-align: center;" width="15%" rowspan="3">
                                        <center><br><br><br>CASHIER\'S NAME</center>
                                    </th>                                                        
                                    <th style="vertical-align: middle; text-align: center;" width="11%" rowspan="3">
                                        <center><br><br><br>LOCATION</center>
                                    </th>
                                    <th style="vertical-align: middle; text-align: center;" width="24%" colspan="2" scope="colgroup">
                                        <center>TERMINAL NO.</center>
                                    </th>  
                                    <th style="vertical-align: middle; text-align: center;" width="50%" colspan="'.$cash_colspan.'" scope="colgroup">
                                        <center>CASH</center>
                                    </th>        
                                </tr>
                                <tr style="border-top: outset; text-align: center;">
                                    <th style="vertical-align: middle;" scope="col" rowspan="2"><center><br><br>CLS</center></th>
                                    <th style="vertical-align: middle;" scope="col" rowspan="2"><center><br><br>NAV</center></th>
                                    <th style="vertical-align: middle;" colspan="3" scope="colgroup"><center>CLS</center></th>
                                    <th style="vertical-align: middle;" colspan="'.$nav_colspan.'" scope="colgroup"><center>NAV</center></th>
                                    <th style="vertical-align: middle;" scope="col" rowspan="2"><center><br><br>VARIANCE</center></th>
                                </tr>
                                <tr style="border-top: outset; text-align: center;">
                                    <th style="vertical-align: middle;" scope="col"><center>PARTIAL</center></th>
                                    <th style="vertical-align: middle;" scope="col"><center>FINAL</center></th>
                                    <th style="vertical-align: middle;" scope="col"><center>TOTAL</center></th>
                                    <th style="vertical-align: middle;" scope="col"><center>PARTIAL</center></th>
                                    <th style="vertical-align: middle;" scope="col"><center>FINAL</center></th>
                                    '.$cash_wholesale_th_html.'
                                    <th style="vertical-align: middle;" scope="col"><center>TOTAL</center></th>
                                </tr>
                            </thead>
                        <tbody>
                        ';
        // =============================================================================================================================================
        $noncash_html = '
                        <table border="1" cellpadding="3">
                            <thead>
                                <tr>                                                          
                                    <th style="vertical-align: middle; text-align: center;" width="20%" rowspan="2">
                                        <center><br><br>CASHIER\'S NAME</center>
                                    </th>                                                        
                                    <th style="vertical-align: middle; text-align: center;" width="15%" rowspan="2">
                                        <center><br><br>LOCATION</center>
                                    </th>
                                    <th style="vertical-align: middle; text-align: center;" width="30%" colspan="2" scope="colgroup">
                                        <center>TERMINAL NO.</center>
                                    </th>  
                                    <th style="vertical-align: middle; text-align: center;" width="35%" colspan="3" scope="colgroup">
                                        <center>'.$_POST['mop_name'].'</center>
                                    </th>        
                                </tr>
                                <tr style="border-top: outset; text-align: center;">
                                    <th style="vertical-align: middle;" scope="col"><center>CLS</center></th>
                                    <th style="vertical-align: middle;" scope="col"><center>NAV</center></th>
                                    <th style="vertical-align: middle;" scope="col" width="12%"><center>CLS</center></th>
                                    <th style="vertical-align: middle;" scope="col" width="12%"><center>NAV</center></th>
                                    <th style="vertical-align: middle;" scope="col" width="11%"><center>VARIANCE</center></th>
                                </tr>
                            </thead>
                        <tbody>
                        ';
        // =============================================================================================================================================
        $total_variance_html = '
                        <table border="1" cellpadding="3">
                            <thead>
                                <tr>                                                          
                                    <th style="vertical-align: middle; text-align: center;" width="20%" rowspan="2">
                                        <center><br><br>CASHIER\'S NAME</center>
                                    </th>                                                        
                                    <th style="vertical-align: middle; text-align: center;" width="15%" rowspan="2">
                                        <center><br><br>LOCATION</center>
                                    </th>
                                    <th style="vertical-align: middle; text-align: center;" width="30%" colspan="2" scope="colgroup">
                                        <center>TERMINAL NO.</center>
                                    </th>  
                                    <th style="vertical-align: middle; text-align: center;" width="35%" colspan="3" scope="colgroup">
                                        <center>TOTAL</center>
                                    </th>        
                                </tr>
                                <tr style="border-top: outset; text-align: center;">
                                    <th style="vertical-align: middle;" scope="col"><center>CLS</center></th>
                                    <th style="vertical-align: middle;" scope="col"><center>NAV</center></th>
                                    <th style="vertical-align: middle;" scope="col" width="12%"><center>CLS</center></th>
                                    <th style="vertical-align: middle;" scope="col" width="12%"><center>NAV</center></th>
                                    <th style="vertical-align: middle;" scope="col" width="11%"><center>VARIANCE</center></th>
                                </tr>
                            </thead>
                        <tbody>
                        ';
        // =============================================================================================================================================
        $store_no_array = explode("|", $_POST['store_no']);
        $nav_data = $this->accounting_model->get_upload_adjusted_navdata_model_v2($_POST['sales_date'],$store_no_array);
        $staff_info_array = array();
        foreach($nav_data as $nav)
        {
            $staff_id_array = array($nav['staff_id'],'0'.$nav['staff_id']);
            $staff_data = $this->accounting_model->get_staff_data_model($staff_id_array);
            if(!empty($staff_data))
            {
                array_push($staff_info_array, $staff_data->name.'|'.$nav['staff_id'].'|'.$staff_data->emp_id);
            }
        }
        // ======================================================================================================================================
        $mop_code = '';
        if($_POST['mop_code'] == 11 || $_POST['mop_code'] == 33)
        {
            $mop_code = array(11,33);
        }
        else
        {
            $mop_code = array($_POST['mop_code']);
        }
        // ======================================================================================================================================

        // ============================================START OF TD LOOP CODE========================================================================
        sort($staff_info_array);
        $cls_total_partial_cash = 0;
        $cls_total_final_cash = 0;
        $cls_grand_total_cash = 0;
        $cls_total_mop_amount = 0;
        $cls_grand_total_sales = 0;
        for($a=0; $a<count($staff_info_array); $a++)
        {
            $staff = explode("|", $staff_info_array[$a]);
            // ============================================START OF LOCATION CODE================================================================
            $cls_cash_location_data = $this->accounting_model->get_cls_cash_location_data_model($staff[2],$_POST['sales_date']);
            $cls_noncash_location_data = $this->accounting_model->get_cls_noncash_location_data_model($staff[2],$_POST['sales_date']);
            $location_code_array = array();
            foreach($cls_cash_location_data as $location)
            {
                if(!in_array($location['sscode'], $location_code_array))
                {
                    array_push($location_code_array, $location['sscode']);
                }
            }
            // ==================================================================================================================================
            foreach($cls_noncash_location_data as $location)
            {
                if(!in_array($location['sscode'], $location_code_array))
                {
                    array_push($location_code_array, $location['sscode']);
                }
            }
            // ==================================================================================================================================
            $location_name_array = array();
            for($b=0; $b<count($location_code_array); $b++)
            {
                $code_length = strlen($location_code_array[$b]);
                if($code_length == 10)
                {
                    $ss_data = $this->accounting_model->get_ssname_model($location_code_array[$b]);
                    if(!empty($ss_data))
                    {
                        array_push($location_name_array, $ss_data->sub_section_name.'<br>');
                    }
                }
                else if($code_length == 8)
                {
                    $s_data = $this->accounting_model->get_sname_model($location_code_array[$b]);
                    if(!empty($s_data))
                    {
                        array_push($location_name_array, $s_data->section_name.'<br>');
                    }
                }
                else if($code_length == 6)
                {
                    $d_data = $this->accounting_model->get_dname_model($location_code_array[$b]);
                    if(!empty($d_data))
                    {
                        array_push($location_name_array, $d_data->dept_name.'<br>');
                    }
                }
            }
            $location_name_array = implode("", $location_name_array);
            $location_name_array = substr_replace($location_name_array, "", -4);
            // ============================================END OF LOCATION CODE=================================================================

            // ==========================================START OF CLS TERMINAL CODE=============================================================
            $cls_terminal_data = $this->accounting_model->get_cls_terminal_data_model($staff[2],$_POST['sales_date']);
            $cls_terminal_array = array();
            foreach($cls_terminal_data as $terminal)
            {
                $terminal_sales = number_format($terminal['total_denomination'] + $terminal['discount'], 2);
                $cls_cash_terminal = $this->accounting_model->get_cls_cash_terminal_model($terminal['tr_no'],$staff[2]);
                $cls_noncash_terminal = $this->accounting_model->get_cls_noncash_terminal_model($terminal['tr_no'],$staff[2]);
                foreach($cls_cash_terminal as $cash)
                {
                   array_push($cls_terminal_array, $cash['pos_name'].' | '.$terminal_sales.'<br>');
                }
                // ==============================================================================================================
                foreach($cls_noncash_terminal as $noncash)
                {
                    if(!in_array($noncash['pos_name'].' | '.$terminal_sales.'<br>', $cls_terminal_array))
                    {
                        array_push($cls_terminal_array, $noncash['pos_name'].' | '.$terminal_sales.'<br>');
                    }
                }
            }
            // sort($cls_terminal_array);
            $cls_terminal_array = implode("", $cls_terminal_array);
            $cls_terminal_array = substr_replace($cls_terminal_array, "", -4);
            // ==========================================END OF CLS TERMINAL CODE=============================================================

            // ==========================================START OF NAV TERMINAL CODE=============================================================
            $nav_terminal_data = $this->accounting_model->get_nav_adjusted_terminal_data_model_v2($staff[1],$_POST['sales_date'],$store_no_array,$_POST['dcode']);
            $nav_terminal_array = array();
            foreach($nav_terminal_data as $nav)
            {
                array_push($nav_terminal_array, $nav['pos_terminal_no'].' | '.number_format($nav['terminal_sales'], 2).'<br>');
            }
            $nav_terminal_array = implode("", $nav_terminal_array);
            $nav_terminal_array = substr_replace($nav_terminal_array, "", -4);
            // ==========================================END OF NAV TERMINAL CODE=============================================================

            if($_POST['mop_code'] == 1)
            {
                // ==========================================START OF CLS PARTIAL CASH CODE=========================================================
                $cls_partial_cash_data = $this->accounting_model->get_cls_partial_cash_data_model($staff[2],$_POST['sales_date']);
                $cls_partial_cash = 0;
                if(!empty($cls_partial_cash_data))
                {
                    $cls_partial_cash = $cls_partial_cash_data->partial_cash;
                    $cls_total_partial_cash += $cls_partial_cash_data->partial_cash;
                }
                // ==========================================END OF CLS PARTIAL CASH CODE===========================================================
                
                // ==========================================START OF CLS FINAL CASH CODE===========================================================
                $cls_final_cash_data = $this->accounting_model->get_cls_final_cash_data_model($staff[2],$_POST['sales_date']);
                $cls_final_cash = 0;
                if(!empty($cls_final_cash_data))
                {
                    $cls_discount_data = $this->accounting_model->get_cls_discount_data_model($staff[2],$_POST['sales_date']);
                    $cls_discount = 0;
                    if(!empty($cls_discount_data))
                    {
                        $cls_discount = $cls_discount_data->discount;
                    }
                    // ================================================================================================================
                    $cls_final_cash = $cls_final_cash_data->final_cash + $cls_discount;
                    $cls_total_final_cash += $cls_final_cash_data->final_cash + $cls_discount;
                }
                // ==========================================END OF CLS FINAL CASH CODE=============================================================
    
                // ==========================================START OF CLS TOTAL CASH CODE===========================================================
                $cls_total_cash = $cls_partial_cash + $cls_final_cash;
                $cls_grand_total_cash += $cls_partial_cash + $cls_final_cash;
                // ==========================================END OF CLS TOTAL CASH CODE=============================================================
    
                // ==========================================START OF NAV PARTIAL CASH CODE===========================================================
                $nav_partial_cash_data = $this->accounting_model->get_nav_adjusted_partial_cash_data_model_v2($staff[1],$_POST['sales_date'],$store_no_array,$_POST['dcode']);
                $nav_partial_cash = 0;
                if(!empty($nav_partial_cash_data))
                {
                    $nav_partial_cash = $nav_partial_cash_data->partial_cash;
                }
                // ==========================================END OF NAV PARTIAL CASH CODE=============================================================
    
                // ==========================================START OF NAV FINAL CASH CODE=============================================================
                $nav_final_cash_data = $this->accounting_model->get_nav_adjusted_final_cash_data_model_v2($staff[1],$_POST['sales_date'],$store_no_array,$_POST['dcode']);
                $nav_final_cash = 0;
                if(!empty($nav_final_cash_data))
                {
                    $nav_final_cash = $nav_final_cash_data->final_cash;
                }
                // ==========================================END OF NAV FINAL CASH CODE=============================================================
    
                // ==========================================START OF NAV TOTAL CASH CODE===========================================================
                $nav_total_cash = $nav_partial_cash + $nav_final_cash;
                // ==========================================END OF NAV TOTAL CASH CODE=============================================================
    
                // ==========================================START OF NAV VS CLS CASH VARIANCE CODE===========================================================
                $cash_variance = bcsub($cls_total_cash, $nav_total_cash, 4);
                if($cash_variance < 0)
                {
                    $cash_variance = ltrim($cash_variance, '-');
                    $cash_variance = '('.number_format($cash_variance, 2).')';
                }
                else
                {
                    $cash_variance = number_format($cash_variance, 2);
                }
                // ==========================================END OF NAV VS CLS CASH VARIANCE CODE=============================================================
                
                // ==================================================================================================================================
                $width1 = 7.1;
                $width2 = 7.2;
                $width3 = 7.1;
                $width4 = 7.2;
                $width5 = 7.1;
                $width6 = 7.2;
                $width7 = 7.1;
                $cash_wholesale_td_html = '';
                if($nav_colspan == 4)
                {
                    $width1 = 6.2;
                    $width2 = 6.3;
                    $width3 = 6.3;
                    $width4 = 6.2;
                    $width5 = 6.2;
                    $width6 = 6.3;
                    $width7 = 6.2;
                    $cash_wholesale_data = $this->accounting_model->ge_adjusted_cash_wholesale_amount_model($_POST['sales_date'],$store_no_array,$_POST['dcode'],$staff[1]);
                    $cash_wholesale_amount = 0;
                    if(!is_null($cash_wholesale_data->cash_wholesale))
                    {
                        $nav_final_cash = bcsub($nav_final_cash, $cash_wholesale_data->cash_wholesale, 4);
                        $cash_wholesale_amount = $cash_wholesale_data->cash_wholesale;
                    }
                    $cash_wholesale_td_html = '<td style="text-align: right;" width="6.3%">'.number_format($cash_wholesale_amount, 2).'</td>';
                }
                // ==================================================================================================================================
                $cash_html .= '
                                <tr>
                                    <td width="15%">'.$staff[0].'</td>
                                    <td style="font-size: 6.5px;" width="11%">'.$location_name_array.'</td>
                                    <td width="12%">'.$cls_terminal_array.'</td>
                                    <td width="12%">'.$nav_terminal_array.'</td>
                                    <td style="text-align: right;" width="'.$width1.'%">'.number_format($cls_partial_cash, 2).'</td>
                                    <td style="text-align: right;" width="'.$width2.'%">'.number_format($cls_final_cash, 2).'</td>
                                    <td style="text-align: right;" width="'.$width3.'%">'.number_format($cls_total_cash, 2).'</td>
                                    <td style="text-align: right;" width="'.$width4.'%">'.number_format($nav_partial_cash, 2).'</td>
                                    <td style="text-align: right;" width="'.$width5.'%">'.number_format($nav_final_cash, 2).'</td>
                                    '.$cash_wholesale_td_html.'
                                    <td style="text-align: right;" width="'.$width6.'%">'.number_format($nav_total_cash, 2).'</td>
                                    <td style="text-align: right;" width="'.$width7.'%">'.$cash_variance.'</td>
                                </tr>
                                ';
            }

            // ============================================START OF NONCASH CODE=====================================================================
            $excluded_mop_code = array(1,'total_var');
            if(!in_array($_POST['mop_code'], $excluded_mop_code))
            {
                $mop_bcode = substr($_POST['dcode'], 0, -2);
                $mop_data = $this->accounting_model->get_mop_name_model($_POST['mop_code'],$mop_bcode);
                $mop_name = '';
                if(!empty($mop_data))
                {
                    $mop_name = $mop_data->mop_name;
                }
                $cls_noncash_data = $this->accounting_model->get_cls_noncash_data_model($staff[2],$mop_name,$_POST['sales_date']);
                $cls_mop_amount = 0;
                if(!empty($cls_noncash_data))
                {
                    $cls_mop_amount = $cls_noncash_data->noncash_amount;
                    $cls_total_mop_amount += $cls_noncash_data->noncash_amount;
                }
                // ======================================================================================================================================
                $nav_noncash_data = $this->accounting_model->get_nav_adjusted_noncash_data_model_v2($mop_code,$staff[1],$_POST['sales_date'],$store_no_array,$_POST['dcode']);
                $nav_mop_amount = 0;
                if(!empty($nav_noncash_data))
                {
                    $nav_mop_amount = $nav_noncash_data->noncash_amount;
                }
                // ======================================================================================================================================
                $noncash_mop_variance = bcsub($cls_mop_amount, $nav_mop_amount, 4);
                if($noncash_mop_variance < 0)
                {
                    $noncash_mop_variance = ltrim($noncash_mop_variance, '-');
                    $noncash_mop_variance = '('.number_format($noncash_mop_variance, 2).')';
                }
                else
                {
                    $noncash_mop_variance = number_format($noncash_mop_variance, 2);
                }
                // ======================================================================================================================================
                $noncash_html .= '
                                <tr>
                                    <td width="20%">'.$staff[0].'</td>
                                    <td width="15%">'.$location_name_array.'</td>
                                    <td width="15%">'.$cls_terminal_array.'</td>
                                    <td width="15%">'.$nav_terminal_array.'</td>
                                    <td width="12%" style="text-align: right;">'.number_format($cls_mop_amount, 2).'</td>
                                    <td width="12%" style="text-align: right;">'.number_format($nav_mop_amount, 2).'</td>
                                    <td width="11%" style="text-align: right;">'.$noncash_mop_variance.'</td>
                                </tr>
                            ';
            }

            // ==============================================START OF TOTAL CODE=====================================================================
            if($_POST['mop_code'] == 'total_var')
            {
                $cls_total_sales_data = $this->accounting_model->get_cls_total_sales_data_model($staff[2],$_POST['sales_date']);
                $cls_total_sales = 0;
                if(!empty($cls_total_sales_data))
                {
                    $cls_total_sales = $cls_total_sales_data->total_sales + $cls_total_sales_data->discount;
                    $cls_grand_total_sales += $cls_total_sales_data->total_sales + $cls_total_sales_data->discount;
                }
                // ===================================================================================================================================
                $nav_total_sales_data = $this->accounting_model->get_nav_adjusted_total_sales_data_model_v2($staff[1],$_POST['sales_date'],$store_no_array,$_POST['dcode']);
                $nav_total_sales = 0;
                if(!empty($nav_total_sales_data))
                {
                    $nav_total_sales = $nav_total_sales_data->total_sales;
                }
                // ===================================================================================================================================
                $total_sales_variance = bcsub($cls_total_sales, $nav_total_sales, 4);
                if($total_sales_variance < 0)
                {
                    $total_sales_variance = ltrim($total_sales_variance, '-');
                    $total_sales_variance = '('.number_format($total_sales_variance, 2).')';
                }
                else
                {
                    $total_sales_variance = number_format($total_sales_variance, 2);
                }
                // ===================================================================================================================================
                $total_variance_html .= '
                                <tr>
                                    <td width="20%">'.$staff[0].'</td>
                                    <td width="15%">'.$location_name_array.'</td>
                                    <td width="15%">'.$cls_terminal_array.'</td>
                                    <td width="15%">'.$nav_terminal_array.'</td>
                                    <td width="12%" style="text-align: right;">'.number_format($cls_total_sales, 2).'</td>
                                    <td width="12%" style="text-align: right;">'.number_format($nav_total_sales, 2).'</td>
                                    <td width="11%" style="text-align: right;">'.$total_sales_variance.'</td>
                                </tr>
                            ';
            }
        }
        // ========================================================================================================================================
        $nav_total_partial_cash_data = $this->accounting_model->get_nav_adjusted_total_partial_cash_data_model_v2($_POST['sales_date'],$store_no_array,$_POST['dcode']);
        $nav_total_partial_cash = 0;
        if(!empty($nav_total_partial_cash_data))
        {
            $nav_total_partial_cash = $nav_total_partial_cash_data->total_partial_cash;
        }
        // ========================================================================================================================================
        $nav_total_final_cash_data = $this->accounting_model->get_nav_adjusted_total_final_cash_data_model_v2($_POST['sales_date'],$store_no_array,$_POST['dcode']);
        $nav_total_final_cash = 0;
        if(!empty($nav_total_final_cash_data))
        {
            $nav_total_final_cash = $nav_total_final_cash_data->total_final_cash;
        }
        // ======================================================================================================================================
        $nav_grand_total_cash = $nav_total_partial_cash + $nav_total_final_cash;
        $total_cash_variance = bcsub($cls_grand_total_cash, $nav_grand_total_cash, 4);
        // ======================================================================================================================================
        if($total_cash_variance < 0)
        {
            $total_cash_variance = ltrim($total_cash_variance, '-');
            $total_cash_variance = '('.number_format($total_cash_variance, 2).')';
        }
        else
        {
            $total_cash_variance = number_format($total_cash_variance, 2);
        }
        // ========================================================================================================================================
        $cash_wholesale_ft_html = '';
        if($nav_colspan == 4)
        {
            $nav_total_final_cash = bcsub($nav_total_final_cash, $cash_wholesale_total, 4);
            $cash_wholesale_ft_html = '<td style="text-align: right;">'.number_format($cash_wholesale_total, 2).'</td>';
        }
        // ========================================================================================================================================
        $cash_html .= '
                        <tr>
                            <td style="text-align: right; font-weight: bold;" colspan="4">TOTAL &nbsp;&nbsp;&nbsp;</td>
                            <td style="text-align: right;">'.number_format($cls_total_partial_cash, 2).'</td>
                            <td style="text-align: right;">'.number_format($cls_total_final_cash, 2).'</td>
                            <td style="text-align: right;">'.number_format($cls_grand_total_cash, 2).'</td>
                            <td style="text-align: right;">'.number_format($nav_total_partial_cash, 2).'</td>
                            <td style="text-align: right;">'.number_format($nav_total_final_cash, 2).'</td>
                            '.$cash_wholesale_ft_html.'
                            <td style="text-align: right;">'.number_format($nav_grand_total_cash, 2).'</td>
                            <td style="text-align: right;">'.$total_cash_variance.'</td>
                        </tr>
                    ';
        $cash_html .= '
                        </tbody>
                    </table>
                    ';
        // =======================================================================================================================================
        $nav_total_noncash_data = $this->accounting_model->get_total_adjusted_nav_noncash_data_model_v2($mop_code,$_POST['sales_date'],$store_no_array,$_POST['dcode']);
        $nav_total_noncash = 0;
        if(!empty($nav_total_noncash_data))
        {
            $nav_total_noncash = $nav_total_noncash_data->total_noncash_amount;
        }
        // ======================================================================================================================================
        $noncash_total_mop_variance = bcsub($cls_total_mop_amount, $nav_total_noncash, 4);
        if($noncash_total_mop_variance < 0)
        {
            $noncash_total_mop_variance = ltrim($noncash_total_mop_variance, '-');
            $noncash_total_mop_variance = '('.number_format($noncash_total_mop_variance, 2).')';
        }
        else
        {
            $noncash_total_mop_variance = number_format($noncash_total_mop_variance, 2);
        }
        // ======================================================================================================================================
        $noncash_html .= '
                            <tr>
                                <td style="text-align: right; font-weight: bold;" colspan="4">TOTAL &nbsp;&nbsp;&nbsp;</td>
                                <td style="text-align: right;">'.number_format($cls_total_mop_amount, 2).'</td>
                                <td style="text-align: right;">'.number_format($nav_total_noncash, 2).'</td>
                                <td style="text-align: right;">'.$noncash_total_mop_variance.'</td>
                            </tr>
                        ';
        $noncash_html .= '
                            </tbody>
                        </table>
                        ';

        // ======================================================================================================================================
        $nav_grand_total_sales_data = $this->accounting_model->get_nav_adjusted_grand_total_sales_data_model_v2($_POST['sales_date'],$store_no_array,$_POST['dcode']);
        $nav_grand_total_sales = 0;
        if(!empty($nav_grand_total_sales_data))
        {
            $nav_grand_total_sales = $nav_grand_total_sales_data->total_sales;
        }
        // ======================================================================================================================================
        $grand_total_sales_variance = bcsub($cls_grand_total_sales, $nav_grand_total_sales, 4);
        if($grand_total_sales_variance < 0)
        {
            $grand_total_sales_variance = ltrim($grand_total_sales_variance, '-');
            $grand_total_sales_variance = '('.number_format($grand_total_sales_variance, 2).')';
        }
        else
        {
            $grand_total_sales_variance = number_format($grand_total_sales_variance, 2);
        }
        // ======================================================================================================================================
        $total_variance_html .= '
                            <tr>
                                <td style="text-align: right; font-weight: bold;" colspan="4">TOTAL &nbsp;&nbsp;&nbsp;</td>
                                <td style="text-align: right;">'.number_format($cls_grand_total_sales, 2).'</td>
                                <td style="text-align: right;">'.number_format($nav_grand_total_sales, 2).'</td>
                                <td style="text-align: right;">'.$grand_total_sales_variance.'</td>
                            </tr>
                        ';
        $total_variance_html .= '
                            </tbody>
                        </table>
                        ';
        // ============================================END OF TD LOOP CODE=======================================================================

        // ============================================START OF SELECTING TABLE TO PRINT CODE====================================================
        $tbl_html = '';
        if($_POST['mop_code'] == 1)
        {
            $tbl_html = $cash_html;
        }
        else if($_POST['mop_code'] == 'total_var')
        {
            $tbl_html = $total_variance_html;
        }
        else
        {
            $tbl_html = $noncash_html;
        }
        // =============================================END OF SELECTING TABLE TO PRINT CODE=====================================================

        // ======================================================================================================================================
        $this->ppdf = new TCPDF();
        $this->ppdf->SetTitle("NAV VS CLS VARIANCE");
        $this->ppdf->SetPrintHeader(true);
        $this->ppdf->SetFont('', '', 8, '', true); 
        $this->ppdf->SetMargins(5, 10, 5);
        $this->ppdf->AddPage("L","LETTER");
        $this->ppdf->SetFooterMargin(15);
        $this->ppdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        // $this->ppdf->SetAutoPageBreak(true, PDF_MARGIN_FOOTER);

        $pages = "Page: ".$this->ppdf->getAliasNumPage().'/'.$this->ppdf->getAliasNbPages();
        
        $tbl = '
                <p>
                    ADJUSTED NAVISION VS CASHIER LIQUIDATION SYSTEM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$pages.'<br>
                    '.$_POST['bname'].'&nbsp;&nbsp;/&nbsp;&nbsp;'.$_POST['dname'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SALES DATE: '.date('F d, Y', strtotime($_POST['sales_date'])).'
                </p>
            ';

        $tbl .= $tbl_html;
  
        $this->ppdf->writeHTML($tbl, true, false, false, false, '');
        ob_end_clean();
        $this->ppdf->Output();  
    }



}
