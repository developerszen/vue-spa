import AdminLayoutCategory from "@/views/admin/category/layout.vue";

import AdminListCategory from "@/views/admin/category/list.vue";
import AdminStoreCategory from "@/views/admin/category/store.vue";
import AdminUpdateCategory from "@/views/admin/category/update.vue";
import AdminShowCategory from "@/views/admin/category/show.vue";

export const category = [
    {
        path: "categories",
        component: AdminLayoutCategory,
        children: [
            {
                path: "",
                component: AdminListCategory,
                name: "admin.category.list",
                meta: {
                    auth: true
                }
            },
            {
                path: "store",
                component: AdminStoreCategory,
                name: "admin.category.store",
                meta: {
                    auth: true
                }
            },
            {
                path: "update/:id",
                component: AdminUpdateCategory,
                name: "admin.category.update",
                meta: {
                    auth: true
                },
                props: true
            },
            {
                path: "show/:id",
                component: AdminShowCategory,
                name: "admin.category.show",
                meta: {
                    auth: true
                },
                props: true
            },
        ]
    }
]
