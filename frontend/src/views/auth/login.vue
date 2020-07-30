<template lang="pug">
    v-row
        v-col()
            v-card.primary.pa-4.elevation-4
                v-card-title.secondary--text {{ $t('auth.login') }}
                v-card-subtitle.white--text {{ $t('auth.enter_credentials') }}

                v-card-text
                    v-row
                        v-col


</template>

<script lang="ts">
    export default {};
</script>
