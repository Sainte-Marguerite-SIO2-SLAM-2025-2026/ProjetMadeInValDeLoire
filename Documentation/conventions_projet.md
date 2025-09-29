# 📋 Conventions de nommage - CodeIgniter 4 (conforme PSR-12)

## Guide des bonnes pratiques pour un code propre, maintenable et conforme aux standards PHP

---

## 1️⃣ Langue et lisibilité

### Règles fondamentales
- **Langue** : Tous les noms doivent être en **français**
- **Clarté** : Les noms doivent être **explicites** et **descriptifs**
- **Restrictions** : Pas d'abréviations obscures ou ambiguës

### Exemples

✅ **Correct**
```php
$nomUtilisateur = "Alice";
$dateInscription = "2025-01-15";
$listeProduits = [];
$scoreTotal = 100;
$configurationBase = [];
```

❌ **Incorrect**
```php
$nu = "Alice";              // Abréviation incompréhensible
$dt = "2025-01-15";         // Trop court
$lst = [];                  // Abréviation obscure
$sc = 100;                  // Ambigu
$cfg = [];                  // Pas explicite
```

---

## 2️⃣ Fichiers et Dossiers (conforme PSR-4)

### Règle PSR-4 fondamentale
**Un fichier contenant une classe doit avoir exactement le même nom que la classe**, avec l'extension `.php`.

### Dossiers
- **Convention** : `snake_case` (minuscules avec underscores)
- **Namespace** : Correspond à la structure des dossiers

### Fichiers de classes
- **Convention** : `PascalCase` (première lettre de chaque mot en majuscule)
- **Règle stricte** : Le nom du fichier = le nom de la classe

### Structure de projet conforme

```
app/
├── Controllers/
│   ├── PersonnageController.php      # class PersonnageController
│   ├── ProduitController.php         # class ProduitController
│   └── TableauBordController.php     # class TableauBordController
│
├── Models/
│   ├── PersonnageModel.php           # class PersonnageModel
│   ├── ProduitModel.php              # class ProduitModel
│   └── CommandeModel.php             # class CommandeModel
│
├── Entities/
│   ├── Personnage.php                # class Personnage
│   ├── Produit.php                   # class Produit
│   └── Commande.php                  # class Commande
│
├── Libraries/
│   ├── GestionnaireEmail.php         # class GestionnaireEmail
│   └── CalculateurScore.php          # class CalculateurScore
│
├── Services/
│   ├── ServiceAuthentification.php   # class ServiceAuthentification
│   └── ServicePaiement.php           # class ServicePaiement
│
└── Views/
    ├── personnage/
    │   ├── index.php
    │   ├── detail.php
    │   └── formulaire.php
    └── tableau_bord/
        └── index.php

public/
└── assets/
    ├── css/
    ├── js/
    └── images/
        ├── personnage/
        └── icone_menu/
```

### Exemples de correspondance fichier/classe

✅ **Correct (PSR-4)**
```php
// Fichier: app/Controllers/PersonnageController.php
namespace App\Controllers;

class PersonnageController extends BaseController
{
    // ...
}

// Fichier: app/Models/PersonnageModel.php
namespace App\Models;

class PersonnageModel extends Model
{
    // ...
}

// Fichier: app/Libraries/GestionnaireEmail.php
namespace App\Libraries;

class GestionnaireEmail
{
    // ...
}
```

❌ **Incorrect**
```php
// ❌ Fichier: personnage_controller.php (snake_case)
class PersonnageController { }

// ❌ Fichier: Personnage.php
class PersonnageController { }  // Nom ne correspond pas

// ❌ Fichier: PersonnageCtrl.php
class PersonnageController { }  // Abréviation dans le fichier
```

---

## 3️⃣ Classes, Propriétés et Méthodes (conforme PSR-12)

### Classes
- **Convention** : `PascalCase`
- **Namespace** : Obligatoire selon PSR-4
- **Accolades** : Sur une nouvelle ligne (style Allman)

### Propriétés
- **Convention** : `camelCase`
- **Visibilité** : Toujours spécifier (`public`, `protected`, `private`)
- **Types** : Déclarer les types (PHP 7.4+)

### Méthodes
- **Convention** : `camelCase`
- **Visibilité** : Toujours spécifier
- **Types de retour** : Déclarer le type de retour

