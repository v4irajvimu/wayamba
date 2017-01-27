<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class r_transaction_list_hp extends CI_Model 
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
    }
    
    public function base_details()
	{
    	
    }

    public function opening_hp_ctrl(){

        $sql="SELECT `def_use_opening_hp` FROM `m_branch` WHERE cl='".$this->sd['cl']."' AND bc='".$this->sd['branch']."'";
        $query = $this->db->query($sql)->first_row();
        echo json_encode( $query);
        
    }
	
	
}
?>