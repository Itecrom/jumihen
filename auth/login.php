<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin login</title>
</head>
<body>
    
<div>
    <h1>admin login</h1>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        

        <button type="submit">login</button>
    </form>
    <p>No account yet? <a href="register.php">register here</a>.</p>
</div>
</body>
</html>