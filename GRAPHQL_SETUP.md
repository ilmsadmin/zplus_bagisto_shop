# GraphQL Schema Testing Instructions

## Backend Setup

1. **Install Dependencies:**
   ```bash
   cd backend-bagisto
   composer install
   ```

2. **Configure Environment:**
   ```bash
   cp .env.example .env
   # Update database settings in .env
   ```

3. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

4. **Run Migrations:**
   ```bash
   php artisan migrate --seed
   ```

5. **Start Server:**
   ```bash
   php artisan serve --port=8000
   ```

## Frontend Setup

1. **Install Dependencies:**
   ```bash
   cd frontend-nextjs
   npm install
   ```

2. **Configure Environment:**
   ```bash
   cp .env.example .env.local
   # Update BAGISTO_STORE_DOMAIN=localhost:8000
   ```

3. **Start Development Server:**
   ```bash
   npm run dev
   ```

## Testing GraphQL Endpoint

1. **Access GraphQL Playground:**
   Visit: `http://localhost:8000/graphql-playground`

2. **Test Basic Query:**
   ```graphql
   query {
     products(first: 5) {
       edges {
         node {
           id
           name
           priceRange {
             minVariantPrice {
               amount
               currencyCode
             }
           }
         }
       }
     }
   }
   ```

3. **Test Authentication:**
   ```graphql
   mutation {
     customerLogin(input: {
       email: "test@example.com"
       password: "password"
     }) {
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

4. **Test Cart Operations:**
   ```graphql
   mutation {
     addToCart(input: {
       productId: "1"
       quantity: 1
     }) {
       success
       message
       cart {
         id
         itemsCount
         grandTotal
       }
     }
   }
   ```

## Expected Results

- GraphQL endpoint should be available at `/graphql`
- Frontend should be able to fetch products, categories, and handle cart operations
- Authentication should work with token-based auth
- Checkout process should be functional through GraphQL mutations

## Schema Files Created

- `graphql/schema.graphql` - Main schema with queries and mutations
- `graphql/product.graphql` - Product types and related entities
- `graphql/category.graphql` - Category types and filtering
- `graphql/cart.graphql` - Cart operations and types
- `graphql/customer.graphql` - Customer authentication and data
- `graphql/core.graphql` - Common types and utilities
- `graphql/checkout.graphql` - Checkout process types

## Resolvers Created

### Queries:
- `ProductQuery` - Handle product listings and filtering
- `HomeCategoriesQuery` - Handle category hierarchies
- `CartQuery` - Get current cart state
- `CustomerQuery` - Get authenticated customer data
- `CountriesQuery` - Get available countries
- `PaymentMethodsQuery` - Get payment options
- `ShippingMethodsQuery` - Get shipping options

### Mutations:
- `CustomerLoginMutation` - Customer authentication
- `CustomerRegisterMutation` - Customer registration
- `CreateCartMutation` - Initialize cart
- `AddToCartMutation` - Add products to cart
- `UpdateCartItemsMutation` - Update cart quantities
- `RemoveFromCartMutation` - Remove items from cart
- `SaveShippingAddressMutation` - Save checkout address
- `SaveShippingMethodMutation` - Select shipping method
- `SavePaymentMethodMutation` - Select payment method
- `PlaceOrderMutation` - Complete order placement