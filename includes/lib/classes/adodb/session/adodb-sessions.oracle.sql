-- $CVSHeader: zentrack/includes/lib/classes/adodb/session/adodb-sessions.oracle.sql,v 1.1 2004/03/13 10:55:06 phpzen Exp $

DROP TABLE adodb_sessions;

CREATE TABLE sessions (
	sesskey		CHAR(32)	DEFAULT '' NOT NULL,
	expiry		INT		DEFAULT 0 NOT NULL,
	expireref	VARCHAR(64)	DEFAULT '',
	data		VARCHAR(4000)	DEFAULT '',
	PRIMARY KEY	(sesskey),
	INDEX expiry (expiry)
);

CREATE INDEX ix_expiry ON sessions (expiry);

QUIT;
