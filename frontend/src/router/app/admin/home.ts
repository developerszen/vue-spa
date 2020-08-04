import AdminHome from "@/views/admin/home.vue";

export const home = [
    {
        path: "home",
        component: AdminHome,
        name: "admin.home",
        meta: {
            auth: true,
        }
    }
]
