<template>
    <AppClean :app-bar-header="appBarHeader">
        <student-users-data-table
            :student-users="studentUsers"
            @add-user="openStudentDialog"
            @edit-user="editUser"
            @delete-user="deleteUser"
        ></student-users-data-table>

        <StudentFormDialog
            v-if="showStudentDialog"
            :loading="loading"
            @saveStudent="saveStudent"
            @closeDialog="closeStudentDialog"
        />
    </AppClean>
</template>

<script>
import axios from 'axios';
import AppClean from "@/Layouts/AppClean.vue";
import StudentUsersDataTable from "@/Components/Management/StudentManagement/StudentUsersDataTable.vue";
import StudentFormDialog from "@/Components/Management/StudentManagement/StudentFormDialog.vue";
export default {
    name: 'StudentManagementPage',
    components: {
        AppClean,
        StudentUsersDataTable,
        StudentFormDialog
    },
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
        return {
            showStudentDialog: false,
            loading: false
        };
    },
    methods: {
        openStudentDialog() {
            console.log("Add Student Button Clicked!");
            this.showStudentDialog = true;
        },
        editUser(user) {

        },
        deleteUser(user) {

        },
        saveStudent(studentData) {
            this.loading = true;
            axios.post('/api/students', studentData)
                .then(response => {

                    this.showStudentDialog = false;
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                });
        },
        closeStudentDialog() {
            this.showStudentDialog = false;
        }
    }
}
</script>

<style scoped>
/* Add styles here */
</style>
