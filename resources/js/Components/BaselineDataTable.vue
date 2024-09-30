<template>
    <v-row justify="start" class="fill-height">
        <v-col class="fill-height">
            <v-toolbar-title class="toolbar-title">
                <slot name="toolbar-title"></slot>
                <header-underline
                    class="header-underline"
                    :length="underlineLength"
                    :primary-color="this.$vuetify.theme.themes.light.colors.primary"
                ></header-underline>
            </v-toolbar-title>
            <v-card class="fill-height mt-6">
                <v-toolbar color="#f5f5f5">
                    <template v-if="searchEnabled">
                        <div style="padding: 20px; width: 300px">
                            <v-text-field
                                @input="onSearch"
                                density="compact"
                                append-inner-icon="mdi-magnify"
                                variant="outlined"
                                label="Search"
                                hide-details
                            ></v-text-field>
                        </div>
                    </template>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-if="actionButton"
                        variant="flat"
                        color="primary"
                        @click="onAddLibraryItem">
                        <v-icon class="pr-1">mdi-plus-box-multiple</v-icon>
                        <slot name="add-library-item-action"></slot>
                    </v-btn>
                </v-toolbar>
                <v-divider></v-divider>

                <div class="library-item-wrapper" :style="{height: librarySectionHeight}">
                    <slot name="library-items"></slot>
                </div>

                <!--                        <v-divider></v-divider>-->
                <!--                        <v-btn flat block class="add-library-item-action" style="border-radius: 0"-->
                <!--                               @click="onAddLibraryItem">-->
                <!--                            <v-icon class="pr-1">mdi-plus</v-icon>-->
                <!--                            <slot name="add-library-item-action"></slot>-->
                <!--                        </v-btn>-->
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import HeaderUnderline from "../../HeaderUnderline.vue";

export default {
    name: "DataTableExplorerBaseline",
    components: {HeaderUnderline},
    props: {
        searchEnabled: {
            type: Boolean,
            default: false,
        },
        actionButton: {
            type: Boolean,
            default: true,
        },
        underlineLength: {
            required: false,
            type: Number,
            default: 7,
        }
    },
    computed: {
        librarySectionHeight() {
            return 'calc(100% - 130px)';
        },
    },
    methods: {
        onSearch(event) {
            this.$emit('search', event.target.value);
        },
        onAddLibraryItem() {
            this.$emit('add');
        },
    },
}
</script>

<style scoped>

.toolbar-title {
    font-size: x-large;
}

.header-underline {
    margin-top: 1px;
    margin-bottom: 1px
}

.border-right {
    border-right: 1px solid lightgray;
}

.library-item-wrapper {
    overflow-y: auto;
}

.library-item-selected {
    height: calc(100% - 130px);
    padding: 20px;
}

</style>
