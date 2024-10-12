<template>
    <v-toolbar
        height="91"
        color="primary"
    >
        <!-- Back Button -->
        <v-btn type="icon" @click="goBack">
            <v-icon>mdi-arrow-left</v-icon>
        </v-btn>

        <!-- Toolbar Title -->
        <v-toolbar-title>{{ module.module_name }}</v-toolbar-title>

        <v-spacer></v-spacer>

    </v-toolbar>
    <v-container style="padding: 50px">
        <v-row>
            <v-col>
                <assignments-data-table
                    :module="module"
                    :assignments="module.assignments"
                    @add-assignment="showDialog"
                    @delete-assignment="showDeleteAssignmentDialog"
                    @edit-assignment="showDialog"
                    @view-assignment="viewAssignment"
                ></assignments-data-table>

                <assignment-form-dialog
                    v-model="assignmentFormDialog"
                    :update="isUpdate"
                    :open-date="openDate"
                    :due-date="dueDate"
                    :assignment="locallySelectedAssignment"
                    @add-assignment="addAssignment"
                    @dialog-closed="closeDialog"
                    @edit-save-assignment="editAssignmentSave"
                    @show-due-date-picker="showDuePicker"
                    @show-open-date-picker="showOpenPicker"
                ></assignment-form-dialog>

                <assignments-delete-dialog
                    v-model="deleteAssignmentDialog"
                    :assignment="selectedAssignment"
                    @dialog-closed="closeDeleteDialog"
                    @delete-assignment-clicked="deleteAssignment"
                ></assignments-delete-dialog>

                <!-- Snacbar Dialog -->
                <v-snackbar v-model="snackbar.show" :timeout="snackbar.timeout" :color="snackbar.color">
                    {{ snackbar.message }}
                </v-snackbar>
            </v-col>
        </v-row>
    </v-container>

    <v-dialog v-model="dueDatePicker"
              max-width="500">
        <v-row justify="space-around">
            <v-date-picker
                color="primary"
                @update:modelValue="setDuePickedDate"
            ></v-date-picker>
        </v-row>
    </v-dialog>

    <v-dialog v-model="openDatePicker"
              max-width="500">
        <v-row justify="space-around">
            <v-date-picker
                color="primary"
                @update:modelValue="setOpenPickedDate"
            ></v-date-picker>
        </v-row>
    </v-dialog>

</template>

<script>
import axios from 'axios';
import AssignmentsDataTable from "@/Components/Assignments/AssignmentsDataTable.vue";
import AssignmentFormDialog from "@/Components/Assignments/AssignmentFormDialog.vue";
import DeleteModuleDialog from "@/Components/Management/ModuleManagement/DeleteModuleDialog.vue";
import AssignmentsDeleteDialog from "@/Components/Assignments/AssignmentsDeleteDialog.vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: 'AssignmentsPage',
    components: {AssignmentsDeleteDialog, DeleteModuleDialog, AssignmentFormDialog, AssignmentsDataTable},
    props: {
        module: {
            required: true
        }
    },
    data() {
        return {
            dueDatePicker: false,
            openDatePicker: false,
            dueDatePickedValue: null,
            openDatePickedValue: null,
            deleteAssignmentDialog: false,
            isUpdate: false,
            selectedAssignment: {
                title: '',
                description: '',
                type: 'individual',
                min_videos: 1,
                max_videos: 1,
                max_video_length: 8,
                max_grade: 100,
                open_date: null,
                due_date: null,
            },
            assignmentFormDialog: false,
            snackbar: {
                show: false,
                message: '',
                color: 'success',
                timeout: 3000
            },
        };
    },
    computed: {
        openDate() {
            return this.openDatePickedValue;
        },
        dueDate() {
            return this.dueDatePickedValue;
        },
        locallySelectedAssignment() {
            console.log("computed:", this.selectedAssignment);
            return this.selectedAssignment;
        }
    },
    methods: {
        async addAssignment(assignment) {
            try {
                const response = await axios.post(`/api/v1/modules/${this.module.id}/assignments/`, {
                    title: assignment.title,
                    description: assignment.description,
                    type: 'individual',
                    min_videos: assignment.min_videos,
                    max_videos: assignment.max_videos,
                    max_video_length: assignment.max_video_length,
                    max_grade: assignment.max_grade,
                    open_date: assignment.open_date,
                    due_date: assignment.due_date,
                });

                this.snackbar.message = "Assignment created successfully";
                this.snackbar.color = "success";
                this.snackbar.show = true;
            } catch (error) {
                this.snackbar.message = error.response?.data?.errors || "Failed to create Assignment";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            } finally {
                this.closeDialog();
            }
        },
        async editAssignmentSave(assignment) {
            try {
                const response = await axios.patch(`/api/v1/modules/${this.module.id}/assignments/${assignment.id}`, {
                    title: assignment.title,
                    description: assignment.description,
                    type: 'individual',
                    min_videos: assignment.min_videos,
                    max_videos: assignment.max_videos,
                    max_video_length: assignment.max_video_length,
                    max_grade: assignment.max_grade,
                    open_date: assignment.open_date,
                    due_date: assignment.due_date,
                });

                this.snackbar.message = "Assignment updated successfully";
                this.snackbar.color = "success";
                this.snackbar.show = true;
            } catch (error) {
                this.snackbar.message = error.response?.data?.errors || "Failed to update Assignment";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            } finally {
                this.closeDialog();
            }
        },
        async deleteAssignment(assignment) {
            try {
                const response = await axios.delete(`/api/v1/modules/${this.module.id}/assignments/${assignment.id}`);

                this.snackbar.message = "Assignment deleted successfully";
                this.snackbar.color = "success";
                this.snackbar.show = true;
            } catch (error) {
                this.snackbar.message = error.response?.data?.errors || "Failed to delete Assignment";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            } finally {
                this.closeDeleteDialog();
            }
        },
        async viewAssignment(assignment) {
            Inertia.visit(route('pages.submissions', {module: this.module, assignment: assignment}));
        },
        showDeleteAssignmentDialog(assignment) {
            this.selectedAssignment = assignment;
            this.deleteAssignmentDialog = true;
        },
        closeDeleteDialog() {
            this.clearSelectedAssignment();
            this.deleteAssignmentDialog = false;
        },
        setDuePickedDate(date) {
            if (date !== null) {
                this.dueDatePickedValue = this.formatDate(date);
            }

            this.hideDatePicker();
        },
        setOpenPickedDate(date) {
            if (date !== null) {
                this.openDatePickedValue = this.formatDate(date);
            }

            this.hideDatePicker();
        },
        formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },
        hideDatePicker() {
            this.dueDatePicker = false;
            this.openDatePicker = false;

            this.assignmentFormDialog = true;
        },
        showDuePicker() {
            this.dueDatePicker = true;
        },
        showOpenPicker() {
            this.openDatePicker = true;
        },
        showDialog(assignment) {
            if (assignment != null) {
                this.isUpdate = true;
                this.selectedAssignment = assignment;
            } else {
                this.isUpdate = false;
            }

            this.assignmentFormDialog = true;
        },
        closeDialog() {
            this.clearSelectedAssignment();
            this.assignmentFormDialog = false;
        },
        goBack() {
            window.history.back();
        },
        clearSelectedAssignment() {
            this.openDatePickedValue = null;
            this.dueDatePickedValue = null;
            this.selectedAssignment = {
                title: '',
                description: '',
                type: 'individual',
                min_videos: 1,
                max_videos: 1,
                max_video_length: 8,
                max_grade: 100,
                open_date: null,
                due_date: null,
            };
        },
    },
}
</script>

<style scoped>
</style>
