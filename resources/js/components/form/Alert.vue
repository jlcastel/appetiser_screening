<template>
    <v-alert dense border="left" :type="alertType">
        {{message}}
    </v-alert>
</template>


<script>
export default {
    props: {
        alertType: String,
        message: String,
    },
}
</script>