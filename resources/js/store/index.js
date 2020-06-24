import Vue from 'vue';
import Vuex from 'vuex';
import { Movie } from './movie';

Vue.use(Vuex);

function naturalCompare(a, b) {
    let ax = [],
        bx = [];

    a.replace(/(\d+)|(\D+)/g, function (_, $1, $2) {
        ax.push([$1 || Infinity, $2 || '']);
    });
    b.replace(/(\d+)|(\D+)/g, function (_, $1, $2) {
        bx.push([$1 || Infinity, $2 || '']);
    });

    while (ax.length && bx.length) {
        let an = ax.shift();
        let bn = bx.shift();
        let nn = an[0] - bn[0] || an[1].localeCompare(bn[1]);
        if (nn) return nn;
    }

    return ax.length - bx.length;
}

function isNumber(value) {
    return typeof value === 'number' && isFinite(value) && !isNaN(value);
}

export default new Vuex.Store({
    state: {
        loading: false,
        currentPageNumber: 1, //здесь и далее отсчёт страниц начинается с единицы, читай коммент в запросе
        pageSize: 50,
        availablePageSizes: [0, 25, 50, 100, 250, 500], //доступные "размеры" страниц
        fields: {
            id: { title: 'ID', shown: true, width: 6 },
            title: { title: 'Title', shown: true, width: 12 },
            original_title: { title: 'Original title', shown: true, width: 12 },
            release_date: { title: 'Release date', shown: true, width: 10, sortable: true },
            status: { title: 'Status', shown: true, width: 8, sortable: true },
            production_countries: { title: 'Countries', shown: true, width: 12 },
            tagline: { title: 'Tagline', shown: true, width: 10 },
            genres: { title: 'Genres', shown: true, width: 10 },
            budget: { title: 'Budget', shown: true, width: 8, sortable: true },
            revenue: { title: 'Revenue', shown: true, width: 8, sortable: true },
            adult: { title: 'Adult', shown: true, width: 6 },
            belongs_to_collection: { title: 'Collection', shown: true, width: 12 },
            homepage: { title: 'Homepage', shown: true, width: 8 },
            imdb_id: { title: 'IMDB', shown: true, width: 6, sortable: true },
            original_language: { title: 'Original language', shown: true, width: 12, sortable: true },
            spoken_languages: { title: 'Language', shown: true, width: 12 },
            overview: { title: 'Overview', shown: true, width: 16 },
            production_companies: { title: 'Production Co', shown: true, width: 12 },
            runtime: { title: 'Runtime', shown: true, width: 8, sortable: true },
            popularity: { title: 'Popularity', shown: true, width: 10, sortable: true },
            vote_average: { title: 'Vote average', shown: true, width: 10, sortable: true },
            vote_count: { title: 'Vote count', shown: true, width: 10, sortable: true },
        },
        sortField: null,
        sortOrder: 'asc',
        filters: {
            imdb_id: null, //String - IMDB ID для поиска только одного фильма
            ids: [], //Integer[]
            search: null, //String
            adult: null, //Boolean
            budget_min: null, //Integer
            budget_max: null, //Integer
            genres: [], //String[]
            original_language: null, //String
            popularity_min: null, //Float
            popularity_max: null, //Float
            release_date_min: null, //String - дата в формате YYYY-MM-DD
            release_date_max: null, //String - дата в формате YYYY-MM-DD
            revenue_min: null, //Integer
            revenue_max: null, //Integer
            runtime_min: null, //Float
            runtime_max: null, //Float
            spoken_languages: [], //String[]
            status: null, //String - статус выхода фильма
            vote_average_min: null, //Float
            vote_average_max: null, //Float
            vote_count_min: null, //Integer
            vote_count_max: null, //Integer
        },
        filtersRanges: {
            budget_min: 0,
            budget_max: 999999999,
            popularity_min: 0.0,
            popularity_max: 9999.99,
            release_date_min: '1874-12-09',
            release_date_max: '2174-12-08',
            revenue_min: 1,
            revenue_max: 9999999999,
            runtime_min: 0.01,
            runtime_max: 9999.99,
            vote_average_min: 0.0,
            vote_average_max: 10.0,
            vote_count_min: 0,
            vote_count_max: 9999999999,
        },
        dataSize: 0,
        movies: [],
        collections: [],
        companies: [],
        countries: [],
        genres: [],
        languages: [],
        statuses: [],
    },

    getters: {
        pageCount: (state) => {
            return Math.ceil(state.dataSize / state.pageSize);
        },

        getDisplayedFields: (state) => {
            return Object.keys(state.fields).filter((key) => state.fields[key].shown === true);
        },

        getHiddenFields: (state) => {
            return Object.keys(state.fields).filter((key) => state.fields[key].shown === false);
        },

        getSortableFields: (state) => {
            return Object.keys(state.fields).filter((key) => {
                return state.fields[key].hasOwnProperty('sortable') && state.fields[key].sortable === true;
            });
        },

        isAnyFilterExceptSearch: (state) => {
            for (const filterName in state.filters) {
                if (filterName === 'search') continue;
                if (Array.isArray(state.filters[filterName])) {
                    if (state.filters[filterName].length > 0) return true;
                } else {
                    if (state.filters[filterName] !== null) return true;
                }
            }
            return false;
        },

        getReleaseDateMinValueInMs: (state) => {
            return Date.parse(state.filtersRanges.release_date_min);
        },

        getReleaseDateMaxValueInMs: (state) => {
            return Date.parse(state.filtersRanges.release_date_max);
        },

        getCollections: (state) => {
            return state.collections.sort((a, b) => {
                return naturalCompare(a.name, b.name);
            });
        },

        getCompanies: (state) => {
            return state.companies.sort((a, b) => {
                return naturalCompare(a.name, b.name);
            });
        },

        getCountries: (state) => {
            return state.countries.sort((a, b) => {
                if (a.name < b.name) return -1;
                if (a.name > b.name) return 1;
                return 0;
            });
        },

        getGenres: (state) => {
            return state.genres.sort((a, b) => {
                if (a.name < b.name) return -1;
                if (a.name > b.name) return 1;
                return 0;
            });
        },

        getLanguages: (state) => {
            return state.languages.sort((a, b) => {
                if (a.name < b.name) return -1;
                if (a.name > b.name) return 1;
                return 0;
            });
        },

        getStatuses: (state) => {
            return state.statuses.sort((a, b) => {
                if (a < b) return -1;
                if (a > b) return 1;
                return 0;
            });
        },

        getQuery: (state) => {
            return {
                page: state.currentPageNumber,
                page_size: state.pageSize,
                sort_field: state.sortField || undefined,
                sort_order: state.sortField ? state.sortOrder : undefined,
                imdb_id: state.filters.imdb_id || undefined,
                ids: state.filters.ids.length > 0 ? state.filters.ids : undefined,
                search: state.filters.search || undefined,
                adult: typeof state.filters.adult === 'boolean' ? state.filters.adult : undefined,
                budget_min: isNumber(state.filters.budget_min) ? state.filters.budget_min : undefined,
                budget_max: isNumber(state.filters.budget_max) ? state.filters.budget_max : undefined,
                genres: state.filters.genres.length > 0 ? state.filters.genres : undefined,
                original_language: state.filters.original_language || undefined,
                popularity_min: isNumber(state.filters.popularity_min) ? state.filters.popularity_min : undefined,
                popularity_max: isNumber(state.filters.popularity_max) ? state.filters.popularity_max : undefined,
                release_date_min: state.filters.release_date_min || undefined,
                release_date_max: state.filters.release_date_max || undefined,
                revenue_min: isNumber(state.filters.revenue_min) ? state.filters.revenue_min : undefined,
                revenue_max: isNumber(state.filters.revenue_max) ? state.filters.revenue_max : undefined,
                runtime_min: isNumber(state.filters.runtime_min) ? state.filters.runtime_min : undefined,
                runtime_max: isNumber(state.filters.runtime_max) ? state.filters.runtime_max : undefined,
                spoken_languages:
                    state.filters.spoken_languages.length > 0 ? state.filters.spoken_languages : undefined,
                status: state.filters.status || undefined,
                vote_average_min: isNumber(state.filters.vote_average_min) ? state.filters.vote_average_min : undefined,
                vote_average_max: isNumber(state.filters.vote_average_max) ? state.filters.vote_average_max : undefined,
                vote_count_min: isNumber(state.filters.vote_count_min) ? state.filters.vote_count_min : undefined,
                vote_count_max: isNumber(state.filters.vote_count_max) ? state.filters.vote_count_max : undefined,
            };
        },
    },

    mutations: {
        setLoading(state, status) {
            state.loading = status;
        },

        setCurrentPageNumber(state, pageNumber) {
            state.currentPageNumber = pageNumber;
        },

        setPageSize(state, size) {
            state.pageSize = size;
        },

        showField(state, fieldName) {
            if (state.fields.hasOwnProperty(fieldName)) {
                state.fields[fieldName].shown = true;
            }
        },

        hideField(state, fieldName) {
            if (state.fields.hasOwnProperty(fieldName)) {
                state.fields[fieldName].shown = false;
            }
        },

        setSortField(state, field) {
            state.sortField = field;
        },

        clearSortField(state) {
            state.sortField = null;
        },

        setSortOrder(state, order) {
            if (order === 'asc' || order === 'desc') {
                state.sortOrder = order;
            }
        },

        setFilter(state, payload) {
            if (state.filters.hasOwnProperty(payload.filter)) {
                state.filters[payload.filter] = payload.value;
            }
        },

        clearFilter(state, filter) {
            if (state.filters.hasOwnProperty(filter)) {
                if (Array.isArray(state.filters[filter])) {
                    state.filters[filter] = [];
                } else {
                    state.filters[filter] = null;
                }
            }
        },

        clearAllFilters(state) {
            for (let filter in state.filters) {
                if (state.filters.hasOwnProperty(filter)) {
                    if (Array.isArray(state.filters[filter])) {
                        state.filters[filter] = [];
                    } else {
                        state.filters[filter] = null;
                    }
                }
            }
        },

        addIdToFilter(state, id) {
            state.filters.ids.push(id);
        },

        removeIdFromFilter(state, id) {
            let index = state.filters.ids.indexOf(id);
            if (index > -1) {
                state.filters.ids.splice(index, 1);
            }
        },

        clearIdsFromFilter(state) {
            state.filters.ids = [];
        },

        setDataSize(state, size) {
            state.dataSize = size;
        },

        addMovie(state, movie) {
            state.movies.push(new Movie(movie));
        },

        clearMovies(state) {
            state.movies = [];
        },

        addCollection(state, collection) {
            state.collections.push(collection);
        },

        addCompany(state, company) {
            state.companies.push(company);
        },

        addCountry(state, country) {
            state.countries.push(country);
        },

        addGenre(state, genre) {
            state.genres.push(genre);
        },

        addLanguage(state, language) {
            state.languages.push(language);
        },

        addStatus(state, status) {
            state.statuses.push(status);
        },
    },

    actions: {
        parseQuery({ commit, state, getters }, query = {}) {
            let pageNumber = query.page ? parseInt(query.page, 10) : state.currentPageNumber;
            if (isNaN(pageNumber) || pageNumber < 1) {
                pageNumber = state.currentPageNumber;
            }
            if (pageNumber !== state.currentPageNumber) {
                commit('setCurrentPageNumber', pageNumber);
            }

            let pageSize = query.page_size ? parseInt(query.page_size, 10) : state.pageSize;
            if (isNaN(pageSize) || state.availablePageSizes.indexOf(pageSize) === -1) {
                pageSize = state.pageSize;
            }
            if (pageSize !== state.pageSize) {
                commit('setPageSize', pageSize);
            }

            let sortField = query.sort_field || null;
            if (
                typeof sortField === 'string' &&
                sortField.length > 0 &&
                getters.getSortableFields.indexOf(sortField) === -1
            ) {
                sortField = null;
            }
            if (sortField !== state.sortField) {
                if (sortField === null) {
                    commit('clearSortField');
                } else {
                    commit('setSortField', sortField);
                }
            }

            let sortOrder = query.sort_order || null;
            if (sortOrder !== 'asc' && sortOrder !== 'desc') {
                sortOrder = 'asc';
            }
            if (sortOrder !== state.sortOrder) {
                commit('setSortOrder', sortOrder);
            }

            let imdbId = query.imdb_id || null;
            if (imdbId !== state.filters.imdb_id) {
                commit('setFilter', { filter: 'imdb_id', value: imdbId });
            }

            let ids = query.ids ? (Array.isArray(query.ids) ? query.ids : [query.ids]) : [];
            for (let id of ids) {
                id = parseInt(id, 10);
                if (!isNaN(id) && state.filters.ids.indexOf(id) === -1) {
                    commit('addIdToFilter', id);
                }
            }

            let search = query.search || null;
            if (search !== state.filters.search) {
                commit('setFilter', { filter: 'search', value: search });
            }

            let adult = query.adult;
            if (typeof adult === 'string') {
                if (adult === 'true') {
                    adult = true;
                } else if (adult === 'false') {
                    adult = false;
                } else {
                    adult = null;
                }
            } else if (adult === undefined) {
                adult = null;
            }
            if (adult !== state.filters.adult) {
                commit('setFilter', { filter: 'adult', value: adult });
            }

            let budgetMin = query.budget_min ? parseInt(query.budget_min, 10) : NaN;
            if (
                isNaN(budgetMin) ||
                budgetMin < state.filtersRanges.budget_min ||
                budgetMin > state.filtersRanges.budget_max
            ) {
                budgetMin = null;
            }
            if (budgetMin !== state.filters.budget_min) {
                commit('setFilter', { filter: 'budget_min', value: budgetMin });
            }

            let budgetMax = query.budget_max ? parseInt(query.budget_max, 10) : NaN;
            if (
                isNaN(budgetMax) ||
                budgetMax < state.filtersRanges.budget_min ||
                budgetMax > state.filtersRanges.budget_max ||
                (budgetMin !== null && budgetMax < budgetMin)
            ) {
                budgetMax = null;
            }
            if (budgetMax !== state.filters.budget_max) {
                commit('setFilter', { filter: 'budget_max', value: budgetMax });
            }

            let genres = query.genres ? (Array.isArray(query.genres) ? query.genres : [query.genres]) : [];
            commit('setFilter', { filter: 'genres', value: genres });

            let originalLanguage = query.original_language || null;
            if (originalLanguage !== state.filters.original_language) {
                commit('setFilter', { filter: 'original_language', value: originalLanguage });
            }

            let popularityMin = query.popularity_min ? parseFloat(query.popularity_min) : NaN;
            if (
                !isFinite(popularityMin) ||
                popularityMin < state.filtersRanges.popularity_min ||
                popularityMin > state.filtersRanges.popularity_max
            ) {
                popularityMin = null;
            }
            if (popularityMin !== state.filters.popularity_min) {
                commit('setFilter', { filter: 'popularity_min', value: popularityMin });
            }

            let popularityMax = query.popularity_max ? parseFloat(query.popularity_max) : NaN;
            if (
                !isFinite(popularityMax) ||
                popularityMax < state.filtersRanges.popularity_min ||
                popularityMax > state.filtersRanges.popularity_max ||
                (popularityMin !== null && popularityMax < popularityMin)
            ) {
                popularityMax = null;
            }
            if (popularityMax !== state.filters.popularity_max) {
                commit('setFilter', { filter: 'popularity_max', value: popularityMax });
            }

            const releaseDateMinInMs = getters.getReleaseDateMinValueInMs;
            const releaseDateMaxInMs = getters.getReleaseDateMaxValueInMs;

            let releaseDateMin = query.release_date_min ? Date.parse(query.release_date_min) : NaN;
            if (isNaN(releaseDateMin) || releaseDateMin < releaseDateMinInMs || releaseDateMin > releaseDateMaxInMs) {
                releaseDateMin = null;
            } else {
                let date = new Date(releaseDateMin);
                releaseDateMin = date.toISOString().slice(0, 10);
            }
            if (releaseDateMin !== state.filters.release_date_min) {
                commit('setFilter', { filter: 'release_date_min', value: releaseDateMin });
            }

            let releaseDateMax = query.release_date_max ? Date.parse(query.release_date_max) : NaN;
            if (isNaN(releaseDateMax) || releaseDateMax < releaseDateMinInMs || releaseDateMax > releaseDateMaxInMs) {
                releaseDateMax = null;
            } else {
                let date = new Date(releaseDateMax);
                releaseDateMax = date.toISOString().slice(0, 10);
            }
            if (releaseDateMax !== state.filters.release_date_max) {
                commit('setFilter', { filter: 'release_date_max', value: releaseDateMax });
            }

            let revenueMin = query.revenue_min ? parseInt(query.revenue_min) : NaN;
            if (
                isNaN(revenueMin) ||
                revenueMin < state.filtersRanges.revenue_min ||
                revenueMin > state.filtersRanges.revenue_max
            ) {
                revenueMin = null;
            }
            if (revenueMin !== state.filters.revenue_min) {
                commit('setFilter', { filter: 'revenue_min', value: revenueMin });
            }

            let revenueMax = query.revenue_max ? parseInt(query.revenue_max) : NaN;
            if (
                isNaN(revenueMax) ||
                revenueMax < state.filtersRanges.revenue_min ||
                revenueMax > state.filtersRanges.revenue_max ||
                (revenueMin !== null && revenueMax < revenueMin)
            ) {
                revenueMax = null;
            }
            if (revenueMax !== state.filters.revenue_max) {
                commit('setFilter', { filter: 'revenue_max', value: revenueMax });
            }

            let runtimeMin = query.runtime_min ? parseFloat(query.runtime_min) : NaN;
            if (
                !isFinite(runtimeMin) ||
                runtimeMin < state.filtersRanges.runtime_min ||
                runtimeMin > state.filtersRanges.runtime_max
            ) {
                runtimeMin = null;
            }
            if (runtimeMin !== state.filters.runtime_min) {
                commit('setFilter', { filter: 'runtime_min', value: runtimeMin });
            }

            let runtimeMax = query.runtime_max ? parseFloat(query.runtime_max) : NaN;
            if (
                !isFinite(runtimeMax) ||
                runtimeMax < state.filtersRanges.runtime_min ||
                runtimeMax > state.filtersRanges.runtime_max ||
                (runtimeMin !== null && runtimeMax < runtimeMin)
            ) {
                runtimeMax = null;
            }
            if (runtimeMax !== state.filters.runtime_max) {
                commit('setFilter', { filter: 'runtime_max', value: runtimeMax });
            }

            let spokenLanguages = query.spoken_languages
                ? Array.isArray(query.spoken_languages)
                    ? query.spoken_languages
                    : [query.spoken_languages]
                : [];
            commit('setFilter', { filter: 'spoken_languages', value: spokenLanguages });

            let status = query.status ? query.status : null;
            if (status !== state.filters.status) {
                commit('setFilter', { filter: 'status', value: status });
            }

            let voteAverageMin = query.vote_average_min ? parseFloat(query.vote_average_min) : NaN;
            if (
                !isFinite(voteAverageMin) ||
                voteAverageMin < state.filtersRanges.vote_average_min ||
                voteAverageMin > state.filtersRanges.vote_average_max
            ) {
                voteAverageMin = null;
            }
            if (voteAverageMin !== state.filters.vote_average_min) {
                commit('setFilter', { filter: 'vote_average_min', value: voteAverageMin });
            }

            let voteAverageMax = query.vote_average_max ? parseFloat(query.vote_average_max) : NaN;
            if (
                !isFinite(voteAverageMax) ||
                voteAverageMax < state.filtersRanges.vote_average_min ||
                voteAverageMax > state.filtersRanges.vote_average_max ||
                (voteAverageMin !== null && voteAverageMax < voteAverageMin)
            ) {
                voteAverageMax = null;
            }
            if (voteAverageMax !== state.filters.vote_average_max) {
                commit('setFilter', { filter: 'vote_average_max', value: voteAverageMax });
            }

            let voteCountMin = query.vote_count_min ? parseInt(query.vote_count_min, 10) : NaN;
            if (
                isNaN(voteCountMin) ||
                voteCountMin < state.filtersRanges.vote_count_min ||
                voteCountMin > state.filtersRanges.vote_count_max
            ) {
                voteCountMin = null;
            }
            if (voteCountMin !== state.filters.vote_count_min) {
                commit('setFilter', { filter: 'vote_count_min', value: voteCountMin });
            }

            let voteCountMax = query.vote_count_max ? parseInt(query.vote_count_max, 10) : NaN;
            if (
                isNaN(voteCountMax) ||
                voteCountMax < state.filtersRanges.vote_count_min ||
                voteCountMax > state.filtersRanges.vote_count_max ||
                (voteCountMin !== null && voteCountMax < voteCountMin)
            ) {
                voteCountMax = null;
            }
            if (voteCountMax !== state.filters.vote_count_max) {
                commit('setFilter', { filter: 'vote_count_max', value: voteCountMax });
            }
        },

        loadMovies({ commit, state, dispatch }, query) {
            return new Promise((resolve, reject) => {
                if (state.movies.length > 0) {
                    commit('clearMovies');
                }

                dispatch('loadData', query)
                    .then((response) => {
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },

        loadData({ commit, state }, query) {
            return new Promise((resolve, reject) => {
                commit('setLoading', true);

                window.axios
                    .post('/list', {
                        ...query,
                        page: (query.page ? query.page : state.currentPageNumber) - 1, //перед отправкой запроса причёсываем нумерацию
                        page_size: query.page_size ? query.page_size : state.pageSize, //чтобы случайно не загрузить всю базу
                    })
                    .then((response) => {
                        console.log(response.data); //TODO удалить

                        const data = response.data;

                        if (!data.hasOwnProperty('ok') || data.ok !== true) {
                            throw new Error('Response is not ok =((');
                        }

                        if (!data.hasOwnProperty('data_size') || data.data_size === 0) {
                            throw new Error('Data size is 0');
                        }

                        if (data.data_size !== state.dataSize) {
                            commit('setDataSize', data.data_size);
                        }

                        const movies = data.hasOwnProperty('data') ? data.data : [];

                        for (let movie of movies) {
                            if (movie.belongs_to_collection !== null) {
                                if (
                                    state.collections.find((e) => e.id === movie.belongs_to_collection.id) === undefined
                                ) {
                                    commit('addCollection', movie.belongs_to_collection);
                                }
                            }

                            if (movie.production_companies !== null) {
                                for (let company of movie.production_companies) {
                                    if (state.companies.find((e) => e.id === company.id) === undefined) {
                                        commit('addCompany', company);
                                    }
                                }
                            }

                            if (movie.production_countries !== null) {
                                for (let country of movie.production_countries) {
                                    if (
                                        state.countries.find((e) => e.iso_3166_1 === country.iso_3166_1) === undefined
                                    ) {
                                        commit('addCountry', country);
                                    }
                                }
                            }

                            if (movie.genres !== null) {
                                for (let genre of movie.genres) {
                                    if (state.genres.find((e) => e.id === genre.id) === undefined) {
                                        commit('addGenre', genre);
                                    }
                                }
                            }

                            if (movie.spoken_languages !== null) {
                                for (let language of movie.spoken_languages) {
                                    if (state.languages.find((e) => e.iso_639_1 === language.iso_639_1) === undefined) {
                                        commit('addLanguage', language);
                                    }
                                }
                            }

                            if (movie.status !== null && state.statuses.indexOf(movie.status) === -1) {
                                commit('addStatus', movie.status);
                            }

                            commit('addMovie', movie);
                        }

                        resolve(data.data_size);
                    })
                    .catch((error) => {
                        reject(error); //TODO обработка ошибки загрузки
                    })
                    .finally(() => {
                        commit('setLoading', false);
                    });
            });
        },
    },

    modules: {},
});
