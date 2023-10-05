<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
<?= isset($name) ? $name : 'Rapports pregate' ?>
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>

<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url(session()->r . '/rapports') ?>">Rapports</a></li>
    <li class="breadcrumb-item active" aria-current="page">Rapports pregates</li>
  </ol>
</nav>
<h1 class="h3 mb-3"><strong>Rapports</strong> pregates</h1>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Générer un rapport des pregates enregistrés</h5>
        <?= form_open() ?>
        <?= csrf_field() ?>
        <div class="row">
          <div class="col-md mb-3">
            <label for="dateFrom" class="form-label">Du</label>
            <input type="date" class="form-control" value="<?= isset($from) ? $from : date('Y-m') . '-01' ?>" name="from" required id="dateFrom" placeholder="Sélectionnez la date">
          </div>
          <div class="col-md mb-3">
            <label for="dateTo" class="form-label">Au</label>
            <input type="date" class="form-control" value="<?= isset($to) ? $to : date('Y-m-d') ?>" name="to" required id="dateTo" placeholder="Sélectionnez la date">
          </div>
          <div class="col-md mb-3 d-flex flex-column justify-content-end">
            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center gap-3">
              <i class="align-middle" data-feather="clipboard"></i>
              <span>Générer un rapport</span>
            </button>
          </div>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>
