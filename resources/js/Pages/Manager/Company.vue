<template>
    <page-layout :title="company.name">
        <div class="col-sm-12 mt-3">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th colspan="2">{{company.name}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ lang.status }}</td>
                                            <td>
                                                <template v-if="company.status">
                                                    {{ lang.active }}
                                                </template>
                                                <template v-else>
                                                    {{ lang.inactive }}
                                                </template>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ lang.companyid }}</td>
                                            <td>
                                                <template v-if="company.companyid">
                                                    {{company.companyid}}
                                                </template>
                                                <template v-else>
                                                    --/--
                                                </template>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ lang.phone }}</td>
                                            <td>
                                                <template v-if="company.phone">
                                                    {{company.phone}}
                                                </template>
                                                <template v-else>
                                                    --/--
                                                </template>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td>{{ lang.email }}</td>
                                        <td>
                                            <template v-if="company.email">
                                                {{company.email}}
                                            </template>
                                            <template v-else>
                                                --/--
                                            </template>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ lang.website }}</td>
                                        <td>
                                            <template v-if="company.website">
                                                {{company.website}}
                                            </template>
                                            <template v-else>
                                                --/--
                                            </template>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ lang.address }}</td>
                                        <td>
                                            <template v-if="company.address">
                                                {{company.address}}
                                            </template>
                                            <template v-else>
                                                --/--
                                            </template>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ lang.city }}</td>
                                        <td> <template v-if="company.city">
                                                {{company.city}}
                                            </template>
                                            <template v-else>
                                                --/--
                                            </template>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ lang.state }}</td>
                                        <td>
                                            <template v-if="company.state_id">
                                                {{company.state.name}}
                                            </template>
                                            <template v-else>
                                                --/--
                                            </template>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ lang.country }}</td>
                                        <td>
                                            <template v-if="company.country_id">
                                                {{company.country.name}}
                                            </template>
                                            <template v-else>
                                                --/--
                                            </template>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ lang.postal_code }}</td>
                                        <td>
                                            <template v-if="company.postal_code">
                                                {{company.postal_code}}
                                            </template>
                                            <template v-else>
                                                --/--
                                            </template>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ lang.updated_at }}</td>
                                        <td>{{company.updated_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ lang.created_at }}</td>
                                        <td>{{company.created_at}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{lang.note}}</h5>
                            <p class="card-text">
                                <template v-if="company.note">
                                    {{ company.note }}
                                </template>
                                <template v-else>
                                    --/--
                                </template>
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ lang.token }}</h5>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" readonly id="token" :value="company.token" />
                                <button class="btn btn-outline-secondary" type="button" @click="copyToken()">{{lang.copy}}</button>
                            </div>
                            <Link :href="route('companies.index')" class="btn btn-success" type="button" @click="copyToken()">{{lang.back}}</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </page-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import PageLayout from '@/Layouts/PageLayout.vue'
    import JetInputError from '@/Jetstream/InputError.vue'

    export default defineComponent({
        components: {
            PageLayout,
            JetInputError,
        },

        props:[
            'lang',
            'company',
        ],

        methods:{
            copyToken(){
                navigator.clipboard.writeText(this.company.token);
                Toast.fire({
                    icon:'success',
                    title: this.lang.copied
                });
            }
        }
    })
</script>
