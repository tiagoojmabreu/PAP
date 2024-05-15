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

$user_age = null;

if (isset($_SESSION['Username'])) {
  $mysqli = new mysqli('localhost', 'teste1', '12345', 'sportselite');

  if ($mysqli->connect_error) {
    die("Erro de conexão: " . $mysqli->connect_error);
  }

  $username = $mysqli->real_escape_string($_SESSION['Username']);
  $sql = "SELECT DataNascimento FROM cliente WHERE Username = '$username'";
  $result = $mysqli->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data_nascimento = $row['DataNascimento'];
    $data_atual = new DateTime();
    $data_nasc = new DateTime($data_nascimento);
    $idade = $data_atual->diff($data_nasc)->y;
    $user_age = $idade;
  }

  $result->free();
  $mysqli->close();
}

if (isset($_GET['id'])) {
  $mysqli = new mysqli('localhost', 'teste1', '12345', 'sportselite');

  if ($mysqli->connect_error) {
    die("Erro de conexão: " . $mysqli->connect_error);
  }

  $id = $mysqli->real_escape_string($_GET['id']);
  $sql = "SELECT nome, tipo, ano, preco, preco_desconto, desporto FROM camisola WHERE id = '$id'";
  $result = $mysqli->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nome = $row['nome'];
    $nome_camisola = "Camisola" . " " . $row['tipo'] . " " . $row['nome'] . " " . $row['ano'];
    $preco_camisola = $row['preco'];
    $preco_desconto_camisola = $row['preco_desconto'];
    $caminho_imagem = "images/" . strtolower(str_replace(' ', '', $row["nome"])) . '-' . strtolower(str_replace(' ', '', $row["tipo"])) . '-' . $row["ano"] . '.jpg';
    $desporto_atual = $row['desporto'];
    $sql_outras_camisolas = "SELECT id, nome, tipo, ano, preco, preco_desconto FROM camisola WHERE desporto = '$desporto_atual' AND id != '$id' ORDER BY RAND() LIMIT 4";
    $result_outras_camisolas = $mysqli->query($sql_outras_camisolas);
  } else {
    $nome_camisola = "Camisola não encontrada";
    $preco_camisola = "N/A";
    $caminho_imagem = "images/not_found.jpg";
  }

  $result->free();
  $mysqli->close();

} else {
  $nome_camisola = "Camisola não especificada";
  $preco_camisola = "N/A";
  $caminho_imagem = "images/not_specified.jpg";
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


  <div class="flex-box">
    <div class="left">
      <div class="big-img">
        <img src="<?php echo $caminho_imagem; ?>" alt="<?php echo $nome_camisola; ?>">
      </div>
    </div>

    <div class="right">

      <div class="url">Home > Camisola > <?php echo $nome; ?></div>
      <div class="pname"><?php echo $nome_camisola; ?></div>
      <div class="ratings">

      </div>
      <div class="size">
        <p>Tamanho :</p>
        <div class="psize" onclick="selectSize(this)">S</div>
        <div class="psize active" onclick="selectSize(this)">M</div>
        <div class="psize" onclick="selectSize(this)">L</div>
        <div class="psize" onclick="selectSize(this)">XL</div>
      </div>

      <div class="quantity">
        <p>Quantidade:</p>
        <input type="number" id="quantidade" min="1" value="1" oninput="updatePrice(<?php echo $preco_camisola; ?>)">
      </div>
      <div class="price" id="preco-container" data-preco="<?php echo number_format($preco_camisola, 2, ',', '.'); ?>"
        data-preco-desconto="<?php echo $preco_desconto_camisola ? number_format($preco_desconto_camisola, 2, ',', '.') : ''; ?>">
        Preço:
        <span id="preco">
          <?php
          if ($preco_desconto_camisola != null) {
            echo '<strong class="text-danger">' . number_format($preco_desconto_camisola, 2, ',', '.') . ' €</strong>
                  <span class="text-muted"><s>' . number_format($preco_camisola, 2, ',', '.') . ' €</s></span>';
          } else {
            echo number_format($preco_camisola, 2, ',', '.') . ' €';
          }
          ?>
        </span>
      </div>


      <div class="btn-box">
        <?php if (isset($_SESSION['Username'])): ?>
          <button id="comprar-btn" class="cart-btn">Comprar</button>
        <?php else: ?>
          <a href="login.php">
            <button class="cart-btn">Login para Comprar</button>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <section class="related-products py-5">
    <div class="container">
      <h3 class="text-center mb-4" style="font-size: 1.5rem;">Talvez você também esteja interessado em:</h3>
      <div id="related-products-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <?php
          $active = true;
          if ($result_outras_camisolas->num_rows > 0) {
            $chunks = array_chunk($result_outras_camisolas->fetch_all(MYSQLI_ASSOC), 4);
            foreach ($chunks as $chunk) {
              ?>
              <div class="carousel-item <?php echo $active ? 'active' : ''; ?>">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                  <?php
                  foreach ($chunk as $row) {
                    $nome_arquivo = strtolower(str_replace(' ', '', $row["nome"])) . '-' . strtolower(str_replace(' ', '', $row["tipo"])) . '-' . $row["ano"] . '.jpg';
                    $caminho_imagem = 'images/' . $nome_arquivo;
                    ?>
                    <div class="col">
                      <div class="card h-100">
                        <img src="<?php echo $caminho_imagem; ?>" class="card-img-top" alt="<?php echo $row["nome"]; ?>">
                        <div class="card-body">
                          <h5 class="card-title"><?php echo $row["nome"] . ' ' . $row["tipo"] . ' ' . $row["ano"]; ?></h5>
                          <p class="card-text">
                            <?php
                            if ($row["preco_desconto"] !== null) {
                              echo '<strong class="text-danger">' . number_format($row["preco_desconto"], 2, ',', '.') . ' €</strong>
                                                              <span class="text-muted"><s>' . number_format($row["preco"], 2, ',', '.') . ' €</s></span>';
                            } else {
                              echo number_format($row["preco"], 2, ',', '.') . ' €';
                            }
                            ?>
                          </p>
                          <a href="detalhes_camisola.php?id=<?php echo $row["id"]; ?>" class="btn btn-primary">Ver
                            detalhes</a>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                  ?>
                </div>
              </div>
              <?php
              $active = false;
            }
          } else {
            echo "Nenhuma camisola relacionada encontrada.";
          }
          ?>
        </div>
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
          <qinput type="text" placeholder="email" />
          <button class="btn" type="submit">Subscrever</button>
        </form>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="detalhes_camisola.js"></script>

</body>

</html>