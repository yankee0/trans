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
        <div class="card-body ">
          <form action="<?= base_url(session()->r . '/chauffeurs/search') ?>" class="d-flex gap-2">
            <input type="search" value="<?= (isset($search)) ? $search : '' ?>" class="form-control flex-grow-1" name="search" id="search" placeholder="Rechercher un chauffeur">
            <button class="btn btn-primary d-flex gap-2 justify-content-center align-items-center"><i data-feather="search"></i> <span class="d-none d-md-flex">Rechercher</span></button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-12 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <h5 class="card-title mb-3">Liste des chauffeurs (<span class="text-primary"><?= $count ?></span>)</h5>
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalIddelG">
            Suppression groupée
          </button>
        </div>
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
          <table class="table table-hover my-0">
            <thead>
              <tr>
                <th></th>
                <th>Nom</th>
                <th class="d-none d-xl-table-cell">Téléphone</th>
                <th class="d-none d-sm-table-cell">Compagnie</th>
                <th class="d-none d-xl-table-cell">Camion</th>
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
                  <td class="d-none d-xl-table-cell"><?= $l['tel'] ?></td>
                  <td class="d-none d-sm-table-cell"><?= $l['societe'] ?></td>

                  <td class="d-none d-xl-table-cell"><?= (empty($l['camion'])) ? '<span class=" badge bg-dark">Pas de camion</span>' : $l['camion'] ?></td>
                  <td>
                    <div class="d-flex gap-2">
                      <button type="button" class="delete btn text-danger" value="<?= $l['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalIdDelete" title="Supprimer la chauffeur" data-bs-toggle="modal" data-bs-target="#delete">
                        <i cla data-feather="trash"></i>
                      </button>
                      <button type="button" value="<?= $l['id'] ?>" class="update btn text-warning" title="Modifier les informations du chauffeur" data-bs-toggle="modal" data-bs-target="#modalIdEdit">
                        <i cla data-feather="edit"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
          <?= form_close() ?>
        <?php endif ?>
        <div class="card-footer text-center d-flex justify-content-end" style="overflow-x: scroll">
          <nav class="pagination">
            <?= $pager->links() ?>
          </nav>
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
          <label for="societe" class="form-label">Compagnie<span class="text-danger">*</span></label>
          <select class="form-select " name="societe" id="societe">
            <option value="POLY-TRANS SUARL" <?= set_select('societe', 'POLY-TRANS SUARL', true) ?>>POLY-TRANS SUARL</option>
            <option value="CMA" <?= set_select('societe', 'CMA', false) ?>>CMA</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="camion" class="form-label">Camions</label>
          <select class="form-select" name="camion" id="camion" required>
            <option value="" hidden selected>Sélectionner un camion</option>
            <option value="" <?= set_select('camion', '', false) ?>>Pas de camion</option>
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
          <label for="societe" class="form-label">Compagnie<span class="text-danger">*</span></label>
          <select class="form-select " name="societe" id="societemod">
            <option value="POLY-TRANS SUARL" <?= set_select('societe', 'POLY-TRANS SUARL', true) ?>>POLY-TRANS SUARL</option>
            <option value="CMA" <?= set_select('societe', 'CMA', false) ?>>CMA</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="camion" class="form-label">Camions</label>
          <select class="form-select" name="camion" id="camionmod" required>
            <option value="" hidden selected>Sélectionner un camion</option>
            <option value="" <?= set_select('camion', '', false) ?>>Pas de camion</option>
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
        Supprimer la chauffeur: <span id="zn" class="text-primary"></span>
        <form action="<?= base_url(session()->r . '/chauffeurs/del') ?>" id="delForm" method="get"></form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" id="znb" name="id" form="delForm" class="btn btn-primary">Supprimer</button>
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
    const i = $(this).val();
    $.ajax({
      type: "get",
      url: "<?= base_url('api/chauffeurs') ?>",
      data: {
        token: '<?= csrf_hash() ?>',
        index: i
      },
      dataType: "JSON",
      success: function(response) {
        $('#zn').html(response.nom);
        $('#znb').val(response.id);
      }
    });
  });

  $('.update').click(function(e) {
    e.preventDefault();
    const i = $(this).val();
    $.ajax({
      type: "get",
      url: "<?= base_url('api/chauffeurs') ?>",
      data: {
        token: '<?= csrf_hash() ?>',
        index: i
      },
      dataType: "JSON",
      success: function(response) {
        $('#eznb').val(response.id);
        $('#nommod').val(response.nom);
        $('#telmod').val(response.tel);
        document.querySelectorAll('#camionmod option').forEach(element => {
          if (element.value == response.camion) {
            $(element).attr('selected', 'selected')
          }
        })
        document.querySelectorAll('#societemod option').forEach(element => {
          if (element.value == response.societe) {
            $(element).attr('selected', 'selected')
          }
        })
      }
    });
  });

  
</script>

<?= $this->endSection(); ?>