### Exemple complet conforme PSR-12

```php
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\PersonnageModel;
use App\Entities\Personnage;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Contrôleur de gestion des personnages
 */
class PersonnageController extends BaseController
{
    // Propriétés avec types
    protected PersonnageModel $personnageModel;
    private int $scoreMaximum = 1000;
    private bool $modeDebug = false;
    
    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->personnageModel = new PersonnageModel();
    }
    
    /**
     * Affiche la liste des personnages
     */
    public function afficherListe(): string
    {
        $listePersonnages = $this->personnageModel->findAll();
        
        return view('personnage/index', [
            'personnages' => $listePersonnages,
            'titre' => 'Liste des personnages'
        ]);
    }
    
    /**
     * Affiche le détail d'un personnage
     */
    public function afficherDetail(int $idPersonnage): ResponseInterface|string
    {
        $personnage = $this->personnageModel->find($idPersonnage);
        
        if ($personnage === null) {
            return redirect()
                ->to('/personnage')
                ->with('erreur', 'Personnage introuvable');
        }
        
        return view('personnage/detail', [
            'personnage' => $personnage
        ]);
    }
    
    /**
     * Calcule le score final d'un personnage
     */
    public function calculerScoreFinal(int $scoreBase, int $bonus): int
    {
        $scoreFinal = $scoreBase + $bonus;
        
        return min($scoreFinal, $this->scoreMaximum);
    }
    
    /**
     * Valide le nom d'un personnage
     */
    protected function validerNomPersonnage(string $nomComplet): bool
    {
        return strlen($nomComplet) >= 3 && strlen($nomComplet) <= 50;
    }
    
    /**
     * Obtient la configuration par défaut
     */
    private function obtenirConfigurationParDefaut(): array
    {
        return [
            'niveauDepart' => 1,
            'pointsVieInitiaux' => 100,
            'classeParDefaut' => 'guerrier'
        ];
    }
}
```

### Exemple de Model conforme

```php
<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class PersonnageModel extends Model
{
    // Configuration du modèle
    protected $table = 'personnage';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    // Champs autorisés
    protected $allowedFields = [
        'nom_complet',
        'niveau',
        'points_vie',
        'classe_personnage',
        'experience',
        'est_actif'
    ];
    
    // Timestamps
    protected $useTimestamps = true;
    protected $createdField = 'date_creation';
    protected $updatedField = 'date_modification';
    protected $deletedField = 'date_suppression';
    
    // Validation
    protected $validationRules = [
        'nom_complet' => 'required|min_length[3]|max_length[100]',
        'niveau' => 'required|integer|greater_than[0]',
        'points_vie' => 'required|integer|greater_than_equal_to[0]'
    ];
    
    protected $validationMessages = [
        'nom_complet' => [
            'required' => 'Le nom du personnage est obligatoire',
            'min_length' => 'Le nom doit contenir au moins 3 caractères'
        ]
    ];
    
    /**
     * Obtient tous les personnages actifs
     */
    public function obtenirPersonnagesActifs(): array
    {
        return $this->where('est_actif', 1)
                    ->orderBy('niveau', 'DESC')
                    ->findAll();
    }
    
    /**
     * Recherche des personnages par classe
     */
    public function rechercherParClasse(string $classePersonnage): array
    {
        return $this->where('classe_personnage', $classePersonnage)
                    ->orderBy('niveau', 'DESC')
                    ->findAll();
    }
    
    /**
     * Calcule le niveau moyen de tous les personnages
     */
    public function calculerNiveauMoyen(): float
    {
        $resultat = $this->selectAvg('niveau', 'moyenne')
                         ->where('est_actif', 1)
                         ->first();
        
        return (float) ($resultat['moyenne'] ?? 0);
    }
    
    /**
     * Augmente l'expérience d'un personnage
     */
    public function augmenterExperience(int $idPersonnage, int $pointsExperience): bool
    {
        $personnage = $this->find($idPersonnage);
        
        if ($personnage === null) {
            return false;
        }
        
        $nouvelleExperience = $personnage['experience'] + $pointsExperience;
        
        return $this->update($idPersonnage, [
            'experience' => $nouvelleExperience
        ]);
    }
}
```

### Exemple d'Entity conforme

