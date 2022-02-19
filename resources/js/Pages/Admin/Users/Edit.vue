<template>
    <inner-layout :title="lang.users">
              <div class="col-sm-12 p-3">
                <div class="card p-3">
                 <form @submit.prevent="update">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="FullName" class="form-label">{{lang.name}} <required /></label>
                            <input type="text" autocomplete="off" v-model="form.name" class="form-control" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="Email" class="form-label">{{lang.email}} <required /></label>
                            <input type="email" autocomplete="off" v-model="form.email" class="form-control" />
                            <jet-input-error :message="form.errors.email" class="mt-2" />
                        </div>
                
                        <div class="mb-3 col-md-6">
                            <label for="Password" class="form-label">{{lang.password}}</label>
                            <input type="password" autocomplete="off" v-model="form.password" class="form-control" />
                            <jet-input-error :message="form.errors.password" class="mt-2" />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="ConfirmPassword" class="form-label">{{lang.confirm_password}}</label>
                            <input type="password" autocomplete="off" v-model="form.password_confirmation" class="form-control" />
                            <jet-input-error :message="form.errors.password_confirmation" class="mt-2" />
                        </div>
                        <div class="mb-3 col-md-4">
                            <label for="ConfirmPassword" class="form-label">{{lang.role}} <required /></label>
                            <select class="form-select" v-model="form.type">
                                <option value="">{{lang.select_user_type}}</option>
                                <option value="Admin">{{lang.admin}}</option>
                                <option value="Detector">{{lang.detector}}</option>
                                <option value="Manager">{{lang.manager}}</option>
                            </select>
                            <jet-input-error :message="form.errors.type" class="mt-2" />
                        </div>

                        <div class="mb-3 col-md-4" v-if="form.type == 'Manager'">
                            <label for="ConfirmPassword" class="form-label">{{lang.company}} <required /></label>
                            <select class="form-select" v-model="form.company_id">
                                <option value="">{{lang.select_company}}</option>
                                <option v-for="(company, index) in companies" :key="index" :value="index">
                                    {{ company }}
                                </option>
                            </select>
                            <jet-input-error :message="form.errors.company_id" class="mt-2" />
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="ConfirmPassword" class="form-label">{{lang.status}} <required /></label>
                            <select class="form-select" v-model="form.status">
                                <option value="1">{{lang.active}}</option>
                                <option value="0">{{lang.inactive}}</option>
                            </select>
                            <jet-input-error :message="form.errors.status" class="mt-2" />
                        </div>
                    </div>
                    <div class="justify-content-md-end">
                        <button type="submit" class="btn btn-primary mr-2">{{lang.update}}</button>
                        <Link :href="route('users.index')" class="btn btn-secondary">{{lang.cancel}}</Link>
                    </div>
                  </form>
                </div>
               </div>
    </inner-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import InnerLayout from '@/Layouts/InnerLayout.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import Required from '@/Shared/Required'

    export default defineComponent({
        components: {
            InnerLayout,
            JetInputError,
            Required,
        },

        props:[
            'lang',
            'user',
            'companies',
        ],

        data(){
            return{

                form: this.$inertia.form({
                    id: this.user.id,
                    name: this.user.name,
                    email: this.user.email,
                    password: '',
                    password_confirmation: '',
                    company_id: this.user.company_id?this.user.company_id:'',
                    type: this.user.type,
                    status: this.user.status,
                }),
            }
        },

        methods:{

            update() {

                if(this.form.type == 'Manager' && this.form.company_id == ''){

                    this.form.errors.company_id = this.$page.props.common.company_field_is_required
                    return;
                }
                this.form.put(route('users.update', this.user.slug), {
                    errorBag: 'create',
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                    onError: () => {
                        // this.form.errors;
                    }
                });
            },
        }
    })
</script>
