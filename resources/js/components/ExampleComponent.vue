<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods: {

            get() {
                axios({
                    method: 'post',
                    url: 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address',
                    mode: "cors",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "Authorization": "Token " + 'fe5af647eda9ca0ec6fcacacad50f45a035eb5aa'
                    },
                })
                    .then(result => {
                        console.log(result)
                    })

            }

        },

    }
</script>
