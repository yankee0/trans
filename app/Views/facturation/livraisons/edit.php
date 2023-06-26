<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Facturation livraisons
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<div class="container-fluid p-0">
  <h1 class="h3 mb-3"><strong class="text-primary">Modification</strong> Facture <span class="text-primary">Nº <?= $facture['id'] ?></span></h1>
  <div class="row">
    <div class="col-12 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <h4 class="card-title">Informations sur la facture</h4>
        </div>
        <div class="card-body">

          <div class="row row-cols-md-2 mb-3">
            <div class="mb-3">
              <h5 class="card-title text-dark">Informations sur le client</h5>
              <hr class="mb-1">

              <div class="d-flex align-items-center">
                <span><strong class="text-primary">Compte:</strong> Nº <?= $facture['id_client'] ?></span>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalIdmodcompte"><i data-feather="edit" class="text-warning"></i></button>
              </div>
              <div class="d-flex align-items-center">
                <span><strong class="text-primary">Consignataire:</strong> <?= $facture['consignataire'] ?></span>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalIdmodconsi"><i data-feather="edit" class="text-warning"></i></button>
              </div>
            </div>
            <div class="mb-3">
              <h5 class="card-title text-dark">Informations sur les containers</h5>
              <hr class="mb-1">
              <div class="d-flex align-items-center">
                <span><strong class="text-primary">BL:</strong> Nº <?= $facture['bl'] ?></span>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modBL"><i data-feather="edit" class="text-warning"></i></button>
              </div>
              <div class="d-flex align-items-center">
                <span><strong class="text-primary">Compagnie:</strong> <?= $facture['compagnie'] ?></span>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modCie"><i data-feather="edit" class="text-warning"></i></button>
              </div>
            </div>
          </div>
          <div class="row">
            <h5 class="card-title text-dark">Informations sur le transport</h5>
            <hr class="mb-1">
            <div class="container-fluid p-3">

              <div class="row mb-3 gap-3">
                <?php foreach ($zones as $z) : ?>
                  <div class="col-md-6 col-lg-4 border flex-fill">
                    <div class="text-muted d-flex align-items-center">
                      <strong class="text-primary"><?= $z['designation'] ?></strong>
                      <button class="btn btn-sm"><i data-feather="edit" class="text-warning"></i></button>
                      <button class="btn btn-sm  dz" id="<?= $facture['id'] . '/' . $z['id_zone'] ?>" value="<?= $z['designation'] ?>" data-bs-toggle="modal" data-bs-target="#delzone"><i data-feather="trash" class="text-danger"></i></button>
                    </div>
                    <div class="d-flex align-items-center">
                      <div><strong class="text-primary">Adresse:</strong> <?= $z['adresse'] ?></div>
                      <button value="<?= $z['id'] ?>" data-ci="<?= $z['designation'] ?>" class="btn btn-sm modadr" data-bs-toggle="modal" data-bs-target="#modadres"><i data-feather="edit" class="text-warning"></i></button>
                    </div>
                    <?php if (!empty($z['c_20'])) : ?>
                      <div class="d-flex align-items-center">
                        <div><strong class="text-primary">HT pour 20':</strong> <?= $z['c_20'][0]['prix'] ?></div>
                        <button class="btn btn-sm pht20" value="<?= $z['id'] ?>"><i data-feather="edit" class="text-warning"></i></button>
                      </div>
                      <div class="text-sm">Les conteneurs 20'</div>
                      <ul>
                        <?php foreach ($z['c_20'] as $c) : ?>
                          <li class="d-flex align-items-center">
                            <?= $c['conteneur'] ?>
                            <button class="btn btn-sm"><i data-feather="edit" class="text-warning"></i></button>
                            <button class="btn btn-sm "><i data-feather="trash" class="text-danger"></i></button>
                          </li>
                        <?php endforeach ?>
                      </ul>
                    <?php else : ?>
                      <div><i>Aucun conteneur 20'</i></div>
                    <?php endif ?>

                    <?php if (!empty($z['c_40'])) : ?>
                      <div class="d-flex align-items-center">
                        <div><strong class="text-primary">HT pour 40':</strong> <?= $z['c_40'][0]['prix'] ?></div>
                        <button class="btn btn-sm" value="<?= $z['id'] ?>"><i data-feather="edit" class="text-warning"></i></button>
                      </div>
                      <div class="text-sm">Les conteneurs 40'</div>
                      <ul>
                        <?php foreach ($z['c_40'] as $c) : ?>
                          <li class="d-flex align-items-center">
                            <?= $c['conteneur'] ?>
                            <button class="btn btn-sm"><i data-feather="edit" class="text-warning"></i></button>
                            <button class="btn btn-sm "><i data-feather="trash" class="text-danger"></i></button>
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
        </div>
        <div class="card-footer text-muted d-flex align-items-center justify-content-center gap-1">
          <a class="btn btn-primary" href="<?= base_url(session()->r) ?>">Retour au Dashboard</a>
          <a class="btn btn-info d-flex align-items-center justify-content-center gap-2" title="Voir les informations" href="<?= base_url(session()->r . '/livraisons/details/' . $facture['id']) ?>" target="_blank" role="button">Aperçu de la facture</a>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  $(document).ready(function() {

    $('.dz').click(function(e) {
      e.preventDefault();
      $('#dz').html($(this).val());
      $('#dzl').attr('href', '<?= base_url(session()->r . '/livraisons/edit/zones/') ?>' + $(this).attr('id'));
    });

    $('.modadr').click(function (e) { 
      e.preventDefault();
      console.log($(this).attr('data-ci'));
      $('#madr').html($(this).attr('data-ci'));
      $('#mas').attr('formaction', '<?= base_url(session()->r . '/livraisons/edit/adresse/') ?>' + $(this).val());
    });
  });
