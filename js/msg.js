$(function(){
  $('.slider').mobilyslider({
    content: '.sliderContent',
    children: 'div',
    transition: 'fade',
    animationSpeed: 500,
    autoplay: true,
    autoplaySpeed: 5000,
    pauseOnHover: false,
    bullets: true,
    arrows: false,
    arrowsHide: false,
    animationStart: function(){},
    animationComplete: function(){}
  });
  $(".termo").focus(function() { 
    if($(this).val()=='' || $(this).val()=='Buscar notícias...'){
      $('.termo').val('');
    }
  }).blur(function(){
    if($(this).val()==''){
      $('.termo').val('Buscar notícias...');
    }
  });  
  $("#topo .util ul li").mouseenter(function() { 
    $('.'+$(this).stop().attr('id')).fadeIn(250);
  }).mouseleave(function(){
    $('.'+$(this).stop().attr('id')).fadeOut(250);
  });
  $('#topo .util ul li').click(function(){
    var item = $(this).attr('id').split('sub')[1];
    if(item=='comunidades'){
      window.location.href = "./"+item;
    }
  });
});
function validacontato() {
    if( document.contatos.cnome.value == "" || document.contatos.cnome.value == "NOME") {
        erro('Informe o seu nome');
        document.contatos.cnome.focus();
        return false;
    }  
    if( document.contatos.cemail.value == "" || document.contatos.cemail.value == "EMAIL") {
        erro('Informe seu e-mail de contato');
        document.contatos.cemail.focus();
        return false;
    }   
    if( document.contatos.cemail.value.search(/^\w+((-\w+)|(\.\w+))*\@\w+((\.|-)\w+)*\.\w+$/) == -1) {
        erro('Informe um e-mail válido');
        document.contatos.cemail.focus();
        return false;
    }
    if( document.contatos.ctelefone.value == "" || document.contatos.ctelefone.value == "TELEFONE") {
        erro('Informe o seu nome');
        document.contatos.ctelefone.focus();
        return false;
    } 
    if( document.contatos.cassunto.value == "" || document.contatos.cassunto.value == "ASSUNTO") {
        erro('Informe o seu nome');
        document.contatos.cassunto.focus();
        return false;
    } 
    if( document.contatos.cmensagem.value == "" || document.contatos.cmensagem.value == "MENSAGEM") {
        erro('Informe o seu nome');
        document.contatos.cmensagem.focus();
        return false;
    } 
}
function validanews() {
   if( document.newsl.nomen.value == "" || document.newsl.nomen.value == "SEU NOME COMPLETO") {
        erro('Informe o seu nome');
        document.newsl.nomen.focus();
        return false;
    }  
    if( document.newsl.emailn.value == "" || document.newsl.emailn.value == "SEU E-MAIL DE CONTATO") {
        erro('Informe seu e-mail de contato');
        document.newsl.emailn.focus();
        return false;
    }   
    if( document.newsl.emailn.value.search(/^\w+((-\w+)|(\.\w+))*\@\w+((\.|-)\w+)*\.\w+$/) == -1) {
        erro('Informe um e-mail válido');
        document.newsl.emailn.focus();
        return false;
    }
    if($('span#problema_email').length > 0){
       erro('Informe outro e-mail');
       document.newsl.emailn.focus();
       return false;
    }
    var nome  = $('#nomen').val();
    var email = $('#emailn').val();
    $.ajax({
      url:'pg/config/addNews.php',
      type:'post',
      data:'email='+email+'&nome='+nome,
      success: function(data){
        if(data=='ok'){
          $("#nomen, #emailn").val('');
          $(".remail").html('');
          certo('Cadastro efetuado com sucesso');
        } else if(data=='erro'){
          erro('ERRO! Tente novamente');
        }
      }
    });
    return false;
}
function veCad(){
  if($("#email").val().search(/^\w+((-\w+)|(\.\w+))*\@\w+((\.|-)\w+)*\.\w+$/) == 0){
    var email = $('#email').val();
    $.ajax({
      url:'pg/config/vemailc.php',
      type:'post',
      data:'email='+email,
      success: function(data){
        $(".remailc").html(data);
      }
    });
    return false;
  } else {
    $(".remailc").html('');
  }
}
function certo(msg) {
$(document).ready(function() { 
  $.blockUI({ message: "<div id='msgalerta'><img src='img/ok.png' width='64' height='64' alt='Ok' /><div id='tmsg'>"+msg+"...</div></div>", css: { width: '100%', left: '-3px' } });  
  setTimeout($.unblockUI, 2000);
    }); 
}
function erro(msg) {
$(document).ready(function() { 
	$.blockUI({ message: "<div id='msgalerta'><img src='img/atencao.png' width='64' height='64' alt='Ok' /><div id='tmsg'>"+msg+"...</div></div>", css: { width: '100%', left: '-3px' } });  
	setTimeout($.unblockUI, 2000);
    }); 
}
function error(msg, volta) {
$(document).ready(function() { 
	$.blockUI({ message: "<div id='msgalerta'><img src='img/atencao.png' width='64' height='64' alt='Ok' /><div id='tmsg'>"+msg+"...</div></div>", css: { width: '100%', left: '-3px' } });  
	setTimeout($.unblockUI, 2000);
	setTimeout("location.href='"+volta+"'",2400);
    }); 
}
function ok(msg, volta) {
$(document).ready(function() { 
	$.blockUI({ message: "<div id='msgalerta'><img src='img/ok.png' width='64' height='64' alt='Ok' /><div id='tmsg'>"+msg+"...</div></div>", css: { width: '100%', left: '-3px' } });  
	setTimeout($.unblockUI, 2000);
	setTimeout("location.href='"+volta+"'",2400);
    }); 
}
function errora(msg, volta) {
$(document).ready(function() { 
	$.blockUI({ message: "<div id='msgalerta'><img src='../img/atencao.png' width='64' height='64' alt='Ok' /><div id='tmsg'>"+msg+"...</div></div>", css: { width: '100%', left: '-3px' } });  
	setTimeout($.unblockUI, 2000);
	setTimeout("location.href='"+volta+"'",2400);
    }); 
}
function oka(msg, volta) {
$(document).ready(function() { 
	$.blockUI({ message: "<div id='msgalerta'><img src='../img/ok.png' width='64' height='64' alt='Ok' /><div id='tmsg'>"+msg+"...</div></div>", css: { width: '100%', left: '-3px' } });  
	setTimeout($.unblockUI, 2000);
	setTimeout("location.href='"+volta+"'",2400);
    }); 
}
function confirmaDel(link){
	if(confirm("Tem certeza que deseja remover?")){
	location.href=''+link+'';
	}
}
function numz(dom){
	dom.value=dom.value.replace(/\D/g,'0');	
	if(dom.value == '') {
		dom.value = '0';
	}
}
function num(dom){
	dom.value=dom.value.replace(/\D/g,'');
}
function nump(dom){
	dom.value=dom.value.replace(/\D/g,'');
	if(dom.value>24){
		dom.value='24';
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
function vExisteEmail(){
  if($("#emailn").val().search(/^\w+((-\w+)|(\.\w+))*\@\w+((\.|-)\w+)*\.\w+$/) == 0){
    var email = $('#emailn').val();
    $.ajax({
      url:'pg/config/vemail.php',
      type:'post',
      data:'email='+email,
      success: function(data){
        $(".remail").html(data);
      }
    });
    return false;
  } else {
    $(".remail").html('');
  }
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