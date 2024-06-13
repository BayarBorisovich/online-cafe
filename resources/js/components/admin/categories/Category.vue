<template>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h1 class="m-0">Категории</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active">Категории</li>
                    </ol>
                </div><!-- /.col -->
                <hr class="border-bottom border-4 border-dark">
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="alert alert-success" v-if="success">
        {{success}}
    </div>
    <div class="alert alert-success" v-if="error">
        {{error}}
    </div>
    <div class="col-6 mb-3">
        <div class="mb-3">
            <label for="name" class="form-label">Добавление категории</label>
            <div :class="errors.name ? 'alert alert-success' : 'd-none'" v-if="errors">
                {{errors.name}}
            </div>
            <input type="text" class="form-control" v-model="category_name" name="name" placeholder="название категории">
        </div>
        <div class="text-right">
            <button type="submit" @click.prevent="create()" class="btn btn-secondary">Добавить</button>
        </div>
    </div>

    <div>
        <label for="name" class="form-label">Все категории</label>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Название</th>
                <th scope="col">Редактировать</th>
                <th scope="col">Удалить</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="category in categories">
                <tr :class=" isId(category.id) ? 'd-none' : ''">
                    <th scope="row">{{category.id}}</th>
                    <td>{{ category.name }}</td>
                    <td>
                        <a @click.prevent="changeCategoryId(category.id, category.name)" class="btn btn-success">Изменить</a>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#categoryDeleteModal">
                            Удалить
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="categoryDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"> Подтвердите пожалуйста</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Вы уверены что хотите удалить категорию ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет</button>
                                        <button type="submit" @click.prevent="deleteCategory(category.id)" class="btn btn-danger" data-bs-dismiss="modal">Да удалить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr :class=" isId(category.id) ? '' : 'd-none'">
                    <th scope="row">{{category.id}}</th>
                    <th><input type="text" v-model="name" class="form-control"></th>
                    <td>
                        <button type="submit" @click.prevent="update(category.id)" class="btn btn-success-danger">Сохранить</button>
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
            categories: null,
            categoryId: null,
            name: null,
            category_name: null,
            success: null,
            error: null,
            errors: {},
        }
    },

    mounted() {
        console.log('Component mounted.')
        this.getCategory()
        this.success = null
    },

    methods: {
        getCategory() {
            axios.get('/api/admin/category/get')
                .then(result => {
                    this.categories = result.data
                })
        },

        update(id) {
            console.log(id)
            axios.patch(`/api/admin/category/update/${id}`, {name: this.name})
                .then(result => {
                    this.getCategory()
                    this.categoryId = null
                })
        },
        create() {
            axios.post('/api/admin/category/create', {name: this.category_name})
                .then(result => {
                    console.log(result)
                    this.category_name = null
                    this.success = result.data.success
                    this.error = result.data.error
                    this.getCategory()
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        console.log(error)
                        this.errors = error.response.data.errors;
                    }
                    console.log(this.error)
                });
        },

        deleteCategory(id) {
            axios.delete(`/api/admin/category/delete/${id}`)
                .then(result => {
                    this.getCategory()
                })
        },

        changeCategoryId(id, name) {
            this.categoryId = id
            this.name = name
        },

        isId(id) {
            return this.categoryId === id;
        },
    }
}
</script>



