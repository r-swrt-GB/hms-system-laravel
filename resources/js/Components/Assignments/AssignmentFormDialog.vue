<template>
    <dialog-baseline
        :loading="loading"
        :primary-button-disabled="primaryButtonDisabled"
        @primaryButtonClicked="addAssignment"
        @secondaryButtonClicked="closeDialog()">
        <template #toolbar-icon>
            mdi-file-outline
        </template>

        <template #toolbar-title>
            New Assignment
        </template>

        <template #dialog-content>
            <v-form ref="validationForm" @submit.prevent>
                <v-row>
                    <v-col cols="6">
                        <!-- Title -->
                        <div class="text-field-label">
                            Title
                        </div>
                        <v-text-field
                            v-model="assignment.title"
                            :readonly="readOnly"
                            :rules="[rules.required]"
                            density="compact"
                            autofocus
                            variant="solo"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <!-- Max Grade -->
                        <div class="text-field-label">
                            Max Grade
                        </div>
                        <v-text-field
                            v-model="assignment.max_grade"
                            :readonly="readOnly"
                            :rules="[rules.required]"
                            density="compact"
                            variant="solo"
                            type="number"
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12">
                        <!-- Description -->
                        <div class="text-field-label">
                            Description
                        </div>
                        <v-textarea
                            v-model="assignment.description"
                            :readonly="readOnly"
                            :rules="[rules.required]"
                            density="compact"
                            variant="solo"
                        ></v-textarea>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="6">
                        <!-- Minimum Videos -->
                        <div class="text-field-label">
                            Minimum Videos
                        </div>
                        <v-text-field
                            v-model="assignment.min_videos"
                            :readonly="readOnly"
                            :rules="[rules.required]"
                            density="compact"
                            variant="solo"
                            type="number"
                            min="1"
                            :value="assignment.min_videos || 1"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <!-- Maximum Videos -->
                        <div class="text-field-label">
                            Maximum Videos
                        </div>
                        <v-text-field
                            v-model="assignment.max_videos"
                            :rules="[rules.required]"
                            :readonly="readOnly"
                            density="compact"
                            variant="solo"
                            type="number"
                            min="1"
                            :value="assignment.max_videos || 3"
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12">
                        <!-- Max Video Length (in minutes) -->
                        <div class="text-field-label">
                            Max Video Length (minutes)
                        </div>
                        <v-text-field
                            v-model="assignment.max_video_length"
                            :rules="[rules.required]"
                            :readonly="readOnly"
                            density="compact"
                            variant="solo"
                            type="number"
                            min="1"
                            :value="assignment.max_video_length || 8"
                        ></v-text-field>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="6">
                        <!-- Open Date -->
                        <div class="text-field-label">
                            Open Date
                        </div>
                        <v-text-field
                            @click="showOpenPicker"
                            :model-value="openDate ?? formatDate(assignment.open_date) ?? ''"
                            :rules="[rules.required]"
                            :readonly="readOnly"
                            label="Open Date"
                            readonly
                            density="compact"
                            variant="solo"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <!-- Due Date -->
                        <div class="text-field-label">
                            Due Date
                        </div>
                        <v-text-field
                            @click="showDuePicker"
                            :model-value="dueDate ??  formatDate(assignment.due_date) ?? ''"
                            :rules="[rules.required]"
                            :readonly="readOnly"
                            label="Due Date"
                            readonly
                            density="compact"
                            variant="solo"
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-form>
        </template>

        <template #primary-button-text>
            Save
        </template>

        <template #secondary-button-text>
            Close
        </template>

    </dialog-baseline>
</template>

<script>
import DialogBaseline from "@/Components/BaselineDialog.vue";

export default {
    name: 'AssignmentFormDialog',
    emits: ['dialogClosed', 'addAssignment', 'editSaveAssignment', 'showOpenDatePicker', 'showDueDatePicker'],
    components: {
        DialogBaseline,
    },
    props: {
        readOnly: {
          required: false,
          default: false,
        },
        dueDate: {
            required: false,
        },
        openDate: {
            required: false,
        },
        assignment: {
            required: false,
            default: {
                title: '',
                description: '',
                min_videos: 1,
                max_videos: 3,
                max_video_length: 8,
                max_grade: '',
                open_date: null,
                due_date: null
            }
        },
        update: {
            required: true,
        },
        primaryButtonDisabled: {
            required: false,
            default: false,
        },
    },
    data() {
        return {
            dialog: true,
            loading: false,
            rules: {
                required: value => !!value || 'This field is required',
            },
        };
    },
    methods: {
        showDuePicker() {
            this.$emit('showDueDatePicker');
        },
        showOpenPicker() {
            this.$emit('showOpenDatePicker');
        },
        addAssignment() {
            this.dialog = false;

            if (this.openDate != null) {
                this.assignment.open_date = this.openDate;
            }

            if (this.dueDate != null) {
                this.assignment.due_date = this.dueDate;
            }

            if (!this.update) {
                this.$emit('addAssignment', this.assignment);
            } else {
                this.$emit('editSaveAssignment', this.assignment);
            }
        },
        closeDialog() {
            this.dialog = false;
            this.$emit('dialogClosed');
        },
        formatDate(date) {
            date = new Date(date);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },
    }
};
</script>

<style scoped>
.text-field-label {
    font-weight: bold;
    margin-bottom: 8px;
}

.mt-3 {
    margin-top: 24px;
}
</style>
