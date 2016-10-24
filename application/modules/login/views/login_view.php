<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="shortcut icon" href="<?php echo base_url().'images/fav_icon.png';?>" />
	<title> Login </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
    <style type="text/css">@import url("<?php echo base_url() . 'css/login.css'; ?>");</style>
    
    <!-- sweet alert js -->
    <script type="text/javascript" src="<?php echo base_url().'js/sweetalert/sweetalert.min.js'; ?>"></script>
    <style type="text/css">@import url("<?php echo base_url() . 'js/sweetalert/sweetalert.css'; ?>");</style>
    
    
</head>

<script type="text/javascript">

	function login()
	{	
		var user = document.getElementById("user");
		var pass = document.getElementById("pass");
		
		  if (user.value == "")
		  {
			 alert("Username must be filled");
			 user.focus();
			 return false;
		  }
		  
		  else if (pass.value == "")
		  {
			 alert("Password must be filled");
			 pass.focus();
			 return false;
		  }
		  
		  else{ return false; }
	}

</script>

<body>


<form action="<?php echo $form_action; ?>" name="login_form" id="login_form" method="post" onsubmit="return login();">
<div class="containerx">
<img src="<?php echo $logo; ?>" alt="<?php echo $pname; ?>" class="logo">


<div class="txt_field">
	<i class="fa fa-user"></i>
	<input type="text" name="username" id="user" class="txt" required placeholder="username">
	<div class="clr">	</div>
</div>



<div class="txt_field">
	<i class="fa fa-lock"></i>
	<input type="password" name="password" id="pass" class="txt" required placeholder="password">
	<div class="clr">	</div>
</div>

<div class="btn">
	<button type="submit">Login&nbsp;&nbsp;<i class="fa fa-arrow-circle-o-right"></i></button>
	<button type="reset" class="fr">Cancel&nbsp;&nbsp;<i class="fa fa-undo"></i></button><p>&copy; Copyrights <?php echo $pname.'&nbsp;'.date('Y'); ?>.    <br>All rights reserved.</p>
</div>
	
</div>
</form>

</body>
</html>