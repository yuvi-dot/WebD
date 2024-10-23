$(document).ready(function(){

    $('#menu').click(function(){
        $(this).toggleClass('fa-times');
        $('.navbar').toggleClass('nav-toggle');
    });

});

document.getElementById("requestButton").addEventListener("click", function() {
    document.querySelector(".popupForm").style.display = "block";
    document.querySelector(".navbar ul li a.active").classList.remove("active");
    document.querySelector(".navbar ul li:nth-child(3) a").classList.add("active");
});

document.querySelector(".closeButton").addEventListener("click", function() {
    document.querySelector(".popupForm").style.display = "none";
    document.querySelector(".navbar ul li a.active").classList.remove("active");
    document.querySelector(".navbar ul li:nth-child(1) a").classList.add("active");
});

window.onclick = function(event) {
    var popup = document.querySelector(".popupForm");
    if (event.target == popup) {
        popup.style.display = "none";
        document.querySelector(".navbar ul li a.active").classList.remove("active");
        document.querySelector(".navbar ul li:nth-child(1) a").classList.add("active");
    }
};

window.scrollTo({ top: 0});
