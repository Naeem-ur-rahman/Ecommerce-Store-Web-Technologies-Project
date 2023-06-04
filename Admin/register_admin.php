<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
     header('location:admin_login.php');
}

?>

<?php
if (isset($_POST['submit'])) {
     $name = $_POST['name'];
     $name = filter_var($name, FILTER_SANITIZE_STRING);
     $password = sha1($_POST['password']);
     $password = filter_var($password, FILTER_SANITIZE_STRING);
     $cpassword = sha1($_POST['cpassword']);
     $cpassword = filter_var($cpassword, FILTER_SANITIZE_STRING);

     $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
     $select_admin->execute([$name]);

     if ($select_admin->rowCount() > 0) {
          $message[] = 'Already username exits!';
     } else {
          if ($password != $cpassword) {
               $message[] = 'Confirm password not matched!';
          } else {
               $insert_admin = $conn->prepare("INSERT INTO `admins`(name,password) VALUES(?,?)");
               $insert_admin->execute([$name, $cpassword]);
               $message[] = 'New Admin Registered!';
          }
     }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Register</title>

     <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

     <!-- custom css link -->
     <link rel="stylesheet" href="../css/admin_style.css">


</head>

<body>
     <?php include '../components/admin_header.php'; ?>

     <!-- register admin section start  -->
     <section class="form-container">
          <form action="" method="post">
               <h3>Register New</h3>
               <input type="text" name="name" maxlength="20" required placeholder="Enter your username" class="box" oninput="this.value = this.value.replace(/\s/g,'')">
               <input type="password" name="password" maxlength="20" required placeholder="Enter your password" class="box" oninput="this.value = this.value.replace(/\s/g,'')">
               <input type="password" name="cpassword" maxlength="20" required placeholder="Confirm your password" class="box" oninput="this.value = this.value.replace(/\s/g,'')">
               <input type="submit" value="Register now" name="submit" class="btn">
          </form>
     </section>
     <!-- register admin section end  -->

     <script src="../js/admin_script.js"></script>
</body>

</html>