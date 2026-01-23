<?php ##this creates the link to the digitised accessions register

$year = $results['year'];
$number = $results['number'];
$suffix = $results['suffix'];

$accpage_sql_str="SELECT * FROM cms_accessionsToPage WHERE year LIKE '$year' AND number LIKE '$number'";
	 $accpagesearch = mysqli_query($id_link, $accpage_sql_str) or die("Search Failed!");

while ($accpageresults = mysqli_fetch_array($accpagesearch)):

echo " (<a href='./?func=accreg&amp;view=page&amp;year=".$year."&amp;number=".$number."&amp;file=".$accpageresults['image_file']."'>".$accpageresults['image_file']."</a>) ";

endwhile; ?>