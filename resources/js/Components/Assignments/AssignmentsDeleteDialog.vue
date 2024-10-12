<template>
    <dialog-baseline
        :loading="loading"
        @primaryButtonClicked="deleteAssignment"
        @secondaryButtonClicked="closeDialog()">
        <template #toolbar-icon>
            mdi-file-outline
        </template>

        <template #toolbar-title>
            Delete Assignment
        </template>

        <template #dialog-content>
            Are you sure you want to delete this assignment and all of its submissions?
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
import DialogBaseline from "@/Components/BaselineComponents/BaselineDialog.vue";

export default {
    name: 'AssignmentsDeleteDialog',
    emits: ['dialogClosed', 'deleteAssignmentClicked'],
    components: {
        DialogBaseline,
    },
    props: {
        assignment: {
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
        deleteAssignment() {
            this.dialog = false;
            this.$emit('deleteAssignmentClicked', this.assignment);
        },
        closeDialog() {
            this.dialog = false;
            this.$emit('dialogClosed');
        }
    }
};
</script>
