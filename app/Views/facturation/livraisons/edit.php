<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Facturation livraisons
<?= $this->endSection(); ?>
<?= $this->section('main'); ?>
<script>
  let zones = [];
  config = {
    type: "get",
    url: "<?= base_url('api/zones') ?>",
    data: {
      token: '<?= csrf_hash() ?>'
    },
    dataType: "JSON",
    success: function(response) {
      zones = response;
    },
  };
</script>
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
                  <div class="col-md-6 col-lg-4 flex-fill">
                    <div class="text-muted d-flex align-items-center">
                      <strong class="text-primary"><?= $z['designation'] ?></strong>
                      <button class="btn btn-sm chz" data-bs-toggle="modal" data-bs-target="#modzname" value="<?= $z['id'] ?>"><i data-feather="edit" class="text-warning"></i></button>
                      <button class="btn btn-sm  dz" id="<?= $facture['id'] . '/' . $z['id_zone'] ?>" value="<?= $z['designation'] ?>" data-bs-toggle="modal" data-bs-target="#delzone"><i data-feather="trash" class="text-danger"></i></button>
                    </div>
                    <div class="d-flex align-items-center">
                      <div><strong class="text-primary">Adresse:</strong> <?= $z['adresse'] ?></div>
                      <button value="<?= $z['id'] ?>" data-ci="<?= $z['designation'] ?>" class="btn btn-sm modadr" data-bs-toggle="modal" data-bs-target="#modadres"><i data-feather="edit" class="text-warning"></i></button>
                    </div>
                    <?php if (!empty($z['c_20'])) : ?>
                      <div class="d-flex align-items-center">
                        <div><strong class="text-primary">HT pour 20':</strong> <?= $z['c_20'][0]['prix'] ?></div>
                        <button class="btn btn-sm pht20" data-bs-toggle="modal" data-bs-target="#modprice" data-price-40="<?= (isset($z['c_20'][0])) ? $z['c_20'][0]['prix'] : 0 ?>" data-price-40="<?= (isset($z['c_40'][0])) ? $z['c_40'][0]['prix'] : 0 ?>" value="<?= $z['id'] ?>"><i data-feather="edit" class="text-warning"></i></button>
                      </div>
                      <div class="text-sm">Les conteneurs 20'</div>
                      <ul>
                        <?php foreach ($z['c_20'] as $c) : ?>
                          <li class="d-flex align-items-center">
                            <?= $c['conteneur'] ?>
                            <button class="btn btn-sm ecb" data-type="<?= $c['type'] ?>" data-tc="<?= $c['conteneur'] ?>" data-id="<?= $c['id'] ?>" data-bs-toggle="modal" data-bs-target="#editcontainer"><i data-feather="edit" class="text-warning"></i></button>
                            <button class="btn btn-sm dcb" data-container="<?= $c['conteneur'] ?>" value="<?= $c['id'] ?>" data-bs-toggle="modal" data-bs-target="#delcontainer"><i data-feather="trash" class="text-danger"></i></button>
                          </li>
                        <?php endforeach ?>
                      </ul>
                    <?php else : ?>
                      <div><i>Aucun conteneur 20'</i></div>
                    <?php endif ?>

                    <?php if (!empty($z['c_40'])) : ?>
                      <div class="d-flex align-items-center">
                        <div><strong class="text-primary">HT pour 40':</strong> <?= $z['c_40'][0]['prix'] ?></div>
                        <button class="btn btn-sm pht40" data-bs-toggle="modal" data-bs-target="#modprice" data-price-40="<?= (isset($z['c_20'][0])) ? $z['c_20'][0]['prix'] : 0 ?>" data-price-40="<?= (isset($z['c_40'][0])) ? $z['c_40'][0]['prix'] : 0 ?>" value="<?= $z['id'] ?>"><i data-feather="edit" class="text-warning"></i></button>
                      </div>
                      <div class="text-sm">Les conteneurs 40'</div>
                      <ul>
                        <?php foreach ($z['c_40'] as $c) : ?>
                          <li class="d-flex align-items-center">
                            <?= $c['conteneur'] ?>
                            <button class="btn btn-sm ecb" data-type="<?= $c['type'] ?>" data-tc="<?= $c['conteneur'] ?>" data-id="<?= $c['id'] ?>" data-bs-toggle="modal" data-bs-target="#editcontainer"><i data-feather="edit" class="text-warning"></i></button>
                            <button class="btn btn-sm dcb" data-container="<?= $c['conteneur'] ?>" value="<?= $c['id'] ?>" data-bs-toggle="modal" data-bs-target="#delcontainer"><i data-feather="trash" class="text-danger"></i></button>
                          </li>
                        <?php endforeach ?>
                      </ul>
                    <?php else : ?>
                      <div><i>Aucun conteneur 40'</i></div>
                    <?php endif ?>
                    <div class="d-flex align-items-center gap-1"><button class="btn btn-sm text-primary addtcb" data-bs-toggle="modal" data-bs-target="#addtc" value="<?= $z['id'] ?>"><i data-feather="plus"></i> Ajouter un conteneur</button></div>
                  </div>
                <?php endforeach ?>
              </div>
            </div>
          </div>
          <form action="#" class="row">
            <div id="yankee"></div>
          </form>
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

    $('.modadr').click(function(e) {
      e.preventDefault();
      console.log($(this).attr('data-ci'));
      $('#madr').html($(this).attr('data-ci'));
      $('#mas').attr('formaction', '<?= base_url(session()->r . '/livraisons/edit/adresse/') ?>' + $(this).val());
    });

    $('.pht20,.pht40').click(function(e) {
      e.preventDefault();
      // $('#prix_20').val($(this).attr('data-price-20'));
      // $('#prix_40').val($(this).attr('data-price-40'));
      $('#modpriceform').attr('action', '<?= base_url(session()->r . '/livraisons/edit/price/') ?>' + $(this).val());
    });

    $('.dcb').click(function(e) {
      e.preventDefault();
      $('#dcon').html($(this).attr('data-container'));
      $('#dcl').attr('href', '<?= base_url(session()->r . '/livraisons/edit/delete/container/') ?>' + $(this).val());
    });

    $('.ecb').click(function(e) {
      e.preventDefault();
      $('#conteneur').val($(this).attr('data-tc'));
      let type = $(this).attr('data-type');
      switch (type) {
        case '20':
          $('#t20').attr('selected', 'selected');
          break;
        case '40':
          $('#t40').attr('selected', 'selected');
          break;
        default:
          break;
      }
      $('#modtcformu').attr('action', '<?= base_url(session()->r . '/livraisons/edit/container/') ?>' + $(this).attr('data-id'));
    });

    $('.addtcb').click(function(e) {
      e.preventDefault();
      $('#addtcs').val($(this).val());
    });

    $('.chz').click(function(e) {
      e.preventDefault();
      $('#chzn').val($(this).val());
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
          <input type="text" class="form-control text-uppercase" value="<?= set_value('consignataire', $facture['consignataire']) ?>" name="consignataire" id="consignataire" placeholder="Consignataire" required>
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
          <input type="text" class="form-control text-uppercase" value="<?= set_value('bl', $facture['bl']) ?>" name="bl" id="bl" placeholder="BL" required>
          <input type="text" hidden readonly class="form-control text-uppercase" value="<?= set_value('bl', $facture['bl']) ?>" name="last_bl" placeholder="BL" required>
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
          <input type="text" class="form-control text-uppercase" value="<?= set_value('compagnie', $facture['compagnie']) ?>" name="compagnie" id="compagnie" placeholder="Compagnie" required>
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
          <input type="text" class="form-control text-uppercase" value="<?= set_value('adresse') ?>" name="adresse" id="adresse" placeholder="Saisir la nouvelle adresse" required>
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

<!-- mod prix -->
<div class="modal fade" id="modprice" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modliv" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modliv">Modifier le prix de livraison</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(
          '/',
          [
            'id' => 'modpriceform'
          ]
        ) ?>
        <div class="mb-3">
          <p class="mb-0">Prix de livraisons 20'</p>
          <input type="number" min="0" class="form-control text-uppercase" value="<?= set_value('prix') ?>" name="prix_20" id="prix_20" placeholder="Nouveaux prix de livraison" required>
        </div>
        <div>

          <p class="mb-0">Prix de livraisons 40'</p>
          <input type="number" min="0" class="form-control text-uppercase" value="<?= set_value('prix') ?>" name="prix_40" id="prix_40" placeholder="Nouveaux prix de livraison" required>
        </div>

        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="modpriceform" class="btn btn-primary">Modifier</button>
      </div>
    </div>
  </div>
</div>
<script>
  const myModalprice = new bootstrap.Modal(document.getElementById('modprice'), options)
</script>

<!-- delete container -->
<div class="modal fade" id="delcontainer" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="delcon" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delcon">Supprimer un conteneur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Êtes vous sur de vouloir supprimer le conteneur <span id="dcon" class="text-primary"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <a role="button" id="dcl" class="btn btn-primary">Supprimer</a>
      </div>
    </div>
  </div>
</div>
<script>
  const myModaldelcon = new bootstrap.Modal(document.getElementById('delcontainer'), options)
</script>

<!-- edit container -->
<div class="modal fade" id="editcontainer" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="editcontitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editcontitle">Modifier le conteneur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(
          '',
          [
            'id' => 'modtcformu'
          ]
        ) ?>
        <div>
          <div class="mb-3">
            <label for="type" class="form-label">Type de conteneur</label>
            <select class="form-select" name="type" id="type" required>
              <option selected hidden value="">Sélectionnner un type de conteneur</option>
              <option <?= set_select('type', '20') ?> id="t20" value="20">20'</option>
              <option <?= set_select('type', '40') ?> id="t40" value="40">40'</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="conteneur" class="form-label">Numéro du conteneur</label>
            <input type="text" class="form-control" name="conteneur" id="conteneur" placeholder="Numéro du conteneur" required>
          </div>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="modtcformu" class="btn btn-primary">Modifier</button>
      </div>
    </div>
  </div>
</div>
<script>
  const myModaltc = new bootstrap.Modal(document.getElementById('editcontainer'), options)
</script>

<!-- add container -->
<div class="modal fade" id="addtc" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="addtctitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addtctitle">Ajouter un conteneur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(
          base_url(session()->r . '/livraisons/edit/container/add'),
          [
            'id' => 'addtcformu'
          ]
        ) ?>
        <div>
          <div class="mb-3">
            <label for="type" class="form-label">Type de conteneur</label>
            <select class="form-select" name="type" id="type" required>
              <option selected hidden value="">Sélectionnner un type de conteneur</option>
              <option <?= set_select('type', '20') ?> value="20">20'</option>
              <option <?= set_select('type', '40') ?> value="40">40'</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="conteneur" class="form-label">Numéro du conteneur</label>
            <input type="text" class="form-control" name="conteneur" id="conteneur" placeholder="Numéro du conteneur" required>
          </div>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" id="addtcs" name="id_lieu" form="addtcformu" class="btn btn-primary">Ajouter</button>
      </div>
    </div>
  </div>
</div>
<script>
  const myModaladdtc = new bootstrap.Modal(document.getElementById('addtc'), options)
</script>

<!-- changer destinations -->
<button type="button" class="btn btn-primary btn-lg">
  Launch
</button>
<div class="modal fade" id="modzname" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modzti" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modzti">Modification de la zone</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(
          base_url(session()->r . '/livraisons/edit/zones/new'),
          [
            'id' => 'chzoneform'
          ]
        ) ?>
        <div>
          <div class="mb-3">
            <label for="zone" class="form-label">Choisir la nouvelle zone de livraison</label>
            <select class="form-select " name="zone" id="zone" required>
              <option selected value="" hidden>Sélectionnez une zone</option>
              <?php foreach ($zn as $z) : ?>
                <option value="<?= $z['id'] ?>"><?= $z['nom'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="chzoneform" id="chzn" name="lastzone" class="btn btn-primary">Modifier</button>
      </div>
    </div>
  </div>
</div>
<script>
  const myModalnz = new bootstrap.Modal(document.getElementById('modzname'), options)
</script>
<?= $this->endSection(); ?>