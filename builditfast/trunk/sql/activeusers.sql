
--
-- Table structure for table `active_users`
--

DROP TABLE IF EXISTS active_users;
CREATE TABLE active_users (
  user_ip varchar(15) NOT NULL default '',
  time datetime default NULL
) TYPE=MyISAM;

