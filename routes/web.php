<?php
//================== Index ============================
Route::get('/', 'MpController@index')->name('inicio');
Route::get('login', 'MpController@login')->name('login');
Route::get('login/{cc}', 'MpController@logear_sinproc')->name('login_sinproc');
Route::get('logout', 'MpController@logout')->name('logout');
Route::post('logear', 'MpController@logear')->name('logear');


//================== WS SINPROC ============================
    //========== GETs ==========
    Route::get('wsinproc/actuacion/{tipo_mp}/{respuesta}', 'MpController@sinproc_actuacion')->name('sinproc_actuacion');
    Route::get('wsinproc/remision/{tipo_mp}/{respuesta}', 'MpController@sinproc_remision')->name('sinproc_remision');
    Route::get('wsinproc/archivo/{tipo_mp}/{respuesta}', 'MpController@sinproc_archivo')->name('sinproc_archivo');
    //========== POSTs ==========
    Route::post('wsinproc/sinproc_detalle', 'MpController@sinproc_detalle')->name('sinproc_detalle');
    Route::post('wsinproc/sinproc_modal_act', 'MpController@sinproc_modal_act')->name('sinproc_modal_act');
    Route::post('wsinproc/sinproc_modal_rem', 'MpController@sinproc_modal_rem')->name('sinproc_modal_rem');
    Route::post('wsinproc/sinproc_jefe_delegada', 'MpController@sinproc_jefe_delegada')->name('sinproc_jefe_delegada');
    Route::post('wsinproc/sinproc_modal_arc', 'MpController@sinproc_modal_arc')->name('sinproc_modal_arc');
    Route::post('wsinproc/sinproc_modal_hist', 'MpController@sinproc_modal_hist')->name('sinproc_modal_hist');

//================== Penales 1 ============================
    //========== GETs ==========
    Route::get('penales1/oficio', 'MPPenales1Controller@oficio')->name('penales1_oficio');
    Route::get('penales1/archivo/{archivo}', 'MPPenales1Controller@archivo')->name('penales1_archivo');
    Route::get('penales1/archivo_enteramientos/{archivo}', 'MPPenales1Controller@archivo_enteramientos')->name('penales1_archivo_enteramientos');
    Route::get('penales1/parte', 'MPPenales1Controller@parte')->name('penales1_parte');
    Route::get('penales1/enteramientos', 'MPPenales1Controller@enteramientos')->name('penales1_enteramientos');
    Route::get('penales1/agencias', 'MPPenales1Controller@agencias')->name('penales1_agencias');
    //========== POSTs ==========
    Route::post('penales1/oficio/guardar', 'MPPenales1Controller@oficio_guardar')->name('penales1_oficio_guardar');
    Route::post('penales1/parte/guardar', 'MPPenales1Controller@parte_guardar')->name('penales1_parte_guardar');
    Route::post('penales1/enteramientos/guardar', 'MPPenales1Controller@enteramientos_guardar')->name('penales1_enteramientos_guardar');
    Route::post('penales1/agencias/intervencion/guardar', 'MPPenales1Controller@agencias_intervencion_guardar')->name('penales1_agencias_intervencion_guardar');
    Route::post('penales1/agencias/informe/guardar', 'MPPenales1Controller@agencias_informe_guardar')->name('penales1_agencias_informe_guardar');
    Route::post('penales1/parte/guardar_act_sinproc', 'MPPenales1Controller@parte_guardar_act_sinproc')->name('penales1_parte_guardar_act_sinproc');
    //========== AJAXs Listas ==========
    Route::post('penales1/oficio/actuaciones', 'MPPenales1Controller@oficio_actuaciones')->name('penales1_oficio_actuaciones');
    Route::post('penales1/parte/actuaciones', 'MPPenales1Controller@parte_actuaciones')->name('penales1_parte_actuaciones');
    Route::post('penales1/oficio/cambio_tipo_actuacion', 'MPPenales1Controller@cambio_tipo_actuacion')->name('penales1_oficio_cambio_tipo_actuacion');
    Route::post('penales1/enteramientos/listas', 'MPPenales1Controller@enteramientos_listas')->name('penales1_enteramientos_listas');
    Route::post('penales1/agencias/tabla', 'MPPenales1Controller@agencias_tabla')->name('penales1_agencias_tabla');
    //========== AJAXs Modals ==========
    Route::post('penales1/oficio/modal', 'MPPenales1Controller@oficio_modal')->name('penales1_oficio_modal');
    Route::post('penales1/oficio/modal_ver', 'MPPenales1Controller@oficio_modal_ver')->name('penales1_oficio_modal_ver');
    Route::post('penales1/parte/modal', 'MPPenales1Controller@parte_modal')->name('penales1_parte_modal');
    Route::post('penales1/parte/modal_ver', 'MPPenales1Controller@parte_modal_ver')->name('penales1_parte_modal_ver');
    Route::post('penales1/enteramientos/modal', 'MPPenales1Controller@enteramientos_modal')->name('penales1_enteramientos_modal');
    Route::post('penales1/agencias/intervencion', 'MPPenales1Controller@agencias_intervencion')->name('penales1_agencias_intervencion');
    Route::post('penales1/agencias/intervenciones', 'MPPenales1Controller@agencias_intervenciones')->name('penales1_agencias_intervenciones');
    Route::post('penales1/agencias/informe', 'MPPenales1Controller@agencias_informe')->name('penales1_agencias_informe');
    Route::post('penales1/agencias/informes', 'MPPenales1Controller@agencias_informes')->name('penales1_agencias_informes');
    Route::post('penales1/agencias/informe_ver', 'MPPenales1Controller@agencias_informe_ver')->name('penales1_agencias_informe_ver');
    
