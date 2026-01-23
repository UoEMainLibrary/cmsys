 <?php echo "<h2>Tasks</h2>";


## display menu
if (!isset ($view)) { 
echo "<h3>Menu</h3>";
echo "<ul>";
echo "<li></li>";
echo "</ul>";
}
elseif ($view == "viewtask") {
 
 $sql_str="SELECT * FROM collections WHERE coll=$coll";
	 $collsearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
   $results = mysqli_fetch_array($collsearch);
	 echo "<p>This task relates to <a href='".$_SERVER['PHP-SELF']."?func=collections&amp;view=viewcoll&amp;coll=".$coll."'>".$results['title']."</a></p>";
 
 
	 $sql_str="SELECT * FROM tasks WHERE id=$id";
	 $tasksearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
 
echo "<table cellpadding='5' width='90%' class='detail'>";

$results = mysqli_fetch_array($tasksearch);
$datefromdb = $results['lastupdated'];
include "cms/sqldate.php";


echo "<tr><td class='label' width='150'>Last Updated</td><td>".$displaydate."</td></tr>";
echo "<tr><td class='label'>Task</td><td>".$results['task']."</td></tr>";
echo "<tr><td class='label'>Created by</td><td>".$results['createdby']."</td></tr>";
echo "<tr><td class='label'>Date created</td><td>".$results['createddate']."</td></tr>";
echo "<tr><td class='label'>Status</td><td>".$results['status']."</td></tr>";
echo "<tr><td class='label'>Completed by</td><td>".$results['completedby']."</td></tr>";
echo "<tr><td class='label'>Date completed</td><td>".$results['completeddate']."</td></tr>";echo "<tr><td colspan='2' align='right' style='border-top: thin solid #000000;'><span style='background-color: #ffffcc;'> <a href='".$_SERVER['PHP_SELF']."?func=tasks&amp;view=edit&amp;id=".$results['id']."'>Edit</a> </span></td></tr>";
echo "</table>";

##Display notes for this task
echo "<h4>Notes</h4>";
  $sql_str="SELECT * FROM notes WHERE tablename LIKE 'tasks' AND tableid=$id";
	 $notesearch = mysqli_query($id_link, $sql_str) or die("Search Failed!");
	 
	 $rows = mysql_num_rows($notesearch);
	 ## display notes if > 0
	 if ($rows>0) {
echo "<table cellpadding='5' width='90%' class='detail'>";
echo "<tr><td class='label' width='180'>Date</td><td class='label'>Note</td><td class='label' width='150'>Created by</td><td class='label' width='150'></td></tr>";
while ($results = mysqli_fetch_array($notesearch)):

echo "<tr><td valign='top'>".$results['createddate']."</td><td valign='top'>".$results['notetext']."</td><td valign='top'>".$results['createdby']."</td><td valign='top'>";

## if editor display Delete Note option
  if ( $edit_permissions == "y" ) { ?>
  
  <div align="right"><form>
  <input type=button value="Delete" onClick="javascript:popUp('cms/popups/note.php?view=delete&amp;id=<?php echo $results['id'] ?>')">
  </form></div>
   
  <?php  
  } 
## end Delete Note loop

echo "</td></tr>";

endwhile;
echo "</table>";
}
## end display notes if >0


## if editor display Add Note option

  if ( $edit_permissions == "y" ) { ?>
  
    <form>
    <input type=button value="Add a Note" onClick="javascript:popUp('cms/popups/note.php?view=add&amp;tablename=tasks&amp;tableid=<?php echo $id ?>')">
    </form>
  <?php }
	## end Add Note loop
	
	}
## end View Note view

## begin Add Task view
	
elseif ($view == "add") {
	echo"<h2>Add Task</h2>";
		

echo "<table width='90%' cellpadding='5' class='detail'>";
echo "<form action='".$_SERVER['PHP_SELF']."' method='GET'>";
echo "<input type='hidden' name='func' value='tasks' />";
echo "<input type='hidden' name='view' value='add_review' />";
echo "<input type='hidden' name='tablename' value='".$tablename."' />";
echo "<input type='hidden' name='tableid' value='".$tableid."' />";
echo "<input type='hidden' name='status' value='not started' />";
echo "<tr><td class='label' width='150'>Task</td><td><input type='text' name='task' size='120' /></td></tr>";
echo "<tr><td  colspan='2' align='right' style='border-top: thin solid #000000;'>";
echo "<input type='submit' value='Add Task' /></td></tr>";
echo "</form>";
echo "</table>";
}

elseif ($view == "add_review") {
	echo "<h2>Review Task</h2>";		

echo "<form action='".$_SERVER['PHP_SELF']."' method='GET'>";
echo "<input type='hidden' name='func' value='tasks' />";
echo "<input type='hidden' name='view' value='add_update' />";
echo "<input type='hidden' name='tablename' value='".$tablename."' />";
echo "<input type='hidden' name='tableid' value='".$tableid."' />";
echo "<input type='hidden' name='status' value='".$status."' />";
echo "<p>".$task."</p>";
echo "<input type='hidden' name='task' value='".$task."' />";
echo "<input type='submit' value='Add this Task' />";
echo "</form>";

}

elseif ($view == "add_update") {

$now = date("Y-m-d H:i:s");

		$sql_str="INSERT INTO tasks VALUES (NULL, NULL, '$tablename', '$tableid', '$task', '$current_user', '$now', '$status', NULL, NULL)";
echo $sql_str;
		mysqli_query($id_link, $sql_str) or die("Insert failed!");
		echo "<p>Task successfully added</p>";

}
elseif ( $view == "edit" ) {

echo "edit page";

}
?>
