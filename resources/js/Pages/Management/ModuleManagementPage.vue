<template>
    <AppClean :app-bar-header="appBarHeader">
        <ModuleDataTable :modules="modules"></ModuleDataTable>
    </AppClean>
</template>

<script>
import axios from 'axios';
import AppClean from "@/Layouts/AppClean.vue";
import ModuleDataTable from "@/Components/Management/ModuleManagement/ModuleDataTable.vue";

export default {
    name: 'ModuleManagementPage',
    components: {ModuleDataTable, AppClean},
    props: {
        appBarHeader: {
            type: String,
            required: false,
            default: '',
        },
        modules: {
            type: Array,
            required: true,
            default: [],
        },
        users: {
            type: Array,
            required: true,
            default: [],
        }
    },
    data() {
        return {};
    },
    methods: {},
}
</script>

<style scoped>
/* Add styles here */
</style>
