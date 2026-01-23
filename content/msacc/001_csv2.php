<?php
//Move through a CSV file, and output an associative array for each line
ini_set("auto_detect_line_endings", 1);
$row = ($_GET['row']-1);
$current_row = 1;
$previous_row = ($row-1);
$next_row = ($row+1);

$handle = fopen("msacc/001_pagination.csv", "r");
while ( ($data = fgetcsv($handle, 10000, ",") ) !== FALSE )
{
    $number_of_fields = count($data);
    if ($current_row == 1)
    {
    //Header line
        for ($c=0; $c < $number_of_fields; $c++)
        {
            $header_array[$c] = $data[$c];
        }
    }
    else
		{
		
		if ($current_row == $previous_row) {
    //Data line
        for ($c=0; $c < $number_of_fields; $c++)
        {
            $data_array[$header_array[$c]] = $data[$c];
        }
       echo "<a onClick='top.banner.location=\"001_banner.php?title=".$data_array[label]."&amp;row=".($current_row-1)."\";' target='main' href='Pdfs/".$data_array['file'].".".$data_array['extension']."'>&lt;&lt;</a> |"; }

		elseif($current_row == $next_row) {
		$next=($next_row+1);
    //Data line
        for ($c=0; $c < $number_of_fields; $c++)
        {
            $data_array[$header_array[$c]] = $data[$c];
        }
       echo "| <a onClick='top.banner.location=\"001_banner.php?title=".$data_array[label]."&amp;row=".($current_row+1)."\";' target='main' href='Pdfs/".$data_array['file'].".".$data_array['extension']."'>&gt;&gt;</a>"; }
		
		
    }
    $current_row++;
}
fclose($handle);

?> 