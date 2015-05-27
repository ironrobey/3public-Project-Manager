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

                <?php echo form_open('staff/time_list/add/'.$param2, array('class' => 'form-horizontal form-groups-bordered validate project-add', 'enctype' => 'multipart/form-data')); ?>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('time'); ?></label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="time" id="title" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" value="" autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('description'); ?></label>

                    <div class="col-sm-8">
                        <textarea class="form-control wysihtml5" rows="10" name="short_note" id="post_content" data-stylesheet-url="assets/css/wysihtml5-color.css"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('project_task'); ?></label>

                    <div class="col-sm-5">
                        <select name="project_task_id" class="selectboxit" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" >
                            <option><?php echo get_phrase('select_a_project_task'); ?></option>
                            <?php
                            $tasks = $this->db->get_where( 'project_task', array('project_id' => $param2 ) )->result_array();
                            foreach ($tasks as $row):
                                ?>
                                <option value="<?php echo $row['project_task_id']; ?>">
                                    <?php echo $row['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-8">
                        <button type="submit" class="btn btn-info" id="submit-button">
                            <?php echo get_phrase('add_time'); ?></button>
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
            window.location.href="<?php echo base_url(); ?>index.php?staff/time_list/<?php echo $param2; ?>";
        }, 1000);
        
    }


</script>