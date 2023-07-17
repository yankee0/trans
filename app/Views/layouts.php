<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Yankee">
  <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" />
  <title><?= $this->renderSection('title'); ?></title>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
  <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
</head>

<body class="position-relative">

  <div id="loadingOverlay" class="overlay">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Chargement en cours...</span>
    </div>
  </div>
  <div class="wrapper">
    <nav id="sidebar" class="sidebar js-sidebar">
      <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="<?= base_url(session()->r) ?>" target="_blank">
          <span class="align-middle"><?= APP_NAME ?></span><br>
          <span class="text-primary font-weight-bold text-sm"><?= session()->u['profil'] ?></span>
        </a>
        <ul class="sidebar-nav">
          <?php if (
            session()->r == 'admin'
            or (session()->r == 'facturation')
            or (session()->r == 'finance')
            or (session()->r == 'ops')
          ) : ?>
            <li class="sidebar-item <?= (session()->p == 'dashboard') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r) ?>">
                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
              </a>
            </li>
          <?php endif ?>
          <?php if (session()->r == 'admin') : ?>
            <li class="sidebar-header">
              Administration
            </li>

            <li class="sidebar-item <?= (session()->p == 'utilisateurs') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/utilisateurs') ?>">
                <i class="align-middle" data-feather="user"></i> <span class="align-middle">Utilisateurs</span>
              </a>
            </li>
          <?php endif ?>
          <?php if (
            session()->r == 'admin'
            or session()->r == 'flotte'
            // or session()->r == 'ops'
          ) : ?>

            <li class="sidebar-header">
              Flotte
            </li>

            <li class="sidebar-item <?= (session()->p == 'chauffeurs') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/chauffeurs') ?>">
                <i class="align-middle" data-feather="users"></i> <span class="align-middle">Chauffeurs</span>
              </a>
            </li>

            <li class="sidebar-item <?= (session()->p == 'camions') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/camions') ?>">
                <i class="align-middle" data-feather="truck"></i> <span class="align-middle">Camions</span>
              </a>
            </li>

            <li class="sidebar-item <?= (session()->p == 'remorques') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/remorques') ?>">
                <i class="align-middle" data-feather="truck"></i> <span class="align-middle">Remorques</span>
              </a>
            </li>
          <?php endif ?>

          <?php if (
            session()->r == 'admin'
            or session()->r == 'ops'
          ) : ?>
            <li class="sidebar-header">
              Opérations
            </li>

            <li class="sidebar-item <?= (session()->p == 'zones') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/zones') ?>">
                <i class="align-middle" data-feather="map-pin"></i> <span class="align-middle">Zones </span>
              </a>
            </li>

            <!-- <li class="sidebar-item <?= (session()->p == 'transferts') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/transferts') ?>">
                <i class="align-middle" data-feather="globe"></i> <span class="align-middle">Transferts</span>
              </a>
            </li> -->

            <li class="sidebar-item <?= (session()->p == 'livraisons') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/livraisons') ?>">
                <i class="align-middle" data-feather="box"></i> <span class="align-middle">Livraisons</span>
              </a>
            </li>

            <li class="sidebar-item <?= (session()->p == 'search') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/search') ?>">
                <i class="align-middle" data-feather="search"></i> <span class="align-middle">Recherches</span>
              </a>
            </li>
          <?php endif; ?>
          <?php if (
            session()->r == 'facturation'
          ) : ?>
            <li class="sidebar-header">
              Facturation
            </li>

            <li class="sidebar-item <?= (session()->p == 'clients') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/clients') ?>">
                <i class="align-middle" data-feather="users"></i> <span class="align-middle">Clients</span>
              </a>
            </li>

            <li class="sidebar-item <?= (session()->p == 'zones') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/zones') ?>">
                <i class="align-middle" data-feather="map-pin"></i> <span class="align-middle">Zones </span>
              </a>
            </li>

            <li class="sidebar-item <?= (session()->p == 'f-livraisons') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/livraisons') ?>">
                <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Factures livraisons</span>
              </a>
            </li>

            <!-- <li class="sidebar-item <?= (session()->p == 'f-transferts') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/transferts') ?>">
                <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Factures transferts</span>
              </a>
            </li> -->

          <?php endif; ?>
          <?php if (
            session()->r == 'finance'
          ) : ?>
            <li class="sidebar-header">
              Finances
            </li>
            <li class="sidebar-item <?= (session()->p == 'clients') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/clients') ?>">
                <i class="align-middle" data-feather="users"></i> <span class="align-middle">Clients</span>
              </a>
            </li>
            <li class="sidebar-item <?= (session()->p == 'f-liv') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/livraisons') ?>">
                <i class="align-middle" data-feather="box"></i> <span class="align-middle">Livraisons</span>
              </a>
            </li>



          <?php endif; ?>

          <?php if (
            session()->r == 'admin'
            or session()->r == 'finance'
            or session()->r == 'ops'
          ) : ?>
            <li class="sidebar-header">
              Statisques
            </li>

            <li class="sidebar-item <?= (session()->p == 'rapports') ? 'active' : '' ?>">
              <a class="sidebar-link" href="<?= base_url(session()->r . '/rapports') ?>">
                <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Rapports</span>
              </a>
            </li>
          <?php endif ?>


        </ul>
      </div>
    </nav>

    <div class="main ">
      <nav class="navbar navbar-expand navbar-light navbar-bg sticky-top">
        <a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

        <div class="navbar-collapse collapse">
          <ul class="navbar-nav navbar-align">
            <!-- <li class="nav-item dropdown">
              <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                <div class="position-relative">
                  <i class="align-middle" data-feather="bell"></i>
                  <span class="indicator">4</span>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                <div class="dropdown-menu-header">
                  4 New Notifications
                </div>
                <div class="list-group">
                  <a href="#" class="list-group-item">
                    <div class="row g-0 align-items-center">
                      <div class="col-2">
                        <i class="text-danger" data-feather="alert-circle"></i>
                      </div>
                      <div class="col-10">
                        <div class="text-dark">Update completed</div>
                        <div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
                        <div class="text-muted small mt-1">30m ago</div>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="list-group-item">
                    <div class="row g-0 align-items-center">
                      <div class="col-2">
                        <i class="text-warning" data-feather="bell"></i>
                      </div>
                      <div class="col-10">
                        <div class="text-dark">Lorem ipsum</div>
                        <div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
                        <div class="text-muted small mt-1">2h ago</div>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="list-group-item">
                    <div class="row g-0 align-items-center">
                      <div class="col-2">
                        <i class="text-primary" data-feather="home"></i>
                      </div>
                      <div class="col-10">
                        <div class="text-dark">Login from 192.186.1.8</div>
                        <div class="text-muted small mt-1">5h ago</div>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="list-group-item">
                    <div class="row g-0 align-items-center">
                      <div class="col-2">
                        <i class="text-success" data-feather="user-plus"></i>
                      </div>
                      <div class="col-10">
                        <div class="text-dark">New connection</div>
                        <div class="text-muted small mt-1">Christina accepted your request.</div>
                        <div class="text-muted small mt-1">14h ago</div>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="dropdown-menu-footer">
                  <a href="#" class="text-muted">Show all notifications</a>
                </div>
              </div>
            </li> -->
            <!-- <li class="nav-item dropdown">
              <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
                <div class="position-relative">
                  <i class="align-middle" data-feather="message-square"></i>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
                <div class="dropdown-menu-header">
                  <div class="position-relative">
                    4 New Messages
                  </div>
                </div>
                <div class="list-group">
                  <a href="#" class="list-group-item">
                    <div class="row g-0 align-items-center">
                      <div class="col-2">
                        <img src="img/avatars/avatar-5.jpg" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                      </div>
                      <div class="col-10 ps-2">
                        <div class="text-dark">Vanessa Tucker</div>
                        <div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu tortor.</div>
                        <div class="text-muted small mt-1">15m ago</div>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="list-group-item">
                    <div class="row g-0 align-items-center">
                      <div class="col-2">
                        <img src="img/avatars/avatar-2.jpg" class="avatar img-fluid rounded-circle" alt="William Harris">
                      </div>
                      <div class="col-10 ps-2">
                        <div class="text-dark">William Harris</div>
                        <div class="text-muted small mt-1">Curabitur ligula sapien euismod vitae.</div>
                        <div class="text-muted small mt-1">2h ago</div>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="list-group-item">
                    <div class="row g-0 align-items-center">
                      <div class="col-2">
                        <img src="img/avatars/avatar-4.jpg" class="avatar img-fluid rounded-circle" alt="Christina Mason">
                      </div>
                      <div class="col-10 ps-2">
                        <div class="text-dark">Christina Mason</div>
                        <div class="text-muted small mt-1">Pellentesque auctor neque nec urna.</div>
                        <div class="text-muted small mt-1">4h ago</div>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="list-group-item">
                    <div class="row g-0 align-items-center">
                      <div class="col-2">
                        <img src="img/avatars/avatar-3.jpg" class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
                      </div>
                      <div class="col-10 ps-2">
                        <div class="text-dark">Sharon Lessman</div>
                        <div class="text-muted small mt-1">Aenean tellus metus, bibendum sed, posuere ac, mattis non.</div>
                        <div class="text-muted small mt-1">5h ago</div>
                      </div>
                    </div>
                  </a>
                </div>
                <div class="dropdown-menu-footer">
                  <a href="#" class="text-muted">Show all messages</a>
                </div>
              </div>
            </li> -->
            <li class="nav-item dropdown">
              <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

              <a class="nav-link dropdown-toggle d-none d-sm-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="user"></i><span class="text-dark"><?= session()->u['nom'] ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item disabled" href="#"><i class="align-middle me-1" data-feather="user"></i> Profil</a>
                <a class="dropdown-item disabled" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modmdp"><i class="align-middle me-1" data-feather="lock"></i> Modifier mon mot de passe</a>
                <a class="dropdown-item disabled" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutMo"><i class="align-middle me-1" data-feather="power"></i> Se déconnecter</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <main class="content p-3">
        <div class="container-fluid">
          <?= $this->renderSection('main'); ?>
        </div>
      </main>

      <footer class="footer">
        <div class="container-fluid">
          <div class="row text-muted">
            <div class="col-6 text-start">
              <p class="mb-0">
                <a class="text-muted" href="<?= APP_WEB ?>" target="_blank"><strong><?= APP_NAME ?> v 2.0 </strong></a> - &copy;2023 by <a class="text-muted" href="https://github.com/yankee0" target="_blank"><strong>Yankee</strong></a>
              </p>
            </div>
            <div class="col-6 text-end">
              <ul class="list-inline">
                <li class="list-inline-item">
                  <a class="text-muted" href="mailto:yankeesuprem@gmail.com">Support</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <div class="modal fade" id="logoutMo" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="logmodtit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logmodtit">Déconnexion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Souhaitez-vous fermer cette session?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary text-dark" data-bs-dismiss="modal">Non, fermer</button>
          <button type="button" onclick="window.location='<?= base_url('deconnexion') ?>'" class="btn btn-primary">Oui, se déconnecter</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modmdp" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="mdptitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mdptitle">Modifier mon mot de passe</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?= form_open(base_url(session()->r) . '/modifier_mdp', ['id' => 'mdpForm']) ?>
          <div class="mb-3">
            <label for="mdpa" class="form-label">Mot de passe actuel</label>
            <input type="password" class="form-control" required name="mdpa" id="mdpa" placeholder="Entrez votre mot de passe actuel">
          </div>
          <div class="mb-3">
            <label for="mdp" class="form-label">Nouveau mot de passe</label>
            <input type="password" class="form-control" required value="<?= set_value('mdp', '') ?>" name="mdp" id="mdp" placeholder="Entrez le nouveau mot de passe">
          </div>
          <div class="mb-3">
            <label for="mdpc" class="form-label">Confirmer le mot de passe</label>
            <input type="password" class="form-control" required name="mdpc" id="mdpc" placeholder="Confirmez le mot de passe">
          </div>
          <?= csrf_field() ?>
          <?= form_close() ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" name="id" value="<?= session()->u['id'] ?>" form="mdpForm" class="btn btn-primary">Modifier</button>
        </div>
      </div>
    </div>
  </div>

  <?php if (session()->has('n')) : ?>
    <div class=" position-fixed bottom-0 end-0 p-2 notif">
      <div class="alert alert-<?= (session()->n) ? 'success' : 'danger' ?>" role="alert">
        <strong><?= (session()->n) ? 'Succès!' : 'Echec!' ?></strong> <?= session()->m ?>
      </div>
    </div>
  <?php endif ?>



  <div id="backTop" class=" position-fixed bottom-0 end-0 p-4 d-none">
    <a class="btn btn-primary btn-lg display-4" href="#" role="button"><i class="align-middle " data-feather="arrow-up"></i></a>
  </div>


  <script>
    function disablePageInteraction() {
      $('#loadingOverlay').show();
    }

    function enablePageInteraction() {
      $('#loadingOverlay').fadeOut();
    }
    $(document).ready(function() {
      disablePageInteraction();
    });
    $(window).on('load', function() {
      enablePageInteraction();
    });
  </script>
  <!-- <script>
    setTimeout(() => {
      // alert();
      $('#loadingOverlay').fadeOut();
    }, 5000)
  </script> -->

  <script>
    const momdp = new bootstrap.Modal(document.getElementById('modmdp'), options)
  </script>

  <script>
    const logout = new bootstrap.Modal(document.getElementById('logoutMo'), options)
  </script>

  <script>
    document.addEventListener('scroll', () => {
      const s = window.scrollY
      if (s > 300) {
        $('#backTop').addClass('d-block');
      } else {
        $('#backTop').removeClass('d-block');
      }
    })
  </script>

  <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>

</html>