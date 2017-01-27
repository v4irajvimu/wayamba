<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class t_hp_payment extends CI_Model {

    private $sd;
    private $mod = '003';

    function __construct() {
        parent::__construct();
        $this->sd = $this->session->all_userdata();
        $this->load->database($this->sd['db'], true);
        $this->load->model('user_permissions');
        
    }

    public function base_details() {
       
    }

   public function PDF_report() {
        $this->db->select(array('name', 'address', 'tp', 'fax', 'email'));
        $this->db->where("cl", $this->sd['cl']);
        $this->db->where("bc", $this->sd['branch']);
        $r_detail['branch'] = $this->db->get('m_branch')->result();


        $invoice_number= $this->utility->invoice_format($_POST['qno']);
        $session_array = array(
             $this->sd['cl'],
             $this->sd['branch'],
             $invoice_number
        );
        $r_detail['session'] = $session_array;

        $r_detail['type'] = $_POST['type'];
        $r_detail['qno'] = $_POST['qno'];
        $num = $_POST['tot'];
        $r_detail['page'] = $_POST['page'];
        $r_detail['header'] = $_POST['header'];
        $r_detail['orientation'] = $_POST['orientation'];
    

        $sql_sum="SELECT 
                      s.agreement_no,
                      s.ddate,
                      s.agr_serial_no,
                      e.`tp1` as sm_tp1,
                      e.`tp2`AS sm_tp2,
                      e.`tp3`AS sm_tp3,
                      e.`name`AS sm_name,
                      c.`name` as cm_name,
                      c.`address1`AS cm_add1,
                      c.`address2`AS cm_add2,
                      c.`address3`AS cm_add3,
                      cc.tp as cm_tp,
                      c.nic,
                      d.`item_code`,
                      i.`description`,
                      d.qty,
                      d.`sales_price`
                    from
                      t_hp_sales_sum s 
                      join m_customer c on c.`code` = s.`cus_id` 
                      join m_employee e on e.`code` = s.`rep` 
                      join t_hp_sales_det d on d.`nno`=s.`nno`
                      join m_item i on i.`code`=d.`item_code`
                      left join `m_customer_contact` cc ON cc.`code` = c.`code` 
                      WHERE s.nno='".$_POST['qno1']."'";

        $query_det=$this->db->query($sql_sum);
        $r_detail['pay_sum'] = $query_det->result();

        $sql_sched="SELECT ins_no,due_date,ins_amount,ins_paid FROM `t_ins_schedule` WHERE trans_no='".$_POST['qno1']."'";

        $query_det=$this->db->query($sql_sched);
        $r_detail['pay_sched'] = $query_det->result();

        $sql_rec="SELECT ddate,inv_no,paid_amount FROM `t_hp_receipt_sum` WHERE inv_no='".$_POST['qno1']."'";

        $query_det=$this->db->query($sql_rec);
        $r_detail['pay_recie'] = $query_det->result();

        $this->db->select(array('interest_amount','net_amount','down_payment','document_charges','balance','no_of_installments','installment_amount'));
        $this->db->from('t_hp_sales_sum');
        $this->db->join('t_hp_sales_det', 't_hp_sales_det.nno=t_hp_sales_sum.nno');
        $this->db->where('t_hp_sales_sum.bc', $this->sd['branch']);
        $this->db->where('t_hp_sales_sum.cl', $this->sd['cl']);
        $this->db->where('t_hp_sales_sum.nno', $_POST['qno1']);
        $r_detail['amount'] = $this->db->get()->result();

        $this->db->select(array('loginName'));
        $this->db->where('cCode', $this->sd['oc']);
        $r_detail['user'] = $this->db->get('users')->result();

        $this->load->view($_POST['by'] . '_' . 'pdf', $r_detail);
    }
}
