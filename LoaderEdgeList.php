<?php

class LoaderEdgeList implements Loader{
	
	private $debugMode = false;
	
	public function __construct(){
	}
	
	public function getGraphFromFile($fileName){
		//echo file_get_contents ("data/Graph2.txt" );
		$graph = new Graph();
		$file = file($fileName);
		$vertexCount = $file[0];
		
		
		// Add all vertices to the graph
		$vertexArray=array();
		for($i=0;$i<$vertexCount;$i++){
			//echo "added vertize ".$i." \n";
			$vertexArray[$i] = $graph->addVertex($i);	
		}
		
		
		// Add all edge informations from the file
		$edgeCounter = 0;
		foreach ($file as $zeile) {
			//skip first entry, it contains only the number of vertices
			if($zeile==$file[0]){
				if ($this->debugMode){
					echo "Starting with ".$zeile." elements\n";
				}
			}
			else{
				$array = explode("\t",$zeile);
				//echo "trying to add edge nr {$edgeCounter} from {$array[0]} to {$array[1]}\n";
				$edge = new EdgeUndirected($edgeCounter,$array[0],$array[1]);
				// add edge to graph
				$graph->addEdge($edge);
				// add edge to vertex
				$vertexArray[(int)$array[0]]->addEdgeId($edgeCounter);
				$vertexArray[(int)$array[1]]->addEdgeId($edgeCounter);
				if ($this->debugMode){
					echo "added edge nr {$edgeCounter} from {$array[0]} to {$array[1]}\n";
				}
				$edgeCounter++;
			}
		}
		for($i=0;$i<$vertexCount;$i++){
			$graph->addVertex($vertexArray[$i]);
		}
		
		if ($this->debugMode){
			echo "Added {$vertexCount} vertices and {$edgeCounter} edges\n";
		}
		
		return $graph;
		
	}	
}
