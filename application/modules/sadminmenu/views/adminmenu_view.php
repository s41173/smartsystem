
<div id="webadmin">

	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<fieldset class="field"> <legend>Add New Admin Menu</legend>
			<form name="admin_form" id="form" class="myform" method="post" action="<?php echo $form_action; ?>" enctype="multipart/form-data">
			
				<ul class="tabs">
					<li><a href="#tab1"> Primary </a></li>
					<li><a href="#tab2"> Secondary </a></li>
				</ul>
				
				<div class="tab_container">
					
					<!-- tab 1 -->
					<div id="tab1" class="tab_content">
						<table>
							
					<tr> <td><span class="label">Name</span></td> <td>:&nbsp;</td> 
						 <td><input type="text" class="required input-large" name="tname" title="Menu name" required /> <br /> </td> </tr>
					
					<tr> <td><span class="label">Parent Item</span></td> <td>:</td> 
					  <td> <?php $js = 'class="", size="10" '; echo form_dropdown('cparent', $query_menu, isset($default['menu']) ? $default['menu'] : '', $js); ?> </td> 
					</tr>
					
				   <tr> <td><span class="label">Modul</span></td> <td>:</td> 
					  <td>  
					 <?php  $js = "class=\"required\", onChange=\"geturl(this.value, 'turl')\" "; 
							echo form_dropdown('cmodul', $query_modul, isset($default['modul']) ? $default['modul'] : '', $js);
					 ?>
					  </td> 
				   </tr>
				   
				   <tr> <td><span class="label">Url</span></td> <td>:</td> 
				        <td> <input type="text" class="required input-large" name="turl" id="turl" title="URL" required /> <br /> </td> </tr>
							
						</table>
					</div>
					<!-- tab 1 -->
					
					<!-- tab 2 -->
					<div id="tab2" class="tab_content">
						
						<table>
				   <tr> <td> <span class="label">Order</span> </td> <td>:&nbsp;</td> 
				        <td> <input type="text" name="tmenuorder" id="tmenuorder" title="Menu Order" onkeyup="checkdigit(this.value, 'tmenuorder')" size="1" class="required" />
				    </td> </tr>
				   
				   <tr> <td><span class="label">Class</span></td> <td>:</td> 
				        <td> <input type="text" class="input-medium" name="tclass" title="Class" /> <br /> </td> </tr>
				   
				   <tr> <td><span class="label">ID</span></td> <td>:</td> 
				        <td> <input type="text" class="input-medium" name="tid" title="ID" /> <br /> </td> </tr>
				   
<tr> <td><span class="label"> Target </span></td> <td>:</td> 
					 <td>
<select name="ctarget" class="required" title="Position">
<option selected="selected" value="_parent" <?php echo set_select('ctarget', '_parent', isset($default['target']) && $default['target'] == '_parent' ? TRUE : FALSE); ?> /> Parent </option>
<option value="_blank" <?php echo set_select('ctarget', '_blank', isset($default['target']) && $default['target'] == '_blank' ? TRUE : FALSE); ?> /> Blank </option>
<option value="_self" <?php echo set_select('ctarget', '_self', isset($default['target']) && $default['target'] == '_self' ? TRUE : FALSE); ?> /> Self </option>
<option value="_top" <?php echo set_select('ctarget', '_top', isset($default['target']) && $default['target'] == '_top' ? TRUE : FALSE); ?> /> Top </option>
</select> <br />   </td>  </tr>
				
				<tr> <td> <span class="label">Change image</span> </td> <td>:</td> <td> 
				<input type="file" title="Upload image" name="userfile" size="25" /> <br /> 
				<?php echo isset($error) ? $error : ''; ?> <small>*) Leave it blank if not upload images.</small> </td> </tr>
				   
				</table>	
						
					</div>
					<!-- tab 2 -->
					
				</div>
		  
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
	 <p class="cek"> <?php echo ! empty($radio1) ? $radio1 : ''; echo ! empty($radio2) ? $radio2 : ''; ?> <input type="submit" name="button" class="button_delete" title="Process Button" value="Delete All" />  </p> 
	</form>	
	
	<!-- links -->
	<div class="buttonplace"> <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?> </div>
</div>
