<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Dashboard
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><strong>Facturations</strong> Dashboard</h1>
  <div class="row">
    <div class="col-md-6 col-lg-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col mt-0">
              <h5 class="card-title">Clients</h5>
            </div>
            <div class="col-auto">
              <div class="stat text-primary">
                <i class="align-middle" data-feather="users"></i>
              </div>
            </div>
          </div>
          <h1 class="mt-1 mb-3"><?= $cli ?></h1>
          <div class="mb-0">
            <span class="text-muted">Total</span><br>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col mt-0">
              <h5 class="card-title">Factures non payées</h5>
            </div>
            <div class="col-auto">
              <div class="stat text-primary">
                <i class="align-middle" data-feather="file"></i>
              </div>
            </div>
          </div>
          <h1 class="mt-1 mb-3"><?= $factLivNotPaid ?></h1>
          <div class="mb-0">
            <span class="text-muted">Total pour livraisons</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col mt-0">
              <h5 class="card-title">Livraisons</h5>
            </div>
            <div class="col-auto">
              <div class="stat text-primary">
                <i class="align-middle" data-feather="box"></i>
              </div>
            </div>
          </div>
          <h1 class="mt-1 mb-3"><?= $sumFactLiv ?></h1>
          <div class="mb-0">
            <span class="text-muted">Total TTC mensuel en FCFA</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <h2 class="h3 mb-3">Encaissements livraisons</h2>
  <div class="row">
    <div class="col-md-6 col-lg-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col mt-0">
              <h5 class="card-title">Journalier</h5>
            </div>
            <div class="col-auto">
              <div class="stat text-primary">
                <i class="align-middle" data-feather="box"></i>
              </div>
            </div>
          </div>
          <h1 class="mt-1 mb-3"><?= $sumFactLiv ?></h1>
          <div class="mb-0">
            <span class="text-muted">Total TTC en FCFA</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col mt-0">
              <h5 class="card-title">Hebdomadaire</h5>
            </div>
            <div class="col-auto">
              <div class="stat text-primary">
                <i class="align-middle" data-feather="box"></i>
              </div>
            </div>
          </div>
          <h1 class="mt-1 mb-3"><?= $sumFactLiv ?></h1>
          <div class="mb-0">
            <span class="text-muted">Total TTC en FCFA</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col mt-0">
              <h5 class="card-title">Mensuel</h5>
            </div>
            <div class="col-auto">
              <div class="stat text-primary">
                <i class="align-middle" data-feather="box"></i>
              </div>
            </div>
          </div>
          <h1 class="mt-1 mb-3"><?= $sumFactLiv ?></h1>
          <div class="mb-0">
            <span class="text-muted">Total TTC en FCFA</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-lg-5 d-flex">
      <div class="card flex-fill w-100">
        <div class="card-header">
          <h5 class="card-title mb-0">État des factures de livraisons</h5>
        </div>
        <div class="card-body d-flex">
          <div class="align-self-center w-100">
            <div class="py-3">
              <div class="chart chart-sm">
                <canvas id="chartjs-dashboard-pie"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-lg-7 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <h5 class="card-title mb-0">Montant de facturation mensuel (PAYÉES)</h5>
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
        <div class="table-responsive">
          <table class="table table-hover my-0">
            <thead>
              <tr>
                <th>Nº Facture</th>
                <th class="table-cell">Nº BL</th>
                <th class="d-none d-md-table-cell">Montant TTC</th>
                <th class="d-none d-xl-table-cell">Date</th>
                <th>Paiement</th>
                <th>Réglement</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($fact_liv_last as $line) : ?>
                <tr>
                  <td><?= $line['id'] ?></td>
                  <td class="table-cell"><?= $line['bl'] ?></td>
                  <td class="d-none d-md-table-cell"><?= $line['total'] ?></td>
                  <td class="d-none d-xl-table-cell"><?= $line['created_at'] ?></td>
                  <td><span class="badge bg-<?= ($line['paiement'] == 'NON') ? 'warning' : 'success' ?>"><?= ($line['paiement'] == 'NON') ? 'NON REÇU' : 'PAYÉ' ?></span></td>
                  <td><span class="badge bg-<?= ($line['reglement'] == 'NON PAYÉ' or $line['reglement'] == 'À CRÉDIT') ? 'danger' : 'success' ?>"><?= $line['reglement'] ?></span></td>
                  <td class="d-flex gap-1">
                    <a class="btn text-info btn-sm d-flex align-items-center justify-content-center gap-2" title="Voir les informations" href="<?= base_url(session()->r . '/livraisons/details/' . $line['id']) ?>" target="_blank" role="button"><i class="align-middle" data-feather="info"></i></a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
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

</div>



<script>
  $('.annfLiv').click(function(e) {
    e.preventDefault();
    $('#AF').html($(this).val());
    const id = '<?= base_url(session()->r . '/livraisons/annuler/') ?>' + $(this).attr('data-id');
    $('#AFLL').attr('href', id);
  });
</script>
<script>
  $('.delfLiv').click(function(e) {
    e.preventDefault();
    $('#nFactLiv').html($(this).val());
    $('#delfLivB').attr('href', '<?= base_url(session()->r . '/livraisons/del/') ?>' + $(this).val());
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const pie_data = $.ajax({
      type: "get",
      url: "<?= base_url('api/graph/pie_fact_liv') ?>",
      data: {
        token: '<?= csrf_hash() ?>'
      },
      dataType: "JSON",
    });

    pie_data.done(res => {
      // Pie chart
      new Chart(document.getElementById("chartjs-dashboard-pie"), {
        type: "pie",
        data: {
          labels: [
            'Factures non payées et sans preget',
            'Factures payées et sans preget',
            'Factures non payées et preget reçu',
            'Factures annulées'
          ],
          datasets: [{
            data: res,
            backgroundColor: [
              '#0097e6',
              '#fbc531',
              '#9c88ff',
              '#e74c3c'
            ],
            borderWidth: 2
          }]
        },
        options: {
          responsive: !window.MSInputMethodContext,
          maintainAspectRatio: false,
          legend: {
            display: true
          },
          cutoutPercentage: 70
        }
      });
    })
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const bar_data = $.ajax({
      type: "get",
      url: "<?= base_url('api/graph/bar_fact_liv') ?>",
      data: {
        token: '<?= csrf_hash() ?>'
      },
      dataType: "JSON",
    });
    // Bar chart
    bar_data.done(res => {
      new Chart(document.getElementById("chartjs-dashboard-bar"), {
        type: "bar",
        data: {
          labels: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Jlt", "Aoû", "Sep", "Oct", "Nov", "Déc"],
          datasets: [{
            label: "Livraisons",
            backgroundColor: '#0097e6',
            borderColor: '#0097e6',
            hoverBackgroundColor: '#0097e6',
            hoverBorderColor: '#0097e6',
            data: res.liv,
            barPercentage: .60,
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
                stepSize: 10000000
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
    })
  });
</script>

<?= $this->endSection(); ?>