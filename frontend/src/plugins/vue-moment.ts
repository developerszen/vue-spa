import Vue from "vue";
import moment from "moment";
import VueMoment from "vue-moment";

moment.locale('es');

Vue.use(VueMoment, {
    moment
});
