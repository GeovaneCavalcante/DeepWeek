<?php
namespace App\Routes\jogos;

class InscricaoJogos{

    public function __construct($Klein, $Twig){
        $this->klein = $Klein;
        $this->twig =  $Twig;
    }
    
    public function start(){
      
        $this->klein->respond('GET', '/inscricao/jogos', function ($request, $response, $service) {   
                echo $this->twig->getTwig()->render('jogos\inscricao.html', array(
                    "user" => $_SESSION,
            
                ));  
        });  
        
        $this->klein->respond('POST', '/inscricao/jogos', function ($request, $response, $service) {   

            $con = new \App\Controllers\jogos\InscricaoJogos($_POST);

            if($con->Validacao() or $con->verificar()){
                
                if($_POST['jogo'] == "Pro Evolution Soccer"){
                    echo $this->twig->getTwig()->render('jogos\InscricaoPesPost.html', array(
                        "erros" => $con->Validacao(),
                        "verificada" => $con->verificar(),
                        "dados" => $_POST
                    ));
                }else{
                    echo $this->twig->getTwig()->render('jogos\InscricaoEquipePost.html', array(
                        "erros" => $con->Validacao(),
                        "verificada" => $con->verificar(),
                        "dados" => $_POST
                    ));
                }

            }else{

                if ($con->insertInscricao() == 200){
                    $response->redirect('/confirmacao/jogos');
                }else{
                   
                }

            }
        });  

        $this->klein->respond('GET', '/admin/inscricoes/jogos', function ($request, $response, $service) {
            
            if ($_SESSION['status'] == true){
                $n = new \App\Controllers\jogos\InscricaoList();
                echo $this->twig->getTwig()->render('/jogos/list.html', array(
                    "user" => $_SESSION,
                    "inscricoes" => $n->getInscricao()
                ));
            }else{
                $response->redirect('/login');
            }
            
        });

        

        $this->klein->respond('GET', '/admin/inscricoes/jogos/apaga', function ($request, $response, $service) {

            if ($_SESSION['status'] == true){
                if($_GET['dados']){
                    $n = new \App\Controllers\inscricao\InscricaoList();
                    $n->deletaInscricao($_GET['dados']);
                    $response->redirect('/admin/inscricoes');
                }else{
                    $response->redirect('/admin/inscricoes');
                }
            }else{
                $response->redirect('/login');
            }
        });


        $this->klein->respond('GET', '/admin/inscricoes/jogos/editar', function ($request, $response, $service) {
            if ($_SESSION['status'] == true){
                if($_GET['dados']){
                
                    $n = new \App\Controllers\jogos\InscricaoList();

                    if ($n->getInscricaoP($_GET['dados'])["status"] == 404){
                        echo $this->twig->getTwig()->render('core\error.html');
                    }else{
                       
                        echo $this->twig->getTwig()->render('jogos\editar.html', array(
                            "user" => $_SESSION,
                            "inscricao" =>$n->getInscricaoP($_GET['dados'])["resultado"]
                        ));
                    }
                }else{
                    $response->redirect('/admin/inscricoes');
                }
            }else{
                $response->redirect('/login');
            }
        });

              
        $this->klein->respond('POST', '/admin/inscricoes/jogos/editar', function ($request, $response, $service) {
           
            $con = new \App\Controllers\jogos\InscricaoJogos($_POST);
            if($con->Validacao()){
                echo $this->twig->getTwig()->render('jogos\editar.html', array(
                    "user" => $_SESSION,
                    "erros" => $con->Validacao(),
                    "inscricao" => $_POST
                ));

            }else{

                if ($con->updateInscricao() == 200){
                    $response->redirect('/admin/inscricoes/jogos');
                }else{
                   
                }

            }
            
        });

        $this->klein->respond('GET', '/confirmacao/jogos', function ($request, $response, $service) {   
            echo $this->twig->getTwig()->render('jogos\confirmacao.html', array(
                "user" => $_SESSION,
        
            ));  
        });  
            
        
    }
}