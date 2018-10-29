jQuery(document).ready(function() {

    $('#txtfecha').datepicker({
        format: "dd-mm-yyyy",
        language: "es",
        autoclose: true,
        todayHighlight: true
    });

    $('#formlogin').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type:'POST',
            url:'https://prueba-conforce.herokuapp.com/Modelo.php',
            data:$('#formlogin').serialize()+'&op=valsesion',
            success:function(resp){
                if(resp == 0){
                    alert("Ocurrió problemas al buscar el registro");
                }else if (resp == 1 || resp == 3) {
                    alert("Usuario o contraseña errados");
                }else if(resp == 2){
                    alert("Usuario desactivado");
                    $('#dataTables-usuario').DataTable().ajax.reload();
                }else{
                    ir("landing.php");
                }
            }
        }); 
        
    });

    $('#formUsu').on('submit',function(event) {
        event.preventDefault();
        $.ajax({
            type:'POST',
            url:'https://prueba-conforce.herokuapp.com/Modelo.php',
            data:$('#formUsu').serialize()+'&op=registrousu',
            success:function(resp){
                if(resp == 1){ 
                    $('#formUsu')[0].reset();
                    $("#formUsu:input:text:visible:first").focus();
                    $('#dataTables-usuario').DataTable().ajax.reload();
                    alert("Resgistro exitoso");
                }else if(resp == 2){ 
                     alert("Nombre de usuario registrado, prueba otro");
                }else if(resp == 3){
                    alert("Ocurrio un error al ingresar el registro");
                }else{ 
                    alert("Hubo un error en la búsqueda");
                }
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });         
    });

    $('#limpiarUsu').on('click',function(event) {
        $('#formUsu')[0].reset();
        $('#regUsu').show();
        $('#modUsu').hide();
        $("#formUsu").find('input').each(function() {
             $(this).prop('disabled', false);
        });
        $('#selectstatus').hide();
        $('#idusumod').val('0');
        $("#txtnombre").focus();
    });

    $('#modUsu').on('click', function(event) {
        event.preventDefault();
       
        if(confirm("¿Seguro desea editar el registro?")){
            $.ajax({
                type:'POST',
                url:'https://prueba-conforce.herokuapp.com/Modelo.php',
                data:$('#formUsu').serialize()+'&op=editusu',
                success:function(resp){
                    if(resp == 1){
                        $('#dataTables-usuario').DataTable().ajax.reload();
                        alert("Registro editado exitosamente");
                         $('#limpiarUsu').click();
                    }else if(resp == 0){
                        alert("Ocurrió un error al editar el registro");
                    }else{
                        alert("Error en datos del registro");
                    }
                }
            }); 
        }

    });

    $('#formresetpass').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            type:'POST',
            url:'https://prueba-conforce.herokuapp.com/Modelo.php',
            data:$('#formresetpass').serialize()+'&op=resetpass',
            success:function(resp){
                if(resp == 0){ 
                    alert("Error al buscar email");
                }else if (resp == 1) {
                    alert("Email no existe");
                }else if (resp == 2) {
                    alert("Correo enviado exitosamente");
                    ir("index.php");
                }else if (resp == 4) {
                    alert("Error al enviar el correo");
                }else{
                    alert("Error al ingresar el has en la bdd");
                }
            }
        }); 
        
    });

    $('#cambiarpass').on('submit', function(e) {
        e.preventDefault();
      
        if($('#cla1').val() == $('#cla2').val()){
            $.ajax({
                type:'POST',
                url:'https://prueba-conforce.herokuapp.com/Modelo.php',
                data:$('#cambiarpass').serialize()+'&op=cambiarpass',
                success:function(resp){
                    if(resp == 0){
                        alert("Error al buscar registro");
                    }else if (resp == 1) {
                        alert("Token invalido");
                    }else if (resp == 3) {
                        alert("Usuario inválido");
                    }else if (resp == 4) {
                        alert("Error al actualizar contraseña");
                    }else if (resp == 5) {
                        alert("Contraseña actualizada correctamente");
                        ir("index.php");
                    }else{
                        alert("Las contraseñas no coinciden");
                        $('#cla1').focus();
                    }
                }
            }); 
        }else{
            alert("Las contraseñas no coinciden");
            $('#cla1').focus();
        }
        
    });

    $('#formproces').on('submit',function(e){
        e.preventDefault();
        if($('#txtnum').val().length != 8){
            alert("El código d eProceso debe ser de 8 carcateres");
            $('#txtnum').focus();
            return;
        }

        if($('#txtdescrip').val().length > 200){
            alert("La descripción debe contener máximo 200 caracteres");
            $('#txtdescrip').focus();
            return;
        }

        if($('#txtdescrip').val().length == 10){
            alert("La descripción debe contener al menos 10 caracteres");
            $('#txtdescrip').focus();
            return;
        }

        $.ajax({
            type:'POST',
            url:'https://prueba-conforce.herokuapp.com/Modelo.php',
            data:$('#formproces').serialize()+'&op=guardarproceso',
            success:function(resp){
                if(resp == 1){
                    $('#limpiarProc').click();
                    alert("Proceso registrado");
                   $('#dataTables-proceso').DataTable().ajax.reload();
                }
                else{
                    alert("Número de proceso repetido");
                    $('#txtnum').focus();
                }
            }
        }); 


    });

    $('#limpiarProc').on('click',function(event) {
        $('#formproces')[0].reset();
        $("#txtnum").focus();
        $("#contador").html(200);
    });


    $("#txtpresupuesto").on({
      "focus": function(event) {
        $(event.target).select();
      },
      "keyup": function(event) {
        $(event.target).val(function(index, value) {
          return value.replace(/\D/g, "")
            .replace(/([0-9])([0-9]{2})$/, '$1,$2')
            .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
        });
      }
    });

    $("#txtdescrip").keyup(function() {

        var max = "200";
        var cadena = $(this).val();
        var longitud = parseInt(cadena.length);
        if(longitud <= max) {
            $("#contador").html(max-longitud);
        }else{
            $(this).val(cadena.substr(0, max));
        }

    });

    $('#editformproces').on('submit',function(e){
            e.preventDefault();
            if($('#txtnum').val().length != 8){
                alert("El código d eProceso debe ser de 8 carcateres");
                $('#txtnum').focus();
                return;
            }

            if($('#txtdescrip').val().length > 200){
                alert("La descripción debe contener máximo 200 caracteres");
                $('#txtdescrip').focus();
                return;
            }

            if($('#txtdescrip').val().length == 10){
                alert("La descripción debe contener al menos 10 caracteres");
                $('#txtdescrip').focus();
                return;
            }
        if(confirm("¿Seguro desea editar el registro?")){
            $.ajax({
                type:'POST',
                url:'https://prueba-conforce.herokuapp.com/Modelo.php',
                data:$('#editformproces').serialize()+'&op=editproceso',
                success:function(resp){
                    alert(resp);
                    if(resp == 1){
                        alert("Proceso editado");
                        ir("crearproceso.php");
                    }else if(resp == 3){
                        alert("El código del proceso existe");
                        $('#txtnum').focus();
                    }else{
                        alert("Ocurrió un error al buscar el proceso");
                    }
                }
            }); 
        }

        });

        $('#volver').on('click',function(event) {
            ir('crearproceso.php');
        });


    ///////////////////////////////////////  

});

