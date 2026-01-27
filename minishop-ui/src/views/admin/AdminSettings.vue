<template>
  <div class="settings-container">
    <div class="container py-5">
      <!-- Header -->
      <div class="settings-header">
        <h1 class="settings-title">
          <i class="bi bi-gear"></i>
          Shop Settings
        </h1>
        <p class="settings-subtitle">Manage your shop information and configuration</p>
      </div>

      <!-- Settings Form -->
      <div class="settings-card">
        <form @submit.prevent="saveSettings">
          <!-- Basic Information Section -->
          <div class="form-section">
            <h2 class="section-title">
              <i class="bi bi-shop"></i>
              Basic Information
            </h2>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="shop_name" class="form-label">
                  <i class="bi bi-building"></i>
                  Shop Name
                </label>
                <input
                  type="text"
                  id="shop_name"
                  v-model="form.shop_name"
                  class="form-control"
                  placeholder="Mini-Shop"
                  required
                />
              </div>

              <div class="form-group col-md-6">
                <label for="logo_url" class="form-label">
                  <i class="bi bi-image"></i>
                  Logo URL
                </label>
                <input
                  type="url"
                  id="logo_url"
                  v-model="form.logo_url"
                  class="form-control"
                  placeholder="https://example.com/logo.png"
                />
              </div>
            </div>

            <div class="form-group">
              <label for="description" class="form-label">
                <i class="bi bi-file-text"></i>
                Description
              </label>
              <textarea
                id="description"
                v-model="form.description"
                class="form-control"
                rows="3"
                placeholder="Your shop description..."
              ></textarea>
            </div>
          </div>

          <!-- Contact Information Section -->
          <div class="form-section">
            <h2 class="section-title">
              <i class="bi bi-telephone"></i>
              Contact Information
            </h2>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="phone" class="form-label">
                  <i class="bi bi-telephone-fill"></i>
                  Phone Number
                </label>
                <input
                  type="tel"
                  id="phone"
                  v-model="form.phone"
                  class="form-control"
                  placeholder="+1 (234) 567-890"
                />
              </div>

              <div class="form-group col-md-6">
                <label for="email" class="form-label">
                  <i class="bi bi-envelope"></i>
                  Email Address
                </label>
                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  class="form-control"
                  placeholder="support@minishop.com"
                />
              </div>
            </div>
          </div>

          <!-- Address Section -->
          <div class="form-section">
            <h2 class="section-title">
              <i class="bi bi-geo-alt"></i>
              Address
            </h2>

            <div class="form-group">
              <label for="address" class="form-label">
                <i class="bi bi-house"></i>
                Street Address
              </label>
              <input
                type="text"
                id="address"
                v-model="form.address"
                class="form-control"
                placeholder="123 Shopping Street"
              />
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="city" class="form-label">
                  <i class="bi bi-pin"></i>
                  City
                </label>
                <input
                  type="text"
                  id="city"
                  v-model="form.city"
                  class="form-control"
                  placeholder="Commerce City"
                />
              </div>

              <div class="form-group col-md-3">
                <label for="state" class="form-label">
                  <i class="bi bi-signpost"></i>
                  State
                </label>
                <input
                  type="text"
                  id="state"
                  v-model="form.state"
                  class="form-control"
                  placeholder="ST"
                  maxlength="2"
                />
              </div>

              <div class="form-group col-md-3">
                <label for="postal_code" class="form-label">
                  <i class="bi bi-mailbox"></i>
                  Postal Code
                </label>
                <input
                  type="text"
                  id="postal_code"
                  v-model="form.postal_code"
                  class="form-control"
                  placeholder="12345"
                />
              </div>
            </div>
          </div>

          <!-- Social Media Section -->
          <div class="form-section">
            <h2 class="section-title">
              <i class="bi bi-share"></i>
              Social Media
            </h2>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="facebook_url" class="form-label">
                  <i class="bi bi-facebook"></i>
                  Facebook
                </label>
                <input
                  type="url"
                  id="facebook_url"
                  v-model="form.facebook_url"
                  class="form-control"
                  placeholder="https://facebook.com/minishop"
                />
              </div>

              <div class="form-group col-md-6">
                <label for="twitter_url" class="form-label">
                  <i class="bi bi-twitter"></i>
                  Twitter
                </label>
                <input
                  type="url"
                  id="twitter_url"
                  v-model="form.twitter_url"
                  class="form-control"
                  placeholder="https://twitter.com/minishop"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="instagram_url" class="form-label">
                  <i class="bi bi-instagram"></i>
                  Instagram
                </label>
                <input
                  type="url"
                  id="instagram_url"
                  v-model="form.instagram_url"
                  class="form-control"
                  placeholder="https://instagram.com/minishop"
                />
              </div>

              <div class="form-group col-md-6">
                <label for="linkedin_url" class="form-label">
                  <i class="bi bi-linkedin"></i>
                  LinkedIn
                </label>
                <input
                  type="url"
                  id="linkedin_url"
                  v-model="form.linkedin_url"
                  class="form-control"
                  placeholder="https://linkedin.com/company/minishop"
                />
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="form-actions">
            <button type="submit" class="btn btn-save">
              <i class="bi bi-check-circle me-2"></i>
              Save Settings
            </button>
            <button type="button" class="btn btn-cancel" @click="resetForm">
              <i class="bi bi-arrow-counterclockwise me-2"></i>
              Reset
            </button>
          </div>

          <!-- Messages -->
          <div v-if="successMessage" class="alert alert-success">
            <i class="bi bi-check-circle me-2"></i>
            {{ successMessage }}
          </div>
          <div v-if="errorMessage" class="alert alert-error">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ errorMessage }}
          </div>
        </form>
      </div>

      <!-- Preview Section -->
      <div class="preview-section mt-5">
        <h2 class="preview-title">
          <i class="bi bi-eye"></i>
          Preview
        </h2>
        <div class="preview-grid">
          <!-- Navbar Preview -->
          <div class="preview-card">
            <h3>Navbar</h3>
            <div class="preview-content navbar-preview">
              <div class="preview-logo">
                <img v-if="form.logo_url" :src="form.logo_url" :alt="form.shop_name" class="logo-img" />
                <i v-else class="bi bi-shop"></i>
              </div>
              <span class="shop-name-preview">{{ form.shop_name }}</span>
            </div>
          </div>

          <!-- Footer Preview -->
          <div class="preview-card">
            <h3>Footer Contact Info</h3>
            <div class="preview-content footer-preview">
              <div v-if="form.phone" class="preview-item">
                <i class="bi bi-telephone"></i>
                <span>{{ form.phone }}</span>
              </div>
              <div v-if="form.email" class="preview-item">
                <i class="bi bi-envelope"></i>
                <span>{{ form.email }}</span>
              </div>
              <div v-if="form.address" class="preview-item">
                <i class="bi bi-geo-alt"></i>
                <span>{{ form.address }}</span>
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

