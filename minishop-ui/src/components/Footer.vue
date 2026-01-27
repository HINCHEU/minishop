<template>
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <!-- Brand Section -->
        <div class="footer-section">
          <div class="footer-brand">
            <i class="bi bi-shop"></i>
            <h3>{{ settings.shop_name }}</h3>
          </div>
          <p class="footer-description">
            {{ settings.description || 'Your trusted destination for quality products at affordable prices. Shop with confidence.' }}
          </p>
          <div class="social-links">
            <a v-if="settings.facebook_url" :href="settings.facebook_url" class="social-icon" title="Facebook" target="_blank">
              <i class="bi bi-facebook"></i>
            </a>
            <a v-if="settings.twitter_url" :href="settings.twitter_url" class="social-icon" title="Twitter" target="_blank">
              <i class="bi bi-twitter"></i>
            </a>
            <a v-if="settings.instagram_url" :href="settings.instagram_url" class="social-icon" title="Instagram" target="_blank">
              <i class="bi bi-instagram"></i>
            </a>
            <a v-if="settings.linkedin_url" :href="settings.linkedin_url" class="social-icon" title="LinkedIn" target="_blank">
              <i class="bi bi-linkedin"></i>
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="footer-section">
          <h4>Quick Links</h4>
          <ul class="footer-links">
            <li><router-link to="/">Home</router-link></li>
            <li><router-link to="/about">About Us</router-link></li>
            <li><router-link to="/contact">Contact</router-link></li>
            <li><a href="#">Shop</a></li>
          </ul>
        </div>

        <!-- Support -->
        <div class="footer-section">
          <h4>Support</h4>
          <ul class="footer-links">
            <li><a href="#">Help Center</a></li>
            <li><a href="#">Shipping Info</a></li>
            <li><a href="#">Returns</a></li>
            <li><a href="#">FAQ</a></li>
          </ul>
        </div>

        <!-- Legal -->
        <div class="footer-section">
          <h4>Legal</h4>
          <ul class="footer-links">
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Cookies</a></li>
            <li><a href="#">Accessibility</a></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div class="footer-section">
          <h4>Contact</h4>
          <div class="contact-info">
            <div v-if="settings.email" class="info-item">
              <i class="bi bi-envelope"></i>
              <a :href="`mailto:${settings.email}`">{{ settings.email }}</a>
            </div>
            <div v-if="settings.phone" class="info-item">
              <i class="bi bi-telephone"></i>
              <a :href="`tel:${settings.phone}`">{{ settings.phone }}</a>
            </div>
            <div v-if="settings.address" class="info-item">
              <i class="bi bi-geo-alt"></i>
              <span>{{ settings.address }}<br/>{{ settings.city }}, {{ settings.state }} {{ settings.postal_code }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Newsletter -->
      <div class="newsletter-section">
        <h4>Subscribe to Our Newsletter</h4>
        <p>Get exclusive deals and updates delivered to your inbox</p>
        <form @submit.prevent="subscribeNewsletter" class="newsletter-form">
          <input
            type="email"
            v-model="email"
            placeholder="Enter your email"
            class="newsletter-input"
            required
          />
          <button type="submit" class="newsletter-btn">
            <i class="bi bi-send"></i>
          </button>
        </form>
        <div v-if="newsletterMessage" class="newsletter-message" :class="messageType">
          {{ newsletterMessage }}
        </div>
      </div>

      <!-- Bottom Section -->
      <div class="footer-bottom">
        <div class="copyright">
          <p>&copy; 2024 {{ settings.shop_name }}. All rights reserved.</p>
        </div>
        <div class="payment-methods">
          <span>We Accept:</span>
          <i class="bi bi-credit-card"></i>
          <i class="bi bi-cash"></i>
          <i class="bi bi-wallet2"></i>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
import { ref, onMounted } from 'vue'

export default {
  name: 'Footer',
  setup() {
    const email = ref('')
    const newsletterMessage = ref('')
    const messageType = ref('')
    const settings = ref({
      shop_name: 'Mini-Shop',
      description: '',
      email: '',
      phone: '',
      address: '',
      city: '',
      state: '',
      postal_code: '',
      facebook_url: '',
      twitter_url: '',
      instagram_url: '',
      linkedin_url: '',
    })

    onMounted(async () => {
      try {
        const response = await fetch('/api/settings')
        const data = await response.json()
        if (data.success) {
          Object.assign(settings.value, data.data)
        }
      } catch (error) {
        console.error('Error fetching settings:', error)
      }

      // Listen for settings updates
      window.addEventListener('settingsUpdated', (event) => {
        Object.assign(settings.value, event.detail)
      })
    })

    const subscribeNewsletter = () => {
      if (email.value) {
        // In a real app, you'd send this to a backend
        console.log('Subscribed with email:', email.value)
        
        messageType.value = 'success'
        newsletterMessage.value = 'Thank you for subscribing!'
        email.value = ''
        
        setTimeout(() => {
          newsletterMessage.value = ''
        }, 4000)
      }
    }

    return {
      email,
      newsletterMessage,
      messageType,
      settings,
      subscribeNewsletter
    }
  }
}
</script>

<style scoped>
.footer {
  background: linear-gradient(135deg, #1a1f71 0%, #0d47a1 100%);
  color: white;
  padding: 60px 0 20px;
  margin-top: 80px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 40px;
  margin-bottom: 50px;
  padding-bottom: 40px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

/* Footer Section */
.footer-section {
  animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Brand Section */
.footer-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 16px;
}

.footer-brand i {
  font-size: 2rem;
  color: #42a5f5;
}

.footer-brand h3 {
  font-size: 1.5rem;
  margin: 0;
  font-weight: 800;
  letter-spacing: -0.5px;
}

.footer-description {
  font-size: 0.95rem;
  line-height: 1.6;
  opacity: 0.9;
  margin: 12px 0;
}

/* Social Links */
.social-links {
  display: flex;
  gap: 12px;
  margin-top: 16px;
}

.social-icon {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 255, 255, 0.15);
  border-radius: 8px;
  color: #42a5f5;
  text-decoration: none;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  font-size: 1.2rem;
}

.social-icon:hover {
  background: #42a5f5;
  color: white;
  transform: translateY(-4px);
}

/* Section Titles */
.footer-section h4 {
  font-size: 1.1rem;
  font-weight: 800;
  margin: 0 0 20px 0;
  letter-spacing: 0.5px;
}

/* Footer Links */
.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links li {
  margin-bottom: 12px;
}

.footer-links a {
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  font-size: 0.95rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  display: inline-block;
}

.footer-links a:hover {
  color: #42a5f5;
  transform: translateX(4px);
}

/* Contact Info */
.contact-info {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.info-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  font-size: 0.95rem;
}

.info-item i {
  color: #42a5f5;
  margin-top: 2px;
  flex-shrink: 0;
}

.info-item a {
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  transition: color 0.3s ease;
}

.info-item a:hover {
  color: #42a5f5;
}

/* Newsletter Section */
.newsletter-section {
  background: rgba(255, 255, 255, 0.08);
  border-radius: 12px;
  padding: 40px;
  margin-bottom: 40px;
  border: 1px solid rgba(255, 255, 255, 0.1);
  text-align: center;
}

.newsletter-section h4 {
  font-size: 1.5rem;
  margin: 0 0 8px 0;
  font-weight: 800;
}

.newsletter-section p {
  opacity: 0.9;
  margin: 0 0 24px 0;
  font-size: 0.95rem;
}

.newsletter-form {
  display: flex;
  gap: 8px;
  margin-bottom: 16px;
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
}

.newsletter-input {
  flex: 1;
  padding: 12px 16px;
  border: 2px solid rgba(255, 255, 255, 0.2);
  border-radius: 8px;
  background: rgba(255, 255, 255, 0.1);
  color: white;
  font-size: 0.95rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.newsletter-input::placeholder {
  color: rgba(255, 255, 255, 0.5);
}

.newsletter-input:focus {
  outline: none;
  border-color: #42a5f5;
  background: rgba(255, 255, 255, 0.15);
}

.newsletter-btn {
  padding: 12px 24px;
  background: #42a5f5;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 700;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
}

.newsletter-btn:hover {
  background: #1565c0;
  transform: translateY(-2px);
}

.newsletter-message {
  padding: 12px 16px;
  border-radius: 8px;
  font-size: 0.95rem;
  font-weight: 600;
  animation: slideUp 0.4s ease-out;
}

.newsletter-message.success {
  background: rgba(76, 175, 80, 0.2);
  border: 1px solid rgba(76, 175, 80, 0.5);
  color: #c8e6c9;
}

.newsletter-message.error {
  background: rgba(211, 47, 47, 0.2);
  border: 1px solid rgba(211, 47, 47, 0.5);
  color: #ffcdd2;
}

/* Footer Bottom */
.footer-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 20px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  flex-wrap: wrap;
  gap: 20px;
}

.copyright {
  font-size: 0.9rem;
  opacity: 0.8;
}

.copyright p {
  margin: 0;
}

.payment-methods {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 0.9rem;
  opacity: 0.8;
}

.payment-methods i {
  font-size: 1.5rem;
  color: #42a5f5;
}

/* Responsive */
@media (max-width: 768px) {
  .footer {
    padding: 40px 0 20px;
  }

  .footer-content {
    grid-template-columns: 1fr;
    gap: 30px;
    margin-bottom: 30px;
    padding-bottom: 30px;
  }

  .newsletter-section {
    padding: 30px 20px;
  }

  .newsletter-form {
    flex-direction: column;
  }

  .newsletter-btn {
    width: 100%;
  }

  .footer-bottom {
    flex-direction: column;
    text-align: center;
  }

  .footer-section h4 {
    font-size: 1rem;
  }

  .footer-brand h3 {
    font-size: 1.3rem;
  }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
