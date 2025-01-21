import { reactive } from "vue";

export const cartNumberStore = reactive({
    cartNumber: Object.values(JSON.parse(localStorage.getItem('cart')) ?? {}).reduce((totalQuantity, item) => {
        return totalQuantity + item.quantity
    }, 0),
    update() {
        this.cartNumber = Object.values(JSON.parse(localStorage.getItem('cart'))).reduce((totalQuantity, item) => {
            return totalQuantity + item.quantity
        }, 0)
    }
})
