/*
Navicat PGSQL Data Transfer

Source Server         : 192.168.18.32
Source Server Version : 90500
Source Host           : 192.168.18.32:5432
Source Database       : postgres
Source Schema         : public

Target Server Type    : PGSQL
Target Server Version : 90500
File Encoding         : 65001

Date: 2018-06-28 19:55:27
*/


-- ----------------------------
-- Table structure for village_person
-- ----------------------------
DROP TABLE IF EXISTS "public"."village_person";
CREATE TABLE "public"."village_person" (
"id" int4 DEFAULT nextval('village_person_id_seq'::regclass) NOT NULL,
"village_id" int4,
"last_name" varchar(32) COLLATE "default",
"first_name" varchar(32) COLLATE "default",
"id_type" int2,
"id_number" varchar(32) COLLATE "default",
"nationality" varchar(32) COLLATE "default",
"gender" int2,
"birth_date" varchar(32) COLLATE "default",
"blood_type" int2,
"ethnicity" int2,
"if_disabled" bool,
"tel_country" varchar(32) COLLATE "default",
"mobile_number" varchar(32) COLLATE "default",
"oth_mob_no" varchar(32) COLLATE "default",
"remark" varchar(128) COLLATE "default",
"create_person" int4,
"create_time" timestamp(6),
"code" int4,
"portrait" varchar(128) COLLATE "default",
"nickname" varchar(32) COLLATE "default",
"qr_code" varchar(255) COLLATE "default"
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of village_person
-- ----------------------------
INSERT INTO "public"."village_person" VALUES ('1', '100001', '张', '志平', '101', '362502198410272632', '中国', '101', '1984-10-27', '104', '101', 'f', '中国', '13728083085', null, null, null, null, '100707', null, null, null);
INSERT INTO "public"."village_person" VALUES ('8', '100001', '张', '超', '101', '230227199310091513', '中国', '101', '1993-10-09', '102', '101', 'f', '中国', '13530625698', 'null', '', null, null, '100197', null, null, null);
INSERT INTO "public"."village_person" VALUES ('9', '100001', '叶', '万华', '101', null, '中国', '101', '1985-03-12', null, '101', 'f', '中国', '13530625697', null, null, null, null, '100252', null, null, null);
INSERT INTO "public"."village_person" VALUES ('28', '100001', '邵', '同举', '101', null, '中国', '101', '1957-05-25', null, '101', 'f', '中国', '13530625699', null, null, null, null, '100531', null, null, null);
INSERT INTO "public"."village_person" VALUES ('101', '100001', '林', '蒙蒙', '101', null, '中国', '102', '1990-11-09', null, '101', 'f', '中国', '13516659116', null, null, null, null, '100094', null, null, null);
INSERT INTO "public"."village_person" VALUES ('104', '100001', '想', 'x', '102', '54353', '澳门', '101', '2018-06-01', '102', '102', 'f', '中国', '13058064096', null, '', null, '2018-06-14 07:06:10', '101296', null, null, null);
INSERT INTO "public"."village_person" VALUES ('105', '100001', '张', '飞', '102', '545465465', '香港', '101', '2018-06-01', '101', '101', 'f', '中国', '13058064096', null, '', null, '2018-06-14 07:09:07', '101297', null, null, null);
INSERT INTO "public"."village_person" VALUES ('107', '100001', '陈', '梦', '101', '440582199909224444', '中国', '102', '1999-09-22', '102', '102', 'f', '中国', '13600000000', null, '', null, '2018-06-15 09:35:54', '101299', null, null, null);
INSERT INTO "public"."village_person" VALUES ('108', '100001', '雷', '诗敏', '102', '12345', '香港', '102', '2018-06-14', '101', '101', 'f', '中国', '13600000002', '13750522719', '', null, '2018-06-15 04:03:16', '101300', null, null, null);
INSERT INTO "public"."village_person" VALUES ('110', '100001', '董', '先生', '103', '3019', '新加坡', '101', '2010-02-03', '101', '101', 'f', '中国', '15537876353', null, '', null, '2018-06-20 11:02:28', '101301', null, null, null);
INSERT INTO "public"."village_person" VALUES ('111', '100001', '里', '111', '103', '342432', '香港', '101', '2018-06-01', '101', '101', 'f', '中国', '13058064096', null, '', null, '2018-06-21 05:56:04', '101302', null, null, null);
INSERT INTO "public"."village_person" VALUES ('112', '100001', '雷', 'ssss', '103', '232323', '香港', '102', '2018-06-12', '102', '102', 'f', '中国', '13750522719', null, '', null, '2018-06-25 06:18:13', '101303', null, null, null);

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table village_person
-- ----------------------------
ALTER TABLE "public"."village_person" ADD PRIMARY KEY ("id");
