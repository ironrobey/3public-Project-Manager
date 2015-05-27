
<?php echo form_open('admin/system_settings/do_update' , 
			array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
    <div class="row">
        <div class="col-md-12">
            
            <div class="panel panel-primary" >
            
                <div class="panel-heading">
                    <div class="panel-title">
                        <?php echo get_phrase('system_settings');?>
                    </div>
                </div>
                
                <div class="panel-body">
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('system_name');?></label>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" name="system_name" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'system_name'))->row()->description;?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('system_title');?></label>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" name="system_title" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'system_title'))->row()->description;?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" name="address" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'address'))->row()->description;?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" name="phone" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'phone'))->row()->description;?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('paypal_email');?></label>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" name="paypal_email" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'paypal_email'))->row()->description;?>">
                      </div>
                  </div>
                  
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('currency');?></label>
                      <div class="col-sm-5">
                          <select name="system_currency_id" class="selectboxit">
                              <?php
                              $system_currency_id = $this->db->get_where('settings' , array('type' =>'system_currency_id'))->row()->description;
                              $currencies  =  $this->db->get('currency')->result_array();
                              foreach ($currencies as $row2):
                                ?>
                                  <option value="<?php echo $row2['currency_id'];?>" 
                                    <?php if ($row2['currency_id'] == $system_currency_id)echo 'selected';?> >
                                      <?php echo $row2['currency_name'].' ('.$row2['currency_code'].')';?>
                                        </option>
                              <?php endforeach;?>
                          </select>
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('system_email');?></label>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" name="system_email" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'system_email'))->row()->description;?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('buyer');?></label>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" name="buyer" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'buyer'))->row()->description;?>" 
                              	data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('purchase_code');?></label>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" name="purchase_code" 
                              value="<?php echo $this->db->get_where('settings' , array('type' =>'purchase_code'))->row()->description;?>"
                              	data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('language');?></label>
                      <div class="col-sm-5">
                          <select name="language" class="selectboxit">
                                    <?php
										$fields = $this->db->list_fields('language');
										foreach ($fields as $field)
										{
											if ($field == 'phrase_id' || $field == 'phrase')continue;
											
											$current_default_language	=	$this->db->get_where('settings' , array('type'=>'language'))->row()->description;
											?>
                                    		<option value="<?php echo $field;?>"
                                            	<?php if ($current_default_language == $field)echo 'selected';?>> <?php echo $field;?> </option>
                                            <?php
										}
										?>
                           </select>
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('text_align');?></label>
                      <div class="col-sm-5">
                          <select name="text_align" class="selectboxit">
                              <?php $text_align = $this->db->get_where('settings' , array('type'=>'text_align'))->row()->description;?>
                              <option value="left-to-right" <?php if ($text_align == 'left-to-right')echo 'selected';?>> left-to-right (LTR)</option>
                              <option value="right-to-left" <?php if ($text_align == 'right-to-left')echo 'selected';?>> right-to-left (RTL)</option>
                          </select>
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('theme');?></label>
                      <div class="col-sm-5">
                          <select name="theme" class="selectboxit">
                              <?php $theme = $this->db->get_where('settings' , array('type'=>'theme'))->row()->description;?>
                              <option value="dark" <?php if ($theme == 'dark')echo 'selected';?>> dark</option>
                              <option value="light" <?php if ($theme == 'light')echo 'selected';?>> light</option>
                          </select>
                      </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-info"><?php echo get_phrase('save');?></button>
                    </div>
                  </div>
                    
                </div>
            
            </div>
        
        </div>
    </div>
	
				
</form>