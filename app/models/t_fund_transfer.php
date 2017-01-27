<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class t_fund_transfer extends CI_Model {
  private $max_no;
  private $mod='003';
  function __construct() {
    parent::__construct();
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
    $this->load->model("user_permissions");
  }

  public function base_details(){
    $a['d_bc']=$this->load_login_bc();
    $a['d_acc']=$this->transit_acc();
    $a['d_cash_bk']=$this->aac_code();
    $this->load->model("utility");
    $a['max_no'] = $this->utility->get_max_no("t_fund_transfer_sum", "nno");
    return $a;
  }

  public function load_login_bc(){
    $sql="SELECT b.bc,b.name FROM `m_branch` b where  b.bc='".$this->sd['branch']."'";
    $query = $this->db->query($sql)->row();
  
    $ar['bc'] = $query->bc;
    $ar['name'] = $query->name;
    return $ar;
  }

  public function transit_acc(){
    $sql="SELECT acc_code,description FROM `m_default_account` WHERE code='CASH_TRANSIT'";
    $query = $this->db->query($sql)->row();
  
    $ar['code'] = $query->acc_code;
    $ar['des'] = $query->description;
    return $ar;
  }

  public function aac_code(){
    $sql="SELECT acc_code,description FROM `m_default_account` WHERE code='CASH_IN_HAND'";
    $query = $this->db->query($sql)->row();
    
    $ar['acc'] = $query->acc_code;
    $ar['des'] = $query->description;
    return $ar;
  }  

  public function cash_bk_bal(){
    $acc=$_POST['acc_code'];

    /*$sql="SELECT sIFNULL(SUM( t.`dr_amount`),0) - IFNULL((t.`cr_amount`),0) AS OPB 
            FROM `t_account_trans` t 
            WHERE t.`cl`='".$this->sd['cl']."' AND t.`bc`='".$this->sd['branch']."' AND t.`ddate` < '".date('Y-m-d')."' AND 
            t.`acc_code` IN ( SELECT acc_code FROM `m_default_account` WHERE CODE='$acc')";*/

     $sql="SELECT IFNULL(SUM( t.`dr_amount`),0) - IFNULL(SUM(t.`cr_amount`),0) AS OPB 
            FROM `t_account_trans` t 
            WHERE t.`cl`='".$this->sd['cl']."' AND t.`bc`='".$this->sd['branch']."' AND t.`ddate` <= '".date('Y-m-d')."' AND 
            t.`acc_code` ='$acc'";
    $query = $this->db->query($sql);
    $query = $this->db->query($sql);
    echo $query->row()->OPB;
  }  

  public function validation(){
    $this->max_no = $this->utility->get_max_no("t_fund_transfer_sum", "nno");
    return 1;
  }


  public function save(){
    $this->db->trans_begin();
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
        throw new Exception($errLine); 
    }
    set_error_handler('exceptionThrower'); 
    try {
      $validation_status = $this->validation();
      if($validation_status == 1) {
        $sum = array(
          "cl"                    => $this->sd['cl'],
          "bc"                    => $this->sd['branch'],
          "nno"                   => $this->max_no,
          "ddate"                 => $_POST['date'],
          "ref_no"                => $_POST['ref_no'],
          "cash_transit_acc_code" => $_POST['tr_acc'],
          "cash_book_acc_code"    => $_POST['cash_bk'],
          "cashier"               => $_POST['cashier_code'],
          "hand_over"             => $_POST['hand_ot'],
          "cash_book_bal"         => $_POST['cash_bb'],
          "transfer_amount"       => $_POST['transfer_am'],
          "cur_cashier_bal"       => $_POST['cc_bal'],
          "sub_cl"                => $_POST['to_cl'],
          "sub_bc"                => $_POST['to_branch'],
          "status"                => 1,
          "oc"                    => $this->sd['oc']
        );


        if ($_POST['hid'] == "0" || $_POST['hid'] == ""){
          if($this->user_permissions->is_add('t_fund_transfer')){
            $account_update=$this->account_update(0);
            if($account_update==1){
              $this->db->insert('t_fund_transfer_sum', $sum);
              $this->account_update(1);
              echo $this->db->trans_commit();
            }else{
              return "Invalid account entries";
            }
          }else{
            echo "No permission to save records";
            $this->db->trans_commit();
          }    

        }else{
          if($this->user_permissions->is_edit('t_fund_transfer')){
            $account_update=$this->account_update(0);
            if($account_update==1){
              $chk_update = $this->check_received($_POST['hid'],$_POST['fr_branch_des']);
              if($chk_update ==1){
                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->where('nno', $this->max_no);
                $this->db->update('t_fund_transfer_sum', $sum);
                $this->account_update(1);
                echo $this->db->trans_commit();
              }else{
                echo $chk_update;
                $this->db->trans_commit();
              }
            }else{
              return "Invalid account entries";
            }  
          }else{
            echo "No permission to edit records";
            $this->db->trans_commit();
          }    
        }
      }else{
        echo $validation_status;
        $this->db->trans_commit();
      }
    }catch(Exception $e){ 
        $this->db->trans_rollback();
        echo $e->getMessage()."Operation fail please contact admin"; 
    }   
  }
 
  public function check_received($no,$bname){
    $status =1;
    $sql="SELECT `status` FROM t_fund_transfer_sum
          WHERE cl='".$this->sd['cl']."' 
          AND bc='".$this->sd['branch']."' 
          AND nno='$no' AND `status` = '1'";

    $query = $this->db->query($sql);

    if($query->num_rows()>0){
      $status=1;
    }else{
      $status="This fund transfer number received from (".$bname.") branch.";
    }
    return $status;
  }

  public function load(){
    $sql="SELECT  t.nno,
                  t.ddate,
                  t.ref_no,
                  t.`cash_transit_acc_code`,
                  m.`description` AS tansit_des,
                  t.`cash_book_acc_code`,
                  mm.`description` AS cb_des,
                  t.cashier,
                  e.name AS c_name,
                  t.hand_over,
                  ee.name AS h_name,
                  t.`cash_book_bal`,
                  t.`transfer_amount`,
                  t.`cur_cashier_bal`,
                  t.`sub_cl`,
                  c.`description` AS cl_name,
                  t.`sub_bc`,
                  b.`name` AS b_name,
                  t.is_cancel
          FROM t_fund_transfer_sum t
          JOIN m_account m ON m.`code` = t.`cash_transit_acc_code`
          JOIN m_account mm ON mm.`code` = t.`cash_book_acc_code`
          JOIN m_employee e ON e.code = t.cashier
          JOIN m_employee ee ON ee.code = t.hand_over
          JOIN m_cluster c ON c.`code` = t.`sub_cl`
          JOIN m_branch b ON b.bc = t.`sub_bc`
          WHERE t.cl='".$this->sd['cl']."' 
          AND t.bc='".$this->sd['branch']."' 
          AND t.nno='".$_POST['id']."' ";

    $query = $this->db->query($sql);
    if($query->num_rows()>0){
      $result = $query->result();
    }else{
      $result = "2";
    }
    echo json_encode($result);
  }


  public function delete(){
    $this->db->trans_begin();
      error_reporting(E_ALL); 
      function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
          throw new Exception($errLine); 
      }
      set_error_handler('exceptionThrower'); 
      try {
        if($this->user_permissions->is_delete('t_fund_transfer')){
          $chk_update = $this->check_received($_POST['id'],$_POST['f_bc']);
          if($chk_update ==1){
          
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->where('nno', $_POST['id']);
            $this->db->update('t_fund_transfer_sum', array("is_cancel" =>1));

            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->where('trans_code', 96);
            $this->db->where('trans_no', $_POST['id']);
            $this->db->delete('t_account_trans');
                
            echo $this->db->trans_commit();
          }else{
            echo $chk_update;
            $this->db->trans_commit();
          }
        }else{
          echo "No permission to delete records";
          $this->db->trans_commit();
        }  

      }catch(Exception $e){ 
        $this->db->trans_rollback();
        echo $e->getMessage()."Operation fail please contact admin"; 
      } 
  }



