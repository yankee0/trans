<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
<?= isset($name) ? $name : 'Rapports finance' ?>
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url(session()->r . '/rapports') ?>">Rapports</a></li>
    <li class="breadcrumb-item active" aria-current="page">Rapports finance</li>
  </ol>
</nav>
<h1 class="h3 mb-3"><strong>Rapports</strong> Finance</h1>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Générer un rapport des encaissements financiers pour les livraisons</h5>
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
        <div class="card-body">
          <h5 class="card-title"><?= $name ?></h5>
          <div class="table-responsive">
            <table id="table" class="table table-hover my-0">
              <thead>
                <tr>
                  <th class="d-table-cell">Nº Facture</th>
                  <th class="d-table-cell">Nº BL</th>
                  <th class="d-table-cell">Nº Compte client</th>
                  <th class="d-table-cell">Client</th>
                  <th class="d-table-cell">Consignataire</th>
                  <th class="d-table-cell">Pregate</th>
                  <th class="d-table-cell">Date pregate</th>
                  <th class="d-table-cell">Paiement</th>
                  <th class="d-table-cell">Montant TTC</th>
                  <th class="d-table-cell">Date de paiement</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $l) : ?>
                  <tr>
                    <td><?= $l['facture'] ?></td>
                    <td><?= $l['bl'] ?></td>
                    <td><?= $l['client'] ?></td>
                    <td><?= $l['nom'] ?></td>
                    <td><?= $l['consignataire'] ?></td>
                    <td><?= $l['pregate'] ?></td>
                    <td><?= date('d/m/Y', strtotime($l['date_pg'])) ?></td>
                    <td><?= $l['paiement'] ?></td>
                    <td><?= number_format(intval($l['total'])) ?></td>
                    <td><?= $l['date_paiement'] ?></td>
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