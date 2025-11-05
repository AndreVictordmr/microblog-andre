'use strict';

/* Selecionar todos os links de excluir */

const links= document.querySelectorAll('.excluir');

for(const link of links){
    link.addEventListener('click',(event)=>{ 
        event.preventDefault();
        
        let resposta=confirm("Deseja Realmente excluir este registro?");
        //Verifica se e verdadeiro ou falso
        if(resposta){
            //Redireciona para o link quardado na lista
            location.href = link.href;
        }

        
    })
   
}