var app = new Vue({
     el: "#root",
     data: {
        message: ' ',
        prodInit:[],
        showingCommission: false,
        primeNette:0,
        CP:0,
        primeTVA : 0,
        TD:0,
        TG:0,
        FGA:0,
        TP:0,
        //primeTotal:0,
        commGestion:0,
        commApport:0,
        // commHT:0,
        //commTVA:0,
        // commTTC:0
        TauxCommGestion:0, // taux de la comm de gestion et apport de la br
        TauxCommApport:0,
        TauxTvaComm:0, // taux tva comm et prime 
        TauxTvaPrime:0,
     },
     mounted:function() {
        this.getProdInit();
        this.withCommission();

    },
    computed: {
        primeTotal: function () {
             var t = (parseFloat(+this.primeNette) *1)+
                     (parseFloat(+this.CP) *1)+
                     (parseFloat(+this.primeTVA) *1)+
                     (parseFloat(+this.TD) *1)+
                     (parseFloat(+this.TG)*1)+
                     (parseFloat(+this.TP)*1)+
                     (parseFloat(+this.FGA)*1);
              $('#calcul_PrimeTotal').text(Number(t).toFixed(2) );
            return  +this.primeNette+ +this.CP+ +this.primeTVA+ +this.TD+ +this.TG+ +this.FGA+ +this.TP;
        }
    },
    watch: {
    prodInit: {
                handler: function () {
                            this.CP = this.prodInit.POL_CP;
                            this.primeNette = this.prodInit.POL_PRIME_NETTE;
                            this.FGA = this.prodInit.POL_FGA;
                            this.TD = this.prodInit.POL_TD;
                            this.TG = this.prodInit.POL_TG;
                            this.TP = this.prodInit.POL_TP;
                            this.primeTVA = this.prodInit.POL_PRIME_TVA;
                            this.primeTotal;
                            this.recalculTVA();
                            this.recalculCommission();
                            this.CommHT();
                            this.CommTVA();
                            this.CommTTC();
                            console.log('changement ');
                             },
                deep: true
    }
    // ,
    // primeNette: function (newPN, oldPN){
    //   this.primeTotal;
    // },
    // CP: function (newPN, oldPN) {
    //   this.primeTotal;
    // },
    // primeTVA: function (newPN, oldPN) {
    //   // this.primeTotal;
    // },
    // TD: function (newPN, oldPN) {
    //   this.primeTotal
    // } 

    //  ,
    // TG: function (newPN, oldPN) {
    //   this.primeTotal
    // },
    // TP: function (newPN, oldPN) {
    //   this.primeTotal
    // },
    // FGA: function (newPN, oldPN) {
    //   this.primeTotal
    // },
    // commApport: function (newPN, oldPN) {
    //   this.CommHT();
    //   // this.CommTTC;
    // },
    // commGestion: function (newPN, oldPN) {
    //   this.CommHT();
    //   // this.CommTTC;
    // }
  },
     methods:{
      CommHT(){
           var t =  Number(+this.prodInit.commGestion + +this.prodInit.commApport).toFixed(2);// commGestion+ +this.commApport;
             $('#calcul_CommHT').text(t);
            //return  +this.commGestion+ +this.commApport;
        },
      CommTTC() { //c'est commTTrecalculée, à refaire
         var t = Number(+this.prodInit.commMHT + +this.prodInit.commTVA).toFixed(2) ;
           $('#calcul_CommTotal').text(t);
           // return parseFloat(+this.CommHT *1) + parseFloat(+this.commTVA *1);
      },
    CommTVA(){
       var t =  (Number( !isNaN(this.TauxTvaComm)? +this.TauxTvaComm :0) * Number(+this.prodInit.commMHT) ).toFixed(2);
       $('#calcul_CommTVA').text(t);

    },
    getProdInit(){
         let that = this;
            $.ajax({
               type:'POST',
               datatype:'JSON',
               data: { '_token': function () {
                            return $('input[name="_token"]').val();
                        },
                        'prod': function(){
                         return $('#prod_id').val() ;
                        }
                    },
               url: $("#URL_getProd").val(),
               success:function(data){
                 that.prodInit = data;
                 console.log('prodInit');
                 that.getTauxTvaInit();  // chargement des taux de tva 
                 that.getTauxCommInit();  // chergement des taux de commission
                 },
               error:function(error) {
                    alert("Erreur de chargement de données");
                   console.log(error);
               }
            });
    },
    withCommission(){
       var catId =  $('#calcul_CommTotal').val();
       this.showingCommission = (typeof(catId) != 'undefined' || catId != null) ;
    },
    getTauxCommInit(){
         let that = this;      
            $.ajax({

               type:'POST',
               datatype:'JSON',
               data: { '_token': function () {
                            return $('input[name="_token"]').val();
                        },
                        'br': function(){
                         return that.prodInit.POL_BRN ;
                        }
                    },
               url: $("#URL_getTauxComm").val(),
               success:function(data){
                 that.TauxCommGestion = data.taux_gestion;
                 that.TauxCommApport = data.taux_apport;
                 console.log('fin chargement taux comm');
                 that.recalculCommission();
                 },
               error:function(error) {
                    alert("Erreur de chargement de données");
                   console.log(error);
               }
            });
    },
    getTauxTvaInit(){
         let that = this;
            $.ajax({
               type:'POST',
               datatype:'JSON',
               data: { '_token': function () {
                            return $('input[name="_token"]').val();
                        }
                    },
               url: $("#URL_getTauxTva").val(),
               success:function(data){
                 that.TauxTvaComm = Number(data.tvaComm);
                 that.TauxTvaPrime = Number(data.tvaProd);
                 that.recalculTVA();
                 that.CommTVA();
                 },
               error:function(error) {
                    alert("Erreur de chargement de données");
                   console.log(error);
               }
            });
    },
    recalculCommission(){  // revalculer les commissions (gestion et apport) proposées
        // console.log('recalcul apres chargement Taux');
        $('#calcul_CommGestion').text(Number( (!isNaN(this.TauxCommGestion)? this.TauxCommGestion : 0) * (+this.prodInit.POL_PRIME_NETTE)).toFixed(2));
        $('#calcul_CommApport').text(Number( (!isNaN(this.TauxCommApport)? this.TauxCommApport :0) * (+this.prodInit.POL_PRIME_NETTE)).toFixed(2));
    },
    recalculTVA(){
        console.log( this.TauxTvaPrime );
        $('#calcul_TVA').text(Number(this.TauxTvaPrime * (+this.prodInit.POL_PRIME_NETTE + +this.prodInit.POL_CP)).toFixed(2));
    }
    }
 });


