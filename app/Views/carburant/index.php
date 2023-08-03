<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Gestion du carburant
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Gestion</strong> Carburant</h1>
<div class="row">
  <div class="col-sm col-md-2 col-lg-4 col-xl-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><strong>Solde de la carte</strong></h5>
        <div class="fs-2"><?= $carte['solde'] ?> <strong>FCFA</strong></div>
        <div class="mb-2">
          <?php if (empty($lastRec)) : ?>
            <small>Pas de recharge enregistrée</small>
          <?php else : ?>
            <small class="text-muted">Dernier ravitallement de <?= $lastRec['montant'] ?> par <?= $lastRec['nom'] ?> le <?= $lastRec['created_at'] ?></small>
          <?php endif ?>  
        </div>
        <div class="d-flex justify-content-end">
          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#recharge">Recharger la carte</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><strong>Nouveau ravitaillement</strong></h5>
        <?= form_open() ?>
        <div class="row">
          <div class="col-md col-lg-4">

            <div class="mb-3">
              <label for="created_at" class="form-label">Date de ravitaillement <span class="text-danger"><strong>*</strong></span></label>
              <input type="datetime-local" class="form-control" name="created_at" id="created_at" value="<?= set_value('created_at') ?>" placeholder="Date de ravitaillent" required>
            </div>

            <div class="mb-3">
              <label for="conducteur" class="form-label">Conducteur <span class="text-danger"><strong>*</strong></span></label>
              <input type="text" class="form-control" name="conducteur" id="conducteur" value="<?= set_value('conducteur') ?>" placeholder="Nom complet du conducteur">
            </div>

          </div>
          <div class="col-md col-lg-4">

            <div class="mb-3">
              <label for="type_veh" class="form-label">Type de véhicule <span class="text-danger"><strong>*</strong></span></label>
              <select class="form-select" name="type_veh" id="type_veh">
                <option selected value="" hidden>Selectionnez le type de véhicule</option>
                <option <?= set_select('type_veh', 'TRACTEUR') ?>>Tracteur</option>
                <option <?= set_select('type_veh', 'MOTO') ?>>Moto</option>
                <option <?= set_select('type_veh', 'VOITURE PARTICULIER') ?>>Voiture particulier</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="conducteur" class="form-label">Immatriculation du véhicule </label>
              <input type="text" class="form-control text-uppercase" name="conducteur" id="conducteur" value="<?= set_value('conducteur') ?>" placeholder="AB 1234 CD">
            </div>

          </div>
          <div class="col-md col-lg-4">

            <div class="mb-3">
              <label for="type_carb" class="form-label">Carburant <span class="text-danger"><strong>*</strong></span></label>
              <select class="form-select" name="type_carb" id="type_carb">
                <option selected value="" hidden>Sélectionnez le type</option>
                <option <?= set_select('type_carb', 'ESSENCE') ?>>ESSENCE - 990 FCFA par litre</option>
                <option <?= set_select('type_carb', 'GASOIL') ?>>GASOIL - 755 FCFA par litre</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="conducteur" class="form-label">Nombre de litres <span class="text-danger"><strong>*</strong></span></label>
              <input type="number" min="0" class="form-control" name="conducteur" id="conducteur" value="<?= set_value('conducteur') ?>" placeholder="Nombre de litre">
            </div>
          </div>
          <div class="col-12">
            <button type="reset" class="btn btn-light">Effacer</button>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><strong>Liste des ravitaillements</strong></h5>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Date de ravitaillement</th>
                <th scope="col">Conducteur</th>
                <th scope="col">Type de véhicule</th>
                <th scope="col">Carburant</th>
                <th scope="col">Nombre de litres</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal recharge -->

<div class="modal fade" id="recharge" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="rechargeModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rechargeModalTitle">Recharge</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(
          base_url(session()->r.'/carburant/recharge'),
          [
            'id' => 'rechargeForm'
          ]
        ) ?>
        <div class="mb-3">
          <label for="montant" class="form-label">Montant</label>
          <input type="number" min="0" class="form-control" name="montant" id="montant" placeholder="Montant de la recharge" required>
        </div>
        <div class="mb-3">
          <label for="created_at" class="form-label">Date de recharge</label>
          <input type="datetime-local" min="0" class="form-control" name="created_at" id="created_at" placeholder="Date de la recharge" required>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="rechargeForm" class="btn btn-success">Recharger la carte</button>
      </div>
    </div>
  </div>
</div>



<script>
  const recharge = new bootstrap.Modal(document.getElementById('recharge'), options)
</script>
<?= $this->endSection(); ?>