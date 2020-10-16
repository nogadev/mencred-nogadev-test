SET FOREIGN_KEY_CHECKS=0;

INSERT INTO countries (id,name,created_at,updated_at)
SELECT db_finis.PAIS.ID_PAIS,db_finis.PAIS.NOMBRE,now(),now()
FROM db_finis.PAIS where db_finis.PAIS.HAB=1;

INSERT INTO provinces (id,name,country_id,created_at,updated_at)
SELECT db_finis.PROVINCIA.ID_PROVINCIA,db_finis.PROVINCIA.NOMBRE,db_finis.PROVINCIA.ID_PAIS,now(),now()
FROM db_finis.PROVINCIA where db_finis.PROVINCIA.HAB=1;

INSERT INTO districts (id,name,province_id,created_at,updated_at)
SELECT db_finis.DEPARTAMENTO.ID_DEPARTAMENTO,db_finis.DEPARTAMENTO.NOMBRE,db_finis.DEPARTAMENTO.ID_PROVINCIA,now(),now()
FROM db_finis.DEPARTAMENTO where db_finis.DEPARTAMENTO.HAB=1;

INSERT INTO towns (id,name,district_id,created_at,updated_at)
SELECT db_finis.LOCALIDAD.ID_LOCALIDAD,db_finis.LOCALIDAD.NOMBRE,db_finis.LOCALIDAD.ID_DEPARTAMENTO,now(),now()
FROM db_finis.LOCALIDAD;

INSERT INTO neighborhoods (id,name,town_id,created_at,updated_at)
SELECT db_finis.BARRIO.ID_BARRIO,db_finis.BARRIO.NOMBRE,db_finis.BARRIO.ID_LOCALIDAD,now(),now()
FROM db_finis.BARRIO;

INSERT INTO visit_days (id,name,created_at,updated_at)
SELECT db_finis.DIA_VISITA.ID_DIA_VISITA,db_finis.DIA_VISITA.DESCRIPCION,now(),now()
FROM db_finis.DIA_VISITA where db_finis.DIA_VISITA.HAB=1;

INSERT INTO commerces (id,name,created_at,updated_at)
SELECT db_finis.COMERCIO.ID_COMERCIO,db_finis.COMERCIO.NOMBRE,now(),now()
FROM db_finis.COMERCIO where db_finis.COMERCIO.HAB=1;

INSERT into companies (id,name,created_at,updated_at) values (0,'PLAYCEMA',now(),now());
INSERT into companies (id,name,created_at,updated_at) values (0,'MENCRED',now(),now());
INSERT into companies (id,name,created_at,updated_at) values (0,'REMITO',now(),now());

insert into stores (id,name,created_at,updated_at) values (0,'GENERAL',now(),now());
 -- DEPOSITO COMERCIAL
 -- insert into stores (id,name,created_at,updated_at) values (0,'COMERCIAL',now(),now());

INSERT INTO sellers (id,name,goal,created_at,updated_at)
SELECT db_finis.VENDEDOR.ID_VENDEDOR,db_finis.VENDEDOR.NOMBRE,db_finis.VENDEDOR.META,now(),now()
FROM db_finis.VENDEDOR;

INSERT INTO deliveries (id,name,created_at,updated_at)
SELECT db_finis.ENTREGA.ID_ENTREGA,db_finis.ENTREGA.NOMBRE,now(),now()
FROM db_finis.ENTREGA where db_finis.ENTREGA.HAB=1;

INSERT INTO routes (id,name,created_at,updated_at)
SELECT db_finis.RECORRIDO.ID_RECORRIDO,db_finis.RECORRIDO.NOMBRE,now(),now()
FROM db_finis.RECORRIDO where db_finis.RECORRIDO.HAB=1;

INSERT INTO kinships (id,name,created_at,updated_at)
SELECT db_finis.PARENTESCO.ID_PARENTESCO,db_finis.PARENTESCO.NOMBRE,now(),now()
FROM db_finis.PARENTESCO where db_finis.PARENTESCO.HAB=1;

INSERT INTO article_categories (id,name,created_at,updated_at) values (0,'SIN ASIGNAR',now(),now());

