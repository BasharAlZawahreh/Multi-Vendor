document.ready((function(){$(".item-quantity").on("change",(function(){var t=$(this),n=t.val(),a="/cart/"+t.data("id");$.ajax({url:a,data:{quantity:n,_token:csrfToken},type:"PUT",success:function(t){console.log(t)}})}))}));