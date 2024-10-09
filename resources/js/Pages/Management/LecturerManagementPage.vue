<template>
    <AppClean :app-bar-header="appBarHeader">
        <lecturer-users-data-table
            :lecturer-users="lecturerUsers"
            @add-user="addUser"
            @edit-user="editUser"
            @delete-user="deleteUser"></lecturer-users-data-table>
    </AppClean>
</template>

<script>
import axios from 'axios';
import AppClean from "@/Layouts/AppClean.vue";
import LecturerUsersDataTable from "@/Components/Management/LecturerMangamenet/LecturerUsersDataTable.vue";

export default {
    name: 'LecturerManagementPage',
    components: {LecturerUsersDataTable, AppClean},
    props: {
        appBarHeader: {
            type: String,
            required: false,
            default: '',
        },
        lecturerUsers: {
            type: Array,
            required: true,
            default: [],
        }
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
/* Add styles here */
</style>