<?php if (isset($name)) : ?>
  <div class="row">
    <div class="col-12">
      <div class="fs-1"><?= $name ?></div>
      <div class="fs-2 mb-3 text-opacity-75"><?= count($data) ?> pregate<?= count($data) > 1 ? 's' : '' ?> enregistré<?= count($data) > 1 ? 's' : '' ?></div>
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link d-flex align-items-center justify-content-center gap-2 active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><i data-feather="table"></i> Tableau</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link d-flex align-items-center justify-content-center gap-2" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"> <i data-feather="layers"></i> Bloc</button>
        </li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="row pt-3">
            <?php foreach ($data as $p) : ?>
              <div class="col-sm-6 col-xl-4">
                <div class="card flex-fill">
                  <div class="card-body">
                    <div>
                      <?php if ($p['livres'] != 0 and $p['restants'] == 0 and $p['encours'] == 0) : ?>
                        <span class="badge bg-success">Lot achevé</span>
                      <?php endif ?>
                      <span class="badge bg-<?= $p['paiement'] == 'OUI' ? 'success' : 'danger' ?>"><?= $p['paiement'] == 'OUI' ? 'Payé le ' . $p['date_paiement'] : 'Non payé' ?></span>
                      <?php if ($p['amendement'] == 'OUI') : ?>
                        <span class="badge bg-warning">Amendement</span>
                      <?php endif ?>
                    </div>
                    <div class="h2"><a href="<?= base_url(session()->r . '/search?search=' . $p['bl']) ?>">Lot de <?= $p['livres'] + $p['encours'] + $p['restants'] ?> conteneur(s) <i data-feather="link"></i></a></div>
                    <hr>
                    <div class="d-flex gap-3">
                      <div class="flex-fill flex-grow-1">
                        <div><small class=" text-black-50">Client:</small><br><?= $p['nom'] ?></div>
                        <div><small class=" text-black-50">Compagnie:</small><br><?= $p['compagnie'] ?></div>
                        <div><small class=" text-black-50">BL:</small><br><?= $p['bl'] ?></div>
                      </div>
                      <div class="flex-fill flex-grow-1">
                        <div><small class=" text-black-50">Nº facture:</small><br><a href="<?= base_url('factures/livraisons/details/' . $p['id']) ?>" target="_blank"><?= $p['id'] ?> <i data-feather="link"></i></a></div>
                        <div><small class=" text-black-50">Date pregate:</small><br><?= date('d/m/Y', strtotime(date('d/m/Y', strtotime($p['date_pg'])))) ?></div>
                        <div><small class=" text-black-50">Deadline:</small><br><span class="text-<?= (!empty($p['deadline']) and date('Y-m-d', strtotime($p['deadline'])) <= date('Y-m-d', strtotime('+2days'))) ? 'danger' : 'success' ?>"><?= date('d/m/Y', strtotime($p['deadline'])) ?></span></div>
                      </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                      <div>
                        <span class="text-sm text-black-50">LIVRÉS</span> <br>
                        <span class="fs-2 text-success"><?= $p['livres'] ?></span>
                      </div>
                      <div>
                        <span class="text-sm text-black-50">EN COURS</span> <br>
                        <span class="fs-2 text-warning"><?= $p['encours'] ?></span>
                      </div>
                      <div>
                        <span class="text-sm text-black-50">ANNULÉS</span> <br>
                        <span class="fs-2 text-danger"><?= $p['annules'] ?></span>
                      </div>
                      <div>
                        <span class="text-sm text-black-50">RESTANTS</span> <br>
                        <span class="fs-2 text-info"><?= $p['restants'] ?></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach ?>
          </div>
        </div>
        <div class="tab-pane active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="row pt-3">
            <div class="col d-flex">
              <div class="card flex-fill">
                <div class="card-body">
                  <div class=" table-responsive">
                    <table class="table table-hover my-0">
                      <thead>
                        <tr>
                          <th>Conteneur</th>
                          <th>Type</th>
                          <th>BL</th>
                          <th>Compagnie</th>
                          <th>Client</th>
                          <th>Paiement</th>
                          <th>État</th>
                          <th>Date pregate</th>
                          <th>Deadline</th>
                          <th>Zone de destination</th>
                          <th>Chauffeur</th>
                          <th>Adresse exacte</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($data as $p) : ?>
                          <?php foreach ($p['zones'] as $z) : ?>
                            <?php foreach ($z['tc'] as $tc) : ?>
                              <tr>
                                <td><?= $tc['conteneur'] ?></td>
                                <td><?= $tc['type'] ?></td>
                                <td><?= $p['bl'] ?></td>
                                <td><?= $p['compagnie'] ?></td>
                                <td><?= $p['nom'] ?></td>
                                <td>
                                  <?= $p['paiement'] == 'OUI' ? '<span class="badge bg-success">OUI</span>' : '<span class="badge bg-warning">NON</span>' ?>
                                </td>
                                <td>
                                  <?php
                                  if ($p['pregate'] == 'OUI') {
                                    switch ($tc['infos']['etat']) {
                                      case 'MISE À TERRE':
                                  ?>
                                        <span class="badge bg-dark"><?= $tc['infos']['etat'] ?></span>
                                      <?php
                                        break;
                                      case 'SUR PLATEAU':
                                      ?>
                                        <span class="badge bg-info"><?= $tc['infos']['etat'] ?></span>
                                      <?php
                                        break;
                                      case 'LIVRÉ':
                                      ?>
                                        <span class="badge bg-success"><?= $tc['infos']['etat'] ?></span>
                                      <?php
                                        break;
                                      case 'ANNULÉ':
                                      ?>
                                        <span class="badge bg-danger"><?= $tc['infos']['etat'] ?></span>
                                      <?php
                                        break;
                                      case 'EN COURS':
                                      ?>
                                        <span class="badge bg-warning"><?= $tc['infos']['etat'] ?></span>
                                  <?php
                                        break;

                                      default:
                                        echo 'Error 500';
                                        break;
                                    }
                                  } else {
                                    echo '-';
                                  }
                                  ?>
                                </td>
                                <td><?= $p['pregate'] == 'OUI' ? date('d/m/Y', strtotime($p['date_pg'])) : '<span class="badge bg-dark">NON REÇU</span>' ?></td>
                                <td><?= date('d/m/Y', strtotime($p['deadline'])) ?></td>
                                <td><?= $z['designation'] ?></td>
                                <td><?= $tc['infos']['nom_ch_aller'] ?></td>
                                <td><?= !(empty($z['adresse'])) ? $z['adresse'] : '<span class="badge bg-dark">INCONNUE</span>' ?></td>
                                <td>
                                  <div class="d-flex justify-content-around">
                                    <button type="button" value="<?= $tc['infos']['id'] ?>" data-container="<?= $tc['conteneur'] ?>" class="update btn border-0 text-danger abordDelv border-0 <?= $tc['infos']['etat'] == 'ANNULÉ' ? 'disabled' : '' ?>" title="Annuler" data-bs-toggle="modal" data-bs-target="#abordDelv"><i cla data-feather="x"></i></button>
                                    <a role="button" href="<?= base_url(session()->r . '/livraisons/infos/' . $p['bl'] . '/' . $tc['conteneur']) ?>" class="update btn border-0 text-info" title="Informations"><i cla data-feather="info"></i></a>
                                  </div>
                                </td>
                              </tr>
                            <?php endforeach ?>
                          <?php endforeach ?>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<?php endif ?>

<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script>
  $(document).ready(function() {
    $('.table').DataTable({
      responsive: true,
      ordering: false,
      dom: 'Bfrtip',
      buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        // 'pdfHtml5',
        {
          extend: "pdfHtml5"
        }
      ],
      language: {
        decimal: ',',
        thousands: '.'
      },
    });
  });
</script>



<?= $this->endSection(); ?>