<?php include 'db/connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hanoi Marathon</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="Image/logo.jpg" alt="Hanoi Marathon Logo">
            <h1>
                <span>Hanoi</span>
                <span>Marathon</span>
                
            </h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home Page</a></li>
                <li><a href="races.php">Races</a></li>
                
                <li><a href="result.php">Result</a></li>
                <li><a href="account.php">Account</a></li>  
            </ul>
        </nav>
    </header>

    <main>
        <section id="home">
            <div class="carousel">
                <img src="Image/photo1.png" alt="Image 1">
                <img src="Image/photo2.png" alt="Image 2">
                <img src="Image/photo3.png" alt="Image 3">
            </div>
        </section>
    </main>

    <a href="register.php" class="register-button">Register</a>

    <footer id="contact">
        <div class="organizer-info">
            <h2>Nguyen Ngoc Thuong</h2>
            <p>Tel: Don't call me</p>
            <p>Email: <a href="mailto:VietNamJapanUniversity@gmail.com">VietNamJapanUniversity@gmail.com</a></p>
            <p>Address: Ha Noi</p>
        </div>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>
