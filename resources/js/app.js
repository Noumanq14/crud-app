import './bootstrap';

import {createApp} from "vue";
import app from "./layouts/app.vue";
import router from "./router.js";
import { createPinia } from "pinia";

createApp(app).use(router).use(createPinia()).mount("#app");
