<?php require_once('../Connections/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['nik'])) {
  $loginUsername=$_POST['nik'];
  $password=md5($_POST['password']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "form/index.php";
  $MM_redirectLoginFailed = "gagal.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_koneksi, $koneksi);
  
  $LoginRS__query=sprintf("SELECT nik, password FROM warga WHERE nik=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $koneksi) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SemPelMas Jagalan</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	

<div class="container">
	
	<div class="header">
		<h1>SemPelMas </h1>
		<strong>Sistem Pelayanan Masyarakat</strong></div> <!--/ .header -->

	<div class="main"><!--/ .header -->

		<div class="middle">
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<table width="96%" border="0">
			  <tr>
			    <td width="10%">&nbsp;</td>
			    <td width="85%">&nbsp;</td>
			    <td width="5%">&nbsp;</td>
		      </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td><form ACTION="<?php echo $loginFormAction; ?>" name="form1" method="POST">
			      <table width="80%" border="0">
			        <tr>
			          <td>NIK</td>
			          <td><label for="nik"></label></td>
			          <td><input type="text" name="nik" id="nik"></td>
		            </tr>
			        <tr>
			          <td>Password</td>
			          <td>&nbsp;</td>
			          <td><label for="password"></label>
		              <input type="password" name="password" id="password"></td>
		            </tr>
			        <tr>
			          <td>&nbsp;</td>
			          <td>&nbsp;</td>
			          <td><input type="submit" name="login" id="login" value="Login"></td>
		            </tr>
		          </table>
			      </form></td>
			    <td>&nbsp;</td>
		      </tr>
			  <tr>
			    <td height="47" rowspan="2">&nbsp;</td>
			    <td>&nbsp;</td>
			    <td rowspan="2">&nbsp;</td>
		      </tr>
			  <tr>
			    <td>&nbsp;</td>
		      </tr>
		  </table>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
           
		</div> 
		<!--/ .middle --><!--/ .right -->

	</div> <!--/ .main -->

	<div class="footer">
		<h4>SemPelMas</h4>
		<p>Copyright &copy; 2019 Jagalan</p>
	</div> <!--/ .footer -->
 
</div>

</body>
</html>