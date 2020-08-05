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
            //- Datatable
            v-data-table(:headers="headers" :items="items" :items-per-page="5")
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
                        color="error"
                        fab
                        x-small
                        depressed
                    ): v-icon(x-small) fas fa-trash
</template>

<script lang="ts">
import axios from "axios";

export default {
    data() {
        return {
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
        }
    }
}
</script>
