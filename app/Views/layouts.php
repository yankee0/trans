<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Yankee">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" />
  <title><?= $this->renderSection('title'); ?></title>
  <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
  <div class="wrapper">
    <nav id="sidebar" class="sidebar js-sidebar">
      <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="<?= base_url(session()->r) ?>" target="_blank">
          <span class="align-middle"><?= APP_NAME ?></span>
        </a>

        <ul class="sidebar-nav">

          <li class="sidebar-item active">
            <a class="sidebar-link" href="<?= base_url(session()->r) ?>">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            </a>
          </li>

          <li class="sidebar-header">
            Administration
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="<?= base_url(session()->r . '/utilisateurs') ?>">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle">Utilisateurs</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="<?= base_url(session()->r . '/zones') ?>">
              <i class="align-middle" data-feather="map-pin"></i> <span class="align-middle">Zones </span>
            </a>
          </li>

          <li class="sidebar-header">
            Flotte
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="<?= base_url(session()->r . '/chauffeurs') ?>">
              <i class="align-middle" data-feather="users"></i> <span class="align-middle">Chauffeurs</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="<?= base_url(session()->r . '/camions') ?>">
              <i class="align-middle" data-feather="truck"></i> <span class="align-middle">Camions</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="<?= base_url(session()->r . '/remorques') ?>">
              <i class="align-middle" data-feather="truck"></i> <span class="align-middle">Remorques</span>
            </a>
          </li>

          <li class="sidebar-header">
            Opérations
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="<?= base_url(session()->r . '/livraisons') ?>">
              <i class="align-middle" data-feather="box"></i> <span class="align-middle">Livraisons</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="<?= base_url(session()->r . '/transferts') ?>">
              <i class="align-middle" data-feather="globe"></i> <span class="align-middle">Transferts</span>
            </a>
          </li>

          <li class="sidebar-header">
            Facturation
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="<?= base_url(session()->r . '/factures/livraisons') ?>">
              <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Factures livraisons</span>
            </a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="<?= base_url(session()->r . '/factures/transferts') ?>">
              <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Factures transferts</span>
            </a>
          </li>


          <li class="sidebar-header">
            Rapports
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="<?= base_url(session()->r . '/rapports/livraisons') ?>">
              <i class="align-middle" data-feather="box"></i> <span class="align-middle">Livraisons</span>
            </a>
          </li>

          <li class="sidebar-item mb-5">
            <a class="sidebar-link" href="<?= base_url(session()->r . '/rapports/transferts') ?>">
              <i class="align-middle" data-feather="globe"></i> <span class="align-middle">Transferts</span>
            </a>
          </li>

        </ul>
      </div>
    </nav>

    <div class="main">
      <nav class="navbar navbar-expand navbar-light navbar-bg">
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
                <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="lock"></i> Modifier mon mot de passe</a>
                <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url('deconnexion') ?>"><i class="align-middle me-1" data-feather="power"></i> Se déconnecter</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <main class="content">
        <?= $this->renderSection('main'); ?>
      </main>

      <footer class="footer">
        <div class="container-fluid">
          <div class="row text-muted">
            <div class="col-6 text-start">
              <p class="mb-0">
                <a class="text-muted" href="<?= APP_WEB ?>" target="_blank"><strong><?= APP_NAME ?></strong></a> - <a class="text-muted" href="https://github.com/yankee0" target="_blank"><strong>DevTeam</strong></a> &copy;
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

  <script src="<?= base_url('assets/js/app.js') ?>"></script>

</body>

</html>