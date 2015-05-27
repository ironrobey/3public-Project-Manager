<?php $edit_data	=	$this->db->get_where('invoice' , array('invoice_id' => $param2))->result_array();
foreach ($edit_data as $row):
?>

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
<h4><?php echo get_phrase('take_payment_manually');?> :</h4>

<?php echo form_open('payment/take_payment_manually/'.$row['invoice_number'] , array('class' => 'form-horizontal form-groups validate invoice-add', 'enctype' => 'multipart/form-data'));?>
                    
    <div class="form-group">
        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('payment_method');?></label>
        
        <div class="col-sm-7">
            <input type="text" class="form-control" name="payment_method" id="title" data-validate="required" 
                data-message-required="<?php echo get_phrase('value_required');?>" value="" placeholder="e.g. Cheque, cash">
        </div>
    </div>    

    <div class="form-group">
        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
        
        <div class="col-sm-7">
            <textarea name="description" class="form-control"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('amount');?></label>
        
        <div class="col-sm-7">
            <input type="text" class="form-control" name="amount"   value="<?php echo $grand_total;?>" >
        </div>
    </div>

    <div class="form-group">
        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
        
        <div class="col-sm-7">
            <input type="text" class="form-control datepicker" name="timestamp"   value="" >
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-8">
            <button type="submit" class="btn btn-info" id="submit-button">
                <?php echo get_phrase('take_payment');?></button>
        </div>
    </div>

<?php echo form_close();?>

<?php endforeach;?>



