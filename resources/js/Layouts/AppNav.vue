<template>
    <v-app>
        <!-- Side Drawer -->
        <v-navigation-drawer v-model="drawer" width="280" scrim>
            <div class="logo-container">
                <v-img
                    class="logo"
                    src="/assets/images/nwu-logo.png"
                    contain
                ></v-img>
            </div>

            <div style="width: 100%; height: 1px; color: grey"></div>

            <v-list>
                <template v-for="item in menuItems" :key="item.title">
                    <!-- Render v-list-group for items with multiple sub-items -->
                    <v-list-group
                        v-if="item.items.length > 1"
                        :prepend-icon="item.icon"
                        :value="item.active"
                    >
                        <template v-slot:activator="{ props }">
                            <v-list-item v-bind="props" :title="item.title"></v-list-item>
                        </template>

                        <v-list-item
                            v-for="subItem in item.items"
                            :key="subItem.title"
                            :title="subItem.title"
                            :prepend-icon="subItem.icon"
                            @click="navigateTo(subItem.to)"
                        ></v-list-item>
                    </v-list-group>

                    <!-- Render v-list-item directly for items with only one sub-item -->
                    <v-list-item
                        v-else
                        :prepend-icon="item.icon"
                        :title="item.items[0].title"
                        @click="navigateTo(item.items[0].to)"
                    ></v-list-item>
                </template>
            </v-list>
        </v-navigation-drawer>

        <!-- App Bar -->
        <v-app-bar app height="91" color="primary">
            <v-app-bar-nav-icon @click="toggleDrawer"></v-app-bar-nav-icon>
            <v-toolbar-title>{{ pageTitle }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn>
                <v-icon>mdi-account-circle</v-icon>
            </v-btn>
        </v-app-bar>

        <!-- Main Content -->
        <v-main>
            <slot></slot>
        </v-main>
    </v-app>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
    name: 'AppNav',
    props: {
        appBarHeader: {
            type: String,
            required: false,
            default: '',
        },
    },
    data() {
        return {
            drawer: true,
            menuItems: [
                {
                    title: 'User Management',
                    icon: 'mdi-book-outline',
                    active: false,
                    items: [
                        {title: 'Modules', icon: 'mdi-book-outline', to: route('pages.management-modules')},
                    ],
                },
                {
                    title: 'User Management',
                    icon: 'mdi-account-group',
                    active: false,
                    items: [
                        {title: 'Admins', icon: 'mdi-account-tie', to: route('pages.management-admins')},
                        {title: 'Lecturers', icon: 'mdi-human-male-board', to: route('pages.management-lecturer')},
                        {title: 'Students', icon: 'mdi-school', to: route('pages.management-students')},
                    ],
                },
            ],
        };
    },

    computed: {
        pageTitle() {
            return this.appBarHeader;
        },
    },

    methods: {
        toggleDrawer() {
            this.drawer = !this.drawer;
        },
        navigateTo(path) {
            Inertia.visit(path);
        },
    },
};
</script>

<style>

</style>
