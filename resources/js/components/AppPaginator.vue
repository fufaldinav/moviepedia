<template>
    <div
        v-if="shown && pageCount > 0 && pageSize === 0"
        class="btn-group mb-0 bg-light rounded shadow app-paginator"
        role="group"
        aria-label="Pagination"
    >
        <button
            type="button"
            class="btn btn-light border d-md-none"
            :disabled="isFirstPage || loading"
            @click="firstPage"
        >
            <fa :icon="angleDoubleLeftIcon"/>
        </button>
        <button
            type="button"
            class="btn btn-light border"
            :disabled="isFirstPage || loading"
            @click="prevPage"
        >
            <fa :icon="angleLeftIcon"/>
        </button>
        <template
            v-for="page in items"
        >
            <div
                v-if="page.active"
                :key="`page_item_${page.label}`"
                class="btn-group"
                role="group"
            >
                <button
                    id="pageManualSelect"
                    type="button"
                    class="btn btn-primary border dropdown-toggle app-paginator-current-page-button"
                    :disabled="loading"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    {{ page.label }}
                </button>
                <div class="dropdown-menu p-3 app-paginator-page-selector" aria-labelledby="pageManualSelect">
                    <div class="form-group">
                        <label for="pageNumberForm">Choose page:</label>
                        <div class="input-group">
                            <input
                                id="pageNumberForm"
                                type="number"
                                class="form-control"
                                min="1"
                                :max="pageCount"
                                :placeholder="currentPageNumber"
                                v-model.number="pageInputFormData"
                            >
                            <div class="input-group-append">
                                <span class="input-group-text">of {{ pageCount }}</span>
                            </div>
                        </div>
                    </div>
                    <button
                        type="button"
                        class="btn btn-primary border"
                        :disabled="pageInputFormData === currentPageNumber || pageInputFormData < 1 || pageInputFormData > pageCount"
                        @click="changePage(pageInputFormData)"
                    >
                        Let's go
                    </button>
                </div>
            </div>
            <button
                v-else-if="page.disable"
                :key="`page_item_${page.label}`"
                type="button"
                class="btn btn-light border d-none d-md-block"
                disabled
            >
                ...
            </button>
            <button
                v-else
                :key="`page_item_${page.label}`"
                type="button"
                class="btn btn-light border d-none d-md-block"
                :disabled="loading"
                @click="changePage(page.label)"
            >
                {{ page.label }}
            </button>
        </template>
        <button
            class="btn btn-light border"
            :disabled="isLastPage || loading"
            @click.prevent="nextPage"
        >
            <fa :icon="angleRightIcon"/>
        </button>
        <button
            class="btn btn-light border d-md-none"
            :disabled="isLastPage || loading"
            @click.prevent="lastPage"
        >
            <fa :icon="angleDoubleRightIcon"/>
        </button>
    </div>
</template>

<script>
    import {faAngleLeft, faAngleRight, faAngleDoubleLeft, faAngleDoubleRight} from '@fortawesome/free-solid-svg-icons';

    export default {
        name: 'AppPaginator',

        data() {
            return {
                shown: true,
                pageInputFormData: 1,
            };
        },

        computed: {
            angleLeftIcon() {
                return faAngleLeft;
            },

            angleRightIcon() {
                return faAngleRight;
            },

            angleDoubleLeftIcon() {
                return faAngleDoubleLeft;
            },

            angleDoubleRightIcon() {
                return faAngleDoubleRight;
            },

            loading() {
                return this.$store.state.loading;
            },

            pageSize() {
                return this.$store.state.pageSize;
            },

            pageCount() {
                return this.$store.getters.pageCount;
            },

            currentPageNumber() {
                return this.$store.state.currentPageNumber;
            },

            isFirstPage() {
                return this.currentPageNumber === 1;
            },

            isLastPage() {
                return this.currentPageNumber === this.pageCount;
            },

            items() {
                let output = [];

                if (this.pageCount < 8) {
                    for (let i = 1; i <= this.pageCount; i++) {
                        output.push({
                            label: i,
                            active: this.currentPageNumber === i,
                        });
                    }

                    return output;
                }

                let valPrev = this.currentPageNumber < 3 ? (this.pageCount - 1) : (this.currentPageNumber - 1);
                let valNext = this.currentPageNumber > (this.pageCount - 2) ? 2 : (this.currentPageNumber + 1);
                let extraPrev = (this.currentPageNumber >= 4 && this.currentPageNumber < (this.pageCount - 3)) ? null : (this.isLastPage || this.currentPageNumber < 3) ? (this.pageCount - 2) : (this.pageCount - 1);
                let extraNext = (this.currentPageNumber >= 3 && this.currentPageNumber < (this.pageCount - 2)) ? null : (this.isFirstPage || this.currentPageNumber > (this.pageCount - 2)) ? 3 : 2;
                let dotsBefore = (this.currentPageNumber > 3 && this.currentPageNumber < (this.pageCount - 2)) ? (valPrev - 1) : null;
                let dotsAfter = (this.currentPageNumber > 1 && this.currentPageNumber < (this.pageCount - 2)) ? (valNext + 1) : (extraNext + 1);

                for (let i = 1; i <= this.pageCount; i++) {
                    if ([1, this.pageCount, this.currentPageNumber, valPrev, valNext, extraPrev, extraNext, dotsBefore, dotsAfter].includes(i)) {
                        output.push({
                            label: i,
                            active: this.currentPageNumber === i,
                            disable: [dotsBefore, dotsAfter].includes(i),
                        });
                    }
                }

                return output;
            },
        },

        methods: {
            changePage(pageNumber) {
                this.$router.push({ path: this.$route.path, query: { ...this.$route.query, page: pageNumber } });
            },

            prevPage() {
                let pageNumber = this.currentPageNumber > 1 ? this.currentPageNumber - 1 : 1;
                this.changePage(pageNumber);
            },

            nextPage() {
                let pageNumber = this.currentPageNumber < this.pageCount ? this.currentPageNumber + 1 : this.pageCount;
                this.changePage(pageNumber);
            },

            firstPage() {
                this.changePage(1);
            },

            lastPage() {
                this.changePage(this.pageCount);
            },
        },

        watch: {
            $route(to) {
                this.shown = to.name === 'table';
                this.pageInputFormData = this.currentPageNumber;
            },
        },
    };
</script>

<style scoped>

</style>