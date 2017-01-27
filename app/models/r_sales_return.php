<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_sales_return extends CI_Model {
    
    private $mtb = "";
    private $sd;
    private $w = 210;
    private $h = 297;
    
    function __construct(){
        parent::__construct();
        
        $this->load->database();
        $this->load->library('useclass');
        
        $this->sd = $this->session->all_userdata();
	$this->load->database($this->sd['db'], true);
	
    }
    
    public function base_details(){
        // $a['report'] = $this->report();
        // $a['title'] = "Sales Return Report";
        
        // return $a;
    }
    
    // public function report(){
        
    //     if(! isset($this->sd['from'])){ $this->sd['from'] = date("Y-m-d");}
    //     if(! isset($this->sd['to'])){ $this->sd['to'] = date("Y-m-d");}
    //     if(! isset($this->sd['wd'])){ $this->sd['wd'] = 1;}
    //     if(isset($this->sd['paper'])){
    //         if($this->sd['paper'] = "l"){
    //             $this->h = 279;
    //             $this->w = 216;
    //         }
    //     }
    //     if(! isset($this->sd['type'])){ $this->sd['type'] = "sum";}
    //     if($this->sd['type'] == 'sum'){
    //         $sql = "SELECT
    //                     t_sales_return_sum.no,
    //                     m_customer.name AS full_name,
    //                     m_sales_ref.name,
    //                     m_stores.description,
    //                     pri.cost
    //                   FROM t_sales_return_sum
    //                     INNER JOIN m_customer
    //                       ON (m_customer.code = t_sales_return_sum.customer)
    //                     INNER JOIN m_stores
    //                       ON (m_stores.code = t_sales_return_sum.stores)
    //                     INNER JOIN m_sales_ref
    //                       ON (m_sales_ref.code = t_sales_return_sum.sales_ref)
    //                     LEFT OUTER JOIN (SELECT
    //                                        SUM(quantity*cost)        AS cost,
    //                                        id
    //                                      FROM t_sales_return_det
    //                                      GROUP BY id) AS pri
    //                       ON (pri.id = t_sales_return_sum.id)
    //                   WHERE t_sales_return_sum.date BETWEEN '".$this->sd['from']."'
    //                       AND '".$this->sd['to']."'
    //                       AND t_sales_return_sum.is_cancel = 0
    //                       AND bc = '".$this->sd['bc']."'
    //                   ORDER BY t_sales_return_sum.id";
    //     }else{
    //         $sql = "SELECT
    //                     t_sales_return_sum.no,
    //                     name AS full_name,
    //                     item_code,
    //                     m_items.description AS item_name,
    //                     quantity,
    //                     t_sales_return_det.cost
    //                   FROM t_sales_return_det
    //                     INNER JOIN t_sales_return_sum
    //                       ON (t_sales_return_sum.id = t_sales_return_det.id)
    //                     INNER JOIN m_customer
    //                       ON (m_customer.code = t_sales_return_sum.customer)
    //                     INNER JOIN m_items
    //                       ON (m_items.code = t_sales_return_det.item_code)
    //                   WHERE t_sales_return_sum.date BETWEEN '".$this->sd['from']."'
    //                       AND '".$this->sd['to']."'
    //                       AND t_sales_return_sum.is_cancel = 0
    //                       AND bc = '".$this->sd['bc']."'
    //                   ORDER BY t_sales_return_sum.id";
    //     }
        
    //     $query = $this->db->query($sql);
        
    //     if($query->num_rows){
    //         if($this->sd['type'] == 'sum'){
    //             $result = $query->result();
    //             $t = 0;
    //             foreach($result as $rr){
    //                 $t += $rr->cost;
    //             }
                
    //             $r = new stdClass();
    //             $r->no = "";
    //             $r->full_name = "";
    //             $r->name = "";
    //             $r->description = array("data"=>"Total", "style"=>"text-align: right; font-weight: bold; border: none;");
    //             $r->cost = array("data"=>$t, "style"=>"text-align: right; font-weight: bold; border-bottom: 2px solid #000;");
                
    //             array_push($result, $r);
                
    //             $inv_no = array("data"=>"INV. No", "style"=>"text-align: left; ", "chalign"=>"text-align: left; width:80px");
    //             $job_no = array("data"=>"Customer", "style"=>"text-align: left; ", "chalign"=>"text-align: left;");
    //             $vehi = array("data"=>"Sales Ref","style"=>"text-align: left; ", "chalign"=>"text-align: left; width:100px");
    //             $cus = array("data"=>"Stores", "style"=>"text-align: left; ", "chalign"=>"text-align: left; width:100px");
    //             $total = array("data"=>"Total", "style"=>"text-align: right;", "chalign"=>"text-align: right; width:100px");
                
    //             $heading = array($inv_no, $job_no, $vehi, $cus, $total);
                
    //             $inv_no = array("data"=>"no", "total"=>false, "format"=>"text");
    //             $job_no  = array("data"=>"full_name", "total"=>false, "format"=>"text");
    //             $vehi  = array("data"=>"name", "total"=>false, "format"=>"text");
    //             $cus  = array("data"=>"description", "total"=>false, "format"=>"text");
    //             $total  = array("data"=>"cost", "total"=>false, "format"=>"amount");
                
    //             $field = array($inv_no, $job_no, $vehi, $cus, $total);
                
    //             $page_rec = 30;
                
    //             $header  = array("data"=>$this->useclass->r_header("Sales Return Summary Report - ".$this->sd['from']." To ".$this->sd['to']), "style"=>"");
    //             $footer  = array("data"=>"<hr />Report generate on - ".date("Y-m-d H:i:s"), "style"=>"font-size: 11px; font-family: Courier;");
    //             $page_no = array("style"=>"font-size: 11px; font-family: Courier;", "vertical"=>"buttom", "horizontal"=>"right");
                
    //             $data = array(
    //                           "dbtem"=>$this->useclass->report_style(),
    //                           "data"=>$result,
    //                           "field"=>$field,
    //                           "heading"=>$heading,
    //                           "page_rec"=>$page_rec,
    //                           "height"=>$this->h,
    //                           "width"=>$this->w,
    //                           "header"=>30,
    //                           "header_txt"=>$header,
    //                           "footer_txt"=>$footer,
    //                           "page_no"=>$page_no,
    //                           "header_of"=>false
    //                           );
    //             //print_r($data); exit;
    //             $this->load->library('greport', $data);
                
    //             $resu = $this->greport->_print();
    //         }else{
    //             $result = $query->result();
    //             $t = $st = $inv = 0; $res = array();
    //             foreach($result as $rr){
    //                 if($inv == 0 || $inv != $rr->no){
    //                     if($inv != 0){
    //                         $r = new stdClass();
    //                         $r->code = "";
    //                         $r->name = "";
    //                         $r->quantity = "";
    //                         $r->price = "";
    //                         $r->total = array("data"=>number_format($st, 2, '.', ','), "style"=>"border-bottom: 1px solid #000; font-weight: bold; text-align:right;");
                            
    //                         $res[] = $r;
    //                         $st = 0;
    //                     }
                        
    //                     $inv = $rr->no;                      
    //                     $r = new stdClass();
    //                     $r->code = "";
    //                     $r->name = array("data"=>"Name : ".$rr->full_name." | INV No : ".$rr->no,
    //                                      "style"=>"font-weight: bold; border-bottom: 1px solid #000; ");
    //                     $r->quantity = "";
    //                     $r->price = "";
    //                     $r->total = "";
                        
    //                     $res[] = $r;
                        
    //                 }
    //                 $tt = $rr->quantity*$rr->cost;
    //                 $t += $tt; $st += $tt;
    //                 $r = new stdClass();
    //                 $r->code = $rr->item_code;
    //                 $r->name = $rr->item_name;
    //                 $r->quantity = number_format($rr->quantity, 0, '.', ',');
    //                 $r->price = number_format($rr->cost, 2, '.', ',');
    //                 $r->total = number_format($tt, 2, '.', ',');
                    
    //                 $res[] = $r;
    //             }
                
    //             $r = new stdClass();
    //             $r->code = "";
    //             $r->name = "";
    //             $r->quantity = "";
    //             $r->price = "";
    //             $r->total = array("data"=>number_format($st, 2, '.', ','), "style"=>"border-bottom: 1px solid #000; font-weight: bold; text-align:right;");
                
    //             $res[] = $r;
                
    //             $r = new stdClass();
    //             $r->code = "";
    //             $r->name = "";
    //             $r->quantity = "";
    //             $r->price = "";
    //             $r->total = array("data"=>number_format($t, 2, '.', ','), "style"=>"border-bottom: 2px solid #000; font-weight: bold; text-align:right;");
                
    //             $res[] = $r;
                
    //             $name = array("data"=>"Item_name", "style"=>"text-align: left; ", "chalign"=>"text-align: left;");
    //             $code = array("data"=>"Item_code", "style"=>"text-align: left; ", "chalign"=>"text-align: left; width:100px");
    //             $qun = array("data"=>"Quantity","style"=>"text-align: right; ", "chalign"=>"text-align: right; width:80px");
    //             $pri = array("data"=>"Price", "style"=>"text-align: right; ", "chalign"=>"text-align: right; width:80px");
    //             $total = array("data"=>"Total", "style"=>"text-align: right;", "chalign"=>"text-align: right; width:100px");
                
    //             $heading = array($name, $code, $qun, $pri, $total);
                
    //             $name = array("data"=>"name", "total"=>false, "format"=>"text");
    //             $code  = array("data"=>"code", "total"=>false, "format"=>"text");
    //             $qun  = array("data"=>"quantity", "total"=>false, "format"=>"text");
    //             $pri  = array("data"=>"price", "total"=>false, "format"=>"text");
    //             $total  = array("data"=>"total", "total"=>false, "format"=>"text");
                
    //             $field = array($name, $code, $qun, $pri, $total);
                
    //             $page_rec = 28;
                
    //             $header  = array("data"=>$this->useclass->r_header("Sales Return Detail Report - ".$this->sd['from']." To ".$this->sd['to']), "style"=>"");
    //             $footer  = array("data"=>"<hr />Report generate on - ".date("Y-m-d H:i:s"), "style"=>"font-size: 11px; font-family: Courier;");
    //             $page_no = array("style"=>"font-size: 11px; font-family: Courier;", "vertical"=>"buttom", "horizontal"=>"right");
                
    //             $data = array(
    //                           "dbtem"=>$this->useclass->report_style(),
    //                           "data"=>$res,
    //                           "field"=>$field,
    //                           "heading"=>$heading,
    //                           "page_rec"=>$page_rec,
    //                           "height"=>$this->h,
    //                           "width"=>$this->w,
    //                           "header"=>40,
    //                           "header_txt"=>$header,
    //                           "footer_txt"=>$footer,
    //                           "page_no"=>$page_no,
    //                           "header_of"=>false
    //                           );
    //             //print_r($data); exit;
    //             $this->load->library('greport', $data);
                
    //             $resu = $this->greport->_print();
    //         }
    //     }else{
    //         $resu = "<span style='color:red;'>There is no data to load.</span>";
    //     }
        
    //     return $resu;
    // }
}
?>