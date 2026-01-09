# Project 1 – Laravel Community Site

Laravel 12 webapplicatie voor Backend Web. Dit is een data-driven website met publieke pagina’s (news/FAQ/members/profielen/contact) en een admin-panel.

---

## Requirements
- **PHP 8.2+**
- **Composer** (PHP package manager)
- **Node.js + npm** (aanbevolen LTS, bv. Node 20+)
- **Database**: SQLite (standaard) of MySQL/PostgreSQL

### PHP & Composer installeren (indien nog niet geïnstalleerd)
**Optie A: Laravel Herd (aanbevolen voor Windows/Mac)**
- Download: https://herd.laravel.com
- Herd installeert PHP + Composer automatisch en zet ze in je PATH.

**Optie B: Manueel**
- PHP (Windows): https://windows.php.net/download/
- Composer: https://getcomposer.org/download/

Verifieer installatie:
```powershell
php -v
composer -V
```

---

## Setup

### 1) Clone the repository
```powershell
git clone <repository-url>
cd laravelproject
```

### 2) Install PHP dependencies (maakt `vendor/`)
```powershell
composer install
```

> ⚠️ Deze stap is verplicht. Zonder `vendor/` werkt de app niet.

### 3) Create your `.env` file
```powershell
Copy-Item .env.example .env
```

> Kopieer geen `.env` van een andere machine: paden/config kunnen verschillen.

### 4) Generate application key
```powershell
php artisan key:generate
```

### 5) Install frontend dependencies
```powershell
npm install
```

### 6) Run migrations + seeders
```powershell
php artisan migrate:fresh --seed
```

### 7) Create storage symlink (voor uploads)
```powershell
php artisan storage:link
```

### 8) Start the development server
Open 2 terminals:

Terminal 1:
```powershell
php artisan serve
```

Terminal 2:
```powershell
npm run dev
```

Open daarna: http://localhost:8000

---

## Quick Start (for teachers/evaluators)
De standaard `.env.example` gebruikt **SQLite** en **MAIL_MAILER=log**.

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

✅ SQLite is standaard ingesteld via `DB_CONNECTION=sqlite`.

> Let op: Laravel gebruikt in deze setup `SESSION_DRIVER=database`, `CACHE_STORE=database` en `QUEUE_CONNECTION=database`.
> Daarom is `php artisan migrate:fresh --seed` belangrijk zodat ook de cache/session/job tabellen bestaan.

### Als je MySQL wilt gebruiken
Pas `.env` aan:
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravelproject
DB_USERNAME=root
DB_PASSWORD=
```
Daarna:
```powershell
php artisan migrate:fresh --seed
```

---

## Mail configuration (local testing)
Standaard staat in `.env.example`:
- `MAIL_MAILER=log`

Dat betekent dat mails worden gelogd in:
- `storage/logs/laravel.log`

Dit is handig om te testen:
- contactformulier → admin reply mail (zonder echte SMTP)
- password reset mails (Laravel standaard flow)

---

## Default admin (required by assignment)
Na seeden kan je inloggen met:
- **Email:** `admin@ehb.be`
- **Password:** `Password!321`

Admin panel:
- `/admin`

---

## Features

### Minimum requirements
- **Authentication**: login / register / password reset / remember me
- **Roles**: user/admin via `users.is_admin`
  - enkel admins kunnen users admin maken/afnemen
  - enkel admins kunnen users manueel aanmaken
- **Public profile pages**: `/users/{username}` (zichtbaar voor iedereen)
- **Profile editor** (voor ingelogde user): username, verjaardag, profielfoto, bio
- **News module**
  - publiek: `/news` en `/news/{news}`
  - admin CRUD: `/admin/news`
  - velden: title, image (server), content, published_at
- **FAQ module**
  - publiek: `/faq` (per categorie)
  - admin CRUD: `/admin/faq/categories` en `/admin/faq/items`
- **Contact form**
  - publiek: `/contact`
  - admin inbox + reply: `/admin/contact`

### Extra’s
- Contactberichten worden opgeslagen in de database en bevatten mailbox velden (`read_at`, `replied_at`, `admin_reply`).
- Members pagina (zoeken): `/members`.

---

## Database Structure & Entity Relationships
Overzicht van de belangrijkste tabellen en relaties (zie `database/migrations/` en `app/Models/`).

### Belangrijkste tabellen
- `users` (incl. `is_admin`)
- `profiles` (publieke profielen)
- `news`
- `faq_categories`
- `faq_items`
- `contact_messages`
- `cache`, `jobs` (omdat cache/queue/session op database staan)

### Belangrijkste relaties
- **User ↔ Profile**: 1–1 (`profiles.user_id` → `users.id`, cascade delete)
- **User ↔ News**: 1–many via `news.created_by` (nullable, `nullOnDelete()`)
- **FaqCategory ↔ FaqItem**: 1–many (`faq_items.faq_category_id`, cascade delete)
- **User ↔ ContactMessage**: 1–many (optioneel, `contact_messages.user_id` nullable)

### ASCII ERD (vereenvoudigd)
```text
users
  |\
  | \__< profiles (1–1)
  |
  |--< news (created_by)
  |
  |--< contact_messages (user_id nullable)

faq_categories
  |--< faq_items
```

---

## Notes for evaluation (migrate:fresh --seed)
De docent kan dit draaien:
```powershell
php artisan migrate:fresh --seed
```
Dit:
- maakt alle tabellen aan via migrations
- maakt de **default admin** aan
- seedt **voorbeeld nieuwsitems** (zie `database/seeders/NewsSeeder.php`)

---

## Troubleshooting

### “composer/php is not recognized”
PHP en/of Composer staat niet in je PATH.
- Aanbevolen: Laravel Herd https://herd.laravel.com

### “Failed to open stream … vendor/autoload.php”
Je hebt `composer install` nog niet uitgevoerd.
```powershell
composer install
```

### “could not find driver” (SQLite)
Je PHP mist SQLite extensies.
- Zoek je `php.ini`: `php --ini`
- Uncomment:
  - `extension=pdo_sqlite`
  - `extension=sqlite3`

### “Database [file] does not exist” (SQLite)
Normaal gebruikt Laravel standaard `database/database.sqlite`.
Als het file ontbreekt:
```powershell
New-Item -Path database\database.sqlite -ItemType File -Force
php artisan migrate:fresh --seed
```

### Images/uploads niet zichtbaar
```powershell
php artisan storage:link
```

### `.env` aangepast maar app pakt oude waarden
```powershell
php artisan config:clear
```

---

## Sources / references
- Laravel docs: https://laravel.com/docs
- Laravel Breeze: https://github.com/laravel/breeze
- Tailwind CSS: https://tailwindcss.com
- Alpine.js: https://alpinejs.dev
- Vite + Laravel plugin: https://github.com/laravel/vite-plugin
- Intervention Image: https://image.intervention.io

License: Educational project.
