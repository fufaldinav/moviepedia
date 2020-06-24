<template>
    <li
        v-if="shown"
        class="nav-item dropdown"
    >
        <a
            id="pageSizeDropdown"
            class="nav-link dropdown-toggle"
            :class="{ 'disabled': loading }"
            role="button"
            href="#"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        >
            {{ pageSize === 0 ? 'Scroll mode' : `Page size: ${pageSize}` }}
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pageSizeDropdown">
            <a
                v-for="size of availablePageSizes"
                v-if="size > 0"
                :key="`page_size_${size}`"
                href="#"
                class="dropdown-item"
                :class="{ 'text-primary disabled': size === pageSize }"
                @click.prevent="setPageSize(size)"
            >
                {{ size }}
            </a>
            <div class="dropdown-divider"></div>
            <a
                href="#"
                class="dropdown-item"
                :class="{ 'text-primary disabled': pageSize === 0 }"
                @click.prevent="setPageSize(0)"
            >
                Scroll mode:
                <span
                    v-if="pageSize === 0"
                    class="text-success"
                >
                    On
                </span>
                <span
                    v-else
                    class="text-danger"
                >
                    Off
                </span>
            </a>
        </div>
    </li>
</template>

<script>

    export default {
        name: 'AppTablePageSizeMenu',

        data() {
            return {
                shown: true,
            };
        },

        computed: {
            loading() {
                return this.$store.state.loading;
            },

            pageSize() {
                return this.$store.state.pageSize;
            },

            availablePageSizes() {
                return this.$store.state.availablePageSizes;
            },
        },

        methods: {
            setPageSize(size) {
                this.$router.push({ path: this.$route.path, query: { ...this.$route.query, page_size: size } });
            },
        },

        watch: {
            $route(to) {
                this.shown = to.name === 'table';
            },
        },
    };
</script>

<style scoped>

</style>