<template>
    <dialog-baseline
        :loading="loading"
        @primaryButtonClicked="addModule"
        @secondaryButtonClicked="closeDialog()">
        <template #toolbar-icon>
            mdi-book-outline
        </template>

        <template #toolbar-title>
            New Module
        </template>

        <template #dialog-content>
            <v-form ref="validationForm" @submit.prevent>
                <v-row>
                    <v-col cols="6">
                        <!-- Module Name -->
                        <div class="text-field-label">
                            Module Name
                        </div>
                        <v-text-field
                            v-model="module.module_name"
                            :readonly="loading"
                            :rules="[rules.required]"
                            placeholder="IT Developments"
                            variant="solo"
                            density="compact"
                            autofocus
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <!-- Module Code -->
                        <div class="text-field-label">
                            Module Code
                        </div>
                        <v-text-field
                            v-model="module.code"
                            :rules="[rules.required]"
                            placeholder="CMPG323"
                            variant="solo"
                            density="compact"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <!-- Description -->
                        <div class="text-field-label">
                            Module Description
                        </div>
                        <v-textarea
                            v-model="module.description"
                            :rules="[rules.required]"
                            placeholder="Giving you the edge you need to make your way in this marvellous world!"
                            density="compact"
                            variant="solo"
                        ></v-textarea>
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
import DataTableExplorerBaseline from '../../BaselineComponents/BaselineDataTable.vue';
import DialogBaseline from "@/Components/BaselineComponents/BaselineDialog.vue";

export default {
    name: 'ModuleFormDialog',
    emits: ['dialogClosed', 'addModuleClicked', 'editSaveModuleClicked'],
    components: {
        DialogBaseline,
        DataTableExplorerBaseline
    },
    props: {
        module: {
            required: false,
            default: {
                module_name: '',
                code: '',
                description: '',
            }
        },
        update: {
            required: true,
        }
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
        addModule() {

            this.dialog = false;

            if (!this.update) {
                this.$emit('addModuleClicked', this.module);
            } else {
                this.$emit('editSaveModuleClicked', this.module);
            }
        },
        closeDialog() {
            this.dialog = false;
            this.$emit('dialogClosed');
        }
    }
};
</script>
