<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
<?= isset($name) ? $name : 'Rapports pregate' ?>
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Rapports</strong> pregate</h1>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Générer un rapport des pregate enregistrés</h5>
        <?= form_open() ?>
        <?= csrf_field() ?>
        <div class="row">
          <div class="col-md mb-3">
            <label for="type" class="form-label">Type </label>
            <select class="form-select" name="type" id="type" required>
              <option value="" selected hidden>Sélectionnez un type</option>
              <option value="j">Journalier</option>
              <option value="h">Hebdomadaire</option>
              <option value="m">Mensuel</option>
              <option value="a">Annuel</option>
            </select>
          </div>
          <div class="col-md mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" value="<?= isset($date) ? $date : '' ?>" name="date" required id="date" placeholder="Sélectionnez la date">
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

  <?php if (isset($name)) : ?>
    <div class="col-12">
      <div class="fs-1"><?= $name ?></div>
      <div class="fs-2 mb-3 text-opacity-75"><?= count($data) ?> pregate<?= count($data) > 1 ? 's' : '' ?> enregistré<?= count($data) > 1 ? 's' : '' ?></div>
      <hr>
    </div>
    <?php foreach ($data as $pg) : ?>
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
            <div class="h2">Lot de <?= $pg['livres'] + $pg['encours'] + $pg['restants'] ?> conteneur(s)</div>
            <hr>
            <div class="d-flex gap-3">
              <div class="flex-fill flex-grow-1">
                <div><small class=" text-black-50">Client:</small><br><?= $pg['nom'] ?></div>
                <div><small class=" text-black-50">Compagnie:</small><br><?= $pg['compagnie'] ?></div>
                <div><small class=" text-black-50">BL:</small><br><?= $pg['bl'] ?></div>
              </div>
              <div class="flex-fill flex-grow-1">
                <div><small class=" text-black-50">Nº facture:</small><br><?= $pg['id'] ?></div>
                <div><small class=" text-black-50">Date pregate:</small><br><?= $pg['date_pg'] ?></div>
                <div><small class=" text-black-50">Deadline:</small><br><?= $pg['deadline'] ?></div>
              </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
              <div>
                <span class="text-sm text-black-50">LIVRES</span> <br>
                <span class="fs-2"><?= $pg['livres'] ?></span>
              </div>
              <div>
                <span class="text-sm text-black-50">EN COURS</span> <br>
                <span class="fs-2"><?= $pg['encours'] ?></span>
              </div>
              <div>
                <span class="text-sm text-black-50">RESTANTS</span> <br>
                <span class="fs-2"><?= $pg['restants'] ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>

  <?php endif ?>



</div>

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