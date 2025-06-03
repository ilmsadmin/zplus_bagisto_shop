# Frontend Next.js Commerce - Bagisto Integration

## Giới thiệu
Frontend này sử dụng Next.js Commerce được tích hợp với Bagisto backend, cung cấp trải nghiệm mua sắm hiện đại và nhanh chóng.

## Tính năng chính
- ✅ Server-Side Rendering (SSR) với Next.js
- ✅ Modern React Components
- ✅ Responsive Design
- ✅ Shopping Cart Functionality
- ✅ Product Catalog
- ✅ Customer Authentication
- ✅ Checkout Process
- ✅ Search Functionality
- ✅ SEO Optimized
- ✅ Performance Optimized
- ✅ Mobile-First Design
- ✅ TypeScript Support

## Công nghệ sử dụng
- **Next.js 14** - React Framework với App Router
- **React 18** - Frontend Library
- **TypeScript** - Type Safety
- **Tailwind CSS** - Styling Framework
- **Headless UI** - UI Components
- **SWR** - Data Fetching
- **Framer Motion** - Animations

## Yêu cầu hệ thống
- Node.js >= 18.0
- npm hoặc yarn
- Backend Bagisto đã setup

## Cài đặt và Cấu hình

### 1. Cài đặt dependencies
```bash
npm install
# hoặc
yarn install
```

### 2. Cấu hình Environment Variables
```bash
# Copy file .env.example thành .env.local
cp .env.example .env.local

# Chỉnh sửa .env.local
NEXT_PUBLIC_BAGISTO_API_URL=http://localhost:8000/api/v1
NEXT_PUBLIC_BAGISTO_BASE_URL=http://localhost:8000
NEXTAUTH_SECRET=your-secret-key
NEXTAUTH_URL=http://localhost:3000
```

### 3. Khởi chạy Development Server
```bash
npm run dev
# hoặc
yarn dev
```

Truy cập: http://localhost:3000

### 4. Build for Production
```bash
npm run build
npm start
# hoặc
yarn build
yarn start
```

## Cấu trúc thư mục
```
frontend-nextjs/
├── app/                    # Next.js App Router
│   ├── globals.css        # Global styles
│   ├── layout.tsx         # Root layout
│   ├── page.tsx          # Home page
│   ├── product/          # Product pages
│   ├── cart/             # Cart pages
│   └── checkout/         # Checkout pages
├── components/            # React components
│   ├── ui/               # UI components
│   ├── cart/             # Cart components
│   ├── product/          # Product components
│   └── layout/           # Layout components
├── lib/                  # Utility functions
│   ├── bagisto.ts        # Bagisto API client
│   ├── utils.ts          # Helper functions
│   └── constants.ts      # Constants
├── public/               # Static assets
├── types/                # TypeScript types
└── styles/               # CSS styles
```

## API Integration với Bagisto

### Endpoints chính:
- **Products**: `/api/v1/products`
- **Categories**: `/api/v1/categories`
- **Cart**: `/api/v1/customer/cart`
- **Checkout**: `/api/v1/customer/checkout`
- **Customer**: `/api/v1/customer`

### Ví dụ sử dụng API:
```typescript
import { bagistoClient } from '@/lib/bagisto';

// Lấy danh sách sản phẩm
const products = await bagistoClient.getProducts();

// Thêm sản phẩm vào giỏ hàng
await bagistoClient.addToCart(productId, quantity);

// Lấy thông tin giỏ hàng
const cart = await bagistoClient.getCart();
```

## Customization

### Thay đổi Theme
- Chỉnh sửa `tailwind.config.js` để thay đổi colors, fonts
- Update `app/globals.css` cho custom styles

### Thêm Components
- Tạo components mới trong thư mục `components/`
- Sử dụng TypeScript interfaces trong `types/`

### Cấu hình SEO
- Chỉnh sửa metadata trong `app/layout.tsx`
- Thêm Open Graph tags trong từng page

## Scripts Available
```bash
npm run dev          # Start development server
npm run build        # Build for production
npm run start        # Start production server
npm run lint         # Run ESLint
npm run type-check   # Run TypeScript check
```

## Performance Optimization
- Image optimization với Next.js Image component
- Code splitting tự động
- Static generation cho performance tốt hơn
- Lazy loading components

## Deployment
- Vercel (Recommended)
- Netlify
- AWS Amplify
- Self-hosted với PM2

## Tích hợp với Backend
Frontend này được thiết kế để hoạt động với:
- Bagisto Laravel Backend (Port 8000)
- RESTful API endpoints
- Authentication tokens
- Real-time cart updates

## Hỗ trợ
- [Next.js Documentation](https://nextjs.org/docs)
- [Bagisto API Docs](https://devdocs.bagisto.com/)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
