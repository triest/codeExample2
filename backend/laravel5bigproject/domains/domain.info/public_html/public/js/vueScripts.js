
var vm = new Vue({
        el: "#app",
        data: {
            progress: 5
        },
        methods: {
            start:function()
            { console.log("start");
                var vm=this
                var width=5
                vm.progress=0
                setInterval(function(){
                    vm.progress+=width;
                    width +=5;
                    if(vm.progress>=100){
                        vm.progress=5;
                        return}
                    console.log(vm.progress)
                },500)
            },






        }
    }
);