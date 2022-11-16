@extends('default')

@section('head_title')
 Détail Production
@endsection

@section('title')
 <span class="ion ion-eye vis_icon"></span> Détail Production
@endsection
@section('head')
 <style>
  label.recalculer{
   display: block;
   font-weight: 100;
  }
  label.recalculer a{
   float: right;
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
      box-shadow: 0px 0px 10px -4px black;
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

 </style>
@endsection

@section('content')
 
 
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
        <input class="form-control" readonly required type="text" name="POL_QTC" id="POL_QTC" value="{{$production->POL_QTC}}">
       </div>
      </div>
      <div class="col-lg-2 col-md-6 col-sm-12">
       <div class="form-group">
        <label for="POL_CLS" class="col-form-label">classe</label>
        <input class="form-control" readonly required type="text" name="POL_CLS" id="POL_CLS" value="{{$production->POL_CLS}}">
       </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12">
       <div class="form-group">
        <label for="POL_BRN" class="col-form-label">Branche </label>
        <input class="form-control" readonly name="POL_BRN" required type="text" id="POL_BRN" value="{{$production->POL_BRN}}">
       </div>
      </div>
     
      <div class="col-lg-4 col-md-6 col-sm-12">
       <div class="form-group">
        <label for="POL_REF" class=" col-form-label">Réference</label>
        <input class="form-control" readonly name="POL_REF" required type="text" id="POL_REF" value="{{$production->POL_REF}}">
       </div>
      </div>
     </div>
     <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-12">
       <div class="form-group">
        <label for="POL_SOUSCRIPTION" class="col-form-label"><i class="fa fa-calendar-plus-o"></i> Souscription </label>
        <input class="form-control input_stot" name="POL_SOUSCRIPTION" readonly id="POL_SOUSCRIPTION" value="{{date('d/m/Y à H:i', strtotime($production->POL_SOUSCRIPTION))}}">
       </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
       <div class="form-group">
        <label for="POL_EFFET" class="col-form-label"><i class="fa fa-calendar-check-o"></i> Effet </label>
        <input class="form-control input_stot" name="POL_EFFET" readonly id="POL_EFFET" value="{{date('d/m/Y à H:i', strtotime($production->POL_EFFET))}}">
       </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12">
       <div class="form-group">
        <label for="POL_EXPIRATION" class="col-form-label"><i class="fa fa-calendar-times-o"></i> Expiration </label>
        <input class="form-control input_stot" name="POL_EXPIRATION" readonly id="POL_EXPIRATION" value="{{date('d/m/Y à H:i', strtotime($production->POL_EXPIRATION))}}">
       </div>
      </div>
     </div>
     <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-12">
       <div class="form-group">
        <label for="POL_NUM" class="col-form-label">Num police </label>
        <input class="form-control" name="POL_NUM" readonly required  id="POL_NUM" value="{{$production->POL_NUM}}">
       </div>
      </div>
     <div class="col-lg-4 col-md-6 col-sm-12">
       <div class="form-group">
        <label for="POL_NUM_AA" class="col-form-label">Num Avis </label>
        <input class="form-control" name="POL_NUM_AA" readonly id="POL_NUM_AA" value="{{$production->POL_NUM_AA}}">
       </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
       <div class="form-group">
        <label for="POL_INS_NAME" class="col-form-label"> <i class="ion ion-person"></i> Assuré </label>
        <input class="form-control input_stot" name="POL_INS_NAME" type="text" required id="POL_INS_NAME" value="{{$production->POL_INS_NAME}}">
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
        <input class="form-control recalcul" readonly name="commGestion"  id="commGestion" value="{{number_format($production->commGestion, 2, ',', ' ')}}">
       </div>
      </div>
      <div class="col-md-6 col-sm-12">
       <div class="form-group">
        <label for="commApport" class="col-form-label">Commission d'Apport</label>
        <input class="form-control recalcul" name="commApport" readonly id="commApport" value="{{number_format($production->commApport, 2, ',', ' ')}}">
       </div>
      </div>
     </div>
     <div class="row">
      <div class="col-md-6 col-sm-12">
       <div class="form-group">
        <label for="commMHT" class="col-form-label"><i class="fa fa-pie-chart"></i>  Commission HT</label>
        <input class="form-control recalcul input_stot" name="commMHT" readonly id="commMHT" value="{{number_format($production->commMHT, 2, ',', ' ')}}">
       </div>
      </div>
      <div class="col-md-6 col-sm-12">
       <div class="form-group">
        <label for="commTVA" class="col-form-label"><i class="fa fa-pie-chart"></i>  TVA Commission </label>
        <input class="form-control recalcul input_stot" name="commTVA"  readonly  id="commTVA" value="{{number_format($production->commTVA, 2, ',', ' ')}}">
       </div>
      </div>
     </div>
     <div class="row totalg">
      <div class="col-sm-12">
       <div class="form-group">
        <label for="commTotal" class="col-form-label"> <i class="fa fa-pie-chart"></i> Commission Total </label>
        <input class="form-control recalcul input_stot" name="commTotal" readonly required id="commTotal" value="{{number_format($production->commTotal, 2, ',', ' ')}}">
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
        <input class="form-control"  name="POL_PRIME_REDUCTION"  readonly id="POL_PRIME_REDUCTION" value="{{number_format($production->POL_PRIME_REDUCTION, 2, ',', ' ')}}">
       </div>
      </div>
      <div class="col-md-4 col-sm-12">
       <div class="form-group">
        <label for="POL_MAJORATION" class=" col-form-label">Majoration</label>
        <input class="form-control"  name="POL_MAJORATION" readonly id="POL_MAJORATION" value="{{number_format($production->POL_MAJORATION, 2, ',', ' ')}}">
       </div>
      </div>
      <div class="col-md-4 col-sm-12">
       <div class="form-group">
        <label for="POL_CP" class="col-form-label">CP </label>
        <input class="form-control recalcul" name="POL_CP" readonly id="POL_CP" value="{{number_format($production->POL_CP, 2, ',', ' ')}}">
       </div>
      </div>
     </div>

     <div class="row">
      <div class="col-sm-4">
       <div class="form-group">
        <label for="POL_FGA" class="col-form-label">FGA </label>
        <input class="form-control recalcul" name="POL_FGA" readonly id="POL_FGA" value="{{number_format($production->POL_FGA, 2, ',', ' ')}}">
       </div>
      </div>
           
      <div class="col-sm-4">
       <div class="form-group">
        <label for="POL_TG" class="col-form-label">TG </label>
        <input class="form-control recalcul" name="POL_TG"  readonly id="POL_TG" value="{{number_format($production->POL_TG, 2, ',', ' ')}}">
       </div>
      </div>
      <div class="col-sm-4">
       <div class="form-group">
        <label for="POL_TD" class="col-form-label">TD </label>
        <input class="form-control recalcul" name="POL_TD" readonly id="POL_TD" value="{{number_format($production->POL_TD, 2, ',', ' ')}}">
       </div>
      </div>
     </div>
     
     <div class="row">
      <div class="col-sm-6">
       <div class="form-group">
        <label for="POL_TP" class="col-form-label">Taxe Pollution</label>
        <input class="form-control recalcul" name="POL_TP" type="number" readonly id="POL_TP" value="{{number_format($production->POL_TP, 2, ',', ' ')}}">
       </div>
      </div>
      <div class="col-sm-6">
       <div class="form-group">
        <label for="POL_PRIME_TVA" class="col-form-label"><i class="mdi mdi-percent"></i> TVA </label>
        <input class="form-control recalcul input_stot" name="POL_PRIME_TVA" readonly id="POL_PRIME_TVA" value="{{number_format($production->POL_PRIME_TVA, 2, ',', ' ')}}">
       </div>
      </div>
     </div>
     <div class="row totalgd">
      <div class="col-md-6 col-sm-12">
       <div class="form-group">
        <label for="POL_PRIME_NETTE" class="col-form-label"><i class="fa fa-shopping-cart"></i> Prime Nette </label>
        <input class="form-control recalcul input_stot"  required readonly name="POL_PRIME_NETTE" id="POL_PRIME_NETTE" value="{{number_format($production->POL_PRIME_NETTE, 2, ',', ' ')}}">
       </div>
      </div>
      <div class="col-md-6 col-sm-12">
       <div class="form-group">
        <label for="POL_PRIME_TOTAL" class="col-form-label"><i class="fa fa-cart-plus"></i> Prime Total </label>
        <input class="form-control recalcul input_stot" name="POL_PRIME_TOTAL" readonly required id="POL_PRIME_TOTAL" value="{{number_format($production->POL_PRIME_TOTAL, 2, ',', ' ')}}">
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
       <a href="#infos"><span class="indicator-rd indicator-rds">1</span></a>
       <a href="#cal_commission"><span class="indicator-rd indicator-rds">2</span></a>
       <a href="#autre_commission"><span class="indicator-rd indicator-rds">3</span></a>
       <a href="#"><span class="indicator-rd">4</span></a>
       <a href="{{route('production.index')}}" class="btn  btn-secondary text-center" id="btnRetour"><i class="ion ion-android-system-back"></i> Retour</a> 
      </div>  
     </div> 
    </div>
   </div> 
@endsection

@section('js')


@endsection