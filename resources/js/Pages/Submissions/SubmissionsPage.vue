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
                <submission-data-table
                    :assignment="assignment"
                    :submissions="submissions"
                    @export-all="exportAll"
                    @delete-submission="showDeleteDialog"
                    @view-assignment-details="showAssignmentInformationDialog"
                    @view-submission="viewSubmission"
                ></submission-data-table>

                <assignment-form-dialog
                    v-model="assignmentDialog"
                    :assignment="assignment"
                    :update="false"
                    :primary-button-disabled="true"
                    :read-only="true"
                    @dialog-closed="closeAssignmentDialog"
                ></assignment-form-dialog>

                <submission-delete-dialog
                    v-model="deleteSubmissionDialog"
                    :module="selectedSubmission"
                    :submission="selectedSubmission"
                    @dialog-closed="closeDeleteDialog"
                    @delete-submission-clicked="deleteSubmission"
                ></submission-delete-dialog>

                <!-- Snackbar Dialog -->
                <v-snackbar v-model="snackbar.show" :timeout="snackbar.timeout" :color="snackbar.color">
                    {{ snackbar.message }}
                </v-snackbar>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from 'axios';
import AssignmentsDataTable from "@/Components/Assignments/AssignmentsDataTable.vue";
import SubmissionDataTable from "@/Components/Submissions/SubmissionDataTable.vue";
import AssignmentFormDialog from "@/Components/Assignments/AssignmentFormDialog.vue";
import DeleteModuleDialog from "@/Components/Management/ModuleManagement/DeleteModuleDialog.vue";
import SubmissionDeleteDialog from "@/Components/Submissions/SubmissionDeleteDialog.vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: 'SubmissionsPage',
    components: {
        SubmissionDeleteDialog,
        DeleteModuleDialog, AssignmentFormDialog, SubmissionDataTable, AssignmentsDataTable
    },
    props: {
        module: {
            required: true
        },
        assignment: {
            required: true
        },
        submissions: {
            required: true
        },
    },
    data() {
        return {
            assignmentDialog: false,
            deleteSubmissionDialog: false,
            selectedSubmission: false,
            snackbar: {
                show: false,
                message: '',
                color: 'success',
                timeout: 3000
            },
        };
    },
    methods: {
        showAssignmentInformationDialog() {
            this.assignmentDialog = true;
        },
        closeAssignmentDialog() {
            this.assignmentDialog = false;
        },
        async deleteSubmission(submission) {
            try {
                const response = await axios.delete(`/api/v1/modules/${this.module.id}/assignments/${this.assignment.id}/submissions/${submission.id}`);

                this.snackbar.message = "Submission deleted successfully";
                this.snackbar.color = "success";
                this.snackbar.show = true;
            } catch (error) {
                this.snackbar.message = error.response?.data?.errors || "Failed to delete Submission";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            } finally {
                this.closeDeleteDialog();
            }
        },
        showDeleteDialog(submission) {
            this.selectedSubmission = submission;
            this.deleteSubmissionDialog = true;
        },
        async exportAll() {
            try {
                const url = route(`api.assignments.export`, {
                    module: this.module,
                    assignment: this.assignment
                });

                window.location.href = url;

                this.snackbar.message = "Assignment exported successfully";
                this.snackbar.color = "success";
                this.snackbar.show = true;
            } catch (error) {
                console.log(error);
                this.snackbar.message = error.response?.data?.errors || "Failed to export Assignment";
                this.snackbar.color = "error";
                this.snackbar.show = true;
            }
        },
        viewSubmission(submission) {
            Inertia.visit(route('pages.submission', {
                module: this.module,
                assignment: this.assignment,
                submission: submission
            }));
        },
        closeDeleteDialog() {
            this.deleteSubmissionDialog = false;
        },
        goBack() {
            window.history.back();
        }
    },
}
</script>

<style scoped>
</style>
