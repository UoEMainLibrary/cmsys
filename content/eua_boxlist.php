<?php  
include "../archives/cmsys/vars.php";
include "includes/upperheader.php";
   echo "<title>EUA</title>";
   include "includes/lowerheader.php";
   
   echo "<h1>Box List</h1>";
   
   		 $sql_str = "SELECT DISTINCT box FROM eua_box_contents WHERE prefix LIKE 'A' AND box > 0 AND box < 101 ORDER BY box ASC"; 		 
		 
		$boxsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
		
		while ($boxresults = mysqli_fetch_array($boxsearch)):
		
		$box = $boxresults['box'];
		
		##echo "<h2>Contents</h2>";
		
		echo "<h3>Box: EUA-A-".$box."</h3>";
		
   		 $sql_str2 = "SELECT * FROM eua_box_contents WHERE prefix LIKE 'A' AND box LIKE '$box' AND box > 0"; 		 
		 
		$boxsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");	
		
		echo "<table width='100%' cellpadding='2' border='1'>";
		
		while ($boxresults2 = mysqli_fetch_array($boxsearch2)):
		
		echo "<tr><td valign='top' width='230'>".$boxresults2['unitid']."</td><td valign='top' width='550'>".$boxresults2['contents']."</td><td valign='top'>".$boxresults2['shelfmark']."</td></tr>";
		
		
		endwhile;	
		
		echo "</table>";
		echo "---";
		
		endwhile;


?>
