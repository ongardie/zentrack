
CREATE INDEX zt_log_tid ON ZENTRACK_LOGS(ticket_id);
CREATE INDEX zt_log_action ON ZENTRACK_LOGS(action);
CREATE INDEX zt_ticket_pri ON ZENTRACK_TICKETS(priority);
CREATE INDEX zt_ticket_stat ON ZENTRACK_TICKETS (status);

create table ZENTRACK_ACTION (
  action_id   int(20)     not null,
  action_name varchar(50) not null,
  action_desc text default '',
  primary key (action_id)
);

INSERT INTO ZENTRACK_ACTION view_log, add_log, delete_log
INSERT INTO ZENTRACK_ACTION assign, accept, reject, test, view, create
INSERT INTO ZENTRACK_ACTION email_anyone, email_login, email_contact
INSERT INTO ZENTRACK_ACTION login_web, login_egate, login_contact
INSERT INTO ZENTRACK_ACTION attach, relate, test, approve
INSERT INTO ZENTRACK_ACTION tab_[1-9]

create table ZENTRACK_ROLE (
  role_id int(20) not null auto_increment,
  role_name varchar(50) not null,
  role_desc varchar(255) default '',
  primary key (role_id)
);

CREATE INDEX zt_role_idx ON ZENTRACK_ROLE(role_name);

create table ZENTRACK_ROLE_NODES {
  role_id   int(20) not null,
  bin_id    int(20) default 0,
  type_id   int(20) default 0,
  action_id int(20) default 0,
  allowit   int(1)  default 0
}

CREATE INDEX zt_role_nodes_rb_idx ON ZENTRACK_ROLE_NODES(role_id,bin_id);
CREATE INDEX zt_role_nodes_rba_idx ON ZENTRACK_ROLE_NODES(role_id,bin_id,action_id);
CREATE INDEX zt_role_nodes_rbt_idx ON ZENTRACK_ROLE_NODES(role_id,bin_id,type_id);
CREATE INDEX zt_role_nodes_rbta_idx ON ZENTRACK_ROLE_NODES(role_id,bin_id,type_id,action_id);

INSERT INTO ZENTRACK_SETTINGS login_password_required
INSERT INTO ZENTRACK_SETTINGS egate_pin_required
INSERT INTO ZENTRACK_SETTINGS egate_allow_anonymous
INSERT INTO ZENTRACK_SETTINGS customers_can_login
INSERT INTO ZENTRACK_SETTINGS customers_require_password
INSERT INTO ZENTRACK_SETTINGS customers_label

CREATE TABLE ZENTRACK_LOGIN (
  login_id int(20) not null auto_increment,
  login_name varchar(255) not null,
  login_pass varchar(255) default '',
  login_source varchar(255) default '',
  login_type varchar(255) not null,
  primary key (login_id)
);

CREATE INDEX zt_login_idx ON ZENTRACK_LOGIN(login_name, login_pass);

DELETE FROM ZENTRACK_FIELD_MAP WHERE field_map_id = 106;
