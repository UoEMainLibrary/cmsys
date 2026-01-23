<?php echo "<h2>Enquiries</h2>";

echo "<p><a href=\"javascript:popUp('popups/popup.php?popup=enquiries&view=new')\">Add new enquiry</a></p>";

$sql_str="SELECT * FROM enquiries ORDER BY received DESC, id DESC"; 

$enqsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");

echo "<table width='100%' border='1' cellpadding='5'>";
echo "<tr><td style='font-weight: bold;' width='100'>Ref.</td><td style='font-weight: bold;' width='200'>Enquirer</td><td style='font-weight: bold;' width='200'>Subject</td><td style='font-weight: bold;' width='100'>Received</td><td style='font-weight: bold;' width='100'>Acknowledged</td><td style='font-weight: bold;' width='100'>Completed</td><td style='font-weight: bold;' width='100'>Due (FOI)</td><td style='font-weight: bold;' width='100'>Logged by</td><td style='font-weight: bold;' width='100'>Assigned to</td></tr>";

while ($results = mysqli_fetch_array($enqsearch)) {

if ($results['completed'] <> "0000-00-00") {
$style = "background-color: #cccccc";
$completed = $results['completed'];
}
else {
$style = "background-color: #ffffff";
$completed = NULL;
} 

echo "<tr style='".$style."'><td width='20'>";

include "20wd.php";
include "17wd.php";

#
$dateDiff = strtotime($rem_date) - strtotime(NOW);
#
$fullDays = floor($dateDiff/(60*60*24));

if ($fullDays <5 && $completed == NULL) { $alert = "<span style='color: red; font-weight: bold'>!</span>"; } else {$alert = ""; }
#
//echo "Differernce is $fullDays days"; 


 ?>

<a href="javascript:popUp('popups/popup.php?popup=enquiries&id=<?php echo $results['id']?>')">

<?php echo "SC-ENQ-".$results['id']."</a></td><td>".$results['enquirer_name']."</td><td>".$results['subject']."</td><td>".$results['received']."</td><td>".$results['acknowledged']."</td><td>".$completed."</td><td>".$due_date." ".$alert."</td><td>".$results['logged_by']."</td><td>".$results['assigned']."</td></tr>";

 }

echo "</table>";

?>




