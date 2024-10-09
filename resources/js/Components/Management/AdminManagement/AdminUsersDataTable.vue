<template>
    <DataTableExplorerBaseline
        :search-enabled="true"
        @search="onSearch"
        @add="addUser"
    >
        <template v-slot:toolbar-title>Admin Users</template>
        <template v-slot:add-library-item-action>Add Admin</template>
        <template v-slot:library-items>
            <v-table>
                <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in filteredUsers" :key="user.id">
                    <td>{{ user.first_name }}</td>
                    <td>{{ user.last_name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                        <v-btn type="icon" variant="flat" size="small" elevation="0" @click="editUser(user)">
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                        <v-btn type="icon" variant="flat" size="small" elevation="0" @click="deleteUser(user)">
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </td>
                </tr>
                </tbody>
            </v-table>
        </template>
    </DataTableExplorerBaseline>
</template>

<script>
import DataTableExplorerBaseline from '../../BaselineDataTable.vue';

export default {
    name: 'AdminUsersDataTable',
    components: {
        DataTableExplorerBaseline
    },
    props: {
        adminUsers: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            searchQuery: ''
        };
    },
    computed: {
        filteredUsers() {
            if (!this.searchQuery) {
                return this.adminUsers;
            }
            const query = this.searchQuery.toLowerCase();
            return this.adminUsers.filter(user =>
                user.first_name.toLowerCase().includes(query) ||
                user.last_name.toLowerCase().includes(query) ||
                user.email.toLowerCase().includes(query)
            );
        }
    },
    methods: {
        onSearch(value) {
            this.searchQuery = value;
        },
        editUser(user) {
            // Implement edit functionality
            this.$emit('editUser',user);
        },
        deleteUser(user) {
            // Implement delete functionality
            this.$emit('deleteUser',user);
        },
        addUser() {
            // Implement delete functionality
            this.$emit('addUser');
        }
    }
};
</script>