```php
<?php

declare(strict_types=1);

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Personnage extends Entity
{
    // Attributs par défaut
    protected $attributes = [
        'id' => null,
        'nom_complet' => null,
        'niveau' => 1,
        'points_vie' => 100,
        'classe_personnage' => 'guerrier',
        'experience' => 0,
        'est_actif' => true
    ];
    
    // Types de données
    protected $casts = [
        'id' => 'integer',
        'niveau' => 'integer',
        'points_vie' => 'integer',
        'experience' => 'integer',
        'est_actif' => 'boolean',
        'date_creation' => 'datetime',
        'date_modification' => 'datetime'
    ];
    
    // Dates
    protected $dates = [
        'date_creation',
        'date_modification',
        'date_suppression'
    ];
    
    /**
     * Vérifie si le personnage est vivant
     */
    public function estVivant(): bool
    {
        return $this->points_vie > 0;
    }
    
    /**
     * Obtient le nom formaté
     */
    public function obtenirNomFormate(): string
    {
        return ucwords(strtolower($this->nom_complet));
    }
    
    /**
     * Calcule le pourcentage de vie restante
     */
    public function calculerPourcentageVie(int $vieMaximale = 100): float
    {
        if ($vieMaximale === 0) {
            return 0.0;
        }
        
        return ($this->points_vie / $vieMaximale) * 100;
    }
    
    /**
     * Vérifie si le personnage peut monter de niveau
     */
    public function peutMonterNiveau(int $experienceRequise = 1000): bool
    {
        return $this->experience >= $experienceRequise;
    }
    
    /**
     * Applique des dégâts au personnage
     */
    public function appliquerDegats(int $montantDegats): void
    {
        $this->points_vie = max(0, $this->points_vie - $montantDegats);
    }
    
    /**
     * Soigne le personnage
     */
    public function soigner(int $montantSoin, int $vieMaximale = 100): void
    {
        $this->points_vie = min(
            $vieMaximale,
            $this->points_vie + $montantSoin
        );
    }
}
```

---

## 4️⃣ Variables (conforme PSR-12)

### Convention générale
- **Style** : `camelCase`
- **Règle importante** : Noms descriptifs **même dans les boucles**
- **Types** : Utiliser les déclarations de type quand possible

### Variables simples

```php
// Variables de base
$nomUtilisateur = "Alice";
$ageUtilisateur = 25;
$estConnecte = true;
$soldeCompte = 1234.56;

// Variables complexes
$listePersonnages = [];
$donneesFormulaire = [];
$configurationServeur = [];

// Variables avec types (PHP 7.4+)
$compteur = 0;
$messageErreur = "";
$tableauResultats = [];
```

### Boucles foreach - Exemples détaillés

✅ **Correct - Noms explicites**

```php
// Boucle simple sur des personnages
foreach ($listePersonnages as $personnage) {
    echo $personnage->nom_complet;
    echo $personnage->niveau;
}

// Boucle avec index
foreach ($produitsDisponibles as $index => $produit) {
    echo "Position {$index}: {$produit->nom}";
}

// Boucle sur un tableau associatif
foreach ($configurationApplication as $cle => $valeur) {
    echo "{$cle}: {$valeur}";
}

// Boucles imbriquées - Noms distincts et clairs
foreach ($listeCategories as $categorie) {
    echo $categorie->nom;
    
    foreach ($categorie->produits as $produit) {
        echo "  - {$produit->nom} ({$produit->prix}€)";
    }
}

// Boucle sur des commandes et détails
foreach ($listeCommandes as $commande) {
    echo "Commande #{$commande->numero}";
    
    foreach ($commande->lignes as $ligneCommande) {
        echo "  {$ligneCommande->produit}: {$ligneCommande->quantite}";
    }
}

// Boucle avec clé-valeur descriptive
foreach ($parametresUtilisateur as $nomParametre => $valeurParametre) {
    echo "{$nomParametre} = {$valeurParametre}";
}
```

❌ **Incorrect - Noms trop courts ou obscurs**

```php
// Variables d'une seule lettre
foreach ($listePersonnages as $p) {
    echo $p->nom_complet;  // ❌ Qu'est-ce que $p ?
}

// Variables ambiguës
foreach ($produitsDisponibles as $x) {
    echo $x->nom;  // ❌ $x ne veut rien dire
}

// Boucles imbriquées confuses
foreach ($listeCategories as $c) {
    foreach ($c->produits as $p) {  // ❌ $c et $p peu clairs
        echo $p->nom;
    }
}

// Abréviations
foreach ($donneesFormulaire as $k => $v) {  // ❌ $k et $v trop courts
    echo "{$k}: {$v}";
}
```

