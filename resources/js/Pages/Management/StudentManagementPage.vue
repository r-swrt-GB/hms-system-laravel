<template>
    <AppClean :app-bar-header="appBarHeader">
        <student-users-data-table
            :student-users="studentUsers"
            @add-user="openStudentDialog"
            @edit-user="openEditDialog"
            @delete-user="openDeleteDialog"
        ></student-users-data-table>

        <StudentFormDialog
            v-if="showStudentDialog"
            :loading="loading"
            :student="selectedStudent"
            :isUpdate="isUpdate"
            @saveStudent="saveStudent"
            @editStudent="editStudent"
            @closeDialog="closeStudentDialog"
        ></StudentFormDialog>

        <DeleteStudentDialog
            v-if="showDeleteDialog"
            :loading="loading"
            :student="selectedStudent"
            @deleteStudentClicked="deleteStudent"
            @dialogClosed="closeDeleteDialog"
        ></DeleteStudentDialog>


    </AppClean>
</template>

<script>
import axios from 'axios';
import AppClean from "@/Layouts/AppClean.vue";
import StudentUsersDataTable from "@/Components/Management/StudentManagement/StudentUsersDataTable.vue";
import StudentFormDialog from "@/Components/Management/StudentManagement/StudentFormDialog.vue";
import DeleteStudentDialog from "@/Components/Management/StudentManagement/DeleteStudentDialog.vue";
export default {
    name: 'StudentManagementPage',
    components: {
        DeleteStudentDialog,
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
            isUpdate: false,
            showStudentDialog: false,
            showDeleteDialog: false,
            showEditDialog: false,
            loading: false,
            selectedStudent: {
                first_name: '',
                last_name: '',
                email: '',
                role: '',
            }
        };
    },
    methods: {
        openStudentDialog() {
            console.log("Add Student Button Clicked!");
            this.isUpdate = false;
            this.showStudentDialog = true;
        },
        openEditDialog(student) {
            this.isUpdate = true;
            this.selectedStudent = student;
            this.showStudentDialog = true;
        },
        openDeleteDialog(student) {
            console.log("Delete Student Button Clicked!");
            this.selectedStudent = student;
            this.showDeleteDialog = true;
        },
        async editStudent(student) {
            this.loading = true;
            try {
                const response = await axios.patch(`/api/v1/edit/user/${student.id}`, {
                    first_name: student.first_name,
                    last_name: student.last_name,
                    email: student.email,
                    role: 'student',
                });
                console.log(response.data.message);

            } catch (error) {
                if(error.response && error.response.data) {
                    console.error(error.response.data.errors);
                } else {
                    console.error(error);
                }
            } finally {
                this.closeStudentDialog();
            }
        },
        async saveStudent(student) {
            this.loading = true;
            try {
                const response = await axios.post('/api/v1/create/user', {
                    first_name: student.name,
                    last_name: student.surname,
                    email: student.email,
                    role: 'student',
                });

                const newStudent = response.data.student;

                this.studentUsers.push(newStudent);

                console.log(response.data.message);
            } catch (error) {
                if (error.response && error.response.data) {
                    console.error(error.response.data.errors);
                } else {
                    console.error(error);
                }
            } finally {
                this.loading = false;
                this.closeStudentDialog();
            }
        },
        async deleteStudent(student) {
            this.loading = true;
            console.log(student)
            try {
                const response = await axios.delete(`/api/v1/delete/user/${student.id}`);

                this.studentUsers = this.studentUsers.filter(u => u.id !== student.id);

                console.log(response.data.message);
            } catch (error) {
                if (error.response && error.response.data) {
                    console.error(error.response.data.errors);
                } else {
                    console.error(error);
                }
            } finally {
                this.loading = false;
                this.closeDeleteDialog();
            }
        },
        closeStudentDialog() {
            this.showStudentDialog = false;
        },
        closeDeleteDialog() {
            this.showDeleteDialog = false;
        },
    }
}
</script>

<style scoped>
/* Add styles here */
</style>
