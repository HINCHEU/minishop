<template>
  <div class="detail-container">
    <div class="container py-4">
      <!-- Back Button -->
      <router-link to="/" class="btn-back">
        <i class="bi bi-arrow-left-short"></i>
        Back to Products
      </router-link>

      <!-- Loading State -->
      <div v-if="loading" class="loading-state">
        <div class="modern-spinner"></div>
        <p class="loading-text">Loading product details...</p>
      </div>

      <!-- Product Detail -->
      <div v-else-if="product" class="product-detail">
        <div class="detail-grid">
          <!-- Image Section -->
          <div class="image-section">
            <div class="image-wrapper">
              <img 
                :src="product.image_url || 'https://via.placeholder.com/600x400?text=No+Image'" 
                class="detail-image" 
                :alt="product.name"
              >
              <div class="stock-badge" :class="product.stock > 0 ? 'in-stock' : 'out-of-stock'">
                {{ product.stock > 0 ? 'In Stock' : 'Out of Stock' }}
              </div>
            </div>
          </div>

          <!-- Details Section -->
          <div class="details-section">
            <div class="details-card">
              <h1 class="product-name">{{ product.name }}</h1>
              
              <div class="rating-section">
                <div class="stars">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-half"></i>
                </div>
                <span class="rating-text">(127 reviews)</span>
              </div>

              <h2 class="price">${{ parseFloat(product.price).toFixed(2) }}</h2>

              <p class="description">{{ product.description || 'Premium quality product with excellent features.' }}</p>

              <!-- Stock Info -->
              <div class="info-box">
                <div class="info-item">
                  <span class="info-label">Stock Available:</span>
                  <span class="info-value">{{ product.stock }} units</span>
                </div>
                <div class="info-item">
                  <span class="info-label">Status:</span>
                  <span class="info-value" :class="product.status === 'ACTIVE' ? 'status-active' : 'status-inactive'">
                    {{ product.status }}
                  </span>
                </div>
              </div>

              <!-- Quantity Selector -->
              <div class="quantity-section">
                <label class="qty-label">Select Quantity:</label>
                <div class="quantity-selector">
                  <button 
                    class="qty-btn"
                    @click="decreaseQuantity"
                    :disabled="quantity <= 1"
                  >
                    <i class="bi bi-dash-lg"></i>
                  </button>
                  <input 
                    type="number" 
                    class="qty-input"
                    v-model.number="quantity"
                    min="1"
                    :max="product.stock"
                  >
                  <button 
                    class="qty-btn"
                    @click="increaseQuantity"
                    :disabled="quantity >= product.stock"
                  >
                    <i class="bi bi-plus-lg"></i>
                  </button>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="action-buttons">
                <button 
                  class="btn-add-cart"
                  @click="addToCartAndNavigate"
                  :disabled="product.stock <= 0"
                >
                  <i class="bi bi-cart-plus"></i>
                  Add to Cart - ${{ (parseFloat(product.price) * quantity).toFixed(2) }}
                </button>
                <button class="btn-wishlist">
                  <i class="bi bi-heart"></i>
                  Save for Later
                </button>
              </div>

              <!-- Features -->
              <div class="features-section">
                <h3 class="features-title">Why You'll Love This</h3>
                <div class="features-list">
                  <div class="feature">
                    <i class="bi bi-check-circle"></i>
                    <span>Premium Quality Guaranteed</span>
                  </div>
                  <div class="feature">
                    <i class="bi bi-check-circle"></i>
                    <span>Fast & Free Shipping</span>
                  </div>
                  <div class="feature">
                    <i class="bi bi-check-circle"></i>
                    <span>30-Day Money Back Guarantee</span>
                  </div>
                  <div class="feature">
                    <i class="bi bi-check-circle"></i>
                    <span>24/7 Customer Support</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Comments Section -->
        <div class="comments-section">
          <h2 class="comments-title">
            <i class="bi bi-chat-dots"></i>
            Customer Reviews & Comments
          </h2>

          <!-- Comments List -->
          <div class="comments-list">
            <div v-if="comments.length === 0" class="no-comments">
              <i class="bi bi-chat-left"></i>
              <p>No comments yet. Be the first to share your thoughts!</p>
            </div>
            <div v-for="comment in comments" :key="comment.id" class="comment-card">
              <div class="comment-header">
                <div class="comment-user">
                  <div class="user-avatar">{{ comment.guest_name.charAt(0).toUpperCase() }}</div>
                  <div class="user-info">
                    <h4 class="user-name">{{ comment.guest_name }}</h4>
                    <div class="comment-rating">
                      <span v-for="n in 5" :key="n" class="star">
                        <i :class="n <= comment.rating ? 'bi bi-star-fill' : 'bi bi-star'"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <span class="comment-date">{{ formatDate(comment.created_at) }}</span>
              </div>
              <p class="comment-text">{{ comment.comment_text }}</p>
            </div>
          </div>

          <!-- Comment Form -->
          <div class="comment-form-section">
            <h3 class="form-title">
              <i class="bi bi-pencil-square"></i>
              Leave a Comment
            </h3>
            <form @submit.prevent="submitComment" class="comment-form">
              <div class="form-row">
                <div class="form-group col-6">
                  <label for="guestName" class="form-label">Your Name</label>
                  <input
                    type="text"
                    id="guestName"
                    v-model="commentForm.guest_name"
                    class="form-control"
                    placeholder="John Doe"
                    required
                  />
                </div>
                <div class="form-group col-6">
                  <label for="guestEmail" class="form-label">Your Email</label>
                  <input
                    type="email"
                    id="guestEmail"
                    v-model="commentForm.guest_email"
                    class="form-control"
                    placeholder="john@example.com"
                    required
                  />
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Rating</label>
                <div class="rating-selector">
                  <button
                    v-for="n in 5"
                    :key="n"
                    type="button"
                    class="star-button"
                    :class="{ active: commentForm.rating >= n }"
                    @click="commentForm.rating = n"
                  >
                    <i :class="commentForm.rating >= n ? 'bi bi-star-fill' : 'bi bi-star'"></i>
                  </button>
                </div>
              </div>

              <div class="form-group">
                <label for="commentText" class="form-label">Your Comment</label>
                <textarea
                  id="commentText"
                  v-model="commentForm.comment_text"
                  class="form-control"
                  rows="4"
                  placeholder="Share your experience with this product..."
                  required
                ></textarea>
              </div>

              <button type="submit" class="btn-submit-comment" :disabled="submittingComment">
                <i class="bi bi-send me-2"></i>
                {{ submittingComment ? 'Posting...' : 'Post Comment' }}
              </button>

              <div v-if="commentMessage" class="comment-message" :class="commentMessageType">
                {{ commentMessage }}
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../services/api'
import { cartStore } from '../stores/cart'

