<template>
    <nav v-if="links.length > 3" aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
            <template  v-for="link in links" :key="link.id">
                <li class="page-item disabled" v-if="link.active">
                    <Link class="page-link" :href="link.url" tabindex="-1" aria-disabled="true">
                        <span v-html="link.label"></span>
                    </Link>
                </li>
                <li class="page-item disabled" v-else-if="link.url == null">
                    <Link class="page-link" :href="link.url" tabindex="-1" aria-disabled="true">
                        <span v-html="link.label"></span>
                    </Link>
                </li>
                <li class="page-item" v-else>
                    <Link class="page-link" :href="link.url" tabindex="-1" aria-disabled="true">
                        <span v-html="link.label"></span>
                    </Link>
                </li>
            </template>
        </ul>
    </nav>
</template>
<script>
export default {
    props:['links'],
}
</script>
