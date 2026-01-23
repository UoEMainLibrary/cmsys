<?php 
include "../archives/cmsys/vars.php";
include "includes/upperheader.php";
   echo "<title>Collections Management System (Prototype)</title>";
   include "includes/lowerheader.php";
	 echo "<h1><a href='".$_SERVER['PHP_SELF']."'>Collections Management System (Prototype)</a></h1>";
	 
	 if (!isset ($func)) {
	 include "../archives/cmsys/front.php";
	 }
	 elseif ($func == "indexing") {	
	 include "../archives/cmsys/indexing.php";
	 }
	 elseif ($func == "collections") {	
	 include "../archives/cmsys/collections.php";
	 }
	 elseif ($func == "accessions") {	
	 include "../archives/cmsys/accessions.php";
	 }
	 elseif ($func == "tasks") {	
	 include "../archives/cmsys/tasks.php";
	 } 
	 elseif ($func == "locations") {	
	 include "../archives/cmsys/locations.php";
	 } 
	 elseif ($func == "loc_eua") {	
	 include "../archives/cmsys/loc_eua.php";
	 }
	 elseif ($func == "loc_clx") {	
	 include "../archives/cmsys/loc_clx.php";
	 }
	 elseif ($func == "accessions_locations") {	
	 include "../archives/cmsys/accessions_locations.php";
	 }
	 elseif ($func == "accessions2") {	
	 include "../archives/cmsys/accessions2.php";
	 }
	 elseif ($func == "shelfmarksToAccessions") {	
	 include "../archives/cmsys/shelfmarksToAccessions.php";
	 }
	 elseif ($func == "accreg") {	
	 include "../archives/cmsys/accreg.php";
	 }
	 elseif ($func == "pi") {	
	 include "../archives/cmsys/pi.php";
	 }
	 elseif ($func == "enquiries") {	
	 include "../archives/cmsys/enquiries.php";
	 }
	 elseif ($func == "readers") {	
	 include "../archives/cmsys/readers.php";
	 }
	 elseif ($func == "collFileUpload") {	
	 include "../archives/cmsys/collFileUpload.php";
	 }
##	 echo "<hr /><a href='http://lib-pc-1998.lib.ed.ac.uk/test/session.php?user=".$current_user."'>test</a>";
	 include "includes/footer.php"; ?> 