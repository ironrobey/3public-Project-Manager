<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/lead_add/');" 
    class="btn btn-primary pull-right">
        <i class="entypo-user-add"></i>
        <?php echo get_phrase('add_new_lead');?>
    </a>
     
<br>
<br>
<br>

<div class="main_data">
	<?php include 'lead_list.php';?>
</div>