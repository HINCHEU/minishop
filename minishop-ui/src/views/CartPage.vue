<template>
  <div class="cart-container">
    <div class="container py-4">
      <!-- Header -->
      <div class="cart-header">
        <h1 class="page-title">Shopping Cart</h1>
        <p class="page-subtitle">Review your items before checkout</p>
      </div>
      
      <!-- Empty Cart State -->
      <div v-if="cartStore.items.length === 0" class="empty-cart">
        <div class="empty-icon">
          <i class="bi bi-cart3"></i>
        </div>
        <h3 class="empty-title">Your cart is empty</h3>
        <p class="empty-subtitle">Looks like you haven't added anything yet</p>
        <router-link to="/" class="btn btn-modern-primary">
          <i class="bi bi-arrow-left me-2"></i>
          Continue Shopping
        </router-link>
      </div>
      
      <!-- Cart Items -->
      <div v-else class="cart-content">
        <!-- Items List -->
        <div class="cart-items">
          <div v-for="item in cartStore.items" :key="item.product_id" class="cart-item">
            <div class="item-image">
              <img 
                :src="item.image_url || 'https://via.placeholder.com/100'" 
                :alt="item.name"
              >
            </div>
            
            <div class="item-details">
              <h4 class="item-name">{{ item.name }}</h4>
              <p class="item-price">${{ parseFloat(item.price).toFixed(2) }}</p>
            </div>
            
            <div class="item-quantity">
              <button 
                class="qty-btn"
                @click="updateQuantity(item.product_id, item.quantity - 1)"
                title="Decrease quantity"
              >
                <i class="bi bi-dash-lg"></i>
              </button>
              <input 
                type="number" 
                class="qty-input"
                :value="item.quantity"
                @input="updateQuantity(item.product_id, parseInt($event.target.value))"
                min="1"
              >
              <button 
                class="qty-btn"
                @click="updateQuantity(item.product_id, item.quantity + 1)"
                title="Increase quantity"
              >
                <i class="bi bi-plus-lg"></i>
              </button>
            </div>
            
            <div class="item-total">
              <p class="total-price">${{ (item.price * item.quantity).toFixed(2) }}</p>
            </div>
            
            <button 
              class="remove-btn"
              @click="removeItem(item.product_id)"
              title="Remove from cart"
            >
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </div>
        
        <!-- Order Summary Sidebar -->
        <div class="order-summary">
          <div class="summary-card">
            <h3 class="summary-title">Order Summary</h3>
            
            <div class="summary-row">
              <span>Subtotal</span>
              <span class="amount">${{ cartStore.getTotal().toFixed(2) }}</span>
            </div>
            
            <div class="summary-row">
              <span>Shipping</span>
              <span class="amount amount-free">Free</span>
            </div>
            
            <div class="summary-divider"></div>
            
            <div class="summary-total">
              <span>Total</span>
              <span class="total-amount">${{ cartStore.getTotal().toFixed(2) }}</span>
            </div>
            
            <router-link to="/checkout" class="btn-checkout">
              <i class="bi bi-credit-card me-2"></i>
              Proceed to Checkout
            </router-link>
            
            <router-link to="/" class="btn-continue">
              <i class="bi bi-arrow-left me-2"></i>
              Continue Shopping
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { cartStore } from '../stores/cart'

export default {
  name: 'CartPage',
  setup() {
    const updateQuantity = (productId, quantity) => {
      if (quantity > 0) {
        cartStore.updateQuantity(productId, quantity)
      }
    }
    
    const removeItem = (productId) => {
      cartStore.removeItem(productId)
    }
    
    return {
      cartStore,
      updateQuantity,
      removeItem
    }
  }
}
</script>

<style scoped>
.cart-container {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
  padding-bottom: 40px;
}

