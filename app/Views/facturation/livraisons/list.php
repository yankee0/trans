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
        <form action="<?= base_url(session()->r . '/zones/search') ?>" class="d-flex gap-2">
          <input type="search" value="<?= (isset($search)) ? $search : '' ?>" class="form-control flex-grow-1" name="search" id="search" placeholder="Rechercher un client, un BL, un numéro de conteneur">
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
              <input type="text" class="form-control" name="consignataire" id="consignataire" aria-describedby="helpId" placeholder="Consignataire" required>
            </div>
          </div>
          <div>
            <h5 class="card-title mb-0 text-dark mb-2">Informations sur les containers</h5>
            <div class="mb-3">
              <input type="text" class="form-control" name="compagnie" id="compagnie" aria-describedby="helpId" placeholder="Compagnie" required>
            </div>
            <div class="mb-3">
              <input type="text" class="form-control" name="bl" id="bl" aria-describedby="helpId" placeholder="BL" required>
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
        <h5 class="card-title mb-0">Derniers enregistrements</h5>
      </div>
      <table class="table table-hover my-0">
        <thead>
          <tr>
            <th>Client</th>
            <th class="d-none d-lg-table-cell">Consignataire</th>
            <th class="d-none d-lg-table-cell">Compagnie</th>
            <th class="d-none d-xl-table-cell">Nombre de 20'</th>
            <th class="d-none d-xl-table-cell">Nombre de 40'</th>
            <th class="d-none d-md-table-cell">Montant</th>
            <th class="d-none d-xl-table-cell">Date</th>
            <th>Statut</th>
            <th></th>
          </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
        </tfoot>
      </table>
    </div>
  </div>
</div>



<script>
  const checkUrl = '<?= base_url('api/utils/checkData') ?>';
  const token = '<?= csrf_hash() ?>';
</script>

<script src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script type="application/javascript" src="https://unpkg.com/babel-standalone@6.26.0/babel.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="<?= base_url('assets/js/react.js') ?>" type="text/babel"></script>

<?= $this->endSection(); ?>