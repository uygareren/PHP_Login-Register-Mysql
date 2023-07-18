<?php

require_once('config.php');


$emailMessage = "";
$passwordMessage = "";
$message = "";

if(isset($_POST['submit'])){
    $email = $_POST["email"]; // get the email from form data
    $password = $_POST["password"]; // get the password from form data

    if(empty($email)){
        $emailMessage = "Email boş olamaz";
    }else if(empty($password)){
        $passwordMessage = "Parola boş olamaz";
    }else{
        $query = "SELECT * FROM `user` WHERE email = '$email'";

        $calistir = mysqli_query($baglanti, $query);
        $kayitsayisi = mysqli_num_rows($calistir);

        if($kayitsayisi > 0){
            $kayit = mysqli_fetch_assoc($calistir);
            $hashedPassword = $kayit['password'];

            if(password_verify($password, $hashedPassword)){
                //session başlat
                session_start();
                $_SESSION['username'] = $kayit['username'];
                $_SESSION['email'] = $kayit['email'];

                header("location: profile.php");

            }else{
                //uyarı ver
                $message = '<div class="alert alert-danger" role="alert">
            Parola yanlış!
          </div>';

            }

        }else{
            // kayıt yoktur. uyarı ver

            $message = '<div class="alert alert-danger" role="alert">
            Böyle bir kayıt yoktur!
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
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
            <p style="color: red;"><?php echo $emailMessage?></p>
            </div>

            <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
            <p style="color: red;"><?php echo $passwordMessage?></p>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <a href="register.php" class="btn btn-link">Kayıt ol!</a> 

            
        </form>

    </div>
    
    

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
</html>