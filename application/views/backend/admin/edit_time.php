<?php $row = $this->db->get_where('project_task_note' , array('project_task_note_id' => $param2))->row(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('project_form'); ?>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->db->where( 'project_task_id', $row->project_task_id ); ?>
                <?php $project_task = $this->db->get( 'project_task' )->row(); ?>

                <?php echo form_open('admin/time_list/edit/', array('class' => 'form-horizontal form-groups-bordered validate project-add', 'enctype' => 'multipart/form-data')); ?>

                <input type="hidden" name="project_task_note_id" value="<?php echo $row->project_task_note_id; ?>">
                <input type="hidden" name="original_time" value="<?php echo $row->project_task_timestamp; ?>">
                <input type="hidden" name="project_id" value="<?php echo $project_task->project_id; ?>">

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('time'); ?></label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="time" id="title" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" value="<?php echo number_format( (float)($row->project_task_timestamp / 3600), 2, '.', '' ); ?>" autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                    <div class="col-sm-8">
                        <textarea class="form-control wysihtml5" rows="10" name="short_note" id="post_content" data-stylesheet-url="assets/css/wysihtml5-color.css"><?php echo $row->project_task_note; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('project_task'); ?></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" value="<?php echo $project_task->title; ?>" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-8">
                        <button type="submit" class="btn btn-info" id="submit-button">
                            <?php echo get_phrase('edit_time'); ?></button>
                        <span id="preloader-form"></span>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>




<script>
    $(document).ready(function () {

        var options = {
            beforeSubmit: validate_project_add,
            success: show_response_project_add,
            resetForm: true
        };
        $('.project-add').submit(function () {
            $(this).ajaxSubmit(options);
            return false;
        });
    });
    function validate_project_add(formData, jqForm, options) {

        console.log(jqForm);

        if (!jqForm[0].title.value)
        {
            return false;
        }
        $('#preloader-form').html('<img src="assets/images/preloader.gif" style="height:15px;margin-left:20px;" />');
        document.getElementById("submit-button").disabled = true;
    }

    function show_response_project_add(responseText, statusText, xhr, $form) {
        $('#preloader-form').html('');
        toastr.success("Project added successfully", "Success");
        document.getElementById("submit-button").disabled = false;
        setTimeout(function(){
            window.location.href="<?php echo base_url(); ?>index.php?admin/time_list/<?php echo $project_task->project_id; ?>";
        }, 1000);
        
    }


</script>