INSERT INTO articles (id,description,print_name,price,fee_quantity,fee_amount,article_category_id,created_at,updated_at, trademark, model, available, price_update_level, commission, deleted_at)
select a.ID_ARTICULO,c.DESCRIPCION,c.NOMBRE_IMPRESO,TRUNCATE(c.PRECIO_VENTA,2),c.CANTIDAD_CUOTAS,c.IMPORTE_CUOTA,1,now(),now(),c.MARCA, c.MODELO, c.DISPONIBLE, c.CODIGO_BARRA, c.COMISION_VENTA, 
CASE c.HAB  
  when 0 then now()
  when 1 then null
END as deleted_at
from db_finis.CREDITO_DETALLE a
join db_finis.CREDITO b on  b.ID_CREDITO=a.ID_CREDITO
join db_finis.ARTICULO c on c.ID_ARTICULO=a.ID_ARTICULO
group by a.ID_ARTICULO;

-- ARTICLES PLAYCEMA
INSERT INTO article_stocks (id,article_id,store_id,company_id,stock,created_at,updated_at)
select 0,a.ID_ARTICULO,1,1,TRUNCATE(c.STOCK_REAL,2),now(),now()
from db_finis.CREDITO_DETALLE a
join db_finis.CREDITO b on  b.ID_CREDITO=a.ID_CREDITO
join db_finis.ARTICULO c on c.ID_ARTICULO=a.ID_ARTICULO
where DESCRIPCION like '%(P#)%' 
OR DESCRIPCION like '%(P&)%'
OR DESCRIPCION like '%(P%'
group by a.ID_ARTICULO;

-- ARTICLES MENCRED
INSERT INTO article_stocks (id,article_id,store_id,company_id,stock,created_at,updated_at)
select 0,a.ID_ARTICULO,1,2,TRUNCATE(c.STOCK_REAL,2),now(),now()
from db_finis.CREDITO_DETALLE a
join db_finis.CREDITO b on  b.ID_CREDITO=a.ID_CREDITO
join db_finis.ARTICULO c on c.ID_ARTICULO=a.ID_ARTICULO
where DESCRIPCION like '%(M#)%'
OR DESCRIPCION like '%(M&)%'
OR DESCRIPCION like '%(M%'
group by a.ID_ARTICULO;

-- ARTICLES REMITO
INSERT INTO article_stocks (id,article_id,store_id,company_id,stock,created_at,updated_at)
select 0,a.ID_ARTICULO,1,3,TRUNCATE(c.STOCK_REAL,2),now(),now()
from db_finis.CREDITO_DETALLE a
join db_finis.CREDITO b on  b.ID_CREDITO=a.ID_CREDITO
join db_finis.ARTICULO c on c.ID_ARTICULO=a.ID_ARTICULO
where DESCRIPCION like '%(*)%'
group by a.ID_ARTICULO;

-- ARTICLES WITHOUT COMPANY - POR EL MOMENTO SE LO ASIGNAMOS A REMITO / VERIFICARLO
INSERT INTO article_stocks (id,article_id,store_id,company_id,stock,created_at,updated_at)
select 0,a.ID_ARTICULO,1,3,TRUNCATE(c.STOCK_REAL,2),now(),now()
from db_finis.CREDITO_DETALLE a
join db_finis.CREDITO b on  b.ID_CREDITO=a.ID_CREDITO
join db_finis.ARTICULO c on c.ID_ARTICULO=a.ID_ARTICULO
where DESCRIPCION not like '%(*)%' 
AND DESCRIPCION not like '%(P#)%' 
AND DESCRIPCION not like '%(P&)%' 
AND DESCRIPCION not like '%(P%'
AND DESCRIPCION not like '%(M#)%'
AND DESCRIPCION not like '%(M&)%'
AND DESCRIPCION not like '%(M%'
group by a.ID_ARTICULO;

INSERT INTO point_of_sales (id,name,created_at,updated_at) values (0,'GENERAL',now(),now());
INSERT INTO point_of_sales (id,name,created_at,updated_at) values (0,'P. LISTA',now(),now());