.cart-header {
  text-align: center;
  margin-bottom: 40px;
  animation: fadeInDown 0.6s ease-out;
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.page-title {
  font-size: 2.5rem;
  font-weight: 800;
  background: linear-gradient(135deg, #1a1f71 0%, #0d47a1 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 10px;
  letter-spacing: -0.5px;
}

.page-subtitle {
  color: #666;
  font-size: 1rem;
  margin: 0;
  font-weight: 300;
}

/* Empty Cart */
.empty-cart {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 80px 20px;
  text-align: center;
  animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.empty-icon {
  font-size: 5rem;
  color: #b0bec5;
  margin-bottom: 20px;
}

.empty-title {
  font-size: 1.5rem;
  color: #1a1f71;
  font-weight: 700;
  margin-bottom: 10px;
}

.empty-subtitle {
  color: #888;
  margin-bottom: 30px;
  font-size: 1rem;
}

.btn-modern-primary {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
  padding: 12px 28px;
  border-radius: 8px;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-modern-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(13, 71, 161, 0.3);
}

/* Cart Content */
.cart-content {
  display: grid;
  grid-template-columns: 1fr 380px;
  gap: 30px;
}

.cart-items {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.cart-item {
  background: white;
  border-radius: 12px;
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 20px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border-left: 4px solid transparent;
  animation: slideIn 0.4s ease-out;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(-20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

.cart-item:hover {
  box-shadow: 0 8px 24px rgba(13, 71, 161, 0.15);
  border-left-color: #0d47a1;
  transform: translateX(4px);
}

.item-image {
  flex-shrink: 0;
}

.item-image img {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 8px;
  transition: transform 0.3s ease-out;
}

.cart-item:hover .item-image img {
  transform: scale(1.05);
}

.item-details {
  flex: 1;
  min-width: 150px;
}

.item-name {
  font-size: 1rem;
  font-weight: 700;
  color: #1a1f71;
  margin: 0 0 8px 0;
}

.item-price {
  color: #0d47a1;
  font-weight: 600;
  margin: 0;
  font-size: 1.1rem;
}

.item-quantity {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #f5f7fa;
  border-radius: 8px;
  padding: 4px 8px;
}

.qty-btn {
  width: 32px;
  height: 32px;
  border: none;
  background: white;
  border-radius: 6px;
  color: #0d47a1;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
  font-weight: 600;
}

.qty-btn:hover {
  background: #0d47a1;
  color: white;
  transform: scale(1.1);
}

.qty-input {
  width: 45px;
  border: none;
  background: transparent;
  text-align: center;
  font-weight: 600;
  color: #1a1f71;
  font-size: 1rem;
}

.qty-input:focus {
  outline: none;
}

.item-total {
  min-width: 100px;
  text-align: right;
}

.total-price {
  font-size: 1.2rem;
  font-weight: 800;
  color: #0d47a1;
  margin: 0;
}

.remove-btn {
  width: 40px;
  height: 40px;
  border: 2px solid #ffebee;
  background: white;
  border-radius: 8px;
  color: #d32f2f;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  font-size: 1rem;
}

.remove-btn:hover {
  background: #d32f2f;
  color: white;
  border-color: #d32f2f;
  transform: scale(1.1);
}

/* Order Summary */
.order-summary {
  position: sticky;
  top: 90px;
}

.summary-card {
  background: white;
  border-radius: 12px;
  padding: 28px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  animation: slideUp 0.5s ease-out;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.summary-title {
  font-size: 1.3rem;
  font-weight: 700;
  color: #1a1f71;
  margin: 0 0 24px 0;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 0;
  color: #666;
  font-weight: 500;
}

.summary-row .amount {
  color: #1a1f71;
  font-weight: 600;
}

.amount-free {
  color: #4caf50;
  font-weight: 600;
}

.summary-divider {
  height: 2px;
  background: #f0f0f0;
  margin: 20px 0;
}

.summary-total {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 0;
  font-size: 1.1rem;
  font-weight: 700;
  color: #1a1f71;
}

.total-amount {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  font-size: 1.4rem;
}

.btn-checkout,
.btn-continue {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 14px 20px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  margin-top: 16px;
}

.btn-checkout {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
  border: none;
}

.btn-checkout:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(13, 71, 161, 0.3);
  filter: brightness(1.1);
}

.btn-continue {
  background: #f5f7fa;
  color: #0d47a1;
  border: 2px solid #e0e7ff;
}

.btn-continue:hover {
  background: #e0e7ff;
  transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
  .page-title {
    font-size: 1.8rem;
  }

  .cart-content {
    grid-template-columns: 1fr;
  }

  .order-summary {
    position: static;
  }

  .cart-item {
    flex-wrap: wrap;
    gap: 12px;
  }

  .item-details {
    order: 3;
    flex-basis: 100%;
  }

  .item-quantity {
    order: 4;
    justify-content: center;
  }

  .item-total {
    order: 5;
    text-align: center;
    flex-basis: 100%;
  }

  .remove-btn {
    order: 6;
  }
}
</style>