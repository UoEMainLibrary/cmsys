<?php
######################################################################################
##### CORPORATE NAMES #################################################################
######################################################################################

## display personal name list
elseif ($view == "perslist") {

	 $sql_str="SELECT * FROM cms_auth_pers AND suppress IS NULL ORDER BY persterm ASC";

	 $perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>People</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($perssearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results['id']."'>".$results['persterm']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";

}

######################################################################################
## display edit screen for personal name
elseif ($view == "persview") {

$sql_str="SELECT * FROM cms_auth_pers WHERE id=$id AND suppress IS NULL";

	 $perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Person</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
$results = mysqli_fetch_array($perssearch);
echo "<tr><td class='label'>Term</td><td>".$results['persterm']."</td></tr>";
echo "<tr><td class='label'>Normal</td><td>".$results['normal']."</td></tr>";
echo "<tr><td class='label'>Family name</td><td>".$results['family_name']."</td></tr>";
echo "<tr><td class='label'>Given name(s)</td><td>".$results['given_name']."</td></tr>";
echo "<tr><td class='label'>Date(s)</td><td>".$results['date']."</td></tr>";
echo "<tr><td class='label'>Terms of address</td><td>".$results['terms_of_address']."</td></tr>";
echo "<tr><td class='label'>Description</td><td>".$results['description']."</td></tr>";
echo "<tr><td class='label'>Variant of</td><td>".$results['variant_of']."</td></tr>";
echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Language code</td><td>".$results['lang_code']."</td></tr>";
echo "<tr><td class='label'>Created for (project/activity)</td><td>".$results['created_for']."</td></tr>";
echo "<tr><td class='label'>Created by</td><td>".$results['created_by']."</td></tr>";
echo "<tr><td class='label'>Created on</td><td>";
if ($results['created_on'] <> '0000-00-00 00:00:00') {
echo $results['created_on'];
}
else {
echo "before 09 September 2009";
}
echo "</td></tr>";

$datefromdb = $results['last_edited'];
include "sqldate.php";

$persterm = htmlentities(($results['persterm']), ENT_QUOTES);
$normal = htmlentities(($results['normal']), ENT_QUOTES);

echo "<tr><td class='label'>Last edited</td><td>".$displaydate."</td></tr>";
echo "<tr><td class='label'>Last edited by</td><td>".$results['last_edited_by']."</td></tr>";
echo "<tr><td class='label'>xml string</td><td><xmp><persname authfilenumber='".$id."' rules='ncarules' normal='".$normal."'>\n".$persterm."\n</persname></xmp></td></tr>";

echo "</table>";
echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persedit&amp;id=".$results['id']."'>Edit</a>";


$sql_str1="SELECT id FROM cms_auth_pers WHERE id < $id AND suppress IS NULL ORDER BY ID DESC LIMIT 1";
$navsearch1 = mysqli_query($id_link, $sql_str1) or die("Search Failed!");
$results1 = mysqli_fetch_array($navsearch1);
$prev = $results1['id'];

$sql_str2="SELECT id FROM cms_auth_pers WHERE id > $id AND suppress IS NULL ORDER BY ID ASC LIMIT 1";
$navsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($navsearch2);
$next = $results2['id'];

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$prev."'>&lt;&lt;&lt;&lt;&lt;</a> | <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$next."'>&gt;&gt;&gt;&gt;&gt;</a></p>";

}

######################################################################################

## display edit screen for personal name
elseif ($view == "persedit") {

$sql_str="SELECT * FROM cms_auth_pers WHERE id=$id AND suppress IS NULL";

	 $perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($perssearch);
	 
if ($results['source'] == "lcsh") { $source_title = "Library of Congress Subject Headings"; } 
if ($results['source'] == "sss") { $source_title = "School of Scottish Studies Thesaurus"; } 
if ($results['source'] == "ukat") { $source_title = "United Kingdom Archival Thesaurus"; } 
if ($results['source'] == "other") { $source_title = "other"; } 

 ?>
<h3>Edit term: Person</h3>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="persupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Term</td><td><textarea cols="61" rows="2" name="persterm"><?php echo $results['persterm'] ?></textarea></td></tr>
<tr><td class="label">Normal</td><td><input name="normal" size="75" type="text" value="<?php echo $results['normal'] ?>" /></td></tr>
<tr><td class="label">Family name</td><td><input name="family_name" size="75" type="text" value="<?php echo $results['family_name'] ?>" /></td></tr>
<tr><td class="label">Given name(s)</td><td><input name="given_name" size="75" type="text" value="<?php echo $results['given_name'] ?>" /></td></tr>
<tr><td class="label">Date(s)</td><td><input name="date" size="75" type="text" value="<?php echo $results['date'] ?>" /></td></tr>
<tr><td class="label">Terms of address</td><td><input name="terms_of_address" size="75" type="text" value="<?php echo $results['terms_of_address'] ?>" /></td></tr>
<tr><td class="label">Description</td><td><input name="description" size="75" type="text" value="<?php echo $results['description'] ?>" /></td></tr>
<tr><td class="label">Variant of</td><td>



<?php   $var_id = $results['variant_of'];
	if ($var_id == 0 ) {

     echo "<div>Currently set as: this is the authority version of the name</div>";
	 } else {

     $sql_str2="SELECT * FROM cms_auth_pers where id='$var_id' AND suppress IS NULL";
	 $authsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
	 $results2 = mysqli_fetch_array($authsearch2);	
echo "<div>Currently set as:  ".$results2['persterm']."</div>";
}
echo "Change to: <select style='width:409px;' name='variant_of'>";
echo "<option value='0'>this is the authority version of the name</option>";
	$sql_str3="SELECT * FROM cms_auth_pers ORDER BY family_name ASC";
	 $authsearch3 = mysqli_query($id_link, $sql_str3) or die("Search Failed!");
while ($results3 = mysqli_fetch_array($authsearch3)):
echo "<option style='width:409px;' value='".$results3['id']."'>".$results3['persterm']."</option>";
endwhile;

 ?>
 </select>
</td></tr>
<tr><td class="label">Use for</td><td><textarea cols="61" rows="2" name="use_for"><?php echo $results['use_for'] ?></textarea></td></tr>
<tr><td class="label">Source(s)</td><td><textarea cols="61" rows="2" name="term"><?php echo $results['source'] ?></textarea></td></tr>
<tr><td class="label">Language code</td><td><input name="lang_code" size="75" type="text" value="<?php echo $results['lang_code'] ?>" /></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value="<?php echo $results['created_for'] ?>"><?php echo $results['created_for'] ?></option>
<option value="CW">CW</option>
<option value="EUA">EUA</option>
<option value="AMS">AMS</option>
</select>
</td></tr>
</table> 
<input type="submit" value="Update term" />
</form>
<?php
}

#########################################################
## Update personal name from Edit
elseif ($view == "persupdate") {

$persterm = $_GET['persterm'];
##$term = $_GET['term'];
$normal = $_GET['normal'];
$family_name = $_GET['family_name'];
$given_name = $_GET['given_name'];
$date = $_GET['date'];
$terms_of_address = $_GET['terms_of_address'];
$description = $_GET['description'];
$variant_of = $_GET['variant_of'];
$use_for = $_GET['use_for'];
$source = $_GET['source'];
$lang_code = $_GET['lang_code'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_pers SET id='$id', persterm='$persterm', normal='$normal', family_name='$family_name', given_name='$given_name', date='$date', terms_of_address='$terms_of_address', description='$description', variant_of='$variant_of', use_for='$use_for', source='$source', lang_code='$lang_code', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update person failed!");


$sql_str="SELECT * FROM cms_auth_pers WHERE id=$id AND suppress IS NULL";
$perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($perssearch);
echo $term;
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results['id']."'>".$results['persterm']."</a> has been updated</p>";

$persterm = htmlentities(($results['persterm']), ENT_QUOTES);
$normal = htmlentities(($results['normal']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><persname authfilenumber='".$id."' rules='ncarules' normal='".$normal."'>\n".$persterm."\n</persname></xmp></td></tr></table>";


}

######################################################################################
elseif ($view == "persadd") {

	 $sql_str="SELECT * FROM cms_auth_pers WHERE suppress IS NULL ORDER BY persterm ASC";

	 $perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
echo "<table align='right' width='300'>";
echo "<tr><td><strong>People already in database</strong><textarea cols='40' rows='30' style='font-size:small; color:#000000; background-color:#ffffff' disabled='disabled' wrap='off'>";
while ($results = mysqli_fetch_array($perssearch)):
echo $results['persterm'] ."\n";
endwhile;
echo "</textarea></td></tr></table>"; ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">

<h3>Add term: Person</h3>

<table summary="">
<tr><td class="label">Term</td><td><textarea cols="61" rows="2" name="persterm"></textarea></td></tr>
<tr><td class="label">Normal</td><td><input name="normal" size="75" type="text" /></td></tr>
<tr><td class="label">Family name</td><td><input name="family_name" size="75" type="text" /></td></tr>
<tr><td class="label">Given name(s)</td><td><input name="given_name" size="75" type="text" /></td></tr>
<tr><td class="label">Date(s)</td><td><input name="date" size="75" type="text" /></td></tr>
<tr><td class="label">Terms of address</td><td><input name="terms_of_address" size="75" type="text" /></td></tr>
<tr><td class="label">Description</td><td><textarea cols="61" rows="2" name="description"></textarea></td></tr>
<tr><td class="label">Variant of</td><td>
<select style="width:490px" name="variant_of">
<option value="0"></option>
<?php $sql_str2="SELECT * FROM cms_auth_pers WHERE suppress IS NULL ORDER BY persterm ASC";

	 $authsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
while ($results2 = mysqli_fetch_array($authsearch)):
echo "<option value='".$results2['id']."'>".$results2['persterm']."</option>";
endwhile;
 ?>
 </select>
</td></tr>
<tr><td class="label">Use for</td><td><textarea cols="61" rows="2" name="use_for"><?php echo $results['use_for'] ?></textarea></td></tr>
<tr><td class="label">Source(s)</td><td><textarea cols="61" rows="2" name="term"><?php echo $results['source'] ?></textarea></td></tr>
<tr><td class="label">Language code</td><td><input name="lang_code" size="75" type="text" value="<?php echo $results['lang_code'] ?>" /></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value="<?php echo $results['created_for'] ?>"><?php echo $results['created_for'] ?></option>
<option value="CW">CW</option>
<option value="EUA">EUA</option>
<option value="AMS">AMS</option>
</select>
</td></tr>
</table> 

<input type="hidden" name="func" value ="authorities"/>
<input type="hidden" name="view" value ="persenter"/>
<input type="submit" value="Add term" />
</form>
<?php }

#########################################################
# Enter new person 

elseif ($view == "persenter") {

$persterm = $_GET['persterm'];
##$term = $_GET['term'];
$normal = $_GET['normal'];
$family_name = $_GET['family_name'];
$given_name = $_GET['given_name'];
$date = $_GET['date'];
$terms_of_address = $_GET['terms_of_address'];
$description = $_GET['description'];
$variant_of = $_GET['variant_of'];
$use_for = $_GET['use_for'];
$source = $_GET['source'];
$lang_code = $_GET['lang_code'];
$last_edited = $date_time;
$last_edited_by = $display_user;
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_pers (id, persterm, normal, family_name, given_name, date, terms_of_address, description, variant_of, use_for, source, lang_code, last_edited, last_edited_by, created_for, created_by, created_on) VALUES  (NULL, '$persterm', '$normal', '$family_name', '$given_name', '$date', '$terms_of_address', '$description', '$variant_of', '$use_for', '$source', '$lang_code', '$last_edited', '$last_edited_by', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("<p>Enter person failed!</p>");


$sql_str="SELECT * FROM cms_auth_pers WHERE persterm LIKE '$persterm' AND suppress IS NULL";
$perssearch = mysqli_query($id_link, $sql_str) or die("<p>Search Failed!</p>");
$results = mysqli_fetch_array($perssearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results['id']."'>".$results['persterm']."</a> has been added</p>";
$persterm = htmlentities(($results['persterm']), ENT_QUOTES);
$normal = htmlentities(($results['normal']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><persname authfilenumber='".$results['id']."' rules='ncarules' normal='".$normal."'>\n".$persterm."\n</persname></xmp></td></tr></table>";

}


######################################################################################
########### END OF PERSONAL NAMES ####################################################
######################################################################################
?>