<?php
include_once "conn.php";
$x=intval($_POST['id']);
$del="SELECT * FROM practiceajax WHERE id={$x}";
$result = mysqli_query($conn,$del);
$row = mysqli_fetch_assoc($result);

$image = explode("|",$row['image']);

foreach ($image as $img){
    if(file_exists('file/'.$img)==1 && $img!=""){
        unlink('file/'.$img);
    }
}
$sql="DELETE FROM practiceajax WHERE id={$x}";
if(mysqli_query($conn,$sql)){
    echo "1";
}else{
    echo "0";
}