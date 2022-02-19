<template>
    <inner-layout :title="lang.companies">
        <div class="col-sm-12">
            <div class="d-flex flex-wrap justify-content-end topnav py-2 my-3">
                <div class="input-group">
                    <input type="text" :placeholder="lang.companyid" class="form-control" v-model='page.keyword'>
                     <div class="bg-secondary btn">
                        <Link :href="route('companies.index')" class="text-gray-200">
                            <i class="cursor-pointer fa fa-undo"></i>
                        </Link>
                     </div>
                    <span class="btn btn-primary input-group-text" @click="companySearch()">
                        <i class="cursor-pointer fa fa-search"></i>
                    </span>
                </div>

                <Link :href="route('companies.create')" class="btn btn-primary" type="button">
                        {{ lang.create_company }}
                </Link>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card shadow table-responsive mb-4">
                <Loader v-if="page.loader" />
              <table v-else class="table table-hover mb-0">
                <thead>
                    <tr class="bg-primary-orange border-b-2">
                        <th scope="col">{{lang.companyid}}</th>
                        <th scope="col">{{lang.name}}</th>
                        <th scope="col">{{lang.phone}}</th>
                        <th scope="col">{{lang.email}}</th>
                        <th scope="col">{{lang.address}}</th>
                        <th scope="col">{{ lang.status }}</th>
                        <th scope="col">{{ lang.last_activity_at }}</th>
                        <th scope="col">{{ lang.created_at }}</th>
                        <th scope="col">{{ lang.action }}</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(company, index) in page.companies.data" :key="index">
                        <td>{{company.companyid}}</td>
                        <td>{{company.name}}</td>
                        <td>{{company.phone}}</td>
                        <td>{{company.email}}</td>
                        <td>{{company.address}}</td>
                        <td>
                            <select v-if="company.status == 1" v-model="company.status" @change="updateStatus(company.id, company.status)" class="form-select border-0 p-1 bg-green font-weight-bold text-white" style="width: 100px;">
                                <option value="1">&nbsp;{{ lang.active }}</option>
                                <option value="0">&nbsp;{{ lang.inactive }}</option>
                            </select>

                            <select v-else v-model="company.status" @change="updateStatus(company.id, company.status)" class="form-select border-0 p-1 bg-redlight font-weight-bold text-white" style="width: 100px;">
                                <option value="1">&nbsp;{{ lang.active }}</option>
                                <option value="0">&nbsp;{{ lang.inactive }}</option>
                            </select>
                        </td>
                        <td>{{company.last_active}}</td>
                        <td>{{company.created_at}}</td>
                        <td><Link :href="route('companies.edit', company.companyid)" class="btn btn-sm btn-primary mr-2">
                                <i class="fa fa-edit textBlack" />
                            </Link>
                             <Link :href="route('companies.show', company.companyid)" class="btn btn-sm btn-primary mr-2">
                                        <i class="fa fa-eye textBlack" />
                             </Link>
                             <button @click="del(company.companyid)" class="btn btn-sm btn-primary">
                                 <i class="fa fa-times-circle textBlack" />
                             </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Paginate :links="page.companies.links" />
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
            'companies',
        ],

        data(){
            return{
                page:{
                    companies: this.companies,
                    type: '',
                    keyword: '',
                    loader: false,
                }
            }
        },

        methods:{

            del(id){

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
                        axios.delete(route('companies.destroy', id)).then(response => {

                            if(response.data.response == 'error'){
                                Toast.fire({
                                    icon:'error',
                                    title: response.data.message
                                });
                            }else{
                                this.page.companies = response.data.data;
                                Toast.fire({
                                    icon:'success',
                                    title: this.$page.props.common.delete_success
                                });
                            }
                        });
                    }
                });
            },

            companySearch(){

                if(this.page.keyword == ''){
                    return;
                }
                this.page.loader = true;
                let data = new FormData;
                data.append('keyword', this.page.keyword);
                axios.post(route('companies.search'), data).then( response => {

                    this.page.companies = response.data;
                    this.page.loader = false;
                });
            },

            updateStatus(id, status){

                let data = new FormData;
                data.append('id', id);
                data.append('status', status);

                axios.post(route('company.status'), data).then(response => {
                    Toast.fire({
                        icon:'success',
                        title: this.$page.props.common.status_has_been_updated
                    });
                });
            }
        }
    })
</script>
