<template>
    <AppClean :app-bar-header="appBarHeader">
        <ModuleDataTable :modules="modules"
                         @add-module-clicked="showDialog"
                         @delete-module-clicked="showDeleteModuleDialog"
                         @view-module-clicked="viewModule"
                         @edit-module-clicked="showDialog"></ModuleDataTable>

        <module-form-dialog
            v-model="moduleFormDialog"
            :module="selectedModule"
            :update="isUpdate"
            @dialog-closed="closeDialog"
            @add-module-clicked="addModule"
            @edit-save-module-clicked="editModule"
        ></module-form-dialog>

        <delete-module-dialog
            v-model="deleteModuleDialog"
            :module="selectedModule"
            @dialog-closed="closeDeleteDialog"
            @delete-module-clicked="deleteModule"
        ></delete-module-dialog>

        <!-- Snacbar Dialog -->
        <v-snackbar v-model="snackbar.show" :timeout="snackbar.timeout" :color="snackbar.color">
            {{ snackbar.message }}
        </v-snackbar>
    </AppClean>
</template>

<script>
import axios from 'axios';
import AppClean from "@/Layouts/AppClean.vue";
import ModuleDataTable from "@/Components/Management/ModuleManagement/ModuleDataTable.vue";
import ModuleFormDialog from "@/Components/Management/ModuleManagement/ModuleFormDialog.vue";
import DeleteModuleDialog from "@/Components/Management/ModuleManagement/DeleteModuleDialog.vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: 'ModuleManagementPage',
    components: {DeleteModuleDialog, ModuleFormDialog, ModuleDataTable, AppClean},
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
        return {
            moduleFormDialog: false,
            deleteModuleDialog: false,
            selectedModule: {
                module_name: '',
                code: '',
                description: '',
            },
            snackbar: {
                show: false,
                message: '',
                color: 'success',
                timeout: 3000
            },
            isUpdate: false,
        };
    },
    methods: {
        showDialog(module) {
            if (module != null) {
                this.isUpdate = true;
                this.selectedModule = module;
            } else {
                this.isUpdate = false;
            }

            this.moduleFormDialog = true;
        },
        closeDialog() {
            this.clearSelectedModule();
            this.moduleFormDialog = false;
        },
        showDeleteModuleDialog(module) {
            this.selectedModule = module;
            this.deleteModuleDialog = true;
        },
        closeDeleteDialog() {
            this.clearSelectedModule();
            this.deleteModuleDialog = false;
        },
        async editModule(module) {
            try {
                const response = await axios.patch(`/api/v1/modules/${module.id}`, {
                    module_name: module.module_name,
                    code: module.code,
                    description: module.description,
                });

                this.snackbar.message = "Module updated successfully";
                this.snackbar.color = "success";
                this.snackbar.show = true;
            } catch (error) {
                this.snackbar.message = error.response?.data?.errors || "Failed to add Module";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            } finally {
                this.closeDialog();
            }
        },
        async addModule(module) {
            try {
                const response = await axios.post('/api/v1/modules/create', {
                    module_name: module.module_name,
                    code: module.code,
                    description: module.description,
                });

                this.snackbar.message = "Module created successfully";
                this.snackbar.color = "success";
                this.snackbar.show = true;
            } catch (error) {
                this.snackbar.message = error.response?.data?.errors || "Failed to create Module";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            } finally {
                this.closeDialog();
            }
        },
        async deleteModule(module) {
            try {
                const response = await axios.delete(`/api/v1/modules/${module.id}`);

                this.snackbar.message = "Module deleted successfully";
                this.snackbar.color = "success";
                this.snackbar.show = true;
            } catch (error) {
                this.snackbar.message = error.response?.data?.errors || "Failed to delete Module";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            } finally {
                this.closeDeleteDialog();
            }
        },
        async viewModule(module) {
            Inertia.visit(route('pages.assignments', {module: module}));
        },
        clearSelectedModule() {
            this.selectedModule = {
                module_name: '',
                code: '',
                description: '',
            };
        }
    },
}
</script>

<style scoped>
/* Add styles here */
</style>
