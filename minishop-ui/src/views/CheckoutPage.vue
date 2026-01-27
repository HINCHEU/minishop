<template>
  <div class="checkout-container">
    <div class="container py-4">
      <!-- Progress Bar -->
      <div class="progress-section">
        <div class="progress-bar-wrapper">
          <div class="progress-step active">
            <div class="step-number">1</div>
            <span class="step-label">Cart</span>
          </div>
          <div class="progress-line"></div>
          <div class="progress-step active">
            <div class="step-number">2</div>
            <span class="step-label">Checkout</span>
          </div>
          <div class="progress-line"></div>
          <div class="progress-step">
            <div class="step-number">3</div>
            <span class="step-label">Confirmation</span>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="checkout-content">
        <!-- Checkout Form -->
        <div class="checkout-form-section">
          <div class="form-card">
            <div class="form-header">
              <h2 class="form-title">Shipping Information</h2>
              <p class="form-subtitle">Enter your details for delivery</p>
            </div>

            <form @submit.prevent="placeOrder" class="checkout-form">
              <!-- Full Name -->
              <div class="form-group">
                <label class="form-label">Full Name <span class="required">*</span></label>
                <div class="input-wrapper">
                  <i class="bi bi-person"></i>
                  <input 
                    type="text" 
                    class="form-input" 
                    v-model="formData.customer_name"
                    placeholder="John Doe"
                    required
                  >
                </div>
              </div>

              <!-- Email -->
              <div class="form-group">
                <label class="form-label">Email Address <span class="required">*</span></label>
                <div class="input-wrapper">
                  <i class="bi bi-envelope"></i>
                  <input 
                    type="email" 
                    class="form-input" 
                    v-model="formData.customer_email"
                    placeholder="john@example.com"
                    required
                  >
                </div>
              </div>

              <!-- Phone -->
              <div class="form-group">
                <label class="form-label">Phone Number <span class="required">*</span></label>
                <div class="input-wrapper">
                  <i class="bi bi-telephone"></i>
                  <input 
                    type="tel" 
                    class="form-input" 
                    v-model="formData.customer_phone"
                    placeholder="+1 (555) 000-0000"
                    required
                  >
                </div>
              </div>

              <!-- Address -->
              <div class="form-group">
                <label class="form-label">Shipping Address <span class="required">*</span></label>
                <textarea 
                  class="form-textarea" 
                  rows="4"
                  v-model="formData.shipping_address"
                  placeholder="123 Main Street, City, State 12345"
                  required
                ></textarea>
              </div>

              <!-- Action Buttons -->
              <div class="action-buttons">
                <router-link to="/cart" class="btn-secondary">
                  <i class="bi bi-arrow-left me-2"></i>
                  Back to Cart
                </router-link>
                <button type="submit" class="btn-primary" :disabled="submitting">
                  <i class="bi bi-check-circle me-2"></i>
                  {{ submitting ? 'Processing...' : 'Place Order' }}
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="summary-section">
          <div class="summary-card">
            <h3 class="summary-title">Order Summary</h3>
            
            <!-- Items List -->
            <div class="items-list">
              <div v-for="item in cartStore.items" :key="item.product_id" class="summary-item">
                <div class="item-info">
                  <span class="item-name">{{ item.name }}</span>
                  <span class="item-qty">x{{ item.quantity }}</span>
                </div>
                <span class="item-amount">${{ (item.price * item.quantity).toFixed(2) }}</span>
              </div>
            </div>

            <div class="summary-divider"></div>

            <!-- Summary Details -->
            <div class="summary-details">
              <div class="detail-row">
                <span>Subtotal</span>
                <span class="amount">${{ cartStore.getTotal().toFixed(2) }}</span>
              </div>
              <div class="detail-row">
                <span>Shipping</span>
                <span class="amount amount-free">FREE</span>
              </div>
              <div class="detail-row">
                <span>Tax</span>
                <span class="amount">$0.00</span>
              </div>
            </div>

            <div class="summary-divider"></div>

            <!-- Total -->
            <div class="summary-total">
              <span>Total Amount</span>
              <span class="total-amount">${{ cartStore.getTotal().toFixed(2) }}</span>
            </div>

            <!-- Security Badge -->
            <div class="security-badge">
              <i class="bi bi-shield-check"></i>
              <span>Secure & Encrypted Payment</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../services/api'
import { cartStore } from '../stores/cart'

export default {
  name: 'CheckoutPage',
  setup() {
    const router = useRouter()
    const submitting = ref(false)
    const formData = ref({
      customer_name: '',
      customer_email: '',
      customer_phone: '',
      shipping_address: ''
    })
    
    const placeOrder = async () => {
      if (!formData.value.customer_name || !formData.value.customer_email || 
          !formData.value.customer_phone || !formData.value.shipping_address) {
        alert('Please fill in all required fields')
        return
      }
      
      submitting.value = true
      
      try {
        const orderData = {
          ...formData.value,
          total_amount: cartStore.getTotal(),
          items: cartStore.items.map(item => ({
            product_id: item.product_id,
            quantity: item.quantity,
            unit_price: item.price,
            subtotal: item.price * item.quantity
          }))
        }
        
        const response = await api.createOrder(orderData)
        const orderData_response = response.data.order
        const totalAmount = orderData_response.total_amount || cartStore.getTotal()
        const orderId = orderData_response.order_id || 'N/A'
        cartStore.clearCart()
        router.push({ 
          name: 'order-confirmation',
          query: { 
            orderId: orderId,
            totalAmount: totalAmount
          }
        })
      } catch (error) {
        console.error('Error placing order:', error)
        alert('Error placing order. Please try again.')
      }
      
      submitting.value = false
    }
    
    return {
      cartStore,
      formData,
      submitting,
      placeOrder
    }
  }
}
</script>

