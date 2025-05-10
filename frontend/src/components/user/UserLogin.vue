<template>
    <div>
        <app-form-layout :on-submit="onSubmit">
            <template #title>Login</template>
            <template #inputs>
                <app-form-input label="Email" v-model="record.email" type="email" :error="errors?.email"/>
                <app-form-input label="Password" v-model="record.password" type="password" :error="errors?.password"/>
            </template>
            <template #footer>
                <app-form-error :error="errors?.credentials" />
            </template>
        </app-form-layout>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                record: {},
                errors: {},
                loading: false
            }
        },
        methods: {
            onSubmit() {
                this.errors = {};
                this.loading = true;

                this.$http
                    .post('/api/login', this.record)
                    .then((res)=>console.log(res))
                    .catch(error => this.errors = error.response?.data?.errors)
                    .finally(() => {
                        this.loading = false;
                    });
            }
        },
    }
</script>