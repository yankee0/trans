<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Preget livraisons
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Livraisons</strong> Preget</h1>
<div class="row">

  <div class="col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <form action="<?= base_url(session()->r . '/livraisons/preget') ?>" method="post" class="d-flex gap-2">
          <input type="search" value="<?= (isset($preget)) ? $preget : '' ?>" class="form-control flex-grow-1" name="preget" id="preget" placeholder="Entrer le numéro du BL">
          <button class="btn btn-primary d-flex gap-2 justify-content-center align-items-center"><i data-feather="search"></i> <span class="d-none d-md-flex">Vérifier</span></button>
        </form>
      </div>
    </div>
  </div>
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
          <?php if ($facture['facture']['preget'] == 'OUI') : ?>
            <div class="alert alert-success text-center" role="alert">
              <?= $facture['facture']['amendement'] == 'OUI' ? '<span class="fs-3">AMENDEMENT</span> <br />' : '' ?>
              Preget enregistré le <?= $facture['facture']['date_pg'] ?>
            </div>
          <?php else : ?>
            <div class="alert alert-warning text-center" role="alert">
              Preget non enregistré
            </div>
          <?php endif ?>
          <?php if(date('Y-m-d',strtotime($facture['facture']['deadline'])) <= date('Y-m-d',strtotime('+5days'))) : ?>
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
                <div class="fs-3"><?= $zone['designation'] ?> de <?= count($zone['c_20']) + count($zone['c_40']) ?></div>
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
            <button class="btn btn-primary" href="#" role="button" data-bs-toggle="modal" data-bs-target="#modalId">Informations PREGET</button>
          </div>
          <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalTitleId">Preget</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <?= form_open(
                    base_url(session()->r . '/livraisons/preget/' . $facture['facture']['id']),
                    [
                      'id' => 'formP'
                    ]
                  ) ?>
                  <div class="form-check form-switch">
                    <input required class="form-check-input" <?= $facture['facture']['preget'] == 'OUI' ? 'checked' : '' ?> name="preget" type="checkbox" id="pregetCatch">
                    <label class="form-check-label" for="pregetCatch">Preget reçu</label>
                  </div>
                  <div class="mb-3">
                    <label for="date_pg" class="form-label">Date de réception</label>
                    <input required type="date" class="form-control" value="<?= $facture['facture']['date_pg'] ?>" name="date_pg" id="date_pg" placeholder="Saisir la date">
                  </div>
                  <div class="mb-3">
                    <label for="deadline" class="form-label">Deadline</label>
                    <input required type="date" class="form-control" value="<?= $facture['facture']['deadline'] ?>" name="deadline" id="deadline" placeholder="Saisir la date">
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
      <div class="card-footer text-muted d-flex align-items-center justify-content-end">
      </div>
    </div>
  </div>
</div>




<?= $this->endSection(); ?>