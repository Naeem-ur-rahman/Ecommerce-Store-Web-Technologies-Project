<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
     header('location:admin_login.php');
}

if (isset($_POST['update'])) {

     $pid = $_POST['pid'];
     $pid = filter_var($pid, FILTER_SANITIZE_STRING);
     $name = $_POST['name'];
     $name = filter_var($name, FILTER_SANITIZE_STRING);
     $price = $_POST['price'];
     $price = filter_var($price, FILTER_SANITIZE_STRING);
     $details = $_POST['details'];
     $details = filter_var($details, FILTER_SANITIZE_STRING);

     $update_product = $conn->prepare("UPDATE `products` SET name = ?,price=?,details=? Where id = ?");
     $update_product->execute([$name, $price, $details, $pid]);
     $message[] = "Update Product!";

     $old_image_01 = $_POST['old_image_01'];
     $image_01 = $_FILES['image_01']['name'];
     $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
     $image_01_size = $_FILES['image_01']['size'];
     $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
     $image_01_folder = '../uploaded_img/' . $image_01;
     
     if(!empty($image_01)){
          if($image_01_size > 2000000){
               $message[]='image size is too big';
          }else{
               $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? where id =?");
               $update_image_01->execute([$image_01,$pid]);
               move_uploaded_file($image_01_tmp_name,$image_01_folder);
               unlink('../uploaded_img/'.$old_image_01);
               $message[] = 'image 01 Updated';
          }
     }

     $old_image_02 = $_POST['old_image_02'];
     $image_02 = $_FILES['image_02']['name'];
     $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
     $image_02_size = $_FILES['image_02']['size'];
     $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
     $image_02_folder = '../uploaded_img/' . $image_02;
     
     if(!empty($image_02)){
          if($image_02_size > 2000000){
               $message[]='image size is too big';
          }else{
               $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? where id =?");
               $update_image_02->execute([$image_02,$pid]);
               move_uploaded_file($image_02_tmp_name,$image_02_folder);
               unlink('../uploaded_img/'.$old_image_02);
               $message[] = 'image 02 Updated';
          }
     }

     $old_image_03 = $_POST['old_image_03'];
     $image_03 = $_FILES['image_03']['name'];
     $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
     $image_03_size = $_FILES['image_03']['size'];
     $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
     $image_03_folder = '../uploaded_img/' . $image_03;

     if(!empty($image_03)){
          if($image_03_size > 2000000){
               $message[]='image size is too big';
          }else{
               $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? where id =?");
               $update_image_03->execute([$image_03,$pid]);
               move_uploaded_file($image_03_tmp_name,$image_03_folder);
               unlink('../uploaded_img/'.$old_image_03);
               $message[] = 'image 03 Updated';
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
     <title>Update products</title>

     <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

     <!-- custom css link -->
     <link rel="stylesheet" href="../css/admin_style.css">


</head>

<body>
     <?php include '../components/admin_header.php'; ?>

     <!-- update product section start  -->
     <section class="update-product">
          <?php
          $update_id = $_GET['update'];
          $show_products = $conn->prepare("Select * from `products` WHERE id = ? ");
          $show_products->execute([$update_id]);
          if ($show_products->rowCount() > 0) {
               while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
          ?>
                    <form action="" method="post" enctype="multipart/form-data">
                         <div class="image-container">
                              <div class="main-image">
                                   <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                              </div>
                              <div class="sub-images">
                                   <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                                   <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt="">
                                   <img src="../uploaded_img/<?= $fetch_products['image_03']; ?>" alt="">
                              </div>
                         </div>
                         <span>Update Name</span>
                         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                         <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
                         <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
                         <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">
                         <input type="text" value="<?= $fetch_products['name']; ?>" required placeholder="Enter Product Name" name="name" maxlength="100" class="box">
                         <span>Update Price</span>
                         <input type="number" value="<?= $fetch_products['price']; ?>" required placeholder="Enter Product price" name="price" max="9999999999" min="0" onkeypress="if(this.value.length == 10)return false;" class="box">
                         <span>Update Details</span>
                         <textarea name="details" required placeholder="Enter Product details" class="box" maxlength="500" cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
                         <span>Update Image 01</span>
                         <input type="file" name="image_01" id="" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
                         <span>Update Image 02</span>
                         <input type="file" name="image_02" id="" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
                         <span>Update Image 03</span>
                         <input type="file" name="image_03" id="" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
                         <div class="flex-btn">
                              <input type="submit" value="Update" class="btn" name="update">
                              <a href="products.php" class="option-btn">Go Back</a>
                         </div>
                    </form>
          <?php
               }
          } else {
               echo '<p class="empty">No Products Added Yet!</p>';
          }
          ?>
     </section>
     <!-- update product section end  -->

     <script src="../js/admin_script.js"></script>
</body>

</html>