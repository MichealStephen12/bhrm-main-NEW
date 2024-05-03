<?php

require 'connection.php';

if(!empty($_SESSION["uname"]) && !empty($_SESSION["role"])){
    echo '';
}else{
    header("location: ../index.php");
}

if(isset($_POST['submit'])){
    $roomno = $_POST['roomno'];
    $amenities = $_POST['amenities'];
    $price = $_POST['price'];
    $status = $_POST['status'];


    $_FILES['image'];

    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];

    $fileExt = explode('.', $fileName);
    $fileactualext = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if(in_array($fileactualext, $allowed)){
        if($fileError === 0){
            if($fileSize < 1000000){
                $fileNameNew = $fileName;
                $fileDestination = '../images/'.$fileNameNew;
                if($fileNameNew > 0){
                    move_uploaded_file($fileTmpName, $fileDestination);
                    header("location: ../index.php");
                }
                
            }else{
                echo "your file is too big.";
            }
        }
    }else{
        echo "you cannot upload this type of file";
    }
   
    $query = "INSERT INTO `rooms`(`id`, `room-no`, `amenities`, `price`, `image`, `status`) VALUES ('','$roomno','$amenities','$price','images/$fileNameNew', '$status')";
    mysqli_query($conn, $query);

    header("location: ../boardinghouse.php");
}



$data = ['id' => '', 'room-no'=>'', 'amenities' => '', 'price' => '', 'image' => '', 'status'=>''];

if(isset($_GET['rupdate'])){
    $id = $_GET['rupdate'];

    $query = "SELECT * FROM `rooms` WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
}

if(isset($_POST['update'])){
    $id = $_GET['rupdate'];
    $roomno = $_POST['roomno'];
    $amenities = $_POST['amenities'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    $file = $_FILES['image'];
    
    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];

    $fileExt = explode('.', $fileName);
    $fileactualext = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if(in_array($fileactualext, $allowed)){
        if($fileError === 0){
            if($fileSize < 1000000){
                $fileNameNew = $fileName;
                $fileDestination = '../images/'.$fileNameNew;
                if($fileNameNew > 0){
                    move_uploaded_file($fileTmpName, $fileDestination);
                    header("location: ../index.php");
                }
                
            }else{
                echo 'your file is too big.';
            }
        }
    }else{
        echo "you cannot upload this type of file";
    }

    $query = "UPDATE `rooms` SET `id`= $id,`room-no`='$roomno',`amenities`='$amenities', `price`='$price', `image`='images/$fileNameNew', `status`='$status' WHERE id = $id";
    mysqli_query($conn, $query);

    header("location: ../boardinghouse.php");
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <h2>Add Rooms</h2><br>
            <label for=""> Room No: </label>
            <input type="text" name="roomno" value="<?php echo $data['room-no']; ?>"  placeholder="enter here.."><br><br>
            <label for=""> Amenities: </label>
            <input type="text" name="amenities" value="<?php echo $data['amenities']; ?>"  placeholder="enter here.."><br><br>
            <label for=""> Price: </label>
            <input type="text" name="price" value="<?php echo $data['price']; ?>"  placeholder="enter here.."><br><br>
            <label for=""> Image: </label>
            <input type="file" name="image" placeholder="enter here.."><br><br>
            <?php if($data['id'] != '') :  ?>
            <div>
                <img src="../<?php echo $data['image'];?>" value="<?php echo $data['image'];?>" height="100" width="100" alt="">
            </div><br>
            <?php else:?>
            <?php endif; ?>
            <label for=""> Status: </label>
            <input type="text" name="status" value="<?php echo $data['status']; ?>" placeholder="enter here.."><br><br>
            <div> 
                <?php if($data['id'] != '') :  ?>
                <input type="submit" name="update" value="Update">
                <?php else: ?>
                <input type="submit" name="submit" value="Submit">
                <?php endif; ?>
                <a href="../boardinghouse.php">Back</a>
            </div>
           
        </form>
    </div>

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
            text-decoration: none;
        }

        .container{
            display: flex;
            justify-content: center;
            margin-top: 50px;
            
        }

        form{
            border: 1px solid black;
            background-color: rgb(221, 221, 221);
            border-radius: 5px; 
            padding: 20px;
            box-shadow: 10px 10px 1px rgba(0, 0, 0, 0.1); 
            font-size: 20px;
        }form h2{
            text-align: center;
        }form a{
            color: black;
        }input[type=text]{
            width: 200px;
            padding: 10px;
            border: 1px solid #ccc; 
            border-radius: 5px; 
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); 
            font-size: 16px; 
        }input[type=password]{
            width: 200px;
            padding: 10px;
            border: 1px solid #ccc; 
            border-radius: 5px; 
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); 
            font-size: 16px; 
        }input[type=submit]{
            background-color: rgb(52, 133, 255);
            padding: 10px;
            color: white;
            border: 1px solid #ccc; 
            border-radius: 5px; 
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); 
            font-size: 16px; 
            
        }
    </style>

<body>
</html>