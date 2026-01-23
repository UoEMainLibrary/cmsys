<?php 
 echo "<h2>Accessions: chronological, 1953-2003</h2>";
 
 if (isset($_GET['year'])) { echo "<p>You are looking for E.".$_GET['year'].".".$_GET['number']."</p>"; }
   
   if ($_GET['view'] == "list" or !isset($_GET['view'])) {

$acc_sql_str="SELECT DISTINCT year, number, suffix, image_file FROM cms_accessionsToPage";
	 
	 $accsearch = mysqli_query($id_link, $acc_sql_str) or die("Search Failed!");
	 
	
	 
	 echo "<div>NB: New Library from E.1967.11</div>";
	 echo "<ul>";
	 
	 while ($accresults = mysqli_fetch_array($accsearch)):
	 
	 echo "<li><a href='".$_SERVER['PHP_SELF']."?func=accreg&amp;view=page&amp;file=".$accresults['image_file']."'>E.".$accresults['year'].".".$accresults['number']." ".$accresults['suffix']."</a></li>";
	 
	 endwhile;
	 
	 echo "</ul>";

}
elseif ($_GET['view'] == "page") { 

	$file = $_GET['file'];
	
	# which run of file numbers are we in?
	
	if (substr(($file), -10, 2) == '01') { echo "<div>The 'Brown Book'</div>";

	$filenumber = substr(($file), -7, 3);
	## echo $filenumber;
	
	if ($filenumber == "002") {$prevfile  = "0025016d.pdf"; } else { $prevfile = "01-".sprintf("%03d",$filenumber - 1).".pdf"; }
	
	if ($filenumber == "161") {$nextfile  = "01-".$filenumber.".pdf"; } else { $nextfile = "01-".sprintf("%03d",$filenumber + 1).".pdf"; }
	 
	echo "<div><a href='".$_SERVER['PHP_SELF']."?func=accreg&amp;view=page&amp;file=".$prevfile."'>Previous Page</a> | <a href='".$_SERVER['PHP_SELF']."?func=accreg&amp;view=list'>Full List</a> | <a href='".$_SERVER['PHP_SELF']."?func=accreg&amp;view=page&amp;file=".$nextfile."'>Next Page</a></div>";
	 
	} else { echo "<div>The 'Jotter'</div>";
	
	$filenumber = substr(($file), -11, 6);
	 
	if ($filenumber == "0025002") {$prevfile  = $filenumber."d.pdf"; } else { $prevfile = sprintf("%07d",$filenumber - 1)."d.pdf"; }
	
	if ($filenumber == "0025016") {$nextfile  = "01-002.pdf"; } else { $nextfile = sprintf("%07d",$filenumber + 1)."d.pdf"; }
	
	echo "<div><a href='".$_SERVER['PHP_SELF']."?func=accreg&amp;view=page&amp;file=".$prevfile."'>Previous Page</a> | <a href='".$_SERVER['PHP_SELF']."?func=accreg&amp;view=list'>Full List</a> | <a href='".$_SERVER['PHP_SELF']."?func=accreg&amp;view=page&amp;file=".$nextfile."'>Next Page</a></div>";  
	
	}
	
	echo "<object data='includes/accreg_file.php?file=".$file."' type='application/pdf' width='1200' height='800' border='1'></object>";
	 
	 }
   
  ?>
