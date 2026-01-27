<template>
  <div>
    <nav class="nav">
      <div class="nav-left">
        <h1 class="logo">Mini Shop</h1>
      </div>

      <button class="menu-btn" @click="toggleMenu">
        ☰
      </button>

      <div class="nav-links" :class="{ open: isOpen }">
        <router-link to="/" @click="closeMenu">Home</router-link>
        <router-link to="/cart" @click="closeMenu">Cart</router-link>
        <button class="btn-admin" @click="showLoginModal = true">Admin</button>
      </div>
    </nav>

    <!-- Login Modal -->
    <div v-if="showLoginModal" class="modal-overlay" @click="showLoginModal = false">
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
            <button type="button" class="btn-cancel" @click="showLoginModal = false">Cancel</button>
            <button type="submit" class="btn-login">Login</button>
          </div>
        </form>
      </div>
    </div>

    <main class="container">
      <router-view />
    </main>
  </div>
</template>

<script>
export default {
  name: "MainLayout",
  data() {
    return {
      isOpen: false,
      showLoginModal: false,
      adminUsername: '',
      adminPassword: '',
      loginError: ''
    };
  },
  methods: {
    toggleMenu() {
      this.isOpen = !this.isOpen;
    },
    closeMenu() {
      this.isOpen = false;
    },
    handleAdminLogin() {
      // Validate credentials
      if (this.adminUsername === 'admin' && this.adminPassword === '123') {
        // Store admin session
        localStorage.setItem('adminLoggedIn', 'true');
        this.showLoginModal = false;
        this.adminUsername = '';
        this.adminPassword = '';
        this.loginError = '';
        // Redirect to admin panel
        this.$router.push('/admin/products');
      } else {
        this.loginError = 'Invalid username or password';
      }
    }
  }
};
</script>

<style scoped>
/* NAVBAR */
.nav {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 20px;
  background: #111;
  color: white;
  position: sticky;
  top: 0;
  z-index: 100;
}

.logo {
  font-size: 1.2rem;
  margin: 0;
}

/* LINKS */
.nav-links {
  display: flex;
  gap: 24px;
}

.nav-links a {
  color: white;
  text-decoration: none;
  font-weight: 500;
}

.nav-links a.router-link-active {
  text-decoration: underline;
}

.btn-admin {
  background: #28a745;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 500;
  transition: background 0.3s;
}

.btn-admin:hover {
  background: #218838;
}

/* MOBILE MENU BUTTON */
.menu-btn {
  display: none;
  background: none;
  border: none;
  color: white;
  font-size: 1.6rem;
  cursor: pointer;
}

/* MAIN CONTENT */
.container {
  padding: 16px;
}

/* MOBILE */
@media (max-width: 768px) {
  .menu-btn {
    display: block;
  }

  .nav-links {
    position: absolute;
    top: 56px;
    right: 0;
    background: #111;
    flex-direction: column;
    width: 100%;
    padding: 16px;
    display: none;
  }

  .nav-links.open {
    display: flex;
  }
}
</style>
