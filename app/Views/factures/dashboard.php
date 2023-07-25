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
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">Toutes</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="unpaid-tab" data-bs-toggle="tab" data-bs-target="#unpaid" type="button" role="tab" aria-controls="unpaid" aria-selected="false">Impayées</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="paid-tab" data-bs-toggle="tab" data-bs-target="#paid" type="button" role="tab" aria-controls="paid" aria-selected="false">Payées</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="aborded-tab" data-bs-toggle="tab" data-bs-target="#aborded" type="button" role="tab" aria-controls="aborded" aria-selected="false">Annulées</button>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active " id="all" role="tabpanel" aria-labelledby="all-tab">
          <div class="table-responsive">
            
          </div>  
          <table id="all-table" class="table table-hover my-0">
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
          </div>
          <div class="tab-pane " id="unpaid" role="tabpanel" aria-labelledby="unpaid-tab">
          <div class="table-responsive">
            
          </div>  
          <table id="unpaid-table" class="table table-hover my-0 ">
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
          </div>
          <div class="tab-pane" id="paid" role="tabpanel" aria-labelledby="paid-tab">
          <div class="table-responsive">
            
          </div>  
          <table id="paid-table" class="table table-hover my-0 ">
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
          </div>
          <div class="tab-pane" id="aborded" role="tabpanel" aria-labelledby="aborded-tab">
          <div class="table-responsive">
            
          </div>  
          <table id="aborded-table" class="table table-hover my-0 ">
              <thead>
                <tr>
                  <th class="d-table-cell">Nº Facture</th>
                  <th class="d-table-cell">Nº Compte client</th>
                  <th class="d-table-cell">Client</th>
                  <th class="d-table-cell">Motif d'annulation</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($aborded as $l) : ?>
                  <tr>
                    <td><?= $l['facture'] ?></td>
                    <td><?= $l['client'] ?></td>
                    <td><?= $l['nom'] ?></td>
                    <td><?= $l['motif'] ?></td>

                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
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

    $('#all-table,#paid-table,#unpaid-table,#aborded-table').DataTable({
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