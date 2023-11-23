<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
<?= isset($name) ? $name : 'Caisse logistique' ?>
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url(session()->r . '/rapports') ?>">Rapports</a></li>
    <li class="breadcrumb-item active" aria-current="page">Caisse logistique</li>
  </ol>
</nav>
<h1 class="h3 mb-3"><strong>Rapports</strong> caisse logistique</h1>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Générer un rapport</h5>
        <?= form_open() ?>
        <?= csrf_field() ?>
        <div class="row">
          <div class="col-md mb-3">
            <label for="from" class="form-label">Du </label>
            <select class="form-select" name="from" id="from" required>
              <option value="" selected hidden>Rechargement de départ</option>
              <?php foreach ($recs as $rec) : ?>
                <option value="<?= $rec['date'] ?>">Rec. de <?= number_format($rec['montant']) ?> FCFA du <?= date("d/m/Y à H:i:s", strtotime($rec['date'])) ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="col-md mb-3">
            <label for="to" class="form-label">Au</label>
            <select class="form-select" name="to" id="to" required>
              <?php foreach ($recs as $rec) : ?>
                <option value="<?= $rec['date'] ?>">Rec. de <?= number_format($rec['montant']) ?> FCFA du <?= date("d/m/Y à H:i:s", strtotime($rec['date'])) ?></option>
              <?php endforeach ?>
            </select>
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

  <?php if (isset($_POST['from'])) : ?>
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Résultat</div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table border w-100" id="tableau">
              <thead class="d-none">
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($res as $r) : ?>
                  <tr class="bg-success text-white">
                    <td class=" fw-bold"><?= $r['titre'] ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr class="bg-light">
                    <td class=" fw-bold">Solde d'ouverture en FCFA</td>
                    <td><?= number_format($r['solde_init']) ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr class="bg-light">
                    <td class=" fw-bold">Montant de la recharge en FCFA</td>
                    <td><?= number_format($r['recharge']) ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr class="bg-light">
                    <td class=" fw-bold">Montant des dépenses en FCFA</td>
                    <td><?= number_format($r['depenses']) ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr class="bg-light">
                    <td class=" fw-bold">Solde de fermeture en FCFA</td>
                    <td><?= number_format($r['solde_fin']) ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr class="bg-light">
                    <td class=" fw-bold">Date</td>
                    <td class=" fw-bold">Nature</td>
                    <td class=" fw-bold">Montant en FCFA</td>
                    <td class=" fw-bold">Description</td>
                    <td class=" fw-bold">Lien fichier joint</td>
                    <td class=" fw-bold">Auteur</td>
                  </tr>
                  <?php foreach ($r['appros'] as $a) : ?>
                    <tr>
                      <td><?= date('d/m/Y à H:i', strtotime($a['date'])) ?></td>
                      <td><?= $a['nature'] ?></td>
                      <td><?= number_format($a['montant']) ?></td>
                      <td><?= $a['description'] ?></td>
                      <td>
                        <?= empty($a['img']) ? '<i>pas de fichier joint</i>' : '<a target="_blank" href="' . base_url('images/approvisionnements/' . $a['img']) . '">' . base_url('images/approvisionnements/' . $a['img']) . '</a>' ?>
                      </td>
                      <td><?= $a['auteur'] ?></td>
                    </tr>
                  <?php endforeach ?>
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
  $(document).ready(function() {
    $('.table').DataTable({
      responsive: true,
      ordering: false,
      paging: false,
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
<?php if (isset($_POST['from'])) : ?>
  <script>
    $('#from').val('<?= $_POST['from'] ?>');
    $('#to').val('<?= $_POST['to'] ?>');
  </script>
<?php endif ?>



<?= $this->endSection(); ?>