<?php ## this script is called in to format the different types of accession numbers in the in-house style

if ($results['acc_type'] == "EUA") {
$y = substr($results['year'], -2);
$a = sprintf("%03d",$results['accession']); 

$acc_str = "Acc.".$y."/".$a;
}
elseif ($results['acc_type'] == "MS") {
$acc_str = "E.".$results['year'].".".$results['accession'];
}
elseif ($results['acc_type'] == "RBP") {
$acc_str = $results['year'].".".$results['accession'];
}
echo $acc_str;

?> 