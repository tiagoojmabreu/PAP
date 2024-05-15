<?php
session_start();

function logoutAndRedirect()
{
  $_SESSION = array();

  session_destroy();

  header("Location: login.php");
  exit;
}

if (isset($_GET['logout'])) {
  logoutAndRedirect();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/camisola.css" />
  <link rel="stylesheet" href="css/detalhes_camisola.css" />

  <title>SportsElite</title>
</head>

<body>
  <div class="fixed-top">
    <div class="header__bar">Entregas sem portes a partir de encomendas + 50$</div>
    <nav class="section__container nav__container navbar-white-bg">
      <a href="indexx.php" class="nav__logo">SPORTS ELITE</a>
      <ul class="nav__links">
        <li class="link dropdown" id="dropdownSport">
          <a href="#">DESPORTO</a>
          <div class="dropdown-content">
            <a href="camisolas.php?desporto=Futebol">Futebol</a>
            <a href="camisolas.php?desporto=Basquetebol">Basquetebol</a>
            <a href="camisolas.php?desporto=Formula 1">Formula 1</a>
          </div>
        </li>
        <li class="link"><a href="#">NOVIDADES</a></li>
        <?php if (isset($_SESSION['Username'])): ?>
          <?php if ($_SESSION['Username'] === 'admin'): ?>
            <li class="link"><a href="dashboard/index.php">DASHBOARD</a></li>
          <?php else: ?>
            <li class="link"><a href="#">SOBRE NÓS</a></li>
            <li class="link"><a href="#">NOTÍCIAS</a></li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>
      <div class="nav__icons">
        <?php if (isset($_SESSION['Username'])): ?>
          <a href="dashboard/index.php">
            <span id="userIcon"><i class="ri-shield-user-line"></i></span>
          </a>
          <a href="dashboard/perfil.php"><?= $_SESSION['Username'] ?></a>
          | <a href="?logout">Logout</a>
        <?php else: ?>
          <a href="login.php"><span id="userIcon"><i class="ri-shield-user-line"></i></span></a>
        <?php endif; ?>
      </div>
    </nav>
  </div>

  <section id="EmStock" class="py-5">
    <div class="container">
      <h2 class="section__title">Resultados da pesquisa</h2>
      <div class="row g-0">
        <?php
        $servername = "localhost";
        $username = "teste1";
        $password = "12345";
        $database = "sportselite";

        if (isset($_GET['marca'])) {

          $marca = $_GET['marca'];

          $conn = new mysqli($servername, $username, $password, $database);

          if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
          }

          $sql = "SELECT id, nome, tipo, liga, ano, preco, preco_desconto FROM camisola WHERE marca='$marca' ORDER BY preco_desconto DESC";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

              $nome_arquivo = strtolower(str_replace(' ', '', $row["nome"])) . '-' . strtolower(str_replace(' ', '', $row["tipo"])) . '-' . $row["ano"] . '.jpg';

              $caminho_imagem = 'images/' . $nome_arquivo;

              echo '
                        <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                            <a href="detalhes_camisola.php?id=' . $row["id"] . '"> 
                                <div class="collection-img position-relative">
                                    <img src="' . $caminho_imagem . '" class="w-100" id="imagem-produto">
                                </div>
                                <div class="text-center">
                                    <p class="text-capitalize my-1">' . 'Camisola' . ' ' . $row["nome"] . ' ' . $row["tipo"] . ' ' . $row["ano"] . '</p>
                                </div>
                            </a>
                            <div class="text-center">';

              if ($row["preco_desconto"] != null) {
                echo '<strong class="text-danger">' . number_format($row["preco_desconto"], 2, ',', '.') . ' €</strong>
                                    <span class="text-muted"><s>' . number_format($row["preco"], 2, ',', '.') . ' €</s></span>';
              } else {
                echo '<strong>' . number_format($row["preco"], 2, ',', '.') . ' €</strong>';
              }

              echo '</div>
                        </div>';
            }
          } else {
            echo "Ainda não temos camisolas para venda da marca $marca";
          }

          $conn->close();
        } else {
          echo "Marca não especificada";
        }
        ?>
      </div>
    </div>
  </section>




  <footer class="section__container footer__container">
    <div class="footer__col">
      <h4 class="footer__heading">CONTACTOS</h4>
      <p>
        <i class="ri-map-pin-2-fill"></i> Viseu, Viseu Portugal
      </p>
      <p><i class="ri-mail-fill"></i>sportselite697@gmail.com</p>
    </div>
    <div class="footer__col">
      <h4 class="footer__heading">Redes Sociais</h4>
      <a href="https://www.tiktok.com/@sports.elite7">
        <p>Tik Tok</p>
      </a>
      <a href="https://www.instagram.com/sports_._elite/">
        <p>Instagram</p>
      </a>
    </div>
    <div class="footer__col">
      <h4 class="footer__heading">SUPORTE</h4>
      <p>Políticas de devolução</p>
      <p>Preservação e limpeza</p>
      <p>Envios e Entregas</p>
    </div>
    <div class="footer__col">
      <h4 class="footer__heading">INSTAGRAM</h4>
      <div class="instagram__grid">
        <a href="https://www.instagram.com/p/Cu-C0zMNy-B/?img_index=1">
          <img src="images/Sporting-Principal-2023-24.jpg" alt="instagram" />
        </a>
        <a href="https://www.instagram.com/p/Cu90pNhN8ZF/?img_index=1">
          <img src="images/Benfica-Principal-2023-24.jpg" alt="instagram" />
        </a>
        <a href="https://www.instagram.com/p/Cu91G9UtTGf/?img_index=1">
          <img src="images/Porto-Principal-2023-24.jpg" alt="instagram" />
        </a>
        <a href="https://www.instagram.com/p/C6uEEL4NT3Y/?img_index=1">
          <img src="images/Japao-2023-24.jpg" alt="instagram" />
        </a>
        <a href="https://www.instagram.com/p/C6uD6hzNXsQ/?img_index=1">
          <img src="images/Sporting-2023-24.jpg" alt="instagram" />
        </a>
        <a href="https://www.instagram.com/p/C6eWlDaNP3E/?img_index=1">
          <img src="images/Noruega-Principal-2023-24.jpg" alt="instagram" />
        </a>
      </div>
    </div>
  </footer>

  <hr />

  <div class="section__container footer__bar">
    <div class="section__container footer__bar">
      <div class="copyright">
        Subscreva para emails com promoções e novidades!
      </div>
      <div class="footer__form">
        <form>
          <input type="text" placeholder="email" />
          <button class="btn" type="submit">Subscrever</button>
        </form>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="nav-dropdown.js"></script>
</body>

</html>