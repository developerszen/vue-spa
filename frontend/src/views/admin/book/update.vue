<template lang="pug">
    v-row(justify="center")
        v-col.py-0(cols="12")
            //- Title
            h3.secondary--text {{ $t('admin.book.update') }}

        v-row(justify="center")
            v-col(xl="5" lg="5" md="6" sm="10" xs="12" cols="12")
                v-card.primary.pa-4.elevation-4
                    //- Header
                    v-card-title.secondary--text {{ $t('general.info') }}
                    v-card-subtitle.white--text {{ $t('general.fields_requireds') }}

                    v-card-text
                        validation-observer(v-slot="{ invalid }")
                            v-row
                                //- Title
                                v-col(cols="12")
                                    validation-provider(
                                        :name="$t('admin.book.fields.title')"
                                        :rules="'required|max:150'"
                                        v-slot="{ errors }"
                                    )
                                        v-text-field(
                                            v-model="payload.title"
                                            counter="150"
                                            prepend-icon="fas fa-book"
                                            :label="$t('admin.book.fields.title')"
                                            :error-messages="errors"
                                            dense
                                            outlined
                                            dark
                                        )
                                //- Category
                                v-col(cols="12")
                                    validation-provider(
                                        :name="$t('admin.book.fields.category')"
                                        :rules="'required'"
                                        v-slot="{ errors }"
                                    )
                                        app-loader(v-show="loading.resources")
                                        v-select(
                                            v-show="!loading.resources"
                                            v-model="payload.category_id"
                                            item-text="name"
                                            item-value="id"
                                            :items="categories"
                                            prepend-icon="fas fa-sitemap"
                                            :label="$t('admin.book.fields.category')"
                                            :error-messages="errors"
                                            dense
                                            outlined
                                            dark
                                        )

                                //- Authors
                                v-col(cols="12")
                                    validation-provider(
                                        :name="$t('admin.book.fields.authors')"
                                        :rules="'required'"
                                        v-slot="{ errors }"
                                    )
                                        app-loader(v-show="loading.resources")
                                        v-select(
                                            v-show="!loading.resources"
                                            v-model="payload.authors"
                                            item-text="name"
                                            item-value="id"
                                            :items="authors"
                                            prepend-icon="fas fa-pen-nib"
                                            :label="$t('admin.book.fields.authors')"
                                            :error-messages="errors"
                                            dense
                                            outlined
                                            dark
                                            multiple
                                        )

                                //- Synopsis
                                v-col(cols="12")
                                    validation-provider(
                                        :name="$t('admin.book.fields.synopsis')"
                                        :rules="'required|max:500'"
                                        v-slot="{ errors }"
                                    )
                                        v-textarea(
                                            v-model="payload.synopsis"
                                            counter="500"
                                            prepend-icon="fas fa-file-alt"
                                            :label="$t('admin.book.fields.synopsis')"
                                            :error-messages="errors"
                                            :value="payload.synopsis"
                                            dense
                                            outlined
                                            dark
                                        )

                                //- Image
                                v-col(cols="12")
                                    validation-provider(
                                        ref="provider_image"
                                        :name="$t('admin.book.fields.image')"
                                        :rules="'image'"
                                        v-slot="{ errors }"
                                    )
                                        v-file-input(
                                            v-model="file"
                                            prepend-icon="fas fa-image"
                                            :label="$t('admin.book.fields.image')"
                                            :error-messages="errors"
                                            @change="setImage"
                                            dense
                                            outlined
                                            dark
                                        )

                                v-col.py-0.text-center(cols="12")
                                    v-btn(
                                        color="secondary"
                                        :loading="loading.data"
                                        :disabled="invalid || loading.data"
                                        @click="save()"
                                    ) {{ $t('general.update') }}

                                    button-return.ml-2



</template>

<script lang="ts">
import axios from "axios";

export default {
    props: {
        id: {
            required: true
        }
    },
    data() {
        return {
            loading: {
                resources: false,
                data: false,
            },
            file: [],
            payload: {
                category_id: "",
                authors: [],
                title: "",
                synopsis: "",
                image: "",
            },
            categories: [],
            authors: [],
        }
    },
    created() {
        this.loading.resources = true;

        axios.get("/api/books/resources").then((response) => {
            this.categories = response.data.categories;
            this.authors = response.data.authors;
        })

        axios.get(`/api/books/${this.id}/edit`).then((response) => {
            this.loading.resources = false;
            this.payload = response.data;
            this.handleImage();
        });
    },
    watch: {
        file(value) {
            this.setImage(value);
        }
    },
    methods: {
        save() {
            this.loading.data = true;

            const form = new FormData();
            form.append("title", this.payload.title);
            form.append("synopsis", this.payload.synopsis);
            form.append("category_id", this.payload.category_id);
            form.append("_method", "put");

            if (this.payload.image) {
                form.append("image", this.payload.image);
            }

            for(const [index, author] of this.payload.authors.entries()) {
                form.append(`authors[${index}]`, author);
            }

            axios.post(`/api/books/${this.id}`, form).then(() => {
                this.loading.data = false;

                this.$notify({
                    type: 'success',
                    title: this.$t('general.notifications.success.title'),
                    text: this.$t('general.notifications.success.server'),
                });

                this.$router.push({ name: 'admin.book.list' });
            }).catch(() => {
                this.loading.data = false;

                this.$notify({
                    type: 'error',
                    title: this.$t('general.notifications.error.title'),
                    text: this.$t('general.notifications.error.server'),
                });
            })
        },
        async setImage(image) {
            const { valid } = await this.$refs.provider_image.validate(image);

            if (valid) {
                this.payload.image = image;
            }
        },
        handleImage() {
            if (!this.payload.image) return;

            axios.get(`/${this.payload.image}`, { responseType: "blob" }).then(({ data }) => {
                this.file = this.generateImage(data);
                this.setImage(data);
            });
        },
        generateImage(data) {
            const extension = data.type.slice(data.type.indexOf("/") + 1);
            const name = `${new Date().getTime()}.${extension}`;

            return new File([data], name, { type: data.type });
        }
    }
}
</script>
