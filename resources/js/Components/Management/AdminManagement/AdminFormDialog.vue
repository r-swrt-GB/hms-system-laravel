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
                <v-row>
                    <v-col cols="6">
                        <!-- First Name -->
                        <div class="text-field-label">
                            Name
                        </div>
                        <v-text-field
                            v-model="formData.name"
                            :rules="nameRules"
                            required
                            placeholder="John"
                            variant="solo"
                            density="compact"
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6">
                        <!-- Last Name -->
                        <div class="text-field-label">
                            Surname
                        </div>
                        <v-text-field
                            v-model="formData.surname"
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
                        <!-- Email -->
                        <div class="text-field-label">
                            Email
                        </div>
                        <v-text-field
                            v-model="formData.email"
                            :rules="emailRules"
                            required
                            placeholder="johndoe@gmail.com"
                            variant="solo"
                            density="compact"
                        ></v-text-field>
                    </v-col>
                </v-row>
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
import DialogBaseline from "@/Components/BaselineComponents/BaselineDialog.vue";

export default {
    name: 'UserFormDialog',
    components: {DialogBaseline},
    props: {
      formData: {
          required: false ,
          default : {
              id: -1,
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
            v => /.+@.+\..+/.test(v) || 'Email must be valid' || 'lowercase Email only',
        ],
    }),
    methods: {
        cancel() {
            this.formDialog = false;
        },
        save() {
            if (this.$refs.form.validate()) {
                console.log('Form Data:', this.formData);

                if(this.formData.id == null)
                {
                    this.$emit('addUser', this.formData);
                }
                else
                {
                    this.$emit('editUser', this.formData);
                }
                this.formDialog = false;  // Close the dialog after saving
            }
        },
    },
};
</script>

<style scoped>
</style>
