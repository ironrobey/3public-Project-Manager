<?php
$staffs	=	$this->db->get('staff')->result_array();
foreach ($staffs as $row):
?>
<ul class="chat-history" id="chat_history_staff_<?php echo $row['staff_id'];?>">
	<!-- thread for per user -->
	<?php
	$this_user				=	'staff-'.$row['staff_id'];
	$this->db->where('sender' , $this_user);
	$this->db->or_where('reciever' , $this_user);
	$message_thread_code	=	$this->db->get('message_thread')->row()->message_thread_code;

	$messages				=	$this->db->get_where('message' , array('message_thread_code' => $message_thread_code))->result_array();
	foreach ($messages as $row2):
		?>
		<li>
			<span class="user">
				<?php 
					$sender 				=	explode('-' , $row2['sender']);
					$sender_account_type	=	$sender[0];
					$sender_id				=	$sender[1];
					echo $this->db->get_where($sender_account_type , array($sender_account_type.'_id' => $sender_id))->row()->name;
				?>
			</span>
			<p><?php echo $row2['message'];?></p>
			<span class="time"><?php echo date("d M,Y" , $row2['timestamp']);?></span>
		</li>
	<?php endforeach;?>
</ul>
<?php endforeach;?>