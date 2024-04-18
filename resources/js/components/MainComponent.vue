<template>
    <div class="main-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="right-phone-box">
                        <p>Call US :- <a href="#"> +11 900 800 100</a></p>
                    </div>
                    <div class="our-link">
                        <ul>
                            <li><a href="#"><i class="fa fa-user s_color"></i> My Account</a></li>
                            <li><a href="#"><i class="fas fa-location-arrow"></i> Our location</a></li>
                            <li><a href="#"><i class="fas fa-headset"></i> Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="login-box">
                        <select id="basic" class="selectpicker show-tick form-control" data-placeholder="Sign In">
                            <option>Register Here</option>
                            <option>Sign In</option>
                        </select>
                    </div>
                    <div class="text-slid-box">
                        <div id="offer-box" class="carouselTicker">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Top -->

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
                    <a class="navbar-brand" href="index.html"><img src="/images/logo.png" class="logo"
                                                                   alt=""></a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu" v-for="category in categories">
                    <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                        <li class="nav-item active"><a class="nav-link" href="index.html">{{ category.name }}</a></li>
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
                            <a href="#">
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
                        <h1>{{ category.name }}</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet lacus enim.</p>
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
                        <div class="why-text">
                            <h4>{{ product.name }}</h4>
                            <h6>{{ product.weight }} гр.</h6>
                            <h6>{{ product.description }}</h6>
                            <h5> {{ product.price }} р.</h5>
                            <a class="cart btn hvr-hover " href="#">Добавить в корзину</a>
<!--                            <button type="button" class="btn btn-success">Success</button>-->
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
        }
    },

    mounted() {
        console.log('Component mounted.')
        this.getProducts()
    },

    methods: {
        getProducts() {
            axios.get('/main/json')
                .then(result => {
                    console.log(result.data)
                    this.categories = result.data.categories
                })
        },

    }
}
</script>