function verProceso (datos){
    $.ajax({
        type:'POST',
        url:'https://prueba-conforce.herokuapp.com/Modelo.php',
        data:'datos='+JSON.stringify(datos)+'&op=viewproc',
        success:function(resp){
            ir('mostrar.php');
        }
    }); 
}

function ir(pagina){
    location.href=pagina;
}

function editar(datos){
    
    $('#txtnombre').val(datos.nombreusu);
    $('#txtape').val(datos.apeusu);
    $('#txtemail').val(datos.loginusu);
    $('#txtpass').val("*************");
    $('#idusumod').val(datos.idusuario);
    $('#statususu').val(datos.status);
    $('#txtemail').prop('disabled', true);
    $('#txtpass').prop('disabled', true);
    $('#regUsu').hide();
    $('#modUsu').show();
    $('#selectstatus').show();
}

function eliminarusu(idusu){
    if(idusu != ''){
        if (confirm("¿Seguro desea desactivar este registro?")) {
            $.ajax({
                type:'POST',
                url:'https://prueba-conforce.herokuapp.com/Modelo.php',
                data:'idusu='+idusu+'&op=deleteusu',
                success:function(resp){
                    if(resp == 1){
                        $('#dataTables-usuario').DataTable().ajax.reload();
                        alert("Usuario desactivado exitosamente");
                    }else{ 
                        alert("Ocurrió un error al desactivar el usuario");
                    }
                }
            }); 
        }
    }
}
//////////////////
