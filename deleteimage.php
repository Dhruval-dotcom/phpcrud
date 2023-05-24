<?php
include_once 'conn.php';
$imageid = $_POST['x'];
$id = INTVAL($_POST['id']);
unlink('file/'.$imageid);
$sql = "UPDATE practiceajax SET image=REPLACE(image,'$imageid','')  WHERE id=$id";
if (mysqli_query($conn,$sql)){
    echo "1";
}else {
    echo "0";
}