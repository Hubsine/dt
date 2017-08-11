
function autocompleteLocationRegion(selectCountry, inputRegion, autocompleteRegion)
{
    inputRegion.val('');
    
    autocompleteRegion.setComponentRestrictions({'country': selectCountry.val()});

    google.maps.event.addListener(autocompleteRegion, 'place_changed', function () {

        var place = autocompleteRegion.getPlace();
        var regionTypes = ['administrative_area_level_1', 'administrative_area_level_2'];

        // Is administrative_area_level_1 or administrative_area_level_2
        if( place.types.length > 0 && 
            ( 
                $.inArray( regionTypes[0], place.types ) !== -1 
                || $.inArray( regionTypes[1], place.types ) !== -1
            ) 
        )
        {
            inputRegion.val( place.name ).parent('.form-group').removeClass('has-error');
        }else{
            inputRegion.val('').parent('.form-group').addClass('has-error');
        }
        
        console.log(place);
    });
}

