
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="image/png" href="<?=base_url(); ?>img/ico.png" rel="icon">
<title>Inventory System - <?php echo $company; ?></title>
<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/main.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/inputs.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/grid.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery-ui-1.8.4_.custom.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery.tablescroll.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/jquery.autocomplete.css" />
<link href="<?=base_url(); ?>css/superfish.css" rel="stylesheet" type="text/css">
<link href="<?=base_url(); ?>css/slider.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>css/menu.css" />
<script type="text/javascript" src="<?=base_url(); ?>js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>js/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>js/autoNumeric1.6.2.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>js/jquery.tablescroll.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>js/jquery.form.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>js/main.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>js/inputs.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>js/menu.js"></script>
<script type="text/javascript" src="<?=base_url(); ?>js/permition.js"></script>

    </head>
    <body ondragstart="return false;" ondrop="return false;" >

        <div id="blocker"></div>
	<div style="display: none"><audio id="player" name="player" src="<?=base_url()?>sound/ring.ogg" controls="controls"></audio></div>
	<div id="blanket">
	    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	    <img src="<?=base_url(); ?>/img/loadingBig.gif" />
	</div>
        
        
   <div id="serch_pop" style="width: 600px;">
	    <input type="text" id="pop_search" title="" class="input_acitve" style="width: 100%;" /><br />
	    <div id="sr"></div>
	    <div style="text-align: right; padding-top: 7px;"><button id="pop_close" >Close</button></div>
	</div>
    
	<div id="blocker"></div>
	<div id="blanket">
	    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	    <img src="<?=base_url(); ?>/img/loadingBig.gif" />
	</div>
	<div id="serch_pop">
	    <input type="text" id="pop_search" title=""  style="width: 100%;" class="input_acitve"/><br />
	    <div id="sr"></div>
	    <div style="text-align: right; padding-top: 7px;"><button id="pop_close" >Close</button></div>
	</div>

	<div id="blocker2"></div>
	<div id="blanket2">
	    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	    <img src="<?=base_url(); ?>/img/loadingBig.gif" />
	</div>
	<div id="serch_pop2">
	    <input type="text" id="pop_search2" title=""  style="width: 100%;" class="input_acitve"/><br />
	    <div id="sr2"></div>
	    <div style="text-align: right; padding-top: 7px;"><button id="pop_close2" >Close</button></div>
	</div>

	<div id="blocker3"></div>
	<div id="blanket3">
	    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	    <img src="<?=base_url(); ?>/img/loadingBig.gif" />
	</div>
	<div id="serch_pop3">
	    <div id="sr3"></div>
	    <div style="text-align: right; padding-top: 7px;"><button id="pop_close3" >Close</button></div>
	</div>

	<div id="blocker4"></div>
	<div id="blanket4">
	    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	    <img src="<?=base_url(); ?>/img/loadingBig.gif" />
	</div>
	<div id="serch_pop4">
	    <input type="text" id="pop_search4" title=""  style="width: 100%;" /><br />
	    <div id="sr4"></div>
	    <div style="text-align: right; padding-top: 7px;"><button id="pop_close4" >Close</button></div>
	</div>
	<div id="logout">
	    <div class="logout">
		<div class="logout_block">
			<!-- <div class="logout_block_center"><?= $branch_det ." | "; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $user->discription ;  ?> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;  -->
			<div class="logout_block_center">
			<?=anchor("main/logout", "Logout"); ?></div>
		</div>
			<!-- <div id="open_det_box"><img id="slide_arrow" src="<?=base_url(); ?>/images/icon-menu.png"/></div> -->
	    </div>
	</div>

	<div id="display_msg">
		<div id="display_inner_msg"></div>
	</div>
	
	<div id="msg_box">
		<img id="close_msg_box" src="<?=base_url(); ?>/images/close_button.png"/>
		<div id="msg_box_inner">
		</div>
	</div>

	<ul class="sf-menu">
	    <li class="current"><a target="_blank" href="#a"><img src="<?=base_url()?>images/arrow.png"  height='50'/></a>
		<ul style="width:63px;">
 			<?php
 				if($this->user_permissions->is_view('s_users')||
 				   $this->user_permissions->is_view('s_module')||
 				   $this->user_permissions->is_view('s_role')||
 				   $this->user_permissions->is_view('s_add_role')||
 				   $this->user_permissions->is_view('s_permission_level_order')||
 				   $this->user_permissions->is_view('u_branch_to_user')){

 			?>
		    <li><a href="#"><img src="<?=base_url()?>images/system.png"  width="53" height="43" /></a>
				<ul>
                	
                    <?php if($this->user_permissions->is_view('s_users')){ ?><li><a target="_blank" href="?action=s_users">Users</a></li><?php } ?>
                    <?php if($this->user_permissions->is_view('s_module')){ ?><li><a target="_blank" href="?action=s_module">Module</a></li><?php } ?>
                    <?php if($this->user_permissions->is_view('s_role')){ ?><li><a target="_blank" href="?action=s_role">User Role</a></li><?php } ?>
                    <?php if($this->user_permissions->is_view('s_add_role')){ ?><li><a target="_blank" href="?action=s_add_role">Add Role</a></li><?php } ?>
                    <?php if($this->user_permissions->is_view('s_permission_level_order')){ ?><li><a target="_blank" href="?action=s_permission_level_order">User Permission Level Order</a></li> <?php } ?> 
                    <?php if($this->user_permissions->is_view('u_branch_to_user')){ ?><li><a target="_blank" href="?action=u_branch_to_user">Add Branch To User</a></li><?php } ?>
                </ul>
            </li>
            <?php } ?>
		    </li>
		</ul>
	    </li>
	</ul>
<div id="copyright" style="display: none;">Copyright &copy; 2012 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>
<input type="hidden" id="cid" title="0" />