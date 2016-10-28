$(document).ready(function (e) {
	
    // modal dialog
    $('#myModal,#myModal2,#myModal3,#myModal4,#myModal5').on('hidden.bs.modal', function () {
	  load_data();
    })
   
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
					$("#success").show();
					document.getElementById("success").innerHTML = res[1];
					setTimeout(function() { $("#success").fadeOut(); }, 2000);
					load_data();
					
				}
				else{ 
				  $("#warning").show(); 
				  document.getElementById("warning").innerHTML = res[1]; 
				  setTimeout(function() { $("#warning").fadeOut(); }, 2000); 
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
				   //window.location.reload(true);
				   load_data();
				}
				})
				return false;
		
			} else {return false;}
	   });
	
	});
	
	
	// =============================================================================================================
		

// document ready end	
});


	// function errorbox
	function error_mess (type,mess)
	{
	  $(document).ready(function (e) {
		  
	    if (type == 1){ $(".success").html(mess).fadeIn(); setTimeout(function() { $(".success").fadeOut(); }, 3000); }
        else if (type == 2){ $(".warning").html(mess).fadeIn(); setTimeout(function() { $(".warning").fadeOut(); }, 3000); }
	    else if (type == 3){ $(".error").html(mess).fadeIn(); setTimeout(function() { $(".error").fadeOut(); }, 3000); }
	   
	   // document ready end	
      });
	}

