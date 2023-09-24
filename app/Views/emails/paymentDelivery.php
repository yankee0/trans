<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon" />
  <title>Deadline TC</title>
</head>
<style>
  body {
    margin: 0;
    box-sizing: border-box;
    min-height: 100vh;
    width: 100vw;
    background-color: #ffffff;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  }

  .container {
    width: 100%;
    max-width: 750px;
    border-radius: 5px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 20px;
  }

  header {
    text-align: center;
    color: #2ecc71;
  }

  .red {
    color: #e74c3c;
  }

  li {
    margin-bottom: 10px;
  }

  main {
    padding: 20px;
  }

  a {
    background: #e74c3c;
    padding-left: 30px;
    padding-right: 30px;
    padding-top: 10px;
    padding-bottom: 10px;
    text-decoration: none;
    color: white;
    border-radius: 5px;
  }

  footer {
    background-color: #e74c3c;
    color: #ffffff;
    margin-top: 20px;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
</style>

<body>
  <div class="container">
    <header>
      <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="3rem" width="3rem" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M12 9H2V8h10v1zm4-6v9c0 .55-.45 1-1 1H1c-.55 0-1-.45-1-1V3c0-.55.45-1 1-1h14c.55 0 1 .45 1 1zm-1 3H1v6h14V6zm0-3H1v1h14V3zm-9 7H2v1h4v-1z"></path>
      </svg>
      <h1>NOTIFICATION DE PAIEMENT</h1>
      <small class="red">Ne pas répondre à ce mail</small>
    </header>
    <hr>
    <main>
      <p>Bonjour <?= $nom ?>,</p>
      <p>
        La facture <strong>Nº <?= $data['id'] ?></strong> du client <strong><?= $data['nom_client'] ?></strong> du montant de <strong><?= $data['total'] ?> XOF TTC</strong> a été payée avec succès.
      </p>

      <p>Pour plus d'informations connectez vous à votre interface de gestion:</p>
      <p><a href="<?= base_url() ?>">Se connecter</a></p>
      <p>Cordialement,</p>
      <strong>SERVICE I.T. POLY-TRANS SUARL</strong>
    </main>
    <footer>
      <img src="<?= base_url('assets/img/logo.png') ?>" height="50px" width="auto" alt="">
      <div>©2023 - POLYTRANS APP</div>
    </footer>

  </div>
</body>

</html>