<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Dashboard livraisons
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<div class="container-fluid p-0">

  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0"><strong>Livraisons</strong> Dashboard</h1>
    <a class="btn btn-primary d-flex gap-1 align-items-center" href="<?= base_url(session()->r . '/livraisons/preget') ?>" role="button">
      <i data-feather="plus"></i><span>Preget</span>
    </a>
  </div>
  <div class="col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-body ">
        <form action="<?= base_url(session()->r . '/search') ?>#livraisons" class="d-flex gap-2">
          <input type="search" value="<?= (isset($search)) ? $search : '' ?>" class="form-control flex-grow-1" name="search" id="search" placeholder="Rechercher un conteneur">
          <button class="btn btn-primary d-flex gap-2 justify-content-center align-items-center"><i data-feather="search"></i> <span class="d-none d-md-flex">Rechercher</span></button>
        </form>
      </div>
    </div>
  </div>



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
          <h5 class="card-title mb-0">Derniers enregistrements</h5>
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
                  <th>BL</th>
                  <th>Compagnie</th>
                  <th>Client</th>
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
                    <td><?= $liv['bl'] ?></td>
                    <td><?= $liv['compagnie'] ?></td>
                    <td><?= $liv['nom_client'] ?></td>
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
                    <td>
                      <div class="d-flex justify-content-around">
                        <button type="button" value="<?= $liv['id'] ?>" data-container="<?= $liv['conteneur'] ?>" class="update btn border-0 text-dark dropDelv <?= ($liv['etat'] == 'MISE À TERRE' or $liv['etat'] == 'LIVRÉ') ? 'disabled' : '' ?>" title="Mise à terre" data-bs-toggle="modal" data-bs-target="#delivDrop"><i cla data-feather="arrow-down"></i></button>
                        <button type="button" value="<?= $liv['id'] ?>" data-container="<?= $liv['conteneur'] ?>" class="update btn border-0 text-info upDelv <?= ($liv['etat'] == 'SUR PLATEAU' or $liv['etat'] == 'LIVRÉ') ? 'disabled' : '' ?>" title="Mise sur plateau" data-bs-toggle="modal" data-bs-target="#uptc"><i cla data-feather="arrow-up"></i></button>
                        <button type="button" value="<?= $liv['id'] ?>" data-container="<?= $liv['conteneur'] ?>" data-id="<?= $liv['id'] ?>" data-challer="<?= $liv['ch_aller_id'] ?>" data-chretour="<?= $liv['ch_retour_id'] ?>" data-camaller="<?= $liv['cam_aller_id'] ?>" data-camretour="<?= $liv['cam_retour_id'] ?>" data-datealler="<?= $liv['date_aller'] ?>" data-dateretour="<?= $liv['date_retour'] ?>" data-commentaire="<?= $liv['commentaire'] ?>" data-etat="<?= $liv['etat'] == 'LIVRÉ' ? 'true' : 'false' ?>" class="update btn border-0 text-warning infDelv" title="Livraison" data-bs-toggle="modal" data-bs-target="#livInf"><i cla data-feather="truck"></i></button>
                        <button type="button" value="<?= $liv['id'] ?>" data-container="<?= $liv['conteneur'] ?>" class="update btn border-0 text-danger abordDelv border-0 <?= $liv['etat'] == 'ANNULÉ' ? 'disabled' : '' ?>" title="Annuler" data-bs-toggle="modal" data-bs-target="#abordDelv"><i cla data-feather="x"></i></button>
                        <a role="button" href="<?= base_url(session()->r . '/livraisons/infos/' . $liv['bl'] . '/' . $liv['conteneur']) ?>" class="update btn border-0 text-info" title="Information"><i cla data-feather="info"></i></a>

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

    <!-- annuler livraisons -->
    <div class="modal fade" id="abordDelv" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="abdelvti" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="abdelvti">Annulation de livraison</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?= form_open(
              base_url(session()->r . '/livraisons/abord'),
              [
                'id' => 'abDeliveryForm'
              ]
            ) ?>
            Annuler la livraison <span class="text-primary" id="abDelivery"></span> ?<br>
            Quel est le motif de l'annulation:
            <div>
              <textarea class="form-control" name="motif" rows="3"></textarea>
            </div>
            <?= csrf_field() ?>
            <?= form_close() ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" form="abDeliveryForm" id="abDeliveryBtn" name="id" class="btn btn-primary">Annuler la livraison</a>
          </div>
        </div>
      </div>
    </div>
    <script>
      $('.abordDelv').click(function(e) {
        e.preventDefault();
        $('#abDelivery').html($(this).attr('data-container'));
        $('#abDeliveryBtn').val($(this).val());
      });
    </script>
    <script>
      const myModalAbordDeliv = new bootstrap.Modal(document.getElementById('abordDelv'), options)
    </script>

    <!-- mise à terre livraisons -->
    <div class="modal fade" id="delivDrop" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitleId">Mise à terre conteneur</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Mettre à terre le conteneur <span class="text-primary" id="dropTC"></span> ?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <a id="dropTCLink" type="button" class="btn btn-primary">Mettre à terre</a>
          </div>
        </div>
      </div>
    </div>
    <script>
      $('.dropDelv').click(function(e) {
        e.preventDefault();
        $('#dropTC').html($(this).attr('data-container'));
        $('#dropTCLink').attr('href', '<?= base_url(session()->r . '/livraisons/drop/') ?>' + $(this).val());
      });
    </script>
    <script>
      const myModalDropDelv = new bootstrap.Modal(document.getElementById('delivDrop'), options)
    </script>

    <!-- sur plateau -->
    <div class="modal fade" id="uptc" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="uppp" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uppp">Mise sur plateau</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Mettre sur plateau le conteneur <span class="text-primary" id="upContainer"></span> ?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <a id="upTCLink" class="btn btn-primary">Mise sur plateau</a>
          </div>
        </div>
      </div>
    </div>
    <script>
      $('.upDelv').click(function(e) {
        e.preventDefault();
        $('#upContainer').html($(this).attr('data-container'));
        $('#upTCLink').attr('href', '<?= base_url(session()->r . '/livraisons/up/') ?>' + $(this).val());
      });
    </script>
    <script>
      const myModalUpTc = new bootstrap.Modal(document.getElementById('uptc'), options)
    </script>

    <!-- gestion de la livraison -->
    <div class="modal fade" id="livInf" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitleId">Livraison</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?= form_open(base_url(session()->r . '/livraisons'), [
              'id' => 'livsForm'
            ]) ?>
            <h2>Nº TC <span class="text-primary" id="TCnum"></span></h2>
            <div class="row">
              <div class="col-md">
                <h4 class="text-primary">ALLER</h4>
                <div class="form-floating mb-3">
                  <select name="ch_aller" class="form-select" id="ch_aller" aria-label="Floating label select example">
                    <option selected value="">Sélectionner</option>
                    <?php foreach ($drivers as $d) : ?>
                      <option class="chAllerOp" value="<?= $d['id'] ?>"><?= $d['nom'] ?></option>
                    <?php endforeach ?>
                  </select>
                  <label for="floatingSelect">Chauffeur</label>
                </div>
                <div class="form-floating mb-3">
                  <select name="cam_aller" class="form-select" id="cam_aller" aria-label="Floating label select example">
                    <option selected value="">Sélectionner</option>
                    <?php foreach ($trucks as $t) : ?>
                      <option class="camAllerOp" value="<?= $t['id'] ?>"><?= $t['im'] ?></option>
                    <?php endforeach ?>
                  </select>
                  <label for="floatingSelect">Camion</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="date" class="form-control" name="date_aller" id="date_aller" placeholder="">
                  <label for="date_aller">Date</label>
                </div>
              </div>
              <div class="col-md">
                <h4 class="text-primary">RETOUR</h4>
                <div class="form-floating mb-3">
                  <select name="ch_retour" class="form-select" id="ch_retour" aria-label="Floating label select example">
                    <option selected value="">Sélectionner</option>
                    <?php foreach ($drivers as $d) : ?>
                      <option class="chRetourOp" value="<?= $d['id'] ?>"><?= $d['nom'] ?></option>
                    <?php endforeach ?>
                  </select>
                  <label for="floatingSelect">Chauffeur</label>
                </div>
                <div class="form-floating mb-3">
                  <select name="cam_retour" class="form-select" id="cam_retour" aria-label="Floating label select example">
                    <option selected value="">Sélectionner</option>
                    <?php foreach ($trucks as $t) : ?>
                      <option class="camRetourOp" value="<?= $t['id'] ?>"><?= $t['im'] ?></option>
                    <?php endforeach ?>
                  </select>
                  <label for="floatingSelect">Camion</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="date" class="form-control" name="date_retour" id="date_retour" placeholder="">
                  <label for="date_retour">Date</label>
                </div>
              </div>
              <div class="col-12 mb-3">
                <div class="form-floating">
                  <textarea id="commentaire" name="commentaire" class="form-control" placeholder="Des remarques concernants la livraisons"></textarea>
                  <label for="commentaire">Commentaire</label>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="form-check form-switch">
                    <input class="form-check-input" name="eirs" type="checkbox" id="eirs">
                    <label class="form-check-label" for="eirs">Retour EIRs</label>
                  </div>
                </div>
              </div>
            </div>
            <?= csrf_field() ?>
            <?= form_close() ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" form="livsForm" id="livSub" name="id" value="" class="btn btn-primary">Enregistrer</button>
          </div>
        </div>
      </div>
    </div>
    <script>
      $('.infDelv').click(function(e) {
        e.preventDefault();
        $('#livSub').val($(this).val());
        $('#TCnum').html($(this).attr('data-container'));
        $('#date_aller').val($(this).data('datealler'));
        $('#date_retour').val($(this).data('dateretour'));
        $('#cam_aller').val($(this).data('camaller'));
        $('#cam_retour').val($(this).data('camretour'));
        $('#ch_aller').val($(this).data('challer'));
        $('#ch_retour').val($(this).data('chretour'));
        $('#commentaire').val($(this).data('commentaire'));
        document.getElementById('eirs').checked = $(this).data('etat');
      });
    </script>
    <script>
      const myModal = new bootstrap.Modal(document.getElementById('livInf'), options)
    </script>

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