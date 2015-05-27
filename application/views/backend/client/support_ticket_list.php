
<table class="table table-bordered datatable" id="table_export">
	<thead>
		<tr>
			<th style="width:30px;">
			<th><div><?php echo get_phrase('title');?></div></th>
			<th><div><?php echo get_phrase('ticket_code');?></div></th>
			<th><div><?php echo get_phrase('client');?></div></th>
			<th><div><?php echo get_phrase('status');?></div></th>
			<th><div><?php echo get_phrase('priority');?></div></th>
			<th><div><?php echo get_phrase('options');?></div></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$counter	=	1;
		$this->db->where('client_id' , $this->session->userdata('login_user_id'));
		$this->db->where('status' , $ticket_status);
		$this->db->order_by('ticket_id' , 'desc');
		$tickets	=	$this->db->get('ticket' )->result_array();
		foreach($tickets as $row):
		?>
		<tr>
			<td style="width:30px;">
           		<?php echo $counter++;?>
			<td>
				<a href="<?php echo base_url();?>index.php?client/support_ticket_view/<?php echo $row['ticket_code'];?>">
					<?php echo $row['title'];?>
               </a>
           	</td>
			<td><?php echo $row['ticket_code'];?></td>
			<td><?php echo $this->db->get_where('client',array('client_id'=>$row['client_id']))->row()->name;?></td>
			<td>
				<div class="label label-<?php if ($row['status'] == 'closed')echo 'primary';
													else if ($row['status'] == 'opened')echo 'success'?>">
					<?php echo $row['status'];?></div>
			</td>
			<td>
				<div class="label label-<?php if ($row['priority'] == 'high')echo 'danger';
													else if ($row['priority'] == 'medium')echo 'info';
														else if ($row['priority'] == 'low')echo 'default'?>">
					<?php echo $row['priority'];?></div>
			</td>
			<td>
            	<div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                      Action <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                      
                      <!-- VIEW LINK -->
                      <li>
                          <a href="<?php echo base_url();?>index.php?client/support_ticket_view/<?php echo $row['ticket_code'];?>">
                              <i class="entypo-target"></i>
                                  <?php echo get_phrase('view_ticket');?>
                              </a>
                      </li>
                      
                      <!-- DELETION LINK 
                      <li class="divider"></li>
                      <li>
                          <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/support/delete/<?php echo $row['ticket_id'];?>' , '<?php echo base_url();?>index.php?admin/reload_support_ticket_list');" >
                              <i class="entypo-trash"></i>
                                  <?php echo get_phrase('delete');?>
                              </a>
                      </li>-->
                  </ul>
              </div>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>




                     
<script type="text/javascript">


	
	jQuery(document).ready(function($)
	{
		var datatable = $("#table_export").dataTable({
			"sPaginationType": "bootstrap",
			"aoColumns": [
				{ "bSortable": false },
				null,
				null,
				null,
				null,
				null,
				null
			],
			
		});
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
		
		

		
	});
		
</script>
