<?php require_once('../../Connections/koneksi.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../gagal.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE warga SET password=%s WHERE nik=%s",
                       GetSQLValueString(md5($_POST['password']), "text"),
                       GetSQLValueString($_POST['nik'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "../index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_warga_u = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_warga_u = $_SESSION['MM_Username'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_warga_u = sprintf("SELECT * FROM warga WHERE nik = %s", GetSQLValueString($colname_warga_u, "text"));
$warga_u = mysql_query($query_warga_u, $koneksi) or die(mysql_error());
$row_warga_u = mysql_fetch_assoc($warga_u);
$totalRows_warga_u = mysql_num_rows($warga_u);
?>
<!DOCTYPE html>
<html class='no-js' >
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		
		
		<!--==================================================================
			Your Title
		==================================================================-->
		<title>System Pelayanan Masyarakat</title>
		
		
		<!--==================================================================
			CSS Stylesheets
		==================================================================-->
		<link rel='stylesheet' type='text/css' href='bootstrap/css/bootstrap.min.css' >
		<link rel='stylesheet' type='text/css' href='css/ionicons.min.css' >
		<link rel='stylesheet' type='text/css' href='css/owl.carousel.css' >
		<link rel='stylesheet' type='text/css' href='css/magnific-popup.css' >
		<link rel='stylesheet' type='text/css' href='css/style.css' >
		
	</head>
	<body>
		
		<!--page-borders-->
		<div class='page-borders' >
			<div class='left' ></div>
			<div class='right' ></div>
		</div>
		
		<!--menu-btn-->
		<a href='#' class='menu-btn' >
			<span class='lines' >
				<span class='l1' ></span>
				<span class='l2' ></span>
				<span class='l3' ></span>
			</span>
		</a>
		
		
		<!--menu-->
		<nav class='menu' >
			<ul>
				<li>
					<a href='user_surket.php' >
						Surat Keterangan
					</a>
				</li>
				<li>
					<a href='user_skck.php' >
						SKCK
					</a>
				</li>
				<li>
					<a href='user_ketlah.php' >
						Keterangan Lahir
					</a>
				</li>
				<li>
					<a href='user_sku.php' >
						Keterangan Tempat Usaha
					</a>
				</li>
			  <li>
					<a href='user_kematian.php' >
						Akta Kematian
					</a>
				</li>
				<li>
					<a href='user_lahir.php' >
						Akta Kelahiran
					</a>
				</li>
				<li>
					<a href='user_pindah_keluar.php' >
						Pindah Keluar
					</a>
				</li>
				<li>
					<a href='ganti.php?nik=<?php echo $row_warga_u['nik']; ?>' >
						Ganti Password
					</a>
				</li>
			</ul>
		</nav>
		
		<!--==================================================================
			Preloader
		==================================================================-->
		<div id='preloader' >
			<div class='loader' ><img src='img/loader.gif' alt></div>
		</div>
		
		
		<!--==================================================================
			Main Wrapper
		==================================================================-->
		<div id='main-wrapper' >
			
			
			<!--==================================================================
				Intro Section
			==================================================================--><!--==================================================================
				Features Section -- 1
			==================================================================-->
			<section id='features' class='section features-section' >
			  <div class='container' >
			    <div class='row' >
			      <div class='col-md-8 col-md-offset-2' >
			        <div class='features-text' >
			          <h2>System Pelayanan Masyarakat</h2>
			          <p>&nbsp;</p>
		            </div>
		          </div>
		        </div>
			    <div class='row features-row' >
			      <div class='col-md-4 col-sm-6' >
			        <div class='feature' >
			          <div class='icon' > <i class='ion-android-lock' ></i></div>
			          <div class='content' >
			            <h4>Ganti password</h4>
			            <p>Catat dan ingat password baru anda. jika lupa hubungi admin</p>
			            <p>&nbsp;</p>
			            <p>&nbsp;</p>
			            <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
			            <table align="center">
                          <tr valign="baseline">
                              <td nowrap align="right">Password </td>
                              <td><input type="text" name="password" value="" size="18"></td>
                          </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">&nbsp;</td>
                              <td><input type="submit" value="Ganti"></td>
                            </tr>
                          </table>
                          <input type="hidden" name="nik" value="<?php echo $row_warga_u['nik']; ?>">
                          <input type="hidden" name="MM_update" value="form1">
                          <input type="hidden" name="nik" value="<?php echo $row_warga_u['nik']; ?>">
                        </form>
                        <p>&nbsp;</p>
                      </div>
		            </div>
		          </div>
			    </div>
		      </div>
		  </section>

			<footer>
				<div class='container text-center' >
					<p>Copyright Sempelmas &copy; 2019. Sempel</p>
				</div>
			</footer>
			
		</div>
		
		
		<!--==================================================================
			JavaScript Files
		==================================================================-->
		<script src='js/jquery.min.js' ></script>
		<script src='js/jquery.fitvids.js' ></script>
		<script src='js/owl.carousel.min.js' ></script>
		<script src='js/jquery.magnific-popup.min.js' ></script>
		<script src='js/validator.min.js' ></script>
		<script src='js/script.js' ></script>
		
	</body>
</html>
<?php
mysql_free_result($warga_u);
?>
