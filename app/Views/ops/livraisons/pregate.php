<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Pregate livraisons
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<div class="row">
  <div class="col-md">
    <h1 class="h3 mb-3"><strong>Livraisons</strong> pregate</h1>
  </div>
  <div class="col-md d-flex justify-content-end">
    <div>
      <a class="btn btn-success" href="<?= base_url(session()->r . '/rapports/pregate') ?>" role="button">Rapport pregate</a>
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
                      <input type="date" class="form-control" value="<?= $facture['facture']['date_pg'] ?>" name="date_pg" id="date_pg" placeholder="Saisir la date">
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
    <?php foreach ($daily_pg as $pg) : ?>
      <div class="col-sm-6 col-xl-4">
        <div class="card flex-fill">
          <div class="card-body">
            <div>
              <?php if ($pg['livres'] != 0 and $pg['restants'] == 0 and $pg['encours'] == 0) : ?>
                <span class="badge bg-success">Lot achevé</span>
              <?php endif ?>
              <span class="badge bg-<?= $pg['paiement'] == 'OUI' ? 'success' : 'danger' ?>"><?= $pg['paiement'] == 'OUI' ? 'Payé le ' . $pg['date_paiement'] : 'Non payé' ?></span>
              <?php if ($pg['amendement'] == 'OUI') : ?>
                <span class="badge bg-warning">Amendement</span>
              <?php endif ?>
            </div>
            <div class="h2"><a href="<?= base_url(session()->r . '/search?search=' . $pg['bl']) ?>">Lot de <?= $pg['livres'] + $pg['encours'] + $pg['restants'] ?> conteneur(s) <i data-feather="link"></i></a></div>
            <hr>
            <div class="d-flex gap-3">
              <div class="flex-fill flex-grow-1">
                <div><small class=" text-black-50">Client:</small><br><?= $pg['nom'] ?></div>
                <div><small class=" text-black-50">Compagnie:</small><br><?= $pg['compagnie'] ?></div>
                <div><small class=" text-black-50">BL:</small><br><?= $pg['bl'] ?></div>
              </div>
              <div class="flex-fill flex-grow-1">
                <div><small class=" text-black-50">Nº facture:</small><br><a href="<?= base_url('factures/livraisons/details/' . $pg['id']) ?>" target="_blank"><?= $pg['id'] ?> <i data-feather="link"></i></a></div>
                <div><small class=" text-black-50">Date pregate:</small><br><?= $pg['date_pg'] ?></div>
                <div><small class=" text-black-50">Deadline:</small><br><?= $pg['deadline'] ?></div>
              </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
              <div>
                <span class="text-sm text-black-50">LIVRÉS</span> <br>
                <span class="fs-2 text-success"><?= $pg['livres'] ?></span>
              </div>
              <div>
                <span class="text-sm text-black-50">EN COURS</span> <br>
                <span class="fs-2 text-warning"><?= $pg['encours'] ?></span>
              </div>
              <div>
                <span class="text-sm text-black-50">ANNULÉS</span> <br>
                <span class="fs-2 text-danger"><?= $pg['annules'] ?></span>
              </div>
              <div>
                <span class="text-sm text-black-50">RESTANTS</span> <br>
                <span class="fs-2 text-info"><?= $pg['restants'] ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
<?php endif ?>


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