<style scoped>
.checkout-container {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
  padding-bottom: 40px;
}

/* Progress Bar */
.progress-section {
  margin-bottom: 40px;
  animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.progress-bar-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
}

.progress-step {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
}

.step-number {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  transition: all 0.3s ease;
  background: #e0e7ff;
  color: #999;
}

.progress-step.active .step-number {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(13, 71, 161, 0.3);
}

.step-label {
  font-size: 0.85rem;
  font-weight: 600;
  color: #999;
}

.progress-step.active .step-label {
  color: #0d47a1;
}

.progress-line {
  width: 60px;
  height: 3px;
  background: #e0e7ff;
  margin-top: 20px;
}

/* Main Content */
.checkout-content {
  display: grid;
  grid-template-columns: 1fr 380px;
  gap: 30px;
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

/* Form Card */
.form-card {
  background: white;
  border-radius: 16px;
  padding: 40px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
  border: 1px solid rgba(0, 0, 0, 0.08);
}

.form-header {
  text-align: center;
  margin-bottom: 40px;
}

.form-title {
  font-size: 2rem;
  font-weight: 800;
  color: #1a1f71;
  margin: 0 0 10px 0;
  letter-spacing: -0.5px;
}

.form-subtitle {
  color: #888;
  margin: 0;
  font-size: 1rem;
}

.checkout-form {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-label {
  font-weight: 700;
  color: #1a1f71;
  margin-bottom: 10px;
  font-size: 0.95rem;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.required {
  color: #d32f2f;
  margin-left: 4px;
}

.input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.input-wrapper i {
  position: absolute;
  left: 16px;
  color: #0d47a1;
  font-size: 1.1rem;
  pointer-events: none;
}

.form-input,
.form-textarea {
  width: 100%;
  padding: 14px 16px 14px 48px;
  border: 2px solid #e0e7ff;
  border-radius: 10px;
  font-size: 1rem;
  font-family: inherit;
  background: #f8f9ff;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  color: #1a1f71;
}

.form-input::placeholder,
.form-textarea::placeholder {
  color: #b0bec5;
}

.form-input:focus,
.form-textarea:focus {
  outline: none;
  border-color: #0d47a1;
  background: white;
  box-shadow: 0 0 0 4px rgba(13, 71, 161, 0.1), inset 0 2px 4px rgba(0, 0, 0, 0.05);
  transform: translateY(-2px);
}

.form-textarea {
  padding: 14px 16px;
  resize: vertical;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 12px;
  margin-top: 30px;
}

.btn-secondary,
.btn-primary {
  flex: 1;
  padding: 14px 24px;
  border-radius: 10px;
  font-weight: 700;
  text-decoration: none;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-size: 0.95rem;
}

.btn-secondary {
  background: #f5f7fa;
  color: #0d47a1;
  border: 2px solid #e0e7ff;
}

.btn-secondary:hover {
  background: #e0e7ff;
  transform: translateY(-2px);
}

.btn-primary {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
}

.btn-primary:hover:not(:disabled) {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(13, 71, 161, 0.4);
  filter: brightness(1.1);
}

.btn-primary:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

/* Summary Sidebar */
.summary-section {
  position: sticky;
  top: 100px;
}

.summary-card {
  background: white;
  border-radius: 16px;
  padding: 28px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(0, 0, 0, 0.08);
}

.summary-title {
  font-size: 1.3rem;
  font-weight: 700;
  color: #1a1f71;
  margin: 0 0 24px 0;
}

.items-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-bottom: 20px;
}

.summary-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 0;
  border-bottom: 1px solid #f0f0f0;
}

.item-info {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.item-name {
  font-weight: 600;
  color: #1a1f71;
  font-size: 0.95rem;
}

.item-qty {
  color: #888;
  font-size: 0.85rem;
}

.item-amount {
  font-weight: 700;
  color: #0d47a1;
  font-size: 1rem;
}

.summary-divider {
  height: 2px;
  background: #f0f0f0;
  margin: 20px 0;
}

.summary-details {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.detail-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 0;
  color: #666;
  font-weight: 500;
}

.detail-row .amount {
  color: #1a1f71;
  font-weight: 600;
}

.amount-free {
  color: #4caf50 !important;
  font-weight: 700;
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

.security-badge {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  margin-top: 24px;
  padding: 12px;
  background: #f0f9ff;
  border-radius: 8px;
  color: #0d47a1;
  font-weight: 600;
  font-size: 0.85rem;
  border: 1px solid #b3d9ff;
}

.security-badge i {
  font-size: 1.1rem;
}

/* Responsive */
@media (max-width: 1024px) {
  .checkout-content {
    gap: 20px;
  }

  .form-card {
    padding: 30px;
  }
}

@media (max-width: 768px) {
  .checkout-content {
    grid-template-columns: 1fr;
  }

  .summary-section {
    position: static;
  }

  .form-title {
    font-size: 1.5rem;
  }

  .progress-bar-wrapper {
    flex-wrap: wrap;
    justify-content: center;
  }

  .action-buttons {
    flex-direction: column;
  }
}
</style>