<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">

        <form action="processar_encomenda.php" method="post">

            <div class="row">

                <div class="col">

                    <h3 class="title">Informações da Encomenda</h3>

                    <div class="inputBox">
                        <span>Nome Completo :</span>
                        <input type="text" name="nome_completo" placeholder="Bernardo Alves" required>
                    </div>
                    <div class="inputBox">
                        <span>Email :</span>
                        <input type="email" name="email" placeholder="bernasalves17@gmail.com" required>
                    </div>
                    <div class="inputBox">
                        <span>Telemóvel / Telefone :</span>
                        <input type="text" name="telefone" placeholder="967240661 / 232232232" required>
                    </div>
                    <div class="inputBox">
                        <span>Morada :</span>
                        <input type="text" name="morada" placeholder="R. César Anjo - 2 - 3510-009" required>
                    </div>
                    <div class="inputBox">
                        <span>Cidade :</span>
                        <input type="text" name="cidade" placeholder="Viseu" required>
                    </div>

                </div>

                <div class="col">

                    <h3 class="title">Pagamento</h3>

                    <div class="inputBox">
                        <span>Métodos aceites :</span>
                        <img src="images/cobranca.jpg" alt="">
                    </div>
                    <div class="inputBox">
                        <span>Informações sobre a entrega :</span>
                        <p>Envio entre 5 a 8 dias úteis</p>
                    </div>

                    <input type="hidden" name="id_camisola" value="<?php echo $_GET['id_camisola']; ?>">
                    <input type="hidden" name="quantidade" value="<?php echo $_GET['quantidade']; ?>">
                    <input type="hidden" name="tamanho" value="<?php echo $_GET['tamanho']; ?>">
                    <input type="hidden" name="preco" value="<?php echo $_GET['preco']; ?>">

                </div>

            </div>

            <input type="submit" value="Proceder a encomenda" class="submit-btn">

        </form>

    </div>

</body>

</html>