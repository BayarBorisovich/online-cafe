<template>
    <!-- Content Header (Page header) -->
<!--    <div class="content-header">-->
<!--        <div class="container-fluid">-->
<!--            <div class="row mb-3">-->
<!--                <div class="col-sm-6">-->
<!--                    <h1 class="m-0">Добавление продукта</h1>-->
<!--                </div>&lt;!&ndash; /.col &ndash;&gt;-->
<!--                <div class="col-sm-6">-->
<!--                    <ol class="breadcrumb float-sm-right">-->
<!--                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>-->
<!--                        <li class="breadcrumb-item active">Продукты</li>-->
<!--                    </ol>-->
<!--                </div>&lt;!&ndash; /.col &ndash;&gt;-->
<!--                <hr class="border-bottom border-4 border-dark">-->
<!--            </div>&lt;!&ndash; /.row &ndash;&gt;-->
<!--        </div>&lt;!&ndash; /.container-fluid &ndash;&gt;-->
<!--    </div>-->
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
            <div :class="errors.structure ? 'alert alert-success' : 'd-none'" v-if="errors">
                {{ errors.structure }}
            </div>
           <textarea
                class="form-control"
                v-model="product_structure"
                :style="{ height: dataHeight }"
                name="structure"
                placeholder="состав продукта"
                @input="autoResize"
            ></textarea>
            <label for="name" class="form-label">Описание продукта</label>
            <div :class="errors.description ? 'alert alert-success' : 'd-none'" v-if="errors">
                {{ errors.description }}
            </div>
            <!--            <input type="text" class="form-control" v-model="product_description" name="description" placeholder="описание продукта">-->
            <textarea
                class="form-control"
                v-model="product_description"
                :style="{ height: dataHeight }"
                name="description"
                placeholder="описание продукта"
                @input="autoResize"
            ></textarea>
            <label for="name" class="form-label">Вес гр.</label>
            <div :class="errors.weight ? 'alert alert-success' : 'd-none'" v-if="errors">
                {{ errors.weight }}
            </div>
            <input type="number" class="form-control" v-model="product_weight" name="weight" placeholder="вес продукта">

            <label for="name" class="form-label">Цена продукта</label>
            <div :class="errors.price ? 'alert alert-success' : 'd-none'" v-if="errors">
                {{ errors.price }}
            </div>
            <input type="number" class="form-control" v-model="product_price" name="price" placeholder="цена продукта">


            <div class="form-group mt-3">
                <label>Выбрать категорию</label>
                <div :class="errors.category_id ? 'alert alert-success' : 'd-none'" v-if="errors">
                    {{ errors.category_id }}
                </div>
                <select class="form-control" v-model="category_id" name="category_id">
                    <template v-for="category in categories" >
                        <option :value="category.id">{{ category.name }}</option>
                    </template>
                </select>
            </div>
            <div>
                <div>
                    <label for="name" class="form-label md-3">Загрузите картинку</label>
                </div>
                <div :class="errors.images ? 'alert alert-success' : 'd-none'" v-if="errors">
                    {{ errors.structure }}
                </div>
                <div ref="dropzone" class="btn col-12 bg-dark text-center text-light">
                    Загрузите
                </div>
            </div>

        </div>
        <div class=" text-right">
            <button type="submit" @click.prevent="create()" class="btn btn-secondary">Добавить продукт</button>
        </div>
    </div>

    <div class="alert alert-success" v-if="successfully_changed">
        {{ successfully_changed }}
    </div>
    <div class="alert alert-success" v-if="error_when_changing">
        {{ error_when_changing }}
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
                <th scope="col">Вес гр.</th>
                <th scope="col">Цена</th>
                <th scope="col">Категория</th>
                <th scope="col">Изменить</th>
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
                    <td>{{ product.weight + ' гр.'}}</td>
                    <td>{{ product.price + ' р.' }}</td>
                    <td>
                        <template v-for="category in product.category">
                            <option :value="category.id"> {{ category.name }} </option>
                        </template>
                    </td>
                    <td>
                        <a @click.prevent="changeProduct(product.id, product.name, product.structure, product.description, product.weight, product.price)" class="btn btn-warning">Изменить</a>
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
                    <th>
                        <textarea
                            class="form-control"
                            v-model="structure"
                            :style="{ height: dataHeight }"
                            @input="autoResize"
                        ></textarea>
                    </th>
                    <th>
                        <textarea
                            class="form-control"
                            v-model="description"
                            :style="{ height: dataHeight }"
                            @input="autoResize"
                        ></textarea>
                    </th>
                    <th><input type="text" v-model="weight" class="form-control"></th>
                    <th><input type="text" v-model="price" class="form-control"></th>
                    <td>
                        <select class="form-control" v-model="category_id" name="category_id">
                            <template v-for="category in categories" >
                                <option :value="category.id">{{ category.name }}</option>
                            </template>
                        </select>
                    </td>
                    <td>
                        <button type="submit" @click.prevent="update(product.id)" class="btn btn-success">
                            Сохранить
                        </button>
                    </td>
                    <td>
                        <button type="submit" @click.prevent="deleteProduct(product.id)" class="btn btn-danger">
                            Удалить
                        </button>
                    </td>
                </tr>

            </template>
            </tbody>
        </table>
    </div>

