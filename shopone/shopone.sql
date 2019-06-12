/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : shopone

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 11/06/2019 18:09:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for my_admin
-- ----------------------------
DROP TABLE IF EXISTS `my_admin`;
CREATE TABLE `my_admin`  (
  `aid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `admin_password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `admin_create_time` int(11) NULL DEFAULT NULL,
  `ad,om_update_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`aid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_admin
-- ----------------------------
INSERT INTO `my_admin` VALUES (1, 'admin', '1b3ae77a2e06580c8cb57e112ddc4a26', NULL, NULL);

-- ----------------------------
-- Table structure for my_banner
-- ----------------------------
DROP TABLE IF EXISTS `my_banner`;
CREATE TABLE `my_banner`  (
  `bid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '轮播图ID',
  `banner_picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `banner_sequence` int(255) NULL DEFAULT NULL,
  `banner_create_time` int(11) NULL DEFAULT NULL,
  `banner_update_time` int(11) NULL DEFAULT NULL,
  `banner_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`bid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_banner
-- ----------------------------
INSERT INTO `my_banner` VALUES (1, '5cf09fea489b7.jpg', 1, 1559273450, 1559273450, '测试1');
INSERT INTO `my_banner` VALUES (2, '5cf0a00d675f0.jpg', 2, 1559273485, 1559273485, '测试2');
INSERT INTO `my_banner` VALUES (3, '5cf0a017d1795.jpg', 3, 1559273495, 1559273495, '测试3');

-- ----------------------------
-- Table structure for my_commission_log
-- ----------------------------
DROP TABLE IF EXISTS `my_commission_log`;
CREATE TABLE `my_commission_log`  (
  `cid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '佣金id',
  `commission_value` decimal(50, 2) NULL DEFAULT NULL COMMENT '佣金金额',
  `commission_create_time` int(20) NULL DEFAULT NULL,
  `commission_update_time` int(20) NULL DEFAULT NULL,
  `user_id` int(50) NULL DEFAULT 1 COMMENT '记录归属用户ID',
  `commission_cate` int(50) NULL DEFAULT NULL COMMENT '佣金记录类型（1获取，2提现）',
  `money_id` int(50) NULL DEFAULT NULL COMMENT '充值的ID',
  `recharge_money_value` int(50) NULL DEFAULT NULL COMMENT '充值的金额',
  `recharge_user_id` int(11) NULL DEFAULT NULL COMMENT '充值的用户',
  PRIMARY KEY (`cid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of my_commission_log
-- ----------------------------
INSERT INTO `my_commission_log` VALUES (1, 47.94, 1560152266, 1560152266, 100000, 1, 12, 799, 100002);
INSERT INTO `my_commission_log` VALUES (2, 7.99, 1560152266, 1560152266, 100001, 1, 12, 799, 100002);
INSERT INTO `my_commission_log` VALUES (3, 47.94, 1560152856, 1560152856, 100002, 1, 14, 799, 100004);
INSERT INTO `my_commission_log` VALUES (4, 23.97, 1560152856, 1560152856, 100001, 1, 14, 799, 100004);
INSERT INTO `my_commission_log` VALUES (5, 23.94, 1560152860, 1560152860, 100002, 1, 13, 399, 100003);
INSERT INTO `my_commission_log` VALUES (6, 11.97, 1560152860, 1560152860, 100001, 1, 13, 399, 100003);
INSERT INTO `my_commission_log` VALUES (7, 1.00, 1560215408, 1560215408, 100002, 2, NULL, NULL, NULL);
INSERT INTO `my_commission_log` VALUES (8, 2.00, 1560215481, 1560215481, 100002, 2, NULL, NULL, NULL);
INSERT INTO `my_commission_log` VALUES (9, 47.94, 1560241440, 1560241440, 100001, 1, 18, 799, 100002);
INSERT INTO `my_commission_log` VALUES (10, 31.96, 1560241440, 1560241440, 100000, 1, 18, 799, 100002);
INSERT INTO `my_commission_log` VALUES (11, 47.94, 1560241684, 1560241684, 100001, 1, 19, 799, 100002);
INSERT INTO `my_commission_log` VALUES (12, 31.96, 1560241684, 1560241684, 100000, 1, 19, 799, 100002);
INSERT INTO `my_commission_log` VALUES (13, 23.94, 1560245628, 1560245628, 100002, 1, 22, 399, 100006);
INSERT INTO `my_commission_log` VALUES (14, 11.97, 1560245628, 1560245628, 100001, 1, 22, 399, 100006);
INSERT INTO `my_commission_log` VALUES (15, 47.94, 1560246590, 1560246590, 100002, 1, 25, 799, 100006);
INSERT INTO `my_commission_log` VALUES (16, 23.97, 1560246590, 1560246590, 100001, 1, 25, 799, 100006);
INSERT INTO `my_commission_log` VALUES (17, 47.94, 1560246593, 1560246593, 100002, 1, 24, 799, 100006);
INSERT INTO `my_commission_log` VALUES (18, 23.97, 1560246593, 1560246593, 100001, 1, 24, 799, 100006);

-- ----------------------------
-- Table structure for my_feedback
-- ----------------------------
DROP TABLE IF EXISTS `my_feedback`;
CREATE TABLE `my_feedback`  (
  `fid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '意见反馈ID  Feedback',
  `feedback_text` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '反馈内容',
  `user_id` int(50) NULL DEFAULT NULL COMMENT '用户ID',
  `feedback_create_time` int(50) NULL DEFAULT NULL,
  `feedback_update_time` int(50) NULL DEFAULT NULL,
  `contact_mode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系方式',
  PRIMARY KEY (`fid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_feedback
-- ----------------------------
INSERT INTO `my_feedback` VALUES (1, '345', 100001, 1560134365, 1560134365, '345');
INSERT INTO `my_feedback` VALUES (2, '做的不错', 100001, 1560134383, 1560134383, '123');

-- ----------------------------
-- Table structure for my_goods
-- ----------------------------
DROP TABLE IF EXISTS `my_goods`;
CREATE TABLE `my_goods`  (
  `gid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `goods_new_price` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '商品最近价格',
  `goods_old_price` decimal(10, 2) NULL DEFAULT 0.00 COMMENT '商品原来的价格',
  `goods_content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '商品图文描述',
  `goods_picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '商品图片',
  `goods_sell_number` int(10) NOT NULL DEFAULT 0 COMMENT '商品销量',
  `goods_seqencing` int(255) NULL DEFAULT NULL,
  `goods_create_time` int(11) NULL DEFAULT NULL,
  `goods_update_time` int(11) NULL DEFAULT NULL,
  `goods_category` int(50) NULL DEFAULT NULL COMMENT '三级分类',
  `goods_category_path_one` int(50) NULL DEFAULT NULL COMMENT '一级分类',
  `goods_category_path_two` int(50) NULL DEFAULT NULL COMMENT '二级分类',
  `goods_status` int(255) NULL DEFAULT 1 COMMENT '商品状态,1上架，2下架',
  `goods_plate` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '归属板块',
  `goods_is_postage` int(50) NULL DEFAULT 1 COMMENT '是否包邮，1包邮，2不包邮',
  PRIMARY KEY (`gid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_goods
-- ----------------------------
INSERT INTO `my_goods` VALUES (1, '商品测试1', 100.00, 120.00, '<p>11111111111111</p>', '5cf094a38a028.jpg', 0, 1, 1559270563, 1559530840, 16, 3, 5, 1, '1_2_3_5', 1);
INSERT INTO `my_goods` VALUES (2, '商品测试2', 300.00, 290.00, '<p>1111111111111</p>', '5cf0997f7e926.jpg', 0, 1, 1559271807, 1559531206, 18, 3, 5, 1, '2_3_4_5', 1);
INSERT INTO `my_goods` VALUES (3, '商品测试31', 1501.00, 1201.00, '<p>11111111111111113333334</p>', '5cf09c26d6ea7.jpg', 0, 31, 1559271998, 1559531058, 16, 3, 5, 1, '1_2_3_4_5', 2);
INSERT INTO `my_goods` VALUES (4, '商品测试', 100.00, 130.00, '<p>1111111111111111111111111111111111111111111111</p>', '5cf48632c7edf.jpg', 0, 1, 1559529010, 1559531183, 20, 3, 6, 1, '', 2);
INSERT INTO `my_goods` VALUES (5, '商品测试商品测试商品测试商品测试商品测试商品测试商品测试商品测试商品测试商品测试商品测试商品测试商品测试商品测试商品测试商品测试商品测试商品测试', 100.00, 130.00, '<p>1111111111111111111111111111111111111111111111222222222222222222222222222222222222222222222222222222222222222222222222</p><p><br/></p><p><br/></p><p>324234</p>', '5cf48648e4508.jpg', 0, 1, 1559529032, 1559543227, 20, 3, 6, 2, '1_2_3_4_5', 1);
INSERT INTO `my_goods` VALUES (6, '天然睡美人蓝松925纯银镀24K金重工弹力手镯 ', 1.00, 1.00, '<p style=\"text-align: center;\"><img src=\"/ueditor/php/upload/image/20190603/1559540373106185.jpg\" title=\"1559540373106185.jpg\" alt=\"timg (1).jpg\"/><img src=\"/ueditor/php/upload/image/20190603/1559540374124684.jpg\" title=\"1559540374124684.jpg\" alt=\"timg (4).jpg\"/><img src=\"/ueditor/php/upload/image/20190603/1559540374984050.jpg\" title=\"1559540374984050.jpg\" alt=\"timg (3).jpg\"/><img src=\"/ueditor/php/upload/image/20190603/1559540374593924.jpg\" title=\"1559540374593924.jpg\" alt=\"timg (2).jpg\"/></p>', '5cf48753c9091.jpg', 0, 1, 1559529299, 1559540395, 19, 3, 5, 1, '1_2_3_4_5', 1);
INSERT INTO `my_goods` VALUES (7, '商品测试1', 100.00, 150.00, '<p><img src=\"/ueditor/php/upload/image/20190611/1560238923148201.jpg\" title=\"1560238923148201.jpg\" alt=\"timg (1).jpg\"/></p>', '5cff5b4e48d2a.jpg', 0, 1, 1560238926, 1560238926, 22, 17, 21, 2, '1_2_3_4_5', 1);

-- ----------------------------
-- Table structure for my_goods_category
-- ----------------------------
DROP TABLE IF EXISTS `my_goods_category`;
CREATE TABLE `my_goods_category`  (
  `cid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '类别ID',
  `category_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '类别名称',
  `category_create_time` int(11) NULL DEFAULT NULL,
  `category_update_time` int(11) NULL DEFAULT NULL,
  `category_level` int(10) NULL DEFAULT 1,
  `category_path` int(255) NULL DEFAULT 0,
  `category_sequence` int(255) NULL DEFAULT NULL,
  `category_picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`cid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_goods_category
-- ----------------------------
INSERT INTO `my_goods_category` VALUES (3, '手饰', 1559210213, 1559210213, 1, 0, 1, NULL);
INSERT INTO `my_goods_category` VALUES (4, '耳饰', 1559210371, 1559210371, 1, 0, 2, NULL);
INSERT INTO `my_goods_category` VALUES (5, '银饰', 1559210857, 1559210857, 1, 3, 1, NULL);
INSERT INTO `my_goods_category` VALUES (6, '水晶玛瑙', 1559210894, 1559210894, 1, 3, 2, NULL);
INSERT INTO `my_goods_category` VALUES (7, '内衣', 1559211708, 1559211708, 1, 0, 3, NULL);
INSERT INTO `my_goods_category` VALUES (8, '红酒', 1559211715, 1559211715, 1, 0, 4, NULL);
INSERT INTO `my_goods_category` VALUES (9, '饮料', 1559211754, 1559211754, 1, 0, 5, NULL);
INSERT INTO `my_goods_category` VALUES (10, '调味', 1559211774, 1559211774, 1, 0, 7, NULL);
INSERT INTO `my_goods_category` VALUES (11, '日化', 1559211791, 1559211791, 1, 0, 8, NULL);
INSERT INTO `my_goods_category` VALUES (12, '蛋糕', 1559211805, 1559211805, 1, 0, 9, NULL);
INSERT INTO `my_goods_category` VALUES (13, '健康', 1559211816, 1559211816, 1, 0, 10, NULL);
INSERT INTO `my_goods_category` VALUES (14, '水果蛋糕', 1559211844, 1559211844, 1, 12, 1, NULL);
INSERT INTO `my_goods_category` VALUES (15, '奶油蛋糕', 1559211865, 1559211865, 1, 12, 2, NULL);
INSERT INTO `my_goods_category` VALUES (16, '银手镯', 1559264694, 1559264694, 1, 5, 1, '5cf08a0a357d5.jpg');
INSERT INTO `my_goods_category` VALUES (17, '情侣戒指', 1559265360, 1559265360, 1, 0, 2, NULL);
INSERT INTO `my_goods_category` VALUES (18, '宝宝银饰', 1559266683, 1559266683, 1, 5, 3, '5cf0857b8db0d.jpg');
INSERT INTO `my_goods_category` VALUES (19, '宝宝银饰', 1559267933, 1559267933, 1, 5, 4, '5cf08a5d0709d.jpg');
INSERT INTO `my_goods_category` VALUES (20, '玛瑙', 1559268005, 1559268005, 1, 6, 1, '5cf08aa5683da.jpg');
INSERT INTO `my_goods_category` VALUES (21, '情侣对戒', 1559292218, 1559292218, 1, 17, 3, '5cf0e93a9ce68.jpg');
INSERT INTO `my_goods_category` VALUES (22, '文字对戒', 1559531336, 1559531336, 1, 21, 222, '5cf48f4844188.jpg');

-- ----------------------------
-- Table structure for my_goods_status
-- ----------------------------
DROP TABLE IF EXISTS `my_goods_status`;
CREATE TABLE `my_goods_status`  (
  `sid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`sid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_goods_status
-- ----------------------------
INSERT INTO `my_goods_status` VALUES (1, '上架');
INSERT INTO `my_goods_status` VALUES (2, '下架');

-- ----------------------------
-- Table structure for my_message
-- ----------------------------
DROP TABLE IF EXISTS `my_message`;
CREATE TABLE `my_message`  (
  `mid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT,
  `message_taitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `message_create_time` int(20) NULL DEFAULT NULL,
  `message_update_time` int(20) NULL DEFAULT NULL,
  `message_content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `message_user_id` int(50) NULL DEFAULT NULL,
  `message_cate` int(11) NULL DEFAULT 1 COMMENT '消息类型',
  `message_status` int(10) NULL DEFAULT 1 COMMENT '消息查看状态，1未读，2已读',
  PRIMARY KEY (`mid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_message
-- ----------------------------
INSERT INTO `my_message` VALUES (1, '充值信息审核不通过', 1560244045, 1560244045, '审核不通过测试1111111111111111111111111111', 100002, 1, 1);
INSERT INTO `my_message` VALUES (2, '订单已发货', 1560245005, 1560245005, '您的订单已经发货，快递公司：顺丰快递快递编号：000001请注意查收快递！', 100002, 3, 1);
INSERT INTO `my_message` VALUES (3, '充值信息审核不通过', 1560245602, 1560245602, '充值凭证看不清，请上传清楚的充值凭证', 100006, 1, 1);
INSERT INTO `my_message` VALUES (4, '订单已发货', 1560245890, 1560245890, '您的订单已经发货，快递公司：申通快递,快递编号：03131321321,请注意查收快递！', 100006, 3, 1);

-- ----------------------------
-- Table structure for my_message_cate
-- ----------------------------
DROP TABLE IF EXISTS `my_message_cate`;
CREATE TABLE `my_message_cate`  (
  `sid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`sid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_message_cate
-- ----------------------------
INSERT INTO `my_message_cate` VALUES (1, '充值审核');
INSERT INTO `my_message_cate` VALUES (2, '提现打款');
INSERT INTO `my_message_cate` VALUES (3, '订单');

-- ----------------------------
-- Table structure for my_notice
-- ----------------------------
DROP TABLE IF EXISTS `my_notice`;
CREATE TABLE `my_notice`  (
  `nid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '公告ID',
  `notice_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `notice_create_time` int(11) NULL DEFAULT NULL,
  `notice_update_time` int(11) NULL DEFAULT NULL,
  `notice_content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '公告内容',
  `notice_order` int(255) NULL DEFAULT NULL COMMENT '显示顺序',
  PRIMARY KEY (`nid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_notice
-- ----------------------------
INSERT INTO `my_notice` VALUES (1, '公告测试111111', 1559274646, 1559274646, '<p>公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111公告测试111111</p>', 1);
INSERT INTO `my_notice` VALUES (3, '公告测试222222222221', 1559274985, 1559275100, '<p>1111111111111</p>', 22);

-- ----------------------------
-- Table structure for my_order
-- ----------------------------
DROP TABLE IF EXISTS `my_order`;
CREATE TABLE `my_order`  (
  `oid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `user_id` int(10) NOT NULL COMMENT '用户ID',
  `order_number` varchar(18) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单编号',
  `order_create_time` int(11) NULL DEFAULT NULL,
  `order_update_time` int(11) NULL DEFAULT NULL,
  `order_total_price` decimal(50, 2) NULL DEFAULT NULL,
  `order_status` int(5) NULL DEFAULT 1 COMMENT '订单状态',
  `order_address_id` int(11) NULL DEFAULT NULL COMMENT '收货地址ID',
  `order_pay_time` int(20) NULL DEFAULT NULL COMMENT '订单支付时间',
  `order_goods_total` int(255) NULL DEFAULT NULL COMMENT '订单商品总数',
  `order_cancel_status` int(255) NULL DEFAULT 1 COMMENT '订单取消状态（1正常，2取消）',
  `order_address_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `order_address_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `order_address_text` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `express_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '快递公司',
  `express_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '快递编号',
  PRIMARY KEY (`oid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 49 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_order
-- ----------------------------
INSERT INTO `my_order` VALUES (38, 100001, 'SHOP15601284342728', 1560128434, 1560128434, 300.00, 2, 10, 1560128434, 3, 1, '13027739565', '地址测试', '1233333333333333331231233333', NULL, NULL);
INSERT INTO `my_order` VALUES (37, 100001, 'SHOP15601282145601', 1560128214, 1560128214, 300.00, 2, 10, 1560128214, 1, 1, '13027739565', '地址测试', '1233333333333333331231233333', NULL, NULL);
INSERT INTO `my_order` VALUES (43, 100001, 'SHOP15601330521019', 1560133052, 1560133052, 200.00, 2, 10, 1560133052, 2, 1, '13027739565', '地址测试', '1233333333333333331231233333', NULL, NULL);
INSERT INTO `my_order` VALUES (42, 100001, 'SHOP15601329153145', 1560132915, 1560132915, 100.00, 2, 10, 1560132915, 1, 1, '13027739565', '地址测试', '1233333333333333331231233333', NULL, NULL);
INSERT INTO `my_order` VALUES (41, 100001, 'SHOP15601328472119', 1560132847, 1560132847, 102.00, 2, 10, 1560132847, 3, 1, '13027739565', '地址测试', '1233333333333333331231233333', NULL, NULL);
INSERT INTO `my_order` VALUES (32, 100001, 'SHOP15597933874268', 1559793387, 1559793387, 2.00, 1, 10, NULL, 2, 2, '13027739565', '地址测试', '1233333333333333331231233333', NULL, NULL);
INSERT INTO `my_order` VALUES (39, 100001, 'SHOP15601316317736', 1560131631, 1560131631, 101.00, 2, 10, 1560131632, 2, 1, '13027739565', '地址测试', '1233333333333333331231233333', NULL, NULL);
INSERT INTO `my_order` VALUES (44, 100002, 'SHOP15601590363025', 1560159036, 1560159036, 100.00, 2, 11, 1560159036, 1, 1, '13027739565', '刘伟超', '河南省郑州市郑东新区郑东商业中心C区2号楼706', NULL, NULL);
INSERT INTO `my_order` VALUES (45, 100002, 'SHOP15602160397586', 1560216039, 1560216039, 1.00, 3, 11, 1560216039, 1, 1, '13027739565', '刘伟超', '河南省郑州市郑东新区郑东商业中心C区2号楼706', '顺丰快递', '000001');
INSERT INTO `my_order` VALUES (46, 100002, 'SHOP15602160676968', 1560216067, 1560216067, 16511.00, 1, 11, NULL, 11, 1, '13027739565', '刘伟超', '河南省郑州市郑东新区郑东商业中心C区2号楼706', NULL, NULL);
INSERT INTO `my_order` VALUES (47, 100002, 'SHOP15602172538038', 1560217253, 1560217253, 401.00, 3, 11, 1560217253, 3, 1, '13027739565', '刘伟超', '河南省郑州市郑东新区郑东商业中心C区2号楼706', '发货测试', '001');
INSERT INTO `my_order` VALUES (48, 100006, 'SHOP15602457053167', 1560245705, 1560245705, 200.00, 4, 12, 1560245705, 2, 1, '13027739565', '河南郑州', '河南省郑州市郑东商业中心C区2号楼706', '申通快递', '03131321321');

-- ----------------------------
-- Table structure for my_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `my_order_goods`;
CREATE TABLE `my_order_goods`  (
  `ogid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_id` int(10) NULL DEFAULT NULL COMMENT '商品ID',
  `order_id` int(10) NULL DEFAULT NULL COMMENT '订单ID',
  `order_goods_create_time` int(11) NULL DEFAULT NULL,
  `order_goods_update_time` int(11) NULL DEFAULT NULL,
  `order_goods_number` int(10) NULL DEFAULT NULL COMMENT '数量',
  `order_goods_unit_price` decimal(50, 2) NULL DEFAULT NULL COMMENT '单价',
  `order_goods_total_price` decimal(50, 2) NULL DEFAULT NULL COMMENT '总价',
  PRIMARY KEY (`ogid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of my_order_goods
-- ----------------------------
INSERT INTO `my_order_goods` VALUES (17, 5, 42, 1560132915, 1560132915, 1, 100.00, 100.00);
INSERT INTO `my_order_goods` VALUES (16, 6, 41, 1560132847, 1560132847, 2, 1.00, 2.00);
INSERT INTO `my_order_goods` VALUES (15, 5, 41, 1560132847, 1560132847, 1, 100.00, 100.00);
INSERT INTO `my_order_goods` VALUES (5, 6, 32, 1559793387, 1559793387, 2, 1.00, 2.00);
INSERT INTO `my_order_goods` VALUES (18, 5, 43, 1560133052, 1560133052, 2, 100.00, 200.00);
INSERT INTO `my_order_goods` VALUES (10, 2, 37, 1560128214, 1560128214, 1, 300.00, 300.00);
INSERT INTO `my_order_goods` VALUES (11, 5, 38, 1560128434, 1560128434, 3, 100.00, 300.00);
INSERT INTO `my_order_goods` VALUES (12, 6, 39, 1560131631, 1560131631, 1, 1.00, 1.00);
INSERT INTO `my_order_goods` VALUES (13, 5, 39, 1560131631, 1560131631, 1, 100.00, 100.00);
INSERT INTO `my_order_goods` VALUES (19, 1, 44, 1560159036, 1560159036, 1, 100.00, 100.00);
INSERT INTO `my_order_goods` VALUES (20, 6, 45, 1560216039, 1560216039, 1, 1.00, 1.00);
INSERT INTO `my_order_goods` VALUES (21, 3, 46, 1560216067, 1560216067, 11, 1501.00, 16511.00);
INSERT INTO `my_order_goods` VALUES (22, 2, 47, 1560217253, 1560217253, 1, 300.00, 300.00);
INSERT INTO `my_order_goods` VALUES (23, 6, 47, 1560217253, 1560217253, 1, 1.00, 1.00);
INSERT INTO `my_order_goods` VALUES (24, 5, 47, 1560217253, 1560217253, 1, 100.00, 100.00);
INSERT INTO `my_order_goods` VALUES (25, 1, 48, 1560245705, 1560245705, 2, 100.00, 200.00);

-- ----------------------------
-- Table structure for my_order_status
-- ----------------------------
DROP TABLE IF EXISTS `my_order_status`;
CREATE TABLE `my_order_status`  (
  `sid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '状态ID',
  `status_name_one` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status_name_two` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `show_status` int(255) NULL DEFAULT 1,
  `status_icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`sid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_order_status
-- ----------------------------
INSERT INTO `my_order_status` VALUES (1, '待付款', '未付款', 1, NULL);
INSERT INTO `my_order_status` VALUES (2, '待发货', '未发货', 1, NULL);
INSERT INTO `my_order_status` VALUES (3, '待收货', '未收货', 1, NULL);
INSERT INTO `my_order_status` VALUES (4, '已完成', '已完成', 1, NULL);
INSERT INTO `my_order_status` VALUES (0, '全部', NULL, 0, NULL);

-- ----------------------------
-- Table structure for my_plate
-- ----------------------------
DROP TABLE IF EXISTS `my_plate`;
CREATE TABLE `my_plate`  (
  `pid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '板块ID',
  `plate_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '板块名称',
  `plate_order` int(100) NULL DEFAULT 1 COMMENT '板块排序',
  `plate_create_time` int(11) NULL DEFAULT NULL,
  `plate_update_time` int(11) NULL DEFAULT NULL,
  `plate_picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '板块图片',
  PRIMARY KEY (`pid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_plate
-- ----------------------------
INSERT INTO `my_plate` VALUES (1, '热卖尖货', 1, 1559384974, 1559384974, NULL);
INSERT INTO `my_plate` VALUES (2, '每日精选', 2, 1559384974, 1559384974, NULL);
INSERT INTO `my_plate` VALUES (3, '精品热卖', 3, 1559384974, 1559384974, NULL);
INSERT INTO `my_plate` VALUES (4, '商品优选', 4, 1559384974, 1559384974, NULL);
INSERT INTO `my_plate` VALUES (5, '推荐商品', 5, 1559384974, 1559384974, NULL);

-- ----------------------------
-- Table structure for my_recharge
-- ----------------------------
DROP TABLE IF EXISTS `my_recharge`;
CREATE TABLE `my_recharge`  (
  `rid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '充值ID',
  `recharge_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '充值显示的名称',
  `recharge_describe` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '充值显示的描述',
  `recharge_value` int(50) NULL DEFAULT NULL COMMENT '充值的 额度',
  `recharge_create_time` int(20) NULL DEFAULT NULL,
  `recharge_update_time` int(20) NULL DEFAULT NULL,
  PRIMARY KEY (`rid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_recharge
-- ----------------------------
INSERT INTO `my_recharge` VALUES (1, '399', 'VIP会员', 399, NULL, NULL);
INSERT INTO `my_recharge` VALUES (2, '799', '超级VIP会员', 799, NULL, NULL);

-- ----------------------------
-- Table structure for my_recharge_status
-- ----------------------------
DROP TABLE IF EXISTS `my_recharge_status`;
CREATE TABLE `my_recharge_status`  (
  `sid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`sid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_recharge_status
-- ----------------------------
INSERT INTO `my_recharge_status` VALUES (1, '未审核');
INSERT INTO `my_recharge_status` VALUES (2, '审核通过');
INSERT INTO `my_recharge_status` VALUES (3, '审核不通过');

-- ----------------------------
-- Table structure for my_reward_category
-- ----------------------------
DROP TABLE IF EXISTS `my_reward_category`;
CREATE TABLE `my_reward_category`  (
  `cid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`cid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_reward_category
-- ----------------------------
INSERT INTO `my_reward_category` VALUES (1, '一层奖励');
INSERT INTO `my_reward_category` VALUES (2, '二层奖励');
INSERT INTO `my_reward_category` VALUES (3, '三层奖励');

-- ----------------------------
-- Table structure for my_shopping_cart
-- ----------------------------
DROP TABLE IF EXISTS `my_shopping_cart`;
CREATE TABLE `my_shopping_cart`  (
  `sid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '购物车ID',
  `goods_id` int(50) NULL DEFAULT NULL COMMENT '商品ID',
  `user_id` int(50) NULL DEFAULT NULL COMMENT '用户ID',
  `shopping_create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `shopping_update_time` int(11) NULL DEFAULT NULL COMMENT '修改时间',
  `shopping_goods_number` int(11) NULL DEFAULT 1 COMMENT '购物车商品数量',
  `shopping_goods_total_price` decimal(50, 2) NULL DEFAULT 0.00 COMMENT '商品总价',
  `selected_status` int(10) NULL DEFAULT 1 COMMENT '选中状态1选中，2未选中',
  PRIMARY KEY (`sid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for my_user
-- ----------------------------
DROP TABLE IF EXISTS `my_user`;
CREATE TABLE `my_user`  (
  `uid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_number` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登录账号',
  `user_name` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名称',
  `user_phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户手机号',
  `user_sex` int(11) NOT NULL DEFAULT 1 COMMENT '用户性别1男2女',
  `user_money` int(10) NOT NULL DEFAULT 0 COMMENT '用户积分',
  `user_commission` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '分销佣金',
  `user_password` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登录密码',
  `recommend_one_number` int(50) NOT NULL DEFAULT 0 COMMENT '直推人数',
  `recommend_team_number` int(50) NOT NULL DEFAULT 0 COMMENT '团队人数',
  `user_create_time` int(20) NOT NULL,
  `user_update_time` int(20) NOT NULL,
  `recommend_code` int(50) NULL DEFAULT 0 COMMENT '推荐码',
  `user_level` int(255) NULL DEFAULT 1 COMMENT '用户等级',
  `recommend_one_achievement` decimal(50, 2) NULL DEFAULT 0.00 COMMENT '直推业绩',
  `recommend_team_achievement` decimal(50, 2) NULL DEFAULT 0.00 COMMENT '团队业绩',
  `message_status` int(10) NULL DEFAULT 1 COMMENT '消息推送开关1开启，2关闭',
  `pays_password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付密码',
  `user_qrcode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '推荐二维码',
  `recommend_code_two` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '直推的推荐人',
  `user_picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '用户头像',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 100007 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_user
-- ----------------------------
INSERT INTO `my_user` VALUES (100000, '', '顶层测试', '13011111111', 1, 0, 71.91, '4297f44b13955235245b2497399d7a93', 0, 0, 1559384974, 1559384974, 0, 4, 0.00, 0.00, 1, NULL, NULL, NULL, NULL);
INSERT INTO `my_user` VALUES (100001, '', '刘伟超', '13027730001', 1, 796, 239.67, '4297f44b13955235245b2497399d7a93', 0, 2, 1559384974, 1559384974, 100000, 3, 0.00, 0.00, 1, '4297f44b13955235245b2497399d7a93', '10000178fb148c4c0e140e2df1df910a6a639b.png', NULL, NULL);
INSERT INTO `my_user` VALUES (100002, '', '刘伟超3333', '13027700004', 1, 1895, 187.70, '4297f44b13955235245b2497399d7a93', 2, 2, 1560149811, 1560157898, 100001, 3, 0.00, 0.00, 1, NULL, '1000023b9cd135801a6f2fbf813fb6c73f8342.png', NULL, '5cfe1e596d0d9.jpg');
INSERT INTO `my_user` VALUES (100003, '', '张飞', '13000000001', 1, 399, 0.00, '4297f44b13955235245b2497399d7a93', 0, 0, 1560152755, 1560152755, 100002, 2, 0.00, 0.00, 1, NULL, NULL, NULL, NULL);
INSERT INTO `my_user` VALUES (100004, '', '关羽', '13000000002', 1, 799, 0.00, '4297f44b13955235245b2497399d7a93', 0, 0, 1560152824, 1560152824, 100002, 4, 0.00, 0.00, 1, NULL, NULL, NULL, NULL);
INSERT INTO `my_user` VALUES (100005, '', '刘备', '13000000003', 1, 0, 0.00, '4297f44b13955235245b2497399d7a93', 0, 0, 1560154518, 1560154518, 100002, 1, 0.00, 0.00, 1, NULL, NULL, '100001', NULL);
INSERT INTO `my_user` VALUES (100006, '', '最后测试账号', '13027739565', 1, 1797, 0.00, '4297f44b13955235245b2497399d7a93', 0, 0, 1560245526, 1560245544, 100002, 3, 0.00, 0.00, 1, NULL, NULL, '100001', '5cff7528473e2.jpg');

-- ----------------------------
-- Table structure for my_user_address
-- ----------------------------
DROP TABLE IF EXISTS `my_user_address`;
CREATE TABLE `my_user_address`  (
  `aid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '收货地址ID',
  `address_text` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '详细地址',
  `address_phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收货人电话',
  `address_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '收货人名称',
  `address_create_time` int(11) NULL DEFAULT NULL,
  `address_update_time` int(11) NULL DEFAULT NULL,
  `selected_status` int(2) NULL DEFAULT 1 COMMENT '选中状态',
  `user_id` int(50) NULL DEFAULT NULL,
  PRIMARY KEY (`aid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_user_address
-- ----------------------------
INSERT INTO `my_user_address` VALUES (10, '1233333333333333331231233333', '13027739565', '地址测试', 1559790170, 1560137487, 1, 100001);
INSERT INTO `my_user_address` VALUES (11, '河南省郑州市郑东新区郑东商业中心C区2号楼706', '13027739565', '刘伟超', 1560159032, 1560159032, 1, 100002);
INSERT INTO `my_user_address` VALUES (12, '河南省郑州市郑东商业中心C区2号楼706', '13027739565', '河南郑州', 1560245702, 1560245702, 1, 100006);

-- ----------------------------
-- Table structure for my_user_level
-- ----------------------------
DROP TABLE IF EXISTS `my_user_level`;
CREATE TABLE `my_user_level`  (
  `lid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '级别ID',
  `level_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '级别名称',
  `one_reward` decimal(50, 2) NULL DEFAULT NULL COMMENT '一层奖励',
  `two_reward` decimal(50, 2) NULL DEFAULT NULL COMMENT '二层奖励',
  `up_level_where` int(50) NULL DEFAULT NULL,
  `level_create_time` int(20) NULL DEFAULT NULL,
  `level_update_time` int(20) NULL DEFAULT NULL,
  PRIMARY KEY (`lid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_user_level
-- ----------------------------
INSERT INTO `my_user_level` VALUES (1, '普通用户', 0.00, 0.00, 0, NULL, NULL);
INSERT INTO `my_user_level` VALUES (2, 'VIP会员', 4.00, 2.00, 399, NULL, NULL);
INSERT INTO `my_user_level` VALUES (3, '超级VIP会员', 6.00, 3.00, 799, NULL, NULL);
INSERT INTO `my_user_level` VALUES (4, '运营商', 2.00, 4.00, 2147483647, NULL, NULL);

-- ----------------------------
-- Table structure for my_user_money_log
-- ----------------------------
DROP TABLE IF EXISTS `my_user_money_log`;
CREATE TABLE `my_user_money_log`  (
  `mid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `action_money_value` int(50) NOT NULL DEFAULT 0 COMMENT '操作金额',
  `money_create_time` int(20) NOT NULL,
  `money_update_time` int(20) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '归属ID',
  `log_types` int(50) NOT NULL DEFAULT 1 COMMENT '记录的类型1消费，2充值',
  `order_id` int(11) NULL DEFAULT NULL,
  `audit_state` int(10) NULL DEFAULT 1 COMMENT '审核状态，1未审核，2审核通过，3审核不通过',
  `audit_state_message` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '审核消息',
  `pay_voucher` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '上传的支付凭证，图片形式',
  PRIMARY KEY (`mid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_user_money_log
-- ----------------------------
INSERT INTO `my_user_money_log` VALUES (4, 799, 1559809549, 1559809549, 100001, 2, NULL, 2, NULL, '5cf8ce0d5d6d5.jpg');
INSERT INTO `my_user_money_log` VALUES (5, 799, 1559811201, 1559811201, 100001, 2, NULL, 2, NULL, '5cf8d48178e44.jpg');
INSERT INTO `my_user_money_log` VALUES (6, 399, 1559814046, 1559814046, 100001, 2, NULL, 2, NULL, '5cf8df9e581b9.png');
INSERT INTO `my_user_money_log` VALUES (11, 200, 1560133052, 1560133052, 100001, 1, 43, 2, NULL, NULL);
INSERT INTO `my_user_money_log` VALUES (10, 100, 1560132915, 1560132915, 100001, 1, 42, 1, NULL, NULL);
INSERT INTO `my_user_money_log` VALUES (12, 799, 1560152226, 1560152226, 100002, 2, NULL, 2, NULL, '5cfe08a283869.png');
INSERT INTO `my_user_money_log` VALUES (13, 399, 1560152778, 1560152778, 100003, 2, NULL, 2, NULL, '5cfe0aca27600.png');
INSERT INTO `my_user_money_log` VALUES (21, 399, 1560245566, 1560245566, 100006, 2, NULL, 3, NULL, '5cff753ee44c1.jpg');
INSERT INTO `my_user_money_log` VALUES (15, 100, 1560159036, 1560159036, 100002, 1, 44, 2, NULL, NULL);
INSERT INTO `my_user_money_log` VALUES (16, 1, 1560216039, 1560216039, 100002, 1, 45, 2, NULL, NULL);
INSERT INTO `my_user_money_log` VALUES (17, 401, 1560217253, 1560217253, 100002, 1, 47, 2, NULL, NULL);
INSERT INTO `my_user_money_log` VALUES (22, 399, 1560245621, 1560245621, 100006, 2, NULL, 2, NULL, '5cff75756fa07.jpg');
INSERT INTO `my_user_money_log` VALUES (23, 200, 1560245705, 1560245705, 100006, 1, 48, 2, NULL, NULL);
INSERT INTO `my_user_money_log` VALUES (20, 799, 1560241738, 1560241738, 100002, 2, NULL, 3, NULL, '5cff664a651ae.jpg');
INSERT INTO `my_user_money_log` VALUES (24, 799, 1560246572, 1560246572, 100006, 2, NULL, 2, NULL, '5cff792c941a2.jpg');
INSERT INTO `my_user_money_log` VALUES (25, 799, 1560246582, 1560246582, 100006, 2, NULL, 2, NULL, '5cff7936dacd6.jpg');

-- ----------------------------
-- Table structure for my_user_msg
-- ----------------------------
DROP TABLE IF EXISTS `my_user_msg`;
CREATE TABLE `my_user_msg`  (
  `mid` int(50) NOT NULL,
  `msg_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `msg_content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `msg_create_time` int(20) NULL DEFAULT NULL,
  `msg_update_time` int(20) NULL DEFAULT NULL,
  `msg_user_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`mid`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for my_user_search
-- ----------------------------
DROP TABLE IF EXISTS `my_user_search`;
CREATE TABLE `my_user_search`  (
  `sid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `search_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '搜索的关键词',
  `search_create_time` int(50) NULL DEFAULT NULL,
  `search_update_time` int(50) NULL DEFAULT NULL,
  `user_id` int(50) NULL DEFAULT NULL,
  PRIMARY KEY (`sid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 22 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_user_search
-- ----------------------------
INSERT INTO `my_user_search` VALUES (21, '天然', 1559718214, 1559718214, 100001);
INSERT INTO `my_user_search` VALUES (20, '567567', 1559718186, 1559718186, 100001);

-- ----------------------------
-- Table structure for my_user_sing_log
-- ----------------------------
DROP TABLE IF EXISTS `my_user_sing_log`;
CREATE TABLE `my_user_sing_log`  (
  `sid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `sign_create_time` int(20) NULL DEFAULT NULL,
  `sing_update_time` int(20) NULL DEFAULT NULL,
  `sing_date_time` int(20) NULL DEFAULT NULL,
  PRIMARY KEY (`sid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for my_withdrawal_log
-- ----------------------------
DROP TABLE IF EXISTS `my_withdrawal_log`;
CREATE TABLE `my_withdrawal_log`  (
  `wid` int(50) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '提现记录ID',
  `withdrawal_value` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '提现金额',
  `withdrawal_create_time` int(11) NULL DEFAULT NULL,
  `withdrawal_update_time` int(11) NULL DEFAULT NULL,
  `withdrawal_user_id` int(50) NULL DEFAULT NULL,
  `withdrawal_status` int(50) NULL DEFAULT 1 COMMENT '提现状态，1未打款，2已打款',
  `withdrawal_types` int(10) NULL DEFAULT 1 COMMENT '打款类型，1支付宝，2转账',
  `alipay_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付宝账号',
  PRIMARY KEY (`wid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_withdrawal_log
-- ----------------------------
INSERT INTO `my_withdrawal_log` VALUES (1, 1.00, 1560215400, 1560215400, 100002, 2, 1, '13027739565');
INSERT INTO `my_withdrawal_log` VALUES (2, 1.00, 1560215408, 1560215408, 100002, 2, 1, '13027739565');
INSERT INTO `my_withdrawal_log` VALUES (3, 2.00, 1560215481, 1560215481, 100002, 1, 1, '13027739565');

SET FOREIGN_KEY_CHECKS = 1;
