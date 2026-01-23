<?php include "../../../../mgt_config/sql.php"; 
 mysqli_query($id_link, $sql_str);
 $id = $_GET['id'];
 $view = $_GET['view'];
 $linkid = $_GET['linkid'];
 $tableid = $_GET['tableid'];
 $tablename = $_GET['tablename'];
 $notetext = $_GET['notetext'];
 $createdby = $_GET['createdby'];
 $createddate = $_GET['createddate'];
 
 include "../../includes/auth.php";
 
  ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>Note</title>
<link rel="stylesheet" type="text/css" href="../../includes/style.css" />
</head>
<body> 
<table summary="banner" cellpadding="10" cellspacing="0" width="100%" class="topbanner">
<tr><td width="40%" height="40"><span style="font-size: 13pt; font-weight: bold;"></td></tr>
<tr><td colspan="2" bgcolor="#000000" height="10"></td></tr>
<tr><td colspan="2" height="10"></td></tr>
</table>



<?php
if ($edit_permissions ==  "y") {

if ($view == "add") {

echo "<h1>Add Note</h1>"; ?>
<table summary="" cellpadding='5' class='detail'>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
<input type="hidden" name="linkid" value="<?php echo $id ?>" />
<input type="hidden" name="tableid" value="<?php echo $tableid ?>" />
<input type="hidden" name="tablename" value="<?php echo $tablename ?>" />
<input type="hidden" name="view" value="add_review" />
<tr><td><textarea rows="4" cols="120" name="notetext"></textarea></td></tr>
<tr><td><input type="submit" value="Next" /></td></tr>
</form>
</table>

<?php }
elseif ($view == "add_review") {
echo "<h1>Your Note</h1>";
echo "<p>".$notetext."</p>";
$now = date("Y-m-d H:i:s");
 ?>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
<input type="hidden" name="tableid" value="<?php echo $tableid ?>" />
<input type="hidden" name="tablename" value="<?php echo $tablename ?>" />
<input type="hidden" name="view" value="add_update" />
<input type="hidden" name="createdby" value="<?php echo $_SERVER['REMOTE_USER'] ?? $LOCAL_USER ?? null; ?>" />
<input type="hidden" name="createddate" value="<?php echo $now ?>" />
<input type="hidden" name="notetext" value="<?php echo $notetext ?>" />
<input type="submit" value="Add this note" />&nbsp;&nbsp;
<input type="button" value="Abandon" onClick="javascript:window.close();">
</form>

<?php }
elseif ($view == "add_update") {

		$sql_str="INSERT INTO notes VALUES (NULL, '$tablename', '$tableid', '$notetext', '$createdby', '$createddate')";
		mysqli_query($id_link, $sql_str) or die("Insert failed!");
		echo "<p>Note successfully added.  Click on the button below to close this window and refresh the main page.</p>";
		
		
echo "<form><input type='button' value='Close this window' onClick='window.opener.document.location.reload();window.close();'></form>";
}
elseif ($view == "delete") {
	 $sql_str="SELECT * FROM notes WHERE id=$id";
	 $notesearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");

echo "<h1>Delete Note</h1>"; 
echo "<table cellpadding='5' width='100%' class='detail'>";

$results = mysqli_fetch_array($notesearch);

echo "<tr><td class='label' width='150'>Note</td><td>".$results['notetext']."</td></tr>";
echo "<tr><td class='label'>Created by</td><td>".$results['createdby']."</td></tr>";
echo "<tr><td class='label'>Date created</td><td>".$results['createddate']."</td></tr>";
echo "</table>";
?>

<p>Delete this note?</p>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
<input type="hidden" name="id" value="<?php echo $id ?>" />
<input type="hidden" name="view" value="delete_review" />
<input type="submit" value="Yes" onclick="" />
&nbsp;&nbsp;
<input type="button" value=" No " onClick="javascript:window.close();">
</form>

<?php }
elseif ( $view == "delete_review" ) { ?>
<p>Are you sure?  Clicking 'Yes' will remove this note from the database.</p>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
<input type="hidden" name="id" value="<?php echo $id ?>" />
<input type="hidden" name="view" value="delete_update" />
<input type="submit" value="Yes" onclick="" />
&nbsp;&nbsp;
<input type="button" value=" No " onClick="javascript:window.close();">
</form>

<?php  }
elseif  ($view == "delete_update") {
$sql_del = "DELETE FROM notes WHERE id='$id'";

$finalise = mysqli_query($sql_del) or die("Delete $id Failed!");
echo "<p>Note deleted</p>";

echo "<form><input type='button' value='Close this window' onClick='window.opener.document.location.reload();window.close();'></form>";
} 

}
elseif ($view == 'assoc') {
echo "Here's where you would associate your accession with a collection - function coming soon";
}
else {

echo "<p>Sorry, you do not have sufficient permission to do this.  You are </p>";
}?>
</body>
</html>
