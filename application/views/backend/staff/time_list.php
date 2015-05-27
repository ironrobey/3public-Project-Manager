<a onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/add_time/<?php echo $this->uri->segment(3); ?>');" class="btn btn-primary pull-right">
        <i class="entypo-user-add"></i>
        <?php echo get_phrase('add_manual_time');?>
</a>
     
<br>
<br>
<br>
<div class="main_data">
	<?php include 'project_time_list.php';?>
</div>