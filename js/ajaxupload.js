
$(document).ready(function (e) {
	
	$('#myModal,#myModal2').on('hidden.bs.modal', function () {
       window.location.reload(true);
    })
	
	
	// ================================================== delete ajax ===============================================
	
	$(".text-danger").click(function(){
	var element = $(this);
	var del_id = element.attr("id");
	var info = 'id=' + del_id;
	if(confirm("Are you sure you want to delete this?"))
	{
		//alert(sites_del +"/"+ del_id);
		$.ajax({
			type: 'POST',
			url: sites_del +"/"+ del_id,
			data: $(this).serialize(),
			success: function(data)
			{
			   window.location.reload(true);
			}
			})
			return false;
	}
	return false;
	});
	
	
	// =============================================================================================================
	
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
				$("#err").fadeOut();
			},
			success: function(data)
		    {
				if(data=='invalid')
				{
					// invalid file format.
					$("#err").html("Invalid File !").fadeIn();
				}
				else
				{
					// view uploaded file.
					$("#preview").html(data).fadeIn();
				//	$("#upload_form").reset();	
				//	$('#myModal').modal('hide');
					
				}
		    },
		  	error: function(e) 
	    	{
				$("#err").html(e).fadeIn();
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
				$("#error").fadeOut();
			},
			success: function(data)
		    {
				res = data.split("|");
				
				if(res[0]=='invalid')
				{
					// invalid file format.
					$("#error").html(res[1]).fadeIn();
				}
				elseif (res[0] == 'success')
				{
					// alert(res[1]);
					
					// view uploaded file.
					$("#preview").html(res[1]).fadeIn();
				//	$("#upload_form").reset();	
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
				$("#err").fadeOut();
			},
			success: function(data)
		    {
				if(data=='invalid')
				{
					// invalid file format.
					$("#err").html("Invalid File !").fadeIn();
				}
				else
				{
					// view uploaded file.
					$("#err").html("Update Successfully...!").fadeIn();
					document.getElementById('catimg').src = '';
					$('#myModal2').modal('hide');
				}
		    },
		  	error: function(e) 
	    	{
				$("#err").html(e).fadeIn();
	    	} 	        
	   });
	   
	}));
	
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
				else
				{
					// alert(data);
					document.getElementById("errorbox").innerHTML = data;
				}
				
			}
		})
		return false;
	});

// document ready end	
});

