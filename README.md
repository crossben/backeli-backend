# Backend — Consortium Jeunesse Sénégal

API REST du système de gestion des membres du Consortium Jeunesse Sénégal (CJS), construite avec **Laravel 11** et sécurisée par **Laravel Sanctum**.

---

## 🛠 Technologies utilisées

| Technologie | Rôle |
|---|---|
| [Laravel 11](https://laravel.com/) | Framework PHP |
| [Laravel Sanctum](https://laravel.com/docs/sanctum) | Authentification API par tokens |
| [MySQL / PostgreSQL](https://www.postgresql.org/) | Base de données relationnelle |
| [PHP 8.2+](https://www.php.net/) | Langage de programmation |

---

## 📂 Structure du projet

```
backend/
├── app/
│   ├── Http/Controllers/Api/
│   │   ├── AuthController.php      # Inscription, connexion, déconnexion
│   │   ├── MemberController.php    # CRUD des membres
│   │   └── StatsController.php     # Statistiques du tableau de bord
│   └── Models/
│       └── User.php                # Modèle utilisateur (rôle : admin | member)
├── database/
│   ├── migrations/                 # Schéma de la base de données
│   └── seeders/
│       ├── AdminUserSeeder.php     # Crée le compte administrateur
│       └── MembreSeeder.php        # Génère 20 membres de test
├── routes/
│   └── api.php                     # Définition des routes API
├── config/
│   ├── cors.php                    # Configuration CORS
│   └── sanctum.php                 # Configuration Sanctum
└── .env                            # Variables d'environnement
```

---

## ⚙️ Prérequis

- PHP 8.2+
- [Composer](https://getcomposer.org/)
- MySQL ou PostgreSQL
- Extension `pdo_pgsql` ou `pdo_mysql` activée dans PHP

---

## 🚀 Installation et démarrage

```bash
# 1. Installer les dépendances PHP
composer install

# 2. Copier le fichier d'environnement
cp .env.example .env

# 3. Générer la clé de l'application
php artisan key:generate

# 4. Configurer la base de données dans .env
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=bakeli
# DB_USERNAME=postgres
# DB_PASSWORD=secret

# 5. Lancer les migrations et les seeders
php artisan migrate:fresh --seed

# 6. Démarrer le serveur de développement
php artisan serve
```

L'API sera accessible sur : **<http://127.0.0.1:8000>**

---

## 🔐 Authentification

L'authentification est basée sur des **tokens Bearer** générés par Laravel Sanctum.

Le token doit être envoyé dans le header de chaque requête protégée :

```
Authorization: Bearer {token}
Accept: application/json
```

### Comptes par défaut (après `--seed`)

| Rôle | Email | Mot de passe |
|---|---|---|
| Administrateur | `admin@bakeli.sn` | `password` |

---

## 📡 Endpoints de l'API

### Authentification (public)

| Méthode | Route | Description |
|---|---|---|
| `POST` | `/api/register` | Inscription d'un nouvel utilisateur |
| `POST` | `/api/login` | Connexion et obtention du token |

### Routes protégées (`Authorization: Bearer {token}`)

| Méthode | Route | Description |
|---|---|---|
| `POST` | `/api/logout` | Déconnexion (révocation du token) |
| `GET` | `/api/user` | Informations de l'utilisateur connecté |
| `GET` | `/api/stats` | Statistiques globales (membres, villes) |
| `GET` | `/api/members` | Liste paginée des membres (search, statut) |
| `POST` | `/api/members` | Créer un membre |
| `GET` | `/api/members/{id}` | Détails d'un membre |
| `PUT` | `/api/members/{id}` | Modifier un membre |
| `DELETE` | `/api/members/{id}` | Supprimer un membre |

### Paramètres de filtrage pour `GET /api/members`

| Paramètre | Type | Description |
|---|---|---|
| `search` | `string` | Recherche par nom, email, ville ou compétences |
| `statut` | `0` ou `1` | Filtrer par statut actif/inactif |
| `page` | `integer` | Numéro de page (pagination : 10 par page) |

---

## 🌐 Configuration CORS

Le CORS est configuré dans `config/cors.php` pour autoriser les requêtes depuis le frontend Vue (port 5173) :

```php
'allowed_origins' => ['http://localhost:5173', 'http://127.0.0.1:5173'],
'supports_credentials' => true,
```

---

## 🔄 Commandes utiles

```bash
# Réinitialiser la base de données avec les seeders
php artisan migrate:fresh --seed

# Vider tous les caches
php artisan optimize:clear

# Recachér la configuration
php artisan config:cache
```
