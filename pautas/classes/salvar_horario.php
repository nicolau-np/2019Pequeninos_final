<?php
class salvar_horario{
    private $sql;
    private $stmt;
    private $con;
    private $resposta;
    private $hora_e;
    private $hora_s;
    private $semana;
    private $id_curso;
    private $id_classe;
    private $id_turma;
    private $id_turno;
    private $ano;
    private $id_disciplina;
    private $exibe;
    private $id_professor;
    private $sala;
    private $codigo;
    private $view;
    
    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

        
    function getSala() {
        return $this->sala;
    }

    function setSala($sala) {
        $this->sala = $sala;
    }

    function getId_professor() {
        return $this->id_professor;
    }

    function setId_professor($id_professor) {
        $this->id_professor = $id_professor;
    }

        
    function getId_disciplina() {
        return $this->id_disciplina;
    }

    function setId_disciplina($id_disciplina) {
        $this->id_disciplina = $id_disciplina;
    }

        function getHora_e() {
        return $this->hora_e;
    }

    function getHora_s() {
        return $this->hora_s;
    }

    function getSemana() {
        return $this->semana;
    }

    function getId_curso() {
        return $this->id_curso;
    }

    function getId_classe() {
        return $this->id_classe;
    }

    function getId_turma() {
        return $this->id_turma;
    }

    function getId_turno() {
        return $this->id_turno;
    }

    function getAno() {
        return $this->ano;
    }

    function setHora_e($hora_e) {
        $this->hora_e = $hora_e;
    }

    function setHora_s($hora_s) {
        $this->hora_s = $hora_s;
    }

    function setSemana($semana) {
        $this->semana = $semana;
    }

    function setId_curso($id_curso) {
        $this->id_curso = $id_curso;
    }

    function setId_classe($id_classe) {
        $this->id_classe = $id_classe;
    }

    function setId_turma($id_turma) {
        $this->id_turma = $id_turma;
    }

    function setId_turno($id_turno) {
        $this->id_turno = $id_turno;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }

        
    function getCon() {
        return $this->con;
    }

    function setCon($con) {
        $this->con = $con;
    }

    function __construct() {
        $this->exibe = "";
    }

public function verificaHorario() {
        $this->resposta = null;
        $this->sql = "select *from tbl_horario where semana=:semana and hora_e=:hora_e "
                . "and hora_s=:hora_s and id_curso=:id_curso and id_classe=:id_classe "
                . "and id_turma=:id_turma and id_turno=:id_turno and anolectivo=:ano";
        try {
            $this->stmt = $this->getCon()->prepare($this->sql);
             $this->stmt->bindParam(":semana",  $this->getSemana(),PDO::PARAM_STR);
             $this->stmt->bindParam(":hora_e",  $this->getHora_e(),PDO::PARAM_STR);
             $this->stmt->bindParam(":hora_s",  $this->getHora_s(),PDO::PARAM_STR);
             $this->stmt->bindParam(":id_curso",  $this->getId_curso(),PDO::PARAM_STR);
             $this->stmt->bindParam(":id_classe",  $this->getId_classe(),PDO::PARAM_STR);
             $this->stmt->bindParam(":id_turma",  $this->getId_turma(),PDO::PARAM_STR);
             $this->stmt->bindParam(":id_turno",  $this->getId_turno(),PDO::PARAM_STR);
             $this->stmt->bindParam(":ano",  $this->getAno(),PDO::PARAM_STR);
             $this->stmt->execute();
             if($this->stmt && $this->stmt->rowCount()>0):
             $this->resposta = "no";
             elseif($this->stmt && $this->stmt->rowCount()<=0):
             $this->resposta = "yes";
             endif;
        } catch (PDOException $ex) {
            echo ''.$ex;   
        }
        return $this->resposta;   
    }
    
