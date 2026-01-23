<?php 
$year = $_GET['year'] ?? date('Y');
$number = $_GET['number'];

	 echo "<h1>CLX boxes and unboxed ('E' accessions)</h1>";
	 
	 if (!isset($view)) { 
echo "<form method='GET' action='".$PHP_SELF."'>";
echo "<input type='hidden' name='view' value='interim' />";	
echo "<input type='hidden' name='func' value='loc_clx' />";	
echo "Select year: <select name='year'>";	 
$sql_str="SELECT distinct year FROM cms_clx WHERE year>0 ORDER BY year ASC";
$boxsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
while ($results = mysqli_fetch_array($boxsearch)):	
echo "<option value='".$results['year']."'>".$results['year']."</option>>";
endwhile; 
echo "</select>";
echo "<input type='submit' value='Proceed' />";	
echo "</form";
	 
	 
	 }
	 
	 else if ($view == "interim") {
	 
	 echo "<form method='GET' action='".$PHP_SELF."'>";
echo "<input type='hidden' name='view' value='results' />";	
echo "<input type='hidden' name='func' value='loc_clx' />";	
echo "<input type='hidden' name='year' value='".$year."' />";	
echo "E . ".$year." . ";

echo " <select name='number'>";	 
$sql_str="SELECT distinct number FROM cms_clx WHERE year LIKE '$year' AND number>0 ORDER BY year ASC";
$boxsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
while ($results = mysqli_fetch_array($boxsearch)):	
echo "<option value='".$results['number']."'>".$results['number']."</option>";
endwhile; 
echo "</select><br />";
echo "View accession information: (brief)<input type='checkbox' name='view_acc' /><br />";
echo "<input type='submit' value='Search' />";	
echo "</form";
	 
	 }
	 
	 else if ($view == "results") {
	 
	 $sql_str="SELECT * FROM cms_clx2 WHERE year like '$year' and number LIKE '$number'";
echo "<h2>E.".$year.".".$number."</h2>";
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

echo "</div>";


if ($results['notes'] <>'') {
echo "<h3>Notes:</h3>";
echo "<p>".$results['notes']."</p>";
echo "<p>If no location information is given, this means that this accession was not located within the sequential run of 'E' accessions.</p>";
}



endwhile;

if ($_GET['view_acc'] == "on") {
include "msaccession.php";
}
	 }
	 
	 else if ($view == "all") {
	 
	 $sql_str="SELECT * FROM cms_clx ORDER BY year ASC, number ASC";
$boxsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");

echo "<table width='90%' cellpadding=>";
echo "<tr><td width='150'>Accession</td><td>Location</td></tr>";
while ($results = mysqli_fetch_array($boxsearch)):

if ($results['box_a'] <>'0') {
echo "<tr><td><b>E.".$results['year'].".".$results['number']."</b></td><td>Box: CLX-A-".$results['box_a']."</td></tr>";
}
if ($results['box_c'] <>'0') {
echo "<tr><td><b>E.".$results['year'].".".$results['number']."</b></td><td>Box: CLX-C-".$results['box_c']."</td></tr>";
}
if ($results['box_d'] <>'0') {
echo "<tr><td><b>E.".$results['year'].".".$results['number']."</b></td><td>Box: CLX-D-".$results['box_d']."</td></tr>";
}
if ($results['unboxed'] <>'') {
echo "<tr><td><b>E.".$results['year'].".".$results['number']."</b></td><td>Material not in box sequence located at ".$results['unboxed'].". (final shelf configuration still to be completed).</td></tr>";
}



##if ($results['notes'] <>'') {
##echo "<h3>Notes:</h3>";
##echo "<p>".$results['notes']."</p>";
##echo "<p>If no location information is given, this means that this accession was not located ##within the sequential run of 'E' accessions.</p>";
##}



endwhile;
echo "</table>";
	 }
	 
	 else {


echo "<br /><input type=button value=\"Back\" onClick=\"history.go(-1)\">";
}
	 
 ?> 