<template>
	<div class="row">
        <div class="col-md">
            <div class="row m-0 mt-3">
                <h5 class="col-6"><i class="fa fa-lock-open"></i> Administración</h5>
                <div class="form-group col-6 mt-2 mb-0 p-0">
                    <router-link to="/permissions"  class="btn btn-secondary btn-sm mr-1 float-right"> Permisos</router-link>
                    <router-link to="/roles"        class="btn btn-secondary btn-sm mr-1 float-right"> Roles</router-link>
                    <router-link to="/users"        class="btn btn-secondary btn-sm mr-1 float-right"> Usuarios</router-link>
                    <router-link to="/groups"       class="btn btn-secondary btn-sm mr-1 float-right"> Actividad</router-link>
                </div>
            </div>
            <div class="form-group row m-0 mt-2 mb-2">
                <h5 class="col-6"><i class="fa fa-users"></i> Roles</h5>
                <div class="col-6 p-0">
                    <router-link to="/roles/create" class="btn btn-primary mr-1 float-right"> Nuevo</router-link>
                    <input
                        type="search"
                        class="form-control col-8 mr-sm-2 mb-sm-0 mr-1 float-right"
                        placeholder="Search..."
                        autocomplete="off"
                        v-model="searchQuery">
                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <lista-search
                        :data="gridData"
                        :columns="gridColumns"
                        :filter-key="searchQuery"
                        :lista="lista"
                        :isAutorized="isAutorized">
                    </lista-search>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import { get } from '../../../helpers/api'
    import ListaSearch from '../../../components/ListaSearch.vue'
    export default {
        components: {
            ListaSearch
        },
        data() {
            return {
                searchQuery:'',
                gridData: [],
                gridColumns:['name', 'permissions'],
                lista:'roles',
                isAutorized: false
            }
        },
        created() {
            get(`../api/roles`)
                .then((res) => {
                //    console.log(res);
                    this.gridData = res.data.roles
                })
        }
    }
</script>
