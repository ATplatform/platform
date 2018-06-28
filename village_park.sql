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

Date: 2018-06-28 19:55:51
*/


-- ----------------------------
-- Table structure for village_park
-- ----------------------------
DROP TABLE IF EXISTS "public"."village_park";
CREATE TABLE "public"."village_park" (
"parkcode" int4 DEFAULT nextval('village_park_parkcode_seq'::regclass) NOT NULL,
"parkname" text COLLATE "default",
"totalspace" int4,
"totalbookspace" int4,
"telephone" text COLLATE "default",
"address" text COLLATE "default",
"chargestandard" text COLLATE "default",
"tempstandard" text COLLATE "default",
"monthstandard" text COLLATE "default",
"cardtype" text COLLATE "default",
"monthperiod" text COLLATE "default",
"cardcharge" float4,
"bookmoney" float4,
"duration" float4,
"void_timeslot" float4,
"void_timeslot_charged" float4,
"photo_url_ids" text COLLATE "default",
"attach" text COLLATE "default"
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of village_park
-- ----------------------------
INSERT INTO "public"."village_park" VALUES ('1000001', '停车场1', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table village_park
-- ----------------------------
ALTER TABLE "public"."village_park" ADD PRIMARY KEY ("parkcode");
