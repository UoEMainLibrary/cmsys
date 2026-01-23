<?php include"includes/upperheader.php";

$id_link = mysql_connect($hostname, $username, $password);

 if (!$id_link || !mysql_select_db($dbname)):

 echo '1:Connection to MySQL has failed.';

 exit();

 endif;
$view = $_GET['view'];
$id = $_GET['id'];
$sort = $_GET['sort'];
$group_filter = $_GET['group_filter'];
$store_filter = $_GET['store_filter'];

$title = "High-level data";

include"includes/lowerheader.php";

?>

<h1>High-level data</h1>

<?php	## echo $view;
if (!isset ($sort)) { $sort = 'id'; }
if (!isset ($group_filter)) { $group_filter = '%'; }
if (!isset ($store_filter)) { $store_filter = '%'; }

if (!isset ($view)) { $view = "data"; }

if ($view == "data") {

 	$sql_str="SELECT * FROM recant1 where collection_group LIKE '$group_filter' AND store_from LIKE '$store_filter' ORDER by '$sort' ASC";
	 $collsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<table cellpadding='5' width='100%'>";
	 echo "<tr><td class='label'>Collection group</td><td class='label'>Collection description</td><td class='label'>Extent</td><td class='label' width='170'>Reference code(s) or shelfmark(s)</td><td class='label' width='170'>From</td><td class='label'>Notes</td></tr>";
	 while ($results = mysqli_fetch_array($collsearch)):
	 echo "<tr><td><a href='".$PHP_SELF."?view=data&amp;group_filter=".$results['collection_group']."&amp;store_filter=".$store_filter."'>".$results['collection_group']."</a></td><td>".$results['collection_desc']."</td><td align='right'>".$results['extent']."</td><td>".$results['reference']."</td><td><a href='".$PHP_SELF."?view=data&amp;store_filter=".$results['store_from']."&amp;group_filter=".$group_filter."'>".$results['store_from']."</a>, row ".$results['store_from_row']."</td><td>".$results['notes']."</td></tr>";
	 
	 endwhile; 
	
	$sql_str="SELECT sum(extent) as 'total' FROM recant1 where collection_group LIKE '$group_filter' AND store_from LIKE '$store_filter'";
	 $totalsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	$total = mysqli_fetch_array($totalsearch);
	
	echo "<tr><td></td><td align='right' colspan='2' style='border-top-style: solid; border-top-color: #000000;'><b>Total</b>: ".$total['total']."</td><tr>";
	
	echo "</table>";
	
	if ($group_filter <> '%') { 
	echo "<b>Group filter on</b>: ".$group_filter."&nbsp;&nbsp;&nbsp;&nbsp";
	$show_remove=1;
	 }
	if ($store_filter <> '%') { 
	echo "<b>Store filter on</b>: ".$store_filter."&nbsp;&nbsp;&nbsp;&nbsp";
	$show_remove=1;
	 } 
	 if ($show_remove == 1) {
echo "<p><a href='".$_SERVER['PHP_SELF']."'>Remove filters</a></p>";
}

} //end 'data' view

  include "includes/footer.php"; ?>
