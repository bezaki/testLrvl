@extends('default')

@section('head_title')
	Productions
@endsection

@section('title')
	<i class="mdi mdi-view-list vis_icon"></i> liste Des Productions
@endsection

@section('head')
	<link rel="stylesheet" href="{{asset('assets/css/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/responsive.bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/custom_styling.css')}}">
	<link rel="stylesheet" href="{{asset('assets/datepicker_dist/css/datepicker.min.css')}}"  type="text/css">
@endsection

@section('content')
	
	<div class="row">
		<div class="col-12">
			<div class="card m-b-30">
				<div class="card-header">
					<h4 class="header-title"> <span class="mdi mdi-view-list"></span> Productions 
				 		@if(auth()->user()->hasAnyPermission(['ImportedFile Add']))
					 	<a href="{{route('importProduction.show')}}" class="btn btn-sm btn-primary float-right"><i class="ion ion-ios7-cloud-upload-outline"></i> Importer</a>
					 	@endif
				 	 	@if(auth()->user()->hasAnyPermission(['Production Add']))
					 	 <a href="{{route('production.add')}}" class="btn btn-sm btn-primary float-right"><i class="mdi mdi-plus"></i> Ajouter</a>
					 	@endif 
					</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<form>
								@csrf
							</form>
							<table id="production" class="display responsive table-striped nowrap" style="width:100%">
						        <thead>
						            <tr>
										<th>#</th>
										<th data-priority="1">Qtc</th>
										<th data-priority="2">Branche</th>
										<th data-priority="2">SOUSCRIPTION</th>
										<th data-priority="1">REFERENCE</th>
										<th data-priority="3">ASSURE</th>
										<th data-priority="5">EFFET</th>
										<th data-priority="6">EXPIRATION</th>
										<th data-priority="4">PRIME TOTAL</th>
										<th data-priority="7">PRIME NETTE</th>
										<th data-priority="8">TVA</th>
										<th data-priority="9">Tax Pol</th>
										<th data-priority="10">Classe</th>
										<th data-priority="11">N° POL</th>
										<th data-priority="12">N° AA</th>
										<th data-priority="13">REDUCTION</th>
										<th data-priority="14">CP</th>
										<th data-priority="15">FGA</th>
										<th data-priority="16">MAJORATION</th>
										<th data-priority="17">TG</th>
										<th data-priority="18">TD</th>
										<th data-priority="19">IMPORTE</th>
										<th data-priority="0">Actions</th>
						            </tr>
						        </thead>
								<tbody>
								</tbody>
						        <tfoot>
						        	<tr>
						        		<th>#</th>
										<th>Qtc</th>
										<th>Branche</th>
										<th>Date</th>
										<th>REFERENCE</th>
										<th>ASSURE</th>
										<th>Date</th>
										<th>Date</th>
										<th>PRIME_TOTAL</th>
										<th>PRIME_NETTE</th>
										<th>TVA</th>
										<th>Tax Pol</th>
										<th>Classe</th>
										<th>N°_POL</th>
										<th>N°_AA</th>
										<th>REDUCTION</th>
										<th>CP</th>
										<th>FGA</th>
										<th>MAJORATION</th>
										<th>TG</th>
										<th>TD</th>
										<th>IMPORTE</th>
										<th>Actions</th>
						            </tr>
						        </tfoot>
						    </table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
@endsection

