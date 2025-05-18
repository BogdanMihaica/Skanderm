<template>
    <app-pannel>
        <template #title>
            <span class="ml-2">Plans</span>
        </template>

        <template #body>
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
            url: '/api/plans',
            filtersInput: {},
            filters: {},
            columns: [
                { field: 'id', header: 'ID' },
                { field: 'name', header: 'Name' },
                { field: 'description', header: 'Description' },
                { field: 'benefits', header: 'Benefits', type: 'array'},
                { field: 'price', header: 'Price'},
                { field: 'created_at', header: 'Created at', sortable: true}
            ],
            //  $table->boolean('is_active')->default(1);
            // $table->string('key')->unique();
            // $table->string('name');
            // $table->string('description')->nullable();
            // $table->json('benefits')->nullable();
            // $table->double('price')->default(0);
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

