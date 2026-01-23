<?php
## construct NCA rules version of a name

if (!empty($results)) {
    if ($results['given_name'] <> '') { $given_name_str = " | ".$results['given_name']; } else { $given_name_str = ''; }
    if ($results['terms_of_address'] <> '') { $terms_of_address_str = " | ".$results['terms_of_address']; } else { $terms_of_address_str = ''; }
    if ($results['date'] <> '') { $date_str = " | ".$results['date']; } else { $date_str = ''; }
    if ($results['description'] <> '') { $description_str = " | ".$results['description']; } else { $description_str = ''; }
    $nca_str = $results['family_name'] . $given_name_str . $terms_of_address_str . $date_str . $description_str;
} else {
    $nca_str = '';
}

if (!empty($results2)) {

    if ($results2['given_name'] <> '') { $given_name_str2 = " | ".$results2['given_name']; } else { $given_name_str2 = ''; }
    if ($results2['terms_of_address'] <> '') { $terms_of_address_str2 = " | ".$results2['terms_of_address']; } else { $terms_of_address_str2 = ''; }
    if ($results2['date'] <> '') { $date_str2 = " | ".$results2['date']; } else { $date_str2 = ''; }
    if ($results2['description'] <> '') { $description_str2 = " | ".$results2['description']; } else { $description_str2 = ''; }
    $nca_str2 = $results2['family_name'] . $given_name_str2 . $terms_of_address_str2 . $date_str2 . $description_str2;
} else {
    $nca_str2 = '';
}

if (!empty($results3)) {
    if ($results3['given_name'] <> '') { $given_name_str3 = " | ".$results3['given_name']; } else { $given_name_str3 = ''; }
    if ($results3['terms_of_address'] <> '') { $terms_of_address_str3 = " | ".$results3['terms_of_address']; } else { $terms_of_address_str3 = ''; }
    if ($results3['date'] <> '') { $date_str3 = " | ".$results3['date']; } else { $date_str3 = ''; }
    if ($results3['description'] <> '') { $description_str3 = " | ".$results3['description']; } else { $description_str3 = ''; }
    $nca_str3 = $results3['family_name'] . $given_name_str3 . $terms_of_address_str3 . $date_str3 . $description_str3;
} else {
    $nca_str3 = '';
}


?>