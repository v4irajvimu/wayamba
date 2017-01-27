<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_total_sale extends CI_Model
{

  private $sd;
  private $w = 210;
  private $h = 297;

  private $mtb;
  private $tb_client;
  private $tb_branch;

  function __construct()
  {
    parent::__construct();
    $this->sd = $this->session->all_userdata();
    $this->load->database($this->sd['db'], true);
  }

  public function base_details()
  {
    $this->load->model('r_sales_category');
    $a['sales_category'] = $this->r_sales_category->select();
    $a['cluster']=$this->get_cluster_name();
        //$a['branch']=$this->get_branch_name();
    return $a;


  }

  public function get_cluster_name(){
    $sql="  SELECT `code`,description
    FROM m_cluster m
    JOIN u_branch_to_user u ON u.cl = m.code
    WHERE user_id='".$this->sd['oc']."'
    GROUP BY m.code";
    $query=$this->db->query($sql);

    $s = "<select name='cluster' id='cluster' style='width:179px;'>";
    $s .= "<option value='0'>---</option>";
    foreach($query->result() as $r){
      $s .= "<option title='".$r->description."' value='".$r->code."'>".$r->code.'-'.$r->description."</option>";
    }
    $s .= "</select>";

    return $s;
  }


  public function get_branch_name(){
    $this->db->select(array('bc','name'));
    $query = $this->db->get('m_branch');

    $s = "<select name='branch' id='branch' style='width:179px;'>";
    $s .= "<option value='0'>---</option>";
    foreach($query->result() as $r){
      $s .= "<option title='".$r->name."' value='".$r->bc."'>".$r->bc.'-'.$r->name."</option>";
    }
    $s .= "</select>";
    return $s;
  }


  public function get_branch_name2(){
    $sql="  SELECT m.`bc`,name
    FROM m_branch m
    JOIN u_branch_to_user u ON u.bc = m.bc
    WHERE user_id='".$this->sd['oc']."' AND m.cl='".$_POST['cl']."'
    GROUP BY m.bc";
    $query=$this->db->query($sql);

    $s = "<select name='branch' id='branch' style='width:179px;'>";
    $s .= "<option value='0'>---</option>";
    foreach($query->result() as $r){
      $s .= "<option title='".$r->name."' value='".$r->bc."'>".$r->bc.'-'.$r->name."</option>";
    }
    $s .= "</select>";
    echo $s;
  }

  public function get_branch_name3(){
    $sql="  SELECT m.`bc`,name
    FROM m_branch m
    JOIN u_branch_to_user u ON u.bc = m.bc
    WHERE user_id='".$this->sd['oc']."'
    GROUP BY m.bc";
    $query=$this->db->query($sql);

    $s = "<select name='branch' id='branch' style='width:179px;'>";
    $s .= "<option value='0'>---</option>";
    foreach($query->result() as $r){
      $s .= "<option title='".$r->name."' value='".$r->bc."'>".$r->bc.'-'.$r->name."</option>";
    }
    $s .= "</select>";
    echo $s;
  }

  public function PDF_report($RepTyp=""){

    $r_detail['type']=$_POST['type'];
    $r_detail['page']=$_POST['page'];
    $r_detail['header']=$_POST['header'];
    $r_detail['orientation']="L";
    $r_detail['type']="";
    $r_detail['to']=$_POST['to'];
    $r_detail['from']=$_POST['from'];
    $cluster=$_POST['cluster'];
    $branch =$_POST['branch'];
    $emp    =$_POST['emp'];
    $to_date=$_POST['to'];
    $f_date =$_POST['from'];
    $r_detail['cluster']=$_POST['cluster'];
    $r_detail['branchs']=$_POST['branch'];
    $r_detail['emp']=$_POST['emp'];
    $r_detail['emp_des']=$_POST['emp_des'];

    if(!empty($cluster)){
      $cl=" AND c.cl='$cluster'";
      $cl1=" AND t.cl='$cluster'";
      $cl2=" AND tt.cl='$cluster'";
      $cl3=" AND cl='$cluster'";
    }else{
      $cl=" ";
      $cl1=" ";
      $cl2=" ";
      $cl3=" ";
    }

    if(!empty($branch)){
      $bc=" AND c.bc='$branch'";
      $bc1=" AND t.bc='$branch'";
      $bc2=" AND tt.bc='$branch'";
      $bc3=" AND bc='$branch'";
    }else{
      $bc=" ";
      $bc1=" ";
      $bc2=" ";
      $bc3=" ";
    }


    if(!empty($emp)){
      $emp1=" AND c.rep='$emp'";
    }else{
      $emp1=" ";
    }

    $this->db->select(array('name','address','tp','fax','email'));
    $this->db->where("cl",$this->sd['cl']);
    $this->db->where("bc",$this->sd['branch']);
    $r_detail['branch']=$this->db->get('m_branch')->result();


    $this->db->select(array('description','code'));
    $this->db->where("code",$_POST['cluster']);
    $r_detail['clus']=$this->db->get('m_cluster')->result();

    $this->db->select(array('name','bc'));
    $this->db->where("bc",$_POST['branch']);
    $r_detail['bran']=$this->db->get('m_branch')->result();

    $sql="SELECT CONCAT(t.bc,' - ',bb.name) AS bc,
    t.ddate,
    IFNULL(cash_gross,0.00) AS cash_gross,
    IFNULL(IFNULL(cash_dis,0)+IFNULL(cash_deduct,0),0.00) AS cash_dis,
    IFNULL(cash_net, 0.00) AS cash_net,
    IFNULL(cash_add, 0.00) AS cash_add,
    IFNULL(credit_gross,0.00) AS credit_gross,
    IFNULL(IFNULL(credit_dis,0) + IFNULL(credit_deduct,0),0.00) AS credit_dis,
    IFNULL(credit_net,0.00) AS credit_net,
    IFNULL(credit_add, 0.00) AS credit_add,
    IFNULL(return_net,0.00) AS return_net,
    (IFNULL(cash_net, 0.00)+IFNULL(credit_net,0.00))-IFNULL(return_net,0.00) AS total
    FROM (SELECT cl, bc, ddate FROM t_cash_sales_sum
    UNION ALL
    SELECT cl, bc, ddate FROM t_credit_sales_sum
    UNION ALL
    SELECT cl, bc, ddate FROM t_sales_return_sum
    UNION ALL
    SELECT cl, bc, ddate FROM t_credit_note
    UNION ALL
    SELECT cl, bc, ddate FROM t_pos_sales_sum)t
    LEFT JOIN (
    SELECT  dd.ddate, IFNULL(c.cash_gross,0.00)+IFNULL(pos.pos_gross,0.00) as cash_gross, IFNULL(c.cash_dis,0)+IFNULL(ss.amnt,0.00)+IFNULL(pos.pos_discount,0.00)  AS cash_dis ,(IFNULL(c.cash_net,0)+IFNULL(pos.pos_net,0.00))-IFNULL(ss.amnt,0.00) AS cash_net ,c.cash_add ,c.cash_deduct,c.foc
    FROM (SELECT cl,bc,ddate FROM t_cash_sales_sum WHERE ddate BETWEEN '$f_date' AND '$to_date' $cl3 $bc3
    UNION  ALL
    SELECT cl,bc,ddate FROM t_credit_note WHERE ddate BETWEEN '$f_date' AND '$to_date' $cl3 $bc3
    UNION ALL
    SELECT cl,bc,ddate FROM t_pos_sales_sum WHERE ddate BETWEEN '$f_date' AND '$to_date' $cl3 $bc3
    GROUP BY ddate) dd
    LEFT JOIN (SELECT cl,bc,ddate,
    SUM(IFNULL(gross_amount - `total_foc_amount`,0)) AS cash_gross ,
    SUM(IFNULL(discount_amount,0))  AS cash_dis,
    SUM(IFNULL(net_amount,0)) AS cash_net,
    SUM(IFNULL(additional_add,0)) AS cash_add,
    SUM(IFNULL(additional_deduct,0)) AS cash_deduct,
    SUM(IFNULL(total_foc_amount, 0)) AS foc
    FROM t_cash_sales_sum
    WHERE is_cancel='0' AND ddate BETWEEN '$f_date' AND '$to_date' $cl3 $bc3 GROUP BY ddate) c ON c.cl=dd.cl AND c.bc=dd.bc AND c.ddate=dd.ddate
    LEFT JOIN (SELECT cl,bc,ddate,sum(amount) as amnt FROM t_credit_note tt WHERE tt.`acc_code` IN ( SELECT acc_code FROM `m_default_account` WHERE CODE='SALES_DISCOUNT') AND dis_type='4' AND is_cancel=0 AND tt.ddate BETWEEN '$f_date' AND '$to_date' $cl2 $bc2 GROUP BY ddate) AS ss ON ss.cl = dd.cl AND ss.bc = dd.bc AND ss.ddate = dd.`ddate`

    LEFT JOIN (SELECT cl,bc,ddate,sum(gross_amount) as pos_gross ,sum(total_discount) as pos_discount , sum(net_amount) as pos_net FROM t_pos_sales_sum WHERE ddate BETWEEN '$f_date' AND '$to_date' $cl3 $bc3 AND is_cancel=0 GROUP BY ddate)pos ON pos.cl = dd.cl AND pos.bc=dd.bc AND pos.ddate=dd.ddate
                    ) cs ON cs.ddate=t.ddate


                    LEFT JOIN (
                    SELECT  dd.ddate,c.credit_gross, IFNULL(c.credit_dis,0)+IFNULL(ss.amnt,0) as credit_dis ,IFNULL(c.credit_net,0)-IFNULL(ss.amnt,0) as credit_net ,c.credit_add ,c.credit_deduct,c.credit_foc
                    FROM (SELECT cl,bc,ddate FROM t_credit_sales_sum WHERE ddate BETWEEN '$f_date' AND '$to_date' $cl3 $bc3
                    UNION  ALL
                    SELECT cl,bc,ddate FROM t_credit_note WHERE ddate BETWEEN '$f_date' AND '$to_date' $cl3 $bc3 ) dd
                    LEFT JOIN (SELECT cl,bc,ddate,
                    SUM(IFNULL(gross_amount - `total_foc_amount`,0)) AS credit_gross ,
                    SUM(IFNULL(discount_amount,0))  AS credit_dis,
                    SUM(IFNULL(net_amount,0)) AS credit_net,
                    SUM(IFNULL(additional_add,0)) AS credit_add,
                    SUM(IFNULL(additional_deduct,0)) AS credit_deduct,
                    SUM(IFNULL(total_foc_amount, 0)) AS credit_foc
                    FROM t_credit_sales_sum
                    WHERE is_cancel='0' AND ddate BETWEEN '$f_date' AND '$to_date' $cl3 $bc3 GROUP by ddate) c ON c.cl=dd.cl AND c.bc=dd.bc AND c.ddate=dd.ddate
                    LEFT JOIN (SELECT cl,bc,ddate,sum(amount) as amnt FROM t_credit_note tt WHERE tt.`acc_code` IN ( SELECT acc_code FROM `m_default_account` WHERE CODE='SALES_DISCOUNT') AND dis_type='5' AND is_cancel=0 AND tt.ddate BETWEEN '$f_date' AND '$to_date' $cl2 $bc2 GROUP BY ddate) AS ss ON ss.cl = dd.cl AND ss.bc = dd.bc AND ss.ddate = dd.`ddate`
                    GROUP BY dd.ddate) cr ON cr.ddate=t.ddate
                    LEFT JOIN (SELECT  c.ddate, SUM(IFNULL(c.net_amount,0)) AS return_net FROM t_sales_return_sum c WHERE c.is_cancel='0' AND c.ddate BETWEEN '$f_date' AND '$to_date' $cl $bc $emp1  GROUP BY c.ddate) rt ON rt.ddate=t.ddate
                    JOIN m_branch bb ON bb.bc=t.bc
                    WHERE t.ddate BETWEEN '$f_date' AND '$to_date' $cl1 $bc1
                    GROUP BY t.ddate
                ORDER BY t.bc, t.ddate ASC";

        /*$sql="SELECT CONCAT(t.bc,' - ',bb.name) AS bc,
                    t.ddate,
                    IFNULL(cash_gross,0.00) AS cash_gross,
                    IFNULL(cash_dis+cash_deduct,0.00) AS cash_dis,
                    IFNULL(cash_net, 0.00) AS cash_net,
                    IFNULL(cash_add, 0.00) AS cash_add,
                    IFNULL(credit_gross,0.00) AS credit_gross,
                    IFNULL(credit_dis+credit_deduct,0.00) AS credit_dis,
                    IFNULL(credit_net,0.00) AS credit_net,
                    IFNULL(credit_add, 0.00) AS credit_add,
                    IFNULL(return_net,0.00) AS return_net,
                    (IFNULL(cash_net, 0.00)+IFNULL(credit_net,0.00))-IFNULL(return_net,0.00) AS total
                FROM (SELECT cl, bc, ddate FROM t_cash_sales_sum
                        UNION ALL
                      SELECT cl, bc, ddate FROM t_credit_sales_sum
                        UNION ALL
                      SELECT cl, bc, ddate FROM t_sales_return_sum)t
                LEFT JOIN (SELECT  c.ddate,SUM(IFNULL(c.gross_amount - c.`total_foc_amount`,0)) AS cash_gross, SUM(IFNULL(c.discount_amount,0))+IFNULL(ss.amnt,0)  AS cash_dis ,SUM(IFNULL(c.net_amount,0))-IFNULL(ss.amnt,0) AS cash_net ,SUM(IFNULL(c.additional_add,0)) AS cash_add ,SUM(IFNULL(c.additional_deduct,0)) AS cash_deduct,SUM(IFNULL(c.total_foc_amount, 0)) AS foc
                    FROM t_cash_sales_sum c
                    LEFT JOIN (SELECT cl,bc,ddate,sum(amount) as amnt FROM t_credit_note tt WHERE tt.`acc_code` IN ( SELECT acc_code FROM `m_default_account` WHERE CODE='SALES_DISCOUNT') AND dis_type='4' AND is_cancel=0 AND tt.ddate BETWEEN '$f_date' AND '$to_date' $cl2 $bc2 GROUP BY ddate) AS ss ON ss.cl = c.cl AND ss.bc = c.bc AND ss.ddate = c.`ddate`
                    WHERE c.is_cancel='0' AND c.ddate BETWEEN '$f_date' AND '$to_date' $cl $bc $emp1 GROUP BY c.ddate) cs ON cs.ddate=t.ddate
                LEFT JOIN (SELECT  c.ddate,SUM(IFNULL(c.gross_amount - c.`total_foc_amount`,0)) AS credit_gross, SUM(IFNULL(c.discount_amount,0))+IFNULL(sc.amnt,0)  AS credit_dis , SUM(IFNULL(c.net_amount,0))-IFNULL(sc.amnt,0) AS credit_net, SUM(IFNULL(c.additional_add,0)) AS credit_add ,SUM(IFNULL(c.additional_deduct,0)) AS credit_deduct,SUM(IFNULL(c.total_foc_amount, 0)) AS credit_foc FROM t_credit_sales_sum c
                    LEFT JOIN (SELECT cl,bc,ddate,sum(amount) as amnt FROM t_credit_note tt WHERE tt.`acc_code` IN ( SELECT acc_code FROM `m_default_account` WHERE CODE='SALES_DISCOUNT') AND dis_type='5' AND is_cancel=0 AND tt.ddate BETWEEN '$f_date' AND '$to_date' $cl2 $bc2 GROUP BY ddate) AS sc ON sc.cl = c.cl AND sc.bc = c.bc AND sc.ddate = c.`ddate`
                    WHERE c.is_cancel='0' AND c.ddate BETWEEN '$f_date' AND '$to_date' $cl $bc $emp1 GROUP BY c.ddate) cr ON cr.ddate=t.ddate
                LEFT JOIN (SELECT  c.ddate, SUM(IFNULL(c.net_amount,0)) AS return_net FROM t_sales_return_sum c WHERE c.is_cancel='0' AND c.ddate BETWEEN '$f_date' AND '$to_date' $cl $bc $emp1  GROUP BY c.ddate) rt ON rt.ddate=t.ddate
                JOIN m_branch bb ON bb.bc=t.bc
                WHERE t.ddate BETWEEN '$f_date' AND '$to_date' $cl1 $bc1
                GROUP BY t.ddate
                -- Having total>0 OR return_net>0
                ORDER BY t.bc, t.ddate ASC";
                */

                $data=$this->db->query($sql);
                if($data->num_rows()>0){
                  $r_detail['r_data']=$data->result();
                  $exTy=($RepTyp=="")?'pdf':'excel';
                  $this->load->view($_POST['by'].'_'.$exTy,$r_detail);
                }else{
                  echo "<script>alert('No Data');window.close();</script>";
                }

             /* if($data->num_rows()>0){
                $r_detail['r_data']=$data->result();
                $this->load->view($_POST['by'].'_'.'pdf',$r_detail);
              }else{
                echo "<script>alert('No data found');close();</script>";
              } */

            }
            public function Excel_report(){
              $this->PDF_report("Excel");
            }

            public function get_branch(){
              $q = $this->db->select(array('code', 'name'))
              ->where('code', $this->sd['bc'])
              ->get($this->tb_branch);
              $s = "<select name='bc' id='bc'>";
        //$s .= "<option value='0'>---</option>";
              foreach($q->result() as $r){
                $s .= "<option title='".$r->name."' value='".$r->code."'>".$r->code."-".$r->name."</option>";
              }
              $s .= "</select>";
              return $s;
            }
























            public function get_loanNo()
            {
              $q = $this->db->select(array('loan_no'))
              ->where('bc', $this->sd['bc'])
              ->get('t_loan_sum');

              $s = "<select name='loan_no' id='loan_no'>";
              $s .= "<option value='0'>---</option>";
              foreach($q->result() as $r)
              {
                $s .= "<option title='".$r->loan_no."' value='".$r->loan_no."'>".$r->loan_no."</option>";
              }
              $s .= "</select>";

              return $s;
            }

            public function get_all_branch()
            {

              $q = $this->db->select(array('code', 'name', ))

              ->get($this->tb_branch);

              $s = "<select name='bc' id='bc'>";
        //$s .= "<option value='0'>---</option>";
              foreach($q->result() as $r)
              {
            //echo $r->num_rows() ;
                $s .= "<option title='".$r->name."' value='".$r->code."'>".$r->code."-".$r->name."</option>";
              }
              $s .= "</select>";

      // $a['d'] = $s ;
              echo json_encode($s);

            }

            public function set_group()
            {

        //echo $_POST['center'];
       // $query = $this->db->where("center_code", $_POST['center'])->get($this->tb_group);

    /*  $query ="SELECT
                    `m_group`.`code`,
                    `m_group`.`description`
FROM
                     `m_group`
WHERE
m_group.center_code =  'KT001'
";

        $s = "<select name='group' id='group'>";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
            $s .= "<option title='".$r->description."' value='".$r->code."'>".$r->code."</option>";
        }
        $s .= "</select>";

        return $s;*/

        $qry = $this->db

        ->select(array("code","description"))
        ->where("center_code",$_POST['center'])
           // ->where("mem_no","KT000001")
            //->where("is_approved",1)
        ->get($this->tb_group);

        $op="<select name='group' id='group'>";
        $op .="<option value='0'>---</option>";
        foreach($qry->result() as $r){

          $op .="<option title='".$r->description."'value='".$r->code."'>".$r->code."-".$r->description."</option>";

        }


        echo $op;
      }

      public function select_center(){
        $query = $this->db->where("bc", $this->sd['bc'])->get($this->tb_center);

        $s = "<select name='center' id='center'>";
        $s .= "<option value='0'>---</option>";
        foreach($query->result() as $r){
          $s .= "<option title='".$r->description."' value='".$r->code."'>".$r->code."</option>";
        }
        $s .= "</select>";

        return $s;
      }


       public function f1_selection_list_cus(){


        $table         = $_POST['data_tbl'];
        $field         = isset($_POST['field'])?$_POST['field']:'code';
        $field2        = isset($_POST['field2'])?$_POST['field2']:'description';
        $field3        = isset($_POST['field3'])?$_POST['field3']:'nic';
        $hid_field     = isset($_POST['hid_field'])?$_POST['hid_field']:"0";
        $add_query     = isset($_POST['add_query'])?$_POST['add_query']:"";
        $preview_name1 = isset($_POST['preview1'])?$_POST['preview1']:'Code';
        $preview_name2 = isset($_POST['preview2'])?$_POST['preview2']:'Description';
        $preview_name3 = isset($_POST['preview3'])?$_POST['preview3']:'NIC';


        if($_POST['search'] == 'Key Word: code, name'){$_POST['search'] = "";}
        if($add_query!=""){
          $sql = "SELECT * FROM $table  WHERE ($field2 LIKE '%$_POST[search]%' OR $field LIKE '%$_POST[search]%' OR $field3 LIKE '%$_POST[search]%' ) ".$add_query." LIMIT 25";
        }else{
          $sql = "SELECT * FROM $table  WHERE $field2 LIKE '%$_POST[search]%' OR $field LIKE '%$_POST[search]%' OR $field3 LIKE '%$_POST[search]%' LIMIT 25";
        }
        $query = $this->db->query($sql);
        $a  = "<table id='item_list' style='width : 100%' >";
        $a .= "<thead><tr>";
        $a .= "<th class='tb_head_th'>".$preview_name1."</th>";
        $a .= "<th class='tb_head_th'>".$preview_name2."</th>";
        $a .= "<th class='tb_head_th'>".$preview_name3."</th>";
        $a .= "</thead></tr><tr class='cl' style='visibility: hidden;'><td>&nbsp;</td><td colspan='2'>&nbsp;</td></tr>";

        foreach($query->result() as $r){
          $a .= "<tr class='cl'>";
          $a .= "<td>".$r->{$field}."</td>";
          $a .= "<td>".$r->{$field2}."</td>";
          $a .= "<td>".$r->{$field3}."</td>";
          $a .= "</tr>";
        }
        $a .= "</table>";
        echo $a;
      }

    }
    ?>
