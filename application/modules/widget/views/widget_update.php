<style type="text/css">@import url("<?php echo base_url() . 'css/style.css'; ?>");</style>
<style type="text/css">@import url("<?php echo base_url() . 'development-bundle/themes/base/ui.all.css'; ?>");</style>
<style type="text/css">@import url("<?php echo base_url() . 'css/jquery.fancybox-1.3.4.css'; ?>");</style>

<script type="text/javascript" src="<?php echo base_url();?>js/register.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/datetimepicker_css.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/development-bundle/ui/ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.tools.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/hoverIntent.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url();?> js/complete.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/sortir.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/validate.js"></script> 
<script type='text/javascript' src='<?php echo base_url();?>js/jquery.validate.js'></script>  

<script type="text/javascript">
var uri = "<?php echo site_url('ajax')."/"; ?>";
var baseuri = "<?php echo base_url(); ?>";
</script>


<div id="webadmin">
	
	<div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
	<p class="message"> <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?> </p>
	
	<div id="errorbox" class="errorbox"> <?php echo validation_errors(); ?> </div>
	
	<fieldset class="field"> <legend>Add New Widget</legend>
			<form name="modul_form" class="myform" id="form" method="post" action="<?php echo $form_action; ?>">
				<table>
					<tr> <td><label for="tname"> Name </label></td> <td>:</td> <td><input type="text" class="required" name="tname" size="30" title="Type Widget Name" value="<?php echo set_value('tname', isset($default['name']) ? $default['name'] : ''); ?>" /> <br />  </td>  </tr>
					
					<tr> <td><label for="ttitle"> Title </label></td> <td>:</td> <td><input type="text" class="required" name="ttitle" size="40" title="Type Widget Title" value="<?php echo set_value('ttitle', isset($default['title']) ? $default['title'] : ''); ?>" /> <br /> </td>  </tr>
					
					<tr> <td><label for="cposition">Position</label></td> <td>:</td> 
					 <td>
						  <select name="cposition" class="required" title="Position">
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
</select> <br /> </td>  </tr>
					 
					 <tr> <td> <label for="tmenuorder">Order</label> </td> <td>:</td> <td> <input type="text" name="tmenuorder" id="tmenuorder" title="Widget Order" onkeyup="checkdigit(this.value, 'tmenuorder')" size="1" class="required" value="<?php echo set_value('tmenuorder', isset($default['menuorder']) ? $default['menuorder'] : ''); ?>" /> 
					 <br /> </td> </tr>
					
					<tr> <td> <label for="rpublish">Publish</label> </td> <td>:</td> 
<td> Yes <input name="rpublish" class="required" type="radio" title="Y" value="1" <?php echo set_radio('rpublish', '1', isset($default['publish']) && $default['publish'] == '1' ? TRUE : FALSE); ?> />
No <input name="rpublish" class="required" type="radio" title="N" value="0" <?php echo set_radio('rpublish', '0', isset($default['publish']) && $default['publish'] == '0' ? TRUE : FALSE); ?> />  <br/> 
					   </td> 
				    </tr>
					
<tr> <td><label for="cmenu">Menu</label></td> <td>:</td> <td> <?php $js="size='10', class='required'"; echo form_dropdown('cmenu[]', $menu, $valuemenu, $js); ?> <br/>  </td> </tr> 
				   
<tr> <td> <label for="cmore"> Readmore </label> </td> <td>:</td> <td> <?php echo form_dropdown('cmore', $menu, isset($default['more']) ? $default['more'] : ''); ?>  <br/> 
</td> </tr>
					 
<tr> <td> <label for="tlimit"> Limit </label> </td> <td>:</td> <td> <input type="text" name="tlimit" id="tlimit" title="Widget Limit" onkeyup="checkdigit(this.value, 'tlimit')" size="1" class="required" value="<?php echo set_value('tlimit', isset($default['limit']) ? $default['limit'] : ''); ?>" /> <br /> </td> </tr>
					
				</table>				  
			<p>
				<input type="submit" name="submit" class="button" title="Klik tombol untuk proses data" value=" Save " />
				<input type="reset" name="reset" class="button" title="Klik tombol untuk proses data" value=" Cancel " />
			</p>
		  </form>
	</fieldset>
</div>

<!-- batas -->