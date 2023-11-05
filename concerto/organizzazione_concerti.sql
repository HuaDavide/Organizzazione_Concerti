create database if not exists organizzazione_concerti;

use organizzazione_concerti;

create table if not exists sale(
	id int auto_increment primary key,
	codice varchar(10),
	nome varchar(50),
	capienza int
);

create table if not exists orchestre(
	id int auto_increment primary key,
	nome varchar(10),
	direttore varchar(50)
);

create table if not exists concerti(
	id int auto_increment primary key,
	codice varchar(10),
	titolo varchar(50),
	descrizione varchar(255),
	data datetime,
	sala_id int,
	orchestra_id int
);

alter table concerti 
add foreign key (sala_id) references sale(id),
add foreign key (orchestra_id) references orchestre(id);

create table if not exists pezzi(
	id int auto_increment primary key,
	codice varchar(10),
	titolo varchar(50)
);

create table if not exists concerti_pezzi(
	concerto_id int,
	pezzo_id int
)

alter table concerti_pezzi
add foreign key (concerto_id) references concerti(id),
add foreign key (pezzo_id) references pezzi(id);

insert into sale(codice, nome, capienza) values
('AB12', 'Sala 1', "1000"),
('BD64', 'Sala 2', "5000"),
('LM14', 'Sala 3', "20000");

insert into pezzi(codice, titolo) values
('LM10', 'PIOGGIA'),
('WMK22', 'SOLE'),
('BULUBULU', 'NEVE');

insert into concerti(codice, titolo) values
('a', 'abc'),
('b', 'qaz'),
('c', 'lmk');

insert into concerti_pezzi(concerto_id, pezzo_id) values
(1, 2),
(1, 3),
(2, 3),
(3, 1);

select p.*
from pezzi p 
inner join concerti_pezzi cp ON cp.pezzo_id = p.id
where cp.concerto_id = 1;
