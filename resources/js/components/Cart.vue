<template>
    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Корзина</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/main">Меню</a></li>
                        <li class="breadcrumb-item active">Корзина</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Cart  -->
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Картинка</th>
                                <th>Название продукта</th>
                                <th>Цена</th>
                                <th>Количество</th>
                                <th>Итого</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="product in products">
                                <td class="thumbnail-img">
                                    <a href="#">
                                        <img class="img-fluid" src="images/img-pro-01.jpg" alt=""/>
                                    </a>
                                </td>
                                <td class="name-pr">
                                    <a href="#">
                                        {{ product.product.name }}
                                    </a>
                                </td>
                                <td class="price-pr">
                                    <p>{{ product.product.price }} р.</p>
                                </td>
                                <td>
                                    <button @click.prevent="addMinus(product.product_id)" type="submit"
                                            class="border-0 bg-transparent">
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>

                                    <input type="text" class="col-md-2" :value="product.quantity">

                                    <button @click.prevent="addPlus(product.product_id)" type="button"
                                            class="border-0 bg-transparent">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </td>
                                <td class="total-pr">
                                    <p>{{ product.product.price * product.quantity }} р.</p>
                                    <!--                                    <p>{{ total }} р.</p>-->
                                </td>
                                <td class="remove-pr">
                                    <button @click.prevent="remove(product.product_id)" type="submit"
                                            class="border-0 bg-transparent">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <div class="col-lg-6 col-sm-6">

                </div>
                <div class="col-lg-6 col-sm-6">
                    <a href="/order">
                        <div class="update-box">
                            <input value="Оформить заказ" type="submit">
                        </div>
                    </a>
                </div>
            </div>

            <div class="row my-5">
                <div class="col-lg-8 col-sm-12"></div>
                <div class="col-lg-4 col-sm-12">
                    <div class="order-box">
                        <div class="d-flex gr-total">
                            <h5>В корзине</h5>
                        </div>
                        <hr>
                        <div class="d-flex gr-total">
                            <h3>Товаров</h3>
                            <div class="ml-auto h5">{{ totalQuantity }} шт.</div>
                        </div>
                        <div class="d-flex gr-total mb-3">
                            <h3>На сумму</h3>
                            <div class="ml-auto h5">{{ orderSum }} р.</div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- End Cart -->
</template>

<script>
import axios from "axios";

export default {
    name: "Cart",

    data() {
        return {
            products: null,
            content: null,
            orderSum: null,
            totalQuantity: null,
        }
    },

    mounted() {
        console.log('Component mounted.')
        this.getProducts()
        this.totalInTheBasket()

    },

    methods: {
        getProducts() {
            axios.get('/cart/products')
                .then(result => {
                    // console.log(result.data.products)
                    this.products = result.data.products
                })
        },

        addPlus(id) {
            console.log(id)
            axios.patch(`/cart/plus/${id}`)
                .then(result => {
                    console.log('+')
                    this.getProducts()
                    this.totalInTheBasket()
                })
        },

        addMinus(id) {
            axios.patch(`/cart/minus/${id}`)
                .then(result => {
                    console.log('-')
                    this.getProducts()
                    this.totalInTheBasket()
                })
        },

        totalInTheBasket() {
            axios.get('/cart/total')
                .then(result => {
                    console.log(result.data.orderSum)
                    this.totalQuantity = result.data.totalQuantity
                    this.orderSum = result.data.orderSum
                })
        },

        remove(id) {
            axios.delete(`/cart/delete/${id}`)
                .then(result => {
                    console.log('delete')
                    this.getProducts()
                    this.totalInTheBasket()
                })
        }

    },

    // computed: {
    //     total() {
    //         let products = this.products
    //         for (let key of products) {
    //             console.log(key.quantity)
    //         }
    //     },
    //
    // },
}
</script>

