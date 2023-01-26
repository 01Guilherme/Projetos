<?php
// error_reporting(0);
// ini_set('display_errors', 0 );

// error_reporting(E_WARNING);
// ini_set('display_errors', 0 );

// error_reporting(E_ALL ^ E_WARNING);
// ini_set('display_errors', 1 );

 /*
 error_reporting(E_ALL);
 ini_set(“display_errors”, 1 );
 */

 error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
 ini_set('display_errors', 0 );

// carrega o autoload
require "./lib/autoload.php";

if(!isset($_SESSION)):
session_start();
endif;

if(isset($_SESSION['USR'])):
  $empresa = $_SESSION['USR']['NOME'];
else:
  $empresa = '';
endif;


// Chama a Classe do Template
$smarty = new Template();

if(isset($_POST['log-off'])) { 
   $login = new Tabelas();   
   $login->LogOff();   
}


$smarty->assign('GET_TEMA', Rotas::get_SiteTEMA());
$smarty->assign('SITE_NOME', Config::SITE_NOME);

$smarty->assign('PAG_MYPAGE', Rotas::pag_Mypage());

$smarty->assign('LOGADO', Tabelas::Logado());
$smarty->assign('PAG_LOGOFF', Rotas::pag_Logoff());

$smarty->assign('USR',isset($_SESSION['USR']['NOME']) ? $_SESSION['USR']['NOME'] :'Off');
if(Tabelas::Logado()):
// $smarty->assign('MESA',isset($_SESSION['USR']['MESA']) ? 'MESA: #'.$_SESSION['USR']['MESA'] :'SELECIONE UMA MESA');
//$smarty->assign('MESA',isset($_SESSION['USR']['MESA']) ? 'MESA: #'.$_SESSION['USR']['MESA'] :'CARDÁPIO ELETRONICO');
$smarty->assign('MESA','CARDÁPIO DIGITAL');
$smarty->assign('ENTRAR','Entrar');
else:
$smarty->assign('MESA','Bem vindo');
// Tabelas::Logoff();    fica em loop
unset($_SESSION['USR']);
unset($_SESSION['USR']['MESA']);
$smarty->assign('ENTRAR','[Entrar]');
endif;

//$hora_atual = Rotas::dh_atual();
//$smarty->assign('MESA',Rotas::dh_atual());
// if(isset($_SESSION['USR']['MESA'])):
//   $smarty->assign('MESA','MESA: ' . $_SESSION['USR']['MESA']);
// else: 
//   $smarty->assign('MESA','SELECIONE UMA MESA');
// endif;

$smarty->display("index.tpl");

/*
 Acesso rapido:
 Ultimo produto: dados da mesa;
 Ultima mesa   : mostrar ultimos itens;
 Ultima observacao : mostrar produto e mesa
 Ultima mesa atendido e finalizada
 
 * aula 034 02-11-2022
 * aula 100 29-10-2017 23:55 Login / Logoff de cliente (08:00 clica para entrar e nao entra)
 * aula 075 26-10-2017 20:09 Carinho Imagens pequenas dos itens
 * aula 071 24-10-2017 21:31 Classe Carrinho de produtos
 * aula 066 24-10-2017 17:18 Recaptulacao dos passos de paginacao
   aula 064 23-10-2017 03:06 Paginacao com erro 
 * aula 038 21-10-2017 11:00 Mostrando dados de um produto (produtos_info)
   aula 036 21-10-2017 03:07 Rotas para imagens e Trabalhar Tamanho da imagem
   aula 031 20-10-2017 20:43 Classe de Conexao
   aula 007 15-10-2017 03:04
   aula 025 15-10-2017   
   http://contratebem-brasil.tempsite.ws/loja
 */

/**  <script src="{$GET_TEMA}/tema/js/javascript.js"></script>   */
?>

<script>


$(function(){
    // Pesquisar os dados sem refresh na página
    $("#pesquisa").keyup(function(){
        var pesquisa = $(this).val();
        // Verificar se ha algo digitado
        if (pesquisa != ''){
            var dados = {
                
                palavra : pesquisa
            }
            $.post('',dados,function(retorna){
                // Mostra dentro da ul os resultados obtidos
                $(".resultado").html(retorna);
            });
            
        }else{
            $(".resultado").html('');
        }
    });
});

/*
window.onload=function(){
  let executaBotao = document.getElementById("GFG_click");
  executaBotao.onclick = function(x) {
    GFG_click1(x)
  }
}
*/

