<style>
    body{
    background-color: lightgreen;
    }
    .center{
        margin-left: 35%;
        margin-right: 35%;
    }
</style>


<nav class="navbar navbar-default navbar-inverse center" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Login</a>
        </div>
        {{ elements.getMenu() }}
    </div>
</nav>

<div class="container">
    {{ flash.output() }}

    {{ content() }}
    <hr>
    <footer>
        <p>&copy; <b>simonHochreinCode llc</b> 2015</p>
    </footer>
</div>