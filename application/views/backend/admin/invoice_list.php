
<table class="table table-bordered datatable" id="table_export">
	<thead>
		<tr>
			<th style="width:30px;">
			</th>
			<th><div><?php echo get_phrase('title');?></div></th>
			<th><div><?php echo get_phrase('amount');?></div></th>
			<th><div><?php echo get_phrase('project');?></div></th>
			<th><div><?php echo get_phrase('client');?></div></th>
			<th><div><?php echo get_phrase('status');?></div></th>
			<th><div><?php echo get_phrase('options');?></div></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$counter	=	1; 
		$system_currency_id	=	$this->db->get_where('settings' , array('type'=>'system_currency_id'))->row()->description;
		$currency_symbol		=	$this->db->get_where('currency' , array('currency_id'=>$system_currency_id))->row()->currency_symbol;
		
		$this->db->order_by('invoice_id' , 'desc');
		$invoices	=	$this->db->get('invoice' )->result_array();
		foreach($invoices as $row):
			?>
		<tr>
			<td style="width:30px;">
           		<?php echo $counter++;?>
			</td>
			<td><?php echo $row['title'];?></td>
			<td><?php echo $currency_symbol.$this->crud_model->calculate_invoice_total_amount($row['invoice_number']);?></td>
			<td><?php echo $this->db->get_where('project' , array('project_id'=>$row['project_id']))->row()->title;?></td>
			<td><?php echo $this->db->get_where('client' , array('client_id'=>$row['client_id']))->row()->name;?></td>
			<td>
				<div class="badge badge-<?php if($row['status']=='paid')echo 'success';else echo 'danger';?>">
					<?php echo $row['status'];?>
				</div>
			</td>
			<td>
				<div class="btn-group">
					<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
						Action <span class="caret"></span>
					</button>
					<ul class="dropdown-menu dropdown-default pull-right" role="menu">

						<!-- INVOICE VIEW/PRINT LINK -->
						<li>
							<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/invoice_view/<?php echo $row['invoice_id'];?>');">
								<i class="entypo-doc-text-inv"></i>
								<?php echo get_phrase('view');?> / <?php echo get_phrase('print');?> / <?php echo get_phrase('email');?>
							</a>
						</li>

						<!-- INVOICE MANUAL PAYMENT LINK -->
						<?php if($row['status']=='unpaid'):?>
							<li>
								<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/invoice_manual_pay/<?php echo $row['invoice_id'];?>');">
									<i class="entypo-credit-card"></i>
									<?php echo get_phrase('take_manual_payment');?>
								</a>
							</li>
						<?php endif;?>

						<!-- EDITING LINK -->
						<li>
							<a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/invoice_edit/<?php echo $row['invoice_id'];?>');">
								<i class="entypo-pencil"></i>
								<?php echo get_phrase('edit');?>
							</a>
						</li>
						<li class="divider"></li>

						<!-- DELETION LINK -->
						<li>
							<a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/invoice/delete/<?php echo $row['invoice_id'];?>' , '<?php echo base_url();?>index.php?admin/reload_invoice_list');" >
								<i class="entypo-trash"></i>
								<?php echo get_phrase('delete');?>
							</a>
						</li>
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
		
		// convert datatable
		var datatable = $("#table_export").dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
			"aoColumns": [
			{ "bSortable": false },
			{ "bVisible": true},
			{ "bVisible": true},
			{ "bVisible": true},
			{ "bVisible": true},
			{ "bVisible": true},
			null
			],
			"oTableTools": {
				"aButtons": [

				{
					"sExtends": "xls",
					"mColumns": [0, 2, 3, 4]
				},
				{
					"sExtends": "pdf",
					"mColumns": [0, 2, 3, 4]
				},
				{
					"sExtends": "print",
					"fnSetText"	   : "Press 'esc' to return",
					"fnClick": function (nButton, oConfig) {
						datatable.fnSetColumnVis(1, false);
						datatable.fnSetColumnVis(5, false);

						this.fnPrint( true, oConfig );

						window.print();

						$(window).keyup(function(e) {
							if (e.which == 27) {
								datatable.fnSetColumnVis(1, true);
								datatable.fnSetColumnVis(5, true);
							}
						});
					},

				},
				]
			},
			
		});


		//customize the select menu
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
		
		

		
	});

</script>
