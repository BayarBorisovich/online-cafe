<template>
    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Оформление заказа</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/cart">Корзина</a></li>
                        <li class="breadcrumb-item active">Оформление заказа</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <div class="alert alert-success" v-if="success">
        {{success}}
    </div>

    <div class="container-sm my-3">
        <div class="col-6">
            <div class="mb-3">
                <label for="user_name" class="form-label">Имя</label>
                <input type="text" class="form-control" name="user_name" v-model="user_name">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Телефон</label>
                <input type="text" class="form-control" name="phone" v-model="phone" >
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">Город</label>
                <input type="text" class="form-control" name="city" v-model="city">
            </div>
            <div class="mb-3">
                <label for="street" class="form-label">Улица</label>
                <input type="text" class="form-control" name="street" v-model="street">
            </div>
            <div class="mb-3">
                <label for="house" class="form-label">Дом</label>
                <input type="text" class="form-control" name="house" v-model="house">
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Коментарий</label>
                <input type="text" class="form-control" name="comment" v-model="comment">
            </div>
            <button @click.prevent="orderRegistration" type="submit" class="btn btn-primary">Оформить</button>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Order",

    data() {
        return {
            user_name: null,
            phone: null,
            city: null,
            street: null,
            house: null,
            comment: null,

            success: null,
            errors: {},
        }
    },

    mounted() {
        console.log('Component mounted.')
    },

    methods: {
        orderRegistration() {
            axios.post('/order/create', {
                user_name: this.user_name,
                phone: this.phone,
                city: this.city,
                street: this.street,
                house: this.house,
                comment: this.comment
            })
                .then(result =>{
                    console.log('ok')
                    console.log(result.data.success)
                    this.success = result.data.success
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                });

        },
        // createPost() {
        //     axios.post('/post/create', {content: this.content})
        //         .then(result => {
        //             this.content = null
        //             this.errors = null
        //         })
        //         .catch(error => {
        //             if (error.response.status === 422) {
        //                 this.errors = error.response.data.errors;
        //             }
        //         });
        // },
    },
}
</script>

