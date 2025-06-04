# ViPOS - Virtual Point of Sale for Bagisto

ViPOS (Virtual Point of Sale) is a comprehensive Point of Sale (POS) system fully integrated with Bagisto e-commerce platform. It provides a fullscreen interface for cashiers to process sales quickly and efficiently in a retail environment.

## Features

### 🖥️ Fullscreen POS Interface
- Dedicated interface optimized for touchscreens and desktop use
- Split screen layout: Left side for cart management, right side for product browsing
- Responsive design that works on tablets and desktop computers

### 📦 Product Management
- Quick search by name, SKU or barcode
- Category-based product browsing
- Visual product grid with images and prices
- Real-time stock checking

### 👥 Customer Management
- Customer search and selection
- Quick view of customer details
- Customer association with orders
- Ability to create new customers on the fly

### 🛒 Cart Management
- Add/remove products with simple clicks
- Update quantities with + and - buttons
- Real-time total calculation including tax
- Clear cart display with item details

### 💳 Checkout Process
- Multiple payment methods:
  - Cash with denomination buttons
  - Card payments
  - UPI payments
  - Bank transfers
- Cash denomination buttons for quick amount entry
- Automatic change calculation for cash payments

### 📋 Order Processing
- Instant order creation in Bagisto system
- Order confirmation with details
- Integration with existing Bagisto order management
- Receipt printing support

### 📊 Session Management
- Open/close register sessions
- Track opening and closing amounts
- Session notes and reporting
- Cash handling accountability

## Installation

1. **Place the package** in the `packages/ZPlus/ViPOS` directory

2. **Add to composer.json** (already done in this installation):
   ```json
   "autoload": {
       "psr-4": {
           "ZPlus\\ViPOS\\": "packages/ZPlus/ViPOS/src"
       }
   }
   ```

3. **Register service providers** (already done in this installation):
   - Added to `bootstrap/providers.php`
   - Added to `config/concord.php`

4. **Run migrations**:
   ```bash
   php artisan migrate
   ```

5. **Publish assets**:
   ```bash
   php artisan vendor:publish --provider="ZPlus\ViPOS\Providers\ViPOSServiceProvider" --tag="public"
   ```

6. **Publish config**:
   ```bash
   php artisan vendor:publish --provider="ZPlus\ViPOS\Providers\ViPOSServiceProvider" --tag="config"
   ```

## Usage

1. **Access the POS**: Navigate to `/admin/vipos` after logging in as an administrator
2. **Start Session**: Enter opening cash amount and any notes
3. **Select Customer**: Use the search function to find or create customers
4. **Add Products**: Click products in the grid or use search function
5. **Adjust Quantities**: Use + and - buttons in the cart
6. **Checkout**: Click checkout button and select payment method
7. **Complete Sale**: Process payment and generate receipt
8. **End Session**: Close session at end of day with closing amount

## API Endpoints

### Products
- `GET /api/vipos/products` - Get paginated product list
- `GET /api/vipos/products/categories` - Get product categories
- `GET /api/vipos/products/{identifier}` - Get product by ID or SKU

### Customers
- `GET /api/vipos/customers/search` - Search customers
- `POST /api/vipos/customers` - Create new customer
- `GET /api/vipos/customers/{id}` - Get customer details

### Orders
- `POST /api/vipos/orders` - Create new order
- `GET /api/vipos/orders/recent` - Get recent POS orders
- `GET /api/vipos/orders/{id}` - Get order details

## Configuration

The package includes configurable settings for:

- **Receipt Settings**: Store information, thank you messages
- **Tax Settings**: Default tax rates and calculation methods
- **Payment Methods**: Enable/disable payment options
- **Display Settings**: Products per page, theme colors

## Database Tables

### `vipos_sessions`
Stores POS session information including opening/closing amounts and session status.

### `vipos_settings`
Stores configurable settings for the POS system.

## Integration

ViPOS seamlessly integrates with:
- **Bagisto Products**: Uses existing product catalog
- **Bagisto Customers**: Access to customer database
- **Bagisto Orders**: Creates standard Bagisto orders
- **Bagisto Inventory**: Real-time stock management

## Technical Architecture

- **Models**: `ViPOSSession`, `ViPOSSetting`
- **Controllers**: Product, Customer, Order, and main ViPOS controllers
- **Views**: Responsive Blade templates with Tailwind CSS
- **API**: RESTful endpoints for all operations
- **Frontend**: Modern JavaScript with async/await patterns

## Security

- Access restricted to authenticated admin users
- CSRF protection on all forms
- Input validation on all endpoints
- Session-based cash handling accountability

## Development

Built following Bagisto's modular architecture:
- PSR-4 autoloading
- Laravel service providers
- Blade templating
- RESTful API design
- Responsive CSS framework

## Support

For issues and feature requests, please refer to the main project repository or contact the development team.

## License

MIT License - Same as Bagisto core.