<template>
  <DataTableExplorerBaseline
      :search-enabled="true"
      :action-button-icon="false"
      @add="viewAssignmentDetails"
      @search="onSearch"
  >
    <template v-slot:toolbar-title>Submissions for {{ assignment.title }}</template>
    <template v-slot:add-library-item-action>Assignment Details</template>
    <template v-slot:library-items>
      <v-table>
        <thead>
        <tr>
          <th>Student</th>
          <th>Submission Date and Time</th>
          <th>Grade</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="submission in filteredSubmissions" :key="submission.id">
          <td>{{ submission.users[0].first_name + ' ' + submission.users[0].last_name }}</td>
          <td>{{ formatDate(submission.submission_date) }}</td>
          <td>{{ submission.grade ?? 'Not graded' }}</td>
          <td>
            <v-btn type="icon" variant="flat" size="small" elevation="0"
                   @click="viewSubmission(submission)">
              <v-icon>mdi-eye</v-icon>
            </v-btn>
            <v-btn type="icon" variant="flat" size="small" elevation="0"
                   @click="deleteSubmission(submission)">
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
  name: 'SubmissionDataTable',
  emits: ['viewSubmission', 'deleteSubmission', 'viewAssignmentDetails'],
  components: {
    DataTableExplorerBaseline
  },
  props: {
    submissions: {
      required: true
    },
    assignment: {
      required: true,
    }
  },
  data() {
    return {
      searchQuery: ''
    };
  },
  computed: {
    filteredSubmissions() {
      if (!this.searchQuery) {
        return this.submissions;
      }
      const query = this.searchQuery.toLowerCase();
      return this.submissions.filter(submission =>
          submission.users[0].first_name.toLowerCase().includes(query) ||
          submission.users[0].last_name.toLowerCase().includes(query) ||
          submission.submission_date.toLowerCase().includes(query) ||
          submission.grade.toLowerCase().includes(query) ||
          submission.due_date.toLowerCase().includes(query)
      );
    }
  },
  methods: {
    onSearch(value) {
      this.searchQuery = value;
    },
    viewSubmission(submission) {
      this.$emit('viewSubmission', submission);
    },
    deleteSubmission(submission) {
      this.$emit('deleteSubmission', submission);
    },
    viewAssignmentDetails() {
      this.$emit('viewAssignmentDetails');
    },
    formatDate(date) {
      date = new Date(date);
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');
      const hours = String(date.getHours()).padStart(2, '0');
      const minutes = String(date.getMinutes()).padStart(2, '0');

      return `${year}-${month}-${day} at ${hours}:${minutes}`;
    }

  }
};
</script>
