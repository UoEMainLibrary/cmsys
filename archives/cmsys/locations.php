IN DEVELOPMENT<br /><br />
<?php ### ref resolver ###

## strip off 'GB-237-' prefix so we are working in same format as CMSys ##
$local_refid = str_replace("GB-237-", "", $_GET['refid']);

## Determine whether this is 'Coll' or EUA' ##
$ref_substr = substr($local_refid, 0, 3);

if ($ref_substr == "Col") {  ## we are working with 'Coll' prefixes, i.e. AMS

$coll_parts = explode("-", $local_refid);
$coll = $coll_parts[1];
echo $coll;

echo "<h2>Archives, Manuscripts, Personal Papers</h2>";
echo "<p>This search has still to be constructed</p>";

## Display accessions with this collection number
echo "<h3>Linked accessions</h3>";

	 $sql_str="SELECT * FROM cms_accessions WHERE coll=$coll";
	 $accsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");

while ($results = mysqli_fetch_array($accsearch)):

$year = $results['year'];
$number = $results['accession'];
echo "<p>E.".$year.".".$number."</p>";
	 
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
echo "</table>";
endwhile;

##Display locations for this collection
echo "<h3>Gen/MS shelfmarks</h3>";
	 $sql_str="SELECT * FROM collections_locations WHERE coll=$coll ORDER BY prefix ASC, number ASC, number2 ASC";
	 $locsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
 
echo "<ul>";
while ($results = mysqli_fetch_array($locsearch)):

## format location code
if ($results['prefix'] == "Gen") {
  if ($results['number2'] <> '') {
  $loccode = $results['prefix'].".".$results['number']." (".$results['number2'].")";
	}
	else {
	$loccode = $results['prefix'].".".$results['number'];
	}
}
else {
$loccode = $results['prefix'].".".$results['number'].".".$results['number2'];
}

echo "<li>".$loccode."</li>";

endwhile;
echo "</ul>";

}
elseif($ref_substr == "EUA") {  ## we are working with EUA references
echo "<h2>Edinburgh University Archives</h2>";
$short_refid = str_replace("EUA-", "", $local_refid);  ## strip off the 'EUA-' bit ##
$local_unitid = "EUA ".str_replace("-", "/", $short_refid);
##echo $short_refid."<br /><br />";
##echo $local_unitid."<br /><br />";

echo "<p>This is a search for ".$local_unitid." and any subsiduary references.</p>";

echo "<ul><li><a href='#boxed'>Boxed</a></li><li><a href='#unboxed'>Unboxed</a></li></ul>";
## sort out the '-' vs '/' issue for parent
$parent_parts = explode("-", $short_refid);
$parent_refid = "Parent: EUA-".$parent_parts[0];
$parent_unitid = "Parent: EUA ".$parent_parts[0];
##echo $parent_refid."<br /><br />";
##echo $parent_unitid."<br /><br />";

## search the database for exact reference: boxed material ##
$sql_str="SELECT * FROM eua_box_contents WHERE unitid LIKE '$local_unitid%'";
$boxsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$hits = mysql_num_rows($boxsearch);
echo "<a name='boxed'></a><h3>Boxed material</h3>";
echo "<p>Hits: ".$hits."</p>";

if ($hits >0) {
echo "<table border='1' cellpadding='5'><thead><tr><th>Box</th><th>Reference Code</th><th>Contents</th><th>Old shelfmark</th></tr></thead>";
while ($results = mysqli_fetch_array($boxsearch)):
echo "<tr><td>EUA-".$results['prefix']."-".$results['box']."</td><td>".$results['unitid']."</td><td>".$results['contents']."</td><td>".$results['shelfmark']."</td></tr>";
endwhile;
echo "</table>";
}

## search the database for exact reference: unboxed material ##
$sql_str="SELECT * FROM cms_unboxed WHERE unitid LIKE '$local_unitid%'";
$boxsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$hits = mysql_num_rows($boxsearch);
echo "<a name='unboxed'></a><h3>Unboxed material</h3>";
echo "<p>This includes material in non-standard boxes</p>";
echo "<p>Hits: ".$hits."</p>";

if ($hits >0) {
echo "<table border='1' cellpadding='5'><thead><tr><th>Begins</th><th>Ends</th><th>Reference Code</th><th>Contents</th><th>Old shelfmark</th></tr></thead>";
while ($results = mysqli_fetch_array($boxsearch)):
echo "<tr><td>".$results['begin']."</td><td>".$results['end']."</td><td>".$results['unitid']."</td><td>".$results['description']."</td><td>".$results['shelfmark']."</td></tr>";
endwhile;
echo "</table>";
}

}
else {

echo "Cannot understand reference<br /><br />";
}

 ?>