<template>
    <li
        v-if="shown"
        class="nav-item dropdown"
    >
        <a
            id="fieldsDropdown"
            class="nav-link dropdown-toggle"
            :class="fieldsLinkClass"
            role="button"
            href="#"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
        >
            Fields
            <fa :icon="hasHiddenFields ? eyeSlashIcon : eyeIcon"/>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="fieldsDropdown">
            <a
                v-for="(field, fieldName) in fields"
                :key="`hidden_field_${fieldName}`"
                class="dropdown-item d-flex"
                href="#"
                @click.prevent.stop="toggleField(fieldName)"
            >
                        <span class="mr-auto">
                            {{ field.title }}
                        </span>
                <span
                    class="ml-2"
                    :class="field.shown ? 'text-success' : 'text-danger'"
                >
                            <fa :icon="field.shown ? eyeIcon : eyeSlashIcon"/>
                        </span>
            </a>
            <template v-if="hasHiddenFields">
                <div class="dropdown-divider"></div>
                <a
                    class="dropdown-item"
                    href="#"
                    @click.prevent="showAllFields()"
                >
                    Show all
                </a>
            </template>
        </div>
    </li>
</template>

<script>
    import {faEye, faEyeSlash} from '@fortawesome/free-solid-svg-icons';

    export default {
        name: 'AppTableFieldsTogglerMenu',

        data() {
            return {
                shown: true,
            };
        },

        computed: {
            eyeIcon() {
                return faEye;
            },

            eyeSlashIcon() {
                return faEyeSlash;
            },

            loading() {
                return this.$store.state.loading;
            },

            fields() {
                return this.$store.state.fields;
            },

            hiddenFields() {
                return this.$store.getters.getHiddenFields;
            },

            hasHiddenFields() {
                return this.hiddenFields.length > 0;
            },

            fieldsLinkClass() {
                return {
                    'text-danger': this.hasHiddenFields,
                    'disabled': this.loading,
                };
            },
        },

        methods: {
            toggleField(fieldName) {
                if (this.fields[fieldName].shown) {
                    this.$store.commit('hideField', fieldName);
                } else {
                    this.$store.commit('showField', fieldName);
                }
            },

            showAllFields() {
                for (let fieldName of this.hiddenFields) {
                    if (! this.fields[fieldName].shown) {
                        this.$store.commit('showField', fieldName);
                    }
                }
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