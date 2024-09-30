<template>
    <AppNav>
        <h1>Welcome to the Dashboard</h1>
        <p>This is your main content area.</p>
    </AppNav>
</template>

<script>
import AppNav from "@/Layouts/AppNav.vue";

export default {
    name: 'DashboardPage',
    components: {
        AppNav,
    },
    data() {
        return {}
    }
};
</script>
