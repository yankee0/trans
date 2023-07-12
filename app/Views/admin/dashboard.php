<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
<?= APP_NAME ?> Dashboard
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>
<div class="row">
  <!-- nombre de clients -->
  <div class="col-md-6 col-lg-4 col-xl-3">
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

  <!-- facturation de livraisons impayées -->
  <div class="col-md-6 col-lg-4 col-xl-3">
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
</div>
<h2 class="h3 mb-3">Encaissements livraisons</h2>
<div class="row">
  <div class="col-xl">
    <div class="row row-cols-2">
      <!-- Encaissements journaliers livraisons -->
      <div>
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col mt-0">
                <h5 class="card-title">Journaliers</h5>
              </div>
              <div class="col-auto">
                <div class="stat text-primary">
                  <i class="align-middle" data-feather="dollar-sign"></i>
                </div>
              </div>
            </div>
            <h1 class="mt-1 mb-3"><?= $sumFactLivD ?></h1>
            <div class="mb-0">
              <span class="text-muted">Total TTC en FCFA</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Encaissements hebdomadaires livraisons -->
      <div>
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col mt-0">
                <h5 class="card-title">Hebdomadaires</h5>
              </div>
              <div class="col-auto">
                <div class="stat text-primary">
                  <i class="align-middle" data-feather="dollar-sign"></i>
                </div>
              </div>
            </div>
            <h1 class="mt-1 mb-3"><?= $sumFactLivW ?></h1>
            <div class="mb-0">
              <span class="text-muted">Total TTC en FCFA</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Encaissements mensuels livraisons -->
      <div>
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col mt-0">
                <h5 class="card-title">Mensuels</h5>
              </div>
              <div class="col-auto">
                <div class="stat text-primary">
                  <i class="align-middle" data-feather="dollar-sign"></i>
                </div>
              </div>
            </div>
            <h1 class="mt-1 mb-3"><?= $sumFactLivM ?></h1>
            <div class="mb-0">
              <span class="text-muted">Total TTC en FCFA</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Encaissements annuels livraisons -->
      <div>
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col mt-0">
                <h5 class="card-title">Annuels</h5>
              </div>
              <div class="col-auto">
                <div class="stat text-primary">
                  <i class="align-middle" data-feather="dollar-sign"></i>
                </div>
              </div>
            </div>
            <h1 class="mt-1 mb-3"><?= $sumFactLivY ?></h1>
            <div class="mb-0">
              <span class="text-muted">Total TTC en FCFA</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl">
    <div class="card flex-fill w-100">
      <div class="card-header">
        <h5 class="card-title mb-0">Statistiques annuelles des livraisons enregistrées</h5>
      </div>
      <div class="card-body d-flex w-100">
        <div class="align-self-center chart chart-lg">
          <canvas id="fin-chartjs-dashboard-bar"></canvas>
        </div>
      </div>
    </div>
  </div>

</div>
<h2 class="h3 mb-3">Décompte livraisons</h2>
<div class="row">
  <div class="col-xl order-xl-2">
    <div class="row row-cols-2">
      <!-- nombre de livraisons journalières -->
      <div>
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col mt-0">
                <h5 class="card-title">Journalières</h5>
              </div>
              <div class="col-auto">
                <div class="stat text-primary">
                  <i class="align-middle" data-feather="box"></i>
                </div>
              </div>
            </div>
            <h1 class="mt-1 mb-3"><?= $livsDailyCount ?></h1>
            <div class="mb-0">
              <span class="text-muted">Total</span>
            </div>
          </div>
        </div>
      </div>

      <!-- nombre de livraisons Hebdomadaires -->
      <div>
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col mt-0">
                <h5 class="card-title">Hebdomadaires</h5>
              </div>
              <div class="col-auto">
                <div class="stat text-primary">
                  <i class="align-middle" data-feather="box"></i>
                </div>
              </div>
            </div>
            <h1 class="mt-1 mb-3"><?= $livsWeekyCount ?></h1>
            <div class="mb-0">
              <span class="text-muted">Total</span>
            </div>
          </div>
        </div>
      </div>

      <!-- nombre de livraisons Mensuelles -->
      <div>
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col mt-0">
                <h5 class="card-title">Mensuelles</h5>
              </div>
              <div class="col-auto">
                <div class="stat text-primary">
                  <i class="align-middle" data-feather="box"></i>
                </div>
              </div>
            </div>
            <h1 class="mt-1 mb-3"><?= $livsMonthlyCount ?></h1>
            <div class="mb-0">
              <span class="text-muted">Total</span>
            </div>
          </div>
        </div>
      </div>

      <!-- nombre de livraisons Annuelles -->
      <div>
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col mt-0">
                <h5 class="card-title">Annuelles</h5>
              </div>
              <div class="col-auto">
                <div class="stat text-primary">
                  <i class="align-middle" data-feather="box"></i>
                </div>
              </div>
            </div>
            <h1 class="mt-1 mb-3"><?= $livsYearlyCount ?></h1>
            <div class="mb-0">
              <span class="text-muted">Total</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl order-xl-1">
    <div class="card flex-fill w-100">
      <div class="card-header">
        <h5 class="card-title mb-0">Statistiques annuelles des états</h5>
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
</div>

<!-- bar -->
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
      new Chart(document.getElementById("fin-chartjs-dashboard-bar"), {
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

<!-- pie -->
<script>
  document.addEventListener("DOMContentLoaded", function() {

    const pie_stat_liv = $.ajax({
      type: "get",
      url: "<?= base_url('api/graph/pie_stat_liv') ?>",
      data: {
        token: '<?= csrf_hash() ?>'
      },
      dataType: "JSON",
    });

    pie_stat_liv.done(res => {
      // console.log(res);
      new Chart(document.getElementById("chartjs-dashboard-pie"), {
        type: "pie",
        data: {
          labels: [
            "Sur plateau",
            "Mise à terre",
            "En cours",
            "Livrés",
            "Annulés",
          ],
          datasets: [{
            data: res,
            backgroundColor: [
              window.theme.info,
              '#2d3436',
              window.theme.warning,
              window.theme.success,
              window.theme.danger
            ],
            borderWidth: 5
          }]
        },
        options: {
          responsive: !window.MSInputMethodContext,
          maintainAspectRatio: false,
          legend: {
            display: true
          },
          cutoutPercentage: 75
        }
      });
    })

  });
</script>

<?= $this->endSection(); ?>