export default {
  name: 'AdminSettings',
  setup() {
    const form = ref({
      shop_name: 'Mini-Shop',
      logo_url: '',
      phone: '',
      email: '',
      address: '',
      city: '',
      state: '',
      postal_code: '',
      description: '',
      facebook_url: '',
      twitter_url: '',
      instagram_url: '',
      linkedin_url: '',
    })

    const successMessage = ref('')
    const errorMessage = ref('')
    const loading = ref(false)

    // Fetch settings on component mount
    onMounted(async () => {
      await fetchSettings()
    })

    const fetchSettings = async () => {
      try {
        loading.value = true
        const response = await fetch('/api/settings')
        
        if (!response.ok) {
          throw new Error(`Server error: ${response.status} ${response.statusText}`)
        }
        
        const data = await response.json()

        if (data.success) {
          Object.assign(form.value, data.data)
        }
      } catch (error) {
        console.error('Error fetching settings:', error)
        errorMessage.value = 'Failed to load settings: ' + error.message
      } finally {
        loading.value = false
      }
    }

    const saveSettings = async () => {
      try {
        loading.value = true
        successMessage.value = ''
        errorMessage.value = ''

        const response = await fetch('/api/admin/settings', {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
          },
          body: JSON.stringify(form.value),
        })

        if (!response.ok) {
          throw new Error(`Server error: ${response.status} ${response.statusText}`)
        }

        const data = await response.json()

        if (data.success) {
          successMessage.value = 'Settings saved successfully!'
          setTimeout(() => {
            successMessage.value = ''
          }, 4000)
          // Emit event to update parent components
          window.dispatchEvent(new CustomEvent('settingsUpdated', { detail: data.data }))
        } else {
          errorMessage.value = data.message || 'Failed to save settings'
        }
      } catch (error) {
        console.error('Error saving settings:', error)
        errorMessage.value = 'Error: ' + (error.message || 'Failed to save settings. Is the backend server running?')
      } finally {
        loading.value = false
      }
    }

    const resetForm = () => {
      fetchSettings()
    }

    return {
      form,
      successMessage,
      errorMessage,
      loading,
      saveSettings,
      resetForm,
    }
  }
}
</script>

<style scoped>
.settings-container {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
  padding: 40px 0;
}

.settings-header {
  text-align: center;
  margin-bottom: 50px;
}

