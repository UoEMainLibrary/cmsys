<?php
## construct NCA rules version of a name

unset($secondary_name_str, $date_str, $description_str, $location_str, $secondary_name_str2, $date_str2, $description_str2, $location_str2, $secondary_name_str3, $date_str3, $description_str3, $location_str3);

if ($results['secondary_name'] <> '') { $secondary_name_str = " | ".$results['secondary_name']; }
if ($results['date'] <> '') { $date_str = " | ".$results['date']; }
if ($results['description'] <> '') { $description_str = " | ".$results['description']; }
if ($results['location'] <> '') { $location_str = " | ".$results['location']; }

$nca_str = $results['primary_name'] . $secondary_name_str . $date_str . $description_str . $location_str;

if ($results2['secondary_name'] <> '') { $secondary_name2 = " | ".$results2['secondary_name']; }
if ($results2['date'] <> '') { $date_str2 = " | ".$results2['date']; }
if ($results2['description'] <> '') { $description_str2 = " | ".$results2['description']; }
if ($results2['location'] <> '') { $location_str2 = " | ".$results2['location']; }

$nca_str2 = $results2['primary_name'] . $secondary_name_str2 . $date_str2 . $description_str2 . $location_str2;

if ($results3['secondary_name'] <> '') { $secondary_name3 = " | ".$results3['secondary_name']; }
if ($results3['date'] <> '') { $date_str3 = " | ".$results3['date']; }
if ($results3['description'] <> '') { $description_str3 = " | ".$results3['description']; }
if ($results3['location'] <> '') { $location_str3 = " | ".$results3['location']; }

$nca_str3 = $results3['primary_name'] . $secondary_name_str3 . $date_str3 . $description_str3 . $location_str3;

?>