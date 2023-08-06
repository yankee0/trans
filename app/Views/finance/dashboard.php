<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Dashboard
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><strong>Finance</strong> Dashboard</h1>
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
          <h1 class="mt-1 mb-3 num"><?= $cli ?></h1>
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
          <h1 class="mt-1 mb-3 num"><?= $factLivNotPaid ?></h1>
          <div class="mb-0">
            <span class="text-muted">Total pour livraisons</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <h2 class="h3 mb-3">Encaissements livraisons</h2>
  <div class="row">

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
    <!-- Etat des factures de livraisons -->
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

    <!-- Statistiques annuelles des paiements encaissés  -->
    <div class="col-md-6 col-lg-7 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <h5 class="card-title mb-0">Statistiques annuelles des paiements encaissés en <?= date('Y') ?></h5>
        </div>
        <div class="card-body">
          <canvas id="chartjs-dashboard-bar"></canvas>
        </div>
      </div>
    </div>

    <!-- tableau des dernieres facturations de livraisons enregistrées -->
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
                <th>Règlement</th>
                <th>Date de paiement</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($fact_liv_last as $line) : ?>
                <tr>
                  <td><?= $line['id'] ?></td>
                  <td class="table-cell"><?= $line['bl'] ?></td>
                  <td class="d-none d-md-table-cell num"><?= $line['total'] ?></td>
                  <td class="d-none d-xl-table-cell"><?= $line['date_creation'] ?></td>
                  <td><span class="badge bg-<?= ($line['paiement'] == 'NON') ? 'warning' : 'success' ?>"><?= ($line['paiement'] == 'NON') ? 'NON REÇU' : 'PAYÉ' ?></span></td>
                  <td><span class="badge bg-<?= ($line['reglement'] == 'NON PAYÉ' or $line['reglement'] == 'À CRÉDIT') ? 'danger' : 'success' ?>"><?= $line['reglement'] ?></span></td>
                  <td><?= $line['date_paiement'] != null ? $line['date_paiement'] : '<span class="badge bg-dark">INDÉFINIE</span>'  ?></td>
                  <td>
                    <div class="d-flex gap-1">
                      <button data-bs-toggle="modal" data-bs-target="#modalId" value="<?= $line['id'] ?>" data-date-paiement="<?= $line['date_paiement'] ?>" data-paiement="<?= $line['paiement'] ?>" data-reglement="<?= $line['reglement'] ?>" class="btn rfl text-success btn-sm d-flex align-items-center justify-content-center gap-2" title="Règler la facture" role="button"><i class="align-middle" data-feather="check"></i></button>
                      <a class="btn text-info btn-sm d-flex align-items-center justify-content-center gap-2" title="Voir les informations" href="<?= base_url(session()->r . '/livraisons/details/' . $line['id']) ?>" target="_blank" role="button"><i class="align-middle" data-feather="info"></i></a>
                    </div>
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
              <a href="<?= base_url(session()->r . '/livraisons') ?>">Tout voir</a>
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

<!-- reglement facture livraisons -->
<div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="regfactliv" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="regfactliv">Règlement de la facture <span class="text-primary" id="rfl"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div>
          <?= form_open(
            '',
            [
              'id' => 'rflF'
            ]
          ) ?>
          <div class="form-check form-switch">
            <input name="paiement" class="form-check-input payState" type="checkbox" id="payCheck">
            <label class="form-check-label" for="payCheck">
              Paiement reçu
            </label>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input payState" type="radio" value="EN ESPÈCES" name="reglement" id="enEspeces">
            <label class="form-check-label" for="enEspeces">
              Règlement en espèces
            </label>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input payState" type="radio" value="PAR CHÈQUE" name="reglement" id="parCheque">
            <label class="form-check-label" for="parCheque">
              Règlement par chèque
            </label>
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input payState" type="radio" value="À CRÉDIT" name="reglement" id="credit">
            <label class="form-check-label" for="credit">
              Règlement à crédit
            </label>
          </div>
          <div class="mb-3">
            <label for="date_paiement" class="form-label">Date de paiement</label>
            <input type="date" class="form-control" name="date_paiement" id="date_paiement">
          </div>
          <script>
            document.getElementById('payCheck').addEventListener('change', (e) => {
              if (!e.target.checked) {
                document.querySelectorAll('.payState').forEach(e => {
                  e.checked = false;
                })
                document.getElementById('date_paiement').value = null;
              }
            })
            document.querySelectorAll('.payState').forEach(e => {
              e.addEventListener('change', (e) => {
                if (e.target.checked) {
                  document.getElementById('payCheck').checked = true;
                }
              })
            })
          </script>
          <?= csrf_field() ?>
          <?= form_close() ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" form="rflF" class="btn btn-primary">Enregistrer</button>
        </div>
      </div>
    </div>
    <script>
      const myModalrefLiv = new bootstrap.Modal(document.getElementById('modalId'), options)
    </script>
    <script>
      $('.rfl').click(function(e) {
        e.preventDefault();
        $('#rfl').html(`Nº ${$(this).val()}`);
        $('#rflF').attr('action', '<?= base_url(session()->r . '/livraisons/reglement/') ?>' + $(this).val());
        document.querySelectorAll('.payState').forEach(e => {
          if (e.value == $(this).attr('data-reglement')) {
            e.checked = true;
            document.getElementById('payCheck').checked = true;
            document.getElementById('date_paiement').value = $(this).attr('data-date-paiement');
          }
        })

      });
    </script>
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