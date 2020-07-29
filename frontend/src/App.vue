<template lang="pug">
  v-app
    v-main
        v-btn(to="/") Home
        
        v-btn(to="/about") About

        router-view
</template>

<script lang="ts">
import Vue from 'vue';

export default Vue.extend({
  name: 'App',
  data: () => ({
    //
  }),
});
</script>