function quantideProcessa(acao,campo){
  //qtde = document.getElementById('add-item-qtde').value;
  if (campo == 'quantidade1'){
    qtde = parseInt(document.querySelector('#quantidade1').value);
  } else {
    qtde = parseInt(document.querySelector('#add-item-quantidade1').value);
  }
  //alert('Acao ' + acao + 'Qtde ' + qtde);
  //var $qtde = document.getElementsByClassName("add-item-qtde");
  if (acao == '+'){
     qtde = qtde + 1;
  } 
  else if (qtde > 1) {
     qtde = qtde - 1;
  }
  //alert('Acao ' + acao + ' Resultado ' + qtde);

  if (campo == 'quantidade1'){
    document.querySelector('#quantidade1').value = qtde;  
  } else {
  document.querySelector('#add-item-quantidade1').value = qtde;
  }
}  


 // function transferecampospedido(clicked,xxdesc,xxqtde,xxobservacao){
    function transferecampospedido(wdtaemissao1,wusuario1,wempresa1,wclifor1,wcodigo1,wdescricao1,wquantidade1,wpreco1,wobservacao1){
     
      // alert('LH = 152 -> ' + wdtaemissao1 + ' Empresa= ' + wdtaemissao1);

       document.getElementById('add-item-usuario1').value = wusuario1; // ok
       document.getElementById('add-item-empresa1').value = wempresa1; // ok
       document.getElementById('add-item-dtaemissao1').value = wdtaemissao1; // ok
      // alert('LH = 152 -> ' + wpedido1 + ' Empresa= ' + wdtaemissao1);
    //   document.getElementById('add-item-pedido1').value = wpedido1; // ok
       
  //     document.getElementById('add-item-sequencia1').value = wsequencia1; // ok
       document.getElementById('add-item-clifor1').value = wclifor1; // ok
       document.getElementById('add-item-codigo1').value = wcodigo1; // ok

       document.querySelector('#add-item-descricao1').textContent = wdescricao1;  // ok
       document.getElementById('add-item-descricao2').value = wdescricao1;  // ok
      // document.querySelector('#descricao1').textContent = wdescricao1;
      
       
       document.getElementById("add-item-quantidade1").value = wquantidade1;  // ok
       document.getElementById("add-item-preco1").value = wpreco1; // ok
       
       document.getElementById("add-item-observacao1").value = wobservacao1; // ok 
   

    }
    /* id nome de campo nao se repetir em todo o projeto, usar os prefixos dos arquivos */
    function transferecampos(clicked){
       
       // alert('Pedido: 160 -> ' + clicked); 
        var preco  = document.getElementsByClassName("preco");
        document.getElementById("preco1").value = preco[clicked].innerText;
        document.getElementById("observacao1").value ='';
        //alert('Cod Preco ---> ' + preco[clicked].innerText);

        var descricao = document.getElementsByClassName("descricao");
        // var $desc1 = descricao[clicked].innerText;
        document.getElementById("descricao1").value = descricao[clicked].innerText;
        
        document.querySelector('#titulo-item-descricao').textContent = descricao[clicked].innerText;

       // document.getElementById("descricao2").value = descricao[clicked].innerText;
        //alert('transferecampos -> Descricao ' + descricao[clicked].innerText);
      
        var usuario = document.getElementsByClassName("usuario");
        // var $empr1 = empresa[clicked].innerText;
        document.getElementById("usuario1").value = usuario[clicked].innerText;
       
        var empresa = document.getElementsByClassName("empresa");
        // var $empr1 = empresa[clicked].innerText;
        document.getElementById("empresa1").value = empresa[clicked].innerText;

        // var empresa = document.getElementsByClassName("dtaemissao");
        // document.getElementById("dtaemissao1").value = dtaemissao[clicked].innerText;

        document.getElementById("pedido1").value = 0;
        document.getElementById("sequencia1").value = '0';
//        alert('Pedido ' + pedido[clicked].innerText);

        var clifor  = document.getElementsByClassName("clifor");     
        document.getElementById("clifor1").value = clifor[clicked].innerText;
  
        var codigo  = document.getElementsByClassName("codigo");
        document.getElementById("codigo1").value = codigo[clicked].innerText;
   
        // document.getElementById("codigopassado").value = codigo[clicked].innerText;

        // var quantidade  = document.getElementsByClassName("quantidade");
        document.getElementById("quantidade1").value = 1;

        window.scrollTo({ top: 0, behavior: 'smooth' });

    }


    function acao(wCodigo,wDescricao,wjanela,wclifor,wempresa){
     /* alert("Codigo:" + wCodigo + " Descricao: " + wDescricao);  */
      if(wclifor == 0){
        alert('Selecione uma mesa, por favor!!!');
        exit;
      }
      if(wempresa == 0){
        alert('Selecione sua cessão foi finalizada, entre novamente por favor!!!');
        exit;
      }
      const modal = document.getElementById(wjanela);
      
      modal.classList.add('modal-abrir');  
     
      modal.addEventListener('click', (e)  => {
        if(e.target.id == 'modal-fechar' || e.target.id == wjanela){
          // alert('Janela: ' + wjanela);
          modal.classList.remove('modal-abrir');
        }
      })
    }

    /*  Chamado pelo add_produtos_item.tpl 
    function modal-gbo-janela-abrir(){
      alert("Codigo:");
      */
     /* const modal-gbo = document.getElementById('modal-gbo-janela') */
     /* modal-gbo.classList.add('modal-abrir') 
    };
    */


    function carregapagina(pagina){
      $("#conteudopagina").load(pagina);
    }

    function GFG_click(acao,wusuario1,wempresa1,wdtaemissao1,wpedido1,wsequencia1,wclifor1,wcodigo1,wdescricao1,wquantidade1,wpreco1,wobservacao1) 
    {      
      
      var var_usuario   = document.getElementById(wusuario1);
      var var_empresa   = document.getElementById(wempresa1);
      var var_pedido    = document.getElementById(wpedido1);
      var var_sequencia = document.getElementById(wsequencia1);    
      var var_dtaemissao= document.getElementById(wdtaemissao1);
      var var_clifor    = document.getElementById(wclifor1);
      var var_codigo    = document.getElementById(wcodigo1);
      var var_descricao = document.getElementById(wdescricao1);
      var var_quantidade= document.getElementById(wquantidade1);
      var var_preco     = document.getElementById(wpreco1);
      var var_observavao= document.getElementById(wobservacao1);
      
      // if(wdescricao1 == 'add-item-descricao2'){
      //   alert('Debugando -> ' + wdescricao1 + ' ====> ' + var_descricao.value);
      //   xxx = document.querySelector('#add-item-descricao2').value;
      //   alert('Debugando -> ' + wdescricao1 + '  conteudo ' + xxx);
      // }
              
      var $dtae = var_dtaemissao.value;
      //alert('Acao -> ' + acao + ' wdtaemissao1 --> ' + wdtaemissao1 + ' Valor: ' + $dtae);
      var $usua = var_usuario.value;
      var $empr = var_empresa.value;
      var $pedi = var_pedido.value;
      var $sequ = var_sequencia.value;
      var $clif = var_clifor.value;
      var $codi = var_codigo.value;
      var $desc = var_descricao.value;
      var $qtde = var_quantidade.value;
     // alert('GFG_click 255 Acao >' + acao + '  > Descricao > ' + wobservacao1 + ' = ' +var_observavao.value);
      var $prec = var_preco.value;
      var $obse = var_observavao.value;
    //  alert('GFG_click 264 Acao >' + acao + '  > Descricao: ' + $desc+ ' Pedido: '+$pedi);
      
    //  alert('GFG_click 260 Acao >' + acao + '  > Empresa > ' + wempresa1 + ' = '+$empr);
    //  alert('256 267 Acao -> ' + acao + ' wpedido1 -> ' + $pedi);
      add_itens1(acao,$usua,$empr,$pedi,$sequ,$clif,$codi,$desc,$qtde,$prec,$obse,$dtae);  
    }  

    function add_itens1(acao,a,b,c,d,e,f,g,h,i,j,k) 
    {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        var elemResult = document.getElementById("divRes");
        var site_pasta = "<?php echo Config::SITE_PASTA;?>";
        var url1 = "<?php echo Rotas::pag_AddItem() .'.php';?>";
       // alert('add_itens1 -> Acao: ' + acao + ' Obs: ' + i + ' Emp: '+ a + ' Pedido: '+b + ' Sequencia: '+c + ' Clif: '+ d + ' Codi: '+ e + ' Desc: '+ f + ' Qtde: '+ g + ' Prec: '+ h + ' Pasta: '+site_pasta+' Url= '+url1);
        $.ajax({
            url: url1,
          //url: 'http://10.0.0.4:8090/gb44/controller/add_produto_item.php',
            type: 'POST',
            data: {
                'acao':acao,
                'usuario':a,
                'empresa':b,
                'pedido':c,
                'sequencia':d,
                'clifor':e,
                'codigo':f,
                'descricao':g,
                'quantidade':h,
                'preco':i,
                'observacao':j,
                'dtaemissao':k,
                'site_pasta': site_pasta,
                },
            contentType: "application/x-www-form-urlencoded;charset=UTF-8",
            success: function(data){
              // elemResult.innerText = data;
              
              elemResult.innerHTML = data;
            },
            error: function(request,error){
                alert("Resultado Erro: "+JSON.stringify(request));
            }
        });
    }
   
$(document).ready(function()
{			
    setTimeout(function() {
	$(".alert").fadeOut("slow", function(){
		$(this).alert('close');
	});				
    }, 5000);	

});



</script>

