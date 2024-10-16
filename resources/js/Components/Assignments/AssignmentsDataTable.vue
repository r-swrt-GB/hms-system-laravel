<template>
    <DataTableExplorerBaseline
        :search-enabled="true"
        @search="onSearch"
        @add="addAssignment"
    >
        <template v-slot:toolbar-title>Assignments for {{ module.code }}</template>
        <template v-slot:add-library-item-action>Add Assignment</template>
        <template v-slot:library-items>
            <v-table>
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Open Date</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="assignment in filteredAssignments" :key="assignment.id">
                    <td>{{ assignment.title }}</td>
                    <td>{{ formatDate(assignment.open_date) }}</td>
                    <td>{{ formatDate(assignment.due_date) }}</td>
                    <td>
                        <v-btn type="icon" variant="flat" size="small" elevation="0"
                               @click="viewAssignment(assignment)">
                            <v-icon>mdi-eye</v-icon>
                        </v-btn>
                        <v-btn type="icon" variant="flat" size="small" elevation="0"
                               @click="editAssignment(assignment)">
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                        <v-btn type="icon" variant="flat" size="small" elevation="0"
                               @click="deleteAssignment(assignment)">
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

import DataTableExplorerBaseline from "@/Components/BaselineComponents/BaselineDataTable.vue";

export default {
    name: 'AssignmentsDataTable',
    emits: ['viewAssignment', 'editAssignment', 'deleteAssignment', 'addAssignment', 'exportAll'],
    components: {
        DataTableExplorerBaseline
    },
    props: {
        assignments: {
            required: true
        },
        module: {
            required: true,
        }
    },
    data() {
        return {
            searchQuery: ''
        };
    },
    computed: {
        filteredAssignments() {
            if (!this.searchQuery) {
                return this.assignments;
            }
            const query = this.searchQuery.toLowerCase();
            return this.assignments.filter(assignment =>
                assignment.title.toLowerCase().includes(query) ||
                assignment.open_date.toLowerCase().includes(query) ||
                assignment.due_date.toLowerCase().includes(query)
            );
        }
    },
    methods: {
        onSearch(value) {
            this.searchQuery = value;
        },
        viewAssignment(assignment) {
            this.$emit('viewAssignment', assignment);
        },
        editAssignment(assignment) {
            this.$emit('editAssignment', assignment);
        },
        deleteAssignment(assignment) {
            this.$emit('deleteAssignment', assignment);
        },
        addAssignment() {
            this.$emit('addAssignment');
        },
        formatDate(date) {
            date = new Date(date);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
    }
};
</script>
