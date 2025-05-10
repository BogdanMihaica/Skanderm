import ActionButton from "@/components/action/ActionButton.vue";
import FilterLayout from "@/components/filter/FilterLayout.vue";
import FormButton from "@/components/form/FormButton.vue";
import FormError from "@/components/form/FormError.vue";
import FormInput from "@/components/form/FormInput.vue";
import FormLayout from "@/components/form/FormLayout.vue";
import FormSelect from "@/components/form/FormSelect.vue";
import FormTextarea from "@/components/form/FormTextarea.vue";
import Grid from "@/components/grid/Grid.vue"
import Pannel from "@/components/pannel/Pannel.vue";
import UserEdit from "@/components/user/UserEdit.vue";
import UserList from "@/components/user/UserList.vue";
import UserLogin from "@/components/user/UserLogin.vue";
import UserRegister from "@/components/user/UserRegister.vue";

export default {
  	install(Vue) {
        // Grid
        Vue.component('app-grid', Grid);

        // Form
        Vue.component('app-form-input', FormInput);
        Vue.component('app-form-error', FormError);
        Vue.component('app-form-layout', FormLayout);
        Vue.component('app-form-select', FormSelect);
        Vue.component('app-form-textarea', FormTextarea);
        Vue.component('app-form-button', FormButton);

        // Filter
        Vue.component('app-filter-layout', FilterLayout);

        // User
        Vue.component('app-user-login', UserLogin);
        Vue.component('app-user-register', UserRegister);
        Vue.component('app-user-list', UserList);
        Vue.component('app-user-edit', UserEdit);

        // Pannel
        Vue.component('app-pannel', Pannel);

        // Action
        Vue.component('app-action-button', ActionButton);
    }
}