/**
 * Created by Ekogoca on 01/26/2017.
 */
$(document).ready(function () {
    addItem();

    $('button').click(function () {
        //get which button was clicked
        var buttonClicked = $(this);
        //target the div below the clicked button
        var details = buttonClicked.next();
        details.toggleClass("hide");

        //toggle the icon
        var icon = $(this).children("i");
        if(icon.hasClass('fa-chevron-down')){
            icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        }else {
            icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        }

    });

    $('form').submit( function(){
        setToppingNames();
    });

    $(document).on('change', '.item', function () {
        showTopping(this);
    });

    $(document).on('click', '.removeItem', function () {
        var elRemove = $(this).closest('.singleItem');
        var parent = $('#food');
        if(parent.find('.singleItem').length == 1){
            return;
        }
        //parent[0].removeChild(elRemove);
        elRemove.remove();
        toggleRemovalVisibility();
    });

    $('#addItem').click( function () {
        // var el = $(".singleItem")[0];
        // var newElem = $(el).clone();
        // var foodDropDown = newElem.find("input").val("").end().find('.item');
        // showTopping(foodDropDown[0]);//convert jquery elem to html element
        // newElem.appendTo("#food");
        addItem();
    });
    $('#login').click( function () {
        login();
    });
    $('#register').click( function () {
        register();
    });
});
function toggleRemovalVisibility(){
    var elem = $('#food .removeItem');
    var firstElem = $('#food .removeItem:first');
    if(elem.length == 1){
        firstElem.removeClass('hide').addClass('hide');
    }else{
        firstElem.removeClass('hide');
    }
}
function addItem(){
    $("#template .singleItem").clone().insertBefore(".buttons");
    toggleRemovalVisibility();
}
function login(){
	var elm = document.getElementById("loginform").innerHTML;
    $( "#food" ).replaceWith( elm );
}
function register(){
	var elm = document.getElementById("registerform").innerHTML;
    $( "#food" ).replaceWith( elm );
}
function showTopping(el){
    var food = el.value;
    var host = $(el).closest('div.singleItem');
    var toppings = host.find('div.toppings');
    toppings.each(function(index, elem){
        var jdivTopping = $(elem);
        if(!jdivTopping.hasClass('hide')){
            jdivTopping.addClass('hide');
        }
    });
    //uncheck all toppings when food type is changed
    host.find('.toppings input:checked').each(function(index, checkbox){
        if(checkbox.checked){
            checkbox.checked = false;
        }
    });
    if(food){
        var currentTopping = host.find('div.' + food);
        if(currentTopping.length){
            currentTopping.removeClass('hide');
        }
    }
}
function setToppingNames(){
  $('#food .singleItem').each(function(index, currentItem){
     $(currentItem).find('input:checked').each(function(toppingItemIndex, toppingItem){
         $(toppingItem).attr('name', 'topping' + index + '[]');
     });
  });

  function showPriceDetails(el) {
      $(el).toggle(".priceDetails");
  }

}

