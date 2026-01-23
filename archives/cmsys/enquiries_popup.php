<?php  $scriptstore = ".";
include "mysql_link.php";
include $SITE_ROOT."includes/auth.php";
//include "auth.php";
include "vars.php";
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Edinburgh University Library Special Collections" />
<link rel="stylesheet" type="text/css" href="../includes/style.css" />

<title>Enquiry</title>
</head>
<body onunload="window.opener.document.location.reload(true);">
<?php if (!isset ($view)) {
 	 $sql_str="SELECT * FROM enquiries WHERE id=$id";
	 
	  $enqsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 	  
	  $results = mysqli_fetch_array($enqsearch); ?>
      
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET" name="myForm">
    <input name="view" type="hidden" value="update" />
    <input name="id" type="hidden" value="<?php echo $results['id'] ?>" />
    <input name="popup" type="hidden" value="<?php echo $_GET['popup'] ?? '' ?>" />
    <table cellpadding="5" cellspacing="0">
    <tr><td class='label'>Ref.</td><td>SC-ENQ-<?php echo $results['id'] ?></td></tr>
    <tr><td class='label'>Enquirer name</td><td><input name="enquirer_name" type="text" size="50" value="<?php echo $results['enquirer_name'] ?>" /></td></tr>
    <tr><td class='label'>Enquirer email</td><td><input name="enquirer_email" type="text" size="50" value="<?php echo $results['enquirer_email'] ?>" /></td></tr>
        <tr><td class='label'>Enquirer (more)</td><td><textarea name="enquirer_more" cols="80" rows="5"><?php echo $results['enquirer_more'] ?></textarea></td></tr>
    <tr><td class='label'>Subject</td><td><input name="subject" type="text" size="50" value="<?php echo $results['subject'] ?>" /></td></tr>
    <tr><td class='label'>Received</td><td><input name="received" type="text" size="50" value="<?php echo $results['received'] ?>" /> Date in format YYYY-MM-DD</td></tr>
    <tr><td class='label'>Acknowledged</td><td><input name="acknowledged" type="text" size="50" value="<?php echo $results['acknowledged'] ?>" /> Date in format YYYY-MM-DD</td></tr>
    <tr><td class='label'>Assigned to</td><td><input name="assigned" type="text" size="50" value="<?php echo $results['assigned'] ?>" /></td></tr>
    <tr><td class='label'>Completed</td><td><input name="completed" type="text" size="50" value="<?php echo $results['completed'] ?>" /> Date in format YYYY-MM-DD</td></tr>
        <tr><td class='label'>Notes</td><td><textarea name="notes" cols="80" rows="10"><?php echo $results['notes'] ?></textarea></td></tr>
    <tr><td class='label'>Logged by</td><td><?php echo $results['logged_by'] ?></td></tr>
    </table> 
    <input name="" type="submit" value="Update" />   
    </form>
	  
<?php }
elseif ($view == 'update') {

$enquirer_name  = mysqli_real_escape_string($id_link, $_GET['enquirer_name'] ?? null);
$enquirer_email = mysqli_real_escape_string($id_link, $_GET['enquirer_email']) ?? null;
$enquirer_more  = mysqli_real_escape_string($id_link, $_GET['enquirer_more'] ?? null);
$subject        = mysqli_real_escape_string($id_link, $_GET['subject'] ?? null);
$received       = $_GET['received'] ?? null;
$acknowledged   = $_GET['acknowledged'] ?? null;
$completed      = $_GET['completed'] ?? null;
$assigned       = $_GET['assigned'] ?? null;
$logged_by      = $_GET['logged_by'] ?? null;
$notes          = mysqli_real_escape_string($id_link, $_GET['notes'] ?? null);

$sql_str = "UPDATE enquiries SET enquirer_name='$enquirer_name', enquirer_email='$enquirer_email', enquirer_more='$enquirer_more',  subject='$subject', received='$received', acknowledged='$acknowledged',  completed='$completed', notes='$notes' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update entry failed!");

echo "<p><a href='javascript:window.close();'>Close and update main page</a></p>"; 
 }	  
elseif ($view == 'new') {	 ?>

   <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET" name="myForm">
    <input name="view" type="hidden" value="add" />
    <input name="popup" type="hidden" value="<?php echo $_GET['popup'] ?? '' ?>" />
    <table cellpadding="5" cellspacing="0">
    <tr><td class='label'>Enquirer name</td><td><input name="enquirer_name" type="text" size="50" value="<?php echo $results['enquirer_name'] ?? '' ?>" /></td></tr>
    <tr><td class='label'>Enquirer email</td><td><input name="enquirer_email" type="text" size="50" value="<?php echo $results['enquirer_email'] ?? ''  ?>" /></td></tr>
        <tr><td class='label'>Enquirer (more)</td><td><textarea name="enquirer_more" cols="80" rows="5"><?php echo $results['enquirer_more'] ?? ''  ?></textarea></td></tr>
    <tr><td class='label'>Subject</td><td><input name="subject" type="text" size="50" value="<?php echo $results['subject'] ?? '' ?>" /></td></tr>
    <tr><td class='label'>Received</td><td><input name="received" type="text" size="50" value="<?php echo $results['received'] ?? '' ?>" /> Date in format YYYY-MM-DD</td></tr>
    <tr><td class='label'>Acknowledged</td><td><input name="acknowledged" type="text" size="50" value="<?php echo $results['acknowledged'] ?? ''  ?>" /> Date in format YYYY-MM-DD</td></tr>
    <tr><td class='label'>Completed</td><td><input name="completed" type="text" size="50" value="<?php echo $results['completed'] ?? '' ?>" /> Date in format YYYY-MM-DD</td></tr>
    <tr><td class='label'>Assigned to</td><td><input name="assigned" type="text" size="50" value="<?php echo $results['assigned'] ?? '' ?>" /></td></tr>
        <tr><td class='label'>Notes</td><td><textarea name="notes" cols="80" rows="10"><?php echo $results['notes'] ?? ''  ?></textarea></td></tr>
    </table> 
    <input name="" type="submit" value="Add" />   
    </form>
<?php } 
elseif ($view == 'add') {

$enquirer_name  = mysqli_real_escape_string($id_link, $_GET['enquirer_name'] ?? null);
$enquirer_email = mysqli_real_escape_string($id_link, $_GET['enquirer_email'] ?? null);
$enquirer_more  = mysqli_real_escape_string($id_link, $_GET['enquirer_more'] ?? null);
$subject        = mysqli_real_escape_string($id_link, $_GET['subject'] ?? null);
$received       = $_GET['received'] ? $_GET['received'] : date("Y-m-d H:i:s");
$acknowledged   = $_GET['acknowledged'] ? $_GET['acknowledged'] : date("Y-m-d H:i:s");
$completed      = $_GET['completed'] ? $_GET['completed'] : date("Y-m-d H:i:s");
$assigned       = $_GET['assigned'] ? $_GET['assigned'] : date("Y-m-d H:i:s");
$notes          = mysqli_real_escape_string($id_link, $_GET['notes'] ?? null);
$logged_by      = $current_user;

$sql_str = "INSERT INTO enquiries (id, enquirer_name, enquirer_email, enquirer_more, subject, received, acknowledged, assigned, completed, logged_by, notes) VALUES (NULL, '$enquirer_name', '$enquirer_email', '$enquirer_more', '$subject', '$received', '$acknowledged', '$assigned', '$completed', '$logged_by', '$notes')";
mysqli_query($id_link, $sql_str) or die ("Add entry failed!");

echo "<p><a href='javascript:window.close();'>Close and update main page</a></p>"; 
}
	  ?>
</body>
</html>

