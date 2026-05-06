# tes-fullstack

Aplikasi manajemen inventaris berbasis web menggunakan **Laravel** sebagai backend REST API dan **Vue.js** sebagai frontend.

---

## Tech Stack

**Backend**
- Laravel
- MySQL
- Laravel Sanctum (Authentication)

**Frontend**
- Vue 3 (Composition API)
- TypeScript
- Tailwind CSS
- Pinia (State Management)
- Vue Router
- Axios

---

## Fitur

- Authentication (Login)
- Management Anggota — CRUD data user/anggota
- Data Inventaris — CRUD data inventaris dengan status barang
- Analytics — Statistik dan visualisasi data inventaris

---

## Instalasi

### Backend (Laravel)

```bash
git clone https://github.com/username/tes-fullstack.git
cd tes-fullstack/backend

composer install
cp .env.example .env
php artisan key:generate

# Sesuaikan konfigurasi database di .env
php artisan migrate --seed
php artisan serve
```

### Frontend (Vue.js)

```bash
cd tes-fullstack/frontend

npm install
cp .env.example .env

# Sesuaikan VITE_API_URL di .env dengan URL backend
npm run dev
```

---

## Struktur Project

```
tes-fullstack/
├── backend/        # Laravel REST API
└── frontend/       # Vue.js
    ├── src/
    │   ├── views/
    │   │   ├── LoginView.vue
    │   │   ├── ManagementAnggota.vue
    │   │   ├── DataInventaris.vue
    │   │   └── Analytics.vue
    │   ├── stores/
    │   │   ├── auth.ts
    │   │   └── inventory.ts
    │   ├── router/
    │   └── types/
```

---

## Database Schema
 
Diagram ERD tersedia di dbdiagram.io:
 
🔗 [https://dbdiagram.io/d/Javier-Tes-Full-Stack-06-69fa91d27a923b94722688ab](https://dbdiagram.io/d/Javier-Tes-Full-Stack-06-69fa91d27a923b94722688ab)

---

## API Endpoints

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/login` | Login user |
| GET | `/user` | Get user yang sedang login |
| GET | `/users` | Get semua anggota |
| POST | `/users` | Tambah anggota |
| PUT | `/users/:id` | Update anggota |
| DELETE | `/users/:id` | Hapus anggota |
| GET | `/inventaris` | Get semua inventaris |
| POST | `/inventaris` | Tambah inventaris |
| PUT | `/inventaris/:id` | Update inventaris |
| DELETE | `/inventaris/:id` | Hapus inventaris |

---

## API Documentation

Dokumentasi API lengkap tersedia di Postman:

[![Run in Postman](https://run.pstmn.io/button.svg)](https://documenter.getpostman.com/view/41516300/2sBXqMGyn9)

🔗 [https://documenter.getpostman.com/view/41516300/2sBXqMGyn9](https://documenter.getpostman.com/view/41516300/2sBXqMGyn9)

---

## Lisensi

MIT

---

## Catatan

Login menggunakan akun ini
email: admin@web.id
password: admin#007
