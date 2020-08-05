import axios from "axios";
import router from "@/router";

axios.interceptors.request.use(
    async (config) => {
        const token = localStorage.getItem("token");

        config.headers["Authorization"] = `Bearer ${token}`;

        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        const status = error.response.status;

        if (status == 401) {
            localStorage.setItem("token", "");
            router.push({ name: "auth.login" });
        }

        return Promise.reject(error);
    }
);
