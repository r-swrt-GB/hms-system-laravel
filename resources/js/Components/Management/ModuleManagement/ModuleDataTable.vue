<template>
    <DataTableExplorerBaseline
        :search-enabled="true"
        @search="onSearch"
        @add="addModule"
    >
        <template v-slot:toolbar-title>Modules</template>
        <template v-slot:add-library-item-action>Add Module</template>
        <template v-slot:library-items>
            <v-table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="module in filteredModules" :key="module.id">
                    <td>{{ module.module_name }}</td>
                    <td>{{ module.code }}</td>
                    <td>{{ module.description }}</td>
                    <td>
                        <v-btn type="icon" variant="flat" size="small" elevation="0" @click="viewModule(module)">
                            <v-icon>mdi-eye</v-icon>
                        </v-btn>
                        <v-btn type="icon" variant="flat" size="small" elevation="0" @click="editModule(module)">
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                        <v-btn type="icon" variant="flat" size="small" elevation="0" @click="deleteModule(module)">
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
    name: 'ModuleDataTable',
    emits: ['viewModuleClicked', 'editModuleClicked', 'deleteModuleClicked', 'addModuleClicked'],
    components: {
        DataTableExplorerBaseline
    },
    props: {
        modules: {
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
        filteredModules() {
            if (!this.searchQuery) {
                return this.modules;
            }
            const query = this.searchQuery.toLowerCase();
            return this.modules.filter(module =>
                module.name.toLowerCase().includes(query) ||
                module.code.toLowerCase().includes(query) ||
                module.description.toLowerCase().includes(query)
            );
        }
    },
    methods: {
        onSearch(value) {
            this.searchQuery = value;
        },
        viewModule(module) {
            this.$emit('viewModuleClicked', module);
        },
        editModule(module) {
            this.$emit('editModuleClicked', module);
        },
        deleteModule(module) {
            this.$emit('deleteModuleClicked', module);
        },
        addModule() {
            this.$emit('addModuleClicked');
        }
    }
};
</script>
