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

## ✅ Points clés à retenir

1. **Cohérence avant tout** : Appliquez les mêmes règles dans toute votre base
2. **Clarté** : Les noms doivent être compréhensibles par tous les développeurs
3. **snake_case partout** : Jamais de CamelCase ni de majuscules
4. **Éviter les abréviations** : Privilégiez la lisibilité
5. **Singulier pour les tables** : Une table représente un type d'entité
6. **Verbes pour les liaisons** : Clarifiez la nature des relations
7. **Noms explicites pour les FK** : Format `table_référencée_clé_primaire`

---

## 📚 Références

- [Documentation MySQL - Identificateurs](https://dev.mysql.com/doc/refman/8.0/en/identifiers.html)
- [ISO/IEC 11179 - Naming conventions](https://www.iso.org/standard/50340.html)

---

*Document créé le 29 septembre 2025*