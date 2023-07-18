<?php
require_once('config.php');

$message = ""; // Başlangıçta boş bir mesaj
$usernameMessage = "";
$emailMessage = "";
$passwordMessage = "";

if(isset($_POST['submit'])){
    $name = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Kullanıcı adı (username) doğrulaması
    if(empty($name)){
        $usernameMessage = "Kullanıcı adı boş bırakılamaz.";
    }

    // E-posta (email) doğrulaması
    elseif(empty($email)){
        $emailMessage = "E-posta boş bırakılamaz.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailMessage = "Geçersiz e-posta adresi.";
    }

    // Şifre (password) doğrulaması
    elseif(empty($password)){
        $passwordMessage = "Şifre boş bırakılamaz.";
    } elseif(strlen($password) < 6){
        $passwordMessage = "Şifre en az 6 karakter olmalıdır.";
    } 
    
    // Şifre ve onay şifresinin eşleşmesi kontrolü
    elseif($password !== $confirmPassword){
        $passwordMessage = "Şifre ve onay şifresi eşleşmiyor.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO `user`(`username`, `email`, `password`) VALUES ('$name','$email','$hashedPassword')";
        
        if(mysqli_query($baglanti, $query)){
            $message = '<div class="alert alert-success" role="alert">
                          Kullanıcı başarıyla kaydedildi.
                        </div>';
        } else {
            $message = '<div class="alert alert-danger" role="alert">
            This is a danger alert—check it out!
          </div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <?php echo $message; ?> <!-- Mesajı ekrana yazdır -->

        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username">
                <p style="color: red;"><?php echo $usernameMessage?></p>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                <p style="color: red;"><?php echo $emailMessage?></p>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <p style="color: red;"><?php echo $passwordMessage?></p>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <a href="login.php" class="btn btn-link">Zaten bir hesabım var!</a> 
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
</html>
