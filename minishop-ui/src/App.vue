<template>
  <div id="app" class="min-vh-100 bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
      <div class="container">
        <router-link to="/" class="navbar-brand fw-bold">
          <img v-if="shopSettings.logo_url" :src="shopSettings.logo_url" :alt="shopSettings.shop_name" class="navbar-logo" />
          <i v-else class="bi bi-shop me-2"></i>
          {{ shopSettings.shop_name }}
        </router-link>
        
        <div class="navbar-nav ms-auto d-flex align-items-center gap-3 me-3">
          <router-link to="/" class="nav-link">Home</router-link>
          <router-link to="/about" class="nav-link">About</router-link>
          <router-link to="/contact" class="nav-link">Contact</router-link>
        </div>
        
        <div class="d-flex align-items-center gap-3">
          <!-- Cart Button (only for public routes) -->
          <router-link 
            v-if="!isAdminRoute" 
            to="/cart" 
            class="btn btn-light position-relative"
          >
            <i class="bi bi-cart3"></i>
            <span 
              v-if="cartStore.getCount() > 0" 
              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            >
              {{ cartStore.getCount() }}
            </span>
          </router-link>
          
          <!-- Admin Toggle -->
          <button 
            class="btn btn-outline-light" 
            @click="toggleAdmin"
          >
            <i :class="isAdminRoute ? 'bi bi-house' : 'bi bi-gear'"></i>
            <span class="ms-2">{{ isAdminRoute ? 'Public' : 'Admin' }}</span>
          </button>
        </div>
      </div>
    </nav>

    <!-- Login Modal -->
    <div v-if="showLoginModal" class="modal-overlay" @click="closeLoginModal">
      <div class="modal-content" @click.stop>
        <h2>Admin Login</h2>
        <form @submit.prevent="handleAdminLogin">
          <div class="form-group">
            <label>Username:</label>
            <input 
              type="text" 
              v-model="adminUsername" 
              placeholder="admin"
              required
            />
          </div>
          <div class="form-group">
            <label>Password:</label>
            <input 
              type="password" 
              v-model="adminPassword" 
              placeholder="123"
              required
            />
          </div>
          <div v-if="loginError" class="error-message">{{ loginError }}</div>
          <div class="modal-buttons">
            <button type="button" class="btn btn-secondary" @click="closeLoginModal">Cancel</button>
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Main Content -->
    <router-view />

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script>
import { computed, ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { cartStore } from './stores/cart'
import Footer from './components/Footer.vue'

export default {
  name: 'App',
  components: {
    Footer
  },
  setup() {
    const route = useRoute()
    const router = useRouter()
    
    const shopSettings = ref({
      shop_name: 'Mini-Shop',
      logo_url: '',
    })
    
    const isAdminRoute = computed(() => route.path.startsWith('/admin'))
    const showLoginModal = ref(false)
    const adminUsername = ref('')
    const adminPassword = ref('')
    const loginError = ref('')

    // Fetch shop settings
    onMounted(async () => {
      try {
        const response = await fetch('/api/settings')
        const data = await response.json()
        if (data.success) {
          shopSettings.value = data.data
          // Update browser tab title
          document.title = shopSettings.value.shop_name
        }
      } catch (error) {
        console.error('Error fetching shop settings:', error)
      }

      // Listen for settings updates
      window.addEventListener('settingsUpdated', (event) => {
        Object.assign(shopSettings.value, event.detail)
        // Update browser tab title when settings change
        document.title = event.detail.shop_name || 'Mini-Shop'
      })
    })
    
    const toggleAdmin = () => {
      if (isAdminRoute.value) {
        // If already in admin, go back to public
        router.push('/')
      } else {
        // If trying to enter admin, show login modal
        showLoginModal.value = true
      }
    }
    
    const closeLoginModal = () => {
      showLoginModal.value = false
      adminUsername.value = ''
      adminPassword.value = ''
      loginError.value = ''
    }
    
    const handleAdminLogin = () => {
      // Validate credentials
      if (adminUsername.value === 'admin' && adminPassword.value === '123') {
        // Store admin session
        localStorage.setItem('adminLoggedIn', 'true')
        closeLoginModal()
        // Redirect to admin panel
        router.push('/admin/products')
      } else {
        loginError.value = 'Invalid username or password'
      }
    }
    
    return {
      cartStore,
      shopSettings,
      isAdminRoute,
      toggleAdmin,
      showLoginModal,
      adminUsername,
      adminPassword,
      loginError,
      closeLoginModal,
      handleAdminLogin
    }
  }
}
</script>

<style>
* {
  scroll-behavior: smooth;
}

#app {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Inter', Roboto, 'Helvetica Neue', Arial, sans-serif;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
}

