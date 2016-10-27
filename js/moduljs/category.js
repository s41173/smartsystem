$(document).ready(function (e) {
	
   
    // function general
    load_data();
	
	// reset form
	$("#breset,#bclose").click(function(){
	
	  document.getElementById('tname').value = '';
	  document.getElementById("preview").innerHTML = "";
	  document.getElementById("uploadImage").value = "";
	  
	});
	
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
					// view uploaded file.
					$("#preview").html(res[1]).fadeIn();
				//	$('#myModal').modal('hide');
					
				}
				setTimeout(function() { $(".error").fadeOut(); }, 3000);
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
					error_mess(3,res[1]);
				}
				else
				{
					// view uploaded file.
					error_mess(1,'Update Successfully...!');
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
	
	
	// fungsi jquery update
	$(document).on('click','.text-primary',function(e)
	{	
		e.preventDefault();
		var element = $(this);
		var del_id = element.attr("id");
		var url = sites_get +"/"+ del_id;
		$(".error").fadeOut();
		
		$("#myModal2").modal('show');
		$.post(url,
			{id:$(this).attr('data-id')},
			function(result)
			{
				res = result.split("|");
				
				$("#tid_update").val(res[0]);
				$("#tname_update").val(res[1]);
				$("#cparent_update").val(res[2]);
				$("#catimg_update").attr("src",res[3]);
			}   
		);
		
	});
		
// document ready end	
});


// fungsi load data
	function load_data()
	{
		$(document).ready(function (e) {
			
			var oTable = $('#datatable-buttons').dataTable();

		    $.ajax({
				type : 'GET',
				url: source,
				//force to handle it as text
				contentType: "application/json",
				dataType: "json",
				success: function(s) 
				{

					 console.log(s);
						oTable.fnClearTable();
						$(".chkselect").remove();
							
		$("#chkbox").append('<input type="checkbox" name="newsletter" value="accept1" onclick="cekall('+s.length+')" id="chkselect" class="chkselect">');
							
							for(var i = 0; i < s.length; i++) {
							 oTable.fnAddData([
'<input type="checkbox" name="cek[]" value="'+s[i][0]+'" id="cek'+i+'" style="margin:0px"  />',
										i+1,
										s[i][1],
										s[i][2],
'<a href="" class="text-primary" id="' +s[i][0]+ '" title=""> <i class="fa fas-2x fa-edit"> </i> </a> <a href="#" class="text-danger" id="'+s[i][0]+'" title="delete"> <i class="fa fas-2x fa-trash"> </i> </a>'
											   ]);										
											} // End For
											
											
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				
			});  // end document ready	
			
        });
	}
	// batas fungsi load data