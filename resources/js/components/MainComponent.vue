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
                    <a class="navbar-brand" href="#"><img src="/asset/images/logo.png" class="logo"
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
                        <div class="box-img-hover mt-3" type="button" data-bs-toggle="modal"
                             data-bs-target="#onlineCafeModal" @click.prevent="getOneProduct(product.id)">
                            <!--                            можно добавить значок 'SALE'-->
                            <!--                            <div class="type-lb">-->
                            <!--                                <p class="sale">Sale</p>-->
                            <!--                            </div>-->
                            <!--                            конец 'SALE'-->
                            <img src="/asset/images/img-pro-01.jpg" class="img-fluid" alt="Image">
                        </div>
                        <div class="why-text col-12">
                            <div type="button" data-bs-toggle="modal"
                                 data-bs-target="#onlineCafeModal" @click.prevent="getOneProduct(product.id)">
                                <h4>{{ product.name }}</h4>
                                <h6>{{ product.description }}</h6>
                            </div>
                            <div class="text-center">
                                <div class="d-flex justify-content-between mt-2">
                                    <h5 class="my-auto"> {{ product.price }} р.</h5>
                                    <button type="submit" @click.prevent="changeProductId(product.id)"
                                            class="border-0 bg-transparent">
                                        <i :class="isId(product.id) ? 'd-none' : 'fa fa-cart-plus fa-2x' "
                                           aria-hidden="true"></i>
                                    </button>
                                    <!--start click plus, minus-->
                                    <div
                                        :class="isId(product.id) ? 'd-flex justify-content-between text-right mt-3' : 'd-none' ">
                                        <button @click.prevent="addMinus(product.id)" type="submit"
                                                class="border-0 bg-transparent">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </button>
                                        <div class="m-auto" v-for="cartProduct in cartProducts">
                                            <div v-if="product.id === cartProduct.product_id">
                                                <h5 class="my-auto"> {{cartProduct.quantity}}</h5>
                                            </div>
                                        </div>

                                        <button @click.prevent="addProduct(product.id)" type="button"
                                                class="border-0 bg-transparent">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <!--end click plus, minus-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Products  -->

    <!-- Button trigger modal -->
    <!--                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#onlineCafeModal">-->
    <!--                            Launch demo modal-->
    <!--                        </button>-->

    <!-- Modal -->
    <div class="modal" id="onlineCafeModal" tabindex="-1" aria-labelledby="onlineCafeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row justify-content-between">
                        <div class="box-img-hover mt-3 col-6">
                            <img src="/asset/images/img-pro-01.jpg" class="img-fluid" alt="Image">
                        </div>
                        <div class="why-text col-6">
                            <h4>{{ oneProduct.name }}</h4>
                            <h6>{{ oneProduct.weight }} гр.</h6>
                            <h6>{{ oneProduct.description }}</h6>
                            <h5 class="my-auto"> {{ oneProduct.price }} р.</h5>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" @click.prevent="changeProductId(oneProduct.id)"
                            class="border-0 bg-transparent" data-bs-dismiss="modal">
                        <i class="fa fa-cart-plus fa-2x"
                           aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

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
            totalQuantity: null,
            orderSum: null,
            oneProduct: [],
            empty: null,
        }
    },

    mounted() {
        console.log('Component mounted.')
        this.getProducts()
        this.totalInTheBasket()
        this.getCartProduct()
    },

    methods: {
        getProducts() {
            axios.get('/main/json')
                .then(result => {
                    this.categories = result.data.categories
                })
        },

        getOneProduct(id) {
            axios.get(`/main/product/${id}`)
                .then(result => {
                    this.oneProduct = result.data.product
                })
        },

        getCartProduct() {
            axios.get('/main/cartProduct')
                .then(result => {
                    this.cartProducts = result.data.cartProducts
                })
        },

        addProduct(id) {
            console.log(id)
            axios.post(`/cart/create/${id}`)
                .then(result => {
                    this.getProducts()
                    this.totalInTheBasket()
                    this.getCartProduct()
                })
                .catch(error => {
                    console.log(error)
                });
        },

        addMinus(id) {
            axios.patch(`/cart/minus/${id}`)
                .then(result => {
                    this.getProducts()
                    this.totalInTheBasket()
                    this.getCartProduct()

                    this.empty = result.data
                    this.isEmptyProduct()
                })
        },

        changeProductId(id) {
            this.productId = id
            this.addProduct(id)
        },

        isId(id) {
            return this.productId === id
        },

        totalInTheBasket() {
            axios.get('/cart/total')
                .then(result => {
                    this.totalQuantity = result.data.totalQuantity
                    this.orderSum = result.data.orderSum
                })
        },

        isEmptyProduct() {
            if ( this.empty === 'empty') {
                this.productId = null
            }
        }
    },

    computed: {
        test(id) {
            return this.oneProduct.filter(function (product) {
                if (product.product_id === id) {
                    return true
                }
            })
        }
    }
}
</script>
