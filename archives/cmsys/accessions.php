<?php  $scriptstore = "/home/lib/lacddt/cmsys/archives/cmsys/";
include $scriptstore."mysql_link.php";
//include "../includes/auth.php";
include "/home/lib/lacddt/cmsys/archives/cmsys/auth.php"; 
include "vars.php";

 echo "<h2>Accessions</h2>";

$today = date("d-m-Y");
## display menu
if (!isset ($view)) { 
echo "<h3>Advanced Search</h3>"; ?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<table>
<tr>
<td class="formlabel">Text</td>
<td class="formlabel">Type</td>
<td class="formlabel">Year</td>
</tr>
<tr>
<td class="formcontent">
<input type="hidden" name="func" value="accessions" />
<input type="hidden" name="view" value="advlist" />
<input type="text" name="searchterm" /> 
</td>
<td class="formcontent">
<select name="acc_type">
<option value="">All</option>
<option value="EUA">EUA</option>
<option value="MS">MS</option>
<option value="RBP">RBP</option>
</select>
</td>
<td class="formcontent">
<select name="year">
<option value="">All</option>
<?php 	 $sql_str="SELECT DISTINCT year FROM cms_accessions ORDER BY year ASC";
	 $yearsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 while ($results = mysqli_fetch_array($yearsearch)):
	 echo "<option value='".$results['year']."'>".$results['year']."</option>";
	 endwhile; ?>
</select>
<input type="submit" value="Search" />
</form></td>
</tr>
<tr>
</table>
<?php }
elseif ($view == 'advlist') {
echo "coming soon";
}
elseif ($view == 'searchlist') {

	 $sql_str="SELECT * FROM cms_accessions WHERE description LIKE '%$searchterm%' ORDER BY year ASC, accession ASC";
	 $accsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 include "cms.accstyle.php";
echo "<table width='90%' cellpadding='5' class='detail'>";	 	 
	 while ($results = mysqli_fetch_array($accsearch)):
echo "<tr><td class='label' width='150'>";
include "accstyle.php";
echo "</td><td><a href=\"javascript:popUp('popups/popup.php?popup=accessions&amp;view=viewacc&amp;id=".$results['id']."')\">".$results['description']."</a></td></tr>";
	 endwhile;
echo "</table>";
	 
}
elseif ($view == 'viewacc') {

echo "<h3></h3>";

	 $sql_str="SELECT * FROM cms_accessions WHERE id=$id";
	 $accsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");	 
	 $results = mysqli_fetch_array($accsearch);
	 
echo "<h3>";
include "accstyle.php";
echo "</h3>";
echo "<table width='90%' cellpadding='5' class='detail'>";
echo "<tr><td class='label' width='150'>Year</td><td>".$results['year']."</td></tr>";
echo "<tr><td class='label'>Accession</td><td>".$results['accession']."</td></tr>";
echo "<tr><td class='label'>Accession Type</td><td>".$results['acc_type']."</td></tr>";
echo "<tr><td class='label'>Description</td><td>".$results['description']."</td></tr>";
echo "<tr><td class='label'>Creator</td><td>".$results['creator']."</td></tr>";
echo "<tr><td class='label'>Donor/Depositor</td><td>".$results['depositor']."</td></tr>";
echo "<tr><td class='label'>Ownership</td><td>".$results['type']."</td></tr>";
echo "<tr><td class='label'>Conditions</td><td>".$results['conditions']."</td></tr>";
echo "<tr><td class='label'>Copyright</td><td>".$results['copyright']."</td></tr>";
echo "<tr><td class='label'>Access Restrictions</td><td>".$results['restrictions']."</td></tr>";
echo "<tr><td class='label'>Extent</td><td>".$results['extent']."</td></tr>";
echo "<tr><td class='label'>Physical Condition</td><td>".$results['phys_cond']."</td></tr>";
echo "<tr><td class='label'>Comments</td><td>".$results['comments']."</td></tr>";
echo "<tr><td class='label'>Further Comments</td><td>".$results['comments2']."</td></tr>";
echo "<tr><td class='label'>Documentation</td><td>".$results['documentation']."</td></tr>";
echo "<tr><td class='label'>Accesssioned by</td><td>".$results['acc_by']."</td></tr>";
echo "<tr><td class='label'>Accession date</td><td>".$results['acc_date']."</td></tr>";
if ($results['coll'] <> '') {
echo "<tr><td class='label'>Collection</td><td><a href='".$_SERVER['PHP_SELF']."?func=collections&amp;view=viewcoll&amp;coll=".$results['coll']."'>".$results['coll']."</a></td></tr>";
}
if ($results['acc_type'] == 'RBP') {
if ($results['shelfmark'] <> '') {
echo "<tr><td class='label'>Shelfmark</td><td>".$results['shelfmark']."</td></tr>";
}
}
echo "</table>"; ?>

<form><input type=button value="Associate this with a collection" onClick="javascript:popUp('cms/popups/note.php?view=assoc&amp;id=<?php echo $results['id'] ?>')"></form>


	 
<?php 	 if (($results['acc_type']) == "MS") {

$year = $results['year'];
$number = $results['accession'];
	 
	 	 $sql_str="SELECT * FROM cms_clx WHERE year like '$year' and number LIKE '$number' AND deleted <> 'y' ORDER BY type ASC, numb ASC";

$boxsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");


echo "<h3>Locations</h3>";
echo "<table cellspacing='5' border='0'>";

while ($results2 = mysqli_fetch_array($boxsearch)):


echo "<tr><td>CLX-".$results2['type']."-".$results2['numb']."</td>";

if ($results2['unboxed'] <>'') {
echo "<td>Material not in box sequence located at ".$results2['unboxed'].".</td>";
}
if ($results2['notes'] <>'') {
echo "<td>".$results2['notes'].".</td>";
}

echo "</td></tr>";

endwhile;
echo "</table>";  ?>
<form><input type=button value="Manage locations" onClick="javascript:popUp('popups/popup.php?popup=locations&amp;id=<?php echo $results['id'] ?>')"></form>
<?php
}

}
elseif ($view == "new") { 
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

$year = $_GET['year'] ?? date('Y');
$accession = $_GET['accession'];
$acc_type = $_GET['acc_type'];
$description = htmlentities(($_GET['description']), ENT_QUOTES);
$creator = htmlentities(($_GET['creator']), ENT_QUOTES);
$depositor = htmlentities(($_GET['depositor']), ENT_QUOTES);
$type = $_GET['type'];
$conditions = htmlentities(($_GET['conditions']), ENT_QUOTES);
$copyright = htmlentities(($_GET['copyright']), ENT_QUOTES);
$restrictions = htmlentities(($_GET['restrictions']), ENT_QUOTES);
$extent = $_GET['extent'];
$phys_cond = htmlentities(($_GET['phys_cond']), ENT_QUOTES);
$comments = htmlentities(($_GET['comments']), ENT_QUOTES);
$documentation = htmlentities(($_GET['documentation']), ENT_QUOTES);
$shelfmark = $_GET['shelfmark'];
$acc_by = $current_user." (".$display_user.")";
$acc_date = date('d M Y');

echo "<h3>Accession added</h3>";

$sql_str="INSERT INTO cms_accessions (year, accession, acc_type, description, creator, depositor, type, conditions, copyright, restrictions, extent, phys_cond, comments, acc_by, acc_date, documentation, shelfmark) VALUES  ('$year','$accession','$acc_type','$description','$creator','$depositor','$type','$conditions','$copyright','$restrictions','$extent','$phys_cond','$comments', '$acc_by', '$acc_date', '$documentation','$shelfmark')";

##  echo "<p>".$sql_str."</p>";
		mysqli_query($id_link, $sql_str) or die("Insert failed!<br />" . mysql_error());
		
	$sql_str="SELECT * FROM cms_accessions WHERE acc_type LIKE '$acc_type' AND year='$year' AND accession LIKE '$accession'";
	 $accsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 $result = mysqli_fetch_array($accsearch);
	 $vid = $result['id'];
	 echo "<p><a href='".$_SERVER['PHP_SELF']."?func=accessions&amp;view=viewacc&amp;id=".$result['id']."'>Go to the accession you have just added</p>";	
		
}
else 
{
echo "<h3>Error</h3>";
}  ?>
