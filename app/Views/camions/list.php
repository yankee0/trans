<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Liste des camions
<?= $this->endSection(); ?>

<?= $this->section('main'); ?>
<div class=" container-fluid p-0">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h3"><strong>Gestion</strong> camions</h1>
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
          <h5 class="card-title mb-3">Liste des camions (<span class="text-primary"><?= $count ?></span>)</h5>
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
            <?= form_open(base_url(session()->r . '/camions/del'), [
              'id' => 'gd'
            ]) ?>
            <div class="table-responsive">
              <table class="table table-hover my-0">
                <thead>
                  <tr>
                    <th></th>
                    <th>Immatriculation</th>
                    <th class="">Société</th>
                    <th class="">Fin visite technique</th>
                    <th class="">Fin assurance</th>
                    <th class="" style="max-width: 400px;">Commentaires</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($list as $l) : ?>
                    <tr>
                      <td id="<?= $l['id'] ?>">
                        <input class="form-check-input" type="checkbox" name="id[]" value="<?= $l['id'] ?>" id="c-<?= $l['id'] ?>">
                      </td>
                      <td><?= $l['im'] ?></td>
                      <td class=""><?= $l['societe'] ?></td>
                      <td class=""><?= $l['vt'] ?></td>
                      <td class=""><?= $l['as'] ?></td>
                      <td class="" style="max-width: 400px;"><?= $l['commentaire'] ?></td>
                      <td>
                        <div class="d-flex gap-2">
                          <button type="button" data-id="<?= $l['id'] ?>" data-im="<?= $l['im'] ?>" data-societe="<?= $l['societe'] ?>" data-vt="<?= $l['vt'] ?>" data-commentaire="<?= $l['commentaire'] ?>" data-as="<?= $l['as'] ?>" class="delete btn text-danger" value="<?= $l['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalIdDelete" title="Supprimer la camion" data-bs-toggle="modal" data-bs-target="#delete">
                            <i cla data-feather="trash"></i>
                          </button>
                          <button type="button" data-id="<?= $l['id'] ?>" data-im="<?= $l['im'] ?>" data-societe="<?= $l['societe'] ?>" data-vt="<?= $l['vt'] ?>" data-commentaire="<?= $l['commentaire'] ?>" data-as="<?= $l['as'] ?>" value="<?= $l['id'] ?>" class="update btn text-warning" title="Modifier les informations de la camion" data-bs-toggle="modal" data-bs-target="#modalIdEdit">
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
        <?= form_open(base_url(session()->r . '/camions'), [
          'id' =>  'ezna'
        ]) ?>
        <div class="mb-3">
          <label for="im" class="form-label">Immatriculation<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="im" id="im" value="<?= set_value('im') ?>" placeholder="Entrez le numéro d'immatriculation" required>
        </div>
        <div class="mb-3">
          <label for="societe" class="form-label">Compagnie<span class="text-danger">*</span></label>
          <select class="form-select " name="societe" id="societe">
            <option value="POLY-TRANS SUARL" <?= set_select('societe', 'POLY-TRANS SUARL', true) ?>>POLY-TRANS SUARL</option>
            <option value="CMA" <?= set_select('societe', 'CMA', false) ?>>CMA</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="vt" class="form-label">Fin visite technique</label>
          <input type="date" class="form-control" name="vt" id="vt" aria-describedby="helpIdvt" value="<?= set_value('vt', null) ?>">
          <small id="helpIdvt" class="form-text text-muted">À laisser vide en cas d'indisponibilité.</small>
        </div>
        <div class="mb-3">
          <label for="as" class="form-label">Fin assurrance</label>
          <input type="date" class="form-control" name="as" id="as" aria-describedby="helpIdas" value="<?= set_value('as', null) ?>">
          <small id="helpIdas" class="form-text text-muted">À laisser vide en cas d'indisponibilité.</small>
        </div>
        <div class="mb-3">
          <label for="commentaire" class="form-label">Commentaire</label>
          <textarea class="form-control" name="commentaire" id="commentaire" rows="3"></textarea>
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
        <?= form_open(base_url(session()->r . '/camions/edit'), [
          'id' =>  'ezn'
        ]) ?>
        <div class="mb-3">
          <label for="immod" class="form-label">Immatriculation<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="im" id="immod" value="<?= set_value('im') ?>" placeholder="Entrez le numéro d'immatriculation" required>
        </div>
        <div class="mb-3">
          <label for="societemod" class="form-label">Compagnie<span class="text-danger">*</span></label>
          <select class="form-select " name="societe" id="societemod">
            <option value="POLY-TRANS SUARL" <?= set_select('societe', 'POLY-TRANS SUARL', true) ?>>POLY-TRANS SUARL</option>
            <option value="CMA" <?= set_select('societe', 'CMA', false) ?>>CMA</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="vtmod" class="form-label">Fin visite technique</label>
          <input type="date" class="form-control" name="vt" id="vtmod" aria-describedby="helpIdvt" value="<?= set_value('vt', null) ?>">
          <small id="helpIdvt" class="form-text text-muted">À laisser vide en cas d'indisponibilité.</small>
        </div>
        <div class="mb-3">
          <label for="asmod" class="form-label">Fin assurrance</label>
          <input type="date" class="form-control" name="as" id="asmod" aria-describedby="helpIdas" value="<?= set_value('as', null) ?>">
          <small id="helpIdas" class="form-text text-muted">À laisser vide en cas d'indisponibilité.</small>
        </div>
        <div class="mb-3">
          <label for="commentaireMod" class="form-label">Commentaire</label>
          <textarea class="form-control" name="commentaire" id="commentaireMod"  rows="3"></textarea>
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
        Supprimer le camion: <span id="zn" class="text-primary"></span>
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
        Supprimer les camions sélectionnés?
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
    $('#zn').html($(this).data('im'));
    $('#znb').attr("href", '<?= base_url(session()->r . '/camions/del/') ?>' + $(this).data('id'));
  });

  $('.update').click(function(e) {
    e.preventDefault();
    $('#immod').val($(this).data('im'));
    $('#vtmod').val($(this).data('vt'));
    $('#asmod').val($(this).data('as'));
    $('#commentairemod').val($(this).data('commentaire'));
    $('#societemod').val($(this).data('societe'));
    $('#eznb').val($(this).data('id'));
    console.log($(this).data('commentaire'));
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