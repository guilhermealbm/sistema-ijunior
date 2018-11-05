<?php
	class FilmeDAO{
		

		public function conectar(){
			$host = 'localhost';
			$usuario = 'root';
			$senha = '';
			$database = 'tvnews';
			$conexao = new mysqli($host, $usuario, $senha, $database);

			return $conexao;
		}

		function novo($movie){
			$situacao = TRUE;
			try{
				$c = $this->conectar();
				$query = "INSERT INTO Movie (name,releaseYear,runningTime, genre, director, studio, active) values ('{$movie->getName()}', '{$movie->getReleaseYear()}', '{$movie->getRunningTime()}', '{$movie->getGenre()}', '{$movie->getDirector()}', '{$movie->getStudio()}', '1')";
				$c->query($query);
				$codigo = $c->insert_id;
                $movie->setIdMovie($codigo);
				$c->close();
			}catch(Exception $ex){
				$situacao = FALSE;
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}
			return $situacao;
		}

		function alterar($movie){
			$situacao = TRUE;
			$c = $this->conectar();
			try{
				$query = "UPDATE Movie SET name='{$movie->getName()}', releaseYear='{$movie->getReleaseYear()}', runningTime='{$movie->getRunningTime()}', genre='{$movie->getGenre()}', director='{$movie->getDirector()}', studio='{$movie->getStudio()}' WHERE idMovie='{$movie->getIdMovie()}'";
				$c->query($query);
				$c->close();
			}catch(Exception $ex){
				$situacao = FALSE;
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}
			return $situacao;
		}

		function excluir($movie){
			$situacao = TRUE;
			$c = $this->conectar();
			try{
				$query = "UPDATE Movie SET active='{0}' WHERE idMovie='{$movie}'";
					$c->query($query);
					$c->close();
			}catch(Exception $ex){
				$situacao = FALSE;
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}
			return $situacao;
		}

		function listar(){
			$filmes = array();
			try{
				$c = $this->conectar();
				$query = "select * from Movie";
				$resultado = $c->query($query);
				$c->close();
				while($registro = mysqli_fetch_assoc($resultado)) {
					$filme = new Filme();
					$filme->setIdMovie($registro['idMovie']);
					$filme->setName($registro['name']);
					$filme->setReleaseYear($registro['releaseYear']);
					$filme->setRunningTime($registro['runningTime']);
					$filme->setGenre($registro['genre']);
					$filme->setDirector($registro['director']);
					$filme->setStudio($registro['studio']);
					$filme->setStatus($registro['active']);
					array_push($filmes, $filme);
				}
				$resultado->close();
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}
			return $filmes;
		}

		function buscarPorId($codigo){
			$movie = new Filme();
			try{
				$c = $this->conectar();
				$query = "select * from Movie where idMovie = {$codigo}";
				$resultado = $c->query($query);
				$c->close();
				$registro = mysqli_fetch_assoc($resultado);
				$movie->setIdMovie($registro['idMovie']);
				$movie->setName($registro['name']);
				$movie->setReleaseYear($registro['releaseYear']);
				$movie->setRunningTime($registro['runningTime']);
				$movie->setGenre($registro['genre']);
				$movie->setDirector($registro['director']);
				$movie->setStudio($registro['studio']);
				$movie->setStatus($registro['active']);
			}catch(Exception $ex){
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}

			return $movie;
		}
		
		function watchList($movie, $user){
			$situacao = TRUE;
			try{
				$c = $this->conectar();
				//INSERT INTO User_Movies (idUser, idMovie, watchList, rating) values (1, 1, 1, 0)
				$query = "INSERT INTO User_Movies (idUser, idMovie, watchlist, rating) values ('{$user->getIdUser()}', '{$movie->getIdMovie()}', '1', '0')";
				$c->query($query);
				$codigo = $c->insert_id;
                $movie->setIdMovie($codigo);
				$c->close();
			}catch(Exception $ex){
				$situacao = FALSE;
				echo $ex->getFile().' : '.$ex->getLine().' : '.$ex->getMessage();
			}
			return $situacao;
		}

	}

?>
