<section class="content-header">
	<h1>Archivos
		<small><i class="fa fa-angle-right"></i> Ingreso de Nuevo Documento</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
		<li class="active">Ingreso de nuevo documento</li>
	</ol>
</section>

<section class="content container-fluid">
    <form role="form" id="formNewFile">
        <p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>
        
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Información del archivo</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gname">
                        <label class="control-label" for="iname">Nombre *</label>
                        <input type="text" class="form-control" id="iNname" name="iname" placeholder="Ingrese nombre del documento" maxlength="250" required>
                        <i class="fa form-control-feedback" id="iconname"></i>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-3 has-feedback" id="gversion">
                        <label class="control-label" for="iversion">Versión *</label>
                        <input type="text" class="form-control" id="iNversion" name="iversion" placeholder="Ingrese versión del documento" maxlength="4" required>
                        <i class="fa form-control-feedback" id="iconversion"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-3 has-feedback" id="gdate">
                        <label class="control-label" for="idate">Fecha de creación *</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" required>
                        </div>
                        <i class="fa form-control-feedback" id="icondate"></i>
                    </div>
                    
                    <div class="form-group col-sm-3 has-feedback" id="gdatec">
                        <label class="control-label" for="idatec">Fecha de caducidad *</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="iNdatec" name="idatec" data-date-format="mm/yyyy" placeholder="MM/AAAA" required>
                        </div>
                        <i class="fa form-control-feedback" id="icondatec"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gfolder">
                        <label class="control-label" for="ifolder">Carpeta *</label>
                        <select class="form-control" id="iNfolder" name="ifolder" required>
                            <option value="">Seleccione carpeta</option>
                            <?php $fl = new Folder() ?>
                            <?php $folder = $fl->getLesser() ?>
                            <?php foreach ($folder as $f): ?>
                            <option value="<?php echo $f->fol_id ?>"><?php echo $f->fol_nombre ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="control-label" for="idocument">Archivo *</label>
                        <div class="controls">
                            <input name="idocument[]" class="multi" id="idocument" type="file" size="16" accept="pdf|doc|docx|xls|xlsx" maxlength="1">
                            <p class="help-block">Formatos admitidos: pdf, doc, docx, xls, xlsx</p>
                        </div>
                    </div>
                </div>
            </div>

            <input name="iind" id="iind" type="hidden">

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
                <button type="reset" class="btn btn-default btn-sm" id="btnClear">Limpiar</button>
            <i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
        </div>
    </form>
</section>

<script src="files/uploadother.js?v=20190828"></script>