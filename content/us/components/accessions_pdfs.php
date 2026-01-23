<?php

   ## $file = basename(urldecode($_GET['file']));
    $fileDir = '/data/d4/libwww/docs/resources/collections/cmsys/content/Pdfs/';

    if (file_exists($fileDir . $file))
    {
        // Note: You should probably do some more checks 
        // on the filetype, size, etc.
        $contents = file_get_contents($fileDir . $file);

        // Note: You should probably implement some kind 
        // of check on filetype
        header('Content-type: application/pdf');

        echo $contents;
    }

?>