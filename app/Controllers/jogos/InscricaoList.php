<?php

namespace App\Controllers\jogos;

class InscricaoList{

    private $post;
    private $inscricao;
    private $connect;

    public function __construct(){
        $this->modeljogo = new \App\Models\jogos\InscricaoJogos();
        $this->connect = new \Config\Connect();
    }

    public function getInscricao(){
        
        $inscricao = $this->modeljogo->getInscricoes();

        if ($inscricao['status'] == 200){
            return $inscricao['resultado'];
        }else{
           
        }
    }

    public function getInscricaoP($dados){
        
        $inscricao = $this->modeljogo->getInscricao($dados);
       
        if ($inscricao['status'] == 200){
           
            return $inscricao;
        }else{
           
        }
    }

    public function deletaInscricao($cpf){
        $inscricao = $this->inscricao->deletaInscricao($cpf);

        if ($inscricao['status'] == 200){
         
        }else{
         
        }
    }
}