//================== Penales 2 ============================
    //========== GETs ==========
    Route::get('penales2/oficio', 'MPPenales2Controller@oficio')->name('penales2_oficio');
    Route::get('penales2/archivo/{archivo}', 'MPPenales2Controller@archivo')->name('penales2_oficio_archivo');
    Route::get('penales2/archivo_enteramientos/{archivo}', 'MPPenales2Controller@archivo_enteramientos')->name('penales2_archivo_enteramientos');
    Route::get('penales2/parte', 'MPPenales2Controller@parte')->name('penales2_parte');
    Route::get('penales2/enteramientos', 'MPPenales2Controller@enteramientos')->name('penales2_enteramientos');
    Route::get('penales2/agencias', 'MPPenales2Controller@agencias')->name('penales2_agencias');
    //========== POSTs ==========
    Route::post('penales2/oficio/guardar', 'MPPenales2Controller@oficio_guardar')->name('penales2_oficio_guardar');
    Route::post('penales2/parte/guardar', 'MPPenales2Controller@parte_guardar')->name('penales2_parte_guardar');
    Route::post('penales2/enteramientos/guardar', 'MPPenales2Controller@enteramientos_guardar')->name('penales2_enteramientos_guardar');
    Route::post('penales2/agencias/intervencion/guardar', 'MPPenales2Controller@agencias_intervencion_guardar')->name('penales2_agencias_intervencion_guardar');
    Route::post('penales2/agencias/informe/guardar', 'MPPenales2Controller@agencias_informe_guardar')->name('penales2_agencias_informe_guardar');
    Route::post('penales2/parte/guardar_act_sinproc', 'MPPenales2Controller@parte_guardar_act_sinproc')->name('penales2_parte_guardar_act_sinproc');
    //========== AJAXs Listas ==========
    Route::post('penales2/oficio/actuaciones', 'MPPenales2Controller@oficio_actuaciones')->name('penales2_oficio_actuaciones');
    Route::post('penales2/parte/actuaciones', 'MPPenales2Controller@parte_actuaciones')->name('penales2_parte_actuaciones');
    Route::post('penales2/oficio/cambio_tipo_actuacion', 'MPPenales2Controller@cambio_tipo_actuacion')->name('penales2_oficio_cambio_tipo_actuacion');
    Route::post('penales2/enteramientos/listas', 'MPPenales2Controller@enteramientos_listas')->name('penales2_enteramientos_listas');
    Route::post('penales2/agencias/tabla', 'MPPenales2Controller@agencias_tabla')->name('penales2_agencias_tabla');
    //========== AJAXs Modals ==========
    Route::post('penales2/oficio/modal', 'MPPenales2Controller@oficio_modal')->name('penales2_oficio_modal');
    Route::post('penales2/oficio/modal_ver', 'MPPenales2Controller@oficio_modal_ver')->name('penales2_oficio_modal_ver');
    Route::post('penales2/parte/modal', 'MPPenales2Controller@parte_modal')->name('penales2_parte_modal');
    Route::post('penales2/parte/modal_ver', 'MPPenales2Controller@parte_modal_ver')->name('penales2_parte_modal_ver');
    Route::post('penales2/enteramientos/modal', 'MPPenales2Controller@enteramientos_modal')->name('penales2_enteramientos_modal');
    Route::post('penales2/agencias/intervencion', 'MPPenales2Controller@agencias_intervencion')->name('penales2_agencias_intervencion');
    Route::post('penales2/agencias/intervenciones', 'MPPenales2Controller@agencias_intervenciones')->name('penales2_agencias_intervenciones');
    Route::post('penales2/agencias/informe', 'MPPenales2Controller@agencias_informe')->name('penales2_agencias_informe');
    Route::post('penales2/agencias/informes', 'MPPenales2Controller@agencias_informes')->name('penales2_agencias_informes');
    Route::post('penales2/agencias/informe_ver', 'MPPenales2Controller@agencias_informe_ver')->name('penales2_agencias_informe_ver');

