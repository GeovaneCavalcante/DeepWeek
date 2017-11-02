<?php 

namespace App\Models\jogos;

class InscricaoJogos{

    private $connect;

    public function __construct(){
        $this->connect = new \Config\Connect();
    } 

    public function insertInscricao($dados){
       
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('d-m-Y');

        $sql = "
            INSERT INTO jogos 
            (
                jogo, nome_lider, cpf, telefone, email,
                pa1,  pa2, pa3,  pa4, pa5, pa6, status_pagamento,
                data_criacao, nome_equipe
            )
            VALUES 
            (
                '$dados[jogo]', '$dados[nome_lider]', '$dados[cpf]', '$dados[telefone]', 
                '$dados[email]', '$dados[pa1]', '$dados[pa2]',  '$dados[pa3]', '$dados[pa4]',
                '$dados[pa5]', ' $dados[pa6]', 'Não pago', '$date', '$dados[nome_equipe]'
            )
        ";
        
        if ($this->connect->getConnection()->query($sql) == true){
        
            
            return ["status" => 200, "resultado" => "Criado com sucesso"];;
        }else{
         
            $error = $this->connect->getConnection()->error;
            echo $error;
            die;
            return ["status" => 405, "resultado" => "Falha ao criar registro: $error"];;
        }
    }

    public function insertInscricaoAdmin($dados){
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('d-m-Y');
        
        if($dados['numero_transacao']==0){
            $dados['numero_transacao'] =  $dados['cpf'];
        }
        $sql = "
            INSERT INTO inscricaoevento 
            (
                nome, email, telefone, cpf, dados_institucionais, instituicao, 
                curso, data_criacao, tipo_inscricao, numero_transacao, status_pagamento, credenciado
            )
            VALUES 
            (
                '$dados[nome]', '$dados[email]', '$dados[telefone]', '$dados[cpf]', 
                '$dados[dados_institucionais]', '$dados[instituicao]', '$dados[curso]',
                '$date','$dados[tipo_inscricao]', '$dados[numero_transacao]', 
                '$dados[status_pagamento]', 'Não credenciado'
            )
        ";
        
        if ($this->connect->getConnection()->query($sql) == true){

            return ["status" => 200, "resultado" => "Criado com sucesso"];;
        }else{
           
            $error = $this->connect->getConnection()->error;
            return ["status" => 405, "resultado" => "Falha ao criar registro: $error"];;
        }
    }


    public function getInscricoes(){
        
        $sql = "SELECT * FROM jogos order by nome_lider asc
        ";
        $result = $this->connect->getConnection()->query($sql);

        if (!$result){
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }else{

            $i = 0;
            while ($dados = mysqli_fetch_assoc($result)){
                $array[$i] = $dados;
                $i++;
            }
        

            return ["status" => 200, "resultado" => $array];
        }
    }


    public function getInscricao($id){
        
        $sql = "select * from jogos where id = '$id'";
        $result = $this->connect->getConnection()->query($sql); 
        $resultado = mysqli_fetch_assoc($result);

        if($resultado){
         
            return ["status" => 200, "resultado" => $resultado];
        }else{
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }
    }


    public function updateInscricao($dados){
        
       
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('d-m-Y');
        if($dados['numero_transacao'] == ""){
            $dados['numero_transacao'] = $dados['cpf'];
        }
        $sql = "
        UPDATE `jogos` SET `jogo` = '$dados[jogo]', `nome_lider` = '$dados[nome_lider]', 
        `nome_equipe` = '$dados[nome_equipe]', `cpf` = '$dados[cpf]',
        `telefone` = '$dados[telefone]', 
        `email` = '$dados[email]', `pa1` = '$dados[pa1]', `pa2` = '$dados[pa2]', `pa3` = '$dados[pa3]',
        `pa4` = '$dados[pa4]', `pa5` = '$dados[pa5]', `pa6` = '$dados[pa6]', 
        `tipo_inscricao` = '$dados[tipo_inscricao]', `numero_transacao` = '$dados[numero_transacao]',
        `status_pagamento` = '$dados[status_pagamento]',   `data_criacao` = '$dados[data_criacao]',
        `data_modificacao` = '$date' WHERE `jogos`.`id` = '$dados[id]'; 
        ";
      
        if($this->connect->getConnection()->query($sql)==true){
        
        
            return ["status" => 200, "resultado" => "Atualizado com sucesso"];
        }else{
            
            $error = $this->connect->getConnection()->error;
           
            return ["status" => 405, "resultado" => "Falha ao atualizar registro:  $error "];
        }        
    }

    function deletaInscricao($cpf){
        $sql = "
            DELETE FROM jogos
            WHERE id='$cpf'
        ";
        if ($this->connect->getConnection()->query($sql) == true){
            return ["status" => 200, "resultado" => "Apagado com sucesso"];
        }else{
            $error = $this->connect->getConnection()->error;
            return ["status" => 405, "resultado" => "Resgistro não apagado: $error"];
        }
    }

}