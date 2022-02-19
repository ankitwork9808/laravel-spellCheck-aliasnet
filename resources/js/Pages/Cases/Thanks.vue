<template>
    <PageLayout>
        <section id="formsubmitted">
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8">
                       <div class="text-center">
                           <img src="/images/thanks-img.png" alt="" class="img-fluid w-50">
                           <h1 class="text-1">{{ lang.thanks_for_submitting }}</h1>
                           <p class="text-2">{{ lang.save_the_following_case_number }}</p>
                           <p class="text-1">{{ lang.fall }} # {{case_number}}</p>
                           <button class="btn bg-primary-2 w-50 text-white">{{ lang.for_case_tracking }}</button>
                       </div>
                    </div>
                </div>
            </div>
        </section>
    </PageLayout>
</template>

<script>
    import { defineComponent } from 'vue';
    import PageLayout from '@/Layouts/PageLayout.vue';

    export default defineComponent({

        components:{
            PageLayout,
        },

        props:[
            'lang',
            'case_number',
        ]
    })
</script>