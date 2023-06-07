<?php
include '../components/connect.php';


session_start();

if (isset($_POST['submit'])) {
     $name = $_POST['name'];
     $name = filter_var($name, FILTER_SANITIZE_STRING);
     $password = sha1($_POST['password']);
     $password = filter_var($password, FILTER_SANITIZE_STRING);

     $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
     $select_admin->execute([$name, $password]);

     if ($select_admin->rowCount() > 0) {
          $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
          $_SESSION['admin_id'] = $fetch_admin_id['id'];
          header('location:dashboard.php');
     } else {
          $message[] = "Incorrect Username or Password!";
     }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Login</title>

     <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

     <!-- custom css link -->
     <link rel="stylesheet" href="../css/admin_style.css">


</head>

<body>

     <?php
     if (isset($message)) {
          foreach ($message as $message) {
               echo '
          <div class="message">
               <span>' . $message . '</span>
               <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
          </div>
          ';
          }
     }

     ?>

     <!-- admin login section start -->
     <section class="form-container">
          <form action="" method="post">
               <h3>login now</h3>
               <p>default username = <span>admin</span> & password = <span>111</span></p>
               <input type="text" name="name" maxlength="20" required placeholder="Enter your username" class="box" oninput="this.value = this.value.replace(/\s/g,'')">
               <input type="password" name="password" maxlength="20" required placeholder="Enter your password" class="box" oninput="this.value = this.value.replace(/\s/g,'')">
               <input type="submit" value="login now" name="submit" class="btn">
               <a href="../home.php" class="option-btn">Home</a>
          </form>
     </section>
</body>

</html>