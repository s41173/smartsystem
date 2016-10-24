<div id="webadmin">
	
	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div id="errorbox" class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<fieldset class="field"> <legend> Add Language </legend>
	<form name="modul_form" class="myform" id="ajaxform" method="post" action="<?php echo $form_action; ?>">
				<table>
					<tr> 
					<td> <span>Name :</span> <br /> 
					     <input type="text" class="input-medium required" name="tname" size="25" title="Name" /> &nbsp; <br />  
					</td> 
					
					<td> <span> Code :</span> <br /> 
					     <input type="text" class="required" name="tcode" size="5" maxlength="15" title="Code" /> &nbsp; <br /> 
					</td>
					
					<td> <input type="submit" name="submit" class="btn" value=" Save " />  </td>
					</tr>
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

