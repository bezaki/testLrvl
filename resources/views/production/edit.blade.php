@extends('default')

@section('head_title')
	{{$Edit?'Modification':'Détail'}} Production
@endsection

@section('title')
	@if ($Edit)
		<span class="fa fa-edit"></span> Modification Production
	@else
		Détail Production
	@endif
@endsection
@section('head')
	<link rel="stylesheet" href="{{asset('assets/datepicker_dist/css/datepicker.min.css')}}"  type="text/css">
	<style>
		label.recalculer{
			display: block;
			font-weight: 100;
		}
		label.recalculer a{
			float: right;
			padding: 7px 23px;
		}
		
		  .fst_header, .snd_header, .trd_header{
		   color: white;
		  }
		  .fst_header{
		   background-color: #47bdd0;
		   } 
		  .snd_header{
		   background-color: #3faebf;   
		   }
		  .trd_header{
		   background-color: #168798;
		  }
		  
		  .input_stot{
		      box-shadow: 0px 0px 6px -4px black;
		      font-weight: bold;
		      font-size: 1.2em;
		  }
		  .indicator-r{
		      float: right;
		      padding: 3px 11px;
		      background-color: #ffffff;
		      color: #4a4a4a;
		      margin-top: -1px;
		      border-radius: 100px;
		      font-size: 17px;
		      box-shadow: 0px 0px 7px -2px black;
		      margin-left: 8px;
		  }

		  .indicator-rd{
		   float: right;
		      padding: 3px 11px;
		      background-color: #47b0d0;
		      color: #ffffff;
		      margin-top: 2px;
		      border-radius: 100px;
		      font-size: 17px;
		      box-shadow: 0px 0px 8px -3px black;
		      border: 1px white solid;
		      margin-left: 8px;
		  }
		  
		   .indicator-rs{
		    padding: 1px 9px;
		    font-size: 13px;
		    margin-top: 1px;
		    opacity: 0.8;
		  }
		  .indicator-rds{
		    padding: 1px 8px;
		    font-size: 13px;
		    margin-top: 7px;
		    opacity: 0.8;
		  }
		  html {
		  scroll-behavior: smooth;
		}
		form{
			margin-bottom: 100px;
		}
		.badge-success{
			background-color: #6c757d73;
		    color: black;
		    font-size: 12.5px;
		    font-weight: 200;
		    padding: 5px 12px !important;

		}
		.badge-success[href]:focus, .badge-success[href]:hover {
		    color: #fff;
		    text-decoration: none;
		    background-color: #58615a;
		}
		label span {
		    display: inline-block;
		    /* float: right; */
		    font-weight: 100;
		    font-size: 11px;
		}
	</style>
@endsection

