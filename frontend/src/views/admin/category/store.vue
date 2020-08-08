<template lang="pug">
    v-row(justify="center")
        v-col.py-0(cols="12")
            //- Title
            h3.secondary--text {{ $t('admin.category.store') }}

        v-row(justify="center")
            v-col(xl="5" lg="5" md="6" sm="10" xs="12" cols="12")
                v-card.primary.pa-4.elevation-4
                    //- Header
                    v-card-title.secondary--text {{ $t('general.info') }}
                    v-card-subtitle.white--text {{ $t('general.fields_requireds') }}

                    v-card-text
                        validation-observer(v-slot="{ invalid }")
                            v-row
                                v-col(cols="12")
                                    validation-provider(
                                        :name="$t('admin.category.fields.name')"
                                        :rules="'required|max:80'"
                                        v-slot="{ errors }"
                                    )
                                        v-text-field(
                                            v-model="payload.name"
                                            counter="80"
                                            prepend-icon="fas fa-sitemap"
                                            :label="$t('admin.category.fields.name')"
                                            :error-messages="errors"
                                            dense
                                            outlined
                                            dark
                                        )
                                v-col.py-0.text-center(cols="12")
                                    v-btn(
                                        color="secondary"
                                        :loading="loading"
                                        :disabled="invalid || loading"
                                        @click="save()"
                                    ) {{ $t('general.store') }}

                                    button-return.ml-2



</template>

<script lang="ts">
import axios from "axios";

export default {
    data() {
        return {
            loading: false,
            payload: {
                name: ""
            }
        }
    },
    methods: {
        save() {
            this.loading = true;

            axios.post('/api/categories', this.payload).then(() => {
                this.loading = false;

                this.$notify({
                    type: 'success',
                    title: this.$t('general.notifications.success.title'),
                    text: this.$t('general.notifications.success.server'),
                });

                this.$router.push({ name: 'admin.category.list' });
            }).catch(() => {
                this.loading = false;

                this.$notify({
                    type: 'error',
                    title: this.$t('general.notifications.error.title'),
                    text: this.$t('general.notifications.error.server'),
                });
            })
        }
    }
}
</script>
