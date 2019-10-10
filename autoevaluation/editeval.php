<?php include("class/classSubPuntoVerificacion.php"); ?>
<?php include("class/classAutoevaluation.php"); ?>
<?php include("class/classSubAmbito.php"); ?>
<?php include("class/classCodigo.php"); ?>
<?php include("class/classIndicador.php") ?>
<?php include("class/classAclaratoria.php") ?>
<?php $spv = new SubPuntoVerificacion() ?>
<?php $am = new Ambito() ?>
<?php $sam = new SubAmbito() ?>
<?php $co = new Codigo() ?>
<?php $in = new Indicador() ?>
<?php $ac = new Aclaratoria() ?>
<?php $au = new Autoevaluation() ?>
<?php $ae = $au->get($id) ?>

<section class="content-header">
	<h1>Autoevaluación
		<small><i class="fa fa-angle-right"></i> Edición de reporte de Autoevaluación</small>
	</h1>

	<ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i>Inicio</a></li>
        <li><a href="index.php?section=autoeval&sbs=manageauto">Reportes de autoevaluación ingresados</a></li>
		<li class="active">Edición de reporte de autoevaluación</li>
	</ol>
</section>

<section class="content container-fluid">
    <form role="form" id="formNewEvent">
        <p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Información del reporte</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gname">
                        <label class="control-label" for="iname">Nombre Evaluado *</label>
                        <input type="text" class="form-control" id="iNname" name="iname" placeholder="Ingrese nombre del o los encargados de la característica" maxlength="250" value="<?php echo $ae->aut_evaluado ?>"ed>
                        <i class="fa form-control-feedback" id="iconname"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gspv">
                        <label class="control-label" for="ispv">Lugar de Evaluación *</label>
                        <select class="form-control" id="iNspv" name="ispv" required>
                            <option value="">Seleccione lugar de evaluación</option>
                            <?php $s = $spv->getAll() ?>
                            <?php foreach ($s as $sp): ?>
                                <option value="<?php echo $sp->spv_id ?>"<?php if ($sp->spv_id == $ae->aut_spvid): ?> selected<?php endif ?>><?php echo $sp->spv_pvnombre . ' - ' . $sp->spv_nombre ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-3 has-feedback" id="gdate">
                        <label class="control-label" for="idate">Fecha de evaluación *</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" value="<?php echo getDateToForm($ae->aut_fecha) ?>"ed>
                        </div>
                        <i class="fa form-control-feedback" id="icondate"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gambito">
                        <label class="control-label" for="iambito">Ámbito *</label>
                        <select class="form-control" id="iNambito" name="iambito" required>
                            <option value="">Seleccione ámbito</option>
                            <?php $ambito = $am->getAll() ?>
                            <?php foreach ($ambito as $a): ?>
                            <option value="<?php echo $a->amb_id ?>"<?php if ($a->amb_id == $ae->aut_ambid): ?> selected<?php endif ?>><?php echo $a->amb_nombre ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-6 has-feedback" id="gsambito">
                        <label class="control-label" for="isambito">Sub-ámbito *</label>
                        <select class="form-control" id="iNsambito" name="isambito" required>
                            <option value="">Seleccione sub-ámbito</option>
                            <?php $sambito = $sam->getByAmbito($ae->aut_ambid) ?>
                            <?php foreach ($sambito as $sa): ?>
                            <option value="<?php echo $sa->samb_id ?>"<?php if ($sa->samb_id == $ae->aut_sambid): ?> selected<?php endif ?>><?php echo $sa->samb_nombre ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gtcode">
                        <label class="control-label" for="itcode">Código de Característica *</label>
                        <select class="form-control" id="iNtcode" name="itcode" required>
                            <option value="">Seleccione código</option>
                            <?php $codigo = $co->getBySa($ae->aut_sambid) ?>
                            <?php foreach ($codigo as $cod): ?>
                            <option value="<?php echo $cod->cod_id ?>"<?php if ($cod->cod_id == $ae->aut_codid): ?> selected<?php endif ?>><?php echo $cod->cod_descripcion ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">Detalles</h3>
            </div>

            <div class="box-body">
                <?php $data = $in->getBySACod($ae->aut_sambid, $ae->aut_codid) ?>
                <?php $data->acl = $ac->getByIndicador($data->ind_id) ?>
                <div id="t-autoeval">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td><strong><?php echo $data->ind_descripcion ?><strong></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Aclaratoria</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($data->acl as $k => $ac): ?>
                            <tr>
                                <td class="text-center" rowspan="2" width="100px">N° <?php echo $ac->acl_numero ?></td>
                                <td><strong><?php echo $ac->acl_resumen ?></strong></td>
                            </tr>
                            <tr>
                                <td><?php echo $ac->acl_descripcion ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <div class="table-responsive">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" width="100px">Código Característica</th>
                                    <th class="text-center" width="150px">Verificadores</th>
                                    <th class="text-center" colspan="<?php echo count($data->pvs) ?>">Puntos de Verificación</th>
                                    <th class="text-center">Observaciones</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                                <tr>
                                    <td class="text-center" rowspan="<?php echo count($data->ems) + 1 ?>"><?php echo $data->samb_sigla . '-' . $data->cod_descripcion ?></td>
                                    <td><strong>Elementos medibles <?php echo $data->samb_sigla . '-' . $data->cod_descripcion ?></strong></td>
                                    <?php foreach ($data->pvs as $k => $v): ?>
                                        <td class="text-center td-pvs"><strong><?php echo $v['pv_code'] ?></strong></td>
                                    <?php endforeach ?>
                                    <td></td>
                                    <?php foreach ($data->ems as $k => $v): ?>
                                        <tr>
                                            <td><?php echo $v['em_descripcion'] ?></td>
                                            <?php $comment = '' ?>
                                            <?php foreach ($data->pvs as $kk => $vv): ?>
                                            <?php $aut_e = $au->getByEmSpvUserDate($v['em_id'], $ae->aut_spvid, $ae->aut_usid, $ae->aut_fecha) ?>
                                            <?php if (!empty($aut_e->aut_comentario)) $comment = str_replace('\n', "\n", $aut_e->aut_comentario) ?>
                                            <td class="text-center">
                                                <div class="radio">
                                                    <label class="label-checkbox">
                                                        <input type="radio" class="minimal" id="vf_si_<?php echo $v['em_id'] . '_' . $vv['pv_id'] ?>" name="vf[<?php echo $v['em_id'] . '_' . $vv['pv_id'] ?>]" value="1"<?php if (!is_null($aut_e->aut_cumplimiento) and $aut_e->aut_cumplimiento == 1): ?> checked<?php endif ?>> 
                                                        Sí
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label class="label-checkbox">
                                                        <input type="radio" class="minimal" id="vf_no_<?php echo $v['em_id'] . '_' . $vv['pv_id'] ?>" name="vf[<?php echo $v['em_id'] . '_' . $vv['pv_id'] ?>]" value="0"<?php if (!is_null($aut_e->aut_cumplimiento) and $aut_e->aut_cumplimiento == 0): ?> checked<?php endif ?>> 
                                                        No
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label class="label-checkbox">
                                                        <input type="radio" class="minimal" id="vf_na_<?php echo $v['em_id'] . '_' . $vv['pv_id'] ?>" name="vf[<?php echo $v['em_id'] . '_' . $vv['pv_id'] ?>]" value="2"<?php if (!is_null($aut_e->aut_cumplimiento) and $aut_e->aut_cumplimiento == 2): ?> checked<?php endif ?>> 
                                                        N/A
                                                    </label>
                                                </div>
                                            </td>
                                            <?php endforeach ?>
                                            <td><textarea class="form-control" rows="4" name="obs[<?php echo $v['em_id'] ?>]"><?php echo $comment ?></textarea></td>
                                    <?php endforeach ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary" id="btnsubmit"><i class="fa fa-check"></i> Guardar</button>
                <button type="reset" class="btn btn-default" id="btnClear">Limpiar</button>
                <i class="ajaxLoader fa fa-cog fa-spin" id="submitLoader"></i>
            </div>
        </div>
    </form>
</section>

<script src="autoevaluation/editeval.js?v=20190828"></script>