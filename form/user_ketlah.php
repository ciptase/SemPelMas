<?php require_once('../../Connections/koneksi.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

$currentPage = $_SERVER["PHP_SELF"];

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO ket_lahir (`no`, nama_rt, nama_rw, rt_rw, kampung, userlog, nokk, noktp, nma, jkela, ttla, almta, ke, temlah, penolong, nmi, ttli, agmi, kewari, almti, peki, nmay, ttlay, kewaray, agmay, almtay, peka, kep, status2, status3) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no'], "int"),
                       GetSQLValueString($_POST['nama_rt'], "text"),
                       GetSQLValueString($_POST['nama_rw'], "text"),
                       GetSQLValueString($_POST['rt_rw'], "text"),
                       GetSQLValueString($_POST['kampung'], "text"),
                       GetSQLValueString($_POST['userlog'], "text"),
                       GetSQLValueString($_POST['nokk'], "text"),
                       GetSQLValueString($_POST['noktp'], "text"),
                       GetSQLValueString($_POST['nma'], "text"),
                       GetSQLValueString($_POST['jkela'], "text"),
                       GetSQLValueString($_POST['ttla'], "text"),
                       GetSQLValueString($_POST['almta'], "text"),
                       GetSQLValueString($_POST['ke'], "text"),
                       GetSQLValueString($_POST['temlah'], "text"),
                       GetSQLValueString($_POST['penolong'], "text"),
                       GetSQLValueString($_POST['nmi'], "text"),
                       GetSQLValueString($_POST['ttli'], "text"),
                       GetSQLValueString($_POST['agmi'], "text"),
                       GetSQLValueString($_POST['kewari'], "text"),
                       GetSQLValueString($_POST['almti'], "text"),
                       GetSQLValueString($_POST['peki'], "text"),
                       GetSQLValueString($_POST['nmay'], "text"),
                       GetSQLValueString($_POST['ttlay'], "text"),
                       GetSQLValueString($_POST['kewaray'], "text"),
                       GetSQLValueString($_POST['agmay'], "text"),
                       GetSQLValueString($_POST['almtay'], "text"),
                       GetSQLValueString($_POST['peka'], "text"),
                       GetSQLValueString($_POST['kep'], "text"),
                       GetSQLValueString($_POST['status2'], "text"),
                       GetSQLValueString($_POST['status3'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "user_ketlah.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

mysql_select_db($database_koneksi, $koneksi);
$query_namart = "SELECT nama_rt FROM rt_rw";
$namart = mysql_query($query_namart, $koneksi) or die(mysql_error());
$row_namart = mysql_fetch_assoc($namart);
$totalRows_namart = mysql_num_rows($namart);

mysql_select_db($database_koneksi, $koneksi);
$query_namarw = "SELECT nama_rw FROM rt_rw";
$namarw = mysql_query($query_namarw, $koneksi) or die(mysql_error());
$row_namarw = mysql_fetch_assoc($namarw);
$totalRows_namarw = mysql_num_rows($namarw);

mysql_select_db($database_koneksi, $koneksi);
$query_peker = "SELECT pekerjaan_no FROM pekerjaan_dat";
$peker = mysql_query($query_peker, $koneksi) or die(mysql_error());
$row_peker = mysql_fetch_assoc($peker);
$totalRows_peker = mysql_num_rows($peker);

mysql_select_db($database_koneksi, $koneksi);
$query_agam = "SELECT agama_dat FROM agama";
$agam = mysql_query($query_agam, $koneksi) or die(mysql_error());
$row_agam = mysql_fetch_assoc($agam);
$totalRows_agam = mysql_num_rows($agam);

mysql_select_db($database_koneksi, $koneksi);
$query_no_rt_rw = "SELECT rt_no1 FROM rt_rw_no";
$no_rt_rw = mysql_query($query_no_rt_rw, $koneksi) or die(mysql_error());
$row_no_rt_rw = mysql_fetch_assoc($no_rt_rw);
$totalRows_no_rt_rw = mysql_num_rows($no_rt_rw);

$maxRows_ketlah_u = 4;
$pageNum_ketlah_u = 0;
if (isset($_GET['pageNum_ketlah_u'])) {
  $pageNum_ketlah_u = $_GET['pageNum_ketlah_u'];
}
$startRow_ketlah_u = $pageNum_ketlah_u * $maxRows_ketlah_u;

$colname_ketlah_u = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_ketlah_u = $_SESSION['MM_Username'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_ketlah_u = sprintf("SELECT * FROM ket_lahir WHERE noktp = %s ORDER BY `no` DESC", GetSQLValueString($colname_ketlah_u, "text"));
$query_limit_ketlah_u = sprintf("%s LIMIT %d, %d", $query_ketlah_u, $startRow_ketlah_u, $maxRows_ketlah_u);
$ketlah_u = mysql_query($query_limit_ketlah_u, $koneksi) or die(mysql_error());
$row_ketlah_u = mysql_fetch_assoc($ketlah_u);

if (isset($_GET['totalRows_ketlah_u'])) {
  $totalRows_ketlah_u = $_GET['totalRows_ketlah_u'];
} else {
  $all_ketlah_u = mysql_query($query_ketlah_u);
  $totalRows_ketlah_u = mysql_num_rows($all_ketlah_u);
}
$totalPages_ketlah_u = ceil($totalRows_ketlah_u/$maxRows_ketlah_u)-1;

mysql_select_db($database_koneksi, $koneksi);
$query_peker1 = "SELECT pekerjaan_no FROM pekerjaan_dat";
$peker1 = mysql_query($query_peker1, $koneksi) or die(mysql_error());
$row_peker1 = mysql_fetch_assoc($peker1);
$totalRows_peker1 = mysql_num_rows($peker1);

mysql_select_db($database_koneksi, $koneksi);
$query_agm1 = "SELECT agama_dat FROM agama";
$agm1 = mysql_query($query_agm1, $koneksi) or die(mysql_error());
$row_agm1 = mysql_fetch_assoc($agm1);
$totalRows_agm1 = mysql_num_rows($agm1);

$queryString_ketlah_u = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ketlah_u") == false && 
        stristr($param, "totalRows_ketlah_u") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ketlah_u = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ketlah_u = sprintf("&totalRows_ketlah_u=%d%s", $totalRows_ketlah_u, $queryString_ketlah_u);
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
			    <td><form id="form" name="form1" method="post" action="<?php echo $logoutAction ?>">
			      <div align="center">
			        <input type="submit" name="button" id="button" value="logout" />
			      </div>
			      </form></td>
		            </div>
		          </div>
		        </div>
			    <div class='row features-row' >
			      <div class='col-md-4 col-sm-6' >
			        <div class='feature' >
			          <div class='icon' > <i class='ion-jet' ></i> </div>
			          <div class='content' >
			            <h4>Surat Keterangan kelahiran</h4>
			            <p>untuk persyaratan pembuatan Akta Kelahiran bagi warga yang lahir lebih dari 2 (dua) bulan.</p>
			            <p>Persyaratan : Pengantar RT/RW, Copy KK, Copy KTP, Copy Surat Nikah, Copy KTP Saksi 3 orang</p>
			            <p>&nbsp;</p>
                        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                          <table align="center">
                            <tr valign="baseline">
                              <td align="left" valign="top" nowrap>Nama RT</td>
                              <td align="left" valign="top"><select name="nama_rt" id="nama_rw_rt" onChange="changeValue(this.value)" >
                                <option value=0>-Pilih-</option>
                                <?php 
    $result = mysql_query("select * from rt_rw");    
    $jsArray = "var dtrtrw = new Array();\n";        
    while ($row = mysql_fetch_array($result)) {    
        echo '<option value="' . $row['nama_rt'] . '">' . $row['nama_rt'] . '</option>';    
        $jsArray .= "dtrtrw['" . $row['nama_rt'] . "'] = {nama_rw:'" . addslashes($row['nama_rw']) . "',rtrw:'".addslashes($row['rt_rw']) . "',kamp:'".addslashes($row['kampung'])  . "',id:'".addslashes($row['userlog']) . "'};\n";    
    }      
    ?>
                              </select>
			                    <script type="text/javascript">    
    <?php echo $jsArray; ?>  
    function changeValue(nama_rw_rt){  
    document.getElementById('nm').value = dtrtrw[nama_rw_rt].nama_rw;  
    document.getElementById('rtrw').value = dtrtrw[nama_rw_rt].rtrw;  
    document.getElementById('kamp').value = dtrtrw[nama_rw_rt].kamp;  
    document.getElementById('id').value = dtrtrw[nama_rw_rt].id;  	
    };  
                                </script></td>                              
                              
                              
                              
                              </td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Nama RW</td>
                              <td><input name="nama_rw" type="text" id="nm" size="22" readonly/>                                <input name="status2" type="hidden" id="status2" value="Dalam Proses" size="2" readonly/></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>RT / RW</td>
                              <td><input name="rt_rw" type="text" id="rtrw" size="22" readonly/>                                <input name="status3" type="hidden" id="status3" value="Baru" size="2" readonly/></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Lingkungan</td>
                              <td><input name="kampung" type="text" id="kamp" size="22" readonly/></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>ID</td>
                              <td><input name="userlog" type="text" id="id" size="22" readonly/></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td colspan="2" nowrap bgcolor="#CCCCCC"><div align="center">DATA ANAK</div></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>No KK</td>
                              <td><input name="nokk" type="text" value="<?php echo $row_warga_u['no_kk']; ?>" size="22" readonly></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>No KTP</td>
                              <td><input name="noktp" type="text" value="<?php echo $row_warga_u['nik']; ?>" size="22" readonly></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Nama</td>
                              <td><input name="nma" type="text" value="<?php echo $row_warga_u['nama']; ?>" size="22" readonly></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Jenis Kelamin</td>
                              <td><input name="jkela" type="text" value="<?php echo $row_warga_u['jkel']; ?>" size="22" readonly></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Tmp/Tgl Lahir</td>
                              <td><textarea name="ttla" cols="22" readonly><?php echo $row_warga_u['ttlahir']; ?></textarea></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Alamat</td>
                              <td><textarea name="almta" cols="22" rows="2" readonly><?php echo $row_warga_u['almt']; ?></textarea></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Anak Ke</td>
                              <td><select name="ke">
                                <option value="(1) Satu" <?php if (!(strcmp("(1) Satu", ""))) {echo "SELECTED";} ?>>(1) Satu</option>
                                <option value="(2) Dua" <?php if (!(strcmp("(2) Dua", ""))) {echo "SELECTED";} ?>>(2) Dua</option>
                                <option value="(3) Tiga" <?php if (!(strcmp("(3) Tiga", ""))) {echo "SELECTED";} ?>>(3) Tiga</option>
                                <option value="(4) Empat" <?php if (!(strcmp("(4) Empat", ""))) {echo "SELECTED";} ?>>(4) Empat</option>
                                <option value="(5) Lima" <?php if (!(strcmp("(5) Lima", ""))) {echo "SELECTED";} ?>>(5) Lima</option>
                                <option value="(6) Enam" <?php if (!(strcmp("(6) Enam", ""))) {echo "SELECTED";} ?>>(6) Enam</option>
                                <option value="(7) Tujuh" <?php if (!(strcmp("(7) Tujuh", ""))) {echo "SELECTED";} ?>>(7) Tujuh</option>
                                <option value="(8) Delapan" <?php if (!(strcmp("(8) Delapan", ""))) {echo "SELECTED";} ?>>(8) Delapan</option>
                                <option value="(9) Sembilan" <?php if (!(strcmp("(9) Sembilan", ""))) {echo "SELECTED";} ?>>(9) Sembilan</option>
                                <option value="(10) Sepuluh" <?php if (!(strcmp("(10) Sepuluh", ""))) {echo "SELECTED";} ?>>(10) Sepuluh</option>
                                <option value="(11) Sebelas" <?php if (!(strcmp("(11) Sebelas", ""))) {echo "SELECTED";} ?>>(11) Sebelas</option>
                                <option value="(12) Dua belas" <?php if (!(strcmp("(12) Dua belas", ""))) {echo "SELECTED";} ?>>(12) Dua belas</option>
                                <option value="(13) Tiga Belas" <?php if (!(strcmp("(13) Tiga Belas", ""))) {echo "SELECTED";} ?>>(13) Tiga Belas</option>
                                <option value="(14) Empat Belas" <?php if (!(strcmp("(14) Empat Belas", ""))) {echo "SELECTED";} ?>>(14) Empat Belas</option>
                                <option value="(15) Lima Belas" <?php if (!(strcmp("(15) Lima Belas", ""))) {echo "SELECTED";} ?>>(15) Lima Belas</option>
                                <option value="(16) Enam Belas" <?php if (!(strcmp("(16) Enam Belas", ""))) {echo "SELECTED";} ?>>(16) Enam Belas</option>
                                <option value="(17) Tujuh Belas" <?php if (!(strcmp("(17) Tujuh Belas", ""))) {echo "SELECTED";} ?>>(17) Tujuh Belas</option>
                                <option value="(18) Delapan Belas" <?php if (!(strcmp("(18) Delapan Belas", ""))) {echo "SELECTED";} ?>>(18) Delapan Belas</option>
                                <option value="(19) Sembilan Belas" <?php if (!(strcmp("(19) Sembilan Belas", ""))) {echo "SELECTED";} ?>>(19) Sembilan Belas</option>
                                <option value="(20) Dua Puluh" <?php if (!(strcmp("(20) Dua Puluh", ""))) {echo "SELECTED";} ?>>(20) Dua Puluh</option>
                              </select></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Tempat Lahir</td>
                              <td><input type="text" name="temlah" value="" size="22"></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Penolong:</td>
                              <td><select name="penolong">
                                <option value="Bidan" <?php if (!(strcmp("Bidan", ""))) {echo "SELECTED";} ?>>Bidan</option>
                                <option value="Dukun" <?php if (!(strcmp("Dukun", ""))) {echo "SELECTED";} ?>>Dukun</option>
                                <option value="Dokter" <?php if (!(strcmp("Dokter", ""))) {echo "SELECTED";} ?>>Dokter</option>
                                <option value="Mantri" <?php if (!(strcmp("Mantri", ""))) {echo "SELECTED";} ?>>Mantri</option>
                                <option value="Lainnya" <?php if (!(strcmp("Lainnya", ""))) {echo "SELECTED";} ?>>Lainnya</option>
                              </select></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td colspan="2" nowrap bgcolor="#CCCCCC"><div align="center">DATA IBU</div></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Nama Ibu</td>
                              <td><input type="text" name="nmi" value="<?php echo $row_warga_u['ibu']; ?>" size="22" readonly></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Tmp/Tgl Lahir</td>
                              <td><textarea name="ttli" cols="22" rows="2"></textarea></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Agama</td>
                              <td><select name="agmi">
                                <?php 
do {  
?>
                                <option value="<?php echo $row_agam['agama_dat']?>" ><?php echo $row_agam['agama_dat']?></option>
                                <?php
} while ($row_agam = mysql_fetch_assoc($agam));
?>
                              </select></td>
                            <tr align="left" valign="top">
                              <td nowrap>warganegara</td>
                              <td><select name="kewari">
                                <option value="-" <?php if (!(strcmp("-", ""))) {echo "SELECTED";} ?>>-</option>
                                <option value="W N A" <?php if (!(strcmp("W N A", ""))) {echo "SELECTED";} ?>>W N A</option>
                                <option value="W N I" <?php if (!(strcmp("W N I", ""))) {echo "SELECTED";} ?>>W N I</option>

                              </select></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Alamat</td>
                              <td><textarea name="almti" cols="22" rows="2"></textarea></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Pekerjaan</td>
                              <td><select name="peki">
                                <?php 
do {  
?>
                                <option value="<?php echo $row_peker['pekerjaan_no']?>" ><?php echo $row_peker['pekerjaan_no']?></option>
                                <?php
} while ($row_peker = mysql_fetch_assoc($peker));
?>
                              </select></td>
                            <tr align="left" valign="top">
                              <td colspan="2" nowrap bgcolor="#CCCCCC"><div align="center">DATA AYAH</div></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Nama Ayah</td>
                              <td><input type="text" name="nmay" value="<?php echo $row_warga_u['ayah']; ?>" size="22" readonly></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Tmp/Tgl Lahir</td>
                              <td><textarea name="ttlay" cols="22" rows="2"></textarea></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Warganegara</td>
                              <td><select name="kewaray">
                                <option value="-" <?php if (!(strcmp("-", ""))) {echo "SELECTED";} ?>>-</option>
                                <option value="W N A" <?php if (!(strcmp("W N A", ""))) {echo "SELECTED";} ?>>W N A</option>
                                <option value="W N I" <?php if (!(strcmp("W N I", ""))) {echo "SELECTED";} ?>>W N I</option>

                              </select></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Agama</td>
                              <td><select name="agmay">
                                <?php
do {  
?>
                                <option value="<?php echo $row_agm1['agama_dat']?>"><?php echo $row_agm1['agama_dat']?></option>
                                <?php
} while ($row_agm1 = mysql_fetch_assoc($agm1));
  $rows = mysql_num_rows($agm1);
  if($rows > 0) {
      mysql_data_seek($agm1, 0);
	  $row_agm1 = mysql_fetch_assoc($agm1);
  }
?>
                              </select></td>
                            <tr align="left" valign="top">
                              <td nowrap>Alamat</td>
                              <td><textarea name="almtay" cols="22" rows="2"></textarea></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td nowrap>Pekerjaan</td>
                              <td><select name="peka">
                                <?php
do {  
?>
                                <option value="<?php echo $row_peker1['pekerjaan_no']?>"><?php echo $row_peker1['pekerjaan_no']?></option>
                                <?php
} while ($row_peker1 = mysql_fetch_assoc($peker1));
  $rows = mysql_num_rows($peker1);
  if($rows > 0) {
      mysql_data_seek($peker1, 0);
	  $row_peker1 = mysql_fetch_assoc($peker1);
  }
?>
                              </select></td>
                            <tr align="left" valign="top">
                              <td nowrap>Keperluan</td>
                              <td><textarea name="kep" cols="22" rows="2"></textarea></td>
                            </tr>
                            <tr align="left" valign="top">
                              <td colspan="2" nowrap><div align="center">
                                <input type="submit" value="Kirim">
                              </div></td>
                          </table>
                          <input type="hidden" name="no" value="">
                          <input type="hidden" name="MM_insert" value="form1">
                        </form>
                        <p>&nbsp;</p>
                      </div>
		            </div>
		          </div>
			      <div class='col-md-4 col-sm-6' >
			        <div class='feature' >
			          <div class='content' >
			            <h4>informasi</h4>
                        <?php if ($totalRows_ketlah_u > 0) { // Show if recordset not empty ?>
  <table width="280" border="0" cellpadding="0" cellspacing="0">
    <?php do { ?>
      <tr>
        <td width="133" align="left" valign="top" bgcolor="#CCCCCC">No Entry</td>
        <td width="9" align="left" valign="top" bgcolor="#CCCCCC">:</td>
        <td width="138" align="left" valign="top" bgcolor="#CCCCCC"><?php echo $row_ketlah_u['no']; ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">Tanggal</td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top"><?php echo $row_ketlah_u['tgl_skrg']; ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">Tmp/Tgl Lahir</td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top"><?php echo $row_ketlah_u['ttla']; ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">Anak ke</td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top"><?php echo $row_ketlah_u['ke']; ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">Penolong</td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top"><?php echo $row_ketlah_u['penolong']; ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">Nama Ibu</td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top"><?php echo $row_ketlah_u['nmi']; ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">Nama Ayah</td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top"><?php echo $row_ketlah_u['nmay']; ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">Status Permohonan</td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top"><?php echo $row_ketlah_u['status2']; ?></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <?php } while ($row_ketlah_u = mysql_fetch_assoc($ketlah_u)); ?>
  </table>
  <table border="0">
    <tr>
      <td><?php if ($pageNum_ketlah_u > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_ketlah_u=%d%s", $currentPage, 0, $queryString_ketlah_u); ?>">Pertama</a>          
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_ketlah_u > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_ketlah_u=%d%s", $currentPage, max(0, $pageNum_ketlah_u - 1), $queryString_ketlah_u); ?>">Sebelumnya</a>          
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_ketlah_u < $totalPages_ketlah_u) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_ketlah_u=%d%s", $currentPage, min($totalPages_ketlah_u, $pageNum_ketlah_u + 1), $queryString_ketlah_u); ?>">Selanjutnya</a>          
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_ketlah_u < $totalPages_ketlah_u) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_ketlah_u=%d%s", $currentPage, $totalPages_ketlah_u, $queryString_ketlah_u); ?>">Terakhir</a>          
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
<?php } // Show if recordset not empty ?>
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

mysql_free_result($namart);

mysql_free_result($namarw);

mysql_free_result($peker);

mysql_free_result($agam);

mysql_free_result($no_rt_rw);

mysql_free_result($ketlah_u);

mysql_free_result($peker1);

mysql_free_result($agm1);
?>
