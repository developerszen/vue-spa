<template lang="pug">
    v-row(justify="center")
        v-col.py-0(xl="9" lg="11" md="9" sm="10" xs="12" cols="12")
            //-Title
            v-col.py-0(cols="12")
                h2.primary--text {{ $t('admin.home.name') }}

            //- Body
            v-col.py-0(cols="12")
                v-row
                    v-col(
                        v-for="(item, index) in items" :key="index"
                        xl="4" lg="4" md="6" sm="6" xs="12" cols="12"
                        )
                        v-card.primary(:to="item.to")
                            v-toolbar(color="primary" dense flat)
                                v-toolbar-title.font-weight-bold.secondary--text
                                    v-icon(color="secondary" left small) {{ item.icon }}
                                    | {{ item.title }}

                                v-spacer

                                v-btn(
                                    color="secondary"
                                    :to="item.to"
                                    x-small
                                    fab
                                )
                                    v-icon(x-small) fas fa-plus

                            v-card-text.pt-0.white--text {{ item.description }}
</template>

<script lang="ts">
export default {
    data() {
        return {
            items: [
                {
                    icon: 'fas fa-book',
                    title: this.$t('admin.book.name'),
                    description: this.$t('admin.book.description'),
                    to: { name: 'admin.book.list' }
                },
                {
                    icon: 'fas fa-pen-nib',
                    title: this.$t('admin.author.name'),
                    description: this.$t('admin.author.description'),
                    to: { name: "admin.author.list" }
                },
                {
                    icon: 'fas fa-sitemap',
                    title: this.$t('admin.category.name'),
                    description: this.$t('admin.category.description'),
                    to: { name: 'admin.category.list' }
                },
            ]
        }
    }
}
</script>
