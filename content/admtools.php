<?php 
include "/home/lib/lacddt/cmsys/archives/cmsys/vars.php";
include "includes/upperheader.php";
   echo "<title>Collections Management System (Prototype): Cataloguing Tools</title>";
   include "includes/lowerheader.php";
	 echo "<h1>Admin Tools</a></h1>";
	 
	 
	 if ($func == "readers") {	
	 include "/home/lib/lacddt/cmsys/archives/cmsys/readers.php";
	 }
	 elseif ($func == "enquiries") {	
	 include "/home/lib/lacddt/cmsys/archives/cmsys/enquiries.php";
	 }
##	 echo "<hr /><a href='http://lib-pc-1998.lib.ed.ac.uk/test/session.php?user=".$current_user."'>test</a>";
	 include "includes/footer.php"; ?> 