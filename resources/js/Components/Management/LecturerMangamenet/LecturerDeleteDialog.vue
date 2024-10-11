<template>
    <v-dialog
        :value="value"
        max-width="400"
        @update:value="closeDialog">
        <v-card>
            <v-card-title>
            <v-icon class="mr-1">
            <slot name="toolbar-icon">mdi-delete</slot>
            </v-icon>
            <slot name="toolbar-title">Delete Lecturer</slot></v-card-title>
            <v-card-text>
                Are you sure you want to delete this lecturer?
            </v-card-text>
            <v-card-actions>
                <v-btn
                    color="grey"
                    variant="plain"
                    @click="cancelDelete">
                    cancel
                </v-btn>

                <v-btn
                    color="primary"
                    variant="elevated"
                    @click="confirmDelete">
                    delete
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "LecturerDeleteDialog",
    props: {
        value: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        confirmDelete() {
            this.$emit("confirmDelete");
            this.closeDialog();
        },
        cancelDelete() {
            this.closeDialog();
        },
        closeDialog() {
            this.$emit("update:value", false);
        }
    }
};
</script>

<style scoped></style>
