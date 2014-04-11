-- phpMyAdmin SQL Dump
-- version 2.7.0-pl1
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2014 年 04 月 11 日 06:39
-- 服务器版本: 5.0.96
-- PHP 版本: 5.2.17
-- 
-- 数据库: `a0404031134`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `tbl_comment`
-- 

CREATE TABLE `tbl_comment` (
  `id` int(11) NOT NULL auto_increment,
  `content` text collate utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) default NULL,
  `author` varchar(128) collate utf8_unicode_ci NOT NULL,
  `email` varchar(128) collate utf8_unicode_ci NOT NULL,
  `url` varchar(128) collate utf8_unicode_ci default NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_comment_post` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1608 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- 表的结构 `tbl_jing`
-- 

CREATE TABLE `tbl_jing` (
  `id` int(11) NOT NULL auto_increment,
  `won` varchar(128) character set latin1 default '0' COMMENT '获胜方   1：sid1  ； 2：sid2 ; -1 : 和棋; 0 : 还没结束',
  `data` varchar(2048) default '' COMMENT '游戏数据',
  `sid1` varchar(128) character set latin1 default '' COMMENT '玩家1',
  `sid2` varchar(128) character set latin1 default '' COMMENT '玩家2',
  `update_time` int(11) default '0' COMMENT '修改时间',
  `create_time` int(11) default '0' COMMENT '创建时间',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2371 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- 表的结构 `tbl_lookup`
-- 

CREATE TABLE `tbl_lookup` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) collate utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `type` varchar(128) collate utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- 表的结构 `tbl_post`
-- 

CREATE TABLE `tbl_post` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(128) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
  `tags` text collate utf8_unicode_ci,
  `status` int(11) NOT NULL,
  `create_time` int(11) default NULL,
  `update_time` int(11) default NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_post_author` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- 表的结构 `tbl_qq_user`
-- 

CREATE TABLE `tbl_qq_user` (
  `id` int(11) NOT NULL,
  `openid` varchar(32) NOT NULL,
  `user_id` int(11) default NULL,
  `token` varchar(32) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- 表的结构 `tbl_sort_domi`
-- 

CREATE TABLE `tbl_sort_domi` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) default NULL,
  `com` varchar(32) default NULL,
  `net` varchar(32) default NULL,
  `cn` varchar(32) default NULL,
  `com_time` int(11) default NULL,
  `cn_time` int(11) default NULL,
  `net_time` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- 表的结构 `tbl_tag`
-- 

CREATE TABLE `tbl_tag` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) collate utf8_unicode_ci NOT NULL,
  `frequency` int(11) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- 表的结构 `tbl_tmp`
-- 

CREATE TABLE `tbl_tmp` (
  `id` int(11) NOT NULL auto_increment,
  `content` text collate utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `ctime` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- 表的结构 `tbl_user`
-- 

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(128) collate utf8_unicode_ci NOT NULL,
  `password` varchar(128) collate utf8_unicode_ci NOT NULL,
  `salt` varchar(128) collate utf8_unicode_ci default NULL,
  `email` varchar(128) collate utf8_unicode_ci NOT NULL,
  `profile` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- 表的结构 `test_mysql`
-- 

CREATE TABLE `test_mysql` (
  `id` int(11) NOT NULL auto_increment,
  `no` int(11) default NULL,
  `name` varchar(1024) default NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_no` (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- 表的结构 `ttt_comment`
-- 

CREATE TABLE `ttt_comment` (
  `id` int(11) NOT NULL auto_increment,
  `content` text collate utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) default NULL,
  `author` varchar(128) collate utf8_unicode_ci NOT NULL,
  `email` varchar(128) collate utf8_unicode_ci NOT NULL,
  `url` varchar(128) collate utf8_unicode_ci default NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_comment_post` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- 表的结构 `ttt_lookup`
-- 

CREATE TABLE `ttt_lookup` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) collate utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `type` varchar(128) collate utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- 表的结构 `ttt_post`
-- 

CREATE TABLE `ttt_post` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(128) collate utf8_unicode_ci NOT NULL,
  `content` text collate utf8_unicode_ci NOT NULL,
  `tags` text collate utf8_unicode_ci,
  `status` int(11) NOT NULL,
  `create_time` int(11) default NULL,
  `update_time` int(11) default NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_post_author` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- 表的结构 `ttt_tag`
-- 

CREATE TABLE `ttt_tag` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) collate utf8_unicode_ci NOT NULL,
  `frequency` int(11) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- 表的结构 `ttt_user`
-- 

CREATE TABLE `ttt_user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(128) collate utf8_unicode_ci NOT NULL,
  `password` varchar(128) collate utf8_unicode_ci NOT NULL,
  `salt` varchar(128) collate utf8_unicode_ci NOT NULL,
  `email` varchar(128) collate utf8_unicode_ci NOT NULL,
  `profile` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- 
-- 表的结构 `yii2_user`
-- 

CREATE TABLE `yii2_user` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(128) NOT NULL,
  `password_hash` varchar(128) NOT NULL,
  `password_reset_token` varchar(128) default NULL,
  `email` varchar(128) default NULL,
  `auth_key` varchar(128) default NULL,
  `role` int(11) default NULL,
  `status` int(11) default NULL,
  `create_time` int(11) default NULL,
  `update_time` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
