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
  <title>SportsElite</title>
</head>

<body>
  <div class="header__bar">Entregas sem portes a partir de encomendas + 50$</div>
  <nav class="section__container nav__container">
    <a href="#" class="nav__logo">SPORTS ELITE</a>
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



  <header>
    <div class="section__container header__container">
      <div class="header__content">
        <p>Promoção 50% todos os artigos Formula 1</p>
        <h1>Nova Coleção</h1>
        </h1>
        <button class="btn">Compre Já</button>
      </div>
      <div class="header__image">
        <img src="images/hamilton1.png" alt="header" />
      </div>
    </div>
  </header>

  <section class="section__container sale__container">
    <h2 class="section__title">Novidades - Em promoção</h2>
    <div class="sale__grid">
      <div class="sale__card">
        <img src="images/sainz.jpg" alt="sale" />
        <div class="sale__content">
          <p class="sale__subtitle">Scuderia Ferrari</p>
          <h4 class="sale__title">Promoção <span>50%</h4>
          <p class="sale__subtitle">- Até dia 18 -</p>
          <a href="promocoes.php?nome=Scuderia Ferrari" class="btn sale__btn">Comprar já</a>
        </div>
      </div>
      <div class="sale__card">
        <img src="images/v.png" alt="sale" />
        <div class="sale__content">
          <p class="sale__subtitle">Oracle Red Bull Racing</p>
          <h4 class="sale__title">Promoção <span>50%</h4>
          <p class="sale__subtitle">- Até dia 18 -</p>
          <a href="promocoes.php?nome=Redbull" class="btn sale__btn">Comprar já</a>
        </div>
      </div>
      <div class="sale__card">
        <img src="images/norris.jpg" alt="sale" />
        <div class="sale__content">
          <p class="sale__subtitle">McLaren Formula 1 Team</p>
          <h4 class="sale__title">Promoção <span>50%</h4>
          <p class="sale__subtitle">- Até dia 18 -</p>
          <a href="promocoes.php?nome=Mclaren" class="btn sale__btn">Comprar já</a>
        </div>
      </div>
    </div>
  </section>

  <section id="EmStock" class="py-5">
    <div class="container">
      <h2 class="section__title text-center">Campeão Liga Portugal Betclic 23/24</h2>

      <div class="row justify-content-center">

        <?php
        $servername = "localhost";
        $username = "teste1";
        $password = "12345";
        $database = "sportselite";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
          die("Erro na conexão: " . $conn->connect_error);
        }

        $sql = "SELECT id, nome, tipo, liga, ano, preco FROM camisola WHERE preco_desconto is NULL AND desporto='Futebol' AND tipo LIKE '%Campeao%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

          while ($row = $result->fetch_assoc()) {

            $nome_arquivo = strtolower(str_replace(' ', '', $row["nome"])) . '-' . strtolower(str_replace(' ', '', $row["tipo"])) . '-' . $row["ano"] . '.jpg';

            $caminho_imagem = 'images/' . $nome_arquivo;

            if (file_exists($caminho_imagem)) {
              echo '
                          <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                              <a href="detalhes_camisola.php?id=' . $row["id"] . '"> 
                                  <div class="collection-img position-relative">
                                      <img src="' . $caminho_imagem . '" class="w-100" id="imagem-produto">
                                  </div>
                              </a>
                              <div class="text-center">
                                  <a href="detalhes_camisola.php?id=' . $row["id"] . '">
                                      <p class="text-capitalize my-1">' . 'Camisola' . ' ' . $row["nome"] . ' ' . $row["tipo"] . ' ' . $row["ano"] . '</p>
                                  </a>
                                  <strong>' . number_format($row["preco"], 2, ',', '.') . ' €</strong>
                              </div>
                          </div>          
                      ';
            } else {
              echo '
                          <div class="col-md-6 col-lg-4 col-xl-3 p-2 best">
                              <div class="collection-img position-relative">
                                  <img src="' . $caminho_imagem . '" class="w-100">
                              </div>
                                <div class="text-center">
                                  <p class="text-capitalize my-1">' . $row["nome"] . ' ' . $row["tipo"] . ' ' . $row["ano"] . '</p>
                                  <strong>' . number_format($row["preco"], 2, ',', '.') . ' €</strong>
                              </div>
                          </div>';
            }
          }
        } else {
          echo "0 resultados encontrados";
        }
        $conn->close();
        ?>
      </div>
    </div>
    <div class="container mt-5">
      <div class="row">
        <div class="col" style="padding-left: 100px; padding-right: 100px;">
          <h3>Sporting Clube de Portugal</h3>
          <p>
            Sporting campeão: correu bem outra vez e não foi preciso esperar muito
            Já foi há mais de quatro anos, mas a frase em forma de pergunta que Rúben Amorim
            deixou no final da sua
            apresentação em Alvalade como treinador do Sporting continua a ser um bom ponto de partida. “E se correr
            bem?”, perguntava a 6 de Março de 2020. Já tinha corrido bem antes, voltou a correr bem agora, talvez até
            melhor do que em 2021. O Sporting garantiu neste domingo o seu 20.º título de campeão nacional, o segundo
            título em quatro anos, ambos com Frederico Varandas na presidência e Amorim no banco. Num ano em que era
            imperativo ficar nos dois primeiros lugares por causa do novo formato da Liga dos campeões, os “leões”
            fizeram as apostas certas no momento certo, aproveitando em pleno a implosão dos concorrentes em diferentes
            momentos ao longo da época. <a
              href="https://www.publico.pt/2024/05/05/desporto/noticia/sporting-campeao-correu-bem-nao-preciso-esperar-2089137"><i
                class="ri-arrow-right-line"></i></a>
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="news">
    <div class="section__container news__container">
      <h2 class="section__title">Notícias recentes
      </h2>
      <div class="news__grid">
        <div class="news__card">
          <img src="images/sportingcampeao.jpeg" alt="news" />
          <div class="news__details">
            <p>
              Sporting <i class="ri-checkbox-blank-circle-fill"></i>
              <span>Liga Portugal Betclic</span>
              <i class="ri-checkbox-blank-circle-fill"></i> 06 maio 2024
            </p>
            <h4>Campeonato Portugal 23/24</h4>
            <hr />
            <p>
              Depois de ter vencido o Portimonense no sábado, ao marcar três golos sem resposta,
              a equipa de Rúben Amorim precisou de esperar pelo resultado do Benfica, que este domingo
              perdeu com o Famalicão. Feitas as contas, a equipa de Alvalade festeja a conquista do
              título.
            </p>
            <a href="https://twitter.com/DAZNPortugal/status/1787232654238109872/photo/1"><i
                class="ri-arrow-right-line"></i></a>
          </div>
        </div>
        <div class="news__card">
          <img src="images/norriswin.jpeg" alt="news" />
          <div class="news__details">
            <p>
              Lando Norris <i class="ri-checkbox-blank-circle-fill"></i>
              <span>Miami Grand Prix</span>
              <i class="ri-checkbox-blank-circle-fill"></i> 05 maio 2024
            </p>
            <h4>Campeonato nº 74 Fórmula 1</h4>
            <hr />
            <p>
              Lando Norris obtém sua primeira vitória histórica na carreira na Fórmula 1 Lando Norris
              obtém sua primeira vitória histórica na carreira na Fórmula 1 Crypto.com Grande Prêmio
              de Miami
            </p>
            <a href="https://f1miamigp.com/"><i class="ri-arrow-right-line"></i></a>
          </div>
        </div>
        <div class="news__card">
          <img src="images/neemias.jpeg" alt="news" />
          <div class="news__details">
            <p>
              Neemias Queta <i class="ri-checkbox-blank-circle-fill"></i>
              <span>Boston Celtics vs Cleveland Cavaliers </span>
              <i class="ri-checkbox-blank-circle-fill"></i> 08 maio 2024
            </p>
            <h4>Nba playoffs</h4>
            <hr />
            <p>
              O basquetebolista internacional português Neemias Queta cumpriu na terça-feira o primeiro
              jogo de sempre no playoff da Liga norte-americana de basquetebol (NBA), ao entrar sobre o
              final no triunfo dos Boston Celtics face aos Cleveland Cavaliers (120-95).
            </p>
            <a
              href="https://www.record.pt/modalidades/basquetebol/nba/detalhe/neemias-queta-estreia-se-no-playoff-da-nba-com-dois-pontos-e-dois-ressaltos"><i
                class="ri-arrow-right-line"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section__container brands__container">
    <div class="brand__image">
      <a href="camisolas_por_marca.php?marca=Adidas"><img src="images/brand-1.png" alt="brand" /></a>
    </div>
    <div class="brand__image">
      <a href="camisolas_por_marca.php?marca=Nike"><img src="images/brand-2.png" alt="brand" /></a>
    </div>
    <div class="brand__image">
      <a href="camisolas_por_marca.php?marca=UnderArmour"><img src="images/brand-3.png" alt="brand" /></a>
    </div>
    <div class="brand__image">
      <a href="camisola_por_marcas.php?marca=Kappa"><img src="images/brand-4.png" alt="brand" /></a>
    </div>
    <div class="brand__image">
      <a href="camisolas_por_marca.php?marca=New Balance"><img src="images/brand-5.png" alt="brand" /></a>
    </div>
    <div class="brand__image">
      <a href="camisolas_por_marca.php?marca=Puma"><img src="images/brand-6.png" alt="brand" /></a>
    </div>
  </section>


  <hr />

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