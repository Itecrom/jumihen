
<?php
//logout ntchito yake ndi ku ngopanga destroy session, Umakhala ngati kuti ukunena kuti session yomwe ndinaipanga start ija ipheni
session_start();
session_destroy();
header('Location: ../home.php');

exit();
