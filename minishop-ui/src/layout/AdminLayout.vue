<template>
  <div class="container-fluid">
    <div class="row min-vh-100">
      <!-- LEFT BLUE SECTION (DESKTOP ONLY) -->
      <div class="col-md-6 d-none d-md-block bg-primary"></div>

      <!-- RIGHT CONTENT -->
      <div class="col-12 col-md-6 py-4 px-3 px-md-5">
        <h1 class="fw-bold mb-2">Our Products</h1>
        <p class="text-muted mb-4">Discover our amazing collection</p>

        <div class="row g-3">
          <div
            class="col-6 col-md-4"
            v-for="product in products"
            :key="product.id"
          >
            <div class="card h-100 text-center product-card">
              <img
                :src="product.image"
                class="card-img-top p-3"
                alt="product"
              />
              <div class="card-body">
                <h6 class="product-title">{{ product.name }}</h6>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductsPage",
  data() {
    return {
      products: [
        {
          id: 1,
          name: "Wireless Mouse",
          image: "https://via.placeholder.com/300"
        },
        {
          id: 2,
          name: "Mechanical Keyboard",
          image: "https://via.placeholder.com/300"
        },
        {
          id: 3,
          name: "Gaming Headset",
          image: "https://via.placeholder.com/300"
        }
      ]
    };
  }
};
</script>

<style scoped>
/* Prevent vertical text breaking */
.product-title {
  white-space: normal;
  word-break: break-word;
  text-align: center;
  font-weight: 600;
}

/* Make images consistent */
.product-card img {
  height: 150px;
  object-fit: contain;
}

/* Card hover effect */
.product-card {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

/* Mobile spacing improvement */
@media (max-width: 576px) {
  h1 {
    font-size: 1.6rem;
  }
}
</style>