-- NUEVOS PRECIOS DE PUNTO DE VENTA
/*INSERT INTO article_prices (id,article_id,point_of_sales_id,price,fee_quantity,fee_amount,created_at,updated_at)
select 0,a.ID_ARTICULO,1,TRUNCATE(c.PRECIO_VENTA,2),c.CANTIDAD_CUOTAS,c.IMPORTE_CUOTA,now(),now() 
from db_finis.CREDITO_DETALLE a
join db_finis.CREDITO b on  b.ID_CREDITO=a.ID_CREDITO
join db_finis.ARTICULO c on c.ID_ARTICULO=a.ID_ARTICULO
group by a.ID_ARTICULO;*/

-- DEPOSITO COMERCIAL
/*INSERT INTO article_stocks (id,article_id,store_id,company_id,stock,price,fee_quantity,fee_amount,created_at,updated_at)
select 0,a.ID_ARTICULO,2,1,0,TRUNCATE(c.PRECIO_VENTA,2),c.CANTIDAD_CUOTAS,c.IMPORTE_CUOTA,now(),now() 
from db_finis.CREDITO_DETALLE a
join db_finis.CREDITO b on  b.ID_CREDITO=a.ID_CREDITO
join db_finis.ARTICULO c on c.ID_ARTICULO=a.ID_ARTICULO
group by a.ID_ARTICULO;*/

/*INSERT INTO `voucher_types` VALUES (1,'001','FACTURA A','FC-A',NULL,NULL),
(2,'002','NOTA DE DEBITO A','ND-A',NULL,NULL),
(3,'003','NOTA DE CREDITO A','NC-A',NULL,NULL),
(4,'004','RECIBO A','RB-A',NULL,NULL),
(5,'005','FACTURA B','FC-B',NULL,NULL),
(6,'006','NOTA DE DEBITO B','ND-B',NULL,NULL),
(7,'007','NOTA DE CREDITO B','NC-B',NULL,NULL),
(8,'008','RECIBO B','RB-B',NULL,NULL),
(9,'009','FACTURA C','FC-C',NULL,NULL),
(10,'010','NOTA DE DEBITO C','ND-C',NULL,NULL),
(11,'011','NOTA DE CREDITO C','NC-C',NULL,NULL),
(12,'012','RECIBO C','RB-C',NULL,NULL),
(13,'996', 'FACTURA X', 'FC-X',NULL,NULL),
(14,'997', 'NOTA DE DEBITO X', 'ND-X',NULL,NULL),
(15,'998', 'NOTA DE CREDITO X', 'NC-X',NULL,NULL),
(16,'999', 'RECIBO X', 'RB-X',NULL,NULL);

INSERT INTO `taxes` VALUES (1,'0%',0.00,NULL,NULL),
(2,'10,5%',10.50,NULL,NULL),
(3,'21%',21.00,NULL,NULL),
(4,'27%',27.00,NULL,NULL),
(5,'EXENTO',0.00,NULL,NULL);*/

/*INSERT INTO users (id,name,email,password,created_at,updated_at) 
values (0,'ADMINISTRADOR','admin@mencred.com','$2y$10$JC1zKhF31HiiKpIlIFzWiettDueRhjG6fB30oHuNcKZ5LUPQF1g4e',now(),now());*/

/*insert into status (id,status,created_at,updated_at) VALUES (1,'A CONFIRMAR',now(),now());
insert into status (id,status,created_at,updated_at) VALUES (2,'OPERANDO',now(),now());
insert into status (id,status,created_at,updated_at) VALUES (3,'CANCELADO',now(),now());
insert into status (id,status,created_at,updated_at) VALUES (4,'RECHAZADO',now(),now());
insert into status (id,status,created_at,updated_at) VALUES (5,'PAGARE',now(),now());
insert into status (id,status,created_at,updated_at) VALUES (6,'EN PROBLEMA',now(),now());*/

