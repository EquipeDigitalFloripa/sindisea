<?php
    if (isset($_SESSION['id_associado']) && $_SESSION['id_associado'] > 0) {
        $a_mais = '<a href="/area-restrita"><li>Área Restrita</li></a>
            <a href="/alterar-dados"><li>Alterar Dados</li></a>
            <a href="/alterar-senha"><li>Alterar Senha</li></a>
            <li id="sair">Sair</li></a>
';
    }else{
        $a_mais = '<li id="btn_area_restrita">Área Restrita</li>';
    }
?>


<ul class="menu">
    <a href="/inicio"><li>Página inicial</li></a>
    <a href="/o-sindiasea"><li>O Sindisea</li></a>
    <a href="/noticias"><li>Notícias</li></a>
    <a href="/convenios"><li>Convênios</li></a>
    
    <a href="/assessoria-juridica"><li>Assessoria Jurídica</li></a>
    <a href="/filie-se"><li>Filie-se</li></a>
    <a href="/contatos"><li>Fale conosco</li></a>
    <?php echo $a_mais ?>
</ul>