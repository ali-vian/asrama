<?php
	class database extends PDO{
		protected $dsn = 'mysql:host=localhost;dbname=asrama';
		protected $dsu = 'root';
		protected $dsp = '';
		private $cmd = '';

		function __construct(){
			try {
				$this->db = new PDO($this->dsn,$this->dsu,$this->dsp);
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}

		//core query
		function select($c,$t){
			$this->cmd = "select $c from $t";
			return $this;
		}

		function insert($t,$v){
			$this->cmd = "insert into $t values($v)";
			return $this;
		}

		function update($t,$v){
			$this->cmd = "update $t set $v";
			return $this;
		}

		function truncate($table){
			$this->cmd = "truncate $table";
			return $this;
		}

		function delete($t){
			$this->cmd = "delete from $t";
			return $this;
		}

		function alter($t,$act,$c,$format){
			$this->cmd = "alter table $t $act $c $format";
			return $this;
		}
		//additional query
		function where($params){
			$this->cmd .= " where $params";
			return $this;
		}

		function group_by($c){
			$this->cmd .= " group by $c";
			return $this;
		}

		function order_by($c,$t){
			$this->cmd .= " order by $c $t";
			return $this;
		}

		function like($c){
			$this->cmd .= " like '%$c%'";	
			return $this;
		}

		//executable
		function get(){
			// echo $this->cmd;
			$q = $this->db->prepare($this->cmd);
			$q->execute();
			return $q->fetchAll();
		}
		function count(){
			//echo $this->cmd;
			$q = $this->db->prepare($this->cmd);
			$q->execute();
			return $q->rowCount();	
		}

		//proses normalisasi
		function rumus($data,$kemampuan){                           
            foreach($this->select('type','kriteria')->where("kriteria='$kemampuan'")->get() as $crt){
                if($crt[0]=='Benefit'){
					foreach ($this->select("max(sub_kriteria.nilai)",'hasil_tpa,sub_kriteria')->where('hasil_tpa.'.$kemampuan.'=sub_kriteria.id_subkriteria')->get() as $nm) {
                        $nilai_max = $nm[0];
                    }
                    return $rumus = $data / $nilai_max;
                    // foreach ($this->select("max($kemampuan)",'hasil_tpa')->get() as $nm) {
                    //     $nilai_max = $nm[0];
                    // }
                    // return $rumus = $data / $nilai_max;
                } else {
					foreach ($this->select("min(sub_kriteria.nilai)",'hasil_tpa,sub_kriteria')->where('hasil_tpa.'.$kemampuan.'=sub_kriteria.id_subkriteria')->get() as $nm) {
                        $nilai_min = $nm[0];
                    }
                    return $rumus = $nilai_min / $data;
                	// foreach ($this->select("min($kemampuan)",'hasil_tpa')->get() as $nm) {
                    //     $nilai_min = $nm[0];
                    // }
                    // return $rumus = $nilai_min / $data;
                }
            }    
        }

		function rumus1($data,$kemampuan){  
			foreach($this->select('type','kriteria')->where("kriteria='$kemampuan'")->get() as $crt){                         
				if($crt[0]=='Benefit'){
					
					$nilai_max = $this->select("max($kemampuan) as max",'hasil_tpa')->get()[0]['max'];
					return $rumus = $data / $nilai_max;
				} else {
					$nilai_min = $this->select("min($kemampuan) as min",'hasil_tpa')->get()[0]['min'];
					return $rumus = $nilai_min / $data;
				} 
			}
        }

        //proses hasil 
        function bobot($kemampuan){
        	foreach ($this->select('bobot','kriteria')->where("kriteria='$kemampuan'")->get() as $bb) {
        		return $bb[0];
            }	
		}

		function totalkriteria(){
        	foreach ($this->select('count(*)','kriteria')->get() as $bb) {
        		return $bb[0];
            }	
		}

		function totalsubkriteria(){
        	foreach ($this->select('count(*)','sub_kriteria')->get() as $bb) {
        		return $bb[0];
            }	
		}

		function getnamesubkriteria($subkriteria)
		{
			foreach ($this->select('subkriteria','sub_kriteria')->where("id_subkriteria='$subkriteria'")->get() as $value) {
        		return $value[0];
            }
		}
		
		function getnilaisubkriteria($subkriteria)
		{
			foreach ($this->select('nilai','sub_kriteria')->where("id_subkriteria='$subkriteria'")->get() as $value) {
        		return $value[0];
            }
		}

	
		
		
	}

	$db = new database();