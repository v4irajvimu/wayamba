<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class t_change_due_day extends CI_Model{
  
  private $sd;
  private $mtb;
  
  private $mod = '003';
  
  function __construct(){
    parent::__construct();
    
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->load->model('user_permissions');
    $this->max_no = 0;
  }
  
    public function base_details(){
        $a['max_no']=$this->max_no();
        return $a;
    }
    
    public function save(){

        $no = $_POST['no'];
        $agr_no  = $_POST['agreement_no'];
        $cus_id = $_POST['customer_id'];
        $loan_date = $_POST['loan_date'];
        $noi = $_POST['no_of_installments'];
        $new_due_day = $_POST['new_due_day'];
        $date = $_POST['date'];
        $last_chge_date = $_POST['last_loan_c_date'];
        $oc = $this->sd['oc'];
        $bc = $this->sd['branch'];
        $cl = $this->sd['cl'];

        $q = $this->db->query("INSERT INTO `t_due_day_change_sum` VALUES('','$no','$agr_no','$cus_id','$loan_date','$noi','$new_due_day','$date','".date('Y-m-d')."','$oc','$bc','$cl')");
        

        $ins_no = $_POST['ins_no'];
        $due_date = $_POST['due_date'];
        $new_due_date = $_POST['new_due_date'];

        for($num=0; $num<count($_POST['ins_no']);   $num++){
            
            $qq = $this->db->query("INSERT INTO `t_due_day_change_det` VALUES('$no','".$ins_no[$num]."','".$due_date[$num]."','".$new_due_date[$num]."')");

            $qqq = $this->db->query("   UPDATE t_ins_schedule SET due_date = '".$new_due_date[$num]."' 
                                        WHERE cl = '$cl' AND bc = '$bc' AND agr_no = '".$agr_no."' AND ins_no = '".$ins_no[$num]."' AND due_date = '".$due_date[$num]."' ");

        }



    }
  
  
   
  
    public function delete(){

    }
  
    public function get_data(){

    }
  
  
  
  public function PDF_report(){        
    $no = $_POST['qno'];
    $r_detail['sum'] = $this->db->query("SELECT * FROM `t_due_day_change_sum` S JOIN m_customer C ON S.`cus_id` = C.`code` WHERE `no` = '$no'")->row();
    $r_detail['det'] = $this->db->query("SELECT * FROM `t_due_day_change_det` WHERE NO = '$no'")->result();

    $this->load->view($_POST['by'] . '_' . 'pdf', $r_detail);
  }



  public function max_no(){
    return $this->db->query("SELECT IFNULL(MAX(NO)+1,1) AS `max_no` FROM t_due_day_change_sum")->row()->max_no;
  }


    public function load_agreement(){
        $agr_no = $_POST['agr_no'];
        $bc     = $this->sd['branch'];
        $cl     = $this->sd['cl'];
        $a['a'] =$this->db->query("SELECT * FROM `t_ins_schedule` WHERE cl = '$cl' AND bc = '$bc' AND agr_no = '$agr_no'")->result();

        $a['b'] =$this->db->query(" SELECT SS.`agreement_no`,C.code,C.`name`, SS.`ddate`,SS.`no_of_installments` 
                                    FROM t_hp_sales_sum SS
                                    JOIN m_customer C ON SS.`cus_id` = C.code
                                    WHERE SS.`cl` = '$cl' AND SS.`bc` ='$bc' AND SS.agreement_no = '$agr_no'")->row();

        $qc = $this->db->query("SELECT last_chge_date FROM `t_due_day_change_sum` WHERE cl = '$cl' and bc = '$bc' and agr_no = '$agr_no'");

        if ($qc->num_rows() > 0){
            $a['c'] = $qc->row()->last_chge_date;
        }else{
            $a['c'] = "";
        }


        echo json_encode($a);

    }



    public function set_preview(){

        $current_Y_M = date('Y-m', strtotime(date('Y-m-d')));

        $agr_no = $_POST['agr_no'];
        $bc     = $this->sd['branch'];
        $cl     = $this->sd['cl'];
        
        $Q = $this->db->query("SELECT ins_no,due_date FROM `t_ins_schedule` WHERE cl = '$cl' AND bc = '$bc' AND agr_no = '$agr_no'");

        $new_due_day = $_POST['new_due_day'];

        if ($new_due_day < 10){
            $new_due_day = "0".$new_due_day;
        }       

        $bc = $this->sd['bc'];
        $Q = $this->db->query("SELECT ins_no,due_date FROM `t_ins_schedule` WHERE cl = '$cl' AND bc = '$bc' AND agr_no = '$agr_no'");

        $current_year_month = date('Y-m');
        $T = "";        
        
        if ($Q->num_rows > 0){ 

            foreach($Q->result() as $R){
                
                $full_due_date    = $R->due_date;
                $installment_Y_M  = substr($full_due_date,0,7);
                
                if ($current_year_month == $installment_Y_M){
                    $T .= "<tr bgColor=#eaeaea ><td>". $R->ins_no ."</td><td>". $R->due_date ."</td><td>". $R->due_date ."</td><td style='color:red'>Not affecting to current month</td>/tr>";
                }else{

                    $YM = date("Y-m-",strtotime($R->due_date));                 
                    $new_due_date = $YM.$new_due_day;

                    if ($this->isValidDate($new_due_date)){
                        $new_due_date = $new_due_date;
                    }else{
                        $new_due_date = $YM. date('d',strtotime(date('Y-m-t',strtotime($R->due_date))));
                    }

                    $T .= "<tr><td>". $R->ins_no ." <input type='hidden' name='ins_no[]' title='".$R->ins_no."' value='".$R->ins_no."'> </td><td>". $R->due_date ." <input type='hidden' name='due_date[]' title='".$R->due_date."' value='".$R->due_date."'> </td><td>". $new_due_date ." <input type='hidden' name='new_due_date[]' title='".$new_due_date."' value='".$new_due_date."'></td></tr>";                
                    
                }
            }
            

        }
        
        echo ($T);


    }



    function isValidDate($date){
        $dtInfo = date_parse($date);    
        if($dtInfo['warning_count'] == 0 && $dtInfo['error_count'] == 0 ){
            return true;
        }else{
            return false;
        }
    }


    public function load_data(){
        
        $no = $_POST['no'];
        $Q = $this->db->query("SELECT * FROM `t_due_day_change_sum` S JOIN m_customer C ON S.`cus_id` = C.`code` WHERE no = '$no'");

        if ($Q->num_rows() > 0){
            
            $a['sum'] = $Q->row();

            $QQ = $this->db->query("SELECT * FROM `t_due_day_change_det` WHERE `no` = '$no'");
            $T  = "";

            foreach ($QQ->result() as $R) {
                $T .= "<tr><td>". $R->ints_no ."</td><td>". $R->old_date ."</td><td>". $R->new_date ."</td></tr>";                
            }

            $a['t'] = $T;
            $a['a'] = 1;
        }else{
            $a['a'] = 0;
        }

        echo json_encode($a);

    }


  
}