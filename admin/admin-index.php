<h3 class="sect-title"><span class="iico iico36 iico-panel"></span> Panel de Control</h3>

<ol class="breadcrumb">
    <li><a href="index.php?section=home"><span class="glyphicon glyphicon-home"></span>Inicio</a></li>
    <li class="active">Panel de Control</li>
</ol>

<div class="row dash-row">
    <div class="col-sm-3">
        <div class="dash-item iico-file-view" id="managefiles">
            <p class="di-ht">Administración</p>
            <p class="di-st">de Documentos</p>
        </div>
    </div>
</div>

<hr>

<div class="row dash-row">
    <div class="col-sm-3">
        <div class="dash-item iico-user-add" id="createuser">
            <p class="di-ht">Creación</p>
            <p class="di-st">de Usuarios</p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="dash-item iico-user-view" id="manageuser">
            <p class="di-ht">Administración</p>
            <p class="di-st">de Usuarios</p>
        </div>
    </div>
</div>

<hr>
<!--
<div class="row">
    <div class="col-sm-3">
        <div class="dash-item iico-group-add" id="creategroup">
            <p class="di-ht">Creación</p>
            <p class="di-st">de Grupos</p>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="dash-item iico-group-view" id="managegroup">
            <p class="di-ht">Administración</p>
            <p class="di-st">de Grupos</p>
        </div>
    </div>
</div>-->

<script>
    $(document).ready( function() {
        $('.dash-item').click( function() {
            window.location.href='index.php?section=admin&sbs=' + $(this).attr('id');
        });
    });
</script>