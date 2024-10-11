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
                    @delete-submission="showDeleteDialog"
                    @view-assignment-details="showAssignmentInformationDialog"
                    @view-submission=""
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

export default {
    name: 'SubmissionsPage',
    components: {
        SubmissionDeleteDialog,
        DeleteModuleDialog, AssignmentFormDialog, SubmissionDataTable, AssignmentsDataTable},
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

                console.log(response.data.message);
            } catch (error) {
                console.error(error);
                if (error.response && error.response.data) {
                    console.error(error.response.data.errors);
                } else {
                    console.error(error);
                }
            } finally {
                this.closeDeleteDialog();
            }
        },
        showDeleteDialog(submission)
        {
            this.selectedSubmission = submission;
            this.deleteSubmissionDialog = true;
        },
        closeDeleteDialog()
        {
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
