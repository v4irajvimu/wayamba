<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class t_day_process extends CI_Model {

    private $sd;
    private $mtb;
    private $mod = '003';
    
    function __construct(){
    	parent::__construct();
       $this->sd = $this->session->all_userdata();
       $this->load->database($this->sd['db'], true);
       $this->load->model('user_permissions');
   }

   public function base_details(){
    $a['trans']=$this->select();

    $a['max']=$this->max_no();
    $a['max_date']=$this->max_date();
    $a['to_date']=$this->today();
    $a['max_date_plus']=$this->max_date_plus();
    return $a;
}


public function PDF_report(){

    $r_detail['type']=$_POST['type'];        
    $r_detail['dt']=$_POST['dt'];
    $r_detail['qno']=$_POST['qno'];
    $r_detail['page']=$_POST['page'];
    $r_detail['header']=$_POST['header'];
    $r_detail['orientation']=$_POST['orientation'];

    $this->db->select(array('name','address','tp','fax','email'));
    $this->db->where("cl",$this->sd['cl']);
    $this->db->where("bc",$this->sd['branch']);
    $r_detail['branch']=$this->db->get('m_branch')->result();

    $sql="SELECT nno 
    FROM t_day_end
    WHERE ddate='".$_POST['print_date']."' AND cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";

    $d_no = $this->db->query($sql)->row()->nno;

    $invoice_number= $this->utility->invoice_format($d_no);
    $r_detail['no'] = $invoice_number;
    $r_detail['date'] = $_POST['print_date'];


    $sql_det="SELECT agr_no,CONCAT(p.acc_code,' - ', c.name) AS customer, dr AS amount,'' AS ins_no , t.`description` 
    FROM `t_penalty_trance_hp` p
    JOIN r_hp_trans_type t ON t.code = p.ins_trans_code
    JOIN m_customer c ON c.code = p.acc_code
    WHERE trans_code='47' AND trans_no='5'
    AND p.cl ='".$this->sd['cl']."' AND p.bc='".$this->sd['branch']."' 
    
    UNION ALL 
    
    SELECT agr_no,CONCAT(i.acc_code,' - ', c.name) AS customer, dr AS amount,ins_no , t.`description`
    FROM t_ins_trans i
    JOIN r_hp_trans_type t ON t.code = i.ins_trans_code
    JOIN m_customer c ON c.code = i.acc_code
    WHERE trans_code='47' AND trans_no='9'
    AND i.cl ='".$this->sd['cl']."' AND i.bc='".$this->sd['branch']."' 
    order by agr_no DESC";

    $query = $this->db->query($sql_det);        
    $r_detail['details'] = $query->result();

    if($query->num_rows()>0){
        $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
    }else{
        echo "<script>alert('No Data');window.close();</script>";
    }

}


public function select(){
    $query = $this->db->get('t_trans_code');
    $s = "<select name='trans_code' id='trans_code'>";
    $s .= "<option value='0'>---</option>";
    foreach($query->result() as $r){
        $s .= "<option title='".$r->description."' value='".$r->code."'>".$r->code."-".$r->description."</option>";
    }
    $s .= "</select>";
    return $s;
}


public function validation(){
    $this->max_no = $this->max_no = $this->max_no();
    $status = 1;
    $account_update=$this->account_update(0,0,0);
    if($account_update!=1){
        return "Invalid account entries";
    } 
    return $status;
}


public function save(){
    $this->db->trans_begin();
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
        throw new Exception($errMsg); 
    }
    set_error_handler('exceptionThrower'); 
    try {
        $validation_status = $this->validation();
        if ($validation_status == 1) {           
            $this->max_no = $this->max_no();
            $this->inactive_po();
            $this->instalment();
            $this->add_penalty();
            $this->day_end_sum();
            $this->update_qtys();
            $this->utility->save_logger("SAVE",47, $this->max_no(),$this->mod);
            echo $this->db->trans_commit();
        } else {
            echo $validation_status;
            $this->db->trans_commit();
        }
    }catch(Exception $e){ 
        $this->db->trans_rollback();
        echo $e->getMessage()." - Operation fail please contact admin"; 
    } 
}

public function update_qtys(){
    $sql="UPDATE m_item i,
    (SELECT item, SUM(qty_in)-SUM(qty_out) AS cur_stock FROM t_item_movement GROUP BY item) t
    SET i.qty = t.cur_stock
    WHERE i.code=t.item";
    $this->db->query($sql);

    $sql2="UPDATE `m_item_batch_stock` i,
    (SELECT cl,bc,store_code,item, batch_no, SUM(qty_in)-SUM(qty_out) AS cur_stock FROM t_item_movement GROUP BY item, cl,bc,store_code,batch_no) t
    SET i.qty = t.cur_stock
    WHERE (i.item_code=t.item) AND (i.batch_no=t.batch_no) AND (i.cl=t.cl) AND (i.bc=t.bc) AND (i.store_code=t.store_code)";
    $this->db->query($sql2);
}

