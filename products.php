<?php
// ===========================
// SECTION 1: Koneksi dan logika tambah ke keranjang
// ===========================
@include 'config.php';

if(isset($_POST['add_to_cart'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = 1;

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_id = '$product_id'");

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'product already added to cart';
   } else {
      $insert_product = mysqli_query($conn, "INSERT INTO `cart`(product_id, name, price, image, quantity) VALUES('$product_id', '$product_name', '$product_price', '$product_image', '$product_quantity')");
      $message[] = 'product added to cart successfully';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <!-- ===========================
      SECTION 2: Head HTML
   ============================ -->
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- ===========================
   SECTION 3: Pesan notifikasi
============================ -->
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i></div>';
   }
}
?>

<!-- ==========================
   SECTION 4: Header Navigasi
============================ -->
<?php include 'header.php'; ?>

<!-- ===========================
   SECTION 5: Kontainer Produk
============================ -->
<div class="container">
<section class="products">
   <h1 class="heading">products & price</h1>
   <div class="box-container">
      <?php
      $select_products = mysqli_query($conn, "SELECT * FROM `products`");
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="post">
         <div class="box">
            <!-- ===========================
               SECTION 6: Detail Produk
            ============================ -->
            <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
            <h3><?php echo $fetch_product['name']; ?></h3>

            <!-- Tampilkan deskripsi -->
            <p class="description"><?php echo $fetch_product['description']; ?></p>

            <div class="price">Rp <?php echo number_format($fetch_product['price'], 0, ',', '.'); ?></div>

            <!-- Hidden form inputs -->
            <input type="hidden" name="product_id" value="<?php echo $fetch_product['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">

            <!-- Tombol tambah ke keranjang -->
            <input type="submit" class="btn" value="add to cart" name="add_to_cart">
         </div>
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No products available</p>';
      }
      ?>
   </div>
</section>
</div>

<!-- ===========================
   SECTION 7: Script
============================ -->
<script src="js/script.js"></script>
</body>
</html>
