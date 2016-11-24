
 <!-- Datatables CSS -->
<link href="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url(); ?>css/icheck/flat/green.css" rel="stylesheet">


<script src="<?php echo base_url(); ?>js/ajaxupload.js"></script>
<script src="<?php echo base_url(); ?>js-old/register.js"></script>
<script src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>

<script type="text/javascript">

    var site = "<?php echo site_url();?>";
	var sites_add  = "<?php echo site_url('product/add_process/');?>";
	var sites_edit = "<?php echo site_url('product/update_process/');?>";
	var sites_del  = "<?php echo site_url('product/delete/');?>";
	
	/*$(function(){
            $(document).on('click','.text-primary',function(e)
			{
				var sites = "<?php echo site_url('category/update/');?>";
				
                e.preventDefault();
                $("#myModal2").modal('show');
                $.post(sites,
                    {id:$(this).attr('data-id')},
                    function(result)
					{
						res = result.split("|");
						
						document.getElementById("tid").value = res[0];
						document.getElementById("tname").value = res[2];
						document.getElementById('cparent').value = res[3];
						document.getElementById('catimg').src = res[4];
						
                        // $(".modal-body").html(res[2]);
                    }   
                );
            });
			
        });*/
	
</script>

          <div class="row"> 
          
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel" >
   				
                <div class="title"> <?php $flashmessage = $this->session->flashdata('message'); ?> </div>
                <p class="message"> 
				   <?php echo ! empty($message) ? $message : '' . ! empty($flashmessage) ? $flashmessage : ''; ?>
                </p>
                
                <div id="error"> <?php echo ! empty($error) ? $error : ''; ?> </div>
                
                <div class="x_content">
                
                 <!-- add form -->
                 
          <form id="supload_form_non" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="<?php echo $form_action; ?>" 
      enctype="multipart/form-data">
                 
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Category (*)</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
             <?php $js = "class='select2_single form-control' id='cparent' tabindex='-1' style='width:100%;' "; 
			        echo form_dropdown('ccategory', $category, isset($default['category']) ? $default['category'] : '', $js); ?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12"> Model / Name (*) </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="tname" class="form-control col-md-7 col-xs-12" type="text" name="tname" required placeholder="">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Price </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="middle-name" class="disabsled form-control col-md-7 col-xs-12" type="number" required name="tprice">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Publish </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                      Y <input name="rpublish" type="radio" class="required" checked value="1" />  
				      N <input name="rpublish" type="radio" class="required" value="0" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Short Description </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="tshortdesc" class="form-control col-md-7 col-xs-12" cols="30" rows="2" required></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Image </label>
                  <div class="checkbox">
                      <label>
                         <input type="file" id="uploadImage" accept="image/*" class="input-medium" title="Upload" name="userfile" /> <br>
                         <div style="margin:10px;" id="preview">  </div>
                      </label>
                    </div>
                </div>
                
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Image Url 1 </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="turl1" class="form-control col-md-7 col-xs-12" cols="30" rows="2"></textarea>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Image Url 2 </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="turl2" class="form-control col-md-7 col-xs-12" cols="30" rows="2"></textarea>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12"> Image Url 3 </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea name="turl3" class="form-control col-md-7 col-xs-12" cols="30" rows="2"></textarea>
                  </div>
                </div>

                <br>  

                <div class="form-group">
                  <div class="col-lg-12">
                    <textarea name="tdesc" id="editor1" rows="10" cols="80"></textarea>
                  </div>
                </div>

                <div class="ln_solid"></div>

                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-success" id="button">Save</button>
                    <button type="reset" class="btn btn-warning"> Cancel </button>
                    <!-- links -->
                    <?php if (!empty($link)){foreach($link as $links){echo $links . '';}} ?>
                    <!-- links -->
                  </div>
                </div>
              </form>
              <!-- Check All Function -->
                  
              </div>
                             
            </div>
          </div>


      <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group"></ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
      </div>
      
      <script src="<?php echo base_url(); ?>js/icheck/icheck.min.js"></script>
      
       <!-- Datatables JS -->
        <script src="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/buttons.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/jszip.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/pdfmake.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/vfs_fonts.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/buttons.print.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/responsive.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/datatables/dataTables.scroller.min.js"></script>

       <!-- pace -->
        <script src="<?php echo base_url(); ?>js/pace/pace.min.js"></script>
        <script>
          var handleDataTableButtons = function() {
              "use strict";
              0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
                dom: "Bfrtip",
                "order": [[ 1, "asc" ]],     
                buttons: [{
                  extend: "copy",
                  className: "btn-sm"
                }, {
                  extend: "csv",
                  className: "btn-sm"
                }, {
                  extend: "excel",
                  className: "btn-sm"
                }, {
                  extend: "pdf",
                  className: "btn-sm"
                }, {
                  extend: "print",
                  className: "btn-sm"
                }],
                responsive: !0
              })
            },
            TableManageButtons = function() {
              "use strict";
              return {
                init: function() {
                  handleDataTableButtons()
                }
              }
            }();
        </script>
        <!-- pace -->
        
		<script type="text/javascript">
             TableManageButtons.init();
			 
			 // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
			 
        </script>
    