<?php 
include "../archives/cmsys/vars.php";

include "includes/upperheader.php";
   echo "<title>MS Accessions 1960-2003</title>";
   include "includes/lowerheader.php";
   
   if ($_GET['view'] == "list" or !isset($_GET['view'])) {

$sql_str="SELECT DISTINCT year, acc, file FROM cms_accessions_images";
	 
	 $accsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 echo "<h2>Accessions: chronological</h2>";
	 
	 echo "<div>NB: New Library from E.1967.11</div>";
	 echo "<ul>";
	 
	 while ($results = mysqli_fetch_array($accsearch)):
	 
	 echo "<li><a href='".$_SERVER['PHP_SELF']."?view=page&amp;file=".$results['file']."'>E.".$results['year'].".".$results['acc']."</a></li>";
	 
	 endwhile;
	 
	 echo "</ul>";

}
elseif ($_GET['view'] == "page") { 

	$file = $_GET['file'];

	$filenumber = substr(($file), -7, 3);
	 
	$nextfile  = sprintf("%03d",$filenumber + 1); 
	 
	$prevfile  = sprintf("%03d",$filenumber - 1); 
	
	echo "<div align='center'><a href='".$_SERVER['PHP_SELF']."?view=page&amp;file=01-".$prevfile.".pdf'>Previous Page</a> | <a href='".$_SERVER['PHP_SELF']."?view=list'>Full List</a> | <a href='".$_SERVER['PHP_SELF']."?view=page&amp;file=01-".$nextfile.".pdf'>Next Page</a></div>";
	
	echo "<object data='includes/accreg_file.php?file=".$file."' type='application/pdf' width='1200' height='700' border='1'></object>";
	 
	 }
   
 	 include "includes/footer.php";  ?>
