<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= link_tag('styles/salle_5/admin/accueil.css'); ?>
    <title>Salle 5 admin</title>
</head>
<body>
<header>
    <h1>Admin - Physique et matériel</h1>
</header>



<div class="zone-admin">
    <div class="selection-buttons">
        <button>Enigmes</button>
        <button>Objets</button>
        <button>Objets Déclencheurs</button>
    </div>

    <?php if(session()->getFlashdata('message')): ?>
        <div class="alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>
    <div class="table-section">
        <?php if($enigme == false):
            echo "Aucune enigme trouvée";
        else:?>
            <?= anchor('admin/viewAjouter/enigmes', 'Ajouter', ['class' => 'btn-add']) ?>

            <table>
                <tr>
                    <th>numero</th>
                    <th>libelle</th>
                    <th>image</th>
                    <th>type_numero</th>
                    <th>explication_numero</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($enigme as $e):?>
                    <tr>
                        <td><?= $e->numero?></td>
                        <td><?= $e->libelle?></td>
                        <td><?= $e->image?></td>
                        <td><?= $e->type_numero?></td>
                        <td><?= $e->explication_numero?></td>
                        <td><?= form_open(base_url('admin/supprimerEnigme/'.$e->numero.'#enigmes'), [
                                    'onsubmit' => "return confirm('Confirmer la suppression ?')"
                            ]) ?>
                            <?= form_hidden('id', $e->numero) ?>
                            <?= form_hidden('section', 'enigmes') ?>
                            <?= form_button([
                                    'type'    => 'submit',
                                    'content' => 'Supprimer',
                                    'class'   => 'btn-delete'
                            ])?>
                            <?= form_close() ?>

                            <?= form_open(base_url('admin/modifier/'.$e->numero.'#enigmes')) ?>
                            <?= form_hidden('id', $e->numero) ?>
                            <?= form_hidden('section', 'enigmes') ?>
                            <?= form_button([
                                    'type'    => 'submit',
                                    'content' => 'Modifier',
                                    'class'   => 'btn-modifier'
                            ])?>
                            <?= form_close() ?></td>
                    </tr>
                <?php endforeach;?>
            </table>
        <?php endif;?>
    </div>


    <div class="table-section">
        <h2>Objets</h2>
        <?= anchor('admin/viewAjouter/objet', 'Ajouter', ['class' => 'btn-add']) ?>
        <?php if($objets == false):
            echo "Aucun objet trouvée";
        else:?>
            <table>
                <tr>
                    <th>id</th>
                    <th>nom</th>
                    <th>x</th>
                    <th>y</th>
                    <th>width</th>
                    <th>height</th>
                    <th>image</th>
                    <th>reponse</th>
                    <th>texte</th>
                    <th>rotate</th>
                    <th>drag</th>
                    <th>hover</th>
                    <th>cliquable</th>
                    <th>ratio</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($objets as $o):?>
                    <tr>
                        <td><?= $o->id ?></td>
                        <td><?= $o->nom ?></td>
                        <td><?= $o->x ?></td>
                        <td><?= $o->y ?></td>
                        <td><?= $o->width ?></td>
                        <td><?= $o->height ?></td>
                        <td><?= $o->image ?></td>
                        <td><?= $o->reponse ?></td>
                        <td><?= $o->texte ?></td>
                        <td><?= $o->rotate ?></td>
                        <td><?= $o->drag ?></td>
                        <td><?= $o->hover ?></td>
                        <td><?= $o->cliquable ?></td>
                        <td><?= $o->ratio ?></td>
                        <td><?= form_open(base_url('admin/supprimerObjet/'.$o->id.'#objet'), [
                                    'onsubmit' => "return confirm('Confirmer la suppression ?')"
                            ]) ?>
                            <?= form_hidden('id', $o->id) ?>
                            <?= form_hidden('section', 'objet') ?>
                            <?= form_button([
                                    'type'    => 'submit',
                                    'content' => 'Supprimer',
                                    'class'   => 'btn-delete'
                            ])?>
                            <?= form_close() ?>

                            <?= form_open(base_url('admin/modifier/'.$o->id.'#objet')) ?>
                            <?= form_hidden('id', $o->id) ?>
                            <?= form_hidden('section', 'objet') ?>
                            <?= form_button([
                                    'type'    => 'submit',
                                    'content' => 'Modifier',
                                    'class'   => 'btn-modifier'
                            ])?>
                            <?= form_close() ?></td>
                    </tr>
                <?php endforeach;?>
            </table>
        <?php endif;?>
    </div>


    <div class="table-section">
        <h2>Objets déclencheurs</h2>
        <?= anchor('admin/viewAjouter/objets_declencheurs', 'Ajouter', ['class' => 'btn-add']) ?>

        <?php if($objets == false):
            echo "Aucun objet trouvée";
        else:?>
            <table>
                <tr>
                    <th>id</th>
                    <th>nom</th>
                    <th>image</th>
                    <th>x</th>
                    <th>y</th>
                    <th>width</th>
                    <th>height</th>
                    <th>zone_path</th>
                    <th>visible_si_selectionnee</th>
                    <th>visible_si_non_reussie</th>
                    <th>numero_activite</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($objetsDeclencheurs as $oD):?>
                    <tr>
                        <td><?= $oD['id'] ?></td>
                        <td><?= $oD['nom'] ?></td>
                        <td><?= $oD['image_path'] ?></td>
                        <td><?= $oD['x'] ?></td>
                        <td><?= $oD['y'] ?></td>
                        <td><?= $oD['width'] ?></td>
                        <td><?= $oD['height'] ?></td>
                        <td><?= $oD['zone_path'] ?></td>
                        <td><?= $oD['visible_si_selectionnee'] ?></td>
                        <td><?= $oD['visible_si_non_reussie'] ?></td>
                        <td><?= $oD['numero_activite'] ?></td>
                        <td><?= form_open(base_url('admin/supprimerObjetDeclencheur/'.$oD['id'].'#objets_declencheurs'), [
                                    'onsubmit' => "return confirm('Confirmer la suppression ?')"
                            ]) ?>
                            <?= form_hidden('id', $oD['id']) ?>
                            <?= form_hidden('section', 'objets_declencheurs') ?>
                            <?= form_button([
                                    'type'    => 'submit',
                                    'content' => 'Supprimer',
                                    'class'   => 'btn-delete'
                            ])?>
                            <?= form_close() ?>

                            <?= form_open(base_url('admin/modifier/'.$oD['id'].'#objets_declencheurs')) ?>
                            <?= form_hidden('id', $oD['id']) ?>
                            <?= form_hidden('section', 'objets_declencheurs') ?>
                            <?= form_button([
                                    'type'    => 'submit',
                                    'content' => 'Modifier',
                                    'class'   => 'btn-modifier'
                            ])?>
                            <?= form_close() ?></td>
                    </tr>
                <?php endforeach;?>
            </table>
        <?php endif;?>
    </div>
</div>

<?= script_tag(base_url('js/salle_5/admin/accueil.js')) ?>


</body>
</html>
