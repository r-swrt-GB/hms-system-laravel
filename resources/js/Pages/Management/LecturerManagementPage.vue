<template>
    <AppClean>
        <lecturer-users-data-table
            :lecturer-users="sinkedLecturers"
            @add-user="addUser"
            @edit-user="editUser"
            @delete-user="deleteUser"></lecturer-users-data-table>

        <!-- Bind v-model to showDialog -->
        <lecturer-form-dialog
            :value="showDialog"
            @update:value="showDialog = $event"
            @saveLecturer="saveLecturer"
            :max-width="600"
            :lecturer="selectUser"
            :useDefaultColor="true">
        </lecturer-form-dialog>

        <!-- Delete Confirmation Dialog -->
        <lecturer-delete-dialog
            v-model="showDeleteDialog"
            @update:value="showDeleteDialog = $event"
            @confirmDelete="confirmDelete"
            @cancelDelete="cancelDelete">
        </lecturer-delete-dialog>

        <!-- Snackbar for success message -->
        <v-snackbar v-model="snackbar.show" :timeout="snackbar.timeout" :color="snackbar.color">
            {{ snackbar.message }}
        </v-snackbar>
    </AppClean>
</template>

<script>
import LecturerUsersDataTable from "@/Components/Management/LecturerMangamenet/LecturerUsersDataTable.vue";
import LecturerFormDialog from "@/Components/Management/LecturerMangamenet/LecturerFormDialog.vue";
import AppClean from "@/Layouts/AppClean.vue";
import LecturerDeleteDialog from "@/Components/Management/LecturerMangamenet/LecturerDeleteDialog.vue";
import axios from "axios";

export default {
    name: 'LecturerManagementPage',
    components: {
        LecturerDeleteDialog,
        LecturerFormDialog,
        LecturerUsersDataTable,
        AppClean
    },
    props: {
        lecturerUsers: {
            required: true,
        }
    },
    data() {
        return {
            localLecturers: {...this.lecturerUsers},
            showDialog: false,
            showDeleteDialog: false,
            selectUser: {id: null, name: '', surname: '', email: ''},
            editing: false,
            lecturerToDelete: null,
            snackbar: {
                show: false,
                message: '',
                color: 'success',
                timeout: 3000
            },
        };
    },
    computed: {
        sinkedLecturers() {
            return this.localLecturers;
        },
    },
    methods: {
        addUser() {
            this.selectUser = {name: '', surname: '', email: ''};
            this.editing = false;
            this.showDialog = true;
        },
        editUser(user) {
            this.selectUser = {
                id: user.id,
                name: user.first_name,
                surname: user.last_name,
                email: user.email
            };
            this.editing = true;
            this.showDialog = true;
        },
        deleteUser(user) {
            this.selectUser = {
                id: user.id,
                name: user.first_name,
                surname: user.last_name,
                email: user.email
            };
            this.showDeleteDialog = true;
        },
        async saveLecturer(lecturer) {
            if (this.editing) {
                await this.updateLecturer(lecturer);
            } else {
                await this.createLecturer(lecturer);
            }
        },
        async createLecturer(lecturer) {
            try {
                const response = await axios.post(`/api/v1/create/user`, {
                    first_name: lecturer.name,
                    last_name: lecturer.surname,
                    email: lecturer.email,
                    role: 'lecturer'
                });
                this.snackbar.message = "Lecturer added successfully";
                this.snackbar.color = "success";
                this.snackbar.show = true;
            } catch (error) {
                this.snackbar.message = error.response?.data?.errors || "Failed to add Lecturer";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            } finally {
                this.showDialog = false;
            }
        },
        async updateLecturer(lecturer) {
            try {
                const response = await axios.patch(`/api/v1/edit/user/${lecturer.id}`, {
                    first_name: lecturer.name,
                    last_name: lecturer.surname,
                    email: lecturer.email
                });
                this.snackbar.message = "Lecturer updated successfully";
                this.snackbar.color = "success";
                this.snackbar.show = true;
            } catch (error) {
                this.snackbar.message = error.response?.data?.errors || "Failed to update Lecturer";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            } finally {
                this.showDialog = false;
            }
        },
        async confirmDelete() {
            try {
                const lecturer = this.selectUser;
                await axios.delete(`/api/v1/delete/user/${lecturer.id}`);

                this.snackbar.message = "Lecturer deleted successfully";
                this.snackbar.color = "success";
                this.snackbar.show = true;
            } catch (error) {
                this.snackbar.message = error.response?.data?.errors || "Failed to delete Lecturer";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            } finally {
                this.showDeleteDialog = false;
            }
        },
        cancelDelete() {
            this.showDeleteDialog = false;
        },
    }
};
</script>

<style scoped></style>
