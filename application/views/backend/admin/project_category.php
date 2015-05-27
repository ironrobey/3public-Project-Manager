<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/project_category_add/');" 
    class="btn btn-primary pull-right">
        <i class="entypo-plus-circled"></i>
        <?php echo get_phrase('add_new_project_category');?>
    </a>
<br><br>
<div class="main_data">
	<?php include 'project_category_list.php';?>
</div>