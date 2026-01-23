<?php

$current_user = $_SERVER['REMOTE_USER'] ?? $LOCAL_USER ?? null;

$sql_str="SELECT * FROM cms_users WHERE userid LIKE '$current_user'";

	 $usersearch = mysqli_query($id_link, $sql_str) or ("Search Failed!");
$results = mysqli_fetch_array($usersearch);

$display_user = $results['forename']." ".$results['surname'];

$group_user =  $results['group'];

//elseif ($group_user > "2") {
if ($group_user > "2") {
$edit_permissions = "y";
}
else {
$edit_permissions = "n";
}
?> 
