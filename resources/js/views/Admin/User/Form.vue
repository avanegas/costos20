<template>
    <div class="row">
        <div class="col-md">
			<div class="form-group row mb-3 mt-3">
                <h5 class="col-6">{{action}} User</h5>
				<div class="col-6 mt-2 mb-0">
					<button type="button" class="btn btn-primary mr-1 float-right" @click="save" :disabled="isProcessing">Save</button>
	        		<template v-if="action == 'Update'">
	            		<button type="button" class="btn btn-danger mr-1 float-right" @click.prevent="remove(form)" :disabled="isProcessing">Eliminar</button>
	        		</template>
					<button type="button" class="btn btn-secondary mr-1 float-right" @click="$router.back()" :disabled="isProcessing">Cancel</button>
				</div>
			</div>
			<div class="card">
				<div class="card card-body">
					<div class="form-group">
					    <label>Name</label>
					    <input type="text" class="form-control" v-model="form.name">
					    <small class="error-control" v-if="error.errors.name">{{error.errors.name[0]}}</small>
					</div>
					<div class="form-group">
					    <label >Email</label>
					    <input type="email" class="form-control" v-model="form.email">
					    <small class="error-control" v-if="error.errors.email">{{error.errors.email[0]}}</small>
					</div>
					<div class="form-group">
						<label>Asignar rol</label>
						<v-select multiple label="name" :options="roles" v-model="form.roles">
						</v-select>
					</div>
					<div class="form-group">
					    <label>Password</label>
					    <input type="password" class="form-control" v-model="form.password">
					    <small class="error-control" v-if="error.errors.password">{{error.errors.password[0]}}</small>
					</div>
					<div class="form-group">
					    <label>Confirme Password</label>
					    <input type="password" step="any" class="form-control" v-model="form.password_confirmation">
					    <small class="error-control" v-if="error.errors.password_confirmation">{{error.errors.password_confirmation[0]}}</small>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	import Vue from 'vue'
	import Flash from '../../../helpers/flash'
	import { get, post, del, byMethod } from '../../../helpers/api'
	import { toMulipartedForm } from '../../../helpers/form'
	export default {
		data() {
			return {
				roles:[],
				form: {
					roles:[]
				},
				error: {
					errors:{}
				},
				isProcessing: false,
				initializeURL: `/api/users/create`,
				storeURL: `/api/users`,
				action: 'Create'
			}
		},
		created() {
			if(this.$route.meta.mode === 'edit') {
				this.initializeURL = `/api/users/${this.$route.params.id}/edit`
				this.storeURL = `/api/users/${this.$route.params.id}?_method=PUT`
				this.action = 'Update'
			}
			get(this.initializeURL)
				.then((res) => {
					Vue.set(this.$data, 'form', res.data.form)
				}),
			get(`/api/roles`)
				.then((res) => {
					this.roles = res.data.roles
				})
		},
		methods: {
			save() {
				this.isProcessing = true
				const form = toMulipartedForm(this.form, this.$route.meta.mode)
				post(this.storeURL, form)
				    .then((res) => {
				        if(res.data.saved) {
				            Flash.setSuccess(res.data.message)
				            //this.$router.push(`/users/${res.data.id}`)
							this.$router.back()
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
				del(`/api/users/${this.$route.params.id}`).then((res) => {
					Flash.setSuccess('Ha eliminado correctamente el user!')
					this.$router.back()
				});
      		}
		}
	}
</script>
