<template>
    <DataTable
        :value="records"
        :total-records="totalRecords"
        :loading="loading"
        :lazy="true"
        :paginator="true"
        :rows="limit"
        paginator-template="RowsPerPageDropdown FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink"
        currentPageReportTemplate="{first} to {last} of {totalRecords}"
        showGridLines
        stripedRows
        @page="reloadParams($event)"
        @sort="reloadParams($event)"
    >
        <Column
            v-for="col in columns.filter(column => !column.disabled)"
            :key="col.field"
            :header="col.header"
            :field="col.field"
            :sortable="col.sortable"
            class="max-md:block"
        >
            <template v-if="col.boolean" #body="slotProps">
                {{ getNestedValue(slotProps.data, col.field) ? 'Yes' : 'No' }}
            </template>

            <template v-if="col.type === 'actions'" #body="slotProps">
                <div v-for="item in col.items(slotProps)">
                    <app-action-button v-bind="item" />
                </div>
            </template>

            <template v-if="col.type === 'image'" #body="slotProps">
                <div>
                    <img class="h-30" :src="backendUrl + '/storage/files/' + slotProps.data.path + slotProps.data.name" />
                </div>
            </template>
        </Column>
    
    </DataTable>
</template>

<script>
import { Column, DataTable } from 'primevue';

export default {
    components: {DataTable, Column},

    props: {
        columns: Array,
        url: String,
        defaultSort: String,
        filters: Object,
    },

    data() {
        return {
            backendUrl: import.meta.env.VITE_BACKEND_URL,
            totalRecords: 0,
            records: [],
            loading: false,
            loadParams: [],
            limit: 0,
        }
    },

    created() {
        this.loadData();
    },

    methods: {
        /**
         * Fetches for the necesarry data
         */
        loadData() {
            this.loading = true;

            this.$http
                .get(this.url, {
                    params: {
                        page: (this.loadParams?.page || 0) + 1,
                        sort: this.loadParams?.sortField
                                ? (this.loadParams.sortOrder < 0 ? '-' : '') + this.loadParams.sortField
                                : this.defaultSort,
                        ...this.filters
                    },
                })
                .then(({data}) => {
                    this.records = data?.data;
                    this.totalRecords = data?.meta?.total ?? 0;
                    this.limit = data?.meta?.per_page || 15;  
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        /**
         * Reloads params for the url and loads data based on them
         * 
         * @param event
         */
        reloadParams(event) {
            this.loadParams = event;
            this.loadData();
        },

        /**
         * Returns the nested property from an object
         * 
         * @param obj 
         * @param path 
         */
        getNestedValue(obj, path) {
            return path.split('.').reduce((acc, part) => acc[part], obj);
        },
    },
}
</script>