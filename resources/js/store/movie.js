export function Movie(data) {
    this.id = null;
    this.adult = null;
    this.belongs_to_collection = null;
    this.budget = null;
    this.genres = null;
    this.homepage = null;
    this.imdb_id = null;
    this.original_language = null;
    this.original_title = null;
    this.overview = null;
    this.popularity = null;
    this.production_companies = null;
    this.production_countries = null;
    this.release_date = null;
    this.revenue = null;
    this.runtime = null;
    this.spoken_languages = null;
    this.status = null;
    this.tagline = null;
    this.title = null;
    this.vote_average = null;
    this.vote_count = null;

    for (let k in data) {
        if (k in this) {
            this[k] = data[k];
        }
    }
}