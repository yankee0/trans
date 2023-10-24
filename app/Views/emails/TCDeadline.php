<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>Deadline TC</title>
</head>
<style>
  body {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    width: 100vw;
    background-color: #ffffff;
    font-family: 'Poppins', sans-serif;
  }

  .container {
    width: 100%;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
    overflow: hidden;
    padding-left: 20px;
    padding-right: 20px;
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


  a {
    color: #e74c3c;
  }

  footer {
    margin-top: 20px;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  #heroImg {
    height: 250px;
    width: 250px;
    margin: auto;
  }

  #num {
    font-size: 7rem;
    text-align: center;
  }

  .text-center {
    text-align: center;
    font-weight: bold;
  }
</style>

<body>
  <div class="container">
    <header>
      <img id="heroImg" src="<?= base_url('assets/img/container.svg') ?>" alt="Conteneur">
      <h1>ALERTE DEADLINE TC</h1>
      <small>Ne pas répondre à ce mail</small>
    </header>
    <main>
      <div id="num"><?= $tcs ?></div>
      <div class="text-center">Conteneurs proches deadlines</div>
      <p>Bonjour <?= $tcs ?>,</p>
      <p>
        Ci-joint la liste des TCs non livrés à moins de 24h avant leurs dates de deadline: <br>
        <?php
        $r = '';
        switch ($profil) {
          case 'ADMIN':
            $r =  'admin';
            break;
          case 'OPS':
            $r =  'ops';
            break;
          case 'OPS TERRAIN':
            $r =  'ops-terrain';
            return redirect()->to(session()->r);
            break;
        }
        ?>
        <a href="<?= base_url($r . "/livraisons/pregate") ?>">Listes des TCs</a>
      </p>
      <p>Cordialement,<br>
        <strong>Services IT POLY-TRANS SUARL</strong>
      </p>
    </main>
    <footer>
      <img src="<?= base_url('assets/img/logo.png') ?>" height="50px" width="auto" alt="">
      <div>©2023 - POLYTRANS APP</div>
    </footer>

  </div>
</body>

</html>