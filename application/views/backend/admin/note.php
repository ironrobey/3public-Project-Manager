<div class="notes-env">

	<div class="notes-header">
		<h2>
        	<?php echo form_open('admin/note/save', 
					array('class' => 'form-horizontal form-groups-bordered validate note-save', 
							'enctype' => 'multipart/form-data'));?>
                            
               <input type="hidden" name="note" id="notes_to_save" value="">
               <button type="submit" class="btn btn-primary btn-icon icon-left" onClick="save_note()"
               	id="submit-button" disabled>
                    <i class="entypo-floppy"></i>
                    <?php echo get_phrase('save_notes');?>
               </button>
               <span id="preloader-form"></span>
           <?php echo form_close();?>
       </h2>
		
		<div class="right">
			<a class="btn btn-default btn-icon icon-left" id="add-note" style="margin:5px 0px;">
				<i class="entypo-pencil"></i>
				<?php echo get_phrase('create_note');?>
			</a>
		</div>
	</div>
	
	
	<div class="notes-list">
	
		<?php //echo $this->db->get_where('note' , array('note_id'=>'1'))->row()->note;?>
		<ul class="list-of-notes">
		
			<?php echo $this->db->get_where('note' , array('note_id'=>'1'))->row()->note;?>
			
			<!-- this will be automatically hidden when there are notes in the list -->
			<li class="no-notes">
				There are no notes yet!
			</li>
		</ul>
		
		<div class="write-pad">
        	
			<textarea class="form-control autogrow" onKeyUp="ready_to_save_note()"></textarea>
		</div>
		
	</div>
</div>

<script>
	$(document).ready(function() { 
	
		var options = { 
			beforeSubmit		:	validate_note,  
			success				:	show_response_note_save,  
			resetForm			:	true 
		}; 
		$('.note-save').submit(function() { 
			$(this).ajaxSubmit(options); 
			return false; 
		}); 
	}); 
	function validate_note(formData, jqForm, options) { 
		
		
		$('#preloader-form').html('<img src="assets/images/preloader.gif" style="height:15px;margin-left:20px;" />');
		document.getElementById("submit-button").disabled=true;
		//return false;
	}
	
	function show_response_note_save(responseText, statusText, xhr, $form)  { 
		
		$('#preloader-form').html('');
		toastr.success("Notes Saved!", "Success");
		//document.getElementById("submit-button").disabled=false;
		
	}
	
	function ready_to_save_note()
	{
		document.getElementById("submit-button").disabled=false;
		document.getElementById("notes_to_save").value = $('.list-of-notes').html();
		//$('.note-save').submit();
	}
</script>