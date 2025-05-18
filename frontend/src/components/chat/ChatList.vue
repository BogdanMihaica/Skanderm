<template>
    <app-pannel>
        <template #title>
            <i class="pi pi-message"></i>
            <span class="ml-2">Chats</span>
        </template>

        <template #body>
            <app-filter-layout :on-search="onSearch" :on-cancel="onCancel">
                <template #filters>
                    <app-form-input v-model="filtersInput['filter[user.name]']" label="Username" placeholder="Search by username" />
                    <app-form-input v-model="filtersInput['filter[user.email]']" label="Email" placeholder="Search by email" />
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
                { field: 'created_at', header: 'Created at', sortable: true},
                { 
                    type: 'actions', 
                    items: (_slotProps) => {
                        return [
                            {
                                icon: 'pi pi-eye',
                                label: 'See messages',
                                // to: { name: 'admin.messages', params: {id: slotProps.data.id} },
                            }
                        ]
                    }
                }
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

