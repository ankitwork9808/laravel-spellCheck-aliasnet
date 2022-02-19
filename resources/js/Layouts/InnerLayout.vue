<template>
    <main>
        <Head :title="title" />
        <div class="d-flex flex-column flex-shrink-0 bg-orange-light w-menu">
            <Link :href="route('admin.dashboard')" class="d-block p-3 active link-dark text-decoration-none border-b-2"
                                                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only">
                <img src="/images/signet-whistleblower-service.svg" alt="Logo" />
            </Link>

            <ul class="nav nav-pills nav-flush flex-column mb-auto text-center align-items-center">
                <li>
                    <Link :href="route('admin.dashboard')" :class="menu.dashboard" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Dashboard" :title="$page.props.common.menu_dashboard">
                        <img src="/images/dashboard.svg" alt="dashboard" />
                    </Link>
                </li>
                <li class="nav-item">
                    <Link :href="route('company.inbox')" :class="menu.inbox" aria-current="page" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Cases" :title="$page.props.common.menu_inbox">
                        <span class="position-relative"><img src="/images/inbox.svg" alt="inbox" />
                          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                              {{ $page.props.unseen }}
                          </span>
                        </span>
                    </Link>
                </li>
                <li>
                    <Link :href="route('users.index')" :class="menu.users" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Users" :title="$page.props.common.menu_users">
                        <img src="/images/users.svg" alt="users" />
                    </Link>
                </li>
                <li>
                    <Link :href="route('companies.index')" :class="menu.companies" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Companies" :title="$page.props.common.menu_companies">
                        <img src="/images/building.svg" alt="companies" />
                    </Link>
                </li>
                <li>
                    <Link :href="route('leads.index')" :class="menu.leads" data-bs-toggle="tooltip" :title="$page.props.common.menu_leads" data-bs-placement="right" data-bs-original-title="Leads">
                        <img src="/images/lead.svg" alt="leads" />
                    </Link>
                </li>
                <li>
                    <Link :href="route('admin.bugs')" :class="menu.logs" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="System Logs" :title="$page.props.common.menu_system_logs">
                        <img src="/images/errorLogs.svg" alt="bugs" />
                    </Link>
                </li>
            </ul>

            <div class="dropdown border-top">
                <a href="#" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false" :title="$page.props.common.menu_user_profile">
                    <img :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" width="34" height="34" class="rounded">
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser3">
                    <li>
                        <Link :href="route('profile.show')" class="dropdown-item">
                            {{ $page.props.common.profile }}
                        </Link>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <Link :href="route('logout')" method="post" as="button" class="dropdown-item">
                            {{ $page.props.common.sign_out }}
                        </Link>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 3ed section start here -->
        <div class="d-flex flex-column mainContent">
            <div class="align-items-center p-2 border-bottom topbar">
               <div class="cursor-pointer w-fitContent d-flex align-items-center" id="searchCompany" :title="$page.props.common.menu_company_switch">
                <i v-if="route().current('company.inbox')" class="fa fa-search cursor-pointer mr-3 d-none"></i>
                <i v-else-if="route().current('companies.index')" class="fa fa-building mr-3"></i>
                <i v-else class="fa fa-home mr-2" aria-hidden="true"></i>

                <template v-if="route().current('company.inbox')">

                    <span class="btn btn-sm btn-outline-dark btnOuter">
                        <template v-if="title != ''">
                            {{ title }} <i class="animate__animated animate__bounceInRight fa fa-arrow-circle-right ml-4"></i>
                        </template>
                        <template v-else>
                            <div class="spinner-border" role="status"></div>
                        </template>
                    </span>
                </template>
                <template v-else>
                    <span>{{title}}</span>
                </template>

              </div>
             </div>
            <div class="overflow-auto">
                <div class="container-fluid">
                    <div class="row">
                        <slot></slot>
                    </div>
                </div>
           </div>
        </div>
    </main>

</template>

<script>
    import { defineComponent } from 'vue'
    import Loader from "@/Shared/Loader"

    export default defineComponent({

        components: {
            Loader,
        },

        data(){
            return{
                menu:{
                    dashboard : 'nav-link py-3 border-bottom',
                    inbox : 'nav-link py-3 border-bottom',
                    companies : 'nav-link py-3 border-bottom',
                    users : 'nav-link py-3 border-bottom',
                    leads : 'nav-link py-3 border-bottom',
                    logs : 'nav-link py-3 border-bottom',
                }
            }
        },

        props:[
            'title',
        ],

        mounted(){

            if(route().current('admin.dashboard')){
                this.menu.dashboard = 'nav-link py-3 border-bottom active';
            }else if(route().current('company.inbox')){
                this.menu.inbox = 'nav-link py-3 border-bottom active';
            }else if(route().current('companies.index') || route().current('companies.create') || route().current('companies.edit') || route().current('companies.show')){
                this.menu.companies = 'nav-link py-3 border-bottom active';
            }else if(route().current('users.index') || route().current('users.create') || route().current('users.edit')){
                this.menu.users = 'nav-link py-3 border-bottom active';
            }else if(route().current('admin.bugs')){
                this.menu.logs = 'nav-link py-3 border-bottom active';
            }else if(route().current('leads.index')){
                this.menu.leads = 'nav-link py-3 border-bottom active';
            }

            if(this.$page.props.flash.success){
                Toast.fire({
                    icon: 'success',
                    title: this.$page.props.flash.success
                });
                this.$page.props.flash.success = null;
            }

            if(this.$page.props.flash.error){
                Toast.fire({
                    icon: 'error',
                    title: this.$page.props.flash.error
                });
                this.$page.props.flash.error = null;
            }
        }
    })
</script>