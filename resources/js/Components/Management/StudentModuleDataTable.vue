<template>
    <v-row justify="start" class="fill-height">
        <v-col class="fill-height">
            <v-toolbar-title class="toolbar-title">
                Student Module Data Table
            </v-toolbar-title>
            <v-card class="fill-height mt-6">
                <v-toolbar color="#f5f5f5">
                    <div style="padding: 20px; width: 300px">
                        <v-text-field
                            v-model="searchQuery"
                            @input="onSearch"
                            density="compact"
                            append-inner-icon="mdi-magnify"
                            variant="outlined"
                            label="Search"
                            hide-details
                        ></v-text-field>
                    </div>
                    <v-spacer></v-spacer>
                    <div style="padding-right: 20px">
                        <v-btn
                            variant="flat"
                            @click="resetChanges"
                            :disabled="!hasChanges"
                        >
                            Reset
                        </v-btn>
                        <v-btn
                            variant="flat"
                            color="primary"
                            @click="saveChanges"
                            :disabled="!hasChanges"
                            class="ml-2"
                        >
                            Save
                        </v-btn>
                    </div>
                </v-toolbar>
                <v-divider></v-divider>

                <div class="library-item-wrapper" :style="{height: librarySectionHeight}">
                    <v-data-table
                        :headers="headers"
                        :items="studentsArray"
                        item-value="id"
                    >
                        <template v-slot:item.has_module="{ item }">
                            <v-checkbox
                                v-model="item.has_module"
                                @change="onCheckboxChange(item)"
                                hide-details
                            ></v-checkbox>
                        </template>
                    </v-data-table>
                </div>
            </v-card>
        </v-col>
    </v-row>

    <v-snackbar v-model="snackbar.show" :timeout="snackbar.timeout" :color="snackbar.color">
        {{ snackbar.message }}
    </v-snackbar>
</template>

<script>
export default {
    name: 'StudentModuleDataTable',
    props: {
        module: {
          required: true,
        },
        students: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            searchQuery: '',
            headers: [
                {title: 'First Name', key: 'first_name'},
                {title: 'Last Name', key: 'last_name'},
                {title: 'Email', key: 'email'},
                {title: 'Enrolled', key: 'has_module', sortable: false}
            ],
            originalStudents: {},
            enrolledStudents: [],
            snackbar: {
                show: false,
                message: '',
                color: 'success',
                timeout: 3000
            },
        };
    },
    computed: {
        librarySectionHeight() {
            return 'calc(100% - 130px)';
        },
        studentsArray() {
            return Object.keys(this.students).map(key => ({
                id: key,
                ...this.students[key]
            }));
        },
        filteredStudents() {
            if (!this.searchQuery) {
                return this.studentsArray;
            }
            const query = this.searchQuery.toLowerCase();
            return this.studentsArray.filter(student =>
                student.first_name.toLowerCase().includes(query) ||
                student.last_name.toLowerCase().includes(query) ||
                student.email.toLowerCase().includes(query)
            );
        },
        hasChanges() {
            return JSON.stringify(this.enrolledStudents) !== JSON.stringify(this.originalEnrolledStudents);
        }
    },
    created() {
        this.originalStudents = JSON.parse(JSON.stringify(this.students));
        this.setEnrolledStudents();
    },
    methods: {
        setEnrolledStudents() {
            this.enrolledStudents = this.studentsArray
                .filter(student => student.has_module)
                .map(student => student.id);
            this.originalEnrolledStudents = [...this.enrolledStudents];
        },
        onSearch() {
            // The v-model on the text field will update searchQuery automatically
        },
        onCheckboxChange(student) {
            if (student.has_module) {
                if (!this.enrolledStudents.includes(student.id)) {
                    this.enrolledStudents.push(student.id);
                }
            } else {
                const index = this.enrolledStudents.indexOf(student.id);
                if (index > -1) {
                    this.enrolledStudents.splice(index, 1);
                }
            }
        },
        saveChanges() {
            const updatedStudents = {...this.students};
            this.studentsArray.forEach(student => {
                updatedStudents[student.id] = {
                    ...student,
                    has_module: this.enrolledStudents.includes(student.id)
                };
            });

            axios.post(route('api.modules.students.sync', {
                module: this.module,
                enrolledStudents: this.enrolledStudents,
            }))
                .then((response) => {
                    this.snackbar.message = "Students updated successfully";
                    this.snackbar.color = "success";
                    this.snackbar.show = true;
                })
                .catch((error) => {
                    this.snackbar.message = error.response?.data?.errors || "Failed to update Students";
                    this.snackbar.color = "error";
                    this.snackbar.show = true;
                })

            this.originalStudents = JSON.parse(JSON.stringify(updatedStudents));
            this.originalEnrolledStudents = [...this.enrolledStudents];
        },
        resetChanges() {
            this.enrolledStudents = [...this.originalEnrolledStudents];
            const resetStudents = JSON.parse(JSON.stringify(this.originalStudents));
            this.studentsArray.forEach(student => {
                student.has_module = this.enrolledStudents.includes(student.id);
            });
        }
    }
};
</script>

<style scoped>
.toolbar-title {
    font-size: x-large;
}

.library-item-wrapper {
    overflow-y: auto;
}
</style>