//================== Movilidad ============================
    //========== GETs ==========
    Route::get('movilidad/oficio', 'MPPolicivosController@movilidad_oficio')->name('movilidad_oficio');
    Route::get('policivos/archivo/{archivo}', 'MPPolicivosController@policivos_archivo')->name('policivos_archivo');
    Route::get('policivos/archivo_notificaciones/{archivo}', 'MPPolicivosController@policivos_archivo_notificaciones')->name('policivos_archivo_notificaciones');
    Route::get('movilidad/parte', 'MPPolicivosController@movilidad_parte')->name('movilidad_parte');
    Route::get('movilidad/notificaciones', 'MPPolicivosController@movilidad_notificaciones')->name('movilidad_notificaciones');
    //========== POSTs ==========
    Route::post('movilidad/oficio/guardar', 'MPPolicivosController@movilidad_oficio_guardar')->name('movilidad_oficio_guardar');
    Route::post('movilidad/parte/guardar', 'MPPolicivosController@movilidad_parte_guardar')->name('movilidad_parte_guardar');
    Route::post('movilidad/enteramientos/guardar', 'MPPolicivosController@movilidad_notificaciones_guardar')->name('movilidad_enteramientos_guardar');
    Route::post('policivos/guardar_act_sinproc', 'MPPolicivosController@parte_guardar_act_sinproc')->name('policivos_parte_guardar_act_sinproc');
    //========== AJAXs Listas ==========
    Route::post('movilidad/oficio/actuaciones', 'MPPolicivosController@movilidad_oficio_actuaciones')->name('movilidad_oficio_actuaciones');
    Route::post('movilidad/parte/actuaciones', 'MPPolicivosController@movilidad_parte_actuaciones')->name('movilidad_parte_actuaciones');
    Route::post('movilidad/oficio/cambio_tipo_actuacion', 'MPPolicivosController@movilidad_cambio_tipo_actuacion')->name('movilidad_oficio_cambio_tipo_actuacion');
    Route::post('movilidad/notificaciones/listas', 'MPPolicivosController@movilidad_notificaciones_listas')->name('movilidad_notificaciones_listas');
    //========== AJAXs Modals ==========
    Route::post('movilidad/oficio/modal', 'MPPolicivosController@movilidad_oficio_modal')->name('movilidad_oficio_modal');
    Route::post('movilidad/oficio/modal_ver', 'MPPolicivosController@movilidad_oficio_modal_ver')->name('movilidad_oficio_modal_ver');
    Route::post('movilidad/parte/modal', 'MPPolicivosController@movilidad_parte_modal')->name('movilidad_parte_modal');
    Route::post('movilidad/parte/modal_ver', 'MPPolicivosController@movilidad_parte_modal_ver')->name('movilidad_parte_modal_ver');
    Route::post('movilidad/notificaciones/modal', 'MPPolicivosController@movilidad_notificaciones_modal')->name('movilidad_notificaciones_modal');

