<div id="webadmin">

	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div id="errorbox" class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<fieldset class="field"> <legend>Add News Category</legend>
	<form name="admin_form" id="ajaxform" class="myform" method="post" action="<?php echo $form_action; ?>">
		<table>
			<tr> 
			<td> <span class="label"> Name </span> </td> <td>: &nbsp;</td> 
			<td>
			    <input type="text" class="required" name="tname" size="35" title="Category name" 
			    value="<?php echo set_value('tname', isset($default['name']) ? $default['name'] : ''); ?>" /> <br />
			</td>
			</tr>
			
			<tr> <td><span class="label"> Parent Category </span> </td> <td>:</td> 
			  <td>  
			    <?php $js = 'size="10", class="required"';  echo form_dropdown('cparent', $category, isset($default['parent']) ? $default['parent'] : '', $js); ?> 
			  </td> 
		   </tr>
		   
		   <tr> <td><span class="label">Description</span></td> <td>:</td> <td> <textarea name="tdesc" title="Product Description" cols="25" rows="2"><?php echo set_value('tdesc', isset($default['desc']) ? $default['desc'] : ''); ?></textarea> <br/> </td> </tr>					
		</table>				  
	<p>
		<input type="submit" name="submit" class="btn" title="Process" value=" Save " />
		<input type="reset" name="reset" class="btn" title="Cancel" value=" Cancel " />
	</p>
  </form>
  </fieldset>  
</div>

<div id="webadmin2">
	
    <form name="search_form" class="myform" method="post" action="<?php echo $form_action_del; ?>">
     <?php echo ! empty($table) ? $table : ''; ?>
	 <div class="paging"> <?php echo ! empty($pagination) ? $pagination : ''; ?> </div>
	 <p class="cek"> &nbsp; <?php echo ! empty($radio1) ? $radio1 : ''.'&nbsp;'; echo ! empty($radio2) ? $radio2 : ''; ?> <input type="submit" name="button" class="button_delete" title="Process Button" value="Delete All" />  </p> 
	</form>	
	
	<!-- links -->
	<div class="buttonplace"> <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?> </div>
</div>