</template>

<script>
import Dropzone from "dropzone";
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

            successfully_changed: null,
            error_when_changing: null,

            // изменение продукта
            name: null,
            structure: null,
            description: null,
            weight: null,
            price: null,

            // добавление продукта
            product_name: null,
            product_structure: null,
            product_description: null,
            product_weight: null,
            product_price: null,

            dataHeight: 'auto', // Начальная высота для описания

            category_id: null,

            // image: null,
            dropzone: null,
            images: null
        }
    },

    mounted() {
        console.log('Component mounted.')
        this.getCategory()
        this.getProduct()

        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: "/api/admin/product/create",
            autoProcessQueue: false,
            addRemoveLinks: true
        })
    },

    methods: {
        getProduct() {
            axios.get('/api/admin/product/get')
                .then(result => {
                    this.products = result.data // надо решить проблему
                    console.log(this.products)
                })
        },

        getCategory() {
            axios.get('/api/admin/category/get')
                .then(result => {
                    //console.log(result)
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
                price: this.price,
                category_id: this.category_id
            })
                .then(result => {
                    this.getCategory()
                    this.getProduct()
                    this.productId = null
                    this.successfully_changed = result.data.successfully_changed
                    this.error_when_changing = result.data.error_when_changing
                })
        },
        create() {
            const formData = new FormData();

            // Добавление текстовых полей
            formData.append('name', this.product_name);
            formData.append('structure', this.product_structure);
            formData.append('description', this.product_description);
            formData.append('weight', this.product_weight);
            formData.append('price', this.product_price);
            formData.append('category_id', this.category_id);
            // console.log(this.dropzone.getAcceptedFiles())

            const files = this.dropzone.getAcceptedFiles()
            files.forEach(file => {
                formData.append('images[]', file)
                this.dropzone.removeFile(file)
            })

            console.log(formData)

            axios.post('/api/admin/product/create', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(result => {
                    console.log(result)
                    this.product_name = null
                    this.product_structure = null
                    this.product_description = null
                    this.product_weight = null
                    this.product_price = null
                    this.category_id = null

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

        // autoResizeDescription(event) {
        //     const textarea = event.target;
        //     textarea.style.height = 'auto'; // Сбрасываем высоту
        //     textarea.style.height = `${textarea.scrollHeight}px`; // Устанавливаем новую высоту
        // },
        autoResize(event) {
            const textarea = event.target;
            textarea.style.height = 'auto'; // Сбрасываем высоту
            textarea.style.height = `${textarea.scrollHeight}px`; // Устанавливаем новую высоту
        }
    },
}
</script>
<style>
textarea {
    transition: height 0.2s; /* Плавное изменение высоты */
}
</style>