@section('js')
	<script src="{{asset('assets/js/jquery-3.3.1.js')}}"></script>
	<script src="{{asset('assets/js/moment.fr.js')}}"></script>
	<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
	
	<script>
		$(function() {
			function currencyFormat(num) {
			  return (
			    num
			      .toFixed(2) // always two decimal digits
			      .replace('.', ',') // replace decimal point character with ,
			      .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ') + ''
			  ) // use ' ' as a separator
			}
				var table = $('#production').DataTable({
					"responsive": true,
					"autoWidth": true,
					"columns": [
						{"data": "id", "orderable": true, "searchable": false, "visible":false},
						{"data": "pol_qtc", "orderable": true, "searchable": true},
						{"data": "pol_brn", "orderable": true, "searchable": true},
						{"data": "pol_souscription", "orderable": true, "searchable": true, "render" : function(data, type, row) {
						   		 return row.pol_souscription ? moment(row.pol_souscription).format("DD/MM/YYYY"):'';
						}},
						{"data": "pol_ref", "orderable": true, "searchable": true},
						{"data": "pol_ins_name", "orderable": true, "searchable": true},
						{"data": "pol_effet", "orderable": true, "searchable": true, 
									"render" : function(data, type, row) {
						   		 			return row.pol_effet ?moment(row.pol_effet).format("DD/MM/YYYY") :'';
						}},
						{"data": "pol_expiration", "orderable": true, "searchable": true ,"render" : function(data, type, row) {
						   		 return row.pol_expiration ? moment(row.pol_expiration).format("DD/MM/YYYY") :'';
						}},
						{"data": "pol_prime_total", "orderable": true, "searchable": true,
						"render" : function(data, type, row) {
								return currencyFormat(Number(row.pol_prime_total));
								
							},
						"className":'bolded'
						},
//#, Qtc, Branche, SOUSCRIPTION, REFERENCE, ASSURE, EFFET, EXPIRATION, PRIME Total,
// TVA, Tax, PRIME, Classe, N°, N°, REDUCTION, CP, FGA, MAJORATION, TG, TD, IMPORTE, Action, 
						{"data": "pol_prime_nette", "orderable": true, "searchable": true,
						"render" : function(data, type, row) {
								return currencyFormat(Number(row.pol_prime_nette));
								
							}},
						{"data": "pol_prime_tva", "orderable": true, "searchable": true,
						"render" : function(data, type, row) {
								return currencyFormat(Number(row.pol_prime_tva));
								
							}},
						{"data": "pol_tp", "orderable": true, "searchable": true,
						"render" : function(data, type, row) {
								return currencyFormat(Number(row.pol_tp));
								
						}},

						{"data": "pol_cls", "orderable": true, "searchable": true},
						{"data": "pol_num", "orderable": true, "searchable": true},
						{"data": "pol_num_aa", "orderable": true, "searchable": true},
						{"data": "pol_prime_reduction", "orderable": true, "searchable": true,
						"render" : function(data, type, row) {
								return currencyFormat(Number(row.pol_prime_reduction));
								
							}},
						{"data": "pol_cp", "orderable": true, "searchable": true,
						"render" : function(data, type, row) {
								return currencyFormat(Number(row.pol_cp));
								
							}},
						{"data": "pol_fga", "orderable": true, "searchable": true,
						"render" : function(data, type, row) {
								return currencyFormat(Number(row.pol_fga));
								
							}},
						{"data": "pol_majoration", "orderable": true, "searchable": true,
						"render" : function(data, type, row) {
								return currencyFormat(Number(row.pol_majoration));
								
							}},
						{"data": "pol_tg", "orderable": true, "searchable": true,
						"render" : function(data, type, row) {
								return currencyFormat(Number(row.pol_tg));
								
							}},
						{"data": "pol_td", "orderable": true, "searchable": true,
						"render" : function(data, type, row) {
								return currencyFormat(Number(row.pol_td));
								
							}},
						{"data": "pol_import_id", "orderable": true, "searchable": false},
						{"data": "action", "orderable": false,"searchable": false}
					],
					"rowId": 'id', 
					"processing": true,
					"serverSide": true,
					"stateSave" : true,
					"stateLoadParams": function (settings, data) {
						    if (data) {
							    $('#production input[type=search]').val(data.search.search);
						    }
  					    },
					"ajax": {
						url: '{{route('production.dataTable')}}',
						type: 'POST',
						data: {
							'_token': function () {
											return $('input[name="_token"]').val();
											}
						}

					},

					"order": [[0, "desc"]],
					"searching": true,
					"responsive": true,
					"language": {
						"info": " page : _PAGE_ sur _PAGES_   (de _START_ à _END_ sur un total de : _TOTAL_ enregistrements )",
						"infoEmpty": "Pas de résultat",
						"infoFiltered": " - Filtere dans _MAX_ enregistrements",
						"decimal": "",
						"emptyTable": "Pas de résultat",
						"infoPostFix": "",
						"thousands": ",",
						"lengthMenu": " <select>" +
								'<option value="10">10 lignes</option>' +
								'<option value="20">20 lignes</option>' +
								'<option value="30">30 lignes</option>' +
								'<option value="40">40 lignes</option>' +
								'<option value="50">50 lignes</option>' +
								'<option value="100">100 lignes</option>' +
								'<option value="-1">Tous</option>' +
								"</select>", //_MENU_

						"loadingRecords": "Veuillez patienter - Chargement...",
						"processing":     "<img src='{{asset('assets/images/spinner.gif')}}' style='width:10%;'> ",
						"search": "<span class='ion ion-search search'></span>",
						"zeroRecords": "Pas de résultat",
						"paginate": {
							"first": "Premier",
							"last": "Dernier",
							"next": "<i class='typcn typcn-chevron-right'></i>",
							"previous": "<i class='typcn typcn-chevron-left'></i>"
						}
					}
				});

				$('#production tfoot th').each(function (index) {
				var index = $(this).text();
				if (index != "Actions"){
					if(index=="Date"){
						$(this).html('<input class="thindate" data-position="left top" data-language="fr" type="text" placeholder="" id=input"'+index+'" style="display:inline-block;width:100% !important;"/> <label for=input"'+index+'"><span class="ion ion-search search"></span></label>');
					}
					// datepicker-here
					// data-timepicker="true" data-language='fr'
					else{
						$(this).html('<input type="text" placeholder="" id=input"'+index+'" style="display:inline-block;width:100% !important;"/> <label for=input"'+index+'"><span class="ion ion-search search"></span></label>');
					}
				}

			    });

				table.columns().every(function () {
					var that = this;
					var data = this.state.loaded();
					if (data) {
						for (var i = data.columns.length - 1; i >= 0; i--) {
						    var colSearch = data.columns[i].search;
						    	// data.columns[i]
						    $( 'input', table.column( i ).footer() ).val( colSearch.search );
						}
					}
					$('input, select', this.footer()).on('change blur', function () {
						if (that.search() !== this.value) {
							that
									.search(this.value)
									.draw();
						}
					});
				});
		});


