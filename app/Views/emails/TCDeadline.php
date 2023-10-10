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
    padding: 20px, 20px, 20px, 20px;
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
    box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 1px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
    padding-top: 30px;
    overflow: hidden;
  }

  header {
    text-align: center;
    color: #e74c3c;
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
      <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg">
        <path fill="none" stroke="#e74c3c" stroke-width="2" d="M12,17 L12,19 M12,10 L12,16 M12,3 L2,22 L22,22 L12,3 Z"></path>
      </svg>
      <h1>ALERTE DEADLINE TC</h1>
      <small>Ne pas répondre à ce mail</small>
    </header>
    <main>
      <p>Bonjour <?= $nom ?>,</p>
      <p>Ci-dessous la liste des <strong class="red"><?= count($tcs) ?> conteneurs</strong> à moins de <strong>48H</strong> de leurs deadlines:</p>
      <ul>
        <?php foreach ($tcs as $tc) : ?>
          <li><strong><?= $tc['designation'] ?></strong> du TC <strong class="red"><?= $tc['conteneur'] ?> de type <?= $tc['type'] ?>'</strong> pour le client <strong><?= $tc['client'] ?></strong>.Deadline prévu le <strong><?= date('d/m/Y', strtotime($tc['deadline'])) ?></strong>, Pregate reçu le <strong><?= date('d/m/Y', strtotime($tc['date_creation'])) ?></strong> et <strong><?= $tc['paiement'] == 'OUI' ? 'payé le ' . date('d/m/Y', strtotime($tc['date_creation'])) . '.' : 'NON PAYÉ.' ?></strong>
          <?php endforeach ?>
      </ul>
      <p>Pour plus d'informations connectez vous à votre interface de gestion <br>
        Cordialement,</p>
      <strong>SERVICE I.T. POLY-TRANS SUARL</strong>
    </main>
    <footer>
      <img src="<?= base_url('assets/img/logo.png') ?>" height="50px" width="auto" alt="">
      <div>©2023 - POLYTRANS APP</div>
    </footer>

  </div>
</body>

</html>