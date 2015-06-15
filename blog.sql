/*
Navicat MySQL Data Transfer

Source Server         : 本地数据
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2015-06-15 15:24:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `blog_categories`
-- ----------------------------
DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE `blog_categories` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `parent_id` int(8) NOT NULL DEFAULT '0' COMMENT '父级分类',
  `cartegory_name` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `category_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1标签，2分类',
  `category_description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `post_count` bigint(20) NOT NULL DEFAULT '0' COMMENT '分类下文章数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_categories
-- ----------------------------

-- ----------------------------
-- Table structure for `blog_comments`
-- ----------------------------
DROP TABLE IF EXISTS `blog_comments`;
CREATE TABLE `blog_comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '父评论ID',
  `post_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `comment_uid` int(8) NOT NULL DEFAULT '0' COMMENT '评论人id',
  `comment_ip` bigint(15) NOT NULL DEFAULT '0' COMMENT '评论人IP地址',
  `comment_date` int(11) NOT NULL DEFAULT '0' COMMENT '评论时间',
  `comment_content` text NOT NULL COMMENT '评论内容',
  `comment_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未通过，1通过',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_comments
-- ----------------------------

-- ----------------------------
-- Table structure for `blog_links`
-- ----------------------------
DROP TABLE IF EXISTS `blog_links`;
CREATE TABLE `blog_links` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接url',
  `link_name` varchar(255) NOT NULL DEFAULT '' COMMENT '链接名称',
  `link_image` varchar(255) NOT NULL DEFAULT '' COMMENT '链接图片',
  `link_targe` tinyint(1) NOT NULL DEFAULT '1' COMMENT '链接打开方式(1本页打开，2新标签页打开)',
  `link_sort` int(4) NOT NULL DEFAULT '0' COMMENT '友情链接排序',
  `link_date` int(11) NOT NULL DEFAULT '0' COMMENT '链接添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_links
-- ----------------------------

-- ----------------------------
-- Table structure for `blog_posts`
-- ----------------------------
DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE `blog_posts` (
  `id` bigint(20) NOT NULL,
  `author_id` int(8) NOT NULL DEFAULT '0' COMMENT '文章作者ID',
  `post_title` varchar(255) NOT NULL DEFAULT '' COMMENT '文章标题',
  `post_excerpt` varchar(255) NOT NULL DEFAULT '' COMMENT '摘录',
  `post_content` text NOT NULL COMMENT '文章内容',
  `post_date` int(11) NOT NULL DEFAULT '0' COMMENT '文章发布时间',
  `post_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '文章状态 （0草稿，1已发布，2回收站）',
  `post_pwd` varchar(20) NOT NULL DEFAULT '' COMMENT '文章密码',
  `post_attribute` tinyint(1) NOT NULL DEFAULT '1' COMMENT '文章可见属性(1所有人 2自己)',
  `modified_date` int(11) NOT NULL DEFAULT '0' COMMENT '文章修改日期',
  `comment_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '该文章是否开启评论（1开启，0关闭）',
  `comment_count` bigint(20) NOT NULL DEFAULT '0' COMMENT '文章评论总数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_posts
-- ----------------------------

-- ----------------------------
-- Table structure for `blog_relationships`
-- ----------------------------
DROP TABLE IF EXISTS `blog_relationships`;
CREATE TABLE `blog_relationships` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '文章ID',
  `category_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '分类ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_relationships
-- ----------------------------

-- ----------------------------
-- Table structure for `blog_users`
-- ----------------------------
DROP TABLE IF EXISTS `blog_users`;
CREATE TABLE `blog_users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `user_pwd` varchar(255) NOT NULL DEFAULT '' COMMENT '用户密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_users
-- ----------------------------
INSERT INTO `blog_users` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e');
