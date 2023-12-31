<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Liste des chauffeurs
<?= $this->endSection(); ?>

<?= $this->section('main'); ?>
<div class=" container-fluid p-0">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h3"><strong>Gestion</strong> chauffeurs</h1>
    <div>
      <a class="btn btn-primary" role="button" data-bs-toggle="modal" data-bs-target="#modalIdadd">
        <i data-feather="plus"></i> Ajouter
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-12 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <h5 class="card-title mb-3">Liste des chauffeurs (<span class="text-primary"><?= $count ?></span>)</h5>
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalIddelG">
            Suppression groupée
          </button>
        </div>
        <div class="card-body">
          <?php if (sizeof($list) == 0) : ?>
            <div class="card-body">
              <div class="alert alert-warning" role="alert">
                Aucun résultat.
              </div>
            </div>
          <?php else : ?>
            <?= form_open(base_url(session()->r . '/chauffeurs/del'), [
              'id' => 'gd'
            ]) ?>
            <div class="table-responsive">
  
              <table class="table table-hover my-0">
                <thead>
                  <tr>
                    <th></th>
                    <th>Nom</th>
                    <th class="">Téléphone</th>
                    <th class="">Société</th>
                    <th class="">Camion</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($list as $l) : ?>
                    <tr>
                      <td id="<?= $l['id'] ?>">
                        <input class="form-check-input" type="checkbox" name="id[]" value="<?= $l['id'] ?>" id="c-<?= $l['id'] ?>">
                      </td>
                      <td><?= $l['nom'] ?></td>
                      <td class=""><?= $l['tel'] ?></td>
                      <td class=""><?= $l['societe'] ?></td>
  
                      <td class=""><?= (empty($l['camion'])) ? '<span class=" badge bg-dark">Pas de camion</span>' : $l['camion'] ?></td>
                      <td>
                        <div class="d-flex gap-2">
                          <button type="button" data-id="<?= $l['id'] ?>" data-nom="<?= $l['nom'] ?>" data-camion="<?= $l['camion'] ?>" data-camionid="<?= $l['camion_id'] ?>" data-societe="<?= $l['societe'] ?>" data-tel="<?= $l['tel'] ?>" class="delete btn text-danger" value="<?= $l['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalIdDelete" title="Supprimer la chauffeur" data-bs-toggle="modal" data-bs-target="#delete">
                            <i cla data-feather="trash"></i>
                          </button>
                          <button type="button" data-id="<?= $l['id'] ?>" data-nom="<?= $l['nom'] ?>" data-camion="<?= $l['camion'] ?>" data-camionid="<?= $l['camion_id'] ?>" data-societe="<?= $l['societe'] ?>" data-tel="<?= $l['tel'] ?>" value="<?= $l['id'] ?>" class="update btn text-warning" title="Modifier les informations du chauffeur" data-bs-toggle="modal" data-bs-target="#modalIdEdit">
                            <i cla data-feather="edit"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
            <?= form_close() ?>
          <?php endif ?>

        </div>

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalIdadd" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleIdadd" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleIdadd">Ajout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(base_url(session()->r . '/chauffeurs'), [
          'id' =>  'ezna'
        ]) ?>
        <div class="mb-3">
          <label for="nom" class="form-label">Nom du chauffeur<span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?= set_value('nom') ?>" name="nom" id="nom" placeholder="Entrez le nom du chauffeur" required>
        </div>
        <div class="mb-3">
          <label for="tel" class="form-label">Numéro de téléphone<span class="text-danger">*</span></label>
          <input type="tel" class="form-control" required value="<?= set_value('tel') ?>" name="tel" id="tel" placeholder="Entrez le numéro de téléphone du chauffeur">
        </div>
        <div class="mb-3">
          <label for="societe" class="form-label">Société<span class="text-danger">*</span></label>
          <select class="form-select " name="societe" id="societe">
            <option value="POLY-TRANS SUARL" <?= set_select('societe', 'POLY-TRANS SUARL', true) ?>>POLY-TRANS SUARL</option>
            <option value="CMA" <?= set_select('societe', 'CMA', false) ?>>CMA</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="camion" class="form-label">Camions</label>
          <select class="form-select" name="camion" id="camion">
            <option value="" hidden selected>Sélectionner un camion</option>
            <option value="" <?= set_select('camion', '', false) ?>>Pas de camion</option>
            <?php foreach ($cam as $c) : ?>
              <option value="<?= $c['id'] ?>" <?= set_select('camion', $c['id'], false) ?>><?= $c['im'] ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="ezna" class="btn btn-primary">Ajouter</button>
      </div>
    </div>
  </div>
