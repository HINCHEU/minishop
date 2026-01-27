// import axios from 'axios'


// export default axios.create({
//     baseURL: 'http://localhost:8000/api'
// })

import axios from 'axios'

const apiClient = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers: {
        'Content-Type': 'application/json'
    }
})

export default {
    // Public API
    getProducts() {
        return apiClient.get('/products')
    },
    getProduct(id) {
        return apiClient.get(`/products/${id}`)
    },
    createOrder(orderData) {
        return apiClient.post('/orders', orderData)
    },

    // Admin API
    getAdminProducts() {
        return apiClient.get('/admin/products')
    },
    createProduct(productData) {
        return apiClient.post('/admin/products', productData)
    },
    updateProduct(id, productData) {
        return apiClient.put(`/admin/products/${id}`, productData)
    },
    deleteProduct(id) {
        return apiClient.delete(`/admin/products/${id}`)
    }
}