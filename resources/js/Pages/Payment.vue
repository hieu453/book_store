<template>
    <div class="px-5 py-5 mx-auto max-w-lg md:flex md:max-w-full md:items-start md:justify-center md:gap-16">
        <div class="md:grow md:max-w-lg md:h-screen">
            <div v-for="item in cart" class="border flex gap-6 mb-2 rounded-lg">
                <div>
                    <img
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="product_image"
                        class="w-20 rounded-lg"
                    >
                </div>
                <div>
                    <p class="text-lg">{{ item.name }}</p>
                    <div class="space-x-2">
                        <span class="text-sm">{{ item.quantity }}</span>
                        <span>x</span>
                        <span class="text-sm">${{ item.price }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:grow md:max-w-sm">
            <div>
                <h1 class="text-xl font-bold">Pay with card</h1>
            </div>
            <div class="py-5">
                <input
                id="card-holder-name"
                class="w-full rounded-lg bg-gray-50 border-none focus:outline-none focus:ring-0 placeholder:text-slate-400"
                placeholder="Enter holder name"
                type="text"
                >
            </div>
            <!-- Stripe Elements Placeholder -->
            <div id="card-element"></div>
            <Transition>
                <p
                    v-if="error"
                    id="card-errors"
                    class="text-red-500 text-left">
                    {{ displayError }}
                </p>
            </Transition>
            <div class="flex justify-center py-5">
                <button @click="pay" id="card-button" class="btn bg-purple-500">
                    Process Payment
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { loadStripe } from '@stripe/stripe-js';
import { onMounted, ref, useTemplateRef } from 'vue';
import { router } from '@inertiajs/vue3';

const cart = ref(JSON.parse(localStorage.getItem('cart')))
const stripe = ref();
const cardElement = ref();
const elements = ref();
const error = ref(false);
const displayError = ref('');
const test = ref();

onMounted(async () => {
    stripe.value = await loadStripe(import.meta.env.VITE_STRIPE_KEY)

    elements.value = stripe.value.elements();

    cardElement.value = elements.value.create('card', {
        classes: {
            base: 'px-5 py-5 bg-gray-50 rounded-lg'
        }
    })

    cardElement.value.mount('#card-element');

    cardElement.value.on('change', function (event) {
        if (event.error) {
            error.value = true;
            displayError.value = event.error.message;
        } else {
            error.value = false;
            displayError.value = '';
        }
    });

    cardElement.value.on('loadError', function (event) {
        if (event.error) {
            console.log(event.error)
        }
    })
})

async function pay() {
    // const { paymentMethod, error } = await stripe.value.createPaymentMethod(
    //     'card', cardElement.value, {
    //         billing_details: { name: 'hieu' }
    //     }
    // );

    // if (error) {
    //     // Display "error.message" to the user...
    //     console.log(error.message);
    // } else {
    //     // The card has been verified successfully...
    //     router.post('/purchase', {
    //         paymentMethodId: paymentMethod.id
    //     }, {
    //         onSuccess: () => {
    //             router.get(route('checkout-success'))
    //         }
    //     })
    // }
}

</script>

<style>
.v-enter-active,
.v-leave-active {
  transition: all 0.5s ease;
  max-height: 300px;
  overflow: hidden;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
  max-height: 0px;
}
</style>
