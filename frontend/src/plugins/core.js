import router from "./router";
import axios from "./axios";
import components from "./components"

export default {
    install(Vue) {
        components.install(Vue);
        axios.install(Vue);
        router.install(Vue);
    }
}