<template>
    <dialog-baseline
        :loading="loading"
        @primaryButtonClicked="deleteStudent"
        @secondaryButtonClicked="closeDialog()">
        <template #toolbar-icon>
            mdi-account-remove
        </template>

        <template #toolbar-title>
            Delete Student
        </template>

        <template #dialog-content>
            Are you sure you want to delete this student? All of their data will be permanently removed.
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
    name: 'DeleteStudentDialog',
    emits: ['dialogClosed', 'deleteStudentClicked'],
    components: {
        DialogBaseline
    },
    props: {
        student: {
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
        async deleteStudent() {
            this.loading = true;
            try {
                this.$emit('deleteStudentClicked', this.student);
            } finally {
                this.loading = false;
                this.closeDialog();
            }
        },
        closeDialog() {
            this.dialog = false;
            this.$emit('dialogClosed');
        }
    }
};
</script>
