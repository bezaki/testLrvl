@if(auth()->user()->hasAnyPermission(['Production Show']))          
	<a href="{{route('production.show', $prodId)}}" class="badge badge-primary waves-effect waves-light" title="détail"><i class="ion ion-eye"></i> 
	</a>
@endif
@if(auth()->user()->hasAnyPermission(['Production Edit']))          
	<a href="{{route('production.showEdit', $prodId)}}" class="badge badge-primary waves-effect waves-light" title="Modifier"><i class="fa fa-edit"></i> 
	</a>
@endif
@if(auth()->user()->hasAnyPermission(['Production Delete']))          
  <a type="button" href="javascript:void(0)" class="badge badge-danger waves-effect waves-light" title="Supprimer" onclick="swal_comfirme_delete({{$prodId}})"><i class="typcn icon typcn-trash"></i></a>
@endif
