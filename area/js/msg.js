function okk(msg) {
	$(document).ready(function() { 
		$.blockUI({ message: "<div id='msgalerta'><img src='img/icones/ok.png' width='64' height='64' alt='Ok' /><div id='tmsg'>"+msg+"...</div></div>", css: { width: '100%', left: '-3px' } });  
		setTimeout($.unblockUI, 2000);
    }); 
}
function erro(msg) {
	$(document).ready(function() {
		$('#carregando').fadeIn(500);
		$.blockUI({ message: "<div id='msgalerta'><img src='img/icones/atencao.png' width='64' height='64' alt='Ok' /><div id='tmsg'>"+msg+"...</div></div>", css: { width: '100%', left: '-3px' } });  
		setTimeout($.unblockUI, 2000);
		$('#carregando').fadeOut(2250);
    }); 
}
function error(msg, volta) {
	$(document).ready(function() { 
		$.blockUI({ message: "<div id='msgalerta'><img src='img/icones/atencao.png' width='64' height='64' alt='Ok' /><div id='tmsg'>"+msg+"...</div></div>", css: { width: '100%', left: '-3px' } });  
		setTimeout($.unblockUI, 2000);
		setTimeout("location.href='"+volta+"'",2400);
    }); 
}
function ok(msg, volta) {
	$(document).ready(function() { 
		$.blockUI({ message: "<div id='msgalerta'><img src='img/icones/ok.png' width='64' height='64' alt='Ok' /><div id='tmsg'>"+msg+"...</div></div>", css: { width: '100%', left: '-3px' } });  
		setTimeout($.unblockUI, 2000);
		setTimeout("location.href='"+volta+"'",2400);
    }); 
}
function confirmaDel(link){
	if(confirm("Tem certeza que deseja remover?")){
		location.href=''+link+'';
	}
}
function PopUpCentralizado(nomepagina, titulopagina, w, h, scroll) {
 var winl = (screen.width - w) / 2;
 var wint = (screen.height - h) / 2;
  winprops = 'height=' + h + ', width = ' + w + ', top = ' + wint + ', left = ' + winl + ', scrollbars = ' + scroll + ', location=no, status=no';
  win = window.open(nomepagina, titulopagina, winprops);
  if (parseInt(navigator.appVersion)  >= 4) {
      win.window.focus();
  }
}
function vsenha() {
  ns1 = document.pass.novasenha.value;
  ns2 = document.pass.novasenha2.value;
  if(ns1==ns2){
    $('span#ok').show();
    $('span#erro').hide();
  } else {
    $('span#erro').show();
    $('span#ok').hide();
  }
}
function vonline(){
	$('#carregando').fadeIn(500);
	if($('#vonline').is(":visible")==false){
		$.ajax({
			url:'pg/config/vonline.php',
			type:'post',
			success: function(data){
				$("#vonline").html(data);
			}
		});
	}
	$('#vonline').slideToggle();
	$('#carregando').fadeOut(500);
}
function delFotos(){
    $('#carregando').fadeIn(500);
    $.ajax({
        url:'pg/config/delfoto.php',
        type:'post',
        success: function(data){
            $("#fotos-empresa").html(data);
        }
    });
    $('#carregando').fadeOut(500);
}
//VALIDA FORMULÁRIO
function validaform(id) {
	var err = 0;
    $("#"+id).find(".obrigatorio").each(function(idx,el){
    	if($(el).attr("id")=='email'){
    		if($("#"+$(el).attr("id")).empty() && $("#"+$(el).attr("id")).val().search(/^\w+((-\w+)|(\.\w+))*\@\w+((\.|-)\w+)*\.\w+$/) == -1){
				err++;
				erro('Por favor, preencha um e-mail valido');
			    $("#"+$(el).attr("id")).focus();
			    return false;
			}
    	} else {
			if($("#"+$(el).attr("id")).val()==''){
				err++;
				erro('Por favor, preencha todos os campos');
			    $("#"+$(el).attr("id")).focus();
			    return false;
			}
		}
	});
	if(err==0){ $("#"+id).submit(); }
}


