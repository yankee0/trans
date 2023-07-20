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
          <input type="search" value="<?= (isset($search)) ? $search : '' ?>" class="form-control flex-grow-1" name="search" id="search" placeholder="Rechercher par Nº Facture, BL, Compagnie ou date d'enregistrement">
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
      <div class="card-body">
        <?php if (sizeof($r) == 0) : ?>
          <div class="alert alert-warning" role="alert">
            Aucun résultat
          </div>

        <?php else : ?>
          <?php foreach ($r as $res) : ?>
            <article>
              <h3 class="d-flex align-items-center justify-content-between">
                <a href="<?= base_url(session()->r . '/livraisons/edit/' . $res['id']) ?>" class="fs-3">
                  Facture Nº <?= $res['id'] ?>
                </a>
              </h3>
              <p class=" text-opacity-75">
                BL Nº <strong><?= $res['bl'] ?></strong> de la compagnie <strong><?= $res['compagnie'] ?></strong> <br>
                Consignataire: <strong><?= $res['consignataire'] ?></strong> <br>
                <span class="text-muted text-sm">Créée le <?= $res['date_creation'] ?></span>
              </p>
            </article>
            <hr>
          <?php endforeach ?>
        <?php endif ?>
      </div>
      <div class="card-footer text-muted d-flex align-items-center justify-content-end">
        <?= $pager->links() ?>
      </div>
    </div>
  </div>

</div>



<?= $this->endSection(); ?>