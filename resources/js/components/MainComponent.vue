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
                        <li class="nav-item active"><a class="nav-link" :href="'#'+category.id">{{ category.name }}</a>
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
                        <li class="side-menu">
                            <a href="/cart">
                                <i class="fa fa-shopping-bag"></i>
                                <span class="badge">3</span>
                                <p>My Cart</p>
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
                        <h1 :id="category.id">{{ category.name }}</h1>
                        <!--                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet lacus enim.</p>-->
                    </div>
                </div>
            </div>

            <div class="row special-list">
                <div class="col-lg-3 col-md-6 special-grid best-seller" v-for="product in category.products">
                    <div class="products-single fix">
                        <div class="box-img-hover">
                            <!--                            можно добавить значок 'SALE'-->
                            <!--                            <div class="type-lb">-->
                            <!--                                <p class="sale">Sale</p>-->
                            <!--                            </div>-->
                            <!--                            конец 'SALE'-->
                            <img src="/images/img-pro-01.jpg" class="img-fluid" alt="Image">
                        </div>
                        <div class="why-text ">
                            <h4>{{ product.name }}</h4>
                            <h6>{{ product.weight }} гр.</h6>
                            <h6>{{ product.description }}</h6>
                            <h5> {{ product.price }} р.</h5>
                            <div class="text-left mt-2">
                                <!--                                <input type="number" class="form-control mb-3" id="quantity"-->
                                <!--                                       aria-describedby="quantity" placeholder="количество">-->
                                <button @click.prevent="addProduct(product.id)" type="submit"
                                        class="btn btn-success hvr-hover">В корзину
                                </button>
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
            productId: null
        }
    },

    mounted() {
        console.log('Component mounted.')
        this.getProducts()
        this.getCartProducts()
    },

    methods: {
        getProducts() {
            axios.get('/main/json')
                .then(result => {
                    // console.log(result.data)
                    this.categories = result.data.categories
                })
        },

        getCartProducts() {
            axios.get('/cart/json')
                .then(result => {
                    console.log(result.data.products)
                    this.cartProducts = result.data.products
                })
        },

        addProduct(id) {
            console.log(id)
            axios.post(`/cart/${id}`)
                .then(result => {
                    console.log('ok')
                    this.getProducts()
                    this.getCartProducts()
                })
                .catch(error => {
                    console.log(error)
                    // if (error.response.status === 422) {
                    //     console.log(error)
                    // }
                });
        },

        // changeProductId(id) {
        //     this.productId = id
        //     console.log('ggggg')
        // },
        //
        // isId(id) {
        //    return  this.productId == id
        // }

    }
}
</script>
