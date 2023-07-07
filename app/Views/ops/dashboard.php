<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
<?= APP_NAME ?> Dashboard
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<div class="container-fluid p-0">

  <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>
  <div class="col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-body ">
        <form action="<?= base_url(session()->r . '/search') ?>" class="d-flex gap-2">
          <input type="search" value="<?= (isset($search)) ? $search : '' ?>" class="form-control flex-grow-1" name="search" id="search" placeholder="Rechercher un conteneur">
          <button class="btn btn-primary d-flex gap-2 justify-content-center align-items-center"><i data-feather="search"></i> <span class="d-none d-md-flex">Rechercher</span></button>
        </form>
      </div>
    </div>
  </div>

  <h2 class="h4 mb-3">Flotte</h2>

  <div class="row">

    <!-- nombre de chauffeurs -->
    <div class="col-md-6 col-lg-4 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col mt-0">
              <h5 class="card-title">Chauffeurs</h5>
            </div>

            <div class="col-auto">
              <div class="stat text-primary">
                <i class="align-middle" data-feather="users"></i>
              </div>
            </div>
          </div>
          <h1 class="mt-1 mb-3"><?= $driversCount ?></h1>
          <div class="mb-0">
            <span class="text-muted">Total</span>
          </div>
        </div>
      </div>
    </div>

    <!-- nombre de camion -->
    <div class="col-md-6 col-lg-4 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col mt-0">
              <h5 class="card-title">Camions</h5>
            </div>

            <div class="col-auto">
              <div class="stat text-primary">
                <i class="align-middle" data-feather="truck"></i>
              </div>
            </div>
          </div>
          <h1 class="mt-1 mb-3"><?= $trucksCount ?></h1>
          <div class="mb-0">
            <span class="text-muted">Total</span>
          </div>
        </div>
      </div>
    </div>

    <!-- nombre de remorques -->
    <div class="col-md-6 col-lg-4 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col mt-0">
              <h5 class="card-title">Remorques</h5>
            </div>

            <div class="col-auto">
              <div class="stat text-primary">
                <i class="align-middle" data-feather="truck"></i>
              </div>
            </div>
          </div>
          <h1 class="mt-1 mb-3"><?= $trailersCount ?></h1>
          <div class="mb-0">
            <span class="text-muted">Total</span>
          </div>
        </div>
      </div>
    </div>

  </div>

  <h2 class="h4 mb-3">Livraisons</h2>

  <div class="row">
    <!-- nombre de livraisons journalières -->
    <div class="col-md-6 col-lg-4 col-xl-3">
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
    <div class="col-md-6 col-lg-4 col-xl-3">
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
    <div class="col-md-6 col-lg-4 col-xl-3">
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
    <div class="col-md-6 col-lg-4 col-xl-3">
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

  <!-- liv graphs -->
  <div class="row">
    <div class="col-md-6 col-lg-7 col-xl-8 d-flex">
      <div class="card flex-fill w-100">
        <div class="card-header">

          <h5 class="card-title mb-0">Statistiques annuelles des livraisons enregistrées</h5>
        </div>
        <div class="card-body d-flex w-100">
          <div class="align-self-center chart chart-lg">
            <canvas id="chartjs-dashboard-bar"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-5 col-xl-4 d-flex">
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

    <!-- <div class=" col-xl-6 col-xxl-7">
      <div class="card flex-fill w-100">
        <div class="card-header">
          <h5 class="card-title mb-0">Mouvements recent</h5>
        </div>
        <div class="card-body py-3">
          <div class="chart chart-sm">
            <canvas id="chartjs-dashboard-line"></canvas>
          </div>
        </div>
      </div>
    </div> -->

  </div>

  <!-- liv table -->
  <div class="row">
    <div class="col-12 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <h5 class="card-title mb-0">En attente de livraison</h5>
        </div>
        <?php if (sizeof($livs['data']) == 0) : ?>
          <div class="card-body">
            <div class="alert alert-warning" role="alert">
              Vide.
            </div>
          </div>
        <?php else : ?>
          <div class=" table-responsive">
            <table class="table table-hover my-0">
              <thead>
                <tr>
                  <th>Conteneur</th>
                  <th>Type</th>
                  <th>Paiement</th>
                  <th>État</th>
                  <th>Date PREGET</th>
                  <th>Zone de destination</th>
                  <th>Adresse exacte</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($livs['data'] as $liv) : ?>
                  <tr>
                    <td><?= $liv['conteneur'] ?></td>
                    <td><?= $liv['type'] ?></td>
                    <td>
                      <?= $liv['paiement'] == 'OUI' ? '<span class="badge bg-success">OUI</span>' : '<span class="badge bg-warning">NON</span>' ?>
                    </td>
                    <td>
                      <?php
                      switch ($liv['etat']) {
                        case 'MISE À TERRE':
                      ?>
                          <span class="badge bg-dark"><?= $liv['etat'] ?></span>
                        <?php
                          break;
                        case 'SUR PLATEAU':
                        ?>
                          <span class="badge bg-info"><?= $liv['etat'] ?></span>
                        <?php
                          break;
                        case 'LIVRÉ':
                        ?>
                          <span class="badge bg-success"><?= $liv['etat'] ?></span>
                        <?php
                          break;
                        case 'ANNULÉ':
                        ?>
                          <span class="badge bg-danger"><?= $liv['etat'] ?></span>
                        <?php
                          break;
                        case 'EN COURS':
                        ?>
                          <span class="badge bg-warning"><?= $liv['etat'] ?></span>
                      <?php
                          break;

                        default:
                          echo 'Error 404';
                          break;
                      }
                      ?>
                    </td>
                    <td><?= $liv['preget'] == 'OUI' ? $liv['date_pg'] : '<span class="badge bg-dark">NON REÇU</span>' ?></td>
                    <td><?= $liv['zone'] ?></td>
                    <td><?= !(empty($liv['adresse'])) ? $liv['adresse'] : '<span class="badge bg-dark">INCONNUE</span>' ?></td>
                    <td >
                      <div class="d-flex justify-content-around">
                        <button type="button" value="" class="update btn text-success" title="Livrer" data-bs-toggle="modal" data-bs-target="#modalIdEdit"><i cla data-feather="truck"></i></button>
                        <button type="button" value="" class="update btn text-danger" title="Annuler" data-bs-toggle="modal" data-bs-target="#modalIdEdit"><i cla data-feather="x"></i></button>
                        <button type="button" value="" class="update btn text-info" title="Information" data-bs-toggle="modal" data-bs-target="#modalIdEdit"><i cla data-feather="info"></i></button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        <?php endif ?>
      </div>
    </div>

    <!-- <div class="col-12">
      <div class="card flex-fill w-100">
        <div class="card-header">

          <h5 class="card-title mb-0">Real-Time</h5>
        </div>
        <div class="card-body px-4">
          <div id="world_map" style="height:350px;"></div>
        </div>
      </div>
    </div> -->
  </div>




