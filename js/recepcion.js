$(function(){
    var selectProveedor = $("#proveedor");
    $.ajax({
        url: selectProveedor.data("url"),
        type: "POST",
        dataType: "json",
        contentType: "application/json; charset=utf-8"
    }).done(function(response){
        $.each(response.data, function(i, proveedor){
            selectProveedor.append($('<option>',{
                text: proveedor.Nombre+" "+proveedor.ApellidoPaterno+" "+proveedor.ApellidoMaterno,
                value: proveedor.IDProveedor
            }));
        });
        var selected = selectProveedor.data("selected");
        if(selected){
            selectProveedor.find("option:selected").removeAttr("selected");
            selectProveedor.find("[value="+selected+"]").attr("selected","selected");
        }
    });

    var selectProductos = $("#listaProductos");
    $.ajax({
        url: selectProductos.data("url"),
        type: "POST",
        dataType: "json",
        contentType: "application/json; charset=utf-8"
    }).done(function(response){
        $.each(response.data, function(i, producto){
            var option = $('<option>',{
                text: producto.Producto+" $ "+producto.PrecioUnitario,
                value: producto.IDProductoServicio
            });
            option.click(function(){
                var el = $(this);

                var parentContainer = $("#productosContainer");
                var container = $('<tr>');
                
                var del = $('<td class="text-center">'),
                    delButton = $('<button class="btn btn-danger btn-circle">');
                    delButton.data('id',el.val());
                    delButton.click(function(e){
                        e.preventDefault();
                        var el = $(this);
                        $("option[value="+el.data('id')+"]").removeAttr("disabled");
                        el.parent().parent().remove();
                        $("option:selected").removeAttr("selected");
                        calcularTotal();
                        //console.log($(this).parent());
                    });
                    delButton.append($('<i class="fa fa-close">'));
                    del.append(delButton);
                    container.append(del);

                var idTd = $('<td>');
                    idTd.append($('<input>',{
                        "class": "form-control",
                        type: "text",
                        readonly: "readonly",
                        name: "idProductos[]",
                        value: el.val()
                    }));
                    container.append(idTd);
                
                var nombreTd = $('<td>');
                    nombreTd.append($('<input>',{
                        "class": "form-control",
                        type: "text",
                        readonly: "readonly",
                        value: el.text().split("$")[0]
                    }));
                    container.append(nombreTd);
                
                var precioTd = $('<td>');
                    precioTd.append($('<input>',{
                        "class": "form-control precio-unitario",
                        type: "text",
                        readonly: "readonly",
                        name: "precioUnitario[]",
                        value: "$ "+el.text().split("$")[1]
                    }));
                    container.append(precioTd);
                
                var cantidadTd = $('<td>');
                var inputCant = $('<input>',{
                        "class": "form-control",
                        type: "number",
                        name: "cantidades[]",
                        value: 1,
                        min: 1,
                        step: 1
                    });
                    inputCant.on("change keyup",function(){
                        var el = $(this),
                            tr = el.parent().parent();
                        if(el.val()<0)
                            el.val(1);
                        tr.find("[name=subtotal]").val("$ "+tr.find(".precio-unitario").val().split("$")[1]*el.val());
                        //Falta agregar iva y quitar descuentos
                        calcularTotal();
                    });
                    cantidadTd.append(inputCant);
                    container.append(cantidadTd);
                
                var subTotalTd = $('<td>');
                    subTotalTd.append($('<input>',{
                        "class": "form-control",
                        type: "text",
                        readonly: "readonly",
                        name: "subtotal",
                        value: "$ "+el.text().split("$")[1]
                    }));
                    container.append(subTotalTd);
                    
                el.attr("disabled","diabled");

                parentContainer.append(container);

                calcularTotal();
                $("option:selected").removeAttr("selected");
            });
            selectProductos.append(option);
        });
    });

    //Se calcula el total
    var totalProductos = $("#totalProductos");
    function calcularTotal(){
        var sum = 0;
        $("[name=subtotal]").each(function(k, v){
            sum += parseFloat($(v).val().split("$ ")[1]);
        });
        totalProductos.text("$ "+sum);
    }

    var botonSeguro = $("#botonSeguro");
    $("[data-id]").click(function(e){
        e.preventDefault();
        var el = $(this);
        botonSeguro.data("ideliminar",el.data("id"));
    });
    botonSeguro.click(function(e){
        e.preventDefault();
        var el = $(this);
        var id = el.data("ideliminar");
        if(id>=0){
            $.ajax({
                type: 'POST',
                data:{ idProveedor: id },
                url: el.attr("href"),
                dataType: 'json'
            }).done(function(response){
                if (response.error == 0) {
                    botonSeguro.data("ideliminar",-1);
                    console.log(response);
                    $("[data-id="+id+"]").closest("tr").hide(1000,function(){
                        $(this).remove()
                    });
                    $("#myModal").modal("toggle");
                }
            });
        }
    });

    $("#formulario").submit(function(e){
        e.preventDefault();
        var el = $(this);
        $("#modalCargar").modal("toggle");
        $.ajax({
            type: 'POST',
            data: el.serialize() ,
            url: el.attr("action"),
            dataType: 'json'
        }).done(function(response){
            if(response.error == 0){
                document.location = $("#formulario").data("tolocation");
            }
        });
    });
});