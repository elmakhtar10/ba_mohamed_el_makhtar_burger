# ISI BURGER - Gestion des commandes (Laravel)

Projet universitaire : application de gestion des commandes pour le restaurant **ISI BURGER**.

## Fonctionnalites principales
- Gestion des produits (burgers)
- Catalogue client + filtres
- Commandes client + suivi
- Gestion des commandes (gestionnaire)
- Paiements en especes
- Facture PDF envoyee lorsque la commande est prete
- Statistiques + graphiques
- Authentification + roles (Spatie)

## Prerequis
- PHP 8.4
- Composer
- Node.js (pour assets)
- Docker (optionnel)

## Installation locale
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm run dev
php artisan serve
```

Acces : http://127.0.0.1:8000

## Comptes de test (seed)
- Gestionnaire : gestionnaire@isi-burger.test / password
- Client : client@isi-burger.test / password

## Mail (Mailtrap)
Mettre vos infos Mailtrap dans `.env` :
```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=xxxx
MAIL_PASSWORD=xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="contact@isi-burger.com"
MAIL_FROM_NAME="ISI BURGER"
```
Puis :
```bash
php artisan config:clear
```

## Docker
```bash
docker build -t isi-burger:local .
docker run --rm -p 9000:9000 isi-burger:local
```

## CI/CD (GitHub Actions)
Workflow dans `.github/workflows/ci.yml` :
- checkout
- composer install
- build image docker

Le workflow se declenche automatiquement sur la branche demandee : **ba_mohamed_el_makhtar_burger**.

## Notes
- Les factures PDF sont generees avec DomPDF
- Les notifications clients et gestionnaires sont envoyees par email
