<template lang="pug">
    v-row(justify="center" align="center")
        v-col(xl="3" lg="4" md="5" sm="6" xs="10" cols="10")
            v-card.primary.pa-4.elevation-4
                v-card-title.secondary--text {{ $t('auth.login') }}
                v-card-subtitle.white--text {{ $t('auth.enter_credentials') }}

                v-card-text
                    v-row
                        v-col.text-center(cols="12")
                            v-icon(color="secondary" size="80") fas fa-fingerprint

                    validation-observer(v-slot="{ invalid }")
                        v-row
                            //- Email
                            v-col.py-0(cols="12")
                                validation-provider(
                                    :name="$t('auth.fields.email')"
                                    :rules="'required|email'"
                                    v-slot="{ errors }"
                                )
                                    v-text-field(
                                        v-model="payload.email"
                                        :label="$t('auth.fields.email')"
                                        prepend-icon="fas fa-at"
                                        :error-messages="errors"
                                        dark
                                        outlined
                                        dense
                                    )
                            //- Password
                            v-col.py-0(cols="12")
                                validation-provider(
                                    :name="$t('auth.fields.password')"
                                    :rules="'required'"
                                    v-slot="{ errors }"
                                )
                                    v-text-field(
                                        type="password"
                                        v-model="payload.password"
                                        :label="$t('auth.fields.password')"
                                        prepend-icon="fas fa-key"
                                        :error-messages="errors"
                                        dark
                                        outlined
                                        dense
                                    )
                            //- Remember
                            v-col.py-0(cols="12")
                                v-switch(
                                    color="secondary"
                                    v-model="payload.remember"
                                    :label="$t('auth.fields.remember')"
                                    dark
                                )
                            //- Actions
                            v-col.py-0.text-center(cols="12")
                                v-btn(
                                    color="secondary"
                                    :loading="loading"
                                    :disabled="loading || invalid"
                                    @click="login()"
                                ) {{ $t('auth.login') }}
            //- Footer
            v-footer(color="secondary" dark)
                v-row
                    v-col.text-center(cols="12")
                        v-icon(color="primary" left) fas fa-desktop
                        v-icon(color="primary" left) fas fa-tablet-alt
                        v-icon(color="primary" left) fas fa-mobile-alt
</template>

<script lang="ts">
    import axios from "axios";

    export default {
        data() {
            return {
                loading: false,
                payload: {
                    email: "",
                    password: "",
                    remember: false
                }
            }
        },
        methods: {
            login() {
                this.loading = true;

                axios.post("/api/login", this.payload)
                .then((response) => {
                    this.loading = false;
                    localStorage.setItem("token", response.data.token);

                    this.$notify({
                        type: "success",
                        title: this.$t("general.notifications.success.title"),
                        text: this.$t("auth.login_success"),
                    });

                    this.$router.push({ name: "admin.home" });
                })
                .catch(() => {
                    this.loading = false;

                    this.$notify({
                        type: "error",
                        title: this.$t("general.notifications.error.title"),
                        text: this.$t("auth.verify_credentials"),
                    });
                });
            }
        }
    };
</script>
