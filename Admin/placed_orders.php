<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
     header('location:admin_login.php');
}

if (isset($_POST['update_payment'])) {
     $order_id = $_POST['order_id'];
     $payment_status = $_POST['payment_status'];
     $update_status = $conn->prepare("UPDATE `orders` SET payment_status=? where id=?");
     $update_status->execute([$payment_status, $order_id]);
     $message[] = "Payment Status Updated!";
}

if (isset($_GET['delete'])) {
     $delete_id = $_GET['delete'];
     $delete_order = $conn->prepare("DELETE from `orders` where id =?");
     $delete_order->execute([$delete_id]);
     header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Placed Orders</title>

     <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

     <!-- custom css link -->
     <link rel="stylesheet" href="../css/admin_style.css">


</head>

<body>
     <?php include '../components/admin_header.php'; ?>

     <section class="placed-orders">

          <h1 class="heading">Placed Orders</h1>

          <div class="box-container">

               <?php
               $select_orders = $conn->prepare("Select * from   `orders`");
               $select_orders->execute();
               if ($select_orders->rowCount() > 0) {
                    while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
               ?>
                         <div class="box">
                              <p>user id <span><?= $fetch_order['user_id']; ?></span></p>
                              <p>placed on <span><?= $fetch_order['placed_on']; ?></span></p>
                              <p>Name <span><?= $fetch_order['name']; ?></span></p>
                              <p>email <span><?= $fetch_order['email']; ?></span></p>
                              <p>number <span><?= $fetch_order['number']; ?></span></p>
                              <p>address <span><?= $fetch_order['address']; ?></span></p>
                              <p>total products <span><?= $fetch_order['total_products']; ?>/-</span></p>
                              <p>total price <span><?= $fetch_order['total_price']; ?>/-</span></p>
                              <p>payment method <span><?= $fetch_order['method']; ?></span></p>

                              <form action="" method="post">
                                   <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">

                                   <select name="payment_status" class="drop-down">
                                        <option value="" selected disabled><?= $fetch_order['payment_status']; ?></option>
                                        <option value="pending">pending</option>
                                        <option value="completed">completed</option>
                                   </select>
                                   <div class="flex-btn">
                                        <input type="submit" value="update" class="btn" name="update_payment">
                                        <a href="placed_orders.php?delete=<?= $fetch_order['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">delete</a>

                                   </div>
                              </form>
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