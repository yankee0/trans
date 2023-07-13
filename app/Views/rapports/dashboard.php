<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Rapports
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Rapports</strong> dashboard</h1>

<div class="row">

  <div class=" col-sm-6 col-md-4 col-lg-3">
    <div class="card">
      <img src="<?= base_url('assets/img/truck.jpeg') ?>" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title">Rapport des livraisons</h5>
        <p class="card-text">Rapports sur les livraisons de <?= APP_NAME ?>.</p>
        <a href="<?= base_url(session()->r.'/rapports/livraisons') ?>">Accéder</a>
      </div>
    </div>
  </div>

  <div class=" col-sm-6 col-md-4 col-lg-3">
    <div class="card">
      <img src="<?= base_url('assets/img/fuel.jpeg') ?>" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title">Rapport carburant</h5>
        <p class="card-text">Rapports sur la consommation de carburant.</p>
        <a href="<?= base_url(session()->r.'/rapports/carburant') ?>">Accéder</a>
      </div>
    </div>
  </div>

  <div class=" col-sm-6 col-md-4 col-lg-3">
    <div class="card">
      <img src="<?= base_url('assets/img/money.jpeg') ?>" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title">Rapport financier</h5>
        <p class="card-text">Rapports sur l'état financier de <?= APP_NAME ?>.</p>
        <a href="<?= base_url(session()->r.'/rapports/finance') ?>">Accéder</a>
      </div>
    </div>
  </div>

</div>





<?= $this->endSection(); ?>