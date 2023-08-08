<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Liste des zones
<?= $this->endSection(); ?>

<?= $this->section('main'); ?>
<div class=" container-fluid p-0">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h3"><strong>Gestion</strong> Zones</h1>
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
          <form action="<?= base_url(session()->r . '/zones/search') ?>" class="d-flex gap-2">
            <input type="search" value="<?= (isset($search)) ? $search : '' ?>" class="form-control flex-grow-1" name="search" id="search" placeholder="Rechercher une zone">
            <button class="btn btn-primary d-flex gap-2 justify-content-center align-items-center"><i data-feather="search"></i> <span class="d-none d-md-flex">Rechercher</span></button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-12 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <h5 class="card-title mb-3">Liste des zones (<span class="text-primary"><?= $count ?></span>)</h5>
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalIddelG">
            Suppression groupée
          </button>
        </div>
        <?php

        if (sizeof($list) == 0) : ?>
          <div class="card-body">
            <div class="alert alert-warning" role="alert">
              Aucune zone trouvée.
            </div>
          </div>

        <?php else : ?>
          <?= form_open(base_url(session()->r . '/zones/del'), [
            'id' => 'gd'
          ]) ?>
          <div class=" table-responsive">

            <table class="table table-hover my-0">
              <thead>
                <tr>
                  <th></th>
                  <th>Nom</th>
                  <th>HT Livraison 20'</th>
                  <th>HT Livraison 40'</th>
                  <th>HT Hammar 20'</th>
                  <th>HT Hammar 40'</th>
                  <th>Carburant (en L)</th>
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
                    <td class="num"><?= $l['ht_liv_20'] ?> FCFA</td>
                    <td class="num"><?= $l['ht_liv_40'] ?> FCFA</td>
                    <td class="num"><?= $l['ham_20'] ?> FCFA</td>
                    <td class="num"><?= $l['ham_40'] ?> FCFA</td>
                    <td><?= $l['carburant'] ?></td>
                    <td>
                      <div class="d-flex gap-2">
                        <button data-id="<?= $l['id'] ?>" data-nom="<?= $l['nom'] ?>" data-htliv20="<?= $l['ht_liv_20'] ?>" data-htliv40="<?= $l['ht_liv_40'] ?>" data-ham20="<?= $l['ham_20'] ?>" data-ham40="<?= $l['ham_40'] ?>" data-carburant="<?= $l['carburant'] ?>" type="button" class="delete btn text-danger" value="<?= $l['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalIdDelete" title="Supprimer la zone" data-bs-toggle="modal" data-bs-target="#delete">
                          <i cla data-feather="trash"></i>
                        </button>
                        <button data-id="<?= $l['id'] ?>" data-nom="<?= $l['nom'] ?>" data-htliv20="<?= $l['ht_liv_20'] ?>" data-htliv40="<?= $l['ht_liv_40'] ?>" data-ham20="<?= $l['ham_20'] ?>" data-ham40="<?= $l['ham_40'] ?>" data-carburant="<?= $l['carburant'] ?>" type="button" value="<?= $l['id'] ?>" class="update btn text-warning" title="Modifier les informations de la zone" data-bs-toggle="modal" data-bs-target="#modalIdEdit"><i cla data-feather="edit"></i></button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
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
        <?= form_open(base_url(session()->r . '/zones'), [
          'id' =>  'ezna'
        ]) ?>
        <div class="mb-3">
          <label for="nom" class="form-label">Nom de la zone<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="nom" id="nom" value="<?= set_value('nom') ?>" placeholder="Entrez le nom de la zone" required>
        </div>
        <?php if (session()->r == 'facturation' or session()->r == 'admin') : ?>
          <div class="mb-3">
            <label for="ht_liv_20" class="form-label">Hors taxes livraison 20'</label>
            <input type="number" min="0" class="form-control" name="ht_liv_20" id="ht_liv_20" value="<?= set_value('ht_liv_20', 0) ?>" placeholder="Entrez la valeur">
          </div>
          <div class="mb-3">
            <label for="ht_liv_40" class="form-label">Hors taxes livraison 40'</label>
            <input type="number" min="0" class="form-control" name="ht_liv_40" id="ht_liv_40" value="<?= set_value('ht_liv_40', 0) ?>" placeholder="Entrez la valeur">
          </div>
          <div class="mb-3">
            <label for="ham_20" class="form-label">Hors taxes hammar 20'</label>
            <input type="number" min="0" class="form-control" name="ham_20" id="ham_20" value="<?= set_value('ham_20', 0) ?>" placeholder="Entrez la valeur">
          </div>
          <div class="mb-3">
            <label for="ham_40" class="form-label">Hors taxes hammar 40'</label>
            <input type="number" min="0" class="form-control" name="ham_40" id="ham_40" value="<?= set_value('ham_40', 0) ?>" placeholder="Entrez la valeur">
          </div>
        <?php endif ?>
        <div class="mb-3">
          <label for="carburant" class="form-label">Carburant</label>
          <input type="number" min="0" class="form-control" name="carburant" id="carburant" value="<?= set_value('carburant', 0) ?>" placeholder="Entrez la valeur">
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
        <?= form_open(base_url(session()->r . '/zones/edit'), [
          'id' =>  'ezn'
        ]) ?>
        <div class="mb-3">
          <label for="nom" class="form-label">Nom de la zone<span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="nom" id="nommod" value="<?= set_value('nom') ?>" placeholder="Entrez le nom de la zone" required>
        </div>
        <?php if (session()->r == 'facturation' or session()->r == 'admin') : ?>
          <div class="mb-3">
            <label for="ht_liv_20mod" class="form-label">Hors taxes livraison 20'</label>
            <input type="number" min="0" class="form-control" name="ht_liv_20" id="ht_liv_20mod" value="<?= set_value('ht_liv_20', 0) ?>" placeholder="Entrez la valeur">
          </div>
          <div class="mb-3">
            <label for="ht_liv_40mod" class="form-label">Hors taxes livraison 40'</label>
            <input type="number" min="0" class="form-control" name="ht_liv_40" id="ht_liv_40mod" value="<?= set_value('ht_liv_40', 0) ?>" placeholder="Entrez la valeur">
          </div>
          <div class="mb-3">
            <label for="ham_20mod" class="form-label">Hors taxes livraison 20'</label>
            <input type="number" min="0" class="form-control" name="ham_20" id="ham_20mod" value="<?= set_value('ham_20', 0) ?>" placeholder="Entrez la valeur">
          </div>
          <div class="mb-3">
            <label for="ham_40mod" class="form-label">Hors taxes livraison 40'</label>
            <input type="number" min="0" class="form-control" name="ham_40" id="ham_40mod" value="<?= set_value('ham_40', 0) ?>" placeholder="Entrez la valeur">
          </div>
        <?php endif ?>
        <div class="mb-3">
          <label for="carburant" class="form-label">Carburant</label>
          <input type="number" min="0" class="form-control" name="carburant" id="carburantmod" value="<?= set_value('carburant', 0) ?>" placeholder="Entrez la valeur">
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
        Supprimer la zone: <span id="zn" class="text-primary"></span>
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
        Supprimer les zones sélectionnées?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="gd" class="btn btn-primary">Supprimer</button>
      </div>
    </div>
  </div>
</div>

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
    $('#znb').attr('href', '<?= base_url(session()->r . '/zones/del/') ?>' + $(this).data('id'));
  });

  $('.update').click(function(e) {
    e.preventDefault();
    $('#nommod').val($(this).data('nom'));
    $('#ht_liv_20mod').val($(this).data('htliv20'));
    $('#ham_20mod').val($(this).data('ham20'));
    $('#ht_liv_40mod').val($(this).data('htliv40'));
    $('#ham_40mod').val($(this).data('ham40'));
    $('#carburantmod').val($(this).data('carburant'));
    $('#eznb').val($(this).data('id'));
  });
</script>

<?= $this->endSection(); ?>