-- CUSTOMERS
INSERT INTO daily_manager.customers
(id, code, name, route_id, email, commerce_id, seller_id, commercial_address, 
commercial_district_id, commercial_town_id, commercial_neighborhood_id, 
commercial_between, personal_address, 
personal_district_id, personal_town_id, personal_neighborhood_id, 
personal_between, doc_number, birthday, horary, marital_status, partner, 
particular_tel, comercial_tel, contact_tel, cuit, contact, kinship_id, owner, observation, sequence_order, visitday_id ,created_at, updated_at)
SELECT db_finis.CLIENTE.ID_CLIENTE, db_finis.CLIENTE.ID_CLIENTE, db_finis.CLIENTE.NOMBRE, db_finis.CLIENTE.ID_RECORRIDO, db_finis.CLIENTE.EMAIL, db_finis.CLIENTE.ID_COMERCIO, 
db_finis.CLIENTE.ID_VENDEDOR, db_finis.CLIENTE.DIRECCION_COMERCIAL, 
db_finis.CLIENTE.DEPARTAMENTO_COMERCIAL_ID_DEPARTAMENTO, db_finis.CLIENTE.LOCALIDAD_COMERCIAL_ID_LOCALIDAD, db_finis.CLIENTE.BARRIO_COMERCIAL_ID_BARRIO,
db_finis.CLIENTE.CALLES_COMERCIAL, db_finis.CLIENTE.DIRECCION_PARTICULAR, 
db_finis.CLIENTE.DEPARTAMENTO_PARTICULAR_ID_DEPARTAMENTO, db_finis.CLIENTE.LOCALIDAD_PARTICULAR_ID_LOCALIDAD, db_finis.CLIENTE.BARRIO_PARTICULAR_ID_BARRIO, 
db_finis.CLIENTE.CALLES_PARTICULAR, db_finis.CLIENTE.DNI, db_finis.CLIENTE.FECHA_NACIMIENTO, db_finis.CLIENTE.HORARIO, db_finis.CLIENTE.ESTADO_CIVIL,
db_finis.CLIENTE.NOMBRE_CONYUGUE, db_finis.CLIENTE.TELEFONO_PARTICULAR, db_finis.CLIENTE.TELEFONO_COMERCIAL, db_finis.CLIENTE.TELEFONO_CONTACTO, db_finis.CLIENTE.CUIT, db_finis.CLIENTE.NOMBRE_CONTACTO,
db_finis.CLIENTE.ID_PARENTESCO, db_finis.CLIENTE.PROPIETARIO, db_finis.CLIENTE.OBSERVACION, db_finis.CLIENTE.ORDEN_VISITA, db_finis.CLIENTE.ID_DIA_VISITA, now(), now()
FROM db_finis.CLIENTE;

-- CREDITS
INSERT INTO credits (id, user_id, 
customer_id, seller_id, delivery_id, status_id,
guarantee, according, have_card, guarantee_date, card_date, 
init_date, confirm_date, fee_quantity, fee_amount, initial_payment, total_amount, 
unification, observation,
created_date, created_at, updated_at)
SELECT db_finis.CREDITO.ID_CREDITO, 1,
db_finis.CREDITO.ID_CLIENTE, db_finis.CREDITO.ID_VENDEDOR, db_finis.CREDITO.ID_ENTREGA,
CASE db_finis.CREDITO.ESTADO  
  when 'A CONFIRMAR' then 1
  when 'OPERANDO' then 2
  when 'PAGARE' then 3
  when 'CANCELADO' then 4
  when 'EN PROBLEMA' then 5
  when 'RECHAZADO' then 6  
END as status,
db_finis.CREDITO.ENTREGO_PAGARE, db_finis.CREDITO.RECIBE_CONFORME, db_finis.CREDITO.TIENE_TARJETA,  db_finis.CREDITO.FECHA_ENTREGA_PAGARE, db_finis.CREDITO.FECHA_ENTREGA_TARJETA,
db_finis.CREDITO.FECHA_INICIO, db_finis.CREDITO.FECHA_CONFIRMACION, db_finis.CREDITO.CANTIDAD_CUOTAS, db_finis.CREDITO.IMPORTE_CUOTA, db_finis.CREDITO.PAGO_INICIAL, db_finis.CREDITO.TOTAL,
db_finis.CREDITO.UNIFICACION, db_finis.CREDITO.OBSERVACION, 
db_finis.CREDITO.FECHA_ALTA,
now(),
now()
FROM db_finis.CREDITO;

