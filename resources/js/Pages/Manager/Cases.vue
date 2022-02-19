<template>
    <page-layout :title="page.company_name">

        <div class="col-sm-12" id="companyCase">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row justify-content-between flex-shrink-0 py-2.5 border-bottom">

                        <div class="col-sm-5">
                            <div class="input-group mb-xs-2">
                                <input type="text" @keyup="getCases(page.company_id, page.company_name, false, 'main')" autofocus v-model="filter.case_id" class="form-control" :placeholder="lang.search_by_case_id" />
                                <div class="bg-gray-100 btn"><i @click="resetSearch()" class="cursor-pointer fa fa-undo"></i></div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="d-flex border rounded border-gray-100 p-0/5 pl-3 mb-xs-2">
                            <img src="/images/inboxdark.svg" alt="input box" />
                            <select v-model="filter.status_id" class="form-select border-0 fs-xs"
                                    @change="getCases(page.company_id, page.company_name, false, 'main')" aria-label="Default select">
                                <option value="">{{lang.all_status}}</option>
                                <template v-for="(status, index) in statuses" :key="index">
                                    <option :value="index">{{status}}</option>
                                </template>
                                <option value="archived">{{lang.archived_text}}</option>
                            </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                          <div class="border rounded border-gray-100 p-0/5 pl-3">
                            <select v-model="filter.overdue" class="form-select border-0 fs-xs"
                                @change="getCases(page.company_id, page.company_name, false, 'main')" aria-label="Default select">
                                <option value="">{{ lang.select }} {{lang.overdue}}</option>
                                <option value="0">{{lang.all_overdue}}</option>
                                <option value="1">1 {{lang.days}} {{lang.overdue}}</option>
                                <option value="2">2 {{lang.days}} {{lang.overdue}}</option>
                                <option value="3">3 {{lang.days}} {{lang.overdue}}</option>
                                <option value="4">4 {{lang.days}} {{lang.overdue}}</option>
                                <option value="5">5 {{lang.days}} {{lang.overdue}}</option>
                                <option value="6">6 {{lang.days}} {{lang.overdue}}</option>
                                <option value="7">7 {{lang.days}} {{lang.overdue}}</option>
                                <option value="8">8 {{lang.days}} {{lang.overdue}}</option>
                                <option value="9">9 {{lang.days}} {{lang.overdue}}</option>
                                <option value="10">10 {{lang.days}} {{lang.overdue}}</option>
                            </select>  
                          </div>
                        </div>
                    </div>

                    <div @scroll="onScroll" class="list-group list-group-flush scrollarea h-full">
                        <template v-for="(object, index) in page.cases" :key="index">
                            <div @click="readCase(object)" :id="object.case_number" :class="'list-group-item cursor-pointer case-row list-group-item-action py-3 '+object.selected">
                                <div class="d-flex w-100 align-items-center justify-content-between">
                                  <div class="">
                                    <p class="mb-1">
                                        <template v-if="object.seen">
                                            {{ lang.case_id }}: {{object.case_number}}
                                        </template>
                                        <template v-else>
                                            <strong>{{ lang.case }} {{object.case_number}}</strong>
                                        </template>

                                        <i v-if="! object.deleted_at" data-bs-toggle="tooltip" data-bs-placement="top" :title="lang.archive" class="fa fa-archive textBlack ml-4 cursor-pointer" @click="softDelete(object.id)">
                                        </i>
                                        <i v-else data-bs-toggle="tooltip" data-bs-placement="top" :title="lang.restore" class="fa fa-undo textBlack ml-4 cursor-pointer" @click="restore(object.id)"></i>

                                        <span v-if="object.overdue == 3" class="badge ml-10" style="background-color:#9A6F19">
                                            {{ lang.overdue_since }} 3 {{ lang.days }}
                                        </span>
                                        <span v-if="object.overdue == 4" class="badge ml-10" style="background-color:#f52c31">
                                            {{ lang.overdue_since }} 4 {{ lang.days }}
                                        </span>
                                        <span v-if="object.overdue == 5" class="badge ml-10" style="background-color:#C82024">
                                            {{ lang.overdue_since }} 5 {{ lang.days }}
                                        </span>
                                        <span v-if="object.overdue == 6" class="badge ml-10" style="background-color:#871114">
                                            {{ lang.overdue_since }} 6 {{ lang.days }}
                                        </span>
                                        <span v-if="object.overdue == 7" class="badge ml-10" style="background-color:#6a090c">
                                            {{ lang.overdue_since }} 7 {{ lang.days }}
                                        </span>
                                    </p>
                                   <div class="col-10 mb-1 small">
                                    <template v-if="object.seen">
                                        {{ lang.subject }}: {{ object.subject }}
                                    </template>
                                    <template v-else>
                                        <strong>{{ lang.subject }}: {{ object.subject }}</strong>
                                    </template>
                                </div>
                                <ul class="flex-wrap unstyled inline-flex p-0 mb-0">
                                    <li class="text-sm mr-2">
                                        <template v-if="object.contact_info">
                                            {{ object.contact_info }}
                                        </template>
                                        <template v-else>
                                            --/--
                                        </template>
                                    </li>
                                    <li class="list-disc text-sm mr-2 ml-4">
                                        <template v-if="object.category">
                                        {{ object.category?.name }}
                                        </template>
                                        <template v-else>
                                            --/--
                                        </template>
                                    </li>
                                    <li class="list-disc text-sm mr-2 ml-4">
                                        {{ object.created_at }}
                                    </li>
                                  </ul>
                                  </div>
                                  <div class="text-muted">
                                    <template v-if="object.seen">
                                            {{ object.status?.name }}
                                      </template>
                                      <template v-else>
                                            <strong>{{ object.status?.name }}</strong>
                                      </template>
                                   </div>
                               </div>
                            </div>
                        </template>
                        <Loader v-if="page.loader" />

                        <div class="mb-10"></div>
                    </div>
                </div>

                <div v-if="page.case.id > 0" class="col-sm-6">
                    <div class="d-flex justify-content-between border-bottom align-items-center py-2.5">
                        <div class="text-1">{{ page.case.subject }} - {{ page.case.case_number }}</div>
                        <button v-if="!page.edit" type="button" @click="edit()" class="btn btn-primary px-4">{{lang.to_edit}}</button>
                        <button v-else type="button" @click="cancel()" class="btn btn-primary px-4">{{lang.cancel}}</button>
                    </div>
                    <div class="d-flex flex-column">
                        <table class="table table-hover">
                            <tbody>
                                <tr class="border-b">
                                    <td class="border-0">{{ lang.status }}</td>
                                    <td class="border-0 text-1">
                                        <template v-if="page.edit">
                                            <label for="status" class="form-label">{{lang.select_status}}</label>
                                            <select class="form-select" @change="updateStatus(page.case)" v-model="page.status_id">
                                                <option value="">{{lang.select}}</option>
                                                <option v-for="(status, id) in statuses" :key="id" :value="id">{{status}}</option>
                                            </select>
                                        </template>
                                        <template v-else>
                                            {{ page.case.status.name }}
                                        </template>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="border-0">{{lang.assigned}}</td>
                                    <td class="border-0 text-black-50">
                                        <template v-if="page.edit">
                                            <label for="status" class="form-label">{{lang.select_manager}}</label>
                                            <select class="form-select" @change="updateManager(page.case)" v-model="page.manager_id">
                                                <option value="">{{lang.select}}</option>
                                                <option v-for="(value, id) in page.managers" :key="id" :value="id">{{value}}</option>
                                            </select>
                                        </template>
                                        <template v-else>
                                            <template v-if="page.case.user">
                                                {{ page.case.user.name }}
                                            </template>
                                            <template v-else>
                                                --/--
                                            </template>
                                        </template>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="border-0">{{lang.case_id}}</td>
                                    <td class="border-0">{{ page.case.case_number }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="border-0">{{lang.security_number}}</td>
                                    <td class="border-0">{{ page.case.wsn }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="border-0">{{lang.category}}</td>
                                    <td class="border-0 text-black-50">
                                        <template v-if="page.edit">
                                            <label for="status" class="form-label">{{lang.status}}</label>
                                            <select class="form-select" @change="updateCategory(page.case.id)" v-model="page.category_id">
                                                <option value="">{{lang.select}}</option>
                                                <option v-for="(value, id) in categories" :key="id" :value="id">{{value}}</option>
                                            </select>
                                        </template>
                                        <template v-else>
                                            <template v-if="page.case.category">
                                                {{ page.case.category.name }}
                                            </template>
                                            <template v-else>
                                                --/--
                                            </template>
                                        </template>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mb-3 ps-2">
                            <span>{{lang.description}}</span>
                            <span class="text-black-50 d-block">
                                {{ page.case.description }}
                            </span>
                        </div>
                        <div class="mb-3 ps-2">
                            <div>{{lang.files}}</div>
                            <template v-if="page.case.files.length">
                                <div class="row">
                                    <template v-for="(file, index) in page.case.files" :key="index" class="text-black-50 d-block">
                                        <div class="col-md-12">
                                            <template v-if="file.file_type == 'png' || file.file_type == 'jpg'|| file.file_type == 'jpeg'">
                                                <a target="_blank" :href="file.file_path" class="flex border border-secondary rounded-lg mt-1">
                                                    <img :src="file.file_path" class="col-md-1 p-1" style="min-height:52px;" />
                                                    <span class="ml-2 align-self-lg-end">{{ file.file_name }}</span>
                                                </a>
                                            </template>

                                            <template v-else-if="file.file_type == 'pdf'">
                                                <a target="_blank" :href="file.file_path" class="flex border border-secondary rounded-lg mt-1">
                                                    <img src="/images/pdf-2--v2.png" class="col-md-1" />
                                                    <span class="ml-2 align-self-lg-end">{{ file.file_name }}</span>
                                                </a>
                                            </template>

                                            <template v-else-if="file.file_type == 'docx' || file.file_type == 'doc'">
                                                <a target="_blank" :href="file.file_path" class="flex border border-secondary rounded-lg mt-1">
                                                    <img src="/images/microsoft-word-2019.png" class="col-md-1" />
                                                    <span class="ml-2 align-self-lg-end">{{ file.file_name }}</span>
                                                </a>
                                            </template>

                                            <template v-else-if="file.file_type == 'xlsx' || file.file_type == 'xls'">
                                                <a target="_blank" :href="file.file_path" class="flex border border-secondary rounded-lg mt-1">
                                                    <img src="/images/microsoft-excel-2019--v1.png" class="col-md-1" />
                                                    <span class="ml-2 align-self-lg-end">{{ file.file_name }}</span>
                                                </a>
                                            </template>


                                            <template v-else-if="file.file_type == 'csv'">
                                                <a target="_blank" :href="file.file_path" class="flex border border-secondary rounded-lg mt-1">
                                                    <img src="/images/export-csv.png" class="col-md-1" />
                                                    <span class="ml-2 align-self-lg-end">{{ file.file_name }}</span>
                                                </a>
                                            </template>

                                            <template v-else>
                                                <a target="_blank" :href="file.file_path" class="flex border border-secondary rounded-lg mt-1">
                                                    <img src="/images/edit-text-file.png" class="col-md-1" />
                                                    <span class="ml-2 align-self-lg-end">{{ file.file_name }}</span>
                                                </a>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template v-else>
                                --/--
                            </template>
                        </div>
                        <div class="mb-3 ps-2">
                            <span>{{lang.contacts}}</span>
                            <span v-if="page.case.contact_info" class="text-black-50 d-block">{{ page.case.contact_info }}</span>
                            <span v-else class="text-black-50 d-block">--/--</span>
                        </div>

                        <div class="mb-3 ps-2" v-if="page.edit">
                            <div class="mb-3 col-md-12">
                                <label for="note" class="form-label">{{lang.add_note}}</label>
                                <textarea v-model="page.note" autocomplete="off" class="form-control"></textarea>
                                <p class="mt-1 mb-1 text-danger text-sm">{{ page.note_error_message }}</p>

                                <div class="align-items-end d-flex mb-3 mt-3">
                                    <label class="form-check-label mr-2" for="is-private-note">
                                        {{ lang.is_private }}
                                    </label>
                                    <label class="switch_btn">
                                        <input type="checkbox" @click="setNoteType(1)" v-if="!page.is_private">
                                        <input type="checkbox" checked @click="setNoteType(0)" v-else>
                                        <span class="slider"></span>
                                        <span class="labels" data-on="Ja" data-off="Nein"></span>
                                    </label>
                                </div>

                                <button type="submit" @click="addNote(page.case.id)" class="btn btn-primary mt-1">
                                    {{lang.save}}
                                </button>
                                <button type="submit" @click="cancel()" class="btn btn-secondary ml-1 mt-1">
                                    {{lang.cancel}}
                                </button>
                            </div>
                        </div>

                        <div class="mb-3 ps-2">
                            <div class="mb-2 border-b">{{lang.notes}}</div>
                            <template v-if="page.case.notes.length">
                                <div v-for="(note, index) in page.case.notes" :key="index" class="border-bottom">
                                    <template v-if="note.is_private && note.user.id == $page.props.user.id">
                                        <p class="pt-3 text-black-50 d-block">
                                            {{ note.note }}
                                            ({{ lang.private }})
                                        </p>
                                        <p class="text-end text-black-50 d-block">
                                            -{{note.user.name}},  {{note.created_at}}
                                        </p>
                                    </template>
                                    <template v-if="note.is_private == false">
                                        <p class="pt-3 text-black-50 d-block">
                                            {{ note.note }}
                                            ({{ lang.public }})
                                        </p>
                                        <p class="text-end text-black-50 d-block">
                                            -{{note.user.name}},  {{note.created_at}}
                                        </p>
                                    </template>
                                </div>
                            </template>
                            <template v-else>
                                --/--
                            </template>
                        </div>
                    </div>
                </div>

                <div v-else class="col-sm-6 bg-lightblue" id="caseInfo">
                    <div class="d-flex justify-content-center mb-5 mt-5">
                        <img src="/images/logo-whistleblower-service.svg" alt="" class="img-fluid" width="450">
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <h2 class="font-quicksand">Hey {{$page.props.user.name}}!</h2>
                        <img src="/images/thanks-img.png" alt="" class="w-50">
                        <div class="mb-3 position-relative">
                            <p class="text-2 font-volkhov pb-5">{{lang.help_who_need_us_most}}</p>
                            <div class="d-lg-block d-none arrow3 position-absolute">
                                <img src="/images/arrow2.svg" alt="arrow" />
                                <p>{{ lang.click_on_case_1 }}<br/>{{ lang.click_on_case_2 }}</p>
                            </div>
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
    import axios from 'axios';
    import Loader from "@/Shared/Loader"

    export default defineComponent({
        components: {
            PageLayout,
            Loader,
        },

        props:[
            'companies',
            'lang',
            'statuses',
            'categories',
            'company_num',
            'case_num'
        ],

        data(){
            return{
                page:{
                    companies: this.companies,
                    cases: [],
                    case: {},
                    from_dashboard_case: {},
                    loader: false,
                    edit: false,
                    note: '',
                    is_private: 0,
                    note_error_message: '',
                    category_id: '',
                    company_id: '',
                    company_name: '',
                    manager_id: '',
                    managers: [],
                    status_id: '',
                    days: '',
                },

                filter:{
                    status_id: '',
                    overdue: '',
                    case_id: '',
                }
            }
        },

        methods:{

            setNoteType(is_private){
                this.page.is_private = is_private;
            },

            onScroll ({ target: { scrollTop, clientHeight, scrollHeight }}) {

                if (scrollTop + clientHeight >= scrollHeight) {

                    this.getCases(this.page.company_id, this.page.company_name, false, 'scroll');
                }
            },

            resetSearch(){

                this.filter.case_id = '';
                this.filter.status_id = '';
                this.filter.overdue = '';
                this.getCases(this.page.company_id, this.page.company_name, false, 'main');
            },

            getCases(company_id, company_name, mode, from){

                this.page.company_id = company_id;
                if(!mode){
                    this.page.loader = true;
                }
                let data = new FormData;
                data.append('from', from);
                data.append('status_id', this.filter.status_id);
                data.append('overdue', this.filter.overdue);
                data.append('case_id', this.filter.case_id);

                axios.post(route('company.cases', company_id), data).then(response => {

                    if(!mode){
                        this.page.loader = false;
                    }

                    /* Update Case List */
                    if(this.page.cases.length && from == 'scroll'){
                        this.page.cases.push(...response.data.data);
                    }else{
                        this.page.cases = response.data.data;
                    }

                    /* Reset Case View section and Update Selected Company Title */
                    this.page.case = {};
                    this.page.company_name = company_name;
                });
            },

            readCase(object){

                axios.get(route('manager.case.count', object.id)).then(response => {
                    this.$page.props.unseen = response.data;
                });
                this.page.case = object;
                this.page.status_id = object.status_id;
                this.page.category_id = object.category_id;
                this.page.manager_id = object.user_id;
                object.seen = true;
                this.page.edit = false;

                this.page.cases.map( obj => {
                    return obj.selected = '';
                });
                object.selected = 'bg-lightblue';
            },

            edit(){

                this.page.edit = true;

                axios.get(route('manager.manager.list', this.page.company_id)).then(response => {
                    this.page.managers = response.data;
                });
            },

            cancel(){
                this.page.note = "";
                this.page.edit = false;
            },

            addNote(case_id){

                if(this.page.note == ""){
                    this.page.note_error_message = this.lang.note_empty;
                    return;
                }
                this.page.note_error_message = '';
                let data = new FormData;
                data.append('note', this.page.note);
                data.append('is_private', this.page.is_private);
                data.append('case_id', case_id);

                axios.post(route('manager.notes.store'), data).then(response => {

                    this.page.note = "";
                    this.page.edit = false;
                    this.page.case.notes = response.data;
                    Toast.fire({
                        icon:'success',
                        title: this.lang.note_added
                    });
                    this.page.is_private = 0;
                });
            },

            updateStatus(object){

                let data = new FormData;
                data.append('status_id', this.page.status_id);
                data.append('case_id', object.id);

                axios.post(route('manager.case.status'), data).then(response => {

                    this.page.case.status = response.data.status;
                    this.page.case.status_id = response.data.status.id;
                    Toast.fire({
                        icon:'success',
                        title: this.lang.status_updated
                    });
                });
            },

            updateCategory(case_id){

                let data = new FormData;
                data.append('category_id', this.page.category_id);
                data.append('case_id', case_id);

                axios.post(route('manager.notes.category'), data).then(response => {

                    this.page.case.category = response.data.category;
                    this.page.case.category_id = this.page.category_id;
                    Toast.fire({
                        icon:'success',
                        title: this.lang.category_updated
                    });
                });
            },

            updateManager(object){

                if(this.page.manager_id == ""){
                    return;
                }
                let data = new FormData;
                data.append('manager_id', this.page.manager_id);
                data.append('case_id', object.id);

                axios.post(route('manager.case.manager'), data).then(response => {

                    this.page.case.user = response.data.user;
                    this.page.case.user_id = response.data.user.id;
                    Toast.fire({
                        icon:'success',
                        title: this.lang.manager_updated
                    });
                });
            },

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
                        axios.post(route('manager.soft.delete', case_id)).then(response => {

                            this.page.cases.map((object, index) => {
                                if(object.id == case_id){
                                    this.page.cases.splice(index, 1);
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

                Toast.fire({
                    title: this.lang.are_you_sure,
                    text: this.lang.restore_confirmation,
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: this.lang.cancel,
                    confirmButtonText: 'Ok',
                })
                .then((willDelete) => {

                    if (willDelete.isConfirmed) {

                        axios.post(route('manager.case.restore', case_id)).then(response => {

                            this.page.cases.map((object, index) => {
                                if(object.id == case_id){
                                    this.page.cases.splice(index, 1);
                                }
                            });

                            Toast.fire({
                                icon:'success',
                                title: this.lang.restored
                            });
                        });
                    }
                });
            }
        },

        mounted(){

            this.getCases(this.companies.data[0].id, this.companies.data[0].name, false, 'main');
            this.page.company_id = this.companies.data[0].id;

            if(this.case_num){

                axios.get(route('manager.case.detail', this.case_num)).then(response => {

                    this.page.from_dashboard_case = response.data;
                    this.getCases(response.data.company.id, response.data.company.name, false, 'main');
                    axios.get(route('case.count', response.data)).then(response => {
                        this.$page.props.unseen = response.data;
                    });
                });
            }
        }
    })
</script>
