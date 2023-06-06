<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
     header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
     $delete_id = $_GET['delete'];
     $delete_admin = $conn->prepare("DELETE from `admins` where id =?");
     $delete_admin->execute([$delete_id]);
     header('location:admin_accounts.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Admin Accounts</title>

     <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

     <!-- custom css link -->
     <link rel="stylesheet" href="../css/admin_style.css">


</head>

<body>
     <?php include '../components/admin_header.php'; ?>
     <section class="accounts">

          <h1 class="heading">Admin Accounts</h1>
          <div class="box-container">
               <div class="box">
                    <p>Register admin</p>
                    <a href="register_admin.php" class="option-btn">Register</a>
               </div>

               <?php
               $select_accounts = $conn->prepare("Select * from   `admins`");
               $select_accounts->execute();
               if ($select_accounts->rowCount() > 0) {
                    while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
               ?>
                         <div class="box">
                              <p>Admin id : <span><?= $fetch_accounts['id']; ?></span></p>
                              <p>Username <span><?= $fetch_accounts['name']; ?></span></p>
                              <div class="flex-btn">
                                   <input type="submit" value="update" class="btn" name="update_payment">
                                   <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('Delete this account?');">delete</a>
                                   <?php
                                   if ($fetch_accounts['id'] == $admin_id) {
                                        echo '<a href="update_profile.php" class="option-btn">Update</a>';
                                   }
                                   ?>
                              </div>
                         </div>
               <?php
                    }
               } else {

                    echo '<p class="empty">No Orders Placed Yet!</p>';
               }
               ?>
          </div>
     </section>

     <script src="../js/admin_script.js"></script>
</body>

</html>