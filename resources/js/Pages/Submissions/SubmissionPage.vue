<template>
    <v-toolbar height="91" color="primary">
        <v-btn type="icon" @click="goBack">
            <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
        <v-toolbar-title>{{
                submission.user[0].first_name + ' ' + submission.user[0].last_name + ' - Submission'
            }}
        </v-toolbar-title>
        <v-spacer></v-spacer>
    </v-toolbar>

    <v-container class="centered-container" style="width: 800px; margin: auto; padding: 50px;">
        <v-row justify="center" style="width: 100%">
            <v-col cols="12">
                <!-- Assignment Details -->
                <v-card class="mb-6">
                    <v-toolbar color="primary" dark>
                        <v-toolbar-title>Assignment Details</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" sm="6">
                                <div class="text-field-label">Assignment Title</div>
                                <h1 style="font-size: 15px">{{ assignment.title }}</h1>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" sm="6">
                                <div class="text-field-label">Assignment Description</div>
                                <h1 style="font-size: 15px">{{ assignment.description }}</h1>
                            </v-col>
                        </v-row>

                        <div class="divider"></div>

                        <v-row>
                            <v-col cols="12" sm="6">
                                <div class="text-field-label">Assignment Open Date</div>
                                <h1 style="font-size: 15px">{{ formatDate(assignment.open_date) }}</h1>
                            </v-col>
                            <v-col cols="6" sm="6">
                                <div class="text-field-label">Assignment Due Date</div>
                                <h1 style="font-size: 15px">{{ formatDate(assignment.open_date) }}</h1>
                            </v-col>
                        </v-row>

                        <div class="divider"></div>


                        <v-row>
                            <v-col cols="12">
                                <div class="text-field-label">Max Grade</div>
                                <h1 style="font-size: 15px">{{ assignment.max_grade }}</h1>
                            </v-col>
                        </v-row>

                        <div class="divider"></div>

                        <v-row>
                            <v-col cols="6">
                                <div class="text-field-label">Minimum Videos</div>
                                <h1 style="font-size: 15px">{{ assignment.max_grade }}</h1>
                            </v-col>
                            <v-col cols="6">
                                <div class="text-field-label">Maximum Videos</div>
                                <h1 style="font-size: 15px">{{ assignment.max_grade }}</h1>
                            </v-col>
                            <v-col cols="6">
                                <div class="text-field-label">Maximum Video Length</div>
                                <h1 style="font-size: 15px">{{ assignment.max_grade }}</h1>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>

                <!-- Submission Details -->
                <v-card class="mb-6">
                    <v-toolbar color="primary" dark>
                        <v-toolbar-title>Submission Details</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn v-if="!submission.grade" @click="showGradeDialog = true"
                               style="background-color: white; color: black">Grade Submission
                        </v-btn>
                    </v-toolbar>
                    <v-card-text>
                        <v-row>
                            <v-col cols="6">
                                <div class="text-field-label">Student Full Name</div>
                                <h1 style="font-size: 15px">
                                    {{ submission.user[0].first_name + ' ' + submission.user[0].last_name }}</h1>
                            </v-col>
                            <v-col cols="6">
                                <div class="text-field-label">Submission Date</div>
                                <h1 style="font-size: 15px">{{ formatDate(submission.submission_date) }}</h1>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <div class="text-field-label">Grade</div>
                                <h1 style="font-size: 15px">
                                    {{ submission.grade ?? 'Not Graded' }}</h1>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>

                <!-- Video Player -->
                <v-card class="mb-6">
                    <v-toolbar color="primary" dark>
                        <v-toolbar-title>Video Submission</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12">
                                <div class="text-field-label">Select a video</div>
                                <v-select
                                    v-model="selectedVideo"
                                    :items="attachmentItems"
                                    item-title="text"
                                    item-value="key"
                                    @update:model-value="changeVideo"
                                    variant="outlined"
                                    hide-details
                                    class="mb-4 custom-select"
                                    style="font-size: 1rem"
                                ></v-select>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <video
                                    ref="videoPlayer"
                                    :src="currentVideoSrc"
                                    controls
                                    style="width: 100%; max-height: 400px;"
                                ></video>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>

                <!-- Comments Section -->
                <v-card>
                    <v-toolbar color="primary" dark>
                        <v-toolbar-title>Comments Section</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-row v-if="submission.comments.length === 0">
                            <v-col cols="12">
                                <h1 class="data-display" style="color: grey">
                                    No Comments
                                </h1>
                            </v-col>
                        </v-row>
                        <v-list v-else>
                            <v-list-item v-for="comment in submission.comments" :key="comment.id">
                                <v-list-item-title>{{ comment.user.first_name + ' ' + comment.user.last_name }}
                                </v-list-item-title>
                                <v-list-item-subtitle>{{ comment.comment_text }}</v-list-item-subtitle>
                            </v-list-item>
                        </v-list>

                        <div class="divider"></div>

                        <div class="text-field-label my-4">Add a comment</div>
                        <v-textarea
                            v-model="newComment"
                            variant="solo"
                            density="compact"
                        ></v-textarea>
                        <v-btn @click="addComment" color="primary" class="mt-2">Add Comment</v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <!-- Snackbar Dialog -->
        <v-snackbar v-model="snackbar.show" :timeout="snackbar.timeout" :color="snackbar.color">
            {{ snackbar.message }}
        </v-snackbar>

        <!-- Grade Dialog -->
        <v-dialog v-model="showGradeDialog" max-width="500px">
            <v-card>
                <v-card-title>Grade Submission</v-card-title>
                <v-card-text>
                    <div class="text-field-label">Grade</div>
                    <v-text-field
                        v-model="gradeInput"
                        type="number"
                        variant="solo"
                        density="compact"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="showGradeDialog = false">Cancel</v-btn>
                    <v-btn @click="submitGrade" color="primary" type="solo">Submit Grade</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
