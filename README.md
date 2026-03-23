# 📧 Email Channel — Laravel Package

A modular Laravel package for sending, receiving, and managing emails using **IMAP** and **SMTP** — with database storage, duplicate prevention, incremental UID-based fetching, API endpoints, and an optional dashboard UI.

---

## ✨ Features

| # | Feature |
|---|---------|
| 1 | Fetch incoming emails via IMAP |
| 2 | Send emails via SMTP |
| 3 | Store emails in database |
| 4 | Prevent duplicate email processing |
| 5 | Incremental fetching using UID tracking |
| 6 | Store metadata (subject, UID, etc.) |
| 7 | API endpoints for email operations |
| 8 | Optional dashboard UI |
| 9 | Auto-fetch emails via Laravel Scheduler |
| 10 | Modular and reusable package architecture |

---

## 🧰 Prerequisites

Ensure the following are installed before getting started:

- **PHP** ≥ 8.1
- **Composer** — https://getcomposer.org/download/
- **XAMPP** (Apache + MySQL) — https://www.apachefriends.org/
- **Git** — https://git-scm.com/

---

## 🚀 Installation & Setup

### Step 1 — Create Laravel Application

```bash
composer create-project laravel/laravel email-channel-app
cd email-channel-app
```

---

### Step 2 — Install the Package

```bash
composer require arkadip/email-channel
```

> ⚠️ If testing locally before publishing to Packagist, add a `repositories` entry in your `composer.json` pointing to the local path.

---

### Step 3 — Setup Database (XAMPP + phpMyAdmin)

1. **Start XAMPP** — enable both **Apache** and **MySQL**
2. **Open phpMyAdmin** at `http://localhost/phpmyadmin`
3. **Create a new database** named:

```
email_channel_db
```

---

### Step 4 — Configure `.env`

Open `email-channel-app/.env` and set the following:

#### 🗄️ Database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=email_channel_db
DB_USERNAME=root
DB_PASSWORD=
```

#### 📥 IMAP — Incoming Emails

```env
IMAP_HOST=imap.gmail.com
IMAP_PORT=993
IMAP_ENCRYPTION=ssl
IMAP_USERNAME=your-email@gmail.com
IMAP_PASSWORD=your-app-password
```

> ⚠️ Use an **App Password**, not your Gmail account password.  
> Don't forget to **enable IMAP** in Gmail Settings → See all settings → Forwarding and POP/IMAP.

#### 📤 SMTP — Sending Emails

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Email Channel"
```

---

### Step 5 — Run Migrations

```bash
php artisan migrate
```

This creates the following tables:

- `messages`
- `message_metas`

---

### Step 6 — Setup Scheduler (Auto Fetch)

Open `bootstrap/app.php` and add the following **before** `->create()`:

```php
->withSchedule(function ($schedule) {
    $schedule->call(function () {
        app(\Arkadip\EmailChannel\Services\ImapService::class)->fetchEmails();
    })->everyTenSeconds(); // near real-time fetching
})
```

Then start the scheduler:

```bash
php artisan schedule:work
```

---

### Step 7 — Setup Routes

Open `routes/web.php` and add:

```php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('email-channel::dashboard');
});
```

---

### Step 8 — Run the Application

```bash
php artisan serve
```

Visit: **[http://127.0.0.1:8000/email-dashboard](http://127.0.0.1:8000/email-dashboard)**

---

## 🎯 Testing Features

| Feature | Description |
|---------|-------------|
| ✅ **Send Email** | Use the dashboard form — sent via SMTP and stored in DB |
| ✅ **Receive Email** | Fetched via IMAP, stored in DB, duplicates prevented |
| ✅ **Auto Fetch** | Scheduler runs automatically, only fetches new emails |
| ✅ **Real-time UI** | Dashboard auto-updates via polling |

---

## 📦 API Endpoints

| Method | Route | Purpose |
|--------|-------|---------|
| `GET` | `/email-channel/emails` | Retrieve stored emails |
| `POST` | `/email-channel/send` | Send an email |
| `POST` | `/email-channel/fetch` | Trigger a manual fetch |
| `GET` | `/email-channel/dashboard` | View the dashboard UI |

---

## 🧠 Key Concepts

### 🔁 Incremental Fetch (UID-based)

Rather than re-fetching all emails on every run:

- ✔ Only **new emails** are fetched
- ✔ Uses **UID tracking** to resume from last position
- ✔ Efficient and scalable for production use

### 🔐 Security Best Practices

- Never expose your `.env` file
- Always use **App Passwords** for Gmail
- Do not commit credentials to version control

---

## ⚠️ Common Issues

<details>
<summary><strong>❌ Emails not fetching</strong></summary>

- Enable IMAP in Gmail Settings
- Use an App Password, not your account password
- Double-check IMAP credentials in `.env`

</details>

<details>
<summary><strong>❌ MySQL not starting</strong></summary>

- Restart XAMPP
- Check for port conflicts (default: 3306)
- Fix corrupted tables via phpMyAdmin if needed

</details>

<details>
<summary><strong>❌ Package not found</strong></summary>

```bash
composer dump-autoload
composer update
```

</details>

<details>
<summary><strong>❌ Scheduler not running</strong></summary>

```bash
php artisan schedule:work
```

</details>

---

## 🗒️ Notes

- Package is **auto-discovered** by Laravel — no manual provider registration needed
- Views are **optional** and fully customizable
- Scheduler is controlled entirely by the host application

---

## ✅ Final Result

> A fully working email system with Laravel package integration, real-time email fetching, and a clean modular architecture.
