import './bootstrap';

import {createApp} from "vue";
import Root from "./App.vue";

const app = createApp();
app.component("example",Root);
app.mount("#app");
