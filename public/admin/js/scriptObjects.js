function Tablerow(array){

	for(var indexer in array){
		this[indexer]= array[indexer];
	}
	
	function getData(index)
	{
		return this.index;
	}
	this.modifyData = function(withArray){
		for(var index in withArray){			
			this[index] = withArray[index];
		}
	}
	this.getDatafromOject = function(key , obj , objprop, objval){
		for(var indexer in obj){
			if(obj[indexer].name==objprop)
				return obj[indexer].value;
		}
	 }
	 this.set = function(key , val){
		return this[key] = val;
	 }
}