### Variables dans des contextes spécifiques

```php
// Dans une méthode de contrôleur
public function traiterCommande(int $idCommande): ResponseInterface
{
    $commande = $this->commandeModel->find($idCommande);
    $lignesCommande = $this->ligneCommandeModel
        ->where('commande_id', $idCommande)
        ->findAll();
    
    $montantTotal = 0;
    
    foreach ($lignesCommande as $ligneCommande) {
        $prixUnitaire = $ligneCommande->prix_unitaire;
        $quantite = $ligneCommande->quantite;
        $montantLigne = $prixUnitaire * $quantite;
        
        $montantTotal += $montantLigne;
    }
    
    return $this->response->setJSON([
        'commande' => $commande,
        'lignes' => $lignesCommande,
        'total' => $montantTotal
    ]);
}

// Dans une vue
<?php foreach ($listeArticles as $article): ?>
    <article class="carte-article">
        <h2><?= esc($article->titre) ?></h2>
        <p><?= esc($article->resume) ?></p>
        
        <?php foreach ($article->tags as $tag): ?>
            <span class="badge-tag"><?= esc($tag->nom) ?></span>
        <?php endforeach; ?>
    </article>
<?php endforeach; ?>
```

### Constantes

```php
// Constantes globales (UPPER_SNAKE_CASE)
define('SCORE_MAXIMUM', 1000);
define('DUREE_SESSION', 3600);
define('CHEMIN_UPLOAD', WRITEPATH . 'uploads/');

// Constantes de classe
class Configuration
{
    public const NIVEAU_DEPART = 1;
    public const POINTS_VIE_INITIAUX = 100;
    public const EXPERIENCE_PAR_NIVEAU = 1000;
    
    private const CLE_API_SECRETE = 'abc123xyz';
}
```

---

## 5️⃣ CSS (convention kebab-case)

### Classes CSS
- **Convention** : `kebab-case` (minuscules avec tirets)
- **Style** : Descriptif, modulaire et réutilisable
- **Méthodologie** : BEM recommandé pour les projets complexes

### Exemples de base

```css
/* Composants principaux */
.conteneur-principal {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.bouton-principal {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.zone-de-jeu {
    width: 100%;
    min-height: 500px;
    background-color: #f8f9fa;
}

.carte-personnage {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
```

### Méthodologie BEM (Block Element Modifier)

```css
/* Block: composant principal */
.menu-navigation {
    display: flex;
    list-style: none;
    padding: 0;
}

/* Element: partie du block */
.menu-navigation__item {
    margin-right: 20px;
}

.menu-navigation__lien {
    text-decoration: none;
    color: #333;
    padding: 10px 15px;
}

/* Modifier: variation du block ou element */
.menu-navigation--vertical {
    flex-direction: column;
}

.menu-navigation__lien--actif {
    color: #007bff;
    font-weight: bold;
}

/* Exemple de carte */
.carte-produit {
    border: 1px solid #ddd;
}

.carte-produit__image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.carte-produit__titre {
    font-size: 1.5rem;
    margin: 10px 0;
}

.carte-produit__prix {
    color: #28a745;
    font-weight: bold;
}

.carte-produit--promotion {
    border-color: #dc3545;
    background-color: #fff5f5;
}
```

### États et variations

```css
/* États d'interaction */
.bouton-principal:hover {
    background-color: #0056b3;
}

.bouton-principal:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.bouton-principal:focus {
    outline: 2px solid #007bff;
    outline-offset: 2px;
}

/* Classes d'état */
.est-actif {
    background-color: #28a745;
}

.est-desactive {
    opacity: 0.5;
}

.est-cache {
    display: none;
}

.est-chargement {
    pointer-events: none;
    opacity: 0.6;
}
```

### Exemple complet avec personnages

