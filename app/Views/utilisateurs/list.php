<?= $this->extend('layouts'); ?>
<?= $this->section('title'); ?>
Liste des utilisateurs
<?= $this->endSection(); ?>

<?= $this->section('main'); ?>
<div class=" container-fluid p-0">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h3"><strong>Suivie</strong> Utilisateurs</h1>
    <div>
      <a class="btn btn-primary" role="button" data-bs-toggle="modal" data-bs-target="#newumod">
        <i data-feather="plus"></i> Ajouter
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-12 d-flex">
      <div class="card flex-fill">
        <div class="card-header">

          <h5 class="card-title mb-0">Liste des utilisateurs (<span class="text-primary"><?= $count ?></span>)</h5>
        </div>
        <?php if ($count == 0) : ?>
          <div class="card-body">
            <div class="alert alert-warning" role="alert">
              Aucun utilisateur enregistré.
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
              <?= form_open() ?>
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
                      <button type="button" class="delete btn text-danger" title="Supprimer l'utilisateur" data-bs-toggle="modal" data-bs-target="#delete">
                        <i cla data-feather="trash"></i>
                      </button>
                      <button type="button" class="update btn text-warning" title="Modifier les informations de l'utilisateur">
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
        <h5 class="modal-title" id="modalTitleId">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= form_open(base_url(session()->r . '/utilisateurs'), [
          'id' => 'newUser'
        ]) ?>

        <div class="mb-3">
          <label for="profil" class="form-label">Profil<span class="text-danger">*</span> </label>
          <select class="form-select" name="profil" id="profil" required>
            <option <?= set_select('profil','',true) ?> hidden value="">Sélectionner un profil</option>
            <option <?= set_select('profil','AMDIN') ?> value="ADMIN">ADMIN</option>
            <option <?= set_select('profil','FACTURATION') ?> value="FACTURATION">FACTURATION</option>
            <option <?= set_select('profil','CONTROLE') ?> value="CONTROLE">CONTROLE</option>
            <option <?= set_select('profil','TRANSPORT') ?> value="TRANSPORT">TRANSPORT</option>
            <option <?= set_select('profil','FINANCE') ?> value="FINANCE">FINANCE</option>
            <option <?= set_select('profil','FLOTTE') ?> value="FLOTTE">FLOTTE</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="nom" class="form-label">Nom<span class="text-danger">*</span></label>
          <input required type="text" value="<?= set_value('nom','') ?>" class="form-control" name="nom" id="nom" placeholder="Nom de l'utilisateur">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
          <input type="email" class="form-control" name="email" value="<?= set_value('email','') ?>" id="email" placeholder="Email de l'utilisateur">
        </div>
        <div class="mb-3">
          <label for="tel" class="form-label">Téléphone</label>
          <input type="tel" class="form-control" name="tel" id="tel" value="<?= set_value('tel','') ?>" placeholder="Numéro de téléphone de l'utilisateur">
        </div>
        <?= csrf_field() ?>
        <?= form_close() ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="newUser" class="btn btn-primary">Créer le compte</button>
      </div>
    </div>
  </div>
</div>


<!-- Optional: Place to the bottom of scripts -->
<script>
  const newuMod = new bootstrap.Modal(document.getElementById('newumod'), options)
</script>


<script>
  const deletemodal = new bootstrap.Modal(document.getElementById('delete'), options)
</script>
<script>
  $('.delete').click(function(e) {
    e.preventDefault();

    const data = $(this).parents('tr').children('td');
    const id = data[0].id;
    const name = data[1].innerText;

    $('#delUser').html(name);
    $('#delsubmit').attr('href', '<?= base_url(session()->r . '/utilisateurs/del?id=') ?>' + id);
  });
</script>
<?= $this->endSection(); ?>