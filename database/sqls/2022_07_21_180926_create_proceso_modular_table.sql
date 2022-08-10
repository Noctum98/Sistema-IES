create table proceso_modular
(
    id                          bigint unsigned auto_increment
        primary key,
    promedio_final_porcentaje   int unsigned          null,
    promedio_final_nota         double(8, 2) unsigned null,
    ponderacion_promedio_final  int unsigned          null,
    trabajo_final_porcentaje    int unsigned          null,
    trabajo_final_nota          double(8, 2) unsigned null,
    ponderacion_trabajo_final   int unsigned          null,
    nota_final_porcentaje       int unsigned          null,
    nota_final_nota             double(8, 2) unsigned null,
    cierre                      tinyint(1) default 0  not null,
    proceso_id                  bigint unsigned       null,
    operador_id                 bigint unsigned       null,
    created_at                  timestamp             null,
    updated_at                  timestamp             null,
    asistencia_final_porcentaje double(8, 2) unsigned null
)
    collate = utf8mb4_unicode_ci;