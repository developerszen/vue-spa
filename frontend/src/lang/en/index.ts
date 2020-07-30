import { app } from "./app";
import es_vuetify from "vuetify/src/locale/es";
import validationMessages from "vee-validate/dist/locale/en.json";

export const en = {
    ...app,
    $vuetify: es_vuetify,
    validations: {
        ...validationMessages.messages
    }
};
