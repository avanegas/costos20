<template>
	<div class="row">
		<div class="col-md">
            <div class="form-group row mb-3 mt-3">
				<div class="form-group col-10">
					<p><strong>AUTOR: </strong>{{proyecto.user.name}}</p>
				</div>
				<div v-if="authState.api_token && authState.user_id === proyecto.user_id">
					<router-link to="/proyectos" class="btn btn-secondary btn-sm"> Back</router-link>
					<router-link :to="`/proyectos/${proyecto.id}/edit`" class="btn btn-primary btn-sm"> Edit</router-link>
					<button type="button" class="btn btn-danger btn-sm" @click="deleteItem"> Delete</button>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<div class="form-row row">
						<div class="col-8">
							<label class="font-weight-bold">PROYECTO</label>
							<h6>{{proyecto.name}}</h6>
						</div>
						<div class="col-3">
							<label class="font-weight-bold">UBICACION</label>
							<p>{{proyecto.ubicacion}}</p>
						</div>
						<div class="col-1">
							<label class="font-weight-bold">DISTANCIA</label>
							<p>{{proyecto.distancia}}</p>
						</div>
					</div>
					<div class="form-row row">
						<div class="col-8">
							<label class="font-weight-bold">CONTRATANTE</label>
							<p>{{proyecto.contratante}}</p>
						</div>
						<div class="col-2">
							<label class="font-weight-bold">PRESENTACION</label>
							<p>{{proyecto.entrega}}</p>
						</div>
						<div class="col-1">
							<label class="font-weight-bold">FORMA</label>
							<p>{{proyecto.formato}}</p>
						</div>
						<div class="col-1">
							<label class="font-weight-bold">#DEC.</label>
							<p>{{proyecto.precision}}</p>
						</div>
					</div>
					<div class="form-row row">
						<div class="col-4">
							<label class="font-weight-bold">OFERENTE</label>
							<p>{{proyecto.oferente}}</p>
						</div>
						<div class="col-4">
							<label class="font-weight-bold">REPRESENTANTE</label>
							<p>{{proyecto.representante}}</p>
						</div>
	                    <div class="col-2">
	                        <label class="font-weight-bold">REFERENCIAL</label>
	                        <p>{{proyecto.referencial}}</p>
	                    </div>
						<div class="col-1">
							<label class="font-weight-bold">C.IND.</label>
							<p>{{proyecto.indirecto}}</p>
						</div>
						<div class="col-1">
							<label class="font-weight-bold">I.V.A.</label>
							<p>{{proyecto.descuento}}</p>
						</div>
					</div>

					<h5 class="text-center font-weight-bold mt-5 mb-0">TABLA DE DESCRIPCION DE RUBROS, UNIDADES, CANTIDADES Y PRECIOS</h5>
					<table class="table table-bordered table-striped table-sm">
						<thead>
							<tr>
								<th style=" width:10%;">Id</th>
								<th style=" width:10%;">Rubro Nº</th>
								<th>Descripcion</th>
								<th style=" width:10%;">Unidad</th>
								<th style=" width:10%;">Cantidad</th>
								<th style=" width:10%;">Precio</th>
								<th style=" width:10%;">Total</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="rubro in proyecto.rubros" :key="rubro.id">
								<td>{{rubro.precio_id}}</td>
								<td>{{rubro.orden}}</td>
								<td>{{rubro.rubro}}</td>
								<td>{{rubro.unidad}}</td>
								<td>{{rubro.cantidad}}</td>
								<td>{{rubro.precio}}</td>
								<td>{{rubro.cantidad * rubro.precio}}</td>
							</tr>
						</tbody>

						<tfoot>
							<tr>
								<td colspan="5"></td>
								<td> Subtotal</td>
								<td>{{ proyecto.sub_total }}</td>
							</tr>
							<tr>
								<td colspan="5"></td>
								<td>IVA %</td>
								<td>{{ proyecto.descuento }}</td>
							</tr>
							<tr>
								<td colspan="5"></td>
								<td>Total</td>
								<td>{{ proyecto.gran_total }}</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
    import Vue from 'vue'
	import Auth from '../../store/auth'
	import Flash from '../../helpers/flash'
	import { get, byMethod } from '../../helpers/api'
	export default {
		data() {
			return {
				authState: Auth.state,
				proyecto: {
					rubros: [],
                    user: {}
				}
			}
		},
        beforeRouteEnter(to, from, next) {
            get(`/api/proyectos/${to.params.id}`)
                .then((res) => {
                	//console.log(res);
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(`/api/proyectos/${to.params.id}`)
                .then((res) => {
                	//console.log(res);
                    this.setData(res)
                    next()
                })
        },
        methods: {
            setData(res) {
                Vue.set(this.$data, 'proyecto', res.data.proyecto)
                this.show = true
                this.$bar.finish()
            },
            deleteItem() {
                byMethod('delete', `/api/proyectos/${this.proyecto.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$router.push('/proyectos')
                        }
                    })
            }
        }
	}
</script>
