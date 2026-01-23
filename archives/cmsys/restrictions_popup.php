<?php  $scriptstore = ".";
include "mysql_link.php";
include $SITE_ROOT."includes/auth.php";
//include "auth.php";
$coll = $_GET['coll'];  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Edinburgh University Library Special Collections" />
<link rel="stylesheet" type="text/css" href="../includes/style.css" />
<title>Restrictions</title>
</head>
<body>
<?php
echo "<div align='right'><button onclick='window.print()'>Print this page</button></div>";
echo "<h1>Restrictions: Coll-".$coll."</h1>";
echo "<p>The following restrictions apply:</p>";
	 $sql_str="SELECT * FROM cms_access_restrict WHERE Coll=$coll";

	 $rest_search = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<table width='100%' cellpadding='5' class='detail'>";
	 while ($results = mysqli_fetch_array($rest_search)):
	 echo "<tr><td class='label' width='200'>Shelfmark(s)/Reference</td><td>".$results['ShMark']."</td></tr>";
	 echo "<tr><td class='label'>Description</td><td>".$results['DatName']."</td></tr>";
	 echo "<tr><td class='label'>Access arrangements</td><td>".$results['AccArr']."</td></tr>";
	 echo "<tr><td class='label'>Notes</td><td>".$results['AddNotes']."</td></tr>";
	 echo "<tr><td height='25'></td></tr>";
	 endwhile;
	 echo "</table>";
	 ?>

</body>
</html>
