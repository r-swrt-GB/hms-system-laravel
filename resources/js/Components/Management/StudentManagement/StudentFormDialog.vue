<template>
    <v-dialog v-model="dialog" :max-width="600" persistent>
        <v-card>
            <v-card-title>
                <v-icon class="mr-1">mdi-account</v-icon>
                <span>Student Form</span>
            </v-card-title>

            <v-divider></v-divider>

            <v-card-text>
                <v-form ref="studentForm">
                    <v-text-field
                        label="Name"
                        v-model="student.name"
                        :rules="[rules.required]"
                        required
                    ></v-text-field>
                    <v-text-field
                        label="Surname"
                        v-model="student.surname"
                        :rules="[rules.required]"
                        required
                    ></v-text-field>
                    <v-text-field
                        label="Email"
                        v-model="student.email"
                        :rules="[rules.required, rules.email]"
                        required
                    ></v-text-field>
                    <v-text-field
                        label="Phone"
                        v-model="student.phone"
                        :rules="[rules.required, rules.phone]"
                        required
                    ></v-text-field>
                    <v-text-field
                        label="Student Number"
                        v-model="student.studentNumber"
                        :rules="[rules.required]"
                        required
                    ></v-text-field>
                </v-form>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <!-- Close Button -->
                <v-btn variant="plain" @click="closeDialog">
                    Close
                </v-btn>
                <!-- Save Button -->
                <v-btn color="primary" :loading="loading" @click="saveStudent">
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "StudentFormDialog",
    props: {
        loading: {
            required: false,
            default: false,
        },
    },
    data: () => ({
        dialog: true,
        student: {
            name: "",
            surname: "",
            email: "",
            phone: "",
            studentNumber: "",
        },
        rules: {
            required: (value) => !!value || "Required.",
            email: (value) => /.+@.+\..+/.test(value) || "E-mail must be valid.",
            phone: (value) =>
                /^\+?\d{10,15}$/.test(value) || "Phone number must be valid.",
        },
    }),
    methods: {
        closeDialog() {
            this.dialog = false;
        },
        saveStudent() {
            const form = this.$refs.studentForm;
            if (form.validate()) {
                // Emit the student data for saving
                this.$emit("saveStudent", this.student);
                this.dialog = false;
            }
        },
    },
};
</script>

<style scoped>
</style>
