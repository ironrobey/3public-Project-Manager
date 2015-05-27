<?php $edit_data	=	$this->db->get_where('invoice' , array('invoice_id' => $param2))->result_array();
foreach ($edit_data as $row):
?>

<a href="#" class="btn btn-default btn-icon icon-left hidden-print  pull-left"
    	onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/invoice_view/<?php echo $row['invoice_id'];?>');">
		<i class="entypo-doc-text"></i>
			<?php echo get_phrase('view_invoice_detail');?>
		</a>
<div style="clear:both;"></div>
<h4><?php echo get_phrase('invoice_entries');?> :</h4>
<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th width="60%"><?php echo get_phrase('entry');?></th>
            <th><?php echo get_phrase('price');?></th>
        </tr>
    </thead>
    
    <tbody>
                <!-- INVOICE ENTRY STARTS HERE-->
              <div id="invoice_entry">
              <?php 
			  	  $system_currency_id	=	$this->db->get_where('settings' , 
				  									array('type'=>'system_currency_id'))->row()->description;
				  $currency_symbol		=	$this->db->get_where('currency' , 
				  									array('currency_id'=>$system_currency_id))->row()->currency_symbol;
                $total_amount		=	0;
                $invoice_entries		=	json_decode($row['invoice_entries']);
                $i = 1;					
                foreach ($invoice_entries as $invoice_entry)
                {
                    $total_amount	+=	$invoice_entry->amount;
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++;?></td>
                        <td>
								<?php echo $invoice_entry->description;?>
                        </td>
                        <td class="text-right">
                        		<?php echo $currency_symbol.$invoice_entry->amount;?>
                        </td>
                    </tr>
                  <?php
                }
				  $vat_amount			=	$total_amount * $row['vat_percentage'] / 100;
				  $grand_total			=	$total_amount + $vat_amount - $row['discount_amount'];
                ?>
              </div>
              <!-- INVOICE ENTRY ENDS HERE-->
    </tbody>
</table>
<table width="100%" border="0">    
    <tr>
    	<td align="right" width="80%"><?php echo get_phrase('sub_total');?> :</td>
    	<td align="right"><?php echo $currency_symbol.$total_amount;?></td>
    </tr>
    <tr>
    	<td align="right" width="80%"><?php echo get_phrase('vat_percentage');?> :</td>
    	<td align="right"><?php echo $row['vat_percentage'];?>% </td>
    </tr>
    <tr>
    	<td align="right" width="80%"><?php echo get_phrase('discount');?> :</td>
    	<td align="right"><?php echo $currency_symbol.$row['discount_amount'];?> </td>
    </tr>
    <tr>
    	<td colspan="2"><hr style="margin:0px;"></td>
    </tr>
    <tr>
    	<td align="right" width="80%"><h4><?php echo get_phrase('grand_total');?> :</h4></td>
    	<td align="right"><h4><?php echo $currency_symbol.$grand_total;?> </h4></td>
    </tr>
</table>

<br>
<h4><?php echo get_phrase('checkout');?> :</h4>
<ul class="list-group">
	
    <!-- paypal terminal-->
    <li class="list-group-item">
    
		<?php echo form_open('payment/pay_invoice/');?>
        	<input type="hidden" name="method" value="paypal" >
        	<input type="hidden" name="invoice_number" value="<?php echo $row['invoice_number'];?>" >
			<button type="submit" class="btn btn-md btn-success btn-icon pull-right" style="margin-top:-6px;">
                <?php echo get_phrase('make_payment');?>
                <i class="entypo-right-thin"></i>
			</button>
        <?php echo form_close();?>
        
        <i class="entypo-dot"></i>
        <?php echo get_phrase('pay_with_paypal');?>
    </li>
	
</ul>

<?php endforeach;?>



