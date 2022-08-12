<?php

extract($_GET);

if (!isset($section) || $section == 'home'):
	include 'main/main-index.php';
elseif ($section == 'verif-points'):
	include 'files/visit-index.php';
elseif ($section == 'search-files'):
	include 'files/search-files.php';
elseif ($section == 'other-files'):
	include 'files/other-index.php';
elseif ($section == 'files' and ($_admin or $_calidad)):
	include 'files/main-index.php';
elseif ($section == 'ind-verif' and $_login):
	if ($sbs == 'createpoint'):
		include 'indicators/create-indicator.php';
	endif;
/** EVENTOS ADVERSOS **/
elseif ($section == 'adv-event' and $_login):
	if ($sbs == 'createevent'):
		include 'events/create-event.php';
	elseif ($sbs == 'viewevents'):
		include 'events/view-events.php';
	elseif ($sbs == 'editevent'):
		include 'events/edit-event.php';
	elseif ($sbs == 'exportevent'):
		include 'events/export-event.php';
	elseif ($sbs == 'eventsteril'):
		include 'events/steril-events.php';
	else:
		include 'src/error.php';
	endif;
/** EVENTOS DE TECNOVIGILANCIA **/
elseif ($section == 'tec-event' and $_login):
	if ($sbs == 'createtecnoevent'):
		include 'tecnoevents/create-tec-event.php';
	elseif ($sbs == 'viewtecnoevents'):
		include 'tecnoevents/view-tec-events.php';
	elseif ($sbs == 'edittecnoevent'):
		include 'tecnoevents/edit-tec-event.php';
	elseif ($sbs == 'createdivevent'):
		include 'tecnoevents/create-div-event.php';
	elseif ($sbs == 'viewdivevents'):
		include 'tecnoevents/view-div-events.php';
	elseif ($sbs == 'editdivevent'):
		include 'tecnoevents/edit-div-event.php';
	elseif ($sbs == 'createalert'):
		include 'tecnoevents/create-alert.php';
	elseif ($sbs == 'viewalerts'):
		include 'tecnoevents/view-alerts.php';
	elseif ($sbs == 'editalert'):
		include 'tecnoevents/edit-alert.php';
	else:
		include 'src/error.php';
	endif;
/** AUTOEVALUACION **/
elseif ($section == 'autoeval' and ($_admin or $_autoeval or $_calidad)):
	if ($sbs == 'newmedible' and ($_admin or $_calidad)):
		include('medibles/new-medible.php');
	elseif ($sbs == 'managemedibles' and ($_admin or $_calidad)):
		include 'medibles/manage-medibles.php';
	elseif ($sbs == 'editmedible' and ($_admin or $_calidad)):
		include 'medibles/edit-medible.php';
	elseif ($sbs == 'editaclaratoria' and ($_admin or $_calidad)):
		include 'medibles/edit-aclaratoria.php';
	elseif ($sbs == 'newindicator' and ($_admin or $_calidad)):
		include 'indicators/new-indicator.php';
	elseif ($sbs == 'manageindicators' and ($_admin or $_calidad)):
		include 'indicators/manage-indicators.php';
	elseif ($sbs == 'editindicator'):
		include 'indicators/edit-indicator.php';
	elseif ($sbs == 'newvaluesindicator'):
		include 'indicators/create-indicator.php';
	elseif ($sbs == 'newauto'):
		include 'autoevaluation/neweval.php';
	elseif ($sbs == 'manageauto'):
		include 'autoevaluation/manage-eval.php';
	elseif ($sbs == 'editauto'):
		include 'autoevaluation/editeval.php';
	elseif ($sbs == 'generatereport'):
		include 'autoevaluation/generate-report.php';
	elseif ($sbs == 'generatereportbychar'):
		include 'autoevaluation/generate-report-caract.php';
	else:
		include 'src/error.php';
	endif;
/** ACCIDENTES LABORALES **/
elseif ($section == 'acc-laboral' and ($_admin or $_acclaboral or $_calidad)):
	if ($sbs == 'createacc'):
		include('accidentes/create-accident.php');
	elseif ($sbs == 'manageacc'):
		include 'accidentes/manage-accidents.php';
	elseif ($sbs == 'editacc'):
		include 'accidentes/edit-accident.php';
	else:
		include 'src/error.php';
	endif;
/** MEDIA **/
elseif ($section == 'media'):
	include 'media/media-index.php';
/** COVID **/
elseif ($section == 'covid'):
	include 'covid/covid-index.php';
/** PERFIL DE USUARIO **/
elseif ($section == 'adminusers' and $_login):
	if ($sbs == 'editprofile'):
		include 'admin/users/edit-profile.php';
	elseif ($sbs == 'changepass'):
		include 'admin/users/change-password.php';
	else:
		include 'src/error.php';
	endif;
/** USUARIOS **/
elseif ($section == 'users' and ($_admin or $_calidad)):
	if ($sbs == 'createuser'):
		include 'admin/users/create-user.php';
	elseif ($sbs == 'manageusers'):
		include 'admin/users/manage-users.php';
	elseif ($sbs == 'edituser'):
		include 'admin/users/edit-user.php';
	else:
		include 'src/error.php';
	endif;
/** DOCUMENTOS **/
elseif ($section == 'admin' and ($_admin or $_calidad)):
	if ($sbs == 'verifdoc'):
		include 'files/uploadverif.php';
	elseif ($sbs == 'otherdoc'):
		include 'files/uploadother.php';
	elseif ($sbs == 'managefiles'):
		include 'admin/files/manage-files.php';
	elseif ($sbs == 'editfile'):
		include 'admin/files/edit-file.php';
	elseif ($sbs == 'manageotherfiles'):
		include 'admin/files/manage-other-files.php';
	elseif ($sbs == 'editotherfile'):
		include 'admin/files/edit-other-file.php';
	else:
		include 'src/error.php';
	endif;
/** CARPETAS **/
elseif ($section == 'folders' and ($_admin or $_calidad)):
	if ($sbs == 'createfolder'):
		include 'admin/folders/create-folder.php';
	elseif ($sbs == 'managefolders'):
		include 'admin/folders/manage-folders.php';
	elseif ($sbs == 'editfolder'):
		include 'admin/folders/edit-folder.php';
	else:
		include 'src/error.php';
	endif;
elseif ($section == 'forgotpass'):
	include 'admin/users/retrieve-password.php';
elseif ($section == 'managers'):
	include 'main/managers.php';
elseif ($section == 'about'):
	include 'main/about.php';
else:
	include 'src/error.php';
endif;
