# SpiceStore - Mini E-Commerce Laravel

Toko online sederhana untuk rempah-rempah nusantara dengan integrasi WhatsApp checkout.

## Fitur

- 📱 Katalog produk responsif dengan Tailwind CSS
- 🛒 Checkout langsung ke WhatsApp
- 👨‍💼 Panel admin untuk melihat pesanan (Basic Auth)
- 🗄️ Data produk dari JSON file
- 💾 Penyimpanan pesanan di MySQL

## Tech Stack

- Laravel 11
- PHP 8.2+
- MySQL (Cloud)
- Tailwind CSS
- Vite

## Instalasi

### 1. Clone & Install Dependencies

```bash
composer install
npm install
```

### 2. Environment Setup

Copy `.env.example` ke `.env` dan sesuaikan konfigurasi:

```env
APP_NAME=SpiceStore
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database MySQL Cloud
DB_CONNECTION=mysql
DB_HOST=34.101.191.161
DB_PORT=5432
DB_DATABASE=default
DB_USERNAME=mysql
DB_PASSWORD=J4fHyyxejMuxtIPRv7lZbPBZk8Kl3Sjahf8UtHNdso3g6oFi7KE0Phy8O44BoBeL

# Admin Credentials
ADMIN_USER=admin
ADMIN_PASS=spicestore123

# WhatsApp Integration
WA_SELLER_NUMBER=62XXXXXXXXXX
```

### 3. Database Migration

```bash
php artisan migrate
```

### 4. Build Assets

```bash
npm run build
# atau untuk development
npm run dev
```

### 5. Jalankan Server

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## Struktur Database

### Tabel `orders`

- `id` - Primary key
- `code` - Kode invoice (INV-XXXXXX)
- `product_sku` - SKU produk
- `product_name` - Nama produk
- `price` - Harga (integer, rupiah)
- `qty` - Jumlah dalam gram (default: 100)
- `customer_name` - Nama pelanggan
- `phone` - Nomor telepon
- `address` - Alamat lengkap
- `status` - Status pesanan (pending/done/canceled)
- `timestamps` - Created/updated at

## Data Produk

Produk rempah-rempah disimpan di `storage/app/products.json`:

```json
[
  {
    "sku": "SPICE-001",
    "name": "Kayu Manis Ceylon",
    "price": 45000,
    "photo": "https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=500&fit=crop",
    "desc": "Kayu manis Ceylon premium kualitas terbaik, aroma harum dan rasa manis alami"
  }
]
```

**Catatan**: Gambar produk menggunakan CDN Unsplash untuk kualitas visual yang optimal.

## Routes

- `GET /` - Halaman katalog rempah-rempah
- `GET /p/{sku}` - Detail rempah & form checkout
- `POST /checkout` - Proses checkout → redirect WhatsApp
- `GET /admin/orders` - Panel admin pesanan rempah (Basic Auth required)

## Admin Panel

Akses: `http://localhost:8000/admin/orders`

**Credentials:**
- Username: `admin`
- Password: `spicestore123`

## WhatsApp Integration

Setelah checkout, pelanggan akan diarahkan ke WhatsApp dengan template pesan:

```
Halo, saya pesan [Nama Rempah] ([Qty] gram)
Kode: [Order Code]
Total: Rp [Total Harga]
Nama: [Nama Pelanggan]
Telp: [Nomor Telepon]
Alamat: [Alamat Lengkap]
```

## Deployment

### Production Environment

1. Set `APP_ENV=production` dan `APP_DEBUG=false`
2. Generate application key: `php artisan key:generate`
3. Optimize untuk production:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
4. Setup web server (Apache/Nginx) dengan document root ke `/public`

### SSL untuk MySQL Cloud

Jika provider MySQL memerlukan SSL, tambahkan di `config/database.php`:

```php
'mysql' => [
    // ... konfigurasi lain
    'options' => [
        PDO::MYSQL_ATTR_SSL_CA => '/path/to/ca-cert.pem',
    ],
],
```

## Security Notes

- Jangan commit file `.env` ke repository
- Gunakan `APP_DEBUG=false` di production
- Pastikan kredensial admin yang kuat
- Validasi input form untuk mencegah XSS/injection

## License

MIT License
