<template>
    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Cart</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/main">Shop</a></li>
                        <li class="breadcrumb-item active">Cart</li>
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
                                <th>Images</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
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
                                <td class="quantity-box"><input type="number" size="4" :value="product.quantity" min="0" step="1"
                                                                class="c-input-text qty text"></td>
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
                    <div class="update-box">
                        <input value="Update Cart" type="submit">
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <div class="col-lg-8 col-sm-12"></div>
                <div class="col-lg-4 col-sm-12">
                    <div class="order-box">
                        <h3>Order summary</h3>
                        <div class="d-flex">
                            <h4>Sub Total</h4>
                            <div class="ml-auto font-weight-bold"> $ 130</div>
                        </div>
                        <div class="d-flex">
                            <h4>Discount</h4>
                            <div class="ml-auto font-weight-bold"> $ 40</div>
                        </div>
                        <hr class="my-1">
                        <div class="d-flex">
                            <h4>Coupon Discount</h4>
                            <div class="ml-auto font-weight-bold"> $ 10</div>
                        </div>
                        <div class="d-flex">
                            <h4>Tax</h4>
                            <div class="ml-auto font-weight-bold"> $ 2</div>
                        </div>
                        <div class="d-flex">
                            <h4>Shipping Cost</h4>
                            <div class="ml-auto font-weight-bold"> Free</div>
                        </div>
                        <hr>
                        <div class="d-flex gr-total">
                            <h5>Grand Total</h5>
                            <div class="ml-auto h5"> $ 388</div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="col-12 d-flex shopping-box">
                    <a href="checkout.html" class="ml-auto btn hvr-hover update-box">Checkout</a>
                </div>
<!--                             <div class="col-lg-6 col-sm-6 ">-->
<!--                                    <div class="update-box">-->
<!--                                            <input value="Update Cart" type="submit">-->
<!--                                        </div>-->
<!--                                </div>-->
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
            content: null
        }
    },

    mounted() {
        console.log('Component mounted.')
        this.getProducts()

    },

    methods: {
        getProducts() {
            axios.get('/cart/json')
                .then(result => {
                    console.log(result.data.products)
                    this.products = result.data.products
                })
        },

        remove(id) {
            axios.delete(`/cart/delete/${id}`)
                .then(result =>{
                    console.log('delete')
                    this.getProducts()
                })
        }

    },

    computed: {
        total() {
            let products = this.products
            for (let key of products) {
                console.log(key.quantity)
            }
        },

    },
}
</script>
