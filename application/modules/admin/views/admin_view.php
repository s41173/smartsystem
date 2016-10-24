<div id="webadmin">
	
	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div id="errorbox" class="errorbox"> <?php echo validation_errors(); ?> </div>
	
<form name="admin_form" id="ajaxform" class="myform" method="post" action="<?php echo $form_action; ?>">

		<ul class="tabs">
			<li><a href="#tab1"> Main Details </a></li>
			<li><a href="#tab2"> Login Area</a></li>
		</ul>
		
		  <div class="tab_container">
			<div id="tab1" class="tab_content">
				<fieldset class="field">
					<table border="0">
					
						<tr> <td> <span class="label"> Name </span> </td> <td>: &nbsp;</td> 
						<td> <input type="text" class="input-large" name="tname" title="Name" maxlength="50" required /> <br />  </td></tr>
						
						<tr> <td> <span class="label">Address</label> </td> <td>:</td> 
						<td> <textarea name="taddress" class="input-large" title="Address" cols="45" rows="3" required ><?php echo set_value('taddress', isset($default['address']) ? $default['address'] : ''); ?></textarea> <br /> </td></tr>	
								
						<tr> <td> <span class="label">Phone</span> </td> <td>:</td> 
						<td> <input type="text" class="input-medium" name="tphone" id="tphone" size="15" maxlength="15" /> <br />  </td> </tr>
						
						<tr> <td> <span class="label">City</span> </td> <td>:</td> 
						<td> <?php $js = 'class="input-medium"'; echo form_dropdown('ccity', $city, isset($default['city']) ? $default['city'] : '', $js); ?> <br/> </td> </tr>
						
						<tr> <td> <span class="label">Email</span></td> <td>:</td> 
						     <td><input type="email" class="input-large" name="tmail" title="Type mail" /> <br /> </td> </tr>
						
						<tr> <td> <span class="label"> Yahoo Id </span></td> <td>:</td> 
						<td><input type="text" class="input-small" name="tid" title="Type id" /> <br /> </td> </tr>
						
					</table>
				</fieldset>
			</div>
			
			<div id="tab2" class="tab_content"> 
				<fieldset class="field"> 
					<table border="0">
					
						<tr> <td><span class="label">Username</span></td> <td>: &nbsp;</td> 
						     <td><input type="text" class="input-medium" name="tusername" title="Username" required /> <br />  </td>  </tr>
						
					    <tr> <td><span class="label">Password</span></td> <td>:</td> 
						     <td> <input type="password" class="input-medium" name="tpassword" size="25" title="Password" required /> <br /> </td> </tr>
						
						<tr> <td><span class="label">Role</span></td> <td>:</td> 
						<td>  <?php $js = 'class="input-medium"'; echo form_dropdown('crole', $roles, isset($default['role']) ? $default['role'] : '', $js); ?> <br/> </td> </tr>
						
					    <tr> <td> <span class="label"> Status </span> </td> <td>:</td> 
						     <td> TRUE <input name="rstatus" class="required" type="radio" value="1" /> 
							      FALSE <input name="rstatus" class="required" type="radio" value="0" />  
						  <br/> </td> </tr>
						  
						<tr> <td> <br /> <input type="submit" name="submit" class="btn" value="Save" /> 
						          <input type="reset" name="reset" class="btn" value=" Cancel " /> </td> </tr>
					</table>
				</fieldset>
			</div>
		  </div>	
	</form>
</div>

<div id="webadmin2">
	
    <?php echo ! empty($table) ? $table : ''; ?>
	<div class="paging"> <?php echo ! empty($pagination) ? $pagination : ''; ?> </div>
	
	<!-- links -->
	<div class="buttonplace"> <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?> </div>
</div>

