/*
|--------------------------------------------------------------------------
| AFFICHAGE DES SECTIONS (SAFE VERSION)
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

    const content = document.getElementById('section-' + section);

    if (content)
    {
        content.classList.remove('hidden');
    }
    else
    {
        console.error("Section introuvable :", section);
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULAIRES
    |--------------------------------------------------------------------------
    */

    const forms = [
        'form-auteur',
        'form-message',
        'form-reponse',
        'form-activite',
        'form-erreur',
        'form-indice'
    ];

    forms.forEach(id =>
    {
        const el = document.getElementById(id);
        if (el) el.classList.add('hidden');
    });

    const form = document.getElementById('form-' + section);

    if (form)
    {
        form.classList.remove('hidden');
    }

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
| ACTIVITE
|--------------------------------------------------------------------------
*/

window.openFormActivite = function (btn)
{
    showSection('activite');

    document.getElementById('activite-numero').value =
        btn.dataset.numero || '';

    document.getElementById('activite-libelle').value =
        btn.dataset.libelle || '';

    scrollToTop();
};

function resetActiviteForm()
{
    document.getElementById('activite-numero').value = '';
    document.getElementById('activite-libelle').value = '';
    
}

/*
|--------------------------------------------------------------------------
| ERREUR
|--------------------------------------------------------------------------
*/


window.openFormErreur = function (btn)
{
    showSection('erreur');

    document.getElementById('erreur-numero').value =
        btn.dataset.numero || '';

    document.getElementById('erreur-mot').value =
        btn.dataset.mot || '';
    document.getElementById('erreur-explication').value =
        btn.dataset.explication || '';

    scrollToTop();
};

function resetErreurForm()
{
    document.getElementById('erreur-numero').value = '';

    document.getElementById('erreur-mot').value = '';
    document.getElementById('erreur-explication').value = '';
    
}

/*
|--------------------------------------------------------------------------
| AUTEUR
|--------------------------------------------------------------------------
*/

window.openFormAuteur = function (btn)
{
    showSection('auteur');

    document.getElementById('auteur-numero').value =
        btn.dataset.numero || '';

    document.getElementById('auteur-nom').value =
        btn.dataset.nom || '';

    document.getElementById('auteur-prenom').value =
        btn.dataset.prenom || '';

    document.getElementById('auteur-fonction').value =
        btn.dataset.fonction || '';

    scrollToTop();
};

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