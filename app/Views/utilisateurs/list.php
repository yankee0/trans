<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Liste des utilisateurs
<?= $this->endSection(); ?>

<?= $this->section('main'); ?>
<div class=" container-fluid p-0">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h3"><strong>Gestion</strong> Utilisateurs</h1>
    <div>
      <a class="btn btn-primary" role="button" data-bs-toggle="modal" data-bs-target="#newumod">
        <i data-feather="plus"></i> Ajouter
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-12 d-flex">
      <div class="card flex-fill">
        <div class="card-body ">
          <form action="<?= base_url(session()->r.'/utilisateurs/search') ?>" class="d-flex gap-2">
            <input type="search" value="<?= (isset($search)) ? $search : '' ?>" class="form-control flex-grow-1" name="search" id="search" placeholder="Rechercher un utilisateur">
            <button class="btn btn-primary d-flex gap-2 justify-content-center align-items-center"><i data-feather="search"></i> <span class="d-none d-md-flex">Rechercher</span></button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-12 d-flex">
      <div class="card flex-fill">
        <div class="card-header">

          <h5 class="card-title mb-3">Liste des utilisateurs (<span class="text-primary"><?= $count ?></span>)</h5>
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalIdGDel">
            Suppression groupée
          </button>
        </div>
        <?php if ($count == 0) : ?>
          <div class="card-body">
            <div class="alert alert-warning" role="alert">
              Aucun utilisateur trouvé.
            </div>
          </div>
        <?php else :  ?>
          <table class="table table-hover my-0">
            <thead>
              <tr>
                <th></th>
                <th>Nom</th>
                <th class="d-none d-sm-table-cell">Profil</th>
                <th class="d-none d-xl-table-cell">Email</th>
                <th class="d-none d-xl-table-cell">Téléphone</th>
                <th class="d-none d-sm-table-cell">Date de création</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?= form_open(base_url(session()->r . '/utilisateurs/del'), [
                'id' => 'delG'
              ]) ?>
              <?php foreach ($list as $l) : ?>
                <tr>
                  <td id="<?= $l['id'] ?>">
                    <input class="form-check-input" type="checkbox" name="id[]" value="<?= $l['id'] ?>" id="c-<?= $l['id'] ?>">
                  </td>
                  <td><?= $l['nom'] ?></td>
                  <td class="d-none d-sm-table-cell"><?= $l['profil'] ?></td>
                  <td class="d-none d-xl-table-cell"><?= $l['email'] ?></td>
                  <td class="d-none d-xl-table-cell"><?= $l['tel'] ?></td>
                  <td class="d-none d-sm-table-cell"><?= $l['created_at'] ?></td>
                  <td>
                    <div class="d-flex gap-2">
                      <button type="button" data-id="<?= $l['id'] ?>" data-nom="<?= $l['nom'] ?>" data-profil="<?= $l['profil'] ?>" data-tel="<?= $l['tel'] ?>" data-email="<?= $l['email'] ?>" class="delete btn text-danger" title="Supprimer l'utilisateur" data-bs-toggle="modal" data-bs-target="#delete">
                        <i cla data-feather="trash"></i>
                      </button>
                      <button type="button" data-id="<?= $l['id'] ?>" data-nom="<?= $l['nom'] ?>" data-profil="<?= $l['profil'] ?>" data-tel="<?= $l['tel'] ?>" data-email="<?= $l['email'] ?>" data-bs-toggle="modal" value="<?= $l['id'] ?>" data-bs-target="#modalIdmodu" class="update btn text-warning" title="Modifier les informations de l'utilisateur">
                        <i cla data-feather="edit"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              <?php endforeach ?>
              <?= form_close() ?>
            </tbody>
          </table>
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

