<template>
    <AppClean :app-bar-header="appBarHeader">
        <!-- Admin Users Data Table -->
        <AdminUsersDataTable
            :admin-users="adminUsers"
            @add-user="addUser"
            @edit-user="editUser"
            @delete-user="deleteUser"
        />

        <!-- User Form Dialog -->
        <UserFormDialog
            v-model="showDialog"
            :form-data="formData"
            :key="dialogKey"
            @add-user="saveUser"
            @edit-user="editSaveUser"
            @secondaryButtonClicked="closeDialog"
        />

        <!-- Admin Delete Dialog -->
        <AdminDeleteDialog
            v-model="showDeleteDialog"
            @close="closeDeleteDialog"
            @confirm="handleConfirmDelete"
        />

        <!-- Snacbar Dialog -->
        <v-snackbar v-model="snackbar.show" :timeout="snackbar.timeout" :color="snackbar.color">
            {{ snackbar.message }}
        </v-snackbar>
    </AppClean>
</template>

<script>
import axios from 'axios';
import AppClean from "@/Layouts/AppClean.vue";
import AdminUsersDataTable from "@/Components/Management/AdminManagement/AdminUsersDataTable.vue";
import UserFormDialog from "@/Components/Management/AdminManagement/AdminFormDialog.vue";
import AdminDeleteDialog from "@/Components/Management/AdminManagement/AdminDeleteDialog.vue";

export default {
    name: 'AdminManagementPage',
    components: {
        AdminDeleteDialog,
        UserFormDialog,
        AdminUsersDataTable,
        AppClean,
    },
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
        return {
            showDeleteDialog: false,
            showDialog: false,
            formData: {
                name: '',
                surname: '',
                email: '',
            },
            userToDelete: null,
            editMode: false,
            dialogKey: 0,
            snackbar: {
                show: false,
                message: '',
                color: 'success',
                timeout: 3000
            },
        };
    },
    methods: {
        // Open the dialog for adding a new user
        addUser() {
            this.resetForm();
            this.editMode = false;
            this.dialogKey += 1;
            this.$nextTick(() => {
                this.showDialog = true;
            });
        },

        // Open the dialog for editing an existing user
        editUser(user) {
            this.formData = {
                id: `${user.id}`,
                name: `${user.first_name}`,
                surname: `${user.last_name}`,
                email: `${user.email}`,
            };
            this.editMode = true;
            this.dialogKey += 1;
            this.$nextTick(() => {
                this.showDialog = true;
            });
        },

        // Trigger the delete confirmation dialog
        deleteUser(user) {
            this.userToDelete = user;
            this.openDeleteDialog();
        },

        // Open the delete dialog
        openDeleteDialog() {
            this.showDeleteDialog = true;
        },

        // Close the delete dialog
        closeDeleteDialog() {
            this.showDeleteDialog = false;
            this.userToDelete = null;
        },

        // Handle confirming deletion
        handleConfirmDelete() {
            if (this.userToDelete) {
                axios
                    .delete(`/api/v1/delete/user/${this.userToDelete.id}`)
                    .then((response) => {
                        console.log('User deleted successfully:', response.data);
                        this.closeDeleteDialog();
                        this.snackbar.message = "Admin deleted successfully";
                        this.snackbar.color = "success";
                        this.snackbar.show = true;
                        window.location.reload();
                    })
                    .catch((error) => {
                        console.error('Error deleting user:', error);
                        this.snackbar.message = "Failed to delete Admin";
                        this.snackbar.color = "error";
                        this.snackbar.show = true;
                    });
            }
        },

        async editSaveUser(user) {
            try {
                const response = await axios.patch(`/api/v1/edit/user/${user.id}`, {
                    id: user.id,
                    first_name: user.name,
                    last_name: user.surname,
                    email: user.email,
                });
                this.snackbar.message = "Admin updated successfully";
                this.snackbar.color = "success";
                this.snackbar.show = true;
                window.location.reload();
            } catch (error) {
                this.snackbar.message = "Failed to update Admin";
                console.log(error)
                this.snackbar.color = "error";
                this.snackbar.show = true;
            } finally {
                this.showDialog = false;
            }
        },

        async saveUser(user) {

            console.log("from user page: ", user)
            try {
                const response = await axios.post('/api/v1/create/user', {
                    first_name: user.name,
                    last_name: user.surname,
                    email: user.email,
                    role: 'admin'
                });
                this.snackbar.message = "Admin added successfully";
                this.snackbar.color = "success";
                this.snackbar.show = true;
                window.location.reload();
            } catch (error) {
                this.snackbar.message = "Failed to add Admin";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            } finally {
                this.closeDialog();
            }

        },

        // Close the form dialog and reset form
        closeDialog() {
            this.showDialog = false;
            this.$nextTick(() => {
                this.resetForm();
            });
        },

        // Reset the form data
        resetForm() {
            this.formData = {name: '', surname: '', email: ''};
        },
    },
};
</script>

<style scoped>
</style>
