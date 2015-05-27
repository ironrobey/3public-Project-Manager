<?php 
$row = $this->db->get_where('project' , array('project_id' => $param))->row();
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('project_form');?>
            	</div>
            </div>
			<div class="panel-body">

				<?php echo form_open('admin/project/edit/'.$row->project_id , array('class' => 'form-horizontal form-groups-bordered validate project-edit', 'enctype' => 'multipart/form-data'));?>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('project_title');?></label>
                        
						<div class="col-sm-8">
							<input type="text" class="form-control" name="title" id="title" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="<?php echo $row->title;?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('description');?></label>
                        
						<div class="col-sm-8">
							<textarea class="form-control wysihtml5" rows="10" name="description" id="post_content" 
                            data-stylesheet-url="assets/css/wysihtml5-color.css"><?php echo $row->description;?></textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('category');?></label>
                        
						<div class="col-sm-5">
                     		<select name="project_category_id" class="form-control">
                            <option><?php echo get_phrase('select_a_category');?></option>
                            <?php 
                                $categories		=	$this->db->get('project_category')->result_array();
                                foreach ($categories as $row2):
                                ?>
                                <option value="<?php echo $row2['project_category_id'];?>"
                                		<?php if($row->project_category_id==$row2['project_category_id'])echo 'selected';?>>
                                        <?php echo $row2['name'];?></option>
                            <?php endforeach;?>
                         </select>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('budget');?></label>
                        
						<div class="col-sm-5">
                        	<div class="input-group">
								<span class="input-group-addon"><i class="entypo-bookmarks"></i></span>
								<input type="text" class="form-control" name="budget" value="<?php echo $row->budget; ?>" >
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('start_time');?></label>
                        
						<div class="col-sm-5">
                      		<div class="input-group">
								<span class="input-group-addon"><i class="entypo-calendar"></i></span>
								<input type="text" class="form-control datepicker" name="timestamp_start" value="<?php echo $row->timestamp_start;?>" >
                        	</div>
						</div>
					</div>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('ending_time');?></label>
                        
						<div class="col-sm-5">
                      		<div class="input-group">
								<span class="input-group-addon"><i class="entypo-calendar"></i></span>
								<input type="text" class="form-control datepicker" name="timestamp_end"  value="<?php echo $row->timestamp_end;?>" >
                        	</div>
						</div>
					</div>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('demo_url');?></label>
                        
						<div class="col-sm-5">
                      		<div class="input-group">
								<span class="input-group-addon"><i class="entypo-globe"></i></span>
								<input type="text" class="form-control" name="demo_url"  value="<?php echo $row->demo_url;?>" >
                        	</div>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('progress_status');?></label>
                        
						<div class="col-sm-5" style="padding-top:9px;">
                      	<div class="slider2 slider slider-blue" data-prefix="" data-postfix="%" data-min="-1" data-max="101" data-value="<?php echo $row->progress_status;?>"></div>
                             <input type="hidden" name="progress_status" id="progress_status" value="<?php echo $row->progress_status;?>" >
						</div>
					</div>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('client');?></label>
                        
						<div class="col-sm-5">
                      	<select name="client_id" class="form-control">
                            <option value=""><?php echo get_phrase('select_a_client');?></option>
                            <?php 
                                $clients		=	$this->db->get('client')->result_array();
                                foreach ($clients as $row2):
                                ?>
                                <option value="<?php echo $row2['client_id'];?>"
                                		<?php if ($row->client_id == $row2['client_id']) echo 'selected';?>>
                                        <?php echo $row2['name'];?></option>
                            <?php endforeach;?>
                         </select>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('assign_staff');?></label>
                        
						<div class="col-sm-8">
                        	<select multiple="multiple" name="staffs[]" class="form-control multi-select">
                            <?php 
									$staffs		=	$this->db->get('staff')->result_array();
									foreach ($staffs as $row2):
									?>
									<option value="<?php echo $row2['staff_id'];?>"
                                    <?php if (in_array($row2['staff_id'] , explode(',' , $row->staffs) ) ) echo 'selected';?>>
										<?php echo $row2['name'];?></option>
								<?php endforeach;?>
                        	</select>
						</div>
					</div>

                  	<div class="form-group">
						<div class="col-sm-offset-3 col-sm-8">
							<button type="submit" class="btn btn-info" id="submit-button"><?php echo get_phrase('update_project');?></button>
                    	    <span id="preloader-form"></span>
						</div>
					</div>

				<?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function() { 
	
		var options = { 
			beforeSubmit		:	validate_project_edit,  
			success				:	show_response_project_edit,  
			resetForm			:	true 
		}; 
		$('.project-edit').submit(function() { 
			$(this).ajaxSubmit(options); 
			return false; 
		}); 
	}); 
	function validate_project_edit(formData, jqForm, options) { 
		
		if (!jqForm[0].title.value)
		{
				return false;
		}
		$('#preloader-form').html('<img src="assets/images/preloader.gif" style="height:15px;margin-left:20px;" />');
		document.getElementById("submit-button").disabled=true;
	}
	
	function show_response_project_edit(responseText, statusText, xhr, $form)  { 
			
		window.location.href="<?php echo base_url();?>index.php?admin/project_monitor/<?php echo $param;?>";

	}
	
</script>
<!--<script src="assets/js/neon-custom-ajax.js"></script>
<script src="assets/js/ajax-form-submission.js"></script>-->
