# Parc d'activités — MVC PHP orienté objet

Projet réalisé dans le cadre du cours **PHP orienté objet** (IIM, A2 CDI).
Une petite application de gestion d'un parc d'activités : les visiteurs consultent les activités, les utilisateurs connectés réservent des places, et un administrateur gère le catalogue.

Le tout est écrit **en PHP pur, sans framework** : le routeur, l'autoload, la couche d'accès aux données et le rendu des vues sont faits maison.

## Fonctionnalités

- Liste et détail des activités (nom, type, description, date, durée, places disponibles)
- Inscription, connexion et déconnexion des utilisateurs (sessions PHP, mots de passe hashés)
- Réservation d'une activité et annulation par l'utilisateur
- Espace admin : création, modification, suppression d'activités et liste de toutes les réservations
- Protection des routes admin par rôle en session

## Architecture

```
MVC/
├── index.php              # Point d'entrée : déclare les routes et dispatch
├── .htaccess              # Réécriture d'URL vers index.php
├── css/style.css
└── app/
    ├── utils/
    │   ├── Autoload.php   # Autoload des classes
    │   ├── Router.php     # Routeur GET/POST maison
    │   ├── Bdd.php        # Connexion PDO (classe abstraite)
    │   └── Render.php     # Trait de rendu des vues dans le layout
    ├── entities/          # Objets métier : Users, Activities, Reservations, Type_activite
    ├── models/            # Requêtes SQL via PDO
    ├── controllers/       # ActivityController, ReservationController, UserController
    └── views/             # Templates PHP (layout + vues par ressource)
```

## Routes principales

| Méthode | Route | Rôle |
|---------|-------|------|
| GET | `/` ou `/activity` | Liste des activités |
| GET | `/activity/show?id=` | Détail d'une activité |
| GET/POST | `/activity/create`, `/activity/store` | Création (admin) |
| GET/POST | `/activity/edit`, `/activity/update` | Modification (admin) |
| GET | `/reservation` | Mes réservations |
| GET/POST | `/reservation/create`, `/reservation/store` | Réserver |
| GET | `/reservation/list` | Toutes les réservations (admin) |
| GET/POST | `/user/login`, `/user/register`, `/user/logout` | Authentification |

## Lancer le projet

Prérequis : PHP 8+, MySQL ou MariaDB, Apache avec `mod_rewrite` (MAMP fonctionne très bien).

1. Créer une base `parc_activite` et importer le schéma (`parc_activite.sql`, disponible dans le repo [MVC](https://github.com/carls-xyz/MVC)). Tables : `users`, `activities`, `type_activite`, `reservations`.
2. Adapter la connexion dans `MVC/app/utils/Bdd.php` (par défaut : `127.0.0.1:8889`, utilisateur `root`, mot de passe `root`, soit la config MAMP).
3. Placer le dossier `MVC` dans le `htdocs` d'Apache et ouvrir `http://localhost:8888/MVC/`.

## Historique

Ce repo est la version finale. Les étapes précédentes sont conservées dans [projetMVC](https://github.com/carls-xyz/projetMVC) et [MVCproject](https://github.com/carls-xyz/MVCproject).
