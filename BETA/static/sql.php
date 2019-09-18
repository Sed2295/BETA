<?php
	class BD_mysql {
		private $conexion;
		private $resource;
		private $sql;
		private $bdatos;
		public static $queries;
		private static $_singleton;
		
		const BD_EJECUTAR = 0;
		const BD_FILA = 1;
		const BD_TABLA = 2;
		const BD_INSERT = 3;

	#------------------------- INICIA -------------------------#
		public static function getInstancia($server,$root,$pass,$bd)
		{
			if (is_null (self::$_singleton)) {
				self::$_singleton = new BD_mysql($server,$root,$pass,$bd);
			}
			return self::$_singleton;
		}
	#------------------------- CONSTRUCTOR -------------------------#
		private function __construct($server,$root,$pass,$bd)
		{
			$this->conexion = @new mysqli($server, $root, $pass, $bd);
			self::$queries = 0;
			$this->resource = null;
		}
	#------------------------- EJECUTA -------------------------#
		public function setQuery($sql){
			if(empty($sql)){
				return false;
			}
			$this->sql = $sql;
			return true;
		}
	#------------------------- OBTENER -------------------------#
		public function execute(){
			if(!($this->resource = $this->conexion->query($this->sql))){
				return NULL;
			}
			self::$queries++;
			return $this->resource;
		}
	#------------------------- OPERACIONES -------------------------#
		public function resultadoQuery($sql, $action = self::BD_EJECUTAR)
		{
			$this->setQuery($sql);
			$resultado = null;
			switch ($action) {
				case self::BD_EJECUTAR:
					$resultado = $this->doIT();
				break;
				case self::BD_FILA:
					$resultado = $this->getFila();
				break;
				case self::BD_TABLA:
					$resultado = $this->getTuplas();
				break;
				case self::BD_INSERT:
					$resultado = $this->doIT2();
				break;
			}
			return $resultado;
		}
	#------------------------- ACTUALIZACIÓN -------------------------#
		public function doIT()
		{
		  if (!($cur = $this->execute())){return false;}else{return true;}
		}
	#------------------------- INSERT ID -------------------------#
		public function doIT2()
		{
			if (!($cur = $this->execute()))
			{
				return false;
			}
			else
			{
				return mysqli_insert_id($this->conexion);
			}
		}
	#------------------------- TABLA -------------------------#	
		public function getTuplas()
		{
			if (!($cur = $this->execute())){
				return null;
			}
			$array = array();
			while ($row = @mysqli_fetch_object($cur)){
				$array[] = $row;
			}
			mysqli_free_result($this->resource);
			return $array;
		}
	#------------------------- FILA -------------------------#
	    public function getFila()
		{
			if (!($cur = $this->execute())){
				return null;
			}
			$array = array();
			$row = @mysqli_fetch_assoc($cur);
			mysqli_free_result($this->resource);
			return $row;
		}  
	#------------------------- DESTRUCTOR -------------------------#
		function __destruct(){
			@mysqli_free_result($this->resource);
			@mysqli_close($this->conexion);
		}
	}
?>
