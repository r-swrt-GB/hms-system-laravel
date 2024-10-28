<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import {Head, useForm} from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import {Inertia} from "@inertiajs/inertia";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    axios.post(route('api.auth.login'), {
        email: form.email,
        password: form.password,
    })
        .then((response) => {
            window.location.href = route('pages.management-modules');
        })
        .catch((error) => {
            if (error.response && error.response.status === 422) {
                form.errors(error.response.data.errors);
            } else {
                console.error('Login failed:', error);
            }
        })
        .finally(() => {
            form.reset('password');
        });
};

const navigateToRegister = () => {
    Inertia.visit(route('register'))
}
</script>

<template>
    <GuestLayout>
        <Head title="Log in"/>

        <center>
            <ApplicationLogo style="width: 300px" class="fill-current text-gray-500 mb-12 mt-8" aria-hidden="true"/>
        </center>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600" role="alert" aria-live="polite">
            {{ status }}
        </div>

        <form @submit.prevent="submit" aria-labelledby="login-form">
            <h1 id="login-form" class="sr-only">Login to your account</h1>

            <v-row>
                <v-col>
                    <label for="email" class="text-field-label">Email</label>
                    <v-text-field
                        v-model="form.email"
                        autofocus
                        required
                        placeholder="Enter your email"
                        variant="solo"
                        density="compact"
                        autocomplete="username"
                        id="email"
                        type="email"
                        aria-required="true"
                        aria-invalid="form.errors.email ? 'true' : 'false'"
                        aria-describedby="email-error"
                    ></v-text-field>
                    <InputError id="email-error" class="mt-2" :message="form.errors.email" v-if="form.errors.email" />
                </v-col>
            </v-row>

            <v-row>
                <v-col>
                    <label for="password" class="text-field-label">Password</label>
                    <v-text-field
                        v-model="form.password"
                        required
                        placeholder="Enter your password"
                        variant="solo"
                        density="compact"
                        autocomplete="current-password"
                        id="password"
                        type="password"
                        aria-required="true"
                        aria-invalid="form.errors.password ? 'true' : 'false'"
                        aria-describedby="password-error"
                    ></v-text-field>
                    <InputError id="password-error" class="mt-2" :message="form.errors.password" v-if="form.errors.password" />
                </v-col>
            </v-row>

            <div class="flex items-center justify-end mt-4 mb-7">
                <v-btn
                    color="primary"
                    width="100%"
                    :loading="form.processing"
                    :disabled="form.processing"
                    variant="elevated"
                    type="submit"
                    aria-label="Log in"
                >
                    Log in
                </v-btn>
            </div>

            <div @click="navigateToRegister" class="mb-4" style="cursor: pointer;">
                <center>
                    <small class="text-caption text-medium-emphasis" style="font-size: 14px; color: dimgray">
                        Existing lecturer? Click <u>here</u> to register an account
                    </small>
                </center>
            </div>
        </form>
    </GuestLayout>
</template>
