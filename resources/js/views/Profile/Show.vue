<template>
    <div class="row">
        <div class="col-md">
            <div class="card mt-3">
                <div class="card-header row m-0">
                    <h5 class = "col-3"><i class='fa fa-user-times'></i> Perfil de {{profile.user.name}}</h5>
                    <div class="form-group col-9">
                        <router-link :to="`/profiles/${authState.user_id}/edit`" title="Editar Perfil" class="btn btn-primary btn-sm mr-1 float-right"> Editar</router-link>
                        <button type="button" class="btn btn-secondary btn-sm mr-1 float-right" @click="$router.back()"
                                :disabled="isProcessing">Cancel
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <img v-if="profile.user.image.url" :src="`/images/${profile.user.image.url}`" class="user-avatar mx-auto d-block mt-1">
                    <dl class="user-info">
                        <div class="title">
                            <h5>{{profile.user.name}}</h5>
                        </div>
                        <p><i class="fas fa-id-card-alt info"></i>BIOGRAFIA:</p>
                        <dd>{{profile.bio}}</dd>
                        <hr>
                        <p><i class="fa fa-briefcase info"></i>ACTIVIDAD:
                            <span class="badge badge-primary ml-1" v-if="profile.user.groups" v-for="group in profile.user.groups" :key="group.id">
                                {{ group.name }}
                            </span>
                            <em v-else>No pertenece a algún grupo.</em>
                        </p>
                        <p><i class="fa fa-home info"></i>UBICACION: {{profile.location.country}}</p>
                        <p><i class="fa fa-envelope info"></i>EMAIL: {{profile.user.email}}</p>
                        <p><i class="fa fa-phone info"></i>TELEFONO: {{profile.phone}}</p>
                        <p><i class="fab fa-twitter info"></i><a href="`https://twitter.com/${profile.}`" class="twitter-link" target="_blank"></a>TWITTER: {{profile.twitter_username}}</p>
                        <p><i class="fab fa-github info"></i><a href="https://github.com/${profile.github_username}" class="github-link" target="_blank"></a>GITHUB: {{profile.github_username}}</p>
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
                    </dl>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Auth from '../../store/auth'
    import { get } from '../../helpers/api'
    export default {
        components: {
            Auth
        },
        data() {
            return {
                authState: Auth.state,
                profile: {
                    user:{
                        image:{}
                    },
                    location:{}
                },
                isProcessing: false,
            }
        },
        created() {
            get(`/api/profiles/${this.$route.params.id}`)
                .then((res) => {
                    this.profile = res.data.profile
                })
        }
    }
</script>