import axios from 'axios';
import {VideoPlayer} from 'vue-video-player';
import 'video.js/dist/video-js.css';

export default {
    name: 'SubmissionPage',
    components: {
        VideoPlayer
    },
    props: {
        module: {
            required: true
        },
        assignment: {
            required: true
        },
        submission: {
            required: true
        },
    },
    data() {
        return {
            selectedVideo: null,
            currentVideoSrc: '',
            newComment: '',
            snackbar: {
                show: false,
                message: '',
                color: 'success',
                timeout: 3000
            },
            showGradeDialog: false,
            gradeInput: null
        };
    },
    computed: {
        attachmentItems() {
            return this.submission.files.map((file, index) => ({
                text: `Attachment ${index + 1}`,
                key: file.key,
                url: file.url
            }));
        }
    },
    mounted() {
        this.initializeVideo();
    },
    methods: {
        initializeVideo() {
            if (this.attachmentItems.length > 0) {
                this.selectedVideo = this.attachmentItems[0].key;
                this.changeVideo();
            }
        },
        changeVideo() {
            const selectedFile = this.attachmentItems.find(item => item.key === this.selectedVideo);
            if (selectedFile) {
                this.currentVideoSrc = selectedFile.url;
            }
        },
        goBack() {
            window.history.back();
        },
        formatDate(date) {

            if (date == null) {
                return '-';
            }

            date = new Date(date);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');

            return `${year}-${month}-${day} at ${hours}:${minutes}`;
        },
        async addComment() {
            try {
                await axios.post(route('api.comments.create', {
                        module: this.module.id,
                        assignment: this.assignment.id,
                        submission: this.submission.id,
                        comment_text: this.newComment,
                    })
                )
                this.newComment = '';
                this.showSnackbar('Comment added successfully');
            } catch (error) {
                console.error('Error adding comment:', error);
                this.showSnackbar('Error adding comment', 'error');
            }
        },
        async editComment(comment) {
            // Implement edit functionality
        },
        async deleteComment(commentId) {
            try {
                await axios.delete(`/api/comments/${commentId}`);
                this.showSnackbar('Comment deleted successfully');
            } catch (error) {
                console.error('Error deleting comment:', error);
                this.showSnackbar('Error deleting comment', 'error');
            }
        },
        async submitGrade() {
            if (this.gradeInput > this.assignment.max_grade) {
                this.showSnackbar(`Max grade is ${this.assignment.max_grade}`, 'error');
                return;
            } else if (this.gradeInput < 0) {
                this.showSnackbar(`Grade cannot be negative`, 'error');
                return;
            }

            try {
                await axios.patch(route('api.submissions.update', {
                        module: this.module.id,
                        assignment: this.assignment.id,
                        submission: this.submission.id,
                        grade: this.gradeInput
                    })
                );
                this.submission.grade = this.gradeInput;
                this.showGradeDialog = false;
                this.showSnackbar('Submission graded successfully');
            } catch (error) {
                console.error('Error submitting grade:', error);
                this.showSnackbar('Error submitting grade', 'error');
            }
        },
        showSnackbar(message, color = 'success') {
            this.snackbar.message = message;
            this.snackbar.color = color;
            this.snackbar.show = true;
        }
    }
};
</script>

<style scoped>
.centered-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.text-field-label {
    font-size: 14px;
    color: rgba(0, 0, 0, 0.6);
    margin-bottom: 4px;
}

.custom-select ::v-deep(.v-field__field) {
    border-color: transparent;
}

.custom-select ::v-deep(.v-field__input) {
    height: 42px;
    padding-top: 0;
    padding-bottom: 0;
}

.custom-select ::v-deep(.v-field__input input) {
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
    caret-color: transparent;
}

.custom-select ::v-deep(.v-field__outline) {
    --v-field-border-opacity: 1;
}

/* Ensure the label is visible */
.custom-select ::v-deep(.v-label) {
    opacity: 1;
    transform: translateY(-16px) scale(0.75);
}

/* Style for the selected value */
.custom-select ::v-deep(.v-select__selection) {
    margin-top: 0;
}
</style>
