<?php include("class/classUser.php") ?>
<?php include("class/classServicio.php") ?>
<?php include("class/classTecnoDivEvento.php") ?>
<?php $u = new User() ?>
<?php $t = new TecnoDivEvento() ?>
<?php $us = $u->get($_SESSION['uc_userid']) ?>
<?php $te = $t->getLastByUser($_SESSION['uc_userid']) ?>

<section class="content-header">
    <h1>Eventos
        <small><i class="fa fa-angle-right"></i> Ingreso de Nuevo Evento de Dispositivo In Vitro</small>
    </h1>

    <ol class="breadcrumb">
        <li><a href="index.php?section=home"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Ingreso de evento</li>
    </ol>
</section>

<section class="content container-fluid">
    <form role="form" id="formNewEvent">
        <p class="bg-class bg-danger">Los campos marcados con (*) son obligatorios</p>

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Lugar de ocurrencia</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-3 has-feedback" id="gdate">
                        <label class="control-label" for="iNdate">Fecha de notificación</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="iNdate" name="idate" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" value="<?php echo date('d/m/Y') ?>" readonly>
                        </div>
                        <span class="fa form-control-feedback" id="icondate"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gserv">
                        <label class="control-label" for="iNserv">Unidad/Servicio Clínico de ocurrencia *</label>
                        <select class="form-control" id="iNserv" name="iserv" required>
                            <option value="">Seleccione servicio</option>
                            <?php $sv = new Servicio() ?>
                            <?php $serv = $sv->getAll() ?>
                            <?php foreach ($serv as $s): ?>
                                <option value="<?php echo $s->ser_id ?>"><?php echo $s->ser_nombre ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">Información del reactivo de diagnóstico</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gngenerico">
                        <label class="control-label" for="iNngenerico">Nombre genérico *</label>
                        <input type="text" class="form-control" id="iNngenerico" name="ingenerico" placeholder="Ingrese nombre genérico del dispositivo" maxlength="256" required>
                        <span class="fa form-control-feedback" id="iconngenerico"></span>
                    </div>

                    <div class="form-group col-sm-6 has-feedback" id="gncomercial">
                        <label class="control-label" for="iNncomercial">Nombre comercial *</label>
                        <input type="text" class="form-control" id="iNncomercial" name="incomercial" placeholder="Ingrese nombre comercial del dispositivo" maxlength="256" required>
                        <span class="fa form-control-feedback" id="iconncomercial"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gcatalogo">
                        <label class="control-label" for="iNcatalogo">Catálogo o referencia *</label>
                        <input type="text" class="form-control" id="iNcatalogo" name="icatalogo" placeholder="Ingrese catálogo o referencia del dispositivo" maxlength="256" required>
                        <span class="fa form-control-feedback" id="iconcatalogo"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-4 has-feedback" id="guso">
                        <label class="control-label" for="iNuso">Uso previsto *</label>
                        <select class="form-control" id="iNuso" name="iuso" required>
                            <option value="">Seleccione uso</option>
                            <option value="CAL">CALIBRADOR</option>
                            <option value="CON">CONTROL</option>
                            <option value="DIA">DIAGNOSTICO</option>
                            <option value="OTR">OTRO</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-4 has-feedback" id="gotrouso">
                        <label class="control-label" for="iNotrouso">Otro uso previsto</label>
                        <input type="text" class="form-control" id="iNotrouso" name="iotrouso" placeholder="Si seleccionó 'otro' en la opción anterior, especifique aquí" maxlength="64" required>
                        <span class="fa form-control-feedback" id="iconotrouso"></span>
                    </div>

                    <div class="form-group col-sm-4 has-feedback" id="gcadena">
                        <label class="control-label" for="iNcadena">Requiere cadena de frío</label>
                        <select class="form-control" id="iNcadena" name="icadena" required>
                            <option value="1">SÍ</option>
                            <option value="0">NO</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-4 has-feedback" id="gtemp">
                        <label class="control-label" for="iNtemp">Rango de temperatura en ºC *</label>
                        <input type="text" class="form-control" id="iNtemp" name="itemp" placeholder="Ingrese rango de temperatura requerida" maxlength="64" required>
                        <span class="fa form-control-feedback" id="icontemp"></span>
                    </div>

                    <div class="form-group col-sm-4 has-feedback" id="gnlote">
                        <label class="control-label" for="iNnlote">Número de lote/serie *</label>
                        <input type="text" class="form-control" id="iNnlote" name="inlote" placeholder="Ingrese número de lote/serie del dispositivo" maxlength="16" required>
                        <span class="fa form-control-feedback" id="iconnlote"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12 has-feedback" id="gseguridad">
                        <label class="control-label" for="iNseguridad">Medidas de seguridad adicionales</label>
                        <input type="text" class="form-control" id="iNseguridad" name="iseguridad" placeholder="Ingrese medidas de seguridad adicionales" maxlength="256">
                        <span class="fa form-control-feedback" id="iconseguridad"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gfnombre">
                        <label class="control-label" for="iNfnombre">Nombre del fabricante *</label>
                        <input type="text" class="form-control" id="iNfnombre" name="ifnombre" placeholder="Ingrese nombre del fabricante legal" maxlength="128" required>
                        <span class="fa form-control-feedback" id="iconfnombre"></span>
                    </div>

                    <div class="form-group col-sm-6 has-feedback" id="gfpais">
                        <label class="control-label" for="iNfpais">País</label>
                        <input type="text" class="form-control" id="iNfpais" name="ifpais" placeholder="Ingrese país de fabricación" maxlength="16">
                        <span class="fa form-control-feedback" id="iconfpais"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gimnombre">
                        <label class="control-label" for="iNimnombre">Nombre del importador *</label>
                        <input type="text" class="form-control" id="iNimnombre" name="iimnombre" placeholder="Ingrese nombre del importador" maxlength="128" required>
                        <span class="fa form-control-feedback" id="iconimnombre"></span>
                    </div>

                    <div class="form-group col-sm-6 has-feedback" id="gimpais">
                        <label class="control-label" for="iNimpais">País de procedencia</label>
                        <input type="text" class="form-control" id="iNimpais" name="iimpais" placeholder="Ingrese país de procedencia" maxlength="16">
                        <span class="fa form-control-feedback" id="iconimpais"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-4 has-feedback" id="gformauso">
                        <label class="control-label" for="iNformauso">Forma de uso *</label>
                        <select class="form-control" id="iNformauso" name="iformauso" required>
                            <option value="">Seleccione forma de uso</option>
                            <option value="S">SEMI-AUTOMATIZADO</option>
                            <option value="M">MANUAL</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-3 has-feedback" id="gdatefab">
                        <label class="control-label" for="iNdatefab">Fecha de fabricación</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="iNdatefab" name="idatefab" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA">
                        </div>
                        <span class="fa form-control-feedback" id="icondatefab"></span>
                    </div>

                    <div class="form-group col-sm-3 has-feedback" id="gdatevenc">
                        <label class="control-label" for="iNdatevenc">Fecha de vencimiento *</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="iNdatevenc" name="idatevenc" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" required>
                        </div>
                        <span class="fa form-control-feedback" id="icondatevenc"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gverificacion">
                        <label class="control-label" for="iNverificacion">Laboratorio cuenta con verificación de condiciones *</label>
                        <select class="form-control" id="iNverificacion" name="iverificacion" required>
                            <option value="1">SÍ</option>
                            <option value="0">NO</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6 has-feedback" id="gcontrol">
                        <label class="control-label" for="iNcontrol">Reactivo sometido a control de calidad interno *</label>
                        <select class="form-control" id="iNcontrol" name="icontrol" required>
                            <option value="1">SÍ</option>
                            <option value="0">NO</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gadscrito">
                        <label class="control-label" for="iNadscrito">Laboratorio adscrito a programa evaluador externo *</label>
                        <select class="form-control" id="iNadscrito" name="iadscrito" required>
                            <option value="1">SÍ</option>
                            <option value="0">NO</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gautorizacion">
                        <label class="control-label" for="iNautorizacion">Autorización de uso diagnóstico *</label>
                        <select class="form-control" id="iNautorizacion" name="iautorizacion" required>
                            <option value="">Seleccione agencia</option>
                            <option value="CU">COMUNIDAD EUROPEA</option>
                            <option value="US">FDA - ESTADOS UNIDOS</option>
                            <option value="ISP">ISP</option>
                            <option value="O">OTRO</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6 has-feedback" id="gotraaut">
                        <label class="control-label" for="iNotraaut">Otro</label>
                        <input type="text" class="form-control" id="iNotraaut" name="iotraaut" placeholder="Si seleccionó 'otro' en la opción anterior, especifique aquí" maxlength="64" required>
                        <span class="fa form-control-feedback" id="iconootraaut"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="gensayo">
                        <label class="control-label" for="iNensayo">Método de ensayo *</label>
                        <input type="text" class="form-control" id="iNensayo" name="iensayo" placeholder="Ingrese método de ensayo" maxlength="256" required>
                        <span class="fa form-control-feedback" id="iconensayo"></span>
                    </div>

                    <div class="form-group col-sm-6 has-feedback" id="gtecnica">
                        <label class="control-label" for="iNtecnica">Tipo de técnica *</label>
                        <select class="form-control" id="iNtecnica" name="itecnica" required>
                            <option value="">Seleccione técnica</option>
                            <option value="CL">CUALITATIVO</option>
                            <option value="SCN">SEMI-CUANTITATIVO</option>
                            <option value="CN">CUANTITATIVO</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="ganalizador">
                        <label class="control-label" for="iNanalizador">Nombre analizador *</label>
                        <input type="text" class="form-control" id="iNanalizador" name="ianalizador" placeholder="Ingrese nombre completo del Analizador utilizado en esta técnica" maxlength="256" required>
                        <span class="fa form-control-feedback" id="iconanalizador"></span>
                    </div>
                </div>
            </div>

            <div class="box-header with-border">
                <h3 class="box-title">Descripción del evento ocurrido</h3>
            </div>
            
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-3 has-feedback" id="gdateev">
                        <label class="control-label" for="iNdateev">Fecha de evento *</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" id="iNdateev" name="idateev" data-date-format="dd/mm/yyyy" placeholder="DD/MM/AAAA" required>
                        </div>
                        <span class="fa form-control-feedback" id="icondateev"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12 has-feedback" id="gdescription">
                        <label class="control-label" for="iNdescription">Descripción del evento *</label>
                        <textarea rows="4" class="form-control" id="iNdescription" name="idescription" maxlength="450" required></textarea>
                        <span class="fa form-control-feedback" id="icondescription"></span>
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group col-sm-6 has-feedback" id="ginvestig">
                        <label class="control-label" for="iNinvestig">Investigación del problema realizada *</label>
                        <select class="form-control" id="iNinvestig" name="iinvestig" required>
                            <option value="1">SÍ</option>
                            <option value="0">NO</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-sm-6 has-feedback" id="greporte">
                        <label class="control-label" for="iNreporte">¿Se reportó el evento al distribuidor y/o fabricante? *</label>
                        <select class="form-control" id="iNreporte" name="ireporte" required>
                            <option value="1">SÍ</option>
                            <option value="0">NO</option>
                        </select>
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

<script src="tecnoevents/create-div-event.js"></script>