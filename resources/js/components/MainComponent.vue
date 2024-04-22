<style scoped>
.box {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: space-between;
    align-items: start;
    flex-direction: column;
}
</style>
<template>

    <!-- Start Main Top -->
    <header class="main-header">
        <!-- Start Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav,">
            <div class="container">
                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu"
                            aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="#"><img src="/images/logo.png" class="logo"
                                                          alt=""></a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu" v-for="category in categories">
                    <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                        <li class="nav-item active">
                            <a class="nav-link" :href="'#'+category.id">{{ category.name }}</a>
                        </li>
                        <!--                        <li class="nav-item"><a class="nav-link" href="about.html">About Us</a></li>-->
                        <!--                        <li class="dropdown">-->
                        <!--                            <a href="#" class="nav-link dropdown-toggle arrow" data-toggle="dropdown">SHOP</a>-->
                        <!--                            <ul class="dropdown-menu">-->
                        <!--                                <li><a href="shop.html">Sidebar Shop</a></li>-->
                        <!--                                <li><a href="shop-detail.html">Shop Detail</a></li>-->
                        <!--                                <li><a href="cart.html">Cart</a></li>-->
                        <!--                                <li><a href="checkout.html">Checkout</a></li>-->
                        <!--                                <li><a href="my-account.html">My Account</a></li>-->
                        <!--                                <li><a href="wishlist.html">Wishlist</a></li>-->
                        <!--                            </ul>-->
                        <!--                        </li>-->
                        <!--                        <li class="nav-item"><a class="nav-link" href="gallery.html">Gallery</a></li>-->
                        <!--                        <li class="nav-item"><a class="nav-link" href="contact-us.html">Contact Us</a></li>-->
                    </ul>
                </div>
                <!-- /.navbar-collapse -->

                <!-- Start Atribute Navigation -->
                <div class="attr-nav">
                    <ul>
                        <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                        <li class="side-menu ">
                            <a href="/cart">
                                <i class="fa fa-shopping-bag">
                                    <p class="mx-2">Корзина: {{ totalQuantity }}</p>
                                </i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End Atribute Navigation -->
            </div>
        </nav>
        <!-- End Navigation -->
    </header>
    <!-- End Main Top -->

    <!-- Start Top Search -->
    <div class="top-search">
        <div class="container">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>
    <!-- End Top Search -->

    <!-- Start Products  -->
    <div class="products-box" v-for="category in categories">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-all text-left">
                        <h1 :id="category.id"> {{ category.name }} </h1>
                        <!--                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet lacus enim.</p>-->
                    </div>
                </div>
            </div>

            <div class="row special-list">
                <div class="col-lg-3 col-md-6 special-grid best-seller" v-for="product in category.products">
                    <div class="products-single fix box">
                        <div class="box-img-hover mt-3">
                            <!--                            можно добавить значок 'SALE'-->
                            <!--                            <div class="type-lb">-->
                            <!--                                <p class="sale">Sale</p>-->
                            <!--                            </div>-->
                            <!--                            конец 'SALE'-->
                            <img src="/images/img-pro-01.jpg" class="img-fluid" alt="Image">
                        </div>
                        <div class="why-text col-12 ">
                            <h4>{{ product.name }}</h4>
                            <h6>{{ product.weight }} гр.</h6>
                            <h6>{{ product.description }}</h6>
                            <div class="text-center">
                                <div class="d-flex justify-content-between mt-2">
                                    <h5 class="my-auto"> {{ product.price }} р.</h5>
                                    <button type="submit" @click.prevent="changeProductId(product.id)"
                                            class="border-0 bg-transparent">
                                        <i class="fa fa-cart-plus fa-2x" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div :class="isId(product.id) ? 'd-flex justify-content-between mt-3' : 'd-none' ">
                                    <input type="number" class="form-control col-md-5" v-model="quantity"
                                           name="quantity"
                                           placeholder="к-во" value="">
                                    <button @click.prevent="addProduct(product.id)" type="submit"
                                            class="btn btn-success hvr-hover h-25">В корзину
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Products  -->

</template>

<script>
import axios from "axios";

export default {
    name: "Main",

    data() {
        return {
            categories: null,
            cartProducts: null,
            productId: null,
            quantity: null,
            totalQuantity: null,
            orderSum: null
        }
    },

    mounted() {
        console.log('Component mounted.')
        this.getProducts()
        // this.getCartProducts()
        this.totalInTheBasket()
    },

    methods: {
        getProducts() {
            axios.get('/main/json')
                .then(result => {
                    // console.log(result.data)
                    this.categories = result.data.categories
                })
        },

        // getCartProducts() {
        //     axios.get('/cart/json')
        //         .then(result => {
        //             console.log(result.data.products)
        //             this.cartProducts = result.data.products
        //         })
        // },

        addProduct(id) {
            console.log(id)
            axios.post(`/cart/create/${id}`, {quantity: this.quantity})
                .then(result => {
                    console.log('ok')
                    this.quantity = null
                    this.getProducts()
                    this.totalInTheBasket()
                    // this.getCartProducts()
                })
                .catch(error => {
                    console.log(error)
                    // if (error.response.status === 422) {
                    //     console.log(error)
                    // }
                });
        },

        changeProductId(id) {
            this.productId = id
        },

        isId(id) {
            return this.productId == id
        },

        totalInTheBasket() {
            axios.get('/cart/total')
                .then(result => {
                    console.log(result.data.orderSum)
                    this.totalQuantity = result.data.totalQuantity
                    this.orderSum = result.data.orderSum
                })
        },

    }
}
</script>
