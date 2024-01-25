CREATE DATABASE bd_orthohand DEFAULT CHARACTER SET utf8; 

use bd_orthohand;

create table if not exists tb_tpoUsu
(id_tpoUsu int(5) not null auto_increment,
tpoUsu varchar(40) not null,
primary key (id_tpoUsu)) default charset = utf8;
insert into tb_tpoUsu (tpoUsu) values
('Fisioterapeuta'),
('Paciente'),
('Clinica');

create table users
(id_usuario int (5) not null auto_increment,
unique_id int (5) not null,
fname varchar(255) not null,
lname varchar(255) not null,
email varchar(255) not null,
password varchar(100) not null,
img varchar(400) not null,
status varchar (255),
primary key (id_usuario)
)default charset = utf8;

create table messages
(msg_id int (5) not null auto_increment,
incoming_msg_id int (8) not null,
outgoing_msg_id int (8) not null,
msg varchar(1000),
primary key(msg_id)
)default charset = utf8;

create table if not exists tb_usuarios
(id_usuario int(5) not null auto_increment,
email varchar(40) not null,
senha varchar(40) NOT NULL,
id_tpoUsu int(5) not null,
primary key (id_usuario),
constraint id_tpoUsu
	foreign key (id_tpoUsu) references tb_tpoUsu(id_tpoUsu)
) default charset = utf8;

CREATE TABLE if not exists tb_clinica
(id_clinica int(5) NOT NULL auto_increment,
nome varchar(40) NOT NULL,
cnpj char(14) NOT NULL,
telefone varchar(15) NOT NULL,
estado varchar(40) NOT NULL, 
cidade varchar(110) NOT NULL,
endereco varchar(110),
id_usuario int(5) not null,
img varchar(400),
PRIMARY KEY (id_clinica),
constraint fkc_id_usuario
	foreign key (id_usuario) references tb_usuarios(id_usuario)
) DEFAULT CHARSET = utf8;

CREATE TABLE if not exists tb_medico
(id_medico int(5) NOT NULL auto_increment,
nome varchar(40) NOT NULL,
cpf char(11) NOT NULL,
crefito char(6) NOT NULL, /* Exemplo de CRM: CRM/SP 123456 !!!! TROCAR PARA CREFITO !!!! -- Crefito é XXXX-XX */
dt_nascimento date not null,
genero varchar(20) not null,
ativo char(1) NOT NULL, /* Ver se está ativo ou inativo -- i, Inativo -- a, Ativo */
id_usuario int (5) not null,
id_clinica int (5) not null,
unique_id int(5),
img varchar(400),
PRIMARY KEY (id_medico),
constraint fkm_id_usuario
	foreign key (id_usuario) references tb_usuarios(id_usuario),
constraint fk_id_clinica
	foreign key (id_clinica) references tb_clinica(id_clinica)
) DEFAULT CHARSET = utf8;

