<?php
$servername = "localhost";
$username = "teste1";
$senha = "12345";
$dbname = "sportselite";

$conn = new mysqli($servername, $username, $senha, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM cliente WHERE username=? AND senha=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['Username'] = $username;
        if ($username === 'admin' && $senha === 'admin') {
            header("Location: dashboard/index.php");
        } else {
            header("Location: indexx.php");
        }
        exit;
    } else {
        echo "Login falhou. Por favor, verifique seu nome de usuário e senha.";
    }
}

$conn->close();