```css
/* Conteneur de liste */
.liste-personnages {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    padding: 0;
    list-style: none;
}

/* Carte personnage */
.carte-personnage {
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    padding: 20px;
    background: white;
    transition: all 0.3s ease;
}

.carte-personnage:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

/* Éléments de la carte */
.carte-personnage__image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 15px;
}

.carte-personnage__nom {
    font-size: 1.5rem;
    color: #2c3e50;
    margin: 10px 0;
    font-weight: bold;
}

.carte-personnage__niveau {
    color: #7f8c8d;
    font-size: 1rem;
    margin: 5px 0;
}

.carte-personnage__classe {
    display: inline-block;
    padding: 5px 10px;
    background-color: #3498db;
    color: white;
    border-radius: 4px;
    font-size: 0.875rem;
}

/* Modificateurs de classe */
.carte-personnage__classe--guerrier {
    background-color: #e74c3c;
}

.carte-personnage__classe--mage {
    background-color: #9b59b6;
}

.carte-personnage__classe--archer {
    background-color: #2ecc71;
}

/* Barre de vie */
.barre-vie {
    width: 100%;
    height: 20px;
    background-color: #ecf0f1;
    border-radius: 10px;
    overflow: hidden;
    margin: 10px 0;
}

.barre-vie__remplissage {
    height: 100%;
    background: linear-gradient(90deg, #2ecc71, #27ae60);
    transition: width 0.3s ease;
}

.barre-vie__remplissage--faible {
    background: linear-gradient(90deg, #e74c3c, #c0392b);
}

.barre-vie__remplissage--moyen {
    background: linear-gradient(90deg, #f39c12, #e67e22);
}

/* Boutons d'action */
.bouton-action {
    display: inline-block;
    padding: 8px 16px;
    margin: 5px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
}

.bouton-action--voir {
    background-color: #3498db;
    color: white;
}

.bouton-action--voir:hover {
    background-color: #2980b9;
}

.bouton-action--modifier {
    background-color: #f39c12;
    color: white;
}

.bouton-action--supprimer {
    background-color: #e74c3c;
    color: white;
}
```

---

## 6️⃣ Images et Assets

### Règles de nommage
- **Convention** : `snake_case` (minuscules avec underscores)
- **Restrictions** :
    - Pas d'espaces
    - Pas d'accents
    - Pas de majuscules
    - Pas de caractères spéciaux
- **Style** : Descriptif, organisé par catégorie

### Structure recommandée

```
public/assets/
├── images/
│   ├── personnage/
│   │   ├── alice.png
│   │   ├── bob_guerrier.png
│   │   ├── clara_mage.png
│   │   └── portrait_default.png
│   │
│   ├── icone/
│   │   ├── coeur_rouge.svg
│   │   ├── etoile_or.svg
│   │   ├── fleche_droite.svg
│   │   ├── bouclier_defense.svg
│   │   └── epee_attaque.svg
│   │
│   ├── equipement/
│   │   ├── epee_legendaire.png
│   │   ├── bouclier_acier.png
│   │   ├── armure_chevalier.png
│   │   ├── potion_vie.png
│   │   └── parchemin_sort.png
│   │
│   ├── background/
│   │   ├── foret_sombre.jpg
│   │   ├── chateau_medieval.jpg
│   │   ├── donjon_niveau_1.jpg
│   │   └── village_depart.jpg
│   │
│   └── interface/
│       ├── bouton_jouer.png
│       ├── bouton_quitter.png
│       ├── logo_jeu.svg
│       └── banniere_accueil.jpg
│
├── css/
│   ├── main.css
│   ├── personnage.css
│   └── combat.css
│
└── js/
    ├── main.js
    ├── personnage.js
    └── combat.js
```

### Exemples de noms valides

✅ **Correct**
```
# Images de personnages
alice.png
bob_guerrier.png
clara_mage_niveau_10.png
portrait_defaut.png

# Icônes
coeur_rouge.svg
etoile_or.svg
fleche_droite.svg
icone_parametres.svg

# Équipement
epee_acier.png
bouclier_bois.png
armure_cuir.png
casque_fer.png
potion_mana_grande.png

# Backgrounds
foret_enchantee.jpg
montagne_enneigee.jpg
desert_aride.jpg
grotte_cristal.jpg

# Interface
logo_entreprise.svg
banniere_promotion_ete.jpg
fond_menu_principal.png
separateur_horizontal.svg

# Documents
guide_utilisateur.pdf
manuel_installation.pdf
fiche_personnage_vierge.pdf
```

