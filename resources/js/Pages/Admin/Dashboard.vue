<template>
    <inner-layout :title="lang.dashboard">
        <div class="col-sm-12">
            <div class="row mt-3">
                <div class="col-sm-3 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold text-gray-600 text-uppercase mb-1">{{ lang.total_companies }}</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{data.company_count}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-building fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mb-4">
                    <div class="card border-left-purple shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold text-gray-600 text-uppercase mb-1">{{ lang.total_cases }}</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{data.case_count}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mb-4">
                    <div class="card border-left-green shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold text-gray-600 text-uppercase mb-1">{{ lang.total_managers }}</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{data.manager_count}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mb-4">
                    <div class="card border-left-cyan shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold text-gray-600  text-uppercase mb-1">{{ lang.total_detectors }}</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{data.detector_count}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-binoculars fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card shadow table-responsive mb-4">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="bg-primary-orange border-b-2">
                                    <th scope="col">{{ lang.case }} #</th>
                                    <th scope="col">{{ lang.company }}</th>
                                    <th scope="col">{{ lang.category }}</th>
                                    <th scope="col">{{ lang.manager }}</th>
                                    <th scope="col">{{ lang.subject }}</th>
                                    <th scope="col">{{ lang.status }}</th>
                                    <th scope="col" class="text-center">{{ lang.action }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, key) in cases" :key="key">
                                    <th scope="row">
                                        {{ value.case_number }}
                                    </th>
                                    <td>
                                        {{ value.company?.name }}
                                    </td>
                                    <td>
                                        <template v-if="value.category">
                                            {{ value.category?.name }}
                                        </template>
                                        <template v-else>
                                            --/--
                                        </template>
                                    </td>
                                    <td>
                                        <template v-if="value.user">
                                            {{ value.user?.name }}
                                        </template>
                                        <template v-else>
                                            --/--
                                        </template>
                                    </td>
                                    <td class="w-200"><p class="text-ellipsis mb-0 max-width-150">{{ value.subject }}</p></td>
                                    <td>
                                        <template v-if="value.status">
                                            {{ value.status?.name }}
                                        </template>
                                        <template v-else>
                                            --/--
                                        </template>
                                    </td>
                                    <td class="text-center">
                                        <Link :href="route('company.inbox', value.case_number)" class="btn btn-sm btn-primary mr-2">
                                            <i class="fa fa-eye"></i>
                                        </Link>
                                        <button type="button" class="btn btn-sm btn-primary" v-if="! value.deleted_at" :title="lang.archive"  @click="softDelete(value.id)"><i class="fa fa-archive" ></i></button>
                                        <button type="button" class="btn btn-sm btn-primary" v-else :title="lang.restore" @click="restore(value.id)"><i  class="fa fa-undo"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </inner-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import InnerLayout from '@/Layouts/InnerLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import axios from 'axios'

    export default defineComponent({
        components: {
            InnerLayout,
            Welcome,
        },

        props:[
            'data',
            'cases',
            'lang'
        ],

        methods:{

            softDelete(case_id){

                Toast.fire({
                    title: this.lang.are_you_sure,
                    text: this.lang.archive_confirmation,
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: this.lang.cancel,
                    confirmButtonText: 'Ok',
                })
                .then((willDelete) => {

                    if (willDelete.isConfirmed) {
                        axios.post(route('soft.delete', case_id)).then(response => {

                            this.cases.map((object, index) => {
                                if(object.id == case_id){
                                    this.cases.splice(index, 1);
                                }
                            });

                            Toast.fire({
                                icon:'success',
                                title: this.lang.archived
                            });
                        });
                    }
                });
            },

            restore(case_id){

                axios.post(route('case.restore', case_id)).then(response => {
                    Toast.fire({
                        icon:'success',
                        title: this.lang.restored
                    });
                });
            }
        }
    })
</script>
