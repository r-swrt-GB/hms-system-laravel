<template>
    <v-dialog
        v-model="internalDialog"
        :max-width="maxWidth"
        persistent>
        <v-responsive
            class="mx-auto"
        />
        <v-card>
            <v-card-title>
                <v-icon class="mr-1">
                    <slot name="toolbar-icon">mdi-account</slot>
                </v-icon>
                <slot name="toolbar-title">Add Lecturer</slot>
            </v-card-title>

            <v-divider></v-divider>

            <v-card-text>
                <v-form ref="lecturerForm" v-model="formValid">
                    <v-row>
                        <v-col cols="6">
                            <!-- Name -->
                            <div class="text-field-label">
                                Name
                            </div>
                            <v-text-field
                                v-model="lecturer.name"
                                :rules="nameRules"
                                required
                                placeholder="John"
                                variant="solo"
                                density="compact"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="6">
                            <!-- Surnmae -->
                            <div class="text-field-label">
                                Surname
                            </div>
                            <v-text-field
                                v-model="lecturer.surname"
                                :rules="surnameRules"
                                required
                                placeholder="Doe"
                                variant="solo"
                                density="compact"
                            ></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="12">
                            <!-- Name -->
                            <div class="text-field-label">
                                Name
                            </div>
                            <v-text-field
                                v-model="lecturer.email"
                                :rules="emailRules"
                                required
                                placeholder="johndoe@gmail.com"
                                variant="solo"
                                density="compact"
                                type="email"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-form>
                <small class="text-caption text-medium-emphasis">
                    <slot name="small-text">Please complete all fields</slot>
                </small>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>

                <!-- Cancel Button -->
                <v-btn
                    variant="plain"
                    @click="cancel">
                    Cancel
                </v-btn>

                <!-- Save Button -->
                <v-btn
                    color="primary"
                    :loading="loading"
                    :disabled="!formValid"
                    variant="elevated"
                    @click="save">
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'LecturerFormDialog',
    props: {
        maxWidth: {
            required: false,
            default: 600,
        },
        useDefaultColor: {
            required: false,
            default: false,
        },
        loading: {
            required: false,
            default: false,
        },
        value: { // This is the v-model binding
            type: Boolean,
            required: true,
        },
        lecturer: {
            required: false,
            default: () => ({
                name: '',
                surname: '',
                email: '',
            })
        }
    },
    data() {
        return {
            formValid: false,  // Tracks form validity
            nameRules: [
                v => !!v || 'Name is required',
                v => v.length >= 2 || 'Name must be at least 2 characters',
            ],
            surnameRules: [
                v => !!v || 'Surname is required',
                v => v.length >= 2 || 'Surname must be at least 2 characters',
            ],
            emailRules: [
                v => !!v || 'Email is required',
                v => /.+@.+\..+/.test(v) || 'Email must be valid',
            ]
        };
    },
    computed: {
        // Controls v-dialog based on the prop value and emits updates
        internalDialog: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('update:value', val);  // Update parent component
            }
        }
    },
    methods: {
        resetForm() {
            this.lecturer = {
                name: '',
                surname: '',
                email: ''
            };
            this.formValid = false;
        },
        save() {
            if (this.$refs.lecturerForm.validate()) {
                this.$emit('saveLecturer', {...this.lecturer});
                this.resetForm();
                this.$emit('update:value', false);
            }
        },
        cancel() {
            this.$emit('update:value', false);
            this.resetForm();
        }
    }
}
</script>;

<style scoped></style>
