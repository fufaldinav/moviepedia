<template>
    <div class="modal fade app-filters-menu" id="filtersMenu" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="filtersMenuTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="filtersMenuTitle">Filters</h5>
                    <a
                        v-show="isAnyFilter"
                        href="#"
                        class="badge badge-pill badge-danger ml-2"
                        data-dismiss="modal"
                        @click.prevent="resetFilters()"
                    >
                        reset all
                    </a>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        @click="loadFilters()"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <!-- Adult -->
                        <div class="form-group">
                            <label for="filterAdult">Adult Titles</label>
                            <a
                                v-show="filters.adult !== null"
                                href="#"
                                class="badge badge-pill badge-danger"
                                @click.prevent="filters.adult = null"
                            >
                                reset
                            </a>
                            <div id="filterAdult" class="form-row ml-1">
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="filterAdult"
                                        id="adultTrue"
                                        :value="true"
                                        v-model="filters.adult"
                                    >
                                    <label class="form-check-label" for="adultTrue">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="filterAdult"
                                        id="adultFalse"
                                        :value="false"
                                        v-model="filters.adult"
                                    >
                                    <label class="form-check-label" for="adultFalse">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- Budget -->
                        <div class="form-group">
                            <label for="filterBudget">Budget</label>
                            <a
                                v-show="budgetMin !== null || budgetMax !== null"
                                href="#"
                                class="badge badge-pill badge-danger"
                                @click.prevent="resetRangedFilter('budget')"
                            >
                                reset
                            </a>
                            <div id="filterBudget" class="form-row">
                                <div class="col">
                                    <input
                                        type="number"
                                        class="form-control"
                                        :min="filtersRanges.budget_min"
                                        :max="filtersRanges.budget_max"
                                        :placeholder="`min: ${filtersRanges.budget_min}`"
                                        v-model.number="budgetMin"
                                    >
                                </div>
                                <div class="col">
                                    <input
                                        type="number"
                                        class="form-control"
                                        :min="filtersRanges.budget_min"
                                        :max="filtersRanges.budget_max"
                                        :placeholder="`max: ${filtersRanges.budget_max}`"
                                        v-model.number="budgetMax"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- Genres -->
                        <div class="form-group">
                            <label for="filterGenres">Genres</label>
                            <a
                                v-show="filters.genres.length > 0"
                                href="#"
                                class="badge badge-pill badge-danger"
                                @click.prevent="filters.genres = []"
                            >
                                reset
                            </a>
                            <select
                                multiple
                                class="form-control"
                                id="filterGenres"
                                v-model="filters.genres"
                            >
                                <option
                                    v-for="genre of genres"
                                    :key="`genre_${genre.id}`"
                                    :value="genre.name"
                                >
                                    {{ genre.name }}
                                </option>
                            </select>
                        </div>
                        <!-- Original language -->
                        <div class="form-group">
                            <label for="filterOriginalLanguage">Original language</label>
                            <a
                                v-show="filters.original_language !== null"
                                href="#"
                                class="badge badge-pill badge-danger"
                                @click.prevent="filters.original_language = null"
                            >
                                reset
                            </a>
                            <select
                                class="form-control"
                                id="filterOriginalLanguage"
                                v-model="filters.original_language"
                            >
                                <option :value="null">
                                    Not selected
                                </option>
                                <option
                                    v-for="language of languages"
                                    :key="`original_language_${language.iso_639_1}`"
                                    :value="language.iso_639_1"
                                >
                                    {{ language.name || language.iso_639_1 }}
                                </option>
                            </select>
                        </div>
                        <!-- Popularity -->
                        <div class="form-group">
                            <label for="filterPopularity">Popularity</label>
                            <a
                                v-show="popularityMin !== null || popularityMax !== null"
                                href="#"
                                class="badge badge-pill badge-danger"
                                @click.prevent="resetRangedFilter('popularity')"
                            >
                                reset
                            </a>
                            <div id="filterPopularity" class="form-row">
                                <div class="col">
                                    <input
                                        type="number"
                                        class="form-control"
                                        :min="filtersRanges.popularity_min"
                                        :max="filtersRanges.popularity_max"
                                        :placeholder="`min: ${filtersRanges.popularity_min}`"
                                        v-model.number="popularityMin"
                                    >
                                </div>
                                <div class="col">
                                    <input
                                        type="number"
                                        class="form-control"
                                        :min="filtersRanges.popularity_min"
                                        :max="filtersRanges.popularity_max"
                                        :placeholder="`max: ${filtersRanges.popularity_max}`"
                                        v-model.number="popularityMax"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- Release date -->
                        <div class="form-group">
                            <label for="filterReleaseDate">Release date</label>
                            <a
                                v-show="releaseDateMin !== null || releaseDateMax !== null"
                                href="#"
                                class="badge badge-pill badge-danger"
                                @click.prevent="resetRangedFilter('release_date')"
                            >
                                reset
                            </a>
                            <div id="filterReleaseDate" class="form-row">
                                <div class="col">
                                    <input
                                        type="text"
                                        class="form-control"
                                        :min="filtersRanges.release_date_min"
                                        :max="releaseDateMax === null ? filtersRanges.release_date_max : releaseDateMax"
                                        :placeholder="`max: ${filtersRanges.release_date_min}`"
                                        v-model="releaseDateMin"
                                        @focus="setInputTypeToDate($event)"
                                        @blur="setInputTypeToText($event)"
                                    >
                                </div>
                                <div class="col">
                                    <input
                                        type="text"
                                        class="form-control"
                                        :min="releaseDateMin === null ? filtersRanges.release_date_min : releaseDateMin"
                                        :max="filtersRanges.release_date_max"
                                        :placeholder="`max: ${filtersRanges.release_date_max}`"
                                        v-model="releaseDateMax"
                                        @focus="setInputTypeToDate($event)"
                                        @blur="setInputTypeToText($event)"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- Revenue -->
                        <div class="form-group">
                            <label for="filterRevenue">Revenue</label>
                            <a
                                v-show="revenueMin !== null || revenueMax !== null"
                                href="#"
                                class="badge badge-pill badge-danger"
                                @click.prevent="resetRangedFilter('revenue')"
                            >
                                reset
                            </a>
                            <div id="filterRevenue" class="form-row">
                                <div class="col">
                                    <input
                                        type="number"
                                        class="form-control"
                                        :min="filtersRanges.revenue_min"
                                        :max="filtersRanges.revenue_max"
                                        :placeholder="`min: ${filtersRanges.revenue_min}`"
                                        v-model.number="revenueMin"
                                    >
                                </div>
                                <div class="col">
                                    <input
                                        type="number"
                                        class="form-control"
                                        :min="filtersRanges.revenue_min"
                                        :max="filtersRanges.revenue_max"
                                        :placeholder="`max: ${filtersRanges.revenue_max}`"
                                        v-model.number="revenueMax"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- Runtime -->
                        <div class="form-group">
                            <label for="filterRuntime">Runtime</label>
                            <a
                                v-show="runtimeMin !== null || runtimeMax !== null"
                                href="#"
                                class="badge badge-pill badge-danger"
                                @click.prevent="resetRangedFilter('runtime')"
                            >
                                reset
                            </a>
                            <div id="filterRuntime" class="form-row">
                                <div class="col">
                                    <input
                                        type="number"
                                        class="form-control"
                                        :min="filtersRanges.runtime_min"
                                        :max="filtersRanges.runtime_max"
                                        :placeholder="`min: ${filtersRanges.runtime_min}`"
                                        v-model.number="runtimeMin"
                                    >
                                </div>
                                <div class="col">
                                    <input
                                        type="number"
                                        class="form-control"
                                        :min="filtersRanges.runtime_min"
                                        :max="filtersRanges.runtime_max"
                                        :placeholder="`max: ${filtersRanges.runtime_max}`"
                                        v-model.number="runtimeMax"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- Spoken languages -->
                        <div class="form-group">
                            <label for="filterLanguages">Spoken languages</label>
                            <a
                                href="#"
                                v-show="filters.spoken_languages.length > 0"
                                class="badge badge-pill badge-danger"
                                @click.prevent="filters.spoken_languages = []"
                            >
                                reset
                            </a>
                            <select
                                multiple
                                class="form-control"
                                id="filterLanguages"
                                v-model="filters.spoken_languages"
                            >
                                <option
                                    v-for="language of languages"
                                    :key="`spoken_language_${language.iso_639_1}`"
                                    :value="language.iso_639_1"
                                >
                                    {{ language.name || language.iso_639_1 }}
                                </option>
                            </select>
                        </div>
                        <!-- Status -->
                        <div class="form-group">
                            <label for="filterStatus">Status</label>
                            <a
                                href="#"
                                v-show="filters.status !== null"
                                class="badge badge-pill badge-danger"
                                @click.prevent="filters.status = null"
                            >
                                reset
                            </a>
                            <select
                                class="form-control"
                                id="filterStatus"
                                v-model="filters.status"
                            >
                                <option :value="null">
                                    Not selected
                                </option>
                                <option
                                    v-for="status of statuses"
                                    :key="`status_${status}`"
                                    :value="status"
                                >
                                    {{ status }}
                                </option>
                            </select>
                        </div>
                        <!-- Vote average -->
                        <div class="form-group">
                            <label for="filterVoteAverage">Vote average</label>
                            <a
                                v-show="voteAverageMin !== null || voteAverageMax !== null"
                                href="#"
                                class="badge badge-pill badge-danger"
                                @click.prevent="resetRangedFilter('vote_average')"
                            >
                                reset
                            </a>
                            <div id="filterVoteAverage" class="form-row">
                                <div class="col">
                                    <input
                                        type="number"
                                        class="form-control"
                                        :min="filtersRanges.vote_average_min"
                                        :max="filtersRanges.vote_average_max"
                                        :placeholder="`min: ${filtersRanges.vote_average_min}`"
                                        v-model.number="voteAverageMin"
                                    >
                                </div>
                                <div class="col">
                                    <input
                                        type="number"
                                        class="form-control"
                                        :min="filtersRanges.vote_average_min"
                                        :max="filtersRanges.vote_average_max"
                                        :placeholder="`max: ${filtersRanges.vote_average_max}`"
                                        v-model.number="voteAverageMax"
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- Vote count -->
                        <div class="form-group">
                            <label for="filterVoteCount">Vote count</label>
                            <a
                                v-show="voteCountMin !== null || voteCountMax !== null"
                                href="#"
                                class="badge badge-pill badge-danger"
                                @click.prevent="resetRangedFilter('vote_count')"
                            >
                                reset
                            </a>
                            <div id="filterVoteCount" class="form-row">
                                <div class="col">
                                    <input
                                        type="number"
                                        class="form-control"
                                        :min="filtersRanges.vote_count_min"
                                        :max="filtersRanges.vote_count_max"
                                        :placeholder="`min: ${filtersRanges.vote_count_min}`"
                                        v-model.number="voteCountMin"
                                    >
                                </div>
                                <div class="col">
                                    <input
                                        type="number"
                                        class="form-control"
                                        :min="filtersRanges.vote_count_min"
                                        :max="filtersRanges.vote_count_max"
                                        :placeholder="`max: ${filtersRanges.vote_count_max}`"
                                        v-model.number="voteCountMax"
                                    >
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="d-flex modal-footer">
                    <button
                        type="button"
                        class="btn btn-danger mr-auto"
                        :disabled="! isAnyFilter"
                        data-dismiss="modal"
                        @click="resetFilters()"
                    >
                        Reset all
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-dismiss="modal"
                        @click="applyFilters()"
                    >
                        Apply
                    </button>
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                        @click="loadFilters()"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'AppFiltersMenu',

        data() {
            return {
                filters: {
                    search: null,            //String
                    adult: null,             //Boolean
                    budget_min: null,        //Integer
                    budget_max: null,        //Integer
                    genres: [],              //String[]
                    original_language: null, //String
                    popularity_min: null,    //Float
                    popularity_max: null,    //Float
                    release_date_min: null,  //String - дата в формате YYYY-MM-DD
                    release_date_max: null,  //String - дата в формате YYYY-MM-DD
                    revenue_min: null,       //Integer
                    revenue_max: null,       //Integer
                    runtime_min: null,       //Float
                    runtime_max: null,       //Float
                    spoken_languages: [],    //String[]
                    status: null,            //String - статус выхода фильма
                    vote_average_min: null,  //Float
                    vote_average_max: null,  //Float
                    vote_count_min: null,    //Integer
                    vote_count_max: null,    //Integer
                },
            };
        },

        computed: {
            currentFilters() {
                return this.$store.state.filters;
            },

            isAnyFilter() {
                return this.$store.getters.isAnyFilterExceptSearch;
            },

            filtersRanges() {
                return this.$store.state.filtersRanges;
            },

            budgetMin: {
                get() {
                    return this.filters.budget_min;
                },

                set(value) {
                    this.filters.budget_min = this.checkInputNumberValue('budget', value);
                    if (this.filters.budget_max !== null && this.filters.budget_min > this.filters.budget_max) {
                        this.filters.budget_min = this.filters.budget_max;
                    }
                },
            },

            budgetMax: {
                get() {
                    return this.filters.budget_max;
                },

                set(value) {
                    this.filters.budget_max = this.checkInputNumberValue('budget', value);
                    if (this.filters.budget_min !== null && this.filters.budget_max < this.filters.budget_min) {
                        this.filters.budget_max = this.filters.budget_min;
                    }
                },
            },

            popularityMin: {
                get() {
                    return this.filters.popularity_min;
                },

                set(value) {
                    this.filters.popularity_min = this.checkInputNumberValue('popularity', value);
                    if (this.filters.popularity_max !== null && this.filters.popularity_min > this.filters.popularity_max) {
                        this.filters.popularity_min = this.filters.popularity_max;
                    }
                },
            },

            popularityMax: {
                get() {
                    return this.filters.popularity_max;
                },

                set(value) {
                    this.filters.popularity_max = this.checkInputNumberValue('popularity', value);
                    if (this.filters.popularity_min !== null && this.filters.popularity_max < this.filters.popularity_min) {
                        this.filters.popularity_max = this.filters.popularity_min;
                    }
                },
            },

            releaseDateMinValueInMs() {
                return this.$store.getters.getReleaseDateMinValueInMs;
            },

            releaseDateMaxValueInMs() {
                return this.$store.getters.getReleaseDateMaxValueInMs;
            },

            releaseDateMin: {
                get() {
                    return this.filters.release_date_min;
                },

                set(value) {
                    value = this.checkInputDateValue('release_date', value);
                    const valueInMs = value === null ? null : Date.parse(value);
                    const releaseDateMaxInMs = this.filters.release_date_max === null ? null : Date.parse(this.filters.release_date_max);
                    if (isNaN(valueInMs) || valueInMs === null) {
                        this.filters.release_date_min = null;
                    } else if (valueInMs < this.releaseDateMinValueInMs) {
                        this.filters.release_date_min = this.releaseDateMinValueInMs;
                    } else if (valueInMs > this.releaseDateMaxValueInMs) {
                        this.filters.release_date_min = this.releaseDateMaxValueInMs;
                    } else if (releaseDateMaxInMs !== null && valueInMs > releaseDateMaxInMs) {
                        this.filters.release_date_min = this.filters.release_date_max;
                    } else {
                        this.filters.release_date_min = value;
                    }
                },
            },

            releaseDateMax: {
                get() {
                    return this.filters.release_date_max;
                },

                set(value) {
                    value = this.checkInputDateValue('release_date', value);
                    const valueInMs = value === null ? null : Date.parse(value);
                    const releaseDateMinInMs = this.filters.release_date_min === null ? null : Date.parse(this.filters.release_date_min);
                    if (isNaN(valueInMs) || valueInMs === null) {
                        this.filters.release_date_max = null;
                    } else if (valueInMs < this.releaseDateMinValueInMs) {
                        this.filters.release_date_max = this.releaseDateMinValueInMs;
                    } else if (valueInMs > this.releaseDateMaxValueInMs) {
                        this.filters.release_date_max = this.releaseDateMaxValueInMs;
                    } else if (releaseDateMinInMs !== null && valueInMs < releaseDateMinInMs) {
                        this.filters.release_date_max = this.filters.release_date_min;
                    } else {
                        this.filters.release_date_max = value;
                    }
                },
            },

            revenueMin: {
                get() {
                    return this.filters.revenue_min;
                },

                set(value) {
                    this.filters.revenue_min = this.checkInputNumberValue('revenue', value);
                    if (this.filters.revenue_max !== null && this.filters.revenue_min > this.filters.revenue_max) {
                        this.filters.revenue_min = this.filters.revenue_max;
                    }
                },
            },

            revenueMax: {
                get() {
                    return this.filters.revenue_max;
                },

                set(value) {
                    this.filters.revenue_max = this.checkInputNumberValue('revenue', value);
                    if (this.filters.revenue_min !== null && this.filters.revenue_max < this.filters.revenue_min) {
                        this.filters.revenue_max = this.filters.revenue_min;
                    }
                },
            },

            runtimeMin: {
                get() {
                    return this.filters.runtime_min;
                },

                set(value) {
                    this.filters.runtime_min = this.checkInputNumberValue('runtime', value);
                    if (this.filters.runtime_max !== null && this.filters.runtime_min > this.filters.runtime_max) {
                        this.filters.runtime_min = this.filters.runtime_max;
                    }
                },
            },

            runtimeMax: {
                get() {
                    return this.filters.runtime_max;
                },

                set(value) {
                    this.filters.runtime_max = this.checkInputNumberValue('runtime', value);
                    if (this.filters.runtime_min !== null && this.filters.runtime_max < this.filters.runtime_min) {
                        this.filters.runtime_max = this.filters.runtime_min;
                    }
                },
            },

            voteAverageMin: {
                get() {
                    return this.filters.vote_average_min;
                },

                set(value) {
                    this.filters.vote_average_min = this.checkInputNumberValue('vote_average', value);
                    if (this.filters.vote_average_max !== null && this.filters.vote_average_min > this.filters.vote_average_max) {
                        this.filters.vote_average_min = this.filters.vote_average_max;
                    }
                },
            },

            voteAverageMax: {
                get() {
                    return this.filters.vote_average_max;
                },

                set(value) {
                    this.filters.vote_average_max = this.checkInputNumberValue('vote_average', value);
                    if (this.filters.vote_average_min !== null && this.filters.vote_average_max < this.filters.vote_average_min) {
                        this.filters.vote_average_max = this.filters.vote_average_min;
                    }
                },
            },

            voteCountMin: {
                get() {
                    return this.filters.vote_count_min;
                },

                set(value) {
                    this.filters.vote_count_min = this.checkInputNumberValue('vote_count', value);
                    if (this.filters.vote_count_max !== null && this.filters.vote_count_min > this.filters.vote_count_max) {
                        this.filters.vote_count_min = this.filters.vote_count_max;
                    }
                },
            },

            voteCountMax: {
                get() {
                    return this.filters.vote_count_max;
                },

                set(value) {
                    this.filters.vote_count_max = this.checkInputNumberValue('vote_count', value);
                    if (this.filters.vote_count_min !== null && this.filters.vote_count_max < this.filters.vote_count_min) {
                        this.filters.vote_count_max = this.filters.vote_count_min;
                    }
                },
            },

            genres() {
                return this.$store.getters.getGenres;
            },

            languages() {
                return this.$store.getters.getLanguages;
            },

            statuses() {
                return this.$store.getters.getStatuses;
            },

            query() {
                return this.$store.getters.getQuery;
            },
        },

        methods: {
            loadFilters() {
                for (let filterName in this.currentFilters) {
                    if (this.filters.hasOwnProperty(filterName)) {
                        this.filters[filterName] = this.currentFilters[filterName];
                    }
                }
            },

            resetFilters() {
                this.$store.commit('clearAllFilters');
                this.$router.push({ path: this.$route.path, query: this.query })
                    .catch(err => {
                        if (err && err.hasOwnProperty('name') && err.name === 'NavigationDuplicated') {
                            this.$router.go(0); //TODO лучший путь обработки дублирующегося пути
                        }
                    });
            },

            resetRangedFilter(fieldName) {
                const min = fieldName + '_min';
                const max = fieldName + '_max';
                if (this.filters.hasOwnProperty(min) && this.filters.hasOwnProperty(max)) {
                    this.filters[min] = null;
                    this.filters[max] = null;
                }
            },

            applyFilters() {
                this.$store.dispatch('parseQuery', this.filters);
                this.$router.push({ path: this.$route.path, query: this.query })
                    .catch(err => {
                        if (err && err.hasOwnProperty('name') && err.name === 'NavigationDuplicated') {
                            this.$router.go(0);
                        }
                    });
            },

            isNumber(value) {
                return typeof value === 'number' && isFinite(value) && ! isNaN(value);
            },

            checkInputNumberValue(fieldName, value) {
                const minPropName = fieldName + '_min';
                const maxPropName = fieldName + '_max';
                if (! this.isNumber(value) || ! this.filtersRanges.hasOwnProperty(minPropName) || ! this.filtersRanges.hasOwnProperty(maxPropName)) {
                    return null;
                } else if (value < this.filtersRanges[minPropName]) {
                    return this.filtersRanges[minPropName];
                } else if (value > this.filtersRanges[maxPropName]) {
                    return this.filtersRanges[maxPropName];
                } else {
                    return value;
                }
            },

            checkInputDateValue(fieldName, value) {
                const minPropName = fieldName + '_min';
                const maxPropName = fieldName + '_max';
                if (! this.filtersRanges.hasOwnProperty(minPropName) || ! this.filtersRanges.hasOwnProperty(maxPropName)) {
                    return null;
                } else {
                    return value;
                }
            },

            setInputTypeToDate(event) {
                if (event.type !== 'focus' || event.target === null || event.target.tagName !== 'INPUT' || event.target.type === 'date') {
                    return;
                }
                event.target.type = 'date';
            },

            setInputTypeToText(event) {
                if (event.type !== 'blur' || event.target === null || event.target.tagName !== 'INPUT' || event.target.type === 'text') {
                    return;
                }
                event.target.type = 'text';
            },
        },

        watch: {
            $route() {
                this.loadFilters();
            },
        },
    };
</script>

<style scoped>

</style>