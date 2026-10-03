
<?php
$server = "localhost";
$database = "myweb";
$user = "root";
$pass = "";

try {
    $koneksi = new PDO(
        "mysql:host=$server;dbname=$database;charset=utf8mb4",
        $user,
        $pass
    );

    $koneksi->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $error) {
    die("Koneksi gagal: " . $error->getMessage());
}
?>