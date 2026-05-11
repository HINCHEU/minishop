<template>
  <div class="homepage-container">
    <div class="container py-5">
      <!-- Header Section -->
      <div class="header-section mb-5">
        <h1 class="page-title">Our Premium Collection</h1>
        <p class="page-subtitle">Discover exquisite products curated just for you</p>
        <div class="header-divider"></div>
      </div>
      
      <!-- Loading Spinner -->
      <div v-if="loading" class="text-center py-5">
        <div class="modern-spinner"></div>
        <p class="mt-3 text-muted">Loading amazing products...</p>
      </div>
      
      <!-- Products Grid -->
      <div v-else class="row g-4">
        <div v-for="product in products" :key="product.id" class="col-lg-4 col-md-6">
          <div class="product-card hover-shadow">
            <div class="product-image-wrapper">
              <img 
                :src="product.image_url || 'https://via.placeholder.com/400x300?text=No+Image'" 
                class="product-image" 
                :alt="product.name"
              >
              <div class="stock-badge" :class="product.stock > 0 ? 'in-stock' : 'out-of-stock'">
                {{ product.stock > 0 ? `${product.stock} in stock` : 'Out of Stock' }}
              </div>
            </div>
            <div class="product-body">
              <h5 class="product-title">{{ product.name }}</h5>
              <p class="product-description">High-quality product at the best price</p>
              <div class="price-section">
                <span class="price">${{ parseFloat(product.price).toFixed(2) }}</span>
              </div>
              <div class="button-group">
                <router-link 
                  :to="`/product/${product.id}`" 
                  class="btn btn-outline-primary btn-modern"
                >
                  <i class="bi bi-eye me-2"></i>
                  View Details
                </router-link>
                <button 
                  class="btn btn-primary btn-modern btn-add-cart" 
                  @click="addToCart(product)"
                  :disabled="product.stock <= 0"
                >
                  <i class="bi bi-cart-plus me-2"></i>
                  Add to Cart
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import { cartStore } from '../stores/cart'

export default {
  name: 'HomePage',
  setup() {
    const products = ref([])
    const loading = ref(true)
    
    const fetchProducts = async () => {
      loading.value = true
      try {
        const response = await api.getProducts()
        products.value = response.data
      } catch (error) {
        console.error('Error fetching products:', error)
      }
      loading.value = false
    }
    
    const addToCart = (product) => {
      cartStore.addItem(product)
    }
    
    onMounted(() => {
      fetchProducts()
    })
    
    return {
      products,
      loading,
      addToCart
    }
  }
}
</script>

<style scoped>
.homepage-container {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
  padding-top: 20px;
}

.header-section {
  text-align: center;
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
  font-size: 3rem;
  font-weight: 800;
  background: linear-gradient(135deg, #1a1f71 0%, #0d47a1 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 15px;
  letter-spacing: -1px;
}

.page-subtitle {
  font-size: 1.2rem;
  color: #555;
  margin-bottom: 20px;
  font-weight: 300;
}

.header-divider {
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, #0d47a1, #42a5f5);
  border-radius: 2px;
  margin: 0 auto;
}

.modern-spinner {
  width: 50px;
  height: 50px;
  border: 4px solid #e0e7ff;
  border-top: 4px solid #0d47a1;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.product-card {
  border: none;
  border-radius: 16px;
  background: white;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  height: 100%;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
}

.product-image-wrapper {
  position: relative;
  overflow: hidden;
  height: 250px;
  background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
}

.product-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.product-card:hover .product-image {
  transform: scale(1.15) rotateZ(2deg);
  filter: brightness(1.15);
}

.stock-badge {
  position: absolute;
  top: 12px;
  right: 12px;
  padding: 8px 12px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
  backdrop-filter: blur(8px);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  animation: slideIn 0.4s ease-out;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

.stock-badge.in-stock {
  background: rgba(76, 175, 80, 0.9);
  color: white;
}

.stock-badge.out-of-stock {
  background: rgba(244, 67, 54, 0.9);
  color: white;
}

.product-body {
  padding: 24px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.product-title {
  font-size: 1.1rem;
  font-weight: 700;
  color: #1a1f71;
  margin-bottom: 10px;
  line-height: 1.4;
}

.product-description {
  font-size: 0.85rem;
  color: #888;
  margin-bottom: 16px;
  flex-grow: 1;
}

.price-section {
  margin-bottom: 20px;
  padding-bottom: 16px;
  border-bottom: 2px solid #f0f0f0;
}

.price {
  font-size: 1.8rem;
  font-weight: 800;
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.button-group {
  display: flex;
  gap: 10px;
  flex-direction: column;
}

.btn-modern {
  border-radius: 8px;
  font-weight: 600;
  padding: 10px 16px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-size: 0.85rem;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid transparent;
}

.btn-outline-primary.btn-modern {
  color: #0d47a1;
  border: 2px solid #0d47a1;
  background: white;
}

.btn-outline-primary.btn-modern:hover {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(13, 71, 161, 0.3);
}

.btn-primary.btn-modern {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
  border: none;
}

.btn-primary.btn-modern:hover:not(:disabled) {
  transform: translateY(-3px);
  box-shadow: 0 12px 30px rgba(13, 71, 161, 0.4);
  filter: brightness(1.1);
}

.btn-primary.btn-modern:disabled {
  background: #ccc;
  cursor: not-allowed;
  opacity: 0.6;
}

/* Responsive */
@media (max-width: 768px) {
  .page-title {
    font-size: 2rem;
  }

  .page-subtitle {
    font-size: 1rem;
  }

  .product-image-wrapper {
    height: 200px;
  }

  .button-group {
    flex-direction: row;
  }

  .btn-modern {
    flex: 1;
  }
}
</style>