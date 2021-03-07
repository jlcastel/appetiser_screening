<template>
    <div>
        <v-btn v-on:click="onClickFunction"  class="ma-2" depressed color="primary">{{buttonName}}</v-btn>
    </div>
</template>

<script>
export default {
    props: {
        buttonName: String,
        buttonColor: String,
        onClickFunction : Function,
    },
}
</script>