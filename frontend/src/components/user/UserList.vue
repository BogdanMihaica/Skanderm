<template>
    <app-pannel>
        <template #title>
            <i class="pi pi-user"></i>
            <span class="ml-2">Users</span>
        </template>

        <template #tools>
            <app-form-button label="Add" severity="contrast" @click.prevent="onAdd" size="xs" icon="pi pi-plus"/>
        </template>

        <template #body>
            <app-filter-layout :on-search="onSearch" :on-cancel="onCancel">
                <template #filters>
                    <app-form-input v-model="filtersInput['filter[name]']" label="Username" placeholder="Search by username" />
                    <app-form-input v-model="filtersInput['filter[email]']" label="Email" placeholder="Search by email" />
                    <app-form-input v-model="filtersInput['filter[plan.name]']" label="Plan" placeholder="Search by plan" />
                    <app-form-select v-model="filtersInput['filter[is_blocked]']" label="Blocked" :boolean="true" />
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
import router from '@/routes/routes';

export default { 
    data() {
        return {
            url: '/api/users',
            filtersInput: {},
            filters: {},
            columns: [
                { field: 'id', header: 'ID' },
                { field: 'name', header: 'Username' },
                { field: 'email', header: 'Email' },
                { field: 'plan.name', header: 'Plan' },
                { field: 'is_blocked', header: 'Blocked', boolean: true },
                { field: 'is_admin', header: 'Admin', boolean: true },
                { field: 'created_at', header: 'Created at', sortable: true },
                { 
                    type: 'actions', 
                    items: (slotProps) => {
                        return [
                            {
                                icon: 'pi pi-pencil',
                                // to: { name: 'user.edit', params: {id: slotProps.data.id} },
                            }
                        ]
                    }
                }
            ],
        }
    },

    methods: {
        /**
         * Handles the 'add' button click
         */
        onAdd() {
            router.push({name: 'user.create'});
        },

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

