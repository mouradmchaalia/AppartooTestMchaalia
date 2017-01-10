$("document").ready(function() {
    
   //remplir  latitudevd et longitudevd
    $("#Circuit_villedepart").change(function() {
       
            $.ajax({
               type: 'get',
               url: 'http://localhost/VersionFinale/web/app_dev.php/Latitude/' + $('#Circuit_villedepart').val(),
               beforeSend: function() {
                    if ($(".loading").length === 0) {     
                            $("form .latitudevd").parent().append('<div class="loading"></div>');
                    }
                            $(".latitudevd option").remove();
               },
               success: function(data) {
                   console.log("hedi latvd");
                   $(".latitudevd").val(data.latitude); 
                   $(".loading").remove();
                    }
            });
     
            $.ajax({
               type: 'get',
               url: 'http://localhost/VersionFinale/web/app_dev.php/Longitude/' + $('#Circuit_villedepart').val(),
               beforeSend: function() {
                            $(".longitudevd option").remove();
               },
               success: function(data) {
                   console.log("hedi lanvd");
                    $(".longitudevd").val(data.longitude); 
                    }
            });
         
});



    //remplir latitude1 et Longitude1 auto
    $("#Circuit_destination1").change(function() {
        
            $.ajax({
               type: 'get',
               url: 'http://localhost/VersionFinale/web/app_dev.php/Latitude1/' + $('#Circuit_destination1').val(),
               beforeSend: function() {
                    if ($(".loading").length === 0) {    
                            $("form .latitude1").parent().append('<div class="loading"></div>');
                    }       
                            $(".latitude1 option").remove();
               },
               success: function(data) {
                   console.log("hedi latyes1");
                    $(".latitude1").val(data.latitude1); 
                       $(".loading").remove();
                    }
            });
        

            $.ajax({
               type: 'get',
               url: 'http://localhost/VersionFinale/web/app_dev.php/Longitude1/' + $('#Circuit_destination1').val(),
               beforeSend: function() {
                            $(".longitude1 option").remove();
               },
               success: function(data) {
                   console.log("hedi longyes1");
                    $(".longitude1").val(data.langitude1); 
                    }
            });
         
});



    //remplir latitude2 et Longitude2 auto
    $("#Circuit_destination2").change(function() {
      
            $.ajax({
               type: 'get',
               url: 'http://localhost/VersionFinale/web/app_dev.php/Latitude2/' + $('#Circuit_destination2').val(),
               beforeSend: function() {
                    if ($(".loading").length === 0) {
                        
                            $("form .latitude2").parent().append('<div class="loading"></div>');
                    }
                        
                            $(".latitude2 option").remove();
               },
               success: function(data) {
                   console.log("hedi latyes2");
                    $(".latitude2").val(data.latitude2); 
                       $(".loading").remove();
                    }
            });
        

            $.ajax({
               type: 'get',
               url: 'http://localhost/VersionFinale/web/app_dev.php/Longitude2/' + $('#Circuit_destination2').val(),
               beforeSend: function() {
                            $(".longitude2 option").remove();
               },
               success: function(data) {
                   console.log("hedi longyes2");
                    $(".longitude2").val(data.langitude2); 
                    }
            });
   

});


    //remplir latitude3 et Longitude3 auto
    $("#Circuit_destination3").change(function() {
      
            $.ajax({
               type: 'get',
               url: 'http://localhost/VersionFinale/web/app_dev.php/Latitude3/' + $('#Circuit_destination3').val(),
               beforeSend: function() {
                    if ($(".loading").length === 0) {
                        
                            $("form .latitude3").parent().append('<div class="loading"></div>');
                    }
                        
                            $(".latitude3 option").remove();
               },
               success: function(data) {
                   console.log("hedi latyes3");
                    $(".latitude3").val(data.latitude3); 
                       $(".loading").remove();
                    }
            });


            $.ajax({
               type: 'get',
               url: 'http://localhost/VersionFinale/web/app_dev.php/Longitude3/' + $('#Circuit_destination3').val(),
               beforeSend: function() {                        
                            $(".longitude3 option").remove();
               },
               success: function(data) {
                   console.log("hedi longyes3");
                    $(".longitude3").val(data.langitude3); 
                    }
            });
        
            
});    
    
   
});