.settings-title {
  font-size: 2.5rem;
  font-weight: 800;
  background: linear-gradient(135deg, #1a1f71 0%, #0d47a1 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 12px;
}

.settings-subtitle {
  color: #666;
  font-size: 1.1rem;
}

.settings-card {
  background: white;
  border-radius: 16px;
  padding: 40px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(0, 0, 0, 0.08);
  margin-bottom: 40px;
}

/* Form Sections */
.form-section {
  margin-bottom: 40px;
  padding-bottom: 40px;
  border-bottom: 1px solid #f0f0f0;
}

.form-section:last-of-type {
  border-bottom: none;
  margin-bottom: 0;
  padding-bottom: 0;
}

.section-title {
  font-size: 1.4rem;
  color: #1a1f71;
  margin-bottom: 24px;
  font-weight: 800;
  display: flex;
  align-items: center;
  gap: 12px;
}

.section-title i {
  color: #0d47a1;
  font-size: 1.6rem;
}

.form-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 24px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-label {
  font-weight: 600;
  color: #333;
  margin-bottom: 8px;
  font-size: 0.95rem;
  display: flex;
  align-items: center;
  gap: 8px;
}

.form-label i {
  color: #0d47a1;
}

.form-control {
  padding: 12px 16px;
  border: 2px solid #e0e7ff;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  background: #f8f9ff;
  font-family: inherit;
}

.form-control:focus {
  outline: none;
  border-color: #0d47a1;
  background: white;
  box-shadow: 0 0 0 3px rgba(13, 71, 161, 0.1);
}

.form-control::placeholder {
  color: #b0bec5;
}

.form-control[type="textarea"],
textarea.form-control {
  resize: vertical;
  min-height: 100px;
}

/* Form Actions */
.form-actions {
  display: flex;
  gap: 12px;
  justify-content: center;
  margin-top: 40px;
}

.btn {
  padding: 12px 28px;
  border: none;
  border-radius: 8px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  font-size: 0.95rem;
}

.btn-save {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
}

.btn-save:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(13, 71, 161, 0.3);
}

.btn-cancel {
  background: #f5f5f5;
  color: #666;
}

.btn-cancel:hover {
  background: #eeeeee;
  transform: translateY(-2px);
}

/* Alerts */
.alert {
  padding: 16px;
  border-radius: 8px;
  margin-top: 24px;
  display: flex;
  align-items: center;
  animation: slideUp 0.4s ease-out;
}

.alert-success {
  background: #e8f5e9;
  border: 2px solid #4caf50;
  color: #2e7d32;
}

.alert-error {
  background: #ffebee;
  border: 2px solid #d32f2f;
  color: #c62828;
}

.alert i {
  font-size: 1.3rem;
}

/* Preview Section */
.preview-section {
  background: white;
  border-radius: 16px;
  padding: 40px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(0, 0, 0, 0.08);
}

.preview-title {
  font-size: 1.5rem;
  color: #1a1f71;
  margin-bottom: 30px;
  font-weight: 800;
  display: flex;
  align-items: center;
  gap: 12px;
}

.preview-title i {
  color: #0d47a1;
}

.preview-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 24px;
}

.preview-card {
  background: #f8f9ff;
  border: 2px solid #e0e7ff;
  border-radius: 12px;
  padding: 24px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.preview-card:hover {
  border-color: #0d47a1;
  box-shadow: 0 6px 20px rgba(13, 71, 161, 0.1);
}

.preview-card h3 {
  color: #1a1f71;
  font-size: 1.1rem;
  margin-bottom: 16px;
  font-weight: 700;
}

.preview-content {
  padding: 16px;
  background: white;
  border-radius: 8px;
  border: 1px solid #e0e7ff;
}

.navbar-preview {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 16px;
}

.preview-logo {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #1a1f71 0%, #0d47a1 100%);
  border-radius: 8px;
  color: white;
  font-size: 1.5rem;
}

.logo-img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  border-radius: 8px;
}

.shop-name-preview {
  font-weight: 800;
  color: #1a1f71;
  font-size: 1.1rem;
  letter-spacing: -0.5px;
}

.footer-preview {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.preview-item {
  display: flex;
  align-items: center;
  gap: 12px;
  color: #666;
  font-size: 0.95rem;
}

.preview-item i {
  color: #0d47a1;
  font-size: 1.2rem;
  flex-shrink: 0;
}

/* Animations */
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

/* Responsive */
@media (max-width: 768px) {
  .settings-title {
    font-size: 1.8rem;
  }

  .settings-card {
    padding: 24px;
  }

  .section-title {
    font-size: 1.1rem;
  }

  .form-actions {
    flex-direction: column;
  }

  .btn {
    width: 100%;
  }

  .form-row {
    grid-template-columns: 1fr;
  }

  .preview-grid {
    grid-template-columns: 1fr;
  }
}
</style>
