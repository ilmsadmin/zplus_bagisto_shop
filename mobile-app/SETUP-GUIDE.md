# Mobile App - Bagisto Flutter eCommerce

## Giới thiệu
Mobile app này được xây dựng bằng Flutter, tích hợp với Bagisto backend để cung cấp trải nghiệm mua sắm di động hoàn chỉnh.

## Tính năng chính
- ✅ Cross-platform (iOS & Android)
- ✅ Modern Flutter UI
- ✅ Product Catalog Browser
- ✅ Shopping Cart
- ✅ User Authentication
- ✅ Order Management
- ✅ Push Notifications
- ✅ Offline Support
- ✅ Multi-language Support
- ✅ Payment Gateway Integration
- ✅ Real-time Updates
- ✅ Dark/Light Theme

## Công nghệ sử dụng
- **Flutter 3.x** - Cross-platform Framework
- **Dart** - Programming Language
- **Bloc/Cubit** - State Management
- **Dio** - HTTP Client
- **Hive** - Local Database
- **Firebase** - Push Notifications & Analytics
- **GetIt** - Dependency Injection

## Yêu cầu hệ thống
- Flutter SDK >= 3.0.0
- Dart SDK >= 3.0.0
- Android Studio / VS Code
- Xcode (cho iOS development)
- Bagisto Backend đã setup

## Cài đặt và Cấu hình

### 1. Cài đặt Flutter
```bash
# Tải Flutter SDK từ https://flutter.dev/docs/get-started/install
# Thêm Flutter vào PATH

# Kiểm tra cài đặt
flutter doctor
```

### 2. Clone và Setup Project
```bash
# Project đã được clone rồi
cd mobile-app

# Get dependencies
flutter pub get
```

### 3. Cấu hình API Endpoints
Chỉnh sửa file `lib/utils/server_configuration.dart`:
```dart
class Server {
  static const String baseUrl = "http://localhost:8000";
  static const String apiBaseUrl = "$baseUrl/api/v1";
  static const String imageBaseUrl = "$baseUrl/storage";
}
```

### 4. Cấu hình Firebase (Optional)
- Tạo project Firebase
- Thêm `google-services.json` vào `android/app/`
- Thêm `GoogleService-Info.plist` vào `ios/Runner/`

### 5. Chạy ứng dụng
```bash
# Chạy trên Android
flutter run -d android

# Chạy trên iOS  
flutter run -d ios

# Chạy trên Windows (desktop)
flutter run -d windows
```

## Cấu trúc thư mục
```
mobile-app/
├── lib/
│   ├── data_model/         # Data models
│   ├── screens/            # App screens
│   │   ├── home/          # Home screen
│   │   ├── product/       # Product screens  
│   │   ├── cart/          # Cart screens
│   │   ├── checkout/      # Checkout screens
│   │   └── profile/       # Profile screens
│   ├── widgets/           # Reusable widgets
│   ├── utils/             # Utilities & helpers
│   ├── services/          # API services
│   ├── bloc/              # State management
│   └── main.dart          # App entry point
├── android/               # Android specific files
├── ios/                   # iOS specific files
├── assets/                # Images, fonts, etc.
└── pubspec.yaml          # Dependencies
```

## API Integration

### Các service chính:
```dart
// Authentication
class AuthService {
  Future<User> login(String email, String password);
  Future<User> register(UserData userData);
  Future<void> logout();
}

// Product Service
class ProductService {
  Future<List<Product>> getProducts();
  Future<Product> getProductDetail(int id);
  Future<List<Category>> getCategories();
}

// Cart Service  
class CartService {
  Future<Cart> getCart();
  Future<void> addToCart(int productId, int quantity);
  Future<void> updateCart(int itemId, int quantity);
}
```

### State Management với Bloc:
```dart
// Product Bloc
class ProductBloc extends Bloc<ProductEvent, ProductState> {
  final ProductRepository repository;
  
  ProductBloc(this.repository) : super(ProductInitial()) {
    on<LoadProducts>(_onLoadProducts);
    on<LoadProductDetail>(_onLoadProductDetail);
  }
}
```

## Tính năng chính

### 1. Authentication
- Đăng ký/Đăng nhập
- Quên mật khẩu
- Social login (Google, Facebook)
- Guest checkout

### 2. Product Catalog
- Danh sách sản phẩm
- Tìm kiếm và lọc
- Chi tiết sản phẩm
- Đánh giá sản phẩm
- Wishlist

### 3. Shopping Cart
- Thêm/xóa sản phẩm
- Cập nhật số lượng
- Áp dụng coupon
- Tính toán shipping

### 4. Checkout Process
- Thông tin giao hàng
- Phương thức thanh toán
- Xác nhận đơn hàng
- Theo dõi đơn hàng

### 5. User Profile
- Thông tin cá nhân
- Lịch sử đơn hàng
- Địa chỉ giao hàng
- Cài đặt ứng dụng

## Customization

### Thay đổi Theme:
```dart
// lib/utils/app_theme.dart
class AppTheme {
  static ThemeData lightTheme = ThemeData(
    primarySwatch: Colors.blue,
    // Customize colors, fonts, etc.
  );
  
  static ThemeData darkTheme = ThemeData(
    brightness: Brightness.dark,
    // Dark theme customization
  );
}
```

### Thêm Screen mới:
```dart
// Tạo screen trong lib/screens/
class NewScreen extends StatefulWidget {
  @override
  _NewScreenState createState() => _NewScreenState();
}

// Thêm route trong main.dart
routes: {
  '/new-screen': (context) => NewScreen(),
}
```

## Build và Deploy

### Build APK (Android):
```bash
flutter build apk --release
```

### Build App Bundle (Android):
```bash
flutter build appbundle --release
```

### Build iOS:
```bash
flutter build ios --release
```

### Build Desktop (Windows):
```bash
flutter build windows --release
```

## Testing
```bash
# Run unit tests
flutter test

# Run integration tests
flutter drive --target=test_driver/app.dart
```

## Performance Optimization
- Image caching và compression
- Lazy loading cho lists
- State management tối ưu
- Memory management
- Background processing

## Push Notifications
- Firebase Cloud Messaging
- Local notifications
- Rich notifications với images
- Deep linking

## Tích hợp với Backend
Mobile app này tương tác với:
- Bagisto Laravel Backend APIs
- Real-time updates
- Offline data caching
- Synchronization khi online

## Publishing
- **Google Play Store**: Android apps
- **Apple App Store**: iOS apps  
- **Microsoft Store**: Windows apps

## Hỗ trợ
- [Flutter Documentation](https://flutter.dev/docs)
- [Bagisto Mobile App Docs](https://github.com/bagisto/opensource-ecommerce-mobile-app)
- [Flutter Community](https://flutter.dev/community)
