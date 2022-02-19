<template>
    <PageLayout>
        <section id="caseform">
            <div class="container px-4">
                <div class="row gx-4 justify-content-center">
                    <div class="col-lg-8">
                        <form @submit.prevent="create">

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">{{lang.company_id}} <Required /></label>
                                <input type="text" v-model="form.company_id" class="form-control customInput" aria-describedby="emailHelp" required />
                                <jet-input-error :message="form.errors.company_id" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <label for="Betreff" class="form-label">{{lang.subject}} <Required /></label>
                                <input type="text" v-model="form.subject" class="form-control customInput" aria-describedby="emailHelp" required />
                                <jet-input-error :message="form.errors.subject" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <label for="Kategorie" class="form-label">{{lang.category}}</label>
                                <select v-model="form.category_id" class="form-select customInput" aria-label="Default select example">
                                    <option value="">{{lang.optional}}</option>
                                    <template v-for="(name, id) in categories" :key="id">
                                        <option :value="id">{{name}}</option>
                                    </template>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="Beschreibung" class="form-label">{{lang.description}} <Required /></label>
                                <textarea type="text" v-model="form.description" class="form-control customInput" aria-describedby="emailHelp" rows="5" required></textarea>
                                <jet-input-error :message="form.errors.description" class="mt-2" />
                            </div>

                            <div class="mb-3">
                                <label for="atei-hochladen" class="form-label">{{lang.upload_file}}</label>
                                <FileUpload v-on:file:upload:event="uploadFiles" />
                            </div>

                            <div class="mb-3">
                                <label for="Kontaktinfo" class="form-label">{{lang.contact_info}}</label>
                                <input type="text" v-model="form.contact_info" class="form-control customInput" aria-describedby="emailHelp">
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" required />
                                <label class="form-check-label" for="ichbin">{{lang.policy_text}}</label>
                            </div>

                            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                {{lang.send_message}}
                            </jet-button>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </PageLayout>
</template>

<script>
    import { defineComponent } from 'vue';
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Required from "@/Shared/Required";
    import JetInputError from '@/Jetstream/InputError.vue';
    import JetButton from '@/Jetstream/Button.vue';
    import FileUpload from "@/Shared/FileUpload";

    export default defineComponent({

        components:{
            PageLayout,
            Required,
            JetInputError,
            JetButton,
            FileUpload,
        },

        props:[
            'lang',
            'categories',
        ],

        data(){
            return{
                form:this.$inertia.form({
                    company_id: '',
                    category_id: '',
                    subject: '',
                    description: '',
                    contact_info: '',
                    files: [],
                }),
            }
        },

        methods: {

            create()
            {
                this.form.post(route('case.store'), {
                    errorBag: 'create',
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                    onError: () => {

                        if (this.form.errors.company_id) {
                            this.$refs.company_id.focus();
                        }

                        if (this.form.errors.subject) {
                            this.$refs.subject.focus();
                        }

                        if (this.form.errors.description) {
                            this.$refs.description.focus();
                        }
                    }
                });
            },

            uploadFiles(files){

                this.form.files = files;
            },

            async recaptcha() {
                // (optional) Wait until recaptcha has been loaded.
                await this.$recaptchaLoaded()

                // Execute reCAPTCHA with action "login".
                const token = await this.$recaptcha('login')

                // Do stuff with the received token.
            }
        }
    })
</script>