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

    $(function(){
    var selectEmpleado = $("#idEmpleado");
    $.ajax({
        url: selectEmpleado.data("url"),
        type: "POST",
        data:{ constrains[IDCargo]: 1 },
        dataType: "json",
        contentType: "application/json; charset=utf-8"
    }).done(function(response){
        $.each(response.data, function(i, empleado){
            selectEmpleado.append($('<option>',{
                text: empleado.Nombre+" "+empleado.ApellidoPaterno+" "+empleado.ApellidoMaterno,
                value: empleado.IDEmpleado
            }));
        });
        var selected = selectEmpleado.data("selected");
        if(selected){
            selectEmpleado.find("option:selected").removeAttr("selected");
            selectEmpleado.find("[value="+selected+"]").attr("selected","selected");
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