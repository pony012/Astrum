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