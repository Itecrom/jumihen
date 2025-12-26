<?php
session_start();
require "includes/polowela.php";

$id = $_GET["id"] ?? $_SESSION["admin_id"];

$stmt = $conn->prepare("SELECT * FROM admin WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();

$msg="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST["username"];
    $email = $_POST["email"];

    $pass_sql = "";
    if(!empty($_POST["password"])){
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $pass_sql = ", password='$password'";
    }

    if(!empty($_FILES["photo"]["name"])){
        $photo = "uploads/adminprofiles/".time()."_".basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $photo);
        $photo_sql = ", photo='$photo'";
    } else $photo_sql = "";

    $sql = "UPDATE admin SET username='$username', email='$email' $pass_sql $photo_sql WHERE id=$id";
    $msg = $conn->query($sql) ? "Profile updated" : "Update failed";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Admin Profile</title>
<style>
body{background:#001f3f;color:white;font-family:Arial;display:flex;justify-content:center}
.box{background:#002b80;padding:25px;border-radius:12px;width:360px}
input{width:100%;padding:10px;margin:8px 0;border:none;border-radius:6px}
button{background:#0066ff;color:white;padding:10px;border:none;border-radius:6px}
img{width:90px;height:90px;border-radius:50%;object-fit:cover}
</style>
</head>
<body>

<div class="box">
<h2>Edit Profile</h2>
<p><?= $msg ?></p>

<?php if($admin["photo"]): ?>
<img src="<?= $admin['photo'] ?>">
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
<input type="text" name="username" value="<?= $admin['username'] ?>" required>
<input type="email" name="email" value="<?= $admin['email'] ?>" required>


<label>Change Password (optional)</label>
<input type="password" name="password">

<button type="submit">Save Changes</button>
</form>

</div>
</body>
</html>
