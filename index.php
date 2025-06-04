<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', 1);
*/
session_start();

if (!isset($_SESSION['cart'])) 
{
    $_SESSION['cart'] = [];
}

$showCart = false;

if (isset($_POST['add_to_cart'])) 
{
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    
    if ($quantity > 0) 
    {
        if (isset($_SESSION['cart'][$product_id])) 
        {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
        $showCart = true;
    }
}


if (isset($_POST['update_cart']))
{
    foreach ($_POST['quantities'] as $product_id => $quantity) {
        $quantity = (int)$quantity;
        if ($quantity > 0) 
        {
            $_SESSION['cart'][$product_id] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }
}
  
if (isset($_GET['remove'])) 
{
    $product_id = $_GET['remove'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

$products = [
    '1' => [
        'name' => 'Lungo Coffee',
        'price' => 700,
        'image' => 'https://storage.googleapis.com/a1aa/image/d171b7ad-6456-4d95-708d-c788d5e07194.jpg'
    ],
    '2' => [
        'name' => 'Delgona Coffee',
        'price' => 14000,
        'image' => 'https://storage.googleapis.com/a1aa/image/6462a202-254d-4ca5-584d-1e3476f0844d.jpg'
    ],
    '3' => [
        'name' => 'Iced Coffee',
        'price' => 4000,
        'image' => 'https://storage.googleapis.com/a1aa/image/c3d0a11a-ea41-45d6-da70-df3a39042d97.jpg'
    ],
    '4' => [
        'name' => 'Filter Coffee',
        'price' => 8000,
        'image' => 'https://storage.googleapis.com/a1aa/image/ccd4ec46-fce6-4e81-c0d1-3027b3749985.jpg'
    ]
    ];
    $productsAdd = [
    '5' => [ 
        'name'  => 'Gulab Jamun',
        'price' => 9000,
        'image' => 'https://storage.googleapis.com/a1aa/image/b483890b-7f65-42c0-0936-f2b4426bb7af.jpg'
    ],
    '6' => [ 
        'name'  =>  'Chocolate',
        'price' =>  20000,
        'image' =>  'https://storage.googleapis.com/a1aa/image/2a002734-3843-461c-d51d-2c6dfc51e10e.jpg' 
    ],
    '7' => [ 
        'name'  =>  'Churros',
        'price' =>  25000,
        'image' =>  'https://storage.googleapis.com/a1aa/image/9f0c95bd-4fad-470e-8ce1-4684da9207e3.jpg'
    ],
     '8' => [ 
        'name'  =>  'Australian Lamingtons',
        'price' =>  25000,
        'image' =>  'https://storage.googleapis.com/a1aa/image/23b9e328-f790-48c8-d610-081fce6a193e.jpg'
    ]
        
];
        $allProducts = $products + $productsAdd;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee Shop</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <header class="header">
    <img class="header-img" src="https://storage.googleapis.com/a1aa/image/fd490963-09e2-429c-ebb3-bd43565fc2c1.jpg" alt="Coffee shop header">
    <div class="header-overlay">
      <nav class="nav-container">
        <div class="logo">Coffee</div>
        <ul class="nav-links">
          <li><a href="index.php">Home</a></li>
          <li><a href="#coffee">Coffee</a></li>
          <li><a href="#">Market</a></li>
          <li><a href="#allShop">Shop</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#">Login</a></li>
        </ul>

        <div class="cart-icon">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count"><?= array_sum($_SESSION['cart']) ?> </span>
        </div>
      </nav>
      <div class="hero-content">
        <p class="hero-subtitle">Welcome!</p>
        <h1 class="hero-title">We serve the richest coffee<br>in the city!</h1>
        <button class="cta-button">Order Now</button>
      </div>
    </div>
  </header>


  <section class="features">
    <div class="feature-item">
      <i class="fas fa-coffee"></i>
      <span>Hot Coffee</span>
    </div>
    <div class="feature-item">
      <i class="fas fa-mug-hot"></i>
      <span>Cold Coffee</span>
    </div>
    <div class="feature-item">
      <i class="fas fa-cup-straw"></i>
      <span>Cappuccino</span>
    </div>
    <div class="feature-item">
      <i class="fas fa-cookie-bite"></i>
      <span>Breakfast</span>
    </div>
  </section>

  <main class="main-content">
    <!-- 
    <section class="product-section">
      <h2 class="section-title">OUR SPECIAL COFFEE</h2>
      <div class="product-grid">
      
      </div>
    </section>

  
    <section class="product-section">
      <h2 class="section-title">OUR SPECIAL DESSERT</h2>
      <div class="product-grid">
       
      </div>
    </section>
    -->
  <main> 
 <div id="cart-content">
        <?php if (!empty($_SESSION['cart'])): ?>
        <form method="post">
            <table>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                <?php 
                $total = 0;
                foreach ($_SESSION['cart'] as $id => $quantity): 
                    if(!isset($allProducts[$id])) continue;
                    $product = $allProducts[$id]; // we can add AllProducts it meants 1 + 2
                    $subtotal = $product['price'] * $quantity;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= $product['name'] ?></td>
                    <td>Riel. <?= number_format($product['price']) ?>៛</td>
                    <td>
                        <input type="number" name="quantities[<?= $id ?>]" 
                               value="<?= $quantity ?>" min="1">
                    </td>
                    <td>Riel. <?= number_format($subtotal) ?>៛</td>
                    <td>
                        <a href="?remove=<?= $id ?>">Remove</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <p>Total: Riel. <?= number_format($total) ?>៛</p>
        <div class="up-p">
            <button type="submit" name="update_cart">Update Cart</button>
        </div>
            <div class="btn-button">
            <a href="https://neatsmos.github.io/nt1/">Order Now</a>
            </div>
        </form>
        <?php else: ?>
            <div class="empty-cart-message">
        <div class="di-p">
        <p>Your cart is empty!</p>
        </div>
        </div>
        <?php endif; ?>
    </div>

    <main>
        <section id="coffee">
            <h2 style="text-align: center; margin: 2rem 0;">OUR SPECIAL COFFEE</h2>
            <div class="coffee-grid">
                <?php foreach ($products as $id => $product): ?>
                <div class="coffee-card">
                    <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    <div class="coffee-info">
                        <p class="coffee-name"> <?= $product['name'] ?></p>
                        <p class="coffee-price">Riel. <?= number_format($product['price']) ?>៛</p>
                        <form method="post">
                            <input type="hidden" name="product_id" value="<?= $id ?>">
                            <input type="number" name="quantity" value="1" min="1">
                            <button type="submit" name="add_to_cart">Add to Cart</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
  </main>
  
   <main>
        <section id="allShop">
            <h2 style="text-align: center; margin: 2rem 0;">OUR SPECIAL DESSERT COFFEE</h2>
            <div class="coffee-grid">
                <?php foreach ($productsAdd as $id => $product): ?>
                <div class="coffee-card">
                    <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    <div class="coffee-info">
                        <p class="coffee-name"><?= $product['name'] ?></p>
                        <p class="coffee-price">Riel. <?= number_format($product['price']) ?>៛</p>
                        <form method="post">
                            <input type="hidden" name="product_id" value="<?= $id ?>">
                            <input type="number" name="quantity" value="1" min="1">
                            <button type="submit" name="add_to_cart">Add to Cart</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
            
        <h2 style="text-align: center; margin: 2rem 0;">OUR SPECIAL DESSERT COFFEE</h2>
   

  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>Handmade Coffee Shop</title>
  <link rel="stylesheet" href="styles.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <div class="coffee-container">
    <div class="coffee-column">
      <img alt="Brown paper coffee bag with black label placed on a wooden table with two white disposable coffee cups on each side" src="https://storage.googleapis.com/a1aa/image/37d6c86e-e891-4c4e-495a-00c0f2743d26.jpg"/>
      <h2>Handmade Just For You</h2>
      <p>
        Our organically grown coffee beans are roasted with an expert hand to a
        taste of a rich, fresh aroma. There's nothing quite like a cup of
        brewed creamy coffee.
      </p>
      <button class="coffee-button">Discover more</button>
    </div>
    <div class="coffee-column">
      <h2>Made In Cambodia</h2>
      <img alt="Exterior of a coffee shop in Brussels with glass windows, warm interior lighting, and plants outside" src="https://storage.googleapis.com/a1aa/image/de0869af-bb8f-4ffa-f01e-98fab2479c86.jpg"/>
      <p>
        Welcome to Cambodia Brewing, where the charm of Cambodia meets the aroma of freshly brewed coffee. 
        Our café is a cozy haven where friends gather, ideas spark, and every sip tells a story.
      </p>
      <p>
        Taste the experience and feel the buzz of every cup and latte that
        can't wait to welcome you!
      </p>
      <button class="coffee-button">Learn more</button>
    </div>
  </div>
  <script>
    /*
            document.querySelector('.cart-icon').addEventListener('click', function() {
            const cartContent = document.getElementById('cart-content');
            cartContent.style.display = cartContent.style.display === 'none' ? 'block' : 'none';
        });
        */
       document.addEventListener('DOMContentLoaded', function() {
        const cartIcon = document.querySelector('.cart-icon');
        const cartContent = document.getElementById('cart-content');
        if (cartIcon && cartContent) {
            cartIcon.addEventListener('click', function() {
                cartContent.style.display = (cartContent.style.display === 'none' || !cartContent.style.display) ? 'block' : 'none';
            });
        }
    });
    </script>

    <section class="container section-padding">
        <div class="text-center mb-8">
            <h2 class="font-bold uppercase tracking-wide mb-2" style="color:#E69108; font-family: 'Arial', sans-serif; font-size: 24px;">
                Come and join
            </h2>
            <p class="font-cursive text-sm mb-1" style="font-size: 18px;">
                We believe in building connections that last, offering experiences that inspire, 
                and creating memories that bring joy.
            </p>
            <h2 class="font-bold uppercase tracking-wide mb-2">OUR HAPPY CUSTOMERS</h2>
        </div>

        
    
        <div class="testimonial-grid">
        <div class="testimonial-card">
        <div class="testimonial-content">
            <div class="flex items-center mb-4">
            <img src="profile\sinath.png" alt="neat" class="profile-img">
            <div>
                <p class="font-bold text-sm">Neng Neat</p>
                <div class="custom-star-color">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                </div>
            </div>

            </div>
            <p class="text-xs text-primary">
                I've been ordering betans from you for ten years, the quality of the product is 
                I originally fly to have a compassionate soul. Honestly, after I got here we did not
                 travel high expectations but I have been very pleased.
                I especially like my selection: great prices with perfectly roasted prices that I recommend..</p>
        </div>
    </div>
<div class="testimonial-card">
  <div class="testimonial-content">
    <div class="flex items-center mb-4">
      <img src="profile\seakie.jpg" alt="Kang Seakie" class="profile-img">
      <div>
        <p class="font-bold text-sm">Kang Seakie</p>
        <div class="custom-star-color">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
      </div>
    </div>
    <p class="text-xs text-primary">
        For over 2 years, your coffee has been my go-to choice, and I couldn’t 
        imagine starting my mornings without it.
         At first, I wasn’t expecting much, but the moment I took my first sip,
          I knew I’d found something special</p>
  </div>
</div>
<div class="testimonial-card">
  <div class="testimonial-content">
    <div class="flex items-center mb-4">
      <img src="profile\vandy.jpg" alt="vandy" class="profile-img">
      <div>
        <p class="font-bold text-sm">Mes Vandy</p>
        <div class="custom-star-color">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
      </div>
    </div>
    <p class="text-xs text-primary">
        I've been ordering betans from you for ten years, the quality of the product is 
        consistently high I'm grateful for the core that is apparently put into the roots 
        and the excellent customer services your
         betans give only to the best cups of coffee.</p>
  </div>
</div>
        <div class="indicator-dots flex justify-center gap-2 mt-4">
            <span class="active"></span>
            <span></span>
            <span></span>
        </div>
    </section>
    

    <!-- Subscription Section -->
    <section class="subscription-section">
        <div class="container text-center">
            <h3 class="font-bold text-sm mb-1">Join in and get 15% Off!</h3>
            <p class="text-xs mb-6">Subscribe to our newsletter and get 15% discount</p>
            
            <form class="subscription-form flex">
                <input type="email" placeholder="Email address" class="email-input">
                <button type="submit" class="subscribe-btn text-xs">Subscribe</button>
            </form>
        </div>
    </section>

<footer class="footer">
   <div id="about">
    <h4 class="footer-heading">
     COFFEE
    </h4>
    <i>
    <p>HELLO</p>
    </i>
   </div>
   <div>
    <h4 class="footer-heading">
     PRIVACY
    </h4>
    <ul class="footer-list">
     <li>
      Terms of Use
     </li>
     <li>
      Privacy Policy
     </li>
     <li>
      Cookies
     </li>
    </ul>
   </div>
   <div>
    <h4 class="footer-heading">
     SERVICES
    </h4>
    <ul class="footer-list">
     <li>
      Order Online
     </li>
     <li>
      Delivery
     </li>
    </ul>
   </div>
   <div>
    <h4 class="footer-heading">
     ABOUT US
    </h4>
    <ul class="footer-list">
     <li>
      How it works
     </li>
     <li>
      About us
     </li>
     <li>
      Our story
     </li>
    </ul>
   </div>
   <div>
    <h4 class="footer-heading">
     INFORMATION
    </h4>
    <ul class="footer-list">
     <li>
      How it working
     </li>
     <li>
      All your products
     </li>
     <li>
      Info
     </li>
    </ul>
    <div class="social-icons">
     <a aria-label="Telegram" href="https://t.me/sinath67">
      <i class="fab fa-telegram"></i>
     </a>
     <a aria-label="Facebook" href="https://www.facebook.com/sinath67">
      <i class="fab fa-facebook-f"></i>
     </a>
     <a aria-label="LinkedIn" href="#">
      <i class="fab fa-linkedin-in"></i>
     </a>
    </div>
   </div>
</footer>
    <di class="cy">
    <i>
    <p>© 2023 All rights reserved.</p>
    </i>
    </di>

</body>
</html> 