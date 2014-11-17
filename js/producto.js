$(function(){
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
                data:{ idProducto: id },
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

    if($("#fileUpload").length){
        $("#fileUpload").fileupload({
            url: $(this).data("url"),
            dataType: 'json',
            done: function(e, data){
                if(data.result.length>0){
                    $("#foto").val(data.result[0]);
                }
            },
            progressall: function(e, data){
                var progress = parseInt(data.loaded / data.total *100, 10);
                console.log(progress);
            },
        });
    }
});