import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

// BOOTSTRAP
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'

// LAYOUT
import Default from './layout/wrapper/index.vue'
import Client from './layout/wrapper/client.vue'

// TOAST
import Toast, { useToast } from "vue-toastification";
import "vue-toastification/dist/index.css";

// ICON
import '@fortawesome/fontawesome-free/css/all.min.css'

// APP
const app = createApp(App)

// ROUTER
app.use(router)

// TOAST
app.use(Toast, {

    position: "top-right",

    timeout: 2500,

    closeOnClick: true,

    pauseOnHover: true,

    draggable: true,

    newestOnTop: true

})

// LAYOUT
app.component("default-layout", Default)

app.component("client-layout", Client)


// Chuyển alert() thành thông báo Toast toàn FE
const toast = useToast();

window.alert = (message) => {
  toast.info(String(message));
};
// MOUNT
app.mount("#app")