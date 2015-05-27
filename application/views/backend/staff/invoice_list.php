
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
                                  <?php echo get_phrase('view/print_invoice');?>
                              </a>
                                      </li>
                      
                      
                      <!-- DELETION LINK -->
                      <li>
                          <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?staff/invoice/delete/<?php echo $row['invoice_id'];?>' , '<?php echo base_url();?>index.php?staff/reload_invoice_list');" >
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
		//show confirmation after the payment status
		<?php if ($this->session->flashdata('paypal_cancel') == 'true'):?>
			toastr.error('payment cancelled');
		<?php endif;?>
		<?php if ($this->session->flashdata('paypal_success') == 'true'):?>
			toastr.success('payment completed successfully');
		<?php endif;?>
		
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
			"aoColumns": [
				{ "bSortable": false },
				{ "bVisible": true},
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
