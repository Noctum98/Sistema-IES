alter table `asistencias_modulares` add `proceso_id` bigint unsigned null, add `materia_id` bigint unsigned null
alter table `asistencias_modulares` add constraint `asistencias_modulares_proceso_id_foreign` foreign key (`proceso_id`) references `procesos` (`id`)
alter table `asistencias_modulares` add constraint `asistencias_modulares_materia_id_foreign` foreign key (`materia_id`) references `materias` (`id`)
