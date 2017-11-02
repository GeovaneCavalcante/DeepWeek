<?php
namespace App\Routes\contato;

class Contato{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }
    
    public function start(){

        $this->klein->respond('GET', '/contato', function ($request, $response, $service) {   
                echo $this->twig->getTwig()->render('contato\contato.html', array(
                    "user" => $_SESSION,
                ));  
        });  
        
        $this->klein->respond('POST', '/contato', function ($request, $response, $service) {   
            $con = new \App\Controllers\contato\Contato($_POST);
            if($con->Validacao()){
                $endereco = new \App\Controllers\core\Endereco();
                $esp = new \App\Controllers\core\Especialidades();
                echo $this->twig->getTwig()->render('contato\contato.html', array(
                    "erros" => $con->Validacao(),      
                    "dados" => $_POST
                ));

            }else{

                if ($con->insertContato($_POST) == 200){
                    $response->redirect('/contato');
                }else{
                    $response->redirect('/');
                }

            }
        });  

        $this->klein->respond('GET', '/admin/contatos', function ($request, $response, $service) {   
            if ($_SESSION['status'] == true){
                
                $n = new \App\Controllers\contato\ContatoList();
                echo $this->twig->getTwig()->render('/contato/contatoList.html', array(
                    "user" => $_SESSION,
                    "contatos" => $n->getContatos()
                ));
            }else{
                $response->redirect('/login');
            }
        });  

        $this->klein->respond('GET', '/admin/contatos/apaga', function ($request, $response, $service) {
            
            if ($_SESSION['status'] == true){
                if($_GET['dados']){
                    $n = new \App\Controllers\contato\ContatoList();
                    $n->deletaContato($_GET['dados']);
                    $response->redirect('/admin/contatos');
                }else{
                    $response->redirect('/admin/contatos');
                }
            }else{
                $response->redirect('/login');
            }
        });

      
    }
}