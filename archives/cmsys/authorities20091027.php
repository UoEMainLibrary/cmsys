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
echo "<tr><td class='label'>Families</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=famlist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=famlist&amp;created_for=CW'>List, A-Z (CW only)</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=famadd'>Add new term</a></td></tr>";
echo "<tr><td class='label'>Corporate Bodies</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corplist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corplist&amp;created_for=CW'>List, A-Z (CW only)</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpadd'>Add new term</a></td></tr>";
echo "<tr><td class='label'>Subjects</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjlist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjlist&amp;created_for=CW'>List, A-Z (CW only)</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjadd'>Add new term</a></td></tr>";
echo "<tr><td class='label'>Places</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geoglist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geoglist&amp;created_for=CW'>List, A-Z (CW only)</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogadd'>Add new term</a></td></tr>";
echo "<tr><td class='label'>Genre</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrlist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrlist&amp;created_for=CW'>List, A-Z (CW only)</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genradd'>Add new term</a></td></tr>";
echo "</table>"; ?>


<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="search" />
<input type="text" name="searchterm" size="55" /><br />
<select name="type">
<option value="pers">Personal Names</option>
<option value="fam">Familiy Names</option>
<option value="corp">Corporate Names</option>
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
if ($_GET['type'] == "pers") { $table = "cms_auth_pers"; $nca_file = "nca_name_form_p.php"; }
if ($_GET['type'] == "fam") { $table = "cms_auth_fam"; $nca_file = "nca_name_form_f.php"; }
if ($_GET['type'] == "corp") { $table = "cms_auth_corp"; $nca_file = "nca_name_form_c.php"; }
if ($_GET['type'] == "subj") { $table = "cms_auth_subj"; }
if ($_GET['type'] == "geog") { $table = "cms_auth_geog"; }
if ($_GET['type'] == "genr") { $table = "cms_auth_genr"; }

if ($_GET['type'] == "pers") { $sql_str="SELECT * FROM $table WHERE persterm LIKE '%$searchterm%' AND suppress IS NULL ORDER BY persterm ASC"; }
elseif ($_GET['type'] == "fam") { $sql_str="SELECT * FROM $table WHERE famterm LIKE '%$searchterm%' AND suppress IS NULL ORDER BY famterm ASC"; }
elseif ($_GET['type'] == "corp") { $sql_str="SELECT * FROM $table WHERE corpterm LIKE '%$searchterm%' AND suppress IS NULL ORDER BY corpterm ASC"; }
elseif ($_GET['type'] == "geog") { $sql_str="SELECT * FROM $table WHERE term LIKE '%$searchterm%' OR island LIKE '%$searchterm%' OR city LIKE '%$searchterm%' OR county LIKE '%$searchterm%' OR country LIKE '%$searchterm%' AND suppress IS NULL ORDER BY term ASC, island ASC, city ASC, county ASC, country ASC"; }
else { $sql_str="SELECT * FROM $table WHERE term LIKE '%$searchterm%' AND suppress IS NULL ORDER BY term ASC"; }

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Results</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($subjsearch)):
include $nca_file;
echo "<tr><td>";
if ($_GET['type'] == "subj" or $_GET['type'] == "genr") {
echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=".$_GET['type']."view&amp;id=".$results['id']."'>".$results['term']."</a>";
}
elseif ($_GET['type'] == "geog") {
echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=".$_GET['type']."view&amp;id=".$results['id']."'>".$results['term']." ".$results['island']." ".$results['city']." ".$results['county']." ".$results['country']."</a>";
}
else {
echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=".$_GET['type']."view&amp;id=".$results['id']."'>".$nca_str."</a>";
}
echo "</td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=".$_GET['type']."edit&amp;id=".$results['id']."'>Edit</a></td></tr>";
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

	 $sql_str="SELECT * FROM cms_auth_pers WHERE created_for LIKE'$created_for%' AND suppress IS NULL ORDER BY family_name ASC, given_name ASC";

	 $perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>People</h3>";
	 
	 if (isset ($created_for)) {
	 echo "<div>Filtered:".$created_for."</div>";
	 }
	 
	 echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persadd'>Add new term</a></p>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($perssearch)):
include "nca_name_form_p.php";
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results['id']."'>".$nca_str."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
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
include "nca_name_form_p.php";

echo "<tr><td class='label'>NCA Term</td><td>".$nca_str."</td></tr>";
echo "<tr><td class='label'>ID</td><td>".$results['id']."</td></tr>";
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

include "nca_name_form_p.php";

echo "<div><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results2['id']."'>".$nca_str2."</a></div>";

endwhile;

}
else {

$variant_of = $results['variant_of'];

$sql_str2="SELECT * FROM cms_auth_pers WHERE id=$variant_of and suppress IS NULL";
$prefsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($prefsearch);

include "nca_name_form_p.php";

echo "<div>Non-preferred term for: <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results2['id']."'>".$nca_str2."</a></div>";

}

echo "</td></tr>";

echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Language code</td><td>".$results['lang_code']."</td></tr>";
echo "<tr><td class='label'>Notes</td><td>".$results['notes']."</td></tr>";
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
	 include "nca_name_form_p.php";
 ?>
