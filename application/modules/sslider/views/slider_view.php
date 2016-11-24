<div id="webadmin">
	
	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div id="errorbox" class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<fieldset class="field"> <legend> Image Slider </legend>
	<form name="modul_form" class="myform" id="form" method="post" action="<?php echo $form_action; ?>" enctype="multipart/form-data">
				<table>
				
					<tr> <td> Name </td> <td>:&nbsp;</td>  <td> <input class="input-medium" type="text" name="tname" title="Name" required /> &nbsp;  </td> </tr>
					<tr> <td> Url </td> <td>:&nbsp;</td>  <td> <input class="input-large" type="text" name="turl" title="Url" required /> &nbsp;  </td> </tr>
					
					<tr> <td> Image </td> <td>:</td> 
				         <td> <input type="file" class="input-medium" title="Upload image" name="userfile"  /> <br /> <?php echo isset($error) ? $error : '';?> </td>
					 </tr>
					
					
					<tr> <td colspan="3"> <br /> <input type="submit" name="submit" class="btn" value=" Save " /> 
					     <input type="reset" name="reset" class="btn" value=" Cancel " /> 
					</td> </tr>
					 
				</table>	
			</form>			  
	</fieldset>
</div>


<div id="webadmin2">
	
	<form name="search_form" class="myform" method="post" action="<?php echo ! empty($form_action_del) ? $form_action_del : ''; ?>">
     <?php echo ! empty($table) ? $table : ''; ?>
	 <div class="paging"> <?php echo ! empty($pagination) ? $pagination : ''; ?> </div>
	</form>	
		
	<!-- links -->
	<div class="buttonplace"> <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?> </div>
</div>

