<template>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Добавдение продукта</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active">Продукты</li>
                    </ol>
                </div><!-- /.col -->
                <hr class="border-bottom border-4 border-dark">
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="alert alert-success" v-if="success">
        {{ success }}
    </div>
    <div class="alert alert-success" v-if="error">
        {{ error }}
    </div>
    <div class="col-6 mb-3">
        <div class="mb-3">

            <label for="name" class="form-label">Название продукта</label>
            <div :class="errors.name ? 'alert alert-success' : 'd-none'" v-if="errors">
                {{ errors.name }}
            </div>
            <input type="text" class="form-control" v-model="product_name" name="name" placeholder="название продукта">

            <label for="name" class="form-label">Состав продукта</label>
            <div :class="errors.name ? 'alert alert-success' : 'd-none'" v-if="errors">
                {{ errors.name }}
            </div>
            <input type="text" class="form-control" v-model="product_structure" name="structure" placeholder="состав продукта">

            <label for="name" class="form-label">Описание продукта</label>
            <div :class="errors.name ? 'alert alert-success' : 'd-none'" v-if="errors">
                {{ errors.name }}
            </div>
            <input type="text" class="form-control" v-model="product_description" name="description" placeholder="описание продукта">

            <label for="name" class="form-label">Вес</label>
            <div :class="errors.name ? 'alert alert-success' : 'd-none'" v-if="errors">
                {{ errors.name }}
            </div>
            <input type="number" class="form-control" v-model="product_weight" name="weight" placeholder="вес продукта">

            <label for="name" class="form-label">Цена продукта</label>
            <div :class="errors.name ? 'alert alert-success' : 'd-none'" v-if="errors">
                {{ errors.name }}
            </div>
            <input type="number" class="form-control" v-model="product_price" name="price" placeholder="цена продукта">


            <div class="form-group mt-3">
                <label>Выбрать категорию</label>
                <select class="form-control">
                    <template v-for="category in categories">
                        <option :value="category.id">{{ category.name }}</option>
                    </template>
                </select>
            </div>
        </div>
        <div class="text-right">
            <button type="submit" @click.prevent="create()" class="btn btn-secondary">Добавить</button>
        </div>
    </div>

    <div>
        <label for="name" class="form-label">Все продукты</label>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Название</th>
                <th scope="col">Состав</th>
                <th scope="col">Описание</th>
                <th scope="col">Вес</th>
                <th scope="col">Цена</th>
                <th scope="col">Удалить</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="product in products">
                <tr :class=" isId(product.id) ? 'd-none' : ''">
                    <th scope="row">{{ product.id }}</th>
                    <td>{{ product.name }}</td>
                    <td>{{ product.structure }}</td>
                    <td>{{ product.description }}</td>
                    <td>{{ product.weight }}</td>
                    <td>{{ product.price }}</td>
                    <td>
                        <a @click.prevent="changeProduct(product.id, product.name, product.structure, product.description, product.weight, product.price)" class="btn btn-success">Изменить</a>
                    </td>
                    <td>
                        <button type="submit" @click.prevent="deleteProduct(product.id)" class="btn btn-danger">
                            Удалить
                        </button>
                    </td>
                </tr>
                <tr :class=" isId(product.id) ? '' : 'd-none'">
                    <th scope="row">{{ product.id }}</th>
                    <th><input type="text" v-model="name" class="form-control"></th>
                    <th><input type="text" v-model="structure" class="form-control"></th>
                    <th><input type="text" v-model="description" class="form-control"></th>
                    <th><input type="text" v-model="weight" class="form-control"></th>
                    <th><input type="text" v-model="price" class="form-control"></th>
                    <td>
                        <button type="submit" @click.prevent="update(product.id)" class="btn btn-success-danger">
                            Сохранить
                        </button>
                    </td>
                    <td>

                    </td>
                </tr>

            </template>
            </tbody>
        </table>
    </div>

</template>

<script>

export default {
    name: "Category",

    data() {
        return {
            products: null,
            productId: null,
            success: null,
            error: null,
            errors: {},
            categories: null,

            name: null,
            structure: null,
            description: null,
            weight: null,
            price: null,

            product_name: null,
            product_structure: null,
            product_description: null,
            product_weight: null,
            product_price: null,
        }
    },

    mounted() {
        console.log('Component mounted.')
        this.getCategory()
        this.getProduct()
    },

    methods: {
        getProduct() {
            axios.get('/api/admin/product/get')
                .then(result => {
                    this.products = result.data
                })
        },

        getCategory() {
            axios.get('/api/admin/category/get')
                .then(result => {
                    this.categories = result.data
                })
        },

        update(id) {
            console.log(id)
            axios.patch(`/api/admin/product/update/${id}`, {
                name: this.name,
                structure: this.structure,
                description: this.description,
                weight: this.weight,
                price: this.price
            })
                .then(result => {
                    this.getCategory()
                    this.getProduct()
                    this.productId = null
                })
        },
        create() {
            axios.post('/api/admin/product/create', {
                name: this.product_name,
                structure: this.product_structure,
                description: this.product_description,
                weight: this.product_weight,
                price: this.product_price
            })
                .then(result => {
                    console.log(result)
                    this.product_name = null
                    this.success = result.data.success
                    this.error = result.data.error
                    this.getCategory()
                    this.getProduct()
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        console.log(error)
                        this.errors = error.response.data.errors;
                    }
                    console.log(this.error)
                });
        },

        deleteProduct(id) {
            axios.delete(`/api/admin/product/delete/${id}`)
                .then(result => {
                    this.getCategory()
                    this.getProduct()
                })
        },

        changeProduct(id, name, structure, description, weight, price) {
            this.productId = id
            this.name = name
            this.structure = structure
            this.description = description
            this.weight = weight
            this.price = price
        },

        isId(id) {
            return this.productId === id;
        },
    }
}
</script>



