<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title" >
                    <i class="entypo-plus-circled"></i>
                    <?php echo get_phrase('add_project_task'); ?>
                </div>
            </div>
            <div class="panel-body">

                <?php echo form_open('admin/project_task/create/'.$param2, array('class' => 'form-horizontal form-groups-bordered validate ajax-submit', 'enctype' => 'multipart/form-data')); ?>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('title'); ?></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" value="" autofocus>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('status'); ?></label>

                    <div class="col-sm-5">
                        <select name="complete_status" class="form-control">
                            <option value="0"><?php echo get_phrase('incomplete'); ?></option>
                            <option value="1"><?php echo get_phrase('complete'); ?></option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('start_date'); ?></label>

                    <div class="col-sm-7">
                        <div class="date-and-time">
                            <input type="text" name="timestamp_start" class="form-control datepicker" data-format="D, dd MM yyyy" placeholder="start date here">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('end_date'); ?></label>

                    <div class="col-sm-7">
                        <div class="date-and-time">
                            <input type="text" name="timestamp_end" class="form-control datepicker" data-format="D, dd MM yyyy" placeholder="end date here">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('task_time_budget'); ?></label>

                    <div class="col-sm-5">
                        <div class="task_time_budget">
                            <input type="text" class="form-control" name="task_time_budget" data-validate="required" data-message-required="<?php echo get_phrase('value_required'); ?>" value="">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-7">
                        <button type="submit" class="btn btn-info" id="submit-button"><?php echo get_phrase('submit'); ?></button>
                        <span id="preloader-form"></span>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    // url for refresh data after ajax form submission
    var post_refresh_url = '<?php echo base_url(); ?>index.php?admin/reload_project_monitor_body/<?php echo $param2; ?>';
    var post_message = 'Data Created Successfully';
</script>

<!-- calling ajax form submission plugin for specific form -->
<script src="assets/js/ajax-form-submission.js"></script>