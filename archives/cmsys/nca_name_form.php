<?php
## construct NCA rules version of a name

if ($results['given_name'] <> '') { $given_name_str = " | ".$results['given_name']; }
if ($results['terms_of_address'] <> '') { $terms_of_address = " | ".$results['terms_of_address']; }
if ($results['date'] <> '') { $date_str = " | ".$results['date']; }
if ($results['description'] <> '') { $description_str = " | ".$results['description']; }

$nca_str = $results['family_name'] . $given_name_str . $date_str . $description_str;

if ($results2['given_name'] <> '') { $given_name_str2 = " | ".$results2['given_name']; }
if ($results2['terms_of_address'] <> '') { $terms_of_address_str2 = " | ".$results2['terms_of_address']; }
if ($results2['date'] <> '') { $date_str2 = " | ".$results2['date']; }
if ($results2['description'] <> '') { $description_str2 = " | ".$results2['description']; }

$nca_str2 = $results2['family_name'] . $given_name_str2 . $date_str2 . $description_str2;

?>