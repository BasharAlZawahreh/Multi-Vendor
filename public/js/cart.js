/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/cart.js ***!
  \******************************/
$(document).ready(function () {
  $(document).on("change", ".data-quantity", function () {
    var $this = $(this);
    var quantity = $this.val();
    var id = $this.data("id");
    var url = "/cart/" + id;
    $.ajax({
      url: url,
      data: {
        quantity: quantity
      },
      method: "PUT",
      "Content-Type": "application/json",
      success: function success(response) {
        console.log(response.message);
      }
    });
  });
});
/******/ })()
;