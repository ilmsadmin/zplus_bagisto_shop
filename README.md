# E-commerce System với Bagisto, Next.js và Flutter

## Tổng quan dự án
Hệ thống e-commerce hoàn chỉnh với 3 thành phần chính:
- **Backend**: Bagisto Laravel Framework
- **Frontend**: Next.js Commerce  
- **Mobile App**: Flutter Application

## Kiến trúc hệ thống

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Mobile App    │    │  Frontend Web   │    │  Admin Panel    │
│   (Flutter)     │    │   (Next.js)     │    │   (Bagisto)     │
│   Port: N/A     │    │   Port: 3000    │    │   Port: 8000    │
└─────────┬───────┘    └─────────┬───────┘    └─────────┬───────┘
          │                      │                      │
          │                      │                      │
          └──────────────────────┼──────────────────────┘
                                 │
                    ┌─────────────▼───────────┐
                    │   Bagisto Backend      │
                    │   Laravel API          │
                    │   Port: 8000           │
                    └─────────────┬───────────┘
                                 │
                    ┌─────────────▼───────────┐
                    │      Database          │
                    │      MySQL             │
                    │      Port: 3306        │
                    └─────────────────────────┘
```

## Thành phần hệ thống

### 1. Backend - Bagisto Laravel (Port 8000)
**Thư mục**: `backend-bagisto/`

**Tính năng chính**:
- ✅ RESTful API cho headless commerce
- ✅ Admin Panel quản lý toàn bộ hệ thống
- ✅ Multi-store & Multi-currency
- ✅ Product & Category Management
- ✅ Customer & Order Management
- ✅ Payment Gateway Integration
- ✅ Shipping Management
- ✅ Marketing Tools (Promotions, Coupons)

**Tech Stack**:
- Laravel 11.x
- PHP 8.1+
- MySQL/MariaDB
- Vue.js (Admin Panel)

### 2. Frontend - Next.js Commerce (Port 3000)
**Thư mục**: `frontend-nextjs/`

**Tính năng chính**:
- ✅ Modern React-based storefront
- ✅ Server-Side Rendering (SSR)
- ✅ Shopping Cart & Checkout
- ✅ Product Search & Filtering
- ✅ Customer Authentication
- ✅ Responsive Design
- ✅ SEO Optimized

**Tech Stack**:
- Next.js 14
- React 18
- TypeScript
- Tailwind CSS
- Headless UI

### 3. Mobile App - Flutter (Cross-platform)
**Thư mục**: `mobile-app/`

**Tính năng chính**:
- ✅ iOS & Android support
- ✅ Native performance
- ✅ Offline capability
- ✅ Push notifications
- ✅ Modern Flutter UI
- ✅ Real-time updates

**Tech Stack**:
- Flutter 3.x
- Dart
- Bloc/Cubit State Management
- Firebase (Optional)

## Quick Start Guide

### Prerequisites
- PHP 8.1+ với Composer
- Node.js 18+ với npm/yarn
- Flutter SDK 3.x (optional cho mobile)
- MySQL/MariaDB
- Web server (Apache/Nginx hoặc Laravel Serve)

### Automated Setup (Recommended)

#### 1. Setup Database
```powershell
# Chạy script setup database và seed data
.\setup-database.ps1
```

#### 2. Start All Services
```powershell
# Khởi chạy tất cả services cùng lúc
.\start-all.ps1
```

### Manual Setup

#### 1. Setup Backend (Bagisto)
```powershell
cd backend-bagisto

# Cấu hình database trong .env
cp .env.example .env
# Chỉnh sửa DB_DATABASE, DB_USERNAME, DB_PASSWORD

# Install dependencies
composer install
npm install

# Generate key và migrate
php artisan key:generate
php artisan migrate
php artisan db:seed

# Create storage link
php artisan storage:link

# Start server
php artisan serve --port=8000
```

**Access**:
- Frontend: http://localhost:8000
- Admin Panel: http://localhost:8000/admin
- API Base: http://localhost:8000/api/v1

#### 2. Setup Frontend (Next.js)
```powershell
cd frontend-nextjs

# Install dependencies
npm install --omit=optional

# Setup environment
cp .env.example .env.local
# Chỉnh sửa NEXT_PUBLIC_BAGISTO_API_URL=http://localhost:8000/api/v1

# Start development server
npm run dev
```

**Access**: http://localhost:3000

#### 3. Setup Mobile App (Flutter)
```powershell
cd mobile-app

# Get dependencies
flutter pub get

# Chỉnh sửa lib/utils/server_configuration.dart
# Đặt baseUrl = "http://localhost:8000"

