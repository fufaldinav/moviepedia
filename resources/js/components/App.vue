<template>
    <div class="h-100">
        <nav class="navbar navbar-light navbar-expand-md bg-light shadow-sm fixed-top">
            <a
                class="navbar-brand mr-1"
                href="#"
                @click.prevent="reloadPage()"
            >
                Moviepedia
            </a>
            <div
                v-if="loading"
                class="spinner-grow spinner-grow-sm text-primary mr-auto"
                role="status"
            >
                <span class="sr-only">Loading...</span>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"/>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mr-2">
                    <AppTablePageSizeMenu/>
                    <AppTableFieldsTogglerMenu/>
                    <li
                        v-if="filtersButtonIsShown"
                        class="nav-item"
                    >
                        <a
                            class="nav-link"
                            :class="filtersLinkClass"
                            href="#"
                            role="button"
                            data-toggle="modal"
                            data-target="#filtersMenu"
                        >
                            Filters
                            <fa :icon="filtersIcon"/>
                        </a>
                    </li>
                </ul>
                <AppSearchPhraseForm/>
            </div>
        </nav>
        <main class="h-100">
            <RouterView/>
        </main>
        <AppPaginator/>
        <AppFiltersMenu/>
    </div>
</template>

<script>
    import AppFiltersMenu from './AppFiltersMenu';
    import AppSearchPhraseForm from './AppSearchPhraseForm';
    import AppTable from './AppTable';
    import AppTableFieldsTogglerMenu from './AppTableFieldsTogglerMenu';
    import AppTablePageSizeMenu from './AppTablePageSizeMenu';
    import AppPaginator from './AppPaginator';
    import {faFilter} from '@fortawesome/free-solid-svg-icons';

    export default {
        name: 'App',

        data() {
            return {
                filtersButtonIsShown: true,
            };
        },

        components: {
            AppSearchPhraseForm,
            AppFiltersMenu,
            AppTable,
            AppTableFieldsTogglerMenu,
            AppTablePageSizeMenu,
            AppPaginator,
        },

        computed: {
            filtersIcon() {
                return faFilter;
            },

            loading() {
                return this.$store.state.loading;
            },

            isAnyFilter() {
                return this.$store.getters.isAnyFilterExceptSearch;
            },

            filtersLinkClass() {
                return {
                    'text-success': this.isAnyFilter,
                    'disabled': this.loading,
                };
            },
        },

        methods: {
            reloadPage() {
                this.$router.go(0);
            },
        },

        watch: {
            $route(to) {
                this.filtersButtonIsShown = to.name === 'table';
            },
        },
    };
</script>

<style>
</style>
