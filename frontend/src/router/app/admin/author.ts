import AdminLayoutAuthor from "@/views/admin/author/layout.vue";

import AdminListAuthor from "@/views/admin/author/list.vue";
import AdminStoreAuthor from "@/views/admin/author/store.vue";
import AdminUpdateAuthor from "@/views/admin/author/update.vue";
import AdminShowAuthor from "@/views/admin/author/show.vue";

export const author = [
    {
        path: "authors",
        component: AdminLayoutAuthor,
        children: [
            {
                path: "",
                component: AdminListAuthor,
                name: "admin.author.list",
                meta: {
                    auth: true
                }
            },
            {
                path: "store",
                component: AdminStoreAuthor,
                name: "admin.author.store",
                meta: {
                    auth: true
                }
            },
            {
                path: "update/:id",
                component: AdminUpdateAuthor,
                name: "admin.author.update",
                meta: {
                    auth: true
                },
                props: true
            },
            {
                path: "show/:id",
                component: AdminShowAuthor,
                name: "admin.author.show",
                meta: {
                    auth: true
                },
                props: true
            },
        ]
    }
]
