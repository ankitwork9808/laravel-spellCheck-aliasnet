<template>
    <div style="width: 240px; margin: 200px auto;">
        <div class="flex">
            <strong>Welcome to the Whistleblower!</strong>
            <!-- <div class="flex-shrink-0 flex items-center">
                <jet-nav-link :href="route('case.new')" class="btn btn-success" :active="route().current('case.new')">
                    Neuen Fall melden
                </jet-nav-link>
            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <jet-nav-link :href="route('case.tracking')" class="btn btn-success btn-large" :active="route().current('case.tracking')">
                    Fallverfolgung
                </jet-nav-link>
            </div> -->
        </div>
    </div>
</template>
<script>
    import { defineComponent } from 'vue';
    import PageLayout from '@/Layouts/PageLayout.vue';
    import JetNavLink from '@/Jetstream/NavLink.vue'

    export default defineComponent({

        components:{
            PageLayout,
            JetNavLink,
        }
    })
</script>
