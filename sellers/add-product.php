<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Business</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- HEADER -->
    <header>
        <img src="../images/logo.png" alt="Logo">
        <nav>
            <a href="../index.php"><i class="fa fa-home"></i> Home</a>
            <a href="../sellers/add-product.php"><i class="fa fa-upload"></i> Upload</a>
            <a href="../about us.php"><i class="fa fa-info-circle"></i> About Us</a>
        </nav>
    </header>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 50%;
      margin: 40px auto;
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #333;
    }
    form input, form textarea {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ddd;
      border-radius: 8px;
    }
       header {
            background: linear-gradient(90deg, #002b55, #004c99);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 40px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
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
            padding: 30px;
            max-width: 1100px;
            margin: auto;
        }
    button {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      border: none;
      border-radius: 8px;
      background: #28a745;
      color: #fff;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover {
      background: #218838;
    }
    .payment {
      margin-top: 25px;
      text-align: center;
    }
    .pay-btn {
      display: inline-block;
      padding: 12px 20px;
      margin: 10px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: bold;
      color: #fff;
    }
    .airtel {
      background: #e60000;
    }
    .mpamba {
      background: #28a745;
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
  <div class="container">
    <h2>Upload Your Business</h2>
    <form method="POST" enctype="multipart/form-data">
      <label>Description:</label>
      <textarea name="description" required></textarea>
      
      <label>Photo:</label>
      <input type="file" name="photo" accept="image/*" required>
      
      <label>Video:</label>
      <input type="file" name="video" accept="video/*" required>
      
      <label>Contact:</label>
      <input type="text" name="contact" maxlength="15" required>
      
      <button type="submit">Submit</button>
    </form>

    <div class="payment">
      <h3>Pay with:</h3>
      <a href="https://www.airtelmoney.com/pay" class="pay-btn airtel">Airtel Money</a>
      <a href="https://www.tnmmobile.com/mpamba/pay" class="pay-btn mpamba">TNM Mpamba</a>
    </div>
  </div>
   <!-- FOOTER -->
    <footer>
        ©jumihen 2025
    </footer>
</body>
</html>
