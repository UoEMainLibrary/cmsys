<?php  $date_time = date("Y-m-d H:i:s"); 


echo "<h2>Indexing</h2>";


 if (isset ($view)) { echo "<a href='".$_SERVER['PHP_SELF']."?func=indexing'><img src='/graphics/up.gif' alt='Up to Indexing Menu' border='0' /></a>"; }
######################################################################################
## display menu
if (!isset ($view)) { 
echo "<h3>Menu</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
# echo "<tr><td class='label'>Personal names</td><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=perslist'>List, A-Z</a></td></tr>";
# echo "<tr><td class='label'>Corporate names</td><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=corplist'>List, A-Z</a></td></tr>";
echo "<tr><td class='label'>Subjects</td><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=subjlist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=subjadd'>Add new term</a></td></tr>";
echo "<tr><td class='label'>Places</td><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=geoglist'>List, A-Z</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=geogadd'>Add new term</a></td></tr>";
echo "</table>"; ?>


<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="indexing" />
<input type="hidden" name="view" value="search" />
<input type="text" name="searchterm" size="55" /><br />
<select name="type">
<option value="subj">Subjects</option>
<option value="geog">Places</option>
</select> &nbsp;&nbsp;
<input type="submit" value="Quick Search" />
</form>

<?php
}
######################################################################################
## display personal name list
elseif ($view == "perslist") {


}
######################################################################################
## display corporate name list
elseif ($view == "corplist") {


}
######################################################################################
## display subject list
elseif ($view == "subjlist") {

if (isset ($_GET['created_by'])) { $created_by = $_GET['created_by']; } else { $created_by = '%'; }
if (isset ($_GET['created_for'])) { $created_by = $_GET['created_for']; } else { $created_by = '%'; }

	 $sql_str="SELECT * FROM cms_indexing_subj WHERE created_by='$created_by' ORDER BY term ASC";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Subjects</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($subjsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=subjview&amp;id=".$results['id']."'>".$results['term']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=subjedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";
}

######################################################################################
## display subject list
elseif ($view == "subjlist2") {

	 $sql_str="SELECT * FROM cms_indexing_subj ORDER BY term ASC";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Subjects</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($subjsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=subjview&amp;id=".$results['id']."'>".$results['term']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=subjedit&amp;id=".$results['id']."'>Edit</a></td><td>";
$subfolder = $year = strtolower (substr(($results['term']),0,1));
$path = "/data/d4/archives/public_docs/subj/".$subfolder."/".$results['id']."/";


if (file_exists($path)) {
    echo "<a href='http://www.archives.lib.ed.ac.uk/subj/".$subfolder."/".$results['id']."/'>Catalogue use</a>";
} else {
    echo "";
}



echo "</td></tr>";
endwhile;
echo "</table>";
}

######################################################################################
## display place list
elseif ($view == "geoglist") {

	 $sql_str="SELECT * FROM cms_indexing_geog ORDER BY term ASC";

	 $geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Places</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($geogsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=geogview&amp;id=".$results['id']."'>".$results['term']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=geogedit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";

}

######################################################################################
## display place list
elseif ($view == "geoglist2") {

	 $sql_str="SELECT * FROM cms_indexing_geog ORDER BY term ASC";

	 $geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Places</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($geogsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=geogview&amp;id=".$results['id']."'>".$results['term']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=geogedit&amp;id=".$results['id']."'>Edit</a></td><td>";
$subfolder = $year = strtolower (substr(($results['term']),0,1));
$path = "/data/d4/archives/public_docs/geog/".$subfolder."/".$results['id']."/";


if (file_exists($path)) {
    echo "<a href='http://www.archives.lib.ed.ac.uk/geog/".$subfolder."/".$results['id']."/'>Catalogue use</a>";
} else {
    echo "";
}



echo "</td></tr>";
endwhile;
echo "</table>";

}

######################################################################################
## display search results
elseif ($view == "search") {
$searchterm = $_GET['searchterm'];
if ($_GET['type'] == "subj") { $table = "cms_indexing_subj"; }
if ($_GET['type'] == "geog") { $table = "cms_indexing_geog"; }

	 $sql_str="SELECT * FROM $table WHERE term LIKE '%$searchterm%' ORDER BY term ASC";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Results</h3>";
echo "<table border='1' cellpadding='5'>";
while ($results = mysqli_fetch_array($subjsearch)):
echo "<tr><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=".$_GET['type']."view&amp;id=".$results['id']."'>".$results['term']."</a></td><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=".$_GET['type']."edit&amp;id=".$results['id']."'>Edit</a></td></tr>";
endwhile;
echo "</table>";
}


######################################################################################
## display edit screen for personal name
elseif ($view == "persedit") {

echo "<p>placeholder: editing interface here: persedit</p>";
}
######################################################################################
## display edit screen for corporate name
elseif ($view == "corpedit") {

echo "<p>placeholder: editing interface here: corpedit</p>";
}
######################################################################################
## display edit screen for subject
elseif ($view == "subjedit") {

	 $sql_str="SELECT * FROM cms_indexing_subj WHERE id=$id";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($subjsearch);
	 
if ($results['source'] == "lcsh") { $source_title = "Library of Congress Subject Headings"; } 
if ($results['source'] == "sss") { $source_title = "School of Scottish Studies Thesaurus"; } 
if ($results['source'] == "ukat") { $source_title = "United Kingdom Archival Thesaurus"; } 
if ($results['source'] == "other") { $source_title = "other"; } 

 ?>
<h3>Edit term: Subject</h3>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="indexing" />
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
######################################################################################
## display edit screen for places
elseif ($view == "geogedit") {

	 $sql_str="SELECT * FROM cms_indexing_geog WHERE id=$id";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $results = mysqli_fetch_array($subjsearch);
	 
if ($results['source'] == "lcsh") { $source_title = "Library of Congress Subject Headings"; } 
if ($results['source'] == "sss") { $source_title = "School of Scottish Studies Thesaurus"; } 
if ($results['source'] == "ukat") { $source_title = "United Kingdom Archival Thesaurus"; } 
if ($results['source'] == "other") { $source_title = "other"; } 

 ?>
<h3>Edit term: Subject</h3>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="indexing" />
<input type="hidden" name="view" value="geogupdate" />
<input type="hidden" name="id" value="<?php echo $results['id'] ?>" />
<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" value="<?php echo $results['term'] ?>" /></td></tr>
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

######################################################################################
## display edit screen for personal name
elseif ($view == "persview") {

echo "<p>placeholder: editing interface here: persview</p>";
}
######################################################################################
## display edit screen for corporate name
elseif ($view == "corpview") {

echo "<p>placeholder: editing interface here: corpview</p>";
}
######################################################################################
## display view screen for subject
elseif ($view == "subjview") {

	 $sql_str="SELECT * FROM cms_indexing_subj WHERE id=$id";

	 $subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Subject term</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
$results = mysqli_fetch_array($subjsearch);
echo "<tr><td class='label'>Term</td><td>".$results['term']."</td></tr>";
echo "<tr><td class='label'>Use for</td><td>".$results['use_for']."</td></tr>";
echo "<tr><td class='label'>Source</td><td>".$results['source']."</td></tr>";
echo "<tr><td class='label'>Other source</td><td>".$results['other']."</td></tr>";
echo "<tr><td class='label'>Created for (project/activity)</td><td>".$results['created_for']."</td></tr>";
echo "<tr><td class='label'>Created by</td><td><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=subjlist&amp;created_by=".$results['created_by']."'>".$results['created_by']."</a></td></tr>";
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
echo "<tr><td class='label'>xml string</td><td><textarea cols='70' rows='2'>&lt;subject authfilenumber='".$id."' source='".$results['source']."'&gt;".$results['term']."&lt;/subject&gt;</textarea></td></tr>";

echo "</table>";
echo "<a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=subjedit&amp;id=".$results['id']."'>Edit</a>";


$sql_str1="SELECT id FROM cms_indexing_subj WHERE id < $id ORDER BY ID DESC LIMIT 1";
$navsearch1 = mysqli_query($id_link, $sql_str1) or die("Search Failed!");
$results1 = mysqli_fetch_array($navsearch1);
$prev = $results1['id'];

$sql_str2="SELECT id FROM cms_indexing_subj WHERE id > $id ORDER BY ID ASC LIMIT 1";
$navsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($navsearch2);
$next = $results2['id'];

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=subjview&amp;id=".$prev."'>&lt;&lt;&lt;&lt;&lt;</a> | <a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=subjview&amp;id=".$next."'>&gt;&gt;&gt;&gt;&gt;</a></p>";

}
######################################################################################
## display edit screen for places
elseif ($view == "geogview") {

	 $sql_str="SELECT * FROM cms_indexing_geog WHERE id=$id";

	 $geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 echo "<h3>Subject term</h3>";
echo "<table cellpadding='5'cellspacing='5'>";
$results = mysqli_fetch_array($geogsearch);
echo "<tr><td class='label'>Term</td><td>".$results['term']."</td></tr>";
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

echo "</table>";
echo "<a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=geogedit&amp;id=".$results['id']."'>Edit</a>";

$sql_str1="SELECT id FROM cms_indexing_geog WHERE id < $id ORDER BY ID DESC LIMIT 1";
$navsearch1 = mysqli_query($id_link, $sql_str1) or die("Search Failed!");
$results1 = mysqli_fetch_array($navsearch1);
$prev = $results1['id'];

$sql_str2="SELECT id FROM cms_indexing_geog WHERE id > $id ORDER BY ID ASC LIMIT 1";
$navsearch2 = mysqli_query($id_link, $sql_str2) or die("Search Failed!");
$results2 = mysqli_fetch_array($navsearch2);
$next = $results2['id'];

echo "<p><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=geogview&amp;id=".$prev."'>&lt;&lt;&lt;&lt;&lt;</a> | <a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=geogview&amp;id=".$next."'>&gt;&gt;&gt;&gt;&gt;</a></p>";

}

######################################################################################
elseif ($view == "subjadd") { ?>

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

<input type="hidden" name="func" value ="indexing"/>
<input type="hidden" name="view" value ="subjenter"/>
<input type="submit" value="Add term" />
</form>
<?php }

######################################################################################
elseif ($view == "geogadd") { ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">

<h3>Add term: Place</h3>

<table summary="">
<tr><td class="label">Term</td><td><input name="term" size="75" type="text" /></td></tr>
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

<input type="hidden" name="func" value ="indexing"/>
<input type="hidden" name="view" value ="geogenter"/>
<input type="submit" value="Add term" />
</form>
<?php }

#########################################################
# Update subject from Edit
elseif ($view == "subjupdate") {
$id = $_GET['id'];
$type = $_GET['type'];
$term = htmlentities(($_GET['term']), ENT_QUOTES);
$use_for = htmlentities(($_GET['use_for']), ENT_QUOTES);
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_indexing_subj SET id='$id', term='$term', use_for='$use_for', source='$source', other='$other', ext_id='$ext_id', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update subject failed!");


$sql_str="SELECT * FROM cms_indexing_subj WHERE id=$id";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=subjview&amp;id=".$results['id']."'>".$results['term']."</a> has been updated</p>";
echo "xml string: <textarea cols='70' rows='2'>&lt;subject authfilenumber='".$id."' source='".$results['source']."'&gt;".$results['term']."&lt;/subject&gt;</textarea>";

}

#########################################################
# Update place from Edit
elseif ($view == "geogupdate") {
$id = $_GET['id'];
$type = $_GET['type'];
$term = htmlentities(($_GET['term']), ENT_QUOTES);
$use_for = htmlentities(($_GET['use_for']), ENT_QUOTES);
$locator = $_GET['locator'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$last_edited = $date_time;
$last_edited_by = $display_user;

$sql_str="UPDATE cms_indexing_geog SET id='$id', term='$term', use_for='$use_for', locator='$locator', source='$source', other='$other', ext_id='$ext_id', last_edited_by='$last_edited_by' WHERE id='$id' LIMIT 1";

mysqli_query($id_link, $sql_str) or die ("Update subject failed!");


$sql_str="SELECT * FROM cms_indexing_geog WHERE id=$id";
$geogsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($geogsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=geogview&amp;id=".$results['id']."'>".$results['term']."</a> has been updated</p>";
echo "xml string: <textarea cols='70' rows='2'>&lt;geogname authfilenumber='".$id."' normal='".$results['term']."' source='".$results['source']."'&gt;".$results['term']."&lt;/geogname&gt;</textarea>";

}

#########################################################
# Enter new subject 
elseif ($view == "subjenter") {
$term = htmlentities(($_GET['term']), ENT_QUOTES);
$use_for = htmlentities(($_GET['use_for']), ENT_QUOTES);
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_indexing_subj (id, term, use_for, source, other, ext_id, created_for, created_by, created_on) VALUES  (NULL, '$term', '$use_for', '$source', '$other', '$ext_id', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("Enter subject failed!");


$sql_str="SELECT * FROM cms_indexing_subj WHERE term LIKE '$term'";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=subjview&amp;id=".$results['id']."'>".$results['term']."</a> has been added</p>";
echo "xml string: <textarea cols='70' rows='2'>&lt;subject authfilenumber='".$id."' source='".$results['source']."'&gt;".$results['term']."&lt;/subject&gt;</textarea>";

}

#########################################################
# Enter new subject 
elseif ($view == "geogenter") {
$term = htmlentities(($_GET['term']), ENT_QUOTES);
$use_for = htmlentities(($_GET['use_for']), ENT_QUOTES);
$locator = $_GET['locator'];
$source = $_GET['source'];
$other = $_GET['other'];
$ext_id = $_GET['ext_id'];
$created_for = $_GET['created_for'];
$created_by = $display_user;
$created_on = $date_time;

$sql_str="INSERT INTO cms_indexing_geog (id, term, use_for, locator, source, other, ext_id, created_for, created_by, created_on) VALUES  (NULL, '$term', '$use_for', '$locator', '$source', '$other', '$ext_id', '$created_for', '$created_by', '$created_on')";

mysqli_query($id_link, $sql_str) or die ("Enter place failed!");


$sql_str="SELECT * FROM cms_indexing_geog WHERE term LIKE '$term'";
$subjsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
$results = mysqli_fetch_array($subjsearch);
echo "<p><a href='".$_SERVER['PHP_SELF']."?func=indexing&amp;view=subjview&amp;id=".$results['id']."'>".$results['term']."</a> has been added</p>";
echo "xml string: <textarea cols='70' rows='2'>&lt;geogname authfilenumber='".$id."' normal='".$results['term']."' source='".$results['source']."'&gt;".$results['term']."&lt;/geogname&gt;</textarea>";

}
####################################################################################################
## display error message when illegal view is called for
else {
echo "<p>Error</p>";
} 

?> 