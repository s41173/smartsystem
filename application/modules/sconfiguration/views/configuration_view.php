
<div id="webadmin">

	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	

<form name="config_form" class="myform" id="form" method="post" action="<?php echo $form_action_add; ?>" enctype="multipart/form-data">
	
		<ul class="tabs">
			<li><a href="#tab1">Primary Details </a></li>
			<li><a href="#tab2">Bank Details</a></li>
			<li><a href="#tab3">Site Configuration</a></li>
		</ul>
		
		 <div class="tab_container">
			<div id="tab1" class="tab_content">
				<fieldset class="field"> <legend>Primary Details</legend>
					<table border="0">
						<tr> <td> <span class="label">Name</span> </td> <td>:&nbsp;</td>
						     <td> <input type="text" class="required" name="tname" title="Name" size="32" maxlength="50" 
							      value="<?php echo set_value('tname', isset($default['name']) ? $default['name'] : ''); ?>" /> </td>
						</tr>
							 
						<tr> <td> <span class="label">Address</span> </td> <td>:</td> <td> 
<textarea class="required" name="taddress" title="Address" cols="25" rows="3"><?php echo set_value('taddress', isset($default['address']) ? $default['address'] : ''); ?>
</textarea> <br /> <?php echo form_error('taddress', '<p class="field_error">', '</p>');?> </td></tr>			

						<tr> <td> <span class="label">City</span> </td> <td>:</td> 
						     <td> <input type="text" title="City" maxlength="25" class="required" name="tcity" size="18"
							 value="<?php echo set_value('tcity', isset($default['city']) ? $default['city'] : ''); ?>" /> <br />  </td> </tr>
						
						<tr> <td> <span class="label">Zip Code</span> </td> <td>:</td> 
						     <td><input type="text" title="Zip Code" maxlength="25" class="required" name="tzip" size="18" value="<?php echo set_value('tzip', isset($default['zip']) ? $default['zip'] : ''); ?>" /> <br />  <?php echo form_error('tzip', '<p class="field_error">', '</p>');?> </td> </tr>
						
						<tr> <td> <span class="label">Phone1</span> </td> <td>:</td> <td> <input type="text" name="tarea1" id="tarea1" title="Area Code" onkeyup="checkdigit(this.value, 'tarea1')" size="3" class="required" value="<?php echo set_value('tarea1', isset($default['area1']) ? $default['area1'] : ''); ?>" />-<input type="text" title="Phone no max 15 character" class="required" name="tphone1" id="tphone1" size="10" maxlength="15" onkeyup="checkdigit(this.value, 'tphone1')" value="<?php echo set_value('tphone1', isset($default['phone1']) ? $default['phone1'] : ''); ?>" /> <br />  <?php echo form_error('tphone1', '<p class="field_error">', '</p>');?> <?php echo form_error('tarea1', '<p class="field_error">', '</p>');?> </td> </tr>
						
						<tr> <td> <span class="label">Phone2</span> </td> <td>:</td> <td> <input type="text" name="tarea2" id="tarea2" title="Area Code" onkeyup="checkdigit(this.value, 'tarea2')" size="3" class="required" value="<?php echo set_value('tarea2', isset($default['area2']) ? $default['area2'] : ''); ?>" />-<input type="text" title="Phone no max 15 character" class="required" name="tphone2" id="tphone2" size="10" maxlength="15" onkeyup="checkdigit(this.value, 'tphone2')" value="<?php echo set_value('tphone2', isset($default['phone2']) ? $default['phone2'] : ''); ?>" /> <br />  <?php echo form_error('tphone2', '<p class="field_error">', '</p>');?> <?php echo form_error('tarea2', '<p class="field_error">', '</p>');?> </td> </tr>
						
						<tr> <td> <span class="label">Email</span></td> <td>:</td> <td><input type="text" class="required email" name="tmail" size="32" title="Type mail" value="<?php echo set_value('tmail', isset($default['mail']) ? $default['mail'] : ''); ?>" /> <br /> <?php echo form_error('tmail', '<p class="field_error">', '</p>');?></td> </tr>	
											
						<tr> <td> <span class="label">Billing Email</span></td> <td>:</td> <td><input type="text" class="required email" name="tbillmail" size="32" title="Type mail" value="<?php echo set_value('tbillmail', isset($default['billingmail']) ? $default['billingmail'] : ''); ?>" /> <br /> <?php echo form_error('tbillmail', '<p class="field_error">', '</p>');?></td> </tr>	
											
						<tr> <td> <span class="label">Technical Email</span></td> <td>:</td> <td><input type="text" class="required email" name="ttechmail" size="32" title="Type mail" value="<?php echo set_value('ttechmail', isset($default['techmail']) ? $default['techmail'] : ''); ?>" /> <br /> <?php echo form_error('ttechmail', '<p class="field_error">', '</p>');?></td> </tr>		
						<tr> <td> <span class="label">CC Email</span></td> <td>:</td> <td><input type="text" class="required email" name="tccmail" size="32" title="Type mail" value="<?php echo set_value('tccmail', isset($default['ccmail']) ? $default['ccmail'] : ''); ?>" /> <br /> <?php echo form_error('tccmail', '<p class="field_error">', '</p>');?></td> </tr>							
					</table>
				</fieldset>
			</div>
			
			<div id="tab2" class="tab_content"> 
				<fieldset class="field"> <legend>Bank Details</legend>
					<table border="0">
						<tr> <td> <span class="label">Account Name</span> </td> <td>:&nbsp;</td> <td> <input type="text" class="form_field" name="taccount_name" title="Account Name" size="32" maxlength="50" value="<?php echo set_value('taccount_name', isset($default['account_name']) ? $default['account_name'] : ''); ?>" /> <br />  <?php echo form_error('taccount_name', '<p class="field_error">', '</p>');?> </td></tr>
						<tr> <td> <span class="label">Account No</span> </td> <td>:</td> <td> <input type="text" class="form_field" name="taccount_no" title="Account No" size="25" maxlength="50" value="<?php echo set_value('taccount_no', isset($default['account_no']) ? $default['account_no'] : ''); ?>" /> <br />  <?php echo form_error('taccount_no', '<p class="field_error">', '</p>');?> </td></tr>
						<tr> <td> <span class="label">Bank Name</span> </td> <td>:</td> <td> <textarea name="tbank" title="Bank Details" cols="25" rows="3"><?php echo set_value('tbank', isset($default['bank']) ? $default['bank'] : ''); ?></textarea> <br /> <?php echo form_error('tbank', '<p class="field_error">', '</p>');?> </td></tr>			
					</table>
				</fieldset>
			</div>
		  </div>	
		  
		  <div id="tab3" class="tab_content"> 
				<fieldset class="field"> <legend>Site Configuration</legend>
					<table border="0">
						<tr> <td> <span class="label"> Site Name </span> </td> <td>:</td> <td> <input type="text" class="form_field" name="tsitename" title="Site Name" size="74" maxlength="100" value="<?php echo set_value('tsitename', isset($default['sitename']) ? $default['sitename'] : ''); ?>" /> <br />  <?php echo form_error('tsitename', '<p class="field_error">', '</p>');?> </td></tr>
						
						<tr> <td> <span class="label"> Site Meta Description </span> </td> <td>:</td> <td> 
						<textarea name="tmetadesc" title="Meta Description" cols="55" rows="5"><?php echo set_value('tmetadesc', isset($default['metadesc']) ? $default['metadesc'] : ''); ?></textarea> <br /> <?php echo form_error('tmetadesc', '<p class="field_error">', '</p>');?> </td></tr>			
						<tr> <td> <span class="label"> Site Meta Keywords </span> </td> <td>:</td> 
						     <td> <textarea name="tmetakey" title="Meta Keyword" cols="55" rows="5"><?php echo set_value('tmetakey', isset($default['metakey']) ? $default['metakey'] : ''); ?></textarea> <br /> <?php echo form_error('tmetakey', '<p class="field_error">', '</p>');?> </td></tr>			
						<tr> <td><span class="label">Image</span> </td> <td>:</td> <td> <img width="250" height="170" src="<?php echo set_value('tket', isset($default['image']) ? $default['image'] : ''); ?>" title="<?php echo set_value('tket', isset($default['image']) ? $default['image'] : ''); ?>"> </td> </tr>
						
					<tr> <td> <span class="label">Change image</span> </td> <td>:</td> <td> <input type="file" title="Upload image" name="userfile" size="50" /> <br /> 
					<?php echo isset($error) ? $error : ''; ?> <small>*) Leave it blank if not upload images.</small> </td> </tr>
						
					</table>
				</fieldset>
				
				<p>
				<input type="submit" name="submit" class="btn" value="Save" />  
				<input type="reset" name="reset" class="btn" value=" Cancel " />
			    </p>
				
			</div>
			
		  </div> 

</form>
</div>

<!-- links -->
<div class="buttonplace"> <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?> </div>