<h3>Edit term: Person</h3>
<div style="margin-left:550px;"><a href="<?php echo $_SERVER['PHP_SELF'] ?>?func=authorities&amp;view=persdelete&id=<?php echo $results['id'] ?>">Delete term</a></div>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="persupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Old NCA Term</td><td><?php echo $results['persterm'] ?></td></tr>
<tr><td class="label">Current NCA Term</td><td><?php echo $nca_str ?></td></tr>
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
include "nca_name_form_p.php";
echo "<div>Currently set as:  ".$nca_str2."</div>";
}
echo "Change to: <select style='width:409px;' name='variant_of'>";
echo "<option value='0'>this is the authority version of the name</option>";
	$sql_str3="SELECT * FROM cms_auth_pers ORDER BY family_name ASC, given_name ASC";
	 $authsearch3 = mysqli_query($id_link, $sql_str3) or die("Search Failed!");
while ($results3 = mysqli_fetch_array($authsearch3)):
include "nca_name_form_p.php";
echo "<option style='width:400px;' value='".$results3['id']."'>".$nca_str3."</option>";
endwhile;

 ?>
 </select>
</td></tr>
<tr><td class="label">Use for</td><td><textarea cols="61" rows="2" name="use_for"><?php echo $results['use_for'] ?></textarea></td></tr>
<tr><td class="label">Source(s)</td><td><textarea cols="61" rows="2" name="source"><?php echo $results['source'] ?></textarea></td></tr>
<tr><td class="label">Language code</td><td><input name="lang_code" size="75" type="text" value="eng" />
<tr><td class="label">Notes</td><td><textarea cols="61" rows="2" name="notes"><?php echo $results['notes'] ?></textarea></td></tr></td></tr>
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

$family_name = mysqli_real_escape_string($id_link, $_GET['family_name']);
$given_name = mysqli_real_escape_string($id_link, $_GET['given_name']);
$date = $_GET['date'];
$terms_of_address = mysqli_real_escape_string($id_link, $_GET['terms_of_address']);
$description = mysqli_real_escape_string($id_link, $_GET['description']);
$variant_of = mysqli_real_escape_string($id_link, $_GET['variant_of']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = mysqli_real_escape_string($id_link, $_GET['source']);
$lang_code = $_GET['lang_code'];
$notes = mysqli_real_escape_string($id_link, $_GET['notes']);
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_pers SET id='$id', family_name='$family_name', given_name='$given_name', date='$date', terms_of_address='$terms_of_address', description='$description', variant_of='$variant_of', use_for='$use_for', source='$source', lang_code='$lang_code', notes='$notes', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update person failed!");


$sql_str="SELECT * FROM cms_auth_pers WHERE id=$id AND suppress IS NULL";
$perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($perssearch);
include "nca_name_form_p.php";
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results['id']."'>".$nca_str."</a> has been updated</p>";

}

