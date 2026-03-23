
# Analyse et Classement de Contenus

Petit outil en **PHP pur** permettant d'analyser et de classer automatiquement des contenus (articles, événements, projets)  
afin d'identifier ceux qui méritent d'être **mis en avant** sur la page d'accueil d'un site.

## Contexte du test

Objectif :  
Créer un script qui :

- filtre les contenus publiés uniquement  
- calcule un **score d'intérêt** selon plusieurs critères  
- identifie les contenus prioritaires (score ≥ 5)  
- trie les résultats du plus intéressant au moins intéressant  
- affiche un résumé clair avec explication détaillée des scores

Données imparfaites à gérer :  
- status manquant ou "draft"  
- auteur absent (null)  
- tags absents  
- autres champs optionnels

## Technologies utilisées

- **PHP 8.2.12** (ou supérieur)   
- Exécution en ligne de commande

## Structure du projet

```
.
├── data.php          # Les données d'exemple (tableau $contents)
├── functions.php     # Fonctions réutilisables (calcul score, comptage par type, etc.)
├── index.php         # Script principal : traitement + affichage
└── README.md         # Ce fichier
```

## Comment exécuter le script

```bash
# Se placer dans le dossier du projet
cd chemin/vers/votre/projet

# Lancer le script
php index.php
```

Le script affiche dans la console :

1. Résumé du nombre de contenus publiés par type  
2. Liste des contenus "featured" (score ≥ 5) triés par score descendant  
3. Liste des autres contenus publiés  
4. Détail de chaque score avec les raisons qui ont donné ces points

## Fonctionnalités réalisées

- Filtrage strict des contenus au statut `"published"`
- Gestion défensive de toutes les clés manquantes (?? opérateur de coalescence nulle)
- Calcul de score basé sur les 5 critères :

| Critère                        | Points |
|--------------------------------|--------|
| > 200 vues                     | +3     |
| 100 à 200 vues                 | +2     |
| `featured` = true              | +3     |
| tag "javascript" ou "data"     | +2     |
| auteur présent (non null/vide) | +1     |

- Séparation claire : featured (≥ 5) vs autres
- Tri descendant par score
- Affichage lisible avec classement numéroté
- Explications détaillées des raisons pour chaque contenu

LDX – Mars 2026
