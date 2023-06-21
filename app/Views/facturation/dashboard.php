<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
<?= APP_NAME ?> Dashboard
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<div class="container-fluid p-0">

  <h1 class="h3 mb-3"><strong>Facturations</strong> Dashboard</h1>
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
    <div class="col-md-6 col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col mt-0">
              <h5 class="card-title">Clients</h5>
            </div>
            <div class="col-auto">
              <div class="stat text-primary">
                <i class="align-middle" data-feather="clipboard"></i>
              </div>
            </div>
          </div>
          <h1 class="mt-1 mb-3"><?= '[]' ?></h1>
          <div class="mb-0">
            <span class="text-muted">Total</span><br>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col mt-0">
              <h5 class="card-title">Facture livraisons</h5>
            </div>

            <div class="col-auto">
              <div class="stat text-primary">
                <i class="align-middle" data-feather="box"></i>
              </div>
            </div>
          </div>
          <h1 class="mt-1 mb-3"><?= '#' ?></h1>
          <div class="mb-0">
            <span class="text-warning"> <i class="mdi mdi-arrow-bottom-right"></i> <?= '#' ?> en attente PREGET</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-lg-5 col-xl-4 d-flex">
      <div class="card flex-fill w-100">
        <div class="card-header">
          <h5 class="card-title mb-0">Statistiques mensuel des factures</h5>
        </div>
        <div class="card-body d-flex">
          <div class="align-self-center w-100">
            <div class="py-3">
              <div class="chart chart-sm">
                <canvas id="chartjs-dashboard-pie"></canvas>
              </div>
            </div>

            <table class="table mb-0">
              <tbody>
                <tr>
                  <td>En attente preget</td>
                  <td class="text-end">[]</td>
                </tr>
                <tr>
                  <td>Annulé</td>
                  <td class="text-end">[]</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-7 col-xl-8 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <h5 class="card-title mb-0">Montant de facturation mensuel</h5>
        </div>
        <div class="card-body">
          <canvas id="chartjs-dashboard-bar"></canvas>
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
              <th>Nº Facture</th>
              <th class="d-none d-lg-table-cell">CIE</th>
              <th class="d-none d-xl-table-cell">Nombre de 20'</th>
              <th class="d-none d-xl-table-cell">Nombre de 40'</th>
              <th class="d-none d-md-table-cell">Montant</th>
              <th class="d-none d-xl-table-cell">Date</th>
              <th>Preget</th>
              <th>Paiement</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($fact_liv_last as $line) : ?>
              <tr>
                <td>Nº <?= $line['id'] ?></td>
                <td class="d-none d-lg-table-cell"><?= $line['compagnie'] ?></td>
                <td class="d-none d-xl-table-cell"><?= $line['n20'] ?></td>
                <td class="d-none d-xl-table-cell"><?= $line['n40'] ?></td>
                <td class="d-none d-md-table-cell"><?= $line['total'] ?></td>
                <td class="d-none d-xl-table-cell"><?= $line['created_at'] ?></td>
                <td><span class="badge bg-<?= ($line['preget'] == 'NON') ? 'warning' : 'success' ?>"><?= ($line['preget'] == 'NON') ? 'NON REÇU' : 'REÇU LE ' . $line['date_preget'] ?></span></td>
                <td><span class="badge bg-<?= ($line['paiement'] == 'NON') ? 'warning' : 'success' ?>"><?= ($line['paiement'] == 'NON') ? 'NON REÇU' : 'PAYÉ LE ' . $line['date_paiement'] ?></span></td>
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
              <a href="#">Tout voir</a>
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
  document.addEventListener("DOMContentLoaded", function() {
    // Pie chart
    new Chart(document.getElementById("chartjs-dashboard-pie"), {
      type: "pie",
      data: {
        labels: ["En attente preget", "Annulé"],
        datasets: [{
          data: [4306, 3801],
          backgroundColor: [
            window.theme.primary,
            window.theme.danger,
          ],
          borderWidth: 5
        }]
      },
      options: {
        responsive: !window.MSInputMethodContext,
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        cutoutPercentage: 75
      }
    });
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Bar chart
    new Chart(document.getElementById("chartjs-dashboard-bar"), {
      type: "bar",
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Livraisons",
          backgroundColor: window.theme.primary,
          borderColor: window.theme.primary,
          hoverBackgroundColor: window.theme.primary,
          hoverBorderColor: window.theme.primary,
          data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
          barPercentage: .75,
          categoryPercentage: .5
        }]
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          display: true
        },
        scales: {
          yAxes: [{
            gridLines: {
              display: false
            },
            stacked: false,
            ticks: {
              stepSize: 20
            }
          }],
          xAxes: [{
            stacked: false,
            gridLines: {
              color: "transparent"
            }
          }]
        }
      }
    });
  });
</script>

<script>
  $('.delfLiv').click(function(e) {
    e.preventDefault();
    $('#nFactLiv').html($(this).val());
    $('#delfLivB').attr('href', '<?= base_url(session()->r.'/livraisons/del/') ?>'+$(this).val());
  });
</script>

<?= $this->endSection(); ?>