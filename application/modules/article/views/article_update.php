

<div id="webadmin">

	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div id="errorbox" class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<form name="search_form" class="myform" id="form" method="post" action="<?php echo $form_action; ?>" enctype="multipart/form-data">
		<fieldset class="field"> <legend>Add News </legend>
			<table border="0">
			
			  <tr> <td> <label for="ccategory">Category</label> </td> <td>:</td> 
			  <td> <?php echo form_dropdown('ccategory', $category, isset($default['category']) ? $default['category'] : ''); ?> <br/> </td>  </tr>
			  
			   <tr> <td> <label for="clang"> Language </label> </td> <td>:</td> 
			   <td> <?php echo form_dropdown('clang', $language, isset($default['lang']) ? $default['lang'] : ''); ?> <br/>  </td>  </tr>
			  
			   <tr> <td> <label for="tpermalink">Permalink</label> </td> <td>:</td> 
			   <td>  <input type="text" class="required" name="tpermalink" id="tpermalink" title="News Permalink - max 20 character" size="30" value="<?php echo set_value('tpermalink', isset($default['permalink']) ? $default['permalink'] : ''); ?>" /> <br /> </td></tr>
			  
				<tr> <td> <label for="ttitle">Title</label> </td> <td>:</td> 
				     <td> <input type="text" class="required" name="ttitle" size="45" maxlength="100" onkeyup="setpermalink(this.value)" 
				          value="<?php echo set_value('ttitle', isset($default['title']) ? $default['title'] : ''); ?>" /> <br /> </td></tr>		
							
				<tr> <td> <span class="label"> Date </span></td> <td>:</td> 
				<td> 
					<div id="datetimepicker" class="input-append date">
					  <input type="text" name="tdate" readonly="readonly" class="input-small" 
					  value="<?php echo set_value('tdate', isset($default['date']) ? $default['date'] : ''); ?>"></input>
					  <span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i> </span>
					</div>
				</td> </tr>
				
				<tr> <td> <label for="ccoment">Commented</label> </td> <td>:</td> 
				<td> <input type="checkbox" name="ccoment" title="Tick checkbox if regulated as commented" value="1" <?php echo set_radio('ccoment', '1', isset($default['coment']) && $default['coment'] == '1' ? TRUE : FALSE); ?> />  </td>
				
				<tr> <td> <label for="cfront"> Front Page </label> </td> <td>:</td> 
				<td> <input type="checkbox" name="cfront" title="Tick checkbox if regulated as front" value="1" <?php echo set_radio('cfront', '1', isset($default['front']) && $default['front'] == '1' ? TRUE : FALSE); ?> />  </td>
				
				<tr> <td> <label for="userfile"> Image</label> </td> <td>:</td> <td> 
				<a class="fancy" href="<?php echo isset($default['image']) ? $default['image'] : ''; ?>"> 
				<img alt="" width="250" src="<?php echo set_value('tket', isset($default['image']) ? $default['image'] : ''); ?>" >
				</a>  </td> </tr>
				
						<tr> <td> <label for="userfile"> Change image</label> </td> <td>:</td> <td> <input type="file" title="Upload image" name="userfile" size="35" /> <br /> <?php echo isset($error) ? $error : '';?> <small>*) Leave it blank if not upload images.</small> </td> </tr>
				
			</table>
		</fieldset>
		
		<fieldset class="field"> <legend>News Content</legend>

			<textarea name="tdesc" id="content" > <?php echo isset($desc) ? $desc : ''; ?> </textarea>
		    <?php echo display_ckeditor($ckeditor); ?> <br />
			
			<p>
				<input type="submit" name="submit" class="btn"  value=" Save " />
				<input type="reset" name="reset" class="btn" value=" Cancel " />
			</p>
		</fieldset>
	</form>	
</div>

<script type="text/javascript">
      $('#datetimepicker').datetimepicker({
        format: 'yyyy-MM-dd'
      });
</script>

<div class="buttonplace"> <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?> </div>


<!-- batas -->