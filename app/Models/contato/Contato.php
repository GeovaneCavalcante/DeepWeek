<?php 

namespace App\Models\Contato;

class Contato{

    private $connect;

    public function __construct(){
        $this->connect = new \Config\Connect();
    } 

    public function insertContato($dados){
    
        $sql = "
              INSERT INTO `contato` 
              (
                  `id`, `nome`, `email`, `menssagem`
              ) 
              VALUES 
              (NULL, '$dados[nome]', '$dados[email]', '$dados[menssagem]')
        ";
        
        if ($this->connect->getConnection()->query($sql) == true){
       
            return ["status" => 200, "resultado" => "Criado com sucesso"];;
        }else{
            
            $error = $this->connect->getConnection()->error;
            return ["status" => 405, "resultado" => "Falha ao criar registro: $error"];;
        }
    }

   
    public function getContatos(){
        
        $sql = "SELECT * FROM contato order by nome asc
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


    public function getMedico($crm){
        
        $sql = "select * from medicos where crm = $crm";
        $result = $this->connect->getConnection()->query($sql); 
        $resultado = mysqli_fetch_assoc($result);

        if($resultado){
            
            $sql2 = "SELECT * FROM especialidades_med WHERE crm_medico = '$resultado[crm]'";
            $result2 = $this->connect->getConnection()->query($sql2);
            $j = 0;
            $array2 = [];
            while ($dados2 = mysqli_fetch_assoc($result2)){
                $array2[$j] = $dados2;
                $j++;
            }

            if($array2){
               $resultado['esp'] =  $array2;
            }else{
               $resultado['esp'] = "Nada encontrado";
            }

            return ["status" => 200, "resultado" => $resultado];
        }else{
            return ["status" => 404, "resultado" => "Nada encontrado"];
        }
    }


    function deletaContato($id){
        $sql = "
            DELETE FROM contato
            WHERE id='$id'
        ";
        if ($this->connect->getConnection()->query($sql) == true){
           
            return ["status" => 200, "resultado" => "Apagado com sucesso"];
        }else{
           
            $error = $this->connect->getConnection()->error;
            return ["status" => 405, "resultado" => "Resgistro não apagado: $error"];
        }
    }

}