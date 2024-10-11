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
                <v-text-field
                    v-model="lecturer.name"
                    label="Name"
                    variant="solo"
                    :rules="nameRules"
                    required
                    clearable></v-text-field>

                <v-text-field
                    v-model="lecturer.surname"
                    label="Surname"
                    variant="solo"
                    :rules="surnameRules"
                    required
                    clearable></v-text-field>

                <v-text-field
                    v-model="lecturer.email"
                    label="Email"
                    placeholder="johndoe@gmail.com"
                    variant="solo"
                    :rules="emailRules"
                    required
                    clearable></v-text-field>
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
