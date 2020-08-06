<template lang="pug">
    v-row(justify="center")
        v-col.py-0(cols="12")
            //- Title
            h3.secondary--text {{ $t('admin.author.list') }}

            //- Store
            v-btn(
                color="primary"
                :to="{ name: 'admin.author.store' }"
                fab
                x-small
                depressed
            )
                v-icon(x-small) fas fa-plus

            app-loader(v-if="loading.resource")

            //- Datatable
            v-data-table(v-else :headers="headers" :items="items" :items-per-page="5")
                template(#item.name="{ item }")
                    span.font-weight-bold {{ item.name }}

                template(#item.created_at="{ item }") {{ item.created_at | moment('LLL') }}

                template(#item.actions="{ item }")
                    //- Show
                    v-btn.mr-2(
                        color="primary"
                        :to="{ name: 'admin.author.show', params: { id: item.id } }"
                        fab
                        x-small
                        depressed
                    ): v-icon(x-small) fas fa-eye
                    //- Update
                    v-btn.mr-2(
                        color="secondary"
                        :to="{ name: 'admin.author.update', params: { id: item.id } }"
                        fab
                        x-small
                        depressed
                    ): v-icon(x-small) fas fa-edit
                    //- Delete
                    v-btn.mr-2(
                        :disabled="Boolean(item.books_count)"
                        @click="openDialog(item)"
                        color="error"
                        fab
                        x-small
                        depressed
                    ): v-icon(x-small) fas fa-trash

        v-col.py-0.text-center(cols="12")
            button-return

        v-dialog(v-model="dialog" max-width="300" persistent)
            v-card(color="primary")
                v-card-text
                    v-row
                        v-col.text-center(cols="12")
                            v-icon(color="error" large) fas fa-exclamation-triangle

                        v-col.text-center.py-0.white--text(cols="12")
                            div.text-h6.font-weight-bold {{ $t('general.delete') }}
                            p {{ item.name }}

                            v-btn(
                                @click="deleteItem()"
                                :loading="loading.data"
                                color="secondary"
                            ) {{ $t('general.delete') }}

                            v-btn.ml-2(@click="dialog = false") {{ $t('general.close') }}

</template>

<script lang="ts">
import axios from "axios";

export default {
    data() {
        return {
            item: {},
            dialog: false,
            loading: {
                data: false,
                resource: false,
            },
            items: [],
            headers: [
                {
                    text: this.$t("admin.author.fields.name"),
                    value: 'name'
                },
                {
                    text: this.$t("admin.author.fields.created_at"),
                    value: 'created_at'
                },
                {
                    text: this.$t("general.actions"),
                    value: 'actions'
                },
            ]
        }
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.loading.resource = true;

            axios.get("/api/authors").then((response) => {
                this.loading.resource = false;

                this.items = response.data;
            })
        },
        openDialog(item) {
            this.item = item;
            this.dialog = true;
        },
        deleteItem() {
            this.loading.data = true;

            axios.delete(`/api/authors/${this.item.id}`).then(() => {
                this.loading.data = false;
                this.dialog = false;
                this.fetchData();
            })
        }
    }
}
</script>
