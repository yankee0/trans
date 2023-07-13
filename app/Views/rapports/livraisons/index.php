<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
<?= isset($name) ? $name : 'Rapports livraisons' ?>
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Rapports</strong> Livraisons</h1>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Générer un rapport de livraisons</h5>
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
      <div class="card">
        <div class="card-header">
          <h5 class="card-title"><?= $name ?></h5>
        </div>
        <div class="card-body">
          <div class=" table-responsive">
            <table id="table" class="table table-hover my-0">
              <thead>
                <tr>
                  <th class=" d-table-cell">Conteneur</th>
                  <th class=" d-table-cell">Type</th>
                  <th class=" d-table-cell">Paiement</th>
                  <th class=" d-table-cell">État</th>
                  <th class=" d-table-cell">Date PREGET</th>
                  <th class=" d-table-cell">Zone de destination</th>
                  <th class=" d-table-cell">Adresse exacte</th>
                  <th class=" d-table-cell">Chauffeur RETOUR</th>
                  <th class=" d-table-cell">Camion RETOUR</th>
                  <th class=" d-table-cell">Date RETOUR</th>
                  <th class=" d-table-cell">Chauffeur RETOUR</th>
                  <th class=" d-table-cell">Camion RETOUR</th>
                  <th class=" d-table-cell">Date RETOUR</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $liv) : ?>
                  <tr>
                    <td class=" d-table-cell"><?= $liv['conteneur'] ?></td>
                    <td class=" d-table-cell"><?= $liv['type'] ?></td>
                    <td class=" d-table-cell">
                      <?= $liv['paiement'] ?>
                    </td>
                    <td class=" d-table-cell"><?= $liv['etat'] ?></td>
                    <td class=" d-table-cell"><?= $liv['preget'] == 'OUI' ? $liv['date_pg'] : '<span class="badge bg-dark">NON REÇU</span>' ?></td>
                    <td class=" d-table-cell"><?= $liv['zone'] ?></td>
                    <td class=" d-table-cell"><?= !(empty($liv['adresse'])) ? $liv['adresse'] : '<span class="badge bg-dark">INCONNUE</span>' ?></td>
                    <td class=" d-table-cell"><?= $liv['ch_aller'] ?></td>
                    <td class=" d-table-cell"><?= $liv['cam_aller'] ?></td>
                    <td class=" d-table-cell"><?= $liv['date_aller'] ?></td>
                    <td class=" d-table-cell"><?= $liv['ch_retour'] ?></td>
                    <td class=" d-table-cell"><?= $liv['cam_retour'] ?></td>
                    <td class=" d-table-cell"><?= $liv['date_retour'] ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  <?php endif ?>



</div>

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
    $('#table').DataTable({
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