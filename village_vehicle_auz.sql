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

Date: 2018-06-28 19:55:09
*/


-- ----------------------------
-- Table structure for village_vehicle_auz
-- ----------------------------
DROP TABLE IF EXISTS "public"."village_vehicle_auz";
CREATE TABLE "public"."village_vehicle_auz" (
"code" int4 DEFAULT nextval('village_vehicle_auz_code_seq'::regclass) NOT NULL,
"village_id" int4,
"vehicle_code" int4,
"person_code" int4,
"begin_date" timestamp(6),
"end_date" timestamp(6),
"remark" varchar(256) COLLATE "default",
"create_time" timestamp(6)
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of village_vehicle_auz
-- ----------------------------
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000001', null, '1000005', '101301', '2018-06-25 00:00:00', '2018-06-25 00:00:00', null, '2018-06-25 09:16:30');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000002', null, '1000005', '100707', '2018-06-25 00:00:00', '2018-06-25 00:00:00', null, '2018-06-25 09:18:49');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000003', null, '1000006', '101300', '2018-06-25 00:00:00', '2018-06-25 00:00:00', null, '2018-06-25 09:21:08');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000004', null, '1000007', '101301', '2018-06-25 00:00:00', '2018-06-26 00:00:00', null, '2018-06-25 09:24:47');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000005', null, '1000008', '101301', '2018-06-25 00:00:00', '2018-06-26 00:00:00', null, '2018-06-25 09:55:35');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000006', null, '1000009', '101301', '2018-06-25 00:00:00', '2099-11-01 00:00:00', null, '2018-06-25 09:55:46');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000007', null, '1000009', '101301', '2018-06-25 00:00:00', '2099-11-01 00:00:00', '无', '2018-06-25 07:40:48');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000008', null, '1000009', '101301', '2018-06-25 00:00:00', '2099-11-01 00:00:00', '无sdasd', '2018-06-25 07:40:57');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000009', null, '1000005', '101301', '2018-06-25 00:00:00', '2099-11-01 00:00:00', '无sdasd', '2018-06-25 07:40:57');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000010', null, '1000008', '101301', '2018-06-25 00:00:00', '2018-06-16 00:00:00', '无', '2018-06-26 10:31:01');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000011', null, '1000008', '101301', '2018-06-25 00:00:00', '2018-06-30 00:00:00', '无', '2018-06-26 10:31:11');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000012', null, '1000010', '101301', '2018-06-26 00:00:00', '2099-12-31 00:00:00', null, '2018-06-26 04:08:14');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000013', null, '1000011', '100707', '2018-06-30 00:00:00', '2099-12-31 00:00:00', null, '2018-06-26 04:08:26');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000014', null, '1000012', '101301', '2018-07-01 00:00:00', '2099-12-31 00:00:00', null, '2018-06-26 04:09:23');
INSERT INTO "public"."village_vehicle_auz" VALUES ('1000015', null, '1000007', '101301', '2018-06-25 00:00:00', '2018-06-26 00:00:00', '无', '2018-06-27 06:07:26');

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table village_vehicle_auz
-- ----------------------------
ALTER TABLE "public"."village_vehicle_auz" ADD PRIMARY KEY ("code");
