/*
|--------------------------------------------------------------------------
| AFFICHAGE DES SECTIONS
|--------------------------------------------------------------------------
*/

function showSection(section, element = null)
{
    /*
    |--------------------------------------------------------------------------
    | CONTENT
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.content-section')
        .forEach(el =>
        {
            el.classList.add('hidden');
        });

    document
        .getElementById('section-' + section)
        .classList.remove('hidden');

    /*
    |--------------------------------------------------------------------------
    | FORMULAIRES
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('form-auteur')
        .classList.add('hidden');

    document
        .getElementById('form-message')
        .classList.add('hidden');

    document
        .getElementById('form-reponse')
        .classList.add('hidden');

    document
        .getElementById('form-' + section)
        .classList.remove('hidden');

    /*
    |--------------------------------------------------------------------------
    | SIDEBAR ACTIVE
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.nav-card')
        .forEach(el =>
        {
            el.classList.remove('active');
        });

    if (element)
    {
        element.classList.add('active');
    }
}

/*
|--------------------------------------------------------------------------
| AUTEUR
|--------------------------------------------------------------------------
*/

function openFormAuteur(data)
{
    showSection('auteur');

    document.getElementById('auteur-numero').value =
        data.numero;

    document.getElementById('auteur-nom').value =
        data.nom;

    document.getElementById('auteur-prenom').value =
        data.prenom;

    document.getElementById('auteur-fonction').value =
        data.fonction_role;

    scrollToTop();
}

function resetAuteurForm()
{
    document.getElementById('auteur-numero').value = '';

    document.getElementById('auteur-nom').value = '';

    document.getElementById('auteur-prenom').value = '';

    document.getElementById('auteur-fonction').value = '';
}

/*
|--------------------------------------------------------------------------
| MESSAGE
|--------------------------------------------------------------------------
*/

function openFormMessage(data)
{
    showSection('message');

    document.getElementById('message-id').value =
        data.id;

    document.getElementById('message-content').value =
        data.message;

    document.getElementById('message-auteur').value =
        data.auteur_numero;

    scrollToTop();
}

function resetMessageForm()
{
    document.getElementById('message-id').value = '';

    document.getElementById('message-content').value = '';

    document.getElementById('message-auteur').selectedIndex = 0;
}

/*
|--------------------------------------------------------------------------
| REPONSE
|--------------------------------------------------------------------------
*/

function openFormReponse(data)
{
    showSection('reponse');

    document.getElementById('reponse-id').value =
        data.id;

    document.getElementById('reponse-mot').value =
        data.mot;

    document.getElementById('reponse-message-id').value =
        data.message_id;

    document.getElementById('reponse-libelle').value =
        data.libelle;

    scrollToTop();
}

function resetReponseForm()
{
    document.getElementById('reponse-id').value = '';

    document.getElementById('reponse-mot').value = '';

    document.getElementById('reponse-message-id').selectedIndex = 0;

    document.getElementById('reponse-libelle').value = '';
}

/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
*/

function confirmDelete(type, numero, nom)
{
    Swal.fire({

        title: 'Supprimer ?',

        text: nom,

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Oui',

        cancelButtonText: 'Annuler'

    }).then((result) =>
    {
        if (result.isConfirmed)
        {
            window.location.href =
                `/ProjetMadeInValDeLoire/public/index.php/gingembre/admin/delete/${type}/${numero}`;
        }
    });
}

/*
|--------------------------------------------------------------------------
| SCROLL
|--------------------------------------------------------------------------
*/

function scrollToTop()
{
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}