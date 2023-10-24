<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Pregate livraisons
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<div class="row mb-3">
  <div class="col-md">
    <h1 class="h3 mb-3"><strong>Livraisons</strong> pregate</h1>
  </div>
  <div class="col-md d-flex justify-content-md-end">
    <div>
      <a class="btn btn-success" href="<?= base_url(session()->r . '/rapports/pregate') ?>" role="button"><i data-feather="file"></i> Rapport pregate</a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <form action="<?= base_url(session()->r . '/livraisons/pregate') ?>" method="post" class="d-flex gap-2">
          <input required type="search" value="<?= (isset($pregate)) ? $pregate : null ?>" class="form-control flex-grow-1" name="pregate" id="pregate" placeholder="Entrer le numéro du BL">
          <button class="btn btn-primary d-flex gap-2 justify-content-center align-items-center"><i data-feather="search"></i> <span class="d-none d-md-flex">Vérifier</span></button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php if (isset($pregate) and !empty($pregate)) : ?>
  <div class="row mb-3">
    <div class="col-12 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <h4 class="card-title">Résultat</h4>
        </div>
        <div class="card-body">
          <?php if (isset($facture) and !$facture) : ?>
            <div class="alert alert-warning" role="alert">
              Aucune facturation portant le numéro de BL saisi n'a été engeristrée. Si ce cas sagit d'une erreur d'enregistrement merci de signaler l'incidant aux personnes ayant les profils agréés. (Profil: FACTURATION)
            </div>
          <?php elseif (isset($facture) and sizeof($facture) > 0) : ?>
            <?php if ($facture['facture']['pregate'] == 'OUI') : ?>
              <div class="alert alert-success text-center" role="alert">
                <?= $facture['facture']['amendement'] == 'OUI' ? '<span class="fs-3">AMENDEMENT</span> <br />' : '' ?>
                Pregate enregistré le <?= $facture['facture']['date_pg'] ?>
              </div>
            <?php else : ?>
              <div class="alert alert-warning text-center" role="alert">
                Pregate non enregistré
              </div>
            <?php endif ?>
            <?php if (date('Y-m-d', strtotime($facture['facture']['deadline'])) <= date('Y-m-d', strtotime('+5days'))) : ?>
              <div class="alert alert-warning text-center" role="alert">
                <strong>Attention!</strong> La date de deadline est dépassée ou est dans moins de 5 jours.
              </div>
            <?php endif ?>
            <div class="display-6">BL <span class="text-primary"><?= $facture['facture']['bl'] ?></span></div>
            <div class="fs-3">Client <span class="text-primary"><?= $facture['facture']['client_nom'] ?></span></div>
            <div class="fs-3">Compagnie <span class="text-primary"><?= $facture['facture']['compagnie'] ?></span></div>
            <div class="fs-3">Deadline <span class="text-primary"><?= $facture['facture']['deadline'] ?></span></div>
            <?php
            $count = 0;
            foreach ($facture['zones'] as $zone) {
              $count += count($zone['c_20']) + count($zone['c_40']);
            }
            ?>
            <div class="fs-3">Lot de <span class="text-primary"><?= $count ?> conteneur<?= ($count) > 1 ? 's' : '' ?></span> facturé le <span class="text-primary"><?= $facture['facture']['date_creation'] ?></span></div>
            <hr>
            <div class="row">
              <?php foreach ($facture['zones'] as $zone) : ?>
                <div class="col-md-6 col-xxl-4">
                  <div class="fs-3"><?= $zone['designation'] ?> de <?= count($zone['c_20']) + count($zone['c_40']) ?> conteneur<?= count($zone['c_40']) + count($zone['c_20']) > 1 ? 's' : '' ?></div>
                  <div class="mb-3 text-muted">Adresse exacte: <span class="text-primary"><?= empty($zone['adresse']) ? '<span class="badge bg-dark">INDÉFINIE</span>' : $zone['adresse'] ?></span></div>
                  <div class="row mb-3">
                    <div class="col-12 text-muted"><strong class="text-primary"><?= count($zone['c_20']) ?></strong> conteneur<?= count($zone['c_20']) > 1 ? 's' : '' ?> de 20':</div>
                    <?php if (empty($zone['c_20'])) : ?>
                      <span><i>Aucun</i></span>
                    <?php endif ?>
                    <?php foreach ($zone['c_20'] as $c) : ?>
                      <div class="col-sm-4 text-sm"><?= $c['conteneur'] ?></div>
                    <?php endforeach ?>
                  </div>
                  <div class="row">
                    <div class="col-12 text-muted"><strong class="text-primary"><?= count($zone['c_40']) ?></strong> conteneur<?= count($zone['c_40']) > 1 ? 's' : '' ?> de 40':</div>
                    <?php if (empty($zone['c_40'])) : ?>
                      <span><i>Aucun</i></span>
                    <?php endif ?>
                    <?php foreach ($zone['c_40'] as $c) : ?>
                      <div class="col-sm-4 text-sm"><?= $c['conteneur'] ?></div>
                    <?php endforeach ?>
                  </div>
                </div>
              <?php endforeach ?>
            </div>

            <div class="d-flex align-items-center justify-content-center mt-3">
              <button class="btn btn-primary" href="#" role="button" data-bs-toggle="modal" data-bs-target="#modalId">Informations pregate</button>
            </div>
            <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">pregate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <?= form_open(
                      base_url(session()->r . '/livraisons/pregate/' . $facture['facture']['id']),
                      [
                        'id' => 'formP'
                      ]
                    ) ?>
                    <div class="form-check form-switch">
                      <input class="form-check-input" <?= $facture['facture']['pregate'] == 'OUI' ? 'checked' : '' ?> name="pregate" type="checkbox" id="pregateCatch">
                      <label class="form-check-label" for="pregateCatch">pregate reçu</label>
                    </div>
                    <div class="mb-3">
                      <label for="date_pg" class="form-label">Date de réception</label>
                      <input type="date" class="form-control" value="<?= $facture['facture']['date_pg'] ?>" max="<?= date('Y-m-d H:i:s') ?>" name="date_pg" id="date_pg" placeholder="Saisir la date">
                    </div>
                    <div class="mb-3">
                      <label for="deadline" class="form-label">Deadline</label>
                      <input type="date" class="form-control" value="<?= $facture['facture']['deadline'] ?>" name="deadline" id="deadline" placeholder="Saisir la date">
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" name='amendement' <?= $facture['facture']['amendement'] == 'OUI' ? 'checked' : '' ?> value="OUI" type="checkbox" id="amendement">
                      <label class="form-check-label" for="amendement">Amendement</label>
                    </div>
                    <?= csrf_field() ?>
                    <?= form_close() ?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" form='formP' name="bl" value="<?= $facture['facture']['bl'] ?>" class="btn btn-primary">Enregistrer</button>
                  </div>
                </div>
              </div>
            </div>
            <script>
              const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
            </script>

          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
