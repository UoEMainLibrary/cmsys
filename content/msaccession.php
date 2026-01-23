<?php

echo "<h3>Accession detail</h3>";

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
echo "No accession record available in database.  Please consult the digitised <a href='accreg.php'>Manuscripts Accessions Register</a>.";

$accpage_sql_str="SELECT * FROM cms_accessionsToPage WHERE  year LIKE '$year' AND number LIKE  '$number'";
	 $accpagesearch = mysqli_query($id_link, $accpage_sql_str) or die("Search Failed!");

while ($results = mysqli_fetch_array($accpagesearch)):

echo "<p>You want page image ".$results['image_file']." (THIS LINK IN DEVELOPMENT)</p>";

endwhile;
}?>
