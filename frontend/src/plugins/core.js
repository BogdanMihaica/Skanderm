import axios from "./axios";
import components from "./components"

export default {
    install(Vue) {
        components.install(Vue);
        axios.install(Vue);
    }
}