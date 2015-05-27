<div class="sidebar-menu">
    <header class="logo-env" >

        <!-- logo -->
        <div class="logo" style="">
            <a href="<?php echo base_url(); ?>">
                <img src="uploads/logo.png?v=12345"  style="max-height:60px;"/>
            </a>
        </div>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse" style="">
            <a href="#" class="sidebar-collapse-icon with-animation">

                <i class="entypo-menu"></i>
            </a>
        </div>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>
    <div class="sidebar-user-info">

        <div class="sui-normal">
            <a href="#" class="user-link">
                <img src="<?php echo $this->crud_model->get_image_url($this->session->userdata('login_type'), $this->session->userdata('login_user_id'));
?>" alt="" class="img-circle" style="height:44px;">

                <span><?php echo get_phrase('welcome'); ?>,</span>
                <strong><?php
                    echo $this->db->get_where($this->session->userdata('login_type'), array($this->session->userdata('login_type') . '_id' =>
                        $this->session->userdata('login_user_id')))->row()->name;
                    ?>
                </strong>
            </a>
        </div>

        <div class="sui-hover inline-links animate-in"><!-- You can remove "inline-links" class to make links appear vertically, class "animate-in" will make A elements animateable when click on user profile -->				
            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/manage_profile">
                <i class="entypo-pencil"></i>
                <?php echo get_phrase('edit_profile'); ?>
            </a>

            <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/manage_profile">
                <i class="entypo-lock"></i>
                <?php echo get_phrase('change_password'); ?>
            </a>

            <span class="close-sui-popup">×</span><!-- this is mandatory -->			
        </div>
    </div>


    <div style="border-top:1px solid rgba(135,135,136,0.2);"></div>	
    <ul id="main-menu" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


        <!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/dashboard">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>

        <!-- PROJECT -->
        <li class="<?php if ($page_name == 'project' || $page_name == 'project_monitor' || $page_name == 'project_add' 
                            || $page_name == 'project_category' || $page_name == 'project_quote')
                            echo 'opened active has-sub';?> ">
            <a href="#">
                <i class="entypo-paper-plane"></i>
                <span><?php echo get_phrase('project'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'project') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/project">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('project_list'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'project_add') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/project_add">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('add_new_project'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'project_category') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/project_category">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('project_category'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'project_quote') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/project_quote">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('project_quote'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- CIENT -->
        <li class="<?php if ($page_name == 'client'|| $page_name == 'pending_client') echo 'opened active has-sub'; ?> ">
            <a href="#">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('client'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'client') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/client">
                        <span><i class="entypo-dot"></i> 
                        <?php echo get_phrase('client_list'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'pending_client') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/pending_client">
                        <span><i class="entypo-dot"></i> 
                        <?php echo get_phrase('pending_client_list'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- LEADS -->
        <li class="<?php if ($page_name == 'lead') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/lead">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('lead'); ?></span>
            </a>
        </li>

        <!-- STAFF -->
        <li class="<?php if ($page_name == 'staff' || $page_name == 'account_role') echo 'opened active has-sub'; ?> ">
            <a href="#" >
                <i class="entypo-user"></i>
                <span><?php echo get_phrase('staff'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'staff') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/staff">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_staffs'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'account_role') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/account_role">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('staff_account_permission'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- PAYMENT -->
        <li class="<?php
        if ($page_name == 'invoice' ||
                $page_name == 'invoice_add' ||
                $page_name == 'expense_income')
            echo 'opened active has-sub';
        ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/invoice">
                <i class="entypo-credit-card"></i>
                <span><?php echo get_phrase('payment'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'invoice_add') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/invoice_add">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('create_invoice'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'invoice') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/invoice">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_client_invoice'); ?></span>
                    </a>
                </li>
                <!--<li class="<?php if ($page_name == 'expense_income') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?admin/expense_income">
                                <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_expense_income'); ?></span>
                        </a>
                </li>-->
            </ul>
        </li>

        <!-- REPORT -->
        <li class="<?php
        if ($page_name == 'report_project' ||
                $page_name == 'report_client' ||
                $page_name == 'report_income_expense')
            echo 'opened active has-sub';
        ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/report">
                <i class="entypo-chart-bar"></i>
                <span><?php echo get_phrase('report'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'report_project') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/report_project">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('project_wise_report'); ?></span>
                    </a>
                </li>
                <!--<li class="<?php if ($page_name == 'report_client') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?admin/report_client">
                                <span><i class="entypo-dot"></i> <?php echo get_phrase('client_wise_report'); ?></span>
                        </a>
                </li>
                <li class="<?php if ($page_name == 'report_income_expense') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?admin/report_income_expense">
                                <span><i class="entypo-dot"></i> <?php echo get_phrase('income_expense_report'); ?></span>
                        </a>
                </li>
                <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?admin/system_settings">
                                <span><i class="entypo-dot"></i> <?php echo get_phrase('system_log'); ?></span>
                        </a>
                </li>-->
            </ul>
        </li>


        <!-- SUPPORT -->
        <li class="<?php
        if ($page_name == 'support_ticket' || $page_name == 'support_ticket_view' || $page_name == 'support_ticket_create')
            echo 'opened active has-sub';
        ?> ">
            <a href="#">
                <i class="entypo-lifebuoy"></i>
                <span><?php echo get_phrase('client_support'); ?></span>
                <?php
                $opened_ticket_query = $this->db->get_where('ticket', array('status' => 'opened'));
                if ($opened_ticket_query->num_rows() > 0):
                    ?>
                                                                                                        <!--<span class="badge badge-secondary">	<?php echo $opened_ticket_query->num_rows(); ?> </span>-->
                <?php endif; ?>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'support_ticket' && $ticket_status == 'opened') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/support_ticket/opened">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('opened_tickets'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'support_ticket' && $ticket_status == 'closed') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/support_ticket/closed">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('closed_tickets'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'support_ticket_create') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/support_ticket_create">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('create_new_ticket'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- MESSAGE -->
        <li class="<?php if ($page_name == 'message') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/message">
                <i class="entypo-mail"></i>
                <span><?php echo get_phrase('message'); ?></span>
            </a>
        </li>

        <!-- NOTE -->
        <li class="<?php if ($page_name == 'note') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/note">
                <i class="entypo-doc-text"></i>
                <span><?php echo get_phrase('note'); ?></span>
            </a>
        </li>

        <!-- SETTINGS -->
        <li class="<?php
        if ($page_name == 'system_settings' ||
                $page_name == 'manage_language' ||
                $page_name == 'email_settings')
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-tools"></i>
                <span><?php echo get_phrase('settings'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/system_settings">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('system_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'email_settings') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/email_settings">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('email_settings'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'manage_language') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/manage_language">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('language_settings'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ACCOUNT -->
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/manage_profile">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('account'); ?></span>
            </a>
        </li>



    </ul>

</div>