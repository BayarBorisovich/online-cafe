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
            <h5>Доставка осуществляется в пределах пгт. Могойтуй</h5>
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
                <label for="address" class="form-label">
                    Адресс: укажите улицу и дом
                </label>
                <div :class="errors.address ? 'alert alert-success' : 'd-none'" v-if="errors">
                    {{errors.address}}
                </div>
                <input type="text" class="form-control" name="address" v-model="address" @input="getAddressSuggestions">
                <div class="list-group" v-for=" suggestion in suggestions">
                    <button class="border-0 bg-transparent" @click.prevent="add(suggestion.value)">
                        <a class="list-group-item" id="aaa" aria-current="true" >{{ suggestion.value }}</a>
                    </button>

                </div>
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
            address: null,
            comment: null,

            success: null,
            error: null,
            errors: {},

            suggestions: [],

            token: 'fe5af647eda9ca0ec6fcacacad50f45a035eb5aa'
        }
    },

    mounted() {
        console.log('Component mounted.')
        console.log(this.address)
    },

    methods: {
        orderRegistration() {
            console.log(this.address)
            axios.post('/order/create', {
                user_name: this.user_name,
                phone: this.phone,
                address: this.address,
                comment: this.comment
            })
                .then(result =>{
                    console.log('ok')
                    console.log(result)
                    this.success = result.data.success
                    this.error = result.data.error
                    console.log(this.address)
                    this.user_name = null
                    this.phone = null
                    this.address = null
                    this.comment = null

                    // if (this.error)
                    // window.location.replace('http://localhost/order/item');
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        console.log(error)
                        this.errors = error.response.data.errors;
                    }
                });

        },
        getAddressSuggestions() {
            axios({
                method: 'post',
                url: 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address',

                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Token " + this.token
                },
                data: {
                    query: this.address,
                    division: "MUNICIPAL",
                    "locations": [{
                        "region": "Забайкальский",
                        "area": "Могойтуйский",
                        "settlement": "Могойтуй"
                        // region	Ограничение по названию региона
                        // area	района
                        // city	города
                        // settlement	населенного пункта
                        // street	улицы
                    }]

                }

            })
                .then(response => {
                    this.suggestions = response.data.suggestions;
                })
                .catch(error => {
                    console.error(error);
                });
        },

        add(selectedAddress) {
            this.address = selectedAddress
            this.suggestions = null
            // console.log(this.address)


        },
    },
}

</script>
<style>
#aaa {
    display: block;
    padding: 0.5rem 1rem;
    color: black;
    text-decoration: none;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out;
    background-color: white;
}

#aaa:hover {

    color: black;
    background-color: #27e127;

}
</style>

