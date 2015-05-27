<style>
    .tooltip-default:hover{cursor:pointer;}
</style>
<?php
$project_detail = $this->db->get_where('project', array('project_id' => $project_id))->result_array();
foreach ($project_detail as $row):
    ?>

    <!-- BREADCRUMB STARTS -->
    <ol class="breadcrumb bc-2">
        <li>
            <a href="<?php echo base_url(); ?>">
                <i class="entypo-folder"></i>
                <?php echo get_phrase('dashboard'); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>index.php?client/project">
                <?php echo get_phrase('project_list'); ?></a>
        </li>
        <li class="active"><?php echo $row['title']; ?></li>
    </ol>
    <!-- BREADCRUMB ENDS -->

    <div class="row">
        <div class="col-md-8">

            <!-- project title and description -->
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><i class="entypo-paper-plane"></i> <?php echo $row['title']; ?></div>
                    <div class="panel-options">

                    </div>
                </div>
                <div class="panel-body" style="min-height:217px;">
                    <div class="scrollable" data-height="188" data-scroll-position="right" data-rail-color="#ccc" data-rail-opacity=".5" data-rail-width="8" data-rail-radius="10" data-autohide="1">
                        <p>
                            <?php echo $row['description']; ?>  
                        </p>
                    </div>
                </div>
            </div>

            <!-- project tasks -->
            <div class="panel panel-primary col-md-6"  style="padding:0px;" >
                <div class="panel-heading">
                    <div class="panel-title"><i class="entypo-doc-text"></i> <?php echo get_phrase('project_task'); ?></div>
                </div>
                <div class="panel-body" style="padding:0px;min-height:248px;">



                    <table class="table table-striped">
                        <tbody>
                            <?php
                            $this->db->order_by('project_task_id', 'desc');
                            $tasks = $this->db->get_where('project_task', array('project_id' => $row['project_id']))->result_array();
                            foreach ($tasks as $row2):
                                ?>
                                <tr>
                                    <td width="5"><i class="entypo-dot"></i></td>
                                    <td style="<?php if ($row2['complete_status'] == 1) echo 'text-decoration:line-through'; ?>"> 
        <?php echo $row2['title']; ?>
                                    </td>
                                </tr>
    <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- project files -->
            <div class="panel panel-primary col-md-5 col-xs-12 pull-right" style="padding:0px;">
                <div class="panel-heading">
                    <div class="panel-title"><i class="entypo-suitcase"></i> <?php echo get_phrase('project_document'); ?></div>
                    <div class="panel-options">
                    </div>
                </div>
                <div class="panel-body" style="padding:0px;min-height:248px;">

                    <button type="button" class="btn btn-default btn-icon icon-left" style="margin:5px; float:right;"
                            onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/project_file_add/<?php echo $row['project_id']; ?>');">
                        <?php echo get_phrase('upload_file'); ?>
                        <i class="entypo-upload"></i>
                    </button>


                    <div style="clear:both;"></div>    
                    <table class="table table-striped">
                        <tbody>
                            <?php
                            $this->db->order_by('project_file_id', 'desc');
                            $tasks = $this->db->get_where('project_file', array('project_id' => $row['project_id']))->result_array();
                            foreach ($tasks as $row2):
                                ?>
                                <tr>
                                    <td width="5"><i class="entypo-dot"></i></td>
                                    <td>
        <?php echo $row2['name']; ?>
                                    </td>
                                    <td width="55">
                                        <a class="tooltip-default" style="color:#aaa;" data-toggle="tooltip" 
                                           data-placement="left" data-original-title="<?php echo get_phrase('view_file'); ?>"
                                           onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/project_file_view/<?php echo $row2['project_file_id']; ?>');">
                                            <i class="entypo-eye"></i>
                                        </a>
                                        <a class="tooltip-default" style="color:#aaa;" data-toggle="tooltip" 
                                           data-placement="left" data-original-title="<?php echo get_phrase('download_file'); ?>"
                                           href="<?php echo base_url(); ?>index.php?client/project_file/download/<?php echo $row2['project_file_id']; ?>">
                                            <i class="entypo-download"></i>
                                        </a>
                                        <!--<a class="tooltip-default" style="color:#aaa;" data-toggle="tooltip" 
                                    data-placement="left" data-original-title="<?php echo get_phrase('delete_file'); ?>"
                                        onclick="confirm_modal('<?php echo base_url(); ?>index.php?client/project_file/delete/<?php echo $row2['project_file_id']; ?>' , '<?php echo base_url(); ?>index.php?client/reload_project_monitor_body/<?php echo $row['project_id']; ?>');">
                                    <i class="entypo-trash"></i>
                                 </a>-->
                                    </td>
                                </tr>
    <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="clear:both;"></div> 

            <!-- project discussion -->
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><i class="entypo-chat"></i> <?php echo get_phrase('project_discussion'); ?></div>
                    <div class="panel-options">

                    </div>
                </div>
                <div class="panel-body" style="min-height:300px;">
                    <div class="scrollable-reverse" data-height="220" data-scroll-position="right" 
                         data-rail-color="#ccc" data-rail-opacity=".5" data-rail-width="8" data-rail-radius="10" 
                         data-autohide="1" scroll-vertical-position="bottom" style="min-height:235px;">

                        <!-- list of messages in discussion-->
                        <?php
                        $messages = $this->db->get_where('project_message', array('project_id' => $row['project_id']))->result_array();
                        foreach ($messages as $row2):
                            ?>
                            <div style="float:left; text-align:center;">
                                <img src="<?php echo $this->crud_model->get_image_url($row2['user_type'], $row2['user_id']); ?>" 
                                     alt="" class="img-circle" height="37">
                                <br>
                                <small style="color:#bbb;"><?php echo $row2['date']; ?></small>
                            </div>
                            <div class="alert alert-default" style="margin-left:60px;">
                                <strong>
        <?php echo $this->db->get_where($row2['user_type'], array($row2['user_type'] . '_id' => $row2['user_id']))->row()->name;
        ?> : 
                                </strong> 

                                <span style="color:#777;"><?php echo $row2['message']; ?></span>

                            </div>
    <?php endforeach; ?>

                    </div>
                    <br>
                    <!-- message submission form -->
    <?php echo form_open('client/project_message/add/' . $row['project_id'], array('class' => 'project-message-add')); ?>
                    <table width="100%" border="0">
                        <tr>
                            <td>
                                <input type="text" name="message" id="message" class="form-control" 
                                       placeholder="<?php echo get_phrase('type_a_message'); ?>.." style="margin:0px 5px;" >
                            </td>
                            <td width="115">
                                <button type="submit" class="btn btn-default btn-icon icon-right" style="margin:5px; float:right;">
    <?php echo get_phrase('send'); ?>
                                    <i class="entypo-right-open-big"></i>
                                </button>
                            </td>
                        </tr>
                    </table>
    <?php echo form_close(); ?>
                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="panel panel-invert" data-collapsed="0"><!-- setting the attribute data-collapsed="1" will collapse the panel -->

                <!-- panel head -->
                <div class="panel-heading">
                    <div class="panel-title"><i class="entypo-target"></i> <?php echo get_phrase('project_overview'); ?></div>

                    <div class="panel-options">

                    </div>
                </div>

                <!-- panel body -->
                <div class="panel-body">

                    <div class="tile-progress tile-primary" style="margin-bottom:0px;">

                        <div class="tile-header" style="padding:0px 0px 20px 0px;">
                            <table width="100%" border="0">
                                <tr>
                                    <td><i class="entypo-dot"></i> <?php echo get_phrase('start'); ?></td>
                                    <td>:</td>
                                    <td><?php echo $row['timestamp_start']; ?></td>
                                </tr>
                                <tr>
                                    <td><i class="entypo-dot"></i> <?php echo get_phrase('end'); ?></td>
                                    <td>:</td>
                                    <td><?php echo $row['timestamp_end']; ?></td>
                                </tr>
                                <tr>
                                    <td><i class="entypo-dot"></i> <?php echo get_phrase('budget'); ?></td>
                                    <td>:</td>
                                    <td><?php echo $row['budget']; ?></td>
                                </tr>
                                <tr>
                                    <td><i class="entypo-dot"></i> <?php echo get_phrase('category'); ?></td>
                                    <td>:</td>
                                    <td>
    <?php echo $this->db->get_where('project_category', array('project_category_id' => $row['project_category_id']))->row()->name;
    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="entypo-dot"></i> <?php echo get_phrase('demo_url'); ?></td>
                                    <td>:</td>
                                    <td><a href="<?php echo $row['demo_url']; ?>" target="_blank"><?php echo $row['demo_url']; ?></a></td>
                                </tr>
                            </table>
                        </div>
                        <div class="tile-progressbar">
                            <span data-fill="<?php echo $row['progress_status']; ?>%" 
                                  style="width: <?php echo $row['progress_status']; ?>%;"></span>
                        </div>

                        <div class="tile-footer" style="text-align:left;padding:10px;">
                            <h4><?php echo $row['progress_status']; ?>% <?php echo get_phrase('completed'); ?></h4>

                        </div>
                    </div>

                </div>

            </div>



            <!-- timer //0 = stopped, 1 = running-->
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="fa fa-refresh <?php if ($row['timer_status'] == 1) echo 'fa-spin'; ?>"></i>
    <?php echo get_phrase('timer'); ?>
                        ( <?php if ($row['timer_status'] == 0) echo get_phrase('stopped');
    else echo get_phrase('running'); ?> )
                    </div>
                    <div class="panel-options">

                    </div>
                </div>
                <div class="panel-body">
                    <center>
                        <h4>
                            <?php
                            if ($row['timer_status'] == 1) { //showing real time amount of time spent
                                $total_hour = intval((strtotime(date("d-m-y H:i:s")) - $row['timer_starting_timestamp'] +
                                        $row['total_time_spent']) / 3600);
                                $total_minute = intval((strtotime(date("d-m-y H:i:s")) - $row['timer_starting_timestamp'] +
                                        $row['total_time_spent']) / 60);
                                $total_second = intval((strtotime(date("d-m-y H:i:s")) - $row['timer_starting_timestamp'] +
                                        $row['total_time_spent']) % 60);
                            } else if ($row['timer_status'] == 0) { //showing db saved time amount of spent
                                $total_hour = intval($row['total_time_spent'] / 3600);
                                $total_minute = intval($row['total_time_spent'] / 60);
                                $total_second = intval($row['total_time_spent'] % 60);
                            }
                            ?>
                            <?php echo $total_hour; ?> <?php echo get_phrase('hours'); ?>,
                            <?php echo $total_minute; ?> <?php echo get_phrase('minutes'); ?>,
    <?php echo $total_second; ?> <?php echo get_phrase('seconds'); ?>
                            <br>
                            <small><?php echo get_phrase('total_spent'); ?></small>
                        </h4>

                    </center>
                </div>
            </div>




            <!-- client-->
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><i class="entypo-user"></i> <?php echo get_phrase('client'); ?></div>
                    <div class="panel-options">

                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    if ($row['client_id'] < 1):
                        ?>
                        <center>
                            <button type="button" class="btn btn-default btn-icon icon-left" style="margin:10px;"
                                    onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/project_edit/<?php echo $row['project_id']; ?>');">
        <?php echo get_phrase('add_client'); ?>
                                <i class="entypo-user-add"></i>
                            </button>
                        </center>
                    <?php endif; ?>
                    <?php
                    if ($row['client_id'] > 0):
                        $client_data = $this->db->get_where('client', array('client_id' => $row['client_id']))->result_array();
                        foreach ($client_data as $row2):
                            ?>
                            <table width="100%" border="0">
                                <tr>
                                    <td rowspan="2" width="60">
                                        <img src="<?php echo $this->crud_model->get_image_url('client', $row2['client_id']); ?>" 
                                             alt="" class="img-circle" width="44">
                                    </td>
                                    <td>
                                        <h4><?php echo $row2['name']; ?></h4>
                                    </td>
                                </tr>

                            </table>
                            <?php
                        endforeach;
                    endif;
                    ?>

                </div>
            </div>


            <!-- staff-->
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><i class="entypo-users"></i> <?php echo get_phrase('assigned_staff'); ?></div>
                    <div class="panel-options">

                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    $staffs = ( explode(',', $row['staffs']));
                    $number_of_staffs = count($staffs) - 1;
                    if ($number_of_staffs < 1):
                        ?>

                        <center>
                            <button type="button" class="btn btn-default btn-icon icon-left" style="margin:10px;"
                                    onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/project_edit/<?php echo $row['project_id']; ?>');">
        <?php echo get_phrase('assign_staff'); ?>
                                <i class="entypo-user-add"></i>
                            </button>
                        </center>
                    <?php endif; ?>
                    <?php
                    if ($number_of_staffs > 0):
                        for ($i = 0; $i < $number_of_staffs; $i++):
                            $staff_data = $this->db->get_where('staff', array('staff_id' => $staffs[$i]))->result_array();
                            foreach ($staff_data as $row2):
                                ?>
                                <table width="100%" border="0">
                                    <tr>
                                        <td rowspan="2" width="60">
                                            <img src="<?php echo $this->crud_model->get_image_url('staff', $row2['staff_id']); ?>" 
                                                 alt="" class="img-circle" width="44">
                                        </td>
                                        <td>
                                            <h4><?php echo $row2['name']; ?></h4>
                                        </td>
                                    </tr>

                                </table>
                                <br>
                                <?php
                            endforeach;
                        endfor;
                    endif;
                    ?>
                    <!--staff list ends here -->
                </div>
            </div>

            <!--finish right bar-->
        </div>
    </div>

    <script src="assets/js/neon-custom-ajax.js"></script>


    <script>
                                $(document).ready(function () {

                                    var options = {
                                        beforeSubmit: validate_project_task_add,
                                        success: show_response_project_task_add,
                                        resetForm: true
                                    };
                                    $('.project-task-add').submit(function () {
                                        $(this).ajaxSubmit(options);
                                        return false;
                                    });
                                });
                                function validate_project_task_add(formData, jqForm, options) {

                                    if (!jqForm[0].title.value)
                                    {
                                        toastr.error("Please enter a task", "Error");
                                        return false;
                                    }
                                }

                                // response after project added
                                function show_response_project_task_add(responseText, statusText, xhr, $form) {
                                    toastr.success("Project task added successfully", "Success");
                                    reload_project_monitor_body();
                                }


                                function reload_project_monitor_body()
                                {
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php?client/reload_project_monitor_body/<?php echo $row['project_id']; ?>',
                                                    success: function (response)
                                                    {
                                                        jQuery('.main_data').html(response);
                                                    }
                                                });
                                            }


                                            /* project message*/

                                            $(document).ready(function () {

                                                var options_message = {
                                                    beforeSubmit: validate_project_message_add,
                                                    success: show_response_project_message_add,
                                                    resetForm: true
                                                };
                                                $('.project-message-add').submit(function () {
                                                    $(this).ajaxSubmit(options_message);
                                                    return false;
                                                });
                                            });
                                            function validate_project_message_add(formData, jqForm, options) {

                                                if (!jqForm[0].message.value)
                                                {
                                                    toastr.error("Please enter a message", "Error");
                                                    return false;
                                                }
                                            }

                                            // response after project added
                                            function show_response_project_message_add(responseText, statusText, xhr, $form) {
                                                //toastr.success("Project message added successfully", "Success");
                                                reload_project_monitor_body();
                                            }




    </script>



    <?php
endforeach;
?>