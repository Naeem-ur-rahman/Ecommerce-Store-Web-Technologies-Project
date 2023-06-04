<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
     header('location:admin_login.php');
}


if (isset($_POST['submit'])) {
     $name = $_POST['name'];
     $name = filter_var($name, FILTER_SANITIZE_STRING);

     $update_name = $conn->prepare('UPDATE `admins` SET name = ? WHERE id =?');
     $update_name->execute([$name, $admin_id]);

     $empty_password = sha1('');
     $select_old_password = $conn->prepare("SELECT password from `admins` where id =?");
     $select_old_password->execute([$admin_id]);
     $fetch_prev_password = $select_old_password->fetch(PDO::FETCH_ASSOC);
     $prev_password = $fetch_prev_password['password'];

     $old_password = $_POST['old_password'];
     $old_password = sha1(filter_var($old_password, FILTER_SANITIZE_STRING));
     $new_password = $_POST['new_password'];
     $new_password = sha1(filter_var($new_password, FILTER_SANITIZE_STRING));
     $confirm_password = $_POST['confirm_password'];
     $confirm_password = sha1(filter_var($confirm_password, FILTER_SANITIZE_STRING));

     if ($old_password == $empty_password) {
          $message[] = 'Please Enter old Password';
     } elseif ($old_password != $prev_password) {
          $message[] = 'Old Password not match';
     } elseif ($new_password != $confirm_password) {
          $message[] = 'Confirm Password not match';
     } else {
          if ($new_password != $empty_password) {
               $update_password = $conn->prepare("UPDATE `admins` SET password =? where id =?");
               $update_password->execute([$confirm_password, $admin_id]);
               $message[] = 'Update Password Successfull';
          } else {
               $message[] = 'Please Enter the New password';
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
     <title>Update Profile</title>

     <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

     <!-- custom css link -->
     <link rel="stylesheet" href="../css/admin_style.css">


</head>

<body>

     <?php include '../components/admin_header.php'; ?>

     <!-- update profile section start  -->
     <section class="form-container">
          <form action="" method="post">
               <h3>Update Profile</h3>
               <input type="text" name="name" maxlength="20" value="<?= $fetch_profile['name'] ?>" required placeholder="Enter your username" class="box" oninput="this.value = this.value.replace(/\s/g,'')">
               <input type="password" name="old_password" maxlength="20" placeholder="Enter your old password" class="box" oninput="this.value = this.value.replace(/\s/g,'')">
               <input type="password" name="new_password" maxlength="20" placeholder="Enter your new password" class="box" oninput="this.value = this.value.replace(/\s/g,'')">
               <input type="password" name="confirm_password" maxlength="20" placeholder="Confirm your new password" class="box" oninput="this.value = this.value.replace(/\s/g,'')">
               <input type="submit" value="Update now" name="submit" class="btn">
          </form>
     </section>
     <!-- update profile section end  -->


     <script src="../js/admin_script.js"></script>
</body>

</html>