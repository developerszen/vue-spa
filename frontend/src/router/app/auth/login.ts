import Login from "@/views/auth/login.vue";

export const login = [
    {
        path: "",
        name: "auth.login",
        component: Login,
        meta: {
            home_redirect: true,
        }
    }
]
