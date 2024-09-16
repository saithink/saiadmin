/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : saiadmin

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 31/07/2024 21:35:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for eb_article
-- ----------------------------
DROP TABLE IF EXISTS `eb_article`;
CREATE TABLE `eb_article`  (
    `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '编号',
    `category_id` int(10) NOT NULL COMMENT '分类id',
    `title` varchar(255) NOT NULL DEFAULT '' COMMENT '文章标题',
    `author` varchar(255) NULL DEFAULT NULL COMMENT '文章作者',
    `image` varchar(1000) NULL DEFAULT '' COMMENT '文章图片',
    `describe` varchar(1000) NOT NULL COMMENT '文章简介',
    `content` text NOT NULL COMMENT '文章内容',
    `views` int(11) NULL DEFAULT 0 COMMENT '浏览次数',
    `sort` int(10) UNSIGNED NULL DEFAULT 100 COMMENT '排序',
    `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态',
    `is_link` tinyint(1) NULL DEFAULT 2 COMMENT '是否外链',
    `link_url` varchar(255) NULL DEFAULT NULL COMMENT '链接地址',
    `is_hot` tinyint(1) UNSIGNED NULL DEFAULT 2 COMMENT '是否热门',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `idx_category_id`(`category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 COMMENT = '文章表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_article
-- ----------------------------
INSERT INTO `eb_article` VALUES (1, 4, '东欧72分独行侠4-1淘汰森林狼 东契奇西决MVP', '新浪体育', 'https://image.saithink.top/saiadmin/0d0efed68441cd12d993d30a767f6119.jpg', '北京时间5月31日，NBA西部决赛G5，独行侠124-103大胜森林狼，独行侠大比分4-1淘汰森林狼晋级总决赛，将在总决赛对阵凯尔特人。卢卡-东契奇当选西部决赛MVP', '<p><br></p>', 3, 100, 1, 2, '', 2, 1, 1, '2024-06-02 22:55:25', '2024-07-31 16:31:42', NULL);
INSERT INTO `eb_article` VALUES (2, 4, '爱德华兹29+10+9 森林狼险胜独行侠大比分1-3', '新浪体育', 'https://image.saithink.top/saiadmin/e5934011260c015721010baed74cbfaa.jpg', '北京时间5月29日，NBA季后赛西部决赛G4，森林狼105-100险胜独行侠，森林狼将大比分追至1-3。 森林狼（1-3）：爱德华兹29分10篮板9助攻、唐斯25分5篮板', '<p><br></p>', 0, 100, 1, 2, '', 2, 1, 1, '2024-06-02 22:56:47', '2024-07-31 16:31:56', NULL);
INSERT INTO `eb_article` VALUES (3, 5, '阿森纳理疗师里斯将前往曼联担任首席理疗师', '新浪体育', 'https://image.saithink.top/saiadmin/0c64a22cef1ad90d650056a6051da8c6.jpg', 'The Athletic报道，阿森纳理疗师乔丹-里斯即将加盟曼联，成为红魔的首席理疗师。曼联首席理疗师罗宾-萨德勒已于今年一月离开俱乐部', '<p><br></p>', 0, 100, 1, 2, '', 2, 1, 1, '2024-06-02 22:58:41', '2024-07-31 16:32:05', NULL);
INSERT INTO `eb_article` VALUES (4, 6, '半场-马莱莱斩获赛季第6球 申花1-0领先深圳新鹏城', '新浪体育', 'https://image.saithink.top/saiadmin/ce0c150d2ef32cf9e9c9d4332204446d.jpg', '5月26日晚上18：00，中超第14轮，深圳新鹏城主场迎战上海申花，上半场马莱莱补射斩获赛季第6球，半场战罢，申花暂1-0新鹏城', '<p> &nbsp; &nbsp; &nbsp; &nbsp;5月26日晚上18：00，中超第14轮，深圳新鹏城主场迎战上海申花，上半场马莱莱补射斩获赛季第6球，半场战罢，申花暂1-0新鹏城。</p><p><br></p>', 0, 100, 1, 2, '', 2, 1, 1, '2024-06-02 22:59:41', '2024-07-31 16:31:32', NULL);
INSERT INTO `eb_article` VALUES (5, 7, '周也热巴带火猫塑女风 如何打造猫系女孩妆容', '新浪时尚', 'https://image.saithink.top/saiadmin/6596f10181d4f482dec009ac758fbf89.jpg', '最近，要问什么最火？不是女明星胜似女明星，说的就是汤姆猫的女朋友', '<p> &nbsp; &nbsp; &nbsp; &nbsp;最近，要问什么最火？不是女明星胜似女明星，说的就是汤姆猫的女朋友：</p><p><br></p><p style=\"text-align: center;\">　　《猫和老鼠》截图（豆瓣）</p><p>　　说是女朋友，不如说是汤姆的女神更为贴切。她身上有着娇俏、妩媚、精致的人类特质，又有着像猫咪一样的慵懒和傲娇，网红和明星都纷纷将她拟人化。</p><p><br></p><p style=\"text-align: center;\">　　《猫和老鼠》截图（豆瓣）</p><p>　　周也这波，在你心里是几分？</p><p><br></p><p><br></p><p>　　猫系女孩当然会具备像小猫一样的慵懒和傲娇，体现在面部特征上，大概率就是这样的类型：</p><p><br></p><p style=\"text-align: center;\">　　微博@喜欢傲娇迪</p><p>　　首先，面部和五官的排布占比中，五官的比重更大。同时，眼睛会是偏圆润的类型。</p><p><br></p><p>　　整体看上去面部的锐感是很微弱的，而钝感较强。比较明显的对比就是Jennie、宁艺卓这类长相与黄礼志是截然不同的两种风格：</p><p><br></p><p><br></p><p>　　在圆眼型的基础上，猫系女孩的眼睛是有上扬感的。面中饱满，鼻子占比大，下巴短而圆润，看上去十分可爱。</p><p><br></p><p style=\"text-align: center;\">　　微博@喜欢傲娇迪</p><p><br></p><p style=\"text-align: center;\">　　微博@妹妹你真吃藕</p><p>　　上面的特征听起来好像都不是什么特别的长相，怎么组合在一起就变成了危险又迷人的猫女了呢？</p><p>　　这大概要归功于钝感带来的眼缘。猫系长相中，面部软组织略厚是一个重要特点。这会给人一种可爱感和亲切感，看上去还会有一种慵懒和随意的气质。同时，这种面相在传统意义中，也代表着喜庆、福气和财富。因此，这也是长辈们特别钟爱的类型。</p><p><br></p><p>　　先来说说猫系女孩怎么妆发：</p><p>　　猫系女孩的妆容烦恼也源自于面部软组织的钝感。因为这种饱满，以及面部折叠度低的特点，特写时会有点显胖。</p><p>　　要想解决这个问题，我们可以把重点放在改善面部长宽比上。长宽比较小，又没有特别突出的面部棱角感，看上去会更衬托圆润感，还会突出没有起伏的“平”，因此我们可以通过侧面内推的修容和长发，去把露肤的脖子也拉进面部比例中：</p><p><br></p><p>　　第二，我们要强化面部的起伏，也就是画强调五官的妆容。</p><p>　　猫系女孩的钝感会导致很难塑造外轮廓，因此在这个部分只需要打造向内推的流畅感即可，把轮廓交给五官。通过眼窝、山根、眉骨的轮廓架起基调，弱化上半张脸的“平”感，再通过饱满的唇妆，强化轮廓的同时增加下庭存在感。</p><p><br></p><p>　　接下来，我们再说说猫系妆感要怎么塑造。</p><p>　　重点有三。</p><p>　　其一，是面部的小巧流畅感。</p><p>　　先找到自己面部最凹陷的一些部分——可以通过手机的手电筒，从下巴往上照，最阴影的地方就是需要调整的位置。三八线、嘴角这些部分要尤其注意，在底妆时就要用亮一色的遮瑕着重遮盖，再盖上散粉。在后续上妆时，避免使用大颗粒、强反光的彩妆产品，不需强调饱满度。使用弱反光、细颗粒及哑光的自然妆感产品，会给人一种原生皮光泽感，更能够凸显猫系的元气魅力。</p><p><br></p><p><br></p><p>　　其二，是眼妆的塑造。</p><p>　　重点是眼睑下至配合眼尾上扬走势，让眼睛呈现出慵懒和深邃的质感。</p><p><br></p><p>　　轮廓色扩大面积，强调色收缩在睫毛根部周围，让眼神更聚光，营造出猫咪圆眼大瞳孔状态下的可爱质感。</p><p><br></p><p><br></p><p>　　其三是腮红和唇妆带来的大面积氛围感。</p><p><br></p><p>　　精致圆润又饱满的唇妆是猫系妆感的重要特征。我们可以在这一步，利用口红颜色的遮盖度调整唇形和唇部对称情况，强调下庭比例，也会在视觉上优化面部五官排布：</p><p><br></p><p>　　同时，使用能够与唇色呼应的腮红色，以团式打法轻扫面中，提升面部平整度的同时，强化可爱氛围感：</p><p><br></p>', 2, 100, 1, 2, '', 2, 1, 1, '2024-06-02 23:01:17', '2024-07-31 16:31:25', NULL);
INSERT INTO `eb_article` VALUES (6, 8, '深度 | 明星穿高定亮相红毯，为何遭客户投诉？', '新浪时尚', 'https://image.saithink.top/saiadmin/2e22e75a309264293ff0a04be1457eac.jpg', '曾经神秘的高级定制正处于舆论漩涡。 国内高级定制客户lulu近日在社交媒体上发帖，控诉意大利奢侈品牌Giambattista Valli在未征求她意见的情况下.', '<p> &nbsp; &nbsp; &nbsp; &nbsp;曾经神秘的高级定制正处于舆论漩涡。</p><p>　　国内高级定制客户lulu近日在社交媒体上发帖，控诉意大利奢侈品牌Giambattista Valli在未征求她意见的情况下，将其已购买的一件高级定制作品的样衣，借予英国演员Anya Taylor-Joy以出席电影首映会，引发网友广泛讨论。</p><p>　　截至发稿，原帖的点赞数已超过1万，而相关讨论帖的平均热度也达上千。</p><p>　　事件焦点是一套来自Giambattista Valli 2024春夏高级定制系列中的立体玫瑰花朵连体衣。lulu称此前在今年年初的巴黎高级定制周中已支付该作品的定金，但目前已决定放弃20余万元的定金并选择退货。</p><p>　　在该名高级定制客户看来，Giambattista Valli过于商业化的做法违背了行业潜规则，也让她失去了收藏高级定制的意义，并称其是“没有底蕴的二线品牌”。</p><p>国内高级定制客户lulu控诉Giambattista Valli过于商业化的做法违背了行业潜规则</p><p>　　Giambattista Valli由意大利同名设计师于2005年成立，于2017年将少数股权出售给开云集团控股股东Pinault家族名下公司Artémis。去年9月，Giambattista Valli宣布上任仅三年的首席执行官Charlotte Werner离职，目前暂未任命继任者。</p><p>　　2011年，Giambattista Valli成为法国高级时装协会的正式成员，并发布其首个高级定制系列。凭借其标志性的梦幻色彩、纱质褶皱以及巨大裙摆，该品牌很快赢得包括蕾哈娜、杨幂、迪丽热巴等国内外明星的青睐，被称为红毯上的新一代“高定之王”。</p><p>　　从明星粉丝间近几年掀起的红毯高定攀比之风中不难看出，其希望从中获得背书的高级定制位于时装产业金字塔塔尖，这也就意味着高级定制拥有与普通奢侈品截然不同的运作逻辑。</p><p>　　作为精英的特供、权力的体现，高级定制无关乎季节性和功能性，也脱离了最基本的商业准则，它只需要展示极致的创意、繁复的工艺和令人咋舌的耗时。尽管高级定制并不是一门赚钱的生意，但它所营造的终极时装梦想养活了整个时尚产业。</p><p>　　某种程度上来说，相比于同属于一家时装屋的成衣系列，高级定制往往与高级珠宝或其他艺术收藏品有着更多相似之处，高昂的标价不仅涵盖作品本身的创意价值，还蕴藏着不可复制的唯一性。</p><p>Giambattista Valli被称为红毯上的新一代“高定之王”</p><p>　　在lulu本次以及此前的多条帖文中均曾提及，Valentino、Giorgio Armani Privé等传统时装屋的高级定制系列具有唯一性，即已经被客户购买的作品将不会以完全相同的外观再出现在其他场合。</p><p>　　如果品牌需要向明星借出该作品，往往会与客户进行沟通，并对其颜色、细节等进行部分改动，以示对高级定制买家的尊重。尽管这并不是明文规定，但却已经成为行业内众所周知的潜规则。</p><p>　　Giambattista Valli如今的做法无疑破坏了这一约定，而lulu自身的影响力更是让这一事件在社交媒体中被反复发酵，令该品牌陷入舆论危机。</p><p>　　不同于国内传统高级定制客户的低调，lulu早在多年前就凭借Valentino音符裙等高级定制作品，独特的收藏品味，以及与Giorgio Armani、Pierpaolo Piccioli等多位明星设计师的互动，而在社交媒体上拥有众多粉丝，其全平台的粉丝数目前已累计超过100万。去年，lulu还在上海开设了一个陈列其所有高级定制收藏的空间Maison Lulu。</p><p>图为lulu购买的Valentino高级定制作品，以及Lady Gaga所身着的改动版</p><p>　　有数据表明，全球高级定制客户仅两千人左右，这也就意味着任何一位客户都至关重要，更何况在舆论发酵后，Giambattista Valli将在中国损失相当大的市场份额，似乎已经成为事实。</p><p>　　尽管由于高级定制的特殊性，该事件几乎被公认为Giambattista Valli的工作失误，但在更广泛的奢侈品领域，明星与VIC客户之间的矛盾却愈演愈烈。</p><p>　　今年年初，LV代言人周冬雨在参加2024秋冬系列时装秀时，就因在合影环节的不配合举动而被VIC客户投诉，并引起社交媒体上广泛关注。据后者所述，品牌方在时装秀结束后安排了合影环节，但周冬雨却态度敷衍，令其感到不适。随后，另一位LV VIC客户也在社交媒体上发帖表示认同。</p><p>　　数据显示，相关微博话题的阅读量短时间内就已超6700万。</p><p>周冬雨出席LV 24秋冬女装秀却遭VIC客户投诉</p><p>　　明星与VIC客户之间的矛盾中，隐藏着话语权和资源的争夺。</p><p>　　在明星效应尚未被大范围应用的时代，VIC客户自然占据上风。</p><p>　　2001年，Chanel为打开年轻市场曾任命歌手李玟为代言人，但有消息指出，该任命被香港VIC客户强烈抵制，导致品牌最终撤掉了代言人。往后的十几年，奢侈品牌在中国市场仍然相对保守，极度爱惜羽毛，对品牌形象一丝不苟，VIC客户的稳定也让品牌鲜少启用明星扩大市场影响力。</p><p>　　然而随着中国社交媒体的迅速发展以及粉丝经济的兴起，流量明星能为品牌带来的短期价值陡然上升。在行业持续低迷的情况下，不少奢侈品牌开始尝试与他们合作。</p><p>　　2017年，Angelababy成为Dior中国区首位品牌大使，并建立了庞大的明星矩阵。借助粉丝经济的红利，在高密度的市场营销活动配合之下，Dior时装秀在社交媒体上的讨论热度逐季攀升，促进品牌的市场影响力在几年内获得指数级增长。</p><p>　　巨大的增幅令奢侈品行业在此后的约五年间激进地押注明星策略，激烈的市场竞争彻底改变了奢侈品牌的心态，使他们在高收益面前跃跃欲试。</p><p>　　LVMH首席财务官Jean-Jacques Guiony曾在当时坦言，“我们并不担心过度曝光，真正的风险是势头不够以致于不能在市场竞争中冲在前面。”</p><p>　　据CBNData与星数的《2020年上半年明星带货》报告显示，即使在疫情期间，仅半年明星引导消费金额就同比增长了52.3%。在奢侈品牌的社交账号上，与明星相关的推文的转评赞通常是常规推文几千倍甚至几万倍。</p><p>奢侈品行业在2017年后激进地押注明星策略</p><p>　　在此期间，即使面临边际效应递减，任命流量明星风险过高等挑战，奢侈品牌依然将其视为最有效的传播媒介。</p><p>　　如果只是有限的回报，奢侈品牌显然不会冒如此大的风险，这背后的关键在于明星在扩大市场影响力以及刺激市场消费的维度上，有着不可替代的作用，而这对于正处于扩张期的奢侈品牌而言至关重要。</p><p>　　笼络中产阶层消费者，是奢侈品牌过去几年的核心策略，他们为后者提供了巨大的市场增量，也为集团不断上涨的股价提供动力。代言人则正是吸引这部分群体最直接的手段之一，明星对奢侈品牌的重要性自然也水涨船高。</p><p>　　然而当经济持续承压，中产阶层消费者购买力因此显著下滑时，明星代言人所能完成的转化也随之降低，再叠加消费者对愈发频繁和同质化的代言人策略的疲劳，品牌增长动力链出现断裂。</p><p>　　奢侈品牌于是逐步意识到核心客群的重要性，并将销售重心重新从中产阶层向高净值人群偏移。面临不确定性增大的市场环境，他们往往拥有更好的抗风险能力。</p><p>　　贝恩报告曾经指出，仅2%的VIC客户贡献了全球奢侈品销售额的40%，而2009年仅为35%，中国市场的VIC集中度超过了全球平均水平。摩根士丹利的分析称在中国一些主要高端购物中心，不到1%的顾客就可以贡献高达40%的销售额。因此在继续稳固非核心消费者规模的同时，奢侈品牌正将如何继续提升VIC核心消费者忠诚度摆在战略地位上。</p><p>　　自2022年起，LV、Chanel和Dior等奢侈品牌接连在北京、上海、广州、深圳以及成都等多个主要奢侈品消费城市，开设VIC沙龙空间，将手伸至这些高净值人群口袋的更深处。上周，LV在其广州太古汇精品店的二层开设了全新沙龙空间，陈列男女成衣、晚礼服、皮具、高级珠宝腕表以及硬箱等产品。</p><p>　　在这一背景下，VIC客户在品牌的话语权也随之被放大，其与明星之间微妙的比较心理或许是二者矛盾的根源。</p><p>　　本质上，明星对应着中产阶层消费者，而奢侈品牌过去十多年间所做的就是在中产阶层和VIC客户之间建立动态平衡。</p><p>　　对于已经驶出高速发展期的奢侈品牌而言，如今的业绩增长更多依靠客户关系管理，通过提升VIC客户的忠诚度完成销售转化，而非过去五年间依靠明星代言人，扩大市场影响力以吸引潜在消费者购买的驱动模式。</p><p><br></p><p>　　这也是奢侈品牌如今在明星策略上逐渐保守的原因，相较于高风险高收益的流量偶像，它们或许更青睐作品口碑俱佳的成熟艺人，这些明星拥有经过时间检验的影响力，并在多个圈层乃至于全球市场拥有影响力。</p><p>　　2022年11月，Balenciaga任命奥斯卡影后杨紫琼为品牌大使。去年12月，周杰伦被Dior任命为全球品牌大使，成为首个拥有该头衔的中国明星，三个月后其成为箱包品牌Rimowa首位华人全球品牌代言人。</p><p>　　在奢侈品牌纷纷将天平向VIC客户倾斜时，一直以来在明星策略上颇为激进的Prada集团又因其代言人而深陷舆论危机。</p><p>　　Miu Miu品牌代言人张元英的所属韩国女子团体ive，此前就因其《HEYA》MV中的文化挪用现象而引发热议，近日又被指新歌《Accendio》MV中一镜头或涉及辱华。近日，有大量中国网友在品牌官方Instagram账号发言敦促品牌与明星解约，Miu Miu目前对此尚未置评。</p><p>　　面对明星背后的消费者，和品牌直面的消费者，奢侈品牌正在谨慎调节手中的天平。</p>', 2, 100, 1, 2, '', 2, 1, 1, '2024-06-02 23:02:40', '2024-07-31 16:31:19', NULL);
INSERT INTO `eb_article` VALUES (7, 9, '荣耀正在筹备一大波新品 两款折叠屏＋X60＋ GT新机', '新浪科技', 'https://image.saithink.top/saiadmin/f6b9600dbe57c1e0344a01d75f16afc8.jpg', '荣耀正在筹备一大波新品 两款折叠屏＋X60＋ GT新机 【CNMO科技消息】5月31日，CNMO注意到，据知名爆料人士“数码闲聊站”透露，荣耀方面似乎正在筹备大量新品', '<p>荣耀正在筹备一大波新品 两款折叠屏＋X60＋ GT新机</p><p>　　【CNMO科技消息】5月31日，CNMO注意到，据知名爆料人士“数码闲聊站”透露，荣耀方面似乎正在筹备大量新品，接下来的6、7、8月基本都有活动。</p><p><br></p><p>　　据悉，荣耀有两款折叠屏手机正在筹备，分别为超大尺寸外屏的小折叠屏手机和超轻薄的大折叠屏手机。据悉，荣耀小折叠屏新机将会在下个月跟大家见面，新机依旧会沿用Magic系列命名，采用目前行业最大电池和最大外屏的小折叠屏手机，可折叠次数也比较猛，并且新机也会提供联名版本。荣耀的大折叠屏手机也同样值得期待，预计该机将在屏幕、续航、影像、厚度、重量等多方面进行改进。</p><p><br></p><p>　　近日，不久前荣耀X50的国内销量已经突破了1000万部，堪称“入门销量王”。而据爆料，荣耀X60将会采用高端设计语言，内置超大容量电池，抗摔能力进一步提升，同时普及等深四曲面屏幕。荣耀X60或许将会成为一款“披着旗舰手机皮的千元机”，销量有望延续前代产品辉煌。</p><p>　　荣耀GT系列新机暂未有消息流传，参考目前的荣耀GT产品，新机应该是一款侧重性能的高性价比机型。</p><p>　　此外，据透露，荣耀还有多款搭载高通骁龙8 Gen 3移动平台和高通骁龙8s Gen 3移动平台的新品正在筹备。</p>', 5, 100, 1, 2, '', 2, 1, 1, '2024-06-02 23:04:23', '2024-07-31 16:31:10', NULL);

-- ----------------------------
-- Table structure for eb_article_banner
-- ----------------------------
DROP TABLE IF EXISTS `eb_article_banner`;
CREATE TABLE `eb_article_banner`  (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
    `banner_type` int(11) NULL DEFAULT NULL COMMENT '类型',
    `image` varchar(1000) NULL DEFAULT NULL COMMENT '图片地址',
    `is_href` tinyint(1) NULL DEFAULT 1 COMMENT '是否链接',
    `url` varchar(255) NULL DEFAULT NULL COMMENT '链接地址',
    `title` varchar(255) NULL DEFAULT NULL COMMENT '标题',
    `status` tinyint(1) NULL DEFAULT 1 COMMENT '状态',
    `sort` int(11) NULL DEFAULT 0 COMMENT '排序',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '描述',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 COMMENT = '文章轮播图' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_article_banner
-- ----------------------------
INSERT INTO `eb_article_banner` VALUES (1, 1, 'https://image.saithink.top/saiadmin/d758c454ef03c49ac7185c7290b020e2.jpg', 1, '/app/saicms/index/article?id=5', '周也热巴带火猫塑女风 如何打造猫系女孩妆容', 1, 0, NULL, 1, 1, '2024-06-02 23:06:37', '2024-07-31 16:24:15', NULL);
INSERT INTO `eb_article_banner` VALUES (2, 1, 'https://image.saithink.top/saiadmin/eb5cc8b9ad1c3e562bae8af25ce630eb.jpg', 1, '/app/saicms/index/article?id=6', '深度 | 明星穿高定亮相红毯，为何遭客户投诉？', 1, 0, NULL, 1, 1, '2024-06-02 23:06:49', '2024-07-31 16:24:23', NULL);
INSERT INTO `eb_article_banner` VALUES (3, 1, 'https://image.saithink.top/saiadmin/995de531bb0c5fd2dac8e8d9e0421344.jpg', 1, '/app/saicms/index/article?id=7', '荣耀正在筹备一大波新品 两款折叠屏＋X60＋ GT新机', 1, 0, NULL, 1, 1, '2024-06-02 23:06:56', '2024-07-31 16:24:34', NULL);

-- ----------------------------
-- Table structure for eb_article_category
-- ----------------------------
DROP TABLE IF EXISTS `eb_article_category`;
CREATE TABLE `eb_article_category`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
    `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '父级ID',
    `category_name` varchar(255) NOT NULL COMMENT '分类标题',
    `describe` varchar(255) NULL DEFAULT NULL COMMENT '分类简介',
    `image` varchar(255) NULL DEFAULT NULL COMMENT '分类图片',
    `sort` int(10) UNSIGNED NULL DEFAULT 100 COMMENT '排序',
    `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 COMMENT = '文章分类表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_article_category
-- ----------------------------
INSERT INTO `eb_article_category` VALUES (1, 0, '体育', '', NULL, 100, 1, 1, 1, '2024-06-02 22:50:51', '2024-07-31 17:24:49', NULL);
INSERT INTO `eb_article_category` VALUES (2, 0, '娱乐', '', NULL, 100, 1, 1, 1, '2024-06-02 22:50:56', '2024-07-20 23:01:30', NULL);
INSERT INTO `eb_article_category` VALUES (3, 0, '科技', '', NULL, 100, 1, 1, 1, '2024-06-02 22:51:01', '2024-07-20 19:49:47', NULL);
INSERT INTO `eb_article_category` VALUES (4, 1, 'NBA', NULL, NULL, 100, 1, 1, 1, '2024-06-02 22:51:16', '2024-06-02 22:51:16', NULL);
INSERT INTO `eb_article_category` VALUES (5, 1, '英超', NULL, NULL, 100, 1, 1, 1, '2024-06-02 22:51:39', '2024-06-02 22:51:39', NULL);
INSERT INTO `eb_article_category` VALUES (6, 1, '中超', NULL, NULL, 100, 1, 1, 1, '2024-06-02 22:51:49', '2024-06-02 22:51:49', NULL);
INSERT INTO `eb_article_category` VALUES (7, 2, '时尚', NULL, NULL, 100, 1, 1, 1, '2024-06-02 22:52:03', '2024-06-02 22:52:03', NULL);
INSERT INTO `eb_article_category` VALUES (8, 2, '女性', NULL, NULL, 100, 1, 1, 1, '2024-06-02 22:52:12', '2024-06-02 22:52:12', NULL);
INSERT INTO `eb_article_category` VALUES (9, 3, '手机', NULL, NULL, 100, 1, 1, 1, '2024-06-02 22:52:37', '2024-06-02 22:52:37', NULL);
INSERT INTO `eb_article_category` VALUES (10, 3, '生活', NULL, NULL, 100, 1, 1, 1, '2024-06-08 13:37:51', '2024-06-08 13:37:51', NULL);

-- ----------------------------
-- Table structure for eb_system_config
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_config`;
CREATE TABLE `eb_system_config`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '编号',
    `group_id` int(11) NULL DEFAULT NULL COMMENT '组id',
    `key` varchar(32) NOT NULL COMMENT '配置键名',
    `value` varchar(1000) NULL DEFAULT NULL COMMENT '配置值',
    `name` varchar(255) NULL DEFAULT NULL COMMENT '配置名称',
    `input_type` varchar(32) NULL DEFAULT NULL COMMENT '数据输入类型',
    `config_select_data` varchar(500) NULL DEFAULT NULL COMMENT '配置选项数据',
    `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    PRIMARY KEY (`id`, `key`) USING BTREE,
    INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 COMMENT = '参数配置信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_config
-- ----------------------------
INSERT INTO `eb_system_config` VALUES (1, 1, 'site_copyright', 'Copyright © 2024 saithink', '版权信息', 'textarea', NULL, 96, '');
INSERT INTO `eb_system_config` VALUES (2, 1, 'site_desc', '基于vue3 + webman 的极速开发框架', '网站描述', 'textarea', NULL, 97, NULL);
INSERT INTO `eb_system_config` VALUES (3, 1, 'site_keywords', '后台管理系统', '网站关键字', 'input', NULL, 98, NULL);
INSERT INTO `eb_system_config` VALUES (4, 1, 'site_name', 'SaiAdmin', '网站名称', 'input', NULL, 99, NULL);
INSERT INTO `eb_system_config` VALUES (5, 1, 'site_record_number', '', '网站备案号', 'input', NULL, 95, NULL);
INSERT INTO `eb_system_config` VALUES (6, 2, 'upload_allow_file', 'txt,doc,docx,xls,xlsx,ppt,pptx,rar,zip,7z,gz,pdf,wps,md', '文件类型', 'input', NULL, 0, NULL);
INSERT INTO `eb_system_config` VALUES (7, 2, 'upload_allow_image', 'jpg,jpeg,png,gif,svg,bmp', '图片类型', 'input', NULL, 0, NULL);
INSERT INTO `eb_system_config` VALUES (8, 2, 'upload_mode', '1', '上传模式', 'select', '[{\"label\":\"本地上传\",\"value\":\"1\"},{\"label\":\"阿里云OSS\",\"value\":\"2\"},{\"label\":\"七牛云\",\"value\":\"3\"},{\"label\":\"腾讯云COS\",\"value\":\"4\"}]', 99, NULL);
INSERT INTO `eb_system_config` VALUES (10, 2, 'upload_size', '5242880', '上传大小', 'input', NULL, 88, '单位Byte,1MB=1024*1024Byte');
INSERT INTO `eb_system_config` VALUES (11, 2, 'local_root', 'public/storage/', '本地存储路径', 'input', NULL, 0, '本地存储文件路径');
INSERT INTO `eb_system_config` VALUES (12, 2, 'local_domain', 'http://127.0.0.1:8787', '本地存储域名', 'input', NULL, 0, 'http://127.0.0.1:8787');
INSERT INTO `eb_system_config` VALUES (13, 2, 'local_uri', '/storage/', '本地访问路径', 'input', NULL, 0, '访问是通过domain + uri');
INSERT INTO `eb_system_config` VALUES (14, 2, 'qiniu_accessKey', '', '七牛key', 'input', NULL, 0, '七牛云存储secretId');
INSERT INTO `eb_system_config` VALUES (15, 2, 'qiniu_secretKey', '', '七牛secret', 'input', NULL, 0, '七牛云存储secretKey');
INSERT INTO `eb_system_config` VALUES (16, 2, 'qiniu_bucket', '', '七牛bucket', 'input', NULL, 0, '七牛云存储bucket');
INSERT INTO `eb_system_config` VALUES (17, 2, 'qiniu_dirname', '', '七牛dirname', 'input', NULL, 0, '七牛云存储dirname');
INSERT INTO `eb_system_config` VALUES (18, 2, 'qiniu_domain', '', '七牛domain', 'input', NULL, 0, '七牛云存储domain');
INSERT INTO `eb_system_config` VALUES (19, 2, 'cos_secretId', '', '腾讯Id', 'input', NULL, 0, '腾讯云存储secretId');
INSERT INTO `eb_system_config` VALUES (20, 2, 'cos_secretKey', '', '腾讯key', 'input', NULL, 0, '腾讯云secretKey');
INSERT INTO `eb_system_config` VALUES (21, 2, 'cos_bucket', '', '腾讯bucket', 'input', NULL, 0, '腾讯云存储bucket');
INSERT INTO `eb_system_config` VALUES (22, 2, 'cos_dirname', '', '腾讯dirname', 'input', NULL, 0, '腾讯云存储dirname');
INSERT INTO `eb_system_config` VALUES (23, 2, 'cos_domain', '', '腾讯domain', 'input', NULL, 0, '腾讯云存储domain');
INSERT INTO `eb_system_config` VALUES (24, 2, 'cos_region', '', '腾讯region', 'input', NULL, 0, '腾讯云存储region');
INSERT INTO `eb_system_config` VALUES (25, 2, 'oss_accessKeyId', '', '阿里Id', 'input', NULL, 0, '阿里云存储accessKeyId');
INSERT INTO `eb_system_config` VALUES (26, 2, 'oss_accessKeySecret', '', '阿里Secret', 'input', NULL, 0, '阿里云存储accessKeySecret');
INSERT INTO `eb_system_config` VALUES (27, 2, 'oss_bucket', '', '阿里bucket', 'input', NULL, 0, '阿里云存储bucket');
INSERT INTO `eb_system_config` VALUES (28, 2, 'oss_dirname', '', '阿里dirname', 'input', NULL, 0, '阿里云存储dirname');
INSERT INTO `eb_system_config` VALUES (29, 2, 'oss_domain', '', '阿里domain', 'input', NULL, 0, '阿里云存储domain');
INSERT INTO `eb_system_config` VALUES (30, 2, 'oss_endpoint', '', '阿里endpoint', 'input', NULL, 0, '阿里云存储endpoint');
INSERT INTO `eb_system_config` VALUES (31, 3, 'Host', 'smtp.qq.com', 'SMTP服务器', 'input', '', 100, '');
INSERT INTO `eb_system_config` VALUES (32, 3, 'Port', '465', 'SMTP端口', 'input', '', 100, '');
INSERT INTO `eb_system_config` VALUES (33, 3, 'Username', '', 'SMTP用户名', 'input', '', 100, '');
INSERT INTO `eb_system_config` VALUES (34, 3, 'Password', '', 'SMTP密码', 'input', '', 100, '');
INSERT INTO `eb_system_config` VALUES (35, 3, 'SMTPSecure', 'ssl', 'SMTP验证方式', 'radio', '[\r\n    {\"label\":\"ssl\",\"value\":\"ssl\"},\r\n    {\"label\":\"tsl\",\"value\":\"tsl\"}\r\n]', 100, '');
INSERT INTO `eb_system_config` VALUES (36, 3, 'From', '', '默认发件人', 'input', '', 100, '默认发件的邮箱地址');
INSERT INTO `eb_system_config` VALUES (37, 3, 'FromName', '', '默认发件名称', 'input', '', 100, '');
INSERT INTO `eb_system_config` VALUES (38, 3, 'CharSet', 'UTF-8', '编码', 'input', '', 100, '');
INSERT INTO `eb_system_config` VALUES (39, 3, 'SMTPDebug', '0', '调试模式', 'radio', '[\r\n    {\"label\":\"关闭\",\"value\":\"0\"},\r\n    {\"label\":\"client\",\"value\":\"1\"},\r\n    {\"label\":\"server\",\"value\":\"2\"}\r\n]', 100, '');

-- ----------------------------
-- Table structure for eb_system_config_group
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_config_group`;
CREATE TABLE `eb_system_config_group`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `name` varchar(50) NULL DEFAULT NULL COMMENT '字典名称',
    `code` varchar(100) NULL DEFAULT NULL COMMENT '字典标示',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建人',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新人',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 COMMENT = '参数配置分组表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_config_group
-- ----------------------------
INSERT INTO `eb_system_config_group` VALUES (1, '站点配置', 'site_config', NULL, 1, 1, '2021-11-23 10:49:29', '2021-11-23 10:49:29', NULL);
INSERT INTO `eb_system_config_group` VALUES (2, '上传配置', 'upload_config', NULL, 1, 1, '2021-11-23 10:49:29', '2021-11-23 10:49:29', NULL);
INSERT INTO `eb_system_config_group` VALUES (3, '邮件服务', 'email_config', NULL, 1, 1, '2021-11-23 10:49:29', '2021-11-23 10:49:29', NULL);

-- ----------------------------
-- Table structure for eb_system_crontab
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_crontab`;
CREATE TABLE `eb_system_crontab`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `name` varchar(100) NULL DEFAULT NULL COMMENT '任务名称',
    `type` smallint(6) NULL DEFAULT 4 COMMENT '任务类型 (1 command, 2 class, 3 url, 4 eval)',
    `target` varchar(500) NULL DEFAULT NULL COMMENT '调用任务字符串',
    `parameter` varchar(1000) NULL DEFAULT NULL COMMENT '调用任务参数',
    `rule` varchar(32) NULL DEFAULT NULL COMMENT '任务执行表达式',
    `singleton` smallint(6) NULL DEFAULT 1 COMMENT '是否单次执行 (1 是 2 不是)',
    `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 COMMENT = '定时任务信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_crontab
-- ----------------------------
INSERT INTO `eb_system_crontab` VALUES (1, '访问官网', 1, 'https://saithink.top', NULL, '0 0 8 * * *', 2, 1, NULL, 1, 1, '2024-01-20 14:21:11', '2024-01-20 15:26:41', NULL);
INSERT INTO `eb_system_crontab` VALUES (2, '登录gitee', 2, 'https://gitee.com/check_user_login', '{\"user_login\": \"saiadmin\"}', '0 0 10 * * *', 2, 1, NULL, 1, 1, '2024-01-20 14:31:51', '2024-01-20 15:21:33', NULL);
INSERT INTO `eb_system_crontab` VALUES (3, '定时执行任务', 3, '\\plugin\\saiadmin\\process\\Task', '{\"type\":\"1\"}', '0 0 12 * * *', 2, 1, NULL, 1, 1, '2024-01-20 14:38:03', '2024-01-20 15:21:42', NULL);

-- ----------------------------
-- Table structure for eb_system_crontab_log
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_crontab_log`;
CREATE TABLE `eb_system_crontab_log`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `crontab_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '任务ID',
    `name` varchar(255) NULL DEFAULT NULL COMMENT '任务名称',
    `target` varchar(500) NULL DEFAULT NULL COMMENT '任务调用目标字符串',
    `parameter` varchar(1000) NULL DEFAULT NULL COMMENT '任务调用参数',
    `exception_info` varchar(2000) NULL DEFAULT NULL COMMENT '异常信息',
    `status` smallint(6) NULL DEFAULT 1 COMMENT '执行状态 (1成功 2失败)',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 COMMENT = '定时任务执行日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_crontab_log
-- ----------------------------

-- ----------------------------
-- Table structure for eb_system_dept
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_dept`;
CREATE TABLE `eb_system_dept`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `parent_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '父ID',
    `level` varchar(500) NULL DEFAULT NULL COMMENT '组级集合',
    `name` varchar(30) NULL DEFAULT NULL COMMENT '部门名称',
    `leader` varchar(20) NULL DEFAULT NULL COMMENT '负责人',
    `phone` varchar(11) NULL DEFAULT NULL COMMENT '联系电话',
    `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
    `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `parent_id`(`parent_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 COMMENT = '部门信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_dept
-- ----------------------------
INSERT INTO `eb_system_dept` VALUES (1, 0, '0', '赛弟科技', '赛弟', '18888888888', 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_dept` VALUES (2, 1, '0,1', '青岛分公司', NULL, NULL, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_dept` VALUES (3, 1, '0,1', '洛阳总公司', NULL, NULL, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_dept` VALUES (4, 2, '0,1,2', '市场部门', NULL, NULL, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_dept` VALUES (5, 2, '0,1,2', '财务部门', NULL, NULL, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_dept` VALUES (6, 3, '0,1,3', '研发部门', NULL, NULL, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_dept` VALUES (7, 3, '0,1,3', '市场部门', NULL, NULL, 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);

-- ----------------------------
-- Table structure for eb_system_dept_leader
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_dept_leader`;
CREATE TABLE `eb_system_dept_leader`  (
    `leader_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
    `dept_id` int(11) unsigned NOT NULL COMMENT '部门主键',
    `user_id` int(11) unsigned NOT NULL COMMENT '角色主键',
    PRIMARY KEY (`leader_id`) USING BTREE,
    KEY `idx_dept_id` (`dept_id`) USING BTREE,
    KEY `idx_user_id` (`user_id`) USING BTREE
) ENGINE = InnoDB COMMENT = '部门领导关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_dept_leader
-- ----------------------------

-- ----------------------------
-- Table structure for eb_system_dict_data
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_dict_data`;
CREATE TABLE `eb_system_dict_data`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `type_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '字典类型ID',
    `label` varchar(50) NULL DEFAULT NULL COMMENT '字典标签',
    `value` varchar(100) NULL DEFAULT NULL COMMENT '字典值',
    `code` varchar(100) NULL DEFAULT NULL COMMENT '字典标示',
    `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
    `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `type_id`(`type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 55 COMMENT = '字典数据表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_dict_data
-- ----------------------------
INSERT INTO `eb_system_dict_data` VALUES (3, 2, '本地存储', '1', 'upload_mode', 99, 1, NULL, 1, 1, '2021-06-27 13:33:43', '2021-06-27 13:33:43', NULL);
INSERT INTO `eb_system_dict_data` VALUES (4, 2, '阿里云OSS', '2', 'upload_mode', 98, 1, NULL, 1, 1, '2021-06-27 13:33:55', '2021-06-27 13:33:55', NULL);
INSERT INTO `eb_system_dict_data` VALUES (5, 2, '七牛云', '3', 'upload_mode', 97, 1, NULL, 1, 1, '2021-06-27 13:34:07', '2023-12-13 16:50:26', NULL);
INSERT INTO `eb_system_dict_data` VALUES (6, 2, '腾讯云COS', '4', 'upload_mode', 96, 1, NULL, 1, 1, '2021-06-27 13:34:19', '2023-12-13 16:47:34', NULL);
INSERT INTO `eb_system_dict_data` VALUES (7, 3, '正常', '1', 'data_status', 0, 1, '1为正常', 1, 1, '2021-06-27 13:36:51', '2021-06-27 13:37:01', NULL);
INSERT INTO `eb_system_dict_data` VALUES (8, 3, '停用', '2', 'data_status', 0, 1, '2为停用', 1, 1, '2021-06-27 13:37:10', '2021-06-27 13:37:10', NULL);
INSERT INTO `eb_system_dict_data` VALUES (9, 4, '统计页面', 'statistics', 'dashboard', 0, 1, '管理员用', 1, 1, '2021-08-09 12:53:53', '2023-11-16 11:39:17', NULL);
INSERT INTO `eb_system_dict_data` VALUES (10, 4, '工作台', 'work', 'dashboard', 0, 1, '员工使用', 1, 1, '2021-08-09 12:54:18', '2021-08-09 12:54:18', NULL);
INSERT INTO `eb_system_dict_data` VALUES (11, 5, '男', '1', 'sex', 0, 1, NULL, 1, 1, '2021-08-09 12:55:00', '2021-08-09 12:55:00', NULL);
INSERT INTO `eb_system_dict_data` VALUES (12, 5, '女', '2', 'sex', 0, 1, NULL, 1, 1, '2021-08-09 12:55:08', '2021-08-09 12:55:08', NULL);
INSERT INTO `eb_system_dict_data` VALUES (13, 5, '未知', '3', 'sex', 0, 1, NULL, 1, 1, '2021-08-09 12:55:16', '2021-08-09 12:55:16', NULL);
INSERT INTO `eb_system_dict_data` VALUES (22, 7, '通知', '1', 'backend_notice_type', 2, 1, NULL, 1, 1, '2021-11-11 17:29:27', '2021-11-11 17:30:51', NULL);
INSERT INTO `eb_system_dict_data` VALUES (23, 7, '公告', '2', 'backend_notice_type', 1, 1, NULL, 1, 1, '2021-11-11 17:31:42', '2021-11-11 17:31:42', NULL);
INSERT INTO `eb_system_dict_data` VALUES (39, 6, '通知', 'notice', 'queue_msg_type', 1, 1, NULL, 1, 1, '2021-12-25 18:30:31', '2024-01-20 14:42:55', NULL);
INSERT INTO `eb_system_dict_data` VALUES (40, 6, '公告', 'announcement', 'queue_msg_type', 2, 1, NULL, 1, 1, '2021-12-25 18:31:00', '2024-01-20 14:42:57', NULL);
INSERT INTO `eb_system_dict_data` VALUES (41, 6, '待办', 'todo', 'queue_msg_type', 3, 1, NULL, 1, 1, '2021-12-25 18:31:26', '2024-01-20 14:42:59', NULL);
INSERT INTO `eb_system_dict_data` VALUES (42, 6, '抄送我的', 'carbon_copy_mine', 'queue_msg_type', 4, 1, NULL, 1, 1, '2021-12-25 18:31:26', '2024-01-20 14:42:59', NULL);
INSERT INTO `eb_system_dict_data` VALUES (43, 6, '私信', 'private_message', 'queue_msg_type', 5, 1, NULL, 1, 1, '2021-12-25 18:31:26', '2024-01-20 14:42:59', NULL);
INSERT INTO `eb_system_dict_data` VALUES (44, 12, '图片', 'image', 'attachment_type', 10, 1, NULL, 1, 1, '2022-03-17 14:49:59', '2022-03-17 14:49:59', NULL);
INSERT INTO `eb_system_dict_data` VALUES (45, 12, '文档', 'text', 'attachment_type', 9, 1, NULL, 1, 1, '2022-03-17 14:50:20', '2022-03-17 14:50:49', NULL);
INSERT INTO `eb_system_dict_data` VALUES (46, 12, '音频', 'audio', 'attachment_type', 8, 1, NULL, 1, 1, '2022-03-17 14:50:37', '2022-03-17 14:50:52', NULL);
INSERT INTO `eb_system_dict_data` VALUES (47, 12, '视频', 'video', 'attachment_type', 7, 1, NULL, 1, 1, '2022-03-17 14:50:45', '2022-03-17 14:50:57', NULL);
INSERT INTO `eb_system_dict_data` VALUES (48, 12, '应用程序', 'application', 'attachment_type', 6, 1, NULL, 1, 1, '2022-03-17 14:50:52', '2022-03-17 14:50:59', NULL);
INSERT INTO `eb_system_dict_data` VALUES (49, 13, '菜单', 'M', 'menu_type', 100, 1, '', 1, 1, '2024-07-31 10:34:12', '2024-07-31 10:34:12', NULL);
INSERT INTO `eb_system_dict_data` VALUES (50, 13, '按钮', 'B', 'menu_type', 100, 1, '', 1, 1, '2024-07-31 10:34:20', '2024-07-31 10:34:20', NULL);
INSERT INTO `eb_system_dict_data` VALUES (51, 13, '外链', 'L', 'menu_type', 100, 1, '', 1, 1, '2024-07-31 10:34:27', '2024-07-31 10:34:27', NULL);
INSERT INTO `eb_system_dict_data` VALUES (52, 13, 'iFrame', 'I', 'menu_type', 100, 1, '', 1, 1, '2024-07-31 10:34:51', '2024-07-31 10:34:51', NULL);
INSERT INTO `eb_system_dict_data` VALUES (53, 14, '是', '1', 'yes_or_no', 100, 1, '', 1, 1, '2024-07-31 10:35:17', '2024-07-31 10:35:17', NULL);
INSERT INTO `eb_system_dict_data` VALUES (54, 14, '否', '2', 'yes_or_no', 100, 1, '', 1, 1, '2024-07-31 10:35:22', '2024-07-31 10:35:22', NULL);
INSERT INTO `eb_system_dict_data` VALUES (55, 15, '全部数据权限', '1', 'data_scope', 100, 1, '', 1, 1, '2024-07-31 10:35:22', '2024-07-31 10:35:22', NULL);
INSERT INTO `eb_system_dict_data` VALUES (56, 15, '自定义数据权限', '2', 'data_scope', 100, 1, '', 1, 1, '2024-07-31 10:35:22', '2024-07-31 10:35:22', NULL);
INSERT INTO `eb_system_dict_data` VALUES (57, 15, '本部门数据权限', '3', 'data_scope', 100, 1, '', 1, 1, '2024-07-31 10:35:22', '2024-07-31 10:35:22', NULL);
INSERT INTO `eb_system_dict_data` VALUES (58, 15, '本部门及以下数据权限', '4', 'data_scope', 100, 1, '', 1, 1, '2024-07-31 10:35:22', '2024-07-31 10:35:22', NULL);
INSERT INTO `eb_system_dict_data` VALUES (59, 15, '本人数据权限', '5', 'data_scope', 100, 1, '', 1, 1, '2024-07-31 10:35:22', '2024-07-31 10:35:22', NULL);

-- ----------------------------
-- Table structure for eb_system_dict_type
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_dict_type`;
CREATE TABLE `eb_system_dict_type`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `name` varchar(50) NULL DEFAULT NULL COMMENT '字典名称',
    `code` varchar(100) NULL DEFAULT NULL COMMENT '字典标示',
    `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 COMMENT = '字典类型表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_dict_type
-- ----------------------------
INSERT INTO `eb_system_dict_type` VALUES (2, '存储模式', 'upload_mode', 1, '上传文件存储模式', 1, 1, '2021-06-27 13:33:29', '2021-06-27 13:33:11', NULL);
INSERT INTO `eb_system_dict_type` VALUES (3, '数据状态', 'data_status', 1, '通用数据状态', 1, 1, '2021-06-27 13:33:29', '2021-06-27 13:36:34', NULL);
INSERT INTO `eb_system_dict_type` VALUES (4, '后台首页', 'dashboard', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2023-11-16 11:28:17', NULL);
INSERT INTO `eb_system_dict_type` VALUES (5, '性别', 'sex', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2023-11-16 11:39:12', NULL);
INSERT INTO `eb_system_dict_type` VALUES (6, '消息类型', 'queue_msg_type', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2024-01-20 14:43:06', NULL);
INSERT INTO `eb_system_dict_type` VALUES (7, '后台公告类型', 'backend_notice_type', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2021-11-11 17:29:14', NULL);
INSERT INTO `eb_system_dict_type` VALUES (12, '附件类型', 'attachment_type', 1, NULL, 1, 1, '2021-06-27 13:33:29', '2022-03-17 14:49:23', NULL);
INSERT INTO `eb_system_dict_type` VALUES (13, '菜单类型', 'menu_type', 1, '', 1, 1, '2024-07-31 10:33:37', '2024-07-31 10:33:37', NULL);
INSERT INTO `eb_system_dict_type` VALUES (14, '是否', 'yes_or_no', 1, '', 1, 1, '2024-07-31 10:35:07', '2024-07-31 10:35:07', NULL);
INSERT INTO `eb_system_dict_type` VALUES (15, '数据权限', 'data_scope', 1, '', 1, 1, '2024-07-31 10:35:07', '2024-07-31 10:35:07', NULL);

-- ----------------------------
-- Table structure for eb_system_login_log
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_login_log`;
CREATE TABLE `eb_system_login_log`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `username` varchar(20) NULL DEFAULT NULL COMMENT '用户名',
    `ip` varchar(45) NULL DEFAULT NULL COMMENT '登录IP地址',
    `ip_location` varchar(255) NULL DEFAULT NULL COMMENT 'IP所属地',
    `os` varchar(50) NULL DEFAULT NULL COMMENT '操作系统',
    `browser` varchar(50) NULL DEFAULT NULL COMMENT '浏览器',
    `status` smallint(6) NULL DEFAULT 1 COMMENT '登录状态 (1成功 2失败)',
    `message` varchar(50) NULL DEFAULT NULL COMMENT '提示消息',
    `login_time` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '登录时间',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '更新时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 COMMENT = '登录日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for eb_system_menu
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_menu`;
CREATE TABLE `eb_system_menu`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `parent_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '父ID',
    `level` varchar(500) NULL DEFAULT NULL COMMENT '组级集合',
    `name` varchar(50) NULL DEFAULT NULL COMMENT '菜单名称',
    `code` varchar(100) NULL DEFAULT NULL COMMENT '菜单标识代码',
    `icon` varchar(50) NULL DEFAULT NULL COMMENT '菜单图标',
    `route` varchar(200) NULL DEFAULT NULL COMMENT '路由地址',
    `component` varchar(255) NULL DEFAULT NULL COMMENT '组件路径',
    `redirect` varchar(255) NULL DEFAULT NULL COMMENT '跳转地址',
    `is_hidden` smallint(6) NULL DEFAULT 1 COMMENT '是否隐藏 (1是 2否)',
    `type` char(1) NULL DEFAULT '' COMMENT '菜单类型, (M菜单 B按钮 L链接 I iframe)',
    `generate_id` int(11) NULL DEFAULT 0 COMMENT '生成id',
    `generate_key` varchar(255) NULL DEFAULT NULL COMMENT '生成key',
    `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
    `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5001 COMMENT = '菜单信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_menu
-- ----------------------------
INSERT INTO `eb_system_menu` VALUES (1000, 0, '0', '权限', 'permission', 'ma-icon-permission', 'permission', '', NULL, 2, 'M', 0, NULL, 1, 99, NULL, 1, 1, '2021-07-25 18:48:47', '2023-11-14 23:13:42', NULL);
INSERT INTO `eb_system_menu` VALUES (1100, 1000, '0,1000', '用户管理', '/core/user', 'ma-icon-user', 'user', 'system/user/index', NULL, 2, 'M', 0, NULL, 1, 99, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1101, 1100, '0,1000,1100', '用户列表', '/core/user/index', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1102, 1100, '0,1000,1100', '用户回收站列表', '/core/user/recycle', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1103, 1100, '0,1000,1100', '用户保存', '/core/user/save', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1104, 1100, '0,1000,1100', '用户更新', '/core/user/update', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1105, 1100, '0,1000,1100', '用户删除', '/core/user/destroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1106, 1100, '0,1000,1100', '用户读取', '/core/user/read', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1107, 1100, '0,1000,1100', '用户恢复', '/core/user/recovery', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 18:50:15', '2021-07-25 18:50:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1108, 1100, '0,1000,1100', '用户销毁', '/core/user/realDestroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2024-04-30 16:30:00', '2023-04-30 16:30:00', NULL);
INSERT INTO `eb_system_menu` VALUES (1111, 1100, '0,1000,1100', '用户状态改变', '/core/user/changeStatus', '', NULL, '', NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 18:53:02', '2021-07-25 18:53:02', NULL);
INSERT INTO `eb_system_menu` VALUES (1112, 1100, '0,1000,1100', '用户初始化密码', '/core/user/initUserPassword', '', NULL, '', NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 18:55:55', '2021-07-25 18:55:55', NULL);
INSERT INTO `eb_system_menu` VALUES (1113, 1100, '0,1000,1100', '更新用户缓存', '/core/user/cache', '', NULL, '', NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-08-08 18:30:57', '2021-08-08 18:30:57', NULL);
INSERT INTO `eb_system_menu` VALUES (1114, 1100, '0,1000,1100', '设置用户首页', '/core/user/setHomePage', '', NULL, '', NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-08-08 18:34:30', '2021-08-08 18:34:30', NULL);
INSERT INTO `eb_system_menu` VALUES (1200, 1000, '0,1000', '菜单管理', '/core/menu', 'icon-menu', 'menu', 'system/menu/index', NULL, 2, 'M', 0, NULL, 1, 96, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1201, 1200, '0,1000,1200', '菜单列表', '/core/menu/index', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1202, 1200, '0,1000,1200', '菜单回收站', '/core/menu/recycle', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1203, 1200, '0,1000,1200', '菜单保存', '/core/menu/save', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1204, 1200, '0,1000,1200', '菜单更新', '/core/menu/update', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1205, 1200, '0,1000,1200', '菜单删除', '/core/menu/destroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1206, 1200, '0,1000,1200', '菜单读取', '/core/menu/read', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1207, 1200, '0,1000,1200', '菜单恢复', '/core/menu/recovery', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:01:47', '2021-07-25 19:01:47', NULL);
INSERT INTO `eb_system_menu` VALUES (1208, 1200, '0,1000,1200', '菜单销毁', '/core/menu/realDestroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2024-04-30 16:30:00', '2023-04-30 16:30:00', NULL);
INSERT INTO `eb_system_menu` VALUES (1300, 1000, '0,1000', '部门管理', '/core/dept', 'ma-icon-dept', 'dept', 'system/dept/index', NULL, 2, 'M', 0, NULL, 1, 97, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1301, 1300, '0,1000,1300', '部门列表', '/core/dept/index', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1302, 1300, '0,1000,1300', '部门回收站', '/core/dept/recycle', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1303, 1300, '0,1000,1300', '部门保存', '/core/dept/save', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1304, 1300, '0,1000,1300', '部门更新', '/core/dept/update', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1305, 1300, '0,1000,1300', '部门删除', '/core/dept/destroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1306, 1300, '0,1000,1300', '部门读取', '/core/dept/read', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1307, 1300, '0,1000,1300', '部门恢复', '/core/dept/recovery', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:16:33', '2021-07-25 19:16:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1308, 1300, '0,1000,1300', '部门销毁', '/core/dept/realDestroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2024-04-30 16:30:00', '2023-04-30 16:30:00', NULL);
INSERT INTO `eb_system_menu` VALUES (1311, 1300, '0,1000,1300', '部门状态改变', '/core/dept/changeStatus', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-11-09 18:26:15', '2021-11-09 18:26:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1400, 1000, '0,1000', '角色管理', '/core/role', 'ma-icon-role', 'role', 'system/role/index', NULL, 2, 'M', 0, NULL, 1, 98, NULL, 1, 1, '2021-07-25 19:17:37', '2021-07-25 19:17:37', NULL);
INSERT INTO `eb_system_menu` VALUES (1401, 1400, '0,1000,1400', '角色列表', '/core/role/index', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:17:37', '2021-07-25 19:17:37', NULL);
INSERT INTO `eb_system_menu` VALUES (1402, 1400, '0,1000,1400', '角色回收站', '/core/role/recycle', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1403, 1400, '0,1000,1400', '角色保存', '/core/role/save', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1404, 1400, '0,1000,1400', '角色更新', '/core/role/update', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1405, 1400, '0,1000,1400', '角色删除', '/core/role/destroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1406, 1400, '0,1000,1400', '角色读取', '/core/role/read', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1407, 1400, '0,1000,1400', '角色恢复', '/core/role/recovery', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 19:17:38', '2021-07-25 19:17:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1408, 1400, '0,1000,1400', '角色销毁', '/core/role/realDestroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2024-04-30 16:30:00', '2023-04-30 16:30:00', NULL);
INSERT INTO `eb_system_menu` VALUES (1411, 1400, '0,1000,1400', '角色状态改变', '/core/role/changeStatus', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-30 11:21:24', '2021-07-30 11:21:24', NULL);
INSERT INTO `eb_system_menu` VALUES (1412, 1400, '0,1000,1400', '更新菜单权限', '/core/role/menuPermission', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-08-09 11:52:33', '2021-08-09 11:52:33', NULL);
INSERT INTO `eb_system_menu` VALUES (1413, 1400, '0,1000,1400', '更新数据权限', '/core/role/dataPermission', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-08-09 11:52:52', '2021-08-09 11:52:52', NULL);
INSERT INTO `eb_system_menu` VALUES (1500, 1000, '0,1000', '岗位管理', '/core/post', 'ma-icon-post', 'post', 'system/post/index', NULL, 2, 'M', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1501, 1500, '0,1000,1500', '岗位列表', '/core/post/index', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1502, 1500, '0,1000,1500', '岗位回收站', '/core/post/recycle', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1503, 1500, '0,1000,1500', '岗位保存', '/core/post/save', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1504, 1500, '0,1000,1500', '岗位更新', '/core/post/update', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1505, 1500, '0,1000,1500', '岗位删除', '/core/post/destroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1506, 1500, '0,1000,1500', '岗位读取', '/core/post/read', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1507, 1500, '0,1000,1500', '岗位恢复', '/core/post/recovery', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-25 20:46:38', '2021-07-25 20:46:38', NULL);
INSERT INTO `eb_system_menu` VALUES (1508, 1500, '0,1000,1500', '岗位销毁', '/core/post/realDestroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2024-04-30 16:30:00', '2023-04-30 16:30:00', NULL);
INSERT INTO `eb_system_menu` VALUES (1511, 1500, '0,1000,1500', '岗位状态改变', '/core/post/changeStatus', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-11-09 18:26:15', '2021-11-09 18:26:15', NULL);
INSERT INTO `eb_system_menu` VALUES (1512, 1500, '0,1000,1500', '岗位导入', '/core/post/import', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 17:17:03', '2021-07-31 17:17:03', NULL);
INSERT INTO `eb_system_menu` VALUES (1513, 1500, '0,1000,1500', '岗位导出', '/core/post/export', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 17:17:03', '2021-07-31 17:17:03', NULL);
INSERT INTO `eb_system_menu` VALUES (2000, 0, '0', '数据', 'dataCenter', 'icon-storage', 'dataCenter', NULL, NULL, 2, 'M', 0, NULL, 1, 98, NULL, 1, 1, '2021-07-31 17:17:03', '2021-07-31 17:17:03', NULL);
INSERT INTO `eb_system_menu` VALUES (2100, 2000, '0,2000', '数据字典', '/core/dictType', 'ma-icon-dict', 'dict', 'system/dict/index', NULL, 2, 'M', 0, NULL, 1, 99, NULL, 1, 1, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL);
INSERT INTO `eb_system_menu` VALUES (2101, 2100, '0,2000,2100', '数据字典列表', '/core/dictType/index', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL);
INSERT INTO `eb_system_menu` VALUES (2102, 2100, '0,2000,2100', '数据字典回收站', '/core/dictType/recycle', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL);
INSERT INTO `eb_system_menu` VALUES (2103, 2100, '0,2000,2100', '数据字典保存', '/core/dictType/save', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL);
INSERT INTO `eb_system_menu` VALUES (2104, 2100, '0,2000,2100', '数据字典更新', '/core/dictType/update', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL);
INSERT INTO `eb_system_menu` VALUES (2105, 2100, '0,2000,2100', '数据字典删除', '/core/dictType/destroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:33:45', '2021-07-31 18:33:45', NULL);
INSERT INTO `eb_system_menu` VALUES (2106, 2100, '0,2000,2100', '数据字典读取', '/core/dictType/read', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL);
INSERT INTO `eb_system_menu` VALUES (2107, 2100, '0,2000,2100', '数据字典恢复', '/core/dictType/recovery', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:33:46', '2021-07-31 18:33:46', NULL);
INSERT INTO `eb_system_menu` VALUES (2108, 2100, '0,2000,2100', '数据字典销毁', '/core/dictType/realDestroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2024-04-30 16:30:00', '2023-04-30 16:30:00', NULL);
INSERT INTO `eb_system_menu` VALUES (2112, 2100, '0,2000,2100', '字典状态改变', '/core/dictType/changeStatus', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-11-09 18:26:15', '2021-11-09 18:26:15', NULL);
INSERT INTO `eb_system_menu` VALUES (2200, 2000, '0,2000', '附件管理', '/core/attachment', 'ma-icon-attach', 'attachment', 'system/attachment/index', NULL, 2, 'M', 0, NULL, 1, 98, NULL, 1, 1, '2021-07-31 18:36:34', '2021-07-31 18:36:34', NULL);
INSERT INTO `eb_system_menu` VALUES (2201, 2200, '0,2000,2200', '附件删除', '/core/attachment/destroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:37:20', '2021-07-31 18:37:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2202, 2200, '0,2000,2200', '附件列表', '/core/attachment/index', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:38:05', '2021-07-31 18:38:05', NULL);
INSERT INTO `eb_system_menu` VALUES (2203, 2200, '0,2000,2200', '附件回收站', '/core/attachment/recycle', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:38:57', '2021-07-31 18:38:57', NULL);
INSERT INTO `eb_system_menu` VALUES (2204, 2200, '0,2000,2200', '附件恢复', '/core/attachment/recovery', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:40:44', '2021-07-31 18:40:44', NULL);
INSERT INTO `eb_system_menu` VALUES (2205, 2200, '0,2000,2200', '附件销毁', '/core/attachment/realDestroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2024-04-30 16:30:00', '2023-04-30 16:30:00', NULL);
INSERT INTO `eb_system_menu` VALUES (2300, 2000, '0,2000', '数据表维护', '/core/dataMaintain', 'ma-icon-db', 'dataMaintain', 'system/dataMaintain/index', NULL, 2, 'M', 0, NULL, 1, 95, NULL, 1, 1, '2021-07-31 18:43:20', '2021-07-31 18:43:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2301, 2300, '0,2000,2300', '数据表列表', '/core/dataMaintain/index', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:44:03', '2021-07-31 18:44:03', NULL);
INSERT INTO `eb_system_menu` VALUES (2302, 2300, '0,2000,2300', '数据表详细', '/core/dataMaintain/detailed', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:45:17', '2021-07-31 18:45:17', NULL);
INSERT INTO `eb_system_menu` VALUES (2303, 2300, '0,2000,2300', '数据表清理碎片', '/core/dataMaintain/fragment', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:46:04', '2021-07-31 18:46:04', NULL);
INSERT INTO `eb_system_menu` VALUES (2304, 2300, '0,2000,2300', '数据表优化', '/core/dataMaintain/optimize', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:46:31', '2021-07-31 18:46:31', NULL);
INSERT INTO `eb_system_menu` VALUES (2700, 2000, '0,2000', '系统公告', '/core/notice', 'icon-bulb', 'notice', 'system/notice/index', NULL, 2, 'M', 0, NULL, 1, 94, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2701, 2700, '0,2000,2700', '系统公告列表', '/core/notice/index', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2702, 2700, '0,2000,2700', '系统公告回收站', '/core/notice/recycle', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2703, 2700, '0,2000,2700', '系统公告保存', '/core/notice/save', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2704, 2700, '0,2000,2700', '系统公告更新', '/core/notice/update', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2705, 2700, '0,2000,2700', '系统公告删除', '/core/notice/destroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2706, 2700, '0,2000,2700', '系统公告读取', '/core/notice/read', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2707, 2700, '0,2000,2700', '系统公告恢复', '/core/notice/recovery', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-12-25 18:10:20', '2021-12-25 18:10:20', NULL);
INSERT INTO `eb_system_menu` VALUES (2708, 2700, '0,2000,2700', '系统公告销毁', '/core/notice/realDestroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2024-04-30 16:30:00', '2023-04-30 16:30:00', NULL);
INSERT INTO `eb_system_menu` VALUES (3000, 0, '0', '监控', 'monitor', 'icon-desktop', 'monitor', NULL, NULL, 2, 'M', 0, NULL, 1, 97, NULL, 1, 1, '2021-07-31 18:49:24', '2021-07-31 18:49:24', NULL);
INSERT INTO `eb_system_menu` VALUES (3200, 3000, '0,3000', '服务监控', '/core/system/monitor', 'icon-thunderbolt', 'server', 'system/monitor/server/index', NULL, 2, 'M', 0, NULL, 1, 99, NULL, 1, 1, '2021-07-31 18:52:46', '2021-07-31 18:52:46', NULL);
INSERT INTO `eb_system_menu` VALUES (3300, 3000, '0,3000', '日志监控', 'logs', 'icon-book', 'logs', NULL, NULL, 2, 'M', 0, NULL, 1, 95, NULL, 1, 1, '2021-07-31 18:54:01', '2021-07-31 18:54:01', NULL);
INSERT INTO `eb_system_menu` VALUES (3400, 3300, '0,3000,3200', '登录日志', '/core/logs/deleteLoginLog', 'icon-idcard', 'loginLog', 'system/logs/loginLog', NULL, 2, 'M', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:54:55', '2021-07-31 18:54:55', NULL);
INSERT INTO `eb_system_menu` VALUES (3401, 3400, '0,3000,3200,3300', '登录日志删除', '/core/logs/deleteOperLog', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:56:43', '2021-07-31 18:56:43', NULL);
INSERT INTO `eb_system_menu` VALUES (3500, 3300, '0,3000,3200', '操作日志', '/core/logs/getOperLogPageList', 'icon-robot', 'operLog', 'system/logs/operLog', NULL, 2, 'M', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:55:40', '2021-07-31 18:55:40', NULL);
INSERT INTO `eb_system_menu` VALUES (3501, 3500, '0,3000,3200,3500', '操作日志删除', '/core/logs/deleteOperLog', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:56:19', '2021-07-31 18:56:19', NULL);
INSERT INTO `eb_system_menu` VALUES (3600, 3000, '0,3000', '邮件记录', '/core/email/index', 'icon-calendar', 'emailLog', 'system/logs/emailLog', NULL, 2, 'M', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:55:40', '2021-07-31 18:55:40', NULL);
INSERT INTO `eb_system_menu` VALUES (3601, 3600, '0,3000,3600', '邮件记录删除', '/core/email/destroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 18:56:19', '2021-07-31 18:56:19', NULL);
INSERT INTO `eb_system_menu` VALUES (4000, 0, '0', '工具', 'devTools', 'ma-icon-tool', 'devTools', NULL, NULL, 2, 'M', 0, NULL, 1, 95, NULL, 1, 1, '2021-07-31 19:03:32', '2021-07-31 19:03:32', NULL);
INSERT INTO `eb_system_menu` VALUES (4200, 4000, '0,4000', '代码生成器', '/tool/code', 'ma-icon-code', 'code', 'setting/code/index', NULL, 2, 'M', 0, NULL, 1, 98, NULL, 1, 1, '2021-07-31 19:36:17', '2021-07-31 19:36:17', NULL);
INSERT INTO `eb_system_menu` VALUES (4400, 4000, '0,4000', '定时任务', '/core/crontab', 'icon-schedule', 'crontab', 'setting/crontab/index', NULL, 2, 'M', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL);
INSERT INTO `eb_system_menu` VALUES (4401, 4400, '0,4000,4400', '定时任务列表', '/core/crontab/index', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL);
INSERT INTO `eb_system_menu` VALUES (4402, 4400, '0,4000,4400', '定时任务保存', '/core/crontab/save', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL);
INSERT INTO `eb_system_menu` VALUES (4403, 4400, '0,4000,4400', '定时任务更新', '/core/crontab/update', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL);
INSERT INTO `eb_system_menu` VALUES (4404, 4400, '0,4000,4400', '定时任务删除', '/core/crontab/destroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL);
INSERT INTO `eb_system_menu` VALUES (4405, 4400, '0,4000,4400', '定时任务读取', '/core/crontab/read', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 19:47:49', '2021-07-31 19:47:49', NULL);
INSERT INTO `eb_system_menu` VALUES (4408, 4400, '0,4000,4400', '定时任务执行', '/core/crontab/run', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-08-07 23:44:06', '2021-08-07 23:44:06', NULL);
INSERT INTO `eb_system_menu` VALUES (4409, 4400, '0,4000,4400', '定时任务日志删除', '/core/crontab/deleteLog', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-12-06 22:06:12', '2021-12-06 22:06:12', NULL);
INSERT INTO `eb_system_menu` VALUES (4500, 0, '0', '系统设置', '/core/config', 'icon-settings', 'system', 'setting/config/index', NULL, 2, 'M', 0, NULL, 1, 0, NULL, 1, 1, '2021-07-31 19:58:57', '2023-12-13 14:49:47', NULL);
INSERT INTO `eb_system_menu` VALUES (4502, 4500, '0,4500', '配置列表', '/core/config/index', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-08-10 13:09:18', '2021-08-10 13:09:18', NULL);
INSERT INTO `eb_system_menu` VALUES (4504, 4500, '0,4500', '新增配置 ', '/core/config/save', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-08-10 13:11:56', '2021-08-10 13:11:56', NULL);
INSERT INTO `eb_system_menu` VALUES (4505, 4500, '0,4500', '更新配置', '/core/config/update', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-08-10 13:12:25', '2021-08-10 13:12:25', NULL);
INSERT INTO `eb_system_menu` VALUES (4506, 4500, '0,4500', '删除配置', '/core/config/destroy', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-08-10 13:13:33', '2021-08-10 13:13:33', NULL);
INSERT INTO `eb_system_menu` VALUES (4507, 4500, '0,4500', '清除配置缓存', '/core/config/clearCache', NULL, NULL, NULL, NULL, 2, 'B', 0, NULL, 1, 0, NULL, 1, 1, '2021-08-10 13:13:59', '2021-08-10 13:13:59', NULL);

-- ----------------------------
-- Table structure for eb_system_notice
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_notice`;
CREATE TABLE `eb_system_notice`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `message_id` int(11) NULL DEFAULT NULL COMMENT '消息ID',
    `title` varchar(255) NULL DEFAULT NULL COMMENT '标题',
    `type` smallint(6) NULL DEFAULT NULL COMMENT '公告类型(1通知 2公告)',
    `content` text NULL COMMENT '公告内容',
    `click_num` int(11) NULL DEFAULT 0 COMMENT '浏览次数',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建人',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新人',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `message_id`(`message_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 COMMENT = '系统公告表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_notice
-- ----------------------------
INSERT INTO `eb_system_notice` VALUES (1, NULL, '欢迎使用SaiAdmin', 1, '<p>saiadmin是一款基于vue3 + webman 的极速开发框架，前端开发采用JavaScript，后端采用PHP</p>', 0, NULL, 1, 1, '2024-01-20 15:55:36', '2024-01-20 15:55:36', NULL);

-- ----------------------------
-- Table structure for eb_system_oper_log
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_oper_log`;
CREATE TABLE `eb_system_oper_log`  (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `username` varchar(20) NULL DEFAULT NULL COMMENT '用户名',
    `app` varchar(50) NULL DEFAULT NULL COMMENT '应用名称',
    `method` varchar(20) NULL DEFAULT NULL COMMENT '请求方式',
    `router` varchar(500) NULL DEFAULT NULL COMMENT '请求路由',
    `service_name` varchar(30) NULL DEFAULT NULL COMMENT '业务名称',
    `ip` varchar(45) NULL DEFAULT NULL COMMENT '请求IP地址',
    `ip_location` varchar(255) NULL DEFAULT NULL COMMENT 'IP所属地',
    `request_data` text NULL COMMENT '请求数据',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '更新时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 COMMENT = '操作日志表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_oper_log
-- ----------------------------

-- ----------------------------
-- Table structure for eb_system_post
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_post`;
CREATE TABLE `eb_system_post`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `name` varchar(50) NULL DEFAULT NULL COMMENT '岗位名称',
    `code` varchar(100) NULL DEFAULT NULL COMMENT '岗位代码',
    `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
    `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 COMMENT = '岗位信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_post
-- ----------------------------
INSERT INTO `eb_system_post` VALUES (1, '总经理', 'zongjingli', 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-12-04 18:02:32', NULL);
INSERT INTO `eb_system_post` VALUES (2, '技术经理', 'jishujingli', 10, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-11-15 10:29:47', NULL);
INSERT INTO `eb_system_post` VALUES (3, '销售经理', 'xiaoshoujingli', 5, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-11-15 11:54:50', NULL);
INSERT INTO `eb_system_post` VALUES (4, '员工', 'yuangong', 1, 1, NULL, 1, 1, '2023-10-24 12:00:00', '2023-11-15 09:51:12', NULL);
INSERT INTO `eb_system_post` VALUES (5, '测试岗位', 'test', 15, 1, NULL, 1, 1, '2023-11-15 09:42:08', '2023-12-06 21:40:46', NULL);
INSERT INTO `eb_system_post` VALUES (6, '技术部', 'jishu', 100, 1, NULL, 1, 1, '2023-12-12 16:19:33', '2023-12-12 16:28:24', NULL);

-- ----------------------------
-- Table structure for eb_system_role
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_role`;
CREATE TABLE `eb_system_role`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `parent_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '父ID',
    `level` varchar(500) NULL DEFAULT NULL COMMENT '组级集合',
    `name` varchar(30) NULL DEFAULT NULL COMMENT '角色名称',
    `code` varchar(100) NULL DEFAULT NULL COMMENT '角色代码',
    `data_scope` smallint(6) NULL DEFAULT 1 COMMENT '数据范围(1:全部数据权限 2:自定义数据权限 3:本部门数据权限 4:本部门及以下数据权限 5:本人数据权限)',
    `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
    `sort` smallint(5) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 COMMENT = '角色信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_role
-- ----------------------------
INSERT INTO `eb_system_role` VALUES (1, 0, '0', '超级管理员（创始人）', 'superAdmin', 1, 1, 100, '系统内置角色，不可删除', 1, 1, '2023-10-24 12:00:00', '2023-10-24 12:00:00', NULL);
INSERT INTO `eb_system_role` VALUES (2, 1, '0,1', '总经理', 'zongjingli', 1, 1, 100, '', 1, 1, '2023-10-24 12:00:00', '2024-08-12 15:47:28', NULL);
INSERT INTO `eb_system_role` VALUES (3, 2, '0,1,2', '销售总监', 'xiaoshouzongjian', 1, 1, 100, '', 1, 2, '2023-10-24 12:00:00', '2024-08-15 23:07:20', NULL);
INSERT INTO `eb_system_role` VALUES (4, 2, '0,1,2', '财务总监', 'caiwuzongjian', 1, 1, 100, '', 1, 1, '2023-10-24 12:00:00', '2024-08-12 15:50:04', NULL);
INSERT INTO `eb_system_role` VALUES (5, 2, '0,1,2', '技术总监', 'jishuzongjian', 1, 1, 100, '', 1, 1, '2023-10-24 12:00:00', '2024-08-12 15:38:42', NULL);
INSERT INTO `eb_system_role` VALUES (6, 3, '0,1,2,3', '销售经理', 'xiaoshoujingli', 1, 1, 100, '', 1, 6, '2023-10-24 12:00:00', '2024-08-12 22:20:36', NULL);
INSERT INTO `eb_system_role` VALUES (7, 6, '0,1,2,3,6', '销售专员', 'xiaoshouzhuanyuan', 1, 1, 100, '', 1, 1, '2024-08-12 15:40:39', '2024-08-12 15:49:49', NULL);
INSERT INTO `eb_system_role` VALUES (8, 4, '0,1,2,4', '财务经理', 'caiwujingli', 1, 1, 100, '', 1, 1, '2024-08-12 15:41:33', '2024-08-12 15:50:11', NULL);
INSERT INTO `eb_system_role` VALUES (9, 8, '0,1,2,4,8', '财务专员', 'caiwuzhuanyuan', 1, 1, 100, '', 1, 1, '2024-08-12 15:41:46', '2024-08-12 15:50:15', NULL);
INSERT INTO `eb_system_role` VALUES (10, 5, '0,1,2,5', '开发部经理', 'kaifajingli', 1, 1, 100, '', 1, 1, '2024-08-12 15:42:40', '2024-08-12 15:50:26', NULL);
INSERT INTO `eb_system_role` VALUES (11, 5, '0,1,2,5', '测试部经理', 'ceshijingli', 1, 1, 100, '', 1, 1, '2024-08-12 15:43:00', '2024-08-12 15:50:37', NULL);
INSERT INTO `eb_system_role` VALUES (12, 10, '0,1,2,5,10', '程序员', 'chegnxuyuan', 1, 1, 100, '', 1, 1, '2024-08-12 15:43:21', '2024-08-12 15:50:31', NULL);
INSERT INTO `eb_system_role` VALUES (13, 11, '0,1,2,5,11', '测试员', 'ceshiyuan', 1, 1, 100, '', 1, 1, '2024-08-12 15:43:38', '2024-08-12 15:50:41', NULL);

-- ----------------------------
-- Table structure for eb_system_role_dept
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_role_dept`;
CREATE TABLE `eb_system_role_dept`  (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
    `role_id` int(11) unsigned NOT NULL COMMENT '用户主键',
    `dept_id` int(11) unsigned NOT NULL COMMENT '角色主键',
    PRIMARY KEY (`id`) USING BTREE,
    KEY `idx_role_id` (`role_id`) USING BTREE,
    KEY `idx_dept_id` (`dept_id`) USING BTREE
) ENGINE = InnoDB COMMENT = '角色与部门关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_role_dept
-- ----------------------------

-- ----------------------------
-- Table structure for eb_system_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_role_menu`;
CREATE TABLE `eb_system_role_menu`  (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
    `role_id` int(11) unsigned NOT NULL COMMENT '角色主键',
    `menu_id` int(11) unsigned NOT NULL COMMENT '菜单主键',
    PRIMARY KEY (`id`) USING BTREE,
    KEY `idx_role_id` (`role_id`) USING BTREE,
    KEY `idx_menu_id` (`menu_id`) USING BTREE
) ENGINE = InnoDB COMMENT = '角色与菜单关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_role_menu
-- ----------------------------

-- ----------------------------
-- Table structure for eb_system_uploadfile
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_uploadfile`;
CREATE TABLE `eb_system_uploadfile`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `storage_mode` smallint(6) NULL DEFAULT 1 COMMENT '存储模式 (1 本地 2 阿里云 3 七牛云 4 腾讯云)',
    `origin_name` varchar(255) NULL DEFAULT NULL COMMENT '原文件名',
    `object_name` varchar(50) NULL DEFAULT NULL COMMENT '新文件名',
    `hash` varchar(64) NULL DEFAULT NULL COMMENT '文件hash',
    `mime_type` varchar(255) NULL DEFAULT NULL COMMENT '资源类型',
    `storage_path` varchar(100) NULL DEFAULT NULL COMMENT '存储目录',
    `suffix` varchar(10) NULL DEFAULT NULL COMMENT '文件后缀',
    `size_byte` bigint(20) NULL DEFAULT NULL COMMENT '字节数',
    `size_info` varchar(50) NULL DEFAULT NULL COMMENT '文件大小',
    `url` varchar(255) NULL DEFAULT NULL COMMENT 'url地址',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `hash`(`hash`) USING BTREE,
    INDEX `storage_path`(`storage_path`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 COMMENT = '上传文件信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_uploadfile
-- ----------------------------

-- ----------------------------
-- Table structure for eb_system_user
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_user`;
CREATE TABLE `eb_system_user`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户ID,主键',
    `username` varchar(20) NOT NULL COMMENT '用户名',
    `password` varchar(100) NOT NULL COMMENT '密码',
    `user_type` varchar(3) NULL DEFAULT '100' COMMENT '用户类型:(100系统用户)',
    `nickname` varchar(30) NULL DEFAULT NULL COMMENT '用户昵称',
    `phone` varchar(11) NULL DEFAULT NULL COMMENT '手机',
    `email` varchar(50) NULL DEFAULT NULL COMMENT '用户邮箱',
    `avatar` varchar(255) NULL DEFAULT NULL COMMENT '用户头像',
    `signed` varchar(255) NULL DEFAULT NULL COMMENT '个人签名',
    `dashboard` varchar(100) NULL DEFAULT NULL COMMENT '后台首页类型',
    `dept_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '部门ID',
    `status` smallint(6) NULL DEFAULT 1 COMMENT '状态 (1正常 2停用)',
    `login_ip` varchar(45) NULL DEFAULT NULL COMMENT '最后登陆IP',
    `login_time` datetime(0) NULL DEFAULT NULL COMMENT '最后登陆时间',
    `backend_setting` varchar(500) NULL DEFAULT NULL COMMENT '后台设置数据',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `username`(`username`) USING BTREE,
    INDEX `dept_id`(`dept_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 COMMENT = '用户信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_user
-- ----------------------------
INSERT INTO `eb_system_user` VALUES (1, 'admin', '$2y$10$Q70WC9RBqMSS72DmppsbIuQtyAydXSmeD.Ae6W8YhmE/w15uLLpiy', '100', '祭道之上', '13888888888', 'admin@admin.com', 'https://image.saithink.top/saiadmin/avatar.jpg', 'Today is very good！', 'statistics', 0, 1, '127.0.0.1', '2024-07-31 21:03:43', '{\"mode\":\"light\",\"tag\":true,\"menuCollapse\":false,\"menuWidth\":230,\"layout\":\"classic\",\"skin\":\"mine\",\"i18n\":true,\"language\":\"zh_CN\",\"animation\":\"ma-slide-down\",\"color\":\"#165DFF\"}', NULL, 1, 1, '2024-01-20 16:02:23', '2024-07-31 21:03:44', NULL);
INSERT INTO `eb_system_user` VALUES (2, 'test1', '$2y$10$Q70WC9RBqMSS72DmppsbIuQtyAydXSmeD.Ae6W8YhmE/w15uLLpiy', '100', '小小测试员', '15822222222', 'test1@saadmin.com', 'http://127.0.0.1:8787/storage/20240731/7971881d7e10a122e0f51ea188571dbe29d82229.jpg', NULL, 'work', 2, 1, '127.0.0.1', '2024-01-20 16:02:22', 'null', 'test', 1, 1, '2024-07-31 09:34:31', '2024-07-31 10:03:04', NULL);
INSERT INTO `eb_system_user` VALUES (3, 'test2', '$2y$10$Q70WC9RBqMSS72DmppsbIuQtyAydXSmeD.Ae6W8YhmE/w15uLLpiy', '100', '酱油党', '13977777777', 'test2@saadmin.com', 'https://image.saithink.top/saiadmin/avatar.jpg', NULL, 'work', 3, 1, '127.0.0.1', '2024-01-20 16:02:22', 'null', 'test', 1, 1, '2024-07-31 09:34:31', '2024-07-31 09:37:10', NULL);

-- ----------------------------
-- Table structure for eb_system_user_post
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_user_post`;
CREATE TABLE `eb_system_user_post`  (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
    `user_id` int(11) unsigned NOT NULL COMMENT '用户主键',
    `post_id` int(11) unsigned NOT NULL COMMENT '岗位主键',
    PRIMARY KEY (`id`,`user_id`) USING BTREE,
    KEY `idx_user_id` (`user_id`) USING BTREE,
    KEY `idx_post_id` (`post_id`) USING BTREE
) ENGINE = InnoDB COMMENT = '用户与岗位关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_user_post
-- ----------------------------

-- ----------------------------
-- Table structure for eb_system_user_role
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_user_role`;
CREATE TABLE `eb_system_user_role`  (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
    `user_id` int(11) unsigned NOT NULL COMMENT '用户主键',
    `role_id` int(11) unsigned NOT NULL COMMENT '角色主键',
    PRIMARY KEY (`id`),
    KEY `idx_user_id` (`user_id`) USING BTREE,
    KEY `idx_role_id` (`role_id`) USING BTREE
) ENGINE = InnoDB COMMENT = '用户与角色关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_system_user_role
-- ----------------------------
INSERT INTO `eb_system_user_role` VALUES (1, 1, 1);

-- ----------------------------
-- Table structure for eb_tool_generate_columns
-- ----------------------------
DROP TABLE IF EXISTS `eb_tool_generate_columns`;
CREATE TABLE `eb_tool_generate_columns`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `table_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '所属表ID',
    `column_name` varchar(200) NULL DEFAULT NULL COMMENT '字段名称',
    `column_comment` varchar(255) NULL DEFAULT NULL COMMENT '字段注释',
    `column_type` varchar(50) NULL DEFAULT NULL COMMENT '字段类型',
    `default_value` varchar(50) NULL DEFAULT NULL COMMENT '默认值',
    `is_pk` smallint(6) NULL DEFAULT 1 COMMENT '1 非主键 2 主键',
    `is_required` smallint(6) NULL DEFAULT 1 COMMENT '1 非必填 2 必填',
    `is_insert` smallint(6) NULL DEFAULT 1 COMMENT '1 非插入字段 2 插入字段',
    `is_edit` smallint(6) NULL DEFAULT 1 COMMENT '1 非编辑字段 2 编辑字段',
    `is_list` smallint(6) NULL DEFAULT 1 COMMENT '1 非列表显示字段 2 列表显示字段',
    `is_query` smallint(6) NULL DEFAULT 1 COMMENT '1 非查询字段 2 查询字段',
    `is_sort` smallint(6) NULL DEFAULT 1 COMMENT '1 非排序 2 排序',
    `query_type` varchar(100) NULL DEFAULT 'eq' COMMENT '查询方式 eq 等于, neq 不等于, gt 大于, lt 小于, like 范围',
    `view_type` varchar(100) NULL DEFAULT 'text' COMMENT '页面控件,text, textarea, password, select, checkbox, radio, date, upload, ma-upload(封装的上传控件)',
    `dict_type` varchar(200) NULL DEFAULT NULL COMMENT '字典类型',
    `allow_roles` varchar(255) NULL DEFAULT NULL COMMENT '允许查看该字段的角色',
    `options` varchar(1000) NULL DEFAULT NULL COMMENT '字段其他设置',
    `sort` tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '排序',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 42 COMMENT = '代码生成业务字段表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_tool_generate_columns
-- ----------------------------
INSERT INTO `eb_tool_generate_columns` VALUES (1, 1, 'id', '编号', 'int', NULL, 2, 2, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 18, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (2, 1, 'category_id', '分类id', 'int', NULL, 1, 2, 2, 1, 1, 1, 1, 'eq', 'treeSelect', NULL, NULL, NULL, 17, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (3, 1, 'title', '文章标题', 'varchar', '', 1, 2, 2, 2, 2, 2, 1, 'like', 'input', NULL, NULL, NULL, 16, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (4, 1, 'author', '文章作者', 'varchar', NULL, 1, 1, 2, 2, 2, 1, 1, 'eq', 'input', NULL, NULL, NULL, 15, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (5, 1, 'image', '文章图片', 'varchar', '', 1, 1, 2, 2, 2, 1, 1, 'eq', 'uploadImage', NULL, NULL, '{\"multiple\":false,\"limit\":3}', 14, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (6, 1, 'describe', '文章简介', 'varchar', NULL, 1, 2, 2, 2, 2, 1, 1, 'eq', 'textarea', NULL, NULL, NULL, 13, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (7, 1, 'content', '文章内容', 'text', NULL, 1, 2, 2, 2, 1, 1, 1, 'eq', 'wangEditor', NULL, NULL, '{\"height\":400}', 12, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (8, 1, 'views', '浏览次数', 'int', '0', 1, 1, 2, 2, 2, 1, 1, 'eq', 'inputNumber', NULL, NULL, NULL, 11, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (9, 1, 'sort', '排序', 'int', '100', 1, 1, 2, 2, 2, 1, 1, 'eq', 'inputNumber', NULL, NULL, NULL, 10, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (10, 1, 'status', '状态', 'tinyint', '1', 1, 1, 2, 2, 2, 1, 1, 'eq', 'radio', 'data_status', NULL, NULL, 9, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (11, 1, 'is_link', '是否外链', 'tinyint', '2', 1, 1, 2, 2, 2, 1, 1, 'eq', 'radio', 'yes_or_no', NULL, NULL, 8, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (12, 1, 'link_url', '链接地址', 'varchar', NULL, 1, 1, 2, 2, 2, 1, 1, 'eq', 'input', NULL, NULL, NULL, 7, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (13, 1, 'is_hot', '是否热门', 'tinyint', '2', 1, 1, 2, 2, 2, 1, 1, 'eq', 'radio', 'yes_or_no', NULL, NULL, 6, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (14, 1, 'created_by', '创建者', 'int', NULL, 1, 1, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 5, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (15, 1, 'updated_by', '更新者', 'int', NULL, 1, 1, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 4, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (16, 1, 'create_time', '创建时间', 'datetime', NULL, 1, 1, 1, 1, 1, 1, 1, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true}', 3, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (17, 1, 'update_time', '修改时间', 'datetime', NULL, 1, 1, 1, 1, 1, 1, 1, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true}', 2, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (18, 2, 'id', '编号', 'int', NULL, 2, 2, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 14, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (19, 2, 'banner_type', '类型', 'int', NULL, 1, 2, 2, 2, 2, 1, 1, 'eq', 'saSelect', 'backend_notice_type', NULL, NULL, 13, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (20, 2, 'image', '图片地址', 'varchar', NULL, 1, 1, 2, 2, 2, 1, 1, 'eq', 'uploadImage', NULL, NULL, '{\"multiple\":false,\"limit\":3}', 12, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (21, 2, 'is_href', '是否链接', 'tinyint', '1', 1, 1, 2, 2, 2, 1, 1, 'eq', 'radio', 'yes_or_no', NULL, NULL, 11, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (22, 2, 'url', '链接地址', 'varchar', NULL, 1, 1, 2, 2, 2, 1, 1, 'eq', 'input', NULL, NULL, NULL, 10, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (23, 2, 'title', '标题', 'varchar', NULL, 1, 2, 2, 2, 2, 2, 1, 'like', 'input', NULL, NULL, NULL, 9, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (24, 2, 'status', '状态', 'tinyint', '1', 1, 1, 2, 2, 2, 1, 1, 'eq', 'radio', 'data_status', NULL, NULL, 8, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (25, 2, 'sort', '排序', 'int', '0', 1, 1, 2, 2, 2, 1, 1, 'eq', 'inputNumber', NULL, NULL, NULL, 7, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (26, 2, 'remark', '描述', 'varchar', NULL, 1, 1, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 6, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (27, 2, 'created_by', '创建者', 'int', NULL, 1, 1, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 5, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (28, 2, 'updated_by', '更新者', 'int', NULL, 1, 1, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 4, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (29, 2, 'create_time', '创建时间', 'datetime', NULL, 1, 1, 1, 1, 1, 1, 1, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true}', 3, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (30, 2, 'update_time', '修改时间', 'datetime', NULL, 1, 1, 1, 1, 1, 1, 1, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true}', 2, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (31, 3, 'id', '编号', 'int', NULL, 2, 2, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 12, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:47:35', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (32, 3, 'parent_id', '上级菜单', 'int', '0', 1, 2, 2, 2, 1, 1, 1, 'eq', 'treeSelect', NULL, NULL, NULL, 11, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:47:35', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (33, 3, 'category_name', '分类标题', 'varchar', NULL, 1, 2, 2, 2, 2, 2, 1, 'like', 'input', NULL, NULL, NULL, 10, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:47:35', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (34, 3, 'describe', '分类简介', 'varchar', NULL, 1, 1, 2, 2, 2, 1, 1, 'eq', 'textarea', NULL, NULL, NULL, 9, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:47:35', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (35, 3, 'image', '分类图片', 'varchar', NULL, 1, 1, 2, 2, 2, 1, 1, 'eq', 'uploadImage', NULL, NULL, '{\"multiple\":false,\"limit\":3}', 8, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:47:35', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (36, 3, 'sort', '排序', 'int', '100', 1, 1, 2, 2, 2, 1, 1, 'eq', 'inputNumber', NULL, NULL, NULL, 7, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:47:35', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (37, 3, 'status', '状态', 'tinyint', '1', 1, 1, 2, 2, 2, 1, 1, 'eq', 'radio', 'data_status', NULL, NULL, 6, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:47:35', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (38, 3, 'created_by', '创建者', 'int', NULL, 1, 1, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 5, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:47:35', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (39, 3, 'updated_by', '更新者', 'int', NULL, 1, 1, 1, 1, 1, 1, 1, 'eq', 'input', NULL, NULL, NULL, 4, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:47:35', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (40, 3, 'create_time', '创建时间', 'datetime', NULL, 1, 1, 1, 1, 1, 1, 1, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true}', 3, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:47:35', NULL);
INSERT INTO `eb_tool_generate_columns` VALUES (41, 3, 'update_time', '修改时间', 'datetime', NULL, 1, 1, 1, 1, 1, 1, 1, 'between', 'date', NULL, NULL, '{\"mode\":\"date\",\"showTime\":true}', 2, NULL, 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:47:35', NULL);

-- ----------------------------
-- Table structure for eb_tool_generate_tables
-- ----------------------------
DROP TABLE IF EXISTS `eb_tool_generate_tables`;
CREATE TABLE `eb_tool_generate_tables`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
    `table_name` varchar(200) NULL DEFAULT NULL COMMENT '表名称',
    `table_comment` varchar(500) NULL DEFAULT NULL COMMENT '表注释',
    `stub` varchar(50) NULL DEFAULT NULL COMMENT 'stub类型',
    `template` varchar(50) NULL DEFAULT NULL COMMENT '模板名称',
    `namespace` varchar(255) NULL DEFAULT NULL COMMENT '命名空间',
    `package_name` varchar(100) NULL DEFAULT NULL COMMENT '控制器包名',
    `business_name` varchar(50) NULL DEFAULT NULL COMMENT '业务名称',
    `class_name` varchar(50) NULL DEFAULT NULL COMMENT '类名称',
    `menu_name` varchar(100) NULL DEFAULT NULL COMMENT '生成菜单名',
    `belong_menu_id` int(11) NULL DEFAULT NULL COMMENT '所属菜单',
    `tpl_category` varchar(100) NULL DEFAULT NULL COMMENT '生成类型,single 单表CRUD,tree 树表CRUD,parent_sub父子表CRUD',
    `generate_type` smallint(6) NULL DEFAULT 1 COMMENT '1 压缩包下载 2 生成到模块',
    `generate_path` varchar(100) NULL DEFAULT 'saiadmin-vue' COMMENT '前端根目录',
    `generate_model` smallint(6) NULL DEFAULT 1 COMMENT '1 软删除 2 非软删除',
    `generate_menus` varchar(255) NULL DEFAULT NULL COMMENT '生成菜单列表',
    `build_menu` smallint(6) NULL DEFAULT 1 COMMENT '是否构建菜单',
    `component_type` smallint(6) NULL DEFAULT 1 COMMENT '组件显示方式',
    `options` varchar(1500) NULL DEFAULT NULL COMMENT '其他业务选项',
    `form_width` int(11) NULL DEFAULT 600 COMMENT '表单宽度',
    `is_full` tinyint(1) NULL DEFAULT 1 COMMENT '是否全屏',
    `remark` varchar(255) NULL DEFAULT NULL COMMENT '备注',
    `source` varchar(255) NULL DEFAULT NULL COMMENT '数据源',
    `created_by` int(11) NULL DEFAULT NULL COMMENT '创建者',
    `updated_by` int(11) NULL DEFAULT NULL COMMENT '更新者',
    `create_time` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
    `update_time` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
    `delete_time` datetime(0) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 COMMENT = '代码生成业务表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of eb_tool_generate_tables
-- ----------------------------
INSERT INTO `eb_tool_generate_tables` VALUES (1, 'eb_article', '文章表', 'saiadmin', 'app', 'cms', '', 'article', 'Article', '文章管理', 4000, 'single', 2, 'saiadmin-vue', 1, 'save,update,read,delete,recycle,recovery,realDestroy', 1, 1, '{\"relations\":[{\"name\":\"category\",\"type\":\"belongsTo\",\"model\":\"ArticleCategory\",\"foreignKey\":\"id\",\"localKey\":\"category_id\",\"table\":\"\"}]}', 600, 2, NULL, 'mysql', 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:52:22', NULL);
INSERT INTO `eb_tool_generate_tables` VALUES (2, 'eb_article_banner', '文章轮播图', 'saiadmin', 'app', 'cms', '', 'banner', 'ArticleBanner', '文章轮播', 4000, 'single', 2, 'saiadmin-vue', 1, 'save,update,read,delete,recycle,recovery,realDestroy', 1, 1, '{\"relations\":[]}', 600, 1, NULL, 'mysql', 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:28:11', NULL);
INSERT INTO `eb_tool_generate_tables` VALUES (3, 'eb_article_category', '文章分类表', 'saiadmin', 'app', 'cms', '', 'category', 'ArticleCategory', '文章分类', 4000, 'tree', 2, 'saiadmin-vue', 1, 'save,update,read,delete,recycle,recovery,realDestroy', 1, 2, '{\"relations\":[],\"tree_id\":\"id\",\"tree_name\":\"category_name\",\"tree_parent_id\":\"parent_id\"}', 800, 1, NULL, 'mysql', 1, 1, '2024-07-31 17:15:23', '2024-07-31 17:47:35', NULL);

-- ----------------------------
-- Table structure for eb_tool_generate_tables
-- ----------------------------
DROP TABLE IF EXISTS `eb_system_mail`;
CREATE TABLE `eb_system_mail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `gateway` varchar(50) DEFAULT NULL COMMENT '网关',
  `from` varchar(50) DEFAULT NULL COMMENT '发送人',
  `email` varchar(50) DEFAULT NULL COMMENT '接收人',
  `code` varchar(20) DEFAULT NULL COMMENT '验证码',
  `content` varchar(500) DEFAULT NULL COMMENT '邮箱内容',
  `status` varchar(20) DEFAULT NULL COMMENT '发送状态',
  `response` varchar(500) DEFAULT NULL COMMENT '返回结果',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  `delete_time` datetime DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 COMMENT='邮件记录' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
