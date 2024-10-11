<template>
    <DialogBaseline
        v-model="deleteDialog"
        :max-width="maxWidth"
        :primaryButton="true"
        @primaryButtonClicked="confirmDelete"
        @secondaryButtonClicked="closeDelete"
    >
        <!-- Icon -->
        <template v-slot:toolbar-icon>
            <v-icon>mdi-alert-circle</v-icon>
        </template>

        <!-- Title Slot -->
        <template v-slot:toolbar-title>
            Delete Admin
        </template>

        <!-- Content Slot -->
        <template v-slot:dialog-content>
            <p>Are you sure you want to delete this admin?</p>
        </template>


        <!-- Secondary Button Slot -->
        <template v-slot:secondary-button-text>
            Cancel
        </template>

        <!-- Primary Button Slot -->
        <template v-slot:primary-button-text>
            Confirm
        </template>
    </DialogBaseline>
</template>

<script>
import DialogBaseline from "@/Components/BaselineDialog.vue";


export default {
    name: "AdminDeleteDialog",
    components: { DialogBaseline },
    props: {
        maxWidth: {
            type: Number,
            default: 400,
        },
    },
    data: () => ({
        deleteDialog: true,
    }),
    methods: {
        // Emit an event to close the dialog
        closeDelete() {
            this.$emit('close');
        },
        confirmDelete() {
            this.$emit('confirm');
            this.closeDelete();
        },
    },
};
</script>

<style scoped>
</style>
