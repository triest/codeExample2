var app = angular.module('jsbin', []);

app.controller('DemoCtrl', function($http) {

  var vm = this;
   var temp1=[];
var URL2;
  var URL = 'http://api.openweathermap.org/data/2.5/forecast/daily';

  var request = {
    method: 'GET',
    url: URL,
    params: {
       q: 'Petrozavodsk',
      mode: 'json',
      units: 'metric',
      cnt: '7',
      appid: '3ac1f68b653ffbf72a5f782420062771'
    }
  };

 $http(request)
    .then(function(response) {
   vm.data = response.data;
   vm.URL2="http://openweathermap.org/img/w/"+vm.data.list[0].weather[0].icon+".png";
   vm.mmrts=Math.round(vm.data.list[0].pressure* 0.7500);
       }).
    catch(function(response) {
      vm.data = response.data;
      vm.URL2="http://openweathermap.org/img/w/"+vm.data.list[0].weather[0].icon+".png";

    });


});
