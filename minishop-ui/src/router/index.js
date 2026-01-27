// // src/router/index.js
// import { createRouter, createWebHistory } from 'vue-router'

// // import your views
// import Home from '../views/Home.vue'
// import ProductDetail from '../views/ProductDetail.vue'
// import Cart from '../views/Cart.vue'
// import Checkout from '../views/Checkout.vue'
// import Success from '../views/OrderSuccess.vue'
// import AdminProductList from '../views/AdminProductList.vue'

// // define routes
// const routes = [
//   { path: '/', component: Home },
//   { path: '/product/:id', component: ProductDetail },
//   { path: '/cart', component: Cart },
//   { path: '/checkout', component: Checkout },
//   { path: '/success/:id', component: Success },
//   { path: '/admin/products', component: AdminProductList }
// ]

// // create router instance
// const router = createRouter({
//   history: createWebHistory(),
//   routes
// })

// export default router


import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '../views/HomePage.vue'
import ProductDetail from '../views/ProductDetail.vue'
import CartPage from '../views/CartPage.vue'
import CheckoutPage from '../views/CheckoutPage.vue'
import OrderConfirmation from '../views/OrderConfirmation.vue'
import AdminProducts from '../views/admin/AdminProducts.vue'
import AdminProductForm from '../views/admin/AdminProductForm.vue'
import AdminSettings from '../views/admin/AdminSettings.vue'
import AboutPage from '../views/AboutPage.vue'
import ContactPage from '../views/ContactPage.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomePage
    },
    {
      path: '/product/:id',
      name: 'product-detail',
      component: ProductDetail
    },
    {
      path: '/cart',
      name: 'cart',
      component: CartPage
    },
    {
      path: '/checkout',
      name: 'checkout',
      component: CheckoutPage
    },
    {
      path: '/order-confirmation',
      name: 'order-confirmation',
      component: OrderConfirmation
    },
    {
      path: '/admin/products',
      name: 'admin-products',
      component: AdminProducts
    },
    {
      path: '/admin/products/create',
      name: 'admin-product-create',
      component: AdminProductForm
    },
    {
      path: '/admin/products/:id/edit',
      name: 'admin-product-edit',
      component: AdminProductForm
    },
    {
      path: '/admin/settings',
      name: 'admin-settings',
      component: AdminSettings
    },
    {
      path: '/about',
      name: 'about',
      component: AboutPage
    },
    {
      path: '/contact',
      name: 'contact',
      component: ContactPage
    }
  ]
})

export default router