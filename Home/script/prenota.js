function addCheckboxListeners() {
  var checkboxes = document.querySelectorAll('input[type="checkbox"]');
  checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
      var className = checkbox.id.replace("Chbox", "");
      document.querySelectorAll("." + className).forEach(function (element) {
        element.classList.toggle("hide", checkbox.checked);
      });
    });
  });
}
addCheckboxListeners();
