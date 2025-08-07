<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>seller signup</title>
</head>
 <link rel="icon" type="image/png" href="../images/logo.png">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #144999ff, #144999ff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: #ffffff;
            animation: fadeIn 1.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .box {
            background: #000000ff;
            padding: 30px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(124, 122, 122, 0.4);
            text-align: center;
        }
        .box img {
            width: 70px;
            margin-bottom: 15px;
        }
        .box h2 {
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: #e9e9e9;
            font-size: 15px;
        }
        .btn-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        button.btn {
            background: #144999ff;
            color: white;
            padding: 10px 20px;
            border: none;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background: #144999ff;
        }
        .login-link {
            font-size: 14px;
        }
        .login-link a {
            color: #144999ff;
            text-decoration: none;
        }
        .footer {
            position: absolute;
            bottom: 5px;
            font-size: 13px;
            color: #ccc;
        }
    </style>
</head>
<body>
<div class="box">
    
 <img src="../images/logo.png" alt="logo.png">
<body>
    
<div>
    <h1>seller signup</h1>
    <form action="signup.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="picture">Picture:</label>
        <input type="file" id="picture" name="picture" accept="image/*"><br><br>


       <button type="submit">signup</button>
    </form>
    <p>Don't have an account? <a href="signin.php">signin here</a>.</p>
</div>
<div>
    <footer>© Jumihen Admin 2025</footer>
</div>
</body>
</html>