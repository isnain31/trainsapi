
var app = angular.module('trainApp', []);

app.directive('timepicker', function() {
   return {
        restrict: 'A',
        require : 'ngModel',
	scope: {
    model: '=ngModel'
  },
        link : function (scope, element, attrs, ngModelCtrl) {
              element.timepicker({'timeFormat' : 'H:i:s','step':1});

	    element.on('changeTime', function () {
	      scope.$apply(function () {
		scope.model = element.val();
	      });
	    });
         }
   }
});


app.service('trainService', [ '$http', function($http) {

   var apiurl;
   
   this.setupApi = function setupApi(url) {
	apiurl='http://'+url;
   }

    this.getAllTrains = function getAllTrains() {
        return $http({
            method : 'GET',
            url : apiurl+'/trains/'
        });
    }
    this.add = function add(train_name,build_year,train_type){
        return $http({
          method: 'POST',
          url: apiurl+'/train/add',
          data: {trainName:train_name,buildYear:build_year,trainType:train_type}
        });
    }
    this.update = function update(train_number,train_name,build_year,train_type){
        return $http({
          method: 'PUT',
          url: apiurl+'/train/'+train_number,
          data: {trainName:train_name,buildYear:build_year,trainType:train_type}
        });
    }

    this.get = function get(train_number){
        return $http({
          method: 'GET',
          url: apiurl+'/train/'+train_number
        });
    }
    this.del= function del(train_number){
        return $http({
          method: 'DELETE',
          url: apiurl+'/train/'+train_number
        });

    }			
} ]);


