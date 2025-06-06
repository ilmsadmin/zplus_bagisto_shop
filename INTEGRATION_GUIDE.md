# Bagisto Next.js GraphQL Integration

This document outlines the complete integration of Bagisto Laravel backend with Next.js frontend using GraphQL.

## Architecture Overview

```
┌─────────────────┐    GraphQL     ┌─────────────────┐
│   Next.js       │───────────────▶│   Bagisto       │
│   Frontend      │◀───────────────│   Laravel       │
│   (Port 3000)   │    /graphql    │   (Port 8000)   │
└─────────────────┘                └─────────────────┘
        │                                    │
        │                                    │
        ▼                                    ▼
┌─────────────────┐                ┌─────────────────┐
│   React         │                │   MySQL/SQLite  │
│   TypeScript    │                │   Database      │
│   Tailwind CSS  │                │                 │
└─────────────────┘                └─────────────────┘
```

## Implementation Details

### Backend (Laravel/Bagisto)

#### Dependencies Added
- `nuwave/lighthouse` - GraphQL server for Laravel
- Configured in `config/lighthouse.php`
- Service provider registered in `bootstrap/providers.php`

#### GraphQL Schema Structure
```
graphql/
├── schema.graphql          # Main schema with queries/mutations
├── product.graphql         # Product types and variants
├── category.graphql        # Category hierarchy
├── cart.graphql           # Shopping cart operations
├── customer.graphql       # Customer authentication
├── core.graphql           # Common types (Image, SEO, etc.)
└── checkout.graphql       # Checkout process
```

#### Resolvers Implemented
```
app/GraphQL/
├── Queries/
│   ├── ProductQuery.php           # Product listings
│   ├── HomeCategoriesQuery.php    # Category hierarchies
│   ├── CartQuery.php              # Cart state
│   ├── CustomerQuery.php          # Customer data
│   ├── CountriesQuery.php         # Available countries
│   ├── PaymentMethodsQuery.php    # Payment options
│   └── ShippingMethodsQuery.php   # Shipping methods
└── Mutations/
    ├── CustomerLoginMutation.php       # Authentication
    ├── CustomerRegisterMutation.php    # Registration
    ├── CreateCartMutation.php          # Cart initialization
    ├── AddToCartMutation.php           # Add to cart
    ├── UpdateCartItemsMutation.php     # Update quantities
    ├── RemoveFromCartMutation.php      # Remove items
    ├── SaveShippingAddressMutation.php # Checkout address
    ├── SaveShippingMethodMutation.php  # Shipping selection
    ├── SavePaymentMethodMutation.php   # Payment selection
    └── PlaceOrderMutation.php          # Order completion
```

### Frontend (Next.js)

#### Existing GraphQL Client
- Pre-configured GraphQL client in `lib/bagisto/`
- Comprehensive query and mutation definitions
- TypeScript types for all GraphQL operations
- Authentication handling with NextAuth.js

#### Key Features
- Server-side rendering (SSR) support
- Product browsing and search
- Shopping cart management
- Customer authentication
- Checkout process
- Order management

## GraphQL Operations

### Products
```graphql
# Get products with filtering and sorting
query GetProducts($sortKey: ProductSortKeys, $reverse: Boolean, $query: String) {
  products(sortKey: $sortKey, reverse: $reverse, query: $query, first: 100) {
    edges {
      node {
        id
        name
        urlKey
        priceRange {
          minVariantPrice {
            amount
            currencyCode
          }
        }
        featuredImage {
          url
        }
      }
    }
  }
}
```

### Categories
```graphql
# Get category hierarchy
query HomeCategories {
  homeCategories(input: [
    { key: "parent_id", value: "1" }
    { key: "status", value: "1" }
  ]) {
    id
    name
    slug
    children {
      id
      name
      slug
    }
  }
}
```

