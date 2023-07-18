<?php 
session_start();

if(isset($_SESSION["username"])){
    echo "<h2>".$_SESSION["username"]." HOŞGELDİN</h2>";
    echo "<h2>".$_SESSION["email"]." </h2>";
    echo '<a href="cikis.php" class="btn btn-primary">Çıkış Yap</a>'; // Güzel bir düğme eklendi
}else{
    echo "<h1>BU SAYFAYI GÖRÜNTÜLEME YETKİNİZ YOKTUR!</h1>";
}
?>