export default {
  name: 'ProductDetail',
  setup() {
    const route = useRoute()
    const router = useRouter()
    const product = ref(null)
    const loading = ref(true)
    const quantity = ref(1)
    
    const fetchProduct = async () => {
      loading.value = true
      try {
        const response = await api.getProduct(route.params.id)
        product.value = response.data
      } catch (error) {
        console.error('Error fetching product:', error)
      }
      loading.value = false
    }
    
    const increaseQuantity = () => {
      if (quantity.value < product.value.stock) {
        quantity.value++
      }
    }
    
    const decreaseQuantity = () => {
      if (quantity.value > 1) {
        quantity.value--
      }
    }
    
    const addToCartAndNavigate = () => {
      cartStore.addItem(product.value, quantity.value)
      router.push('/cart')
    }

    // Comments functionality
    const comments = ref([])
    const commentForm = ref({
      guest_name: '',
      guest_email: '',
      comment_text: '',
      rating: 5
    })
    const submittingComment = ref(false)
    const commentMessage = ref('')
    const commentMessageType = ref('')

    const fetchComments = async () => {
      try {
        const response = await fetch(`/api/products/${route.params.id}/comments`)
        if (response.ok) {
          const data = await response.json()
          comments.value = data.data || []
        }
      } catch (error) {
        console.error('Error fetching comments:', error)
      }
    }

    const formatDate = (dateString) => {
      const date = new Date(dateString)
      const options = { year: 'numeric', month: 'short', day: 'numeric' }
      return date.toLocaleDateString('en-US', options)
    }

    const submitComment = async () => {
      if (!commentForm.value.guest_name || !commentForm.value.guest_email || !commentForm.value.comment_text) {
        commentMessage.value = 'Please fill in all fields'
        commentMessageType.value = 'error'
        return
      }

      submittingComment.value = true
      commentMessage.value = ''

      try {
        const response = await fetch(`/api/products/${route.params.id}/comments`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(commentForm.value)
        })

        if (response.ok) {
          const data = await response.json()
          commentMessage.value = 'Thank you! Your comment has been posted.'
          commentMessageType.value = 'success'

          // Reset form
          commentForm.value = {
            guest_name: '',
            guest_email: '',
            comment_text: '',
            rating: 5
          }

          // Refresh comments
          await fetchComments()

          // Clear message after 3 seconds
          setTimeout(() => {
            commentMessage.value = ''
          }, 3000)
        } else {
          // Handle error response
          let errorMessage = 'Error posting comment. Please try again.'
          try {
            const errorData = await response.json()
            if (errorData.message) {
              errorMessage = errorData.message
            } else if (errorData.errors) {
              // Handle validation errors
              const firstError = Object.values(errorData.errors)[0]
              errorMessage = Array.isArray(firstError) ? firstError[0] : firstError
            }
          } catch (parseError) {
            // Response is not JSON, use status text
            errorMessage = response.statusText || 'Error posting comment. Please try again.'
          }
          commentMessage.value = errorMessage
          commentMessageType.value = 'error'
          console.error('Server error:', response.status, errorMessage)
        }
      } catch (error) {
        console.error('Error submitting comment:', error)
        commentMessage.value = 'Network error. Please check your connection and try again.'
        commentMessageType.value = 'error'
      } finally {
        submittingComment.value = false
      }
    }
    
    onMounted(() => {
      fetchProduct()
      fetchComments()
    })
    
    return {
      product,
      loading,
      quantity,
      increaseQuantity,
      decreaseQuantity,
      addToCartAndNavigate,
      comments,
      commentForm,
      submittingComment,
      commentMessage,
      commentMessageType,
      fetchComments,
      submitComment,
      formatDate
    }
  }
}
</script>

