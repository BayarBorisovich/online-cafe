<template>
    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Ваш заказ</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/main">Меню</a></li>
                        <li class="breadcrumb-item active">Оформленный заказ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <div class="my-5">
        <div class="col-lg-4 col-sm-12">
            <div class="order-box">
                <div class="d-flex gr-total">
                    <h5>Состав заказа</h5>
                </div>
                <hr>

                <div class="d-flex gr-total" v-for="product in products">
                    <h3>{{ product.product.name }}</h3>
                    <div class="ml-auto h5">{{ product.quantity }} × {{ product.price }} р.</div>

                </div>
                <hr>
                <div class="d-flex gr-total mb-3">
                    <h3>Позиций</h3>
                    <div class="ml-auto h5">{{ totalQuantity }} шт.</div>
                </div>
                <hr>
                <div class="d-flex gr-total mb-3">
                    <h3>На сумму</h3>
                    <div class="ml-auto h5">{{ sum }} р.</div>
                </div>
                <hr>
            </div>
        </div>
    </div>

</template>

<script>
import axios from "axios";

export default {
    name: "OrderItem",

    data() {
        return {
            products: null,
            sum: null,
            totalQuantity: null
        }
    },

    mounted() {
        console.log('Component mounted.')
        this.getOrders()
    },

    methods: {
        getOrders() {
            axios.get('/order/item/json')
                .then(result => {
                    console.log(result)
                    this.products = result.data.order
                    this.sum = result.data.sum
                    this.totalQuantity = result.data.totalQuantity
                })
        }
    },
}
</script>

