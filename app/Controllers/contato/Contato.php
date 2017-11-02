<?php
namespace App\Controllers\contato;

class Contato{

    private $post;
    private $modelContato;
    private $connect;

    public function __construct($post){
        
        $this->post = $post;
        $this->modelContato = new \App\Models\contato\Contato();
        $this->connect = new \Config\Connect();
      
    }

    public function Validacao(){

        $v = new \Valitron\Validator($this->post);

        $v->rule('required', array(
            'nome', 'menssagem', 'email'
        ))->message('{field} é obrigatório');

        if($v->validate()) {
            return $v->errors();
        } else {
            return $v->errors();
        }
    }
   
    public function insertContato($dados){
        $model = $this->modelContato->insertContato($dados);
    
        if ($model['status'] == 200){
            return 200;
        }
    }

   
}