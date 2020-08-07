import AdminLayoutBook from "@/views/admin/book/layout.vue";

import AdminListBook from "@/views/admin/book/list.vue";
import AdminStoreBook from "@/views/admin/book/store.vue";
import AdminUpdateBook from "@/views/admin/book/update.vue";
import AdminShowBook from "@/views/admin/book/show.vue";

export const book = [
    {
        path: "book",
        component: AdminLayoutBook,
        children: [
            {
                path: "",
                component: AdminListBook,
                name: "admin.book.list",
                meta: {
                    auth: true
                }
            },
            {
                path: "store",
                component: AdminStoreBook,
                name: "admin.book.store",
                meta: {
                    auth: true
                }
            },
            {
                path: "update/:id",
                component: AdminUpdateBook,
                name: "admin.book.update",
                meta: {
                    auth: true
                },
                props: true
            },
            {
                path: "show/:id",
                component: AdminShowBook,
                name: "admin.book.show",
                meta: {
                    auth: true
                },
                props: true
            },
        ]
    }
]
