<? 
#  Lets get all pre 1997 accessions and create skeleton records for them
$acc_sql_str="SELECT DISTINCT year, number, suffix FROM cms_accessionsToPage WHERE year<1997";
	 
	 $accsearch = mysqli_query($id_link, $acc_sql_str) or die("Search Failed!");
	
	  
	 echo "<table border='1' cellpadding='5' width='100%'>";
	 
	 while ($accresults = mysqli_fetch_array($accsearch)):
	 $year = $accresults['year'];
	 
	 $number = $accresults['number'];
	 
	 $suffix = $accresults['suffix'];
	 
	 echo "<tr><td>".$year."</td><td>".$number."</td><td>".$suffix."</td><td>This is a skeleton record.  Detail can be found in the digitised MSS Accession Register</td><td>";
	 
	
	
			$accpage_sql_str="SELECT * FROM cms_accessionsToPage WHERE year LIKE '$year' AND number LIKE '$number'";
	 		$accpagesearch = mysqli_query($id_link, $accpage_sql_str) or die("Search Failed!");

			while ($accpageresults = mysqli_fetch_array($accpagesearch)):

			echo $accpageresults['image_file'].", ";

			endwhile;
	
	
	 
	 echo "</td></tr>";
	 
	 endwhile;
	 echo "</table>";
	 
	 ?>