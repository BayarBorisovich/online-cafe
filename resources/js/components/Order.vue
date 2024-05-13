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
    <div class="alert alert-success" v-if="error">
        {{error}}
    </div>

    <div class="container-sm my-3">
        <div class="col-6">
            <div class="mb-3">
                <label for="user_name" class="form-label">Имя</label>
                <input type="text" class="form-control" name="user_name" v-model="user_name">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Телефон</label>
                <div :class="errors.phone ? 'alert alert-success' : 'd-none'" v-if="errors">
                    {{errors.phone}}
                </div>
                <input type="text" class="form-control" name="phone" v-model="phone" >
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">Город</label>
                <div :class="errors.city ? 'alert alert-success' : 'd-none'" v-if="errors">
                    {{errors.city}}
                </div>
                <input type="text" class="form-control" name="city" v-model="city">
            </div>
            <div class="mb-3">
                <label for="street" class="form-label">Улица</label>
                <div :class="errors.street ? 'alert alert-success' : 'd-none'" v-if="errors">
                    {{errors.street}}
                </div>
                <input type="text" class="form-control" name="street" v-model="street">
            </div>
            <div class="mb-3">
                <label for="house" class="form-label">Дом</label>
                <div :class="errors.house ? 'alert alert-success' : 'd-none'" v-if="errors">
                    {{errors.house}}
                </div>
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
            error: null,
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
                    console.log(result)
                    this.success = result.data.success
                    this.error = result.data.error
                    this.user_name = null
                    this.phone = null
                    this.city = null
                    this.street = null
                    this.house = null
                    this.comment = null
                    window.location.replace('http://localhost/order/item');
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        console.log(error)
                        this.errors = error.response.data.errors;
                    }
                });

        },
    },
}
</script>

