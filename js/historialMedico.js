$(function(){
    var selectCliente = $("#idCliente");
    $.ajax({
        url: selectCliente.data("url"),
        type: "POST",
        dataType: "json",
        contentType: "application/json; charset=utf-8"
    }).done(function(response){
        $.each(response.data, function(i, cliente){
            selectCliente.append($('<option>',{
                text: cliente.Nombre+" "+cliente.ApellidoPaterno+" "+cliente.ApellidoMaterno,
                value: cliente.IDCliente
            }));
        });
        var selected = selectCliente.data("selected");
        if(selected){
            selectCliente.find("option:selected").removeAttr("selected");
            selectCliente.find("[value="+selected+"]").attr("selected","selected");
        }
    });

    var selectServicio = $("#idServicio");
    $.post(selectServicio.data("url"), function(response){
        $.each(response.data, function(i, servicio){
            selectServicio.append($('<option>',{
                text: servicio.Producto,
                value: servicio.IDProductoServicio
            }));
        });
        var selected = selectServicio.data("selected");
        if(selected){
            selectServicio.find("option:selected").removeAttr("selected");
            selectServicio.find("[value="+selected+"]").attr("selected","selected");
        } 
    });

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
                data:{ idRecepcion: id },
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
                //console.log(response);
                document.location = $("#formulario").data("tolocation")+"id/"+response.data;
            }
        });
    });
});