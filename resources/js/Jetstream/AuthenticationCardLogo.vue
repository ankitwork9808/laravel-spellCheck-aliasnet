<template>
    <Link :href="'/'">
        <div class="d-flex justify-content-center">
            <img src="/images/logo-whistleblower-service.svg" class="img-fluid" />
        </div>
    </Link>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
    })
</script>
