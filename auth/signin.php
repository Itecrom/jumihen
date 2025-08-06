<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signin</title>
</head>
<body>
    
<div>
    <h1>signin</h1>
    <form action="signin.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        

        <button type="submit">signin</button>
    </form>
    <p>Don't have an account? <a href="signup.php">signup here</a>.</p>
</div>
</body>
</html>