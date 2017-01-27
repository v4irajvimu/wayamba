<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_master_seettu extends CI_Model {
    
    private $sd;
    private $mtb;
    private $mod = '003';
    private $max_no;
    
    function __construct(){
	parent::__construct();
	
	$this->sd = $this->session->all_userdata();
	$this->load->database($this->sd['db'], true);
	$this->load->model('user_permissions');
  
        

    }
    
    public function base_details(){

      
    }
}