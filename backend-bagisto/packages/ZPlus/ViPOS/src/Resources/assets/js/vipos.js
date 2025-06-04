// ViPOS JavaScript functionality
export class ViPOS {
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
        document.getElementById('product-search')?.addEventListener('input', (e) => {
            this.searchProducts(e.target.value);
        });
        
        // Customer search  
        document.getElementById('customer-search')?.addEventListener('input', (e) => {
            this.searchCustomers(e.target.value);
        });
        
        // Checkout
        document.getElementById('checkout-btn')?.addEventListener('click', () => {
            this.openCheckoutModal();
        });
        
        // Modal events
        document.getElementById('cancel-checkout')?.addEventListener('click', () => {
            this.closeCheckoutModal();
        });
        
        document.getElementById('complete-payment')?.addEventListener('click', () => {
            this.completePayment();
        });
        
        // Payment amount change
        document.getElementById('amount-received')?.addEventListener('input', (e) => {
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
        if (!container) return;
        
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
        document.querySelector(`[data-category="${categoryId}"]`)?.classList.add('active');
        
        this.loadProducts();
    }
    
    async loadProducts() {
        const loading = document.getElementById('products-loading');
        const grid = document.getElementById('products-grid');
        
        if (loading) loading.classList.remove('hidden');
        if (grid) grid.innerHTML = '';
        
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
            if (loading) loading.classList.add('hidden');
        }
    }
    
    renderProducts() {
        const grid = document.getElementById('products-grid');
        const count = document.getElementById('products-count');
        
        if (count) count.textContent = this.products.length;
        if (!grid) return;
        
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
    
    renderCart() {
        const container = document.getElementById('cart-items');
        const checkoutBtn = document.getElementById('checkout-btn');
        
        if (!container) return;
        
        if (this.cart.length === 0) {
            container.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <p>Cart is empty</p>
                    <p class="text-sm">Add products to start a transaction</p>
                </div>
            `;
            if (checkoutBtn) checkoutBtn.disabled = true;
        } else {
            container.innerHTML = this.cart.map(item => `
                <div class="cart-item flex justify-between items-center">
                    <div class="flex-1">
                        <p class="font-medium">${item.name}</p>
                        <p class="text-sm text-gray-600">$${item.price.toFixed(2)} each</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center" onclick="window.vipos?.updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                        <span class="w-8 text-center">${item.quantity}</span>
                        <button class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center" onclick="window.vipos?.updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                    </div>
                    <div class="w-20 text-right">
                        <p class="font-bold">$${(item.price * item.quantity).toFixed(2)}</p>
                    </div>
                </div>
            `).join('');
            
            if (checkoutBtn) checkoutBtn.disabled = !this.selectedCustomer;
        }
        
        this.updateTotals();
    }
    
    updateTotals() {
        const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const taxRate = 0.0; // TODO: Get from config
        const tax = subtotal * taxRate;
        const total = subtotal + tax;
        
        const subtotalEl = document.getElementById('cart-subtotal');
        const taxEl = document.getElementById('cart-tax');
        const totalEl = document.getElementById('cart-total');
        
        if (subtotalEl) subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
        if (taxEl) taxEl.textContent = `$${tax.toFixed(2)}`;
        if (totalEl) totalEl.textContent = `$${total.toFixed(2)}`;
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
        
        const totalInput = document.getElementById('payment-total');
        if (totalInput) totalInput.value = `$${total.toFixed(2)}`;
        if (modal) modal.classList.remove('hidden');
    }
    
    closeCheckoutModal() {
        const modal = document.getElementById('checkout-modal');
        if (modal) modal.classList.add('hidden');
    }
    
    calculateChange() {
        const total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const received = parseFloat(document.getElementById('amount-received')?.value) || 0;
        const change = received - total;
        
        const changeEl = document.getElementById('change-amount');
        if (changeEl) changeEl.textContent = `$${Math.max(0, change).toFixed(2)}`;
    }
    
    async completePayment() {
        if (!this.selectedCustomer) {
            alert('Please select a customer');
            return;
        }
        
        const paymentMethod = document.getElementById('payment-method')?.value;
        const total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        
        try {
            const response = await fetch('/api/vipos/orders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
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