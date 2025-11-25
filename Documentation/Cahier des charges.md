# 🧾 Cahier des charges  
## Made_in_Val_de_Loire

---

## 📑 Sommaire
1. [Présentation du projet](#1-présentation-du-projet)  
   - [1.1 Contexte](#11-contexte)  
   - [1.2 Objectifs](#12-objectifs)  
   - [1.3 Participants](#13-participants)  
2. [Public cible](#2-public-cible)  
   - [2.1 Description des utilisateurs](#21-description-des-utilisateurs)  
   - [2.2 Cas d’utilisation principaux](#22-cas-dutilisation-principaux)  
3. [Spécifications fonctionnelles](#3-spécifications-fonctionnelles)  
   - [3.1 Fonctionnalités principales](#31-fonctionnalités-principales)  
   - [3.2 Parcours utilisateur](#32-parcours-utilisateur)  
4. [Spécifications techniques](#4-spécifications-techniques)  
   - [4.1 Technologies utilisées](#41-technologies-utilisées)  
   - [4.2 Contraintes techniques](#42-contraintes-techniques)  
5. [Charte graphique & identité visuelle](#5-charte-graphique--identité-visuelle)  
   - [5.1 Logo et couleurs](#51-logo-et-couleurs)  
   - [5.2 Typographie](#52-typographie)  
   - [5.3 Ton et style visuel](#53-ton-et-style-visuel)  
6. [Critères de validation](#6-critères-de-validation)  
   - [6.1 Tests et validation](#61-tests-et-validation)  
   - [6.2 Livraison finale](#62-livraison-finale)  
7. [Annexes](#7-annexes)

---

## 1. Présentation du projet

### 1.1 Contexte
Le projet **Made_in_Val_de_Loire** s’inscrit dans une démarche de **sensibilisation à la cybersécurité** auprès des **professionnels** de la région Val de Loire.  
Face à la montée croissante des **attaques informatiques** (phishing, ransomware, ingénierie sociale, etc.), il devient essentiel d’offrir des outils ludiques et pédagogiques pour mieux comprendre les risques et adopter les bons réflexes.

Le site web proposera une expérience originale et interactive sous la forme d’un **parcours d’énigmes**.  
Chaque **salle** représentera un **type d’attaque** spécifique, dans laquelle l’utilisateur devra résoudre une ou plusieurs énigmes pour progresser.  
L’objectif est de **rendre l’apprentissage de la cybersécurité accessible, engageant et concret**, en combinant **pédagogie** et **gamification**.

Ce projet s’adresse principalement aux **entreprises, institutions et professionnels** souhaitant **former leurs collaborateurs** de manière innovante et participative.  
À travers cette approche ludique, **Made_in_Val_de_Loire** vise à renforcer la **culture de la cybersécurité** dans le tissu économique local tout en valorisant l’identité numérique du territoire.

### 1.2 Objectifs
- **Objectif principal :** Sensibiliser les professionnels à la cybersécurité de manière ludique et interactive, grâce à un parcours d’énigmes inspiré des principales attaques informatiques.  
- **Objectifs secondaires :**  
  - Promouvoir la culture numérique et la prévention des risques dans la région Val de Loire.  
  - Offrir une ressource pédagogique accessible et intuitive aux entreprises locales.  
  - Créer un outil évolutif pouvant intégrer de nouvelles attaques ou mises à jour de contenu.  
  - Encourager la collaboration entre étudiants en design et en développement autour d’un projet concret.

### 1.3 Participants

| Nom | Prénom | Classe |
|-----|--------|--------|
| ADAM | Dorian | 2SIO |
| BRIANNE | Louna | 2DNMade |
| CHARY | Alice | 2DNMade |
| COUTURE | Laura | 2DNMade |
| DAUVERGNE | Mathys | 2SIO |
| DAVID | Lisa | 2DNMade |
| DENEUX | Morgane | 2DNMade |
| DESNOYERS | Paola | 2DNMade |
| FREIDA | Clara | 2DNMade |
| GOUSSET | Kérrian | 2SIO |
| GUTTIN | Héloïse | 2DNMade |
| JOUANNEAU | Clovis | 2SIO |
| LAGARDE | Clara | 2DNMade |
| LAHAYE | Fleur | 2DNMade |
| LE FLOCH | Gaidig | 2DNMade |
| MENINI | Enzo | 2SIO |
| PANTAIS | Yasmine | 2DNMade |
| PINTO | Benjamin | 2SIO |
| REDON | Léo | 2DNMade |
| SOULICE | Lisa-Maria | 2DNMade |

---

## 2. Public cible

### 2.1 Description des utilisateurs
- **Type d’utilisateurs :** Professionnels, entreprises, institutions locales.  
- **Besoins spécifiques :** Comprendre les différents types d’attaques informatiques, apprendre à les reconnaître et à s’en protéger à travers un contenu accessible, ludique et engageant.  

### 2.2 Cas d’utilisation principaux 
1. L'utilisateur choisit un mode de jeu : **Mode Parcours** ou **Mode Libre**.  
2. Il résout les énigmes liées aux différentes attaques informatiques.  
3. Il consulte ses résultats, conseils et bonnes pratiques.  
4. Il peut revenir ultérieurement pour découvrir d’autres salles ou améliorer son score.  

---

## 3. Spécifications fonctionnelles

### 3.1 Fonctionnalités principales
| Fonctionnalité | Description | Priorité |
|----------------|--------------|-----------|
| Page d’accueil | Présente le projet, les objectifs et les modes de jeu | Haute |
| Mode Parcours | Permet de suivre un ordre d’énigmes prédéfini | Haute |
| Mode Libre | Permet de choisir directement une salle spécifique | Haute |
| Salles d’énigmes | Contiennent les défis et explications liées à chaque type d’attaque | Haute |

### 3.2 Parcours utilisateur
L’utilisateur dispose de **deux modes de navigation** principaux au sein du site :

1. **Mode Parcours**  
   Dans ce mode, l’utilisateur suit un **chemin progressif**.  
   Il doit résoudre les énigmes **salle après salle**, dans un ordre défini.  
   Chaque salle correspond à un **type d’attaque informatique** (ex : phishing, ransomware, etc.).  
   Ce mode est conçu pour offrir un **apprentissage structuré et complet**, guidant pas à pas l’utilisateur dans la découverte des différentes menaces.

2. **Mode Libre**  
   Ce mode permet à l’utilisateur de **choisir librement la salle** qu’il souhaite explorer.  
   Il peut ainsi se concentrer sur les **attaques qui l’intéressent le plus** ou qu’il souhaite approfondir.  
   Ce mode favorise une **autonomie totale** et s’adresse aux utilisateurs souhaitant une expérience personnalisée ou ciblée.

À la fin de chaque salle, l’utilisateur peut consulter des **informations complémentaires**, renforçant ainsi la dimension **ludique et pédagogique** du projet.

---

## 4. Spécifications techniques

### 4.1 Technologies utilisées
- **Langages :** HTML5, CSS3, JavaScript, PHP  
- **Frameworks :** CodeIgniter 4  
- **Base de données :** MySQL  
- **Hébergement :** Serveur web (Apache / Nginx)  
- **Compatibilités :** PC (navigateur web récent : Chrome, Firefox, Edge)

### 4.2 Contraintes techniques
- **Normes à respecter :** PSR-12 (conventions de code PHP), respect des standards HTML5/CSS3   
- **Performances attendues :**  
  - Temps de chargement inférieur à 3 secondes par page.  
  - Expérience fluide et responsive sur les écrans PC.  

---

## 5. Charte graphique & identité visuelle

### 5.1 Logo et couleurs
- **Logo officiel :** Représentant la région Val de Loire et la cybersécurité.  
- **Mascotte :** Une mascotte principal et selon le thème de la salle un déclinaison de celle-ci

### 5.2 Typographie
- **Police principale :** *Dépends du thème de chaque salle* 
- **Police secondaire :** *Dépends du thème de chaque salle*   

### 5.3 Ton et style visuel
- **Style :** *Dépends du thème de chaque salle*
- **Images / icônes :** Illustrations vectorielles et icônes libres de droit.
- **Format :** webp

---

## 6. Critères de validation

### 6.1 Tests et validation
- Vérification de la conformité aux besoins du cahier des charges.  
- Tests unitaires sur les fonctionnalités principales.  
- Validation du design et de la navigation par un panel d’utilisateurs.  

### 6.2 Livraison finale
- **Date de livraison prévue :** 27/11/2025  
- **Livrables attendus :**  
  - Site web fonctionnel  
  - Base de données opérationnelle  
  - Documentation technique et utilisateur  

---

## 7. Annexes
- Documents complémentaires  
- Inspirations / références : [cybermalveillance.gouv.fr](https://www.cybermalveillance.gouv.fr)  
- Liens utiles : [CodeIgniter 4 Documentation](https://codeigniter.com/user_guide/)
