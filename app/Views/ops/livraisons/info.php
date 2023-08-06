<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Information de livraison
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<h1 class="h3 mb-3"><strong>Livraisons</strong> <?= $conteneur ?></h1>
<div class="row">

  <div class="col-12 d-flex">
    <div class="card flex-fill">
      <div class="card-header">
        <h4 class="card-title">Informations</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <?php if ($preget == 'NON') : ?>
              <div class="alert alert-warning text-center" role="alert">
                Preget non reçu
              </div>
            <?php endif ?>
            <div>
              <h1 class="display-6">TC Nº <span class="text-primary"><?= $conteneur ?></span></h1>
            </div>
            <hr>
          </div>
          <div class="col-md-6 col-lg-4  col-xl-3">
            <div class="fs-2">TC</div>
            <p>
            <div class="text-sm text-muted">Numéro conteneur</div>
            <div><?= $conteneur ?></div>
            </p>
            <p>
            <div class="text-sm text-muted">Type</div>
            <div><?= $type ?></div>
            </p>
            <p>
            <div class="text-sm text-muted">Compagnie</div>
            <div><?= $compagnie ?></div>
            </p>
            <p>
            <div class="text-sm text-muted">Numéro BL</div>
            <div><?= $bl ?></div>
            </p>
            <p>
            <div class="text-sm text-muted">Date de réception du preget</div>
            <div><?= $date_pg ?></div>
            </p>
          </div>
          <div class="col-md-6 col-lg-4  col-xl-3">
            <div class="fs-2">Client</div>
            <p>
            <div class="text-sm text-muted">Nº de facture</div>
            <div><?= $facture ?></div>
            </p>
            <div class="text-sm text-muted">Date de facturation</div>
            <div><?= $date_creation ?></div>
            </p>
            <div class="text-sm text-muted">Client</div>
            <div><?= $nom_client ?></div>
            </p>
            <p>
            <p>
            <div class="text-sm text-muted">Email</div>
            <div><?= $email_client ?></div>
            </p>
            <p>
            <div class="text-sm text-muted">Téléphone</div>
            <div><?= $tel_client ?></div>
            </p>
          </div>
          <div class="col-md-6 col-lg-4  col-xl-3">
            <div class="fs-2">Livraison</div>
            <p>
            <div class="text-sm text-muted">Etat</div>
            <div>
              <?php
              switch ($etat) {
                case 'MISE À TERRE':
              ?>
                  <span class="badge bg-dark"><?= $etat ?></span>
                <?php
                  break;
                case 'SUR PLATEAU':
                ?>
                  <span class="badge bg-info"><?= $etat ?></span>
                <?php
                  break;
                case 'EN COURS':
                ?>
                  <span class="badge bg-warning"><?= $etat ?></span>
                <?php
                  break;
                case 'LIVRÉ':
                ?>
                  <span class="badge bg-success"><?= $etat ?></span>
                <?php
                  break;
                case 'ANNULÉ':
                ?>
                  <span class="badge bg-danger"><?= $etat ?></span>
              <?php
                  break;

                default:
                  echo "ERROR 404";
                  break;
              }
              ?>
            </div>
            </p>
            <?php if ($etat == 'ANNULÉ') : ?>
              <p>
              <div class="text-sm text-muted">Motif d'annulation</div>
              <div><?= $motif ?></div>
              </p>
            <?php endif ?>
            <p>
            <div class="text-sm text-muted">Zone</div>
            <div><?= $zone ?></div>
            </p>
            <p>
            <div class="text-sm text-muted">Adresse exacte</div>
            <div><?= empty($adresse) ? '<span class="badge bg-dark">INDÉFINIE</span>' : $adresse ?></div>
            </p>
            <p>
            <div class="text-sm text-muted">Paiement</div>
            <div><span class="badge bg-<?= $paiement == 'OUI' ? 'success' : 'danger' ?>"><?= $paiement ?></span></div>
            </p>
            <p>
            <div class="text-sm text-muted">Commentaire</div>
            <div><?= $commentaire ?></div>
            </p>
          </div>
          <div class="col-md-6 col-lg-4  col-xl-3">
            <div class="fs-2">Transport</div>
            <p>
            <div class="text-sm text-muted">Carburant approximatif en litres</div>
            <div><?= $carburant ?></div>
            </p>
            <p>
            <div class="text-sm text-muted">Date ALLER</div>
            <div><?= empty($date_aller) ? '<span class="badge bg-dark">INDÉFINI</span>' : $date_aller ?></div>
            </p>
            <p>
            <div class="text-sm text-muted">Chauffeur ALLER</div>
            <div><?= empty($ch_aller) ? '<span class="badge bg-dark">INDÉFINI</span>' : $ch_aller ?></div>
            </p>
            <p>
            <div class="text-sm text-muted">Camion ALLER</div>
            <div><?= empty($cam_aller) ? '<span class="badge bg-dark">INDÉFINI</span>' : $cam_aller ?></div>
            </p>
            <p>
            <p>
            <div class="text-sm text-muted">Date RETOUR</div>
            <div><?= empty($date_retour) ? '<span class="badge bg-dark">INDÉFINI</span>' : $date_retour ?></div>
            </p>
            <div class="text-sm text-muted">Chauffeur RETOUR</div>
            <div><?= empty($ch_retour) ? '<span class="badge bg-dark">INDÉFINI</span>' : $ch_retour ?></div>
            </p>
            <p>
            <div class="text-sm text-muted">Camion RETOUR</div>
            <div><?= empty($cam_retour) ? '<span class="badge bg-dark">INDÉFINI</span>' : $cam_retour ?></div>
            </p>
          </div>
          <div class="col-12">
            <hr>
          </div>
          <div class="col-12">
            <div class="row gap-3">
              <?php if (session()->r != 'facturation') : ?>

                <div class="col-md d-grid">
                  <button class="btn btn-dark d-flex align-items-center justify-content-center gap-2 <?= ($etat == 'MISE À TERRE' or $etat == 'LIVRÉ') ? 'disabled' : '' ?>" data-bs-toggle="modal" data-bs-target="#delivDrop"><i data-feather="arrow-down"></i>Mise à terre</button>
                </div>
                <div class="col-md d-grid">
                  <button class="btn btn-info d-flex align-items-center justify-content-center gap-2 <?= ($etat == 'SUR PLATEAU' or $etat == 'LIVRÉ') ? 'disabled' : '' ?>" data-bs-toggle="modal" data-bs-target="#uptc"><i data-feather="arrow-up"></i>Mise sur plateau</button>
                </div>
                <div class="col-md d-grid">
                  <button class="btn btn-warning d-flex align-items-center justify-content-center gap-2 infDelv" data-bs-toggle="modal" data-bs-target="#livInf"><i data-feather="truck"></i>Livraison</button>
                </div>
              <?php endif ?>
              <div class="col-md d-grid">
                <button class="btn btn-danger d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#abordDelv"><i data-feather="x"></i>Annuler</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-muted d-flex align-items-center justify-content-end">
      </div>
    </div>
  </div>