<style scoped>
.detail-container {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
  padding-bottom: 40px;
}

.btn-back {
  display: inline-flex;
  align-items: center;
  color: #0d47a1;
  text-decoration: none;
  font-weight: 600;
  margin-bottom: 30px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  font-size: 1rem;
}

.btn-back:hover {
  color: #1565c0;
  transform: translateX(-4px);
}

.btn-back i {
  font-size: 1.3rem;
  margin-right: 4px;
}

/* Loading State */
.loading-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 80px 20px;
  text-align: center;
}

.modern-spinner {
  width: 50px;
  height: 50px;
  border: 4px solid #e0e7ff;
  border-top: 4px solid #0d47a1;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.loading-text {
  color: #888;
  margin-top: 16px;
}

/* Product Detail Grid */
.product-detail {
  animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.detail-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
  align-items: start;
}

/* Image Section */
.image-section {
  position: sticky;
  top: 100px;
}

.image-wrapper {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  background: white;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.detail-image {
  width: 100%;
  display: block;
  aspect-ratio: 1;
  object-fit: cover;
  transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.image-wrapper:hover .detail-image {
  transform: scale(1.08);
}

.stock-badge {
  position: absolute;
  top: 20px;
  right: 20px;
  padding: 10px 16px;
  border-radius: 20px;
  font-weight: 700;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  backdrop-filter: blur(8px);
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

/* Details Section */
.details-section {
  display: flex;
  flex-direction: column;
}

.details-card {
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

.product-name {
  font-size: 2.2rem;
  font-weight: 800;
  color: #1a1f71;
  margin-bottom: 16px;
  letter-spacing: -0.5px;
  line-height: 1.3;
}

/* Rating Section */
.rating-section {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 20px;
}

.stars {
  display: flex;
  gap: 4px;
  color: #ffc107;
  font-size: 1.1rem;
}

.rating-text {
  color: #888;
  font-size: 0.9rem;
}

/* Price */
.price {
  font-size: 2.5rem;
  font-weight: 800;
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin: 20px 0;
  letter-spacing: -1px;
}

/* Description */
.description {
  font-size: 1rem;
  color: #666;
  line-height: 1.8;
  margin-bottom: 30px;
}

/* Info Box */
.info-box {
  background: #f8f9ff;
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 30px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  border: 2px solid #e0e7ff;
}

.info-item {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.info-label {
  font-weight: 600;
  color: #1a1f71;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.info-value {
  color: #0d47a1;
  font-weight: 700;
  font-size: 1.1rem;
}

.status-active {
  background: rgba(76, 175, 80, 0.2);
  color: #2e7d32 !important;
  padding: 4px 8px;
  border-radius: 4px;
  display: inline-block;
}

.status-inactive {
  background: rgba(158, 158, 158, 0.2);
  color: #616161 !important;
  padding: 4px 8px;
  border-radius: 4px;
  display: inline-block;
}

/* Quantity Section */
.quantity-section {
  margin-bottom: 30px;
}

.qty-label {
  display: block;
  font-weight: 700;
  color: #1a1f71;
  margin-bottom: 12px;
  text-transform: uppercase;
  letter-spacing: 0.3px;
  font-size: 0.9rem;
}

.quantity-selector {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #f5f7fa;
  border-radius: 8px;
  padding: 4px 8px;
  max-width: 150px;
}

.qty-btn {
  width: 36px;
  height: 36px;
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

.qty-btn:hover:not(:disabled) {
  background: #0d47a1;
  color: white;
  transform: scale(1.1);
}

.qty-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.qty-input {
  flex: 1;
  border: none;
  background: transparent;
  text-align: center;
  font-weight: 700;
  color: #1a1f71;
  font-size: 1.1rem;
}

.qty-input:focus {
  outline: none;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 12px;
  margin-bottom: 30px;
}

.btn-add-cart,
.btn-wishlist {
  padding: 16px 24px;
  border-radius: 10px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  border: none;
  font-size: 1rem;
}

.btn-add-cart {
  flex: 1;
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
  box-shadow: 0 4px 15px rgba(13, 71, 161, 0.2);
}

.btn-add-cart:hover:not(:disabled) {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(13, 71, 161, 0.4);
  filter: brightness(1.1);
}

.btn-add-cart:disabled {
  background: #ccc;
  cursor: not-allowed;
  opacity: 0.6;
}

.btn-wishlist {
  flex: 1;
  background: white;
  color: #0d47a1;
  border: 2px solid #0d47a1;
}

.btn-wishlist:hover {
  background: #0d47a1;
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(13, 71, 161, 0.3);
}

/* Features Section */
.features-section {
  margin-top: 30px;
  padding-top: 30px;
  border-top: 2px solid #e0e7ff;
}

.features-title {
  font-size: 1.2rem;
  font-weight: 700;
  color: #1a1f71;
  margin-bottom: 16px;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.features-list {
  display: grid;
  gap: 12px;
}

.feature {
  display: flex;
  align-items: center;
  gap: 12px;
  color: #666;
  font-weight: 500;
}

.feature i {
  color: #4caf50;
  font-size: 1.2rem;
  flex-shrink: 0;
}

/* Comments Section */
.comments-section {
  margin-top: 50px;
  padding-top: 40px;
  border-top: 3px solid #e0e7ff;
}

.comments-title {
  font-size: 1.8rem;
  font-weight: 800;
  color: #1a1f71;
  margin-bottom: 30px;
  display: flex;
  align-items: center;
  gap: 12px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.comments-title i {
  color: #0d47a1;
  font-size: 2rem;
}

/* Comments List */
.comments-list {
  margin-bottom: 40px;
}

.no-comments {
  text-align: center;
  padding: 40px 20px;
  background: linear-gradient(135deg, #f5f7fa 0%, #e0e7ff 100%);
  border-radius: 12px;
  color: #888;
}

.no-comments i {
  font-size: 3rem;
  color: #ccc;
  display: block;
  margin-bottom: 12px;
}

.no-comments p {
  margin: 0;
  font-size: 1.1rem;
  color: #999;
}

.comment-card {
  background: white;
  border-radius: 12px;
  padding: 24px;
  margin-bottom: 16px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
  border: 1px solid #f0f0f0;
}

.comment-card:hover {
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
  transform: translateY(-2px);
}

.comment-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 16px;
}

.comment-user {
  display: flex;
  align-items: center;
  gap: 12px;
  flex: 1;
}

.user-avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1.2rem;
  flex-shrink: 0;
}

.user-info {
  flex: 1;
}

.user-name {
  margin: 0;
  font-weight: 700;
  color: #1a1f71;
  font-size: 1rem;
}

.comment-rating {
  display: flex;
  gap: 4px;
  margin-top: 4px;
}

.star {
  color: #ffc107;
  font-size: 0.85rem;
}

.comment-date {
  color: #999;
  font-size: 0.9rem;
  white-space: nowrap;
}

.comment-text {
  color: #666;
  line-height: 1.6;
  margin: 0;
  word-wrap: break-word;
}

/* Comment Form Section */
.comment-form-section {
  background: linear-gradient(135deg, #f5f7fa 0%, #e8ecff 100%);
  border-radius: 12px;
  padding: 32px;
  border: 2px solid #e0e7ff;
}

.form-title {
  font-size: 1.4rem;
  font-weight: 800;
  color: #1a1f71;
  margin-bottom: 24px;
  display: flex;
  align-items: center;
  gap: 12px;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}

.form-title i {
  color: #0d47a1;
  font-size: 1.6rem;
}

.comment-form {
  max-width: 100%;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group.col-6 {
  margin-bottom: 0;
}

.form-label {
  display: block;
  font-weight: 700;
  color: #1a1f71;
  margin-bottom: 8px;
  text-transform: uppercase;
  letter-spacing: 0.2px;
  font-size: 0.9rem;
}

.form-control {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid #d0d7ff;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: white;
  color: #333;
  font-family: inherit;
}

.form-control:focus {
  outline: none;
  border-color: #0d47a1;
  box-shadow: 0 0 0 3px rgba(13, 71, 161, 0.1);
  background: white;
}

.form-control::placeholder {
  color: #999;
}

textarea.form-control {
  resize: vertical;
  min-height: 100px;
}

/* Rating Selector */
.rating-selector {
  display: flex;
  gap: 12px;
}

.star-button {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  border: 2px solid #d0d7ff;
  background: white;
  color: #ffc107;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
  font-size: 1.4rem;
}

.star-button:hover {
  border-color: #ffc107;
  transform: scale(1.1);
}

.star-button.active {
  background: #ffc107;
  border-color: #ffc107;
  color: white;
}

/* Submit Button */
.btn-submit-comment {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
  padding: 14px 28px;
  border: none;
  border-radius: 8px;
  font-weight: 700;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-transform: uppercase;
  letter-spacing: 0.3px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  box-shadow: 0 4px 15px rgba(13, 71, 161, 0.2);
}

.btn-submit-comment:hover:not(:disabled) {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(13, 71, 161, 0.4);
  filter: brightness(1.1);
}

.btn-submit-comment:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Comment Message */
.comment-message {
  margin-top: 16px;
  padding: 12px 16px;
  border-radius: 8px;
  font-weight: 600;
  text-align: center;
  animation: slideUp 0.3s ease-out;
}

.comment-message.success {
  background: rgba(76, 175, 80, 0.15);
  color: #2e7d32;
  border: 1px solid rgba(76, 175, 80, 0.3);
}

.comment-message.error {
  background: rgba(244, 67, 54, 0.15);
  color: #c62828;
  border: 1px solid rgba(244, 67, 54, 0.3);
}

/* Responsive */
@media (max-width: 1024px) {
  .detail-grid {
    gap: 30px;
  }

  .image-section {
    position: static;
  }
}

@media (max-width: 768px) {
  .detail-grid {
    grid-template-columns: 1fr;
    gap: 20px;
  }

  .product-name {
    font-size: 1.8rem;
  }

  .price {
    font-size: 2rem;
  }

  .action-buttons {
    flex-direction: column;
  }

  .info-box {
    grid-template-columns: 1fr;
  }

  .form-row {
    grid-template-columns: 1fr;
    gap: 16px;
  }

  .comment-header {
    flex-direction: column;
    gap: 12px;
  }

  .comment-date {
    width: 100%;
    text-align: left;
  }

  .comments-title {
    font-size: 1.4rem;
  }

  .form-title {
    font-size: 1.2rem;
  }
}
</style>