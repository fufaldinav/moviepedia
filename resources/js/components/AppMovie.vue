<template>
    <tr>
        <th scope="row">
            <div class="text-truncate app-table-cell-wrapper">
                {{ number }}
            </div>
        </th>
        <td
            v-show="displayedFields.indexOf('id') > -1"
            headers="id"
            :title="movie.id"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ movie.id }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('title') > -1"
            headers="title"
            :title="title"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ title }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('original_title') > -1"
            headers="original_title"
            :title="originalTitle"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ originalTitle }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('release_date') > -1"
            headers="release_date"
            :title="releaseDateFormatted"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ releaseDateFormatted }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('status') > -1"
            headers="status"
            :title="status"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ status }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('production_countries') > -1"
            headers="production_countries"
            :title="productionCountries"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ productionCountries }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('tagline') > -1"
            headers="tagline"
            :title="tagline"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ tagline }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('genres') > -1"
            headers="genres"
            :title="genres"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ genres }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('budget') > -1"
            headers="budget"
            :title="budgetFormatted"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ budgetFormatted }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('revenue') > -1"
            headers="revenue"
            :title="revenueFormatted"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ revenueFormatted }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('adult') > -1"
            headers="adult"
            :title="adult"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ adult }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('belongs_to_collection') > -1"
            headers="belongs_to_collection"
            :title="collection"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ collection }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('homepage') > -1"
            headers="homepage"
            title="Internet movie homepage"
        >
            <div class="text-truncate app-table-cell-wrapper">
                <a
                    v-if="movie.homepage !== null"
                    :href="movie.homepage"
                    target="_blank"
                >link</a>
                <span v-else>N/A</span>
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('imdb_id') > -1"
            headers="imdb_id"
            title="Homepage of the movie on the IMDB website"
        >
            <div class="text-truncate app-table-cell-wrapper">
                <a
                    v-if="movie.imdb_id !== null"
                    :href="`http://www.imdb.com/title/${movie.imdb_id}/`"
                    target="_blank"
                >IMDB</a>
                <span v-else>N/A</span>
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('original_language') > -1"
            headers="original_language"
            :title="originalLanguage"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ originalLanguage }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('spoken_languages') > -1"
            headers="spoken_languages"
            :title="spokenLanguages"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ spokenLanguages }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('overview') > -1"
            headers="overview"
            :title="overview"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ overview }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('production_companies') > -1"
            headers="production_companies"
            :title="productionCompanies"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ productionCompanies }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('runtime') > -1"
            headers="runtime"
            :title="runtimeFormatted"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ runtimeFormatted }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('popularity') > -1"
            headers="popularity"
            :title="popularity"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ popularityShort }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('vote_average') > -1"
            headers="vote_average"
            :title="voteAverage"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ voteAverageShort }}
            </div>
        </td>
        <td
            v-show="displayedFields.indexOf('vote_count') > -1"
            headers="vote_count"
            :title="voteCount"
        >
            <div class="text-truncate app-table-cell-wrapper">
                {{ voteCount }}
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        name: 'AppMovie',

        props: {
            number: {
                type: Number,
                required: true,
            },
            movie: {
                type: Object,
                required: true,
            },
        },

        computed: {
            displayedFields() {
                return this.$store.getters.getDisplayedFields;
            },

            title() {
                return this.movie.title || 'N/A';
            },

            originalTitle() {
                return this.movie.original_title || 'N/A';
            },

            releaseDateFormatted() {
                if (this.movie.release_date === null) return 'N/A';
                return new Date(this.movie.release_date).toLocaleString(document.documentElement.lang, {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric',
                });
            },

            status() {
                return this.movie.status || 'N/A';
            },

            productionCountries() {
                if (this.movie.production_countries === null || this.movie.production_countries.length === 0) return 'N/A';
                let countries = '';
                for (let i = 0; i < this.movie.production_countries.length; i++) {
                    countries += this.movie.production_countries[i].name;
                    if (i < this.movie.production_countries.length - 1) {
                        countries += ', ';
                    }
                }
                return countries;
            },

            tagline() {
                return this.movie.tagline || 'N/A';
            },

            genres() {
                if (this.movie.genres === null || this.movie.genres.length === 0) return 'N/A';
                let genres = '';
                for (let i = 0; i < this.movie.genres.length; i++) {
                    genres += this.movie.genres[i].name;
                    if (i < this.movie.genres.length - 1) {
                        genres += ', ';
                    }
                }
                return genres;
            },

            budgetFormatted() {
                if (this.movie.budget === null) return 'N/A';
                return `\$${this.formatNumber(this.movie.budget)}`;
            },

            revenueFormatted() {
                if (this.movie.revenue === null) return 'N/A';
                return `\$${this.formatNumber(this.movie.revenue)}`;
            },

            adult() {
                return this.movie.adult ? 'Yes' : 'No';
            },

            collection() {
                return this.movie.belongs_to_collection ? this.movie.belongs_to_collection.name : 'N/A'
            },

            originalLanguage() {
                if (this.movie.original_language === null) return null;
                let lang = this.$store.state.languages.find(lang => lang.iso_639_1 === this.movie.original_language);
                if (lang === undefined) return this.movie.original_language;
                return lang.name;
            },

            spokenLanguages() {
                if (this.movie.spoken_languages === null || this.movie.spoken_languages.length === 0) return 'N/A';
                let languages = '';
                for (let i = 0; i < this.movie.spoken_languages.length; i++) {
                    languages += this.movie.spoken_languages[i].name;
                    if (i < this.movie.spoken_languages.length - 1) {
                        languages += ', ';
                    }
                }
                return languages;
            },

            overview() {
                return this.movie.overview || 'N/A';
            },

            productionCompanies() {
                if (this.movie.production_companies === null || this.movie.production_companies.length === 0) return 'N/A';
                let companies = '';
                for (let i = 0; i < this.movie.production_companies.length; i++) {
                    companies += this.movie.production_companies[i].name;
                    if (i < this.movie.production_companies.length - 1) {
                        companies += ', ';
                    }
                }
                return companies;
            },

            runtimeFormatted() {
                let result = 'N/A';
                if (this.movie.runtime === null) return result;

                const minutes = Math.floor(this.movie.runtime % 60);
                result = `${minutes}min`;

                const hours = Math.floor(this.movie.runtime / 60);
                if (hours > 0) {
                    result = `${hours}h ` + result;
                }

                const secs = Math.round((this.movie.runtime % 1) * 60);
                if (secs > 0) {
                    result += ` ${secs}sec`;
                }

                return result;
            },

            popularity() {
                if (this.movie.popularity === null) return 'N/A';
                return this.movie.popularity;
            },

            popularityShort() {
                if (this.movie.popularity === null) return 'N/A';
                return this.movie.popularity.toFixed(2);
            },

            voteAverage() {
                if (this.movie.vote_average === null) return 'N/A';
                return this.movie.vote_average;
            },

            voteAverageShort() {
                if (this.movie.vote_average === null) return 'N/A';
                return this.movie.vote_average.toFixed(1);
            },

            voteCount() {
                return this.movie.vote_count || 'N/A';
            },
        },

        methods: {
            formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            },

            filter(field, argument) { //TODO доделать!
                let filter = {};
                filter[field] = argument;
                this.$router.push({ path: this.$route.path, query: { ...this.$route.query, ...filter } });
            },
        },
    };
</script>

<style scoped>

</style>