</div>


<script>
  const myModalAdd = new bootstrap.Modal(document.getElementById('modalIdadd'), options)
</script>

<div class="modal fade" id="modalIdEdit" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleIdEdit" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleIdEdit">Modification</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(base_url(session()->r . '/chauffeurs/edit'), [
          'id' =>  'ezn'
        ]) ?>
        <div class="mb-3">
          <label for="nom" class="form-label">Nom du chauffeur<span class="text-danger">*</span></label>
          <input type="text" class="form-control" value="<?= set_value('nom') ?>" name="nom" id="nommod" placeholder="Entrez le nom du chauffeur" required>
        </div>
        <div class="mb-3">
          <label for="tel" class="form-label">Numéro de téléphone<span class="text-danger">*</span></label>
          <input type="tel" class="form-control" required value="<?= set_value('tel') ?>" name="tel" id="telmod" placeholder="Entrez le numéro de téléphone du chauffeur">
        </div>
        <div class="mb-3">
          <label for="societe" class="form-label">Société<span class="text-danger">*</span></label>
          <select class="form-select " name="societe" id="societemod">
            <option value="POLY-TRANS SUARL" <?= set_select('societe', 'POLY-TRANS SUARL', true) ?>>POLY-TRANS SUARL</option>
            <option value="CMA" <?= set_select('societe', 'CMA', false) ?>>CMA</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="camion" class="form-label">Camions</label>
          <select class="form-select" name="camion" id="camionmod">
            <option value="" hidden selected>Sélectionner un camion</option>
            <option value="" <?= set_select('camion', '', false) ?>>Pas de camion</option>
            <?php foreach ($cam as $c) : ?>
              <option value="<?= $c['id'] ?>" <?= set_select('camion', $c['id'], false) ?>><?= $c['im'] ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" id="eznb" name="id" form="ezn" class="btn btn-primary">Modifier</button>
      </div>
    </div>
  </div>
</div>


<!-- Optional: Place to the bottom of scripts -->
<script>
  const myModalEdit = new bootstrap.Modal(document.getElementById('modalIdEdit'), options)
</script>


<div class="modal fade" id="modalIdDelete" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleIdDelete" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleIdDelete">Suppression</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Supprimer le chauffeur: <span id="zn" class="text-primary"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <a id="znb" href="" class="btn btn-primary">Supprimer</a>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalIddelG" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleIddelG" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleIddelG">Suppression groupée</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Supprimer les chauffeurs sélectionnées?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="gd" class="btn btn-primary">Supprimer</button>
      </div>
    </div>
  </div>
</div>


<!-- Optional: Place to the bottom of scripts -->
<script>
  const myModal = new bootstrap.Modal(document.getElementById('modalIddelG'), options)
</script>

<script>
  const myModalDelete = new bootstrap.Modal(document.getElementById('modalIdDelete'), options)
</script>
<script>
  $('.delete').click(function(e) {
    e.preventDefault();
    $('#zn').html($(this).data('nom'));
    $('#znb').attr('href','<?= base_url(session()->r . '/chauffeurs/del/') ?>'+$(this).data('id'));

  });

  $('.update').click(function(e) {
    e.preventDefault();
    $('#eznb').val($(this).data('id'));
    $('#nommod').val($(this).data('nom'));
    $('#telmod').val($(this).data('tel'));
    $('#camionmod').val($(this).data('camionid'));
    $('#societemod').val($(this).data('societe'));
  });
</script>

<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script>
  $(document).ready(function() {
    $('.table').DataTable({
      responsive: true,
      dom: 'Bfrtip',
      buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        'pdfHtml5',
      ],
      language: {
        decimal: ',',
        thousands: '.'
      },
    });
  });
</script>

<?= $this->endSection(); ?>