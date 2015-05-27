<div class="row">
	<div class="col-md-12 col-sm-12 clearfix" style="text-align:center;">
    	<!-- logo 
			<div class="logo" style="">
				<a href="<?php echo base_url();?>">
					<img src="assets/images/logo.png"  style="max-height:50px;"/>
				</a>
			</div>-->
		<h2 style="font-weight:200; margin:0px;"><?php echo $system_name;?></h2>
    </div>
	
	<!-- Raw Links -->
	<div class="col-md-12 col-sm-12 clearfix ">
		
        <ul class="list-inline links-list pull-left" style="padding-top:0px; padding-bottom:0px;">		
           


			<!-- Message Notifications -->
			<li class="notifications dropdown">
				<?php
				$total_unread_message_number		=	0;
				$current_user						=	$this->session->userdata('login_type').'-'.$this->session->userdata('login_user_id');

				$this->db->where('sender' , $current_user);
				$this->db->or_where('reciever' , $current_user);
				$message_threads					=	$this->db->get('message_thread')->result_array();
				foreach($message_threads as $row) {
					$unread_message_number			=	$this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
					$total_unread_message_number	+=	$unread_message_number;
				}
				?>
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="entypo-mail"></i>
					<?php if ($total_unread_message_number >0 ):?>
						<span class="badge badge-secondary"><?php echo $total_unread_message_number;?></span>
					<?php endif;?>
				</a>
				
				<ul class="dropdown-menu">
					<li>
						<ul class="dropdown-menu-list scroller">
							

							<?php
							$current_user				=	$this->session->userdata('login_type').'-'.$this->session->userdata('login_user_id');
							$this->db->where('sender' , $current_user);
							$this->db->or_where('reciever' , $current_user);
							$message_threads			=	$this->db->get('message_thread')->result_array();
							foreach($message_threads as $row):

								// defining the user to show
								if ($row['sender'] == $current_user)
									$user_to_show		=	explode('-' , $row['reciever']);
								if ($row['reciever'] == $current_user)
									$user_to_show		=	explode('-' , $row['sender']);
								$user_to_show_type		=	$user_to_show[0];
								$user_to_show_id		=	$user_to_show[1];
								$unread_message_number	=	$this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
								if ($unread_message_number == 0)
									continue;

								// the last sent message from the opponent user
								$this->db->order_by('timestamp' , 'desc');
								$last_message_row		=	$this->db->get_where('message',array('message_thread_code' => $row['message_thread_code']) )->row();
								$last_unread_message	=	$last_message_row->message;
								$last_message_timestamp	=	$last_message_row->timestamp;

							?>
							<li class="active">
								<a href="<?php echo base_url();?>index.php?<?php echo $this->session->userdata('login_type');?>/message/message_read/<?php echo $row['message_thread_code'];?>">
									<span class="image pull-right">
										<img src="<?php echo $this->crud_model->get_image_url($user_to_show_type , $user_to_show_id);?>" height="48" class="img-circle" />
									</span>
									
									<span class="line">
										<strong>
											<?php echo $this->db->get_where($user_to_show_type , array($user_to_show_type.'_id' => $user_to_show_id))->row()->name;?>
										</strong>
										- <?php echo date("d M, Y" , $last_message_timestamp);?>
									</span>
									
									<span class="line desc small">
										<!-- preview of the last unread message substring -->
										<?php
											echo substr($last_unread_message , 0 , 50);
										?>
									</span>
								</a>
							</li>
							<?php endforeach;?>
						</ul>
					</li>

					<li class="external">
						<a href="<?php echo base_url();?>index.php?<?php echo $this->session->userdata('login_type');?>/message">
							<?php echo get_phrase('view_all_messages');?>
						</a>
					</li>				
				</ul>
				
			</li>


			<!-- Project status // shown to admin only-->
			<?php 
				if ($this->session->userdata('login_type') == 'admin'):

				$this->db->where('progress_status <' , 100);
				$this->db->order_by('project_id' , 'desc');
				$projects	=	$this->db->get('project' )->result_array();
				?>
				<li class="notifications dropdown">
					
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<i class="entypo-paper-plane"></i>
						<?php if (count($projects) > 0):?>
							<span class="badge badge-info"><?php echo count($projects);?></span>
						<?php endif;?>
					</a>
					
					<ul class="dropdown-menu">
						<li class="top">
							<p><?php echo count($projects);?> <?php echo get_phrase('pending_projects');?></p>
						</li>

						<li>
							<ul class="dropdown-menu-list scroller">
								

								<?php 
								foreach($projects as $row):
									$status = 'info';
									if ($row['progress_status'] == 100)$status = 'success';
									if ($row['progress_status'] < 50)$status = 'danger';
									?>
									<li>
										<a href="<?php echo base_url();?>index.php?admin/project_monitor/<?php echo $row['project_id'];?>">
											<span class="task">
												<span class="desc"><?php echo $row['title'];?></span>
												<span class="percent"><?php echo $row['progress_status'];?>%</span>
											</span>
											
											<span class="progress progress-striped active" role="progressbar" >
												<span style="width: <?php echo $row['progress_status'];?>%;" 
													class="progress-bar progress-bar-<?php echo $status;?>">
														<span class="sr-only"><?php echo $row['progress_status'];?>% Complete</span>
												</span>
											</span>
										</a>
									</li>
								<?php endforeach;?>
							</ul>
						</li>

						<li class="external">
							<a href="<?php echo base_url();?>index.php?admin/project">
								<?php echo get_phrase('view_all_projects');?>
							</a>
						</li>				
					</ul>
				</li>
			<?php endif;?>


        </ul>
        
        
		<ul class="list-inline links-list pull-right" style="padding-top:0px; padding-bottom:0px;">	
			
			<!-- Language Selector 			
           <li class="dropdown language-selector">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                        <i class="entypo-globe"></i> language
                    </a>
				
				<ul class="dropdown-menu pull-right">
					<li>
						<a href="#">					
							<span>Deutsch</span>
						</a>
					</li>
					<li class="active">
						<a href="#">
							<span>English</span>
						</a>
					</li>
				</ul>
				
			</li>-->

			<!-- chat button
			<li>
				<a href="#"   onclick="update_chat_area()">
					<i class="entypo-chat"></i>
					update
				</a>
				<a href="#" data-animate="0" data-collapse-sidebar="1" class="chat-open" onclick="make_online()"
					style="display:<?php #if ($chat_status == 'offline') echo 'block'; else echo 'none';?>;">
					<i class="entypo-chat"></i>
					Chat
				</a>
				<a href="#" data-animate="0" data-collapse-sidebar="1" class="chat-close" onclick="make_offline()"
					style="display:<?php #if ($chat_status == 'online') echo 'block'; else echo 'none';?>;">
					<i class="entypo-chat"></i>
					Chat
				</a>

				<span class="badge badge-success chat-notifications-badge">3</span>
			</li>-->

			<script type="text/javascript">

				// function update_chat_area()
				// {
				// 	$.ajax({
				// 		url: '<?php echo base_url();?>index.php?chat/view_chat_area',
				// 		success: function(response)
				// 		{
				// 			jQuery('#chat_area').html(response);
				// 			//neonChat.refreshUserIds();
				// 			neonChat.open($(".chat-group a#staff-5"));
				// 		}
				// 	});
				// }
				// function make_online()
				// {
				// 	$.ajax({
				// 		url: '<?php echo base_url();?>index.php?chat/update_chat_status/online',
				// 		success: function(response)
				// 		{
				// 			toastr.info("online" , "chat status" );
				// 		}
				// 	});
				// 	$(".chat-open").css("display" , "none");
				// 	$(".chat-close").css("display" , "block");
					
				// }
				// function make_offline()
				// {
				// 	$.ajax({
				// 		url: '<?php echo base_url();?>index.php?chat/update_chat_status/offline',
				// 		success: function(response)
				// 		{
				// 			toastr.info("offline" , "chat status" );
				// 		}
				// 	});
				// 	$(".chat-close").css("display" , "none");
				// 	$(".chat-open").css("display" , "block");
				// }
			</script>
			<!--<li class="sep"></li>-->
			
			<li>
				<a href="<?php echo base_url();?>index.php?login/logout">
					Log Out <i class="entypo-logout right"></i>
				</a>
			</li>
		</ul>
	</div>
	
</div>

<hr style="margin-top:0px;" />