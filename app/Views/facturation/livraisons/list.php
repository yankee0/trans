<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Facturation livraisons
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<script>
  let zones = [];
  config = {
    type: "get",
    url: "<?= base_url('api/zones') ?>",
    data: {
      token: '<?= csrf_hash() ?>'
    },
    dataType: "JSON",
    success: function(response) {
      zones = response;
    },
  };
</script>

<h1 class="h3 mb-3"><strong>Facturations</strong> Livraisons</h1>
<div class="row">

  <div class="col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-body ">
        <form action="<?= base_url(session()->r . '/livraisons/search') ?>" class="d-flex gap-2">
          <input type="search" value="<?= (isset($search)) ? $search : '' ?>" class="form-control flex-grow-1" name="search" id="search" placeholder="Rechercher par Nº Facture, BL ou nom de la Compagnie">
          <button class="btn btn-primary d-flex gap-2 justify-content-center align-items-center"><i data-feather="search"></i> <span class="d-none d-md-flex">Rechercher</span></button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header">
        <h5 class="card-title mb-0">Créer une nouvelle facture</h5>
      </div>
      <div class="card-body ">
        <?= form_open(base_url(session()->r . '/livraisons'), []) ?>
        <?= csrf_field() ?>
        <div class="row row-cols-md-2 mb-3">
          <div>
            <h5 class="card-title mb-0 text-dark mb-2">Informations sur le client</h5>
            <div class="mb-3">
              <select class="form-select" name="id_client" id="id_client" required>
                <option selected value="" hidden>Sélectionner un compte</option>
                <?php foreach ($cli as $c) : ?>
                  <option value="<?= $c['id'] ?>"><?= $c['id'] . ' - ' . $c['nom'] ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="mb-3">
              <input type="text" class="form-control text-uppercase" name="consignataire" id="consignataire" aria-describedby="helpId" placeholder="Consignataire" required>
            </div>
          </div>
          <div>
            <h5 class="card-title mb-0 text-dark mb-2">Informations sur les containers</h5>
            <div class="mb-3">
              <input type="text" class="form-control text-uppercase" name="compagnie" id="compagnie" aria-describedby="helpId" placeholder="Compagnie" required>
            </div>
            <div class="mb-3">
              <input type="text" class="form-control text-uppercase" name="bl" id="bl" aria-describedby="helpId" placeholder="BL" required>
            </div>
          </div>
        </div>
        <h5 class="card-title mb-0 text-dark mb-2">Informations sur le transport</h5>
        <div id="yankee"></div>

        <?= form_close() ?>
      </div>
    </div>
  </div>
  <div class="col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header">
        <h5 class="card-title mb-0">Dernières facturations de livraisons</h5>
      </div>
      <table class="table table-hover my-0">
        <thead>
          <tr>
            <th class="d-none d-sm-table-cell">Nº Facture</th>
            <th class="">BL</th>
            <th class="d-none d-xl-table-cell">Nombre de 20'</th>
            <th class="d-none d-xl-table-cell">Nombre de 40'</th>
            <th class="d-none d-md-table-cell">Montant</th>
            <th class="d-none d-xl-table-cell">Date</th>
            <th class="d-none d-sm-table-cell">Preget</th>
            <th class="d-none d-sm-table-cell">Paiement</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($fact_liv_last as $line) : ?>
            <tr>
              <td class="d-none d-sm-table-cell"><?= $line['id'] ?></td>
              <td class=""><?= $line['bl'] ?></td>
              <td class="d-none d-xl-table-cell"><?= $line['n20'] ?></td>
              <td class="d-none d-xl-table-cell"><?= $line['n40'] ?></td>
              <td class="d-none d-md-table-cell"><?= $line['total'] ?></td>
              <td class="d-none d-xl-table-cell"><?= $line['created_at'] ?></td>
              <td class="d-none d-sm-table-cell"><span class="badge bg-<?= ($line['preget'] == 'NON') ? 'warning' : 'success' ?>"><?= ($line['preget'] == 'NON') ? 'NON REÇU' : 'REÇU'?></span></td>
              <td class="d-none d-sm-table-cell"><span class="badge bg-<?= ($line['paiement'] == 'NON') ? 'warning' : 'success' ?>"><?= ($line['paiement'] == 'NON') ? 'NON REÇU' : 'PAYÉ'?></span></td>
              <td class="d-flex gap-1">
                <button value="Nº <?= $line['id'] ?>" class="delfLiv btn btn-danger btn-sm d-flex align-items-center justify-content-center gap-2" type="button" title="Supprimer la facture" data-bs-toggle="modal" data-bs-target="#delFactLiv"><i class="align-middle" data-feather="trash"></i></button>
                <a class="btn btn-info btn-sm d-flex align-items-center justify-content-center gap-2" title="Voir les informations" href="<?= base_url(session()->r . '/livraisons/details/' . $line['id']) ?>" target="_blank" role="button"><i class="align-middle" data-feather="info"></i></a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
        <tfoot>
        </tfoot>
      </table>
      <div class=" card-footer">
        <div class="text-center">
          <?php if (sizeof($fact_liv_last) > 0) : ?>
            <a href="<?= base_url(session()->r . '/livraisons/search?search=') ?>">Tout voir</a>
          <?php else : ?>
            <div class="alert alert-warning" role="alert">
              Vide.
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
</div>

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
  const checkUrl = '<?= base_url('api/utils/checkData') ?>';
  const token = '<?= csrf_hash() ?>';
</script>

<script src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script type="application/javascript" src="https://unpkg.com/babel-standalone@6.26.0/babel.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="<?= base_url('assets/js/react.js') ?>" type="text/babel"></script>

<script>
  $('.delfLiv').click(function(e) {
    e.preventDefault();
    $('#nFactLiv').html($(this).val());
    $('#delfLivB').attr('href', '<?= base_url(session()->r . '/livraisons/del/') ?>' + $(this).val());
  });
</script>

<?= $this->endSection(); ?>