</div>
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
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const bar_stat_liv = $.ajax({
      type: "get",
      url: "<?= base_url('api/graph/bar_stat_liv') ?>",
      data: {
        token: '<?= csrf_hash() ?>'
      },
      dataType: "JSON",
    });

    bar_stat_liv.done(res => {
      console.log(res);
      new Chart(document.getElementById("chartjs-dashboard-bar"), {
        type: "bar",
        data: {
          labels: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Jlt", "Aoû", "Sep", "Oct", "Nov", "Déc"],
          datasets: [{
            label: "This year",
            backgroundColor: window.theme.primary,
            borderColor: window.theme.primary,
            hoverBackgroundColor: window.theme.primary,
            hoverBorderColor: window.theme.primary,
            data: res,
            barPercentage: .75,
            categoryPercentage: .5
          }]
        },
        options: {
          maintainAspectRatio: false,
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              gridLines: {
                // display: false
              },
              stacked: false,
              ticks: {
                stepSize: 300
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
<!-- <script>
  document.addEventListener("DOMContentLoaded", function() {
    var markers = [{
        coords: [31.230391, 121.473701],
        name: "Shanghai"
      },
      {
        coords: [28.704060, 77.102493],
        name: "Delhi"
      },
      {
        coords: [6.524379, 3.379206],
        name: "Lagos"
      },
      {
        coords: [35.689487, 139.691711],
        name: "Tokyo"
      },
      {
        coords: [23.129110, 113.264381],
        name: "Guangzhou"
      },
      {
        coords: [40.7127837, -74.0059413],
        name: "New York"
      },
      {
        coords: [34.052235, -118.243683],
        name: "Los Angeles"
      },
      {
        coords: [41.878113, -87.629799],
        name: "Chicago"
      },
      {
        coords: [51.507351, -0.127758],
        name: "London"
      },
      {
        coords: [40.416775, -3.703790],
        name: "Madrid "
      }
    ];
    var map = new jsVectorMap({
      map: "world",
      selector: "#world_map",
      zoomButtons: true,
      markers: markers,
      markerStyle: {
        initial: {
          r: 9,
          strokeWidth: 7,
          stokeOpacity: .4,
          fill: window.theme.primary
        },
        hover: {
          fill: window.theme.primary,
          stroke: window.theme.primary
        }
      },
      zoomOnScroll: false
    });
    window.addEventListener("resize", () => {
      map.updateSize();
    });
  });
</script> -->
<!-- <script>
  document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
    var gradient = ctx.createLinearGradient(0, 0, 0, 225);
    gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
    gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
    // Line chart
    new Chart(document.getElementById("chartjs-dashboard-line"), {
      type: "line",
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Sales ($)",
          fill: true,
          backgroundColor: gradient,
          borderColor: window.theme.primary,
          data: [
            2115,
            1562,
            1584,
            1892,
            1587,
            1923,
            2566,
            2448,
            2805,
            3438,
            2917,
            3327
          ]
        }]
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        tooltips: {
          intersect: false
        },
        hover: {
          intersect: true
        },
        plugins: {
          filler: {
            propagate: false
          }
        },
        scales: {
          xAxes: [{
            reverse: true,
            gridLines: {
              color: "rgba(0,0,0,0.0)"
            }
          }],
          yAxes: [{
            ticks: {
              stepSize: 1000
            },
            display: true,
            borderDash: [3, 3],
            gridLines: {
              color: "rgba(0,0,0,0.0)"
            }
          }]
        }
      }
    });
  });
</script> -->

<?= $this->endSection(); ?>