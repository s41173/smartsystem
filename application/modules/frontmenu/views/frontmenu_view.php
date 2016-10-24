<style>
	#bnews{ border:1px solid #CCC; padding:2px; margin:3px; font-size:11px;}
	#bnewsplace{ margin:3px 0 3px 0;}
</style>

<div id="webadmin">
	
	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<fieldset class="field"> <legend>Add New Front Menu</legend>
			
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
					     <td><input type="text" class="required input-large" name="tname" size="35" title="Category name" required/> <br /> </td> </tr>
					
					<tr><td> <span class="label">Type</span> </td> <td>:</td> 
<td> <select name="ctype" id="ctypefront" class="required input-medium" size="5" title="Type"> 
<option value="modul" <?php echo set_select('ctype', 'modul', isset($default['type']) && $default['type'] == 'modul' ? TRUE : FALSE); ?> >modul</option> 
<option value="article" <?php echo set_select('ctype', 'article', isset($default['type']) && $default['type'] == 'article' ? TRUE : FALSE); ?> >article</option> 
<option value="articlelist" <?php echo set_select('ctype', 'articlelist', isset($default['type']) && $default['type'] == 'articlelist' ? TRUE : FALSE); ?> >article list</option> 
<option value="url" <?php echo set_select('ctype', 'url', isset($default['type']) && $default['type'] == 'url' ? TRUE : FALSE); ?> >url</option> 
</select>  </td> </tr>
					
					<tr> <td> <span class="label"> Value </span> </td> <td>:</td> <td> <div id="valueplace"></div> <div id="bnewsplace"> <?php echo $tombol; ?> </div> </td> </tr>
					
					<tr> <td> <span class="label"> Position </span> </td> <td>:</td> 
						 <td> 
				<input name="rposition" type="radio" class="required" title="Menu Position"  value="top" <?php echo set_radio('rposition', 'top',    isset($default['position']) && $default['position'] == 'top' ? TRUE : FALSE); ?> /> Top <br/>
				<input name="rposition" type="radio" class="required" title="Menu Position"  value="middle" <?php echo set_radio('rposition', 'middle', isset($default['position']) && $default['position'] == 'middle' ? TRUE : FALSE); ?> /> Middle <br/>
				<input name="rposition" class="required" type="radio" title="Menu Position"  value="bottom" <?php echo set_radio('rposition', 'bottom', isset($default['position']) && $default['position'] == 'bottom' ? TRUE : FALSE); ?> /> Bottom <br/> <br/>
						</td>  </tr>
					
			<tr> <td><span class="label">Parent Item</span></td> <td>:</td> 
	    	  <td> <?php $js = 'class="required input-medium", size="10" '; 
			             echo form_dropdown('cparent', $query_menu, isset($default['parent']) ? $default['parent'] : '', $js); 
				   ?> </td> 
 			</tr>
					
					
				   <tr> <td><span class="label">Url</span></td> <td>:</td> 
	                    <td> <input type="text" class="required input-large" name="turl" id="turl" size="50" title="URL" required /> <br /> </td> </tr>
						</table>
						
					</div>
					<!-- tab 1 -->
					
					<!-- tab2 -->
					<div id="tab2" class="tab_content">
					
						<table>
				   <tr> <td> <span class="label">Order</span> </td> <td>:</td> <td> 
				   <input class="required input-small" type="text" name="tmenuorder" id="tmenuorder" title="Menu Order" onkeyup="checkdigit(this.value, 'tmenuorder')" size="1" />                   <br /> </td> </tr>
				   
				<tr> <td><span class="label"> Limit </span></td> <td>:</td> 
				<td> <input type="text" class="required input-small" name="tlimit" id="tlimit" size="2" maxlength="3" onkeyup="checkdigit(this.value, 'tlimit')" /> 
				<br />  </td>  </tr>
				   
				   <tr> <td><span class="label">Class</span></td> <td>:</td> 
				        <td><input type="text" class="input-small" name="tclass" size="10" title="Class" /> <br /> </td> </tr>
				   
				   <tr> <td><span class="label">ID</span></td> <td>:</td> 
				        <td><input type="text" class="input-small" name="tid" size="10" title="ID" /> <br /> </td> </tr>
				   
				   <tr> <td><span class="label"> Target </span></td> <td>:</td> 
					 <td>
<select name="ctarget" class="required" title="Position">
<option selected="selected" value="_parent" <?php echo set_select('ctarget', '_parent', isset($default['target']) && $default['target'] == '_parent' ? TRUE : FALSE); ?> /> Parent </option>
<option value="_blank" <?php echo set_select('ctarget', '_blank', isset($default['target']) && $default['target'] == '_blank' ? TRUE : FALSE); ?> /> Blank </option>
<option value="_self" <?php echo set_select('ctarget', '_self', isset($default['target']) && $default['target'] == '_self' ? TRUE : FALSE); ?> /> Self </option>
<option value="_top" <?php echo set_select('ctarget', '_top', isset($default['target']) && $default['target'] == '_top' ? TRUE : FALSE); ?> /> Top </option>
</select> <br />   </td>  </tr>
				   
				 <tr> <td> <span class="label"> Image </span> </td> <td>:</td> <td> 
				<input type="file" title="Upload image" name="userfile" size="35" /> <br /> 
				<?php echo isset($error) ? $error : ''; ?> <small>*) Leave it blank if not upload images.</small> </td> </tr>
				   
				</table>			
						
					</div>
					<!-- tab2 -->
					
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
