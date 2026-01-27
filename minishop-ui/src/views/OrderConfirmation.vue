<template>
  <div class="container py-4">
    <div class="text-center py-5">
      <div class="mb-4">
        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
             style="width: 80px; height: 80px;">
          <i class="bi bi-check-lg" style="font-size: 3rem;"></i>
        </div>
      </div>
      <h1 class="fw-bold mb-3">Order Confirmed!</h1>
      <p class="text-muted mb-4">Thank you for your purchase</p>
      <div class="card shadow-sm mx-auto" style="max-width: 500px;">
        <div class="card-body">
          <h5 class="mb-3">Order Details</h5>
          <div class="text-start">
            <p><strong>Order ID:</strong> #{{ order?.id }}</p>
            <p><strong>Total Amount:</strong> ${{ parseFloat(order?.total_amount || 0).toFixed(2) }}</p>
            <p class="text-muted mb-0">A confirmation email has been sent to your email address.</p>
          </div>
        </div>
      </div>
      <router-link to="/" class="btn btn-primary mt-4">
        Continue Shopping
      </router-link>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

export default {
  name: 'OrderConfirmation',
  setup() {
    const route = useRoute()
    const order = ref({
      id: null,
      total_amount: 0
    })
    
    onMounted(() => {
      if (route.query.orderId && route.query.totalAmount) {
        order.value = {
          id: route.query.orderId,
          total_amount: parseFloat(route.query.totalAmount)
        }
      }
    })
    
    return {
      order
    }
  }
}
</script>