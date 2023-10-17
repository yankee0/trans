<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Rapports
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Rapports</strong> dashboard</h1>

<div class="row">

  <div class="d-flex col-md-6 col-xl-3">
    <div class="card flex-fill">
      <img src="<?= base_url('assets/img/pregate.jpg') ?>" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title">Rapport des pregate</h5>
        <p class="card-text">pregate enregistrés.</p>
        <a href="<?= base_url(session()->r . '/rapports/pregate') ?>" class="btn btn-sm btn-primary">Accéder <i data-feather="arrow-right"></i></a>
      </div>
    </div>
  </div>

  <div class="d-flex col-md-6 col-xl-3">
    <div class="card flex-fill">
      <img src="<?= base_url('assets/img/truck.jpeg') ?>" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title">Rapport des livraisons</h5>
        <p class="card-text">Rapports sur les livraisons de <?= APP_NAME ?>.</p>
        <a href="<?= base_url(session()->r . '/rapports/livraisons') ?>" class="btn btn-sm btn-primary">Accéder <i data-feather="arrow-right"></i></a>
      </div>
    </div>
  </div>

  <div class="d-flex col-md-6 col-xl-3">
    <div class="card flex-fill">
      <img src="<?= base_url('assets/img/fuel.jpeg') ?>" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title">Rapport carburant</h5>
        <p class="card-text">Rapports sur la consommation de carburant.</p>
        <a href="<?= base_url(session()->r . '/rapports/carburant') ?>" class="btn btn-sm btn-primary">Accéder <i data-feather="arrow-right"></i></a>
      </div>
    </div>
  </div>

  <?php if (session()->r == 'finance' or session()->r == 'admin') : ?>
    <div class="d-flex col-md-6 col-xl-3">
      <div class="card flex-fill">
        <img src="<?= base_url('assets/img/money.jpeg') ?>" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Rapport financier</h5>
          <p class="card-text">Rapports sur l'état financier de <?= APP_NAME ?>.</p>
          <a href="<?= base_url(session()->r . '/rapports/finance') ?>" class="btn btn-sm btn-primary">Accéder <i data-feather="arrow-right"></i></a>
        </div>
      </div>
    </div>
    <div class="d-flex col-md-6 col-xl-3">
      <div class="card flex-fill">
        <img src="<?= base_url('assets/img/appro.webp') ?>" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title">Rapport Appro</h5>
          <p class="card-text">Rapports sur les approvisionnements de <?= APP_NAME ?>.</p>
          <a href="<?= base_url(session()->r . '/rapports/approvisionnements') ?>" class="btn btn-sm btn-primary">Accéder <i data-feather="arrow-right"></i></a>
        </div>
      </div>
    </div>
  <?php endif ?>

</div>





<?= $this->endSection(); ?>