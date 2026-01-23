<?php ## converts MySQL format date into display version


$year = substr($datefromdb,0,4);
$mon  = substr($datefromdb,4,2);
$day  = substr($datefromdb,6,2);
$hour = substr($datefromdb,8,2);
$min  = substr($datefromdb,10,2);
$sec  = substr($datefromdb,12,2);
$displaydate = date("d F Y, H:i",mktime($hour,$min,$sec,$mon,$day,$year));
$stddate = date("Y-m-d H:i:s",mktime($hour,$min,$sec,$mon,$day,$year)); ?>