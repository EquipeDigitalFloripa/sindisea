
<script type="text/javascript">
    window.onload = function () {
        $("#popup").fadeIn(450);
    };
    var fechar = function () {
        $("#popup").css({display: 'none'});
    };

/////////// LINK QUANDO CLICAR NA IMAGEM ////////
</script>
<style>    
    #popup{

        width: 100vw;
        height: 100vh;
        position: fixed;
        z-index: 9999999999;
        display: block;
        background: rgba(0,0,0,0.8);
		overflow-x: hidden;
    }

    #div{
        position: relative;        
        top: 5%;        
        width: 600px;
        margin: 0 auto;  
        background: white;
        padding: 10px 50px 30px 50px;
        border: 1px solid black;
		text-align: center;
        font-family: 'Lato_Bold';
    }

    @media (max-width: 1024px) 
    {   #div{
            width: 90%;
            padding: 10px 20px 30px 20px;
        }
    }

    #close-div{
        width: 45px;
        height: 45px;                
        position: absolute;
        top: 20px;
        right: 20px;
        background: url('../imagens/fechar.png') center / contain no-repeat;
        cursor: pointer;
        z-index: 99999;
    } 

    h1{
        text-align: center;
        font-size: 30px;
    }

    .botao{
        text-transform: uppercase;
        color: black;
        text-decoration: none;
        font-size: 40px;
    }


</style>
<div id="popup" >
    
    <div id="div">
	<div id="close-div" onclick="fechar()"></div>
	<h1>ELEIÇÕES 2020</h1>
        <a href="/eleicao" class="botao">CLIQUE AQUI PARA VOTAR!</a>
</div>

</div>

