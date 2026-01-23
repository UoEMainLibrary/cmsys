<?php  
echo "<h2>Readers</h2>"; 

echo "<p><a href=\"javascript:popUp('popups/popup.php?popup=readers&view=new')\">Add new Reader</a></p>";?>

   <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
    <input name="func" type="hidden" value="readers" />
    <input name="view" type="hidden" value="results" />
    Surname search: <input name="searchterm" type="text" size="30" />
    <input type="submit" value="Search"  />
   </form>

<?php


if ($view == "results") {
echo "<p>You searched for : <strong>".$searchterm."</strong</p>";

$sql_str="SELECT * FROM crc_readers WHERE surname LIKE '$searchterm' ORDER BY surname ASC, forenames ASC"; 

$perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");


echo "<table border='1' cellpadding='5' width='70%'>";
echo "<tr><td class='label' width='100'>id</td><td class='label'>Surname</td><td class='label'>Forenames</td><td class='label'>Renewal due</td></tr>";

while ($results = mysqli_fetch_array($perssearch)) {


$next_renewal_a = substr($results['registration_date'], 0, 4)+1;
$next_renewal_b = substr($results['registration_date'], 4, 10);

echo "<tr><td>"; ?>
<a href="javascript:popUp('popups/popup.php?popup=readers&id=<?php echo $results['id']?>')">CRC-RR-<?php echo $results['id']?></a>
<?php echo "</td><td>".$results['surname']."</td><td>".$results['forenames']."</td><td>".$next_renewal_a.$next_renewal_b."</td>";

}

echo "</table>";

}
?>