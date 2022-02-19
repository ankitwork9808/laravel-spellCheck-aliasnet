<template>
    <inner-layout :title="lang.users">
        <div class="col-sm-12">
            <div class="d-flex justify-content-end py-2 my-3 topnav flex-wrap">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" v-model='page.keyword'>
                <div class="bg-secondary btn"><i @click="resetSearch()" class="cursor-pointer fa fa-undo"></i></div>
                <div class="btn btn-primary" @click="userSearch()" >
                   <i class="cursor-pointer fa fa-search"></i>
                </div>
              </div>
              <select class="form-select mr-3" v-model='page.type' @change="userSearch()">
                    <option value="">{{lang.user_by_type}}</option>
                    <option value="Admin">{{lang.admin}}</option>
                    <option value="Detector">{{lang.detector}}</option>
                    <option value="Manager">{{lang.manager}}</option>
                </select>
                <Link :href="route('users.create')" class="btn btn-primary" type="button">
                    {{ lang.create_user }}
                </Link>
             </div>
        </div>
         <div class="col-sm-12">
             <div class="card shadow table-responsive mb-4">
                 <Loader v-if="page.loader" />
               <table v-else class="table table-hover mb-0">
                <thead>
                    <tr class="bg-primary-orange border-b-2">
                        <th scope="col">{{ lang.name }}</th>
                        <th scope="col">{{ lang.email }}</th>
                        <th scope="col">{{ lang.role }}</th>
                        <th scope="col">{{ lang.company }}</th>
                        <th scope="col">{{ lang.last_activity_at }}</th>
                        <th scope="col">{{ lang.status }}</th>
                        <th scope="col">{{ lang.created_at }}</th>
                        <th scope="col">{{ lang.action }}</th>
                    </tr>
                </thead>

                    <tbody>
                        <tr v-for="user in page.users.data" :key="user.id">
                            <th>{{user.name}}</th>
                            <td>{{user.email}}</td>
                            <td>
                                <span v-if="user.type == 'Admin'" class="badge bg-primary mw-role">{{user.type}}</span>
                                <span v-else-if="user.type == 'Detector'" class="badge bg-primary-orange mw-role">{{user.type}}</span>
                                <span v-else-if="user.type == 'Manager'" class="badge bg-success mw-role">{{user.type}}</span>
                                <span v-else class="badge bg-secondary mw-role">{{user.type}}</span>
                            </td>
                            <td>
                                <template v-if="user.company">
                                    {{user.company.name}}
                                </template>
                                <template v-else>
                                    --/--
                                </template>
                            </td>

                            <td>{{user.last_active}}</td>

                            <td>
                                <select v-if="user.status == 1" v-model="user.status" @change="updateStatus(user.id, user.status)" class="form-select border-0 p-1 bg-green font-weight-bold text-white" style="width: 100px;">
                                    <option value="1">&nbsp;{{ lang.active }}</option>
                                    <option value="0">&nbsp;{{ lang.inactive }}</option>
                                </select>

                                <select v-else v-model="user.status" @change="updateStatus(user.id, user.status)" class="form-select border-0 p-1 bg-redlight font-weight-bold text-white" style="width: 100px;">
                                    <option value="1">&nbsp;{{ lang.active }}</option>
                                    <option value="0">&nbsp;{{ lang.inactive }}</option>
                                </select>
                            </td>

                            <td>{{user.created_at}}</td>
                            <td>
                                <Link :href="route('users.edit', user.slug)" class="btn btn-sm btn-primary mr-2">
                                      <i class="fa fa-edit textBlack" />
                                </Link>
                                 <button @click="del(user.slug)" class="btn btn-sm btn-primary">
                                     <i class="fa fa-times-circle textBlack" />
                                 </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <Paginate :links="page.users.links" />
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
            'users',
        ],

        data(){
            return{
                page:{
                    users: this.users,
                    type: '',
                    keyword: '',
                    loader: false,
                    status: this.users.status
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
                        axios.delete(route('users.destroy', id)).then(response => {

                            if(!response.data.success){
                                Toast.fire({
                                    icon:'error',
                                    title: this.$page.props.common.delete_error
                                });
                            }else{
                                this.page.users = response.data.users;
                                Toast.fire({
                                    icon:'success',
                                    title: this.$page.props.common.delete_success
                                });
                            }
                        });
                    }
                });
            },

            resetSearch(){

                this.page.type = '';
                this.page.keyword = '';
                this.userSearch();
            },

            userSearch(){

                this.page.loader = true;
                let data = new FormData;
                data.append('type', this.page.type);
                data.append('keyword', this.page.keyword);
                axios.post(route('users.search'), data).then( response => {
                    this.page.users = response.data;
                    this.page.loader = false;
                });
            },

            updateStatus(id, status){

                let data = new FormData;
                data.append('id', id);
                data.append('status', status);

                axios.post(route('user.status'), data).then(response => {
                    Toast.fire({
                        icon:'success',
                        title: this.$page.props.common.status_has_been_updated
                    });
                });
            }
        }
    })
</script>
