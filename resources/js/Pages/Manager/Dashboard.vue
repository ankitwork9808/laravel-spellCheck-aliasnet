<template>
    <page-layout title="Dashboard">

        <div class="col-sm-12 mt-3">
            <label for="ByCategory" class="text-lg">Cases count grouped by status</label>
            <div class="row mt-3">
                <div v-for="status in statuses" :key="status.id" class="col-sm-4 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold text-gray-600 text-lg text-uppercase mb-2">{{status.name}}</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{status.case_count}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tools fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 mt-3">
            <label for="ByCategory" class="text-lg">Categories with case count</label>
            <div class="row mt-3">
                <div v-for="category in categories" :key="category.id" class="col-sm-2 mb-4">
                    <div class="card shadow-md h-100 py-2 border-primary border-left-primary">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold text-gray-600 text-uppercase mb-2 text-sm">{{category.name}}</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800 badge rounded-pill bg-primary">{{category.case_count}}</div>
                                </div>
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
    import Welcome from '@/Jetstream/Welcome.vue'
    import PageLayout from '@/Layouts/PageLayout.vue'

    export default defineComponent({
        components: {
            PageLayout,
            Welcome,
        },
        props:[
            'categories',
            'statuses'
        ],
    })
</script>
