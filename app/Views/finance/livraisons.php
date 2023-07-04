<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Facturation livraisons
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Livraisons</strong></h1>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Liste des facturations de livraisons</h4>
        <form action="<?= base_url(session()->r . '/livraisons') ?>" class="d-flex gap-2">
          <input type="search" value="<?= (isset($_GET['search'])) ? $_GET['search'] : '' ?>" class="form-control flex-grow-1" name="search" id="search" placeholder="Rechercher par Nº Facture, BL, Compagnie ou date d'enregistrement">
          <button class="btn btn-primary d-flex gap-2 justify-content-center align-items-center"><i data-feather="search"></i> <span class="d-none d-md-flex">Rechercher</span></button>
        </form>
      </div>
      <div class="table-responsive">
        <?php if (sizeof($facts) == 0) : ?>
          <div class="card-body">
            <div class="alert alert-warning" role="alert">
              Vide
            </div>
          </div>
        <?php else : ?>
          <table class="table table-hover my-0">
            <thead>
              <tr>
                <th>Nº Facture</th>
                <th class="table-cell">Nº BL</th>
                <th class="d-none d-md-table-cell">Montant TTC</th>
                <th class="d-none d-xl-table-cell">Date</th>
                <th>Paiement</th>
                <th>Règlement</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($facts as $line) : ?>
                <tr>
                  <td><?= $line['id'] ?></td>
                  <td class="table-cell"><?= $line['bl'] ?></td>
                  <td class="d-none d-md-table-cell"><?= $line['total'] ?></td>
                  <td class="d-none d-xl-table-cell"><?= $line['created_at'] ?></td>
                  <td><span class="badge bg-<?= ($line['paiement'] == 'NON') ? 'warning' : 'success' ?>"><?= ($line['paiement'] == 'NON') ? 'NON REÇU' : 'PAYÉ' ?></span></td>
                  <td><span class="badge bg-<?= ($line['reglement'] == 'NON PAYÉ' or $line['reglement'] == 'À CRÉDIT') ? 'danger' : 'success' ?>"><?= $line['reglement'] ?></span></td>
                  <td class="d-flex gap-1">
                    <button data-bs-toggle="modal" data-bs-target="#modalId" value="<?= $line['id'] ?>" data-paiement="<?= $line['paiement'] ?>" data-reglement="<?= $line['reglement'] ?>" class="btn rfl text-success btn-sm d-flex align-items-center justify-content-center gap-2" title="Règler la facture" role="button"><i class="align-middle" data-feather="check"></i></button>
                    <a class="btn text-info btn-sm d-flex align-items-center justify-content-center gap-2" title="Voir les informations" href="<?= base_url(session()->r . '/livraisons/details/' . $line['id']) ?>" target="_blank" role="button"><i class="align-middle" data-feather="info"></i></a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
            <tfoot>
            </tfoot>
          </table>
        <?php endif ?>
      </div>
      <div class="card-footer text-muted">
        <nav class="pagination text-end">
          <?= $pager->links() ?>
        </nav>
      </div>
    </div>
  </div>
</div>

<!-- reglement facture livraisons -->
<div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="regfactliv" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="regfactliv">Règlement de la facture <span class="text-primary" id="rfl"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div>
          <?= form_open(
            '',
            [
              'id' => 'rflF'
            ]
          ) ?>
          <div class="form-check form-switch">
            <input name="paiement" class="form-check-input" type="checkbox" id="payCheck">
            <label class="form-check-label" for="payCheck">Paiement reçu</label>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input " type="radio" value="COMPTANT" name="reglement" id="comptant">
            <label class="form-check-label" for="comptant">
              Paiement comptant
            </label>
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input payType" type="radio" value="À CRÉDIT" name="reglement" id="credit">
            <label class="form-check-label" for="credit">
              Paiement à crédit
            </label>
          </div>
          <script>
            document.getElementById('payCheck').addEventListener('change', (e) => {
              if (!e.target.checked) {
                document.getElementById('comptant').checked = false;
                document.getElementById('credit').checked = false;
              }
            })
            document.getElementById('comptant').addEventListener('change', (e) => {
              if (e.target.checked) {
                document.getElementById('payCheck').checked = true;
              }
            })
          </script>

          <?= csrf_field() ?>
          <?= form_close() ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" form="rflF" class="btn btn-primary">Enregistrer</button>
        </div>
      </div>
    </div>
    <script>
      const myModalrefLiv = new bootstrap.Modal(document.getElementById('modalId'), options)
    </script>
    <script>
      $('.rfl').click(function(e) {
        e.preventDefault();
        $('#rfl').html(`Nº ${$(this).val()}`);
        const pay = $(this).attr('data-paiement');
        const payType = $(this).attr('data-reglement');
        document.getElementById('comptant').checked = (payType == 'COMPTANT') ? true : false;
        document.getElementById('credit').checked = (payType == 'À CRÉDIT') ? true : false;
        document.getElementById('payCheck').checked = (pay == 'OUI') ? true : false;
        $('#rflF').attr('action', '<?= base_url(session()->r . '/livraisons/reglement/') ?>' + $(this).val());
      });
    </script>
  </div>
</div>

<?= $this->endSection(); ?>