function swal_comfirme_delete(id) {
	var prodId = id;//your customer key value.
	var prod =  $('#production').DataTable().row('#'+prodId).data();
	// console.log(prod);
	// return false;
	swal({
	    title: "Supprission Production " ,
	    html: 'Voullez vous supprimer la production Ref : '+prod.pol_ref+' Qtc N°:'+prod.pol_qtc,
	    animation: true,
	    width: 600,
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: "#ff5560",
	    cancelButtonText: "Annuler",
	    confirmButtonText: "Confirmer la Supprission",
	    buttonsStyling: true
	}).then(function () {       
	    $.ajax({
	        type: "POST", 
	        url: "{{route('production.deleteProd')}}",
	        data: {'_token' : function(){return $('input[name="_token"]').val();},
	        	   'file_id': prodId
	        	 },
	        cache: false,
	        success: function(data) {
	            if(data.status == 'ok'){
		            swal(
		            "Success!",
		            data.msg +", Ref de production :"+data.data.file,
		            "success"
		            );
		              $('#production').DataTable().ajax.reload('',false);
	            }
	        },
	        failure: function (response) {
	            swal(
	            "Erreur ",
	            "Oops, la supprission de la production n'a pas été faite!.", // had a missing comma
	            "error"
	            );
	            console.log(response);
	        },
	        error:function(data){
	        	swal(
	            "Erreur ",
	            "Oops, la supprission de la production n'a pas été faite!. "+data.responseJSON.errors, // had a missing comma
	            "error"
	            );
	            console.log(data);

	        }
	    });
	}, 
	function (dismiss) {
	  if (dismiss === "cancel") {
	    // swal(
	    //   "Cancelled",
	    //     "Canceled Note",
	    //   "error"
	    // )
	  }
	})

}
</script>
<script src="{{asset('assets/datepicker_dist/js/datepicker.min.js')}}"></script>
<script src="{{asset('assets/datepicker_dist/js/i18n/datepicker.fr.js')}}"></script>
<script>
	$(document).ready(function() {
		$('.thindate').datepicker({dateFormat: "yyyy-mm-dd"})
	});
</script>

@endsection