//================== Juzgados ============================
    //========== GETs ==========
    Route::get('juzgados/oficio', 'MPPolicivosController@juzgados_oficio')->name('juzgados_oficio');
    Route::get('juzgados/parte', 'MPPolicivosController@juzgados_parte')->name('juzgados_parte');
    Route::get('juzgados/notificaciones', 'MPPolicivosController@juzgados_notificaciones')->name('juzgados_notificaciones');
    //========== POSTs ==========
    Route::post('juzgados/oficio/guardar', 'MPPolicivosController@juzgados_oficio_guardar')->name('juzgados_oficio_guardar');
    Route::post('juzgados/parte/guardar', 'MPPolicivosController@juzgados_parte_guardar')->name('juzgados_parte_guardar');
    Route::post('juzgados/notificaciones/guardar', 'MPPolicivosController@juzgados_notificaciones_guardar')->name('juzgados_notificaciones_guardar');
    //========== AJAXs Listas ==========
    Route::post('juzgados/oficio/actuaciones', 'MPPolicivosController@juzgados_oficio_actuaciones')->name('juzgados_oficio_actuaciones');
    Route::post('juzgados/parte/actuaciones', 'MPPolicivosController@juzgados_parte_actuaciones')->name('juzgados_parte_actuaciones');
    Route::post('juzgados/oficio/cambio_tipo_actuacion', 'MPPolicivosController@juzgados_cambio_tipo_actuacion')->name('juzgados_oficio_cambio_tipo_actuacion');
    Route::post('juzgados/notificaciones/listas', 'MPPolicivosController@juzgados_notificaciones_listas')->name('juzgados_notificaciones_listas');
    //========== AJAXs Modals ==========
    Route::post('juzgados/oficio/modal', 'MPPolicivosController@juzgados_oficio_modal')->name('juzgados_oficio_modal');
    Route::post('juzgados/oficio/modal_ver', 'MPPolicivosController@juzgados_oficio_modal_ver')->name('juzgados_oficio_modal_ver');
    Route::post('juzgados/parte/modal', 'MPPolicivosController@juzgados_parte_modal')->name('juzgados_parte_modal');
    Route::post('juzgados/parte/modal_ver', 'MPPolicivosController@juzgados_parte_modal_ver')->name('juzgados_parte_modal_ver');
    Route::post('juzgados/notificaciones/modal', 'MPPolicivosController@juzgados_notificaciones_modal')->name('juzgados_notificaciones_modal');

//================== Segunda ============================
    //========== GETs ==========
    Route::get('segunda/oficio', 'MPPolicivosController@segunda_oficio')->name('segunda_oficio');
    Route::get('segunda/parte', 'MPPolicivosController@segunda_parte')->name('segunda_parte');
    Route::get('segunda/notificaciones', 'MPPolicivosController@segunda_notificaciones')->name('segunda_notificaciones');
    //========== POSTs ==========
    Route::post('segunda/oficio/guardar', 'MPPolicivosController@segunda_oficio_guardar')->name('segunda_oficio_guardar');
    Route::post('segunda/parte/guardar', 'MPPolicivosController@segunda_parte_guardar')->name('segunda_parte_guardar');
    Route::post('segunda/notificaciones/guardar', 'MPPolicivosController@segunda_notificaciones_guardar')->name('segunda_notificaciones_guardar');
    //========== AJAXs Listas ==========
    Route::post('segunda/oficio/actuaciones', 'MPPolicivosController@segunda_oficio_actuaciones')->name('segunda_oficio_actuaciones');
    Route::post('segunda/parte/actuaciones', 'MPPolicivosController@segunda_parte_actuaciones')->name('segunda_parte_actuaciones');
    Route::post('segunda/oficio/cambio_tipo_actuacion', 'MPPolicivosController@segunda_cambio_tipo_actuacion')->name('segunda_oficio_cambio_tipo_actuacion');
    Route::post('segunda/notificaciones/listas', 'MPPolicivosController@segunda_notificaciones_listas')->name('segunda_notificaciones_listas');
    //========== AJAXs Modals ==========
    Route::post('segunda/oficio/modal', 'MPPolicivosController@segunda_oficio_modal')->name('segunda_oficio_modal');
    Route::post('segunda/oficio/modal_ver', 'MPPolicivosController@segunda_oficio_modal_ver')->name('segunda_oficio_modal_ver');
    Route::post('segunda/parte/modal', 'MPPolicivosController@segunda_parte_modal')->name('segunda_parte_modal');
    Route::post('segunda/parte/modal_ver', 'MPPolicivosController@segunda_parte_modal_ver')->name('segunda_parte_modal_ver');
    Route::post('segunda/notificaciones/modal', 'MPPolicivosController@segunda_notificaciones_modal')->name('segunda_notificaciones_modal');


