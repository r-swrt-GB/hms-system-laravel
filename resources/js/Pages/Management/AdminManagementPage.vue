<template>
    <AppClean :app-bar-header="appBarHeader">
        <AdminUsersDataTable :admin-users="adminUsers"
                             @add-user="addUser"
                             @edit-user="editUser"
                             @delete-user="deleteUser"
        ></AdminUsersDataTable>
    </AppClean>
</template>

<script>
import axios from 'axios';
import AppClean from "@/Layouts/AppClean.vue";
import AdminUsersDataTable from "@/Components/Management/AdminManagement/AdminUsersDataTable.vue";
import LecturerUsersDataTable from "@/Components/Management/LecturerMangamenet/LecturerUsersDataTable.vue";

export default {
    name: 'AdminManagementPage',
    components: {LecturerUsersDataTable, AdminUsersDataTable, AppClean},
    props: {
        appBarHeader: {
            type: String,
            required: false,
            default: '',
        },
        adminUsers: {
            type: Array,
            required: true,
            default: [],
        },
    },
    data() {
        return {};
    },
    methods: {
        addUser() {

        }, editUser(user) {

        }, deleteUser(user) {

        }
    },
}
</script>

<style scoped>
</style>
