<div id="webadmin">
	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<fieldset class="field"> <legend>Search Log</legend>
	
			<form name="log_form" class="myform" method="post" action="<?php echo $form_action; ?>">
				<table>
					<tr>
						<td> 
							<span> Period Date : </span> <br />
							<div id="datetimepicker" class="input-append date">
							  <input type="text" name="tstart" readonly="readonly" class="input-small"></input>
							  <span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i> </span>
							</div>
						</td>
						
						<td> &nbsp;
						   <input type="submit" name="submit" class="btn" value="Search" />
						   <input type="submit" name="submit" class="btn" value="Delete" />
						   <input type="reset" name="submit" class="btn" value="Clear" />
						</td>
					</tr>
				</table>
		  </form>
		  
	</fieldset>
</div>

<div id="webadmin2">
	
    <?php echo ! empty($table) ? $table : ''; ?>
	<div class="paging"> <?php echo ! empty($pagination) ? $pagination : ''; ?> </div>
	
	<!-- links -->
	<div class="buttonplace"> <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?> </div>
</div>

<script type="text/javascript">
      $('#datetimepicker').datetimepicker({
        format: 'yyyy-MM-dd'
      });
</script>