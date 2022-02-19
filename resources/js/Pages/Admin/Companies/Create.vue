<template>
    <inner-layout :title="lang.companies">
            <div class="col-sm-12 p-3">
                <form class="card p-3" @submit.prevent="create">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="FullName" class="form-label">{{lang.name}} <required /></label>
                            <input type="text" autocomplete="off" v-model="form.name" :placeholder="lang.name" class="form-control" required />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="website" class="form-label">{{lang.website}}</label>
                            <input type="text" autocomplete="off" v-model="form.website" :placeholder="lang.website" class="form-control" />
                            <jet-input-error :message="form.errors.website" class="mt-2" />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="phone" class="form-label">{{lang.phone}}</label>
                            <input type="text" autocomplete="off" v-model="form.phone" :placeholder="lang.phone" class="form-control phone" />
                            <jet-input-error :message="form.errors.phone" class="mt-2" />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="Email" class="form-label">{{lang.email}}</label>
                            <input type="email" autocomplete="off" v-model="form.email" :placeholder="lang.email" class="form-control" />
                            <jet-input-error :message="form.errors.email" class="mt-2" />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">{{lang.address}}</label>
                            <input type="text" autocomplete="off" v-model="form.address" :placeholder="lang.address" class="form-control" />
                            <jet-input-error :message="form.errors.address" class="mt-2" />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="city" class="form-label">{{lang.city}}</label>
                            <input type="text" autocomplete="off" v-model="form.city" :placeholder="lang.city" class="form-control" />
                            <jet-input-error :message="form.errors.city" class="mt-2" />
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="country" class="form-label">{{lang.country}}</label>
                            <select class="form-select" @change="getStates()" v-model="form.country_id">
                                <option v-for="(name, id) in countries" :key="id" :value="id">{{name}}</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="state" class="form-label">{{lang.state}}</label>
                            <select class="form-select" v-model="form.state_id">
                                <option value="">{{ lang.select_state }}</option>
                                <option v-for="(name, id) in page.states" :key="id" :value="id">{{name}}</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="postalcode" class="form-label">{{lang.postal_code}}</label>
                            <input type="text" autocomplete="off" v-model="form.postal_code" :placeholder="lang.postal_code" class="form-control zipcode" />
                            <jet-input-error :message="form.errors.postal_code" class="mt-2" />
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="note" class="form-label">{{lang.note}}</label>
                            <textarea autocomplete="off" v-model="form.note" :placeholder="lang.note" class="form-control"></textarea>
                            <jet-input-error :message="form.errors.note" class="mt-2" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="status" class="form-label">{{lang.status}} <required /></label>
                            <select class="form-select" v-model="form.status">
                                <option value="1">{{lang.active}}</option>
                                <option value="0">{{lang.inactive}}</option>
                            </select>
                            <jet-input-error :message="form.errors.status" class="mt-2" />
                        </div>
                    </div>
                    <div class="justify-content-md-end">
                        <button type="submit" class="btn btn-primary mr-2">{{lang.save}}</button>
                        <Link :href="route('companies.index')" class="btn btn-secondary">{{lang.cancel}}</Link>
                    </div>
                </form>
            </div>
    </inner-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import InnerLayout from '@/Layouts/InnerLayout.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import axios from 'axios'
    import Required from '@/Shared/Required'

    export default defineComponent({
        components: {
            InnerLayout,
            JetInputError,
            Required,
        },

        props:[
            'lang',
            'countries',
            'states',
        ],

        data(){
            return{

                form: this.$inertia.form({
                    name: '',
                    phone: '',
                    email: '',
                    address: '',
                    city: '',
                    state_id: '',
                    country_id: 81,
                    postal_code: '',
                    website: '',
                    note: '',
                    status: 1,
                }),

                page:{
                    states: this.states,
                }
            }
        },

        methods:{

            create() {

                this.form.post(route('companies.store'), {
                    errorBag: 'create',
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                    onError: () => {
                        // this.form.errors;
                    }
                });
            },

            getStates(){

                axios.get(route('state.list', this.form.country_id)).then( response => {
                    this.form.state_id = '';
                    this.page.states = response.data;
                });
            }
        }
    })
</script>
