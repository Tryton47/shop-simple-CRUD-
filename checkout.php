<?php

@include 'config.php';

if(isset($_POST['order_btn'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $address = $_POST['address'];

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   $product_name = [];

   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
         $product_price = $product_item['price'] * $product_item['quantity']; 
         $price_total += $product_price;
      };
   };

   $total_product = implode(', ',$product_name);

   $detail_query = mysqli_query($conn, "INSERT INTO `orders`(name, number, email, method, address, total_products, total_price) 
   VALUES('$name','$number','$email','$method','$address','$total_product','$price_total')") or die('query failed');

   if($cart_query && $detail_query){
      echo "
      <div class='order-message-container'>
         <div class='message-container'>
            <h3>thank you!</h3>
            <div class='order-detail'>
               <span>".$total_product."</span>
               <span class='total'> total : Rp".number_format($price_total, 0, ',', '.').",-</span>
            </div>
            <div class='customer-details'>
               <p> name : <span>".$name."</span> </p>
               <p> number : <span>".$number."</span> </p>
               <p> email : <span>".$email."</span> </p>
               <p> address : <span>".$address."</span> </p>
               <p> payment method : <span>".$method."</span> </p>
               <p>(*pay when product is received*)</p>
            </div>
            <a href='products.php' class='btn'>Continue Shopping</a>
         </div>
      </div>
      ";
   }

}
?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
   <section class="checkout-form">
      <h1 class="heading">Complete Shopping</h1>

      <form action="" method="post">
         <div class="display-order">
            <?php
               $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
               $grand_total = 0;

               if(mysqli_num_rows($select_cart) > 0){
                  while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                     $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
                     $grand_total += $total_price;
            ?>
            <span><?= $fetch_cart['name']; ?> (<?= $fetch_cart['quantity']; ?>)</span>
            <?php
                  }
               }
            ?>
            <span class="grand-total">Total: Rp<?= number_format($grand_total, 0, ',', '.'); ?>,-</span>
         </div>

         <div class="flex">
            <div class="inputBox">
               <span>Name</span>
               <input type="text" placeholder="Your name" name="name" required>
            </div>
            <div class="inputBox">
               <span>Mobile Phone Number</span>
               <input type="number" placeholder="+62......" name="number" required>
            </div>
            <div class="inputBox">
               <span>Email</span>
               <input type="email" placeholder="Your Email" name="email" required>
            </div>
            <div class="inputBox">
               <span>Payment Method</span>
               <select name="method">
                  <option value="cash on delivery" selected>Cash</option>
                  <option value="transfer bank">Transfer Bank</option>
               </select>
            </div>
            <div class="inputBox">
               <span>Address</span>
               <input type="text" placeholder="Your Address" name="address" required>
            </div>
         </div>

         <input type="submit" value="Checkout Now" name="order_btn" class="btn">
      </form>
   </section>
</div>

<!-- JS -->
<script src="js/script.js"></script>

</body>
</html>
