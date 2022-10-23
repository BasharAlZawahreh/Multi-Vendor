$(document).ready(function () {
    $(document).on("change",".data-quantity" , function () {
        var $this = $(this);
        var quantity = $this.val();
        var id = $this.data("id");
        var url = "/cart/" + id;
        $.ajax({
            url: url,
            data: {
                quantity: quantity,
            },
            method: "PUT",
            "Content-Type":"application/json",
            success: function (response) {
                console.log(response.message);
            },
        });
    });
});