CREATE TABLE if not exists tb_paciente
(id_paciente int NOT NULL auto_increment,
nome varchar(40) NOT NULL,
cpf char(11) NOT NULL,
dt_nascimento date not null,
genero varchar(20) not null,
naturalidade varchar(50) not null, /* Local de nascimento */
estado_civil varchar(25) not null,
ativo char(1) NOT NULL, /* Ver se está ativo ou inativo -- i, Inativo -- a, Ativo */
id_usuario int(5) not null,
id_medico int(5) not null,
unique_id int(5),
img varchar(400),
PRIMARY KEY (id_paciente),
constraint fkp_id_usuario 
	foreign key (id_usuario) references tb_usuarios(id_usuario),
constraint fk_id_medico
	foreign key (id_medico) references tb_medico(id_medico)
) DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS tb_consulta (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(220) DEFAULT NULL,
  color varchar(10) not NULL,
  start datetime not NULL,
  end datetime not NULL,
  ativo char(1) not null, /* Ver se está ativo ou inativo -- i, Inativo -- a, Ativo */
  id_medico int (5) not null,
  id_paciente int(5) not null,
  id_clinica int(5) not null,
  PRIMARY KEY (id),
  constraint fkc_id_medico
	foreign key(id_medico) references tb_medico(id_medico),
  constraint fkc_id_paciente
	foreign key(id_paciente) references tb_paciente(id_paciente),
  constraint fkc_id_clinica
	foreign key(id_clinica) references tb_clinica(id_clinica)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

create table if not exists tb_registro
(id_registro int(6) not null auto_increment,
historia_clinica tinytext not null, /* Diagnóstico do paciente - 1 vez */
exame_clinico_fisico tinytext not null, /* Exame clínico / Desrição do estado de saúde de acordo com a semiologia fisioterpêutica - 1 vez */
exames_complementares tinytext, /* Exames requisitados previamente solicitado pelo próprio fisioterapêuta - mais de uma vez */
plano_terapeutico tinytext, /* Descrição dos procedimentos fisioterapêuticos - quantidade de sessoes e com serao feitas */
id_medico int (5) not null,
id_paciente int(5) not null,
primary key(id_registro),
constraint fkr_id_medico
	foreign key(id_medico) references tb_medico(id_medico),
constraint fkr_id_paciente
	foreign key(id_paciente) references tb_paciente(id_paciente)
) default charset utf8;

create table if not exists tb_sessao(
id_sessao int(255) not null auto_increment,
diagnostico_fisio tinytext, /* Diagnóstico fisioterapêutico / Prognóstico do paciente - mais de uma vez, em relacao a ida do paciente na clinica, de acordo com a consulta */
evolucao_saude text,  /* Evolucao da saude do paciente -- Feito para enviar ao paciente - pode ser modificada tb, de acordo com a consulta */
dt_ultimo_registro date not null,
id_registro int (6) not null,
primary key(id_sessao),
constraint fks_id_registro
	foreign key(id_registro) references tb_registro(id_registro)
) default charset utf8;

create table tb_auditoria(
codigo int(5),
usuario varchar(45),
acao varchar(25), 
data_acao date,
hora_acao time,
Primary Key(codigo)
)default charset utf8;

insert into tb_usuarios (id_usuario, email, senha, id_tpoUsu) 
	values (1, "mu@gmail.com", 12345, 3),
    (2, "thiago@gmail.com", 12345, 2),
    (3, "eduardo@gmail.com", 12345, 2),
    (4, "camile@gmail.com", 12345, 2),
    (5, "caca@gmail.com", 12345, 2),
    (6, "felipe@gmail.com", 12345, 1),
    (7, "clarissa@gmail.com", 12345, 1),
    (8, "vanessa@gmail.com", 12345, 1),
    (9, "ortho@gmail.com", 12345, 3),
    (10, "lari@gmail.com", 12345, 1),
    (11, "emi@gmail.com", 12345, 2);

/*Clinica*/
insert into tb_clinica (nome, cnpj, telefone, estado, cidade, endereco, id_usuario, img)
	values ("OrthoFisio", 85880211000119, 13997321919, "SP", "São Vicente", "Av. Prestes Maia", 9, "orthofisio.png");
insert into tb_clinica (nome, cnpj, telefone, estado, cidade, endereco, id_usuario)
	values ("Caselatti's Clínica", 04780590000173, 13985328914, "SP", "Santos", "Av. Prestes Maia", 1);
    
/*Médicos*/
insert into tb_medico (nome, cpf, crefito, dt_nascimento, genero, ativo, id_usuario, id_clinica, unique_id, img)
	values ("Larissa Fernanda dos Santos", 62802642030, 123456, "2005-08-06", "Feminino", 'a', 10, 1, 24578, "larissa.jpeg");
insert into tb_medico (nome, cpf, crefito, dt_nascimento, genero, ativo, id_usuario, id_clinica, unique_id)
	values ("Felipe Silva Barroso", 87004927016, 465247, "1989-09-14", "Masculino", 'a', 6, 1, 21283);
insert into tb_medico (nome, cpf, crefito, dt_nascimento, genero, ativo, id_usuario, id_clinica, unique_id)
	values ("Clarissa Cezar Soares", 89079025003, 249853, "1990-11-24", "Feminino", 'a', 7, 2, 75462);
insert into tb_medico (nome, cpf, crefito, dt_nascimento, genero, ativo, id_usuario, id_clinica, unique_id)
	values ("Vanessa de Assis Moraes", 98101955089, 136966, "2001-12-30", "Feminino", 'a', 8, 1, 98765);
    
/*Pacientes*/
insert into tb_paciente (nome, cpf, dt_nascimento, genero, naturalidade, estado_civil, ativo, id_usuario, id_medico, unique_id, img)
	values("Emily Santos Silva", 97730978032, "2003-01-29", "Feminino", "Santos, SP", "Solteiro(a)", 'a', 11, 1, 12345, "emily.jpeg");
insert into tb_paciente (nome, cpf, dt_nascimento, genero, naturalidade, estado_civil, ativo, id_usuario, id_medico, unique_id, img)
	values("Thiago Blitskow", 84387374047, "2001-08-10", "Masculino", "Belo Horizonte, MG", "Solteiro(a)", 'a', 2, 2, 35426, "thiago.jpeg");
insert into tb_paciente (nome, cpf, dt_nascimento, genero, naturalidade, estado_civil, ativo, id_usuario, id_medico, unique_id)
	values("Eduardo Ferreira", 14080647077, "2000-10-16", "Masculino", "Guarujá, SP", "Viúvo(a)", 'a', 3, 1, 54321);
insert into tb_paciente (nome, cpf, dt_nascimento, genero, naturalidade, estado_civil, ativo, id_usuario, id_medico, unique_id)
	values("Camile Santos", 83683627093, "2008-01-20", "Feminino", "Praia Grande, SP", "Solteiro(a)", 'a', 4, 3, 31642);
insert into tb_paciente (nome, cpf, dt_nascimento, genero, naturalidade, estado_civil, ativo, id_usuario, id_medico, unique_id)
	values("Cassio Menezes da Silva", 34336400091, "1999-06-17", "Masculino", "Santos, SP", "Solteiro(a)", 'a', 5, 1, 98765);

/* Registros */
insert into tb_registro (id_registro, historia_clinica, exame_clinico_fisico, exames_complementares, plano_terapeutico, id_medico, id_paciente)
	values(1, "Paciente foi andar de bicicleta e fraturou o membro inferior direito", "Paciente com fratura longitudinal", "Foi feito um raio-x", "Fazer 10 sessões no total, 1 por semana, com agachamentos, esteira e alongamento de ambos os membro inferiores para uma melhor adaptação ao caminhar", 1, 1);
insert into tb_sessao (id_sessao, diagnostico_fisio, evolucao_saude, dt_ultimo_registro, id_registro)
	values(1, "Paciente utilizou gesso e está se recuperando", "Em sua última consulta...","2022-10-28", 1);
    
insert into tb_registro (id_registro, historia_clinica, exame_clinico_fisico, exames_complementares, plano_terapeutico, id_medico, id_paciente)
	values(2, "Paciente pulou de forma errada na piscina e bateu o braço na borda dela, fraturando-a", "Paciente com fratura oblíqua exposta no rádio, membro superior esquerdo", "Foi feito um raio-x do braço", "Precisará de 10 seções totais, 1 por semana, com variação dentre 3 a 4 exercícios para o antebraço esquerdo", 2, 2);
insert into tb_sessao (id_sessao, diagnostico_fisio, evolucao_saude, dt_ultimo_registro, id_registro)
	values(2, "Paciente irá de fazer uma cirurgia de reconstrução do osso", "Em sua última consulta...","2022-10-29", 2);
    
insert into tb_registro (id_registro, historia_clinica, exame_clinico_fisico, exames_complementares, plano_terapeutico, id_medico, id_paciente)
	values(3, "Foi andar de skate e caiu, fraturou o rádio do braço direito", "Fratura longitudinal", "Foi feito um raio-x e enfaixado com gesso durante 2 semanas", "4 seções totais, 1 por semana, com exercícios para o braço e alongamentos", 3, 4);
insert into tb_sessao (id_sessao, diagnostico_fisio, evolucao_saude, dt_ultimo_registro, id_registro)
	values(3, "O paciente deverá realizar tratamento com gesso e repouso", "A primeira consulta demonstrou melhoras em seu repouso desde sua consulta", "2022-10-30", 3);

/* Insert TB_CONSULTA */
INSERT INTO tb_consulta (title, color, start, end, ativo, id_medico, id_paciente, id_clinica) VALUES
('Camile', '#2980b9', '2022-11-30 19:00:00', '2022-11-30 19:30:00', 'a', 3, 4, 1);
INSERT INTO tb_consulta (title, color, start, end, ativo, id_medico, id_paciente, id_clinica) VALUES
('Thiago', '#2980b9', '2022-11-30 18:30:00', '2022-11-30 19:05:00', 'a', 2, 2, 1);
INSERT INTO tb_consulta (title, color, start, end, ativo, id_medico, id_paciente, id_clinica) VALUES
('Eduardo', '#2980b9', '2022-12-01 10:05:00', '2022-12-01 10:35:00', 'a', 1, 3, 1);
INSERT INTO tb_consulta (title, color, start, end, ativo, id_medico, id_paciente, id_clinica) VALUES
('Cassio', '#2980b9', '2022-12-08 13:00:00', '2022-12-08 13:30:00', 'a', 1, 5, 1);
INSERT INTO tb_consulta (title, color, start, end, ativo, id_medico, id_paciente, id_clinica) VALUES
('Thiago ', '#2980b9', '2022-12-09 08:15:00', '2022-12-09 08:45:00', 'a', 2, 2, 1);
INSERT INTO tb_consulta (title, color, start, end, ativo, id_medico, id_paciente, id_clinica) VALUES
('Emily', '#2980b9', '2022-12-02 10:0:00', '2022-12-02 10:30:00', 'a', 1, 1, 1);
INSERT INTO tb_consulta (title, color, start, end, ativo, id_medico, id_paciente, id_clinica) VALUES
('Eduardo', '#2980b9', '2022-12-13 10:00:00', '2022-12-13 10:30:00', 'a', 3, 4, 1);
INSERT INTO tb_consulta (title, color, start, end, ativo, id_medico, id_paciente, id_clinica) VALUES
('Emily', '#2980b9', '2022-12-23 10:00:00', '2022-12-23 10:30:00', 'a', 1, 1, 1);
INSERT INTO tb_consulta (title, color, start, end, ativo, id_medico, id_paciente, id_clinica) VALUES
('Cassio', '#2980b9', '2022-12-27 10:05:00', '2022-12-27 10:30:00', 'a', 1, 5, 1);


select * from tb_usuarios;
select * from tb_tpoUsu;
select * from tb_clinica;  /* CNPJ Válido: 85880211000119 */
select * from tb_medico;
select * from tb_paciente;
select * from tb_registro; 
select * from tb_sessao;
select * from tb_consulta; 


/* Procedures */
delimiter $
create procedure editarUsuarioPaci(
in id_paci int(11), /* O que vai ser utilizado para atualizar os dados */
in nomeP varchar(40),
in cpfP char(11),
in dt_nascimentoP date,
in generoP varchar(20),
in naturalidadeP varchar(50),
in estado_civilP varchar(25),
in emailP varchar(40),
in id_medicoP int(5))
begin
	declare idUsu int;
	update tb_paciente set nome = nomeP, cpf = cpfP, dt_nascimento = dt_nascimentoP, genero = generoP, naturalidade = naturalidadeP, estado_civil = estado_civilP, id_medico = id_medicoP where id_paciente = id_paci;
    set idUsu = (select id_usuario from tb_paciente where id_paciente = id_paci);
    update tb_usuarios set email = emailP where id_usuario = idUsu;
end $

delimiter $
create procedure editarUsuarioFisio(
in id_fisio int(5), /* O que vai ser utilizado para atualizar os dados */
in nomeF varchar(40),
in cpfF char(11),
in crefitoF char(6),
in dt_nascimentoF date,
in generoF varchar(20),
in emailF varchar(40))
begin
	declare idFisio int;
	update tb_medico set nome = nomeF, cpf = cpfF, crefito = crefitoF, dt_nascimento = dt_nascimentoF, genero = generoF where id_medico = id_fisio;
    set idFisio = (select id_usuario from tb_medico where id_medico = id_fisio);
    update tb_usuarios set email = emailF where id_usuario = idFisio;
end $

delimiter $
create procedure spDelPaciente(
in id_paci int(5))
begin
	update tb_paciente set ativo = 'i' where id_paciente = id_paci;
end $

delimiter $
create procedure spDelFisio(
in id_fisio int(5))
begin
	update tb_medico set ativo = 'i' where id_medico = id_fisio;
end $

delimiter $
create procedure spCadFisio(
in id_clin int(5),
in nomeF varchar(40),
in cpfF char(11),
in crefitoF char(6),
in dt_nascimentoF date,
in generoF varchar(20),
in emailF varchar(40),
in senhaF varchar(40))
begin
	declare id_usu int;
	insert into tb_usuarios (email, senha, id_tpoUsu) values ( emailF, senhaF, '1');
    set id_usu = (select max(id_usuario) from tb_usuarios);
    
    insert into tb_medico (nome, cpf, crefito, dt_nascimento, genero, ativo, id_usuario, id_clinica) values (nomeF, cpfF, crefitoF, dt_nascimentoF, generoF, 'a', id_usu, id_clin);
end $

delimiter $
create procedure UpInsert_Registro(
in validacao int(1),
in historiaClinica tinytext,
in exameClinicoFisico tinytext,
in exameComplementares tinytext,
in diagnosticoFisio tinytext,
in planoFisio tinytext,
in evolucaoSaude tinytext,
in dtReg date,
in idPaci int (5))
begin
declare idMed int;
declare idReg int;
	if(validacao = 1)then
		set idMed = (select id_medico from tb_paciente where id_paciente = idPaci);/*1*/
		insert into tb_registro (historia_clinica, exame_clinico_fisico, exames_complementares, plano_terapeutico, id_medico, id_paciente) values (historiaClinica, exameClinicoFisico, exameComplementares, planoFisio, idMed, idPaci);
        set idReg = (select max(id_registro) from tb_registro);
        insert into tb_sessao (diagnostico_fisio, evolucao_saude, dt_ultimo_registro, id_registro)values(diagnosticoFisio, evolucaoSaude, dtReg, idReg);
	else
		update tb_registro set historia_clinica = historiaClinica, exame_clinico_fisico = exameClinicoFisico, exames_complementares = exameComplementares, plano_terapeutico = planoFisio where id_paciente = idPaci;
        set idReg = (select id_registro from tb_registro where id_paciente = idPaci);
        update tb_sessao set diagnostico_fisio = diagnosticoFisio, evolucao_saude = evolucaoSaude, dt_ultimo_registro = dtReg where id_registro = idReg;
	end if;
end $UpInsert_Registro

delimiter $
create procedure CadClinica(
in emailC varchar(40),
in senhaC varchar(40),
in clinica varchar(40),
in cnpjCli char(14),
in tel varchar(15),
in estadoCli varchar(40),
in cidadeCli varchar(110),
in enderecoCli varchar(110))
begin
declare idUsu int;
    insert into tb_usuarios (email, senha, id_tpoUsu) values (emailC, senhaC, '3');
    set idUsu = (select max(id_usuario) from tb_usuarios);
    insert into tb_clinica (nome, cnpj, telefone, estado, cidade, endereco, id_usuario) values (clinica, cnpjCli, tel, estadoCli, cidadeCli, enderecoCli, idUsu);
end $

/* Trigger */
delimiter $
	create trigger trUniqueIdPaciente
		before insert on tb_paciente
			for each row 
				begin
					if(new.unique_id is null) then
						set new.unique_id = substr(RAND(), 3, 5);
					end if;
				end $
                
delimiter $
	create trigger trUniqueIdMedic
		before insert on tb_medico
			for each row 
				begin
					if(new.unique_id is null) then
						set new.unique_id = substr(RAND(), 3, 5);
					end if;
				end $
                
delimiter $
	create trigger trInsereAuditoria_revendedor /*nome da trigger*/
		after insert on tb_paciente /*após o insert criado */
			for each row 
				begin 
					insert into tb_auditoria set 
						codigo = new.id_paciente,
                        usuario = user(), 
                        acao = 'CADASTRO', 
                        data_acao = curdate(), 
                        hora_acao = curtime();
				end $