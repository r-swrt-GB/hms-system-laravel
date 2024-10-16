<template>
    <GuestLayout>
        <Head title="Log in"/>

        <center>
            <ApplicationLogo style="width: 300px" class="fill-current text-gray-500 mb-8 mt-8"/>
        </center>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <v-card-text style="font-size: 26px; font-weight: bolder" class="text-center">
            Welcome to the HMS-System

            <div>
                <div class="flex items-center justify-end mt-7 mb-4">
                    <v-btn
                        color="primary"
                        width="100%"
                        variant="elevated"
                        type="submit"
                        @click="navigateToSignIn">
                        Log in
                    </v-btn>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <v-btn
                        color="primary"
                        width="100%"
                        variant="elevated"
                        type="submit"
                        @click="navigateToRegister">
                        Register
                    </v-btn>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <v-btn
                        color="gray"
                        width="100%"
                        variant="elevated"
                        type="submit"
                        @click="navigateToGitHub">
                        Other resources
                    </v-btn>
                </div>
            </div>
        </v-card-text>
    </GuestLayout>
</template>

<script>
import {Head, Link} from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: 'LandingPage',
    components: {
        InputError,
        Link,
        GuestLayout,
        Head,
        ApplicationLogo,
    },
    methods: {
        navigateToSignIn() {
         Inertia.visit(route('login'));
        },
        navigateToRegister() {
            Inertia.visit(route('register'));
        },
        navigateToGitHub() {
           window.open('https://github.com/r-swrt-GB/hms-system-laravel');
        },
    },
}
</script>

<style scoped>
/* Add any additional styles here */
</style>
