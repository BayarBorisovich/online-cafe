import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import MainComponent from "./components/MainComponent.vue";
import Cart from "./components/Cart.vue";
import Order from "./components/Order.vue";
import OrderItem from "./components/OrderItem.vue";

app.component('example-component', ExampleComponent);
app.component('main-component', MainComponent);
app.component('cart-component', Cart);
app.component('order-component', Order);
app.component('order-item-component', OrderItem);

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

app.mount('#app');
