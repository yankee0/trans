<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Gestion du carburant
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Gestion</strong> Carburant</h1>

<div class="row">

  <div class="col-sm col-md-2 col-lg-4 ">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><strong>Solde de la carte</strong></h5>
        <div class="fs-2 <?= $carte['solde'] <= 70000 ? 'text-danger' : 'text-success' ?>"><span class="num"><?= $carte['solde'] ?></span> <strong>FCFA</strong></div>
        <div class="mb-2">
          <?php if (empty($recs)) : ?>
            <small>Pas de recharge enregistrée</small>
          <?php else : ?>
            <small class="text-muted">Dernier ravitallement de <span class="num"><?= $recs[0]['montant'] ?></span> de FCFA par <?= $recs[0]['nom'] ?> le <?= $recs[0]['created_at'] ?></small>
          <?php endif ?>
        </div>
        <div class="d-flex justify-content-end">
          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#recharge">Recharger la carte</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if (session()->r == 'admin') : ?>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><strong>Liste des rechargements</strong></h5>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Date de recharge</th>
                  <th>Montant</th>
                  <th>Auteur de l'enregistrement</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($recs as $rec) : ?>
                  <tr>
                    <td><?= $rec['created_at'] ?></td>
                    <td><?= $rec['montant'] ?></td>
                    <td><?= $rec['nom'] ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif ?>
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
              <input required type="datetime-local" class="form-control" name="created_at" id="created_at" value="<?= set_value('created_at') ?>" placeholder="Date de ravitaillent" required>
            </div>

            <div class="mb-3">
              <label for="conducteur" class="form-label">Conducteur <span class="text-danger"><strong>*</strong></span></label>
              <input required type="text" class="form-control" name="conducteur" id="conducteur" value="<?= set_value('conducteur') ?>" placeholder="Nom complet du conducteur">
            </div>

          </div>
          <div class="col-md col-lg-4">

            <div class="mb-3">
              <label for="type_veh" class="form-label">Type de véhicule <span class="text-danger"><strong>*</strong></span></label>
              <select required class="form-select" name="type_veh" id="type_veh">
                <option selected value="" hidden>Selectionnez le type de véhicule</option>
                <option <?= set_select('type_veh', 'TRACTEUR') ?>>Tracteur</option>
                <option <?= set_select('type_veh', 'MOTO') ?>>Moto</option>
                <option <?= set_select('type_veh', 'VOITURE PARTICULIER') ?>>Voiture particulier</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="imm" class="form-label">Immatriculation du véhicule </label>
              <input type="text" class="form-control text-uppercase" name="imm" id="imm" value="<?= set_value('imm') ?>" placeholder="AB 1234 CD">
            </div>

          </div>
          <div class="col-md col-lg-4">

            <div class="mb-3">
              <label for="type_carb" class="form-label">Carburant <span class="text-danger"><strong>*</strong></span></label>
              <select required class="form-select" name="type_carb" id="type_carb">
                <option selected value="" hidden>Sélectionnez le type</option>
                <option value="ESSENCE" <?= set_select('type_carb', 'ESSENCE') ?>>ESSENCE - 990 FCFA par litre</option>
                <option value="GASOIL" <?= set_select('type_carb', 'GASOIL') ?>>GASOIL - 755 FCFA par litre</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="litres" class="form-label">Nombre de litres <span class="text-danger"><strong>*</strong></span></label>
              <input required type="number" min="1" step="0.1" max="500" class="form-control" name="litres" id="litres" value="<?= set_value('litres') ?>" placeholder="Nombre de litre">
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
        <h5 class="card-title"><strong>Liste des rechargements</strong></h5>
        <div class="table-responsive">
          <table id="ravitaillements" class="table table-hover">
            <thead>
              <tr>
                <th>Date</th>
                <th>Carburant</th>
                <th>Prix</th>
                <th>Nombre de litres</th>
                <th>Montant</th>
                <th>Conducteur</th>
                <th>Véhicule</th>
                <th>Immatriculation</th>
                <th>Auteur de l'enregistrement</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($ravs as $rav) : ?>
                <tr>
                  <td><?= $rav['created_at'] ?></td>
                  <td><?= $rav['type_carb'] ?></td>
                  <td><?= $rav['prix_litre'] ?> FCFA/Litre</td>
                  <td><?= $rav['litres'] ?></td>
                  <td><?= $rav['prix_litre'] * $rav['litres'] ?> FCFA</td>
                  <td><?= $rav['conducteur'] ?></td>
                  <td><?= $rav['type_veh'] ?></td>
                  <td><?= $rav['imm'] ?></td>
                  <td><?= $rav['auteur'] ?></td>
                  <td>
                    <div class="d-flex justify-content-around">
                      <button type="button" class="btn border-0 text-warning modRav" data-id="<?= $rav['id'] ?>" data-conducteur="<?= $rav['conducteur'] ?>" data-date="<?= $rav['created_at'] ?>" data-vehicule="<?= $rav['imm'] ?>" data-typveh="<?= $rav['type_veh'] ?>" data-carb="<?= $rav['type_carb'] ?>" data-litres="<?= $rav['litres'] ?>" data-bs-toggle="modal" data-bs-target="#modCarb"><i cla data-feather="edit"></i> Modifier</button>
                      <button data-id="<?= $rav['id'] ?>" data-conducteur="<?= $rav['conducteur'] ?>" data-date="<?= $rav['created_at'] ?>" data-bs-toggle="modal" data-bs-target="#supRav" type="button" class="btn supRav border-0 text-danger">
                        <i cla data-feather="trash"></i> Supprimer
                      </button>
                    </div>
                  </td>
                </tr>
              <?php endforeach ?>
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
          base_url(session()->r . '/carburant/recharge'),
          [
            'id' => 'rechargeForm'
          ]
        ) ?>
        <div class="mb-3">
          <label for="montant" class="form-label">Montant</label>
          <input type="number" min="1" class="form-control" name="montant" id="montant" placeholder="Montant de la recharge" required>
        </div>
        <div class="mb-3">
          <label for="created_at" class="form-label">Date de recharge</label>
          <input type="datetime-local" min="1" class="form-control" name="created_at" id="created_at" placeholder="Date de la recharge" required>
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

