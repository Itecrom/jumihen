<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - Jumihen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f4f8ff;
        }
        header {
            background: linear-gradient(90deg, #002b55, #004c99);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 40px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
        header img {
            height: 55px;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            transition: 0.3s;
        }
        nav a i {
            margin-right: 6px;
        }
        nav a:hover {
            color: #ffcc00;
        }
        .container {
            max-width: 1100px;
            margin: auto;
            padding: 40px 20px;
            text-align: center;
        }
        h1 {
            color: #003366;
            margin-bottom: 15px;
        }
        .intro {
            font-size: 18px;
            color: #333;
            max-width: 800px;
            margin: 0 auto 40px auto;
            line-height: 1.6;
        }
        .team {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
        }
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
            padding: 20px;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid #004c99;
        }
        .card h3 {
            margin: 10px 0 5px 0;
            color: #004c99;
        }
        .card p {
            font-size: 14px;
            color: #555;
        }
        footer {
            text-align: center;
            background: #002b55;
            color: white;
            padding: 15px;
            margin-top: 40px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header>
        <img src="images/logo.png" alt="Logo">
        <nav>
            <a href="index.php"><i class="fa fa-home"></i> Home</a>
            <a href="sellers/add-product.php"><i class="fa fa-upload"></i> Upload</a>
            <a href="about us.php"><i class="fa fa-info-circle"></i> About Us</a>
        </nav>
    </header>

    <!-- CONTENT -->
    <div class="container">
        <h1>About Us</h1>
        <p class="intro">
            This platform was proudly created by <b>Promise Henderson </b>and asisted by <b>Gladys Junta, Getrude Mission, and Christina Nkawihe</b>.  
            We are passionate developers and administrators working hard to connect buyers and sellers,  
            making it easier for you to access <b>Food, Clothes, Electronics, and School products</b> in one simple place.  
            <br><br>
            Our mission is to build trust, grow communities, and make online business simple and secure.  
            <b>We are here for you — join us and experience the difference!</b>
        </p>

        <div class="team">
            <div class="card">
                <img src="images/admins/hendreson.jpg" alt="Promise Henderson">
                <h3>Promise Henderson</h3>
                <p>CEO And System Admin</p>
            </div>
            <div class="card">
                <img src="images/admins/junta.jpg" alt="Gladys Junta">
                <h3>Gladys Junta</h3>
                <p>Co-system Developer & Admin</p>
            </div>
            <div class="card">
                <img src="images/admins/gutrude.jpg" alt="Getrude Mission">
                <h3>Getrude Mission</h3>
                <p>co-system Designer & Admin</p>
            </div>
            <div class="card">
                <img src="images/admins/christina.jpg" alt="Christina Nkawihe">
                <h3>Christina Nkawihe</h3>
                <p>co-System Developer & Admin</p>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        ©jumihen 2025
    </footer>
</body>
</html>