<?php $account_type 	=	$this->session->userdata('login_type');?>
<div id="chat" class="fixed" 
	data-current-user="<?php echo $this->db->get_where($account_type , array($account_type.'_id' => $this->session->userdata('login_user_id')) )->row()->name;?>" 
		data-order-by-status="1" data-max-chat-history="25">
	
	<div class="chat-inner">
	
		
		<h2 class="chat-header">
			<a href="#" class="chat-close" data-animate="1" onclick="make_offline()"><i class="entypo-cancel"></i></a>
			
			<i class="entypo-users"></i>
			Chat
			<span class="badge badge-success is-hidden">0</span>
		</h2>
		
		
		<div class="chat-group" id="group-1">
			<strong><?php echo get_phrase('staff');?></strong>
			
			<?php 
			$staffs	=	$this->db->get('staff')->result_array();
			foreach ($staffs as $row):
				?>
				<a href="#" id="staff-<?php echo $row['staff_id'];?>" 
					data-conversation-history="#chat_history_staff_<?php echo $row['staff_id'];?>">
						<span class="user-status is-<?php echo $row['chat_status'];?>"></span> 
							<em><?php echo $row['name'];?></em>
								</a>
			<?php endforeach;?>


		</div>
		
		
	
	</div>
	
	<!-- conversation template -->
	<div class="chat-conversation">
		
		<div class="conversation-header">
			<a href="#" class="conversation-close"><i class="entypo-cancel"></i></a>
			
			<span class="user-status"></span>
			<span class="display-name"></span> 
			<small></small>
		</div>
		
		<ul class="conversation-body">	
		</ul>
		
		<div class="chat-textarea">
			<textarea class="form-control autogrow" placeholder="Type your message"></textarea>
		</div>
	</div>
	
</div>


<!-- staff chat history -->

<div id="chat_history">

<?php include 'chat_history.php';?>

</div>

<!--<ul class="chat-history" id="sample_history">
	<li>
		<span class="user">Art Ramadani</span>
		<p>Are you here?</p>
		<span class="time">09:00</span>
	</li>
	
	<li class="opponent">
		<span class="user">Catherine J. Watkins</span>
		<p>This message is pre-queued.</p>
		<span class="time">09:25</span>
	</li>
	
	<li class="opponent unread">
		<span class="user">Catherine J. Watkins</span>
		<p>Whohoo!</p>
		<span class="time">09:26</span>
	</li>
	
	<li class="opponent unread">
		<span class="user">Catherine J. Watkins</span>
		<p>Do you like it?</p>
		<span class="time">09:27</span>
	</li>
</ul>

<ul class="chat-history" id="sample_history_2">
	<li class="opponent unread">
		<span class="user">Daniel A. Pena</span>
		<p>I am going out.</p>
		<span class="time">08:21</span>
	</li>
	
	<li class="opponent unread">
		<span class="user">Daniel A. Pena</span>
		<p>Call me when you see this message.</p>
		<span class="time">08:27</span>
	</li>
</ul>-->

<!-- <script src="assets/js/neon-chat.js"></script> -->