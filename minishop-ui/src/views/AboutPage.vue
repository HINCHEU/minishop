<template>
  <div class="about-container">
    <div class="container py-5">
      <!-- Hero Section -->
      <div class="about-hero">
        <h1 class="about-title">About Mini-Shop</h1>
        <p class="about-subtitle">Bringing quality products and exceptional service to your doorstep</p>
      </div>

      <!-- Story Section -->
      <div class="content-section">
        <div class="section-card">
          <div class="section-header">
            <i class="bi bi-book"></i>
            <h2>Our Story</h2>
          </div>
          <p class="section-text">
            Founded in 2024, Mini-Shop was created with a simple vision: to provide customers with 
            high-quality products at affordable prices. What started as a small marketplace has grown 
            into a trusted destination for thousands of customers seeking reliability and excellent service.
          </p>
          <p class="section-text">
            Our journey is built on the foundation of trust, transparency, and a genuine commitment to 
            customer satisfaction. Every product in our catalog is carefully selected to ensure it meets 
            our rigorous quality standards.
          </p>
        </div>
      </div>

      <!-- Mission Section -->
      <div class="content-section">
        <div class="section-card">
          <div class="section-header">
            <i class="bi bi-target"></i>
            <h2>Our Mission</h2>
          </div>
          <p class="section-text">
            To empower customers with access to premium products while maintaining the highest standards 
            of service, integrity, and innovation. We believe in making quality shopping convenient, 
            affordable, and enjoyable for everyone.
          </p>
        </div>
      </div>

      <!-- Values Section -->
      <div class="content-section">
        <div class="section-card">
          <div class="section-header">
            <i class="bi bi-heart"></i>
            <h2>Our Core Values</h2>
          </div>
          <div class="values-grid">
            <div class="value-item">
              <div class="value-icon">
                <i class="bi bi-check-circle"></i>
              </div>
              <h3>Quality First</h3>
              <p>We never compromise on product quality or customer service</p>
            </div>
            <div class="value-item">
              <div class="value-icon">
                <i class="bi bi-handshake"></i>
              </div>
              <h3>Trust & Transparency</h3>
              <p>Honest communication and transparent practices in all our dealings</p>
            </div>
            <div class="value-item">
              <div class="value-icon">
                <i class="bi bi-lightning"></i>
              </div>
              <h3>Innovation</h3>
              <p>Continuously improving our platform and services for better experiences</p>
            </div>
            <div class="value-item">
              <div class="value-icon">
                <i class="bi bi-people"></i>
              </div>
              <h3>Customer Focused</h3>
              <p>Your satisfaction is our priority and drives everything we do</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Stats Section -->
      <div class="stats-section">
        <div class="stat-card">
          <div class="stat-number">10K+</div>
          <div class="stat-label">Happy Customers</div>
        </div>
        <div class="stat-card">
          <div class="stat-number">500+</div>
          <div class="stat-label">Products Available</div>
        </div>
        <div class="stat-card">
          <div class="stat-number">24/7</div>
          <div class="stat-label">Customer Support</div>
        </div>
        <div class="stat-card">
          <div class="stat-number">100%</div>
          <div class="stat-label">Satisfaction Guaranteed</div>
        </div>
      </div>

      <!-- CTA Section -->
      <div class="cta-section">
        <h2>Ready to Shop?</h2>
        <p>Browse our collection of premium products today</p>
        <router-link to="/" class="btn-cta">
          <i class="bi bi-shop me-2"></i>
          Start Shopping
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AboutPage'
}
</script>

<style scoped>
.about-container {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
  padding-bottom: 40px;
}

.about-hero {
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

.about-title {
  font-size: 3.5rem;
  font-weight: 800;
  background: linear-gradient(135deg, #1a1f71 0%, #0d47a1 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 20px;
  letter-spacing: -1px;
}

.about-subtitle {
  font-size: 1.3rem;
  color: #666;
  max-width: 600px;
  margin: 0 auto;
  line-height: 1.6;
}

.content-section {
  margin-bottom: 40px;
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

.section-card {
  background: white;
  border-radius: 16px;
  padding: 40px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(0, 0, 0, 0.08);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.section-card:hover {
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
  transform: translateY(-4px);
}

.section-header {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 24px;
}

.section-header i {
  font-size: 2.5rem;
  color: #0d47a1;
}

.section-header h2 {
  font-size: 2rem;
  color: #1a1f71;
  margin: 0;
  font-weight: 800;
}

.section-text {
  font-size: 1rem;
  color: #666;
  line-height: 1.8;
  margin-bottom: 16px;
}

.section-text:last-child {
  margin-bottom: 0;
}

/* Values Grid */
.values-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
  margin-top: 30px;
}

.value-item {
  text-align: center;
  padding: 30px;
  background: #f8f9ff;
  border-radius: 12px;
  border: 2px solid #e0e7ff;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.value-item:hover {
  background: white;
  border-color: #0d47a1;
  transform: translateY(-8px);
  box-shadow: 0 8px 24px rgba(13, 71, 161, 0.15);
}

.value-icon {
  font-size: 3rem;
  color: #0d47a1;
  margin-bottom: 16px;
}

.value-item h3 {
  font-size: 1.2rem;
  color: #1a1f71;
  margin: 16px 0;
  font-weight: 700;
}

.value-item p {
  color: #666;
  margin: 0;
  font-size: 0.95rem;
  line-height: 1.6;
}

/* Stats Section */
.stats-section {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 24px;
  margin: 60px 0;
}

.stat-card {
  background: white;
  border-radius: 12px;
  padding: 40px 30px;
  text-align: center;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(0, 0, 0, 0.08);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.stat-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 32px rgba(13, 71, 161, 0.2);
}

.stat-number {
  font-size: 2.8rem;
  font-weight: 800;
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 12px;
}

.stat-label {
  color: #666;
  font-weight: 600;
  font-size: 1rem;
}

/* CTA Section */
.cta-section {
  background: white;
  border-radius: 16px;
  padding: 60px 40px;
  text-align: center;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
  border: 1px solid rgba(0, 0, 0, 0.08);
  margin-top: 60px;
}

.cta-section h2 {
  font-size: 2.5rem;
  color: #1a1f71;
  margin: 0 0 12px 0;
  font-weight: 800;
}

.cta-section p {
  color: #666;
  font-size: 1.1rem;
  margin: 0 0 30px 0;
}

.btn-cta {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
  padding: 14px 40px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.btn-cta:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 30px rgba(13, 71, 161, 0.4);
  filter: brightness(1.1);
}

/* Responsive */
@media (max-width: 768px) {
  .about-title {
    font-size: 2rem;
  }

  .about-subtitle {
    font-size: 1rem;
  }

  .section-card {
    padding: 24px;
  }

  .section-header i {
    font-size: 2rem;
  }

  .section-header h2 {
    font-size: 1.5rem;
  }

  .values-grid {
    grid-template-columns: 1fr;
    gap: 20px;
  }

  .stat-card {
    padding: 30px 20px;
  }

  .stat-number {
    font-size: 2rem;
  }

  .cta-section {
    padding: 40px 24px;
  }

  .cta-section h2 {
    font-size: 1.8rem;
  }
}
</style>
