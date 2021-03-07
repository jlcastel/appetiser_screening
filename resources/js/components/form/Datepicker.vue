<template>
    <div>
        <v-menu v-model="menu" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
            <template v-slot:activator="{ on, attrs }">
                <v-text-field v-model="value" :label="datePickerLabel" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
            </template>
            <v-date-picker v-model="dateFromInside" @input="changeValue" ></v-date-picker>
        </v-menu>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                menu: false,
                dateFromInside: '',
            };
        },
        props: {
            datePickerLabel: String,
            value : String,
        },
        methods: {
            changeValue(val) {
                this.menu = false;
                this.$emit('valueChanged', val);
            }
        }
    }
</script>