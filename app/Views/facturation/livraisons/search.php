<?php
//Pour permettre d'utiliser la page sans données
if (!isset($r)) {
  $r = [];
}
?>
<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Facturation livraisons
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Recherches</strong> Facturation de livraisons</h1>
<div class="row">

  <div class="col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-body ">
        <form action="<?= base_url(session()->r . '/livraisons/search') ?>" class="d-flex gap-2">
          <input type="search" value="<?= (isset($search)) ? $search : '' ?>" class="form-control flex-grow-1" name="search" id="search" placeholder="Rechercher par Nº Facture, BL, Compagnie, client ou date d'enregistrement">
          <button class="btn btn-primary d-flex gap-2 justify-content-center align-items-center"><i data-feather="search"></i> <span class="d-none d-md-flex">Rechercher</span></button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header">
        <h4 class="card-title">Résultat des recherches</h4>
      </div>

      <?php if (sizeof($r) == 0) : ?>
        <div class="card-body">
          <div class="alert alert-warning" role="alert">
            Aucun résultat
          </div>
        </div>

      <?php else : ?>
        <div class="table-responsive">
          <table class="table table-hover my-0">
            <thead>
              <tr>
                <th>Nº Facture</th>
                <th class="table-cell">Client</th>
                <th class="table-cell">BL</th>
                <th class="table-cell">Compagnie</th>
                <th class="d-none d-xl-table-cell">20'</th>
                <th class="d-none d-xl-table-cell">40'</th>
                <th class="d-none d-md-table-cell">Montant en FCFA TTC</th>
                <th class="d-none d-xl-table-cell">Date</th>
                <th>Annulée</th>
                <th>pregate</th>
                <th>Paiement</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($r as $line) : ?>
                <tr>
                  <td><?= $line['id'] ?></td>
                  <td class="table-cell"><?= $line['nom'] ?></td>
                  <td class="table-cell"><?= $line['bl'] ?></td>
                  <td class="table-cell"><?= $line['compagnie'] ?></td>
                  <td class="d-none d-xl-table-cell"><?= $line['n20'] ?></td>
                  <td class="d-none d-xl-table-cell"><?= $line['n40'] ?></td>
                  <td class="d-none d-md-table-cell num"><?= $line['total'] ?></td>
                  <td class="d-none d-xl-table-cell"><?= $line['date_creation'] ?></td>
                  <td><span class="badge bg-<?= ($line['annulation'] == 'OUI') ? 'danger' : 'success' ?>"><?= $line['annulation'] ?></span></td>
                  <td><span class="badge bg-<?= ($line['pregate'] == 'NON') ? 'warning' : 'success' ?>"><?= ($line['pregate'] == 'NON') ? 'NON REÇU' : 'REÇU' ?></span></td>
                  <td><span class="badge bg-<?= ($line['paiement'] == 'NON') ? 'warning' : 'success' ?>"><?= ($line['paiement'] == 'NON') ? 'NON REÇU' : 'PAYÉ' ?></span></td>
                  <td>
                    <div class="d-flex gap-1">
                      <a class="btn text-warning btn-sm d-flex align-items-center justify-content-center gap-2" title="Modifier les informations" href="<?= base_url(session()->r . '/livraisons/edit/' . $line['id']) ?>" role="button"><i class="align-middle" data-feather="edit"></i></a>
                      <button value="Nº <?= $line['id'] ?>" data-id="<?= $line['id'] ?>" class="annfLiv btn text-dark btn-sm d-flex align-items-center justify-content-center gap-2 <?= ($line['annulation'] == 'OUI') ? 'disabled text-white border-0' : '' ?> " type="button" title="Annuler la facture" data-bs-toggle="modal" data-bs-target="#modalIdannF"><i class="align-middle" data-feather="x"></i></button>
                      <button value="Nº <?= $line['id'] ?>" class="delfLiv btn text-danger btn-sm d-flex align-items-center justify-content-center gap-2" type="button" title="Supprimer la facture" data-bs-toggle="modal" data-bs-target="#delFactLiv"><i class="align-middle" data-feather="trash"></i></button>
                      <a class="btn text-info btn-sm d-flex align-items-center justify-content-center gap-2" title="Voir les informations" href="<?= base_url(session()->r . '/livraisons/details/' . $line['id']) ?>" target="_blank" role="button"><i class="align-middle" data-feather="info"></i></a>
                    </div>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
        <div class="card-footer text-muted d-flex align-items-center justify-content-end">
          <?= $pager->links() ?>
        </div>
      <?php endif ?>

    </div>
  </div>


</div>

<div class="modal fade" id="modalIdannF" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleIdAnnFact" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleIdAnnFact">Annulation de la facture <span class="text-primary" id="AF"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open('', [
          'id' => 'AFLL',
        ]) ?>
        <div class="mb-3">
          <label for="motif" class="form-label">Motif d'annulation de la facture:</label>
          <textarea required class="form-control" name="motif" id="motif" rows="3"></textarea>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
        <div class="alert alert-warning" role="alert">
          <p>CETTE ACTION EST IRREVERSIBLE!</p>
          <strong>Attention</strong> Si vous annulez la facture, toutes les livraisons lui étant liées seront aussi annulées.
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="AFLL" class="btn btn-primary">Annuler la facture</button>
      </div>
    </div>
  </div>
</div>
<script>
  const myModal = new bootstrap.Modal(document.getElementById('modalIdannF'), options)
</script>

<script>
  $('.annfLiv').click(function(e) {
    e.preventDefault();
    $('#AF').html($(this).val());
    const id = '<?= base_url(session()->r . '/livraisons/annuler/') ?>' + $(this).attr('data-id');
    $('#AFLL').attr('action', id);
  });
</script>
<div class="modal fade" id="delFactLiv" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleIdfactlivdel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleIdfactlivdel">Suppression</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Vous souhaitez supprimer la facture <span class="text-primary" id="nFactLiv"></span> ?</p>
        <div class="alert alert-warning" role="alert">
          <strong>URGENT</strong> En supprimant une facturation de livraison:
          <ul>
            <li>vous supprimer l'ensemble des livraisons liées à elle</li>
            <li>le total de la facture sera débité du chiffre d'affaire de l'entreprise, ce qui rendra les anciens rapports obsolétes.</li>
          </ul>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non annuler</button>
        <a id="delfLivB" role="button" class="btn btn-primary">Oui supprimer</a>
      </div>
    </div>
  </div>
</div>
<script>
  const myModaldelfliv = new bootstrap.Modal(document.getElementById('delFactLiv'), options)
</script>
<script>
  $('.delfLiv').click(function(e) {
    e.preventDefault();
    $('#nFactLiv').html($(this).val());
    $('#delfLivB').attr('href', '<?= base_url(session()->r . '/livraisons/del/') ?>' + $(this).val());
  });
</script>


<?= $this->endSection(); ?>