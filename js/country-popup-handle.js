jQuery(document).ready(function($) {
    // Display the popup
    var popup = $('.popup-container');
    var disclaimerPopup = document.getElementById('disclaimer-popup');
    var agreeButton = document.getElementById('agree-button');
    var disagreeButton = document.getElementById('disagree-button');
    var countryForm = document.getElementById('country-popup-form');
    var redirectURL = countryPopupParams.redirectURL;
    var notOkCountries = countryPopupParams.notOkCountries;
    var selectedCountry;


    // Handle form submission
    if (countryForm) {
        countryForm.addEventListener('submit', function(e) {
            e.preventDefault();
            selectedCountry = document.getElementById('country-dropdown').value;
            if(selectedCountry == "-") {
                document.getElementById('country-dropdown').style.border = '1px solid red';
            }
            else if (notOkCountries.includes(selectedCountry)) {
                // Handle action for not allowed countries 
                console.log('Selected Country:', selectedCountry);
                window.location.href = redirectURL;
            } else {
                // Display the disclaimer popup for OK country

                if (disclaimerPopup) {
                    disclaimerPopup.style.display = 'block';
                }
                
            }
        });
    }

    // Handle Agree button click in disclaimer popup
    if (agreeButton) {
        agreeButton.addEventListener('click', function() {
            // Hide the disclaimer popup if user agrees
            if (disclaimerPopup) {
                $(popup).fadeOut(); // Close the popup (example: fade out)
            }
        });
    }

    // Handle Disagree button click in disclaimer popup
    if (disagreeButton) {
        disagreeButton.addEventListener('click', function() {
            // Redirect user to custom URL if user disagrees
            window.location.href = redirectURL;
        });
    }
});
