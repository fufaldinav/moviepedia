<template>
    <div class="bg-light table-responsive h-100">
        <table class="table table-bordered table-striped table-hover table-sm app-table">
            <col style="width: 4rem;"/>
            <col
                v-for="fieldName in displayedFields"
                :key="`col_${fieldName}`"
                :style="colWidth(fieldName)"
            />
            <thead class="thead-light">
            <tr>
                <th id="number" scope="col">
                    #
                </th>
                <th
                    v-for="fieldName in displayedFields"
                    :key="`field_${fieldName}`"
                    :id="fieldName"
                    class="app-table-th"
                    scope="col"
                >
                    <div class="d-flex">
                        <span class="mr-auto">
                            {{ fields[fieldName].title }}
                        </span>
                        <a
                            class="text-danger mr-1 d-none d-md-block app-hide-field-icon"
                            href="#"
                            @click.prevent="hideField(fieldName)"
                        >
                            <fa :icon="eyeSlashIcon"/>
                        </a>
                        <a
                            v-if="fields[fieldName].hasOwnProperty('sortable') && fields[fieldName].sortable"
                            class="text-dark app-sort-icon"
                            :class="{ 'app-sort-icon-active': sortField === fieldName }"
                            href="#"
                            @click.prevent="sortTable(fieldName)"
                        >
                            <fa :icon="drawSortIcon(fieldName)"/>
                        </a>
                    </div>
                </th>
            </tr>
            </thead>
            <tbody>
            <app-movie
                v-for="(movie, n) in movies"
                :key="`app_movie_${movie.id}`"
                :number="getRowNumber(n)"
                :movie="movie"
            >
            </app-movie>
            </tbody>
        </table>
    </div>
</template>

<script>
    import AppMovie from './AppMovie';
    import {faSort, faSortAmountDown, faSortAmountUp, faEyeSlash} from '@fortawesome/free-solid-svg-icons';

    export default {
        name: 'AppTable',

        components: { AppMovie },

        computed: {
            loading() {
                return this.$store.state.loading;
            },

            eyeSlashIcon() {
                return faEyeSlash;
            },

            currentPageNumber() {
                return this.$store.state.currentPageNumber;
            },

            pageSize() {
                return this.$store.state.pageSize;
            },

            fields() {
                return this.$store.state.fields;
            },

            sortField() {
                return this.$store.state.sortField;
            },

            sortOrder() {
                return this.$store.state.sortOrder;
            },

            movies() {
                return this.$store.state.movies;
            },

            pageCount() {
                return this.$store.getters.pageCount;
            },

            displayedFields() {
                return this.$store.getters.getDisplayedFields;
            },

            query() {
                return this.$store.getters.getQuery;
            },
        },

        methods: {
            getRowNumber(n) {
                return n + 1 + (this.currentPageNumber - 1) * this.pageSize;
            },

            drawSortIcon(fieldName) {
                if (fieldName === this.sortField) {
                    if (this.sortOrder === 'desc') {
                        return faSortAmountDown;
                    } else {
                        return faSortAmountUp;
                    }
                } else {
                    return faSort;
                }
            },

            sortTable(fieldName) {
                if (fieldName === this.sortField) {
                    if (this.sortOrder === 'desc') {
                        this.$router.push({
                            path: this.$route.path,
                            query: { ...this.$route.query, sort_order: 'asc' },
                        });
                    } else {
                        this.$router.push({
                            path: this.$route.path,
                            query: { ...this.$route.query, sort_order: 'desc' },
                        });
                    }
                } else {
                    this.$router.push({
                        path: this.$route.path,
                        query: { ...this.$route.query, sort_field: fieldName, sort_order: 'asc' },
                    });
                }
            },

            hideField(fieldName) {
                this.$store.commit('hideField', fieldName);
            },

            colWidth(fieldName) {
                const length = this.fields[fieldName].width || 10;
                return {
                    width: `${length}rem`,
                };
            },
        },

        beforeRouteEnter(to, from, next) {
            next(vm => {
                // console.log('enter'); //TODO удалить
                // console.log(from); //TODO удалить
                // console.log(to); //TODO удалить
                vm.$store.dispatch('parseQuery', to.query);
                vm.$router.replace({ path: to.path, query: vm.query })
                    .catch(err => {
                        if (err && err.hasOwnProperty('name') && err.name === 'NavigationDuplicated') {
                            vm.$store.dispatch('loadMovies', vm.query)
                                .then(() => {
                                    if (vm.query.page > vm.pageCount) {
                                        vm.$router.replace({
                                            path: to.path,
                                            query: { ...vm.query, page: vm.pageCount },
                                        });
                                    }
                                })
                                .catch(() => {
                                    vm.$router.replace('/error');
                                });
                        } else {
                            //TODO обработка ошибки
                        }
                    });
            });
        },

        beforeRouteUpdate(to, from, next) {
            // console.log('update'); //TODO удалить
            // console.log(from); //TODO удалить
            // console.log(to); //TODO удалить
            this.$store.dispatch('parseQuery', to.query);
            this.$store.dispatch('loadMovies', this.query)
                .then(() => {
                    if (this.query.page > this.pageCount) {
                        next({
                            path: to.path,
                            query: { ...this.query, page: this.pageCount },
                            replace: true,
                        });
                    } else {
                        next();
                    }
                })
                .catch(() => {
                    next('/error');
                });
        },
    };
</script>

<style scoped>

</style>