<?php include "includes/upperheader.php";
echo "<title>Collections Management System</title>";
include "includes/lowerheader.php";
 ?>

<h1>Introduction</h1>

<p>The Collections Management System will be developed from existing data and from data collected as part of the RECANT process.</p>


<table width="100%" cellpadding="5" cellspacing="5">
<tr>
<td width="50%" valign="top" class="label">
<h2>Manuscripts &amp; Archives</h2>
</td>
<td width="50%" valign="top" class="label">
<h2>Rare Books &amp; Printed</h2>
</td>
</tr>
<tr>
<td valign="top">
<ul>
<li><a href="accreg.php?view=list">Manuscripts Accession Register 1960-2003</a> *** UPDATED ***&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<a href="001.php">old version</a>)<br /><br /></li>
<li><a href="clx.php">CLX boxes ('E' accessions)</a><br /><br /></li>
<!--<li><a href="eua.php">EUA (inc. old 'Da')</a><br /><br /></li>-->
<li><a href="cms.php?func=loc_eua">EUA (inc. old 'Da')</a><br /><br /></li>
</ul>
</td>
<td valign="top">
<ul>

<li><a href="docs/rbp.pdf" target="blank">Rare Books (temp list of locations)</a><br /><br /></li>
</ul>
</td>
</tr><tr>
<td width="50%" valign="top" class="label">
<h2>Other Tools</h2>
</td>
<td width="50%" valign="top" class="label">&nbsp;

</td>
</tr>
<tr>
<td valign="top">
<ul>
<li><a href="cattools.php?func=authorities">Authorities</a><br /><br /></li>
<?php if ($group_user > 4) { echo "<li><a href=\"javascript:popUp('popups/popup.php?popup=cat_auth&amp;view=add')\">Catalogue: Update Geog pages</a> (UNDER TEST)<br /><br /></li>"; } 
 if ($group_user > 1) { echo "<li><a href='cms.php?func=enquiries'>Enquiries</a><br /><br /></li>"; } ?>
</ul>
</td>
<td valign="top">
<?php if ($group_user > 1) { echo "<ul><li><a href='cms.php'>Launch full CMS</a></li></ul>"; } ?>
</td>
</tr>
</table>

<?php include "includes/footer.php"; ?>
