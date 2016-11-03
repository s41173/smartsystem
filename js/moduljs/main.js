$(document).ready(function (e) {
	
    // modal dialog
    $('#myModal,#myModal2,#myModal3,#myModal4,#myModal5').on('hidden.bs.modal', function () {
	  load_data();
    })
	
	// $('#datatable-buttons').dataTable({
	 // dom: 'T<"clear">lfrtip',
		// tableTools: {"sSwfPath": site}
	 // });

   
    // function general
	$("#error,#success,#warning").hide();
	$(".error,.success,.warning").hide();

	// ajax form
	
	$('#ajaxform,#ajaxform2,#ajaxform3,#ajaxform4').submit(function() {
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				// $('#result').html(data);
				if (data == "true")
				{
					location.reload(true);
				}
				else{ error_mess(3,data); }
			}
		})
		return false;
	});
	
	$('#cekallform').submit(function() {
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				res = data.split("|");
				if (res[0] == "true")
				{
					load_data();
					error_mess(1,res[1],0);
				}
				else if(res[0] == 'error') { error_mess(3,res[1],0); }
				else{ 
				  load_data();
				  error_mess(2,res[1],0);
			    }
			}
		})
		return false;
	});
	
	// ajax loading
	$('#loading').ajaxStart(function(){
		$(this).fadeIn();
	}).ajaxStop(function(){
		$(this).fadeOut();
	});
	
	// ================================================== delete ajax ===============================================
	
	
	$(document).on('click','.text-danger',function(e){
	
	e.preventDefault();
	
	var element = $(this);
	var del_id = element.attr("id");
	var info = 'id=' + del_id;
	
	 swal({
		title: "Are you sure?",
		text: "",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, I am sure!',
		cancelButtonText: "No, cancel it!",
		closeOnConfirm: true,
		closeOnCancel: true
	   },
	   function(isConfirm)
	   {
			if (isConfirm){  
			 
			  //alert(sites_del +"/"+ del_id);  
			  $.ajax({
				type: 'POST',
				url: sites_del +"/"+ del_id,
				data: $(this).serialize(),
				success: function(data)
				{
					res = data.split("|");
					if (res[0] == 'true'){ error_mess(1,res[1],0); }
					else if(res[0] == 'error') { error_mess(3,res[1],0); }
					else { error_mess(2,res[1],0); }
				    load_data();
				}
				})
				return false; 
			}
	   });
	
	});
	
	// form untuk upload data
	$("#upload_form").on('submit',(function(e) {
		
		e.preventDefault();
		$.ajax({
        	url: sites_add,
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			beforeSend : function()
			{
				//$("#preview").fadeOut();
				$(".error").fadeOut();
			},
			success: function(data)
		    {
				if(data=='invalid')
				{
					// invalid file format.
					$(".error").html("Invalid File !").fadeIn();
				}
				else
				{
					// view uploaded file.
					$("#preview").html(data).fadeIn();
   				    $('#tname,#uploadImage').val("");
					//$('#preview').html('')
				}
				
				setTimeout(function() { $(".error").fadeOut(); }, 3000);
		    },
		  	error: function(e) 
	    	{
				$("#error").html(e).fadeIn();
	    	} 
				        
	   });
	     
	}));
	
	// ajax form non modal
	$("#upload_form_non").on('submit',(function(e) {
		
		e.preventDefault();
		$.ajax({
        	url: sites_add,
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			beforeSend : function()
			{
				//$("#preview").fadeOut();
			},
			success: function(data)
		    {
				res = data.split("|");
				
				if(res[0]=='true')
				{
					// invalid file format.
					error_mess(1,res[1]);
					resets();
				}
				else
				{	
					error_mess(3,res[1]);
				//	$('#myModal').modal('hide');
					
				}
		    },
		  	error: function(e) 
	    	{
				$("#error").html(e).fadeIn();
	    	} 	        
	   });
	     
	}));
	
	/*  edit form  */
	$("#upload_form_edit").on('submit',(function(e) {
		
		e.preventDefault();
		$.ajax({
        	url: sites_edit,
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			beforeSend : function()
			{
				//$("#preview").fadeOut();
			},
			success: function(data)
		    {
				res = data.split("|");
				if(res[0]=='invalid')
				{
					// invalid file format.
					error_mess(2,res[1],1);
				}
				else if(res[0]=='error') { error_mess(3,res[1]); }
				else
				{
					// view uploaded file.
					error_mess(1,'Update Successfully...!',1);
					if (res[1]){ $("#catimg_update").attr("src",res[1]); }

					//$('#myModal2').modal('hide');
				}
		    },
		  	error: function(e) 
	    	{
				$("#err").html(e).fadeIn();
	    	} 	        
	   });
	   
	}));
	
	
	// =============================================================================================================
		

// document ready end	
});


	// function errorbox
	function error_mess (type,mess,pages=1)
	{
	  $(document).ready(function (e) {
		  
		if (pages == 1)  
		{
			/* pop up window */
		  if (type == 1){ $(".success").html(mess).fadeIn(); setTimeout(function() { $(".success").fadeOut(); }, 3000); }
          else if (type == 2){ $(".warning").html(mess).fadeIn(); setTimeout(function() { $(".warning").fadeOut(); }, 3000); }
	      else if (type == 3){ $(".error").html(mess).fadeIn(); setTimeout(function() { $(".error").fadeOut(); }, 3000); }
		}
		else{
		  /* parent window */
		  if (type == 1){ $("#success").html(mess).fadeIn(); setTimeout(function() { $("#success").fadeOut(); }, 3000); }
          else if (type == 2){ $("#warning").html(mess).fadeIn(); setTimeout(function() { $("#warning").fadeOut(); }, 3000); }
	      else if (type == 3){ $("#error").html(mess).fadeIn(); setTimeout(function() { $("#error").fadeOut(); }, 3000); }
		}
	   
	   // document ready end	
      });
	}

