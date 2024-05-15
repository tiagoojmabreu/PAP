<?php
$servername = "localhost";
$username = "teste";
$senha = "teste";
$dbname = "sportselite";

$conn = new mysqli($servername, $username, $senha, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['usernamee'];
    $senha = $_POST['senhaa'];
    $morada = $_POST['moradaa'];
    $email = $_POST['emaill'];
    $datanascimento = $_POST['datanascimentoo'];

    $check_sql = "SELECT Username FROM cliente WHERE Username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Erro ao registar: O nome de usuário '$username' já está em uso.";
    } else {
        $sql = "INSERT INTO cliente (Username, Senha, Morada, Email, DataNascimento)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $senha, $morada, $email, $datanascimento);

        if ($stmt->execute() === TRUE) {
            echo "Registo bem-sucedido!";
            header("Location: login.php");
        } else {
            echo "Erro ao registar: " . $conn->error;
        }

        $stmt->close();
    }


    $check_stmt->close();
}


$conn->close();



