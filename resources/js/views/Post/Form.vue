<template>
    <div class="row">
        <div class="col-md">
            <div class="form-group row mb-3 mt-3">
                <div class="form-group col-10">
                    <h5>{{action}} Artículo</h5>
                </div>
                <div>
                    <button type="button" class="btn btn-primary btn-sm" @click="save" :disabled="isProcessing"> Save</button>
                    <template v-if="action == 'Update'">
                        <button type="button" class="btn btn-danger btn-sm" @click.prevent="remove(form)" :disabled="isProcessing"> Eliminar</button>
                    </template>
                    <button type="button" class="btn btn-secondary btn-sm" @click="$router.back()" :disabled="isProcessing"> Cancel</button>
                </div>
            </div>

            <div class="card">
                <div class="card card-body">
                    <div class="image-show">
                        <div class="card-body">
                            <image-upload v-model="form.image.url"></image-upload>
                            <!--<small class="error-control" v-if="error.image.url">{{error.errors.image.url[0]}}</small>-->
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category_id">Categoría</label>
                                <select id="category_id" name="category_id" class="form-control"
                                        v-model="form.category_id">
                                    <option disabled value="">Seleccione</option>
                                    <option v-for="c in categories" :value="c.id"
                                            selected=" form.category_id == c.id ? true : false ">{{ c.name }}
                                    </option>
                                </select>
                                <small class="error-control" v-if="error.errors.category_id">{{error.errors.category_id[0]}}</small>
                            </div>
                            <div class="form-group">
                                <label>Titulo</label>
                                <input type="text" class="form-control" v-model="form.name">
                                <small class="error-control" v-if="error.errors.name">{{error.errors.name[0]}}</small>
                            </div>
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" class="form-control input-sm" name="slug" :value="slug">
                            </div>
                            <div class="form-group">
                                <label>Resumen</label>
                                <textarea class="form-control form-description" rows="6" v-model="form.excerpt"></textarea>
                                <small class="error-control" v-if="error.errors.excerpt">{{error.errors.excerpt[0]}}</small>
                            </div>
                            <div class="form-group">
                                <label>Contenido</label>
                                <textarea class="form-control form-description" rows="8" v-model="form.body"></textarea>
                                <small class="error-control" v-if="error.errors.body">{{error.errors.body[0]}}</small>
                            </div>
                            <div class="form-group">
                                <p>Estado del artículo</p>
                                <input type="radio" id="DRAFT" value="DRAFT" v-model="form.status">
                                <label for="DRAFT">DRAFT</label>
                                <input type="radio" id="PUBLISHED" value="PUBLISHED" v-model="form.status">
                                <label for="PUBLISHED">PUBLISHED</label>
                            </div>
                            <div class="form-group">
                                <label>Seleccione las etiquétas de categoría específica:</label>
                                <div>
                                    <v-select multiple label="name" :options="tags" v-model="form.tags"></v-select>
                                </div>
                                <small class="error-control" v-if="error.errors.tags">{{error.errors.tags[0]}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
    import Auth from '../../store/auth'
    import Flash from '../../helpers/flash'
    import {get, post, del, byMethod} from '../../helpers/api'
    import {toMulipartedForm} from '../../helpers/form'
    import ImageUpload from '../../components/ImageUpload.vue'

    import {Typeahead } from '../../components/typeahead'

    function initialize(to) {
        let urls = {
            'create': `/api/posts/create`,
            'edit': `/api/posts/${to.params.id}/edit`
        }

        return (urls[to.meta.mode] || urls['create'])
    }

    export default {
        components: {
            Typeahead,
            ImageUpload
        },
        data() {
            return {
                authState: Auth.state,
                categories: [],
                tags: [],
                form: {
                    image: [],
                    tags: []
                },
                error: {
                    errors: {}
                },
                isProcessing: false,
                initializeURL: `/api/posts/create`,
                storeURL: `/api/posts`,
                action: 'Create'
            }
        },
        created() {
            if (this.$route.meta.mode === 'edit') {
                this.initializeURL = `/api/posts/${this.$route.params.id}/edit`
                this.storeURL = `/api/posts/${this.$route.params.id}?_method=PUT`
                this.action = 'Update'
            }
            get(this.initializeURL)
                .then((res) => {
                    Vue.set(this.$data, 'form', res.data.form)
                }),
                get(`/api/categories`)
                    .then((res) => {
                        this.categories = res.data.categories
                    }),
                get(`/api/tags`)
                    .then((res) => {
                        this.tags = res.data.tags
                    })
        },
        computed: {
            slug: function () {
                this.form.slug = this.sanitizeName(this.form.name);
                return this.form.slug;
            }
        },
        methods: {
            sanitizeName: function (title) {
                let slug = "";
                if (title != undefined) {
                    // Change to LowerCase
                    let titleLower = title.toLowerCase();
                    // Letter "e"
                    slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
                    // Letter "a"
                    slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
                    // Letter "o"
                    slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
                    // Letter "u"
                    slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
                    // Letter "d"
                    slug = slug.replace(/đ/gi, 'd');
                    // Trim the last whitespace
                    slug = slug.replace(/\s*$/g, '');
                    // Change whitespace to "-"
                    slug = slug.replace(/\s+/g, '-');
                }
                return slug;
            },
            save() {
                this.isProcessing = true;
                this.form.user_id = this.authState.user_id;
                const form = toMulipartedForm(this.form, this.$route.meta.mode);
                post(this.storeURL, form)
                    .then((res) => {
                        if (res.data.saved) {
                            Flash.setSuccess(res.data.message)
                            this.$router.push(`/posts/${res.data.id}`)
                        }
                        this.isProcessing = false
                    })
                    .catch((err) => {
                        if (err.response.status === 422) {
                            this.error = err.response.data
                        }
                        this.isProcessing = false
                    })
            },
            remove() {
                del(`/api/posts/${this.$route.params.id}`).then((res) => {
                    Flash.setSuccess('Ha eliminado correctamente el Post!')
                    this.$router.back()
                });
            }
        }
    }
</script>
