# SGS - Système de Gestion Scolaire

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Laravel Version"></a>
<a href="https://php.net"><img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version"></a>
<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License"></a>
</p>

## 📋 Description

SGS (School Management System) est une application web complète de gestion scolaire développée avec le framework Laravel. Ce système permet de gérer efficacement tous les aspects administratifs d'une école : étudiants, parents, classes, niveaux, cycles, inscriptions et années scolaires.

## ✨ Fonctionnalités

### 👨‍🎓 Gestion des Étudiants
- Inscription et gestion des profils étudiants
- Génération automatique de matricules
- Suivi des informations personnelles (nom, prénom, date de naissance, sexe, contact)
- Gestion des statuts (actif, suspendu, abandon)

### 👨‍👩‍👧‍👦 Gestion des Parents
- Gestion des profils parents/tuteurs
- Relations multiples avec les étudiants (père, mère, frère, sœur, tuteur)
- Informations de contact détaillées

### 🏫 Structure Académique
- **Cycles** : Organisation par cycles d'enseignement
- **Niveaux** : Gestion hiérarchisée des niveaux scolaires
- **Classes** : Attribution des élèves aux classes
- **Années Scolaires** : Gestion des périodes scolaires avec statuts actif/inactif

### 📝 Système d'Inscription
- Inscription des étudiants par année scolaire
- Association automatique avec cycle, niveau et classe
- Contrôle de cohérence des données (Cycle → Niveau → Classe)
- Historique des inscriptions

### 🔐 Système d'Authentification
- Authentification complète Laravel Breeze
- Gestion des rôles et permissions (Spatie Laravel Permission)
- Profils utilisateurs personnalisables

### 📊 Dashboard Administrateur
- Vue d'ensemble des statistiques scolaires
- Gestion centralisée de tous les modules
- Interface responsive et moderne

## 🛠️ Technologies Utilisées

- **Framework** : Laravel 12.0
- **Base de données** : MySQL / SQLite
- **Frontend** : Blade Templates, Tailwind CSS
- **Authentification** : Laravel Breeze
- **Permissions** : Spatie Laravel Permission
- **Debug** : Laravel Debugbar
- **Tests** : PHPUnit

## 📋 Prérequis

- PHP 8.2 ou supérieur
- Composer
- Node.js & NPM
- MySQL ou SQLite

## 🚀 Installation

1. **Cloner le repository**
```bash
git clone <repository-url>
cd SGS
```

2. **Installer les dépendances PHP**
```bash
composer install
```

3. **Installer les dépendances JavaScript**
```bash
npm install
```

4. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configuration de la base de données**
   - Créer une base de données MySQL ou utiliser SQLite
   - Modifier le fichier `.env` avec vos paramètres de base de données

6. **Migration et seeding**
```bash
php artisan migrate
php artisan db:seed
```

7. **Compiler les assets**
```bash
npm run build
# ou pour le développement
npm run dev
```

8. **Démarrer le serveur**
```bash
php artisan serve
```

## 📁 Structure du Projet

```
SGS/
├── app/
│   ├── Http/Controllers/     # Contrôleurs
│   │   ├── Auth/            # Authentification
│   │   ├── StudentController.php
│   │   ├── ParentController.php
│   │   ├── ClasseController.php
│   │   └── ...
│   └── Models/              # Modèles Eloquent
│       ├── Student.php
│       ├── Parents.php
│       ├── Classe.php
│       ├── Inscription.php
│       └── ...
├── database/
│   ├── migrations/          # Migrations de base de données
│   └── seeders/            # Données de test
├── resources/
│   ├── views/              # Templates Blade
│   │   ├── admin/          # Interface administrateur
│   │   ├── auth/           # Pages d'authentification
│   │   └── layouts/        # Layouts principaux
│   └── css/                # Styles personnalisés
├── routes/                 # Définition des routes
└── tests/                  # Tests automatisés
```

## 🗄️ Modèle de Données

### Relations Principales
- **Student** ↔ **Parents** (Many-to-Many via `relations`)
- **Student** → **Inscription** (One-to-Many)
- **Inscription** → **Classe**, **Niveau**, **Cycle**, **Annee_scolaire** (Many-to-One)
- **Cycle** → **Niveau** → **Classe** (Hiérarchie académique)

## 🔧 Configuration

### Variables d'environnement importantes
```env
APP_NAME="SGS - Système de Gestion Scolaire"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sgs
DB_USERNAME=votre_username
DB_PASSWORD=votre_password
```

## 🧪 Tests

```bash
# Exécuter tous les tests
php artisan test

# Tests avec couverture
php artisan test --coverage
```

## 📚 Utilisation

### Accès à l'application
- **URL** : `http://localhost:8000`
- **Login administrateur** : Créer un compte via `/register` ou utiliser les seeders

### Fonctionnalités principales
1. **Gestion des Étudiants** : `/admin/etudiant`
2. **Gestion des Parents** : `/admin/parents`
3. **Gestion Académique** : Cycles, Niveaux, Classes
4. **Inscriptions** : `/admin/inscription`
5. **Dashboard** : `/dashboard`

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📝 Licence

Ce projet est sous licence MIT - voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 👥 Auteur

Développé avec ❤️ par [Djue kouassi Celestin]

## 🙏 Remerciements

- [Laravel](https://laravel.com/) - Le framework PHP le plus populaire
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) - Gestion des permissions
- [Tailwind CSS](https://tailwindcss.com/) - Framework CSS utilitaire
- Toute la communauté Laravel pour leur support continu
