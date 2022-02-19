<template>
    <inner-layout :title="$page.props.common.system_logs">
        <iframe class="h-full" src="/admin/logs" width="100%" frameborder="0"></iframe>
    </inner-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import InnerLayout from '@/Layouts/InnerLayout.vue'

    export default defineComponent({
        components: {
            InnerLayout,
        },
    })
</script>