$(document).ready(function(){
    $("input[name='rd-pessoa']").click(function(){  
        $("#palco > div").hide();

        if($("#"+$(this).val()).attr("id")=='fisica'){
            $("#cpf").validacpf();
            $("#cnpj, #ies, #empresa").removeClass("obrigatorio").addClass("vt");
        } else if($("#"+$(this).val()).attr("id")=='juridica'){
            $("#cnpj").validacnpj();
            $("#rg, #cpf").removeClass("obrigatorio").addClass("vt");
        }

        $("#"+$('#'+$(this).val()).attr("id")).find(".vt").each(function(idx,el){
            $("#"+$(el).attr("id")).removeClass("vt").addClass("obrigatorio");
        });

        $('#'+$(this).val()).fadeIn('fast');   
    });

    //VALIDAÇÃO CNPJ
    jQuery.fn.validacnpj = function(){
      this.change(function(){
        CNPJ = $(this).val();
        if(!CNPJ){ return false;}
        ms = new String;
        if(CNPJ == "00.000.000/0000-00"){
        	ms += "CNPJ invalido";
        }
        CNPJ = CNPJ.replace(".","");
        CNPJ = CNPJ.replace(".","");
        CNPJ = CNPJ.replace("-","");
        CNPJ = CNPJ.replace("/","");

        var a = [];
        var b = new Number;
        var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
        for(i=0; i<12; i++){
          a[i] = CNPJ.charAt(i);
          b += a[i] * c[i+1];
        }
        if((x = b % 11) < 2){
          a[12] = 0
        }else{
          a[12] = 11-x
        }
        b = 0;
        for(y=0; y<13; y++){
          b += (a[y] * c[y]);
        }
        if((x = b % 11) < 2){
          a[13] = 0;
        }else{
          a[13] = 11-x;
        }
        if((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){
        	ms +="CNPJ invalido";
        }
        if (ms.length > 0){
          erro(ms);
          $("#cnpj").focus();
          return false;
        }
        return $(this);
      });
    }

    //VALIDA CPF
    jQuery.fn.validacpf = function(){
        this.change(function(){
            CPF = $(this).val();
            if(!CPF){ return false;}
            ms  = new String;
            cpfv  = CPF;
            if(cpfv.length == 14 || cpfv.length == 11){
                cpfv = cpfv.replace('.', '');
                cpfv = cpfv.replace('.', '');
                cpfv = cpfv.replace('-', '');
     
                var nonNumbers = /\D/;
       
                if(nonNumbers.test(cpfv)){
                    ms = "Apenas numeros";
                }else{
                    if (cpfv == "00000000000" ||
                        cpfv == "11111111111" ||
                        cpfv == "22222222222" ||
                        cpfv == "33333333333" ||
                        cpfv == "44444444444" ||
                        cpfv == "55555555555" ||
                        cpfv == "66666666666" ||
                        cpfv == "77777777777" ||
                        cpfv == "88888888888" ||
                        cpfv == "99999999999") {
                               
                        ms = "CPF invalido"
                    }
                    var a = [];
                    var b = new Number;
                    var c = 11;
     
                    for(i=0; i<11; i++){
                        a[i] = cpfv.charAt(i);
                        if (i < 9) b += (a[i] * --c);
                    }
                    if((x = b % 11) < 2){
                        a[9] = 0
                    }else{
                        a[9] = 11-x
                    }
                    b = 0;
                    c = 11;
                    for (y=0; y<10; y++) b += (a[y] * c--);
       
                    if((x = b % 11) < 2){
                        a[10] = 0;
                    }else{
                        a[10] = 11-x;
                    }
                    if((cpfv.charAt(9) != a[9]) || (cpfv.charAt(10) != a[10])){
                        ms = "CPF invalido";
                    }
                }
            }else{
                if(cpfv.length == 0){
                    return false;
                }else{
                    ms = "CPF invalido";
                }
            }
            if (ms.length > 0){
                $(this).focus();
                erro(ms);
                return false;
            }
            return $(this);
        });
    }
});
//<![CDATA[
addEvent = function(o, e, f, s){
  var r = o[r = "_" + (e = "on" + e)] = o[r] || (o[e] ? [[o[e], o]] : []), a, c, d;
  r[r.length] = [f, s || o], o[e] = function(e){
    try{
      (e = e || event).preventDefault || (e.preventDefault = function(){e.returnValue = false;});
      e.stopPropagation || (e.stopPropagation = function(){e.cancelBubble = true;});
      e.target || (e.target = e.srcElement || null);
      e.key = (e.which + 1 || e.keyCode + 1) - 1 || 0;
    }catch(f){}
    for(d = 1, f = r.length; f; r[--f] && (a = r[f][0], o = r[f][1], a.call ? c = a.call(o, e) : (o._ = a, c = o._(e), o._ = null), d &= c !== false));
    return e = null, !!d;
    }
};

removeEvent = function(o, e, f, s){
  for(var i = (e = o["_on" + e] || []).length; i;)
    if(e[--i] && e[i][0] == f && (s || o) == e[i][1])
      return delete e[i];
  return false;
};

function formataMoeda(o, n, dig, dec){
  o.c = !isNaN(n) ? Math.abs(n) : 2;
  o.dec = typeof dec != "string" ? "," : dec, o.dig = typeof dig != "string" ? "." : dig;
  addEvent(o, "keypress", function(e){
    if(e.key > 47 && e.key < 58){
      var o, s, l = (s = ((o = this).value.replace(/^0+/g, "") + String.fromCharCode(e.key)).replace(/\D/g, "")).length, n;
      if(o.maxLength + 1 && l >= o.maxLength) return false;
      l <= (n = o.c) && (s = new Array(n - l + 2).join("0") + s);
      for(var i = (l = (s = s.split("")).length) - n; (i -= 3) > 0; s[i - 1] += o.dig);
      n && n < l && (s[l - ++n] += o.dec);
      o.value = s.join("");
    }
    e.key > 30 && e.preventDefault();
  });
}
//]]>