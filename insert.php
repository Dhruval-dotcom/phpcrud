<?php
$name = $_POST['name'];
$email = $_POST['email'];
$filename = time().$_FILES['file']['name'][0];
$domain = implode("|",$_POST['check']);
echo $name;
print_r($_POST['check']);
print_r($_FILES['file']);


$co = count($_FILES['file']['name']);
   
for($i=0;$i<$co;$i++){
    $_FILES['file']['name'][$i] = time().$_FILES['file']['name'][$i];
    if(move_uploaded_file($_FILES['file']['tmp_name'][$i],'file/'.basename($_FILES['file']['name'][$i]))){
        // echo realpath($_FILES['file']['tmp_name'][$i])."<br>";
        // echo $_FILES['file']['name'][$i]."uploaded succesfully<br>";
    }else{
        echo $_FILES['file']['error'][$i];
    }
}

$filename = implode ("|",$_FILES['file']['name']);

include 'conn.php';

$sql= "INSERT INTO practiceajax (name,email,image,doi) VALUES ('$name','$email','$filename','$domain')";
if (mysqli_query($conn, $sql)) {
    echo "1";
}else{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

