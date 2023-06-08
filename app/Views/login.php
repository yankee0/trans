<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Yankee">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" />
  <title><?= APP_NAME ?> - Se connecter</title>
  <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
  <main class="d-flex w-100">
    <div class="container d-flex flex-column">
      <div class="row vh-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
          <div class="d-table-cell align-middle">

            <div class="card">
              <div class="card-body">
                <div class="m-sm-4">
                  <div class="text-center">
                    <img src="<?= base_url('assets/img/logo.png') ?>" alt="<?= APP_NAME ?> - Logo" class="img-fluid" width="132" height="132" />
                  </div>
                  <div class="text-center mt-4">
                    <h1 class="h2 text-primary"><?= APP_NAME ?> APP</h1>
                  </div>
                  <form method="post" action="<?= base_url() ?>">
                    <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input class="form-control form-control-lg" value="<?= set_value('email','') ?>" type="email" name="email" placeholder="Votre email" required />
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Mot de passe</label>
                      <input class="form-control form-control-lg" value="<?= set_value('mdp','') ?>" type="password" name="mdp" placeholder="Votre mot de passe" required />

                    </div>
                    <div class="text-center mt-3">
                      <button type="submit" class="btn btn-lg btn-primary">Se connecter</button>
                      <!-- <button type="submit" class="btn btn-lg btn-primary">Sign in</button> -->
                    </div>
                  </form>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="js/app.js"></script>

</body>

</html>