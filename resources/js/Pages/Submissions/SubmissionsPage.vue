<template>
    <v-toolbar
        height="91"
        color="primary"
    >
        <!-- Back Button -->
        <v-btn type="icon" @click="goBack">
            <v-icon>mdi-arrow-left</v-icon>
        </v-btn>

        <!-- Toolbar Title -->
        <v-toolbar-title>{{ module.code }}</v-toolbar-title>

        <v-spacer></v-spacer>

    </v-toolbar>
    <v-container>
        <v-row>
            <v-col>
               Hi from submissions page
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from 'axios';
import AssignmentsDataTable from "@/Components/Assignments/AssignmentsDataTable.vue";

export default {
    name: 'SubmissionsPage',
    components: {AssignmentsDataTable},
    props: {
        module: {
            required: true
        }
    },
    data() {
        return {};
    },
    methods: {
        goBack() {
            window.history.back();
        }
    },
}
</script>

<style scoped>
</style>
