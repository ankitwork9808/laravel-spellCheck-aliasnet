<template>
    <inner-layout :title="lang?.leads">

        <div class="col-sm-12 mt-5">
            <div class="card shadow table-responsive mb-4">
                <Loader v-if="page.loader" />
                <table v-else class="table table-hover mb-2">
                    <thead>
                        <tr class="bg-primary-orange border-b-2">
                            <th scope="col">{{ lang.package }}</th>
                            <th scope="col">{{ lang.name }}</th>
                            <th scope="col">{{ lang.email }}</th>
                            <th scope="col">{{ lang.phone }}</th>
                            <th scope="col">{{ lang.company_name }}</th>
                            <th scope="col">{{ lang.address }}</th>
                            <th scope="col" class="text-center">{{ lang.action }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(lead, index) in page.leads.data" :key="index" :class="'row-'+index">
                            <td>{{lead.package_name}}</td>
                            <td>{{lead.name}}</td>
                            <td>{{lead.email}}</td>
                            <td>{{lead.phone}}</td>
                            <td>{{lead.company_name}}</td>
                            <td>{{lead.address}}</td>
                            <td class="text-center">
                                <button @click="del(lead.id, index)" class="btn btn-sm btn-primary">
                                    <i class="fa fa-times-circle textBlack" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <Paginate :links="page.leads.links" class="mr-2"/>
            </div>
        </div>
    </inner-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import InnerLayout from '@/Layouts/InnerLayout.vue'
    import Loader from "@/Shared/Loader"
    import Paginate from "@/Shared/Paginate"

    export default defineComponent({
        components: {
            InnerLayout,
            Loader,
            Paginate,
        },

        props:[
            'lang',
            'leads',
        ],

        data(){
            return{
                page:{
                    leads: this.leads,
                    type: '',
                    keyword: '',
                    loader: false,
                }
            }
        },

        methods:{

            del(id, index){

                Toast.fire({
                    title: this.lang.are_you_sure,
                    text: this.lang.delete_confirm_message,
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: this.lang.cancel,
                    confirmButtonText: 'Ok',
                })
                .then((willDelete) => {

                    if (willDelete.isConfirmed) {
                        axios.delete(route('leads.destroy', id)).then(response => {

                            Toast.fire({
                                icon:'success',
                                title: this.$page.props.common.delete_success
                            });
                            $(`.row-${index}`).hide('slow');
                        });
                    }
                });
            },
        }
    })
</script>
