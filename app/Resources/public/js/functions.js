////
// Google Maps API JS - Autocomplete
////
function autocompleteItemDisabled(element, disabled = true)
{
    if( disabled )
    {
        element.attr('disabled', 'disabled');
    }else{
        element.attr('disabled', false);
    }
}

function autocompleteItemReset(element)
{
    element.val('');
}

function autocompleteSuccess(element, place)
{
    //element.val( place.name ).parent('.form-group').removeClass('has-error');
    element.parent('.form-group').removeClass('has-error');
}

function autocompleteError(element)
{
    element.val('').parent('.form-group').addClass('has-error');
}

function autocompleteLocationRegion(selectCountry, inputRegion, autocompleteRegion)
{
    autocompleteItemReset(inputRegion);
    
    autocompleteRegion.setComponentRestrictions({'country': selectCountry.val()});

//    google.maps.event.addListener(autocompleteRegion, 'place_changed', function () {
//
//        var place = autocompleteRegion.getPlace();
//        var regionTypes = ['administrative_area_level_1', 'administrative_area_level_2'];
//
//        // Is administrative_area_level_1 or administrative_area_level_2
//        if( place.types.length > 0 && 
//            ( 
//                $.inArray( regionTypes[0], place.types ) !== -1 
//                || $.inArray( regionTypes[1], place.types ) !== -1
//            ) 
//        )
//        {
//            autocompleteSuccess(inputRegion, place);
//        }else{
//            autocompleteError(inputRegion);
//        }
//        
//        //console.log(place);
//    });
}

function autocompleteLocationCity(selectCountry, inputCity, autocompleteCity)
{
    autocompleteItemReset(inputCity);
    
    autocompleteCity.setComponentRestrictions({'country': selectCountry.val()});

//    google.maps.event.addListener(autocompleteCity, 'place_changed', function () {
//
//        var place = autocompleteCity.getPlace();
//        var cityTypes = ['locality'];
//        
//        // Is administrative_area_level_1 or administrative_area_level_2
//        if( place.types.length > 0 && 
//            ( 
//                $.inArray( cityTypes[0], place.types ) !== -1 
//            ) 
//        )
//        {
//            autocompleteSuccess(inputCity, place);
//        }else{
//            autocompleteError(inputCity);
//        }
//        
//        console.log(place);
//    });
}