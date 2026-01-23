<?php $scriptstore = ".";
include "mysql_link.php";
include $SITE_ROOT."includes/auth.php";
//include "auth.php";
include "vars.php"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Edinburgh University Library Special Collections" />
<link rel="stylesheet" type="text/css" href="../includes/style.css" />

<title>Locations Management</title>
</head>
<body onunload="window.opener.document.location.reload(true);">
<table summary="banner" cellpadding="10" cellspacing="0" width="100%" class="topbanner">
<tr><td width="40%" height="40"><span style="font-size: 13pt; font-weight: bold;">Locations Management</td></tr>
<tr><td colspan="2" bgcolor="#000000" height="10"></td></tr>
<tr><td colspan="2" height="10"></td></tr>
</table>

<?php 	 $sql_str="SELECT * FROM cms_accessions WHERE id =$id";
	 $accsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 $results = mysqli_fetch_array($accsearch);
	 echo "<h2>Accession: ";
	 include "accstyle.php";
	 echo "</h2>";
	 
	 if ($results['acc_type'] == "MS") { echo "<p>Archives and Manuscripts (CLX)</p>"; }
	 
	 $year = $results['year'];
	 $number = $results['accession'];
	 
	 	 $sql_str="SELECT * FROM cms_clx WHERE year like '$year' AND number LIKE '$number' AND deleted <> 'y' ORDER BY type ASC, numb ASC";
		 
$boxsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");

if (!isset ($view)) { $view= "viewloc"; }

if ($view == "viewloc") {

echo "<h3>Current Locations</h3>";

echo "<table cellpadding='5' border='1'>";

echo "<tr><td class='label'>Box</td><td class='label' width='200'>Other</td><td class='label' width='200'>Notes</td><td colspan='2' class='label'>Ammend</tr>";

while ($results2 = mysqli_fetch_array($boxsearch)):


echo "<tr><td>CLX-".$results2['type']."-".$results2['numb']."</td><td>";

if ($results2['unboxed'] <>'') {
echo $results2['unboxed'];
}
echo "</td><td>";

if ($results2['notes'] <>'') {
echo $results2['notes'];
}

echo "</td><td>[<a href='".$_SERVER['PHP_SELF']."?popup=locations&amp;id=".$id."&amp;view=delloc&amp;locid=".$results2['id']."'>Remove</a>]</td><td>[<a href='".$_SERVER['PHP_SELF']."?popup=locations&amp;id=".$id."&amp;view=editloc&amp;locid=".$results2['id']."'>Edit</a>]</td></td></tr>";

endwhile;
echo "</table>";

?>
<hr />

<h3>Add a location</h3>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>">
<input type="hidden" name="view" value="addloc" />
<input type="hidden" name="id" value="<?php echo $id ?>" />
<input type="hidden" name="year" value="<?php echo $year ?>" />
<input type="hidden" name="number" value="<?php echo $number ?>" />
<input type="hidden" name="popup" value="locations" />
<table>
<tr>
<td>CLX - </td>
<td>
<select name="type">
<option value="A">A</option>
<option value="D">D</option>
<option value="F">F</option>
<option value="G">G</option>
<option value="AP">AP</option>
<option value="DP">DP</option>
<option value="FP">FP</option>
<option value="GP">GP</option>
<option value="other">other</option>
</select> - 
</td>
<td><input name="numb" type="text" /></td>
</tr>
<tr><td colspan="2">Other</td><td>
<textarea name="other" cols="30" rows="2"></textarea>
</td></tr>
<tr><td colspan="2">Notes</td><td>
<textarea name="notes" cols="30" rows="2"></textarea>
</td></tr>
</table>
<input name="" type="submit" value="Enter">
</form>

<?php }

elseif ( $view == "delloc" ) { 

echo "<h3>Deleting</h3>";

echo "<p>Deleting ... Please <a href='".$_SERVER['PHP_SELF']."?popup=locations&amp;id=".$id."'>Refresh page</a></p>";

$locid= $_GET['locid'];

$del_str="UPDATE cms_clx SET deleted ='y' WHERE id='$locid' LIMIT 1";

mysqli_query($del_str); }

elseif ( $view == "addloc" ) { echo "<p>Adding ... Please <a href='".$_SERVER['PHP_SELF']."?popup=locations&amp;id=".$id."'>Refresh page</a></p>";

$type = $_GET['type'];
$numb = $_GET['numb'];
$other = $_GET['other'];
$notes = $_GET['notes'];

$sql_str="INSERT INTO cms_clx(year, number, type, numb, unboxed, notes) VALUES  ('$year','$number','$type','$numb', '$other', '$notes')";


mysqli_query($id_link, $sql_str);  

} 

elseif ($view == "editloc") {

echo "<h3>Edit Location</h3>";

$locid= $_GET['locid'];

	 	 $sql_str="SELECT * FROM cms_clx WHERE id = '$locid'";
		 
$boxsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");

$results2 = mysqli_fetch_array($boxsearch);   ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>">
<input type="hidden" name="view" value="updateloc" />
<input type="hidden" name="id" value="<?php echo $id ?>" />
<input type="hidden" name="locid" value="<?php echo $locid ?>" />
<input type="hidden" name="year" value="<?php echo $year ?>" />
<input type="hidden" name="number" value="<?php echo $number ?>" />
<input type="hidden" name="popup" value="locations" />
<table>
<tr>
<td>CLX - </td>
<td>
<select name="type">
<option value="<?php echo $results2['type'] ?>">A</option>
<option value="A">A</option>
<option value="D">D</option>
<option value="F">F</option>
<option value="G">G</option>
<option value="AP">AP</option>
<option value="DP">DP</option>
<option value="FP">FP</option>
<option value="GP">GP</option>
<option value="other">other</option>
</select> - 
</td>
<td><input name="numb" type="text" value="<?php echo $results2['numb'] ?>" /></td>
</tr>
<tr><td colspan="2">Other</td><td>
<textarea name="other" cols="30" rows="2"><?php echo $results2['other'] ?></textarea>
</td></tr>
<tr><td colspan="2">Notes</td><td>
<textarea name="notes" cols="30" rows="2"><?php echo $results2['notes'] ?></textarea>
</td></tr>
</table>
<input name="" type="submit" value="Enter">
</form>

<?php } 

elseif ($view == "updateloc") {

echo "<h3>Updating</h3>";

echo "<p>Updating ... Please <a href='".$_SERVER['PHP_SELF']."?popup=locations&amp;id=".$id."'>Refresh page</a></p>";

$locid = $_GET['locid'];
$type = $_GET['type'];
$numb = $_GET['numb'];
$other = $_GET['other'];
$notes = $_GET['notes'];

$sql_str= "UPDATE cms_clx SET year = '$year', number = '$number', type = '$type', numb = '$numb', unboxed = '$other', notes = '$notes' WHERE id ='$locid' LIMIT 1";

mysqli_query($id_link, $sql_str);  
}
 ?>
</body>