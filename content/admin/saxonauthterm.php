<?php
## This script is designed to be called by an xslt stylesheet and retrieve the most current version of a term 
## from the Authorities database for inclusion in xml/EAD document

##call database connection
include "../../archives/cmsys/mysql_link.php";

## set output as xml
## header("Content-Type: text/xml; charset=utf-8");
## header("Content-Type: text/xml; charset=iso-8859-1");
 header("Content-Type: text/xml");
 
  ## define variables
$table = $_GET['table'];
$authfilenumber = $_GET['authfilenumber'];
##subjects
if ($table == "cms_auth_subj") {

 	 $sql_str="SELECT * FROM cms_auth_subj WHERE id LIKE '$authfilenumber'";
	 
	 $termsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($termsearch); 
	      
echo "<subject authfilenumber=\"sub_".$results['id'] ."\" source=\"".$results['source']."\">".utf8_encode(htmlspecialchars($results['term'], ENT_QUOTES))."</subject>";
         
 }
 
 ##genres
if ($table == "cms_auth_genr") {

 	 $sql_str="SELECT * FROM cms_auth_genr WHERE id LIKE '$authfilenumber'";
	 
	 $termsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($termsearch); ?>
     
     <genre authfilenumber='gen_<?php echo $results['id'] ?>' source='<?php echo $results['source'] ?>'><?php echo $results['term'] ?></genre>
     
     <?php
	 
 }
 
 ## places
 elseif ($table == "cms_auth_geog") {

 	 $sql_str="SELECT * FROM cms_auth_geog WHERE id LIKE '$authfilenumber'";
	 
	 $termsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($termsearch); 
     
      if ($results['part_order'] <> '') {

	$parts = explode(",", $results['part_order']);
	$norm_part = $parts[0];
	if ($norm_part == 'area') {$normal = utf8_encode($results['term']); } else { $normal = utf8_encode($results[$norm_part]); }
	
	echo "<geogname authfilenumber=\"geo_".$results['id']."\" normal=\"".$normal."\">";
	foreach ( $parts as $part ) {
		if ($part == "area") { echo utf8_encode(htmlspecialchars($results['term'], ENT_QUOTES))." "; } else { echo utf8_encode(htmlspecialchars($results[$part], ENT_QUOTES))." "; }
	}
	echo "</geogname>";	

}
else {

echo utf8_encode("<geogname authfilenumber='geo_".$results['id']."' normal='".$results['term']."'>".$results['term']." ".$results['island']." ".$results['city']." ".$results['territory']." ".$results['county']." ".$results['country'] ." ".$results['continent']."</geogname>");

} 
	 
 }
 
 ##personal names
if ($table == "cms_auth_pers") {

 	 $sql_str="SELECT * FROM cms_auth_pers WHERE id LIKE '$authfilenumber'";
	 
	 $termsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($termsearch);
	 
	 $term = utf8_encode(htmlspecialchars($results['family_name'], ENT_QUOTES))." | ".utf8_encode(htmlspecialchars($results['given_name'], ENT_QUOTES))." | ". htmlspecialchars($results['terms_of_address'], ENT_QUOTES)." | ".utf8_encode(htmlspecialchars($results['date'], ENT_QUOTES))." | ". utf8_encode(htmlspecialchars($results['description'], ENT_QUOTES));	 
	
	 
	  ?>
     
     <persname normal='<?php echo utf8_encode(htmlspecialchars($results['family_name'], ENT_QUOTES)) ?>, <?php echo utf8_encode(htmlspecialchars($results['given_name'], ENT_QUOTES)) ?>' authfilenumber='per_<?php echo $results['id'] ?>'><?php echo $term ?></persname>
     
     <?php
	 
 }
 
 ##corporate names
if ($table == "cms_auth_corp") {

 	 $sql_str="SELECT * FROM cms_auth_corp WHERE id LIKE '$authfilenumber'";
	 
	 $termsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($termsearch);
	 
	 $term = utf8_encode(htmlspecialchars($results['primary_name'], ENT_QUOTES))." | ".utf8_encode(htmlspecialchars($results['secondary_name'], ENT_QUOTES))." | ".$results['date']." | ".utf8_encode(htmlspecialchars($results['description'], ENT_QUOTES))." | ".utf8_encode(htmlspecialchars($results['location'], ENT_QUOTES));
		 
	  ?>
     
     <corpname normal='<?php echo utf8_encode(htmlspecialchars($results['primary_name'], ENT_QUOTES)) ?>, <?php echo utf8_encode(htmlspecialchars($results['secondary_name'], ENT_QUOTES)) ?>' authfilenumber="cor_<?php echo $results['id'] ?>"><?php echo $term ?></corpname>
     
     <?php
	 
 }
 
 ##family names
if ($table == "cms_auth_fam") {

 	 $sql_str="SELECT * FROM cms_auth_fam WHERE id LIKE '$authfilenumber'";
	 
	 $termsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($termsearch);
	 
	 if ($results['family_name'] <> '') {	 
	 $family_name = htmlspecialchars($results['family_name'], ENT_QUOTES);	 
	 } else {	 
	 $family_name = "";	 
	 }
	 
	 if ($results['title'] <> '') {	 
	 $title = " | ". htmlspecialchars($results['title'], ENT_QUOTES);	 
	 $title_normal = ", ". htmlspecialchars($results['title'], ENT_QUOTES);	 
	 } else {	 
	 $title = "";	 	 
	 }
	 
	 if ($results['territorial_distinction'] <> '') {	 
	 $territorial_distinction = " | ". htmlspecialchars($results['territorial_distinction'], ENT_QUOTES);	 
	 $territorial_distinction_normal = ", ". htmlspecialchars($results['territorial_distinction'], ENT_QUOTES);	 
	 } else {	 
	 $territorial_distinction = "";	 	 
	 }
	 	 
	  
	 
	 $term = utf8_encode($family_name.$title.$territorial_distinction);		 
	 
	 $normal = utf8_encode($family_name.$title_normal.$territorial_distinction_normal);	
	 
	 
	  ?>
     
     <famname authfilenumber='fam_<?php echo $results['id'] ?>' normal='<?php echo $normal ?>'><?php echo $term ?></famname>
     
     <?php
	 
 }
?>

  

     


