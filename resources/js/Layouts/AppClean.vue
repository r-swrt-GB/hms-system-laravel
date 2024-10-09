<template>
    <AppNav :app-bar-header="appBarHeader">
        <v-container style="padding: 50px">
            <v-col>
                <v-row>
                    <slot></slot>
                </v-row>
            </v-col>
        </v-container>
    </AppNav>
</template>
<script>
import AppNav from "@/Layouts/AppNav.vue";

export default {
    name: 'AppClean',
    components: {
        AppNav
    },
    props: {
        appBarHeader: {
            type: String,
            required: false,
            default: '',
        }
    }
}
</script>
