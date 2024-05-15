<?php
session_start();

if (!isset($_SESSION['Username'])) {
    header("Location: login.php");
    exit;
}

$mysqli = new mysqli('localhost', 'teste1', '12345', 'sportselite');

if ($mysqli->connect_error) {
    die("Erro de conexão: " . $mysqli->connect_error);
}

$username = $_SESSION['Username'];
$query = $mysqli->prepare("SELECT id FROM cliente WHERE Username = ?");
$query->bind_param("s", $username);
$query->execute();
$query->bind_result($id_cliente);
$query->fetch();
$query->close();

if (!$id_cliente) {
    die("Erro: Cliente não encontrado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $mysqli->prepare("INSERT INTO encomenda (id_cliente, id_camisola, Nome_Completo, contacto, morada, email, quantidade, tamanho, preco, data, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
    $stmt->bind_param("iissssisss", $id_cliente, $id_camisola, $nome_completo, $contacto, $morada, $email, $quantidade, $tamanho, $preco, $estado);

    $id_camisola = $_POST['id_camisola'];
    $nome_completo = $_POST['nome_completo'];
    $contacto = $_POST['telefone'];
    $morada = $_POST['morada'];
    $email = $_POST['email'];
    $quantidade = $_POST['quantidade'];
    $tamanho = $_POST['tamanho'];
    $preco = $_POST['preco'];
    $estado = 'Por confirmar';

    if ($stmt->execute()) {
        echo "Encomenda realizada com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();