app.controller('trainController', ['$scope','trainService', 
  function ($scope,trainService) {
      $scope.trainsSelecteds=[];	
      $scope.arrivals = [];	
      $scope.departures = [];	
      $scope.tracks = 0;
      $scope.successMessage = '';
      $scope.errorMessage = '';	
      $scope.api_url='';	
      $scope.vm = {data: {}};
	
      $scope.getALlTrains = function () {
          trainService.getAllTrains()
            .then(function success(response) {
		
                $scope.trains = response.data;
            },
            function error (response) {
                $scope.message = '';
                if (response.status === 400){
                    $scope.errorMessage = 'Bad Request!';
                }
                else {
                    $scope.errorMessage = "No train Found";
                }
            });
      };
	
     $scope.setApi=function(){
	$scope.api_url=$scope.api_url_input;
	trainService.setupApi($scope.api_url);
	$scope.getALlTrains();
     }

     $scope.clear=function(){
       $scope.train_number="";
       $scope.train_name="";
       $scope.build_year="";
       $scope.train_type="";
     }

     $scope.saveTrain = function () {
	
	if($scope.train_number==undefined){
            trainService.add($scope.train_name,$scope.build_year,$scope.train_type)
              .then (function success(response){
                  $scope.successMessage = 'Train Added';
		  $scope.errorMessage = '';
		  $scope.clear();
		  $scope.getALlTrains();	
              },
              function error(response){
                  $scope.errorMessage = 'Invalid Request All the fields are needed!';
                  $scope.successMessage = '';
            });
        }
	else{
	
	    trainService.update($scope.train_number,$scope.train_name,$scope.build_year,$scope.train_type)
              .then (function success(response){
                  $scope.successMessage='Train updated!';
                  $scope.errorMessage = '';
		  $scope.clear();
		  $scope.getALlTrains();
              },
              function error(response){
                  $scope.errorMessage = 'Invalid Request All the fields are needed!';
                  $scope.successMessage = '';
            });		
	}
      } 	

      $scope.editTrain = function (train_number) {
	  trainService.get(train_number)
            .then(function success(response) {
		aTrain=response.data.pop();
		$scope.train_number=aTrain.train_number;
		$scope.train_name=aTrain.train_name;
		$scope.build_year=aTrain.build_year;
		$scope.train_type=aTrain.train_type;
		
            },
            function error (response) {
                if (response.status === 404){
                    $scope.errorMessage = 'Train not found!';
                }
                else {
                    $scope.errorMessage = "Error getting train!";
                }
            });
      };     
 

      $scope.deleteTrain=function(train_number){
	if(confirm("Are you sure to delete this train?")){
	      	trainService.del(train_number)
		    .then(function success(response) {
			 $scope.getALlTrains();
			  $scope.successMessage = 'Train Removed';
		    },
		    function error (response) {
		        if (response.status === 404){
		            $scope.errorMessage = 'Train not found!';
		        }
		        else {
		            $scope.errorMessage = 'Invalid Request All the fields are needed!';
		        }
		    });
	}	
      };

      $scope.selectTrain=function (train_number,train_name){
	      if(!$scope.trainAddedAllready(train_number)) {
	      	$scope.trainsSelecteds.push({train_number:train_number,train_name:train_name});

	      }
	      
      }
      $scope.rowClick=function(event,train){
	element=angular.element(event.target);
	if(element.is('span'))
		element=element.parent();
	if(element.hasClass('select')){
	  $scope.selectTrain(train.train_number,train.train_name);	
	}
	else if(element.hasClass('edit')){
	  $scope.editTrain(train.train_number);	
	}
	else if(element.hasClass('delete')){
	  $scope.deleteTrain(train.train_number);	
	}

      }	

      $scope.sortArrivalTime = function(arr){

	  arr = arr.sort(function(a,b){
	    return a.arrival > b.arrival;
	  })
	
	  return arr;
	}	

      $scope.trainAddedAllready=function(element){
	  var retval=false;
	  angular.forEach($scope.trainsSelecteds, function(object) {
	  	if(object.train_number==element){
			retval=true;
		}
 	  });
          return retval;
      }	

    $scope.countTracks=function(arrivalDepartures){
	  var count = 0;
	  angular.forEach(arrivalDepartures, function(object) {
		count += object.serviced==0 ? 1 : 0;
	   });
          return count;
      }

    $scope.processDate=function(timeval) {
	
	split_date=timeval.split(":");
	dateobj=new Date();
	dateobj.setHours(split_date[0],split_date[1],split_date[2]);
	return dateobj;
    }

      $scope.calculate=function(){
	     var arrivalDepartures=[];	

	     for (var i = 0; i < $scope.arrivals.length; i++){

		if($scope.arrivals[i]!=undefined && $scope.departures[i]!=undefined){
			// getting the time stamp
			arrival_date=$scope.processDate($scope.arrivals[i]);
			departure_date=$scope.processDate($scope.departures[i]);
		
			arrivalDepartures.push({"arrival":arrival_date.getTime(),"departure":departure_date.getTime(),"serviced":0})		
		}
	     }	
	    $scope.sortArrivalTime(arrivalDepartures);	// sorting based on arrival time

	

	    for (var i = 0; i < arrivalDepartures.length; i++){
		for (var j = i+1; j < arrivalDepartures.length; j++){
			if(arrivalDepartures[j].serviced==1)
				continue;
			// since sorted next train must be later or exact the same time
			if(arrivalDepartures[i].departure < arrivalDepartures[j].arrival ) {
				arrivalDepartures[j].serviced=1;				
				arrivalDepartures[i].departure=arrivalDepartures[j].departure
			} 
			
		}
	    }	
		
	    $scope.tracks=$scope.countTracks(arrivalDepartures);	
      }	
	
      
}]);


describe('trainController', function() {
  beforeEach(module('trainApp'));

  var $controller;

  beforeEach(inject(function(_$controller_){
    $controller = _$controller_;
  }));

  describe('$scope.calculate', function() {
    it('checks if the caclculated tracks are fine', function() {
      var $scope = {};
      var controller = $controller('trainController', { $scope: $scope });
      $scope.arrivals=["07:00:00","08:00:00","06:56:00"];
      $scope.departures=["08:50:00","08:05:00","07:54:00"];
      $scope.calculate();
      expect($scope.tracks).toEqual(2);
    });
  });
});
