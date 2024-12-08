/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : account

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2024-12-08 15:57:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `userName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emailnum` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userPwd` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `schoolnum` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sex` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `copname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phonenum` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mottoword` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `turename` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `identit` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`identit`,`schoolnum`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES ('zyg', '1@qq.com', '1', '00000001', 'male', '计算机', '18300000000', '数据结构', '1999', '朱允刚', 'teacher');
INSERT INTO `account` VALUES ('fzx', '1798224146@qq.com', '1', '21211019', 'male', '计算机', '18795465975', 'sad', '2021', '冯哲熙', 'student');
INSERT INTO `account` VALUES ('lxh', '1@qq.com', '1', '22222222', 'female', '计算机', '18700000000', '离散数学', '1995', '卢欣华', 'teacher');
INSERT INTO `account` VALUES ('kh', '1@qq.com', '1', '00000002', 'female\r\n', '计算机', '13900000000', '数据库', '1994', '康辉', 'teacher');
INSERT INTO `account` VALUES ('syh', '1@qq.com', '1', '21211030', 'male', '计算机', '13700000000', 'smart', '2021', '宋羽豪', 'student');
INSERT INTO `account` VALUES ('ljq', '1@qq.com', '1', '21211020', 'male', '计算机', '13800000000', 'clever', '2021', '李纪群', 'student');
INSERT INTO `account` VALUES ('zyt', '1@qq.com', '1', '21211031', 'male', '计算机', '17700000000', 'happy', '2021', '张翼天', 'student');
INSERT INTO `account` VALUES ('1', '1@qq.com', '22222222', '33333333', 'male', '计算机', '18795465975', '12345', '2021', '111', 'student');
INSERT INTO `account` VALUES ('sh', '1@qq.com', '1', '00000003', 'male', '数学', '18795465975', '高等数学', '1995', '宋浩', 'teacher');
INSERT INTO `account` VALUES ('lhx', '1@qq.com', '1', '00000004', 'male', '计算机', '18795465975', '编译原理', '1996', '刘华虓', 'teacher');

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `userName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emailnum` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userPwd` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `turename` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `schoolnum` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sex` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `copname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `identit` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phonenum` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mottoword` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`schoolnum`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('Administrator', '1@qq.com', '00000000', 'admin', '99999999', 'male', 'JLU', 'admin', '19900000000', 'admin', '1900');

-- ----------------------------
-- Table structure for course
-- ----------------------------
DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `courseid` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `subject` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timeindex` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locationid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credit` varchar(50) COLLATE utf8_unicode_ci DEFAULT '0',
  `realcapacity` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cdep` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `weekid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`courseid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of course
-- ----------------------------
INSERT INTO `course` VALUES ('2', '专业英语', '6', '2', '1', '10', '英语', '2');
INSERT INTO `course` VALUES ('4', '编译原理', '35', '3', '2', '10', '计算机', '4');
INSERT INTO `course` VALUES ('6', '离散数学2', '17', '2', '2', '10', '数学', '2');
INSERT INTO `course` VALUES ('7', '高等数学', '34', '6', '3', '30', '数学', '2');
INSERT INTO `course` VALUES ('8', '体育', '30', '2', '1', '20', '体育', '5');
INSERT INTO `course` VALUES ('5', '数据库', '6', '1', '2', '33', '计算机', '6');
INSERT INTO `course` VALUES ('10', '数据库', '6', '6', '2', '20', '计算机', '6');

-- ----------------------------
-- Table structure for location
-- ----------------------------
DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `locationid` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `building` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `room` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `capacity` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`locationid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of location
-- ----------------------------
INSERT INTO `location` VALUES ('1', '逸夫楼', '501', '60');
INSERT INTO `location` VALUES ('2', '经信楼', '第一阶梯教室', '200');
INSERT INTO `location` VALUES ('3', '第三教学楼', '第二阶梯教室', '150');
INSERT INTO `location` VALUES ('4', '王湘浩楼', 'A211', '30');
INSERT INTO `location` VALUES ('5', '逸夫楼', '第十阶梯教室', '250');
INSERT INTO `location` VALUES ('6', '经信楼', '308', '30');