@section('content')
	<form id="root" name="formEditProd" action="{{route('production.update',$production->id)}}" method="post">
	@csrf
	<div class="row">
		<div class="col-12">
			<div class="card m-b-30" id="infos">
			    <div class="card-header fst_header">
			     <h4 class="header-title"> <span class="typcn typcn-info-large"></span> {{$Edit?'Modification':'Détail'}} Information de la Production <a href="#autre_commission"><span class="indicator-r indicator-rs">3</span></a> <a href="#cal_commission"><span class="indicator-r indicator-rs">2</span></a> <a href="#infos"><span class="indicator-r">1</span></a></h4>
			    </div>

					<div class="card-body">


					<div class="row">
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="form-group">
								<label for="POL_QTC" class="col-form-label">N° QTC</label>
								<input class="form-control" readonly required type="text" name="POL_QTC" id="POL_QTC"  v-model="prodInit.POL_QTC">
							</div>
						</div>
						<div class="col-lg-2 col-md-6 col-sm-12">
							<div class="form-group">
								<label for="POL_CLS" class="col-form-label">classe</label>
								<input class="form-control" v-model="prodInit.POL_CLS" readonly required type="text" name="POL_CLS" id="POL_CLS" >
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="form-group">
								<label for="POL_BRN" class="col-form-label">Branche </label>
								<input class="form-control" readonly name="POL_BRN" v-model="prodInit.POL_BRN" required type="text" id="POL_BRN">
							</div>
						</div>
					
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="form-group">
								<label for="POL_REF" class=" col-form-label">Réference</label>
								<input class="form-control" readonly name="POL_REF" required type="text" id="POL_REF" v-model="prodInit.POL_REF">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="form-group">
								<label for="POL_SOUSCRIPTION" class="col-form-label"><i class="fa fa-calendar-plus-o"></i> Souscription <span>(Champ obligatoire)</span></label>
								<input data-timepicker="true" data-language='fr' class="form-control input_stot" name="POL_SOUSCRIPTION" type="date-time" data-format="YYYY-MM-DD" id="POL_SOUSCRIPTION" v-model="prodInit.POL_SOUSCRIPTION">
							</div>
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="form-group">
								<label for="POL_EFFET" class="col-form-label"><i class="fa fa-calendar-check-o"></i> Effet <span>(Champ obligatoire)</span></label>
								<input data-timepicker="true" data-language='fr' class="form-control input_stot" name="POL_EFFET" type="date-time" id="POL_EFFET" v-model="prodInit.POL_EFFET">
							</div>
						</div>

						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="form-group">
								<label for="POL_EXPIRATION" class="col-form-label"><i class="fa fa-calendar-times-o"></i> Expiration <span>(Champ obligatoire)</span></label>
								<input data-timepicker="true" data-language='fr' class="form-control input_stot" name="POL_EXPIRATION" type="date-time" id="POL_EXPIRATION" v-model="prodInit.POL_EXPIRATION">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="form-group">
								<label for="POL_NUM" class="col-form-label">Num police </label>
								<input class="form-control" name="POL_NUM" readonly type="text" required  id="POL_NUM" v-model="prodInit.POL_NUM">
							</div>
						</div>
					<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="form-group">
								<label for="POL_NUM_AA" class="col-form-label">Num Avis </label>
								<input class="form-control" name="POL_NUM_AA" type="text" readonly id="POL_NUM_AA" v-model="prodInit.POL_NUM_AA">
							</div>
						</div>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="form-group">
								<label for="POL_INS_NAME" class="col-form-label"><i class="ion ion-person"></i> Assuré <span>(Champ obligatoire)</span></label>
								<input class="form-control input_stot" name="POL_INS_NAME" type="text" required id="POL_INS_NAME" v-model="prodInit.POL_INS_NAME">
							</div>
						</div>
					</div>

					{{-- <h4 class="col-form-label"> Information de la Prime</h4> --}}

					

					{{-- <h4 class="col-form-label"> Information de la Prime</h4> --}}
						
				</div>
			</div>
		</div><!-- end col -->
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="card m-b-30" id="cal_commission">  
			    <div class="card-header snd_header">
			     <h4 class="header-title"> <span class="mdi mdi-calculator"></span> Calculs Commission <a href="#autre_commission"><span class="indicator-r indicator-rs">3</span></a> <a href="#cal_commission"><span class="indicator-r">2</span></a> <a href="#infos"><span class="indicator-r indicator-rs">1</span></a></h4>
			    </div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="commGestion" class="col-form-label">Commision de Gestion </label>
								<input class="form-control recalcul" name="commGestion" type="number" step="0.01" id="commGestion" v-model="prodInit.commGestion">
								<label for="calcul_CommGestion" class="recalculer col-form-label">recalculé : <a href="javascript:void(0);"  class="badge badge-success waves-effect" ><span id="calcul_CommGestion" onclick="useRecalcul('calcul_CommGestion')" >{{$calculCommission['comm_gestion']}}</span><span class="menu-arrow float-right"><i class="mdi mdi-chevron-up"></i></span></a>
								</label>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="commApport" class="col-form-label">Commission d'Apport</label>
								<input class="form-control recalcul" name="commApport" type="number" step="0.01" id="commApport" v-model="prodInit.commApport">
								<label for="calcul_CommApport" class="recalculer col-form-label">recalculé : <a class="badge badge-success waves-effect" href="javascript:void(0);" class="waves-effect" ><span id="calcul_CommApport" onclick="useRecalcul('calcul_CommApport')" >{{$calculCommission['comm_apport']}}</span><span class="menu-arrow float-right"><i class="mdi mdi-chevron-up"></i></span></a>
								</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="commMHT" class="col-form-label"><i class="fa fa-pie-chart"></i> Commission HT</label>
								<input class="form-control recalcul input_stot" name="commMHT" type="number" step="0.01" id="commMHT" v-model="prodInit.commMHT">
								<label for="calcul_CommHT" class="recalculer col-form-label">recalculé : <a href="javascript:void(0);" class="badge badge-success waves-effect" ><span id="calcul_CommHT" onclick="useRecalcul('calcul_CommHT')" >{{$calculCommission['comm_total']}}</span><span class="menu-arrow float-right"><i class="mdi mdi-chevron-up"></i></span></a>
								</label>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="commTVA" class="col-form-label"><i class="fa fa-pie-chart"></i> TVA Commission </label>
								<input class="form-control recalcul input_stot" name="commTVA" type="number" step="0.01"  id="commTVA" v-model="prodInit.commTVA">
								<label for="calcul_CommTVA" class="recalculer col-form-label">recalculé : <a href="javascript:void(0);" class="badge badge-success waves-effect" ><span id="calcul_CommTVA" onclick="useRecalcul('calcul_CommTVA')" >{{$calculCommission['commTVA']}}</span><span class="menu-arrow float-right"><i class="mdi mdi-chevron-up"></i></span></a>
								</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="commTotal" class="col-form-label"><i class="fa fa-pie-chart"></i> Commission Total </label>
								<input class="form-control recalcul input_stot" name="commTotal" type="number" step="0.01" required id="commTotal" v-model="prodInit.commTotal">
								<label for="calcul_CommTotal" class="recalculer col-form-label">recalculé : <a href="javascript:void(0);" class="badge badge-success waves-effect" ><span id="calcul_CommTotal" onclick="useRecalcul('calcul_CommTotal')" >{{$calculCommission['commTotal']}}</span><span class="menu-arrow float-right"><i class="mdi mdi-chevron-up"></i></span></a>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card m-b-30" id="autre_commission">
			    <div class="card-header trd_header">
			     <h4 class="header-title"> <span class="mdi mdi-calculator"></span> Autres Calculs <a href="#autre_commission"><span class="indicator-r">3</span></a> <a href="#cal_commission"><span class="indicator-r indicator-rs">2</span></a> <a href="#infos"><span class="indicator-r indicator-rs">1</span></a></h4>
			    </div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4 col-sm-12 ">
							<div class="form-group">
								<label for="POL_PRIME_REDUCTION" class="col-form-label">Reduction </label>
								<input class="form-control"  name="POL_PRIME_REDUCTION"  type="number" step="0.01" id="POL_PRIME_REDUCTION" v-model="prodInit.POL_PRIME_REDUCTION">
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label for="POL_MAJORATION" class=" col-form-label">Majoration</label>
								<input class="form-control"  name="POL_MAJORATION" type="number" step="0.01" id="POL_MAJORATION" v-model="prodInit.POL_MAJORATION">
							</div>
						</div>
						<div class="col-md-4 col-sm-12">
							<div class="form-group">
								<label for="POL_CP" class="col-form-label">CP </label>
								<input class="form-control recalcul"  name="POL_CP" type="number" step="0.01" id="POL_CP" v-model="prodInit.POL_CP">
							</div>
						</div>
					</div>

				



					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label for="POL_FGA" class="col-form-label">FGA </label>
								<input class="form-control recalcul" name="POL_FGA" type="number" step="0.01" id="POL_FGA" v-model.number="prodInit.POL_FGA">
							</div>
						</div>
											
						<div class="col-sm-4">
							<div class="form-group">
								<label for="POL_TG" class="col-form-label">TG </label>
								<input class="form-control recalcul" name="POL_TG"  type="number" step="0.01"  id="POL_TG" v-model.number="prodInit.POL_TG">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label for="POL_TD" class="col-form-label">TD </label>
								<input class="form-control recalcul" name="POL_TD" type="number" step="0.01"  id="POL_TD" v-model.number="prodInit.POL_TD">
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="POL_TP" class="col-form-label">Taxe Pollution</label>
								<input class="form-control recalcul" name="POL_TP" type="number" step="0.01" id="POL_TP" v-model.number="prodInit.POL_TP" >
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="POL_PRIME_NETTE" class="col-form-label"><i class="fa fa-shopping-cart"></i> Prime Nette <span>(Champ obligatoire)</span></label>
								<input class="form-control recalcul input_stot"  required type="number" step="0.01" name="POL_PRIME_NETTE" id="POL_PRIME_NETTE" v-model.number="prodInit.POL_PRIME_NETTE">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="POL_PRIME_TVA" class="col-form-label"><i class="mdi mdi-percent"></i> TVA <span>(Champ obligatoire)</span></label>
								<input class="form-control recalcul input_stot" name="POL_PRIME_TVA" type="number" step="0.01" id="POL_PRIME_TVA" v-model.number="prodInit.POL_PRIME_TVA" >
								<label for="calcul_TVA" class="recalculer col-form-label">
									recalculé : <a href="javascript:void(0); "  class="badge badge-success waves-effect" ><span id="calcul_TVA" onclick="useRecalcul('calcul_TVA')">{{$production->recalculPrimeTtlTva()['calcul_TVA']}}</span><span class="menu-arrow float-right"><i class="mdi mdi-chevron-up"></i></span></a>
								</label>
							</div>						
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="POL_PRIME_TOTAL" class="col-form-label"><i class="fa fa-cart-plus"></i> Prime Total <span>(Champ obligatoire)</span></label>
								<input class="form-control recalcul input_stot" name="POL_PRIME_TOTAL" type="number" step="0.01" required id="POL_PRIME_TOTAL" v-model.number="prodInit.POL_PRIME_TOTAL">
								<label for="calcul_PrimeTotal " class="col-form-label recalculer">recalculé : <a href="javascript:void(0);" class="badge badge-success waves-effect" ><span onclick="useRecalcul('calcul_PrimeTotal')" id="calcul_PrimeTotal">{{$production->recalculPrimeTtlTva()['calcul_PrimeTotal']}}</span><span class="menu-arrow float-right"><i class="mdi mdi-chevron-up"></i></span></a>
								</label>
							</div>
						</div>
					</div>
					
					</div>
				</div>
				</div>
			</div>
			<div class="row">
				<div class="offset-lg-6 col-md-6 col-xs-12">
					<div class="card">
						<div class="card-body">
						       <a href="#"><span class="indicator-rd">4</span></a>
						       <a href="#autre_commission"><span class="indicator-rd indicator-rds">3</span></a>
						       <a href="#cal_commission"><span class="indicator-rd indicator-rds">2</span></a>
							   <a href="#infos"><span class="indicator-rd indicator-rds">1</span></a>
							<a href="{{route('production.index')}}" class="btn  btn-secondary text-center" id="btnRetour"><i class="ion ion-android-system-back"></i> Retour</a> 
							<button type="submit" class="col-sm-3 btn btn-primary waves-effect waves-light"><span class="fa fa-edit"></span> Modifier
							</button>
						</div>		
					</div>	
				</div>
			</div>		
	</form>