-- ARTICLES CREDITS

-- ARTICLES PLAYCEMA
INSERT INTO daily_manager.article_credits (id, credit_id, article_id, store_id, company_id, point_of_sale_id,
price, quantity, serial_number, created_at, updated_at)
SELECT db_finis.CREDITO_DETALLE.ID_CREDITO_DETALLE, db_finis.CREDITO_DETALLE.ID_CREDITO, db_finis.CREDITO_DETALLE.ID_ARTICULO, 1, 1, 1,
db_finis.CREDITO_DETALLE.PRECIO, db_finis.CREDITO_DETALLE.CANTIDAD, db_finis.CREDITO_DETALLE.NUMERO_SERIE, now(), now()
FROM db_finis.CREDITO_DETALLE
JOIN db_finis.ARTICULO on db_finis.ARTICULO.ID_ARTICULO = db_finis.CREDITO_DETALLE.ID_ARTICULO
WHERE db_finis.ARTICULO.DESCRIPCION like '%(P#)%' 
OR db_finis.ARTICULO.DESCRIPCION like '%(P&)%'
OR db_finis.ARTICULO.DESCRIPCION like '%(P%';

-- ARTICLES MENCRED
INSERT INTO daily_manager.article_credits (id, credit_id, article_id, store_id, company_id, point_of_sale_id,
price, quantity, serial_number, created_at, updated_at)
SELECT db_finis.CREDITO_DETALLE.ID_CREDITO_DETALLE, db_finis.CREDITO_DETALLE.ID_CREDITO, db_finis.CREDITO_DETALLE.ID_ARTICULO, 1, 2, 1,
db_finis.CREDITO_DETALLE.PRECIO, db_finis.CREDITO_DETALLE.CANTIDAD, db_finis.CREDITO_DETALLE.NUMERO_SERIE, now(), now()
FROM db_finis.CREDITO_DETALLE
JOIN db_finis.ARTICULO on db_finis.ARTICULO.ID_ARTICULO = db_finis.CREDITO_DETALLE.ID_ARTICULO
WHERE db_finis.ARTICULO.DESCRIPCION like '%(M#)%' 
OR db_finis.ARTICULO.DESCRIPCION like '%(M&)%'
OR db_finis.ARTICULO.DESCRIPCION like '%(M%';

-- ARTICLES REMITO
INSERT INTO daily_manager.article_credits (id, credit_id, article_id, store_id, company_id, point_of_sale_id,
price, quantity, serial_number, created_at, updated_at)
SELECT db_finis.CREDITO_DETALLE.ID_CREDITO_DETALLE, db_finis.CREDITO_DETALLE.ID_CREDITO, db_finis.CREDITO_DETALLE.ID_ARTICULO, 1, 3, 1,
db_finis.CREDITO_DETALLE.PRECIO, db_finis.CREDITO_DETALLE.CANTIDAD, db_finis.CREDITO_DETALLE.NUMERO_SERIE, now(), now()
FROM db_finis.CREDITO_DETALLE
JOIN db_finis.ARTICULO on db_finis.ARTICULO.ID_ARTICULO = db_finis.CREDITO_DETALLE.ID_ARTICULO
WHERE db_finis.ARTICULO.DESCRIPCION like '%(*)%';

-- ARTICLES WITHOUT COMPANY - POR EL MOMENTO SE LO ASIGNAMOS A REMITO / VERIFICARLO
INSERT INTO daily_manager.article_credits (id, credit_id, article_id, store_id, company_id, point_of_sale_id,
price, quantity, serial_number, created_at, updated_at)
SELECT db_finis.CREDITO_DETALLE.ID_CREDITO_DETALLE, db_finis.CREDITO_DETALLE.ID_CREDITO, db_finis.CREDITO_DETALLE.ID_ARTICULO, 1, 3, 1,
db_finis.CREDITO_DETALLE.PRECIO, db_finis.CREDITO_DETALLE.CANTIDAD, db_finis.CREDITO_DETALLE.NUMERO_SERIE, now(), now()
FROM db_finis.CREDITO_DETALLE
JOIN db_finis.ARTICULO on db_finis.ARTICULO.ID_ARTICULO = db_finis.CREDITO_DETALLE.ID_ARTICULO
where db_finis.ARTICULO.DESCRIPCION not like '%(*)%' 
AND db_finis.ARTICULO.DESCRIPCION not like '%(P#)%' 
AND db_finis.ARTICULO.DESCRIPCION not like '%(P&)%' 
AND db_finis.ARTICULO.DESCRIPCION not like '%(P%'
AND db_finis.ARTICULO.DESCRIPCION not like '%(M#)%'
AND db_finis.ARTICULO.DESCRIPCION not like '%(M&)%'
AND db_finis.ARTICULO.DESCRIPCION not like '%(M%';

