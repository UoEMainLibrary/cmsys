<?php

$year = $_GET['year'] ?? date('Y');
$number = $_GET['number'];
$suffix = $_GET['suffix'];

echo "<h3>Accession detail: E.".$year.".".$number." ".$suffix."</h3>";

	 $acc_sql_str="SELECT * FROM cms_accessions WHERE acc_type LIKE 'MS' AND year LIKE '$year' AND accession LIKE  '$number'";
	 $accsearch = mysqli_query($id_link, $acc_sql_str) or die("Search Failed!");	 
	 $acc_num_rows = mysql_num_rows($accsearch);
	 if ($acc_num_rows >'0') {
	 $results = mysqli_fetch_array($accsearch);
	 

echo "<table width='90%' cellpadding='5' class='detail'>";
echo "<tr><td class='label' width='150'>Year</td><td>".$results['year']."</td></tr>";
echo "<tr><td class='label'>Accession</td><td>".$results['accession']."</td></tr>";
echo "<tr><td class='label'>Accession Type</td><td>".$results['acc_type']."</td></tr>";
echo "<tr><td class='label'>Description</td><td>".$results['description']."</td></tr>";
echo "<tr><td class='label'>Creator</td><td>".$results['creator']."</td></tr>";
echo "<tr><td class='label'>Donor/Depositor</td><td>".$results['depositor']."</td></tr>";
##echo "<tr><td class='label'>Ownership</td><td>".$results['type']."</td></tr>";
##echo "<tr><td class='label'>Conditions</td><td>".$results['conditions']."</td></tr>";
##echo "<tr><td class='label'>Copyright</td><td>".$results['copyright']."</td></tr>";
echo "<tr><td class='label'>Restrictions</td><td>".$results['restrict']."</td></tr>";
##echo "<tr><td class='label'>Extent</td><td>".$results['extent']."</td></tr>";
##echo "<tr><td class='label'>Physical Condition</td><td>".$results['phys_cond']."</td></tr>";
##echo "<tr><td class='label'>Comments</td><td>".$results['comments']."</td></tr>";
##echo "<tr><td class='label'>Further Comments</td><td>".$results['comments2']."</td></tr>";
##echo "<tr><td class='label'>Documentation</td><td>".$results['documentation']."</td></tr>";
echo "<tr><td class='label'>Accesssioned by</td><td>".$results['acc_by']."</td></tr>";
echo "<tr><td class='label'>Accession date</td><td>".$results['acc_date']."</td></tr>";
if ($results['coll'] <> '') {
echo "<tr><td class='label'>Collection</td><td><a href='".$_SERVER['PHP_SELF']."?func=collections&amp;view=viewcoll&amp;coll=".$results['coll']."'>".$results['coll']."</a></td></tr>";
}
echo "</table>"; 

if ($year < 2004) {
echo "<p>Note: Pre-2004 records may be partial. Please consult the digitised <a href='accreg.php'>Manuscripts Accessions Register</a> for a full record.</p>"; 

}
}
else {
echo "No accession record available in database.";

$accpage_sql_str="SELECT * FROM cms_accessionsToPage WHERE  year LIKE '$year' AND number LIKE  '$number' AND suffix LIKE '$suffix'";
	 $accpagesearch = mysqli_query($id_link, $accpage_sql_str) or die("Search Failed!");

while ($results = mysqli_fetch_array($accpagesearch)):

echo "<p>You want page image <a href='./?func=accreg&view=page&amp;year=".$year."&amp;number=".$number."&amp;suffix=".$suffix."&amp;file=".$results['image_file']."'>".$results['image_file']."</a> (THIS LINK IN DEVELOPMENT)</p>";

endwhile;

$sm_sql_str="SELECT * FROM cms_accessionsToShelfmarks WHERE year LIKE '$year' AND number LIKE  '$number' AND suffix LIKE '$suffix'";
	 $smsearch = mysqli_query($id_link, $sm_sql_str) or die("Search Failed!");
	 
	 echo "<h3>Shelfmarks</h3>";
	 
	 echo "<p>";

while ($smresults = mysqli_fetch_array($smsearch)):

echo $smresults['sm_prefix'].".".$smresults['sm_1'].".".$smresults['sm_2']." ".$smresults['sm_suffix']." &nbsp; &nbsp;";

endwhile;

echo "</p>";
}

 $sql_str="SELECT * FROM cms_clx2 WHERE year like '$year' and number LIKE '$number'";

$boxsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");


echo "<h3>Boxes: </h3>";

while ($results = mysqli_fetch_array($boxsearch)):
echo "<div style='margin-left: 20px;'>";

if ($results['box_a'] <>'0') {
echo "<p>CLX-A-".$results['box_a']."</p>";
}
if ($results['box_c'] <>'0') {
echo "<p>CLX-C-".$results['box_c']."</p>";
}
if ($results['box_d'] <>'0') {
echo "<p>CLX-D-".$results['box_d']."</p>";
}
if ($results['unboxed'] <>'') {
echo "<p>Material not in box sequence located at ".$results['unboxed'].". (final shelf configuration still to be completed)</p>";
}

endwhile;
?>
