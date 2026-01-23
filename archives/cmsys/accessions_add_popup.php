<?php  $scriptstore = ".";
include "mysql_link.php";
include $SITE_ROOT."includes/auth.php";
//include "auth.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Edinburgh University Library Special Collections" />
<link rel="stylesheet" type="text/css" href="../includes/style.css" />
<title>Add accession</title>
</head>
<body>
<?php

$view = $_GET['view'];
$acc_type = $_GET['acc_type'];

echo "New accession";

if ($view == "new") { 
echo "<p>Fields marked with <b>**</b> must be completed.</p>";
## display different forms dependant on accession type to be added


## begin EUA form
if ($acc_type == "EUA") {

?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
<table width='90%' cellpadding='5' class='detail'>
<tr><td class='label' width='150'>Year</td><td>
<?php $current_year  = date("Y"); 
echo $current_year; ?>
<input name="popup" type="text" value="<?php echo $_GET['popup'] ?? '' ?>" />
<input name="view" type="hidden" value="review" />
<input name="year" type="hidden" value="<?php echo $current_year ?>" />
</td></tr>
<?php
## get next available accession number for current year

$sql_str="SELECT * FROM cms_accessions WHERE acc_type LIKE '$acc_type' AND year='$current_year' ORDER BY accession DESC LIMIT 1";
	 $accsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 $result = mysqli_fetch_array($accsearch);
	 $next_acc = $result['accession'] + 1;

?>
<tr><td class='label'>Accession</td><td><?php echo $next_acc ?><input name="accession" type="hidden" value="<?php echo $next_acc ?>" /></td></tr>
<tr><td class='label'>Accession Type</td><td><?php echo $acc_type ?></td></tr>
<tr><td class='label'>Description **</td><td><textarea name="description" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Creator</td><td><input name="creator" type="text" size="98" /></td></tr>
<tr><td class='label'>Donor/Depositor **</td><td><textarea name="depositor" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Ownership</td><td>
<select name="type">
<option value="transfer">Transfer (internal)</option>
<option value="donation">Donation (external)</option>
<option value="loan_i">Loan (internal)</option>
<option value="loan_e">Loan (external)</option>
<option value="purchase">Purchase</option>
</select>
</td></tr>
<tr><td class='label'>Conditions</td><td><textarea name="conditions" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Copyright</td><td><textarea name="copyright" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Access Restrictions</td><td><textarea name="restrictions" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Extent</td><td><input name="extent" type="text" size="98" /></td></tr>
<tr><td class='label'>Physical Condition</td><td><textarea name="phys_cond" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Comments</td><td><textarea name="comments" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Documentation</td><td><textarea name="documentation" cols="80" rows="3"></textarea></td></tr>
</table>
<input name="func" type="hidden" value="accessions" />
<input name="acc_type" type="hidden" value="EUA" />
<input name="" type="submit" value="Continue" />
</form>
<?php }
## end of EUA form

## begin MS form

elseif ($acc_type == "MS") {

?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
<table width='90%' cellpadding='5' class='detail'>
<tr><td class='label' width='150'>Year</td><td>
<?php $current_year  = date("Y"); 
echo $current_year; ?>
<input name="view" type="hidden" value="review" />
<input name="year" type="hidden" value="<?php echo $current_year ?>" />
</td></tr>
<?php
## get next available accession number for current year

$sql_str="SELECT * FROM cms_accessions WHERE acc_type LIKE '$acc_type' AND year='$current_year' ORDER BY accession DESC LIMIT 1";
	 $accsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 $result = mysqli_fetch_array($accsearch);
	 $next_acc = $result['accession'] + 1;

?>
<tr><td class='label'>Accession</td><td><?php echo $next_acc ?><input name="accession" type="hidden" value="<?php echo $next_acc ?>" /></td></tr>
<tr><td class='label'>Accession Type</td><td><?php echo $acc_type ?></td></tr>
<tr><td class='label'>Description **</td><td><textarea name="description" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Creator</td><td><input name="creator" type="text" size="98" /></td></tr>
<tr><td class='label'>Donor/Depositor **</td><td><textarea name="depositor" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Ownership</td><td>
<select name="type">
<option value="donation">Donation</option>
<option value="deposit">Deposit</option>
<option value="purchase">Purchase</option>
</select>
</td></tr>
<tr><td class='label'>Conditions</td><td><textarea name="conditions" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Copyright</td><td><textarea name="copyright" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Access Restrictions</td><td><textarea name="restrictions" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Extent</td><td><input name="extent" type="text" size="98" /></td></tr>
<tr><td class='label'>Physical Condition</td><td><textarea name="phys_cond" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Comments</td><td><textarea name="comments" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Documentation</td><td><textarea name="documentation" cols="80" rows="3"></textarea></td></tr>
</table>
<input name="func" type="hidden" value="accessions" />
<input name="acc_type" type="hidden" value="<?php echo $acc_type ?>" />
<input name="" type="submit" value="Continue" />
</form>
<?php }
## end of MS form

## begin RBP form

elseif ($acc_type == "RBP") {

?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
<table width='90%' cellpadding='5' class='detail'>
<tr><td class='label' width='150'>Year</td><td>
<?php $current_year  = date("Y"); 
echo $current_year; ?>
<input name="view" type="hidden" value="review" />
<input name="year" type="hidden" value="<?php echo $current_year ?>" />
</td></tr>
<?php
## get next available accession number for current year

$sql_str="SELECT * FROM cms_accessions WHERE acc_type LIKE '$acc_type' AND year='$current_year' ORDER BY accession DESC LIMIT 1";
	 $accsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 $result = mysqli_fetch_array($accsearch);
	 $next_acc = $result['accession'] + 1;

?>
<tr><td class='label'>Accession</td><td><?php echo $next_acc ?><input name="accession" type="hidden" value="<?php echo $next_acc ?>" /></td></tr>
<tr><td class='label'>Accession Type</td><td><?php echo $acc_type ?></td></tr>
<tr><td class='label'>Title/Description **</td><td><textarea name="description" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Author</td><td><input name="creator" type="text" size="98" /></td></tr>
<tr><td class='label'>Donor/Depositor **</td><td><textarea name="depositor" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Ownership</td><td>
<select name="type">
<option value="donation">Donation</option>
<option value="deposit">Deposit</option>
<option value="purchase">Purchase</option>
</select>
</td></tr>
<tr><td class='label'>Conditions</td><td><textarea name="conditions" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Copyright</td><td><textarea name="copyright" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Access Restrictions</td><td><textarea name="restrictions" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Extent</td><td><input name="extent" type="text" size="98" /></td></tr>
<tr><td class='label'>Physical Condition</td><td><textarea name="phys_cond" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Comments</td><td><textarea name="comments" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Documentation</td><td><textarea name="documentation" cols="80" rows="3"></textarea></td></tr>
<tr><td class='label'>Shelfmark</td><td><input name="shelfmark" type="text" size="98" /></td></tr>
</table>
<input name="func" type="hidden" value="accessions" />
<input name="acc_type" type="hidden" value="<?php echo $acc_type ?>" />
<input name="" type="submit" value="Continue" />
</form>
<?php }
## end RBP form 
else {

echo "</p>No accession type selected</p>";

}
## end accession type option

}
elseif ($view == "review") {

echo "<h3>Review</h3><p>Please review below</p>";

$year = date("Y");
if ($_GET['acc_type'] == "EUA") {
$y = substr($year, -2);
$a = sprintf("%03d",$_GET['accession']); 

$acc_str = "Acc.".$y."/".$a;
}
elseif ($_GET['acc_type'] == "MS") {
$acc_str = "E.".$_GET['year'].".".$_GET['accession'];
}
elseif ($_GET['acc_type'] == "Book/Publication") {
$acc_str = $_GET['year'].".".$_GET['accession'];
}

echo "<p>".$acc_str."</p>";

if (($_GET['description']) == '') { $proceed = "n"; }
if (($_GET['depositor']) == '') { $proceed = "n"; }

if ($proceed == 'n') {  echo "<p>Fields marked with <b>**</b> must be completed.</p>"; }
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
<table width='90%' cellpadding='5' class='detail'>
<tr><td class='label' width='150'>Year</td><td>
<?php $current_year  = date("Y"); 
echo $current_year; 

if ($proceed == 'n') {
$vw = "review";
 } else {
$vw = "add";
}
 ?>
<input name="view" type="hidden" value="<?php echo $vw; ?>" />
<input name="year" type="hidden" value="<?php echo $current_year ?>" />
</td></tr>
<tr><td class='label'>Accession</td><td><?php echo $_GET['accession'] ?><input name="accession" type="hidden" value="<?php echo $_GET['accession'] ?>" /></td></tr>
<tr><td class='label'>Accession Type</td><td><?php echo $acc_type ?></td></tr>
<tr><td class='label'>Description **</td><td><textarea name="description" cols="80" rows="3"><?php echo $_GET['description'] ?></textarea></td></tr>
<tr><td class='label'>Creator</td><td><input name="creator" type="text" size="98" value="<?php echo $_GET['creator'] ?>" /></td></tr>
<tr><td class='label'>Donor/Depositor **</td><td><textarea name="depositor" cols="80" rows="3"><?php echo $_GET['depositor'] ?></textarea></td></tr>
<tr><td class='label'>Ownership</td><td>

<?php if (($_GET['type']) == 'transfer') { $type_val="Transfer (internal)"; }
elseif (($_GET['type']) == 'donation') { $type_val="Donation (external)"; }
elseif (($_GET['type']) == 'loan_i') { $type_val="Loan (internal)"; }
elseif (($_GET['type']) == 'loan_e') { $type_val="Loan (external)"; }
elseif (($_GET['type']) == 'deposit') { $type_val="Deposit"; }
elseif (($_GET['type']) == 'purchase') { $type_val="Purchase"; }
?>
<select name="type">
<option value="<?php echo $_GET['type'] ?? '' ?>"><?php echo $type_val ?></option>
<?php if ($acc_type == 'EUA') { ?>
<option value="transfer">Transfer (internal)</option>
<option value="donation">Donation (external)</option>
<option value="loan_i">Loan (internal)</option>
<option value="loan_e">Loan (external)</option>
<option value="purchase">Purchase</option>

<?php
}
else { ?>
<option value="donation">Donation</option>
<option value="deposit">Deposit</option>
<option value="purchase">Purchase</option>

<?php
}
?>
</select>
</td></tr>
<tr><td class='label'>Conditions</td><td><textarea name="conditions" cols="80" rows="3"><?php echo $_GET['conditions'] ?></textarea></td></tr>
<tr><td class='label'>Copyright</td><td><textarea name="copyright" cols="80" rows="3"><?php echo $_GET['copyright'] ?></textarea></td></tr>
<tr><td class='label'>Access Restrictions</td><td><textarea name="restrictions" cols="80" rows="3"><?php echo $_GET['restrictions'] ?></textarea></td></tr>
<tr><td class='label'>Extent</td><td><input name="extent" type="text" size="98" value="<?php echo $_GET['extent'] ?>" /></td></tr>
<tr><td class='label'>Physical Condition</td><td><textarea name="phys_cond" cols="80" rows="3"><?php echo $_GET['phys_cond'] ?></textarea></td></tr>
<tr><td class='label'>Comments</td><td><textarea name="comments" cols="80" rows="3"><?php echo $_GET['comments'] ?></textarea></td></tr>
<tr><td class='label'>Documentation</td><td><textarea name="documentation" cols="80" rows="3"><?php echo $_GET['documentation'] ?></textarea></td></tr>
<?php if ($acc_type == 'RBP') { ?>
<tr><td class='label'>Shelfmark</td><td><input name="extent" type="text" size="98" value="<?php echo $_GET['shelfmark'] ?>" /></td></tr>
<?php } ?>
</table>
<input name="func" type="hidden" value="accessions" />
<input name="acc_type" type="hidden" value="<?php echo $acc_type ?>" />
<input name="" type="submit" value="Continue" />
</form>

<?php 

}
elseif ($view == "add") 
{

$year          = $_GET['year'] ?? date('Y');
$accession     = $_GET['accession'];
$acc_type      = $_GET['acc_type'];
$description   = htmlentities(($_GET['description']), ENT_QUOTES);
$creator       = htmlentities(($_GET['creator']), ENT_QUOTES);
$depositor     = htmlentities(($_GET['depositor']), ENT_QUOTES);
$type          = $_GET['type'];
$conditions    = htmlentities(($_GET['conditions']), ENT_QUOTES);
$copyright     = htmlentities(($_GET['copyright']), ENT_QUOTES);
$restrictions  = htmlentities(($_GET['restrictions']), ENT_QUOTES);
$extent        = $_GET['extent'];
$phys_cond     = htmlentities(($_GET['phys_cond']), ENT_QUOTES);
$comments      = htmlentities(($_GET['comments']), ENT_QUOTES);
$documentation = htmlentities(($_GET['documentation']), ENT_QUOTES);
$shelfmark     = $_GET['shelfmark'];
$acc_by        = $current_user." (".$display_user.")";
$acc_date      = date('d M Y');

echo "<h3>Accession added</h3>";

$sql_str="INSERT INTO cms_accessions (year, accession, acc_type, description, creator, depositor, type, conditions, copyright, restrictions, extent, phys_cond, comments, acc_by, acc_date, documentation, shelfmark) VALUES  ('$year','$accession','$acc_type','$description','$creator','$depositor','$type','$conditions','$copyright','$restrictions','$extent','$phys_cond','$comments', '$acc_by', '$acc_date', '$documentation','$shelfmark')";

##  echo "<p>".$sql_str."</p>";
		mysqli_query($id_link, $sql_str) or die("Insert failed!<br />" . mysql_error());
		
	$sql_str="SELECT * FROM cms_accessions WHERE acc_type LIKE '$acc_type' AND year='$year' AND accession LIKE '$accession'";
	 $accsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 $result = mysqli_fetch_array($accsearch);
	 $vid = $result['id'];
	 echo "<p><a href='".$_SERVER['PHP_SELF']."?func=accessions&amp;view=viewacc&amp;id=".$result['id']."'>Go to the accession you have just added</p>";	
		
} ?>

</body>
</html>

