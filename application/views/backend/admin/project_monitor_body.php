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
            <a href="<?php echo base_url(); ?>index.php?admin/project">
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
                        <p style="text-align:justify;">
                            <?php echo $row['description']; ?>  
                        </p>
                    </div>
                </div>
            </div>

            <!-- project tasks -->
            <div class="panel panel-primary col-md-12"  style="padding:0px;" >
                <div class="panel-heading">
                    <div class="panel-title" style="width:100%;">
                        <i class="entypo-doc-text"></i> 
                        <?php echo get_phrase('project_task'); ?>
                        <a href="#" class="btn btn-default btn-xs pull-right tooltip-primary" data-toggle="tooltip"  data-placement="left"
                                data-placement="top" title="" data-original-title="<?php echo get_phrase('create_new_task'); ?>"
                                onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/project_task_add/<?php echo $row['project_id']; ?>');">
                            <i class="entypo-upload"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-body" style="padding:0px;min-height:346px;">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th width="20"></th>
                                <th><?php echo get_phrase('task_title'); ?></th>
                                <th><?php echo get_phrase('time_allocated'); ?></th>
                                <th><?php echo get_phrase('time_remaining'); ?></th>
                                <th><?php echo get_phrase('option'); ?></th>
                            </tr>
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
                                    <td><?php convert_to_digital_time( $row2['time_allocated'], false ); ?></td>
                                    <td><?php convert_to_digital_time( $row2['time_remaining'], false, true ); ?></td>
                                    <td style="width:140px;">
                                        <?php if( $row2['complete_status'] == 0 ): ?>
                                            <?php if( $row2['timer_status'] == 0 ): ?>
                                                <button type="button" class="btn btn-success btn-xs btn-icon icon-left" onclick="update_timer_status(1,<?php echo $row2['project_task_id']; ?>)">
                                                    Start Timer<i class="entypo-clock"></i>
                                                </button>&nbsp;
                                            <?php else: ?>
                                                <?php if( $row2['timer_started_by'] == $this->session->userdata('login_user_id') && $row2['timer_starter_account_type'] == $this->session->userdata('login_type') ): ?>
                                                    <button type="button" class="btn btn-danger btn-xs btn-icon icon-left" onclick="update_timer_status(0,<?php echo $row2['project_task_id']; ?>)">
                                                        End Timer<i class="entypo-clock"></i>
                                                    </button>&nbsp;
                                                <?php else: ?>
                                                    <span style="font-size: 11px;"><?php echo get_phrase('already_started!'); ?></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <div class="btn-group pull-right">
                                            <button type="button" class="btn btn-default btn-xs dropdown-toggle " data-toggle="dropdown">
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-default pull-right" role="menu"> 
                                                
                                                <!-- EDITING LINK -->
                                                <li>
                                                    <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/project_task_edit/<?php echo $row['project_id']; ?>/<?php echo $row2['project_task_id']; ?>');">
                                                        <i class="entypo-pencil"></i>
                                                        <?php echo get_phrase('edit'); ?>
                                                    </a>
                                                </li>
                                                
                                                <li class="divider"></li>

                                                <!-- delete task -->
                                                <li>
                                                    <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?admin/project_task/delete/<?php echo $row2['project_task_id']; ?>', '<?php echo base_url(); ?>index.php?admin/reload_project_monitor_body/<?php echo $row['project_id']; ?>');">
                                                        <i class="entypo-trash"></i>
                                                        <?php echo get_phrase('delete_task'); ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div> 
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- project calendar -->
            <div class="panel panel-primary col-md-12 col-xs-12" style="padding:0px;">

                <div class="panel-body" style="padding:0px;">
                    <div class="calendar-env">
                        <div class="calendar-body">
                            <div id="project_calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear:both;"></div>

            <!-- project files -->
            <div class="panel panel-primary col-md-5 col-xs-12 pull-left" style="padding:0px;">
                <div class="panel-heading">
                    <div class="panel-title" style="width:100%;">
                        <i class="entypo-suitcase"></i>
                        <?php echo get_phrase('project_document'); ?>
                        <a href="#" class="btn btn-default btn-xs pull-right tooltip-primary" data-toggle="tooltip"  data-placement="left"
                                data-placement="top" title="" data-original-title="<?php echo get_phrase('upload_file'); ?>"
                                onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/project_file_add/<?php echo $row['project_id']; ?>');">
                            <i class="entypo-upload"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-body" style="padding:0px;min-height:306px;">
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
                                    <td width="85">
                                        <a class="tooltip-default" style="color:#aaa;" data-toggle="tooltip" 
                                           data-placement="left" data-original-title="<?php echo get_phrase('view_file'); ?>"
                                           onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/project_file_view/<?php echo $row2['project_file_id']; ?>');">
                                            <i class="entypo-eye"></i>
                                        </a>
                                        <a class="tooltip-default" style="color:#aaa;" data-toggle="tooltip" 
                                           data-placement="left" data-original-title="<?php echo get_phrase('download_file'); ?>"
                                           href="<?php echo base_url(); ?>index.php?admin/project_file/download/<?php echo $row2['project_file_id']; ?>">
                                            <i class="entypo-download"></i>
                                        </a>
                                        <a class="tooltip-default" style="color:#aaa;" data-toggle="tooltip" 
                                           data-placement="left" data-original-title="<?php echo get_phrase('delete_file'); ?>"
                                           onclick="confirm_modal('<?php echo base_url(); ?>index.php?admin/project_file/delete/<?php echo $row2['project_file_id']; ?>', '<?php echo base_url(); ?>index.php?admin/reload_project_monitor_body/<?php echo $row['project_id']; ?>');">
                                            <i class="entypo-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- project discussion -->
            <div class="panel panel-primary col-md-7 col-xs-12 pull-right" data-collapsed="0">
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
                    <?php echo form_open('admin/project_message/add/' . $row['project_id'], array('class' => 'project-message-add')); ?>
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
                        <center>
                            <a class="btn btn-info btn-icon icon-left" style="margin-top:15px;" href="<?php echo base_url(); ?>index.php?admin/project_edit/<?php echo $row['project_id']; ?>"><?php echo get_phrase('edit_this_project'); ?><i class="entypo-pencil"></i>
                            </a>
                        </center>
                    </div>

                </div>

            </div>

            <!-- timer //0 = stopped, 1 = running-->
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="fa fa-refresh"></i>
                        <?php echo get_phrase('timer'); ?>
                    </div>
                    <div class="panel-options">

                    </div>
                </div>
                <div class="panel-body">
                    <center>
                        <h4>
                            <?php convert_to_digital_time( $row['total_time_spent'] ); ?>
                            <br>
                            <small><?php echo get_phrase('total_spent'); ?></small>
                        </h4>
                    </center>
                </div>
            </div>

            <!-- timer //0 = stopped, 1 = running-->
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="fa fa-plus-circle"></i>
                        <?php echo get_phrase('manual_time'); ?>
                    </div>
                    <div class="panel-options">

                    </div>
                </div>
                <div class="panel-body">
                    <center>

                        <a class="btn btn-success btn-icon icon-left" href="<?php echo base_url(); ?>index.php?admin/time_list/<?php echo $row['project_id']; ?>"><?php echo get_phrase('time_list'); ?>
                            <i class="fa fa-list"></i>
                        </a>

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
                            <a class="btn btn-default btn-icon icon-left" style="margin:10px;" href="<?php echo base_url(); ?>index.php?admin/project_edit/<?php echo $row['project_id']; ?>">
                                        <?php echo get_phrase('add_client'); ?>
                                <i class="entypo-user-add"></i>
                            </a>
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
                                <tr>
                                    <td>
                                        <?php if ($row2['skype_id'] != ''): ?>
                                            <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" 
                                               data-original-title="<?php echo get_phrase('call_skype'); ?>"	
                                               href="skype:<?php echo $row2['skype_id']; ?>?chat" style="color:#bbb;">
                                                <i class="entypo-skype"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($row2['email'] != ''): ?>
                                            <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" 
                                               data-original-title="<?php echo get_phrase('send_email'); ?>"	
                                               href="mailto:<?php echo $row2['email']; ?>" style="color:#bbb;">
                                                <i class="entypo-mail"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($row2['phone'] != ''): ?>
                                            <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" 
                                               data-original-title="<?php echo get_phrase('call_phone'); ?>"	
                                               href="tel:<?php echo $row2['phone']; ?>" style="color:#bbb;">
                                                <i class="entypo-phone"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($row2['facebook_profile_link'] != ''): ?>
                                            <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" 
                                               data-original-title="<?php echo get_phrase('facebook_profile'); ?>"	
                                               href="<?php echo $row2['facebook_profile_link']; ?>" style="color:#bbb;" target="_blank">
                                                <i class="entypo-facebook"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($row2['twitter_profile_link'] != ''): ?>
                                            <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" 
                                               data-original-title="<?php echo get_phrase('twitter_profile'); ?>"	
                                               href="<?php echo $row2['twitter_profile_link']; ?>" style="color:#bbb;" target="_blank">
                                                <i class="entypo-twitter"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($row2['linkedin_profile_link'] != ''): ?>
                                            <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" 
                                               data-original-title="<?php echo get_phrase('linkedin_profile'); ?>"	
                                               href="<?php echo $row2['linkedin_profile_link']; ?>" style="color:#bbb;" target="_blank">
                                                <i class="entypo-linkedin"></i>
                                            </a>
                                        <?php endif; ?>

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
                            <a class="btn btn-default btn-icon icon-left" style="margin:10px;" href="<?php echo base_url(); ?>index.php?admin/project_edit/<?php echo $row['project_id']; ?>">
                                        <?php echo get_phrase('assign_staff'); ?>
                                <i class="entypo-user-add"></i>
                            </a>
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
                                    <tr>
                                        <td>
                                            <?php if ($row2['skype_id'] != ''): ?>
                                                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" 
                                                   data-original-title="<?php echo get_phrase('call_skype'); ?>"	
                                                   href="skype:<?php echo $row2['skype_id']; ?>?chat" style="color:#bbb;">
                                                    <i class="entypo-skype"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($row2['email'] != ''): ?>
                                                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" 
                                                   data-original-title="<?php echo get_phrase('send_email'); ?>"	
                                                   href="mailto:<?php echo $row2['email']; ?>" style="color:#bbb;">
                                                    <i class="entypo-mail"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($row2['phone'] != ''): ?>
                                                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" 
                                                   data-original-title="<?php echo get_phrase('call_phone'); ?>"	
                                                   href="tel:<?php echo $row2['phone']; ?>" style="color:#bbb;">
                                                    <i class="entypo-phone"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($row2['facebook_profile_link'] != ''): ?>
                                                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" 
                                                   data-original-title="<?php echo get_phrase('facebook_profile'); ?>"	
                                                   href="<?php echo $row2['facebook_profile_link']; ?>" style="color:#bbb;" target="_blank">
                                                    <i class="entypo-facebook"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($row2['twitter_profile_link'] != ''): ?>
                                                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" 
                                                   data-original-title="<?php echo get_phrase('twitter_profile'); ?>"	
                                                   href="<?php echo $row2['twitter_profile_link']; ?>" style="color:#bbb;" target="_blank">
                                                    <i class="entypo-twitter"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($row2['linkedin_profile_link'] != ''): ?>
                                                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" 
                                                   data-original-title="<?php echo get_phrase('linkedin_profile'); ?>"	
                                                   href="<?php echo $row2['linkedin_profile_link']; ?>" style="color:#bbb;" target="_blank">
                                                    <i class="entypo-linkedin"></i>
                                                </a>
                                            <?php endif; ?>

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

    <!-- custom styling for project calendar -->
    <style>
        h2{font-weight: 200; font-size: 16px;}
        .fc-header-left{padding:4px !important;}
        .fc-header-right{padding:4px !important;}
    </style>


    <script>
        $(document).ready(function () {

            // config for project calendar
            $('#project_calendar').fullCalendar({
                header: {
                    left: 'title',
                    right: 'today prev,next'
                },
                //defaultView: 'basicWeek',

                editable: false,
                firstDay: 1,
                height: 350,
                droppable: false,
                
                events:
                [
                    <?php
                    $tasks = $this->db->get_where('project_task', array('project_id' => $row['project_id']))->result_array();
                    foreach ($tasks as $row):
                    ?>
                        {
                            title   :   "<?php  echo $row['title'];?>",
                            start   :   new Date(<?php echo date('Y', $row['timestamp_start']); ?>, 
                                            <?php echo date('m', $row['timestamp_start']) - 1; ?>, 
                                            <?php echo date('d', $row['timestamp_start']); ?>),
                            end    :   new Date(<?php echo date('Y', $row['timestamp_end']); ?>, 
                                            <?php echo date('m', $row['timestamp_end']) - 1; ?>, 
                                            <?php echo date('d', $row['timestamp_end']); ?>),
                            allDay: true
                        },
                    <?php endforeach ?>
                ]
            });

            // config for project task adding
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
                url: '<?php echo base_url(); ?>index.php?admin/reload_project_monitor_body/<?php echo $row['project_id']; ?>',
                success: function (response)
                {
                    jQuery('.main_data').html(response);
                }
            });
        }

        /* function for updating task status*/
        function update_task_status(complete_status, project_task_id)
        {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?admin/project_task/edit/' + complete_status + '/' + project_task_id,
                success: function (response)
                {
                    toastr.success("Project task updated", "Success");
                    // calling project monitor reload function
                    reload_project_monitor_body();
                }
            });
        }

        /* function for deleting task*/
        function delete_task(project_task_id)
        {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?admin/project_task/delete/' + project_task_id,
                success: function (response)
                {
                    toastr.success("Project task deleted", "Success");
                    // calling project monitor reload function
                    reload_project_monitor_body();
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

        /* function for updating timer status // 0=stopped,1=running*/
        function update_timer_status(timer_status, project_task_id)
        {
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?admin/project_task_timer/edit/' + timer_status + '/' + project_task_id,
                success: function (response)
                {
                    if (timer_status == 1)
                        toastr.success("Project task timer started");
                    if (timer_status == 0)
                        toastr.info("Project task timer stopped");
                    // calling project monitor reload function
                    reload_project_monitor_body();
                }
            });
        }
    </script>

    <script src="assets/js/neon-custom-ajax.js"></script>
    <script src="assets/js/ajax-form-submission.js"></script>

    <?php
endforeach;
?>