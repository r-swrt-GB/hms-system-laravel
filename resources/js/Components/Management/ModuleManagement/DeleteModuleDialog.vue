<template>
    <dialog-baseline
        :loading="loading"
        @primaryButtonClicked="deleteModule"
        @secondaryButtonClicked="closeDialog()">
        <template #toolbar-icon>
            mdi-book-outline
        </template>

        <template #toolbar-title>
            Delete Module
        </template>

        <template #dialog-content>
            Are you sure you want to delete this module, all of its assignments and all of its submissions?
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
import DataTableExplorerBaseline from '../../BaselineDataTable.vue';
import DialogBaseline from "@/Components/BaselineDialog.vue";

export default {
    name: 'DeleteModuleDialog',
    emits: ['dialogClosed', 'deleteModuleClicked'],
    components: {
        DialogBaseline,
        DataTableExplorerBaseline
    },
    props: {
        module: {
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
        deleteModule() {
            this.dialog = false;
            this.$emit('deleteModuleClicked', this.module);
        },
        closeDialog() {
            this.dialog = false;
            this.$emit('dialogClosed');
        }
    }
};
</script>
