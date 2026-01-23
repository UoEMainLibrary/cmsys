<?php  
###########################################################################
############### Authorities script ########################################
############### manages authorities tables in MySQL database ##############
############### created by Grant Buttars ##################################
###########################################################################

##  global variables for this script
$date_time = date("Y-m-d H:i:s"); 
$id = $_GET['id'];
$type = $_GET['type'];
$created_for = $_GET['created_for'];
##########################################################################

## the following appears regardless of which view is called
echo "<h2>Authorities</h2>";
##########################################################################

## 
##if ($view = "persenter" OR $view = "corpenter" OR $view = "subjenter" OR $view = "geogenter" OR $view = "genrenter") {
##echo "<p>DO NOT use your BACK button on this page - this can cause erroneous duplicate entries to be created.<p>";
##}
##########################################################################

## show up link on all but front page
 if (isset ($view)) { echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities'><img src='/graphics/up.gif' alt='Up to Authorities Menu' border='0' /></a>"; }
######################################################################################

## display menu on front page
if (!isset ($view)) { 
echo "<h3>Menu</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
echo "<tr><td class='label'>People</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=perslist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=perslist&amp;created_for=CW'>List, A-Z (CW only)</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persadd'>Add new term</a></td></tr>";
echo "<tr><td class='label'>Corporate Bodies</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corplist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpadd'>Add new term</a></td></tr>";
echo "<tr><td class='label'>Subjects</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjlist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjadd'>Add new term</a></td></tr>";
echo "<tr><td class='label'>Places</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geoglist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogadd'>Add new term</a></td></tr>";
echo "<tr><td class='label'>Genre</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrlist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genradd'>Add new term</a></td></tr>";
echo "</table>"; ?>


<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="search" />
<input type="text" name="searchterm" size="55" /><br />
<select name="type">
<option value="pers">People</option>
<option value="corp">Corporate Bodies</option>
<option value="subj">Subjects</option>
<option value="geog">Places</option>
<option value="genr">Genres</option>
</select> &nbsp;&nbsp;
<input type="submit" value="Quick Search" />
</form>

<?php
}
######################################################################################

######################################################################################
## display search results
elseif ($view == "search") {
$searchterm = $_GET['searchterm'];
if ($_GET['type'] == "pers") { $table = "cms_auth_pers"; }
if ($_GET['type'] == "corp") { $table = "cms_auth_corp"; }
if ($_GET['type'] == "subj") { $table = "cms_auth_subj"; }
if ($_GET['type'] == "geog") { $table = "cms_auth_geog"; }
if ($_GET['type'] == "genr") { $table = "cms_auth_genr"; }

if ($_GET['type'] == "pers") { $sql_str="SELECT * FROM $table WHERE persterm LIKE '%$searchterm%' AND suppress IS NULL ORDER BY persterm ASC"; }
elseif ($_GET['type'] == "corp") { $sql_str="SELECT * FROM $table WHERE corpterm LIKE '%$searchterm%' AND suppress IS NULL ORDER BY corpterm ASC"; }
else { $sql_str="SELECT * FROM $table WHERE term LIKE '%$searchterm%' AND suppress IS NULL ORDER BY term ASC"; }

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Results</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($subjsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=".$_GET['type']."view&amp;id=".$results['id']."'>".$results['term'].$results['persterm'].$results['corpterm']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=".$_GET['type']."edit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";
}

######################################################################################
######################################################################################

######################################################################################
##### PERSONAL NAMES #################################################################
######################################################################################

## display personal name list
elseif ($view == "perslist") {

	 $sql_str="SELECT * FROM cms_auth_pers WHERE created_for LIKE'$created_for%' AND suppress IS NULL ORDER BY persterm ASC";

	 $perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>People</h3>";
	 
	 if (isset ($created_for)) {
	 echo "<div>Filtered:".$created_for."</div>";
	 }
	 
	 echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persadd'>Add new term</a></p>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($perssearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results['id']."'>".$results['persterm']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";

}

######################################################################################
## display view screen for personal name
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

echo "<tr><td class='label' valign='top'>Variants</td><td>";

if ($results['variant_of'] == 0) {


$sql_str2="SELECT * FROM cms_auth_pers WHERE variant_of=$id and suppress IS NULL";
$varsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
while ($results2 = mysqli_fetch_array($varsearch)):

include "nca_name_form.php";

echo "<div><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results2['id']."'>".$nca_str2."</a></div>";

endwhile;

}
else {

$variant_of = $results['variant_of'];

$sql_str2="SELECT * FROM cms_auth_pers WHERE id=$variant_of and suppress IS NULL";
$prefsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($prefsearch);

include "nca_name_form.php";

echo "<div>Non-preferred term for: <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results2['id']."'>".$nca_str2."</a></div>";

}

echo "</td></tr>";

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
	 
 ?>
<h3>Edit term: Person</h3>
<div style="margin-left:550px;"><a href="<?php echo $_SERVER['PHP_SELF'] ?>?func=authorities&amp;view=persdelete&id=<?php echo $results['id'] ?>">Delete term</a></div>

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
echo "<option style='width:400px;' value='".$results3['id']."'>".$results3['persterm']."</option>";
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

$persterm = mysqli_real_escape_string($id_link, $_GET['persterm']);
##$term = $_GET['term'];
$normal = mysqli_real_escape_string($id_link, $_GET['normal']);
$family_name = mysqli_real_escape_string($id_link, $_GET['family_name']);
$given_name = mysqli_real_escape_string($id_link, $_GET['given_name']);
$date = $_GET['date'];
$terms_of_address = mysqli_real_escape_string($id_link, $_GET['terms_of_address']);
$description = mysqli_real_escape_string($id_link, $_GET['description']);
$variant_of = mysqli_real_escape_string($id_link, $_GET['variant_of']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = mysqli_real_escape_string($id_link, $_GET['source']);
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
<select style="width:409px" name="variant_of">
<option value="0"></option>
<?php $sql_str2="SELECT * FROM cms_auth_pers WHERE suppress IS NULL ORDER BY persterm ASC";

	 $authsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
while ($results2 = mysqli_fetch_array($authsearch)):
echo "<option style='width:400px;' value='".$results2['id']."'>".$results2['persterm']."</option>";
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

$persterm = mysqli_real_escape_string($id_link, $_GET['persterm']);
##$term = $_GET['term'];
$normal = mysqli_real_escape_string($id_link, $_GET['normal']);
$family_name = mysqli_real_escape_string($id_link, $_GET['family_name']);
$given_name = mysqli_real_escape_string($id_link, $_GET['given_name']);
$date = $_GET['date'];
$terms_of_address = mysqli_real_escape_string($id_link, $_GET['terms_of_address']);
$description = mysqli_real_escape_string($id_link, $_GET['description']);
$variant_of = mysqli_real_escape_string($id_link, $_GET['variant_of']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = mysqli_real_escape_string($id_link, $_GET['source']);
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

#########################################################
# Delete a person 
elseif ($view == "persdelete") {

$sql_str="SELECT * FROM cms_auth_pers WHERE id=$id";
$perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($perssearch);

include "nca_name_form.php";

if ($results['variant_of'] == 0) {

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results['id']."'>".$nca_str."</a></p>";

$sql_str2="SELECT * FROM cms_auth_pers WHERE variant_of=$id";
$varsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$num_rows = mysql_num_rows($varsearch);
if ($num_rows >0) {
echo "<div>Varaints exist for this term.  You may not delete it until all variants have been deleted or disassociated from it.</div>";
}
}
else {


echo "<p>".$nca_str."</p>";

$variant_of = $results['variant_of'];

$sql_str2="SELECT * FROM cms_auth_pers WHERE id=$variant_of";
$prefsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($prefsearch);

include "nca_name_form.php";

echo "<p>Non-preferred term for:<br /><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results2['id']."'>".$nca_str2."</a></p>";

$sql_str="UPDATE cms_auth_pers SET suppress='y' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Delete person failed!");

echo "<p>This term has been deleted</p>";

}
}

######################################################################################
########### END OF PERSONAL NAMES ####################################################
######################################################################################


######################################################################################
##### CORPORATE NAMES #################################################################
######################################################################################

## display corporate name list
elseif ($view == "corplist") {

	 $sql_str="SELECT * FROM cms_auth_corp WHERE suppress IS NULL ORDER BY corpterm ASC";

	 $corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Corporate Bodies</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($corpsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$results['id']."'>".$results['corpterm']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";

}

######################################################################################
## display view screen for corporate name
elseif ($view == "corpview") {

$sql_str="SELECT * FROM cms_auth_corp WHERE id=$id AND suppress IS NULL";

	 $corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Corporate Body</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
$results = mysqli_fetch_array($corpsearch);
echo "<tr><td class='label'>Term</td><td>".$results['corpterm']."</td></tr>";
echo "<tr><td class='label'>Normal</td><td>".$results['normal']."</td></tr>";
echo "<tr><td class='label'>Primary name</td><td>".$results['primary_name']."</td></tr>";
echo "<tr><td class='label'>Secondary names</td><td>".$results['secondary_name']."</td></tr>";
echo "<tr><td class='label'>Date(s)</td><td>".$results['date']."</td></tr>";
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

$corpterm = htmlentities(($results['corpterm']), ENT_QUOTES);
$normal = htmlentities(($results['normal']), ENT_QUOTES);

echo "<tr><td class='label'>Last edited</td><td>".$displaydate."</td></tr>";
echo "<tr><td class='label'>Last edited by</td><td>".$results['last_edited_by']."</td></tr>";
echo "<tr><td class='label'>xml string</td><td><xmp><corpname authfilenumber='".$id."' rules='ncarules' normal='".$normal."'>\n".$corpterm."\n</corpname></xmp></td></tr>";

echo "</table>";
echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpedit&amp;id=".$results['id']."'>Edit</a>";


$sql_str1="SELECT id FROM cms_auth_corp WHERE id < $id AND suppress IS NULL ORDER BY ID DESC LIMIT 1";
$navsearch1 = mysqli_query($id_link, $sql_str1) or die("Search Failed!");
$results1 = mysqli_fetch_array($navsearch1);
$prev = $results1['id'];

$sql_str2="SELECT id FROM cms_auth_corp WHERE id > $id AND suppress IS NULL ORDER BY ID ASC LIMIT 1";
$navsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($navsearch2);
$next = $results2['id'];

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$prev."'>&lt;&lt;&lt;&lt;&lt;</a> | <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$next."'>&gt;&gt;&gt;&gt;&gt;</a></p>";

}

######################################################################################

## display edit screen for corporate name
elseif ($view == "corpedit") {

$sql_str="SELECT * FROM cms_auth_corp WHERE id=$id AND suppress IS NULL";

	 $corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($corpsearch);
	 
 ?>
<h3>Edit term: Corporate Body</h3>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="corpupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Term</td><td><textarea cols="61" rows="2" name="corpterm"><?php echo $results['corpterm'] ?></textarea></td></tr>
<tr><td class="label">Normal</td><td><input name="normal" size="75" type="text" value="<?php echo $results['normal'] ?>" /></td></tr>
<tr><td class="label">Family name</td><td><input name="primary_name" size="75" type="text" value="<?php echo $results['primary_name'] ?>" /></td></tr>
<tr><td class="label">Given name(s)</td><td><input name="secondary_name" size="75" type="text" value="<?php echo $results['secondary_name'] ?>" /></td></tr>
<tr><td class="label">Date(s)</td><td><input name="date" size="75" type="text" value="<?php echo $results['date'] ?>" /></td></tr>
<tr><td class="label">Description</td><td><input name="description" size="75" type="text" value="<?php echo $results['description'] ?>" /></td></tr>
<tr><td class="label">Variant of</td><td>



<?php   $var_id = $results['variant_of'];
	if ($var_id == 0 ) {

     echo "<div>Currently set as: this is the authority version of the name</div>";
	 } else {

     $sql_str2="SELECT * FROM cms_auth_corp where id='$var_id' AND suppress IS NULL";
	 $authsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
	 $results2 = mysqli_fetch_array($authsearch2);	
echo "<div>Currently set as:  ".$results2['corpterm']."</div>";
}
echo "Change to: <select style='width:409px;' name='variant_of'>";
echo "<option value='0'>this is the authority version of the name</option>";
	$sql_str3="SELECT * FROM cms_auth_corp ORDER BY primary_name ASC";
	 $authsearch3 = mysqli_query($id_link, $sql_str3) or die("Search Failed!");
while ($results3 = mysqli_fetch_array($authsearch3)):
echo "<option style='width:400px;' value='".$results3['id']."'>".$results3['corpterm']."</option>";
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
## Update corporate name from Edit
elseif ($view == "corpupdate") {

$corpterm = mysqli_real_escape_string($id_link, $_GET['corpterm']);
##$term = $_GET['term'];
$normal = mysqli_real_escape_string($id_link, $_GET['normal']);
$primary_name = mysqli_real_escape_string($id_link, $_GET['primary_name']);
$secondary_name = mysqli_real_escape_string($id_link, $_GET['secondary_name']);
$date = $_GET['date'];
$terms_of_address = mysqli_real_escape_string($id_link, $_GET['terms_of_address']);
$description = mysqli_real_escape_string($id_link, $_GET['description']);
$variant_of = mysqli_real_escape_string($id_link, $_GET['variant_of']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = $_GET['source'];
$lang_code = $_GET['lang_code'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_corp SET id='$id', corpterm='$corpterm', normal='$normal', primary_name='$primary_name', secondary_name='$secondary_name', date='$date', description='$description', variant_of='$variant_of', use_for='$use_for', source='$source', lang_code='$lang_code', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update corporate name failed!");


$sql_str="SELECT * FROM cms_auth_corp WHERE id=$id AND suppress IS NULL";
$corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($corpsearch);
echo $term;
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$results['id']."'>".$results['corpterm']."</a> has been updated</p>";

$corpterm = htmlentities(($results['corpterm']), ENT_QUOTES);
$normal = htmlentities(($results['normal']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><corpname authfilenumber='".$id."' rules='ncarules' normal='".$normal."'>\n".$corpterm."\n</corpname></xmp></td></tr></table>";


}

######################################################################################
elseif ($view == "corpadd") {

	 $sql_str="SELECT * FROM cms_auth_corp WHERE suppress IS NULL ORDER BY corpterm ASC";

	 $corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
echo "<table align='right' width='300'>";
echo "<tr><td><strong>People already in database</strong><textarea cols='40' rows='30' style='font-size:small; color:#000000; background-color:#ffffff' disabled='disabled' wrap='off'>";
while ($results = mysqli_fetch_array($corpsearch)):
echo $results['corpterm'] ."\n";
endwhile;
echo "</textarea></td></tr></table>"; ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">

<h3>Add term: Corporate Body</h3>

<table summary="">
<tr><td class="label">Term</td><td><textarea cols="61" rows="2" name="corpterm"></textarea></td></tr>
<tr><td class="label">Normal</td><td><input name="normal" size="75" type="text" /></td></tr>
<tr><td class="label">Family name</td><td><input name="primary_name" size="75" type="text" /></td></tr>
<tr><td class="label">Given name(s)</td><td><input name="secondary_name" size="75" type="text" /></td></tr>
<tr><td class="label">Date(s)</td><td><input name="date" size="75" type="text" /></td></tr>
<tr><td class="label">Description</td><td><textarea cols="61" rows="2" name="description"></textarea></td></tr>
<tr><td class="label">Variant of</td><td>
<select style="width:409px" name="variant_of">
<option value="0"></option>
<?php $sql_str2="SELECT * FROM cms_auth_corp WHERE suppress IS NULL ORDER BY corpterm ASC";

	 $authsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
while ($results2 = mysqli_fetch_array($authsearch)):
echo "<option style='width:400px;' value='".$results2['id']."'>".$results2['corpterm']."</option>";
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
<input type="hidden" name="view" value ="corpenter"/>
<input type="submit" value="Add term" />
</form>
<?php }

#########################################################
# Enter new corporate name 

elseif ($view == "corpenter") {

$corpterm = mysqli_real_escape_string($id_link, $_GET['corpterm']);
##$term = $_GET['term'];
$normal = mysqli_real_escape_string($id_link, $_GET['normal']);
$primary_name = mysqli_real_escape_string($id_link, $_GET['primary_name']);
$secondary_name = mysqli_real_escape_string($id_link, $_GET['secondary_name']);
$date = $_GET['date'];
$description = mysqli_real_escape_string($id_link, $_GET['description']);
$variant_of = mysqli_real_escape_string($id_link, $_GET['variant_of']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = mysqli_real_escape_string($id_link, $_GET['source']);
$lang_code = $_GET['lang_code'];
$last_edited = $date_time;
$last_edited_by = $display_user;
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_corp (id, corpterm, normal, primary_name, secondary_name, date, description, variant_of, use_for, source, lang_code, last_edited, last_edited_by, created_for, created_by, created_on) VALUES  (NULL, '$corpterm', '$normal', '$primary_name', '$secondary_name', '$date', '$description', '$variant_of', '$use_for', '$source', '$lang_code', '$last_edited', '$last_edited_by', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("<p>Enter corpon failed!</p>");


$sql_str="SELECT * FROM cms_auth_corp WHERE corpterm LIKE '$corpterm' AND suppress IS NULL";
$corpsearch = mysqli_query($id_link, $sql_str) or die("<p>Search Failed!</p>");
$results = mysqli_fetch_array($corpsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$results['id']."'>".$results['corpterm']."</a> has been added</p>";
$corpterm = htmlentities(($results['corpterm']), ENT_QUOTES);
$normal = htmlentities(($results['normal']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><corpname authfilenumber='".$results['id']."' rules='ncarules' normal='".$normal."'>\n".$corpterm."\n</corpname></xmp></td></tr></table>";

}


######################################################################################
########### END OF CORPORATE NAMES ####################################################
######################################################################################

######################################################################################
##### SUBJECTS #######################################################################
######################################################################################

## display subject list
elseif ($view == "subjlist") {

	 $sql_str="SELECT * FROM cms_auth_subj WHERE suppress IS NULL ORDER BY term ASC";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Subjects</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($subjsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjview&amp;id=".$results['id']."'>".$results['term']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";
}


######################################################################################
## display view screen for subject
elseif ($view == "subjview") {

	 $sql_str="SELECT * FROM cms_auth_subj WHERE id=$id AND suppress IS NULL";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Subject term</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
$results = mysqli_fetch_array($subjsearch);
echo "<tr><td class='label'>Term</td><td>".$results['term']."</td></tr>";
echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Other source</td><td>".$results['other']."</td></tr>";
echo "<tr><td class='label'>Created for (project/activity)</td><td>".$results['created_for']."</td></tr>";
echo "<tr><td class='label'>Created by</td><td>".$results['created_by']."</td></tr>";
echo "<tr><td class='label'>Created on</td><td>";
if ($results['created_on'] <> '0000-00-00 00:00:00') {
echo $results['created_on'];
}
else {
echo "before 17 August 2009";
}
echo "</td></tr>";

$datefromdb = $results['last_edited'];
include "sqldate.php";
echo "<tr><td class='label'>Last edited</td><td>".$displaydate."</td></tr>";
echo "<tr><td class='label'>Last edited by</td><td>".$results['last_edited_by']."</td></tr>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<tr><td class='label'>xml string</td><td><xmp><subject authfilenumber='".$id."' source='".$source."'>\n".$term."\n</subject></xmp></td></tr>";

echo "</table>";
echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjedit&amp;id=".$results['id']."'>Edit</a>";


$sql_str1="SELECT id FROM cms_auth_subj WHERE id < $id AND suppress IS NULL ORDER BY ID DESC LIMIT 1";
$navsearch1 = mysqli_query($id_link, $sql_str1) or die("Search Failed!");
$results1 = mysqli_fetch_array($navsearch1);
$prev = $results1['id'];

$sql_str2="SELECT id FROM cms_auth_subj WHERE id > $id AND suppress IS NULL ORDER BY ID ASC LIMIT 1";
$navsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($navsearch2);
$next = $results2['id'];

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjview&amp;id=".$prev."'>&lt;&lt;&lt;&lt;&lt;</a> | <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjview&amp;id=".$next."'>&gt;&gt;&gt;&gt;&gt;</a></p>";


}
######################################################################################
## display edit screen for subject
elseif ($view == "subjedit") {

	 $sql_str="SELECT * FROM cms_auth_subj WHERE id=$id AND suppress IS NULL";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($subjsearch);
	 
if ($results['source'] == "lcsh") { $source_title = "Library of Congress Subject Headings"; } 
if ($results['source'] == "sss") { $source_title = "School of Scottish Studies Thesaurus"; } 
if ($results['source'] == "ukat") { $source_title = "United Kingdom Archival Thesaurus"; } 
if ($results['source'] == "other") { $source_title = "other"; } 

 ?>
<h3>Edit term: Subject</h3>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="subjupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" value="<?php echo $results['term'] ?>" /></td></tr>
<tr><td class="label">Use for</td><td><input name="use_for" size="75" type="text" value="<?php echo $results['use_for'] ?>" /></td></tr>
<tr><td class="label">Source</td><td>
<select name="source">
<option value="<?php echo $results['source'] ?>"><?php echo $source_title ?> (current value)</option>
<option value="lcsh">Library of Congress Subject Headings</option>
<option value="sss">School of Scottish Studies Thesaurus</option>
<option value="ukat">United Kingdom Archival Thesaurus</option>
<option value="other">other</option>
</select>
</td></tr>
<tr><td class="label">Other Source *</td><td><input name="other" size="75" type="text" value="<?php echo $results['other'] ?>" /></td></tr>
<tr><td class="label">External identifier</td><td><input name="ext_id" size="75" type="text" value="<?php echo $results['ext_id'] ?>" /></td></tr>
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
# Update subject from Edit
elseif ($view == "subjupdate") {

$term = $_GET['term'];
$use_for = $_GET['use_for'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_subj SET id='$id', term='$term', use_for='$use_for', source='$source', other='$other', ext_id='$ext_id', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update subject failed!");


$sql_str="SELECT * FROM cms_auth_subj WHERE id=$id AND suppress IS NULL";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjview&amp;id=".$results['id']."'>".$results['term']."</a> has been updated</p>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><subject authfilenumber='".$id."' source='".$source."'>\n".$term."\n</subject></xmp></td></tr></table>";

}
######################################################################################
elseif ($view == "subjadd") {

	 $sql_str="SELECT * FROM cms_auth_subj WHERE suppress IS NULL ORDER BY term ASC";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
echo "<table align='right' width='200'>";
echo "<tr><td><strong>Subjects already in database</strong><textarea cols='40' rows='20' style='font-size:small; color:#000000; background-color:#ffffff' disabled='disabled'>";
while ($results = mysqli_fetch_array($subjsearch)):
echo $results['term'] ."\n";
endwhile;
echo "</textarea></td></tr></table>"; ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">

<h3>Add term: Subject</h3>

<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" /></td></tr>
<tr><td class="label">Use for</td><td><input name="use_for" size="75" type="text" /></td></tr>
<tr><td class="label">Source</td><td>
<select name="source">
<option value="lcsh">Library of Congress Subject Headings</option>
<option value="sss">School of Scottish Studies Thesaurus</option>
<option value="ukat">United Kingdom Archival Thesaurus</option>
<option value="other">other</option>
</select>
</td></tr>
<tr><td class="label">Other Source *</td><td><input name="other" size="75" type="text" /></td></tr>
<tr><td class="label">External identifier</td><td><input name="ext_id" size="75" type="text" /></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value="CW">CW</option>
<option value="EUA">EUA</option>
<option value="AMS">AMS</option>
</select>
</td></tr>
</table>

<input type="hidden" name="func" value ="authorities"/>
<input type="hidden" name="view" value ="subjenter"/>
<input type="submit" value="Add term" />
</form>
<?php }
#########################################################
# Enter new subject 
elseif ($view == "subjenter") {
$term = $_GET['term'];
$use_for = $_GET['use_for'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_subj (id, term, use_for, source, other, ext_id, created_for, created_by, created_on) VALUES  (NULL, '$term', '$use_for', '$source', '$other', '$ext_id', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("Enter subject failed!");


$sql_str="SELECT * FROM cms_auth_subj WHERE term LIKE '$term' AND suppress IS NULL";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjview&amp;id=".$results['id']."'>".$results['term']."</a> has been added</p>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><subject authfilenumber='".$results['id']."' source='".$source."'>\n".$term."\n</subject></xmp></td></tr></table>";

}

######################################################################################
########### END OF SUBJECTS ##########################################################
######################################################################################

######################################################################################
##### PLACES #########################################################################
######################################################################################
## display place list
elseif ($view == "geoglist") {

	 $sql_str="SELECT * FROM cms_auth_geog WHERE suppress IS NULL ORDER BY term ASC";

	 $geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Places</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($geogsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogview&amp;id=".$results['id']."'>".$results['term']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";

}
######################################################################################
## display view screen for places
elseif ($view == "geogview") {

	 $sql_str="SELECT * FROM cms_auth_geog WHERE id=$id AND suppress IS NULL";

	 $geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Place name</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
$results = mysqli_fetch_array($geogsearch);
echo "<tr><td class='label'>Term</td><td>".$results['term']."</td></tr>";
echo "<tr><td class='label'>Alt. form</td><td>".$results['alt_form']."</td></tr>";
echo "<tr><td class='label'>Alt. form language code</td><td>".$results['alt_form_lang']."</td></tr>";
echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Locator</td><td>".$results['locator']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Other source</td><td>".$results['other']."</td></tr>";
echo "<tr><td class='label'>Created for (project/activity)</td><td>".$results['created_for']."</td></tr>";
echo "<tr><td class='label'>Created by</td><td>".$results['created_by']."</td></tr>";
echo "<tr><td class='label'>Created on</td><td>";
if ($results['created_on'] <> '0000-00-00 00:00:00') {
echo $results['created_on'];
}
else {
echo "before 17 August 2009";
}
echo "</td></tr>";

$datefromdb = $results['last_edited'];
include "sqldate.php";
echo "<tr><td class='label'>Last edited</td><td>".$displaydate."</td></tr>";
echo "<tr><td class='label'>Last edited by</td><td>".$results['last_edited_by']."</td></tr>";
echo "<tr><td class='label'>xml string</td><td><textarea cols='70' rows='2'>&lt;geogname authfilenumber='".$id."' normal='".$results['term']."' source='".$results['source']."'&gt;".$results['term']."&lt;/geogname&gt;</textarea></td></tr>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<tr><td class='label'>xml string</td><td><xmp><geogname authfilenumber='".$id."' normal='".$term."' source='".$source."'>\n".$term."\n</geogname></xmp></td></tr>";

echo "</table>";
echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogedit&amp;id=".$results['id']."'>Edit</a>";

$sql_str1="SELECT id FROM cms_auth_geog WHERE id < $id AND suppress IS NULL ORDER BY ID DESC LIMIT 1";
$navsearch1 = mysqli_query($id_link, $sql_str1) or die("Search Failed!");
$results1 = mysqli_fetch_array($navsearch1);
$prev = $results1['id'];

$sql_str2="SELECT id FROM cms_auth_geog WHERE id > $id AND suppress IS NULL ORDER BY ID ASC LIMIT 1";
$navsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($navsearch2);
$next = $results2['id'];

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogview&amp;id=".$prev."'>&lt;&lt;&lt;&lt;&lt;</a> | <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogview&amp;id=".$next."'>&gt;&gt;&gt;&gt;&gt;</a></p>";

}

######################################################################################
## display edit screen for places
elseif ($view == "geogedit") {

	 $sql_str="SELECT * FROM cms_auth_geog WHERE id=$id AND suppress IS NULL";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($subjsearch);
	 
if ($results['source'] == "lcsh") { $source_title = "Library of Congress Subject Headings"; } 
if ($results['source'] == "sss") { $source_title = "School of Scottish Studies Thesaurus"; } 
if ($results['source'] == "ukat") { $source_title = "United Kingdom Archival Thesaurus"; } 
if ($results['source'] == "other") { $source_title = "other"; } 

 ?>
<h3>Edit term: Place name</h3>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="geogupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" value="<?php echo $results['term'] ?>" /></td></tr>
<tr><td class="label">Alt. form</td><td><input name="alt_form" size="75" type="text" value="<?php echo $results['alt_form'] ?>" /></td></tr>
<tr><td class="label">Alt. form language code</td><td><input name="alt_form_lang" size="75" type="text" value="<?php echo $results['alt_form_lang'] ?>" /></td></tr>
<tr><td class="label">Use for</td><td><input name="use_for" size="75" type="text" value="<?php echo $results['use_for'] ?>" />
<tr><td class="label">Locator</td><td><input name="ext_id" size="75" type="text" value="<?php echo $results['locator'] ?>" /></td></tr></td></tr>
<tr><td class="label">Source</td><td>
<select name="source">
<option value="<?php echo $results['source'] ?>"><?php echo $source_title ?> (current value)</option>
<option value="lcsh">Library of Congress Subject Headings</option>
<option value="sss">School of Scottish Studies Thesaurus</option>
<option value="ukat">United Kingdom Archival Thesaurus</option>
<option value="other">other</option>
</select>
</td></tr>
<tr><td class="label">Other Source *</td><td><input name="other" size="75" type="text" value="<?php echo $results['other'] ?>" /></td></tr>
<tr><td class="label">External identifier</td><td><input name="ext_id" size="75" type="text" value="<?php echo $results['ext_id'] ?>" /></td></tr>
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
# Update place from Edit
elseif ($view == "geogupdate") {

$term = $_GET['term'];
$alt_form = $_GET['alt_form'];
$alt_form_lang = $_GET['alt_form_lang'];
$use_for = $_GET['use_for'];
$locator = $_GET['locator'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_geog SET id='$id', term='$term', alt_form='$alt_form', alt_form_lang='$alt_form_lang',  use_for='$use_for', locator='$locator', source='$source', other='$other', ext_id='$ext_id', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update place failed!");


$sql_str="SELECT * FROM cms_auth_geog WHERE id=$id AND suppress IS NULL";
$geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($geogsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogview&amp;id=".$results['id']."'>".$results['term']."</a> has been updated</p>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><geogname authfilenumber='".$id."' normal='".$term."' source='".$source."'>\n".$term."\n</geogname></xmp></td></tr></table>";

}

######################################################################################
elseif ($view == "geogadd") {

	 $sql_str="SELECT * FROM cms_auth_geog WHERE suppress IS NULL ORDER BY term ASC";

	 $geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
echo "<table align='right' width='200'>";
echo "<tr><td><strong>Places already in database</strong><textarea cols='40' rows='20' style='font-size:small; color:#000000; background-color:#ffffff' disabled='disabled'>";
while ($results = mysqli_fetch_array($geogsearch)):
echo $results['term'] ."\n";
endwhile;
echo "</textarea></td></tr></table>"; ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">

<h3>Add term: Place</h3>

<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" /></td></tr>
<tr><td class="label">Alt. form</td><td><input name="alt_form" size="75" type="text" /></td></tr>
<tr><td class="label">Alt. form language code</td><td><input name="alt_form_lang" size="75" type="text" /></td></tr>
<tr><td class="label">Use for</td><td><input name="use_for" size="75" type="text" /></td></tr>
<tr><td class="label">Locator</td><td><input name="locator" size="75" type="text" /></td></tr>
<tr><td class="label">Source</td><td>
<select name="source">
<option value="lcsh">Library of Congress Subject Headings</option>
<option value="sss">School of Scottish Studies Thesaurus</option>
<option value="ukat">United Kingdom Archival Thesaurus</option>
<option value="other">other</option>
</select>
</td></tr>
<tr><td class="label">Other Source *</td><td><input name="other" size="75" type="text" /></td></tr>
<tr><td class="label">External identifier</td><td><input name="ext_id" size="75" type="text" /></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value="CW">CW</option>
<option value="EUA">EUA</option>
<option value="AMS">AMS</option>
</select>
</td></tr>
</table>

<input type="hidden" name="func" value ="authorities"/>
<input type="hidden" name="view" value ="geogenter"/>
<input type="submit" value="Add term" />
</form>
<?php }

#########################################################
# Enter new place 
elseif ($view == "geogenter") {
$term = $_GET['term'];
$alt_form = $_GET['alt_form'];
$alt_form_lang = $_GET['alt_form_lang'];
$use_for = $_GET['use_for'];
$locator = $_GET['locator'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_geog (id, term, alt_form, alt_form_lang use_for, locator, source, other, ext_id, created_for, created_by, created_on) VALUES  (NULL, '$term', '$alt_form', '$alt_form_lang', '$use_for', '$locator', '$source', '$other', '$ext_id', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("Enter place failed!");


$sql_str="SELECT * FROM cms_auth_geog WHERE term LIKE '$term' AND suppress IS NULL";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogview&amp;id=".$results['id']."'>".$results['term']."</a> has been added</p>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><geogname authfilenumber='".$results['id']."' normal='".$term."' source='".$source."'>\n".$term."\n</geogname></xmp></td></tr></table>";

}

######################################################################################
########### END OF PLACES ############################################################
######################################################################################

######################################################################################
##### GENRES #########################################################################
######################################################################################
## display genre list
elseif ($view == "genrlist") {

	 $sql_str="SELECT * FROM cms_auth_genr WHERE suppress IS NULL ORDER BY term ASC";

	 $genrsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Genre</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($genrsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrview&amp;id=".$results['id']."'>".$results['term']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genredit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";

}
## display view screen for genr
elseif ($view == "genrview") {

	 $sql_str="SELECT * FROM cms_auth_genr WHERE id=$id AND suppress IS NULL";

	 $genrsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Genre</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
$results = mysqli_fetch_array($genrsearch);
echo "<tr><td class='label'>Term</td><td>".$results['term']."</td></tr>";
echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Other source</td><td>".$results['other']."</td></tr>";
echo "<tr><td class='label'>Created for (project/activity)</td><td>".$results['created_for']."</td></tr>";
echo "<tr><td class='label'>Created by</td><td>".$results['created_by']."</td></tr>";
echo "<tr><td class='label'>Created on</td><td>";
if ($results['created_on'] <> '0000-00-00 00:00:00') {
echo $results['created_on'];
}
else {
echo "before 17 August 2009";
}
echo "</td></tr>";

$datefromdb = $results['last_edited'];
include "sqldate.php";
echo "<tr><td class='label'>Last edited</td><td>".$displaydate."</td></tr>";
echo "<tr><td class='label'>Last edited by</td><td>".$results['last_edited_by']."</td></tr>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<tr><td class='label'>xml string</td><td><xmp><genreform authfilenumber='".$id."' normal='".$term."' source='".$source."'>\n".$term."\n</genreform></xmp></td></tr>";

echo "</table>";
echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genredit&amp;id=".$results['id']."'>Edit</a>";

$sql_str1="SELECT id FROM cms_auth_genr WHERE id < $id AND suppress IS NULL ORDER BY ID DESC LIMIT 1";
$navsearch1 = mysqli_query($id_link, $sql_str1) or die("Search Failed!");
$results1 = mysqli_fetch_array($navsearch1);
$prev = $results1['id'];

$sql_str2="SELECT id FROM cms_auth_genr WHERE id > $id AND suppress IS NULL ORDER BY ID ASC LIMIT 1";
$navsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($navsearch2);
$next = $results2['id'];

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrview&amp;id=".$prev."'>&lt;&lt;&lt;&lt;&lt;</a> | <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrview&amp;id=".$next."'>&gt;&gt;&gt;&gt;&gt;</a></p>";

}

## display edit screen for genre
elseif ($view == "genredit") {

	 $sql_str="SELECT * FROM cms_auth_genr WHERE id=$id AND suppress IS NULL";

	 $genrsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($genrsearch);
	 
if ($results['source'] == "lcsh") { $source_title = "Library of Congress Subject Headings"; } 
if ($results['source'] == "sss") { $source_title = "School of Scottish Studies Thesaurus"; } 
if ($results['source'] == "ukat") { $source_title = "United Kingdom Archival Thesaurus"; } 
if ($results['source'] == "other") { $source_title = "other"; } 

 ?>
<h3>Edit term: Genre</h3>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="genrupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" value="<?php echo $results['term'] ?>" /></td></tr>
<tr><td class="label">Use for</td><td><input name="use_for" size="75" type="text" value="<?php echo $results['use_for'] ?>" />
<tr><td class="label">Source</td><td>
<select name="source">
<option value="<?php echo $results['source'] ?>"><?php echo $source_title ?> (current value)</option>
<option value="lcsh">Library of Congress Subject Headings</option>
<option value="sss">School of Scottish Studies Thesaurus</option>
<option value="ukat">United Kingdom Archival Thesaurus</option>
<option value="other">other</option>
</select>
</td></tr>
<tr><td class="label">Other Source *</td><td><input name="other" size="75" type="text" value="<?php echo $results['other'] ?>" /></td></tr>
<tr><td class="label">External identifier</td><td><input name="ext_id" size="75" type="text" value="<?php echo $results['ext_id'] ?>" /></td></tr>
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
# Update genre from Edit
elseif ($view == "genrupdate") {

$term = $_GET['term'];
$use_for = $_GET['use_for'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_genr SET id='$id', term='$term', use_for='$use_for', source='$source', other='$other', ext_id='$ext_id', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update subject failed!");


$sql_str="SELECT * FROM cms_auth_genr WHERE id=$id AND suppress IS NULL";
$geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($geogsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrview&amp;id=".$results['id']."'>".$results['term']."</a> has been updated</p>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><genreform authfilenumber='".$id."' normal='".$term."' source='".$source."'>\n".$term."\n</genreform></xmp></td></tr></table>";

}

######################################################################################
elseif ($view == "genradd") {

	 $sql_str="SELECT * FROM cms_auth_genr WHERE suppress IS NULL ORDER BY term ASC";

	 $genrsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
echo "<table align='right' width='200'>";
echo "<tr><td><strong>Genres already in database</strong><textarea cols='40' rows='20' style='font-size:small; color:#000000; background-color:#ffffff' disabled='disabled'>";
while ($results = mysqli_fetch_array($genrsearch)):
echo $results['term'] ."\n";
endwhile;
echo "</textarea></td></tr></table>"; ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">

<h3>Add term: Genre</h3>

<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" /></td></tr>
<tr><td class="label">Use for</td><td><input name="use_for" size="75" type="text" /></td></tr>
<tr><td class="label">Source</td><td>
<select name="source">
<option value="lcsh">Library of Congress Subject Headings</option>
<option value="sss">School of Scottish Studies Thesaurus</option>
<option value="ukat">United Kingdom Archival Thesaurus</option>
<option value="other">other</option>
</select>
</td></tr>
<tr><td class="label">Other Source *</td><td><input name="other" size="75" type="text" /></td></tr>
<tr><td class="label">External identifier</td><td><input name="ext_id" size="75" type="text" /></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value="CW">CW</option>
<option value="EUA">EUA</option>
<option value="AMS">AMS</option>
</select>
</td></tr>
</table>

<input type="hidden" name="func" value ="authorities"/>
<input type="hidden" name="view" value ="genrenter"/>
<input type="submit" value="Add term" />
</form>
<?php }
#########################################################
# Enter new genre 
elseif ($view == "genrenter") {
$term = $_GET['term'];
$use_for = $_GET['use_for'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_genr (id, term, use_for, source, other, ext_id, created_for, created_by, created_on) VALUES  (NULL, '$term', '$use_for', '$source', '$other', '$ext_id', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("Enter genre failed!");


$sql_str="SELECT * FROM cms_auth_genr WHERE term LIKE '$term' AND suppress IS NULL";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrview&amp;id=".$results['id']."'>".$results['term']."</a> has been added</p>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><genreform authfilenumber='".$results['id']."' normal='".$term."' source='".$source."'>\n".$term."\n</genreform></xmp></td></tr></table>";

}
elseif ($view == "persfix") {

	 $sql_str="SELECT * FROM cms_auth_pers WHERE suppress IS NULL ORDER BY id ASC";

	 $perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>People</h3>";
while ($results = mysqli_fetch_array($perssearch)):
$pieces = explode(" | ", $results['term']);
$family_name = $pieces[0];
$id= $results['id']; 
$sql_str="UPDATE cms_auth_pers SET family_name='$family_name' WHERE id='$id' LIMIT 1";
if ($id <> '2024') {
mysqli_query($id_link, $sql_str) or die ("Update failed!");
echo "<p>Term ".$id." updated, surname ".$pieces[0]."</p>";
}
endwhile;


}

######################################################################################
########### END OF GENRES ############################################################
######################################################################################

######################################################################################
######################################################################################





####################################################################################################
## display error message when illegal view is called for
else {
echo "<p>Error</p>";
} 

?> <?php  
###########################################################################
############### Authorities script ########################################
############### manages authorities tables in MySQL database ##############
############### created by Grant Buttars ##################################
###########################################################################

##  global variables for this script
$date_time = date("Y-m-d H:i:s"); 
$id = $_GET['id'];
$type = $_GET['type'];
$created_for = $_GET['created_for'];
##########################################################################

## the following appears regardless of which view is called
echo "<h2>Authorities</h2>";
##########################################################################

## 
##if ($view = "persenter" OR $view = "corpenter" OR $view = "subjenter" OR $view = "geogenter" OR $view = "genrenter") {
##echo "<p>DO NOT use your BACK button on this page - this can cause erroneous duplicate entries to be created.<p>";
##}
##########################################################################

## show up link on all but front page
 if (isset ($view)) { echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities'><img src='/graphics/up.gif' alt='Up to Authorities Menu' border='0' /></a>"; }
######################################################################################

## display menu on front page
if (!isset ($view)) { 
echo "<h3>Menu</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
echo "<tr><td class='label'>People</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=perslist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=perslist&amp;created_for=CW'>List, A-Z (CW only)</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persadd'>Add new term</a></td></tr>";
echo "<tr><td class='label'>Corporate Bodies</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corplist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpadd'>Add new term</a></td></tr>";
echo "<tr><td class='label'>Subjects</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjlist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjadd'>Add new term</a></td></tr>";
echo "<tr><td class='label'>Places</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geoglist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogadd'>Add new term</a></td></tr>";
echo "<tr><td class='label'>Genre</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrlist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genradd'>Add new term</a></td></tr>";
echo "</table>"; ?>


<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="search" />
<input type="text" name="searchterm" size="55" /><br />
<select name="type">
<option value="pers">People</option>
<option value="corp">Corporate Bodies</option>
<option value="subj">Subjects</option>
<option value="geog">Places</option>
<option value="genr">Genres</option>
</select> &nbsp;&nbsp;
<input type="submit" value="Quick Search" />
</form>

<?php
}
######################################################################################

######################################################################################
## display search results
elseif ($view == "search") {
$searchterm = $_GET['searchterm'];
if ($_GET['type'] == "pers") { $table = "cms_auth_pers"; }
if ($_GET['type'] == "corp") { $table = "cms_auth_corp"; }
if ($_GET['type'] == "subj") { $table = "cms_auth_subj"; }
if ($_GET['type'] == "geog") { $table = "cms_auth_geog"; }
if ($_GET['type'] == "genr") { $table = "cms_auth_genr"; }

if ($_GET['type'] == "pers") { $sql_str="SELECT * FROM $table WHERE persterm LIKE '%$searchterm%' AND suppress IS NULL ORDER BY persterm ASC"; }
elseif ($_GET['type'] == "corp") { $sql_str="SELECT * FROM $table WHERE corpterm LIKE '%$searchterm%' AND suppress IS NULL ORDER BY corpterm ASC"; }
else { $sql_str="SELECT * FROM $table WHERE term LIKE '%$searchterm%' AND suppress IS NULL ORDER BY term ASC"; }

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Results</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($subjsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=".$_GET['type']."view&amp;id=".$results['id']."'>".$results['term'].$results['persterm'].$results['corpterm']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=".$_GET['type']."edit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";
}

######################################################################################
######################################################################################

######################################################################################
##### PERSONAL NAMES #################################################################
######################################################################################

## display personal name list
elseif ($view == "perslist") {

	 $sql_str="SELECT * FROM cms_auth_pers WHERE created_for LIKE'$created_for%' AND suppress IS NULL ORDER BY persterm ASC";

	 $perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>People</h3>";
	 
	 if (isset ($created_for)) {
	 echo "<div>Filtered:".$created_for."</div>";
	 }
	 
	 echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persadd'>Add new term</a></p>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($perssearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results['id']."'>".$results['persterm']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";

}

######################################################################################
## display view screen for personal name
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

echo "<tr><td class='label' valign='top'>Variants</td><td>";

if ($results['variant_of'] == 0) {


$sql_str2="SELECT * FROM cms_auth_pers WHERE variant_of=$id and suppress IS NULL";
$varsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
while ($results2 = mysqli_fetch_array($varsearch)):

include "nca_name_form.php";

echo "<div><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results2['id']."'>".$nca_str2."</a></div>";

endwhile;

}
else {

$variant_of = $results['variant_of'];

$sql_str2="SELECT * FROM cms_auth_pers WHERE id=$variant_of and suppress IS NULL";
$prefsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($prefsearch);

include "nca_name_form.php";

echo "<div>Non-preferred term for: <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results2['id']."'>".$nca_str2."</a></div>";

}

echo "</td></tr>";

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
	 
 ?>
<h3>Edit term: Person</h3>
<div style="margin-left:550px;"><a href="<?php echo $_SERVER['PHP_SELF'] ?>?func=authorities&amp;view=persdelete&id=<?php echo $results['id'] ?>">Delete term</a></div>

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
echo "<option style='width:400px;' value='".$results3['id']."'>".$results3['persterm']."</option>";
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

$persterm = mysqli_real_escape_string($id_link, $_GET['persterm']);
##$term = $_GET['term'];
$normal = mysqli_real_escape_string($id_link, $_GET['normal']);
$family_name = mysqli_real_escape_string($id_link, $_GET['family_name']);
$given_name = mysqli_real_escape_string($id_link, $_GET['given_name']);
$date = $_GET['date'];
$terms_of_address = mysqli_real_escape_string($id_link, $_GET['terms_of_address']);
$description = mysqli_real_escape_string($id_link, $_GET['description']);
$variant_of = mysqli_real_escape_string($id_link, $_GET['variant_of']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = mysqli_real_escape_string($id_link, $_GET['source']);
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
<select style="width:409px" name="variant_of">
<option value="0"></option>
<?php $sql_str2="SELECT * FROM cms_auth_pers WHERE suppress IS NULL ORDER BY persterm ASC";

	 $authsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
while ($results2 = mysqli_fetch_array($authsearch)):
echo "<option style='width:400px;' value='".$results2['id']."'>".$results2['persterm']."</option>";
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

$persterm = mysqli_real_escape_string($id_link, $_GET['persterm']);
##$term = $_GET['term'];
$normal = mysqli_real_escape_string($id_link, $_GET['normal']);
$family_name = mysqli_real_escape_string($id_link, $_GET['family_name']);
$given_name = mysqli_real_escape_string($id_link, $_GET['given_name']);
$date = $_GET['date'];
$terms_of_address = mysqli_real_escape_string($id_link, $_GET['terms_of_address']);
$description = mysqli_real_escape_string($id_link, $_GET['description']);
$variant_of = mysqli_real_escape_string($id_link, $_GET['variant_of']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = mysqli_real_escape_string($id_link, $_GET['source']);
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

#########################################################
# Delete a person 
elseif ($view == "persdelete") {

$sql_str="SELECT * FROM cms_auth_pers WHERE id=$id";
$perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($perssearch);

include "nca_name_form.php";

if ($results['variant_of'] == 0) {

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results['id']."'>".$nca_str."</a></p>";

$sql_str2="SELECT * FROM cms_auth_pers WHERE variant_of=$id";
$varsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$num_rows = mysql_num_rows($varsearch);
if ($num_rows >0) {
echo "<div>Varaints exist for this term.  You may not delete it until all variants have been deleted or disassociated from it.</div>";
}
}
else {


echo "<p>".$nca_str."</p>";

$variant_of = $results['variant_of'];

$sql_str2="SELECT * FROM cms_auth_pers WHERE id=$variant_of";
$prefsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($prefsearch);

include "nca_name_form.php";

echo "<p>Non-preferred term for:<br /><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results2['id']."'>".$nca_str2."</a></p>";

}

$sql_str="UPDATE cms_auth_pers SET suppress='y' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Delete person failed!");

echo "<p>This term has been deleted</p>";
}

######################################################################################
########### END OF PERSONAL NAMES ####################################################
######################################################################################


######################################################################################
##### CORPORATE NAMES #################################################################
######################################################################################

## display corporate name list
elseif ($view == "corplist") {

	 $sql_str="SELECT * FROM cms_auth_corp WHERE suppress IS NULL ORDER BY corpterm ASC";

	 $corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Corporate Bodies</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($corpsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$results['id']."'>".$results['corpterm']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";

}

######################################################################################
## display view screen for corporate name
elseif ($view == "corpview") {

$sql_str="SELECT * FROM cms_auth_corp WHERE id=$id AND suppress IS NULL";

	 $corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Corporate Body</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
$results = mysqli_fetch_array($corpsearch);
echo "<tr><td class='label'>Term</td><td>".$results['corpterm']."</td></tr>";
echo "<tr><td class='label'>Normal</td><td>".$results['normal']."</td></tr>";
echo "<tr><td class='label'>Primary name</td><td>".$results['primary_name']."</td></tr>";
echo "<tr><td class='label'>Secondary names</td><td>".$results['secondary_name']."</td></tr>";
echo "<tr><td class='label'>Date(s)</td><td>".$results['date']."</td></tr>";
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

$corpterm = htmlentities(($results['corpterm']), ENT_QUOTES);
$normal = htmlentities(($results['normal']), ENT_QUOTES);

echo "<tr><td class='label'>Last edited</td><td>".$displaydate."</td></tr>";
echo "<tr><td class='label'>Last edited by</td><td>".$results['last_edited_by']."</td></tr>";
echo "<tr><td class='label'>xml string</td><td><xmp><corpname authfilenumber='".$id."' rules='ncarules' normal='".$normal."'>\n".$corpterm."\n</corpname></xmp></td></tr>";

echo "</table>";
echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpedit&amp;id=".$results['id']."'>Edit</a>";


$sql_str1="SELECT id FROM cms_auth_corp WHERE id < $id AND suppress IS NULL ORDER BY ID DESC LIMIT 1";
$navsearch1 = mysqli_query($id_link, $sql_str1) or die("Search Failed!");
$results1 = mysqli_fetch_array($navsearch1);
$prev = $results1['id'];

$sql_str2="SELECT id FROM cms_auth_corp WHERE id > $id AND suppress IS NULL ORDER BY ID ASC LIMIT 1";
$navsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($navsearch2);
$next = $results2['id'];

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$prev."'>&lt;&lt;&lt;&lt;&lt;</a> | <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$next."'>&gt;&gt;&gt;&gt;&gt;</a></p>";

}

######################################################################################

## display edit screen for corporate name
elseif ($view == "corpedit") {

$sql_str="SELECT * FROM cms_auth_corp WHERE id=$id AND suppress IS NULL";

	 $corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($corpsearch);
	 
 ?>
<h3>Edit term: Corporate Body</h3>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="corpupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Term</td><td><textarea cols="61" rows="2" name="corpterm"><?php echo $results['corpterm'] ?></textarea></td></tr>
<tr><td class="label">Normal</td><td><input name="normal" size="75" type="text" value="<?php echo $results['normal'] ?>" /></td></tr>
<tr><td class="label">Family name</td><td><input name="primary_name" size="75" type="text" value="<?php echo $results['primary_name'] ?>" /></td></tr>
<tr><td class="label">Given name(s)</td><td><input name="secondary_name" size="75" type="text" value="<?php echo $results['secondary_name'] ?>" /></td></tr>
<tr><td class="label">Date(s)</td><td><input name="date" size="75" type="text" value="<?php echo $results['date'] ?>" /></td></tr>
<tr><td class="label">Description</td><td><input name="description" size="75" type="text" value="<?php echo $results['description'] ?>" /></td></tr>
<tr><td class="label">Variant of</td><td>



<?php   $var_id = $results['variant_of'];
	if ($var_id == 0 ) {

     echo "<div>Currently set as: this is the authority version of the name</div>";
	 } else {

     $sql_str2="SELECT * FROM cms_auth_corp where id='$var_id' AND suppress IS NULL";
	 $authsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
	 $results2 = mysqli_fetch_array($authsearch2);	
echo "<div>Currently set as:  ".$results2['corpterm']."</div>";
}
echo "Change to: <select style='width:409px;' name='variant_of'>";
echo "<option value='0'>this is the authority version of the name</option>";
	$sql_str3="SELECT * FROM cms_auth_corp ORDER BY primary_name ASC";
	 $authsearch3 = mysqli_query($id_link, $sql_str3) or die("Search Failed!");
while ($results3 = mysqli_fetch_array($authsearch3)):
echo "<option style='width:400px;' value='".$results3['id']."'>".$results3['corpterm']."</option>";
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
## Update corporate name from Edit
elseif ($view == "corpupdate") {

$corpterm = mysqli_real_escape_string($id_link, $_GET['corpterm']);
##$term = $_GET['term'];
$normal = mysqli_real_escape_string($id_link, $_GET['normal']);
$primary_name = mysqli_real_escape_string($id_link, $_GET['primary_name']);
$secondary_name = mysqli_real_escape_string($id_link, $_GET['secondary_name']);
$date = $_GET['date'];
$terms_of_address = mysqli_real_escape_string($id_link, $_GET['terms_of_address']);
$description = mysqli_real_escape_string($id_link, $_GET['description']);
$variant_of = mysqli_real_escape_string($id_link, $_GET['variant_of']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = $_GET['source'];
$lang_code = $_GET['lang_code'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_corp SET id='$id', corpterm='$corpterm', normal='$normal', primary_name='$primary_name', secondary_name='$secondary_name', date='$date', description='$description', variant_of='$variant_of', use_for='$use_for', source='$source', lang_code='$lang_code', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update corporate name failed!");


$sql_str="SELECT * FROM cms_auth_corp WHERE id=$id AND suppress IS NULL";
$corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($corpsearch);
echo $term;
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$results['id']."'>".$results['corpterm']."</a> has been updated</p>";

$corpterm = htmlentities(($results['corpterm']), ENT_QUOTES);
$normal = htmlentities(($results['normal']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><corpname authfilenumber='".$id."' rules='ncarules' normal='".$normal."'>\n".$corpterm."\n</corpname></xmp></td></tr></table>";


}

######################################################################################
elseif ($view == "corpadd") {

	 $sql_str="SELECT * FROM cms_auth_corp WHERE suppress IS NULL ORDER BY corpterm ASC";

	 $corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
echo "<table align='right' width='300'>";
echo "<tr><td><strong>People already in database</strong><textarea cols='40' rows='30' style='font-size:small; color:#000000; background-color:#ffffff' disabled='disabled' wrap='off'>";
while ($results = mysqli_fetch_array($corpsearch)):
echo $results['corpterm'] ."\n";
endwhile;
echo "</textarea></td></tr></table>"; ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">

<h3>Add term: Corporate Body</h3>

<table summary="">
<tr><td class="label">Term</td><td><textarea cols="61" rows="2" name="corpterm"></textarea></td></tr>
<tr><td class="label">Normal</td><td><input name="normal" size="75" type="text" /></td></tr>
<tr><td class="label">Family name</td><td><input name="primary_name" size="75" type="text" /></td></tr>
<tr><td class="label">Given name(s)</td><td><input name="secondary_name" size="75" type="text" /></td></tr>
<tr><td class="label">Date(s)</td><td><input name="date" size="75" type="text" /></td></tr>
<tr><td class="label">Description</td><td><textarea cols="61" rows="2" name="description"></textarea></td></tr>
<tr><td class="label">Variant of</td><td>
<select style="width:409px" name="variant_of">
<option value="0"></option>
<?php $sql_str2="SELECT * FROM cms_auth_corp WHERE suppress IS NULL ORDER BY corpterm ASC";

	 $authsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
while ($results2 = mysqli_fetch_array($authsearch)):
echo "<option style='width:400px;' value='".$results2['id']."'>".$results2['corpterm']."</option>";
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
<input type="hidden" name="view" value ="corpenter"/>
<input type="submit" value="Add term" />
</form>
<?php }

#########################################################
# Enter new corporate name 

elseif ($view == "corpenter") {

$corpterm = mysqli_real_escape_string($id_link, $_GET['corpterm']);
##$term = $_GET['term'];
$normal = mysqli_real_escape_string($id_link, $_GET['normal']);
$primary_name = mysqli_real_escape_string($id_link, $_GET['primary_name']);
$secondary_name = mysqli_real_escape_string($id_link, $_GET['secondary_name']);
$date = $_GET['date'];
$description = mysqli_real_escape_string($id_link, $_GET['description']);
$variant_of = mysqli_real_escape_string($id_link, $_GET['variant_of']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = mysqli_real_escape_string($id_link, $_GET['source']);
$lang_code = $_GET['lang_code'];
$last_edited = $date_time;
$last_edited_by = $display_user;
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_corp (id, corpterm, normal, primary_name, secondary_name, date, description, variant_of, use_for, source, lang_code, last_edited, last_edited_by, created_for, created_by, created_on) VALUES  (NULL, '$corpterm', '$normal', '$primary_name', '$secondary_name', '$date', '$description', '$variant_of', '$use_for', '$source', '$lang_code', '$last_edited', '$last_edited_by', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("<p>Enter corpon failed!</p>");


$sql_str="SELECT * FROM cms_auth_corp WHERE corpterm LIKE '$corpterm' AND suppress IS NULL";
$corpsearch = mysqli_query($id_link, $sql_str) or die("<p>Search Failed!</p>");
$results = mysqli_fetch_array($corpsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$results['id']."'>".$results['corpterm']."</a> has been added</p>";
$corpterm = htmlentities(($results['corpterm']), ENT_QUOTES);
$normal = htmlentities(($results['normal']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><corpname authfilenumber='".$results['id']."' rules='ncarules' normal='".$normal."'>\n".$corpterm."\n</corpname></xmp></td></tr></table>";

}


######################################################################################
########### END OF CORPORATE NAMES ####################################################
######################################################################################

######################################################################################
##### SUBJECTS #######################################################################
######################################################################################

## display subject list
elseif ($view == "subjlist") {

	 $sql_str="SELECT * FROM cms_auth_subj WHERE suppress IS NULL ORDER BY term ASC";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Subjects</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($subjsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjview&amp;id=".$results['id']."'>".$results['term']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";
}


######################################################################################
## display view screen for subject
elseif ($view == "subjview") {

	 $sql_str="SELECT * FROM cms_auth_subj WHERE id=$id AND suppress IS NULL";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Subject term</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
$results = mysqli_fetch_array($subjsearch);
echo "<tr><td class='label'>Term</td><td>".$results['term']."</td></tr>";
echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Other source</td><td>".$results['other']."</td></tr>";
echo "<tr><td class='label'>Created for (project/activity)</td><td>".$results['created_for']."</td></tr>";
echo "<tr><td class='label'>Created by</td><td>".$results['created_by']."</td></tr>";
echo "<tr><td class='label'>Created on</td><td>";
if ($results['created_on'] <> '0000-00-00 00:00:00') {
echo $results['created_on'];
}
else {
echo "before 17 August 2009";
}
echo "</td></tr>";

$datefromdb = $results['last_edited'];
include "sqldate.php";
echo "<tr><td class='label'>Last edited</td><td>".$displaydate."</td></tr>";
echo "<tr><td class='label'>Last edited by</td><td>".$results['last_edited_by']."</td></tr>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<tr><td class='label'>xml string</td><td><xmp><subject authfilenumber='".$id."' source='".$source."'>\n".$term."\n</subject></xmp></td></tr>";

echo "</table>";
echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjedit&amp;id=".$results['id']."'>Edit</a>";


$sql_str1="SELECT id FROM cms_auth_subj WHERE id < $id AND suppress IS NULL ORDER BY ID DESC LIMIT 1";
$navsearch1 = mysqli_query($id_link, $sql_str1) or die("Search Failed!");
$results1 = mysqli_fetch_array($navsearch1);
$prev = $results1['id'];

$sql_str2="SELECT id FROM cms_auth_subj WHERE id > $id AND suppress IS NULL ORDER BY ID ASC LIMIT 1";
$navsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($navsearch2);
$next = $results2['id'];

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjview&amp;id=".$prev."'>&lt;&lt;&lt;&lt;&lt;</a> | <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjview&amp;id=".$next."'>&gt;&gt;&gt;&gt;&gt;</a></p>";


}
######################################################################################
## display edit screen for subject
elseif ($view == "subjedit") {

	 $sql_str="SELECT * FROM cms_auth_subj WHERE id=$id AND suppress IS NULL";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($subjsearch);
	 
if ($results['source'] == "lcsh") { $source_title = "Library of Congress Subject Headings"; } 
if ($results['source'] == "sss") { $source_title = "School of Scottish Studies Thesaurus"; } 
if ($results['source'] == "ukat") { $source_title = "United Kingdom Archival Thesaurus"; } 
if ($results['source'] == "other") { $source_title = "other"; } 

 ?>
<h3>Edit term: Subject</h3>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="subjupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" value="<?php echo $results['term'] ?>" /></td></tr>
<tr><td class="label">Use for</td><td><input name="use_for" size="75" type="text" value="<?php echo $results['use_for'] ?>" /></td></tr>
<tr><td class="label">Source</td><td>
<select name="source">
<option value="<?php echo $results['source'] ?>"><?php echo $source_title ?> (current value)</option>
<option value="lcsh">Library of Congress Subject Headings</option>
<option value="sss">School of Scottish Studies Thesaurus</option>
<option value="ukat">United Kingdom Archival Thesaurus</option>
<option value="other">other</option>
</select>
</td></tr>
<tr><td class="label">Other Source *</td><td><input name="other" size="75" type="text" value="<?php echo $results['other'] ?>" /></td></tr>
<tr><td class="label">External identifier</td><td><input name="ext_id" size="75" type="text" value="<?php echo $results['ext_id'] ?>" /></td></tr>
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
# Update subject from Edit
elseif ($view == "subjupdate") {

$term = $_GET['term'];
$use_for = $_GET['use_for'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_subj SET id='$id', term='$term', use_for='$use_for', source='$source', other='$other', ext_id='$ext_id', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update subject failed!");


$sql_str="SELECT * FROM cms_auth_subj WHERE id=$id AND suppress IS NULL";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjview&amp;id=".$results['id']."'>".$results['term']."</a> has been updated</p>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><subject authfilenumber='".$id."' source='".$source."'>\n".$term."\n</subject></xmp></td></tr></table>";

}
######################################################################################
elseif ($view == "subjadd") {

	 $sql_str="SELECT * FROM cms_auth_subj WHERE suppress IS NULL ORDER BY term ASC";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
echo "<table align='right' width='200'>";
echo "<tr><td><strong>Subjects already in database</strong><textarea cols='40' rows='20' style='font-size:small; color:#000000; background-color:#ffffff' disabled='disabled'>";
while ($results = mysqli_fetch_array($subjsearch)):
echo $results['term'] ."\n";
endwhile;
echo "</textarea></td></tr></table>"; ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">

<h3>Add term: Subject</h3>

<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" /></td></tr>
<tr><td class="label">Use for</td><td><input name="use_for" size="75" type="text" /></td></tr>
<tr><td class="label">Source</td><td>
<select name="source">
<option value="lcsh">Library of Congress Subject Headings</option>
<option value="sss">School of Scottish Studies Thesaurus</option>
<option value="ukat">United Kingdom Archival Thesaurus</option>
<option value="other">other</option>
</select>
</td></tr>
<tr><td class="label">Other Source *</td><td><input name="other" size="75" type="text" /></td></tr>
<tr><td class="label">External identifier</td><td><input name="ext_id" size="75" type="text" /></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value="CW">CW</option>
<option value="EUA">EUA</option>
<option value="AMS">AMS</option>
</select>
</td></tr>
</table>

<input type="hidden" name="func" value ="authorities"/>
<input type="hidden" name="view" value ="subjenter"/>
<input type="submit" value="Add term" />
</form>
<?php }
#########################################################
# Enter new subject 
elseif ($view == "subjenter") {
$term = $_GET['term'];
$use_for = $_GET['use_for'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_subj (id, term, use_for, source, other, ext_id, created_for, created_by, created_on) VALUES  (NULL, '$term', '$use_for', '$source', '$other', '$ext_id', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("Enter subject failed!");


$sql_str="SELECT * FROM cms_auth_subj WHERE term LIKE '$term' AND suppress IS NULL";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjview&amp;id=".$results['id']."'>".$results['term']."</a> has been added</p>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><subject authfilenumber='".$results['id']."' source='".$source."'>\n".$term."\n</subject></xmp></td></tr></table>";

}

######################################################################################
########### END OF SUBJECTS ##########################################################
######################################################################################

######################################################################################
##### PLACES #########################################################################
######################################################################################
## display place list
elseif ($view == "geoglist") {

	 $sql_str="SELECT * FROM cms_auth_geog WHERE suppress IS NULL ORDER BY term ASC";

	 $geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Places</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($geogsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogview&amp;id=".$results['id']."'>".$results['term']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";

}
######################################################################################
## display view screen for places
elseif ($view == "geogview") {

	 $sql_str="SELECT * FROM cms_auth_geog WHERE id=$id AND suppress IS NULL";

	 $geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Place name</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
$results = mysqli_fetch_array($geogsearch);
echo "<tr><td class='label'>Term</td><td>".$results['term']."</td></tr>";
echo "<tr><td class='label'>Alt. form</td><td>".$results['alt_form']."</td></tr>";
echo "<tr><td class='label'>Alt. form language code</td><td>".$results['alt_form_lang']."</td></tr>";
echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Locator</td><td>".$results['locator']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Other source</td><td>".$results['other']."</td></tr>";
echo "<tr><td class='label'>Created for (project/activity)</td><td>".$results['created_for']."</td></tr>";
echo "<tr><td class='label'>Created by</td><td>".$results['created_by']."</td></tr>";
echo "<tr><td class='label'>Created on</td><td>";
if ($results['created_on'] <> '0000-00-00 00:00:00') {
echo $results['created_on'];
}
else {
echo "before 17 August 2009";
}
echo "</td></tr>";

$datefromdb = $results['last_edited'];
include "sqldate.php";
echo "<tr><td class='label'>Last edited</td><td>".$displaydate."</td></tr>";
echo "<tr><td class='label'>Last edited by</td><td>".$results['last_edited_by']."</td></tr>";
echo "<tr><td class='label'>xml string</td><td><textarea cols='70' rows='2'>&lt;geogname authfilenumber='".$id."' normal='".$results['term']."' source='".$results['source']."'&gt;".$results['term']."&lt;/geogname&gt;</textarea></td></tr>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<tr><td class='label'>xml string</td><td><xmp><geogname authfilenumber='".$id."' normal='".$term."' source='".$source."'>\n".$term."\n</geogname></xmp></td></tr>";

echo "</table>";
echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogedit&amp;id=".$results['id']."'>Edit</a>";

$sql_str1="SELECT id FROM cms_auth_geog WHERE id < $id AND suppress IS NULL ORDER BY ID DESC LIMIT 1";
$navsearch1 = mysqli_query($id_link, $sql_str1) or die("Search Failed!");
$results1 = mysqli_fetch_array($navsearch1);
$prev = $results1['id'];

$sql_str2="SELECT id FROM cms_auth_geog WHERE id > $id AND suppress IS NULL ORDER BY ID ASC LIMIT 1";
$navsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($navsearch2);
$next = $results2['id'];

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogview&amp;id=".$prev."'>&lt;&lt;&lt;&lt;&lt;</a> | <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogview&amp;id=".$next."'>&gt;&gt;&gt;&gt;&gt;</a></p>";

}

######################################################################################
## display edit screen for places
elseif ($view == "geogedit") {

	 $sql_str="SELECT * FROM cms_auth_geog WHERE id=$id AND suppress IS NULL";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($subjsearch);
	 
if ($results['source'] == "lcsh") { $source_title = "Library of Congress Subject Headings"; } 
if ($results['source'] == "sss") { $source_title = "School of Scottish Studies Thesaurus"; } 
if ($results['source'] == "ukat") { $source_title = "United Kingdom Archival Thesaurus"; } 
if ($results['source'] == "other") { $source_title = "other"; } 

 ?>
<h3>Edit term: Place name</h3>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="geogupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" value="<?php echo $results['term'] ?>" /></td></tr>
<tr><td class="label">Alt. form</td><td><input name="alt_form" size="75" type="text" value="<?php echo $results['alt_form'] ?>" /></td></tr>
<tr><td class="label">Alt. form language code</td><td><input name="alt_form_lang" size="75" type="text" value="<?php echo $results['alt_form_lang'] ?>" /></td></tr>
<tr><td class="label">Use for</td><td><input name="use_for" size="75" type="text" value="<?php echo $results['use_for'] ?>" />
<tr><td class="label">Locator</td><td><input name="ext_id" size="75" type="text" value="<?php echo $results['locator'] ?>" /></td></tr></td></tr>
<tr><td class="label">Source</td><td>
<select name="source">
<option value="<?php echo $results['source'] ?>"><?php echo $source_title ?> (current value)</option>
<option value="lcsh">Library of Congress Subject Headings</option>
<option value="sss">School of Scottish Studies Thesaurus</option>
<option value="ukat">United Kingdom Archival Thesaurus</option>
<option value="other">other</option>
</select>
</td></tr>
<tr><td class="label">Other Source *</td><td><input name="other" size="75" type="text" value="<?php echo $results['other'] ?>" /></td></tr>
<tr><td class="label">External identifier</td><td><input name="ext_id" size="75" type="text" value="<?php echo $results['ext_id'] ?>" /></td></tr>
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
# Update place from Edit
elseif ($view == "geogupdate") {

$term = $_GET['term'];
$alt_form = $_GET['alt_form'];
$alt_form_lang = $_GET['alt_form_lang'];
$use_for = $_GET['use_for'];
$locator = $_GET['locator'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_geog SET id='$id', term='$term', alt_form='$alt_form', alt_form_lang='$alt_form_lang',  use_for='$use_for', locator='$locator', source='$source', other='$other', ext_id='$ext_id', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update place failed!");


$sql_str="SELECT * FROM cms_auth_geog WHERE id=$id AND suppress IS NULL";
$geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($geogsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogview&amp;id=".$results['id']."'>".$results['term']."</a> has been updated</p>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><geogname authfilenumber='".$id."' normal='".$term."' source='".$source."'>\n".$term."\n</geogname></xmp></td></tr></table>";

}

######################################################################################
elseif ($view == "geogadd") {

	 $sql_str="SELECT * FROM cms_auth_geog WHERE suppress IS NULL ORDER BY term ASC";

	 $geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
echo "<table align='right' width='200'>";
echo "<tr><td><strong>Places already in database</strong><textarea cols='40' rows='20' style='font-size:small; color:#000000; background-color:#ffffff' disabled='disabled'>";
while ($results = mysqli_fetch_array($geogsearch)):
echo $results['term'] ."\n";
endwhile;
echo "</textarea></td></tr></table>"; ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">

<h3>Add term: Place</h3>

<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" /></td></tr>
<tr><td class="label">Alt. form</td><td><input name="alt_form" size="75" type="text" /></td></tr>
<tr><td class="label">Alt. form language code</td><td><input name="alt_form_lang" size="75" type="text" /></td></tr>
<tr><td class="label">Use for</td><td><input name="use_for" size="75" type="text" /></td></tr>
<tr><td class="label">Locator</td><td><input name="locator" size="75" type="text" /></td></tr>
<tr><td class="label">Source</td><td>
<select name="source">
<option value="lcsh">Library of Congress Subject Headings</option>
<option value="sss">School of Scottish Studies Thesaurus</option>
<option value="ukat">United Kingdom Archival Thesaurus</option>
<option value="other">other</option>
</select>
</td></tr>
<tr><td class="label">Other Source *</td><td><input name="other" size="75" type="text" /></td></tr>
<tr><td class="label">External identifier</td><td><input name="ext_id" size="75" type="text" /></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value="CW">CW</option>
<option value="EUA">EUA</option>
<option value="AMS">AMS</option>
</select>
</td></tr>
</table>

<input type="hidden" name="func" value ="authorities"/>
<input type="hidden" name="view" value ="geogenter"/>
<input type="submit" value="Add term" />
</form>
<?php }

#########################################################
# Enter new place 
elseif ($view == "geogenter") {
$term = $_GET['term'];
$alt_form = $_GET['alt_form'];
$alt_form_lang = $_GET['alt_form_lang'];
$use_for = $_GET['use_for'];
$locator = $_GET['locator'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_geog (id, term, alt_form, alt_form_lang use_for, locator, source, other, ext_id, created_for, created_by, created_on) VALUES  (NULL, '$term', '$alt_form', '$alt_form_lang', '$use_for', '$locator', '$source', '$other', '$ext_id', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("Enter place failed!");


$sql_str="SELECT * FROM cms_auth_geog WHERE term LIKE '$term' AND suppress IS NULL";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogview&amp;id=".$results['id']."'>".$results['term']."</a> has been added</p>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><geogname authfilenumber='".$results['id']."' normal='".$term."' source='".$source."'>\n".$term."\n</geogname></xmp></td></tr></table>";

}

######################################################################################
########### END OF PLACES ############################################################
######################################################################################

######################################################################################
##### GENRES #########################################################################
######################################################################################
## display genre list
elseif ($view == "genrlist") {

	 $sql_str="SELECT * FROM cms_auth_genr WHERE suppress IS NULL ORDER BY term ASC";

	 $genrsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Genre</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($genrsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrview&amp;id=".$results['id']."'>".$results['term']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genredit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";

}
## display view screen for genr
elseif ($view == "genrview") {

	 $sql_str="SELECT * FROM cms_auth_genr WHERE id=$id AND suppress IS NULL";

	 $genrsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Genre</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
$results = mysqli_fetch_array($genrsearch);
echo "<tr><td class='label'>Term</td><td>".$results['term']."</td></tr>";
echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Other source</td><td>".$results['other']."</td></tr>";
echo "<tr><td class='label'>Created for (project/activity)</td><td>".$results['created_for']."</td></tr>";
echo "<tr><td class='label'>Created by</td><td>".$results['created_by']."</td></tr>";
echo "<tr><td class='label'>Created on</td><td>";
if ($results['created_on'] <> '0000-00-00 00:00:00') {
echo $results['created_on'];
}
else {
echo "before 17 August 2009";
}
echo "</td></tr>";

$datefromdb = $results['last_edited'];
include "sqldate.php";
echo "<tr><td class='label'>Last edited</td><td>".$displaydate."</td></tr>";
echo "<tr><td class='label'>Last edited by</td><td>".$results['last_edited_by']."</td></tr>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<tr><td class='label'>xml string</td><td><xmp><genreform authfilenumber='".$id."' normal='".$term."' source='".$source."'>\n".$term."\n</genreform></xmp></td></tr>";

echo "</table>";
echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genredit&amp;id=".$results['id']."'>Edit</a>";

$sql_str1="SELECT id FROM cms_auth_genr WHERE id < $id AND suppress IS NULL ORDER BY ID DESC LIMIT 1";
$navsearch1 = mysqli_query($id_link, $sql_str1) or die("Search Failed!");
$results1 = mysqli_fetch_array($navsearch1);
$prev = $results1['id'];

$sql_str2="SELECT id FROM cms_auth_genr WHERE id > $id AND suppress IS NULL ORDER BY ID ASC LIMIT 1";
$navsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($navsearch2);
$next = $results2['id'];

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrview&amp;id=".$prev."'>&lt;&lt;&lt;&lt;&lt;</a> | <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrview&amp;id=".$next."'>&gt;&gt;&gt;&gt;&gt;</a></p>";

}

## display edit screen for genre
elseif ($view == "genredit") {

	 $sql_str="SELECT * FROM cms_auth_genr WHERE id=$id AND suppress IS NULL";

	 $genrsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($genrsearch);
	 
if ($results['source'] == "lcsh") { $source_title = "Library of Congress Subject Headings"; } 
if ($results['source'] == "sss") { $source_title = "School of Scottish Studies Thesaurus"; } 
if ($results['source'] == "ukat") { $source_title = "United Kingdom Archival Thesaurus"; } 
if ($results['source'] == "other") { $source_title = "other"; } 

 ?>
<h3>Edit term: Genre</h3>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="genrupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" value="<?php echo $results['term'] ?>" /></td></tr>
<tr><td class="label">Use for</td><td><input name="use_for" size="75" type="text" value="<?php echo $results['use_for'] ?>" />
<tr><td class="label">Source</td><td>
<select name="source">
<option value="<?php echo $results['source'] ?>"><?php echo $source_title ?> (current value)</option>
<option value="lcsh">Library of Congress Subject Headings</option>
<option value="sss">School of Scottish Studies Thesaurus</option>
<option value="ukat">United Kingdom Archival Thesaurus</option>
<option value="other">other</option>
</select>
</td></tr>
<tr><td class="label">Other Source *</td><td><input name="other" size="75" type="text" value="<?php echo $results['other'] ?>" /></td></tr>
<tr><td class="label">External identifier</td><td><input name="ext_id" size="75" type="text" value="<?php echo $results['ext_id'] ?>" /></td></tr>
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
# Update genre from Edit
elseif ($view == "genrupdate") {

$term = $_GET['term'];
$use_for = $_GET['use_for'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_genr SET id='$id', term='$term', use_for='$use_for', source='$source', other='$other', ext_id='$ext_id', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update subject failed!");


$sql_str="SELECT * FROM cms_auth_genr WHERE id=$id AND suppress IS NULL";
$geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($geogsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrview&amp;id=".$results['id']."'>".$results['term']."</a> has been updated</p>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><genreform authfilenumber='".$id."' normal='".$term."' source='".$source."'>\n".$term."\n</genreform></xmp></td></tr></table>";

}

######################################################################################
elseif ($view == "genradd") {

	 $sql_str="SELECT * FROM cms_auth_genr WHERE suppress IS NULL ORDER BY term ASC";

	 $genrsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
echo "<table align='right' width='200'>";
echo "<tr><td><strong>Genres already in database</strong><textarea cols='40' rows='20' style='font-size:small; color:#000000; background-color:#ffffff' disabled='disabled'>";
while ($results = mysqli_fetch_array($genrsearch)):
echo $results['term'] ."\n";
endwhile;
echo "</textarea></td></tr></table>"; ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">

<h3>Add term: Genre</h3>

<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" /></td></tr>
<tr><td class="label">Use for</td><td><input name="use_for" size="75" type="text" /></td></tr>
<tr><td class="label">Source</td><td>
<select name="source">
<option value="lcsh">Library of Congress Subject Headings</option>
<option value="sss">School of Scottish Studies Thesaurus</option>
<option value="ukat">United Kingdom Archival Thesaurus</option>
<option value="other">other</option>
</select>
</td></tr>
<tr><td class="label">Other Source *</td><td><input name="other" size="75" type="text" /></td></tr>
<tr><td class="label">External identifier</td><td><input name="ext_id" size="75" type="text" /></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value="CW">CW</option>
<option value="EUA">EUA</option>
<option value="AMS">AMS</option>
</select>
</td></tr>
</table>

<input type="hidden" name="func" value ="authorities"/>
<input type="hidden" name="view" value ="genrenter"/>
<input type="submit" value="Add term" />
</form>
<?php }
#########################################################
# Enter new genre 
elseif ($view == "genrenter") {
$term = $_GET['term'];
$use_for = $_GET['use_for'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_genr (id, term, use_for, source, other, ext_id, created_for, created_by, created_on) VALUES  (NULL, '$term', '$use_for', '$source', '$other', '$ext_id', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("Enter genre failed!");


$sql_str="SELECT * FROM cms_auth_genr WHERE term LIKE '$term' AND suppress IS NULL";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrview&amp;id=".$results['id']."'>".$results['term']."</a> has been added</p>";

$term = htmlentities(($results['term']), ENT_QUOTES);
$source = htmlentities(($results['source']), ENT_QUOTES);

echo "<table><tr><td class='label'>xml string</td><td><xmp><genreform authfilenumber='".$results['id']."' normal='".$term."' source='".$source."'>\n".$term."\n</genreform></xmp></td></tr></table>";

}
elseif ($view == "persfix") {

	 $sql_str="SELECT * FROM cms_auth_pers WHERE suppress IS NULL ORDER BY id ASC";

	 $perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>People</h3>";
while ($results = mysqli_fetch_array($perssearch)):
$pieces = explode(" | ", $results['term']);
$family_name = $pieces[0];
$id= $results['id']; 
$sql_str="UPDATE cms_auth_pers SET family_name='$family_name' WHERE id='$id' LIMIT 1";
if ($id <> '2024') {
mysqli_query($id_link, $sql_str) or die ("Update failed!");
echo "<p>Term ".$id." updated, surname ".$pieces[0]."</p>";
}
endwhile;


}

######################################################################################
########### END OF GENRES ############################################################
######################################################################################

######################################################################################
######################################################################################





####################################################################################################
## display error message when illegal view is called for
else {
echo "<p>Error</p>";
} 

?> 