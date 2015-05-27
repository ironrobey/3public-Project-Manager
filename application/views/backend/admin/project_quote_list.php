<?php $client_id  = $this->session->userdata('login_user_id'); ?>
<div class="row">

    <div class="col-md-12">

        <ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
            <li class="active">
                <a href="#quote_list" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-user"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('quote_list'); ?></span>
                </a>
            </li>
            <li>
                <a href="#archive_list" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-home"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('archive_list'); ?></span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            
            <div class="tab-pane active" id="quote_list">

                <table class="table table-bordered table-striped datatable" id="table-2">
                    <thead>
                        <tr>
                            <th></th>
                            <th><?php echo get_phrase('title');?></th>
                            <th><?php echo get_phrase('client');?></th>
                            <th><?php echo get_phrase('date');?></th>
                            <th><?php echo get_phrase('amount');?></th>
                            <th><?php echo get_phrase('options');?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $count      = 1;
                        $this->db->order_by('quote_id', 'desc');
                        $quotes     = $this->db->get_where('quote', array('status' => 0))->result_array();
                        foreach ($quotes as $row) { ?>   
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td>
                                    <?php $name = $this->db->get_where('client' , array('client_id' => $client_id ))->row()->name;
                                        echo $name;?>
                                </td>
                                <td><?php echo date("d M, Y", $row['timestamp']); ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle " data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                            
                                            <!-- VIEW LINK -->
                                            <li>
                                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/project_quote_view/<?php echo $row['quote_id']; ?>');">
                                                    <i class="entypo-eye"></i>
                                                    <?php echo get_phrase('view_quote'); ?>
                                                </a>
                                            </li>
                                            
                                            <!-- ARCHIVE LINK -->
                                            <li>
                                                <a href="<?php echo base_url();?>index.php?admin/project_quote/archive/<?php echo $row['quote_id']?>">
                                                    <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('archive'); ?>
                                                </a>
                                            </li>
                                            <li class="divider"></li>

                                            <!-- DELETION LINK -->
                                            <li>
                                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?admin/project_quote/delete/<?php echo $row['quote_id']; ?>', '<?php echo base_url(); ?>index.php?admin/reload_project_quote_list');" >
                                                    <i class="entypo-trash"></i>
                                                    <?php echo get_phrase('discard'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>

            <div class="tab-pane" id="archive_list">
                
                <table class="table table-bordered table-striped datatable" id="table-2">
                    <thead>
                        <tr>
                            <th></th>
                            <th><?php echo get_phrase('title');?></th>
                            <th><?php echo get_phrase('description');?></th>
                            <th><?php echo get_phrase('client');?></th>
                            <th><?php echo get_phrase('date');?></th>
                            <th><?php echo get_phrase('amount');?></th>
                            <th><?php echo get_phrase('options');?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        $count      = 1;
                        $this->db->order_by('quote_id', 'desc');
                        $quotes     = $this->db->get_where('quote', array('status' => 1))->result_array();
                        foreach ($quotes as $row) { ?>   
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td>
                                    <?php $name = $this->db->get_where('client' , array('client_id' => $client_id ))->row()->name;
                                        echo $name;?>
                                </td>
                                <td><?php echo date("d M, Y", $row['timestamp']); ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm dropdown-toggle " data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                            
                                            <!-- VIEW LINK -->
                                            <li>
                                                <a href="#" onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/project_quote_view/<?php echo $row['quote_id']; ?>');">
                                                    <i class="entypo-eye"></i>
                                                    <?php echo get_phrase('view_quote'); ?>
                                                </a>
                                            </li>
                                            
                                            <!-- UNARCHIVE LINK -->
                                            <li>
                                                <a href="<?php echo base_url();?>index.php?admin/project_quote/unarchive/<?php echo $row['quote_id']?>">
                                                    <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('unarchive'); ?>
                                                </a>
                                            </li>
                                            <li class="divider"></li>

                                            <!-- DELETION LINK -->
                                            <li>
                                                <a href="#" onclick="confirm_modal('<?php echo base_url(); ?>index.php?admin/project_quote/delete/<?php echo $row['quote_id']; ?>', '<?php echo base_url(); ?>index.php?admin/reload_project_quote_list');" >
                                                    <i class="entypo-trash"></i>
                                                    <?php echo get_phrase('delete'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>

        </div>

    </div>

</div>

<?php for ($count = 1; $count <= 2; $count++) { ?>
    <script type="text/javascript">
        jQuery(window).load(function ()
        {
            var $ = jQuery;

            $("#table-<?php echo $count ?>").dataTable({
                "sPaginationType": "bootstrap",
                "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>"
            });

            $(".dataTables_wrapper select").select2({
                minimumResultsForSearch: -1
            });

            // Highlighted rows
            $("#table-<?php echo $count ?> tbody input[type=checkbox]").each(function (i, el)
            {
                var $this = $(el),
                        $p = $this.closest('tr');

                $(el).on('change', function ()
                {
                    var is_checked = $this.is(':checked');

                    $p[is_checked ? 'addClass' : 'removeClass']('highlight');
                });
            });

            // Replace Checboxes
            $(".pagination a").click(function (ev)
            {
                replaceCheckboxes();
            });
        });
    </script>
<?php } ?>