<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iniciar sessão e Criar</title>
  <link rel="stylesheet" href="stylee.css" />
</head>

<body>
  <main>
    <div class="box">
      <div class="inner-box">
        <div class="forms-wrap">
          <form action="dados.php" autocomplete="off" class="sign-in-form" method="post">

            <div class="heading">
              <h2>Bem-Vindo!</h2>
              <h6>Ainda sem conta?</h6>
              <a href="#" class="toggle">Criar Conta</a>
            </div>

            <div class="actual-form">
              <div class="input-wrap">
                <input name="username" type="text" minlength="4" class="input-field" autocomplete="off" required />
                <label>Username</label>
              </div>
              <div class="input-wrap">
                <input name="senha" type="password" minlength="4" class="input-field" autocomplete="off" required />
                <label>Senha</label>
              </div>

              <input type="submit" value="Entrar" class="sign-btn" />

              <p class="text">
                Quer saber mais sobre nós?
                <a href="#">Leia</a> a nossa história.
              </p>
              <p class="text">
                Deseja continuar sem conta?
                <a href="indexx.php">Continuar</a>
              </p>
            </div>
          </form>











          <form action="registo.php" autocomplete="off" class="sign-up-form" method="post">

            <div class="heading">
              <h2>Começar</h2>
              <h6>Já tem conta?</h6>
              <a href="#" class="toggle">Iniciar sessão</a>
            </div>

            <div class="actual-form">
              <div class="input-wrap">
                <input name="usernamee" type="text" minlength="4" class="input-field" autocomplete="off" required />
                <label>Username</label>
              </div>

              <div class="input-wrap">
                <input name="emaill" type="email" class="input-field" autocomplete="off" required />
                <label>Email</label>
              </div>

              <div class="input-wrap">
                <input name="moradaa" type="text" class="input-field" autocomplete="off" required />
                <label>Morada</label>
              </div>

              <div class="input-wrap">
                <input name="datanascimentoo" type="date" minlength="4" class="input-field" autocomplete="off"
                  required />
              </div>

              <div class="input-wrap">
                <input name="senhaa" type="password" minlength="4" class="input-field" autocomplete="off" required />
                <label>Senha</label>
              </div>

              <input type="submit" value="Criar Conta" class="sign-btn" />

              <p class="text">
                Quer saber mais sobre nós?
                <a href="#">Leia</a> a nossa história.
              </p>

            </div>
          </form>
        </div>











        <div class="carousel">
          <div class="images-wrapper">
            <img src="images/norriswin.jpeg" class="image img-1 show" alt="" />
            <img src="./images/" class="image img-2" alt="" />
            <img src="./images/" class="image img-3" alt="" />
          </div>

          <div class="text-slider">
            <div class="text-wrap">
              <div class="text-group">
                <h2>Sporting - Principal - 2023/2024</h2>
                <h2>...</h2>
                <h2>...</h2>
              </div>
            </div>

            <div class="bullets">
              <span class="active" data-value="1"></span>
              <span data-value="2"></span>
              <span data-value="3"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="aapp.js"></script>
</body>

</html>