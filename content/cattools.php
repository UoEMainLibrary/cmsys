<?php 
include "../archives/cmsys/vars.php";
include "includes/upperheader.php";
   echo "<title>Collections Management System (Prototype): Cataloguing Tools</title>";
   include "includes/lowerheader.php";
	 echo "<h1>Cataloguing Tools</a></h1>";
	 	 
	 if ($func == "authorities") {	
		 include $SITE_ROOT.'/../archives/cmsys/authorities.php';
	 }
	 elseif ($func == "enquiries") {	
		 include $SITE_ROOT.'/../archives/cmsys/enquiries.php';
	 }
##	 echo "<hr /><a href='http://lib-pc-1998.lib.ed.ac.uk/test/session.php?user=".$current_user."'>test</a>";
	 include "includes/footer.php"; ?> 