######################################################################################
elseif ($view == "persadd") {

	 $sql_str="SELECT * FROM cms_auth_pers WHERE suppress IS NULL ORDER BY family_name ASC, given_name ASC";

	 $perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
echo "<table align='right' width='300'>";
echo "<tr><td><strong>People already in database</strong><textarea cols='40' rows='30' style='font-size:small; color:#000000; background-color:#ffffff' disabled='disabled' wrap='off'>";
while ($results = mysqli_fetch_array($perssearch)):
include "nca_name_form_p.php";
echo $nca_str ."\n";
endwhile;
echo "</textarea></td></tr></table>"; ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">

<h3>Add term: Person</h3>

<table summary="">
<tr><td class="label">Family name</td><td><input name="family_name" size="75" type="text" /></td></tr>
<tr><td class="label">Given name(s)</td><td><input name="given_name" size="75" type="text" /></td></tr>
<tr><td class="label">Date(s)</td><td><input name="date" size="75" type="text" /></td></tr>
<tr><td class="label">Terms of address</td><td><input name="terms_of_address" size="75" type="text" /></td></tr>
<tr><td class="label">Description</td><td><textarea cols="61" rows="2" name="description"></textarea></td></tr>
<tr><td class="label">Variant of</td><td>
<select style="width:409px" name="variant_of">
<option value="0"></option>
<?php $sql_str2="SELECT * FROM cms_auth_pers WHERE suppress IS NULL ORDER BY family_name ASC, given_name ASC";

	 $authsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
while ($results2 = mysqli_fetch_array($authsearch)):
include "nca_name_form_p.php";
echo "<option style='width:400px;' value='".$results2['id']."'>".$nca_str2."</option>";
endwhile;
 ?>
 </select>
</td></tr>
<tr><td class="label">Use for</td><td><textarea cols="61" rows="2" name="use_for"></textarea></td></tr>
<tr><td class="label">Source(s)</td><td><textarea cols="61" rows="2" name="source"></textarea></td></tr>
<tr><td class="label">Language code</td><td><input name="lang_code" size="75" type="text" value="eng" /></td></tr>
<tr><td class="label">Notes</td><td><textarea cols="61" rows="2" name="notes"></textarea></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value=""></option>
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

$family_name = mysqli_real_escape_string($id_link, $_GET['family_name']);
$given_name = mysqli_real_escape_string($id_link, $_GET['given_name']);
$date = $_GET['date'];
$terms_of_address = mysqli_real_escape_string($id_link, $_GET['terms_of_address']);
$description = mysqli_real_escape_string($id_link, $_GET['description']);
$variant_of = mysqli_real_escape_string($id_link, $_GET['variant_of']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = mysqli_real_escape_string($id_link, $_GET['source']);
$lang_code = $_GET['lang_code'];
$notes = mysqli_real_escape_string($id_link, $_GET['notes']);
$last_edited = $date_time;
$last_edited_by = $display_user;
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_pers (id, family_name, given_name, date, terms_of_address, description, variant_of, use_for, source, lang_code, notes, last_edited, last_edited_by, created_for, created_by, created_on) VALUES  (NULL, '$family_name', '$given_name', '$date', '$terms_of_address', '$description', '$variant_of', '$use_for', '$source', '$lang_code', '$notes', '$last_edited', '$last_edited_by', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("<p>Enter person failed!</p>");


$sql_str="SELECT * FROM cms_auth_pers WHERE family_name LIKE '$family_name' AND given_name LIKE '$given_name' AND suppress IS NULL";
$perssearch = mysqli_query($id_link, $sql_str) or die("<p>Search Failed!</p>");
$results = mysqli_fetch_array($perssearch);
include "nca_name_form_p.php";
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=persview&amp;id=".$results['id']."'>".$nca_str."</a> has been added</p>";


}

#########################################################
# Delete a person 
elseif ($view == "persdelete") {

$sql_str="SELECT * FROM cms_auth_pers WHERE id=$id";
$perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($perssearch);

include "nca_name_form_p.php";

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

include "nca_name_form_p.php";

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
##### FAMILY NAMES ###################################################################
######################################################################################

## display family name list
elseif ($view == "famlist") {

	 $sql_str="SELECT * FROM cms_auth_fam WHERE created_for LIKE'$created_for%' AND suppress IS NULL ORDER BY family_name ASC";

	 $famsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Family names</h3>";
	 
	 if (isset ($created_for)) {
	 echo "<div>Filtered:".$created_for."</div>";
	 }
	 
	 echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=famadd'>Add new term</a></p>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($famsearch)):
include "nca_name_form_f.php";
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=famview&amp;id=".$results['id']."'>".$nca_str."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=famedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";

}

######################################################################################
## display view screen for family name
elseif ($view == "famview") {

$sql_str="SELECT * FROM cms_auth_fam WHERE id=$id AND suppress IS NULL";

	 $famsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Family</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
$results = mysqli_fetch_array($famsearch);
echo "<tr><td class='label'>ID</td><td>".$results['id']."</td></tr>";
echo "<tr><td class='label'>Family name</td><td>".$results['family_name']."</td></tr>";
echo "<tr><td class='label'>Title</td><td>".$results['title']."</td></tr>";
echo "<tr><td class='label'>Territorial distinction</td><td>".$results['territorial_distinction']."</td></tr>";
echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Language code</td><td>".$results['lang_code']."</td></tr>";
echo "<tr><td class='label'>Notes</td><td>".$results['notes']."</td></tr>";
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

$famterm = htmlentities(($results['famterm']), ENT_QUOTES);
$normal = htmlentities(($results['normal']), ENT_QUOTES);

echo "<tr><td class='label'>Last edited</td><td>".$displaydate."</td></tr>";
echo "<tr><td class='label'>Last edited by</td><td>".$results['last_edited_by']."</td></tr>";

echo "</table>";
echo "<a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=famedit&amp;id=".$results['id']."'>Edit</a>";



$sql_str1="SELECT id FROM cms_auth_fam WHERE id < $id AND suppress IS NULL ORDER BY ID DESC LIMIT 1";
$navsearch1 = mysqli_query($id_link, $sql_str1) or die("Search Failed!");
$results1 = mysqli_fetch_array($navsearch1);
$prev = $results1['id'];

$sql_str2="SELECT id FROM cms_auth_fam WHERE id > $id AND suppress IS NULL ORDER BY ID ASC LIMIT 1";
$navsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($navsearch2);
$next = $results2['id'];

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=famview&amp;id=".$prev."'>&lt;&lt;&lt;&lt;&lt;</a> | <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=famview&amp;id=".$next."'>&gt;&gt;&gt;&gt;&gt;</a></p>";

}

######################################################################################

## display edit screen for family name
elseif ($view == "famedit") {

$sql_str="SELECT * FROM cms_auth_fam WHERE id=$id AND suppress IS NULL";

	 $perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($perssearch);
	 
 ?>
<h3>Edit term: Person</h3>
<div style="margin-left:550px;"><a href="<?php echo $_SERVER['PHP_SELF'] ?>?func=authorities&amp;view=famdelete&id=<?php echo $results['id'] ?>">Delete term</a></div>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="famupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Family name</td><td><input name="family_name" size="75" type="text" value="<?php echo $results['family_name'] ?>" /></td></tr>
<tr><td class="label">Title</td><td><input name="title" size="75" type="text" value="<?php echo $results['title'] ?>" /></td></tr>
<tr><td class="label">Territorial distinction</td><td><input name="territorial_distinction" size="75" type="text" value="<?php echo $results['territorial_distinction'] ?>" /></td></tr>
<tr><td class="label">Use for</td><td><textarea cols="61" rows="2" name="use_for"><?php echo $results['use_for'] ?></textarea></td></tr>
<tr><td class="label">Source(s)</td><td><textarea cols="61" rows="2" name="term"><?php echo $results['source'] ?></textarea></td></tr>
<tr><td class="label">Language code</td><td><input name="lang_code" size="75" type="text" value="<?php echo $results['lang_code'] ?>" /></td></tr>
<tr><td class="label">Notes</td><td><textarea cols="61" rows="2" name="use_for"><?php echo $results['notes'] ?></textarea></td></tr>
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
## Update family name from Edit
elseif ($view == "famupdate") {

$family_name = mysqli_real_escape_string($id_link, $_GET['family_name']);
$title = mysqli_real_escape_string($id_link, $_GET['title']);
$territorial_distinction = mysqli_real_escape_string($id_link, $_GET['territorial_distinction']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = mysqli_real_escape_string($id_link, $_GET['source']);
$lang_code = $_GET['lang_code'];
$notes = mysqli_real_escape_string($id_link, $_GET['notes']);
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_fam SET id='$id', family_name='$family_name', title='$title', territorial_distinction='$territorial_distinction', use_for='$use_for', source='$source', lang_code='$lang_code', notes='$notes', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update family failed!");


$sql_str="SELECT * FROM cms_auth_fam WHERE id=$id AND suppress IS NULL";
$famsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($famsearch);
include "nca_name_form_f.php";
echo $term;
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=famview&amp;id=".$results['id']."'>".$nca_str."</a> has been updated</p>";

}

######################################################################################
elseif ($view == "famadd") {

	 $sql_str="SELECT * FROM cms_auth_fam WHERE suppress IS NULL ORDER BY family_name ASC";

	 $famsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
echo "<table align='right' width='300'>";
echo "<tr><td><strong>Family names already in database</strong><textarea cols='40' rows='30' style='font-size:small; color:#000000; background-color:#ffffff' disabled='disabled' wrap='off'>";
while ($results = mysqli_fetch_array($famsearch)):
include "nca_name_form_f.php";
echo $nca_str ."\n";
endwhile;
echo "</textarea></td></tr></table>"; ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">

<h3>Add term: Family name</h3>

<table summary="">
<tr><td class="label">Family name</td><td><input name="family_name" size="75" type="text" /></td></tr>
<tr><td class="label">Title</td><td><input name="title" size="75" type="text" /></td></tr>
<tr><td class="label">Territorial distinction</td><td><textarea cols="61" rows="2" name="territorial_distinction"></textarea></td></tr>
<tr><td class="label">Use for</td><td><textarea cols="61" rows="2" name="use_for"></textarea></td></tr>
<tr><td class="label">Source(s)</td><td><textarea cols="61" rows="2" name="term"></textarea></td></tr>
<tr><td class="label">Language code</td><td><input name="lang_code" size="75" type="text" /></td></tr>
<tr><td class="label">Notes</td><td><textarea cols="61" rows="2" name="notes"></textarea></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value=""></option>
<option value="CW">CW</option>
<option value="EUA">EUA</option>
<option value="AMS">AMS</option>
</select>
</td></tr>
</table> 

<input type="hidden" name="func" value ="authorities"/>
<input type="hidden" name="view" value ="famenter"/>
<input type="submit" value="Add term" />
</form>
<?php }

#########################################################
# Enter new family name 

elseif ($view == "famenter") {

$family_name = mysqli_real_escape_string($id_link, $_GET['family_name']);
$title = mysqli_real_escape_string($id_link, $_GET['title']);
$territorial_distinction = mysqli_real_escape_string($id_link, $_GET['territorial_distinction']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = mysqli_real_escape_string($id_link, $_GET['source']);
$lang_code = $_GET['lang_code'];
$notes = mysqli_real_escape_string($id_link, $_GET['notes']);
$last_edited = $date_time;
$last_edited_by = $display_user;
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_fam (id, family_name, title, territorial_distinction, use_for, source, lang_code, notes, last_edited, last_edited_by, created_for, created_by, created_on) VALUES  (NULL, '$family_name', '$title', '$territorial_distinction', '$use_for', '$source', '$lang_code', '$notes', '$last_edited', '$last_edited_by', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("<p>Enter family name failed!</p>");


$sql_str="SELECT * FROM cms_auth_fam WHERE family_name LIKE '$family_name' AND territorial_distinction LIKE '$territorial_distinction' AND suppress IS NULL";
$famsearch = mysqli_query($id_link, $sql_str) or die("<p>Search Failed!</p>");
$results = mysqli_fetch_array($famsearch);
include "nca_name_form_f.php";
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=famview&amp;id=".$results['id']."'>".$nca_str."</a> has been added</p>";

	 echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=famadd'>Add new term</a></p>";

}

#########################################################
# Delete a family name 
elseif ($view == "famdelete") {

$sql_str="SELECT * FROM cms_auth_fam WHERE id=$id";
$perssearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($perssearch);

include "nca_name_form_f.php";



echo "<p>".$nca_str."</p>";


$sql_str="UPDATE cms_auth_fam SET suppress='y' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Delete family name failed!");

echo "<p>This term has been deleted</p>";
}

######################################################################################
########### END OF FAMILY NAMES ######################################################
######################################################################################


######################################################################################
##### CORPORATE NAMES #################################################################
######################################################################################

## display corporate name list
elseif ($view == "corplist") {

	 $sql_str="SELECT * FROM cms_auth_corp WHERE created_for LIKE'$created_for%' AND suppress IS NULL ORDER BY primary_name ASC";

	 $corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Corporate Bodies</h3>";
	 
	  if (isset ($created_for)) {
	 echo "<div>Filtered:".$created_for."</div>";
	 }
	 
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($corpsearch)):
include "nca_name_form_c.php";

echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$results['id']."'>".$nca_str."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
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
include "nca_name_form_c.php";

echo "<tr><td class='label'>NCA Term</td><td>".$nca_str."</td></tr>";
echo "<tr><td class='label'>ID</td><td>".$results['id']."</td></tr>";
echo "<tr><td class='label'>Primary name</td><td>".$results['primary_name']."</td></tr>";
echo "<tr><td class='label'>Secondary name</td><td>".$results['secondary_name']."</td></tr>";
echo "<tr><td class='label'>Date(s)</td><td>".$results['date']."</td></tr>";
echo "<tr><td class='label'>Description</td><td>".$results['description']."</td></tr>";
echo "<tr><td class='label'>Location</td><td>".$results['location']."</td></tr>";
echo "<tr><td class='label'>Variant of</td><td>".$results['variant_of']."</td></tr>";
echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Language code</td><td>".$results['lang_code']."</td></tr>";
echo "<tr><td class='label'>Notes</td><td>".$results['notes']."</td></tr>";
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

## echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$prev."'>&lt;&lt;&lt;&lt;&lt;</a> | <a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$next."'>&gt;&gt;&gt;&gt;&gt;</a></p>";

}

######################################################################################

## display edit screen for corporate name
elseif ($view == "corpedit") {

$sql_str="SELECT * FROM cms_auth_corp WHERE id=$id AND suppress IS NULL";

	 $corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($corpsearch);
	 
	 include "nca_name_form_c.php";
	 
 ?>
<h3>Edit term: Corporate Body</h3>
<div style="margin-left:550px;"><a href="<?php echo $_SERVER['PHP_SELF'] ?>?func=authorities&amp;view=corpdelete&id=<?php echo $results['id'] ?>">Delete term</a></div>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="corpupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Old NCA Term</td><td><?php echo $results['corpterm'] ?></td></tr>
<tr><td class="label">Current NCA Term</td><td><?php echo $nca_str ?></td></tr>
<tr><td class="label">Primary name</td><td><input name="primary_name" size="75" type="text" value="<?php echo $results['primary_name'] ?>" /></td></tr>
<tr><td class="label">Secondary name</td><td><input name="secondary_name" size="75" type="text" value="<?php echo $results['secondary_name'] ?>" /></td></tr>
<tr><td class="label">Date(s)</td><td><input name="date" size="75" type="text" value="<?php echo $results['date'] ?>" /></td></tr>
<tr><td class="label">Description</td><td><input name="description" size="75" type="text" value="<?php echo $results['description'] ?>" /></td></tr>
<tr><td class="label">Location</td><td><input name="location" size="75" type="text" value="<?php echo $results['location'] ?>" /></td></tr>
<tr><td class="label">Variant of</td><td>



<?php   $var_id = $results['variant_of'];
	if ($var_id == 0 ) {

     echo "<div>Currently set as: this is the authority version of the name</div>";
	 } else {

     $sql_str2="SELECT * FROM cms_auth_corp where id='$var_id' AND suppress IS NULL";
	 $authsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
	 $results2 = mysqli_fetch_array($authsearch2);
	 include "nca_name_form_c.php";	
echo "<div>Currently set as:  ".$nca_str2."</div>";
}
echo "Change to: <select style='width:409px;' name='variant_of'>";
echo "<option value='0'>this is the authority version of the name</option>";
	$sql_str3="SELECT * FROM cms_auth_corp ORDER BY primary_name ASC";
	 $authsearch3 = mysqli_query($id_link, $sql_str3) or die("Search Failed!");
while ($results3 = mysqli_fetch_array($authsearch3)):
	 include "nca_name_form_c.php";	
echo "<option style='width:400px;' value='".$results3['id']."'>".$nca_str3."</option>";
endwhile;

 ?>
 </select>
</td></tr>
<tr><td class="label">Use for</td><td><textarea cols="61" rows="2" name="use_for"><?php echo $results['use_for'] ?></textarea></td></tr>
<tr><td class="label">Source(s)</td><td><textarea cols="61" rows="2" name="term"><?php echo $results['source'] ?></textarea></td></tr>
<tr><td class="label">Language code</td><td><input name="lang_code" size="75" type="text" value="<?php echo $results['lang_code'] ?>" /></td></tr>
<tr><td class="label">Notes</td><td><textarea cols="61" rows="2" name="notes"><?php echo $results['notes'] ?></textarea></td></tr>
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

$primary_name = mysqli_real_escape_string($id_link, $_GET['primary_name']);
$secondary_name = mysqli_real_escape_string($id_link, $_GET['secondary_name']);
$date = $_GET['date'];
$terms_of_address = mysqli_real_escape_string($id_link, $_GET['terms_of_address']);
$description = mysqli_real_escape_string($id_link, $_GET['description']);
$location = mysqli_real_escape_string($id_link, $_GET['location']);
$variant_of = mysqli_real_escape_string($id_link, $_GET['variant_of']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = $_GET['source'];
$lang_code = $_GET['lang_code'];
$notes = mysqli_real_escape_string($id_link, $_GET['notes']);
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_corp SET id='$id', primary_name='$primary_name', secondary_name='$secondary_name', date='$date', description='$description', location='$location', variant_of='$variant_of', use_for='$use_for', source='$source', lang_code='$lang_code', notes='$notes', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update corporate name failed!");


$sql_str="SELECT * FROM cms_auth_corp WHERE id=$id AND suppress IS NULL";
$corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($corpsearch);
echo $term;
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$results['id']."'>".$results['corpterm']."</a> has been updated</p>";

}

######################################################################################
elseif ($view == "corpadd") {

	 $sql_str="SELECT * FROM cms_auth_corp WHERE suppress IS NULL ORDER BY primary_name ASC";

	 $corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
echo "<table align='right' width='300'>";
echo "<tr><td><strong>Corporate names already in database</strong><textarea cols='40' rows='30' style='font-size:small; color:#000000; background-color:#ffffff' disabled='disabled' wrap='off'>";
while ($results = mysqli_fetch_array($corpsearch)):
include "nca_name_form_c.php";	
echo $nca_str ."\n";
endwhile;
echo "</textarea></td></tr></table>"; ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">

<h3>Add term: Corporate Body</h3>

<table summary="">
<tr><td class="label">Primary name</td><td><input name="primary_name" size="75" type="text" /></td></tr>
<tr><td class="label">Secondary name</td><td><input name="secondary_name" size="75" type="text" /></td></tr>
<tr><td class="label">Date(s)</td><td><input name="date" size="75" type="text" /></td></tr>
<tr><td class="label">Description</td><td><textarea cols="61" rows="2" name="description"></textarea></td></tr>
<tr><td class="label">Location</td><td><textarea cols="61" rows="2" name="location"></textarea></td></tr>
<tr><td class="label">Variant of</td><td>
<select style="width:409px" name="variant_of">
<option value="0"></option>
<?php $sql_str2="SELECT * FROM cms_auth_corp WHERE suppress IS NULL ORDER BY primary_name ASC";

	 $authsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
while ($results2 = mysqli_fetch_array($authsearch)):
include "nca_name_form_c.php";
echo "<option style='width:400px;' value='".$results2['id']."'>".$nca_str2."</option>";
endwhile;
 ?>
 </select>
</td></tr>
<tr><td class="label">Use for</td><td><textarea cols="61" rows="2" name="use_for"></textarea></td></tr>
<tr><td class="label">Source(s)</td><td><textarea cols="61" rows="2" name="source"></textarea></td></tr>
<tr><td class="label">Language code</td><td><input name="lang_code" size="75" type="text" /></td></tr>
<tr><td class="label">Notes</td><td><textarea cols="61" rows="2" name="notes"></textarea></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value=""></option>
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

$primary_name = mysqli_real_escape_string($id_link, $_GET['primary_name']);
$secondary_name = mysqli_real_escape_string($id_link, $_GET['secondary_name']);
$date = $_GET['date'];
$description = mysqli_real_escape_string($id_link, $_GET['description']);
$location = mysqli_real_escape_string($id_link, $_GET['location']);
$variant_of = mysqli_real_escape_string($id_link, $_GET['variant_of']);
$use_for = mysqli_real_escape_string($id_link, $_GET['use_for']);
$source = mysqli_real_escape_string($id_link, $_GET['source']);
$lang_code = $_GET['lang_code'];
$notes = mysqli_real_escape_string($id_link, $_GET['notes']);
$last_edited = $date_time;
$last_edited_by = $display_user;
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_corp (id, primary_name, secondary_name, date, description, location, variant_of, use_for, source, lang_code, notes, last_edited, last_edited_by, created_for, created_by, created_on) VALUES  (NULL, '$primary_name', '$secondary_name', '$date', '$description', '$location', '$variant_of', '$use_for', '$source', '$lang_code', '$notes', '$last_edited', '$last_edited_by', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("<p>Enter corporate name failed!</p>");


$sql_str="SELECT * FROM cms_auth_corp WHERE primary_name LIKE '$primary_name' AND secondary_name LIKE '$secondary_name' AND suppress IS NULL";
$corpsearch = mysqli_query($id_link, $sql_str) or die("<p>Search Failed!</p>");
$results = mysqli_fetch_array($corpsearch);
include "nca_name_form_c.php";
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$results['id']."'>".$nca_str."</a> has been added</p>";


}

#########################################################
# Delete a corporate name 
elseif ($view == "corpdelete") {

$sql_str="SELECT * FROM cms_auth_corp WHERE id=$id";
$corpsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($corpsearch);

include "nca_name_form_c.php";

if ($results['variant_of'] == 0) {

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$results['id']."'>".$nca_str."</a></p>";

$sql_str2="SELECT * FROM cms_auth_corp WHERE variant_of=$id";
$varsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$num_rows = mysql_num_rows($varsearch);
if ($num_rows >0) {
echo "<div>Varaints exist for this term.  You may not delete it until all variants have been deleted or disassociated from it.</div>";
}
}
else {


echo "<p>".$nca_str."</p>";

$variant_of = $results['variant_of'];

$sql_str2="SELECT * FROM cms_auth_corp WHERE id=$variant_of";
$prefsearch = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($prefsearch);

include "nca_name_form_c.php";

echo "<p>Non-preferred term for:<br /><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=corpview&amp;id=".$results2['id']."'>".$nca_str2."</a></p>";

}

$sql_str="UPDATE cms_auth_corp SET suppress='y' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Delete corporate name failed!");

echo "<p>This term has been deleted</p>";
}


######################################################################################
########### END OF CORPORATE NAMES ####################################################
######################################################################################

######################################################################################
##### SUBJECTS #######################################################################
######################################################################################

## display subject list
elseif ($view == "subjlist") {

	 $sql_str="SELECT * FROM cms_auth_subj WHERE created_for LIKE'$created_for%' AND suppress IS NULL ORDER BY term ASC";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Subjects</h3>";
	 
	  if (isset ($created_for)) {
	 echo "<div>Filtered:".$created_for."</div>";
	 }
	 
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
echo "<tr><td class='label'>ID</td><td>".$results['id']."</td></tr>";
echo "<tr><td class='label'>Term</td><td>".$results['term']."</td></tr>";
echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Other source</td><td>".$results['other']."</td></tr>";
echo "<tr><td class='label'>External identifier</td><td>".$results['extid']."</td></tr>";
echo "<tr><td class='label'>Notes</td><td>".$results['notes']."</td></tr>";
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
<div style="margin-left:550px;"><a href="<?php echo $_SERVER['PHP_SELF'] ?>?func=authorities&amp;view=subjdelete&id=<?php echo $results['id'] ?>">Delete term</a></div>
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
<tr><td class="label">Notes</td><td><textarea cols="61" rows="2" name="notes"><?php echo $results['notes'] ?></textarea></td></tr>
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
$notes = $_GET['notes'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_subj SET id='$id', term='$term', use_for='$use_for', source='$source', other='$other', ext_id='$ext_id', notes='$notes', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

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
<tr><td class="label">Notes</td><td><textarea cols="61" rows="2" name="notes"></textarea></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value=""></option>
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
$notes = $_GET['notes'];
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_subj (id, term, use_for, source, other, ext_id, notes, created_for, created_by, created_on) VALUES  (NULL, '$term', '$use_for', '$source', '$other', '$ext_id', '$notes', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("Enter subject failed!");


$sql_str="SELECT * FROM cms_auth_subj WHERE term LIKE '$term' AND suppress IS NULL";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=subjview&amp;id=".$results['id']."'>".$results['term']."</a> has been added</p>";

}

#########################################################
# Delete a subject 
elseif ($view == "subjdelete") {

$sql_str="SELECT * FROM cms_auth_subj WHERE id=$id";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);

echo "<p>".$results['term']."</p>";

$sql_str="UPDATE cms_auth_subj SET suppress='y' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Delete subject failed!");

echo "<p>This term has been deleted</p>";
}

######################################################################################
########### END OF SUBJECTS ##########################################################
######################################################################################

######################################################################################
##### PLACES #########################################################################
######################################################################################
## display place list
elseif ($view == "geoglist") {

	 $sql_str="SELECT * FROM cms_auth_geog WHERE created_for LIKE'$created_for%' AND suppress IS NULL ORDER BY term ASC, island ASC, city ASC, county ASC, country ASC";

	 $geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Places</h3>";
	 
	  if (isset ($created_for)) {
	 echo "<div>Filtered:".$created_for."</div>";
	 }
	 
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($geogsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogview&amp;id=".$results['id']."'>".$results['term']." ".$results['island']." ".$results['city']." ".$results['county']." ".$results['country']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";

}
######################################################################################
## display view screen for places
elseif ($view == "geogview") {

	 $sql_str="SELECT * FROM cms_auth_geog WHERE id=$id AND suppress IS NULL";

	 $geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Place name</h3>";
$results = mysqli_fetch_array($geogsearch);

if ($results['locator'] <>'') {
	$locators = explode(";", $results['locator']);
	echo "<table align='right' style='margin-right:50px'><tr><td><iframe width='425' height='350' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='http://maps.google.com/?q=".$locators[0].",".$locators[1]."(".$results['term']." ".$results['island']." ".$results['city']." ".$results['county']." ".$results['country'].")&amp;z=12&amp;output=embed'></iframe></td></tr></table>";
	}
	
echo "<table cellpadding='5'cellspacing='5'>";
echo "<tr><td class='label'>ID</td><td>".$results['id']."</td></tr>";
echo "<tr><td class='label'>Term / Area</td><td>".$results['term']."</td></tr>";
echo "<tr><td class='label'>Island</td><td>".$results['island']."</td></tr>";
echo "<tr><td class='label'>City</td><td>".$results['city']."</td></tr>";
echo "<tr><td class='label'>County</td><td>".$results['county']."</td></tr>";
echo "<tr><td class='label'>Country</td><td>".$results['country']."</td></tr>";
echo "<tr><td class='label'>Alt. form</td><td>".$results['alt_form']."</td></tr>";
echo "<tr><td class='label'>Alt. form language code</td><td>".$results['alt_form_lang']."</td></tr>";
echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Locator</td><td>".$results['locator']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Other source</td><td>".$results['other']."</td></tr>";
echo "<tr><td class='label'>External identifier</td><td>".$results['ext_id']."</td></tr>";
echo "<tr><td class='label'>Notes</td><td>".$results['notes']."</td></tr>";
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
<div style="margin-left:550px;"><a href="<?php echo $_SERVER['PHP_SELF'] ?>?func=authorities&amp;view=geogdelete&id=<?php echo $results['id'] ?>">Delete term</a></div>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="authorities" />
<input type="hidden" name="view" value="geogupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Term / Area</td><td><input name="term" size="75" type="text" value="<?php echo $results['term'] ?>" /></td></tr>
<tr><td class="label">Island</td><td><input name="island" size="75" type="text" value="<?php echo $results['island'] ?>" /></td></tr>
<tr><td class="label">City</td><td><input name="city" size="75" type="text" value="<?php echo $results['city'] ?>" /></td></tr>
<tr><td class="label">County</td><td><input name="county" size="75" type="text" value="<?php echo $results['county'] ?>" /></td></tr>
<tr><td class="label">Country</td><td><input name="country" size="75" type="text" value="<?php echo $results['country'] ?>" /></td></tr>
<tr><td class="label">Alt. form</td><td><input name="alt_form" size="75" type="text" value="<?php echo $results['alt_form'] ?>" /></td></tr>
<tr><td class="label">Alt. form language code</td><td><input name="alt_form_lang" size="75" type="text" value="<?php echo $results['alt_form_lang'] ?>" /></td></tr>
<tr><td class="label">Use for</td><td><input name="use_for" size="75" type="text" value="<?php echo $results['use_for'] ?>" />
<tr><td class="label">Locator</td><td><input name="locator" size="75" type="text" value="<?php echo $results['locator'] ?>" /></td></tr></td></tr>
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
<tr><td class="label">Notes</td><td><textarea cols="61" rows="2" name="notes"><?php echo $results['notes'] ?></textarea></td></tr>
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
$island = $_GET['island'];
$city = $_GET['city'];
$county = $_GET['county'];
$country = $_GET['country'];
$alt_form = $_GET['alt_form'];
$alt_form_lang = $_GET['alt_form_lang'];
$use_for = $_GET['use_for'];
$locator = $_GET['locator'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$notes = $_GET['notes'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_geog SET id='$id', term='$term', island='$island', city='$city', county='$county', country='$country',  alt_form='$alt_form', alt_form_lang='$alt_form_lang',  use_for='$use_for', locator='$locator', source='$source', other='$other', ext_id='$ext_id', notes='$notes', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update place failed!");


$sql_str="SELECT * FROM cms_auth_geog WHERE id=$id AND suppress IS NULL";
$geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($geogsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogview&amp;id=".$results['id']."'>".$results['term']." ".$results['island']." ".$results['city']." ".$results['county']." ".$results['country']."</a> has been updated</p>";

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
<tr><td class="label">Term / Area</td><td><input name="term" size="75" type="text" /></td></tr>
<tr><td class="label">Island</td><td><input name="island" size="75" type="text"/></td></tr>
<tr><td class="label">City</td><td><input name="city" size="75" type="text" /></td></tr>
<tr><td class="label">County</td><td><input name="county" size="75" type="text" /></td></tr>
<tr><td class="label">Country</td><td><input name="country" size="75" type="text" /></td></tr>
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
<tr><td class="label">Notes</td><td><textarea cols="61" rows="2" name="notes"></textarea></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value=""></option>
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
$island = $_GET['island'];
$city = $_GET['city'];
$county = $_GET['county'];
$country = $_GET['country'];
$alt_form = $_GET['alt_form'];
$alt_form_lang = $_GET['alt_form_lang'];
$use_for = $_GET['use_for'];
$locator = $_GET['locator'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$notes = $_GET['notes'];
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_geog (id, term, island, city, county, country, alt_form, alt_form_lang, use_for, locator, source, other, ext_id, notes, created_for, created_by, created_on) VALUES  (NULL, '$term', '$island', '$city', '$county', '$country', '$alt_form', '$alt_form_lang', '$use_for', '$locator', '$source', '$other', '$ext_id', '$notes', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("Enter place failed!");


$sql_str="SELECT * FROM cms_auth_geog WHERE term LIKE '$term' AND suppress IS NULL";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=geogview&amp;id=".$results['id']."'>".$results['term']."</a> has been added</p>";

}

#########################################################
# Delete a place 
elseif ($view == "geogdelete") {

$sql_str="SELECT * FROM cms_auth_geog WHERE id=$id";
$geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($geogsearch);

echo "<p>".$results['term']."</p>";

$sql_str="UPDATE cms_auth_geog SET suppress='y' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Delete place failed!");

echo "<p>This term has been deleted</p>";
}

######################################################################################
########### END OF PLACES ############################################################
######################################################################################

######################################################################################
##### GENRES #########################################################################
######################################################################################
## display genre list
elseif ($view == "genrlist") {

	 $sql_str="SELECT * FROM cms_auth_genr WHERE created_for LIKE'$created_for%' AND suppress IS NULL ORDER BY term ASC";

	 $genrsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Genre</h3>";
	 
	  if (isset ($created_for)) {
	 echo "<div>Filtered:".$created_for."</div>";
	 }
	 
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($genrsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrview&amp;id=".$results['id']."'>".$results['term']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genredit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";

}
## display view screen for genre
elseif ($view == "genrview") {

	 $sql_str="SELECT * FROM cms_auth_genr WHERE id=$id AND suppress IS NULL";

	 $genrsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Genre</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
$results = mysqli_fetch_array($genrsearch);
echo "<tr><td class='label'>ID</td><td>".$results['id']."</td></tr>";
echo "<tr><td class='label'>Term</td><td>".$results['term']."</td></tr>";
echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Other source</td><td>".$results['other']."</td></tr>";
echo "<tr><td class='label'>External identifier</td><td>".$results['ext_id']."</td></tr>";
echo "<tr><td class='label'>Notes</td><td>".$results['notes']."</td></tr>";
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
<div style="margin-left:550px;"><a href="<?php echo $_SERVER['PHP_SELF'] ?>?func=authorities&amp;view=genrdelete&id=<?php echo $results['id'] ?>">Delete term</a></div>
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
<tr><td class="label">Notes</td><td><textarea cols="61" rows="2" name="notes"><?php echo $results['notes'] ?></textarea></td></tr>
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
$notes = $_GET['notes'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_auth_genr SET id='$id', term='$term', use_for='$use_for', source='$source', other='$other', ext_id='$ext_id', notes='$notes', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update subject failed!");


$sql_str="SELECT * FROM cms_auth_genr WHERE id=$id AND suppress IS NULL";
$geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($geogsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrview&amp;id=".$results['id']."'>".$results['term']."</a> has been updated</p>";

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
<tr><td class="label">Notes</td><td><textarea cols="61" rows="2" name="notes"></textarea></td></tr>
<tr><td class="label">Created for</td><td>
<select name="created_for">
<option value=""></option>
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
$notes = $_GET['notes'];
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_auth_genr (id, term, use_for, source, other, ext_id, notes, created_for, created_by, created_on) VALUES  (NULL, '$term', '$use_for', '$source', '$other', '$ext_id', '$notes', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("Enter genre failed!");


$sql_str="SELECT * FROM cms_auth_genr WHERE term LIKE '$term' AND suppress IS NULL";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=authorities&amp;view=genrview&amp;id=".$results['id']."'>".$results['term']."</a> has been added</p>";

}

#########################################################
# Delete a genre 
elseif ($view == "genrdelete") {

$sql_str="SELECT * FROM cms_auth_genr WHERE id=$id";
$genrsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($genrsearch);

echo "<p>".$results['term']."</p>";

$sql_str="UPDATE cms_auth_genr SET suppress='y' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Delete genre failed!");

echo "<p>This term has been deleted</p>";
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

?> 