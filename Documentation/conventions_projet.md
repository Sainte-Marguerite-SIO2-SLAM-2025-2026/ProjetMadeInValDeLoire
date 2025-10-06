# 📘 Guide des Conventions de Nommage - CodeIgniter 4

*Guide complet pour un code professionnel et maintenable*

---

## 📑 Sommaire

### Partie 1 : Projet CodeIgniter 4

1. [Langue et Lisibilité](#1-langue-et-lisibilité)
2. [Structure des Fichiers](#2-structure-des-fichiers)
3. [Classes et Méthodes](#3-classes-et-méthodes)
4. [Variables et Boucles](#4-variables-et-boucles)
5. [Commentaires](#5-commentaires)
6. [CSS et Assets](#6-css-et-assets)

### Partie 2 : Base de Donnees
7. [Base de données](#7-base-de-données)
8.  [Tables](#8-tables)
9. [Tables de liaisons](#9-tables-de-liaison)
10. [Champs](#10-champs-)
11. [Clés primaires](#11-clés-primaires)
12. [Clés étrangères](#12-clés-étrangères)
13. [Intégration CodeIgniter](#13-intégration-codeigniter)

---

# 🎯 PARTIE 1 : PROJET CODEIGNITER 4

## 1. Langue et Lisibilité

### Règles fondamentales
- **Langue** : Tous les noms doivent être en **français**
- **Clarté** : Les noms doivent être **explicites** et **descriptifs**
- **Restrictions** : Pas d'abréviations obscures ou ambiguës

### Exemples

✅ **Correct**
```php
$nomUtilisateur = "Alice";
$listeCommandes = [];
$estConnecte = true;
$montantTotal = 1234.56;
```

❌ **Incorrect**
```php
$nu = "Alice";              // Abréviation incompréhensible
$lst = [];                  // Trop court
$conn = true;               // Ambigu
$mt = 1234.56;              // Pas explicite
```

---

## 2. Structure des Fichiers

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
│   ├── CommandeController.php       # class CommandeController
│   └── UtilisateurController.php    # class UtilisateurController
├── Models/
│   ├── CommandeModel.php            # class CommandeModel
│   └── UtilisateurModel.php         # class UtilisateurModel
├── Entities/
│   ├── Commande.php                 # class Commande
│   └── Utilisateur.php              # class Utilisateur
└── Views/
    └── commande/
        ├── liste.php
        └── detail.php
```

### Exemples de correspondance fichier/classe

✅ **Correct (PSR-4)**
```php
// Fichier: app/Controllers/CommandeController.php
namespace App\Controllers;

class CommandeController extends BaseController
{
    // ...
}

// Fichier: app/Models/CommandeModel.php
namespace App\Models;

class CommandeModel extends Model
{
    // ...
}
```

❌ **Incorrect**
```php
// ❌ Fichier: commande_controller.php (snake_case)
class CommandeController { }

// ❌ Fichier: Commande.php
class CommandeController { }  // Nom ne correspond pas

// ❌ Fichier: CommandeCtrl.php
class CommandeController { }  // Abréviation dans le fichier
```

---

## 3. Classes et Méthodes

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

### Exemple de Controller

```php
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\CommandeModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Contrôleur de gestion des commandes
 */
class CommandeController extends BaseController
{
    // Propriétés avec types
    protected CommandeModel $commandeModel;
    private int $montantMinimum = 10;
    
    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->commandeModel = model(CommandeModel::class);
    }
    
    /**
     * Affiche la liste des commandes
     */
    public function afficherListe(): string
    {
        $listeCommandes = $this->commandeModel
            ->orderBy('date_creation', 'DESC')
            ->findAll();
        
        return view('commande/liste', [
            'commandes' => $listeCommandes
        ]);
    }
    
    /**
     * Affiche le détail d'une commande
     */
    public function afficherDetail(int $idCommande): ResponseInterface|string
    {
        $commande = $this->commandeModel->find($idCommande);
        
        if ($commande === null) {
            return redirect()
                ->back()
                ->with('erreur', 'Commande introuvable');
        }
        
        return view('commande/detail', compact('commande'));
    }
    
    /**
     * Calcule le montant TTC
     */
    private function calculerMontantTTC(float $montantHT): float
    {
        return $montantHT * 1.20;
    }
}
```

### Exemple de Model

```php
<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class CommandeModel extends Model
{
    // Configuration du modèle
    protected $table = 'commande';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField = 'date_creation';
    protected $updatedField = 'date_modification';
    
    // Champs autorisés
    protected $allowedFields = [
        'utilisateur_id',
        'numero_commande',
        'montant_total',
        'statut'
    ];
    
    // Validation
    protected $validationRules = [
        'numero_commande' => 'required|is_unique[commande.numero_commande]',
        'montant_total' => 'required|decimal'
    ];
    
    /**
     * Récupère les commandes d'un utilisateur
     */
    public function obtenirParUtilisateur(int $utilisateurId): array
    {
        return $this->where('utilisateur_id', $utilisateurId)
            ->orderBy('date_creation', 'DESC')
            ->findAll();
    }
    
    /**
     * Calcule le total du mois
     */
    public function calculerTotalMois(): float
    {
        $resultat = $this->selectSum('montant_total', 'total')
            ->where('MONTH(date_creation)', date('m'))
            ->where('YEAR(date_creation)', date('Y'))
            ->first();
        
        return (float) ($resultat['total'] ?? 0);
    }
}
```

### Exemple d'Entity

```php
<?php

declare(strict_types=1);

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Commande extends Entity
{
    // Attributs par défaut
    protected $attributes = [
        'id' => null,
        'numero_commande' => null,
        'montant_total' => 0,
        'statut' => 'en_attente'
    ];
    
    // Types de données
    protected $casts = [
        'id' => 'integer',
        'utilisateur_id' => 'integer',
        'montant_total' => 'float',
        'date_creation' => 'datetime'
    ];
    
    /**
     * Vérifie si la commande est payée
     */
    public function estPayee(): bool
    {
        return $this->statut === 'payee';
    }
    
    /**
     * Obtient le numéro formaté
     */
    public function obtenirNumeroFormate(): string
    {
        return sprintf('CMD-%06d', $this->id);
    }
    
    /**
     * Calcule le montant TTC
     */
    public function calculerMontantTTC(float $tauxTVA = 0.20): float
    {
        return $this->montant_total * (1 + $tauxTVA);
    }
}
```

---

## 4. Variables et Boucles

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
$montantTotal = 1234.56;

// Variables complexes
$listeCommandes = [];
$donneesFormulaire = [];
$configurationServeur = [];
```

### Boucles foreach - Exemples détaillés

✅ **Correct - Noms explicites**

```php
// Boucle simple sur des commandes
foreach ($listeCommandes as $commande) {
    echo $commande->numero_commande;
    echo $commande->montant_total;
}

// Boucle avec index
foreach ($listeProduits as $index => $produit) {
    echo "Position {$index}: {$produit->nom}";
}

// Boucle sur un tableau associatif
foreach ($parametresUtilisateur as $cle => $valeur) {
    echo "{$cle}: {$valeur}";
}

// Boucles imbriquées - Noms distincts et clairs
foreach ($listeCommandes as $commande) {
    echo $commande->numero_commande;
    
    foreach ($commande->lignes as $ligneCommande) {
        echo "  {$ligneCommande->produit}: {$ligneCommande->quantite}";
    }
}
```

❌ **Incorrect - Noms trop courts ou obscurs**

```php
// Variables d'une seule lettre
foreach ($listeCommandes as $c) {
    echo $c->numero_commande;  // ❌ Qu'est-ce que $c ?
}

// Variables ambiguës
foreach ($listeProduits as $x) {
    echo $x->nom;  // ❌ $x ne veut rien dire
}

// Boucles imbriquées confuses
foreach ($listeCommandes as $c) {
    foreach ($c->lignes as $l) {  // ❌ $c et $l peu clairs
        echo $l->produit;
    }
}
```

### Constantes

```php
// Constantes globales (UPPER_SNAKE_CASE)
define('MONTANT_MINIMUM', 10);
define('DUREE_SESSION', 3600);
define('CHEMIN_UPLOAD', WRITEPATH . 'uploads/');

// Constantes de classe
class Configuration
{
    public const TVA_TAUX_NORMAL = 0.20;
    public const TVA_TAUX_REDUIT = 0.055;
    public const DEVISE_DEFAUT = 'EUR';
    
    private const CLE_API_SECRETE = 'abc123xyz';
}
```

---

## 5. Commentaires

### Commentaires PHPDoc (documentation)

```php
/**
 * Gère les opérations sur les commandes
 * 
 * @package App\Controllers
 * @author Votre Nom
 */
class CommandeController extends BaseController
{
    /**
     * Affiche la liste des commandes avec pagination
     * 
     * @return string Vue HTML de la liste
     */
    public function afficherListe(): string
    {
        // Code...
    }
    
    /**
     * Valide et enregistre une nouvelle commande
     * 
     * @param array $donnees Données de la commande
     * @return bool Succès de l'opération
     * @throws \Exception Si les données sont invalides
     */
    public function enregistrer(array $donnees): bool
    {
        // Code...
    }
}
```

### Commentaires inline (explication du code)

```php
public function traiterCommande(int $idCommande): bool
{
    // Récupération de la commande
    $commande = $this->commandeModel->find($idCommande);
    
    /* 
     * Vérification du stock pour chaque ligne
     * Si le stock est insuffisant, on rejette la commande
     */
    foreach ($commande->lignes as $ligne) {
        if ($ligne->quantite > $ligne->stock_disponible) {
            return false;
        }
    }
    
    // TODO: Ajouter la gestion des promotions
    // FIXME: Corriger le calcul de la TVA pour les produits mixtes
    // NOTE: Le paiement est traité de manière asynchrone
    
    return true;
}
```

### Types de commentaires

```php
// Commentaire simple pour une ligne de code

/* 
 * Commentaire multi-lignes
 * pour expliquer une logique complexe
 */

/**
 * Commentaire PHPDoc pour la documentation
 * 
 * @param int $id Identifiant unique
 * @return bool Résultat de l'opération
 */

// TODO: Fonctionnalité à implémenter plus tard
// FIXME: Bug connu à corriger
// NOTE: Information importante pour les développeurs
// HACK: Solution temporaire en attendant mieux
```

---

## 6. CSS et Assets

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
    border-radius: 4px;
}

.carte-commande {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
}
```

### Méthodologie BEM (Block Element Modifier)

```css
/* Block: composant principal */
.carte-commande {
    border: 1px solid #ddd;
}

/* Element: partie du block */
.carte-commande__numero {
    font-size: 1.5rem;
    font-weight: bold;
}

.carte-commande__montant {
    color: #28a745;
}

/* Modifier: variation du block */
.carte-commande--urgente {
    border-color: #dc3545;
    background-color: #fff5f5;
}

/* États d'interaction */
.bouton-principal:hover {
    background-color: #0056b3;
}

.bouton-principal:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Classes d'état */
.est-actif {
    background-color: #28a745;
}

.est-cache {
    display: none;
}
```

### Règles de nommage des images et assets
- **Convention** : `snake_case` (minuscules avec underscores)
- **Restrictions** :
    - Pas d'espaces
    - Pas d'accents
    - Pas de majuscules
    - Pas de caractères spéciaux

### Structure recommandée

```
public/assets/
├── images/
│   ├── produit/
│   │   ├── chaise_bureau.jpg
│   │   ├── table_bois.jpg
│   │   └── lampe_led.jpg
│   ├── icone/
│   │   ├── panier.svg
│   │   ├── utilisateur.svg
│   │   └── recherche.svg
│   └── logo_entreprise.png
├── css/
│   └── main.css
└── js/
    └── main.js
```

### Exemples de noms valides

✅ **Correct**
```
chaise_bureau.jpg
logo_entreprise.svg
icone_panier.png
banniere_promotion_ete.jpg
```

❌ **Incorrect**
```
ChaiseBureau.jpg           // ❌ CamelCase
chaise-bureau.jpg          // ❌ kebab-case
chaise bureau.jpg          // ❌ Espaces
château_médiéval.jpg       // ❌ Accents
```

### Utilisation dans les vues

```php
<!-- Image statique -->
<img 
    src="<?= base_url('assets/images/produit/chaise_bureau.jpg') ?>" 
    alt="Chaise de bureau"
    class="image-produit"
>

<!-- Image dynamique -->
<?php foreach ($listeProduits as $produit): ?>
    <img 
        src="<?= base_url('assets/images/produit/' . $produit->image_fichier) ?>" 
        alt="<?= esc($produit->nom) ?>"
        class="carte-produit__image"
    >
<?php endforeach; ?>
```

---

# 🗄️ PARTIE 2 : BASE DE DONNÉES

## 7. Base de données
- **Casse** : `snake_case` (minuscules avec underscores)
- **Caractères** : Alphanumériques uniquement, pas d'espaces
- **Restrictions** : Pas d'accents, pas de majuscules

### Exemples

✅ **Correct**
```sql
CREATE DATABASE gestion_boutique;
CREATE DATABASE systeme_reservation;
```

❌ **Incorrect**
```sql
CREATE DATABASE GestionBoutique;    -- Majuscules
CREATE DATABASE gestion-boutique;   -- Tirets
CREATE DATABASE système_résa;       -- Accents
```

## 8. Tables
- **Casse** : `snake_case`
- **Nombre** : **Singulier** 
- **Type** : Nom commun significatif
- **Restictions** : Pas d'accents, pas de majuscules

### Exemples

✅ **Correct**
```sql
CREATE TABLE utilisateur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL
);

CREATE TABLE commande (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_commande VARCHAR(50) UNIQUE NOT NULL,
    montant_total DECIMAL(10,2) NOT NULL
);

CREATE TABLE produit (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(200) NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL
);
```

❌ **Incorrect**
```sql
CREATE TABLE utilisateurs;  -- ❌ Pluriel
CREATE TABLE Utilisateur;   -- ❌ Majuscule
CREATE TABLE ModeEmploi;    -- ❌ CamelCase
```

## 9. Tables de liaison
- **Casse** : `snake_case`
- **Type** : **Verbe à l'infinitif** représentant la relation
- **Objectif** : Clarifier la nature de la relation entre entités

### Exemples

✅ **Correct**
```sql
CREATE TABLE commander_produit (
    id INT PRIMARY KEY AUTO_INCREMENT,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commande(id),
    FOREIGN KEY (produit_id) REFERENCES produit(id)
);

CREATE TABLE attribuer_role (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id),
    FOREIGN KEY (role_id) REFERENCES role(id)
);
```

❌ **Incorrect**
```sql
CREATE TABLE commande_produit;     -- ❌ Pas de verbe
CREATE TABLE utilisateurs_roles;   -- ❌ Pluriel + pas de verbe
```

## 10. Champs 
- **Casse** : `snake_case`
- **Style** : Concis mais significatif
- **Type** : Nom commun descriptif
- **Restictions** : Pas d'accents, pas de majuscules, pas d'abrèviations

### Exemples

✅ **Correct**
```sql
CREATE TABLE utilisateur (
    id INT PRIMARY KEY,
    nom_complet VARCHAR(200),
    adresse_email VARCHAR(255),
    numero_telephone VARCHAR(20),
    date_naissance DATE,
    date_inscription DATETIME,
    est_actif BOOLEAN DEFAULT TRUE
);
```

❌ **Incorrect**
```sql
CREATE TABLE utilisateur (
    ID INT PRIMARY KEY,              -- ❌ Majuscules
    NomComplet VARCHAR(200),         -- ❌ CamelCase
    mail VARCHAR(255),               -- ❌ Nom ambigu
    tel VARCHAR(20),                 -- ❌ Abréviation
    dt_naiss DATE                    -- ❌ Abréviation obscure
);
```

## 11. Clés primaires
- **Casse** : `snake_case`
- **Style** : Significatif et représentatif
- **Options courantes** :
    - `id` (pour les tables simples)
    - `[nom_table]_id` (plus explicite dans certains cas)
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

## 12. Clés étrangères
- **Casse** : `snake_case`
- **Format** : `[nom_table_référencée]_[nom_clé_primaire]`
- **Cohérence** : Le nom doit refléter clairement la relation

### Exemples

✅ **Correct**
```sql
CREATE TABLE commande (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    date_commande DATETIME,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id)
);

CREATE TABLE commander_produit (
    id INT PRIMARY KEY AUTO_INCREMENT,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commande(id),
    FOREIGN KEY (produit_id) REFERENCES produit(id)
);
```

❌ **Incorrect**
```sql
CREATE TABLE commande (
    id INT PRIMARY KEY,
    id_utilisateur INT,        -- ❌ Ordre inversé
    fk_user INT,               -- ❌ Abréviation
    UtilisateurID INT          -- ❌ CamelCase
);
```

---

## 13. Intégration CodeIgniter

### Query Builder

```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class CommandeModel extends Model
{
    protected $table = 'commande';
    protected $primaryKey = 'id';
    
    /**
     * Récupère les commandes avec leurs utilisateurs
     */
    public function obtenirAvecUtilisateur(): array
    {
        return $this->select('commande.*, utilisateur.nom, utilisateur.prenom')
            ->join('utilisateur', 'utilisateur.id = commande.utilisateur_id')
            ->orderBy('commande.date_creation', 'DESC')
            ->findAll();
    }
    
    /**
     * Obtient les statistiques du mois
     */
    public function obtenirStatistiquesMois(): array
    {
        return $this->select('
                COUNT(*) as nombre_commandes,
                SUM(montant_total) as total_ventes,
                AVG(montant_total) as panier_moyen
            ')
            ->where('MONTH(date_creation)', date('m'))
            ->where('YEAR(date_creation)', date('Y'))
            ->first();
    }
}
```



---

## 📚 Tableau Récapitulatif

| Élément | Convention | Exemple |
|---------|-----------|---------|
| **Fichier de classe** | PascalCase | `CommandeController.php` |
| **Classe** | PascalCase | `class CommandeController` |
| **Méthode** | camelCase | `afficherListe()` |
| **Propriété** | camelCase | `$commandeModel` |
| **Variable** | camelCase | `$nomUtilisateur` |
| **Constante** | UPPER_SNAKE_CASE | `MONTANT_MINIMUM` |
| **Dossier** | snake_case | `vue_personnalisee/` |
| **Base de données** | snake_case | `gestion_boutique` |
| **Table** | snake_case (singulier) | `commande` |
| **Table de liaison** | snake_case (verbe) | `commander_produit` |
| **Champ SQL** | snake_case | `numero_commande` |
| **Clé étrangère** | snake_case + _id | `utilisateur_id` |
| **Classe CSS** | kebab-case | `carte-commande` |
| **Fichier image** | snake_case | `logo_entreprise.png` |

---

*Document créé le 29 septembre 2025 - CodeIgniter 4*