<table class="table table-bordered datatable" id="table_export">
	<thead>
		<tr>
			<th><div><?php echo get_phrase('task');?></div></th>
			<th><div><?php echo get_phrase('time');?></div></th>
			<th><div><?php echo get_phrase('description');?></div></th>
			<th><div><?php echo get_phrase('added_by');?></div></th>
			<th><div><?php echo get_phrase('date_added');?></div></th>
			<th><div><?php echo get_phrase('option');?></div></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$this->db->order_by('project_task_note_id' , 'desc');
			$this->db->select('*');
			$this->db->from('project_task A');
			$this->db->join('project_task_note B', 'B.project_task_id = A.project_task_id');
			$this->db->where('project_id',$param);
			$times = $this->db->get();

			$counter = 1;

			if( $times->num_rows() > 1 ){
				foreach( $times->result_array() as $row ):

					$seconds = $row['project_task_timestamp'];
					$hours = $seconds / 3600;

					?>
					<tr>
						<td><?php echo $row['title']; ?></td>
						<td><?php echo number_format( (float)$hours, 2, '.', '' ); ?></td>
						<td><?php echo $row['project_task_note']; ?></td>
						<td><?php echo $row['added_by']; ?></td>
						<td><?php echo $row['date_added']; ?></td>
						<td>
							<?php if( $this->crud_model->get_user_account_name() == $row['added_by'] ): ?>
							<div class="btn-group">
								<button type="button" class="btn btn-default btn-sm dropdown-toggle " data-toggle="dropdown">
									Action <span class="caret"></span>
								</button>
								<ul class="dropdown-menu dropdown-default pull-right" role="menu">

									<!-- EDITING LINK -->
									<li>
										<a onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/edit_time/<?php echo $row['project_task_note_id'];?>');">
											<i class="entypo-pencil"></i>
											<?php echo get_phrase('edit');?>
										</a>
									</li>

									<li class="divider"></li>

									<!-- DELETION LINK -->
									<li>
										<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?staff/time_list/delete/<?php echo $row['project_task_note_id'];?>' , '<?php echo base_url();?>index.php?staff/reload_time_list/<?php echo $param; ?>');" >
											<i class="entypo-trash"></i>
											<?php echo get_phrase('delete');?>
										</a>
									</li>
								</ul>
							</div>
							<?php endif; ?>
						</td>
					</tr>
					<?php
				endforeach;
			} else {
				?>
				<tr>
					<td> No manual time added yet </td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php
			}

		?>
	</tbody>
</table>

<script type="text/javascript">
	jQuery(document).ready(function(){
		replaceCheckboxes();
		var datatable = $("#table_export").dataTable({
			"sPaginationType": "bootstrap",
			"aoColumns": [
        		{ "bVisible": true},    //0,task
				{ "bVisible": true},	//1,time
		        { "bVisible": true},    //2,description
		        { "bVisible": true},    //3,added by
		        { "bVisible": true},    //4,date added
		        { "bVisible": true},    //4,date added
			],
			
		});

		//customize the select menu
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
</script>