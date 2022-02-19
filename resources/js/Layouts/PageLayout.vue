<template>
    <main>
        <Head :title="title" />
        <div class="d-flex flex-column flex-shrink-0 bg-orange-light w-menu">
            <Link :href="route('manager.dashboard')" class="d-block p-3 active link-dark text-decoration-none border-b-2"
                                                data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only">
                <img src="/images/signet-whistleblower-service.svg" alt="Logo" />
            </Link>

            <ul class="nav nav-pills nav-flush flex-column mb-auto text-center align-items-center">
                <li>
                    <Link :href="route('manager.dashboard')" :class="menu.dashboard" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Dashboard">
                        <img src="/images/dashboard.svg" alt="dashboard" />
                    </Link>
                </li>
                <li>
                    <Link :href="route('manager.cases')" :class="menu.users" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="inbox">
                        <span class="position-relative"><img src="/images/inbox.svg" alt="inbox" />
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $page.props.unseen }}
                            </span>
                        </span>
                    </Link>
                </li>
                <li>
                    <Link :href="route('manager.company')" :class="menu.companies" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Companies">
                        <img src="/images/building.svg" alt="company" />
                    </Link>
                </li>
            </ul>

            <div class="dropdown border-top">
                <a href="#" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false">
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
            <div class="align-items-center p-2 border-bottom topbar d-flex">
                <img v-if="route().current('company.inbox')" src="/images/search.svg" alt="Search" class="cursor-pointer mr-3 animate__animated" id="searchCompany">
                <i v-else class="fa fa-home mr-2" aria-hidden="true"></i>
                <span>{{title}}</span>
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

    export default defineComponent({

        data(){
            return{
                menu:{
                    dashboard : 'nav-link py-3 border-bottom',
                    inbox : 'nav-link py-3 border-bottom',
                    companies : 'nav-link py-3 border-bottom',
                    users : 'nav-link py-3 border-bottom',
                    logs : 'nav-link py-3 border-bottom',
                }
            }
        },

        props:[
            'title'
        ],

        mounted(){
        }
    })
</script>