<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ViPOS - Point of Sale</title>
    
    <!-- Tailwind CSS CDN for now -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .pos-container {
            height: 100vh;
            overflow: hidden;
        }
        
        .pos-left {
            height: 100vh;
            overflow-y: auto;
        }
        
        .pos-right {
            height: 100vh;
            overflow-y: auto;
        }
        
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .product-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .product-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .cart-item {
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 0;
        }
        
        .category-button {
            white-space: nowrap;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .category-button:hover,
        .category-button.active {
            background: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="pos-container flex">
        <!-- Left Section - Cart and Checkout -->
        <div class="pos-left w-1/2 bg-white border-r border-gray-200">
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800">ViPOS</h1>
                <p class="text-sm text-gray-600">Point of Sale System</p>
            </div>
            
            <!-- Product Search -->
            <div class="p-4 border-b border-gray-200">
                <input 
                    type="text" 
                    id="product-search"
                    placeholder="Search products by name, SKU, or barcode..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
            
            <!-- Shopping Cart -->
            <div class="flex-1 p-4">
                <h2 class="text-lg font-semibold mb-4">Shopping Cart</h2>
                <div id="cart-items" class="mb-4">
                    <div class="text-center text-gray-500 py-8">
                        <p>Cart is empty</p>
                        <p class="text-sm">Add products to start a transaction</p>
                    </div>
                </div>
                
                <!-- Cart Totals -->
                <div class="border-t pt-4">
                    <div class="flex justify-between mb-2">
                        <span>Subtotal:</span>
                        <span id="cart-subtotal">$0.00</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Tax:</span>
                        <span id="cart-tax">$0.00</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2">
                        <span>Total:</span>
                        <span id="cart-total">$0.00</span>
                    </div>
                </div>
                
                <!-- Checkout Button -->
                <button 
                    id="checkout-btn"
                    class="w-full mt-4 bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed"
                    disabled
                >
                    Checkout
                </button>
            </div>
        </div>
        
        <!-- Right Section - Products and Customers -->
        <div class="pos-right w-1/2 bg-gray-50">
            <!-- Customer Section -->
            <div class="p-4 bg-white border-b border-gray-200">
                <h2 class="text-lg font-semibold mb-3">Customer</h2>
                <div class="flex gap-2 mb-3">
                    <input 
                        type="text" 
                        id="customer-search"
                        placeholder="Search customer by name, email, or phone..."
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    <button 
                        id="new-customer-btn"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700"
                    >
                        New
                    </button>
                </div>
                <div id="selected-customer" class="hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                        <p class="font-medium" id="customer-name"></p>
                        <p class="text-sm text-gray-600" id="customer-email"></p>
                        <p class="text-sm text-gray-600" id="customer-phone"></p>
                    </div>
                </div>
            </div>
            
            <!-- Categories -->
            <div class="p-4 border-b border-gray-200 bg-white">
                <h3 class="text-md font-semibold mb-3">Categories</h3>
                <div class="flex gap-2 overflow-x-auto pb-2" id="categories-container">
                    <button class="category-button active" data-category="">All</button>
                    <!-- Categories will be loaded here -->
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-md font-semibold">Products</h3>
                    <div class="text-sm text-gray-600">
                        <span id="products-count">0</span> products
                    </div>
                </div>
                <div id="products-grid" class="product-grid">
                    <!-- Products will be loaded here -->
                </div>
                
                <!-- Loading indicator -->
                <div id="products-loading" class="hidden text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <p class="mt-2 text-gray-600">Loading products...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div id="checkout-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-96 max-w-full">
            <h3 class="text-lg font-semibold mb-4">Complete Payment</h3>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Payment Method</label>
                <select id="payment-method" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="upi">UPI</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Total Amount</label>
                <input 
                    type="text" 
                    id="payment-total"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100"
                    readonly
                >
            </div>
            
            <div id="cash-payment" class="mb-4">
                <label class="block text-sm font-medium mb-2">Amount Received</label>
                <input 
                    type="number" 
                    id="amount-received"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md"
                    step="0.01"
                >
                <div class="mt-2 text-sm">
                    Change: <span id="change-amount" class="font-semibold">$0.00</span>
                </div>
            </div>
            
            <div class="flex gap-2">
                <button 
                    id="cancel-checkout"
                    class="flex-1 bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600"
                >
                    Cancel
                </button>
                <button 
                    id="complete-payment"
                    class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700"
                >
                    Complete
                </button>
            </div>
        </div>
    </div>

    <script>
        // ViPOS JavaScript functionality
        class ViPOS {
            constructor() {
                this.cart = [];
                this.selectedCustomer = null;
                this.currentCategory = '';
                this.products = [];
                this.categories = [];
                
                this.init();
            }
            
            init() {
                this.setupEventListeners();
                this.loadCategories();
                this.loadProducts();
            }
            
            setupEventListeners() {
                // Product search
                document.getElementById('product-search').addEventListener('input', (e) => {
                    this.searchProducts(e.target.value);
                });
                
                // Customer search  
                document.getElementById('customer-search').addEventListener('input', (e) => {
                    this.searchCustomers(e.target.value);
                });
                
                // Checkout
                document.getElementById('checkout-btn').addEventListener('click', () => {
                    this.openCheckoutModal();
                });
                
                // Modal events
                document.getElementById('cancel-checkout').addEventListener('click', () => {
                    this.closeCheckoutModal();
                });
                
                document.getElementById('complete-payment').addEventListener('click', () => {
                    this.completePayment();
                });
                
                // Payment amount change
                document.getElementById('amount-received').addEventListener('input', (e) => {
                    this.calculateChange();
                });
            }
            
            async loadCategories() {
                try {
                    const response = await fetch('/api/vipos/products/categories');
                    const data = await response.json();
                    this.categories = data.data;
                    this.renderCategories();
                } catch (error) {
                    console.error('Error loading categories:', error);
                }
            }
            
            renderCategories() {
                const container = document.getElementById('categories-container');
                const allButton = container.querySelector('[data-category=""]');
                
                this.categories.forEach(category => {
                    const button = document.createElement('button');
                    button.className = 'category-button';
                    button.textContent = category.name;
                    button.dataset.category = category.id;
                    button.addEventListener('click', () => this.selectCategory(category.id));
                    container.appendChild(button);
                });
            }
            
            selectCategory(categoryId) {
                this.currentCategory = categoryId;
                
                // Update active button
                document.querySelectorAll('.category-button').forEach(btn => {
                    btn.classList.remove('active');
                });
                document.querySelector(`[data-category="${categoryId}"]`).classList.add('active');
                
                this.loadProducts();
            }
            
            async loadProducts() {
                const loading = document.getElementById('products-loading');
                const grid = document.getElementById('products-grid');
                
                loading.classList.remove('hidden');
                grid.innerHTML = '';
                
                try {
                    const params = new URLSearchParams();
                    if (this.currentCategory) {
                        params.append('category_id', this.currentCategory);
                    }
                    
                    const response = await fetch(`/api/vipos/products?${params}`);
                    const data = await response.json();
                    this.products = data.data;
                    this.renderProducts();
                } catch (error) {
                    console.error('Error loading products:', error);
                } finally {
                    loading.classList.add('hidden');
                }
            }
            
            renderProducts() {
                const grid = document.getElementById('products-grid');
                const count = document.getElementById('products-count');
                
                count.textContent = this.products.length;
                
                this.products.forEach(product => {
                    const card = document.createElement('div');
                    card.className = 'product-card';
                    card.innerHTML = `
                        <div class="text-center">
                            <div class="w-full h-32 bg-gray-200 rounded mb-2 flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                            <h4 class="font-medium text-sm mb-1">${product.name}</h4>
                            <p class="text-xs text-gray-600 mb-2">SKU: ${product.sku}</p>
                            <p class="font-bold text-blue-600">$${product.price || '0.00'}</p>
                        </div>
                    `;
                    card.addEventListener('click', () => this.addToCart(product));
                    grid.appendChild(card);
                });
            }
            
            addToCart(product) {
                const existingItem = this.cart.find(item => item.id === product.id);
                
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    this.cart.push({
                        id: product.id,
                        name: product.name,
                        sku: product.sku,
                        price: parseFloat(product.price || 0),
                        quantity: 1
                    });
                }
                
                this.renderCart();
            }
            
            renderCart() {
                const container = document.getElementById('cart-items');
                const checkoutBtn = document.getElementById('checkout-btn');
                
                if (this.cart.length === 0) {
                    container.innerHTML = `
                        <div class="text-center text-gray-500 py-8">
                            <p>Cart is empty</p>
                            <p class="text-sm">Add products to start a transaction</p>
                        </div>
                    `;
                    checkoutBtn.disabled = true;
                } else {
                    container.innerHTML = this.cart.map(item => `
                        <div class="cart-item flex justify-between items-center">
                            <div class="flex-1">
                                <p class="font-medium">${item.name}</p>
                                <p class="text-sm text-gray-600">$${item.price.toFixed(2)} each</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center" onclick="vipos.updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                                <span class="w-8 text-center">${item.quantity}</span>
                                <button class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center" onclick="vipos.updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                            </div>
                            <div class="w-20 text-right">
                                <p class="font-bold">$${(item.price * item.quantity).toFixed(2)}</p>
                            </div>
                        </div>
                    `).join('');
                    
                    checkoutBtn.disabled = !this.selectedCustomer;
                }
                
                this.updateTotals();
            }
            
            updateQuantity(productId, newQuantity) {
                if (newQuantity <= 0) {
                    this.cart = this.cart.filter(item => item.id !== productId);
                } else {
                    const item = this.cart.find(item => item.id === productId);
                    if (item) {
                        item.quantity = newQuantity;
                    }
                }
                this.renderCart();
            }
            
            updateTotals() {
                const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const taxRate = 0.0; // TODO: Get from config
                const tax = subtotal * taxRate;
                const total = subtotal + tax;
                
                document.getElementById('cart-subtotal').textContent = `$${subtotal.toFixed(2)}`;
                document.getElementById('cart-tax').textContent = `$${tax.toFixed(2)}`;
                document.getElementById('cart-total').textContent = `$${total.toFixed(2)}`;
            }
            
            async searchCustomers(query) {
                if (query.length < 2) return;
                
                try {
                    const response = await fetch(`/api/vipos/customers/search?query=${encodeURIComponent(query)}`);
                    const data = await response.json();
                    // TODO: Show customer suggestions
                } catch (error) {
                    console.error('Error searching customers:', error);
                }
            }
            
            openCheckoutModal() {
                const modal = document.getElementById('checkout-modal');
                const total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                
                document.getElementById('payment-total').value = `$${total.toFixed(2)}`;
                modal.classList.remove('hidden');
            }
            
            closeCheckoutModal() {
                document.getElementById('checkout-modal').classList.add('hidden');
            }
            
            calculateChange() {
                const total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const received = parseFloat(document.getElementById('amount-received').value) || 0;
                const change = received - total;
                
                document.getElementById('change-amount').textContent = `$${Math.max(0, change).toFixed(2)}`;
            }
            
            async completePayment() {
                if (!this.selectedCustomer) {
                    alert('Please select a customer');
                    return;
                }
                
                const paymentMethod = document.getElementById('payment-method').value;
                const total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                
                try {
                    const response = await fetch('/api/vipos/orders', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            customer_id: this.selectedCustomer.id,
                            items: this.cart.map(item => ({
                                product_id: item.id,
                                quantity: item.quantity,
                                price: item.price
                            })),
                            payment_method: paymentMethod,
                            payment_amount: total
                        })
                    });
                    
                    if (response.ok) {
                        alert('Order completed successfully!');
                        this.cart = [];
                        this.renderCart();
                        this.closeCheckoutModal();
                    } else {
                        alert('Error completing order');
                    }
                } catch (error) {
                    console.error('Error completing payment:', error);
                    alert('Error completing order');
                }
            }
        }
        
        // Initialize ViPOS
        const vipos = new ViPOS();
    </script>
</body>
</html>