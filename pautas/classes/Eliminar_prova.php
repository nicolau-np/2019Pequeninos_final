<?php

class Eliminar_prova {
 
    public $PAGINA;
    public $ID_ALUNO;
    public $ID_PROVA;
    public $ID_DISCIPLINA;
    public $ANO;
    public $EPOCA;
    public $CON;
    
    public $CAP_ARREDONDADO;
    public $CF_ARRENDODADO;
    public $OBSERVACAO;
    public $CF_EXTENSO;
    
    public $CURSO;
    public $CLASSE;
    
    
    public function __construct($con,$ano,$id_aluno,$id_prova,$id_disciplina,$epoca,$curso,$classe,$pagina) {
        $this->CON=$con;
        $this->ANO=$ano;
        $this->ID_ALUNO=$id_aluno;
        $this->ID_PROVA=$id_prova;
        $this->ID_DISCIPLINA=$id_disciplina;
        $this->EPOCA=$epoca;
        $this->CURSO=$curso;
        $this->CLASSE=$classe;
        $this->PAGINA=$pagina;
        
        }
        
        public function eliminar_ava() {
          $sql1="delete from tbl_provas where id_prova=:id_prova and id_aluno=:id_aluno and ano=:ano and epoca=:epoca and id_disciplina=:id_disciplina";
          try {
              $run1=  $this->CON->prepare($sql1);
              $run1->bindParam(":id_prova",  $this->ID_PROVA,PDO::PARAM_STR);
              $run1->bindParam(":id_aluno",  $this->ID_ALUNO,PDO::PARAM_STR);
              $run1->bindParam(":ano",  $this->ANO,PDO::PARAM_STR);
              $run1->bindParam(":epoca",  $this->EPOCA,PDO::PARAM_STR);
              $run1->bindParam(":id_disciplina",  $this->ID_DISCIPLINA,PDO::PARAM_STR);
              $run1->execute();
              if($run1):
                  $r=1;
              else:
                  $r=0;
              endif;
          } catch (PDOException $exc) {
              echo $exc->getMessage();
          }
return $r;
        }
        public function buscar_valores_MAC_CT($r1){
            if($r1==0):
                echo 'nao eliminou nota'; 
                elseif($r1==1) :
                    $sql3="select AVG(valor) from tbl_avaliacao where id_aluno=:id and ano=:ano and id_disciplina=:id_dis and epoca=:epoca";
                    $run3=$this->CON->prepare($sql3);
                    $run3->bindParam(":id",$this->ID_ALUNO,PDO::PARAM_STR);
                    $run3->bindParam(":ano",  $this->ANO,PDO::PARAM_STR);
                    $run3->bindParam(":id_dis",  $this->ID_DISCIPLINA,PDO::PARAM_STR);
                    $run3->bindParam(":epoca",  $this->EPOCA,PDO::PARAM_STR);
                   $run3->execute();
                        $contarAvaliacao=$run3->rowCount();                               
                        $array=$run3->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($array as $row) {
                            $mediaMAC=$row["AVG(valor)"];
                            $MAC=round($mediaMAC);
                        }
                        
                           $sql5="select AVG(valor) from tbl_provas where id_aluno=:id and ano=:ano and id_disciplina=:id_dis and epoca=:epoca";
                    $run5=$this->CON->prepare($sql5);
                    $run5->bindParam(":id",$this->ID_ALUNO,PDO::PARAM_STR);
                    $run5->bindParam(":ano",  $this->ANO,PDO::PARAM_STR);
                    $run5->bindParam(":id_dis",  $this->ID_DISCIPLINA,PDO::PARAM_STR);
                    $run5->bindParam(":epoca",  $this->EPOCA,PDO::PARAM_STR);
                   $run5->execute();
                        $contarProvas=$run5->rowCount();                               
                        $array5=$run5->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($array5 as $row5) {
                            $mediaCPP=$row5["AVG(valor)"];
                            $CPP=round($mediaCPP);
                        }
                        
                        $CT=($MAC + $CPP)/2;
                        $ct_arredondado=  round($CT);
                        
                        $sql4="update tbl_notas set cpp=:cpp, ct=:ct where anoLetivo=:ano and id_aluno=:id_aluno and id_di2=:id_dis and epoca=:epoca";
                        $run4=  $this->CON->prepare($sql4);
                        $run4->bindParam(":cpp",  $CPP,  PDO::PARAM_STR);
                        $run4->bindParam(":ct",  $ct_arredondado,  PDO::PARAM_STR);
                        $run4->bindParam(":ano",  $this->ANO,  PDO::PARAM_STR);
                        $run4->bindParam(":id_aluno",  $this->ID_ALUNO,  PDO::PARAM_STR);
                        $run4->bindParam(":id_dis",  $this->ID_DISCIPLINA,  PDO::PARAM_STR);
                        $run4->bindParam(":epoca",  $this->EPOCA,  PDO::PARAM_STR);
                        $run4->execute();
                        if($run4):
                            $r=1;
                        else:
                            $r=0;
                        endif;
                        
                        
                
            endif;
            
            return $r;
        }
        
