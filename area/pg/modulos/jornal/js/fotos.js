$(function(){
	$(".lista_fotos").sortable({
        stop: function() {
            atualizaOrdemFotos();
        },
        handle: '.foto-photo'
    });
});

function atualizaOrdemFotos() {
    var elemento = $();
    var codImg = "";
    var cont   = 1;
    
    var saida = '[';
    
    elemento = $(".lista_fotos");    
    
    $(elemento).find("li").each(function() {
        if(saida.length > 1) {
            saida = saida+', ';
        }
                                         
        codImg = $(this).attr('id').substr(3);
        saida = saida+'{ "codimg" : "'+codImg+'", "seq" : "'+cont+'" }';
        
        cont++;
    });
    
    saida = saida+"]";
    
    $.ajax({
        url: "pg/modulos/jornal/ajax/ordena_fotos.php",
        type: "post",
        data: { "acao": "bio", "dados": saida }
    });
}

function removeFoto(id) {
	$('#carregando').fadeIn(500);
	if(confirm("Deseja exlcuir a foto ?")) {
		$.ajax({
			url: "pg/modulos/jornal/ajax/fotos.php",
			type: "post",
			dataType: "json",
			data: { "acao" : "del" , "id" : id },
			
			success: function(data) {
				if(data.status == 1) {
					$("#fto"+id).remove();
				} else {
					alert("Ocorreu um erro ao excluir a imagem. \n\n"+data.errmsg);
				}
			}		
		});
	}
	$('#carregando').fadeOut(500);
}

function removeFotos(){
    $('#carregando').fadeIn(500);
    var selecionados = '';
    $("input[type=checkbox][name='ck_del[]']:checked").each(function(ix,el){
    	if(ix == 0) {
    		selecionados += $(this).val();
    		return true;
    	}
        selecionados += '###'+$(this).val();
    });
    
    if(selecionados != '' && confirm('Deseja remover todas as fotos selecionadas ?')) {
    	$.ajax({
	        url:'pg/modulos/jornal/ajax/fotos.php',
	        type:'post',
	        data:'acao=del_v&id='+selecionados,
	        dataType: 'json',
	        success: function(data){
	            $.each(data.itens,function(ix,el){
	            	$('#fto'+el).remove();
	            });
	        }
	    });
	    $(".rem").html('REMOVER SELEÇÃO');	
    } else {
    	$("input[type=checkbox][name='ck_del[]']").attr('checked', false);
    	$(".rem").html('REMOVER SELEÇÃO');	
    }
    $('#carregando').fadeOut(500);
}

function attdelFts(){
	var cont = $("input[type=checkbox][name='ck_del[]']:checked").length;
	if(cont > 0) {
	   $(".rem").html('REMOVER SELEÇÃO ('+cont+')');
	} else {
	   $(".rem").html('REMOVER SELEÇÃO');
	}
}

function editFoto(id) {
	var el = $("#fto"+id).find(".foto-config").first();
	
	$("#lista-fotos").find(".foto-box").each(function(idx, alb) {
		var al    = $(alb).find(".foto-config").first();
		var al_id = $(alb).parent('li').attr("id").substr(3);		
		
		if(id != al_id) {
			$.ajax({
				url: "pg/modulos/jornal/ajax/fotos.php",
				type: "post",
				data: { "acao" : "content" , "tp" : "1" , "id" : al_id },
				
				success: function(data) {
					al.html(data);	
				}		
			});
		}
	});
	
	$.ajax({
		url: "pg/modulos/jornal/ajax/fotos.php",
		type: "post",
		data: { "acao" : "content" , "tp" : "2" , "id" : id },
		
		success: function(data) {
			el.html(data);
			
			ativaValidate(id);
			
			$("#bt_c_alb"+id).click(function(){
				cancelaEdit(id);
			});		
		}		
	});
}

function cancelaEdit(id) {
	var e = $("#fto"+id).find(".foto-config").first();
	
	$.ajax({
		url: "pg/modulos/jornal/ajax/fotos.php",
		type: "post",
		data: { "acao" : "content" , "tp" : "1" , "id" : id },
		
		success: function(data) {
			e.html(data);	
		}		
	});
}

function ativaValidate(id) {
	$('#carregando').fadeIn(500);
	$("#f_album"+id).on('submit', function() {
		$.ajax({
			url: "pg/modulos/jornal/ajax/fotos.php",
			type: "post",
			dataType: "json",
			data: $(this).serialize(),
			
			success: function(data) {	
				if(data.status == 1) {
					okk("Dados atualizados com sucesso");					
					$("#bt_c_alb"+id).click();
				} else {
					alert("Ocorreu um erro ao atualizar os dados. \n\n"+data.errmsg);
				}
			}
		});
		
		return false;
	});
	$('#carregando').fadeOut(500);
}