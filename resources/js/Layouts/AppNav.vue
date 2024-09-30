<template>
    <v-app>
        <!-- Side Drawer -->
        <v-navigation-drawer v-model="drawer" width="270">
            <v-img
                src="https://services.nwu.ac.za/sites/services.nwu.ac.za/files/files/designs-branding/NWU-Acronym-Logo-Purple-Digital0.png"
                contain
                style="margin: 12px"
            ></v-img>

            <div style="width: 100%; height: 1px; color: grey"></div>

            <v-list>
                <v-list-group
                    v-for="item in menuItems"
                    :key="item.title"
                    :prepend-icon="item.icon"
                    :value="item.active"
                >
                    <template v-slot:activator="{ props }">
                        <v-list-item v-bind="props" :title="item.title"></v-list-item>
                    </template>

                    <v-list-item
                        v-for="subItem in item.items"
                        :key="subItem.title"
                        :to="subItem.to"
                        :title="subItem.title"
                        :prepend-icon="subItem.icon"
                    ></v-list-item>
                </v-list-group>
            </v-list>
        </v-navigation-drawer>

        <!-- App Bar -->
        <v-app-bar app>
            <v-app-bar-nav-icon @click="toggleDrawer"></v-app-bar-nav-icon>
            <v-toolbar-title>{{ pageTitle }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn>
                <v-icon>mdi-account-circle</v-icon>
            </v-btn>
        </v-app-bar>

        <!-- Main Content -->
        <v-main>
            <v-container fluid class="pa-6">
                <slot></slot>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    name: 'AppNav',
    data() {
        return {
            drawer: true,
            menuItems: [
                {
                    title: 'Dashboard',
                    icon: 'mdi-view-dashboard',
                    active: true,
                    items: [
                        { title: 'Analytics', icon: 'mdi-chart-bar', to: '/dashboard/analytics' },
                        { title: 'Overview', icon: 'mdi-eye', to: '/dashboard/overview' },
                    ],
                },
                {
                    title: 'User Management',
                    icon: 'mdi-account-group',
                    active: false,
                    items: [
                        { title: 'Users', icon: 'mdi-account', to: '/users' },
                        { title: 'Roles', icon: 'mdi-shield-account', to: '/roles' },
                    ],
                },
            ],
        };
    },

    computed: {
        pageTitle() {
           return 'Dashboard';
        },
    },

    methods: {
        toggleDrawer() {
            this.drawer = !this.drawer;
        },
    },
};
</script>
