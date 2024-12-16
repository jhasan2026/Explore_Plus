<?php
ob_start();
session_start();
$user = $_SESSION['username'];
$booking_id =  $_SESSION['booking_id'];
//$_SESSION['booking_id'] = "";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Payment</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
<header class="header">
    <div class="header__logo">
        <figure>
            <img src="../img/logo2.png" alt="logo" title="logo" height="115" width="603">
        </figure>
    </div>
    <div class="header_search">
        <form class="search__bar" action="tour.php" method="get">
            <input class="search__input"  type="text" placeholder="Search anything" name="search">
            <button class="search__button" name="searchSubmit" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>
    <nav class="header__nav">
        <ul class="header__ul">
            <li><a href="main.php">Home</a></li>
            <li><a href="tour.php">Tour</a></li>
            <li><a href="../footerPage/contact_us.html">Contact</a></li>
            <li><a href="user_profile.php">User</a></li>
        </ul>
    </nav>
    <div class="logout"><a href="logout.php">Logout</a></div>
</header>

<main class="main">
    <div class="payment__container">
        <div class="payment__method">
            <h2 class="payment__h2">Payment method</h2>
            <form action="user_payment_maintain.php" method="post" class="payment__form">
                <fieldset class="payment__fieldset">
                    <input type="hidden" name="tour_id" value="<?php echo $_GET['tour_id'] ?>">
                    <input type="hidden" name="username" value="<?php echo $user; ?>">
                    <p class="payment__p">
                        <input type="radio" name="payment_method" value="dept_crdt" id="dept_crdt">
                        <i class="fa-solid fa-credit-card"></i>
                        <label for="dept-crdt">Credit/Debit Card</label>
                    </p>
                    <p class="payment__p">
                        <input type="radio" name="payment_method" value="paypal" id="paypal">
                        <i class="fa-brands fa-cc-paypal"></i>
                        <label for="paypal">Paypal</label>
                    </p>
                    <p class="payment__p">
                        <input type="radio" name="payment_method" value="g_pay" id="g_pay">
                        <i class="fa-brands fa-google-pay"></i>
                        <label for="g-pay">Google Pay</label>
                    </p>
                    <p class="payment__p">
                        <input type="radio" name="payment_method" value="apple_pay" id="apple_pay">
                        <i class="fa-brands fa-cc-apple-pay"></i>
                        <label for="apple-pay">Apple Pay</label>
                    </p>
                    <p class="payment__p">
                        <input type="radio" name="payment_method" value="amazon_pay" id="amazon_pay">
                        <i class="fa-brands fa-cc-amazon-pay"></i>
                        <label for="amazon-pay">Amazon Pay</label>
                    </p>
                <div class="payment__summary">
                    <?php
                    $conn = mysqli_connect("localhost","root","","explore_plus");

                    if(!$conn){
                        echo "Connection Error" . mysqli_connect_error() . '<br>';
                    }

                    $tour = $_GET['tour_id'];



                    $moneyQ = "SELECT t.budget,((b.child+b.adult+b.senior)*t.budget) as total
                                from tour t
                                right join enrollment e 
                                on t.tour_id = e.tour_id
                                right join booking b
                                on e.booking_id = b.booking_id
                                WHERE t.tour_id = '{$tour}' and e.username='{$user}' and b.booking_id = '{$booking_id}'";
                    $resultQ = mysqli_query($conn,$moneyQ);

                    $money = mysqli_fetch_assoc($resultQ);

                    ?>
                    <h2 class="payment__h2">Summary</h2>
                    <div class="amount">
                        <span>Original Price:</span>
                        <span>$ <?php echo $money['budget'] ?></span>
                    </div>
                    <div class="total">
                        <span>Total:</span>
                        <span>$ <?php echo $money['total'] ?></span>
                    </div>
                    <div class="checkout">
                        <button class="payment__button" type="submit" name="checkout"><span>Complete Checkout</span></button>
                    </div>
                </div>
                </fieldset>

            </form>
        </div>


    </div>


</main>


<footer class="footer">
    <div class="footer__contact">
        <h3 class="footer__h3">Contact us:</h3>
        <ul class="footer__ul">
            <li><a href="../footerPage/contact_us.html">Contact</a></li>
            <li><a href="../footerPage/customer.html">Customer</a></li>
            <li><a href="../footerPage/website_feedback.php">Website Feedback</a></li>
        </ul>
        <div class="footer__icons">
            <i class="fa-brands fa-square-facebook"></i>
            <i class="fa-brands fa-square-instagram"></i>
            <i class="fa-brands fa-square-twitter"></i>
            <i class="fa-brands fa-square-youtube"></i>
        </div>
    </div>
    <div class="footer__about">
        <h3 class="footer__h3">About us:</h3>
        <ul class="footer__ul">
            <li><a href="../footerPage/about__us.html">About Explore.com</a></li>
            <li><a href="../footerPage/terms_condition.html">Terms &amp; Conditions</a></li>
            <li><a href="../footerPage/privacy_statement.html">Privacy Statement</a></li>
        </ul>
        <h4 class="footer__h3">Payment Method</h4>
        <div class="footer__icons">
            <i class="fa-brands fa-cc-mastercard"></i>
            <i class="fa-brands fa-cc-paypal"></i>
            <i class="fa-brands fa-cc-amazon-pay"></i>
            <i class="fa-brands fa-apple-pay"></i>
            <i class="fa-brands fa-google-pay"></i>
        </div>
    </div>
</footer>
</body>
</html>
