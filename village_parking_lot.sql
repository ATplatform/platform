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

Date: 2018-06-28 19:55:44
*/


-- ----------------------------
-- Table structure for village_parking_lot
-- ----------------------------
DROP TABLE IF EXISTS "public"."village_parking_lot";
CREATE TABLE "public"."village_parking_lot" (
"code" int4 DEFAULT nextval('village_parking_lot_code_seq'::regclass) NOT NULL,
"effective_date" timestamp(0) NOT NULL,
"effective_status" bool NOT NULL,
"parkcode" int4 NOT NULL,
"floor" int4 NOT NULL,
"biz_type" int4 NOT NULL,
"biz_status" int4 NOT NULL,
"biz_reason" int4,
"owner" int4,
"begin_date" timestamp(0),
"end_date" timestamp(0),
"linked_lot_code" int4,
"area" float4,
"monthly_rent" float4,
"bluetoothaddress" varchar(64) COLLATE "default",
"remark" text COLLATE "default"
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of village_parking_lot
-- ----------------------------
INSERT INTO "public"."village_parking_lot" VALUES ('1000001', '2018-06-27 00:00:00', 't', '1000001', '101', '101', '101', '101', '101300', '2018-06-27 15:08:17', '2018-06-27 15:08:19', '1000001', '1001', '1001', '1001', '1001');
INSERT INTO "public"."village_parking_lot" VALUES ('1000002', '2018-06-27 00:00:00', 't', '1000001', '102', '101', '102', '102', '100531', '2018-06-27 00:00:00', '2018-06-29 00:00:00', '1000001', '1001', '1001', '1001', '1001');

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table village_parking_lot
-- ----------------------------
ALTER TABLE "public"."village_parking_lot" ADD PRIMARY KEY ("code");
