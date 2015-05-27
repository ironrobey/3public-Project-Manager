<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/invoice_add/');" 
    class="btn btn-primary pull-right">
        <i class="entypo-plus-circled"></i>
        <?php echo get_phrase('add_new_invoice');?>
    </a>
     
<br><br>

<div class="main_data">
	<?php include 'invoice_list.php';?>
</div>