### Authentication
```graphql
# Customer login
mutation CustomerLogin($input: CustomerLoginInput!) {
  customerLogin(input: $input) {
    success
    accessToken
    customer {
      firstName
      lastName
      email
    }
  }
}
```

### Cart Operations
```graphql
# Add product to cart
mutation AddToCart($input: AddToCartInput!) {
  addToCart(input: $input) {
    success
    message
    cart {
      id
      itemsCount
      grandTotal
      items {
        id
        quantity
        product {
          name
          priceRange {
            minVariantPrice {
              amount
            }
          }
        }
      }
    }
  }
}
```

### Checkout Process
```graphql
# Save shipping address
mutation SaveShippingAddress($input: ShippingAddressInput!) {
  saveShippingAddress(input: $input) {
    success
    jumpToSection
  }
}

# Place order
mutation PlaceOrder {
  placeOrder {
    success
    redirectUrl
    order {
      id
      customerEmail
    }
  }
}
```

## Configuration

### Backend Environment (.env)
```env
APP_URL=http://localhost:8000
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite

# GraphQL endpoint will be available at:
# http://localhost:8000/graphql
```

### Frontend Environment (.env.local)
```env
BAGISTO_PROTOCOL="http://"
BAGISTO_STORE_DOMAIN="localhost:8000"
NEXTAUTH_SECRET="your-secret-here"
NEXTAUTH_URL="http://localhost:3000"
```

### CORS Configuration
Updated `config/cors.php` to include GraphQL endpoint:
```php
'paths' => ['api/*', 'sanctum/csrf-cookie', 'graphql'],
```

## Authentication Flow

1. **Customer Login**: GraphQL mutation generates Sanctum token
2. **Token Storage**: Frontend stores token in NextAuth session
3. **Authenticated Requests**: Token included in GraphQL request headers
4. **Cart Association**: Cart linked to authenticated customer

## Data Mapping

### Bagisto Models → GraphQL Types
- `Product` → Product type with variants, pricing, images
- `Category` → Category type with hierarchy support
- `Cart` → Cart type with items and totals
- `Customer` → Customer type with addresses and orders
- `Order` → Order type with items and status

### Key Resolvers Logic
- **Products**: Integrates with existing Bagisto product repository
- **Categories**: Supports nested category structures
- **Cart**: Uses Bagisto's cart facade for operations
- **Authentication**: Leverages Sanctum for token-based auth
- **Checkout**: Maps to Bagisto's checkout process

## Testing

### GraphQL Playground
Access at `http://localhost:8000/graphql-playground` for interactive testing.

### Frontend Integration
```bash
cd frontend-nextjs
npm run dev
# Visit http://localhost:3000
```

### Example Queries
See `GRAPHQL_SETUP.md` for comprehensive testing examples.

## Deployment Considerations

### Production Setup
1. **Database**: Configure MySQL/PostgreSQL for production
2. **CORS**: Restrict origins to frontend domain
3. **Rate Limiting**: Add GraphQL query complexity limits
4. **Caching**: Enable Laravel response caching
5. **SSL**: Ensure HTTPS for production

### Performance Optimization
- Enable GraphQL query caching
- Implement DataLoader for N+1 query prevention
- Use Laravel Octane for improved performance
- Configure Redis for session/cache storage

## Troubleshooting

### Common Issues
1. **CORS Errors**: Ensure GraphQL path is in CORS config
2. **Authentication**: Verify Sanctum configuration
3. **Schema Errors**: Check GraphQL schema syntax
4. **Database**: Ensure migrations are run

### Debug Mode
Enable in `config/lighthouse.php`:
```php
'debug' => env('LIGHTHOUSE_DEBUG', true),
```

## Future Enhancements

1. **Subscriptions**: Real-time cart updates
2. **File Uploads**: Product image uploads via GraphQL
3. **Admin Operations**: GraphQL mutations for admin tasks
4. **Multi-store**: Support for multiple store configurations
5. **Caching**: Advanced caching strategies for better performance