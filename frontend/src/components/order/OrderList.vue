<template>
    <app-pannel>
        <template #title>
            <i class="pi pi-credit-card"></i>
            <span class="ml-2">Orders</span>
        </template>

        <template #body>
            <app-filter-layout :on-search="onSearch" :on-cancel="onCancel">
                <template #filters>
                    <app-form-input v-model="filtersInput['filter[user.name]']" label="Username" placeholder="Search by username" />
                    <app-form-input v-model="filtersInput['filter[user.email]']" label="Email" placeholder="Search by email" />
                    <app-form-input v-model="filtersInput['filter[plan.name]']" label="Plan" placeholder="Search by plan" />
                </template>
            </app-filter-layout>

            <app-grid
                :columns="columns"
                defaultSort="-created_at"
                :filters="filters"
                :url="url"
                :key="JSON.stringify(filters)"
            />
        </template>
    </app-pannel>
</template>

<script>
export default { 
    data() {
        return {
            url: '/api/orders',
            filtersInput: {},
            filters: {},
            columns: [
                { field: 'id', header: 'ID' },
                { field: 'user.name', header: 'Username' },
                { field: 'user.email', header: 'Email' },
                { field: 'plan.name', header: 'Plan'},
                { field: 'transaction_id', header: 'Transaction ID'},
                { field: 'created_at', header: 'Created at', sortable: true}
            ],
        }
    },

    methods: {
        /**
         * Handles the search event
         */
        onSearch() {
            this.filters = {...this.filtersInput};
        },

        /**
         * Handles the cancel event
         */
        onCancel() {
            this.filtersInput = {};
            this.filters = {};
        }
    }
}
</script>

