<?php $scriptstore = "/home/lib/lacddt/cmsys/archives/cmsys/";
include $scriptstore."mysql_link.php";
include "../includes/auth.php";
include "/home/lib/lacddt/cmsys/archives/cmsys/auth.php";
include $scriptstore."vars.php"; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Edinburgh University Library Special Collections" />
<link rel="stylesheet" type="text/css" href="../includes/style.css" />

<title>Collection</title>
</head>
<body onunload="window.opener.document.location.reload(true);">
abc
<?php
if ($view == "edit") {
	 $sql_str="SELECT * FROM cms_collections WHERE coll=$coll";

	 $collsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($collsearch);
echo "<h3>Editing: ".$results['title']."</h3>";

echo "<table width='90%' cellpadding='5' class='detail'>";
echo "<form action='".$_SERVER['PHP_SELF']."' method='GET'>";
echo "<input type='hidden' name='popup' value='collections' />";
echo "<input type='hidden' name='view' value='edit_review' />";
echo "<input type='hidden' name='coll' value='".$results['coll']."' />";
echo "<tr><td class='label' width='150'>Reference code:</td><td>Coll-".$results['coll']."</td></tr>";
echo "<tr><td class='label'>Alt. reference code</td><td><input name='alt' size='40' value='".$results['alt']."' /></td></tr>";
echo "<tr><td class='label'>Title</td><td><input name='title' size='90' value='".$results['title']."' /></td></tr>";
echo "<tr><td class='label'>Creator</td><td><input name='creator' size='90' value='".$results['creator']."' /></td></tr>";
echo "<tr><td class='label'>Locations</td><td><input name='shelf' size='90' value='".$results['shelf']."' /></td></tr>";
echo "<tr><td class='label'>Description public</td><td><select name='public'>";
echo "<option value='".$results['public']."' selected='selected'>".$results['public']."</option>";
if (($results['public']) == 'n') {
echo "<option value='y'>y</option>";
} elseif (($results['public']) == 'y') {
echo "<option value='n'>n</option>";
}
else {
echo "<option value='y'>y</option><option value='n'>n</option>";
}
echo "</select></td></tr>";

echo "<tr><td  colspan='2' align='right' style='border-top: thin solid #000000;'>";
echo "<input type='submit' value='Update' /></td></tr>";
echo "</form>";
echo "</table>";

}

elseif ($view == "edit_review") {
echo "<h3>Reviewing: Coll-".$coll."</h3>";

echo "<p style='color: red;'><b>Please check all information below</b>.  Click on button <b>Update</b> to confirm or <b>Go Back</b> to change anything.</p>";

echo "<table width='90%' cellpadding='5' class='detail'>";
echo "<tr><td class='label' width='150'>Reference code</td><td>Coll-".$coll."</td></tr>";
echo "<tr><td class='label'>Alt. reference code</td><td>".$alt."</td></tr>";
echo "<tr><td class='label'>Title</td><td>".$title."</td></tr>";
echo "<tr><td class='label'>Creator</td><td>".$creator."</td></tr>";
echo "<tr><td class='label'>Locations</td><td>".$shelf."</td></tr>";
echo "<tr><td class='label'>Description public</td><td>".$public."</td></tr>";
echo "<tr><td  colspan='2' align='right' style='border-top: thin solid #000000;'>";

echo "<form action='".$_SERVER['PHP_SELF']."' method='GET'>";
echo "<input type='hidden' name='popup' value='collections' />";
echo "<input type='hidden' name='view' value='edit_update' />";
echo "<input type='hidden' name='coll' value='".$coll."' />";
echo "<input type='hidden' name='alt' value='".$alt."' />";
echo "<input type='hidden' name='title' value='".$title."' />";
echo "<input type='hidden' name='creator' value='".$creator."' />";
echo "<input type='hidden' name='shelf' value='".$shelf."' />";
echo "<input type='hidden' name='public' value='".$public."' />";
echo "<input type='submit' value='Update' />";
echo "</form>";
echo "</td></tr>"; 
echo "</table>";?>

<input type=button value="Go Back" onClick="history.go(-1)">

<?php  }
elseif ($view == "edit_update") {

$sql_str="UPDATE cms_collections SET alt='$alt', creator='$creator', title='$title', shelfmarks='$shelf', public='$public' WHERE coll='$coll' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update failed!");
echo "Update successful.";
}

## ADDING COLLECTIONS ##

## add a new collection
elseif ($view == "add") {

echo "<h3>Add a New Collection</h3>";
## find highest existing coll number and add 1
$sql_str="SELECT coll FROM cms_collections ORDER BY coll DESC LIMIT 1";
$collsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$result = mysqli_fetch_array($collsearch);


echo "<table width='90%' cellpadding='5' class='detail'>";
echo "<form action='".$_SERVER['PHP_SELF']."' method='GET'>";
echo "<input type='hidden' name='popup' value='collections' />";
echo "<input type='hidden' name='view' value='add_review' />";
echo "<input type='hidden' name='coll' value='".($result['coll']+1)."' />";
echo "<tr><td class='label' width='150'>Reference code:</td><td>Coll-".($result['coll']+1)."</td></tr>";
echo "<tr><td class='label'>Alt. reference code</td><td><input name='alt' size='40' /></td></tr>";
echo "<tr><td class='label'>Title</td><td><input name='title' size='90' /></td></tr>";
echo "<tr><td class='label'>Creator</td><td><input name='creator' size='90' /></td></tr>";
echo "<tr><td class='label'>Locations</td><td><input name='shelf' size='90' /></td></tr>";
echo "<tr><td class='label'>Description public</td><td><select name='public'>";
echo "<option value='y'>y</option><option value='n'>n</option>";
echo "</select></td></tr>";
echo "<tr><td  colspan='2' align='right' style='border-top: thin solid #000000;'>";
echo "<input type='submit' value='Add Collection' /></td></tr>";
echo "</form>";
echo "</table>";
}
## review collection being added
elseif ($view == "add_review") {
echo "<h3>Reviewing: Coll-".$coll."</h3>";

echo "<table width='90%' cellpadding='5' class='detail'>";
echo "<tr><td class='label' width='150'>Reference code</td><td>Coll-".$coll."</td></tr>";
echo "<tr><td class='label'>Alt. reference code</td><td>".$alt."</td></tr>";
echo "<tr><td class='label'>Title</td><td>".$title."</td></tr>";
echo "<tr><td class='label'>Creator</td><td>".$creator."</td></tr>";
echo "<tr><td class='label'>Locations</td><td>".$shelf."</td></tr>";
echo "<tr><td class='label'>Description public</td><td>".$public."</td></tr>";
echo "<tr><td  colspan='2' align='right' style='border-top: thin solid #000000;'>";
echo "<form action='".$_SERVER['PHP_SELF']."' method='GET'>";
echo "<input type='hidden' name='popup' value='collections' />";
echo "<input type='hidden' name='view' value='add_update' />";
echo "<input type='hidden' name='coll' value='".$coll."' />";
echo "<input type='hidden' name='alt' value='".$alt."' />";
echo "<input type='hidden' name='title' value='".$title."' />";
echo "<input type='hidden' name='creator' value='".$creator."' />";
echo "<input type='hidden' name='shelf' value='".$shelf."' />";
echo "<input type='hidden' name='public' value='".$public."' />";
echo "<input type='submit' value='Update' />";
echo "</form>";
echo "</td></tr>";
echo "</table>";

 ?>


<input type=button value="Go Back" onClick="history.go(-1)">

