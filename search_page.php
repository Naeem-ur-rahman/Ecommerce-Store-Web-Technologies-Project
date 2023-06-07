<?php
include 'components/connect.php';

session_start();
if (isset($_SESSION['user_id'])) {
     $user_id = $_SESSION['user_id'];
} else {
     $user_id = '';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Search Page</title>

     <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

     <!-- custom css file  -->
     <link rel="stylesheet" href="css/style.css">
</head>

<body>
     <?php include 'components/user_header.php';?>












<?php include'components/footer.php';?>
     <!-- custum js file  -->
     <script src="js/script.js"></script>
</body>

</html>