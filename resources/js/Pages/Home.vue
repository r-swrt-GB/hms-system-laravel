<template>
    <v-container>
        <v-row>
            <v-col>
                <v-card>
                    <v-card-title>
                        Home
                    </v-card-title>
                    <v-card-text>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn @click="login">Login</v-btn>
                        <v-btn @click="dashboard">Dashboard</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Home',
    props: {},
    data() {
        return {};
    },
    methods: {
        async login() {
            try {
                await axios.post(this.route('pages.login.index'));
            } catch (error) {
                console.error('Login error:', error);
            }
        },
        async dashboard() {
            try {
                await axios.post(this.route('pages.login.index'));
            } catch (error) {
                console.error('Dashboard error:', error);
            }
        },
    },
}
</script>

<style scoped>
/* Add styles here */
</style>
