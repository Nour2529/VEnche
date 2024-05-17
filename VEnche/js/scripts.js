/*!
* Start Bootstrap - Agency v7.0.12 (https://startbootstrap.com/theme/agency)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-agency/blob/master/LICENSE)
*/
//
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    //  Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

});


// Lorsque la valeur du curseur de prix minimum change
document.getElementById('rangeInput').addEventListener('input', function() {
    console.log("hhh")
    // Mettre à jour la valeur affichée
    document.getElementById('amount').innerHTML = this.value;
    // Envoyer les valeurs de filtre au serveur
    sendFilterValues();
});

// Lorsque la valeur du curseur de prix maximum change
document.getElementById('maxPrice').addEventListener('input', function() {
    // Mettre à jour la valeur affichée
    document.getElementById('maxAmount').innerHTML = this.value;
    // Envoyer les valeurs de filtre au serveur
    sendFilterValues();
});

function sendFilterValues() {
    // Récupérer les valeurs des curseurs
    var minPrice = document.getElementById('rangeInput').value;
    var maxPrice = document.getElementById('maxPrice').value;
    var url;
    if (window.location.href.indexOf('?') !== -1) {
        if((window.location.href.indexOf('&') !== -1))
        {
            url= window.location.href.substring(0,window.location.href.indexOf('&')) +"&min="+minPrice+"&max="+maxPrice;
        }else{
            url= window.location.href+"&min="+minPrice+"&max="+maxPrice;
        }
    } else {
        // The URL does not contain 'subCategorieId'
        url="annonce.php?min="+minPrice+"&max="+maxPrice;
    }
    window.location.href = url;  

}

var searchIcon = document.getElementById("searchIcon");

searchIcon.addEventListener("click", function() {

    var searchTerm = document.getElementById("searchInput").value;

    if (window.location.href.indexOf('?') !== -1) {
        if((window.location.href.indexOf('&') !== -1))
        {
            url= window.location.href.substring(0,window.location.href.indexOf('&')) +"&titre="+searchTerm;
        }else{
            url= window.location.href+"&titre="+searchTerm;
        }
    } else {
        url="annonce.php?titre="+searchTerm;
    }
    window.location.href = url;  


});


