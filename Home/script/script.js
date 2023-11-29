function addCheckboxListeners() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", function() {
            var className = checkbox.id.replace("Chbox", "");
            document.querySelectorAll("." + className).forEach(function(element) {
                element.classList.toggle("hide", checkbox.checked);
            });
        });
    });
}
addCheckboxListeners();


document.addEventListener('DOMContentLoaded', function() {
    var mobileMenu = document.getElementById('mobile-menu');
    var navList = document.querySelector('.nav-list');

    mobileMenu.addEventListener('click', function() {
        navList.classList.toggle('show');
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.menu')) {
            navList.classList.remove('show');
        }
    });
});