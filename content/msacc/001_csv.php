<?php
$row = 1;
$handle = fopen("msacc/001_pagination.csv", "r");
echo "<ul>\n";
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $num = count($data);
		
		$row++;
		if ($row>2) {
        echo "<li style='font-size: 8pt;'><a class='white' target='main' href='Pdfs/".$data[1].".".$data[2]."' onClick='top.banner.location=\"001_banner.php?title=".$data[3]."&amp;row=".$row."\";'>".$data[3]."</a></li>\n";
  }  
}
echo "</ul>\n";
fclose($handle);
?> 