<?php
    $pagesize = isset($_POST['pagesize'])?intval($_POST['pagesize']):5;
    $currentpage = intval(isset($_POST['pg'])?$_POST['pg']:1);
?>
<table class="table table-striped ">
    <thead>
        <tr>
            <th scope="col">#
                <button onclick="sortorder(<?php echo $currentpage; ?>,1)" class="buttonarrow">
                    <!--descorderid -->
                    <img id="uparrowid" class="updown" src="img/Untitled-removebg-preview2.png">
                </button>
                <button onclick="sortorder(<?php echo $currentpage; ?>,2)" class="buttonarrow">
                    <!--ascorderid -->
                    <img id="downarrowid" class="updown" src="img/Untitled-removebg-preview.png">
                </button>
            </th>
            <th scope="col">img</th>
            <th scope="col">Name
                <button onclick="sortorder(<?php echo $currentpage; ?>,3)" class="buttonarrow">
                    <!--descordername -->
                    <img id="uparrowname" class="updown" src="img/Untitled-removebg-preview2.png">
                </button>
                <button onclick="sortorder(<?php echo $currentpage; ?>,4)" class="buttonarrow">
                    <!--ascordername -->
                    <img id="downarrowname" class="updown" src="img/Untitled-removebg-preview.png">
                </button>
            </th>
            <th scope="col">Email</th>
            <th scope="col">Gallery</th>
            <th scope="col">DOI</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody id="myTable">
        <?php
            include 'conn.php';
            $sqlcount = "SELECT count(*) FROM practiceajax";
            $resultcount = mysqli_query($conn,$sqlcount);
            $countx = mysqli_fetch_array($resultcount);
            $offsetvalue = ($currentpage-1)*$pagesize;

            $strorder = "";
            if(isset($_POST['orderid'])){
                switch ($_POST['orderid']){
                    case 1:
                        $strorder = "ORDER BY id DESC";
                        break;
                    case 2:
                        $strorder = "ORDER BY id ASC";
                        break;
                    case 3:
                        $strorder = "ORDER BY name DESC";
                        break;
                    case 4:
                        $strorder = "ORDER BY name ASC";
                        break;
                    default:
                        $strorder = "";
                }
            }
            
            $sql = "SELECT * FROM practiceajax ". $strorder ." LIMIT $pagesize OFFSET $offsetvalue";
            if(isset($_POST['val'])){
                $val = $_POST['val'];
                $sql = "SELECT * FROM practiceajax WHERE name LIKE '%$val%' OR email LIKE '%$val%' OR doi LIKE '%$val%'";
                $resulttemp = mysqli_query($conn,$sql);
                $countx = [mysqli_num_rows($resulttemp)];
                $sql .= "LIMIT $pagesize OFFSET $offsetvalue";
            }
            $result = mysqli_query($conn,$sql);
            $count = ceil($countx[0]/$pagesize);
            while($row = mysqli_fetch_assoc($result)){
                $doi = explode("|",$row['doi']);
                $image = explode("|",$row['image']);
        ?>
        <tr>
            <th scope="row"><?php echo $row['id']; ?></th>
            <td><?php if(file_exists('file/'.$image[0])==1 && $image[0]!=""){ ?><img class="imgrow"
                    src="file/<?php echo $image[0]; ?>"><?php } ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <?php 
                    for($i=0;$i<count($image);$i++){
                        if(file_exists('file/'.$image[$i])==1 && $image[$i]!=""){
                ?>
                <div class="galleryouter">
                    <div class="galleryinner">
                        <button onclick="deleteimage(<?php echo $row['id']; ?>,'<?php echo $image[$i]; ?>')"
                            class="deleteimage"><img class="cross" src="img/57165.png" ></button>
                        <img class="gallery" src="file/<?php echo $image[$i]; ?>">
                    </div>
                </div>
                <?php  }} ?>
            </td>
            <td><span class="badge bg-primary"><?php if(isset($doi[0])){ echo $doi[0]; } ?></span>
                <span class="badge bg-secondary"><?php if(isset($doi[1])){ echo $doi[1]; } ?></span>
                <span class="badge bg-success"><?php if(isset($doi[2])){ echo $doi[2]; } ?></span>
            </td>
            <td>
                <button class="update" data-id="<?php echo $row['id']; ?>"
                    onclick='updaterow(<?php echo $row['id']; ?> , <?php echo $currentpage ?>)'><i
                        style="color:Lightskyblue;" class="material-icons">&#xE254;</i></button> 
                <button class="delete" data-id="<?php echo $row['id']; ?>"
                    onclick='deleterow(<?php echo $row['id']; ?>)'></a><i style="color:orange;"
                        class="material-icons">&#xE872;</i></button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<nav aria-label="...">
    <ul class="pagination">
        <li class="page-item <?php if(1==$currentpage) echo "disabled"; ?>">
            <button class="page-link" onclick=pagination(<?php echo $currentpage-1; ?>) tabindex="-1">Previous</button>
        </li>
        <?php for($i=1;$i<=$count;$i++){ ?>
        <li class="page-item <?php if($i==$currentpage) echo "active"; ?>">
            <button class="page-link" onclick=pagination(<?php echo $i; ?>)><?php echo $i; ?></button>
        </li>
        <?php } ?>
        <li class="page-item <?php if($count==$currentpage) echo "disabled"; ?>">
            <button class="page-link" onclick=pagination(<?php echo $currentpage+1; ?>)>Next</button>
        </li>
    </ul>
</nav>