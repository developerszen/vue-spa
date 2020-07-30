import Vue from "vue";
import { i18n } from "@/plugins/vue-i18n";
import { extend, ValidationProvider, ValidationObserver } from "vee-validate";
import { max, email, image, required } from "vee-validate/dist/rules";

Vue.component('validation-provider', ValidationProvider);
Vue.component('validation-observer', ValidationObserver);

extend('max', {
    ...max,
    message: (field, values): any => i18n.t('validations.max', values)
})

extend('email', {
    ...email,
    message: (field, values): any => i18n.t('validations.email', values)
})

extend('image', {
    ...image,
    message: (field, values): any => i18n.t('validations.image', values)
})

extend('required', {
    ...required,
    message: (field, values): any => i18n.t('validations.required', values)
})
