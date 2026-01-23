<?php  ##include "../../mgt_config/sql.php";
$scriptstore = "../../archives/cmsys/";
include $scriptstore."mysql_link.php";
$func = $_GET['func'];
$view = $_GET['view'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body, p, td {
font-family:Arial, Helvetica, sans-serif;
font-size: 10pt;
}
h1 {
font-size: 16pt;
}
td {
vertical-align:top;
}
div.content { 
min-height: 500px; 
}
</style>
<title>User Services Interface: <?php echo $subtitle ?></title>
</head>
<body>
<table width="100%" cellpadding="5" cellspacing="0" border="0">
<tr><td style="font-size: 24pt; background-color:#CCCC99">User Services Interface</td><td style="text-align: right; background-color:#CCCC99">Please address any questions to<br />Grant Buttars</td></tr>
</table>

<?php if (isset ($func)) { ?>
<div class="crumbs"><a href="./">Home</a></div>
<?php } ?>
<div class="content">
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td>
    <strong>Live catalogue</strong>
    <ul>
    <li><a href="http://archives.collections.ed.ac.uk" target="_blank">Public catalogue</a></li>
    <li><a href="http://aspaceadmin.collections.ed.ac.uk" target="_blank">Internal catalogue</a></li>
    
    </ul>
    </td>
    <td>
    <strong>Legacy</strong>
    <ul>
    <li><a href="./?func=accreg">Digitised MS Accessions Registers, 1953-2003</a></li>
    <li><a href="./?func=accessionsToLocations">Accessions to Locations</a></li>
    <li><a href="./?func=shelfmarksToAccessions">Shelfmarks to Accessions</a></li>
    </ul></td>
  </tr>
</table>
<hr color="#CCCC99" size="10px" />

<?php include "../../usi/".$func.".php"; ?>




</div>
<hr color="#CCCC99" size="10px" />
This interface is currently under development
</body>
</html>
