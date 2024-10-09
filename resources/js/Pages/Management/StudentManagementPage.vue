<template>
    <AppClean :app-bar-header="appBarHeader">
        <student-users-data-table :student-users="studentUsers"
                                  @add-user="addUser"
                                  @edit-user="editUser"
                                  @delete-user="deleteUser"
        ></student-users-data-table>
    </AppClean>
</template>

<script>
import axios from 'axios';
import AppClean from "@/Layouts/AppClean.vue";
import StudentUsersDataTable from "@/Components/Management/StudentManagement/StudentUsersDataTable.vue";
import LecturerUsersDataTable from "@/Components/Management/LecturerMangamenet/LecturerUsersDataTable.vue";

export default {
    name: 'StudentManagementPage',
    components: {LecturerUsersDataTable, StudentUsersDataTable, AppClean},
    props: {
        appBarHeader: {
            type: String,
            required: false,
            default: '',
        },
        studentUsers: {
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
/* Add styles here */
</style>
