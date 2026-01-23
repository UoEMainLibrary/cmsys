<?php

if (!isset($_GET['view'])) { ?>

<h2>Choose file</h2>
	
	<form enctype="multipart/form-data" action="cms.php" method="GET">
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
<input type="hidden" name="func" value="collFileUpload" />
<input type="hidden" name="view" value="verify" />
Choose a file to upload: <input name="uploadedfile" type="file" /><br />
<input type="submit" value="Upload File" />
</form>

<?php
	
}
elseif (($_GET['view']) == "verify") {

$target_path = "/home/lib/lacddt/cmsys/content/colldocs";

$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
    " has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
}

}

?>