<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Factures
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Factures</strong></h1>


<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Factures de livraisons</h4>
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Toutes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Non payées</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Payées</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Annulées</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="all" class="table table-hover my-0">
            <thead>
              <tr>
                <th class="d-table-cell">Nº Facture</th>
                <th class="d-table-cell">Nº Compte client</th>
                <th class="d-table-cell">Client</th>
                <th class="d-table-cell">Consignataire</th>
                <th class="d-table-cell">Paiement</th>
                <th class="d-table-cell">Montant TTC</th>
                <th class="d-table-cell">Date de paiement</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($all as $l) : ?>
                <tr>
                  <td><?= $l['facture'] ?></td>
                  <td><?= $l['client'] ?></td>
                  <td><?= $l['nom'] ?></td>
                  <td><?= $l['consignataire'] ?></td>
                  <td><?= $l['paiement'] ?></td>
                  <td><?= intval($l['total']) ?></td>
                  <td><?= $l['date_paiement'] ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
          <table id="unpaid" class="table table-hover my-0 d-none">
            <thead>
              <tr>
                <th class="d-table-cell">Nº Facture</th>
                <th class="d-table-cell">Nº Compte client</th>
                <th class="d-table-cell">Client</th>
                <th class="d-table-cell">Consignataire</th>
                <th class="d-table-cell">Paiement</th>
                <th class="d-table-cell">Montant TTC</th>
                <th class="d-table-cell">Date de paiement</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($unpaid as $l) : ?>
                <tr>
                  <td><?= $l['facture'] ?></td>
                  <td><?= $l['client'] ?></td>
                  <td><?= $l['nom'] ?></td>
                  <td><?= $l['consignataire'] ?></td>
                  <td><?= $l['paiement'] ?></td>
                  <td><?= intval($l['total']) ?></td>
                  <td><?= $l['date_paiement'] ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
          <table id="paid" class="table table-hover my-0 d-none">
            <thead>
              <tr>
                <th class="d-table-cell">Nº Facture</th>
                <th class="d-table-cell">Nº Compte client</th>
                <th class="d-table-cell">Client</th>
                <th class="d-table-cell">Consignataire</th>
                <th class="d-table-cell">Paiement</th>
                <th class="d-table-cell">Montant TTC</th>
                <th class="d-table-cell">Date de paiement</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($paid as $l) : ?>
                <tr>
                  <td><?= $l['facture'] ?></td>
                  <td><?= $l['client'] ?></td>
                  <td><?= $l['nom'] ?></td>
                  <td><?= $l['consignataire'] ?></td>
                  <td><?= $l['paiement'] ?></td>
                  <td><?= intval($l['total']) ?></td>
                  <td><?= $l['date_paiement'] ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
          <table id="aborded" class="table table-hover my-0 d-none">
            <thead>
              <tr>
                <th class="d-table-cell">Nº Facture</th>
                <th class="d-table-cell">Nº Compte client</th>
                <th class="d-table-cell">Client</th>
                <th class="d-table-cell">Consignataire</th>
                <th class="d-table-cell">Paiement</th>
                <th class="d-table-cell">Montant TTC</th>
                <th class="d-table-cell">Date de paiement</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($aborded as $l) : ?>
                <tr>
                  <td><?= $l['facture'] ?></td>
                  <td><?= $l['client'] ?></td>
                  <td><?= $l['nom'] ?></td>
                  <td><?= $l['consignataire'] ?></td>
                  <td><?= $l['paiement'] ?></td>
                  <td><?= intval($l['total']) ?></td>
                  <td><?= $l['date_paiement'] ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>




<?= $this->endSection(); ?>