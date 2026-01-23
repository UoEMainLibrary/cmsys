<?php  
echo "<h2>Collections</h2>";

## display menu
if (!isset ($view)) { 
echo "<h3>Menu</h3>";
echo "<ul>";
echo "<li></li>";
echo "</ul>";
}
## display collections list in numerical order
elseif ($view == "numlist") {

	 $sql_str="SELECT * FROM cms_collections WHERE title <> 'NOT ALLOCATED' ORDER BY coll ASC";

	 $collsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Collections (numerical order)</h3>";
echo "<table width='90%' class='list' border='1'>";
while ($results = mysqli_fetch_array($collsearch)):
echo "<tr><td valign='top' width='150' class='label'>";
if ($results['alt'] == NULL) {
echo "Coll-".$results['coll'];
} 
else {
echo $results['alt']." (Coll-".$results['coll'].")";
}

echo "</td><td valign='top' width='60%'><a href='".$_SERVER['PHP_SELF']."?func=collections&amp;view=viewcoll&amp;coll=".$results['coll']."'>".$results['title']."</a></td><td valign='top'>".$results['shelfmarks']."</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; ?>


<?php echo"</td></tr>";
endwhile;
echo "</table>";
}
## display collections search results
elseif ($view == "searchlist") {

	 $sql_str="SELECT * FROM cms_collections WHERE title LIKE '%$searchterm%' ORDER BY creator ASC";

	 $collsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Search Results</h3>";
echo "<table summary='Search Results' width='90%' class='list'>";
while ($results = mysqli_fetch_array($collsearch)):
echo "<tr><td width='150' class='label'>Coll-".$results['coll']."</td><td width='150' class='label'>".$results['alt']."</td><td><a href='".$_SERVER['PHP_SELF']."?func=collections&amp;view=viewcoll&amp;coll=".$results['coll']."'>".$results['title']."</a></td></tr>";
endwhile;
echo "</table>";
}
## display selected collection
elseif ($view == "viewcoll") {

	 $sql_str="SELECT * FROM cms_collections WHERE coll=$coll";

	 $collsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($collsearch);
echo "<h3>".$results['title']."</h3>";
echo "<table width='90%' cellpadding='5' class='detail'>";
echo "<tr><td class='label' width='150'>Reference code</td><td>Coll-".$results['coll']."</td></tr>";
if (($results['alt'])<>'') {
echo "<tr><td class='label'>Alt. reference code</td><td>".$results['alt']."</td></tr>";
}
echo "<tr><td class='label'>Title</td><td>".$results['title']."</td></tr>";
echo "<tr><td class='label'>Creator</td><td>".$results['creator']."</td></tr>";
echo "<tr><td class='label'>Locations</td><td>".$results['shelfmarks']."</td></tr>";
echo "<tr><td class='label'>Public</td><td>".$results['public']."</td></tr>";
echo "<tr><td class='label'>Online catalogue</td><td>";
## need bit in here for collections with alt refs ##

if ($results['alt'] == '') {
$filename = "/data/d4/archives/catalogue_source_docs/isad/Coll-".$results['coll'].".xml";
} else {
$filename = "/data/d4/archives/catalogue_source_docs/isad/".$results['alt'].".xml";
}
if (file_exists($filename)) {
    echo "<a href='http://www.archives.lib.ed.ac.uk/catalogue/cs/viewcat.pl?view=basic&amp;id=Coll-".$results['coll']."' target= '_blank'>View</a>";
} else {
    echo "not online";
}
echo "</td></tr>";
echo "<tr><td colspan='2' align='right' style='border-top: thin solid #000000;'><span style='background-color: #ffffcc;'> <a href=\"javascript:popUp('popups/popup.php?popup=collections&amp;view=edit&amp;coll=$coll')\">Edit</a> </span></td></tr>";
echo "</table>";

## General access restrictions

	 $sql_str="SELECT * FROM cms_access_restrict WHERE Coll=$coll";

	 $rest_search = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 $rest_num = mysql_num_rows($rest_search);
	 if ($rest_num > 0) {
	 echo "<p><a href=\"javascript:popUp('popups/popup.php?popup=restrictions&amp;coll=$coll')\">Access restrictions exist for this collection</a></p>";
	 }


## Display accessions with this collection number
echo "<h4>Linked accessions</h4>";

	 $sql_str="SELECT * FROM cms_accessions WHERE coll=$coll";
	 $accsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
echo "<table width='90%' cellpadding='5' class='detail'>";
while ($results = mysqli_fetch_array($accsearch)):

echo "<tr><td class='label' width='150'>";
##.$results['year']."/".$results['accession']."
include "/home/lib/lacddt/cmsys/archives/cmsys/accstyle.php";
echo "</td><td><a href='".$_SERVER['PHP_SELF']."?func=accessions&amp;view=viewacc&amp;id=".$results['id']."'>".$results['description']."</a></td><td>";

## flag any accession records mentioning restrictions
if ($results['restrict'] <>'') {
echo "<span style='font-weight:bold; color:#ff0000; background-color: #ffffcc;' title='Access Restrictions'>R</span> ";
}

## flag any accession records mentioning copyright
if ($results['copyright'] <>'') {
echo "<span style='font-weight:bold; color:#000099; background-color: #ccffff;' title='Copyright Information'>&copy;</span> ";
}
echo "</td></tr>";

endwhile;
echo "</table>";

##Display locations for this collection
echo "<h4>Mapped locations/shelfmarks</h4>";
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

##Display tasks for this collection
echo "<h4>Tasks</h4>";
  $sql_str="SELECT * FROM tasks WHERE tablename LIKE 'collections' AND tableid=$coll";
	 $tasksearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
 
echo "<table cellpadding='5' width='90%' class='detail'>";
echo "<tr><td class='label' width='180'>Last Updated</td><td class='label'>Task</td><td class='label' width='100'>Status</td></tr>";
while ($results = mysqli_fetch_array($tasksearch)):

$datefromdb = $results['lastupdated'];
include "cms/sqldate.php";

echo "<tr><td>".$displaydate."</td><td><a href='".$_SERVER['PHP_SELF']."?func=tasks&amp;view=viewtask&amp;id=".$results['id']."&amp;table=collections&amp;coll=".$coll."'>".$results['task']."</a></td><td>".$results['status']."</td></tr>";

endwhile;
echo "</table>";

## Add a task temporarily disabled
##
##echo "<form action='".$_SERVER['PHP_SELF']."' method='GET'>";
##echo "<input type='hidden' name='func' value='tasks' />";
##echo "<input type='hidden' name='view' value='add' />";
##echo "<input type='hidden' name='tablename' value='collections' />";
##echo "<input type='hidden' name='tableid' value='".$coll."' />";
##echo "<input type='submit' value='Add a Task' /></td></tr>";
##echo "</form>";

}

## display error message when illegal view is called for
else {
echo "<h3>Error</h3>";
} 
?> 