.navbar-logo {
  height: 40px;
  max-width: 40px;
  object-fit: contain;
  margin-right: 8px;
}

/* Modern Navigation Bar */
.navbar {
  background: linear-gradient(90deg, #1a1f71 0%, #0d47a1 100%) !important;
  box-shadow: 0 8px 32px rgba(13, 71, 161, 0.2) !important;
  backdrop-filter: blur(10px);
  position: sticky;
  top: 0;
  z-index: 999;
}

.navbar-brand {
  font-size: 1.5rem;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.navbar-brand:hover {
  transform: scale(1.05);
  text-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
}

.navbar-nav .nav-link {
  color: rgba(255, 255, 255, 0.8) !important;
  font-weight: 500;
  margin: 0 8px;
  padding: 4px 0 !important;
  border-bottom: 3px solid transparent;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.navbar-nav .nav-link:hover {
  color: white !important;
  border-bottom-color: #42a5f5;
  transform: translateY(-2px);
}

.navbar-nav .router-link-active {
  color: #42a5f5 !important;
  border-bottom-color: #42a5f5;
}

.btn-light {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: 2px solid transparent;
}

.btn-light:hover {
  background: rgba(255, 255, 255, 0.95) !important;
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.btn-outline-light {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  border: 2px solid rgba(255, 255, 255, 0.8);
}

.btn-outline-light:hover {
  background: rgba(255, 255, 255, 0.2) !important;
  border-color: white;
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.badge {
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.8;
  }
}

/* Enhanced Card Hover Effects */
.hover-shadow {
  border: none;
  border-radius: 12px;
  background: white;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
}

.hover-shadow::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
  transition: left 0.5s;
  z-index: 1;
}

.hover-shadow:hover::before {
  left: 100%;
}

.hover-shadow:hover {
  box-shadow: 0 20px 40px rgba(13, 71, 161, 0.2), 0 0 40px rgba(66, 165, 245, 0.1) !important;
  transform: translateY(-8px) scale(1.02);
}

.card-img-top {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover-shadow:hover .card-img-top {
  transform: scale(1.1) rotateZ(1deg);
  filter: brightness(1.1);
}

/* Modal Styles with Modern Look */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  backdrop-filter: blur(4px);
  animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    backdrop-filter: blur(0px);
  }
  to {
    opacity: 1;
    backdrop-filter: blur(4px);
  }
}

.modal-content {
  background: white;
  padding: 40px;
  border-radius: 16px;
  width: 90%;
  max-width: 450px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), 0 0 40px rgba(66, 165, 245, 0.15);
  animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  border: 1px solid rgba(255, 255, 255, 0.8);
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(40px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.modal-content h2 {
  margin: 0 0 30px 0;
  text-align: center;
  color: #1a1f71;
  font-weight: 700;
  font-size: 1.5rem;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: 600;
  color: #1a1f71;
  font-size: 0.95rem;
}

.form-group input {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid #e0e7ff;
  border-radius: 8px;
  font-size: 1rem;
  box-sizing: border-box;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  background: #f8f9ff;
}

.form-group input:focus {
  outline: none;
  border-color: #0d47a1;
  background: white;
  box-shadow: 0 0 0 4px rgba(13, 71, 161, 0.1), inset 0 2px 4px rgba(0, 0, 0, 0.05);
  transform: scale(1.01);
}

.form-group input::placeholder {
  color: #b0bec5;
}

.error-message {
  color: #d32f2f;
  font-size: 0.9rem;
  margin-bottom: 16px;
  text-align: center;
  padding: 12px;
  background: #ffebee;
  border-radius: 8px;
  border-left: 4px solid #d32f2f;
  animation: shake 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  75% { transform: translateX(5px); }
}

.modal-buttons {
  display: flex;
  gap: 12px;
  margin-top: 28px;
}

.modal-buttons button {
  flex: 1;
  padding: 12px 20px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  font-size: 1rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.modal-buttons .btn-primary {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
}

.modal-buttons .btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(13, 71, 161, 0.3);
}

.modal-buttons .btn-secondary {
  background: #f5f5f5;
  color: #1a1f71;
}

.modal-buttons .btn-secondary:hover {
  background: #eeeeee;
  transform: translateY(-2px);
}
</style>