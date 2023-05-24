<?php
    include_once 'conn.php';
    $id = $_POST['id'];
    $response = array();
    $sql = "SELECT * FROM practiceajax WHERE ID=$id";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $image = $row['image'];
    $doi = $row['doi'];
    $email = $row['email'];
    $response = compact("name","image","doi","email");
    echo json_encode($response);