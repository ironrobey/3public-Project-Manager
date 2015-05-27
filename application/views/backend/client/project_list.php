
<table class="table table-bordered datatable" id="table_export">
	<thead>
		<tr>
			<th style="width:30px;">
           </th>
			<th><div><?php echo get_phrase('project');?></div></th>
			<th><div><?php echo get_phrase('category');?></div></th>
			<th><div><?php echo get_phrase('client');?></div></th>
			<th><div><?php echo get_phrase('progress');?></div></th>
			<th><div><?php echo get_phrase('options');?></div></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$counter	=	1;
		$this->db->order_by('project_id' , 'desc');
		$this->db->where('client_id' , $this->session->userdata('login_user_id'));
		$projects	=	$this->db->get('project' )->result_array();
		foreach($projects as $row):
		?>
		<tr>
			<td style="width:30px;">
           		<?php echo $counter++;?>
           	</td>
			<td>
				<a href="<?php echo base_url();?>index.php?client/project_monitor/<?php echo $row['project_id'];?>">
					<?php echo $row['title'];?>
               </a>
           	</td>
			<td><?php echo $this->db->get_where('project_category' , 
					array('project_category_id'=>$row['project_category_id']))->row()->name;?>
                    </td>
			<td><?php echo $this->db->get_where('client' , 
					array('client_id'=>$row['client_id']))->row()->name;?>
                    </td>
			<td>
            	<?php 
				$status = 'info';
				if ($row['progress_status'] == 100)$status = 'success';
				if ($row['progress_status'] < 50)$status = 'danger';
				?>
              
              <div class="progress progress-striped <?php if ($row['progress_status']!=100)echo 'active';?> tooltip-primary" 
                      style="height:3px !important; cursor:pointer;"  data-toggle="tooltip"  data-placement="top"
                          title="" data-original-title="<?php echo $row['progress_status'];?>% completed" >
                  <div class="progress-bar progress-bar-<?php echo $status;?>" 
                  	role="progressbar" aria-valuenow="<?php echo $row['progress_status'];?>" 
                    		aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row['progress_status'];?>%">
                      <span class="sr-only">40% Complete (success)</span>
                  </div>
              </div> 
           </td>
			<td>
            	<a class="btn btn-info tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('monitor_project');?>"	href="<?php echo base_url();?>index.php?client/project_monitor/<?php echo $row['project_id'];?>">
                	<i class="entypo-target"></i>
               </a>
            	
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>




                     
<script type="text/javascript">


	
	jQuery(document).ready(function($)
	{
		//convert all checkboxes before converting datatable
		replaceCheckboxes();
		
		// Highlighted rows
		$("#table_export tbody input[type=checkbox]").each(function(i, el)
		{
			var $this = $(el),
				$p = $this.closest('tr');
			
			$(el).on('change', function()
			{
				var is_checked = $this.is(':checked');
				
				$p[is_checked ? 'addClass' : 'removeClass']('highlight');
			});
		});
		
		// convert the datatable
		var datatable = $("#table_export").dataTable({
			"sPaginationType": "bootstrap",
			"aoColumns": [
				{ "bSortable": false },
				{ "bVisible": true},
				{ "bVisible": true},
				{ "bVisible": true},
				{ "bVisible": true},
				null
			],
			
		});
		
		//customize the select menu
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
		
		

		
	});
		
</script>
<script src="assets/js/neon-custom-ajax.js"></script>