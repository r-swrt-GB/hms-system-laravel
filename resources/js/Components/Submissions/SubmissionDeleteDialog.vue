<template>
    <dialog-baseline
        :loading="loading"
        @primaryButtonClicked="deleteSubmission"
        @secondaryButtonClicked="closeDialog()">
        <template #toolbar-icon>
            mdi-file-document
        </template>

        <template #toolbar-title>
            Delete Submission
        </template>

        <template #dialog-content>
            Are you sure you want to delete this submission and all of its associated contents?
        </template>

        <template #primary-button-text>
            Delete
        </template>

        <template #secondary-button-text>
            Cancel
        </template>

    </dialog-baseline>
</template>

<script>
import DialogBaseline from "@/Components/BaselineDialog.vue";

export default {
    name: 'SubmissionDeleteDialog',
    emits: ['dialogClosed', 'deleteSubmissionClicked'],
    components: {
        DialogBaseline,
    },
    props: {
        submission: {
            required: true,
        },
    },
    data() {
        return {
            dialog: true,
            loading: false,
        };
    },
    methods: {
        deleteSubmission() {
            this.dialog = false;
            this.$emit('deleteSubmissionClicked', this.submission);
        },
        closeDialog() {
            this.dialog = false;
            this.$emit('dialogClosed');
        }
    }
};
</script>
