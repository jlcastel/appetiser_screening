<template>
    <div>
        <v-btn v-on:click="onClickFunction"  class="ma-2" outlined color="red">{{buttonName}}</v-btn>
    </div>
</template>

<script>
export default {
    props: {
        buttonName: String,
        onClickFunction : Function,
    },
}
</script>