<!-- group delete -->
<div class="modal fade" id="modalIdGDel" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="gdel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gdel">Suppression groupée</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Supprimer les utilisateurs sélectionnés?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary" form="delG">Supprimer</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="delete" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="deleteTi" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteTi">Suppression</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Souhaitez vous supprimer l'utilisateur: <br>
        <span id="delUser" class="text-primary"></span>
        <form action="<?= base_url(session()->r . '/utilisateurs/del') ?>" id="deluserform" method="get"></form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non, fermer.</button>
        <a id="delsubmit" name="id" class="btn btn-primary">Oui, supprimer.</a>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="newumod" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Ajouter un utilisateur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(base_url(session()->r . '/utilisateurs'), [
          'id' => 'newUser'
        ]) ?>

        <div class="mb-3">
          <label for="profil" class="form-label">Profil<span class="text-danger">*</span> </label>
          <select class="form-select" name="profil" id="profil" required>
            <option <?= set_select('profil', '', true) ?> hidden value="">Sélectionner un profil</option>
            <option <?= set_select('profil', 'AMDIN') ?> value="ADMIN">ADMIN</option>
            <option <?= set_select('profil', 'FACTURATION') ?> value="FACTURATION">FACTURATION</option>
            <option <?= set_select('profil', 'OPS') ?> value="OPS">OPS</option>
            <option <?= set_select('profil', 'FINANCE') ?> value="FINANCE">FINANCE</option>
            <option <?= set_select('profil', 'FLOTTE') ?> value="FLOTTE">FLOTTE</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="nom" class="form-label">Nom<span class="text-danger">*</span></label>
          <input required type="text" value="<?= set_value('nom', '') ?>" class="form-control" name="nom" id="nom" placeholder="Nom de l'utilisateur">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
          <input required type="email" class="form-control" name="email" value="<?= set_value('email', '') ?>" id="email" placeholder="Email de l'utilisateur">
        </div>
        <div class="mb-3">
          <label for="tel" class="form-label">Téléphone<span class="text-danger">*</span></label>
          <input type="tel" class="form-control" name="tel" id="tel" value="<?= set_value('tel', '') ?>" required placeholder="Numéro de téléphone de l'utilisateur">
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="newUser" class="btn btn-primary">Créer le compte</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalIdmodu" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleIdmodu" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleIdmodu">Modifier utilisateur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(base_url(session()->r . '/utilisateurs/edit'), [
          'id' => 'modUser'
        ]) ?>
        <div class="mb-3">
          <label for="profilmod" class="form-label">Profil<span class="text-danger">*</span> </label>
          <select class="form-select" name="profil" id="profilmod" required>
            <option class="op" <?= set_select('profil', '', true) ?> hidden value="">Sélectionner un profil</option>
            <option class="op" <?= set_select('profil', 'AMDIN') ?> value="ADMIN">ADMIN</option>
            <option class="op" <?= set_select('profil', 'FACTURATION') ?> value="FACTURATION">FACTURATION</option>
            <option class="op" <?= set_select('profil', 'OPS') ?> value="OPS">OPS</option>
            <option class="op" <?= set_select('profil', 'FINANCE') ?> value="FINANCE">FINANCE</option>
            <option class="op" <?= set_select('profil', 'FLOTTE') ?> value="FLOTTE">FLOTTE</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="nommod" class="form-label">Nom<span class="text-danger">*</span></label>
          <input required type="text" value="<?= set_value('nom', '') ?>" class="form-control" name="nom" id="nommod" placeholder="Nom de l'utilisateur">
        </div>
        <div class="mb-3">
          <label for="emailmod" class="form-label">Email<span class="text-danger">*</span></label>
          <input type="email" class="form-control" name="email" value="<?= set_value('email', '') ?>" id="emailmod" required placeholder="Email de l'utilisateur">
        </div>
        <div class="mb-3">
          <label for="telmod" class="form-label">Téléphone<span class="text-danger">*</span></label>
          <input type="tel" class="form-control" name="tel" id="telmod" value="<?= set_value('tel', '') ?>" required placeholder="Numéro de téléphone de l'utilisateur">
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" form="modUser" name="id" id="submod" class="btn btn-primary">Modifier</button>
      </div>
    </div>
  </div>
</div>

<script>
  const myModalDelG = new bootstrap.Modal(document.getElementById('modalIdGDel'), options)
</script>
<script>
  const myModalmod = new bootstrap.Modal(document.getElementById('modalIdmodu'), options)
</script>
<script>
  const newuMod = new bootstrap.Modal(document.getElementById('newumod'), options)
</script>
<script>
  const deletemodal = new bootstrap.Modal(document.getElementById('delete'), options)
</script>

<script>
  $('.delete').click(function(e) {
    e.preventDefault();
    $('#delUser').html($(this).data('nom'));
    $('#delsubmit').attr('href', '<?= base_url(session()->r . '/utilisateurs/del?id=') ?>' + $(this).data('id'));
  });
</script>

<script>
  $('.update').click(function(e) {
    e.preventDefault();
    $('#nommod').val($(this).data('nom'));
    $('#emailmod').val($(this).data('email'));
    $('#telmod').val($(this).data('tel'));
    $('#submod').val($(this).data('id'));
    $('#profilmod').val($(this).data('profil'));
    
  });
</script>
<?= $this->endSection(); ?>