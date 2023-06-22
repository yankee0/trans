<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Facturation livraisons
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<div class="container-fluid">
  <h1 class="h3 mb-3"><strong class="text-primary">Modification</strong> Facture <span class="text-primary">Nº <?= $facture['id'] ?></span></h1>
  <div class="row">
    <div class="col-12 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <h4 class="card-title">Informations sur la facture</h4>
        </div>
        <div class="card-body">

          <div class="row row-cols-md-2 mb-3">
            <div>
              <h5 class="card-title text-dark">Informations sur le client</h5>
              <hr>

              <div class="d-flex align-items-center">
                <span><strong class="text-primary">Compte:</strong> Nº <?= $facture['id_client'] ?></span>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalIdmodcompte"><i data-feather="edit"></i></button>
              </div>
              <div class="d-flex align-items-center">
                <span><strong class="text-primary">Consignataire:</strong> <?= $facture['consignataire'] ?></span>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalIdmodconsi"><i data-feather="edit"></i></button>
              </div>
            </div>
            <div>
              <h5 class="card-title text-dark">Informations sur les containers</h5>
              <hr>
              <div class="d-flex align-items-center">
                <span><strong class="text-primary">BL:</strong> Nº <?= $facture['bl'] ?></span>
                <button class="btn btn-sm"><i data-feather="edit"></i></button>
              </div>
              <div class="d-flex align-items-center">
                <span><strong class="text-primary">Compagnie:</strong> <?= $facture['compagnie'] ?></span>
                <button class="btn btn-sm"><i data-feather="edit"></i></button>
              </div>
            </div>
          </div>
          <div class="row">
            <h5 class="card-title text-dark">Informations sur le transport</h5>
            <hr>
            <div class="row mb-3">
              <?php foreach ($zones as $z) : ?>
                <div class="col-md-2 col-xl-3 mb-4">
                  <div class="text-muted d-flex align-items-center">
                    <strong class="text-primary"><?= $z['designation'] ?></strong>
                    <button class="btn btn-sm"><i data-feather="edit"></i></button>
                    <button class="btn btn-sm text-danger"><i data-feather="trash"></i></button>
                  </div>
                  <div class="d-flex align-items-center">
                    <div><strong class="text-primary">Adresse:</strong> <?= $z['adresse'] ?></div>
                    <button class="btn btn-sm"><i data-feather="edit"></i></button>
                  </div>


                  <?php if (!empty($z['c_20'])) : ?>
                    <div class="d-flex align-items-center">
                      <div><strong class="text-primary">HT pour 20':</strong> <?= $z['c_20'][0]['prix'] ?></div>
                      <button class="btn btn-sm"><i data-feather="edit"></i></button>
                    </div>
                    <div class="text-sm">Les conteneurs 20'</div>
                    <ul>
                      <?php foreach ($z['c_20'] as $c) : ?>
                        <li class="d-flex align-items-center">
                          <?= $c['conteneur'] ?>
                          <button class="btn btn-sm"><i data-feather="edit"></i></button>
                          <button class="btn btn-sm text-danger"><i data-feather="trash"></i></button>
                        </li>
                      <?php endforeach ?>
                    </ul>
                  <?php else : ?>
                    <div><i>Aucun conteneur 20'</i></div>
                  <?php endif ?>

                  <?php if (!empty($z['c_40'])) : ?>
                    <div class="d-flex align-items-center">
                      <div><strong class="text-primary">HT pour 40':</strong> <?= $z['c_40'][0]['prix'] ?></div>
                      <button class="btn btn-sm"><i data-feather="edit"></i></button>
                    </div>
                    <div class="text-sm">Les conteneurs 40'</div>
                    <ul>
                      <?php foreach ($z['c_40'] as $c) : ?>
                        <li class="d-flex align-items-center">
                          <?= $c['conteneur'] ?>
                          <button class="btn btn-sm"><i data-feather="edit"></i></button>
                          <button class="btn btn-sm text-danger"><i data-feather="trash"></i></button>
                        </li>
                      <?php endforeach ?>
                    </ul>
                  <?php else : ?>
                    <div><i>Aucun conteneur 40'</i></div>
                  <?php endif ?>
                  <div class="d-flex align-items-center gap-1"><button class="btn btn-sm text-primary"><i data-feather="plus"></i> Ajouter un conteneur</button></div>
                </div>
              <?php endforeach ?>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted d-flex align-items-center justify-content-center gap-1">
          <a class="btn btn-primary" href="<?= base_url(session()->r) ?>">Retour au Dashboard</a>
          <a class="btn btn-info d-flex align-items-center justify-content-center gap-2" title="Voir les informations" href="<?= base_url(session()->r . '/livraisons/details/' . $facture['id']) ?>" target="_blank" role="button">Aperçu de la facture</a>
        </div>
      </div>
    </div>

  </div>
</div>



<div class="modal fade" id="modalIdmodcompte" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleIdmodclient" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleIdmodclient">Modifier le compte client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(
          base_url(session()->r . '/livraisons/edit/entete/' . $facture['id']),
          [
            'id' => 'modcliform'
          ]
        ) ?>

        <div>
          <select class="form-select" name="id_client" id="id_client" required>
            <option selected value="" hidden>Sélectionner un compte</option>
            <?php foreach ($cli as $c) : ?>
              <option value="<?= $c['id'] ?>" <?= set_select('id_client', $c['id'], ($facture['id_client'] == $c['id']) ? true : false) ?>><?= $c['id'] . ' - ' . $c['nom'] ?></option>
            <?php endforeach ?>
          </select>
        </div>

        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="modcliform" class="btn btn-primary">Modifier</button>
      </div>
    </div>
  </div>
</div>
<script>
  const myModalcli = new bootstrap.Modal(document.getElementById('modalIdmodcompte'), options)
</script>

<!-- mod consignataire -->

<div class="modal fade" id="modalIdmodconsi" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleIdmodcons" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleIdmodcons">Modifier le consignataire</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(
          base_url(session()->r . '/livraisons/edit/entete/' . $facture['id']),
          [
            'id' => 'modconsform'
          ]
        ) ?>
        <div>
          <input type="text" class="form-control text-uppercase" value="<?= set_value('consignataire', $facture['consignataire']) ?>" name="consignataire" id="consignataire" aria-describedby="helpId" placeholder="Consignataire" required>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="modconsform" class="btn btn-primary">Modifier</button>
      </div>
    </div>
  </div>
</div>


<!-- Optional: Place to the bottom of scripts -->
<script>
  const myModalcons = new bootstrap.Modal(document.getElementById('modalIdmodconsi'), options)
</script>
<?= $this->endSection(); ?>