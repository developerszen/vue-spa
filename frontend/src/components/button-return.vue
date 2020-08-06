<template lang="pug">
    v-btn(@click="$router.back()" depressed) {{ $t('general.return') }}
</template>

<script lang="ts">
    export default {
    }
</script>
