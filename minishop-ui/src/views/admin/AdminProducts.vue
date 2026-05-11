<template>
  <div class="admin-container">
    <div class="container py-4">
      <!-- Header -->
      <div class="admin-header">
        <div>
          <h1 class="admin-title">Product Management</h1>
          <p class="admin-subtitle">Manage your product inventory</p>
        </div>
        <div class="header-actions">
          <router-link to="/admin/settings" class="btn btn-secondary btn-modern-add">
            <i class="bi bi-gear me-2"></i>
            Shop Settings
          </router-link>
          <router-link to="/admin/products/create" class="btn btn-primary btn-modern-add">
            <i class="bi bi-plus-lg me-2"></i>
            Add New Product
          </router-link>
        </div>
      </div>
      
      <!-- Table Card -->
      <div class="table-card shadow-sm">
        <div class="table-responsive">
          <table class="products-table">
            <thead>
              <tr>
                <th class="col-id">ID</th>
                <th class="col-name">Product Name</th>
                <th class="col-price">Price</th>
                <th class="col-stock">Stock</th>
                <th class="col-status">Status</th>
                <th class="col-actions">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products" :key="product.id" class="table-row">
                <td class="col-id"><span class="id-badge">{{ product.id }}</span></td>
                <td class="col-name"><strong>{{ product.name }}</strong></td>
                <td class="col-price"><span class="price-highlight">${{ parseFloat(product.price).toFixed(2) }}</span></td>
                <td class="col-stock">
                  <span class="stock-indicator" :class="product.stock > 10 ? 'high' : product.stock > 0 ? 'medium' : 'low'">
                    {{ product.stock }} units
                  </span>
                </td>
                <td class="col-status">
                  <span :class="['status-badge', product.status === 'ACTIVE' ? 'status-active' : 'status-inactive']">
                    {{ product.status }}
                  </span>
                </td>
                <td class="col-actions">
                  <div class="action-buttons">
                    <router-link 
                      :to="`/admin/products/${product.id}/edit`" 
                      class="btn-icon btn-edit"
                      title="Edit Product"
                    >
                      <i class="bi bi-pencil-square"></i>
                    </router-link>
                    <button 
                      class="btn-icon btn-delete" 
                      @click="deleteProduct(product.id)"
                      title="Delete Product"
                    >
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import api from '../../services/api'

export default {
  name: 'AdminProducts',
  setup() {
    const products = ref([])
    
    const fetchProducts = async () => {
      try {
        const response = await api.getAdminProducts()
        products.value = response.data
      } catch (error) {
        console.error('Error fetching products:', error)
      }
    }
    
    const deleteProduct = async (id) => {
      if (confirm('Are you sure you want to delete this product?')) {
        try {
          await api.deleteProduct(id)
          fetchProducts()
        } catch (error) {
          console.error('Error deleting product:', error)
        }
      }
    }
    
    onMounted(() => {
      fetchProducts()
    })
    
    return {
      products,
      deleteProduct
    }
  }
}
</script>

<style scoped>
.admin-container {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
  padding-bottom: 40px;
}

.admin-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
  padding: 20px 0;
  animation: fadeInDown 0.6s ease-out;
}

.header-actions {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
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

.admin-title {
  font-size: 2rem;
  font-weight: 800;
  color: #1a1f71;
  margin: 0;
  letter-spacing: -0.5px;
}

.admin-subtitle {
  color: #888;
  margin: 8px 0 0 0;
  font-size: 0.95rem;
}

.btn {
  text-decoration: none;
  color: white;
  display: inline-flex;
  align-items: center;
  cursor: pointer;
}

.btn-primary,
.btn-secondary {
  border: none;
  border-radius: 8px;
  padding: 12px 24px;
  font-weight: 600;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.btn-primary {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
}

.btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(13, 71, 161, 0.3);
  filter: brightness(1.1);
}

.btn-secondary {
  background: linear-gradient(135deg, #42a5f5 0%, #1e88e5 100%);
}

.btn-secondary:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(30, 136, 229, 0.3);
  filter: brightness(1.1);
}

.btn-modern-add {
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  border: none;
  border-radius: 8px;
  padding: 12px 24px;
  font-weight: 600;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.btn-modern-add:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(13, 71, 161, 0.3);
  filter: brightness(1.1);
}

.table-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  border: 1px solid rgba(0, 0, 0, 0.08);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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

.products-table {
  width: 100%;
  border-collapse: collapse;
  margin: 0;
}

.products-table thead {
  background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
  border-bottom: 2px solid #e0e7ff;
}

.products-table thead tr {
  height: 60px;
}

.products-table th {
  padding: 16px 20px;
  text-align: left;
  font-weight: 700;
  color: #1a1f71;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.products-table tbody tr {
  border-bottom: 1px solid #f0f0f0;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  height: 70px;
}

.table-row:hover {
  background: #f8f9ff;
  box-shadow: inset 4px 0 0 #0d47a1;
  transform: scale(1.001);
}

.products-table td {
  padding: 16px 20px;
  vertical-align: middle;
}

.id-badge {
  display: inline-block;
  background: linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);
  color: white;
  padding: 6px 12px;
  border-radius: 6px;
  font-weight: 600;
  font-size: 0.85rem;
}

.price-highlight {
  font-weight: 700;
  color: #0d47a1;
  font-size: 1.1rem;
}

.stock-indicator {
  display: inline-block;
  padding: 6px 12px;
  border-radius: 6px;
  font-weight: 600;
  font-size: 0.85rem;
}

.stock-indicator.high {
  background: rgba(76, 175, 80, 0.15);
  color: #2e7d32;
}

.stock-indicator.medium {
  background: rgba(255, 193, 7, 0.15);
  color: #f57f17;
}

.stock-indicator.low {
  background: rgba(244, 67, 54, 0.15);
  color: #c62828;
}

.status-badge {
  display: inline-block;
  padding: 8px 14px;
  border-radius: 6px;
  font-weight: 600;
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.status-active {
  background: rgba(76, 175, 80, 0.2);
  color: #2e7d32;
}

.status-inactive {
  background: rgba(158, 158, 158, 0.2);
  color: #616161;
}

.action-buttons {
  display: flex;
  gap: 8px;
}

.btn-icon {
  width: 38px;
  height: 38px;
  border-radius: 8px;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 1rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-decoration: none;
}

.btn-edit {
  background: rgba(13, 71, 161, 0.15);
  color: #0d47a1;
}

.btn-edit:hover {
  background: #0d47a1;
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 6px 16px rgba(13, 71, 161, 0.3);
}

.btn-delete {
  background: rgba(244, 67, 54, 0.15);
  color: #d32f2f;
}

.btn-delete:hover {
  background: #d32f2f;
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 6px 16px rgba(244, 67, 54, 0.3);
}

@media (max-width: 768px) {
  .admin-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
  }

  .admin-title {
    font-size: 1.5rem;
  }

  .col-id, .col-status {
    display: none;
  }

  .products-table th,
  .products-table td {
    padding: 12px 8px;
    font-size: 0.85rem;
  }

  .action-buttons {
    gap: 4px;
  }

  .btn-icon {
    width: 32px;
    height: 32px;
  }
}
</style>