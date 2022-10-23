document.ready(function () {
    $(".item-quantity").on("change", function () {
        var $this = $(this);
        var quantity = $this.val();
        var id = $this.data("id");
        var url = "/cart/" + id;
        $.ajax({
            url: url,
            data: {
                quantity: quantity,
                _token: csrfToken,
            },
            type: "PUT",
            success: function (response) {
                console.log(response);
            },
        });
    });
});
