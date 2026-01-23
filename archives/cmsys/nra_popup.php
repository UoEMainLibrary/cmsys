<?php  $scriptstore = ".";
include "mysql_link.php";
include $SITE_ROOT."includes/auth.php";
//include "auth.php"; 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
 "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Edinburgh University Library Special Collections" />
<link rel="stylesheet" type="text/css" href="../includes/style.css" />
<title>Accessions</title>
</head>
<body>

<form action="<?php echo $PHP_SELF ?>">
<input type="hidden" name="popup" value="<?php echo $_GET['popup'] ?? '' ?>" />
Type: 
<select name="type">
<option value="<?php echo $_GET['type'] ?? '' ?>"><?php echo $_GET['type'] ?? '' ?></option>
<option value="MS">MS</option>
<option value="EUA">EUA</option>
</select> Year: 
<input type="text" name="year" value="<?php echo $_GET['year'] ?? '' ?>" />
<input type="submit" value="Select" />
</form>
<hr />

<?php  
	 $year = $_GET['year'] ?? date('Y');
     $type = $_GET['type'] ?? 'EUA';
	 
	 if ($type <>'' ){
	 echo "<div align='right'><button onclick='window.print()'>Print this page</button></div>";
	 }

	 $sql_str="SELECT * FROM cms_accessions WHERE acc_type LIKE '$type' AND year LIKE '$year'";

	 $acc_search = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<table width='100%' cellpadding='5' class='detail' border='1'>";
	 while ($results = mysqli_fetch_array($acc_search)):
	 
	 echo "<tr><td>".$results['creator']."</td><td>".$results['description']."</td><td>Accession: ";  
	 
	 include "accstyle.php";
	 
	 echo "</td><td></td><td>".$results['extent']."</td></tr>";
	 endwhile;
	 echo "</table>";
	 ?>
</body>
</html>