# Run app
flutter run
```

### NPM Scripts (Available in root directory)
```powershell
# Setup database
npm run setup

# Start all services
npm run start

# Install all dependencies
npm run install:all

# Start individual services
npm run start:backend
npm run start:frontend
npm run start:mobile

# Build for production
npm run build:frontend
npm run build:mobile

# Run tests
npm run test:backend
npm run test:frontend
npm run test:mobile

# Clean cache
npm run clean
```

## API Endpoints

### Authentication
- `POST /api/v1/customer/login` - Customer login
- `POST /api/v1/customer/register` - Customer registration
- `POST /api/v1/admin/login` - Admin login

### Products
- `GET /api/v1/products` - Get products list
- `GET /api/v1/products/{id}` - Get product details
- `GET /api/v1/categories` - Get categories

### Cart & Checkout
- `GET /api/v1/customer/cart` - Get cart
- `POST /api/v1/customer/cart/add` - Add to cart
- `POST /api/v1/customer/checkout/save-address` - Save checkout address
- `POST /api/v1/customer/checkout/save-payment` - Process payment

### Orders
- `GET /api/v1/customer/orders` - Get customer orders
- `GET /api/v1/customer/orders/{id}` - Get order details

## Development Workflow

### 1. Backend Development
```powershell
cd backend-bagisto

# Run with auto-reload
php artisan serve --port=8000

# Watch for asset changes
npm run dev

# Run tests
php artisan test
```

### 2. Frontend Development
```powershell
cd frontend-nextjs

# Development server với hot reload
npm run dev

# Build for production
npm run build

# Type checking
npm run type-check
```

### 3. Mobile Development
```powershell
cd mobile-app

# Hot reload development
flutter run

# Build APK
flutter build apk --release

# Run tests
flutter test
```

## Environment Configuration

### Backend (.env)
```env
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bagisto_shop
DB_USERNAME=root
DB_PASSWORD=

# Email configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587

# Payment gateways
PAYPAL_CLIENT_ID=your_paypal_client_id
STRIPE_PUBLISHABLE_KEY=your_stripe_key
```

### Frontend (.env.local)
```env
NEXT_PUBLIC_BAGISTO_API_URL=http://localhost:8000/api/v1
NEXT_PUBLIC_BAGISTO_BASE_URL=http://localhost:8000
NEXTAUTH_SECRET=your-nextauth-secret
NEXTAUTH_URL=http://localhost:3000
```

### Mobile (server_configuration.dart)
```dart
class Server {
  static const String baseUrl = "http://localhost:8000";
  static const String apiBaseUrl = "$baseUrl/api/v1";
  static const String imageBaseUrl = "$baseUrl/storage";
}
```

## Deployment Guide

### Production Checklist
- [ ] Setup production database
- [ ] Configure SSL certificates
- [ ] Setup proper web server (Nginx/Apache)
- [ ] Configure environment variables
- [ ] Setup backup systems
- [ ] Configure monitoring

### Backend Deployment
- Laravel Forge
- DigitalOcean
- AWS EC2
- VPS với cPanel

### Frontend Deployment
- Vercel (Recommended)
- Netlify
- AWS Amplify
- Static hosting

### Mobile Deployment
- Google Play Store (Android)
- Apple App Store (iOS)
- Microsoft Store (Windows)

## Monitoring & Analytics

### Backend Monitoring
- Laravel Telescope (Development)
- New Relic / DataDog (Production)
- Error tracking với Sentry

### Frontend Analytics
- Google Analytics
- Vercel Analytics
- Mixpanel

### Mobile Analytics
- Firebase Analytics
- Crashlytics
- Performance monitoring

## Support & Documentation

### Documentation Links
- [Bagisto Documentation](https://devdocs.bagisto.com/)
- [Next.js Documentation](https://nextjs.org/docs)
- [Flutter Documentation](https://flutter.dev/docs)

### Community Support
- [Bagisto Forums](https://forums.bagisto.com/)
- [Bagisto Discord](https://discord.com/invite/bagisto)
- [GitHub Issues](https://github.com/bagisto/bagisto/issues)

## Contributing
Mỗi thành phần có hướng dẫn riêng trong file `SETUP-GUIDE.md` tương ứng:
- `backend-bagisto/SETUP-GUIDE.md`
- `frontend-nextjs/SETUP-GUIDE.md`  
- `mobile-app/SETUP-GUIDE.md`

## License
- Bagisto: MIT License
- Next.js Commerce: MIT License
- Flutter App: MIT License

---

**Developed with ❤️ using Bagisto Laravel, Next.js, and Flutter**
