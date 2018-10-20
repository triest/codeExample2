<!DOCTYPE html>
<html>
<head>
    <title>Task List</title>
    <meta charset="utf-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        /* The side navigation menu */
        .sidenav {
            height: 100%; /* 100% Full-height */
            width: 0; /* 0 width - change this with JavaScript */
            position: fixed; /* Stay in place */
            z-index: 1; /* Stay on top */
            top: 0;
            left: 0;
            /*  background-color: #111; *//* Black*/
            background-color: #ffffff;
            overflow-x: hidden; /* Disable horizontal scroll */
            padding-top: 60px; /* Place content 60px from the top */
            transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
        }

        /* The navigation menu links */
        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #000000;
            display: block;
            transition: 0.3s;
        }

        /* When you mouse over the navigation links, change their color */
        .sidenav a:hover{
            color: #f1f1f1;
        }

        /* Position and style the close button (top right corner) */
        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        /* Style page content - use this if you want to push the page content to the right when you open the side navigation */


        /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }
        tr button {
            display: none;
        }

        tr:hover button {
            display: inline-block;
        }

        @import url(https://fonts.googleapis.com/css?family=Roboto);

        $primary = #2196f3;
        $accent = #d500f9;

        .ui-snackbar-container {
            position: absolute;
            overflow: hidden;

            bottom: 0;
            left: 8px;
        }

        .ui-snackbar {
            display: inline-flex;
            align-items: center;

            min-width: 288px;
            max-width: 568px;
            min-height: 48px;

            padding: 14px 24px;
            margin: 4px 4px 8px 4px;

            border-radius: 2px;
            background-color: #323232;

           /* box-shadow: 0 1px 3px alpha(black, 0.12), 0 1px 2px alpha(black, 0.24);*/
        }

        .ui-snackbar-text {
            font-size: 14px;
            color: white;
        }

        .ui-snackbar-action {
            margin-left: auto;
            padding-left: 48px;

        button {
            border: none;
            background: none;
            margin: 0;
            padding: 0;

            font-size: 14px;
            text-transform: uppercase;

            color: #ffeb3b;
        }
        }

        .ui-snackbar-toggle-transition {
            transition: transform 0.3s ease;

        .ui-snackbar-text,
        .ui-snackbar-action {
            opacity: 1;
            transition: opacity 0.3s ease;
        }
        }

        .ui-snackbar-toggle-enter,
        .ui-snackbar-toggle-leave {
            transform: translateY(60px);

        .ui-snackbar-text,
        .ui-snackbar-action {
            opacity: 0;
        }
        }

        span {
            float: right;
            padding: 4px 5px;
            color: #fff;
            font-size: 0.7em
        }
        }



        // Prettification
           * {
               font-family: Roboto;
               box-sizing: border-box;
           }

        body {
            padding: 16px;
        }

        .page {
            position: relative;
            border: 2px solid #777;
            height: 150px;
        }

        label {
            display: block;
            margin-top: 16px;
        }

        .shell {
            height: 20px;
            width: 250px;
            border: 1px solid #aaa;
            border-radius: 13px;
            padding: 3px;
        }
        table {
            table-layout: fixed; /* Фиксированная ширина ячеек */
            width: 100%; /* Ширина таблицы */
        }
    </style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="container">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <div id="app6">
        <div id="my-modal" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text"  v-model="text" :value="value_input" name="text">
                        <br>
                        <button type="button" class="btn btn-secondary" v-on:click="saveChange" >Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cancel</button>
                        </form>
                    </div>


                </div>
            </div>
        </div>
        <div id="del-modal" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                    </div>
                    <div class="modal-body">
                        <b>Delete task?</b>
                        <button type="button" class="btn btn-secondary" v-on:click="confurmDelete" >Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >No</button>
                        </form>
                    </div>


                </div>
            </div>
        </div>
        <div id="progess-modal" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>

                    </div>
                    <div class="modal-body">
                                    {{progress}}%
                        <div class="progress">
                             <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" v-bind:style="{width:progress+'%'}">
                                 <!--      <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%"> -->
                                   <span class="sr-only">{{progress}}% Complete</span>
                            </div>
                        </div>
                        </div>


                            </div>


                    </div>
                </div>

            <!--snackbar-->
        <!-- add task bar-->
        <div  ref="mySidenav" id="mySidenav" class="sidenav">
            <a @click="closeNav" @mouseover="changeText" class="closebtn">&times;</a>
            <input type="text" v-model="text" v-on:change="checInput(text)"  name="text" >
            <button v-on:click="saveText" class="btn btn-default" v-bind:disabled="text === ''">Add task</button>
            <div class="ui-snackbar-container">
                <div class="ui-snackbar" v-show="shankShowItem" transition="ui-snackbar-toggle">
                    <div class="ui-snackbar-text">Invalid "!"</div>
                </div>
                <div class="ui-snackbar" v-show="errorAdd" transition="ui-snackbar-toggle">
                    <div class="ui-snackbar-text">Error adding task!</div>
                </div>
            </div>
        </div>
        <!--end modal -->
        <center> <h3>Task list</h3></center>

        <button class="btn btn-default"  @click="getUsers()">Get tasks</button>
        <!-- Use any element to open the sidenav -->
        <button class="btn btn-default" @click="openNav">Open slide menu</button>

        <table class="table table-condensed">
            <thead>
            <tr>
                <th>id</th>
                <th>task</th>
                <th>date</th>
                <th>delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in tasks">

                <td span @mouseover="showButtonFunction"  @mouseleave="hideButtonFunction" >    {{row.id}}</td>
                <td span @mouseover="showButtonFunction"  @mouseleave="hideButtonFunction">
                    {{row.text}}
                    <button v-if="showBatton" :data-target="'#myModal' + row.id" @click="itemClicked(row)"><img src="pen.jpg" width="50" hidden="50"><i class="fa fa-pencil" aria-hidden="true"></i>
                    </button>

                    <!--   <a data-toggle="modal" v-if="showBatton" :data-target="'#myModal' + row.id" @click="itemClicked(row)">Edit from git</a>-->
                </td>
                <td span @mouseover="showButtonFunction"  @mouseleave="hideButtonFunction">
                    {{row.date_current}}
                </td>
                <td> <button class="btn"  @click="deleWindow(row)"><i class="fa fa-trash"></i></button>
                </td>

            </tr>
            </tbody>
        </table>
    </div>
    <template>
        <v-snackbar v-model=True>
            {{message}}
            <v-btn flat color="accent" @click.native="show = false">Close</v-btn>
        </v-snackbar>
    </template>
