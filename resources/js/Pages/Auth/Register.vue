<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import {Head} from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import axios from 'axios';
import {ref} from 'vue';
import {Inertia} from "@inertiajs/inertia";

const form = ref({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
});

const errors = ref({});

// Snackbar state
const snackbar = ref({
    show: false,
    message: '',
    color: '',
    timeout: 4000
});

const submit = async () => {
    try {
        const response = await axios.post(route('pages.management-modules'), form.value);
        form.value.password = '';
        errors.value = {};

        if (response.data['message'] === 'Registration successful') {
            Inertia.visit(route('pages.home.index'));
        } else {
            snackbar.value = {
                show: true,
                message: `${response.data['message']}`,
                color: 'red',
                timeout: 4000
            };
        }
    } catch (error) {
        if (error.response && error.response.data.errors) {
            errors.value = error.response.data.errors;

            // Show error snackbar
            snackbar.value = {
                show: true,
                message: 'Registration failed. Invalid credentials.',
                color: 'red',
                timeout: 4000
            };
        }
    }
};

const navigateToLogin = () => {
    window.location.href = route('login');
};
</script>

<template>
    <GuestLayout>
        <Head title="Register"/>
        <center>
            <ApplicationLogo style="width: 300px" class="fill-current text-gray-500 mb-12 mt-8"/>
        </center>
        <form @submit.prevent="submit">
            <v-row>
                <v-col>
                    <div class="text-field-label">
                        First Name
                    </div>
                    <v-text-field
                        v-model="form.first_name"
                        variant="solo"
                        density="compact"
                        required
                        autofocus
                        autocomplete="name"
                        id="name1"
                        type="text"
                    ></v-text-field>
                    <InputError class="mt-2" :message="errors.first_name"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <div class="text-field-label">
                        Last Name
                    </div>
                    <v-text-field
                        v-model="form.last_name"
                        variant="solo"
                        density="compact"
                        required
                        autocomplete="name"
                        id="name2"
                        type="text"
                    ></v-text-field>
                    <InputError class="mt-2" :message="errors.last_name"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <div class="text-field-label">
                        Email
                    </div>
                    <v-text-field
                        v-model="form.email"
                        variant="solo"
                        density="compact"
                        required
                        autocomplete="email"
                        id="name"
                        type="text"
                    ></v-text-field>
                    <InputError class="mt-2" :message="errors.email"/>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <div class="text-field-label">
                        Password
                    </div>
                    <v-text-field
                        v-model="form.password"
                        variant="solo"
                        density="compact"
                        required
                        autocomplete="new-password"
                        id="password"
                        type="password"
                    ></v-text-field>
                    <InputError class="mt-2" :message="errors.password"/>
                </v-col>
            </v-row>
            <div class="flex items-center justify-end mt-4 mb-7">
                <v-btn
                    color="primary"
                    width="100%"
                    :loading="false"
                    :disabled="false"
                    variant="elevated"
                    type="submit"
                >
                    Register
                </v-btn>
            </div>
            <div @click="navigateToLogin" class="mb-4" style="cursor: pointer;">
                <center>
                    <small class="text-caption text-medium-emphasis" style="font-size: 14px; color: dimgray">
                        Already registered? Click <u>here</u> to login
                    </small>
                </center>
            </div>
        </form>

        <!-- Snackbar implementation -->
        <v-snackbar v-model="snackbar.show" :timeout="snackbar.timeout" :color="snackbar.color">
            {{ snackbar.message }}
        </v-snackbar>
    </GuestLayout>
</template>
