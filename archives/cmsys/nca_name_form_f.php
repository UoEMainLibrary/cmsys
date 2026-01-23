<?php
## construct NCA rules version of a name

if ($results['title'] <> '') { $title_str = " | ".$results['title']; } else { $title_str = ''; }
if ($results['territorial_distinction'] <> '') { $territorial_distinction_str = " | ".$results['territorial_distinction']; } else { $territorial_distinction_str = ''; }

$nca_str = $results['family_name'] . $title_str . $territorial_distinction_str;



?>