</div>


<!-- mise à terre livraisons -->
<div class="modal fade" id="delivDrop" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Mise à terre conteneur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Mettre à terre le conteneur <span class="text-primary" id="dropTC"><?= $conteneur ?></span> ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <a id="dropTCLink" href="<?= base_url(session()->r . '/livraisons/drop/' . $id) ?>" type="button" class="btn btn-primary">Mettre à terre</a>
      </div>
    </div>
  </div>
</div>
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
        Mettre sur plateau le conteneur <span class="text-primary"><?= $conteneur ?></span> ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <a id="upTCLink" href="<?= base_url(session()->r . '/livraisons/up/' . $id) ?>" class="btn btn-primary">Mise sur plateau</a>
      </div>
    </div>
  </div>
</div>
<script>
  const myModalUpTc = new bootstrap.Modal(document.getElementById('uptc'), options)
</script>

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
        Annuler la livraison <span class="text-primary"><?= $conteneur ?></span> ?<br>
        Quel est le motif de l'annulation:
        <div>
          <textarea class="form-control" name="motif" rows="3"></textarea>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="abDeliveryForm" id="abDeliveryBtn" name="id" value="<?= $id ?>" class="btn btn-primary">Annuler la livraison</a>
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
        <h2>Nº TC <span class="text-primary"><?= $conteneur ?></span></h2>
        <div class="row">
          <div class="col-md">
            <h4 class="text-primary">ALLER</h4>
            <div class="form-floating mb-3">
              <select name="ch_aller" class="form-select" id="ch_aller" aria-label="Floating label select example">
                <option selected value="" hidden>Sélectionner</option>
                <?php foreach ($drivers as $d) : ?>
                  <option class="chAllerOp" <?= $ch_aller_id == $d['id'] ? 'selected' : '' ?> value="<?= $d['id'] ?>"><?= $d['nom'] ?></option>
                <?php endforeach ?>
              </select>
              <label for="floatingSelect">Chauffeur</label>
            </div>
            <div class="form-floating mb-3">
              <select name="cam_aller" class="form-select" id="cam_aller" aria-label="Floating label select example">
                <option selected value="" hidden>Sélectionner</option>
                <?php foreach ($trucks as $t) : ?>
                  <option class="camAllerOp" <?= $cam_aller_id == $t['id'] ? 'selected' : '' ?> value="<?= $t['id'] ?>"><?= $t['im'] ?></option>
                <?php endforeach ?>
              </select>
              <label for="floatingSelect">Camion</label>
            </div>
            <div class="form-floating mb-3">
              <input type="date" value="<?= $date_aller ?>" class="form-control" name="date_aller" id="date_aller" placeholder="Entrez la date">
              <label for="date_aller">Date</label>
            </div>
          </div>
          <div class="col-md">
            <h4 class="text-primary">RETOUR</h4>
            <div class="form-floating mb-3">
              <select name="ch_retour" class="form-select" id="ch_retour" aria-label="Floating label select example">
                <option selected value="" hidden>Sélectionner</option>
                <?php foreach ($drivers as $d) : ?>
                  <option class="chRetourOp" <?= $ch_retour_id == $d['id'] ? 'selected' : '' ?> value="<?= $d['id'] ?>"><?= $d['nom'] ?></option>
                <?php endforeach ?>
              </select>
              <label for="floatingSelect">Chauffeur</label>
            </div>
            <div class="form-floating mb-3">
              <select name="cam_retour" class="form-select" id="cam_retour" aria-label="Floating label select example">
                <option selected value="" hidden>Sélectionner</option>
                <?php foreach ($trucks as $t) : ?>
                  <option class="camRetourOp" <?= $cam_retour_id == $t['id'] ? 'selected' : '' ?> value="<?= $t['id'] ?>"><?= $t['im'] ?></option>
                <?php endforeach ?>
              </select>
              <label for="floatingSelect">Camion</label>
            </div>
            <div class="form-floating mb-3">
              <input type="date" value="<?= $date_retour ?>" class="form-control" name="date_retour" id="date_retour" placeholder="Entrez la date">
              <label for="date_retour">Date</label>
            </div>
          </div>

          <div class="col-12 mb-3">
            <div class="form-floating">
              <textarea id="commentaire" name="commentaire" class="form-control" placeholder="Des remarques concernants la livraisons"><?= $commentaire ?></textarea>
              <label for="commentaire">Commentaire</label>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <div class="form-check form-switch">
                <input class="form-check-input" <?= $etat == 'LIVRÉ' ? 'checked' : '' ?> name="eirs" type="checkbox" id="eirs">
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
        <button type="submit" form="livsForm" id="livSub" name="id" value="<?= $id ?>" class="btn btn-primary">Enregistrer</button>
      </div>
    </div>
  </div>
</div>

<script>
  const myModal = new bootstrap.Modal(document.getElementById('livInf'), options)
</script>

<?= $this->endSection(); ?>