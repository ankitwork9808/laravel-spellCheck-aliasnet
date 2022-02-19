<template>
    <div>
        <div class="bg-white border-2 border-dotted relative rounded w-full">
            <input type="file" class="absolute cursor-pointer h-full opacity-0 w-full" v-on:change="fileUpload" :required="is_required" accept="application/pdf,docx,doc,xls,xlsx,image/*"/>

            <p class="font-semibold mt-5 text-center text-gray-900">
                {{ $page.props.lang.drop_files }}
            </p>
            <p class="mb-5 text-blue-700 text-center text-sm">
                {{ $page.props.lang.drag_by_clicking_here }}
            </p>
        </div>

        <div class="flex p-2">
            <div class="border p-1 relative mr-2" v-for="(item, index) in images" :key="index">
                <img src="/images/svg/agriment-file.svg" :alt="item.name" width="120" height="200" v-if="item.path.includes('.pdf')"/>
                <img :src="`${item.path}`" :alt="item.name" width="120" height="200" v-else/>
                <div class="absolute top-2 right-2">
                    <a class="_view_file border-0 btn btn-sm btn-success cursor-pointer shadow-lg text-white mr-1" :href="`${item.path}`" target="_BLANK">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                        </svg>
                    </a>
                    <button type="button" class="bg-theme-6 btn-success border-0 btn btn-sm cursor-pointer shadow-lg text-white" @click="removeFileNode(index, item)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="border p-1 relative mr-2" v-if="img_processing">
                <img src="/images/svg/loading.svg" alt="Loading..." width="120" height="120"/>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { defineComponent } from 'vue';

export default defineComponent({

    name: "FileUpload",
    props: {
        is_required: {
            default: false
        }
    },

    data() {
        return {
            images:[],
            img_processing: false
        }
    },

    emits:[
        "file:upload:event"
    ],

    methods: {
        fileUpload(e) {

            if(e.target.files[0] !== undefined){

                let data = new FormData();
                data.append('file', e.target.files[0]);
                this.img_processing = true;

                axios.post(route('file.upload','with_name'), data)
                .then(response => {

                    this.images.push({
                        'name' : response.data.original_name,
                        'path' : response.data.path
                    });
                    this.img_processing = false;

                    this.$emit("file:upload:event", this.images);

                }).catch((error) => {
                    Toast.fire({
                        icon: "error",
                        title: this.$page.props.lang.file_deletetion_error,
                    });
                    this.img_processing = false;
                });
            }
        },

        removeFileNode(index, item) {

            log(index);
            this.images.splice(index, 1);
            let data = new FormData();
            data.append('file_path', item.path);
            axios.post(route('delete.file'), data).then(response => {
                // log(response.data);
            })
        }
    },
});
</script>