<template>
    <AppClean :app-bar-header="appBarHeader">
        <lecturer-users-data-table
            :lecturer-users="lecturerUsers"
            @add-user="addUser"
            @edit-user="editUser"
            @delete-user="deleteUser"></lecturer-users-data-table>

        <!-- Bind v-model to showDialog -->
        <lecturer-form-dialog
            v-model="showDialog"
            @cancel="cancelDialog"
            @saveLecturer="saveLecturer"
            :max-width="600"
            :lecturer="selectUser"
            :useDefaultColor="true" value>
        </lecturer-form-dialog>

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

export default {
    name: 'LecturerManagementPage',
    components: {
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
            showDialog: false,
            selectUser: { id: null, name: '', surname: '', email: '' },
            editing: false,
            snackbar: {
                show: false,
                message: '',
                color: 'success',
                timeout: 3000
            },
        };
    },
    methods: {
        addUser() {
            this.selectUser = { name: '', surname: '', email: '' };
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
        async saveLecturer(lecturer) {
            if (this.editing) {
                await this.updateLecturer(lecturer);
            } else {
                await this.createLecturer(lecturer);
            }
        },
        async createLecturer(lecturer) {
            try {
                const response = await axios.post('/api/v1/create/user', {
                    first_name: lecturer.name,
                    last_name: lecturer.surname,
                    email: lecturer.email,
                    role: 'lecturer'
                });
                this.lecturerUsers.push(response.data.lecturer);
                this.snackbar.message = "Lecturer successfully added!";
                this.snackbar.show = true;
            } catch (error) {
                this.snackbar.message = error.response?.data?.errors || "An error occurred";
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
                const index = this.lecturerUsers.findIndex(user => user.id === lecturer.id);
                if (index !== -1) {
                    this.$set(this.lecturerUsers, index, response.data.lecturer);
                }
                this.snackbar.message = "Lecturer successfully updated!";
                this.snackbar.show = true;
            } catch (error) {
                this.snackbar.message = error.response?.data?.errors || "An error occurred";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            } finally {
                this.showDialog = false;
            }
        },
        async deleteUser(user) {
            try {
                const response = await axios.delete(`/api/v1/delete/user/${user.id}`);

                // Remove the lecturer from the lecturerUsers array
                this.lecturerUsers = this.lecturerUsers.filter(lecturer => lecturer.id !== user.id);

                this.snackbar.message = "Lecturer successfully deleted!";
                this.snackbar.show = true;
            } catch (error) {
                this.snackbar.message = error.response?.data?.errors || "An error occurred while deleting the lecturer";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            }
        },
        cancelDialog() {
            this.showDialog = false;
            this.selectUser = { name: '', surname: '', email: '' };
        }
    }
};
</script>

<style scoped></style>
