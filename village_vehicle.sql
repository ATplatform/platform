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

Date: 2018-06-28 19:55:17
*/


-- ----------------------------
-- Table structure for village_vehicle
-- ----------------------------
DROP TABLE IF EXISTS "public"."village_vehicle";
CREATE TABLE "public"."village_vehicle" (
"code" int4 DEFAULT nextval('village_vehicle_code_seq'::regclass) NOT NULL,
"effective_date" timestamp(6),
"effective_status" bool,
"village_id" int4,
"person_code" int4,
"vehicle_type" int4,
"if_electro" bool,
"licence" varchar(64) COLLATE "default",
"if_temp" bool,
"owner" varchar(32) COLLATE "default",
"brand" varchar(32) COLLATE "default",
"model" varchar(32) COLLATE "default",
"color" varchar(32) COLLATE "default",
"remark" varchar(256) COLLATE "default",
"create_time" timestamp(6),
"if_resident" bool
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of village_vehicle
-- ----------------------------
INSERT INTO "public"."village_vehicle" VALUES ('2', null, 't', null, null, null, null, '粤-Q10000', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('3', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('4', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('5', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('12', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('13', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('14', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('15', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('16', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('17', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('18', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('19', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('20', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('21', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('22', null, 't', null, null, null, null, '粤-F55555', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('23', null, 't', null, null, null, null, '粤-B12338', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('1000001', null, 't', null, null, null, null, '粤-Q10000', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('1000002', null, 't', null, null, null, null, '粤-Q10000', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('1000003', null, 't', null, null, null, null, '粤-Q10000', null, null, null, null, null, null, null, null);
INSERT INTO "public"."village_vehicle" VALUES ('1000005', '2018-06-25 00:00:00', 't', null, '101301', '103', 'f', '32142', 't', null, '1', null, '1', null, '2018-06-25 09:18:49', 't');
INSERT INTO "public"."village_vehicle" VALUES ('1000006', '2018-06-25 00:00:00', 't', null, '101301', '103', 'f', 'asd', 't', null, null, null, null, null, '2018-06-25 09:21:08', 't');
INSERT INTO "public"."village_vehicle" VALUES ('1000007', '2018-06-25 00:00:00', 'f', null, '101301', '103', 'f', 'sad', 'f', '1', '1', '1', '1', null, '2018-06-25 06:07:49', 't');
INSERT INTO "public"."village_vehicle" VALUES ('1000008', '2018-06-25 00:00:00', 't', null, '100707', '102', 'f', '345', 'f', null, '1', '1', null, null, '2018-06-25 06:11:05', 't');
INSERT INTO "public"."village_vehicle" VALUES ('1000009', '2018-06-25 00:00:00', 't', null, '100531', '103', 't', '435', 't', 'sadasdsad', null, '1', '1', null, '2018-06-25 06:27:29', 'f');
INSERT INTO "public"."village_vehicle" VALUES ('1000010', '2018-06-26 00:00:00', 't', null, '101301', '103', 'f', 'sad', 't', null, null, null, null, null, '2018-06-26 04:08:14', 't');
INSERT INTO "public"."village_vehicle" VALUES ('1000011', '2018-06-26 00:00:00', 't', null, '100531', '104', 'f', '23423', 't', null, null, null, null, null, '2018-06-26 04:08:26', 't');
INSERT INTO "public"."village_vehicle" VALUES ('1000012', '2018-06-26 00:00:00', 't', null, '101301', '103', 'f', '456', 't', null, null, null, null, null, '2018-06-26 04:09:23', 't');
INSERT INTO "public"."village_vehicle" VALUES ('1000013', '2018-06-26 00:00:00', 't', null, '101301', '103', 'f', '456', 't', null, null, null, null, null, '2018-06-26 04:09:23', 't');

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table village_vehicle
-- ----------------------------
ALTER TABLE "public"."village_vehicle" ADD PRIMARY KEY ("code");
