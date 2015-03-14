<?php
require_once 'models/baseMdl.php';
    /**
    * Clase para el modelo de Consulta
    */
class ConsultaMdl extends BaseMdl{
    private $idCliente;
    private $idTerapeuta;
    private $idHistorialMedico;
    private $fechaCita;
    private $idConsultaStatus;
    private $idServicio;
    private $observaciones;
    
    /**
     *@param integer $idCliente
     *@param integer $idTerapeuta
     *@param date $fechaCita
     *@param integer $idConsultaStatus
     *@param string $observaciones
     *Crea una nueva consulta
     *@return true
     */
    function create($idCliente, $idTerapeuta, $idHistorialMedico = NULL, $fechaCita, $idConsultaStatus, $idServicio, $observaciones){
        $this->idCliente        = $idCliente;
        $this->idTerapeuta      = $idTerapeuta;
        $this->idHistorialMedico= $idHistorialMedico;
        $this->idServicio       = $idServicio;
        $this->fechaCita        = $fechaCita;
        $this->idConsultaStatus = $idConsultaStatus;
        $this->observaciones    = $this->driver->real_escape_string($observaciones);
        
        $stmt = $this->driver->prepare("INSERT INTO Consulta (IDCliente, IDTerapeuta, IDHistorialMedico, FechaCita, IDConsultaStatus, IDServicio,Observaciones)
                                        VALUES(?,?,?,?,?,?,?)");

        if(!$stmt->bind_param('iiisiis',$this->idCliente,$this->idTerapeuta,$this->idHistorialMedico,$this->fechaCita,$this->idConsultaStatus,$this->idServicio,$this->observaciones)){
            return false;
        }

        if (!$stmt->execute()) {
            return false;
        }


        if($this->driver->error){
            return false;
        }

        return true;
    }

    /**
     *@param integer $idConsulta
     *@param integer $idCliente
     *@param integer $idTerapeuta
     *@param date $fechaCita
     *@param integer $idConsultaStatus
     *@param string $observaciones
     *Crea una nueva consulta
     *@return true
     */
    function update($idConsulta,$idCliente, $idTerapeuta, $idHistorialMedico=NULL, $fechaCita, $idConsultaStatus,$idServicio, $observaciones){
        $this->idCliente        = $idCliente;
        $this->idTerapeuta      = $idTerapeuta;
        $this->idServicio       = $idServicio;
        $this->fechaCita        = $fechaCita;
        $this->idConsultaStatus = $idConsultaStatus;
        $this->observaciones    = $this->driver->real_escape_string($observaciones);
        
        $stmt = $this->driver->prepare("UPDATE Consulta SET IDCliente=?, IDTerapeuta=?, IDHistorialMedico=?, FechaCita=?, IDConsultaStatus=?, IDServicio=?, Observaciones=? WHERE IDConsulta=?");
        if(!$stmt->bind_param('iiisiisi',$this->idCliente,$this->idTerapeuta,$this->idHistorialMedico,$this->fechaCita,$this->idConsultaStatus, $this->idServicio, $this->observaciones,$idConsulta)){
            return false;
        }
        if (!$stmt->execute()) {
            return false;
        }

        if($this->driver->error){
            return false;
        }

        return true;
    }
    
    /**
    * Busca a las Consultas registradas
    *@param int $offset
    *@param int $idConsulta
    * @return array or false
    **/
    
    function lists($offset = -1,$idConsulta = -1, $constrain = '1 = 1'){
        $rows = array();
        if($offset>-1){
            $stmt = $this->driver->prepare('SELECT * FROM V_Consulta WHERE '.$constrain.' LIMIT ?,?');
        }else{
            if($idConsulta>-1){
                $stmt = $this->driver->prepare('SELECT * FROM V_Consulta WHERE IDConsulta=?');
            }else{
                $stmt = $this->driver->prepare('SELECT * FROM V_Consulta WHERE '.$constrain);
            }
        }
        if($stmt){
            if($offset>-1){
                $amountRows = 10;
                $offset*=10;
                if(!$stmt->bind_param('ii',$offset,$amountRows))
                    return false;
            }else if($idConsulta>-1){
                if(!$stmt->bind_param('i',$idConsulta))
                    return false;
            }
            if(!$stmt->execute())
                return false;

            $mySqliResult = $stmt->get_result();

            if($mySqliResult->field_count > 0){

                while($result = $mySqliResult->fetch_assoc())
                    array_push($rows, $result);
                if(empty($rows))
                    return VACIO;
                return $rows;
            }else
                return VACIO;

        }else
            return false;
            
        return false;
    }
}
?>