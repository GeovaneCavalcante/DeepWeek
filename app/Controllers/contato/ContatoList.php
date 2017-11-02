<?php
namespace App\Controllers\contato;

class ContatoList{

    private $modelContato;
    private $connect;


    public function __construct(){
        $this->modelContato = new \App\Models\contato\Contato();
        $this->connect = new \Config\Connect();
    }

    public function getContatos(){
        $trabalhos = $this->modelContato->getContatos();
        if($trabalhos['status'] == 200){
            return $trabalhos['resultado'];
        }
    }

    public function deletaContato($id){
        $trabalho = $this->modelContato->deletaContato($id);

        if ($trabalho['status'] == 200){
           
        }else{
        
        }
    }

   
}