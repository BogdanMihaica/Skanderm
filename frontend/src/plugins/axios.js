import axios from "axios";

export default {
  	install(Vue) {
		const http = axios.create({
			baseURL: import.meta.env.VITE_BACKEND_URL,
			withCredentials: true,
		});

		Vue.config.globalProperties.$http = http;

		Vue.config.globalProperties.save = (url, record, id = null) => {
			if (id) {
				return Vue.config.globalProperties.$http.put(url + `/${id}`, record);
			} else {
				return Vue.config.globalProperties.$http.post(url, record);
			}
		};
  	}
}