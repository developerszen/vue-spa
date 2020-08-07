<template lang="pug">
    v-row(justify="center")
        v-col.py-0(cols="12")
            //- Title
            h3.secondary--text {{ $t('admin.book.show') }}

        app-loader(v-if="loading")

        v-row(v-else justify="center")
            v-col(xl="5" lg="5" md="6" sm="10" xs="12" cols="12")
                v-card(color="primary")
                    v-card-text
                        v-row
                            v-col.text-center.py-0.secondary--text.text-h6.font-weight-bold(cols="12")
                                | {{ record.title }}

                            v-col.py-0.white--text(cols="12")
                                //- Category
                                div
                                    span.font-weight-bold
                                        | {{ $t('admin.book.fields.category') }}:
                                    | {{ record.category.name }}
                                //- Authors
                                div
                                    span.font-weight-bold
                                        | {{ $t('admin.book.fields.authors') }}:
                                    v-chip.ml-2.primary--text(
                                        v-for="(author, index) in record.authors"
                                        :key="index"
                                        color="secondary"
                                        small
                                    ) {{ author.name }}
                                //- Synopsis
                                div
                                    span.font-weight-bold
                                        | {{ $t('admin.book.fields.synopsis') }}:
                                    | {{ record.synopsis }}

                                //- Created at
                                div
                                    span.font-weight-bold
                                        | {{ $t('admin.book.fields.created_at') }}:
                                    | {{ record.created_at | moment('LLL') }}
                                //- Created by
                                div
                                    span.font-weight-bold
                                        | {{ $t('admin.book.fields.created_by') }}:
                                    | {{ record.created_by.name }}
                                //- Updated at
                                div(v-if="record.updated_at")
                                    span.font-weight-bold
                                        | {{ $t('admin.book.fields.updated_at') }}:
                                    | {{ record.updated_at | moment('LLL') }}
                                //- Updated by
                                div(v-if="record.updated_by")
                                    span.font-weight-bold
                                        | {{ $t('admin.book.fields.updated_by') }}:
                                    | {{ record.updated_by.name }}


            v-col.text-center(cols="12"): button-return
</template>

<script lang="ts">
import axios from "axios";

export default {
    props: {
        id: {
            required: true
        }
    },
    created() {
        this.loading = true;

        axios.get(`/api/books/${this.id}`).then((response) => {
            this.loading = false;

            this.record = response.data;
        })
    },
    data() {
        return {
            loading: false,
            record: {}
        }
    }
}
</script>
