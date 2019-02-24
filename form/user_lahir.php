<?php require_once('../../Connections/koneksi.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO kelahiran (`no`, nama_rt, nama_rw, rt_rw, kampung, userlog, nama, hub_dg_lahir, ttl, j_kelamin, agama, status, pekerjaan, kewarganegaraan, no_kk, no_ktp, alamat, ibu, alamat_ibu, ttl_ibu, ayah, alamat_ayah, ttl_ayah, bayi, hari_lahir, tgl_lahir, jam, kelamin_bayi, anak_ke, status2, status3) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no'], "int"),
                       GetSQLValueString($_POST['nama_rt'], "text"),
                       GetSQLValueString($_POST['nama_rw'], "text"),
                       GetSQLValueString($_POST['rt_rw'], "text"),
                       GetSQLValueString($_POST['kampung'], "text"),
                       GetSQLValueString($_POST['userlog'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['hub_dg_lahir'], "text"),
                       GetSQLValueString($_POST['ttl'], "text"),
                       GetSQLValueString($_POST['j_kelamin'], "text"),
                       GetSQLValueString($_POST['agama'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['pekerjaan'], "text"),
                       GetSQLValueString($_POST['kewarganegaraan'], "text"),
                       GetSQLValueString($_POST['no_kk'], "text"),
                       GetSQLValueString($_POST['no_ktp'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['ibu'], "text"),
                       GetSQLValueString($_POST['alamat_ibu'], "text"),
                       GetSQLValueString($_POST['ttl_ibu'], "text"),
                       GetSQLValueString($_POST['ayah'], "text"),
                       GetSQLValueString($_POST['alamat_ayah'], "text"),
                       GetSQLValueString($_POST['ttl_ayah'], "text"),
                       GetSQLValueString($_POST['bayi'], "text"),
                       GetSQLValueString($_POST['hari_lahir'], "text"),
                       GetSQLValueString($_POST['tgl_lahir'], "text"),
                       GetSQLValueString($_POST['jam'], "text"),
                       GetSQLValueString($_POST['kelamin_bayi'], "text"),
                       GetSQLValueString($_POST['anak_ke'], "text"),
                       GetSQLValueString($_POST['status2'], "text"),
                       GetSQLValueString($_POST['status3'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "user_lahir.php";
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
$query_namarw = "SELECT nama_rw FROM rt_rw";
$namarw = mysql_query($query_namarw, $koneksi) or die(mysql_error());
$row_namarw = mysql_fetch_assoc($namarw);
$totalRows_namarw = mysql_num_rows($namarw);

mysql_select_db($database_koneksi, $koneksi);
$query_status_data = "SELECT status_e FROM status_dat";
$status_data = mysql_query($query_status_data, $koneksi) or die(mysql_error());
$row_status_data = mysql_fetch_assoc($status_data);
$totalRows_status_data = mysql_num_rows($status_data);

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

mysql_select_db($database_koneksi, $koneksi);
$query_hari_u = "SELECT dino FROM hari";
$hari_u = mysql_query($query_hari_u, $koneksi) or die(mysql_error());
$row_hari_u = mysql_fetch_assoc($hari_u);
$totalRows_hari_u = mysql_num_rows($hari_u);

$maxRows_lahir_u = 4;
$pageNum_lahir_u = 0;
if (isset($_GET['pageNum_lahir_u'])) {
  $pageNum_lahir_u = $_GET['pageNum_lahir_u'];
}
$startRow_lahir_u = $pageNum_lahir_u * $maxRows_lahir_u;

$colname_lahir_u = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_lahir_u = $_SESSION['MM_Username'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_lahir_u = sprintf("SELECT * FROM kelahiran WHERE no_ktp = %s ORDER BY `no` DESC", GetSQLValueString($colname_lahir_u, "text"));
$query_limit_lahir_u = sprintf("%s LIMIT %d, %d", $query_lahir_u, $startRow_lahir_u, $maxRows_lahir_u);
$lahir_u = mysql_query($query_limit_lahir_u, $koneksi) or die(mysql_error());
$row_lahir_u = mysql_fetch_assoc($lahir_u);

if (isset($_GET['totalRows_lahir_u'])) {
  $totalRows_lahir_u = $_GET['totalRows_lahir_u'];
} else {
  $all_lahir_u = mysql_query($query_lahir_u);
  $totalRows_lahir_u = mysql_num_rows($all_lahir_u);
}
$totalPages_lahir_u = ceil($totalRows_lahir_u/$maxRows_lahir_u)-1;

$queryString_lahir_u = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_lahir_u") == false && 
        stristr($param, "totalRows_lahir_u") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_lahir_u = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_lahir_u = sprintf("&totalRows_lahir_u=%d%s", $totalRows_lahir_u, $queryString_lahir_u);
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
		<script type="text/javascript">
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
        </script>
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
		            </div>
		          </div>
		        </div>
			    <div class='row features-row' >
			      <div class='col-md-4 col-sm-6' >
			        <div class='feature' >
			          <div class='icon' > <i class='ion-star' ></i> </div>
			          <div class='content' >
			            <h4>AKTA KELAHIRAN</h4>
			            <p>Permohonan membuat Akta Kelahiran bagi warga yang dilahirkan tidak lebih dari 2 (dua) bulan</p>
			            <p>Persyaratan : Pengantar RT/RW, copy KK, copy KTP, keterangan kelahiran dari RS, puskesmas bidan</p>
			            <form action="<?php echo $editFormAction; ?>" method="post" name="form2" onSubmit="MM_validateForm('nm','','R','rtrw','','R','kamp','','R','id','','R','nama','','R','hub_dg_lahir','','R','j_kelamin','','R','agama','','R','status','','R','pekerjaan','','R','kewarganegaraan','','R','no_kk','','R','no_ktp','','R','ibu','','R','ayah','','R','bayi','','R','tgl_lahir','','R','jam','','R','ttl','','R','alamat','','R','alamat_ibu','','R','ttl_ibu','','R','alamat_ayah','','R','ttl_ayah','','R');return document.MM_returnValue">
			              <table width="283" align="center">
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Nama RT</div></td>
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
		                    <tr valign="baseline">
			                    <td align="left" valign="top" nowrap><div align="left">Nama RW</div></td>
		                      <td align="left" valign="top"><input name="nama_rw" type="text" id="nm" size="22" readonly/>
	                          <input name="status2" type="hidden" id="status2" value="Sedang diproses" size="2" readonly/></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">RT / RW</div></td>
			                  <td align="left" valign="top"><input name="rt_rw" type="text" id="rtrw" size="22" readonly/>
		                      <input name="status3" type="hidden" id="status3" value="Baru" size="2" readonly/></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Lingkungan</div></td>
			                  <td align="left" valign="top"><input name="kampung" type="text" id="kamp" size="22" readonly/></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">ID</div></td>
			                  <td align="left" valign="top"><input name="userlog" type="text" id="id" size="22" readonly/></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap>&nbsp;</td>
			                  <td align="left" valign="top">Data Pelapor</td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Nama</div></td>
			                  <td align="left" valign="top"><input name="nama" type="text" id="nama" value="<?php echo $row_warga_u['nama']; ?>" size="22" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Hub dg yg Lahir</div></td>
			                  <td align="left" valign="top"><input name="hub_dg_lahir" type="text" id="hub_dg_lahir" value="" size="20">
			                    *</td>
		                    </tr>
			                <tr valign="baseline">
			                  <td nowrap align="left" valign="top"><div align="left">Temp/Tgl Lahir</div></td>
			                  <td align="left" valign="top"><textarea name="ttl" cols="22" rows="2" readonly id="ttl"><?php echo $row_warga_u['ttlahir']; ?></textarea></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Jenis Kelamin</div></td>
			                  <td align="left" valign="top"><input name="j_kelamin" type="text" id="j_kelamin" value="<?php echo $row_warga_u['jkel']; ?>" size="22" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Agama</div></td>
			                  <td align="left" valign="top"><input name="agama" type="text" id="agama" value="<?php echo $row_warga_u['agama']; ?>" size="22" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Status</div></td>
			                  <td align="left" valign="top"><input name="status" type="text" id="status" value="<?php echo $row_warga_u['status']; ?>" size="22" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Pekerjaan</div></td>
			                  <td align="left" valign="top"><input name="pekerjaan" type="text" id="pekerjaan" value="<?php echo $row_warga_u['peker']; ?>" size="22" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Kewarganegaraan</div></td>
			                  <td align="left" valign="top"><input name="kewarganegaraan" type="text" id="kewarganegaraan" value="<?php echo $row_warga_u['kewarga']; ?>" size="5" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">No_kk:</div></td>
			                  <td align="left" valign="top"><input name="no_kk" type="text" id="no_kk" value="<?php echo $row_warga_u['no_kk']; ?>" size="18" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">No_ktp:</div></td>
			                  <td align="left" valign="top"><input name="no_ktp" type="text" id="no_ktp" value="<?php echo $row_warga_u['nik']; ?>" size="18" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td nowrap align="left" valign="top"><div align="left">Alamat:</div></td>
			                  <td align="left" valign="top"><textarea name="alamat" cols="22" rows="2" readonly id="alamat"><?php echo $row_warga_u['almt']; ?></textarea></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td colspan="2" align="left" valign="top" nowrap bgcolor="#C6D580"><div align="center">Data IBU</div></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Ibu:</div></td>
			                  <td align="left" valign="top"><input name="ibu" type="text" id="ibu" value="" size="20">
			                    *</td>
		                    </tr>
			                <tr valign="baseline">
			                  <td nowrap align="left" valign="top"><div align="left">Alamat_ibu:</div></td>
			                  <td align="left" valign="top"><textarea name="alamat_ibu" cols="22" rows="2" id="alamat_ibu"><?php echo $row_warga_u['almt']; ?></textarea></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td nowrap align="left" valign="top"><div align="left">Temp/Tgl Lahir</div></td>
			                  <td align="left" valign="top"><textarea name="ttl_ibu" cols="20" rows="2" id="ttl_ibu"></textarea>
			                    *</td>
		                    </tr>
			                <tr valign="baseline">
			                  <td colspan="2" align="left" valign="top" nowrap bgcolor="#C6D580"><div align="center">Data AYAH</div></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Ayah</div></td>
			                  <td align="left" valign="top"><input name="ayah" type="text" id="ayah" value="<?php echo $row_warga_u['nama']; ?>" size="22" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td nowrap align="left" valign="top"><div align="left">Alamat_ayah:</div></td>
			                  <td align="left" valign="top"><textarea name="alamat_ayah" cols="22" rows="2" id="alamat_ayah"><?php echo $row_warga_u['almt']; ?></textarea></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td nowrap align="left" valign="top"><div align="left">Temp/Tgl Lahir</div></td>
			                  <td align="left" valign="top"><textarea name="ttl_ayah" cols="22" rows="2" readonly id="ttl_ayah"><?php echo $row_warga_u['ttlahir']; ?></textarea></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td colspan="2" align="left" valign="top" nowrap bgcolor="#C6D580"><div align="center">Data Bayi</div></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Bayi:</div></td>
			                  <td align="left" valign="top"><input name="bayi" type="text" id="bayi" value="" size="20">
			                    *</td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Hari_lahir:</div></td>
			                  <td align="left" valign="top"><select name="hari_lahir">
			                    <?php
do {  
?>
			                    <option value="<?php echo $row_hari_u['dino']?>"><?php echo $row_hari_u['dino']?></option>
			                    <?php
} while ($row_hari_u = mysql_fetch_assoc($hari_u));
  $rows = mysql_num_rows($hari_u);
  if($rows > 0) {
      mysql_data_seek($hari_u, 0);
	  $row_hari_u = mysql_fetch_assoc($hari_u);
  }
?>
			                    </select>
			                    *</td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Tgl_lahir:</div></td>
			                  <td align="left" valign="top"><input name="tgl_lahir" type="text" id="tgl_lahir" value="" size="20">
			                    *</td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Jam:</div></td>
			                  <td align="left" valign="top"><input name="jam" type="text" id="jam" value="" size="8">
			                    WIB *</td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Kelamin_bayi:</div></td>
			                  <td align="left" valign="top"><select name="kelamin_bayi">
			                    <option value="Laki-Laki" <?php if (!(strcmp("Laki-Laki", ""))) {echo "SELECTED";} ?>>Laki-Laki</option>
			                    <option value="Perempuan" <?php if (!(strcmp("Perempuan", ""))) {echo "SELECTED";} ?>>Perempuan</option>
			                    </select>
			                    *</td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Anak_ke:</div></td>
			                  <td align="left" valign="top"><select name="anak_ke">
			                    <option value="1 (Satu)" <?php if (!(strcmp("1 (Satu)", ""))) {echo "SELECTED";} ?>>1 (Satu)</option>
			                    <option value="2 (Dua)" <?php if (!(strcmp("2 (Dua)", ""))) {echo "SELECTED";} ?>>2 (Dua)</option>
			                    <option value="3 (Tiga)" <?php if (!(strcmp("3 (Tiga)", ""))) {echo "SELECTED";} ?>>3 (Tiga)</option>
			                    <option value="4 (Empat)" <?php if (!(strcmp("4 (Empat)", ""))) {echo "SELECTED";} ?>>4 (Empat)</option>
			                    <option value="5 (Lima)" <?php if (!(strcmp("5 (Lima)", ""))) {echo "SELECTED";} ?>>5 (Lima)</option>
			                    <option value="6 (Enam)" <?php if (!(strcmp("6 (Enam)", ""))) {echo "SELECTED";} ?>>6 (Enam)</option>
			                    <option value="7 (Tujuh)" <?php if (!(strcmp("7 (Tujuh)", ""))) {echo "SELECTED";} ?>>7 (Tujuh)</option>
			                    <option value="8 (Delapan)" <?php if (!(strcmp("8 (Delapan)", ""))) {echo "SELECTED";} ?>>8 (Delapan)</option>
			                    <option value="9 (Sembilan)" <?php if (!(strcmp("9 (Sembilan)", ""))) {echo "SELECTED";} ?>>9 (Sembilan)</option>
			                    <option value="10 (Sepuluh)" <?php if (!(strcmp("10 (Sepuluh)", ""))) {echo "SELECTED";} ?>>10 (Sepuluh)</option>
			                    </select>
			                    *</td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left"></div></td>
			                  <td align="left" valign="top"><input type="submit" value="Kirim"></td>
		                    </tr>
		                  </table>
			              <input type="hidden" name="no" value="">
			              <input type="hidden" name="MM_insert" value="form2">
		                </form>
			            <p>&nbsp;</p>
		              </div>
		            </div>
		          </div>
			      <div class='col-md-4 col-sm-6' >
			        <div class='feature' >
			          <div class='content' >
			            <h4>informasi</h4>

                        <?php if ($totalRows_lahir_u > 0) { // Show if recordset not empty ?>
                          <table width="305" border="0" cellpadding="0" cellspacing="0">
                            <?php do { ?>
                              <tr>
                                <td width="130" align="left" valign="top" bgcolor="#CCCCCC">No entry</td>
                                <td width="10" align="left" valign="top" bgcolor="#CCCCCC">:</td>
                                <td width="165" align="left" valign="top" bgcolor="#CCCCCC"><?php echo $row_lahir_u['no']; ?></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top">Tanggal</td>
                                <td align="left" valign="top">:</td>
                                <td align="left" valign="top"><?php echo $row_lahir_u['tgl_skrg']; ?></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top">Nama Pemohon</td>
                                <td align="left" valign="top">:</td>
                                <td align="left" valign="top"><?php echo $row_lahir_u['nama']; ?></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top">Nama bayi</td>
                                <td align="left" valign="top">:</td>
                                <td align="left" valign="top"><?php echo $row_lahir_u['bayi']; ?></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top">Jenis kelamin</td>
                                <td align="left" valign="top">:</td>
                                <td align="left" valign="top"><?php echo $row_lahir_u['kelamin_bayi']; ?></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top">Hari lahir</td>
                                <td align="left" valign="top">:</td>
                                <td align="left" valign="top"><?php echo $row_lahir_u['hari_lahir']; ?></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top">Tanggal Lahir</td>
                                <td align="left" valign="top">:</td>
                                <td align="left" valign="top"><?php echo $row_lahir_u['tgl_lahir']; ?></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top">Jam lahir</td>
                                <td align="left" valign="top">:</td>
                                <td align="left" valign="top"><?php echo $row_lahir_u['jam']; ?></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top">Status permohonan</td>
                                <td align="left" valign="top">:</td>
                                <td align="left" valign="top"><?php echo $row_lahir_u['status2']; ?></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top">&nbsp;</td>
                                <td align="left" valign="top">&nbsp;</td>
                                <td align="left" valign="top">&nbsp;</td>
                              </tr>
                              <?php } while ($row_lahir_u = mysql_fetch_assoc($lahir_u)); ?>
                          </table>
                          <table border="0">
                            <tr>
                              <td><?php if ($pageNum_lahir_u > 0) { // Show if not first page ?>
                                  <a href="<?php printf("%s?pageNum_lahir_u=%d%s", $currentPage, 0, $queryString_lahir_u); ?>">Pertama</a>                                  
                                  <?php } // Show if not first page ?></td>
                              <td><?php if ($pageNum_lahir_u > 0) { // Show if not first page ?>
                                  <a href="<?php printf("%s?pageNum_lahir_u=%d%s", $currentPage, max(0, $pageNum_lahir_u - 1), $queryString_lahir_u); ?>">Sebelumnya</a>                                  
                                  <?php } // Show if not first page ?></td>
                              <td><?php if ($pageNum_lahir_u < $totalPages_lahir_u) { // Show if not last page ?>
                                  <a href="<?php printf("%s?pageNum_lahir_u=%d%s", $currentPage, min($totalPages_lahir_u, $pageNum_lahir_u + 1), $queryString_lahir_u); ?>">Selanjutnya</a>                                  
                                  <?php } // Show if not last page ?></td>
                              <td><?php if ($pageNum_lahir_u < $totalPages_lahir_u) { // Show if not last page ?>
                                  <a href="<?php printf("%s?pageNum_lahir_u=%d%s", $currentPage, $totalPages_lahir_u, $queryString_lahir_u); ?>">Terakhir</a>                                  
                                  <?php } // Show if not last page ?></td>
                            </tr>
                        </table>
                          <?php } // Show if recordset not empty ?>
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

mysql_free_result($namarw);

mysql_free_result($status_data);

mysql_free_result($peker);

mysql_free_result($agam);

mysql_free_result($no_rt_rw);

mysql_free_result($hari_u);

mysql_free_result($lahir_u);
?>
