<template>
    <div class="row">
        <div class="col-md">
            <div class="card mt-3">
                <div class="card-header row m-0">
                    <h5 class = "col-4"><i class='fa fa-user-times'></i> {{action}} Perfil de {{form.user.name}}</h5>
                    <div class="form-group col-8">
                        <button type="button" class="btn btn-primary btn-sm mr-1 float-right" @click="save" :disabled="isProcessing"> Save</button>
                        <button type="button" class="btn btn-secondary btn-sm mr-1 float-right" @click="$router.back()" :disabled="isProcessing"> Cancel
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="border" >
                        <img v-if="form.avatar_status === 1" :src="`/images/${form.user.image.url}`" alt="avatar" class="user-avatar mx-auto d-block mt-1">
                        <img v-else :src="`/images/profile.png`" alt="avatar" class="user-avatar mx-auto d-block">
                        <div class="mt-3 mb-3">
                            <p class="text-center font-weight-bold">Arrastre y suelte los archivos a subir aqui.</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 btn-group">
                            <div class="col-6 col-xs-6 right-btn-container">
                                <label class="btn btn-primary btn-block" for="0">
                                    <input type="radio" id="0" value="0" v-model="form.avatar_status" > Use Gravatar
                                </label>
                            </div>
                            <div class="col-6 col-xs-6 left-btn-container">
                                <label class="btn btn-primary btn-block" for="1">
                                    <input type="radio" id="1" value="1" v-model="form.avatar_status"> Use My Image
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <div class="col-sm">
                            <label class="font-weight-bold mr-5" for="status"><i class="fas fa-toggle-on info"></i> Status</label>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="public">
                                    <input class="form-check-input" type="radio" name="status" id="public" value="PUBLIC" v-model="form.status">
                                    PUBLICO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="private">
                                    <input class="form-check-input" type="radio" name="status" id="private" value="PRIVATE" v-model="form.status">
                                    PRIVADO </label>
                            </div>
                        </div>
                        <div class="col-sm">
                            <label class="font-weight-bold mr-5" for="ok"><i class="fas fa-toggle-on info"></i> Habilitado</label>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="ok">
                                    <input name="activated" class="form-check-input" type="radio" id="ok" value="1" v-model="form.activated">
                                    SI </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="out">
                                    <input name="activated" class="form-check-input" type="radio" id="out" value="0" v-model="form.activated">
                                    NO </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label class="font-weight-bold ml-3" for="groups"><i class="fa fa-briefcase info"></i> Actividad:</label>
                        <v-select multiple label="name" id="groups" class="ml-2" :options="groups" v-model="form.user.groups">
                        </v-select>
                    </div>
                    <div class="form-group row mt-3">
                        <label class="font-weight-bold ml-3" for="bio"><i class="fas fa-id-card-alt info"></i> Biografía:</label>
                        <div class="col-md">
                            <textarea name="bio" id="bio" rows="8" class="form-control required" v-model=" form.bio"></textarea>
                            <small class="error-control" v-if="error.errors.bio">{{error.errors.bio[0]}}</small>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label class="font-weight-bold ml-3" for="country"><i class="fa fa-home info"></i> Ubicación:</label>
                        <div class="col-md">
                            <input type="text" name="country" class="form-control" id="country" v-model="form.location.country">
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label class="font-weight-bold ml-3" for="email"><i class="fa fa-envelope info"></i> Email:</label>
                        <div class="col-md">
                            <input type="text" name="email" class="form-control" id="email" v-model="form.user.email">
                            <small class="error-control" v-if="error.errors.email">{{error.errors.email[0]}}</small>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label class="font-weight-bold ml-3" for="phone"><i class="fa fa-phone info"></i> Phone</label>
                        <div class="col-md">
                            <input type="text" name="phone" class="form-control" id="phone" v-model="form.phone">
                            <small class="error-control" v-if="error.errors.phone">{{error.errors.phone[0]}}</small>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label class="font-weight-bold ml-3" for="twitter_username"><i class="fab fa-twitter info"></i> twitter</label>
                        <div class="col-md">
                            <input type="text" name="twitter_username" class="form-control" id="twitter_username" v-model=" form.twitter_username ">
                            <small class="error-control" v-if="error.errors.twitter_username">{{error.errors.twitter_username[0]}}</small>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label class="font-weight-bold ml-3" for="github_username"><i class="fab fa-github info"></i> github</label>
                        <div class="col-md">
                            <input type="text" name="github_username" class="form-control" id="github_username" v-model=" form.github_username ">
                            <small class="error-control" v-if="error.errors.github_username">{{error.errors.github_username[0]}}</small>
                        </div>
                    </div>

                    <hr>
                    <p><i class="fa fa-asterisk info"></i>Habilidades</p>
                    <p class = "mt-3 mb-0">Software</p>
                    <div class="skill-bar">
                        <div class="progress-bar" style="width:80%">80%</div>
                    </div>
                    <p class = "mt-3 mb-0">Programación</p>
                    <div class="skill-bar">
                        <div class="progress-bar" style="width:80%">80%</div>
                    </div>
                    <p class = "mt-3 mb-0">Construcción</p>
                    <div class="skill-bar">
                        <div class="progress-bar" style="width:80%">80%</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue'
    import Auth from '../../store/auth'
    import Flash from '../../helpers/flash'
    import { get, post, del, byMethod } from '../../helpers/api'
    import { toMulipartedForm } from '../../helpers/form'
    import ImageUpload from '../../components/ImageUpload.vue'
    export default {
        components: {
            Auth,
            ImageUpload
        },
        data() {
            return {
                authState: Auth.state,
                groups: [],
                form: {
                    user:{
                        groups: [],
                        image: {}
                    },
                    location: {}
                },
                error: {
                    errors:{}
                },
                isProcessing: false,
                initializeURL: `/api/profiles/create`,
                storeURL: `/api/profiles`,
                action: 'Create'
            }
        },
        created() {
            if(this.$route.meta.mode === 'edit') {
                this.initializeURL = `/api/profiles/${this.$route.params.id}/edit`
                this.storeURL = `/api/profiles/${this.$route.params.id}?_method=PUT`
                this.action = 'Update'
            }
            get(this.initializeURL)
                .then((res) => {
                    Vue.set(this.$data, 'form', res.data.form)
                }),
                get(`/api/groups`)
                    .then((res) => {
                        this.groups = res.data.groups
                    })
        },
        methods: {
            save() {
                this.isProcessing = true;
                this.form.user_id = this.authState.user_id;
                const form = toMulipartedForm(this.form, this.$route.meta.mode);
                post(this.storeURL, form)
                    .then((res) => {
                        if(res.data.saved) {
                            Flash.setSuccess(res.data.message)
                            this.$router.push(`/profiles/${res.data.id}`)
                        }
                        this.isProcessing = false
                    })
                    .catch((err) => {
                        if(err.response.status === 422) {
                            this.error = err.response.data
                        }
                        this.isProcessing = false
                    })
            },
            remove() {
                del(`/api/profiles/${this.$route.params.id}`).then((res) => {
                    Flash.setSuccess('Ha eliminado correctamente el Perfil!')
                    this.$router.back()
                });
            }
        }
    }
</script>
