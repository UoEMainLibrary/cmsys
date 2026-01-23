
<div align="center">
<table summary="" cellpadding="5" cellspacing="5" width="100%">

<tr>

<td width="50%" valign="top">
<table summary="Collections" cellpadding="5" cellspacing="5" width="100%">
<tr><td class="grouptitle">Collections</td></tr>
<tr>
<td class="menutable">Search Collection Titles<br /><form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="collections" />
<input type="hidden" name="view" value="searchlist" />
<input type="text" name="searchterm" />
<input type="submit" value="Search" />
</form></td>
</tr>
<tr>
<td class="menutable"><a href="<?php echo $_SERVER['PHP_SELF'] ?>?func=collections&amp;view=numlist">Numerical list</a></td>
</tr>
<tr>
<td class="menutable">
<?php if ($edit_permissions == "y") {
$url= "javascript:popUp('popups/popup.php?popup=collections&amp;view=add')";

}
else {
$url = "user.php?mode=denied";
}
echo "<a href=\"".$url."\">Add a New Collection</a>";
 ?>
</td>
</tr>
</table>
</td>

<td width="50%" valign="top">

<table summary="Collections" cellpadding="5" cellspacing="5" width="100%">
<tr><td class="grouptitle">Quick links</td></tr>
<tr>
<td class="menutable">
<p><a href="javascript:popUp('popups/popup.php?popup=accessions_report')">Accessions by type/year</a></p>
<p><a href="javascript:popUp('popups/popup.php?popup=nra')">NRA return</a></p></td>
</tr>
</table>
</td>
</tr>
<tr>
<td valign="top">
<table summary="Accessioning" cellpadding="5" cellspacing="5" width="100%">
<tr><td class="grouptitle">Accessions</td></tr>
<tr>
<td class="menutable">Search Accessions<br /><form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
<input type="hidden" name="func" value="accessions" />
<input type="hidden" name="view" value="searchlist" />
<input type="text" name="searchterm" />
<input type="submit" value="Search" />
</form></td>
</tr>
<tr>
<td class="menutable">
<?php if ($edit_permissions == "y") { ?>

<!--Add new accession<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:popUp('popups/popup.php?popup=accessions&amp;view=new&amp;acc_type=EUA')">University Archives</a> &nbsp;|&nbsp; <a href="javascript:popUp('popups/popup.php?popup=accessions&amp;view=new&amp;acc_type=RBP')">Rare Books</a> &nbsp;|&nbsp; <a href="javascript:popUp('popups/popup.php?popup=accessions&amp;view=new&amp;acc_type=MS')">Manuscripts, Archives, Personal Papers</a>-->

 <?php }
 else {
 
 echo "<a href='user.php?mode=denied'>No rights to add/edit</a>";
 } ?>
 </td>
</tr>
</table>
</td>
<td valign="top">
<table summary="locations" cellpadding="5" cellspacing="5" width="100%">
<tr><td class="grouptitle">Locations</td></tr>
<tr>
<td class="menutable"><a href="<?php echo $_SERVER['PHP_SELF'] ?>?func=loc_eua">University Archives</a></td>
</tr>
<tr>
<td class="menutable"><a href="<?php echo $_SERVER['PHP_SELF'] ?>?func=loc_clx">'E' Accessions</a></td>
</tr>
<tr>
<td class="menutable"><a href="<?php echo $_SERVER['PHP_SELF'] ?>?func=pi">Phot.Ill.</a></td>
</tr>
</table>
</td>
</tr>
</table>

</div>

