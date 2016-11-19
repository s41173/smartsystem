
<div id="webadmin">

	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div id="errorbox" class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<fieldset class="field"> <legend>Add Banner</legend>
	
			<form name="admin_form" id="form" class="myform" method="post" action="<?php echo $form_action; ?>" enctype="multipart/form-data">
				<table>
					<tr> <td> <span class="label"> Name </span> </td> <td>: &nbsp;</td> 
					     <td><input type="text" name="tname" size="30" title="Banner Name" required /> <br /> </td> 
					</tr>
					
					<tr> <td> <span class="label">Position</span></td> <td>:</td> 
					 <td>
<select name="cposition" class="required input-medium" title="Position">
<option value="user1" <?php echo set_select('cposition', 'user1', isset($default['position']) && $default['position'] == 'user1' ? TRUE : FALSE); ?> /> User 1 </option>
<option value="user2" <?php echo set_select('cposition', 'user2', isset($default['position']) && $default['position'] == 'user2' ? TRUE : FALSE); ?> /> User 2 </option>
<option value="user3" <?php echo set_select('cposition', 'user3', isset($default['position']) && $default['position'] == 'user3' ? TRUE : FALSE); ?> /> User 3 </option>
<option value="user4" <?php echo set_select('cposition', 'user4', isset($default['position']) && $default['position'] == 'user4' ? TRUE : FALSE); ?> /> User 4 </option>
<option value="user5" <?php echo set_select('cposition', 'user5', isset($default['position']) && $default['position'] == 'user5' ? TRUE : FALSE); ?> /> User 5 </option>
<option value="user6" <?php echo set_select('cposition', 'user6', isset($default['position']) && $default['position'] == 'user6' ? TRUE : FALSE); ?> /> User 6 </option>
<option value="user7" <?php echo set_select('cposition', 'user7', isset($default['position']) && $default['position'] == 'user7' ? TRUE : FALSE); ?> /> User 7 </option>
<option value="user8" <?php echo set_select('cposition', 'user8', isset($default['position']) && $default['position'] == 'user8' ? TRUE : FALSE); ?> /> User 8 </option>
<option value="user9" <?php echo set_select('cposition', 'user9', isset($default['position']) && $default['position'] == 'user9' ? TRUE : FALSE); ?> /> User 9 </option>
<option value="user10" <?php echo set_select('cposition', 'user10', isset($default['position']) && $default['position'] == 'user10' ? TRUE : FALSE); ?> /> User 10 </option>
<option value="user11" <?php echo set_select('cposition', 'user11', isset($default['position']) && $default['position'] == 'user11' ? TRUE : FALSE); ?> /> User 11 </option>
<option value="user12" <?php echo set_select('cposition', 'user12', isset($default['position']) && $default['position'] == 'user12' ? TRUE : FALSE); ?> /> User 12 </option>
<option value="user13" <?php echo set_select('cposition', 'user13', isset($default['position']) && $default['position'] == 'user13' ? TRUE : FALSE); ?> /> User 13 </option>
<option value="user14" <?php echo set_select('cposition', 'user14', isset($default['position']) && $default['position'] == 'user14' ? TRUE : FALSE); ?> /> User 14 </option>
<option value="user15" <?php echo set_select('cposition', 'user15', isset($default['position']) && $default['position'] == 'user15' ? TRUE : FALSE); ?> /> User 15 </option>
<option value="user16" <?php echo set_select('cposition', 'user16', isset($default['position']) && $default['position'] == 'user16' ? TRUE : FALSE); ?> /> User 16 </option>
<option value="user17" <?php echo set_select('cposition', 'user17', isset($default['position']) && $default['position'] == 'user17' ? TRUE : FALSE); ?> /> User 17 </option>
<option value="user18" <?php echo set_select('cposition', 'user18', isset($default['position']) && $default['position'] == 'user18' ? TRUE : FALSE); ?> /> User 18 </option>
<option value="user19" <?php echo set_select('cposition', 'user19', isset($default['position']) && $default['position'] == 'user19' ? TRUE : FALSE); ?> /> User 19 </option>
<option value="user20" <?php echo set_select('cposition', 'user20', isset($default['position']) && $default['position'] == 'user20' ? TRUE : FALSE); ?> /> User 20 </option>
</select> <br />  
					 </td>  </tr>
					 
					 <tr> <td><span class="label">Url</span></td> <td>:</td> 
	                      <td> <input type="text" class="required input-large" name="turl" id="turl" size="50" title="URL" required /> <br /> </td> 
					 </tr>
					 
					 <tr> <td><span class="label"> Width x Height </span></td> <td>:</td> 
	                      <td> <input type="text" class="input-small" name="twidth" id="tw" title="Width" onkeyup="checkdigit(this.value, 'tw')" required /> X
						       <input type="text" class="input-small" name="theight" id="th" title="Height" onkeyup="checkdigit(this.value, 'th')" required /> <br /> 
						  </td> 
					 </tr>
					 
					<tr> <td> <span class="label">Publish</span> </td> <td>:</td> 
					   <td> Yes <input name="rpublish" class="required" type="radio" title="Y" value="1" />
					        No <input name="rpublish" class="required" type="radio" title="N" value="0" />  <br/> <br/>  
					   </td> 
				    </tr>
					
					<tr> <td><span class="label">Menu</span></td> <td>:</td> 
					<td> <?php $js = 'size="10"'; $array = array('', '');  echo form_dropdown('cmenu[]', $menu, $array, $js, isset($default['menu']) ? $default['menu'] : ''); ?> 
						<br> </td> </tr> 
						
					 <tr> <td> <span class="label"> Image </span> </td> <td>:</td> 
				          <td> <input type="file" class="input-medium" title="Upload image" name="userfile" required /> <br /> <?php echo isset($error) ? $error : '';?> </td> 
					 </tr>	
					
				</table>				  
			<p> <br />
				<input type="submit" name="submit" class="btn" value=" Save " />
				<input type="reset" name="reset" class="btn" value=" Cancel " />
			</p>
		  </form>
	</fieldset>
</div>

<div id="webadmin2">
	
    <form name="search_form" class="myform" method="post" action="<?php echo $form_action_del; ?>">
     <?php echo ! empty($table) ? $table : ''; ?>
	 <div class="paging"> <?php echo ! empty($pagination) ? $pagination : ''; ?> </div>
	</form>	
	
	<!-- links -->
	<div class="buttonplace"> <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?> </div>
</div>



<!-- batas -->