<input class="hidden" style="display: none !important;" readonly id="prod_id" value="{{$production->id}}">
<input class="hidden" style="display: none !important;" readonly id="URL_getProd" value="{{route('production.info',$production->id)}}">
<input class="hidden" style="display: none !important;" readonly id="URL_getTauxComm" value="{{route('production.tauxCommBr')}}">
<input class="hidden" style="display: none !important;" readonly id="URL_getTauxTva" value="{{route('production.tauxTva')}}">

@endsection

@section('js')
<script src="{{asset('assets/datepicker_dist/js/datepicker.min.js')}}"></script>
<script src="{{asset('assets/datepicker_dist/js/i18n/datepicker.fr.js')}}"></script>
<script>
	$(document).ready(function() {
		$(' #POL_SOUSCRIPTION, #POL_EFFET, #POL_EXPIRATION').datepicker({dateFormat: "yyyy-mm-dd"})
	});
</script>

<script src="{{asset('assets/js/vue.js')}}" type="text/javascript"></script>  
<script  src="{{asset('assets/js/app_prod_edit.js')}}" type="text/javascript"> </script>

  <script>
   function useRecalcul(e){

   	console.log($('#'+e).text() );
	// $('#'+e).parent().parent().parent('div').find('input').val($('#'+e).text()).change();

	t= $('#'+e).parent().parent().parent('div').find('input').attr('id');
	$('#'+t).val( $('#'+e).text()).change();

	app.prodInit[t] =  $('#'+e).text();
	// const elem = this.$refs.t;
 //    elem.change();

	}
$( document ).ready(function() {
////////////////////////////////////////////////////////////////////// 
// $('.recalcul').on('change',  function(event) {
// 	event.preventDefault();
// 	/* Act on the event */
// 	console.log($(this).attr('id'));
// });




});


  </script>
@endsection