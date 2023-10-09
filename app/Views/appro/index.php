<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Approvisionnements
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url(session()->r . '/') ?>">Accueil</a></li>
    <li class="breadcrumb-item active" aria-current="page">Approvisionnements</li>
  </ol>
</nav>
<h1 class="h3 mb-3"><strong>Gestion</strong> Approvisionnements</h1>
<div class="row">
  <div class="col-sm col-md-6 col-xl-4">
    <div class="card">
      <div class="card-body">
        <h5><strong>Solde compte appro</strong></h5>
        <div class="fs-2 <?= $carte['solde'] <= 70000 ? 'text-danger' : 'text-success' ?>"><span class="num"><?= $carte['solde'] ?></span> <strong>FCFA</strong></div>
        <div class="mb-2">
          <?php if (empty($recs)) : ?>
            <small>Pas de recharge enregistrée</small>
          <?php else : ?>
            <small class="text-muted">Dernier rechargement de <span class="num"><?= $recs[0]['montant'] ?></span> par <?= $recs[0]['auteur'] ?> le <?= date('d/m/Y à H:i', strtotime($recs[0]['date'])) ?></small>
          <?php endif ?>
        </div>
        <?php if (session()->r == 'admin') : ?>
          <div class="d-flex justify-content-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approModal">Recharger le compte</button>
          </div>
        <?php endif ?>
      </div>
    </div>

    <div class="modal fade" id="approModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="approTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="approTitle">Recharger le compte appro</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?= form_open(session()->r . '/approvisionnements/recharge', ['id' => 'form']) ?>

            <div class="mb-3">
              <label for="montant" class="form-label">Montant en FCFA</label>
              <input type="number" min="0" class="form-control" name="montant" id="montant" placeholder="Montant de la recharge" required>
            </div>
            <div class="mb-3">
              <label for="date" class="form-label">Date</label>
              <input type="datetime-local" class="form-control" name="date" id="date" required max="<?= date('Y-m-d') ?>">
            </div>

            <?= csrf_field() ?>
            <?= form_close() ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" form="form" class="btn btn-success">Recharger le compte</button>
          </div>
        </div>
      </div>
    </div>
    <script>
      const myModalAppro = new bootstrap.Modal(document.getElementById('approModal'), options)
    </script>
  </div>
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