</div>





<script src="https://unpkg.com/axios/dist/axios.min.js"></script>


<script type="text/javascript">




    new Vue({
        el: '#app6',
        data:{
            tasks:[],
            fields:[
                'id','text','date',
            ],
            text:'',
            id:'',
            active: true,
            value_input:'',
            postBody:'',
            showBatton:false,
            shankShowItem:false,
            errorAdd:false,
            progress:10
        },
        methods: {
            deleWindow(item){
                this.id = item.id;
                // this.text = item.text;
                //this.value_input=item.text;
                console.log(this.id);
                //  this.id = item.id;
                //      this.text = item.text;
                //   this.value_input=item.text;
                console.log(this.id);

                $("#del-modal").modal('show');
            },
            confurmDelete:function (item) {
                console.log(this.id)
                var data = new FormData();
                data.append('del',this.id);
                $("#progess-modal").modal('show');
                this.progress = 0;
                var that = this;
                this.progress_bar().then(function(res) {
                axios.post('http://task.ru.xsph.ru/task.php',
                    data)
                    .then(res => {

                        $("#del-modal").modal('hide');
                        that.getUsers()
                    })
                    .catch(error => {
                        console.log(error)
                        that.getUsers()
                        $("#del-modal").modal('hide');
                    })

                $("#del-modal").modal('hide');
                    that.getUsers()
            })
            },
            //open edit windows
            itemClicked: function(item) {
                this.id = item.id;
                this.text = item.text;
                this.value_input=item.text;
                console.log(this.text);
                $("#my-modal").modal('show');
            },
            saveChange: function(item){
                console.log("new text: "+this.text);

                console.log("id: "+this.id);
                var data = new FormData();
                data.append('id',this.id);
                data.append('text',this.text)
                axios.post('http://task.ru.xsph.ru/task.php',
                    data
                )
                    .then(res => {
                        //  console.log(res)
                        //   this.closeNav()
                        showModal: false
                        this.getUsers()
                        this.closeNav()
                        $("#my-modal").modal('hide');

                    })
                    .catch(error => {
                        console.log(error)
                        //   showModal: true
                        //    this.closeNav()
                        showModal:false
                        this.getUsers()
                        $("#my-modal").modal('hide');
                    })
                $("#my-modal").modal('hide');
            }
            ,
            getUsers: function () {
                axios
                    .get('http://task.ru.xsph.ru/task.php')
                    .then(
                        response=> {
                            //   console.log(response);
                            this.tasks=response.data;
                        }
                    )
                    .catch(
                        // error=>console.log(error)
                    )
            },
            openNav(){
                /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
                var vm = this;
                if (vm.$refs.mySidenav.style.width== "250px" ) {
                    vm.$refs.mySidenav.style.width = "0px";
                    vm.$refs.main.style.marginRight = "0px";
                }
                else {
                    vm.$refs.mySidenav.style.width = "250px";
                    vm.$refs.main.style.marginRight = "250px";
                }

            },
            closeNav() {
                /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
                var vm = this;
                this.shankShowItem=false;
                vm.$refs.mySidenav.style.width = "0";
                vm.$refs.main.style.marginRight = "0";
                this.errorAdd(false);
            },
            changeText (){
                // this.title="dsds2"
                console.log("test")
                this.showBatton=true;
            },
            saveText(){  // сохраняет новыю задачу
                this.text2=this.text;
                var string="!";
                if (this.text.includes(string)){
                    this.shankShowItem=true;
                    return;
                }

                $("#progess-modal").modal('show');
                this.progress = 0;
                var that = this;
                this.progress_bar().then(function(res) {
                    axios.post('http://task.ru.xsph.ru/task.php',
                        'text=' + that.text
                    )
                        .then(res => {
                            that.getUsers()
                            that.closeNav()
                        })
                        .catch(error => {
                            showModal: true
                            that.getUsers()
                        })
                })

            },
            checInput(){
                if(this.text.lenght==0){
                    console.log('enpty')
                    console.log(this.text)
                    disabled=false
                }
                else {
                    disabled=true
                }
                console.log('change text')
            },

            showButtonFunction(){
                // this.title="dsds2"
                console.log("test")
                this.showBatton=true;
            },
            hideButtonFunction(){
                this.showBatton=false;
            },
            progress_bar: function() {
                var vm = this
                return new Promise(function(resolve,reject) {
                    var width = 5
                    $("#progess-modal").modal('show');
                    vm.progress = 0;
                    var refreshId=setInterval(function() {
                        vm.progress += width;
                        console.log(vm.progress)
                        if (vm.progress >= 100) {
                            clearInterval(refreshId);
                            $("#progess-modal").modal('hide');
                            resolve();
                        }
                    }, 500)

                })
            }



        },
        beforeMount(){
            this.getUsers()
        }
    })

</script>



</body>
</html>