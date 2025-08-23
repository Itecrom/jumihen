<!DOCTYPE html>
<html>
<head>
    <title>Seller Signin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<style>
    body {
    background: #001f3f;
    color: #fff;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.form-container {
    background: #000;
    padding: 2em;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.8);
    width: 300px;
}

input[type="text"], input[type="email"], input[type="password"], input[type="file"] {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border: none;
    border-radius: 5px;
}

button {
    background: #0074D9;
    color: white;
    border: none;
    padding: 10px;
    width: 100%;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #005fa3;
}
</style>
<body>
    <div class="form-container">
        <h2>Seller Signin</h2>
        <form id="loginForm">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Signin</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Signup</a></p>
    </div>

    <script>
    document.getElementById("loginForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch("signin_handler.php", {
            method: "POST",
            body: formData
        }).then(res => res.text())
          .then(data => {
            if (data === 'success') {
                window.location.href = "../sellers/dashboard.php";
            } else {
                alert(data);
            }
        });
    });
    </script>
</body>
</html>