    public function verDisponibilidadeProf(){
        $this->resposta = null;
        $this->sql = "select *from tbl_horario where semana = :semana and id_professor = :id_professor "
                . "and anolectivo = :anolectivo and hora_e = :hora_e and hora_s = :hora_s";
        try{
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":semana", $this->getSemana(), PDO::PARAM_STR);
            $this->stmt->bindParam(":id_professor", $this->getId_professor(), PDO::PARAM_STR);
            $this->stmt->bindParam(":anolectivo", $this->getAno(), PDO::PARAM_STR);
            $this->stmt->bindParam(":hora_e", $this->getHora_e(), PDO::PARAM_STR);
            $this->stmt->bindParam(":hora_s", $this->getHora_s(), PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt && $this->stmt->rowCount()>0):
            $this->resposta = "no";
            elseif($this->stmt && $this->stmt->rowCount()<=0):
            $this->resposta = "yes";
            endif;
                    
        } catch (PDOException $ex) {
            echo ''.$ex;
        }        
        return $this->resposta;
    }
    
    public function verDisponibilidadeSala(){
        $this->resposta = null;
        $this->sql = "select *from tbl_horario where sala = :sala and anolectivo = :anolectivo "
                . "and hora_e = :hora_e and hora_s = :hora_s and semana = :semana";
        try{
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":sala", $this->getSala(), PDO::PARAM_STR);
            $this->stmt->bindParam(":anolectivo", $this->getAno(), PDO::PARAM_STR);
            $this->stmt->bindParam(":hora_e", $this->getHora_e(), PDO::PARAM_STR);
            $this->stmt->bindParam(":hora_s", $this->getHora_s(), PDO::PARAM_STR);
            $this->stmt->bindParam(":semana", $this->getSemana(), PDO::PARAM_STR);
            $this->stmt->execute();
            if($this->stmt && $this->stmt->rowCount()>0):
            $this->resposta = "no";
            elseif($this->stmt && $this->stmt->rowCount()<=0):
            $this->resposta = "yes";
            endif;
        } catch (PDOException $ex) {
            echo ''.$ex;
        }        
        return $this->resposta;
    }
    
    public function verProfVSdisciplinas(){
        $this->resposta = null;
        $this->sql = "select *from tbl_horario where id_di2 = :id_disciplina "
                . "and anolectivo = :ano and id_curso = :id_curso and id_classe = :id_classe "
                . "and id_turma = :id_turma and id_turno = :id_turno";
        try {
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":id_disciplina", $this->getId_disciplina(), PDO::PARAM_STR);
            $this->stmt->bindParam(":ano", $this->getAno(), PDO::PARAM_STR);
            $this->stmt->bindParam(":id_curso", $this->getId_curso(), PDO::PARAM_STR);
            $this->stmt->bindParam(":id_classe", $this->getId_classe(), PDO::PARAM_STR);
            $this->stmt->bindParam(":id_turma", $this->getId_turma(), PDO::PARAM_STR);
            $this->stmt->bindParam(":id_turno", $this->getId_turno(), PDO::PARAM_STR);
            $this->stmt->execute();
            $this->view = $this->stmt->fetch(PDO::FETCH_OBJ);
            if($this->stmt && $this->stmt->rowCount()>0):
                if($this->view->id_professor != $this->getId_professor()):
                $this->resposta = "no";
                elseif($this->view->id_professor == $this->getId_professor()):
                $this->resposta = "yes";   
                endif;
           elseif($this->stmt && $this->stmt->rowCount()<=0):
           $this->resposta = "yes";
            endif;
        } catch (PDOException $ex) {
            echo ''.$ex;
        }
        return $this->resposta;
    }
    
    public function Exibicao(){
        $this->resposta = null;
        $this->sql = "select *from tbl_horario where id_di2=:disciplina and id_curso=:id_curso "
                . "and id_classe=:id_classe and id_turma=:id_turma and id_turno=:id_turno "
                . "and anolectivo=:ano";
        try {
            $this->stmt = $this->getCon()->prepare($this->sql);
            $this->stmt->bindParam(":disciplina",  $this->getId_disciplina(),PDO::PARAM_STR);
             $this->stmt->bindParam(":id_curso",  $this->getId_curso(),PDO::PARAM_STR);
             $this->stmt->bindParam(":id_classe",  $this->getId_classe(),PDO::PARAM_STR);
             $this->stmt->bindParam(":id_turma",  $this->getId_turma(),PDO::PARAM_STR);
             $this->stmt->bindParam(":id_turno",  $this->getId_turno(),PDO::PARAM_STR);
             $this->stmt->bindParam(":ano",  $this->getAno(),PDO::PARAM_STR);
             $this->stmt->execute();
             if($this->stmt && $this->stmt->rowCount()>0):
             $this->resposta = "yes";
             $this->exibe = "";
             elseif($this->stmt && $this->stmt->rowCount()<=0):
             $this->resposta = "yes";
             $this->exibe = "sim";
             endif;
             
        } catch (PDOException $ex) {
            echo ''.$ex;   
        }
        return $this->resposta;
    }
    
    public function salva(){
        $this->resposta = null;
     $this->sql="insert into tbl_horario(id_professor,id_di2,id_curso,id_classe,"
             . "id_turma,id_turno,sala,hora_e,hora_s,semana,codigo,anolectivo,exibe)"
             . "values(:id_professor,:id_di2,:id_curso,:id_classe,:id_turma,"
             . ":id_turno,:sala,:hora_e,:hora_s,:semana,:codigo,:anolectivo,:exibe)";   
    try{
        $this->stmt = $this->getCon()->prepare($this->sql);
         $this->stmt->bindParam(":id_professor",  $this->getId_professor(),PDO::PARAM_STR);
    $this->stmt->bindParam(":id_di2",  $this->getId_disciplina(),PDO::PARAM_STR);
     $this->stmt->bindParam(":id_curso",  $this->getId_curso(),PDO::PARAM_STR);
     $this->stmt->bindParam(":id_classe",  $this->getId_classe(),PDO::PARAM_STR);
     $this->stmt->bindParam(":id_turma",  $this->getId_turma(),PDO::PARAM_STR);
     $this->stmt->bindParam(":id_turno",  $this->getId_turno(),PDO::PARAM_STR);
      $this->stmt->bindParam(":sala",  $this->getSala(),PDO::PARAM_STR);
     $this->stmt->bindParam(":hora_e",  $this->getHora_e(),PDO::PARAM_STR);
     $this->stmt->bindParam(":hora_s",  $this->getHora_s(),PDO::PARAM_STR);
	 $this->stmt->bindParam(":semana",  $this->getSemana(),PDO::PARAM_STR);
	 $this->stmt->bindParam(":codigo",  $this->getCodigo(),PDO::PARAM_STR);
     $this->stmt->bindParam(":anolectivo",  $this->getAno(),PDO::PARAM_STR);
     $this->stmt->bindParam(":exibe",  $this->exibe,PDO::PARAM_STR);
     $this->stmt->execute();
     if($this->stmt):
     $this->resposta = "yes";
     else:
     $this->resposta = "no";
     endif;
    } catch (PDOException $ex) {
        echo ''.$ex;
    }
    return $this->resposta;
    
    
    }
	
	
    
	
}

?>
