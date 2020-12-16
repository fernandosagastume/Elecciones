CREATE TABLE Departamento (
	codigo int,
	nombre varchar(25),
	PRIMARY KEY(codigo)
	);

CREATE TABLE Municipio (
	codigo int,
	nombre varchar(25),
	no_habitantes int,
	departamento int,
	PRIMARY KEY(codigo),
	FOREIGN KEY(departamento) REFERENCES Departamento(codigo) ON DELETE CASCADE);
	
CREATE TABLE PartidoPolitico (
	nombre varchar(25),
	secretarioGeneral varchar(30),
	/*Aqui va un codigo binario*/logo bytea,
	acronimo varchar(10),
	PRIMARY KEY(nombre));

CREATE TABLE Empadronado(
	DPI bigint,
	nombres varchar(25),
	apellidos varchar(25),
	direccion varchar(30),
	municipio int,
	departamento int,
	votop int,
	votoa int,
	votoc int,
	votoln int,
	votodep int,
	PRIMARY KEY(DPI),
	FOREIGN KEY(municipio) REFERENCES Municipio(codigo) ON DELETE CASCADE,
	FOREIGN KEY(departamento) REFERENCES Departamento(codigo) ON DELETE CASCADE
	);

CREATE TABLE Presidencia(
	DPI_presi bigint,
	DPI_vice bigint,
	partido varchar(25),
	foto bytea,
	PRIMARY KEY(DPI_presi),
	UNIQUE(DPI_vice),
	UNIQUE(partido),
	FOREIGN KEY(DPI_presi) REFERENCES Empadronado(DPI) ON DELETE CASCADE,
	FOREIGN KEY(DPI_vice) REFERENCES Empadronado(DPI) ON DELETE CASCADE,
	FOREIGN KEY(partido) REFERENCES PartidoPolitico(nombre) ON DELETE CASCADE
	);

CREATE TABLE Alcalde(
	DPI bigint,
	partido varchar(25),
	municipio int,
	PRIMARY KEY(DPI),
	UNIQUE(partido, municipio),
	FOREIGN KEY(DPI) REFERENCES Empadronado(DPI),
	FOREIGN KEY(partido) REFERENCES PartidoPolitico(nombre) ON DELETE CASCADE,
	FOREIGN KEY(municipio) REFERENCES Municipio(codigo) ON DELETE CASCADE
	);

CREATE TABLE Congreso (
	DPI bigint,
	departamento int,
	partido varchar(25),
	casilla int,
	PRIMARY KEY(DPI),
	UNIQUE(partido, departamento, casilla),
	FOREIGN KEY(DPI) REFERENCES Empadronado(DPI) ON DELETE CASCADE,
	FOREIGN KEY(departamento) REFERENCES Departamento(codigo) ON DELETE CASCADE,
	FOREIGN KEY(partido) REFERENCES PartidoPolitico(nombre) ON DELETE CASCADE
	);

CREATE TABLE Mesa (
	no_mesa int,
	nombrePresidente varchar(30),
	secretario varchar(30),
	vocal varchar(30),
	alguacil varchar(30),
	nombreUbicacion varchar(30),
	DireccionUbicacion varchar(40),
	rangoEmpadronamientoMinimo bigint,
	rangoEmpadronamientoMaximo bigint,
	votosNulos int,
	votosBlanco int,
	municipio int,
	PRIMARY KEY(no_mesa),
	FOREIGN KEY(municipio) REFERENCES Municipio(codigo) ON DELETE CASCADE
	);

CREATE TABLE conteoFinal (
	no_mesa int,
	partido varchar(25),
	votoPresidencia int,
	votoAlcalde int,
	votoDiputadosDistritales int,
	VotoDiputadosListadoNacional int,
	votoblancopresi int, votonulopresi int,
	votoblancoalcal int, votonuloalcal int,
	votoblancodistrital int, votonulodistrital int,
	votoblanconacional int, votonulonacional int,
	PRIMARY KEY(no_mesa, partido),
	FOREIGN KEY (partido) REFERENCES PartidoPolitico(nombre) ON DELETE CASCADE,
	FOREIGN KEY (no_mesa) REFERENCES Mesa(no_mesa) ON DELETE CASCADE
	);

CREATE USER empadronado WITH PASSWORD 'aiudenos';

GRANT SELECT, UPDATE ON Empadronado, ConteoFinal TO empadronado;
GRANT SELECT ON PartidoPolitico, Municipio, Departamento, Mesa, Alcalde, Presidencia, Congreso TO empadronado;

CREATE USER administrador WITH PASSWORD 'elmerogfe';

GRANT SELECT, INSERT, UPDATE, DELETE ON Departamento, Municipio, Empadronado, PartidoPolitico, Presidencia, Alcalde, Congreso, Mesa, ConteoFinal TO administrador;