-- Verificar que no se inserta el ID de la cuota del FINIS

UPDATE db_finis.CREDITO_CUOTA set db_finis.CREDITO_CUOTA.FECHA_PAGADO=now() where db_finis.CREDITO_CUOTA.FECHA_PAGADO is null;

INSERT INTO daily_manager.fees
(credit_id, route_id, reason_id, `number`, paid_date, payment_amount, paid_amount, created_at, updated_at)
SELECT db_finis.CREDITO_CUOTA.ID_CREDITO, db_finis.COBRADOR .ID_COBRADOR , -- db_finis.CREDITO_CUOTA.ID_COBRADOR, 
CASE db_finis.CREDITO_CUOTA.MOTIVO  
  when 'SIN DINERO' then 1
  when 'CERRADO' then 2
  when 'SEMANAL' then 3
  when 'DIA POR MEDIO' then 4
  when 'PROBLEMA' then 5
  when 'ADELANTADO' then 6
  when 'OTRO' then 7
  else null
END as reason_id,
db_finis.CREDITO_CUOTA.NUMERO, db_finis.CREDITO_CUOTA.FECHA_PAGADO, db_finis.CREDITO_CUOTA.IMPORTE, db_finis.CREDITO_CUOTA.IMPORTE_PAGADO, now(), now()
FROM db_finis.CREDITO_CUOTA
JOIN db_finis.COBRADOR on db_finis.COBRADOR .ID_COBRADOR=db_finis.CREDITO_CUOTA.ID_COBRADOR;

-- VER TIPO DE RECLAMO ENUM
INSERT INTO daily_manager.claims
(credit_id, status_id, init_date, end_date, `type`, observation, created_at, updated_at)
SELECT db_finis.RECLAMO.ID_CREDITO, 
CASE db_finis.RECLAMO.ESTADO
  when 0 then 7
  when 1 then 8
  else 7
END as status_id,
db_finis.RECLAMO.FECHA_INICIO, db_finis.RECLAMO.FECHA_FIN, db_finis.RECLAMO.TIPO, 
db_finis.RECLAMO.OBSERVACION, now(),now()
FROM db_finis.RECLAMO;

-- TRAKING RECLAMO
INSERT INTO daily_manager.claim_trakings 
(claim_id, date_of, observation, created_at, updated_at)
SELECT db_finis.RECLAMO.ID_RECLAMO, db_finis.RECLAMO.FECHA_INICIO, db_finis.RECLAMO.OBSERVACION, now(),now()
FROM db_finis.RECLAMO;

-- GASTOS DE VENDEDORES
INSERT INTO daily_manager.expenses (expenseconcept_id, `date`, amount, seller_id)
SELECT CASE db_finis.GASTOS_VENDEDOR.CONCEPTO
  when 'Vales' then 2
  when 'Previsiones' then 1
  when 'Articulos' then 3
  when 'Creditos' then 4
  when 'Premios' then 5
  when 'Viaticos' then 6
  when 'Aguinaldo' then 7
  when 'Vacaciones' then 8
  when 'Retiro' then 9
END as CONCEPTO, db_finis.GASTOS_VENDEDOR.FECHA, db_finis.GASTOS_VENDEDOR.MONTO, db_finis.GASTOS_VENDEDOR.ID_VENDEDOR
FROM db_finis.GASTOS_VENDEDOR
WHERE db_finis.GASTOS_VENDEDOR.ID_VENDEDOR IS NOT NULL;

SET FOREIGN_KEY_CHECKS=1;