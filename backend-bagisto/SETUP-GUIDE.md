# Hướng dẫn Backend Bagisto - Laravel E-commerce

## Giới thiệu
Backend này sử dụng Bagisto Laravel framework - một nền tảng e-commerce mã nguồn mở mạnh mẽ được xây dựng trên Laravel và Vue.js.

## Tính năng chính
- ✅ Multi-store & Multi-currency
- ✅ Admin Panel với giao diện hiện đại
- ✅ Catalog Management (Sản phẩm, Danh mục, Thuộc tính)
- ✅ Customer Management
- ✅ Order Management
- ✅ Payment Gateway Integration
- ✅ Shipping Methods
- ✅ Marketing Tools (Promotions, Coupons)
- ✅ SEO Friendly
- ✅ API Support cho headless commerce
- ✅ Multi-language Support
- ✅ Theme Customization

## Yêu cầu hệ thống
- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM
- Web server (Apache/Nginx)

## Cài đặt và Cấu hình

### 1. Cấu hình Database
```bash
# Copy và chỉnh sửa file .env
cp .env.example .env

# Cấu hình database trong .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bagisto_shop
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 2. Chạy Migration và Seeder
```bash
php artisan migrate
php artisan db:seed
```

### 3. Install Dependencies
```bash
composer install
npm install
npm run build
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Create Storage Link
```bash
php artisan storage:link
```

### 6. Chạy ứng dụng
```bash
php artisan serve
```

## API Documentation
Bagisto cung cấp RESTful API cho headless commerce:
- Customer API
- Product API  
- Cart API
- Order API
- Authentication API

## Cấu trúc thư mục quan trọng
```
backend-bagisto/
├── app/                    # Laravel application code
├── packages/Webkul/        # Bagisto core packages
├── public/                 # Public assets
├── resources/              # Views, assets
├── database/               # Migrations, seeders
├── config/                 # Configuration files
└── .env                    # Environment configuration
```

## Tích hợp với Frontend và Mobile
Backend này cung cấp API endpoints để tích hợp với:
- Frontend Next.js Commerce
- Mobile App Flutter
- Các ứng dụng headless khác

## Đăng nhập Admin Panel
URL: http://localhost:8000/admin
- Email: admin@example.com
- Password: admin123

## Đăng nhập Customer
URL: http://localhost:8000
- Tạo tài khoản mới hoặc sử dụng demo data

## Hỗ trợ
- [Bagisto Documentation](https://devdocs.bagisto.com/)
- [Community Forum](https://forums.bagisto.com/)
- [GitHub Issues](https://github.com/bagisto/bagisto/issues)
