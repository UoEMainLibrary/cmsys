<?php include "includes/upperheader.php";
include "includes/lowerheader.php";
 ?>

<h1>User information</h1>


<table cellpadding="5" cellspacing="5" summary="user details">
<tr>
<td>Username</td>
<td><?php echo $_SERVER['REMOTE_USER'] ?? $LOCAL_USER ?? null; ?></td>
</tr>
<tr>
<td>Name</td>
<td><?php echo $display_user ?></td>
</tr>
<tr>
<td>Permissions group</td>
<td><?php echo $results['group'] ?></td>
</tr>
</table>
<p>Further content for this page in development.</p>

<?php 
include "includes/footer.php"; ?>
