<style scoped>
body {
    background-color: lightblue;
}

#form-wrapper {
    background-color: white;
    margin: auto;
    margin-top: 100px;
    width: 600px;
    height: auto;
    padding: 20px;
    border-radius: 12px;
    border: 1px solid lightgray;
}

#header {
    background-color: #638D99;
    border-radius: 10px 10px 0px 0px;
    border: lightgray solid 1px;
}

h1 {
    color: #D9F6FF;
}

h5 {
    color: #997654;
}

i {
    color: #997654;
}

button i {
    color: white;
}

hr {
    border-color: #E6C9AC;
}

button {
    background-color: #638D99 !important;
}

select {
    display: inline;
}

</style>
<template>
    <div class="container">
        <div class="row justify-content-between">
            <div id='header' class='text-center mt-5'>
                <h1>Оформление заказа</h1>
            </div>
            <div class="col-4">
                <div id='form-wrapper' class="mb-5">

                    <div class='text-center'>
                        <i class="fab fa-cc-visa fa-3x mr-3"></i>
                        <i class="fab fa-cc-mastercard fa-3x mr-3"></i>
                        <i class="fab fa-cc-amex fa-3x mr-3"></i>
                        <i class="fab fa-cc-discover fa-3x mr-3"></i>
                    </div>

                    <h4>Укажите свой адрес</h4>

                    <hr>

                    <div class='form-group mb-1'>
                        <label class='mb-1' for='firstName'>Имя</label>
                        <input class='form-control mb-1' id='firstName' type='text' placeholder='Имя'>
                    </div>

<!--                    <div class='form-group mb-1'>-->
<!--                        <label class='mb-1' for='lastName'>Фамилия</label>-->
<!--                        <input id='lastName' type='text' class='form-control' placeholder='Фамилия'>-->
<!--                    </div>-->

                    <div class='form-group mb-1'>
                        <label class='mb-1'>Телефон</label>
                        <input class='form-control' type='text' id='street1' placeholder='телефон'>
                    </div>

                    <div class='form-group mb-1'>
                        <label class='mb-1' for='city'>Город</label>
                        <input type='text' id='city' class='form-control' placeholder='Город'>
                    </div>

                    <div class='form-row mb-2'>
                        <div class='col-md-8'>
                            <label class='mb-1' for='state'>Улица</label>
                            <input id='street1' class='form-control' placeholder='Улица'>
                        </div>
                        <div class='col-md-4'>

                            <label class='mb-1' for='zip'>Дом</label>
                            <input type='text' id='zip' class='form-control' placeholder='дом'>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div id='form-wrapper'>

                    <h4>Card Info</h4>

                    <hr class='mb-1'>

                    <div class='form-group mb-1'>
                        <label class='mb-1' for='nameOnCard'>Name on card</label>
                        <input class='form-control' id='nameOnCard' placeholder='Johnny Big Dough'>
                    </div>

                    <div class='form-group mb-1'>
                        <label class='mb-1' for='cardNum'>Card number</label>
                        <input class='form-control' id='cardNum' placeholder>
                    </div>

                    <div class='form-row mb-1'>
                        <div class='col'>
                            <label class='mb-0' for='expMonth'>Expiration Month</label>
                            <select class='form-control' id='expMonth'>
                                <option value='01'>Jan</option>
                                <option value='02'>Feb</option>
                                <option value='03'>March</option>
                                <option value='04'>April</option>
                                <option value='05'>May</option>
                                <option value='06'>June</option>
                                <option value='07'>July</option>
                                <option value='08'>Aug</option>
                                <option value='09'>Sept</option>
                                <option value='10'>Oct</option>
                                <option value='11'>Nov</option>
                                <option value='12'>Dec</option>
                            </select>
                        </div>
                        <div class='col'>
                            <label class='mb-0' for='expYear'>Exp Year</label>
                            <select class='form-control' id='expYear'>
                                <option value='2023'>2023</option>
                                <option value='2023'>2022</option>
                                <option value='2023'>2021</option>
                                <option value='2023'>2020</option>
                                <option value='2023'>2019</option>
                            </select>
                        </div>
                        <div class='col'>
                            <label class='mb-0' for='ccv'>CCV</label>
                            <input placeholder='* * * *' class='form-control' id='ccv'>
                        </div>
                        <button class='btn btn-primary mt-4' type='submit'><i class="fas fa-lock mr-2"></i>Submit
                            Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Order",

    data() {
        return {
            name: null,
            phone: null,
            city: null,
            street: null,
            house: null,
            comment: null
        }
    },

    mounted() {
        console.log('Component mounted.')
    },

    methods: {
        orderRegistration() {
            axios.post('', {
                name: this.name,
                phone: this.phone,
                city: this.street,
                house: this.house,
                comment:this.comment})
                .then(result =>{
                    console.log(result)
                })
        }
    },
}
</script>

