<template>
    <AppClean :app-bar-header="appBarHeader">
        <!-- Admin Users Data Table -->
        <AdminUsersDataTable
            :admin-users="adminUsers"
            @add-user="addUser"
            @edit-user="editUser"
            @delete-user="deleteUser"
        ></AdminUsersDataTable>

        <!-- User Form Dialog -->
        <UserFormDialog
            v-model="showDialog"
            :form-data="formData"
            :key="dialogKey"
            @primaryButtonClicked="saveUser"
            @secondaryButtonClicked="closeDialog"
        />
    </AppClean>
</template>

<script>
import axios from 'axios';
import AppClean from "@/Layouts/AppClean.vue";
import AdminUsersDataTable from "@/Components/Management/AdminManagement/AdminUsersDataTable.vue";
import UserFormDialog from "@/Components/Management/AdminManagement/AdminFormDialog.vue";

export default {
    name: 'AdminManagementPage',
    components: { UserFormDialog, AdminUsersDataTable, AppClean },
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
            showDialog: false, // Controls dialog visibility
            formData: {
                name: '',
                surname: '',
                email: '',
            },
            editMode: false, // Tracks whether it's in edit mode or add mode
            dialogKey: 0, // Add a key to trigger re-render
        };
    },
    methods: {
        // Open the dialog for adding a new user
        addUser() {
            this.resetForm(); // Reset the form data
            this.editMode = false; // Not in edit mode
            this.dialogKey += 1; // Change the key to force dialog re-render
            this.$nextTick(() => { // Ensure form reset happens before dialog opens
                this.showDialog = true; // Show the dialog after reset
            });
        },

        // Open the dialog for editing an existing user
        editUser(user) {
            this.formData = { name: `${user.first_name}`, surname: `${user.last_name}`, email: `${user.email}` }; // Populate form with user data
            this.editMode = true; // Switch to edit mode
            this.dialogKey += 1; // Change the key to force dialog re-render
            this.$nextTick(() => { // Show dialog after form population
                this.showDialog = true;
            });
        },

        // Delete user logic (you can implement the actual delete logic here)
        deleteUser(user) {
            console.log('Deleting user:', user);
            // Example: axios.delete(`/api/users/${user.id}`);
        },

        // Handle saving the user (both for add and edit modes)
        saveUser(localFormData) {
            if (this.editMode) {
                console.log('Editing user:', localFormData);
                // Example: axios.patch(`/api/users/${localFormData.id}`, localFormData);
            } else {
                console.log('Adding new user:', localFormData);
                // Example: axios.post('/api/users', localFormData);
            }

            // Close the dialog after saving
            this.closeDialog();
        },

        // Close the dialog and reset the form
        closeDialog() {
            this.showDialog = false; // Hide the dialog first
            this.$nextTick(() => {
                this.resetForm(); // Reset form data after the dialog is closed
            });
        },

        // Reset the form data
        resetForm() {
            this.formData = { name: '', surname: '', email: '' }; // Clear form data
        },
    },
};
</script>
