$(document).ready(function () {

    // 删除商品
    $(".delete.opbtn").click(function (e) {
        if (!confirm("Do you really want to delete it?"))
            return;

        var $li = $(this).parents("li:first");
        var id = $li.data("id");  //就是data-id

        $.ajax({
            type: "GET",
            url: location.href, // 本页面跳转
            data: { id: id, type: "delete" },
            dataType: "json",
            complete: function (data) {
				if(!data.code && data.responseText)
					data = JSON.parse(data.responseText);
                if (data.code == 200) {
                    $li.fadeOut(function () {
                        var amount = $li.parent().children("li").length - 1;
                        var num = 3;
                        if ($li.parent().width() < 850)
                            num = 4;
                        $li.parent().height(Math.ceil(amount / num) * 316);
                        $li.remove();
                    });
                }
                else if (data.code == 300) {
                    alert("No permission!");
                }
                else
                    alert(data.msg);
            }
        });
    });

    // add more item
    $(".op.add").click(function (e) {
        location.href = "addItem.php";
    });

    // edit chosed item
    $(".edit.opbtn").click(function (e) {
        location.href = "editItem.php?id=" + $(this).parents("li:first").data("id");
    });

    // add item to cart
    $(".cart.opbtn").click(function (e) {
        var $li = $(this).parents("li:first");
        var id = $li.data("id");
        var name = $li.find(".name").text();
        var price = $li.find(".price").text();
        $.ajax({
            type: "POST",
            url: "php/cart.php",
            data: { id: id, type: 1, name: name, price: price },
            dataType: "json",
            complete: function (data) {
				if(!data.code && data.responseText)
					data = JSON.parse(data.responseText);
                if (data.code == 200) {
                    $("<tr data-id='" + id + "'><td class='name'>" + $li.find(".name").text() + "</td><td class='price'>" + $li.find(".price").text() + "</td><td class='sub'>-</td><td class='qty'>1</td><td class='add'>+</td></tr>").appendTo($(".CartList"));
                    updateTotal();
                }
                else if (data.code == 300) {
                    alert(data.msg);
                }
                else if (data.code == 500) {
                    alert(data.msg);
                }
                else
                    alert(data.msg);
            }
        });
    });

    // sub the quantity of a cart item
    $(".CartList").on("click", ".sub", function () {
        var $li = $(this).parents("tr:first");
        var id = $li.data("id");
        $.ajax({
            type: "POST",
            url: "php/cart.php",
            data: { id: id, type: 2 },
            dataType: "json",
            complete: function (data) {
				if(!data.code && data.responseText)
					data = JSON.parse(data.responseText);
                if (data.code == 200) {
                    $li.find(".qty").text(parseInt($li.find(".qty").text()) - 1);
                    updateTotal();
                }
                else if (data.code == 300) {
                    $li.fadeOut(function () {
                        $li.remove();
                        updateTotal();
                    });
                }
                else
                    alert(data.msg);
            }
        });
    });

    // add the quantity of a cart item
    $(".CartList").on("click", ".add", function () {
        var $li = $(this).parents("tr:first");
        var id = $li.data("id");
        $.ajax({
            type: "POST",
            url: "php/cart.php",
            data: { id: id, type: 3 },
            dataType: "json",
            complete: function (data) {
				if(!data.code && data.responseText)
					data = JSON.parse(data.responseText);
                if (data.code == 200) {
                    $li.find(".qty").text(parseInt($li.find(".qty").text()) + 1);
                    updateTotal();
                }
                else
                    alert(data.msg);
            }
        });
    });

    // clear cart
    $(".clear.opbtn").click(function (e) {
        $.ajax({
            type: "POST",
            url: "php/cart.php",
            data: { id: 0, type: 4 },
            dataType: "json",
            complete: function (data) {
				if(!data.code && data.responseText)
					data = JSON.parse(data.responseText);
                if (data.code == 200) {
                    $(".CartList").html("");
                    updateTotal();
                }
                else
                    alert(data.msg);
            }
        });
    });

    // order all cart item
    $(".pay.opbtn").click(function (e) {
        if($(".CartList").find("tr").length)
            $.ajax({
                type: "POST",
                url: "php/cart.php",
                data: { id: 0, type: 5 },
                dataType: "json",
                complete: function (data) {
					if(!data.code && data.responseText)
						data = JSON.parse(data.responseText);
                    if (data.code == 200) {
                        alert("Operation successful!");
                        $(".CartList").html("");
                        updateTotal();
                    }
                    else if (data.code == 300) {
                        alert(data.msg);
                        location.href = "login.php";
                    }
                    else if (data.code == 400) {
                        alert(data.msg);
                    }
                    else
                        alert(data.msg);
                }
            });
    });

    // update the total amount
    function updateTotal() {
        var total = 0;
        $(".CartList").find("tr").each(function (i, v) {
            total += parseInt($(v).find(".qty").text()) * parseFloat($(v).find(".price").text()*0.75);
        });
        $(".total").text(total);
    }
    updateTotal();

});