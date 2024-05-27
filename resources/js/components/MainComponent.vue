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
        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default fa">
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
                            <a class="nav-link fa" :href="'#'+category.id">{{ category.name }}</a>
                        </li>
                       </ul>
                </div>
                <!-- /.navbar-collapse -->
                <!-- Start Atribute Navigation -->
                <div class="attr-nav">
                    <ul>
                        <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>

                        <li class="side-menu">
                            <!-- Button trigger modal -->
                            <a>
                                <button type="button" class="border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#CartsModal">
                                    <i class="fa fa-shopping-bag">
                                        <p class="mx-2">Корзина: {{ totalQuantity ? totalQuantity : 0 }}</p>
                                    </i>
                                </button>
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
                    <div class="title-all text-left fa">
                        <h1 :id="category.id"> {{ category.name }} </h1>
                    </div>
                </div>
            </div>

            <div class="row special-list">
                <div class="col-lg-3 col-md-6 special-grid best-seller" v-for="product in category.products">
                    <div class="products-single fix box">
                        <div class="box-img-hover mt-3" type="button" data-bs-toggle="modal"
                             data-bs-target="#onlineCafeModal" @click.prevent="getOneProduct(product.id)">
                            <img src="/asset/images/img-pro-01.jpg" class="img-fluid" alt="Image">
                        </div>
                        <div class="why-text col-12 fa">
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
                                        <div class="m-auto" v-for="cartProduct in products">
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

    <!-- Modal product-->
    <div class="modal" id="onlineCafeModal" tabindex="-1" aria-labelledby="onlineCafeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row justify-content-between fa">
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

    <!-- Modal cart -->
    <div class="modal fade" id="CartsModal" tabindex="-1" aria-labelledby="CartsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered fa">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bolder" id="CartsModalLabel">{{ totalQuantity + ' товаров на ' + orderSum + ' р.'}} </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Start Cart  -->
                    <div class="cart-box-main">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-12 " v-for="product in products">
                                        <div class="row justify-content-between" >
                                            <div class="col">
                                                <img class="img-fluid" src="/asset/images/img-pro-01.jpg"  alt=""/>
                                            </div>
                                            <div class="col text-left">
                                                <h5 class="fw-bolder">{{ product.product.name }}</h5>
                                                <p class="fw-lighter">{{ product.product.weight }} гр.</p>
                                            </div>
                                            <div class="col text-right">
                                                <button @click.prevent="remove(product.id)" type="submit"
                                                        class="border-0 bg-transparent">
                                                    <i class="fa fa-window-close" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="col-10">
                                                <h5 class="fw-bolder">{{ product.product.price }} р. </h5>
                                            </div>
                                            <div class="col-2">
                                                <div class="row">
                                                    <div class="col-1">
                                                        <button @click.prevent="addMinus(product.product_id)" type="button"
                                                                class="border-0 bg-transparent">
                                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-1">
                                                        <h5 class="fw-bolder">{{ product.quantity }}</h5>
                                                    </div>
                                                    <div class="col-1">
                                                        <button @click.prevent="addProduct(product.product_id)" type="button"
                                                                class="border-0 bg-transparent">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="border-bottom border-4 border-dark">
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- End Cart -->
                </div>
                <div class="modal-footer row">
                    <div>
                        <a href="/order">
                            <div class="update-box">
                                <input value="Оформить заказ" type="submit">
                            </div>
                        </a>
                    </div>

                    <div>
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
    </div>

</template>

<script>
import axios from "axios";

export default {
    name: "Main",

    data() {
        return {
            categories: null,
            productId: null,
            totalQuantity: null,
            orderSum: null,
            oneProduct: [],
            empty: null,

            products: null
        }
    },

    mounted() {
        console.log('Component mounted.')
        this.getProducts()
        this.totalInTheBasket()
        this.getCartProducts()
    },

    methods: {
        getProducts() {
            axios.get('/api/main/category/products')
                .then(result => {
                    console.log(result)
                    this.categories = result.data.category
                })
        },

        getCartProducts() {
            axios.get('/cart/products')
                .then(result => {
                    console.log(result.data.products.length)
                    this.products = result.data.products
                })
        },

        getOneProduct(id) {
            axios.get(`/api/main/product/${id}`)
                .then(result => {
                    this.oneProduct = result.data.product
                })
        },

        addProduct(id) {
            console.log(id)
            axios.post(`/cart/create/${id}`)
                .then(result => {
                    this.getProducts()
                    this.totalInTheBasket()

                    this.getCartProducts()
                    // console.log(result)
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

                    this.getCartProducts()

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
                    // console.log(result)
                    this.totalQuantity = result.data.totalQuantity
                    this.orderSum = result.data.orderSum
                })
        },

        isEmptyProduct() {
            if ( this.empty === 'empty') {
                this.productId = null
            }
        },

        remove(id) {
            axios.delete(`/cart/delete/${id}`)
                .then(result => {
                    console.log('delete')
                    this.getProducts()
                    this.totalInTheBasket()

                    this.getCartProducts()
                })
        },
    },

    computed: {
        // test(id) {
        //     return this.oneProduct.filter(function (product) {
        //         if (product.product_id === id) {
        //             return true
        //         }
        //     })
        // }
    }
}
</script>
