<template>
  <div class="form-container">
    <div class="container py-4">
      <!-- Back Button -->
      <router-link 
        to="/admin/products"
        class="btn-back"
      >
        <i class="bi bi-arrow-left-short"></i>
        Back to Products
      </router-link>

      <!-- Form Card -->
      <div class="form-card">
        <div class="form-header">
          <h2 class="form-title">{{ isEdit ? 'Edit Product' : 'Add New Product' }}</h2>
          <p class="form-subtitle">
            {{ isEdit ? 'Update product details' : 'Create a new product to your store' }}
          </p>
        </div>

        <form @submit.prevent="submitForm" class="product-form">
          <!-- Product Name -->
          <div class="form-group">
            <label class="form-label">Product Name <span class="required">*</span></label>
            <div class="input-wrapper">
              <i class="bi bi-box"></i>
              <input
                type="text"
                class="form-input"
                v-model="formData.name"
                placeholder="Enter product name"
                required
              />
            </div>
          </div>

          <!-- Description -->
          <div class="form-group">
            <label class="form-label">Description</label>
            <textarea
              class="form-textarea"
              rows="4"
              v-model="formData.description"
              placeholder="Enter product description"
            ></textarea>
          </div>

          <!-- Price & Stock Row -->
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Price <span class="required">*</span></label>
              <div class="input-wrapper">
                <span class="currency">$</span>
                <input
                  type="number"
                  step="0.01"
                  class="form-input"
                  v-model="formData.price"
                  placeholder="0.00"
                  required
                />
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Stock <span class="required">*</span></label>
              <div class="input-wrapper">
                <i class="bi bi-bag"></i>
                <input
                  type="number"
                  class="form-input"
                  v-model="formData.stock"
                  placeholder="0"
                  required
                />
              </div>
            </div>
          </div>

          <!-- Image URL -->
          <div class="form-group">
            <label class="form-label">Image URL</label>
            <div class="input-wrapper">
              <i class="bi bi-image"></i>
              <input
                type="url"
                class="form-input"
                v-model="formData.image_url"
                placeholder="https://example.com/image.jpg"
              />
            </div>
          </div>

          <!-- Status -->
          <div class="form-group">
            <label class="form-label">Status <span class="required">*</span></label>
            <select class="form-select" v-model="formData.status">
              <option value="ACTIVE">Active</option>
              <option value="INACTIVE">Inactive</option>
            </select>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn-submit">
            <i :class="isEdit ? 'bi bi-pencil-square' : 'bi bi-check-circle'"></i>
            {{ isEdit ? 'Update Product' : 'Create Product' }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../../services/api";

export default {
  name: "ProductForm",
  data() {
    return {
      formData: {
        name: "",
        description: "",
        price: "",
        stock: "",
        image_url: "",
        status: "ACTIVE",
      },
    };
  },
  computed: {
    isEdit() {
      return !!this.$route.params.id;
    },
  },
  mounted() {
    if (this.isEdit) {
      this.fetchProduct();
    }
  },
  methods: {
    async fetchProduct() {
      try {
        const res = await api.getProduct(this.$route.params.id);
        this.formData = res.data;
      } catch (err) {
        alert("Failed to load product");
      }
    },

    async submitForm() {
      try {
        if (this.isEdit) {
          await api.updateProduct(this.$route.params.id, this.formData);
        } else {
          await api.createProduct(this.formData);
        }
        this.$router.push("/admin/products");
      } catch (err) {
        alert("Failed to save product");
      }
    },
  },
};
</script>

<style scoped>
.form-container {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
  padding-top: 20px;
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

.form-card {
  background: white;
  border-radius: 16px;
  padding: 40px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
  border: 1px solid rgba(0, 0, 0, 0.08);
  animation: slideUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
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

.product-form {
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

.input-wrapper.currency::before {
  content: '';
}

.currency {
  position: absolute;
  left: 16px;
  color: #0d47a1;
  font-weight: 700;
  font-size: 1.2rem;
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
  min-height: 120px;
}

.form-select {
  width: 100%;
  padding: 14px 16px;
  border: 2px solid #e0e7ff;
  border-radius: 10px;
  font-size: 1rem;
  font-family: inherit;
  background: #f8f9ff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%230d47a1' d='M6 9L1 4h10z'/%3E%3C/svg%3E") no-repeat;
  background-position: right 16px center;
  background-repeat: no-repeat;
  padding-right: 40px;
  appearance: none;
  color: #1a1f71;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.form-select:focus {
  outline: none;
  border-color: #0d47a1;
  background-color: white;
  box-shadow: 0 0 0 4px rgba(13, 71, 161, 0.1), inset 0 2px 4px rgba(0, 0, 0, 0.05);
  transform: translateY(-2px);
}

.form-select option {
  background: white;
  color: #1a1f71;
  padding: 8px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.btn-submit {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
  border: none;
  padding: 16px 32px;
  border-radius: 10px;
  font-weight: 700;
  font-size: 1rem;
  cursor: pointer;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin-top: 10px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 4px 15px rgba(13, 71, 161, 0.2);
}

.btn-submit:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(13, 71, 161, 0.4);
  filter: brightness(1.1);
}

.btn-submit:active {
  transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 768px) {
  .form-card {
    padding: 24px;
  }

  .form-title {
    font-size: 1.5rem;
  }

  .form-row {
    grid-template-columns: 1fr;
    gap: 16px;
  }

  .btn-submit {
    padding: 14px 24px;
    font-size: 0.95rem;
  }
}
</style>