<!-- supprimer un ravitaillement -->
<div class="modal fade" id="supRav" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="supRavModTi" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="supRavModTi">Supprimer un ravitaillement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Supprimer le ravitaillement du <strong id="supDate"></strong> pour <strong id="supConducteur"></strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
        <a id="supRavBtn" href="" type="button" class="btn btn-primary">Oui, supprimer</a>
      </div>
    </div>
  </div>
</div>
<script>
  const myModalRav = new bootstrap.Modal(document.getElementById('supRav'), options)
</script>

<script>
  $('.supRav').click(function(e) {
    e.preventDefault();
    $('#supDate').html($(this).data('date'));
    $('#supConducteur').html($(this).data('conducteur'));
    $('#supRavBtn').attr('href', '<?= base_url(session()->r . '/carburant/supprimer/') ?>' + $(this).data('id'));
  });
</script>

<!-- modifier -->
<div class="modal fade" id="modCarb" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Modifier les information du Ravitaillement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(
          base_url(session()->r . '/carburant/modifier'),
          [
            'id' => 'modCarbForm'
          ]
        ) ?>

        <div class="row">
          <div class="col-md col-lg-4">

            <div class="mb-3">
              <label for="created_at_mod" class="form-label">Date de ravitaillement <span class="text-danger"><strong>*</strong></span></label>
              <input required type="datetime-local" class="form-control" name="created_at" id="created_at_mod" value="<?= set_value('created_at') ?>" placeholder="Date de ravitaillent" required>
            </div>

            <div class="mb-3">
              <label for="conducteur_mod" class="form-label">Conducteur <span class="text-danger"><strong>*</strong></span></label>
              <input required type="text" class="form-control" name="conducteur" id="conducteur_mod" value="<?= set_value('conducteur') ?>" placeholder="Nom complet du conducteur">
            </div>

          </div>
          <div class="col-md col-lg-4">

            <div class="mb-3">
              <label for="type_veh_mod" class="form-label">Type de véhicule <span class="text-danger"><strong>*</strong></span></label>
              <select required class="form-select" name="type_veh" id="type_veh_mod">
                <option selected value="" hidden>Selectionnez le type de véhicule</option>
                <option <?= set_select('type_veh', 'TRACTEUR') ?>>Tracteur</option>
                <option <?= set_select('type_veh', 'MOTO') ?>>Moto</option>
                <option <?= set_select('type_veh', 'VOITURE PARTICULIER') ?>>Voiture particulier</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="imm_mod" class="form-label">Immatriculation du véhicule </label>
              <input type="text" class="form-control text-uppercase" name="imm" id="imm_mod" value="<?= set_value('imm') ?>" placeholder="AB 1234 CD">
            </div>

          </div>
          <div class="col-md col-lg-4">

            <div class="mb-3">
              <label for="type_carb_mod" class="form-label">Carburant <span class="text-danger"><strong>*</strong></span></label>
              <select required class="form-select" name="type_carb" id="type_carb_mod">
                <option selected value="" hidden>Sélectionnez le type</option>
                <option value="ESSENCE" <?= set_select('type_carb', 'ESSENCE') ?>>ESSENCE - 990 FCFA par litre</option>
                <option value="GASOIL" <?= set_select('type_carb', 'GASOIL') ?>>GASOIL - 755 FCFA par litre</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="litres_mod" class="form-label">Nombre de litres <span class="text-danger"><strong>*</strong></span></label>
              <input required type="number" min="1" step="0.1" max="500" class="form-control" name="litres" id="litres_mod" value="<?= set_value('litres') ?>" placeholder="Nombre de litre">
            </div>
          </div>
          <div class="col-12">
            <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Effacer</button>
            <button type="submit" id="subRav_mod" name="id" form="modCarbForm" class="btn btn-primary">Enregistrer</button>
          </div>
        </div>


        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>

    </div>
  </div>
</div>


<!-- Optional: Place to the bottom of scripts -->
<script>
  const myModal = new bootstrap.Modal(document.getElementById('modCarb'), options)
</script>
<script>
  $('.modRav').click(function(e) {
    e.preventDefault();
    $('#subRav_mod').val($(this).data('id'));
    $('#created_at_mod').val($(this).data('date'));
    $('#conducteur_mod').val($(this).data('conducteur'));
    $('#type_veh_mod').val($(this).data('typveh'));
    $('#imm_mod').val($(this).data('vehicule'));
    $('#type_carb_mod').val($(this).data('carb'));
    $('#litres_mod').val($(this).data('litres'));
  });
</script>

<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script>
  $('#type').val('<?= isset($type) ? $type : '' ?>');

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