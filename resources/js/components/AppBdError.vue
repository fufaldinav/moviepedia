<template>
    <div class="d-flex flex-row align-items-center h-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <span class="display-1 d-block">Error</span>
                    <div class="mb-4 lead">Something was wrong.</div>
                    <template v-if="fromPath !== null">
                        <router-link :to="fromPath">Go back</router-link>
                        or
                        <router-link to="/">reset filters</router-link>
                    </template>
                    <template v-else>
                        <router-link to="/">Go to Home</router-link>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'AppBdError',

        data() {
            return {
                fromPath: null,
            };
        },

        beforeRouteEnter(to, from, next) {
            if (from.name !== 'table') {
                next('/');
            } else if (typeof from.query.page === 'number') { //TODO найти "павильный" способ вычислять переход по внешним ссылкам
                next(vm => vm.fromPath = from.fullPath);
            } else {
                next();
            }
        },
    };
</script>

<style scoped>

</style>