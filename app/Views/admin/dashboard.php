<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
<?= APP_NAME ?> Dashboard
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>
<div class="row">
  <!-- nombre de clients -->
  <div class="col-md-6 col-lg-4 col-xl-3 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <div class="row">
          <div class="col mt-0">
            <h5 class="card-title"><a href="<?= base_url(session()->r . '/clients') ?>">Clients <i data-feather="link"></i></a></h5>
          </div>
          <div class="col-auto">
            <div class="stat text-primary">
              <i class="align-middle" data-feather="users"></i>
            </div>
          </div>
        </div>
        <h1 class="mt-1 mb-3 num"><?= $cli ?></h1>
        <div class="mb-0">
          <span class="text-muted">Total</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm col-md-6 col-xl-4 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <h5 class="card-title"><a href="<?= base_url(session()->r . '/carburant') ?>"><strong>Solde de la carte carburant</strong> <i data-feather="link"></i></a></h5>
        <div class="fs-2 <?= $carte['solde'] <= 70000 ? 'text-danger' : 'text-success' ?>"><span class="num"><?= $carte['solde'] ?></span> <strong>FCFA</strong></div>
        <div class="mb-2">
          <?php if (empty($recs)) : ?>
            <small>Pas de recharge enregistrée</small>
          <?php else : ?>
            <small class="text-muted">Dernier ravitallement de <span class="num"><?= $recs[0]['montant'] ?></span> par <?= $recs[0]['nom'] ?> le <?= $recs[0]['created_at'] ?></small>
          <?php endif ?>
        </div>
        <?php if (session()->r == 'admin') : ?>
          <div class="d-flex justify-content-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#recharge">Recharger la carte</button>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>

  <div class="col-sm col-md-6 col-xl-4 d-flex">
    <div class="card flex-fill">
      <div class="card-body">
        <h5 class="card-title"><a href="<?= base_url(session()->r . '/approvisionnements') ?>"><strong>Solde compte appro</strong> <i data-feather="link"></i></a></h5>
        <div class="fs-2 <?= $cpt_appro['solde'] <= 70000 ? 'text-danger' : 'text-success' ?>"><span class="num"><?= $cpt_appro['solde'] ?></span> <strong>FCFA</strong></div>
        <div class="mb-2">
          <?php if (empty($recs_appro)) : ?>
            <small>Pas de recharge enregistrée</small>
          <?php else : ?>
            <small class="text-muted">Dernier rechargement de <span class="num"><?= $recs_appro[0]['montant'] ?></span> FCFA par <?= $recs_appro[0]['auteur'] ?> le <?= date('d/m/Y à H:i', strtotime($recs_appro[0]['date'])) ?></small>
          <?php endif ?>
        </div>
        <?php if (session()->u['profil'] === 'ADMIN' or session()->u['profil'] === 'FINANCE') : ?>
          <div class="d-flex justify-content-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approModal">Recharger le compte</button>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>

</div>
<h2 class="h3 mb-3">Encaissements livraisons</h2>
<div class="row ">
  <!-- Encaissements journaliers livraisons -->
  <div class="col-md-6 col-lg-4 col-xl-3">
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
        <h1 class="mt-1 mb-3 num"><?= $sumFactLivD ?></h1>
        <div class="mb-0">
          <span class="text-muted">Total TTC en FCFA</span>
        </div>
      </div>
    </div>
  </div>


  <!-- Encaissements hebdomadaires livraisons -->
  <div class="col-md-6 col-lg-4 col-xl-3">
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
        <h1 class="mt-1 mb-3 num"><?= $sumFactLivW ?></h1>
        <div class="mb-0">
          <span class="text-muted">Total TTC en FCFA</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Encaissements mensuels livraisons -->
  <div class="col-md-6 col-lg-4 col-xl-3">
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
        <h1 class="mt-1 mb-3 num"><?= $sumFactLivM ?></h1>
        <div class="mb-0">
          <span class="text-muted">Total TTC en FCFA</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Encaissements annuels livraisons -->
  <div class="col-md-6 col-lg-4 col-xl-3">
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
        <h1 class="mt-1 mb-3 num"><?= $sumFactLivY ?></h1>
        <div class="mb-0">
          <span class="text-muted">Total TTC en FCFA</span>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col">
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
        <h1 class="mt-1 mb-3 num"><?= $livsDailyCount ?></h1>
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
        <h1 class="mt-1 mb-3 num"><?= $livsWeekyCount ?></h1>
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
        <h1 class="mt-1 mb-3 num"><?= $livsMonthlyCount ?></h1>
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
        <h1 class="mt-1 mb-3 num"><?= $livsYearlyCount ?></h1>
        <div class="mb-0">
          <span class="text-muted">Total</span>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col">
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
<!-- modal recharge -->
<div class="modal fade" id="recharge" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="rechargeModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rechargeModalTitle">Recharge</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(
          base_url(session()->r . '/carburant/recharge'),
          [
            'id' => 'rechargeForm'
          ]
        ) ?>
        <div class="mb-3">
          <label for="montant" class="form-label">Montant</label>
          <input type="number" step="0.00001" min="1" class="form-control" name="montant" id="montant" placeholder="Montant de la recharge" required>
        </div>
        <div class="mb-3">
          <label for="created_at" class="form-label">Date de recharge</label>
          <input type="datetime-local" min="1" class="form-control" name="created_at" id="created_at" placeholder="Date de la recharge" required>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="rechargeForm" class="btn btn-success">Recharger la carte</button>
      </div>
    </div>
  </div>
</div>
<script>
  const recharge = new bootstrap.Modal(document.getElementById('recharge'), options)
</script>


<div class="modal fade" id="approModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="approTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="approTitle">Recharger le compte appro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(session()->r . '/approvisionnements/recharge', ['id' => 'form']) ?>

        <div class="mb-3">
          <label for="montantR" class="form-label">Montant en FCFA</label>
          <input type="number" min="0" class="form-control" name="montant" id="montantR" placeholder="Montant de la recharge" required>
        </div>
        <div class="mb-3">
          <label for="dateR" class="form-label">Date</label>
          <input type="datetime-local" class="form-control" name="date" id="dateR" required max="<?= date('Y-m-d') ?>">
        </div>

        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="form" class="btn btn-success">Recharger le compte</button>
      </div>
    </div>
  </div>
</div>
<script>
  const myModalAppro = new bootstrap.Modal(document.getElementById('approModal'), options)
</script>

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