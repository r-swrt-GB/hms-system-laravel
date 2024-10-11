<template>
    <DialogBaseline
        v-model="formDialog"
        :max-width="500"
        persistent
        @secondaryButtonClicked="cancel"
        @primaryButtonClicked="save"
    >
        <template #toolbar-icon>mdi-account</template>

        <template #toolbar-title>
            User Information
        </template>

        <template #dialog-content>
            <v-form ref="form" v-model="valid" lazy-validation>
                <!-- Name Input -->
                <v-text-field
                    clearable variant="solo"
                    v-model="formData.name"
                    label="First Name"
                    :rules="nameRules"
                    required
                ></v-text-field>

                <!-- Surname Input -->
                <v-text-field
                    clearable variant="solo"
                    v-model="formData.surname"
                    label="Last Name"
                    :rules="surnameRules"
                    required
                ></v-text-field>

                <!-- Email Input -->
                <v-text-field
                    clearable variant="solo"
                    v-model="formData.email"
                    label="Email"
                    :rules="emailRules"
                    required
                ></v-text-field>
            </v-form>
        </template>

        <template #small-text>
            Please ensure all fields are filled correctly.
        </template>

        <template #secondary-button-text>
            Cancel
        </template>

        <template #primary-button-text>
            Save
        </template>
    </DialogBaseline>
</template>

<script>
import DialogBaseline from "@/Components/BaselineDialog.vue";

export default {
    name: 'UserFormDialog',
    components: {DialogBaseline},
    props: {
      formData: {
          required: false ,
          default : {
              name: '',
              surname: '',
              email: '',}
      }
    },
    data: () => ({
        formDialog: false,
        valid: false,
        nameRules: [
            v => !!v || 'First name is required',
            v => v.length >= 2 || 'Name must be at least 2 characters long',
        ],
        surnameRules: [
            v => !!v || 'Last name is required',
            v => v.length >= 2 || 'Surname must be at least 2 characters long',
        ],
        emailRules: [
            v => !!v || 'Email is required',
            v => /.+@.+\..+/.test(v) || 'Email must be valid',
        ],
    }),
    methods: {
        cancel() {
            this.formDialog = false;  // Close the dialog
        },
        save() {
            if (this.$refs.form.validate()) {
                // Handle the form submission
                console.log('Form Data:', this.formData);
                this.formDialog = false;  // Close the dialog after saving
            }
        },
    },
};
</script>

<style scoped>
</style>
