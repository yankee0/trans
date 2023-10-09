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
            <small class="text-muted">Dernier rechargement de <span class="num"><?= $recs[0]['montant'] ?></span> FCFA par <?= $recs[0]['auteur'] ?> le <?= date('d/m/Y à H:i', strtotime($recs[0]['date'])) ?></small>
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
              <label for="montantR" class="form-label">Montant en FCFA</label>
              <input type="number" min="0" class="form-control" name="montant" id="montantR" placeholder="Montant de la recharge" required>
            </div>
            <div class="mb-3">
              <label for="dateR" class="form-label">Date</label>
              <input type="datetime-local" class="form-control" name="date" id="dateR" required max="<?= date('Y-m-d') ?>">
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

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Nouvel appro</div>
      </div>
      <div class="card-body">
        <?= form_open() ?>
        <div class="row">
          <div class="col-md-6 col-lg-4">
            <div class="mb-3">
              <label for="nature" class="form-label">Nature<span class="text-danger">*</span></label>
              <select required class="form-select " name="nature" id="nature">
                <option selected value="" hidden>Sélectionnez la nature</option>
                <option value="PIECES DE RECHANGE">PIECES DE RECHANGE</option>
                <option value="REPARATION ET ENTRETIEN">REPARATION ET ENTRETIEN</option>
                <option value="RATION">RATION</option>
                <option value="CONTRAVENTION">CONTRAVENTION</option>
                <option value="AUTRES">AUTRES</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="mb-3">
              <label for="montant" class="form-label">Montant<span class="text-danger">*</span></label>
              <input type="number" required min="0" class="form-control" name="montant" id="montant" aria-describedby="" placeholder="Montant de l'appros">
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="mb-3">
              <label for="date" class="form-label">Date<span class="text-danger">*</span></label>
              <input type="datetime-local" required max="<?= date('Y-m-d H:i:s', strtotime('+1 hour')) ?>" class="form-control" name="date" id="date" aria-describedby="" placeholder="Date de l'appros">
            </div>
          </div>
          <div class="col-12">
            <div class="mb-3">
              <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
              <textarea class="form-control" required name="description" id="description" rows="3"></textarea>
            </div>
          </div>
          <div class="col-12 d-flex gap-3">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <button type="reset" class="btn btn-light">Effacer</button>
          </div>
        </div>

        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <div class="card-title">Liste des approvisionnements</div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Date</th>
                <th>Nature</th>
                <th>Montant en FCFA</th>
                <th>Description</th>
                <th>Auteur</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($ravs as $r) : ?>
                <tr>
                  <td><?= date('d/m/Y à H:i', strtotime($r['date'])) ?></td>
                  <td><?= $r['nature'] ?></td>
                  <td><?= $r['montant'] ?></td>
                  <td><?= $r['description'] ?></td>
                  <td><?= $r['auteur'] ?></td>
                  <td>
                    <div class="d-flex gap-2">
                      <button data-bs-toggle="modal" data-bs-target="#modalIdAppro" data-id="<?= $r['id'] ?>" data-nature="<?= $r['nature'] ?>" data-montant="<?= $r['montant'] ?>" data-description="<?= $r['description'] ?>" data-date="<?= $r['date'] ?>" class="btn mod text-warning">Modifier</button>
                      <button data-bs-toggle="modal" data-bs-target="#modalIdAppro" data-id="<?= $r['id'] ?>" data-nature="<?= $r['nature'] ?>" data-montant="<?= $r['montant'] ?>" data-description="<?= $r['description'] ?>" data-date="<?= $r['date'] ?>" class="btn del text-danger">Supprimer</button>
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

<!-- Modification de l'approvisionnement -->
<div class="modal fade" id="modalIdAppro" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleIdAppro" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleIdAppro">Modifier l'appro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(base_url(session()->r . '/approvisionnements/modifier'), ['id' => 'edit']) ?>
        <div class="row">
          <div class="col-md-6 col-lg-4">
            <div class="mb-3">
              <label for="natureMod" class="form-label">Nature<span class="text-danger">*</span></label>
              <select required class="form-select " name="nature" id="natureMod">
                <option selected value="" hidden>Sélectionnez la nature</option>
                <option value="PIECES DE RECHANGE">PIECES DE RECHANGE</option>
                <option value="REPARATION ET ENTRETIEN">REPARATION ET ENTRETIEN</option>
                <option value="RATION">RATION</option>
                <option value="CONTRAVENTION">CONTRAVENTION</option>
                <option value="AUTRES">AUTRES</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="mb-3">
              <label for="montantMod" class="form-label">Montant<span class="text-danger">*</span></label>
              <input type="number" required min="0" class="form-control" name="montant" id="montantMod" aria-describedby="" placeholder="Montant de l'appros">
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="mb-3">
              <label for="dateMod" class="form-label">Date<span class="text-danger">*</span></label>
              <input type="datetime-local" required max="<?= date('Y-m-d H:i:s', strtotime('+1 hour')) ?>" class="form-control" name="date" id="dateMod" aria-describedby="" placeholder="Date de l'appros">
            </div>
          </div>
          <div class="col-12">
            <div class="mb-3">
              <label for="descriptionMod" class="form-label">Description<span class="text-danger">*</span></label>
              <textarea class="form-control" required name="description" id="descriptionMod" rows="3"></textarea>
            </div>
          </div>
        </div>

        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="edit" name="id" id="idMod" class="btn btn-primary">Modifier</button>
      </div>
    </div>
  </div>
</div>
<script>
  $('.mod').click(function(e) {
    e.preventDefault();
    $('#idMod').val($(this).data('id'));
    $('#natureMod').val($(this).data('nature'));
    $('#montantMod').val($(this).data('montant'));
    $('#dateMod').val($(this).data('date'));
    $('#descriptionMod').val($(this).data('description'));
  });
</script>
<script>
  const myModal = new bootstrap.Modal(document.getElementById('modalIdAppro'), options)
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
      order: [
        [0, 'desc']
      ],
      dom: 'Bfrtip',
      buttons: [
        'copyHtml5',
        {
          extend: 'excelHtml5',
          exportOptions: {
            columns: ':not(:last-child)' // Excludes the last column
          }
        },
        {
          extend: 'csvHtml5',
          exportOptions: {
            columns: ':not(:last-child)' // Excludes the last column
          }
        },
        {
          extend: 'pdfHtml5',
          exportOptions: {
            columns: ':not(:last-child)' // Excludes the last column
          }
        },
      ],
      language: {
        decimal: ',',
        thousands: '.'
      },
    });
  });
</script>



<?= $this->endSection(); ?>