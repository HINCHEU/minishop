<template>
  <div class="contact-container">
    <div class="container py-5">
      <!-- Hero Section -->
      <div class="contact-hero">
        <h1 class="contact-title">Get In Touch</h1>
        <p class="contact-subtitle">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
      </div>

      <div class="contact-content">
        <!-- Contact Form -->
        <div class="form-section">
          <div class="form-card">
            <h2 class="form-title">Send us a Message</h2>
            <form @submit.prevent="submitForm">
              <div class="form-group">
                <label for="name" class="form-label">
                  <i class="bi bi-person"></i>
                  Your Name
                </label>
                <input
                  type="text"
                  id="name"
                  v-model="form.name"
                  class="form-input"
                  placeholder="John Doe"
                  required
                />
              </div>

              <div class="form-group">
                <label for="email" class="form-label">
                  <i class="bi bi-envelope"></i>
                  Email Address
                </label>
                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  class="form-input"
                  placeholder="john@example.com"
                  required
                />
              </div>

              <div class="form-group">
                <label for="subject" class="form-label">
                  <i class="bi bi-chat-square"></i>
                  Subject
                </label>
                <input
                  type="text"
                  id="subject"
                  v-model="form.subject"
                  class="form-input"
                  placeholder="How can we help?"
                  required
                />
              </div>

              <div class="form-group">
                <label for="message" class="form-label">
                  <i class="bi bi-pencil-square"></i>
                  Message
                </label>
                <textarea
                  id="message"
                  v-model="form.message"
                  class="form-textarea"
                  rows="6"
                  placeholder="Tell us more about your inquiry..."
                  required
                ></textarea>
              </div>

              <button type="submit" class="btn-submit">
                <i class="bi bi-send me-2"></i>
                Send Message
              </button>

              <div v-if="formSubmitted" class="success-message">
                <i class="bi bi-check-circle"></i>
                Thank you! We'll get back to you soon.
              </div>
            </form>
          </div>
        </div>

        <!-- Contact Info -->
        <div class="info-section">
          <!-- Email Card -->
          <div class="info-card">
            <div class="info-icon">
              <i class="bi bi-envelope"></i>
            </div>
            <h3>Email</h3>
            <p><a href="mailto:support@minishop.com">support@minishop.com</a></p>
            <span class="response-time">Response time: 2-4 hours</span>
          </div>

          <!-- Phone Card -->
          <div class="info-card">
            <div class="info-icon">
              <i class="bi bi-telephone"></i>
            </div>
            <h3>Phone</h3>
            <p><a href="tel:+1234567890">+1 (234) 567-890</a></p>
            <span class="response-time">Available: Mon-Fri, 9AM-6PM</span>
          </div>

          <!-- Address Card -->
          <div class="info-card">
            <div class="info-icon">
              <i class="bi bi-geo-alt"></i>
            </div>
            <h3>Address</h3>
            <p>123 Shopping Street<br/>Commerce City, ST 12345<br/>United States</p>
            <span class="response-time">Visit our office</span>
          </div>

          <!-- Hours Card -->
          <div class="info-card">
            <div class="info-icon">
              <i class="bi bi-clock"></i>
            </div>
            <h3>Business Hours</h3>
            <div class="hours-list">
              <div>Monday - Friday: 9:00 AM - 6:00 PM</div>
              <div>Saturday: 10:00 AM - 4:00 PM</div>
              <div>Sunday: Closed</div>
            </div>
          </div>
        </div>
      </div>

      <!-- FAQ Section -->
      <div class="faq-section">
        <h2>Frequently Asked Questions</h2>
        <div class="faq-grid">
          <div class="faq-item">
            <h4>How long does delivery take?</h4>
            <p>Standard delivery takes 3-5 business days. Express delivery options are available at checkout.</p>
          </div>
          <div class="faq-item">
            <h4>What's your return policy?</h4>
            <p>We offer a 30-day return policy on all items. Products must be unused and in original packaging.</p>
          </div>
          <div class="faq-item">
            <h4>Do you ship internationally?</h4>
            <p>Currently, we ship to select countries. Check our shipping page for available locations.</p>
          </div>
          <div class="faq-item">
            <h4>What payment methods do you accept?</h4>
            <p>We accept all major credit cards, PayPal, and digital wallets for secure transactions.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'ContactPage',
  setup() {
    const form = ref({
      name: '',
      email: '',
      subject: '',
      message: ''
    })

    const formSubmitted = ref(false)

    const submitForm = () => {
      // In a real app, you'd send this data to a backend
      console.log('Form submitted:', form.value)
      
      // Show success message
      formSubmitted.value = true
      
      // Reset form
      form.value = {
        name: '',
        email: '',
        subject: '',
        message: ''
      }
      
      // Hide success message after 5 seconds
      setTimeout(() => {
        formSubmitted.value = false
      }, 5000)
    }

    return {
      form,
      formSubmitted,
      submitForm
    }
  }
}
</script>

