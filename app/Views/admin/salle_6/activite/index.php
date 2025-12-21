<?= $this->extend('admin/salle_6/layout') ?>
<?= $this->section('content') ?>

<h2>Liste activite</h2>
<a href="<?= site_url('admin/activite/create') ?>">Ajouter</a>
<table>
<thead><tr><th>id</th><th>nom</th><th>description</th><th>Actions</th></tr></thead>
<tbody>
<?php foreach ($activites as $activite): ?>
<tr>
<td><?= esc($activite['id']) ?></td><td><?= esc($activite['nom']) ?></td><td><?= esc($activite['description']) ?></td>
<td>
<a href="<?= site_url('admin/activite/edit/' . $activite['id']) ?>">Edit</a>
</td>
</tr>
<?php endforeach ?>
</tbody>
</table>

<?= $this->endSection() ?>