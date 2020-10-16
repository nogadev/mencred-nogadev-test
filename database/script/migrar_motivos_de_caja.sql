-- CAJA REVIEW
-- 1 - Motivos de ingreso y egresos que son iguales
INSERT INTO daily_manager.movement_reasons 
(id, description)
SELECT 0, me.DESCRIPCION
from db_finis.MOTIVOS_INGRESO mi
join db_finis.MOTIVOS_EGRESO me on me.DESCRIPCION = mi.DESCRIPCION;

-- 2 - Se asocian los tipos de movimiento (ingreso y egreso) con los motivos 
INSERT INTO daily_manager.movement_reason_movement_type (movement_reason_id, movement_type_id) 
select id, 1 from daily_manager.movement_reasons;

INSERT INTO daily_manager.movement_reason_movement_type (movement_reason_id, movement_type_id) 
select id, 2 from daily_manager.movement_reasons;

-- 3 - Motivos de ingresos

INSERT INTO daily_manager.movement_reasons 
(id, description) 
select 2000 + db_finis.MOTIVOS_INGRESO.ID_MOTIVOS_INGRESO, db_finis.MOTIVOS_INGRESO.DESCRIPCION from db_finis.MOTIVOS_INGRESO
where db_finis.MOTIVOS_INGRESO.DESCRIPCION not in (select db_finis.MOTIVOS_EGRESO.DESCRIPCION from db_finis.MOTIVOS_EGRESO);

-- 4 - Asociamos los motivos con el tipo de movimiento ingreso
INSERT INTO daily_manager.movement_reason_movement_type 
(movement_reason_id, movement_type_id) 
select id, 1 from movement_reasons where id > 2000;

-- 5 - Motivos de egresos
INSERT INTO daily_manager.movement_reasons 
(id, description)  
select 3000 + db_finis.MOTIVOS_EGRESO.ID_MOTIVOS_EGRESO, db_finis.MOTIVOS_EGRESO.DESCRIPCION from db_finis.MOTIVOS_EGRESO
where db_finis.MOTIVOS_EGRESO.DESCRIPCION not in (select db_finis.MOTIVOS_INGRESO.DESCRIPCION from db_finis.MOTIVOS_INGRESO);

-- 6 - Asociamos los motivos al tipo de movimiento egreso
INSERT INTO daily_manager.movement_reason_movement_type 
(movement_reason_id, movement_type_id) 
select id, 2 from movement_reasons where id > 3000;

-- 7 - Tabla cashes con los id y fechas de las cajas
INSERT INTO daily_manager.cashes(id, date_of, balance)   
select db_finis.CAJA.ID_CAJA, db_finis.CAJA.FECHA, db_finis.CAJA.SALDO from db_finis.CAJA;

-- 8 - Ingresos
INSERT INTO daily_manager.cash_movements (cash_id, movementtype_id, amount, description, reference, `method`, movementreason_id)
(
select c.ID_CAJA, 1, MONTO, DETALLE, REFERENCIA, ti.DESCRIPCION,
if( ci.ID_MOTIVO_CAJA_INGRESOS = 4 , 1 ,
if( ci.ID_MOTIVO_CAJA_INGRESOS = 6 , 2 , 
if( ci.ID_MOTIVO_CAJA_INGRESOS = 5 , 3 , 
if( ci.ID_MOTIVO_CAJA_INGRESOS = 8 , 4 , 
if( ci.ID_MOTIVO_CAJA_INGRESOS = 14 , 5 , 
if( ci.ID_MOTIVO_CAJA_INGRESOS = 12 , 6 , 
if( ci.ID_MOTIVO_CAJA_INGRESOS = 15 , 7 , 
if( ci.ID_MOTIVO_CAJA_INGRESOS = 13 , 8 , ci.ID_MOTIVO_CAJA_INGRESOS + 2000
)))))))) as id_motivo
from db_finis.CAJA_INGRESOS ci 
join db_finis.CAJA c on c.FECHA = ci.FECHA
join db_finis.TIPO_INGRESOS ti on ti.ID_TIPO_INGRESOS = ci.ID_TIPO_INGRESOS
);

-- saldo de cajas anteriores
-- insert into cash_movements 
-- (select 0, id+1, 1 , 1, balance, concat('CAJA ANTERIOR ', date_format(date_of,'%d/%m/%Y')), '', '', now(),now(), null from cashes
-- where id < (select max(id) from cashes));

-- 9 - Egresos
INSERT INTO daily_manager.cash_movements (cash_id, movementtype_id, amount, description, reference, `method`, movementreason_id)
(
select c.ID_CAJA, 2, IMPORTE, left(DETALLE,191) detalle, null, '',
if( ci.ID_MOTIVOS_EGRESO = 9 , 1 ,
if( ci.ID_MOTIVOS_EGRESO = 50 , 2 , 
if( ci.ID_MOTIVOS_EGRESO = 51 , 3 , 
if( ci.ID_MOTIVOS_EGRESO = 96 , 4 , 
if( ci.ID_MOTIVOS_EGRESO = 117 , 5 , 
if( ci.ID_MOTIVOS_EGRESO = 123 , 6 , 
if( ci.ID_MOTIVOS_EGRESO = 134 , 7 , 
if( ci.ID_MOTIVOS_EGRESO = 147 , 8 , ci.ID_MOTIVOS_EGRESO+3000
)))))))) as id_motivo
from db_finis.CAJA_EGRESOS ci 
join db_finis.CAJA c on c.FECHA = ci.FECHA
);