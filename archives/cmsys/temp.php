<?php ##template for add, edit, delete

if ($edit_permissions ==  "y") {

if ($view == "add") {

 
## Add title for this option

## Add form for data entry

}
if ($view == "add_review") {

## Add title for this option

## Display data sent from form

}
if ($view == "add_update") {

}
if ($view == "edit") {

}
if ($view == "edit_review") {

}
if ($view == "edit_update") {

}
if ($view == "delete") {

}
if ($view == "delete_review") {

}
if ($view == "delete_update") {

}

}

else {

echo "<p>Sorry, you do not have sufficient permission to do this</p>";
} ?> 