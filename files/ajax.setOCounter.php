<?php

include("../class/classMyDBC.php");
include("../class/classOFile.php");

if (extract($_POST)):
    $file = new OFile();
    echo json_encode($file->setCounter($id));
endif;