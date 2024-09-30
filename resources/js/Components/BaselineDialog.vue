<template>
    <v-dialog
        v-model="baselineDialog"
        :max-width="maxWidth"
        persistent>
        <v-card>
            <v-card-title>
                <v-icon class="mr-1">
                    <slot name="toolbar-icon"></slot>
                </v-icon>
                <slot name="toolbar-title"></slot>
            </v-card-title>

            <v-divider></v-divider>

            <v-card-text>
                <slot name="dialog-content"></slot>
                <small class="text-caption text-medium-emphasis">
                    <slot name="small-text"></slot>
                </small>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <!-- Secondary Button -->
                <v-btn
                    variant="plain"
                    @click="$emit('secondaryButtonClicked')">

                    <slot name="secondary-button-text"></slot>

                </v-btn>
                <!-- Primary Button -->
                <v-btn
                    v-if="primaryButton"
                    :color="useDefaultColor ? '#942028' : 'primary'"
                    :loading="loading"
                    variant="elevated"
                    type="submit"
                    @click="$emit('primaryButtonClicked')">

                    <slot name="primary-button-text"></slot>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>

export default {
    name: 'DialogBaseline',
    mixins: [],
    props: {
        maxWidth: {
            required: false,
            default: 600,
        },
        primaryButton: {
            required: false,
            default: true,
        },
        useDefaultColor: {
            required: false,
            default: false,
        },
        loading: {
            required: false,
            default: false,
        }
    },
    data: () => ({
        baselineDialog: true,
    }),
}
</script>

<style scoped>

</style>
