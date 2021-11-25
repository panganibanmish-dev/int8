$(document).ready(function(){
    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        var TargetA = $(e.target).parent().find('.NamePlace');
        TargetA.html(fileName);
    });

    $('.SearchButton').click(function(){
        $('.Search01 form').css({'display':'flex'});
    });
    $(document).on("click", function(event){
        var WW = $(window).width();      
        if(!$(event.target).closest(".Search01").length && WW < 767){
            $('.Search01 form').css({'display':'none'});            
        }
        if(!$(event.target).closest(".User01").length){
            $('.DropDown02').css({'display':'none'});            
        }
    });
    
    $('.BurgerMenu').click(function(){
        $(this).toggleClass('Active01');
        $('.MainNav ul').slideToggle();
    });

    $('.DropDown01').click(function(){
        $('.DropDown02').fadeToggle();
    });

    $('.SideBarBtn').click(function(){
        $(this).toggleClass('Active01');
        $('.SideBarOuter').toggleClass('Active01');
        chartlabel();
    });
    function chartlabel(){
        var topP = $('.ChartSize').width();
        $('#chartdiv').css({"width": topP + "px", "height": topP + "px"});   
    } 
    chartlabel();
    $(window).resize(function(){
        chartlabel();
    });
});


// display all erros as alert box in targets.

function process_pop_up_errors(errors, target, modal){

    $(target).html(errors);

    $(modal).animate({ scrollTop: 0 }, 'slow');

}
$(document).ready(function(){
    //var bg_img = $("body").css("background-image");
    
    $('.col-md-3:nth-child(odd)').each(function(){
        
        var bg_img = $(this).css("background-image");
        //alert(bg_img);
        if(bg_img == 'url("https://int1.dev.humanpixel.com.au/News")'){
            $(this).find(".dateManage").css("background-color", "#000D22");
            $(this).find(".descriptionManage").css("background-color", "#000D22");
        }
    });
    
    
    
     $('.col-md-3:nth-child(even)').each(function(){
        
        var bg_img = $(this).css("background-image");
        //alert(bg_img);
        if(bg_img == 'url("https://int1.dev.humanpixel.com.au/News")'){
            $(this).find(".dateManage").css("background-color", "#DADCE0");
            $(this).find(".descriptionManage").css("background-color", "#DADCE0");
        }
    });
    
    
    

   
});
