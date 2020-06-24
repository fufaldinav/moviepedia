<template>
    <form
        v-if="shown"
        class="form-inline"
    >
        <fieldset :disabled="loading">
            <div class="input-group my-2 my-md-0">
                <input
                    class="form-control form-control-sm app-phrase-search-input"
                    type="text"
                    size="50"
                    placeholder="phrase from movie..."
                    aria-label="Search"
                    v-model="searchPhrase"
                >
                <div class="input-group-append">
                    <button
                        v-if="searchPhrase === null && currentSearchPhrase !== null"
                        type="button"
                        class="btn btn-sm btn-success"
                        @click="applyClearedFilter()"
                    >
                        Apply
                    </button>
                    <button
                        v-else-if="searchPhrase === currentSearchPhrase && currentSearchPhrase !== null"
                        type="button"
                        class="btn btn-sm btn-danger"
                        @click="searchPhrase = null"
                    >
                        Clear
                    </button>
                    <button
                        v-else
                        type="button"
                        class="btn btn-sm btn-success"
                        :disabled="searchButtonDisabled"
                        @click="applySearchFilter()"
                    >
                        Search
                    </button>
                </div>
            </div>
        </fieldset>
    </form>
</template>

<script>
    export default {
        name: 'AppSearchPhraseForm',

        data() {
            return {
                shown: true,
                searchPhrase: null,
            };
        },

        computed: {
            loading() {
                return this.$store.state.loading;
            },

            currentSearchPhrase() {
                return this.$store.state.filters.search;
            },

            searchButtonDisabled() {
                return this.searchPhrase === '' || this.searchPhrase === null;
            },
        },

        methods: {
            applySearchFilter() {
                this.$router.push({
                    path: this.$route.path,
                    query: { ...this.$route.query, search: this.searchPhrase },
                });
            },

            applyClearedFilter() {
                this.$router.push({
                    path: this.$route.path,
                    query: { ...this.$route.query, search: undefined },
                });
            },
        },

        watch: {
            $route(to) {
                this.shown = to.name === 'table';
                this.searchPhrase = this.currentSearchPhrase;
            },
        },
    };
</script>

<style scoped>

</style>