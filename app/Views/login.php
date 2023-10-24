<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Yankee" />
  <meta name="description" content="Application de gestion POLY-TRANS SUARL, une entreprise spécialisée dans Transit - Transport - Manutention - Consignation - Entreposage - Groupage - Conseils de haute qualité, basée au Sénégal, à Dakar." />
  <meta name="keywords" content="polytrans suarl, POLY-TRANS SUARL, gestion, matériaux plastiques, entreprise, Sénégal, Dakar" />
  <meta itemprop="address" content="44, Av Lamine GUEYE Immeuble BHT 2ème étage porte B, Dakar, Sénégal" />
  <meta itemprop="telephone" content="33 842 52 58" />
  <meta itemprop="faxNumber" content="33 842 52 58" />
  <meta itemprop="email" content="contact@poly-trans.sn" />
  <meta name="RC" content="SN-DKR-2027-B-1563" />
  <meta name="NINEA" content="006214332 2Y2" />
  <meta name="url" content="https://www.poly-trans.sn" />
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
  <title><?= APP_NAME ?> - Se connecter</title>
</head>

<body class="d-flex align-items-center container-fluid">
  <main class="container">
    <div class="row flex-md-row-reverse">
      <div class="col-md d-flex align-items-center">
        <div class="text-center flex-fill">
          <!-- <h1>Portail de connexion</h1>
          <p>Connecter-vous pour accèder à votre interface de gestion.</p>
          <div class="p-2 bg-opacity-25 bg-info text-info rounded mb-3">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
              <path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z"></path>
              <path d="M464 336a48 48 0 1 0 96 0 48 48 0 1 0-96 0zm72 112h-48c-4.4 0-8 3.6-8 8v272c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V456c0-4.4-3.6-8-8-8z"></path>
            </svg>
            Pour plus de sécurité, nous vous conseillons de modifier votre mot de passe plus souvent.
          </div> -->
          <img src="<?= base_url('assets/img/cake.svg') ?>" height="250px" class="m-auto" alt="Jo's">
          <h1>🥳HBD Jooo, Portail de connexion</h1>
          <p>Dieundeul gateau!🤣</p>
        </div>
      </div>
      <div class="col-md">
        <div class="card p-3">
          <div class="card-body">
            <div class="d-flex align-items-center gap-2 mb-3">
              <img src="<?= base_url('assets/img/logo.png') ?>" alt="<?= APP_NAME ?> - Logo" class="img-fluid" style="height: 30px;" />
              <h2 class="card-title mb-0 fs-3">POLY-TRANS SUARL</h2>
            </div>
            <form method="post" action="<?= base_url() ?>">
              <div class="text-center">
                <?php if (session()->has('n')) : ?>
                  <div class="p-2 bg-opacity-25 bg-<?= (session()->n) ? 'success' : 'danger' ?> rounded mb-2 text-<?= (session()->n) ? 'success' : 'danger' ?>">
                    <strong><?= (session()->n) ? 'Succès!' : 'Accès refusé!' ?></strong> <?= session()->m ?>
                  </div>
                <?php endif ?>
              </div>
              <div class="mb-3">
                <label class="form-label">Email<span class="text-danger">*</span></label>
                <input class="form-control form-control-lg" value="<?= set_value('email', '') ?>" type="email" name="email" placeholder="Votre email" required />
              </div>
              <div class="mb-3">
                <label class="form-label">Mot de passe<span class="text-danger">*</span></label>
                <input class="form-control form-control-lg" value="<?= set_value('mdp', '') ?>" type="password" name="mdp" placeholder="Votre mot de passe" required />

              </div>
              <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-lg btn-light">Effacer</button>
                <button type="submit" class="btn btn-lg btn-primary">Se connecter</button>
              </div>
            </form>
          </div>
        </div>
        <div class="mb-0 text-center">
          <a class="text-muted" href="<?= APP_WEB ?>" target="_blank"><strong><?= APP_NAME ?> v 2.3 </strong></a> - &copy;2023 by <a class="text-muted" href="https://github.com/yankee0" target="_blank"><strong>Yankee</strong></a>
        </div>
      </div>
    </div>
  </main>
</body>

</html>