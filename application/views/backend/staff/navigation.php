<div class="sidebar-menu">
		<header class="logo-env" >
			
            <!-- logo -->
			<div class="logo" style="">
				<a href="<?php echo base_url();?>">
					<img src="assets/images/logo.png"  style="max-height:60px;"/>
				</a>
			</div>
            
			<!-- logo collapse icon -->
			<div class="sidebar-collapse" style="">
				<a href="#" class="sidebar-collapse-icon with-animation">
                
					<i class="entypo-menu"></i>
				</a>
			</div>
			
			<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
			<div class="sidebar-mobile-menu visible-xs">
				<a href="#" class="with-animation">
					<i class="entypo-menu"></i>
				</a>
			</div>
		</header>
		<div class="sidebar-user-info">
			
			<div class="sui-normal">
				<a href="#" class="user-link">
					<img src="<?php echo $this->crud_model->get_image_url($this->session->userdata('login_type') , 
							$this->session->userdata('login_user_id'));?>" alt="" class="img-circle" style="height:44px;">
					
					<span><?php echo get_phrase('welcome');?>,</span>
					<strong><?php echo $this->db->get_where($this->session->userdata('login_type'), 
											array( 		$this->session->userdata('login_type').'_id' =>
														$this->session->userdata('login_user_id')))->row()->name;?>
                  </strong>
				</a>
			</div>
			
			<div class="sui-hover inline-links animate-in">				
				<a href="<?php echo base_url();?>index.php?<?php echo $account_type;?>/manage_profile">
					<i class="entypo-pencil"></i>
					<?php echo get_phrase('edit_profile');?>
				</a>
				
				<a href="<?php echo base_url();?>index.php?<?php echo $account_type;?>/manage_profile">
					<i class="entypo-lock"></i>
					<?php echo get_phrase('change_password');?>
				</a>
				
				<span class="close-sui-popup">×</span><!-- this is mandatory -->			</div>
		</div>
        
        
		<div style="border-top:1px solid rgba(69, 74, 84, 0.7);"></div>	
		<ul id="main-menu" class="">
            
           
           <!-- DASHBOARD -->
           <li class="<?php if($page_name == 'dashboard')echo 'active';?> ">
				<a href="<?php echo base_url();?>index.php?staff/dashboard">
					<i class="entypo-gauge"></i>
					<span><?php echo get_phrase('dashboard');?></span>
				</a>
           </li>
           
           <!-- ASSIGNED PROJECT  -->
           <?php if ($this->crud_model->staff_permission(1)):?>
           <li class="<?php if($page_name == 'project' || $page_name == 'project_monitor')echo 'active';?> ">
				<a href="<?php echo base_url();?>index.php?staff/project">
					<i class="entypo-paper-plane"></i>
					<span><?php echo get_phrase('assigned_project_list');?></span>
				</a>
           </li>
           <?php endif;?>
           
           <!-- ALL PROJECT  -->
           <?php if ($this->crud_model->staff_permission(2)):?>
           <li class="<?php if($page_name == 'project' || $page_name == 'project_monitor')echo 'active';?> ">
				<a href="<?php echo base_url();?>index.php?staff/project">
					<i class="entypo-paper-plane"></i>
					<span><?php echo get_phrase('all_project_list');?></span>
				</a>
           </li>
           <li class="<?php if($page_name == 'project_add')echo 'active';?> ">
				<a href="<?php echo base_url();?>index.php?staff/project_add">
					<i class="entypo-plus"></i>
					<span><?php echo get_phrase('add_new_project');?></span>
				</a>
           </li>
           <?php endif;?>
           
          
           
           <!-- CIENT -->
           <?php if ($this->crud_model->staff_permission(3)):?>
           <li class="<?php if($page_name == 'client')echo 'active';?> ">
				<a href="<?php echo base_url();?>index.php?staff/client">
					<i class="entypo-users"></i>
					<span><?php echo get_phrase('client');?></span>
				</a>
           </li>
           <?php endif;?>

           <!-- LEAD -->
           <?php if ($this->crud_model->staff_permission(8)):?>
           <li class="<?php if($page_name == 'lead')echo 'active';?> ">
				<a href="<?php echo base_url();?>index.php?staff/lead">
					<i class="entypo-users"></i>
					<span><?php echo get_phrase('lead');?></span>
				</a>
           </li>
           <?php endif;?>
           
           <!-- STAFF -->
           <?php if ($this->crud_model->staff_permission(4)):?>
           <li class="<?php if($page_name == 'staff' )echo 'active';?> ">
				<a href="<?php echo base_url();?>index.php?staff/staffs" >
					<i class="entypo-user"></i>
					<span><?php echo get_phrase('manage_staffs');?></span>
				</a>
           </li>
           <?php endif;?>
           
           <!-- PAYMENT -->
           <?php if ($this->crud_model->staff_permission(5)):?>
           <li class="<?php if($page_name == 'invoice' || 
		   							$page_name == 'invoice_add' )echo 'opened active has-sub';?> ">
				<a href="<?php echo base_url();?>index.php?staff/invoice">
					<i class="entypo-credit-card"></i>
					<span><?php echo get_phrase('payment');?></span>
				</a>
                <ul>
					<li class="<?php if($page_name == 'invoice_add')echo 'active';?> ">
						<a href="<?php echo base_url();?>index.php?staff/invoice_add">
							<span><i class="entypo-dot"></i> <?php echo get_phrase('create_invoice');?></span>
						</a>
					</li>
					<li class="<?php if($page_name == 'invoice')echo 'active';?> ">
						<a href="<?php echo base_url();?>index.php?staff/invoice">
							<span><i class="entypo-dot"></i> <?php echo get_phrase('manage_client_invoice');?></span>
						</a>
					</li>
                </ul>
           </li>
           <?php endif;?>         
           
           
           <!-- ASSIGNED SUPPORT TICKETS -->
           <?php if ($this->crud_model->staff_permission(6)):?>
           <li class="<?php if($page_name == 'support_ticket' ||
		   							$page_name == 'support_ticket_view')echo 'opened active has-sub';?> ">
				<a href="#" >
					<i class="entypo-lifebuoy"></i>
					<span><?php echo get_phrase('assigned_support_tickets');?></span>
				</a>
                <ul>
					<li class="<?php if($page_name == 'support_ticket' && $ticket_status == 'opened')echo 'active';?> ">
						<a href="<?php echo base_url();?>index.php?staff/support_ticket/opened">
							<span><i class="entypo-dot"></i> <?php echo get_phrase('opened_tickets');?></span>
						</a>
					</li>
					<li class="<?php if($page_name == 'support_ticket' && $ticket_status == 'closed')echo 'active';?> ">
						<a href="<?php echo base_url();?>index.php?staff/support_ticket/closed">
							<span><i class="entypo-dot"></i> <?php echo get_phrase('closed_tickets');?></span>
						</a>
					</li>
                </ul>
           </li>
           <?php endif;?>           
           
           
           <!-- ALL SUPPORT TICKETS -->
           <?php if ($this->crud_model->staff_permission(7)):?>
           <li class="<?php if($page_name == 'support_all' )echo 'active';?> ">
				<a href="#" >
					<i class="entypo-lifebuoy"></i>
					<span><?php echo get_phrase('all_support_tickets');?></span>
				</a>
                <ul>
					<li class="<?php if($page_name == 'support_ticket' && $ticket_status == 'opened')echo 'active';?> ">
						<a href="<?php echo base_url();?>index.php?staff/support_ticket/opened">
							<span><i class="entypo-dot"></i> <?php echo get_phrase('opened_tickets');?></span>
						</a>
					</li>
					<li class="<?php if($page_name == 'support_ticket' && $ticket_status == 'closed')echo 'active';?> ">
						<a href="<?php echo base_url();?>index.php?staff/support_ticket/closed">
							<span><i class="entypo-dot"></i> <?php echo get_phrase('closed_tickets');?></span>
						</a>
					</li>
                </ul>
           </li>
           <?php endif;?>
           
           	<!-- MESSAGE -->
           	<?php if( $this->crud_model->get_account_role_id(8) ): ?>
           	<li class="<?php if($page_name == 'message') echo 'active';?>">
				<a href="<?php echo base_url();?>index.php?staff/message">
					<i class="entypo-mail"></i>
					<span><?php echo get_phrase('message');?></span>
				</a>
           	</li>
       		<?php endif; ?>
           
           <!-- ACCOUNT -->
           <li class="<?php if($page_name == 'manage_profile')echo 'active';?> ">
				<a href="<?php echo base_url();?>index.php?staff/manage_profile">
					<i class="entypo-lock"></i>
					<span><?php echo get_phrase('account');?></span>
				</a>
           </li>
                
           
           
		</ul>
        		
</div>