-- ----------------------------
-- Table structure for studenttake
-- ----------------------------
DROP TABLE IF EXISTS `studenttake`;
CREATE TABLE `studenttake` (
  `schoolnum` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `courseid` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `score` varchar(50) COLLATE utf8_unicode_ci DEFAULT '暂无成绩',
  PRIMARY KEY (`schoolnum`,`courseid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of studenttake
-- ----------------------------
INSERT INTO `studenttake` VALUES ('21211019', '6', '80');
INSERT INTO `studenttake` VALUES ('21211031', '6', '90');
INSERT INTO `studenttake` VALUES ('21211019', '4', '暂无成绩');
INSERT INTO `studenttake` VALUES ('33333333', '6', '60');

-- ----------------------------
-- Table structure for teach
-- ----------------------------
DROP TABLE IF EXISTS `teach`;
CREATE TABLE `teach` (
  `schoolnum` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `courseid` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`schoolnum`,`courseid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of teach
-- ----------------------------
INSERT INTO `teach` VALUES ('00000002', '10');
INSERT INTO `teach` VALUES ('00000002', '5');
INSERT INTO `teach` VALUES ('00000004', '4');
INSERT INTO `teach` VALUES ('22222222', '6');

-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `userName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emailnum` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userPwd` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `turename` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `schoolnum` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `sex` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `copname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `identit` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phonenum` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mottoword` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `year` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`schoolnum`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of teacher
-- ----------------------------
INSERT INTO `teacher` VALUES ('zyg', '1@qq.com', '1', '朱允刚', '00000001', 'male', '计算机', 'teacher', '18300000000', '数据结构', '1999');
INSERT INTO `teacher` VALUES ('sh', '1@qq.com', '1', '宋浩', '00000003', 'male', '数学', 'teacher', '18795465975', '高等数学', '1995');
INSERT INTO `teacher` VALUES ('lxh', '1@qq.com', '1', '卢欣华', '22222222', 'female', '计算机', 'teacher', '18700000000', '离散数学', '1995');
INSERT INTO `teacher` VALUES ('lhx', '1@qq.com', '1', '刘华虓', '00000004', 'male', '计算机', 'teacher', '18795465975', '编译原理', '1996');
INSERT INTO `teacher` VALUES ('kh', '1@qq.com', '1', '康辉', '000000002', 'female', '计算机', 'teacher', '13900000000', '数据库', '1994\r\n');

-- ----------------------------
-- Table structure for timetable
-- ----------------------------
DROP TABLE IF EXISTS `timetable`;
CREATE TABLE `timetable` (
  `timeindex` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `time` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`timeindex`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of timetable
-- ----------------------------
INSERT INTO `timetable` VALUES ('2', '周一 10:00-11:40 3-4节');
INSERT INTO `timetable` VALUES ('3', '周一 13:30-15:10 5-6节');
INSERT INTO `timetable` VALUES ('4', '周一 15:30-17:10 7-8节');
INSERT INTO `timetable` VALUES ('5', '周一 18:20-19:50 9-10节');
INSERT INTO `timetable` VALUES ('6', '周一 20:00-21:30 11-12节');
INSERT INTO `timetable` VALUES ('7', '周二 8:00-9:40 1-2节');
INSERT INTO `timetable` VALUES ('8', '周二 10:00-11:40 3-4节');
INSERT INTO `timetable` VALUES ('9', '周二 13:30-15:10 5-6节');
INSERT INTO `timetable` VALUES ('10', '周二 15:30-17:10 7-8节');
INSERT INTO `timetable` VALUES ('11', '周二 18:20-19:50 9-10节');
INSERT INTO `timetable` VALUES ('12', '周二 20:00-21:30 11-12节');
INSERT INTO `timetable` VALUES ('13', '周三 8:00-9:40 1-2节');
INSERT INTO `timetable` VALUES ('14', '周三 10:00-11:40 3-4节');
INSERT INTO `timetable` VALUES ('15', '周三 13:30-15:10 5-6节');
INSERT INTO `timetable` VALUES ('16', '周三 15:30-17:10 7-8节');
INSERT INTO `timetable` VALUES ('17', '周三 18:20-19:50 9-10节');
INSERT INTO `timetable` VALUES ('18', '周三 20:00-21:30 11-12节');
INSERT INTO `timetable` VALUES ('19', '周四 8:00-9:40 1-2节');
INSERT INTO `timetable` VALUES ('20', '周四 10:00-11:40 3-4节');
INSERT INTO `timetable` VALUES ('21', '周四 13:30-15:10 5-6节');
INSERT INTO `timetable` VALUES ('22', '周四 15:30-17:10 7-8节');
INSERT INTO `timetable` VALUES ('23', '周四 18:20-19:50 9-10节');
INSERT INTO `timetable` VALUES ('24', '周四 20:00-21:30 11-12节');
INSERT INTO `timetable` VALUES ('25', '周五 8:00-9:40 1-2节');
INSERT INTO `timetable` VALUES ('26', '周五 10:00-11:40 3-4节');
INSERT INTO `timetable` VALUES ('27', '周五 13:30-15:10 5-6节');
INSERT INTO `timetable` VALUES ('28', '周五 15:30-17:10 7-8节');
INSERT INTO `timetable` VALUES ('29', '周五 18:20-19:50 9-10节');
INSERT INTO `timetable` VALUES ('30', '周五 20:00-21:30 11-12节');
INSERT INTO `timetable` VALUES ('31', '周六 8:00-9:40 1-2节');
INSERT INTO `timetable` VALUES ('32', '周六 10:00-11:40 3-4节');
INSERT INTO `timetable` VALUES ('33', '周六 13:30-15:10 5-6节');
INSERT INTO `timetable` VALUES ('34', '周六 15:30-17:10 7-8节');
INSERT INTO `timetable` VALUES ('35', '周六 18:20-19:50 9-10节');
INSERT INTO `timetable` VALUES ('36', '周六 20:00-21:30 11-12节');
INSERT INTO `timetable` VALUES ('37', '周日 8:00-9:40 1-2节');
INSERT INTO `timetable` VALUES ('38', '周日 10:00-11:40 3-4节');
INSERT INTO `timetable` VALUES ('39', '周日 13:30-15:10 5-6节');
INSERT INTO `timetable` VALUES ('40', '周日 15:30-17:10 7-8节');
INSERT INTO `timetable` VALUES ('41', '周日 18:20-19:50 9-10节');
INSERT INTO `timetable` VALUES ('42', '周日 20:00-21:30 11-12节');
INSERT INTO `timetable` VALUES ('1', '周一 8:00-9:40 1-2节');

-- ----------------------------
-- Table structure for weektable
-- ----------------------------
DROP TABLE IF EXISTS `weektable`;
CREATE TABLE `weektable` (
  `weekid` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `week` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`weekid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of weektable
-- ----------------------------
INSERT INTO `weektable` VALUES ('1', '1-6周');
INSERT INTO `weektable` VALUES ('2', '1-17周');
INSERT INTO `weektable` VALUES ('3', '1-18周');
INSERT INTO `weektable` VALUES ('4', '2-16周');
INSERT INTO `weektable` VALUES ('5', '2-17周');
INSERT INTO `weektable` VALUES ('6', '2-18周');
INSERT INTO `weektable` VALUES ('7', '3-13周');
