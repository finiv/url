import { createApp } from 'vue'
import UrlForm from "./components/UrlForm.vue";
import 'bootstrap/dist/css/bootstrap.min.css'; // Імпорт стилів Bootstrap
import 'bootstrap';

const app = createApp()

app.component('url-form', UrlForm)

app.mount('#app')
