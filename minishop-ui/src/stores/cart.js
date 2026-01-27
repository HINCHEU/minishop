// import { reactive } from 'vue'


// export const cart = reactive({
//     items: [],


//     add(product, qty = 1) {
//         const found = this.items.find(i => i.product_id === product.product_id)
//         if (found) found.quantity += qty
//         else this.items.push({ ...product, quantity: qty })
//     },


//     remove(id) {
//         this.items = this.items.filter(i => i.product_id !== id)
//     },


//     total() {
//         return this.items.reduce((s, i) => s + i.price * i.quantity, 0)
//     }
// })

import { reactive } from 'vue'

export const cartStore = reactive({
    items: [],

    addItem(product, quantity = 1) {
        const existingItem = this.items.find(item => item.product_id === product.product_id)

        if (existingItem) {
            existingItem.quantity += quantity
        } else {
            this.items.push({ ...product, quantity })
        }
    },

    updateQuantity(productId, quantity) {
        const item = this.items.find(item => item.product_id === productId)
        if (item) {
            if (quantity <= 0) {
                this.removeItem(productId)
            } else {
                item.quantity = quantity
            }
        }
    },

    removeItem(productId) {
        this.items = this.items.filter(item => item.product_id !== productId)
    },

    clearCart() {
        this.items = []
    },

    getTotal() {
        return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0)
    },

    getCount() {
        return this.items.reduce((sum, item) => sum + item.quantity, 0)
    }
})