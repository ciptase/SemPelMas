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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO surket (`no`, userlog, j_surat, nama_rt, nama_rw, rt_rw, kampung, nama, j_kelamin, ttl, kewarganegaraan, pekerjaan, status, agama, no_kk, no_ktp, alamat, keperluan, status2, status3) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no'], "int"),
                       GetSQLValueString($_POST['userlog'], "text"),
                       GetSQLValueString($_POST['j_surat'], "text"),
                       GetSQLValueString($_POST['nama_rt'], "text"),
                       GetSQLValueString($_POST['nama_rw'], "text"),
                       GetSQLValueString($_POST['rt_rw'], "text"),
                       GetSQLValueString($_POST['kampung'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['j_kelamin'], "text"),
                       GetSQLValueString($_POST['ttl'], "text"),
                       GetSQLValueString($_POST['kewarganegaraan'], "text"),
                       GetSQLValueString($_POST['pekerjaan'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['agama'], "text"),
                       GetSQLValueString($_POST['no_kk'], "text"),
                       GetSQLValueString($_POST['no_ktp'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['keperluan'], "text"),
                       GetSQLValueString($_POST['status2'], "text"),
                       GetSQLValueString($_POST['status3'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "user_surket.php";
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

mysql_select_db($database_koneksi, $koneksi);
$query_u_j_sur = "SELECT j_surat FROM jenis_surat";
$u_j_sur = mysql_query($query_u_j_sur, $koneksi) or die(mysql_error());
$row_u_j_sur = mysql_fetch_assoc($u_j_sur);
$totalRows_u_j_sur = mysql_num_rows($u_j_sur);

$maxRows_surket_u = 4;
$pageNum_surket_u = 0;
if (isset($_GET['pageNum_surket_u'])) {
  $pageNum_surket_u = $_GET['pageNum_surket_u'];
}
$startRow_surket_u = $pageNum_surket_u * $maxRows_surket_u;

$colname_surket_u = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_surket_u = $_SESSION['MM_Username'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_surket_u = sprintf("SELECT * FROM surket WHERE no_ktp = %s ORDER BY `no` DESC", GetSQLValueString($colname_surket_u, "text"));
$query_limit_surket_u = sprintf("%s LIMIT %d, %d", $query_surket_u, $startRow_surket_u, $maxRows_surket_u);
$surket_u = mysql_query($query_limit_surket_u, $koneksi) or die(mysql_error());
$row_surket_u = mysql_fetch_assoc($surket_u);

if (isset($_GET['totalRows_surket_u'])) {
  $totalRows_surket_u = $_GET['totalRows_surket_u'];
} else {
  $all_surket_u = mysql_query($query_surket_u);
  $totalRows_surket_u = mysql_num_rows($all_surket_u);
}
$totalPages_surket_u = ceil($totalRows_surket_u/$maxRows_surket_u)-1;

$queryString_surket_u = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_surket_u") == false && 
        stristr($param, "totalRows_surket_u") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_surket_u = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_surket_u = sprintf("&totalRows_surket_u=%d%s", $totalRows_surket_u, $queryString_surket_u);
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
			          <p>&nbsp;</p>
		            </div>
		          </div>
		        </div>
			    <div class='row features-row' >
			      <div class='col-md-4 col-sm-6' >
			        <div class='feature' >
			          <div class='icon' > <i class='ion-android-mail' ></i></div>
			          <div class='content' >
			            <h4>Surat Keterangan</h4>
			            <p>Surat Keterangan, SKTM,Ket. Usaha,	Ket Kehilangan</p>
			            <p>Persyaratan berkas : Pengantar RT/RW, Copy KK, Copy KTP dan berkas pendukung lainnya</p>
			            <form action="<?php echo $editFormAction; ?>" method="post" name="form1" onSubmit="MM_validateForm('nm','','R','rtrw','','R','kamp','','R','id','','R','nama','','R','j_kelamin','','R','kewarganegaraan','','R','pekerjaan','','R','status','','R','agama','','R','no_kk','','R','no_ktp','','R','ttl','','R','alamat','','R','keperluan','','R');return document.MM_returnValue">
			              <table align="center">
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left" >Jenis Surat</div></td>
			                  <td align="left" valign="top"><select name="j_surat">
			                    <?php 
do {  
?>
			                    <option value="<?php echo $row_u_j_sur['j_surat']?>" ><?php echo $row_u_j_sur['j_surat']?></option>
			                    <?php
} while ($row_u_j_sur = mysql_fetch_assoc($u_j_sur));
?>
			                    </select>
			                    <label for="select"  size="22" >
			                      <input name="status2" type="hidden" id="status2" value="Dalam Proses" size="2" readonly/>
		                          <input name="status3" type="hidden" id="status3" value="Baru" size="2" readonly/>
			                    </label></td>
		                    <tr valign="baseline">
			                    <td align="left" valign="top" nowrap><div align="left">Nama RT</div></td>
			                    <td align="left" valign="top" ><select name="nama_rt" id="nama_rw_rt" onChange="changeValue(this.value)" >
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
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Nama RW</div></td>
			                  <td align="left" valign="top"><input name="nama_rw" type="text" id="nm" size="22" readonly/></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">RT / RW</div></td>
			                  <td align="left" valign="top"><input name="rt_rw" type="text" id="rtrw" size="22" readonly/></td>
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
			                  <td align="left" valign="top" nowrap><div align="left">Nama</div></td>
			                  <td align="left" valign="top"><input name="nama" type="text" id="nama" value="<?php echo $row_warga_u['nama']; ?>" size="22" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Jenis Kelamin</div></td>
			                  <td align="left" valign="top"><input name="j_kelamin" type="text" id="j_kelamin" value="<?php echo $row_warga_u['jkel']; ?>" size="11" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td nowrap align="left" valign="top"><div align="left">Tmp/Tgl Lhir</div></td>
			                  <td align="left" valign="top"><textarea name="ttl" cols="24" rows="2" readonly id="ttl"><?php echo $row_warga_u['ttlahir']; ?></textarea></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">WargaNegara</div></td>
			                  <td align="left" valign="top"><input name="kewarganegaraan" type="text" id="kewarganegaraan" value="<?php echo $row_warga_u['kewarga']; ?>" size="5" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Pekerjaan</div></td>
			                  <td align="left" valign="top"><input name="pekerjaan" type="text" id="pekerjaan" value="<?php echo $row_warga_u['peker']; ?>" size="22" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Status</div></td>
			                  <td align="left" valign="top"><input name="status" type="text" id="status" value="<?php echo $row_warga_u['status']; ?>" size="22" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">Agama</div></td>
			                  <td align="left" valign="top"><input name="agama" type="text" id="agama" value="<?php echo $row_warga_u['agama']; ?>" size="22" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">No KK</div></td>
			                  <td align="left" valign="top"><input name="no_kk" type="text" id="no_kk" value="<?php echo $row_warga_u['no_kk']; ?>" size="22" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td align="left" valign="top" nowrap><div align="left">No KTP</div></td>
			                  <td align="left" valign="top"><input name="no_ktp" type="text" id="no_ktp" value="<?php echo $row_warga_u['nik']; ?>" size="22" readonly></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td nowrap align="left" valign="top"><div align="left">Alamat</div></td>
			                  <td align="left" valign="top"><textarea name="alamat" cols="24" rows="2" readonly id="alamat"><?php echo $row_warga_u['almt']; ?></textarea></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td nowrap align="left" valign="top"><div align="left">Keperluan</div></td>
			                  <td align="left" valign="top"><textarea name="keperluan" cols="24" rows="2" id="keperluan"></textarea></td>
		                    </tr>
			                <tr valign="baseline">
			                  <td colspan="2" align="right" nowrap><div align="center">
			                    <input type="submit" value="Kirim">
			                    </div></td>
		                    </tr>
		                  </table>
			              <p>
			                <input type="hidden" name="no" value="">
			                <input type="hidden" name="MM_insert" value="form1">
		                  </p>
		                </form>

		              </div>
		            </div>
		          </div>
			      <div class='col-md-4 col-sm-6' >
			        <div class='feature' >
			          <div class='content' >
			            <h4>informasi</h4>

                        <table width="306" border="0" cellpadding="0" cellspacing="0">
                          <?php do { ?>
                            <tr>
                                <td width="75" align="left" valign="top" bgcolor="#CCCCCC">No Entry</td>
                                <td width="10" align="left" valign="top" bgcolor="#CCCCCC">:</td>
                                <td width="221" align="left" valign="top" bgcolor="#CCCCCC"><?php echo $row_surket_u['no']; ?></td>
                          </tr>
                            <tr>
                                <td align="left" valign="top">Tanggal</td>
                                <td align="left" valign="top">:</td>
                                <td align="left" valign="top"><?php echo $row_surket_u['tgl_skrg']; ?></td>
                          </tr>
                            <tr>
                                <td align="left" valign="top">Jenis Surat</td>
                                <td align="left" valign="top">:</td>
                                <td align="left" valign="top"><?php echo $row_surket_u['j_surat']; ?></td>
                          </tr>
                            <tr>
                                <td align="left" valign="top">Keperluan</td>
                                <td align="left" valign="top">:</td>
                                <td align="left" valign="top"><?php echo $row_surket_u['keperluan']; ?></td>
                          </tr>
                            <tr>
                                <td align="left" valign="top">Status</td>
                                <td align="left" valign="top">:</td>
                                <td align="left" valign="top"><?php echo $row_surket_u['status2']; ?></td>
                          </tr>
                            <tr>
                                <td align="left" valign="top">&nbsp;</td>
                                <td align="left" valign="top">&nbsp;</td>
                                <td align="left" valign="top">&nbsp;</td>
                          </tr>
                            <?php } while ($row_surket_u = mysql_fetch_assoc($surket_u)); ?>
                        </table>
                        <table border="0">
                          <tr>
                            <td><?php if ($pageNum_surket_u > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_surket_u=%d%s", $currentPage, 0, $queryString_surket_u); ?>">Pertama</a>                                
                                <?php } // Show if not first page ?></td>
                            <td><?php if ($pageNum_surket_u > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_surket_u=%d%s", $currentPage, max(0, $pageNum_surket_u - 1), $queryString_surket_u); ?>">Sebelumnya</a>                                
                                <?php } // Show if not first page ?></td>
                            <td><?php if ($pageNum_surket_u < $totalPages_surket_u) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_surket_u=%d%s", $currentPage, min($totalPages_surket_u, $pageNum_surket_u + 1), $queryString_surket_u); ?>">Selanjutnya</a>                                
                                <?php } // Show if not last page ?></td>
                            <td><?php if ($pageNum_surket_u < $totalPages_surket_u) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_surket_u=%d%s", $currentPage, $totalPages_surket_u, $queryString_surket_u); ?>">Terakhir</a>                                
                                <?php } // Show if not last page ?></td>
                          </tr>
                        </table>
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

mysql_free_result($u_j_sur);

mysql_free_result($surket_u);
?>