//================== Coordinador ============================
    //========== GETs ==========
    Route::get('coordinador', 'MPAgenciasController@inicio_coordinador')->name('coordinador_agencias');
    Route::get('agencias/generarword/{id}', 'MPGenerarWordController@agencias')->name('agencia_word');
    //========== POSTs ==========
    Route::post('coordinador/guardar', 'MPAgenciasController@guardar')->name('coordinador_guardar');
    Route::post('coordinador/finalizar/guardar', 'MPAgenciasController@finalizar_guardar')->name('coordinador_finalizar_guardar');
    //========== AJAXs Listas ==========
    Route::post('coordinador/tabla', 'MPAgenciasController@tabla')->name('coordinador_tabla');
    Route::post('coordinador/ministerio', 'MPAgenciasController@cambio_tipo_actuacion')->name('seleccionar_ministerio');
    //========== AJAXs Modals ==========
    Route::post('coordinador/modal', 'MPAgenciasController@modal_coordinador')->name('modal_coordinador_crear');
    Route::post('coordinador/editar', 'MPAgenciasController@modal_editar_coordinador')->name('modal_editar_coordinador');
    Route::post('coordinador/historial', 'MPAgenciasController@historial')->name('coordinador_historial');


//================== Estadisticas ============================
    //========== GETs ==========
    Route::get('estadisticas/informes', 'MPEstadisticasController@index')->name('estadisticas_informes');
    Route::post('estadisticas/informe/detalle', 'MPEstadisticasController@informe_detalle')->name('estadisticas_informe_detalle');
    //========== AJAXs Listas ==========
    Route::get('estadisticas/informes/lista', 'MPEstadisticasController@lista')->name('estadisticas_informes_lista');
    Route::post('estadisticas/informe/detalle1_datos', 'MPEstadisticasController@informe_detalle1_datos')->name('estadisticas_informe_detalle1_datos');
    Route::post('estadisticas/informe/detalle2_datos', 'MPEstadisticasController@informe_detalle2_datos')->name('estadisticas_informe_detalle2_datos');
    Route::post('estadisticas/informe/detalle3_datos', 'MPEstadisticasController@informe_detalle3_datos')->name('estadisticas_informe_detalle3_datos');
    Route::post('estadisticas/informe/detalle6_datos', 'MPEstadisticasController@informe_detalle6_datos')->name('estadisticas_informe_detalle6_datos');
    Route::post('estadisticas/informe/detalle7_datos', 'MPEstadisticasController@informe_detalle7_datos')->name('estadisticas_informe_detalle7_datos');
    //========== AJAXs Modals ==========
    Route::post('estadisticas/informe/general', 'MPEstadisticasController@informe_general')->name('estadisticas_informe_general');

//================== Gestión ============================
    //========== GETs ==========
    Route::get('gestion', 'MPGestionController@index')->name('gestion');
    Route::get('gestion/editar/{id}', 'MPGestionController@gestion_editar')->name('gestion_editar');
    //========== POSTs ==========
    Route::post('gestion/lista/guardar', 'MPGestionController@gestion_lista_guardar')->name('gestion_lista_guardar');
    //========== AJAXs Listas ==========
    Route::post('gestion/lista', 'MPGestionController@gestion_lista')->name('gestion_lista');
    Route::post('gestion/lista/editar', 'MPGestionController@gestion_lista_editar')->name('gestion_lista_editar');
    Route::post('gestion/lista/item', 'MPGestionController@gestion_lista_item')->name('gestion_lista_item');
    Route::post('gestion/lista/activar_desactivar', 'MPGestionController@gestion_lista_activar_desactivar')->name('gestion_lista_activar_desactivar');
    Route::post('gestion/lista/actuaciones_mp', 'MPGestionController@gestion_lista_actuaciones_mp')->name('gestion_lista_actuaciones_mp');
    Route::post('gestion/lista/actualizar_usuarios', 'MPGestionController@gestion_lista_actualizar_usuarios')->name('gestion_lista_actualizar_usuarios');

//================== Policivos ============================
    //========== GETs ==========
    Route::get('policivos/oficio', 'MPPolicivosController@policivos_oficio')->name('policivos_oficio');
    Route::get('policivos/parte', 'MPPolicivosController@policivos_parte')->name('policivos_parte');
    Route::get('policivos/notificaciones', 'MPPolicivosController@policivos_notificaciones')->name('policivos_notificaciones');