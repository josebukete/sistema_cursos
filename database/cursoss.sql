CREATE DATABASE cursoss;
USE cursoss;
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('aluno', 'formador') NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT NOT NULL,
    categoria VARCHAR(100),
    nivel ENUM('iniciante', 'intermediario', 'avancado'),
    formador_id INT NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (formador_id)
    REFERENCES usuarios(id)
    ON DELETE CASCADE
);
CREATE TABLE aulas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    conteudo TEXT,
    curso_id INT NOT NULL,
    ordem_aula INT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (curso_id)
    REFERENCES cursos(id)
    ON DELETE CASCADE
);
CREATE TABLE inscricoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    data_inscricao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id)
    ON DELETE CASCADE,
    FOREIGN KEY (curso_id)
    REFERENCES cursos(id)
    ON DELETE CASCADE
);
CREATE TABLE progresso_aulas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    aula_id INT NOT NULL,
    concluida BOOLEAN DEFAULT FALSE,
    data_conclusao TIMESTAMP NULL,
    FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id)
    ON DELETE CASCADE,
    FOREIGN KEY (aula_id)
    REFERENCES aulas(id)
    ON DELETE CASCADE
);
ALTER TABLE inscricoes
ADD CONSTRAINT unique_inscricao
UNIQUE(usuario_id, curso_id);
ALTER TABLE progresso_aulas
ADD CONSTRAINT unique_progresso
UNIQUE(usuario_id, aula_id);

ALTER TABLE aulas 
ADD COLUMN video VARCHAR(255),
ADD COLUMN thumbnail VARCHAR(255);

ALTER TABLE cursos
ADD COLUMN thumbnail VARCHAR(255);