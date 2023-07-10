<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Recherches
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Recherches</strong></h1>

<div class="row">
  <div class="col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-body ">
        <form action="<?= base_url(session()->r . '/search') ?>" class="d-flex gap-2">
          <input type="search" value="<?= (isset($search)) ? $search : '' ?>" class="form-control flex-grow-1" name="search" id="search" placeholder="Rechercher un conteneur (par nom du client, zone ou BL)">
          <button class="btn btn-primary d-flex gap-2 justify-content-center align-items-center"><i data-feather="search"></i> <span class="d-none d-md-flex">Rechercher</span></button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- liv table -->
<div class="row" id="livraisons">
  <div class="col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header">
        <h5 class="card-title mb-0">Résultat pour les livraisons</h5>
      </div>
      <?php if (sizeof($livs['data']) == 0) : ?>
        <div class="card-body">
          <div class="alert alert-warning" role="alert">
            Pas de résultat.
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
                  <td>
                    <div class="d-flex justify-content-around">
                      <button type="button" value="<?= $liv['id'] ?>" data-container="<?= $liv['conteneur'] ?>" class="update btn border-0 text-dark dropDelv <?= ($liv['etat'] == 'MISE À TERRE' or $liv['etat'] == 'LIVRÉ') ? 'disabled' : '' ?>" title="Mise à terre" data-bs-toggle="modal" data-bs-target="#delivDrop"><i cla data-feather="arrow-down"></i></button>
                      <button type="button" value="<?= $liv['id'] ?>" data-container="<?= $liv['conteneur'] ?>" class="update btn border-0 text-info upDelv <?= ($liv['etat'] == 'SUR PLATEAU' or $liv['etat'] == 'LIVRÉ') ? 'disabled' : '' ?>" title="Mise sur plateau" data-bs-toggle="modal" data-bs-target="#uptc"><i cla data-feather="arrow-up"></i></button>
                      <button type="button" value="<?= $liv['id'] ?>" data-container="<?= $liv['conteneur'] ?>" class="update btn border-0 text-warning infDelv" title="Livraison" data-bs-toggle="modal" data-bs-target="#livInf"><i cla data-feather="truck"></i></button>
                      <button type="button" value="<?= $liv['id'] ?>" data-container="<?= $liv['conteneur'] ?>" class="update btn border-0 text-danger abordDelv border-0 <?= $liv['etat'] == 'ANNULÉ' ? 'disabled' : '' ?>" title="Annuler" data-bs-toggle="modal" data-bs-target="#abordDelv"><i cla data-feather="x"></i></button>
                      <a role="button" href="<?= base_url(session()->r . '/livraisons/infos/' . $liv['conteneur']) ?>" class="update btn border-0 text-info" title="Information"><i cla data-feather="info"></i></a>
                    </div>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>

          <div class="card-footer text-center d-flex justify-content-end" style="overflow-x: scroll">
            <nav class="pagination">
              <?= $livs['pager']->links() ?>
            </nav>
          </div>
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
      $.ajax({
        type: "get",
        url: "<?= base_url('api/livraisons') ?>",
        data: {
          token: '<?= csrf_hash() ?>',
          id: $(this).val()
        },
        dataType: "JSON",
        success: function(res) {
          // console.log(res);
          $('#date_aller').val(res.date_aller);
          $('#date_retour').val(res.date_retour);
          $('#commentaire').val(res.commentaire);
          document.querySelectorAll('.chAllerOp').forEach(e => {
            if (e.value == res.ch_aller) {
              console.log(e.selected);
              e.selected = true
            }
          })
          document.querySelectorAll('.chRetourOp').forEach(e => {
            if (e.value == res.ch_retour) {
              console.log(e.selected);
              e.selected = true
            }
          })
          document.querySelectorAll('.camAllerOp').forEach(e => {
            if (e.value == res.cam_aller) {
              console.log(e.selected);
              e.selected = true
            }
          })
          document.querySelectorAll('.camRetourOp').forEach(e => {
            if (e.value == res.cam_retour) {
              console.log(e.selected);
              e.selected = true
            }
          })
          document.getElementById('eirs').checked = res.etat == 'LIVRÉ' ? true : false;
        }
      });
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


<?= $this->endSection(); ?>