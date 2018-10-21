<style>
    .parent {
        width: 1200px;
        height:80px;
        overflow: hidden;
        overflow-x: scroll;
        background: white;
        white-space:nowrap;
        horiz-align: center;
    }

    .child {
        display: inline-block;
        vertical-align: top;
        width: 60px;
        height:60px;
        background: #f6fff7;
    }

    .DocumentList
    {
        overflow-x:scroll;
        overflow-y:hidden;
        height:200px;
        width:100%;
        padding: 0 15px;
    }

    .DocumentItem
    {
        border:1px solid black;
        padding:0;
        height:200px;
    }

    .list-inline {
        white-space:nowrap;
    }

    .row > .col-xs-3 {
        display:flex;
        flex: 0 0 25%;
        max-width: 25%
    }

    .flex-nowrap {
        -webkit-flex-wrap: nowrap!important;
        -ms-flex-wrap: nowrap!important;
        flex-wrap: nowrap!important;
    }
    .flex-row {
        display:flex;
        -webkit-box-orient: horizontal!important;
        -webkit-box-direction: normal!important;
        -webkit-flex-direction: row!important;
        -ms-flex-direction: row!important;
        flex-direction: row!important;
    }


    .well {
        min-height: 300px;
        width: 100%;
    }

    .row > .col-xs-3 {
        display:flex;
        flex: 0 0 25%;
        max-width: 25%
    }

    .flex-nowrap {
        -webkit-flex-wrap: nowrap!important;
        -ms-flex-wrap: nowrap!important;
        flex-wrap: nowrap!important;
    }
    .flex-row {
        display:flex;
        -webkit-box-orient: horizontal!important;
        -webkit-box-direction: normal!important;
        -webkit-flex-direction: row!important;
        -ms-flex-direction: row!important;
        flex-direction: row!important;
    }


    .well {
        min-height: 300px;
        width: 100%;
    }


</style>


<div class="scrollmenu">
    @foreach($girls as $girl)
        <div class="child">

        </div>
    @endforeach
</div>
<br>
<div class="container-fluid">
    <h2>Bootstrap Horizontal Scrolling with Flexbox</h2>
    <div class="row flex-row flex-nowrap">
        <div class="col-xs-3">
            <div class="well">Well</div>
        </div>
        <div class="col-xs-3">
            <div class="well">Well</div>
        </div>
        <div class="col-xs-3">
            <div class="well">Well</div>
        </div>
        <div class="col-xs-3">
            <div class="well">Well</div>
        </div>
        <div class="col-xs-3">
            <div class="well">Well</div>
        </div>
        <div class="col-xs-3">
            <div class="well">Well</div>
        </div>
        <div class="col-xs-3">
            <div class="well">Well</div>
        </div>
        <div class="col-xs-3">
            <div class="well">Well</div>
        </div>
        <div class="col-xs-3">
            <div class="well">Well</div>
        </div>
    </div>
</div>

<div id="intro">
    <h1><a href="http://caroufredsel.dev7studios.com">carouFredSel</a></h1>
    <p>This is a demo page, for more examples, the complete documentation, tips &amp; tricks, a support-forum and even a configuration robot, visit <a href="http://caroufredsel.dev7studios.com">caroufredsel.dev7studios.com</a></p>
</div>

<div class="wrapper">
    <br />


    <p>Basic carousel.</p>
    <div class="list_carousel">
        <ul id="foo0">
            <li>c</li>
            <li>a</li>
            <li>r</li>
            <li>o</li>
            <li>u</li>
            <li>F</li>
            <li>r</li>
            <li>e</li>
            <li>d</li>
            <li>S</li>
            <li>e</li>
            <li>l</li>
            <li> </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <br />


    <p>Basic carousel + timer, using CSS-transitions.</p>
    <div class="list_carousel">
        <ul id="foo1">
            <li>c</li>
            <li>a</li>
            <li>r</li>
            <li>o</li>
            <li>u</li>
            <li>F</li>
            <li>r</li>
            <li>e</li>
            <li>d</li>
            <li>S</li>
            <li>e</li>
            <li>l</li>
            <li> </li>
        </ul>
        <div class="clearfix"></div>
        <div id="timer1" class="timer"></div>
    </div>
    <br />


    <p>Carousel scrolled by user interaction.<br />
        (prev-button, next-button, pagination, mousewheel and swipe)</p>
    <div class="list_carousel">
        <ul id="foo2">
            <li>c</li>
            <li>a</li>
            <li>r</li>
            <li>o</li>
            <li>u</li>
            <li>F</li>
            <li>r</li>
            <li>e</li>
            <li>d</li>
            <li>S</li>
            <li>e</li>
            <li>l</li>
            <li> </li>
        </ul>
        <div class="clearfix"></div>
        <a id="prev2" class="prev" href="#">&lt;</a>
        <a id="next2" class="next" href="#">&gt;</a>
        <div id="pager2" class="pager"></div>
    </div>
    <br />


    <p>Carousel with a variable number of visible items with variable sizes.</p>
    <div class="list_carousel">
        <ul id="foo3">
            <li style="width: 50px; height: 50px;">c</li>
            <li style="width: 200px; height: 100px;">a</li>
            <li style="width: 50px; height: 150px;">r</li>
            <li style="width: 50px; height: 200px;">o</li>
            <li style="width: 50px; height: 150px;">u</li>
            <li style="width: 100px; height: 100px;">F</li>
            <li style="width: 250px; height: 50px;">r</li>
            <li style="width: 150px; height: 100px;">e</li>
            <li style="width: 150px; height: 150px;">d</li>
            <li style="width: 50px; height: 200px;">S</li>
            <li style="width: 100px; height: 150px;">e</li>
            <li style="width: 150px; height: 100px;">l</li>
            <li style="width: 200px; height: 50px;"> </li>
        </ul>
        <div class="clearfix"></div>
        <a id="prev3" class="prev" href="#">&lt;</a>
        <a id="next3" class="next" href="#">&gt;</a>
    </div>
</div>
<br />


<p style="text-align: center;">Responsive layout example resizing the items (resize your browser).</p>
<div class="list_carousel responsive">
    <ul id="foo4">
        <li>c</li>
        <li>a</li>
        <li>r</li>
        <li>o</li>
        <li>u</li>
        <li>F</li>
        <li>r</li>
        <li>e</li>
        <li>d</li>
        <li>S</li>
        <li>e</li>
        <li>l</li>
        <li> </li>
    </ul>
    <div class="clearfix"></div>
</div>
<br />


<p style="text-align: center;">Responsive layout example centering the items (resize your browser).</p>
<div class="list_carousel responsive" >
    <ul id="foo5">
        <li style="width: 300px;">c</li>
        <li style="width: 150px;">a</li>
        <li>r</li>
        <li style="width: 300px;">o</li>
        <li style="width: 150px;">u</li>
        <li>F</li>
        <li style="width: 300px;">r</li>
        <li style="width: 150px;">e</li>
        <li>d</li>
        <li style="width: 400px;">S</li>
        <li style="width: 150px;">e</li>
        <li>l</li>
        <li> </li>
    </ul>
    <div class="clearfix"></div>
</div>
<br />


<br />
<br />