public function account_update($condition) {
        $this->db->where("trans_no", $this->max_no);
        $this->db->where("trans_code", 96);
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->delete("t_check_double_entry");

        if ($_POST['hid'] != "0" || $_POST['hid'] != "") {
            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('trans_code',96);
            $this->db->where('trans_no',$this->max_no);
            $this->db->delete('t_account_trans');
        }

        $config = array(
            "ddate" => $_POST['date'],
            "trans_code" => 96,
            "trans_no" => $this->max_no,
            "op_acc" => 0,
            "reconcile" => 0,
            "cheque_no" => 0,
            "narration" => "",
            "ref_no" => $_POST['ref_no']
        );

        $amount = $_POST['transfer_am'];
        $this->load->model('account');
        $this->account->set_data($config);

        $sql_b="SELECT name from m_branch where bc='".$_POST['to_branch']."'";
        $to_bc_name=$this->db->query($sql_b)->first_row()->name;

        $des = "Fund Transfer To- (" . $to_bc_name." - No ".$this->max_no.")";
         
        $cash_book=$this->utility->get_default_acc('CASH_IN_HAND');
        $this->account->set_value2($des, $amount, "cr", $cash_book,$condition);

        $cash_transit=$this->utility->get_default_acc('CASH_TRANSIT');
        $this->account->set_value2($des, $amount, "dr", $cash_transit,$condition);

        if($condition==0){
             $query = $this->db->query("
                 SELECT (IFNULL( SUM( t.`dr_amount`),0) = IFNULL(SUM(t.`cr_amount`),0)) AS ok 
                 FROM `t_check_double_entry` t
                 LEFT JOIN `m_account` a ON t.`acc_code` = a.`code`
                 WHERE  t.`cl`='" . $this->sd['cl'] . "'  AND t.`bc`='" . $this->sd['branch'] . "'  AND t.`trans_code`='96'  AND t.`trans_no` ='" . $this->max_no . "' AND 
                 a.`is_control_acc`='0'");

            if ($query->row()->ok == "0") {
                $this->db->where("trans_no", $this->max_no);
                $this->db->where("trans_code", 96);
                $this->db->where("cl", $this->sd['cl']);
                $this->db->where("bc", $this->sd['branch']);
                $this->db->delete("t_check_double_entry");
                return "0";
            } else {
                return "1";
            }
        }
    }


    public function PDF_report(){

        $this->db->select(array('name','address','tp','fax','email'));
        $this->db->where("cl",$this->sd['cl']);
        $this->db->where("bc",$this->sd['branch']);
        $r_detail['branch']=$this->db->get('m_branch')->result();


        $cl=$this->sd['cl'];
        $bc=$this->sd['branch'];

        $r_detail['store_code']=$_POST['stores'];   
        $r_detail['type']=$_POST['type'];        
        $r_detail['dd']=$_POST['dd'];
        $r_detail['qno']=$_POST['id'];

        $invoice_number= $this->utility->invoice_format($_POST['id']);
        $session_array = array(
             $this->sd['cl'],
             $this->sd['branch'],
             $invoice_number
        );
        $r_detail['session'] = $session_array;

        $r_detail['page']=$_POST['page'];
        $r_detail['header']=$_POST['header'];
        $r_detail['orientation']="P";
        $r_detail['dfrom']=$_POST['from'];
        $r_detail['dto']=$_POST['to'];
        $r_detail['trans_code']=$_POST['t_type'];
        $r_detail['trans_code_des']=$_POST['t_type_des'];
        $r_detail['trans_no_from']=$_POST['t_range_from'];
        $r_detail['trans_no_to']=$_POST['t_range_to'];
        $cluster=$_POST['cluster'];
        $branch=$_POST['branch'];

        $sql="SELECTs 
                s.cl,
                s.bc,
                s.nno,
                s.ddate,
                s.sub_cl,
                s.sub_bc,
                s.cash_book_acc_code,
                s.cash_transit_acc_code,
                s.cashier,
                s.hand_over,
                s.cur_cashier_bal,
                s.transfer_amount,
                s.cur_cashier_bal ,
                m.description AS cash_dis,
                a.description AS trans_dis
              FROM
                t_fund_transfer_sum s
              JOIN m_account m ON m.code=s.cash_book_acc_code
              JOIN m_account a ON a.code=s.cash_transit_acc_code
                      WHERE s.nno ='".$_POST['id']."' AND s.cl = '".$this->sd['cl']."' AND s.bc = '".$this->sd['branch']."'";
                  
        $r_detail['r_bank_entry']=$this->db->query($sql)->result();    //pass as the variable in pdf page t_bank_entry_list
        var_dump($r_detail['r_bank_entry']);
        exit();
        $num = $this->db->query($sql)->row()->amount;

        $this->utility->num_in_letter($num);
      
        $r_detail['rec']=convertNum($num);;

        $r_detail['is_cur_time'] = $this->utility->get_cur_time();

        $s_time=$this->utility->save_time();
        if($s_time==1){
        $r_detail['save_time']="  -  ".$this->utility->get_save_time('t_bank_entry','action_date',$_POST['qno'],'nno');

        }else{
          $r_detail['save_time']="";
        }
    


        if($this->db->query($sql)->num_rows()>0)
        {
            $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
        }
        else
        {
            echo "<script>alert('No Data');window.close();</script>";
        }
  }
  











}