❌ **Incorrect**
```
# Majuscules
Alice.png                    // ❌
BobGuerrier.png             // ❌
EPEE.png                    // ❌

# Espaces
bob guerrier.png            // ❌
coeur rouge.svg             // ❌
épée acier.png              // ❌

# Accents
forêt_enchantée.jpg         // ❌
château_médiéval.jpg        // ❌
résultat_final.png          // ❌

# Tirets (kebab-case)
bob-guerrier.png            // ❌
coeur-rouge.svg             // ❌

# CamelCase
bobGuerrier.png             // ❌
coeurRouge.svg              // ❌

# Noms non descriptifs
img1.png                    // ❌
photo.jpg                   // ❌
image_finale.png            // ❌
```

### Utilisation dans le code

```php
<!-- Dans une vue PHP -->
<img 
    src="<?= base_url('assets/images/personnage/alice.png') ?>" 
    alt="Portrait d'Alice"
    class="image-personnage"
>

<img 
    src="<?= base_url('assets/images/icone/coeur_rouge.svg') ?>" 
    alt="Points de vie"
    class="icone-vie"
>

<!-- Image dynamique -->
<?php foreach ($listePersonnages as $personnage): ?>
    <img 
        src="<?= base_url('assets/images/personnage/' . $personnage->image_fichier) ?>" 
        alt="<?= esc($personnage->nom_complet) ?>"
        class="carte-personnage__image"
    >
<?php endforeach; ?>
```

```css
/* Dans un fichier CSS */
.banniere-accueil {
    background-image: url('../images/background/chateau_medieval.jpg');
    background-size: cover;
}

.bouton-principal::before {
    content: '';
    background-image: url('../images/icone/etoile_or.svg');
    width: 20px;
    height: 20px;
}
```

---

## 7️⃣ Exemple complet d'application

### Structure du projet
```
app/
├── Controllers/
│   └── PersonnageController.php
├── Models/
│   └── PersonnageModel.php
├── Entities/
│   └── Personnage.php
├── Libraries/
│   └── GestionnaireScore.php
└── Views

# 🗄️ Conventions de nommage SQL - MySQL

## Guide des bonnes pratiques pour la conception de bases de données

---

## 1️⃣ Base de données

### Règles de nommage
- **Casse** : `snake_case` (minuscules avec underscores)
- **Caractères** : Alphanumériques uniquement, pas d'espaces
- **Restrictions** : Pas d'accents, pas de majuscules
- **Sémantique** : Nom significatif représentant le domaine métier

### Exemples
✅ **Correct**
```sql
CREATE DATABASE jeu_rpg;
CREATE DATABASE gestion_stock;
CREATE DATABASE systeme_reservation;
```

❌ **Incorrect**
```sql
CREATE DATABASE JeuRPG;        -- Majuscules
CREATE DATABASE gestion-stock; -- Tirets
CREATE DATABASE système_résa;  -- Accents
```

---

## 2️⃣ Tables

### Règles de nommage
- **Casse** : `snake_case`
- **Nombre** : Singulier (représente une entité)
- **Type** : Nom commun significatif
- **Restrictions** : Pas d'accents, pas de majuscules

### Exemples
✅ **Correct**
```sql
CREATE TABLE utilisateur (...);
CREATE TABLE mode_emploi (...);
CREATE TABLE commande (...);
CREATE TABLE article_blog (...);
```

❌ **Incorrect**
```sql
CREATE TABLE utilisateurs;  -- Pluriel
CREATE TABLE Utilisateur;   -- Majuscule
CREATE TABLE ModeEmploi;    -- CamelCase
```

---

## 3️⃣ Tables de liaison

### Règles de nommage
- **Casse** : `snake_case`
- **Type** : Verbe à l'infinitif représentant la relation
- **Objectif** : Clarifier la nature de la relation entre entités

### Exemples
✅ **Correct**
```sql
CREATE TABLE proposer_vpn (...);
CREATE TABLE attribuer_role (...);
CREATE TABLE commander_produit (...);
CREATE TABLE inscrire_cours (...);
```

❌ **Incorrect**
```sql
CREATE TABLE vpn_proposition;    -- Nom au lieu de verbe
CREATE TABLE utilisateur_role;   -- Pas de verbe
CREATE TABLE commandes_produits; -- Pluriel
```

---

## 4️⃣ Champs (colonnes)

### Règles de nommage
- **Casse** : `snake_case`
- **Style** : Concis mais significatif
- **Type** : Nom commun descriptif
- **Restrictions** :
    - Pas d'accents
    - Pas de majuscules
    - Pas d'abréviations obscures

### Exemples
✅ **Correct**
```sql
CREATE TABLE utilisateur (
    id INT PRIMARY KEY,
    nom_etudiant VARCHAR(100),
    prenom VARCHAR(100),
    date_naissance DATE,
    adresse_email VARCHAR(255),
    numero_telephone VARCHAR(20),
    date_inscription DATETIME
);
```

❌ **Incorrect**
```sql
CREATE TABLE utilisateur (
    ID INT,                    -- Majuscules
    NomEtudiant VARCHAR(100),  -- CamelCase
    prénom VARCHAR(100),       -- Accent
    dt_naiss DATE,             -- Abréviation
    mail VARCHAR(255)          -- Trop concis/ambigu
);
```

---

## 5️⃣ Clés primaires

### Règles de nommage
- **Casse** : `snake_case`
- **Style** : Significatif et représentatif de l'entité
- **Options courantes** :
    - `id` (pour les tables simples)
    - `[nom_table]_id` (plus explicite)
    - Identifiant métier (ex: `reference_produit`)

### Exemples
✅ **Correct**
```sql
CREATE TABLE utilisateur (
    id INT PRIMARY KEY AUTO_INCREMENT
);