public function inactive_po(){
    $sql2="SELECT nno,type FROM t_po_sum WHERE ddate <= '".$_POST['date']."' - INTERVAL 1 MONTH AND cl ='".$this->sd['cl']."' AND bc ='".$this->sd['branch']."' AND inactive='0'";
    $query3=$this->db->query($sql2);

    $sql="UPDATE t_po_sum s,
    (SELECT nno,type FROM t_po_sum WHERE ddate <= '".$_POST['date']."' - INTERVAL 1 MONTH AND cl ='".$this->sd['cl']."' AND bc ='".$this->sd['branch']."' AND inactive='0')t
    SET inactive = '1'
    WHERE s.`nno` = t.nno
    AND s.type = t.type
    AND cl ='".$this->sd['cl']."' 
    AND bc ='".$this->sd['branch']."'";

    
    $query= $this->db->query($sql);   
    $query2= $this->db->affected_rows($sql);  

    
    foreach($query3->result() as $t){
        $this->utility->save_logger("Inactive PO no ". $t->nno." type ".$t->type,47,0,$this->mod);
    }
}

public function instalment(){

    $date=$_POST['date'];
    $n_date =  date('Y-m-d', strtotime($date . ' +1 day'));
    $is_int_fr=0;
    $qu_ins1=0;
    $qu_paid_ins1=0;
    $is_int_fr1=0;
    $qu_ins2=0;
    $qu_paid_ins2=0;
    $is_int_fr2=0;

    /*-----------------------------------------------------------------------------------------*/

    $get_agr_no="SELECT s.`cl`,s.`bc`, '$n_date', s.`agr_no`,ss.`cus_id` AS `acc_code`,s.`due_date`, 47 , '".$this->max_no."' , 1,s.`ins_no`,s.`capital_amount`,0,'".$this->sd['oc']."'
    FROM `t_ins_schedule` s 
    JOIN t_hp_sales_sum ss ON s.`agr_no` = ss.`agreement_no` AND s.`cl` = ss.`cl` AND s.`bc` = ss.`bc`
    WHERE s.`due_date` = '$n_date'  AND s.cl ='".$this->sd['cl']."' AND s.bc ='".$this->sd['branch']."' AND ss.is_closed!='1'";

    $qu_agr_no=$this->db->query($get_agr_no);

    if($qu_agr_no->num_rows()>0){
        foreach($qu_agr_no->result() as $row){

            $sql_chck_fr_intrst="SELECT m.`is_intfree` FROM t_hp_sales_sum s
            JOIN `m_hp_payment_scheme` m ON m.`code`=s.`scheme_id`
            WHERE s.cl = '".$row->cl."' 
            AND s.bc = '".$row->bc."' 
            AND s.agreement_no = '".$row->agr_no."'";

            $query_intr_fre=$this->db->query($sql_chck_fr_intrst);
            $is_int_fr=$query_intr_fre->first_row()->is_intfree;

            $qu_paid_ins=0;
            $paid_installmnts="SELECT COUNT(DISTINCT trans_no) AS paid_ins FROM t_ins_trans 
            WHERE agr_no='".$row->agr_no."' AND ins_trans_code='1' AND sub_trans_code='66'
            AND cl = '".$row->cl."'AND bc = '".$row->bc."'";

            $qu_paid_ins=$this->db->query($paid_installmnts)->first_row()->paid_ins;

            $instalments="SELECT no_of_installments FROM `t_hp_sales_sum` 
            WHERE  agreement_no='".$row->agr_no."'AND cl = '".$row->cl."'AND bc = '".$row->bc."' AND t_hp_sales_sum.is_closed!='1'";
            $qu_ins=$this->db->query($instalments)->first_row()->no_of_installments;

            /*--------------------------------------------------------------------------------------------------------*/

        }


        $slct_data5="SELECT s.`cl`,s.`bc`, '$n_date', s.`agr_no`,ss.`cus_id` AS `acc_code`,s.`due_date`, 47 , '".$this->max_no."' , 1,s.`ins_no`,s.`capital_amount`,0,'".$this->sd['oc']."'
        FROM `t_ins_schedule` s 
        JOIN t_hp_sales_sum ss ON s.`agr_no` = ss.`agreement_no` AND s.`cl` = ss.`cl` AND s.`bc` = ss.`bc`
        WHERE s.`due_date` = '$n_date'  AND s.cl ='".$this->sd['cl']."' AND s.bc ='".$this->sd['branch']."'AND ss.is_closed!='1'";               

        $qu_slct5=$this->db->query($slct_data5);

        foreach($qu_slct5->result() as $row){
            $slct_arry5[]=array(
                "cl"                => $row->cl,
                "bc"                => $row->bc,
                "ddate"             => $n_date,
                "agr_no"            => $row->agr_no,
                "acc_code"          => $row->acc_code,
                "due_date"          => $row->due_date,
                "trans_code"        => 47,
                "trans_no"          => $this->max_no,
                "ins_trans_code"    => 1,
                "ins_no"            => $row->ins_no,
                "dr"                => $row->capital_amount,
                "cr"                => 0,
                "oc"                => $this->sd['oc']
                );
        }

    }

    $agr_no="SELECT cl,bc, SUM(dr-cr) AS balance,agr_no,SUM(is_update_ful_int) AS stats FROM t_ins_trans GROUP BY agr_no HAVING balance>0 AND stats='0'";
    $qu_agr_no2=$this->db->query($agr_no);

    foreach($qu_agr_no2->result() as $val){

        $sql_chck_fr_intrst1="SELECT m.`is_intfree` FROM t_hp_sales_sum s
        JOIN `m_hp_payment_scheme` m ON m.`code`=s.`scheme_id`
        WHERE s.cl = '".$val->cl."' 
        AND s.bc = '".$val->bc."' 
        AND s.agreement_no = '".$val->agr_no."'
        AND s.is_closed='0'";

        $query_intr_fre1=$this->db->query($sql_chck_fr_intrst1);
        if($query_intr_fre1->num_rows()>0){
            $is_int_fr1=$query_intr_fre1->first_row()->is_intfree; 
        }else{
            $is_int_fr1='0';        
        }

        if($is_int_fr1=="1"){

            $paid_installmnts1="SELECT COUNT(DISTINCT trans_no) AS paid_ins FROM t_ins_trans 
            WHERE agr_no='".$val->agr_no."' AND ins_trans_code='1'AND sub_trans_code='66'
            AND cl = '".$val->cl."'AND bc = '".$val->bc."'";
            $qu_paid_ins1=$this->db->query($paid_installmnts1)->first_row()->paid_ins;


            $instalments1="SELECT cl,bc,no_of_installments FROM `t_hp_sales_sum` 
            WHERE  agreement_no='".$val->agr_no."'AND cl = '".$val->cl."'AND bc = '".$val->bc."'AND t_hp_sales_sum.is_closed!='1'";
            $qu_ins1=$this->db->query($instalments1)->first_row()->no_of_installments;

            $this->db->query("UPDATE t_ins_schedule SET is_post = 1 
                WHERE bc = '".$this->sd['branch']."' AND cl = '".$this->sd['cl']."' AND `agr_no` = '".$val->agr_no."'  AND is_post = 0");


            $slct_data="SELECT s.cl,s.bc, '$n_date',s.`agr_no`,s.`acc_code`,s.`due_date`,47,'".$this->max_no."',1,s.`ins_no`,0,'".$this->sd['oc']."',
            e.`int_amount`,h.`no_of_installments`,(e.`int_amount`*(h.`no_of_installments`+1))AS totint
            FROM  t_ins_trans s 
            JOIN t_ins_schedule e ON e.`agr_no` = s.`agr_no` AND e.`cl` = s.`cl` AND e.`bc` = s.`bc` 
            JOIN t_hp_sales_sum h ON h.`agreement_no` = s.`agr_no` AND h.`cl` = s.`cl` AND h.`bc` = s.`bc` 
            WHERE s.cl ='".$this->sd['cl']."' AND s.bc ='".$this->sd['branch']."' AND s.agr_no='".$val->agr_no."'
            group by agr_no";   

            $qu_slct=$this->db->query($slct_data);

            foreach($qu_slct->result() as $row){
                $slct_arry[]=array(
                    "cl"                => $row->cl,
                    "bc"                => $row->bc,
                    "ddate"             => $n_date,
                    "agr_no"            => $row->agr_no,
                    "acc_code"          => $row->acc_code,
                    "due_date"          => $row->due_date,
                    "trans_code"        => 47,
                    "trans_no"          => $this->max_no,
                    "ins_trans_code"    => 2,
                    "ins_no"            => $row->ins_no,
                    "dr"                => $row->totint,
                    "cr"                => 0,
                    "is_update_ful_int" => 1,
                    "oc"                => $this->sd['oc']
                    );
            }  
            if($qu_paid_ins1==$qu_ins1){

                if(isset($slct_arry)){if(count($slct_arry)){$this->db->insert_batch('t_ins_trans', $slct_arry);}}
            }

        }
    }


    $agr_no="SELECT cl,bc, SUM(dr-cr) AS balance,agr_no,SUM(is_update_ful_int) AS stats FROM t_ins_trans GROUP BY agr_no HAVING balance>0 AND stats='1'";
    $qu_agr_no3=$this->db->query($agr_no);

    foreach($qu_agr_no3->result() as $val){

        $sql_chck_fr_intrst2="SELECT m.`is_intfree` FROM t_hp_sales_sum s
        JOIN `m_hp_payment_scheme` m ON m.`code`=s.`scheme_id`
        WHERE s.cl = '".$val->cl."' 
        AND s.bc = '".$val->bc."' 
        AND s.agreement_no = '".$val->agr_no."'";

        $query_intr_fre2=$this->db->query($sql_chck_fr_intrst2);
        $is_int_fr2=$query_intr_fre2->first_row()->is_intfree;

        if($is_int_fr2=="1"){

            $paid_installmnts2="SELECT COUNT(DISTINCT trans_no) AS paid_ins FROM t_ins_trans 
            WHERE agr_no='".$val->agr_no."' AND ins_trans_code='1'AND sub_trans_code='66'
            AND cl = '".$val->cl."'AND bc = '".$val->bc."'";
            $qu_paid_ins2=$this->db->query($paid_installmnts2)->first_row()->paid_ins;


            $instalments2="SELECT cl,bc,no_of_installments FROM `t_hp_sales_sum` 
            WHERE  agreement_no='".$val->agr_no."'AND cl = '".$val->cl."'AND bc = '".$val->bc."'AND t_hp_sales_sum.is_closed!='1'";
            $qu_ins2=$this->db->query($instalments2)->first_row()->no_of_installments;


            $this->db->query("UPDATE t_ins_schedule SET is_post = 1 
                WHERE bc = '".$this->sd['branch']."' AND cl = '".$this->sd['cl']."' AND `agr_no` = '".$val->agr_no."'  AND is_post = 0");

            $slct_data2="SELECT s.`cl`,s.`bc`, '$n_date', s.`agr_no`,ss.`cus_id` AS `acc_code`,s.`due_date`, 47 , '".$this->max_no."' , 2,s.`ins_no`,s.int_amount ,0,'".$this->sd['oc']."'
            FROM `t_ins_schedule` s 
            JOIN t_hp_sales_sum ss ON s.`agr_no` = ss.`agreement_no` AND s.`cl` = ss.`cl` AND s.`bc` = ss.`bc`
            WHERE s.`agr_no` = '".$val->agr_no."'  AND s.cl ='".$this->sd['cl']."' AND s.bc ='".$this->sd['branch']."' AND ss.is_closed!='1' GROUP BY s.`agr_no`";               

            $qu_slct2=$this->db->query($slct_data2);

            foreach($qu_slct2->result() as $row){
                $slct_arry2[]=array(
                    "cl"                => $row->cl,
                    "bc"                => $row->bc,
                    "ddate"             => $n_date,
                    "agr_no"            => $row->agr_no,
                    "acc_code"          => $row->acc_code,
                    "due_date"          => $row->due_date,
                    "trans_code"        => 47,
                    "trans_no"          => $this->max_no,
                    "ins_trans_code"    => 2,
                    "ins_no"            => $row->ins_no,
                    "dr"                => $row->int_amount,
                    "cr"                => 0,
                    "oc"                => $this->sd['oc']
                    );

            }

            if($qu_paid_ins2>$qu_ins2){

                if(isset($slct_arry2)){if(count($slct_arry2)){$this->db->insert_batch('t_ins_trans', $slct_arry2);}}
            }

        }
    }
    if($is_int_fr=='1'){
      if($qu_paid_ins<$qu_ins){
        $date=$_POST['date'];
        $n_date =  date('Y-m-d', strtotime($date . ' +1 day'));
        $qu_ins3=0;
        $qu_paid_ins3=0;

        if(isset($slct_arry5)){if(count($slct_arry5)){$this->db->insert_batch('t_ins_trans', $slct_arry5);}}


        $agr_no="SELECT cl,bc, SUM(dr-cr) AS balance,agr_no FROM t_ins_trans GROUP BY agr_no HAVING balance>0";
        $qu_agr_no3=$this->db->query($agr_no);

        foreach($qu_agr_no3->result() as $val){

            if(isset($slct_arry3)){if(count($slct_arry3)){$this->db->insert_batch('t_ins_trans', $slct_arry3);}}
            $this->db->query("UPDATE t_ins_schedule SET is_post = 1 
                WHERE bc = '".$this->sd['branch']."' AND cl = '".$this->sd['cl']."' AND `agr_no` = '".$val->agr_no."'  AND is_post = 0");

        }
    }

}else{
    $date=$_POST['date'];
    $n_date =  date('Y-m-d', strtotime($date . ' +1 day'));

    $R = $this->db->query("INSERT INTO `t_ins_trans` (`cl`,`bc`,`ddate`,`agr_no`,`acc_code`,`due_date`,`trans_code`,`trans_no`,`ins_trans_code`,`ins_no`,`dr`,`cr`,`oc`)

        SELECT s.`cl`,s.`bc`, '$n_date', s.`agr_no`,ss.`cus_id` AS `acc_code`,s.`due_date`, 47 , '".$this->max_no."' , 1,s.`ins_no`,s.`capital_amount`,0,'".$this->sd['oc']."'
        FROM `t_ins_schedule` s 
        JOIN t_hp_sales_sum ss ON s.`agr_no` = ss.`agreement_no` AND s.`cl` = ss.`cl` AND s.`bc` = ss.`bc`
        WHERE s.`due_date` = '$n_date'  AND s.cl ='".$this->sd['cl']."' AND s.bc ='".$this->sd['branch']."'

        UNION ALL

        SELECT s.`cl`,s.`bc`, '$n_date', s.`agr_no`,ss.`cus_id` AS `acc_code`,s.`due_date`, 47 , '".$this->max_no."' , 2,s.`ins_no`,s.`int_amount`,0,'".$this->sd['oc']."'
        FROM `t_ins_schedule` s 
        JOIN t_hp_sales_sum ss ON s.`agr_no` = ss.`agreement_no` AND s.`cl` = ss.`cl` AND s.`bc` = ss.`bc`
        WHERE s.`due_date` = '$n_date'  AND s.cl ='".$this->sd['cl']."' AND s.bc ='".$this->sd['branch']."'");                

    if ($R){
        $this->db->query("UPDATE t_ins_schedule SET is_post = 1 
          WHERE bc = '".$this->sd['branch']."' AND cl = '".$this->sd['cl']."' AND `due_date` = '$n_date'  AND is_post = 0");
    }
}


$sql_arg_no="SELECT s.`cl`,
s.`bc`,
ss.`cus_id`,
s.`due_date`,
s.`agr_no`,
s.ins_amount
FROM `t_ins_schedule` s 
JOIN t_hp_sales_sum ss ON s.`agr_no` = ss.`agreement_no` AND s.`cl` = ss.`cl` AND s.`bc` = ss.`bc` 
WHERE s.`due_date` = '$n_date' 
AND s.cl = '".$this->sd['cl']."' 
AND s.bc = '".$this->sd['branch']."' 
GROUP BY cl,bc,agr_no";

$query_agr = $this->db->query($sql_arg_no);
foreach($query_agr->result() as $row){
    $sql_a="SELECT SUM(dr) - SUM(cr) AS balance 
    FROM t_advance_trans  
    WHERE cl='".$row->cl."' 
    AND bc='".$row->bc."' 
    AND agr_no='".$row->agr_no."' 
    HAVING balance >0";

    $query_a=$this->db->query($sql_a);

    $pay1=0;
    foreach($query_a->result() as $qun){
        if($qun->balance>=$row->ins_amount){
            $advance_due=($row->ins_amount);
        }else{
            $advance_due=$qun->balance;
        }
        $advance_transe=array(
            "cl"            => $row->cl,
            "bc"            => $row->bc,
            "ddate"         => $n_date,
            "sub_cl"        => "",
            "sub_bc"        => "",
            "agr_no"        => $row->agr_no,
            "acc_code"      => $row->cus_id,
            "trans_code"    => 47,
            "trans_no"      => $this->max_no,
            "sub_trans_code"=> "",
            "sub_trans_no"  => "",
            "dr"            => "0.00",
            "cr"            => $advance_due,
            "oc"            => $this->sd['oc']
            );

        if($qun->balance>0){
            $this->db->insert('t_advance_trans', $advance_transe);
        }

        $sql_due="SELECT t.`ins_no`,
        t.`trans_no`,
        t.`due_date`,
        r.description, 
        SUM(t.cr) AS cr, 
        SUM(t.dr) AS dr,
        SUM(t.dr)-SUM(t.cr) AS balance,
        r.code AS r_code,
        t.cl,
        t.bc,
        t.ins_trans_code,
        t.trans_no,
        t.trans_code 
        FROM t_ins_trans t
        JOIN r_hp_trans_type r ON r.code = t.ins_trans_code
        WHERE t.cl = '".$row->cl."' 
        AND t.bc = '".$row->bc."' 
        AND t.agr_no = '".$row->agr_no."' 
        GROUP BY  t.`trans_no`, r.code  
        HAVING SUM(t.dr)-SUM(t.cr)>0
        ORDER BY r.order_no ";

        $query_due=$this->db->query($sql_due);
        $pay1=(float)$qun->balance;



        foreach($query_due->result() as $due){
            $amount =(float)$due->balance;
            if($amount<=$pay1){
                $pay_ins_trans= array(
                    "cl" => $row->cl,
                    "bc" => $row->bc,
                    "sub_cl" => $row->cl,
                    "sub_bc" => $row->bc,
                    "ddate" => $n_date,
                    "agr_no" => $row->agr_no,
                    "acc_code" => $row->cus_id,
                    "due_date" => $row->due_date,
                    "trans_code" =>47,
                    "trans_no" => $this->max_no,
                    "sub_trans_code" => 47,
                    "sub_trans_no" => $this->max_no,
                    "ins_trans_code" => $due->ins_trans_code,
                    "ins_no" => $due->trans_no,
                    "cr" => $amount,
                    "oc" => $this->sd['oc']
                    );
                $pay1 = $pay1-$amount;
                $this->db->insert('t_ins_trans', $pay_ins_trans);
            }else{
                $pay_ins_trans= array(
                    "cl" => $row->cl,
                    "bc" => $row->bc,
                    "sub_cl" => $row->cl,
                    "sub_bc" => $row->bc,
                    "ddate" => $n_date,
                    "agr_no" => $row->agr_no,
                    "acc_code" => $row->cus_id,
                    "due_date" => $row->due_date,
                    "trans_code" =>47,
                    "trans_no" => $this->max_no,
                    "sub_trans_code" => 47,
                    "sub_trans_no" => $this->max_no,
                    "ins_trans_code" => $due->ins_trans_code,
                    "ins_no" => $due->trans_no,
                    "cr" => $pay1,
                    "oc" => $this->sd['oc']
                    );
                if($pay1>0){
                    $this->db->insert('t_ins_trans', $pay_ins_trans);
                }
                $pay1=0;
            }

        }

    }
}
}


public function add_penalty(){

    $date = $_POST['date'];
    $trans_no = $_POST['id'];
    $cl = $this->sd['cl'];
    $bc = $this->sd['branch'];
    $oc = $this->sd['oc'];
    
    $sql   ="SELECT grace_period_cal_type FROM `def_option_hp`";
    $query = $this->db->query($sql);
    $grace_type=$query->row()->grace_period_cal_type;

    if($grace_type == "1"){
        $this->db->query("INSERT INTO `t_penalty_trance_hp`(`cl`,`bc`,`ddate`,`agr_no`,acc_code,`trans_code`,`trans_no`,`ins_trans_code`,`ins_no`,`dr`,`oc`)
            SELECT IT.cl,IT.bc,'$date',IT.`agr_no`, SS.cus_id,47,'$trans_no',3,0,ifnull(ROUND(((SUM(IT.`dr`) - SUM(IT.`cr`)) * (SELECT penalty_rate FROM def_option_account) / 100) / 30,2),0) AS `penalty_amount`, '$oc'

            FROM `t_ins_trans` IT 
            JOIN t_hp_sales_sum SS ON IT.`agr_no` = SS.`agreement_no` AND IT.`cl` = SS.`cl` AND IT.`bc` = SS.`bc`
            WHERE IT.`bc` = '$bc' 
            AND IT.`cl` = '$cl' 
            AND DATE_ADD(IT.`due_date`,INTERVAL (SELECT grace_period FROM def_option_account) DAY) = '$date' 
            AND IT.`ins_trans_code` IN (1,2) 
            GROUP BY IT.`agr_no`
            HAVING penalty_amount > 0 ");  
    }


       /* Befor add acc_code(customer) to query
        $this->db->query("INSERT INTO `t_penalty_trance_hp`(`cl`,`bc`,`ddate`,`agr_no`,`trans_code`,`trans_no`,`ins_trans_code`,`ins_no`,`dr`,`oc`)
        SELECT IT.cl,IT.bc,'$date',IT.`agr_no`,47,'$trans_no',3,0,ifnull(ROUND(((SUM(IT.`dr`) - SUM(IT.`cr`)) * (SELECT penalty_rate FROM def_option_account) / 100) / 30,2),0) AS `penalty_amount`, '$oc'

        FROM `t_ins_trans` IT 
        JOIN t_hp_sales_sum SS ON IT.`agr_no` = SS.`agreement_no` AND IT.`cl` = SS.`cl` AND IT.`bc` = SS.`bc`
        WHERE IT.`bc` = '$bc' AND IT.`cl` = '$cl' AND IT.`ins_trans_code` IN (1,2) 
        GROUP BY IT.`agr_no`
        HAVING ifnull(ROUND(((SUM(IT.`dr`) - SUM(IT.`cr`)) * (SELECT penalty_rate FROM def_option_account) / 100) / 30,2),0) > 0 ");
        */
    }

    public function move_penalty_ti_ins_trans( $date,$max_no,$agr_no,$oc,$bc,$cl ){

        $Q = $this->db->query("INSERT INTO t_ins_trans (`cl`,`bc`,`ddate`,`agr_no`,`trans_code`,`trans_no`,`ins_trans_code`,`ins_no`,`dr`,`oc`,`due_date`)
            SELECT P.`cl` , P.`bc` , '$date' , P.`agr_no` , 66 , '$max_no' , 3 , 0 , SUM(dr) AS `penalty_bal` , '$oc','$date' 
            FROM `t_penalty_trance_hp` P
            WHERE bc = '$bc' 
            AND cl = '$cl' 
            AND P.ddate = '$date' 
            AND `agr_no` = '$agr_no'  
            AND is_post = 0 HAVING SUM(dr) > 0");

        if ($Q){
            $this->db->query("UPDATE t_penalty_trance_hp SET is_post = 1 
              WHERE bc = '$bc' AND cl = '$cl' AND `agr_no` = '$agr_no' AND is_post = 0");
        }
    }

    public function day_end_sum(){
        $day_sum = array("cl" => $this->sd['cl'],"bc" => $this->sd['branch'],"nno" => $this->max_no,"ddate" => $_POST['date'],"oc" => $this->sd['oc']);
        $this->db->insert('t_day_end', $day_sum);
    }

    public function account_update($condition,$des,$amount) {

        $this->db->where("trans_no", $this->max_no);
        $this->db->where("trans_code", 47);
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $this->db->delete("t_check_double_entry");

        

        $config = array(
            "ddate" => $_POST['date'],
            "trans_code" => 47,
            "trans_no" => $this->max_no,
            "op_acc" => 0,
            "reconcile" => 0,
            "cheque_no" => 0,
            "narration" => "",
            "ref_no" => ""
            );

        $des = "Day End Process - " . $des;
        $this->load->model('account');
        $this->account->set_data($config);
        
        $acc_code=$this->utility->get_default_acc('INTEREST_INCOME');
        $this->account->set_value2($des, $amount, "cr", $acc_code,$condition);

        $acc_code=$this->utility->get_default_acc('INTEREST_SUSPENCE');
        $this->account->set_value2($des, $amount, "dr", $acc_code,$condition);



        if($condition==0){
           $query = $this->db->query("
               SELECT (IFNULL( SUM( t.`dr_amount`),0) = IFNULL(SUM(t.`cr_amount`),0)) AS ok 
               FROM `t_check_double_entry` t
               LEFT JOIN `m_account` a ON t.`acc_code` = a.`code`
               WHERE  t.`cl`='" . $this->sd['cl'] . "'  AND t.`bc`='" . $this->sd['branch'] . "'  AND t.`trans_code`='47'  AND t.`trans_no` ='" . $this->max_no . "' AND 
               a.`is_control_acc`='0'");

           if ($query->row()->ok == "0") {
            $this->db->where("trans_no", $this->max_no);
            $this->db->where("trans_code", 47);
            $this->db->where("cl", $this->sd['cl']);
            $this->db->where("bc", $this->sd['branch']);
            $this->db->delete("t_check_double_entry");
            return "0";
        } else {
            return "1";
        }
    }
}


public function load_penalty(){

    $sql="SELECT ins_amount-ins_paid AS amount, trans_no,due_date
    FROM t_ins_schedule 
    WHERE DATE_ADD(`due_date`,INTERVAL (SELECT grace_period FROM def_option_account) DAY) <= '".$_POST['date']."' 
    AND cl ='".$this->sd['cl']."' AND bc ='".$this->sd['branch']."'
    HAVING amount > 0";
    $query=$this->db->query($sql);
    $x=0;
    $a="";
    foreach($query->result() as $r){
        $a .= "<tr>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='0_".$x."' value='".$r->due_date."' title='".$r->due_date."' style='border:dotted 1px #ccc;background-color: #f9f9ec; width:100%;cursor:pointer;text-align:center;'/></td>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_num' name='1_".$x."' value='".$r->trans_no."' title='".$r->trans_no."' style='border:dotted 1px #ccc; background-color: #f9f9ec; width:100%; cursor:pointer;text-align:left;'/></td>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='n_".$x."' value='".$r->amount."' title='".$r->amount."'  style='border:dotted 1px #ccc;background-color: #f9f9ec; cursor:pointer; width:100%;text-align:center;'/></td>";
        $a .= "</tr>";
        $x++;
    }
    echo $a;       
}



public function load_po(){
    $sql="SELECT * FROM t_po_sum WHERE ddate  <= '".$_POST['date']."' - INTERVAL 1 MONTH AND cl ='".$this->sd['cl']."' AND bc ='".$this->sd['branch']."' AND inactive='0' ";
    $query=$this->db->query($sql);
    $x=0;
    $a="";
    foreach($query->result() as $r){
        $a .= "<tr>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='0_".$x."' value='".$r->ddate."' title='".$r->ddate."' style='border:dotted 1px #ccc;background-color: #f9f9ec; width:100%;cursor:pointer;text-align:center;'/></td>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_num' name='1_".$x."' value='".$r->nno."' title='".$r->nno."' style='border:dotted 1px #ccc; background-color: #f9f9ec; width:100%; cursor:pointer;text-align:left;'/></td>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='n_".$x."' value='".$r->supplier."' title='".$r->supplier."'  style='border:dotted 1px #ccc;background-color: #f9f9ec; cursor:pointer; width:100%;text-align:center;'/></td>";
        $a .= "</tr>";
        $x++;
    }
    echo $a;
}

public function load_intrest(){
    $sql="SELECT * FROM t_ins_schedule WHERE due_date = '".$_POST['date']."'  AND cl ='".$this->sd['cl']."' AND bc ='".$this->sd['branch']."'";
    $query=$this->db->query($sql);
    
    $x=0;
    $a="";
    foreach($query->result() as $r){
        $a .= "<tr>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='0_".$x."' value='".$r->due_date."' title='".$r->due_date."' style='border:dotted 1px #ccc;background-color: #f9f9ec; width:100%;cursor:pointer;text-align:center;'/></td>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_num' name='1_".$x."' value='".$r->trans_no."' title='".$r->trans_no."' style='border:dotted 1px #ccc; background-color: #f9f9ec; width:100%; cursor:pointer;text-align:left;'/></td>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='n_".$x."' value='".$r->ins_amount."' title='".$r->ins_amount."'  style='border:dotted 1px #ccc;background-color: #f9f9ec; cursor:pointer; width:100%;text-align:center;'/></td>";
        $a .= "</tr>";
        $x++;
    }
    echo $a;
}

public function max_no(){    
    $this->db->select_max('nno');
    $this->db->where("cl",$this->sd['cl']);
    $this->db->where("bc",$this->sd['branch']);    
    return $this->db->get('t_day_end')->first_row()->nno+1;    
}


public function max_date_plus(){
    $sql="SELECT DATE_ADD(IFNULL(MAX(ddate),CURRENT_DATE),INTERVAL 1 DAY) AS date
    FROM t_day_end 
    WHERE cl='".$this->sd['cl']."' 
    AND bc='".$this->sd['branch']."'
    limit 1";  
    return $this->db->query($sql)->first_row()->date;    
}

public function max_date(){
    $sql="SELECT DATE_ADD(IFNULL(MAX(ddate),(SELECT open_bal_date FROM m_branch Where cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."')),INTERVAL 1 DAY) AS date 
    FROM t_day_end 
    WHERE cl='".$this->sd['cl']."' 
    AND bc='".$this->sd['branch']."'
    limit 1";  
    return $this->db->query($sql)->first_row()->date;    
}


public function today(){
    $sql="SELECT DATE_ADD(CURRENT_DATE,INTERVAL 1 DAY) AS toDATE";  
    return $this->db->query($sql)->first_row()->toDATE;    
}

public function real_date(){

 $sql="SELECT DATE_ADD(IFNULL(MAX(ddate),CURRENT_DATE),INTERVAL 1 DAY) AS date 
 FROM t_day_end 
 WHERE cl='".$this->sd['cl']."' 
 AND bc='".$this->sd['branch']."'
 limit 1";  
 $max_date_plus= $this->db->query($sql)->first_row()->date;

 $sql="SELECT IFNULL(MAX(ddate),0) AS ddate 
 FROM t_day_end 
 WHERE cl='".$this->sd['cl']."' 
 AND bc='".$this->sd['branch']."'
 limit 1";  
 $max_date=$this->db->query($sql)->first_row()->ddate;  

 $sql="SELECT CURRENT_DATE AS toDATE";  
 $today=$this->db->query($sql)->first_row()->toDATE;
 if($max_date==$today){
    return $max_date_plus;
}else{
    return $today;
}


}

public function transaction_list(){
    $cl=$this->sd['cl'];
    $bc=$this->sd['branch'];
    $trans_no=$_POST['trans_no'];
    $trans_code=$_POST['trans_code'];
    $sql="SELECT t_logger.oc,t_logger.action_date,t_logger.action,t_logger.ip_address,users.discription FROM t_logger join users on t_logger.oc=users.cCode WHERE trans_code='$trans_code' AND trans_no='$trans_no' AND t_logger.cl='$cl' AND t_logger.bc='$bc'";
    $query=$this->db->query($sql);
    $a = "<table id='item_list' style='width : 100%' border='0'>";
    $x=0;
    foreach($query->result() as $r){

        $a .= "<tr>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='0_".$x."' value='".$r->oc."' title='".$r->oc."' style='border:dotted 1px #ccc;background-color: #f9f9ec; width:100%;cursor:pointer;text-align:center;'/></td>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_num' name='1_".$x."' value='".$r->discription."' title='".$r->discription."' style='border:dotted 1px #ccc; background-color: #f9f9ec; width:100%; cursor:pointer;text-align:left;'/></td>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='2_".$x."' value='".$r->action."' title='".$r->action."'  style='border:dotted 1px #ccc;background-color: #f9f9ec; cursor:pointer; width:100%;text-align:center;'/></td>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='2_".$x."' value='".$r->action_date."' title='".$r->action_date."'  style='border:dotted 1px #ccc;background-color: #f9f9ec; cursor:pointer; width:100%;text-align:right;'/></td>";
        $a .= "<td ><input type='text' readonly='readonly' class='g_input_txt' name='3_".$x."' value='".$r->ip_address."' title='".$r->ip_address."' style='border:dotted 1px #ccc;background-color: #f9f9ec; cursor:pointer;width:100%;text-align:right;'/></td>";
        $a .= "</tr>";
        $x++;
    }
    $a .= "</table>";
    
    echo $a;
}


public function set_delete(){
    $this->db->trans_begin();
    error_reporting(E_ALL); 
    function exceptionThrower($type, $errMsg, $errFile, $errLine) { 
        throw new Exception($errMsg); 
    }
    set_error_handler('exceptionThrower'); 
    try {
        if($this->user_permissions->is_delete('t_cash_sales_sum')){

            $nno = $_POST['no'] - 1;
            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('trans_code','47');
            $this->db->where('trans_no',$nno);
            $this->db->delete('t_penalty_trance_hp');

            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('trans_code','47');
            $this->db->where('trans_no',$nno);
            $this->db->delete('t_ins_trans');

            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('trans_code','47');
            $this->db->where('trans_no',$nno);
            $this->db->delete('t_advance_trans');

            $this->db->where('cl',$this->sd['cl']);
            $this->db->where('bc',$this->sd['branch']);
            $this->db->where('nno',$nno);
            $this->db->delete('t_day_end');

            $this->utility->save_logger("CANCEL",47,$_POST['no'],$this->mod);
            echo $this->db->trans_commit();
        }else{
            $this->db->trans_commit();
            echo "No permission to delete records";
        }  
    }catch(Exception $e){ 
        $this->db->trans_rollback();
        echo $e->getMessage()." - Operation fail please contact admin"; 
    } 
}

}