</script>


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
<script>
  const myModalcons = new bootstrap.Modal(document.getElementById('modalIdmodconsi'), options)
</script>

<!-- mod bl -->
<div class="modal fade" id="modBL" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleIdmodBl" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleIdmodBl">Modifier le BL</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(
          base_url(session()->r . '/livraisons/edit/entete/' . $facture['id']),
          [
            'id' => 'modblform'
          ]
        ) ?>
        <div>
          <input type="text" class="form-control text-uppercase" value="<?= set_value('bl', $facture['bl']) ?>" name="bl" id="bl" aria-describedby="helpId" placeholder="BL" required>
          <input type="text" hidden readonly class="form-control text-uppercase" value="<?= set_value('bl', $facture['bl']) ?>" name="last_bl" aria-describedby="helpId" placeholder="BL" required>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="modblform" class="btn btn-primary">Modifier</button>
      </div>
    </div>
  </div>
</div>
<script>
  const myModalmodbl = new bootstrap.Modal(document.getElementById('modBL'), options)
</script>

<!-- mod bl -->
<div class="modal fade" id="modCie" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleIdmodCie" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleIdmodCie">Modifier la compagnie</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(
          base_url(session()->r . '/livraisons/edit/entete/' . $facture['id']),
          [
            'id' => 'modCieform'
          ]
        ) ?>
        <div>
          <input type="text" class="form-control text-uppercase" value="<?= set_value('compagnie', $facture['compagnie']) ?>" name="compagnie" id="compagnie" aria-describedby="helpId" placeholder="Compagnie" required>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="modCieform" class="btn btn-primary">Modifier</button>
      </div>
    </div>
  </div>
</div>
<script>
  const myModalmodCie = new bootstrap.Modal(document.getElementById('modCie'), options)
</script>

<!-- del zone -->
<div class="modal fade" id="delzone" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="tdelzone" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tdelzone">Suppression de la zone</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Supprimer: <span id="dz" class="text-primary"></span> ?</p>
        <div class="alert alert-warning" role="alert">
          <strong>ATTENTION!</strong> Supprimer la zone de livraison implique la suppression des conteneurs devant y être livrés. <br>
          <strong class="textdanger">CETTE ACTION EST IRREVERSIBLE!</strong>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non, annuler.</button>
        <a type="button" id="dzl" role="button" class="btn btn-primary">Oui, supprimer.</a>
      </div>
    </div>
  </div>
</div>
<script>
  const delzone = new bootstrap.Modal(document.getElementById('delzone'), options)
</script>

<!-- mod adr -->
<div class="modal fade" id="modadres" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modadrtitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modadrtitle">Modification de l'adresse</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(
          base_url(session()->r . '/livraisons/edit/adres/' . $facture['id']),
          [
            'id' => 'modadrform'
          ]
        ) ?>
        <div>
          <p>Nouvelle adresse pour la <span id="madr"></span></p>
          <input type="text" class="form-control text-uppercase" value="<?= set_value('adresse') ?>" name="adresse" id="adresse" aria-describedby="helpId" placeholder="Saisir la nouvelle adresse" required>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="modadrform" class="btn btn-primary" id="mas">Modifier</button>
      </div>
    </div>
  </div>
</div>
<script>
  const myModal = new bootstrap.Modal(document.getElementById('modadres'), options)
</script>

<?= $this->endSection(); ?>