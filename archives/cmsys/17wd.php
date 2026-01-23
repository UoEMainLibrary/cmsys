<?php
$holidayList = array("04-03-2008","07-03-2008");
$j = $i = 0; //changed this to 0 or you were always starting one day ahead
$given_date = $results['received'];
$tmp1 = strtotime($given_date); //worked out a timstamp to start with
while($i < 17)
{
$tmp2 = strtotime("+$j day", $tmp1);
$day = date("l", $tmp2);  
//echo strftime("%d-%m-%Y",$tmp2);

    $day = date("d-m-y", $tmp2); 
    if(($day != "Sunday") && ($day != "Saturday" )&&(!in_array($tmp, $holidayList)))
    {
        $i = $i + 1;
        $j = $j + 1;
        
    }
    else
    {
        $j = $j + 1;
       
    }
}
    $j = $j -1;
$newdate = strtotime("+$j day",$tmp1);
$rem_date = date("Y-m-d", $newdate);   

?>