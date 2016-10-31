<script type="text/javascript">

$(document).ready(function (e) {
	
	$("#breset").click(function(){
	
	  document.getElementById('tname').value = '';
	  document.getElementById("preview").innerHTML = "";
	  document.getElementById("uploadImage").value = "";
	  
	});
	
	// document ready end	
});

</script>

<div class="modal-dialog">
        
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"> Category Report </h4>
</div>
<div class="modal-body">
 
 <!-- form add -->
<div class="x_panel" >
<div class="x_title">
  
  <div class="clearfix"></div> 
</div>
<div class="x_content">

<form id="" data-parsley-validate class="form-horizontal form-label-left" method="POST" target="_blank" 
action="<?php echo $form_action_report; ?>" enctype="multipart/form-data">
     
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> User </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <?php $js = "class='form-control' id='cuser'"; 
           echo form_dropdown('cuser', $user, isset($default['user']) ? $default['user'] : '', $js); ?>
        </div>
    </div>
    
     <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> Component </label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <?php $js = "class='form-control' id='ccom'"; 
           echo form_dropdown('ccom', $modul, isset($default['modul']) ? $default['modul'] : '', $js); ?>
        </div>
    </div>

      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-primary">Post</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
      </div>
  </form> 
  <div id="err"></div>
</div>
</div>
<!-- form add -->

</div>
    <div class="modal-footer">
      
    </div>
  </div>
  
</div>