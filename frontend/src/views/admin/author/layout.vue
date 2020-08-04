<template lang="pug">
    v-row(justify="center")
        v-col.py-0(xl="9" lg="11" md="9" sm="10" xs="12" cols="12")
            //-Title
            v-col.py-0(cols="12")
                h2.primary--text {{ $t('admin.author.name') }}

            //- Body
            v-col.py-0(cols="12")
                router-view
</template>

<script lang="ts">
export default {

}
</script>