        public function buscar_valores_finais($r2) {
            if($r2==0):
                echo'nao buscou mac nem ct';
            elseif($r2==1):
           $E1=1;
           $E2=2;
            $E3=3;
            
          $sql629="select *from tbl_notas where id_aluno=:id and id_di2=:id_dis and anoLetivo=:ano and epoca=:epoca";
          $run629=  $this->CON->prepare($sql629);
          $run629->bindParam(":id",  $this->ID_ALUNO,PDO::PARAM_STR);
           $run629->bindParam(":id_dis",  $this->ID_DISCIPLINA,PDO::PARAM_STR);
            $run629->bindParam(":ano",  $this->ANO,PDO::PARAM_STR);
             $run629->bindParam(":epoca",$E1,PDO::PARAM_STR);
          $run629->execute();
          $V1=$run629->fetch(PDO::FETCH_OBJ);
          if($V1->ct!="---"):
              $CT1=$V1->ct;
          else:
              $CT1=0;
          endif;
          
          
              $sql630="select *from tbl_notas where id_aluno=:id and id_di2=:id_dis and anoLetivo=:ano and epoca=:epoca";
          $run630=  $this->CON->prepare($sql630);
          $run630->bindParam(":id",  $this->ID_ALUNO,PDO::PARAM_STR);
           $run630->bindParam(":id_dis",  $this->ID_DISCIPLINA,PDO::PARAM_STR);
            $run630->bindParam(":ano",  $this->ANO,PDO::PARAM_STR);
             $run630->bindParam(":epoca",$E2,PDO::PARAM_STR);
          $run630->execute();
          $V2=$run630->fetch(PDO::FETCH_OBJ);
           if($V2->ct!="---"):
              $CT2=$V2->ct;
          else:
              $CT2=0;
          endif;
          
          
          
              $sql631="select *from tbl_notas where id_aluno=:id and id_di2=:id_dis and anoLetivo=:ano and epoca=:epoca";
          $run631=  $this->CON->prepare($sql630);
          $run631->bindParam(":id",  $this->ID_ALUNO,PDO::PARAM_STR);
           $run631->bindParam(":id_dis",  $this->ID_DISCIPLINA,PDO::PARAM_STR);
            $run631->bindParam(":ano",  $this->ANO,PDO::PARAM_STR);
             $run631->bindParam(":epoca",$E3,PDO::PARAM_STR);
          $run631->execute();
          $V3=$run631->fetch(PDO::FETCH_OBJ);
           if($V3->ct!="---"):
              $CT3=$V3->ct;
          else:
              $CT3=0;
          endif;
          
          $sql632="select *from tbl_cla_finais where id_aluno=:id and id_di2=:id_dis and anolectivo=:ano";
          $run632=  $this->CON->prepare($sql632);
          $run632->bindParam(":id",  $this->ID_ALUNO,PDO::PARAM_STR);
          $run632->bindParam(":id_dis",  $this->ID_DISCIPLINA,PDO::PARAM_STR);
          $run632->bindParam(":ano",  $this->ANO,PDO::PARAM_STR);
          $run632->execute();
          $V4=$run632->fetch(PDO::FETCH_OBJ);
          if($V4->cpe!="---"):
              $CPE=$V4->cpe;
          else:
              $CPE=0;
          endif;
          
          $CAP=($CT1 + $CT2 + $CT3)/3;
          $CAP_ARREDONDADO=round($CAP);
          $CF=($CAP_ARREDONDADO * 0.4)+($CPE * 0.6);
          $CF_ARRENDODADO=  round($CF);
          
          $this->CAP_ARREDONDADO=$CAP_ARREDONDADO;
          $this->CF_ARRENDODADO=$CF_ARRENDODADO;
          
          
        if($CF_ARRENDODADO<=4):
    	  $obser="Nao Transita";
    	  elseif($CF_ARRENDODADO>=5):
    	  $obser="Transita";
    	  endif; 
          
              $this->OBSERVACAO=$obser;
        
            
            // transformando em extenso
          if($CF_ARRENDODADO==0):
              $cf_extenso="Zero";
          elseif($CF_ARRENDODADO==1):
              $cf_extenso="Um valor";
          elseif($CF_ARRENDODADO==2):
               $cf_extenso="Dois valores";
           elseif($CF_ARRENDODADO==3):
               $cf_extenso="Três valores";
           elseif($CF_ARRENDODADO==4):
               $cf_extenso="Quatro valores";
           elseif($CF_ARRENDODADO==5):
               $cf_extenso="Cinco valores";
           elseif($CF_ARRENDODADO==6):
               $cf_extenso="Seis valores";
           elseif($CF_ARRENDODADO==7):
               $cf_extenso="Sete valores";
           elseif($CF_ARRENDODADO==8):
               $cf_extenso="Oito valores";
           elseif($CF_ARRENDODADO==9):
               $cf_extenso="Nove valores";
           elseif($CF_ARRENDODADO==10):
               $cf_extenso="Dez valores";
           elseif($CF_ARRENDODADO==11):
               $cf_extenso="Onze valores";
           elseif($CF_ARRENDODADO==12):
              $cf_extenso="Doze valores";
            elseif($CF_ARRENDODADO==13):
              $cf_extenso="Treze valores";
            elseif($CF_ARRENDODADO==14):
              $cf_extenso="Catorze valores";
            elseif($CF_ARRENDODADO==15):
              $cf_extenso="Quinze valores";
            elseif($CF_ARRENDODADO==16):
              $cf_extenso="Dezasseis valores";
            elseif($CF_ARRENDODADO==17):
              $cf_extenso="Dezassete valores";
            elseif($CF_ARRENDODADO==18):
              $cf_extenso="Dezoito valores";
            elseif($CF_ARRENDODADO==19):
              $cf_extenso="Dezanove valores";
            elseif($CF_ARRENDODADO==20):
              $cf_extenso="Vinte valores";
            endif;
            //fim estenso
            $this->CF_EXTENSO=$cf_extenso;
              endif;
              $r=1;
              
              return $r;
      
        }
        
public function update_cla($r3) {
    if($r3==0):
        echo'nao buscou dados finais';
    else:
       $re="update tbl_cla_finais set cap=:cap, cf=:cf, observacao=:ob, cf_extensao=:cf_extensao where id_aluno=:id and id_di2=:id_di2 and anolectivo=:ano";
                        $r=$this->CON->prepare($re);
                        $r->bindParam(":cap",  $this->CAP_ARREDONDADO,PDO::PARAM_STR);
                        $r->bindParam(":cf",  $this->CF_ARRENDODADO,PDO::PARAM_STR);
                        $r->bindParam(":ob",  $this->OBSERVACAO,PDO::PARAM_STR);
                        $r->bindParam(":cf_extensao",$cf_extenso,PDO::PARAM_STR);
                        $r->bindParam(":id",$_SESSION['id_aluno'],PDO::PARAM_STR);
                        $r->bindParam(":id_di2",$_SESSION['id_dis'],PDO::PARAM_STR);
                        $r->bindParam(":ano",$_SESSION['ano'],PDO::PARAM_STR);   
                        $r->execute();
          
     $sql="select *from view_disciplinas where curso=:curso and classe=:classe";
                            $run=  $this->CON->prepare($sql);
                            $run->bindParam(":curso",  $this->CURSO,PDO::PARAM_STR);
                            $run->bindParam(":classe",  $this->CLASSE,PDO::PARAM_STR);
                            $run->execute();
                            $conta_Dis=$run->rowCount();
            
                                        $ob00="Aluno Novo";
$co3="select *from view_clas_finais where anolectivo=:ano and id_aluno=:id and observacao!=:ob";                            
$re3=$this->CON->prepare($co3);
$re3->bindParam(":ano",  $this->ANO,PDO::PARAM_STR);
$re3->bindParam(":id",  $this->ID_ALUNO,PDO::PARAM_STR);
$re3->bindParam(":ob",$ob00,PDO::PARAM_STR);
$re3->execute();

$contar_OB=$re3->rowCount();

if($conta_Dis>$contar_OB):
  
elseif($conta_Dis==$contar_OB):
    $obser2="Nao Transita";
$co4="select *from view_clas_finais where anolectivo=:ano and id_aluno=:id and observacao=:ob";                            
$re4=  $this->CON->prepare($co4);
$re4->bindParam(":ano",  $this->ANO,PDO::PARAM_STR);
$re4->bindParam(":id",  $this->ID_ALUNO,PDO::PARAM_STR);
$re4->bindParam(":ob",$obser2,PDO::PARAM_STR);
$re4->execute();
$contar_OB2=$re4->rowCount();
if($contar_OB2>=3):
   $obsercacao_finalH="Não Transita";
elseif($contar_OB2<=2):
     $obsercacao_finalH="Transita";
endif;
$se03="update tbl_historico_aluno set aproveitamento=:apro where id_aluno=:id_aluno and anolectivo=:ano";
$r03=  $this->CON->prepare($se03);
$r03->bindParam(":apro",$obsercacao_finalH,PDO::PARAM_STR);
$r03->bindParam(":id_aluno",  $this->ID_ALUNO,PDO::PARAM_STR);
$r03->bindParam(":ano",  $this->ANO,PDO::PARAM_STR);
$r03->execute();

endif; 
echo '<script>
    alert("Eliminada com sucesso");
    window.location.href="'.$this->PAGINA.'";
</script>';

    endif;
                      
        }
}
?>
