Projeto de aprendisagem PHP.

Para execução em outra máquina é necessário a criação de um DB em MySQL.
O programa utilizado para este projeto foi o XAMPP.

Adicionar ao DB os seguintes comandos:

CREATE DATABASE alunos;

USE alunos;

CREATE TABLE ALUNO (
    matricula INT PRIMARY KEY AUTO_INCREMENT,
    nomea VARCHAR(100) NOT NULL
);

CREATE TABLE PROFESSOR (
    matricula INT PRIMARY KEY AUTO_INCREMENT,
    nomep VARCHAR(100) NOT NULL
);

CREATE TABLE MUNICIPIO (
    codigo INT PRIMARY KEY AUTO_INCREMENT,
    nomem VARCHAR(100) NOT NULL
);

CREATE TABLE DISCIPLINA (
    codigo INT PRIMARY KEY AUTO_INCREMENT,
    nomed VARCHAR(100) NOT NULL
);

O projeto deve estar localizado em uma subpasta dentro de htdocs do programa xampp.
Para acessar a pasta do xampp, basta clicar em "Explorer" no meu menu ao lado direito do programa, 
ou acessa-la pelo caminho que você utilizou na hora da instalação.

Para execução é necessário inserir o seguinte link em um browser que você utiliza: localhost/(Aqui a pasta que você criou dentro de htdocs)
