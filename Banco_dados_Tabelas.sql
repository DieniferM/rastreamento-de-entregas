CREATE TABLE entregas ( _id VARCHAR(36) NOT NULL COLLATE 'latin1_swedish_ci', _id_transportadora VARCHAR(36) NOT 
NULL COLLATE 'latin1_swedish_ci', _volumes INT(11) NOT NULL DEFAULT '0', _remetente_nome VARCHAR(36) NOT NULL 
DEFAULT '0' COLLATE 'latin1_swedish_ci', _destinatario_nome VARCHAR(36) NOT NULL DEFAULT '0' COLLATE 'latin1_swedish_ci',
_destinatario_cpf VARCHAR(11) NOT NULL DEFAULT '0' COLLATE 'latin1_swedish_ci', _destinatario_endereco VARCHAR(255) NOT 
NULL DEFAULT '0' COLLATE 'latin1_swedish_ci', _destinatario_estado VARCHAR(36) NOT NULL DEFAULT '0' 
COLLATE 'latin1_swedish_ci', _destinatario_cep VARCHAR(10) NOT NULL DEFAULT '0' COLLATE 'latin1_swedish_ci', 
_destinatario_pais VARCHAR(50) NOT NULL DEFAULT '0' COLLATE 'latin1_swedish_ci', _geolocalizacao_lat DECIMAL(10,6) 
NOT NULL DEFAULT '0.000000', _geolocalizacao_lng DECIMAL(10,6) NOT NULL DEFAULT '0.000000', PRIMARY KEY (_id) 
USING BTREE, INDEX FK_entregas_transportadoras (_id_transportadora) USING BTREE ) 
COLLATE='latin1_swedish_ci' ENGINE=MyISAM ;

CREATE TABLE transportadoras ( _id VARCHAR(36) NOT NULL COLLATE 'latin1_swedish_ci', _cnpj VARCHAR(14) 
NOT NULL COLLATE 'latin1_swedish_ci', _fantasia VARCHAR(36) NOT NULL COLLATE 'latin1_swedish_ci', PRIMARY KEY (_id) 
USING BTREE ) COLLATE='latin1_swedish_ci' ENGINE=MyISAM ; 

CREATE TABLE _rastreamento ( id INT(11) NOT NULL 
AUTO_INCREMENT, _id_entrega VARCHAR(36) NOT NULL COLLATE 'latin1_swedish_ci', message VARCHAR(255) NULL DEFAULT NULL 
COLLATE 'latin1_swedish_ci', date TIMESTAMP NOT NULL, PRIMARY KEY (id) USING BTREE ) COLLATE='latin1_swedish_ci' 
ENGINE=MyISAM AUTO_INCREMENT=54 ;

CREATE TABLE _remetente ( _id_entrega VARCHAR(36) NOT NULL COLLATE 'latin1_swedish_ci', _nome VARCHAR(255) NOT NULL 
COLLATE 'latin1_swedish_ci', PRIMARY KEY (_id_entrega, _nome) USING BTREE ) COLLATE='latin1_swedish_ci' ENGINE=MyISAM ;