<style scoped>
.contact-container {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
  padding-bottom: 40px;
}

.contact-hero {
  text-align: center;
  margin-bottom: 50px;
  padding: 60px 20px;
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

.contact-title {
  font-size: 3.5rem;
  font-weight: 800;
  background: linear-gradient(135deg, #1a1f71 0%, #0d47a1 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 20px;
  letter-spacing: -1px;
}

.contact-subtitle {
  font-size: 1.3rem;
  color: #666;
  max-width: 600px;
  margin: 0 auto;
  line-height: 1.6;
}

.contact-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
  margin-bottom: 60px;
  animation: slideUp 0.6s ease-out;
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

/* Form Section */
.form-section {
  min-height: 100%;
}

.form-card {
  background: white;
  border-radius: 16px;
  padding: 40px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(0, 0, 0, 0.08);
  height: 100%;
}

.form-title {
  font-size: 1.8rem;
  color: #1a1f71;
  margin: 0 0 30px 0;
  font-weight: 800;
}

.form-group {
  margin-bottom: 24px;
}

.form-label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: 600;
  color: #333;
  margin-bottom: 8px;
  font-size: 0.95rem;
}

.form-label i {
  color: #0d47a1;
  font-size: 1.1rem;
}

.form-input,
.form-textarea {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid #e0e7ff;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  font-family: inherit;
  background: #f8f9ff;
}

.form-input:focus,
.form-textarea:focus {
  outline: none;
  border-color: #0d47a1;
  background: white;
  box-shadow: 0 0 0 3px rgba(13, 71, 161, 0.1);
}

.form-textarea {
  resize: vertical;
  min-height: 120px;
}

.btn-submit {
  width: 100%;
  padding: 14px 24px;
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.btn-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 30px rgba(13, 71, 161, 0.4);
  filter: brightness(1.1);
}

.btn-submit:active {
  transform: translateY(0);
}

.success-message {
  margin-top: 20px;
  padding: 16px;
  background: #e8f5e9;
  border: 2px solid #4caf50;
  border-radius: 8px;
  color: #2e7d32;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 12px;
  animation: slideUp 0.4s ease-out;
}

.success-message i {
  font-size: 1.5rem;
}

/* Info Section */
.info-section {
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;
}

.info-card {
  background: white;
  border-radius: 12px;
  padding: 28px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(0, 0, 0, 0.08);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  animation: slideUp 0.6s ease-out;
}

.info-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 40px rgba(13, 71, 161, 0.15);
}

.info-icon {
  font-size: 2.5rem;
  color: #0d47a1;
  margin-bottom: 12px;
}

.info-card h3 {
  font-size: 1.3rem;
  color: #1a1f71;
  margin: 12px 0;
  font-weight: 800;
}

.info-card p {
  color: #666;
  margin: 12px 0;
  font-weight: 500;
  line-height: 1.6;
}

.info-card a {
  color: #0d47a1;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.3s ease;
}

.info-card a:hover {
  color: #1565c0;
  text-decoration: underline;
}

.response-time {
  display: block;
  font-size: 0.85rem;
  color: #999;
  margin-top: 8px;
  font-style: italic;
}

.hours-list {
  font-size: 0.95rem;
  color: #666;
  line-height: 1.8;
}

/* FAQ Section */
.faq-section {
  background: white;
  border-radius: 16px;
  padding: 50px 40px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(0, 0, 0, 0.08);
}

.faq-section h2 {
  font-size: 2.2rem;
  color: #1a1f71;
  margin: 0 0 40px 0;
  font-weight: 800;
  text-align: center;
}

.faq-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 30px;
}

.faq-item {
  padding: 24px;
  background: #f8f9ff;
  border-radius: 12px;
  border: 2px solid #e0e7ff;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.faq-item:hover {
  border-color: #0d47a1;
  background: white;
  box-shadow: 0 6px 20px rgba(13, 71, 161, 0.12);
  transform: translateY(-4px);
}

.faq-item h4 {
  color: #1a1f71;
  margin: 0 0 12px 0;
  font-weight: 700;
  font-size: 1.1rem;
}

.faq-item p {
  color: #666;
  margin: 0;
  font-size: 0.95rem;
  line-height: 1.6;
}

/* Responsive */
@media (max-width: 1024px) {
  .contact-content {
    grid-template-columns: 1fr;
    gap: 30px;
  }
}

@media (max-width: 768px) {
  .contact-title {
    font-size: 2rem;
  }

  .contact-subtitle {
    font-size: 1rem;
  }

  .form-card {
    padding: 24px;
  }

  .form-title {
    font-size: 1.5rem;
  }

  .info-section {
    grid-template-columns: 1fr;
  }

  .faq-section {
    padding: 30px 20px;
  }

  .faq-section h2 {
    font-size: 1.6rem;
  }

  .faq-grid {
    grid-template-columns: 1fr;
    gap: 20px;
  }
}
</style>
