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

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=your_database_host
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

# Admin credentials are now managed in database
# Run: php artisan db:seed --class=AdminUserSeeder to create admin user

# WhatsApp Integration
WA_SELLER_NUMBER=62XXXXXXXXXX
```

### 3. Database Setup

```bash
# Jalankan migrasi database
php artisan migrate

# Buat user admin
php artisan db:seed --class=AdminUserSeeder
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

**Setup Admin User:**
1. Jalankan seeder untuk membuat user admin:
   ```bash
   php artisan db:seed --class=AdminUserSeeder
   ```

**Default Credentials:**
- Email: `admin@spicestore.com`
- Password: `admin123`

⚠️ **PENTING:** Ganti password default setelah login pertama!

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

### Development vs Production

**Development (Local):**
```bash
# Script composer untuk development (menjalankan semua service sekaligus)
composer run dev
# Atau manual:
php artisan serve
php artisan queue:work
npm run dev
```

### Production Deployment

#### 1. Environment Setup
```bash
# Set environment production
cp .env.example .env
```

Edit `.env` untuk production:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database production
DB_CONNECTION=mysql
DB_HOST=your_production_db_host
DB_PORT=3306
DB_DATABASE=your_production_db
DB_USERNAME=your_production_user
DB_PASSWORD=your_secure_password

# Admin credentials akan dibuat via seeder
# WhatsApp Integration
WA_SELLER_NUMBER=62XXXXXXXXXX
```

#### 2. Dependencies & Build
```bash
# Install dependencies (production only)
composer install --optimize-autoloader --no-dev

# Generate application key
php artisan key:generate

# Build assets untuk production
npm ci
npm run build
```

#### 3. Database Setup
```bash
# Jalankan migrasi
php artisan migrate --force

# Buat admin user
php artisan db:seed --class=AdminUserSeeder
```

#### 4. Optimization
```bash
# Cache konfigurasi untuk performa
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Optimize autoloader
composer dump-autoload --optimize
```

#### 5. Web Server Configuration

**Nginx Example:**
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/your/project/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

**Apache Example (.htaccess sudah ada di /public):**
- Set DocumentRoot ke `/path/to/your/project/public`
- Pastikan mod_rewrite aktif

#### 6. Process Management

**Queue Worker (Supervisor):**
```ini
[program:spicestore-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/queue.log
```

#### 7. File Permissions
```bash
# Set proper permissions
sudo chown -R www-data:www-data /path/to/your/project
sudo chmod -R 755 /path/to/your/project
sudo chmod -R 775 /path/to/your/project/storage
sudo chmod -R 775 /path/to/your/project/bootstrap/cache
```

#### 8. SSL/HTTPS Setup
```bash
# Menggunakan Let's Encrypt (Certbot)
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com
```

#### 9. Monitoring & Maintenance

**Log Monitoring:**
```bash
# Monitor aplikasi logs
tail -f storage/logs/laravel.log

# Monitor queue logs
tail -f storage/logs/queue.log

# Monitor web server logs
tail -f /var/log/nginx/access.log
tail -f /var/log/nginx/error.log
```

**Maintenance Commands:**
```bash
# Clear cache jika ada update
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Restart queue worker setelah update code
sudo supervisorctl restart spicestore-queue:*

# Backup database
mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql
```

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

⚠️ **PENTING - Keamanan Kredensial:**
- **JANGAN PERNAH** commit file `.env` ke repository
- **JANGAN** bagikan kredensial database di README atau dokumentasi publik
- Gunakan environment variables atau secret management untuk kredensial sensitif
- Ganti semua password default sebelum deployment

📋 **Best Practices:**
- Gunakan `APP_DEBUG=false` di production
- Pastikan kredensial admin yang kuat (minimal 12 karakter, kombinasi huruf, angka, simbol)
- Validasi input form untuk mencegah XSS/injection
- Aktifkan SSL/TLS untuk koneksi database di production
- Backup database secara berkala

## License

MIT License
