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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" />
  <title><?= APP_NAME ?> - Se connecter</title>
  <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
</head>

<body>
  <main class="d-flex w-100">
    <div class="container d-flex flex-column overflow-hidden">
      <div class="row vh-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
          <div class="d-table-cell align-middle">

            <div class="card">
              <div class="card-body">
                <div class="m-sm-4">
                  <div class="text-center">
                    <img src="<?= base_url('assets/img/logo.png') ?>" alt="<?= APP_NAME ?> - Logo" class="img-fluid" width="132" height="132" />
                  </div>
                  <div class="text-center mt-3">
                    <!-- <h1 class="h2 text-primary"><?= APP_NAME ?> APP</h1> -->
                  </div>
                  <div class="text-center mt-3">
                    <?php if (session()->has('n')) : ?>
                      <div class="alert text-<?= (session()->n) ? 'success' : 'danger' ?>" role="alert">
                        <strong><?= (session()->n) ? 'Succès!' : 'Echec!' ?></strong> <?= session()->m ?>
                      </div>
                    <?php endif ?>
                  </div>
                  <form method="post" action="<?= base_url() ?>">
                    <div class="mb-3">
                      <label class="form-label">Email<span class="text-danger">*</span></label>
                      <input class="form-control form-control-lg" value="<?= set_value('email', '') ?>" type="email" name="email" placeholder="Votre email" required />
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Mot de passe<span class="text-danger">*</span></label>
                      <input class="form-control form-control-lg" value="<?= set_value('mdp', '') ?>" type="password" name="mdp" placeholder="Votre mot de passe" required />

                    </div>
                    <div class="text-center mt-3">
                      <button type="submit" class="btn btn-lg btn-primary">Se connecter</button>
                      <!-- <button type="submit" class="btn btn-lg btn-primary">Sign in</button> -->
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="text-center">
              <span class="m-auto text-center text-muted">Poly-Trans App V 2.0 - ©2023 by <a target="_blank" class="text-muted" href="https://www.github.com/yankee0">Yankee</a></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="<?= base_url('assets/js/app.js') ?>"></script>

</body>

</html>