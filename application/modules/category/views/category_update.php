<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"> Category - Update </h4>
        </div>
        
 <div class="modal-body"> 

 <!-- form edit -->
<form id="upload_form_edit" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="<?php echo $form_action; ?>" 
      enctype="multipart/form-data">
     
    <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Name </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <input id="tname" class="form-control col-md-7 col-xs-12" readonly type="text" name="tname" required placeholder="Category Name">
        <input type="hidden" id="tid" name="tid">
      </div>
    </div>

      <div class="form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Parent <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
               <?php $js = "class='form-control' tabindex='-1' style='width:100%;' id='cparent' "; 
			        echo form_dropdown('cparent', $parent, isset($default['parent']) ? $default['parent'] : '', $js); 
			   ?>
          </div>
      </div>


      <div class="form-group">
      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Image </label>
      <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="file" id="uploadImage" accept="image/*" class="input-medium" title="Upload" name="userfile" /> <br>
            <img id="catimg" style="width:100%; height:auto;">
      </div>
      </div>

      <div class="ln_solid"></div>
      <div class="form-group">
          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button type="submit" class="btn btn-success" id="button">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>
  </form> 
  <!-- form edit -->
  <div id="err"></div>
  
  </div>
 </div>
</div>