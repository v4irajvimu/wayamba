<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller {

    private $sd;

    function __construct(){
		parent::__construct();
		$this->sd = $this->session->all_userdata();


		if(isset($this->sd['db'])){
			$this->load->database($this->sd['db'], true);
		}

    }

    public function index(){

        if(base_url() == 'http://softmasterlk.com/mthree/' || base_url() == 'http://www.softmasterlk.com/mthree/'){
				redirect('http://mthree.softmasterlk.com');
			}else{
					if(isset($this->sd['is_login']) == true){

							if($this->sd['is_process']!=false){
								$this->load->model("user_permissions");
								$this->load->view('header', $this->loder->base_details());

							if(isset($_GET['action'])){
								if ($this->user_permissions->view_mod_permission($_GET['action'])=="1"){
									$this->load->model($_GET['action']);
									$this->load->view($_GET['action'], $this->{$_GET['action']}->base_details());
								}else{
									$this->load->view('welcome');
								}
							}else{
								$this->load->view('welcome');
							}
							$this->load->view('footer');

							}else{
								$this->load->model("user_permissions");
								$this->load->view('header', $this->loder->base_details());
									if(isset($_GET['action'])){
										if ($this->user_permissions->view_mod_permission($_GET['action'])=="1"){
											$this->load->model($_GET['action']);
											$this->load->view($_GET['action'], $this->{$_GET['action']}->base_details());
										}
										else{
											$this->load->view('welcome');
										}
									}else{
                    $data = array('dash_cashsales'=>32.5, 'dash_creditsales'=>65.89, 'dash_hpsales'=>48.25);
										$this->load->view('welcome',$data);
									}
								$this->load->view('footer');
							}
					}else{
						$this->load->model('login');
						$this->load->view('login', $this->login->base_details());
					}
        }
    }

    public function login(){
	$this->load->model('s_users');
	$this->s_users->check_previous_process_login();
	echo $this->s_users->authenticate();
        $this->load->model("user_permissions");
        $this->user_permissions->add_permission();


    }

    public function logout(){

	$sd = array(
            "is_login"=>false
        );

    $this->session->set_userdata($sd);
	$this->session->unset_userdata("oc");
	$this->session->unset_userdata("bc");
	$this->session->unset_userdata("db");
	$this->session->unset_userdata("is_login");

	redirect(base_url());
    }


    public function save(){

    	/*if(isset($_POST['date'])){
    		$ddate = $_POST['date'];
    	}else if(isset($_POST['ddate'])){
    		$ddate = $_POST['ddate'];
    	}else{
    		$ddate = date('Y-m-d');
    	}

    	if(isset($_POST['hid'])){
    		if ($_POST['hid'] == "0" || $_POST['hid'] == "") {
    			$this->load->model($this->uri->segment(3));
				$this->{$this->uri->segment(3)}->save();
    		}else{
    			if(isset($_POST['transtype']) && $_POST['transtype']=="PURCHASE"){
    				if(isset($_POST['app_status']) && $_POST['app_status']=="2"){
    					$this->load->model($this->uri->segment(3));
						$this->{$this->uri->segment(3)}->save();
    				}else{
		    			if($ddate<=$this->sd['day_end']){
		    				echo "Transaction Cann't be Edit";
		    			}else{
		    				$this->load->model($this->uri->segment(3));
							$this->{$this->uri->segment(3)}->save();
		    			}
    				}
    			}else if(isset($_POST['transtype']) && ($_POST['transtype']=="PURCHASE RETURN" ||  $_POST['transtype']=="SALES RETURN WITHOUT INVOICE" ||  $_POST['transtype']=="SALES RETURN")){
    				if(isset($_POST['approve']) && $_POST['approve']=="2"){
    					$this->load->model($this->uri->segment(3));
						$this->{$this->uri->segment(3)}->save();
    				}else{
		    			if($ddate<=$this->sd['day_end']){
		    				echo "Transaction Cann't be Edit";
		    			}else{
		    				$this->load->model($this->uri->segment(3));
							$this->{$this->uri->segment(3)}->save();
		    			}
    				}
    			}else if(isset($_POST['transtype']) && $_POST['transtype']=="CREDIT"){
    				if(isset($_POST['approve_h']) && $_POST['approve_h']=="1"){
    					$this->load->model($this->uri->segment(3));
						$this->{$this->uri->segment(3)}->save();
    				}else{
		    			if($ddate<=$this->sd['day_end']){
		    				echo "Transaction Cann't be Edit";
		    			}else{
		    				$this->load->model($this->uri->segment(3));
							$this->{$this->uri->segment(3)}->save();
		    			}
    				}
    			}else{
    				if($ddate<=$this->sd['day_end']){
	    				echo "Transaction Cann't be Edit";
	    			}else{
	    				$this->load->model($this->uri->segment(3));
						$this->{$this->uri->segment(3)}->save();
	    			}
    			}
    		}
    	}else{
			$this->load->model($this->uri->segment(3));
			$this->{$this->uri->segment(3)}->save();
    	}*/
    	$this->load->model($this->uri->segment(3));
		$this->{$this->uri->segment(3)}->save();
    }


    public function delete(){
    	/*if($this->sd['delete_day']<=$this->sd['day_end']){
			echo "Transaction Cann't be Cancel";
		}else{
			$this->load->model($this->uri->segment(3));
			$this->{$this->uri->segment(3)}->delete();
		}*/
		$this->load->model($this->uri->segment(3));
		$this->{$this->uri->segment(3)}->delete();
    }

    public function get_data(){
	$this->load->model($this->uri->segment(3));
	$this->{$this->uri->segment(3)}->load();
    }

    public function load_return_qty(){
	$this->load->model($this->uri->segment(3));
	$this->{$this->uri->segment(3)}->load_return_qty();
    }

    public function get_return_data(){
	$this->load->model($this->uri->segment(3));
	$this->{$this->uri->segment(3)}->load_return();
    }

    public function get_department(){
	$this->load->model($this->uri->segment(3));
	$this->{$this->uri->segment(3)}->load_main_cat();
    }

    public function get_sub_cat(){
	$this->load->model($this->uri->segment(3));
	$this->{$this->uri->segment(3)}->load_sub_cat();
    }

    public function get_subitem_data(){
	$this->load->model($this->uri->segment(3));
	$this->{$this->uri->segment(3)}->load_subitem();
    }


    public function select(){
	$this->load->model($this->uri->segment(3));
	$this->{$this->uri->segment(3)}->select();
    }


    public function load_data(){
	$this->load->model($this->uri->segment(3));

	if(isset($_GET['echo'])){
	    if($_GET['echo'] == "true"){
		echo json_encode($this->{$this->uri->segment(3)}->{$this->uri->segment(4)}());
	    }else{
		$this->{$this->uri->segment(3)}->{$this->uri->segment(4)}();
	    }
	}else{
	    $this->{$this->uri->segment(3)}->{$this->uri->segment(4)}();
	}
}

    public function backup(){
	/*
	$this->load->dbutil();
	$backup =& $this->dbutil->backup();

	$this->load->helper('download');
	force_download(time().'.sql', $backup);
	*/
	$ddate=date("Y-m-d H:i:s");
  	$this->load->dbutil();
     $prefs = array(
         //'tables'      => array('m_customer', 'm_employee'),
         'ignore'      => array(),
         'format'      => 'txt',
         'filename'    => $ddate.'_DB.sql',
         'add_drop'    => TRUE,
         'add_insert'  => TRUE,
         'newline'     => "\n"
     );
     $backup =& $this->dbutil->backup($prefs);
     $this->load->helper('file');
     $file_name = "(".$ddate.')DB.sql';
     write_file('/'.$file_name, $backup);
     $this->load->helper('download');
     force_download($file_name, $backup);

    }



}
