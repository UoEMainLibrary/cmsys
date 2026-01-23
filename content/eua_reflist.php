<?php  
include "../archives/cmsys/vars.php";
include "includes/upperheader.php";
   echo "<title>EUA</title>";
   include "includes/lowerheader.php";
   
  
   
   		 $sql_str = "SELECT * FROM eua_box_contents ORDER by unitid"; 		 
		 
		$refsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
		echo "<table width='100%' cellpadding='5' border='1'>";
		
		while ($refresults = mysqli_fetch_array($refsearch)):
		
		echo "<tr><td>".$refresults['unitid']."</td><td>".$refresults['contents']."</td><td>EUA-".$refresults['prefix']."-".$refresults['box']."</td><td>".$refresults['shelfmark']."</td></tr>";
		
		endwhile;
		
echo "</table>";

?>
