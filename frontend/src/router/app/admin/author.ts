import AdminLayoutAuthor from "@/views/admin/author/layout.vue";

import AdminListAuthor from "@/views/admin/author/list.vue";

export const author = [
    {
        path: "authors",
        component: AdminLayoutAuthor,
        children: [
            {
                path: "",
                components: AdminListAuthor,
                name: "admin.author.list",
                meta: {
                    auth: true
                }
            }
        ]
    }
]
