<?php 
header('Content-Type: text/html; charset=utf-8');

$usernameIsInUse = $_GET['isset'];
$usernameAlert = '';
if ($usernameIsInUse == 'yes') {
	$usernameAlert = 'Promiň toto jméno se již používá';
} elseif ($usernameIsInUse == 'no') {
	$usernameAlert = 'Jste úspěšně zaregistrován';
} else {
	$usernameAlert = '';
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Cyklosport Chropyně - Admin</title>
	<meta charset="UTF-8" />
	<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/admin/admin_style.css">
	<script type="text/javascript">
$(document).ready(function(){
	// $(window).load(function(){
	$(".login-table").toggleClass("visible");
		
	// })
})
	// $(".login-table").click(function(){
	// 	$(".login-table").toggleClass("visible");
	// })
</script>
</head>
<body class="login-body">
<div class="login-table">
	<form id="login_form" method="post" action="check_login.php">
		<td>
			<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
				<tr>
					<td colspan="3"><strong>CYKLOSPORT CHROPYNĚ</strong></td>
				</tr>
				<tr>
					<td width="78">Username</td>
					<td width="6">:</td>
					<td width="294">
						<input name="myusername" type="text" id="myusername">
					</td>
				</tr>
				<tr>
					<td>Password</td>
					<td>:</td>
					<td>
						<input name="mypassword" type="text" id="mypassword">
					</td>
				</tr>
				<tr style="text-align: center;">
					<!-- <td>&nbsp;</td> -->
					<!-- <td>&nbsp;</td> -->
					<td colspan="3" style="margin: 0 auto;">
						<input type="submit" name="Submit" value="Login">
					</td>
					
				</tr>
			</table>
		</td>
	</form>
</div>

</body>

</html>