<?php else : ?>
  <div class="row">
    <h2>Enregistrements</h2>
  </div>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link d-flex align-items-center justify-content-center gap-2 " id="dernier-enregistrement" data-bs-toggle="tab" data-bs-target="#last-recs" type="button" role="tab" aria-controls="last-recs" aria-selected="false"><i data-feather="clock"></i> Derniers enregistrement</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link d-flex align-items-center justify-content-center gap-2 active" id="alerts-dl" data-bs-toggle="tab" data-bs-target="#alertdl" type="button" role="tab" aria-controls="alertdl" aria-selected="true"><i data-feather="alert-triangle"></i> Deadline dans moins de 48h</button>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div class="tab-pane" id="last-recs" role="tabpanel" aria-labelledby="dernier-enregistrement">
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
                <?php foreach ($pg as $p) : ?>
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
                            <div><small class=" text-black-50">Date pregate:</small><br><?= date('d/m/Y', strtotime($p['date_pg'])) ?></div>
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
                            <?php foreach ($pg as $p) : ?>
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
    </div>
    <div class="tab-pane  active" id="alertdl" role="tabpanel" aria-labelledby="alerts-dl">
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
                    <?php foreach ($pg as $p) : ?>
                      <?php if ($p['deadline'] <= date('Y-m-d', strtotime('+ 2 days'))) : ?>
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
                      <?php endif ?>
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
<?php endif ?>

<!-- annuler livraisons -->
<div class="modal fade" id="abordDelv" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="abdelvti" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="abdelvti">Annulation de livraison</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(
          base_url(session()->r . '/livraisons/abord'),
          [
            'id' => 'abDeliveryForm'
          ]
        ) ?>
        Annuler la livraison <span class="text-primary" id="abDelivery"></span> ?<br>
        Quel est le motif de l'annulation:
        <div>
          <textarea class="form-control" name="motif" rows="3"></textarea>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="abDeliveryForm" id="abDeliveryBtn" name="id" class="btn btn-primary">Annuler la livraison</a>
      </div>
    </div>
  </div>
</div>
<script>
  $('.abordDelv').click(function(e) {
    e.preventDefault();
    $('#abDelivery').html($(this).attr('data-container'));
    $('#abDeliveryBtn').val($(this).val());
  });
</script>
<script>
  const myModalAbordDeliv = new bootstrap.Modal(document.getElementById('abordDelv'), options)
</script>

<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
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
        'pdfHtml5',
      ],
      language: {
        decimal: ',',
        thousands: '.'
      },
    });
  });
</script>



<?= $this->endSection(); ?>