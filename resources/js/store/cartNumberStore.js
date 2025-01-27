import { reactive } from "vue";

export const cartNumberStore = reactive({
    // cartNumber: page.props.cartNumber,
    update() {
        this.cartNumber = page.props.cartNumber;
    }
})
