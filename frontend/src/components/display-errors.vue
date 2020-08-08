<template lang="pug">
    v-alert(type="error" :value="true")
        ul
            li.body-2(v-for="(error, index) in errors" :key="index") {{ error[0] }}
</template>

<script lang="ts">
    export default {
        props: {
            errors: {
                required: true
            }
        }
    }
</script>