CREATE TABLE produit (
    reference_produit VARCHAR(50) PRIMARY KEY
);

CREATE TABLE commande (
    numero_commande INT PRIMARY KEY AUTO_INCREMENT
);
```

❌ **Incorrect**
```sql
CREATE TABLE utilisateur (
    UtilisateurID INT PRIMARY KEY  -- CamelCase + majuscules
);

CREATE TABLE produit (
    ref_prod VARCHAR(50) PRIMARY KEY  -- Abréviation
);
```

---

## 6️⃣ Clés étrangères

### Règles de nommage
- **Casse** : `snake_case`
- **Format** : `[nom_table_référencée]_[nom_clé_primaire]`
- **Cohérence** : Le nom doit refléter clairement la relation

### Exemples
✅ **Correct**
```sql
CREATE TABLE commande (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT,
    date_commande DATETIME,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id)
);

CREATE TABLE detail_commande (
    id INT PRIMARY KEY AUTO_INCREMENT,
    commande_numero INT,
    produit_reference VARCHAR(50),
    FOREIGN KEY (commande_numero) REFERENCES commande(numero_commande),
    FOREIGN KEY (produit_reference) REFERENCES produit(reference_produit)
);
```

❌ **Incorrect**
```sql
CREATE TABLE commande (
    id INT PRIMARY KEY,
    id_utilisateur INT,        -- Ordre inversé
    fk_user INT,               -- Abréviation + anglais
    UtilisateurID INT          -- CamelCase
);
```

---

## 📋 Exemple complet

```sql
-- Création de la base de données
CREATE DATABASE gestion_bibliotheque;
USE gestion_bibliotheque;

-- Table principale
CREATE TABLE auteur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100),
    date_naissance DATE,
    nationalite VARCHAR(50)
);

CREATE TABLE livre (
    isbn VARCHAR(20) PRIMARY KEY,
    titre VARCHAR(200) NOT NULL,
    date_publication DATE,
    nombre_pages INT,
    auteur_id INT,
    FOREIGN KEY (auteur_id) REFERENCES auteur(id)
);

CREATE TABLE membre (
    numero_membre INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    adresse_email VARCHAR(255) UNIQUE,
    date_inscription DATE DEFAULT CURRENT_DATE
);

-- Table de liaison
CREATE TABLE emprunter_livre (
    id INT PRIMARY KEY AUTO_INCREMENT,
    membre_numero INT,
    livre_isbn VARCHAR(20),
    date_emprunt DATE NOT NULL,
    date_retour_prevue DATE NOT NULL,
    date_retour_effective DATE,
    FOREIGN KEY (membre_numero) REFERENCES membre(numero_membre),
    FOREIGN KEY (livre_isbn) REFERENCES livre(isbn)
);
```

---



*Document créé le 29 septembre 2025 par Dorian ADAM*