<template>
    <div>
        <app-form-layout :on-submit="onSubmit">
            <template #title>Register</template>
            <template #inputs>
                <app-form-input label="Username" v-model="record.name" :error="errors?.name" />
                <app-form-input label="Email" v-model="record.email" type="email" :error="errors?.email" />
                <app-form-input 
                    label="Confirm your email" 
                    v-model="record.email_confirmation" 
                    type="email" 
                    placeholder="Confirm email"
                />
                <app-form-input label="Password" v-model="record.password" type="password" :error="errors?.password" />
                <app-form-input 
                    label="Confirm your password" 
                    v-model="record.password_confirmation" 
                    type="password" 
                    placeholder="Confirm password" 
                />
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
                    .post('/api/users', this.record)
                    .then((res)=>console.log(res))
                    .catch(error => this.errors = error.response?.data?.errors)
                    .finally(() => {
                        this.loading = false;
                    });
            }
        },
    }
</script>