alter table `alumnos` add `fecha_primera_acreditacion` varchar(191) null after `pase`, add `fecha_ultima_acreditacion` varchar(191) null after `fecha_primera_acreditacion`;
alter table `proceso_modular` add `asistencia_final_porcentaje` double(8, 2) unsigned null;
alter table `materias` add `regimen` varchar(191) null after `nombre`;
alter table `proceso_modular` add `asistencia_practica_profesional` double(8, 2) unsigned null;
