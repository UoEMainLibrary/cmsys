<?php

echo "<h1>Legacy Shelfmarks</h1>";
$sql_str="SELECT DISTINCT sm_prefix FROM cms_accessionsToShelfmarks WHERE sm_prefix <>'' ORDER BY sm_prefix";
$smsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
echo "<p>";
while ($results = mysqli_fetch_array($smsearch)):	
echo "<a href='".$_SERVER['PHP_SELF']."?func=".$func."&amp;view=list&amp;sm_prefix=".$results['sm_prefix']."'>".$results['sm_prefix']."</a> &nbsp;&nbsp;";
endwhile; 
echo "</p>";

if ($view == "list") {
$sm_prefix = $_GET['sm_prefix'];

$sql_str="SELECT * FROM cms_accessionsToShelfmarks WHERE sm_prefix LIKE '$sm_prefix' ORDER BY sm_1 ASC, sm_2 ASC";

$smsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");

echo "<table width='100%' cellpadding='5' border='1'>";

echo "<tr><td width='20'></td><td width='150'><strong>Shelfmark</strong></td><td width='150'><strong>Accession</strong></td><td width='300'><strong>Original page(s)</strong></td><td><strong>Recorded in original as</strong></td></tr>";

$count = 1;

while ($results = mysqli_fetch_array($smsearch)):	

echo "<tr><td>".$count."</td><td>".$results['sm_prefix'].".".$results['sm_1'].".".$results['sm_2']." ".$results['sm_suffix']."</td><td><a href='".$_SERVER['PHP_SELF']."?func=accessions&amp;view=list&amp;year=".$results['year']."&amp;number=".$results['number']."&amp;suffix=".$results['suffix']."'>E.".$results['year'].".".$results['number']." ".$results['suffix']."</a></td><td>";

include "accessions_page_frag.php";

echo "</td><td>".$results['sm_written']."</td></tr>";
$count ++;

endwhile; 

echo "</table>";

}
