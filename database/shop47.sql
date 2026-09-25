-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- 호스트: localhost
-- 생성 시간: 26-07-18 22:55
-- 서버 버전: 10.11.16-MariaDB
-- PHP 버전: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `shop47`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `jumun`
--

CREATE TABLE `jumun` (
  `id` char(10) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `jumunday` date DEFAULT NULL,
  `product_names` varchar(255) DEFAULT NULL,
  `product_nums` int(11) DEFAULT NULL,
  `o_name` varchar(20) DEFAULT NULL,
  `o_tel` varchar(13) DEFAULT NULL,
  `o_email` varchar(50) DEFAULT NULL,
  `o_zip` varchar(5) DEFAULT NULL,
  `o_juso` varchar(100) DEFAULT NULL,
  `r_name` varchar(20) DEFAULT NULL,
  `r_tel` varchar(13) DEFAULT NULL,
  `r_email` varchar(50) DEFAULT NULL,
  `r_zip` varchar(5) DEFAULT NULL,
  `r_juso` varchar(100) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `pay_kind` tinyint(4) DEFAULT NULL,
  `card_okno` varchar(10) DEFAULT NULL,
  `card_halbu` tinyint(4) DEFAULT NULL,
  `card_kind` tinyint(4) DEFAULT NULL,
  `bank_kind` int(11) DEFAULT NULL,
  `bank_sender` varchar(30) DEFAULT NULL,
  `totalprice` int(11) DEFAULT NULL,
  `state` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- 테이블의 덤프 데이터 `jumun`
--

INSERT INTO `jumun` (`id`, `member_id`, `jumunday`, `product_names`, `product_nums`, `o_name`, `o_tel`, `o_email`, `o_zip`, `o_juso`, `r_name`, `r_tel`, `r_email`, `r_zip`, `r_juso`, `memo`, `pay_kind`, `card_okno`, `card_halbu`, `card_kind`, `bank_kind`, `bank_sender`, `totalprice`, `state`) VALUES
('2606170007', 4, '2026-06-17', 'The Sims™ 4', 1, '나나나', '010-1212-1212', 'zxc123@gmail.com', '01878', '서울특별시노원구초안산로12인덕대학 11', '나나나', '010-1212-1212', 'zxc123@gmail.com', '01878', '서울특별시노원구초안산로12인덕대학 11', '', 0, '2606170007', 0, 1, 0, '', 2500, 1),
('2606170008', 2, '2026-06-17', 'Red Dead Redemption 2', 1, '가나다', '010-4242-2424', 'asd123@gaiglsa.ocm', '06336', '서울특별시강남구개포로617-8강남구 건강가정지원센터 22', '가나다', '010-4242-2424', 'asd123@gaiglsa.ocm', '06336', '서울특별시강남구개포로617-8강남구 건강가정지원센터 22', '', 0, '2606170008', 0, 1, 0, '', 68500, 4),
('2606170009', 0, '2026-06-17', 'Baldurs Gate 3', 1, '아에이', '010-1234-1234', 'qwer1234@gmail.com', '06244', '서울특별시강남구역삼로147인덕빌딩 11', '아에이', '010-1234-1234', 'qwer1234@gmail.com', '06244', '서울특별시강남구역삼로147인덕빌딩 11', '', 0, '2606170009', 0, 1, 0, '', 35500, 3),
('2606180001', 2, '2026-06-18', 'Cyberpunk 2077', 1, '아나바', '010-1234-1212', 'asar1234@gmail.com', '06244', '서울특별시강남구역삼로147인덕빌딩 11', '아나바', '010-1234-1212', 'asar1234@gmail.com', '06244', '서울특별시강남구역삼로147인덕빌딩 11', '', 0, '2606180001', 0, 1, 0, '', 106000, 2),
('2606180002', 0, '2026-06-18', 'ARC Raiders', 1, 'a', '010-1111-1111', '1', 'adsf', 'undefined a', 'a', '010-1111-1111', 'as', 'ads', 'undefined asdf', 'asdf', 0, '2606180002', 0, 1, 0, '', 39500, 1),
('2606180003', 0, '2026-06-18', 'PRAGMATA 외 1', 2, '이현우', '010-8860-4579', 'a01088604579@gmail.com', '01778', '서울특별시 노원구 동일로207길 17 (중계동) 중계그린아파트 106동 713호', '이현우', '010-8860-4579', 'a01088604579@gmail.com', '01778', '서울특별시 노원구 동일로207길 17 (중계동) 중계그린아파트 106동 713호', '', 1, '', 0, 0, 1, '이현우', 45139600, 1);

-- --------------------------------------------------------

--
-- 테이블 구조 `jumuns`
--

CREATE TABLE `jumuns` (
  `id` int(11) NOT NULL,
  `jumun_id` char(10) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `prices` int(11) DEFAULT NULL,
  `discount` tinyint(4) DEFAULT NULL,
  `opts_id1` int(11) DEFAULT NULL,
  `opts_id2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- 테이블의 덤프 데이터 `jumuns`
--

INSERT INTO `jumuns` (`id`, `jumun_id`, `product_id`, `num`, `price`, `prices`, `discount`, `opts_id1`, `opts_id2`) VALUES
(31, '2606170004', 23, 1, 33000, 33000, 50, 1, 10),
(32, '2606170004', 0, 1, 2500, 2500, 0, 0, 0),
(33, '2606170005', 0, 1, 2500, 2500, 0, 0, 0),
(35, '2606170007', 15, 1, 0, 0, 0, 1, 6),
(36, '2606170007', 0, 1, 2500, 2500, 0, 0, 0),
(37, '2606170008', 13, 1, 66000, 66000, 30, 4, 10),
(38, '2606170008', 0, 1, 2500, 2500, 0, 0, 0),
(39, '2606170009', 21, 1, 33000, 33000, 50, 12, 17),
(40, '2606170009', 0, 1, 2500, 2500, 0, 0, 0),
(41, '2606180001', 10, 2, 53000, 106000, 20, 2, 6),
(42, '2606180002', 7, 1, 37000, 37000, 37, 5, 0),
(43, '2606180002', 0, 1, 2500, 2500, 0, 0, 0),
(44, '2606180003', 11, 2, 69800, 139600, 0, 0, 2026),
(45, '2606180003', 22, 1000, 45000, 45000000, 40, 1, 10);

-- --------------------------------------------------------

--
-- 테이블 구조 `juso`
--

CREATE TABLE `juso` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `tel` varchar(11) DEFAULT NULL,
  `sm` tinyint(4) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `juso` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- 테이블의 덤프 데이터 `juso`
--

INSERT INTO `juso` (`id`, `name`, `tel`, `sm`, `date`, `juso`) VALUES
(1, '최민기', '01627516250', 0, '1990-01-01', '서울 노원구 초안산로 12 인덕대학교 1'),
(2, '노준국', '01192318426', 1, '1990-01-02', '서울 노원구 초안산로 12 인덕대학교 2'),
(3, '배인정', '01091419758', 0, '1990-01-03', '서울 노원구 초안산로 12 인덕대학교 3'),
(4, '윤수진', '01091315099', 0, '1990-01-04', '서울 노원구 초안산로 12 인덕대학교 4'),
(5, '김민주', '01012715951', 1, '1990-01-05', '서울 노원구 초안산로 12 인덕대학교 5'),
(6, '고향에', '01164712495', 0, '1990-01-06', '서울 노원구 초안산로 12 인덕대학교 6'),
(7, '이창기', '01094567737', 0, '1990-01-07', '서울 노원구 초안산로 12 인덕대학교 7'),
(8, '강범조', '01197515356', 0, '1990-01-08', '서울 노원구 초안산로 12 인덕대학교 8'),
(9, '임상호', '01076212041', 1, '1990-01-09', '서울 노원구 초안산로 12 인덕대학교 9'),
(10, '김경진', '01196616064', 0, '1990-01-10', '서울 노원구 초안산로 12 인덕대학교 10'),
(11, '양지민', '01085916932', 0, '1990-01-11', '서울 노원구 초안산로 12 인덕대학교 11'),
(12, '김철규', '01064517732', 0, '1990-01-12', '서울 노원구 초안산로 12 인덕대학교 12'),
(13, '이재진', '01066725207', 0, '1990-01-13', '서울 노원구 초안산로 12 인덕대학교 13'),
(14, '김인기', '01045825553', 1, '1990-01-14', '서울 노원구 초안산로 12 인덕대학교 14'),
(15, '황호하', '01094529069', 0, '1990-01-15', '서울 노원구 초안산로 12 인덕대학교 15'),
(16, '원미현', '01697323309', 0, '1990-01-16', '서울 노원구 초안산로 12 인덕대학교 16'),
(17, '김성현', '01077524586', 0, '1990-01-17', '서울 노원구 초안산로 12 인덕대학교 17'),
(18, '윤태양', '01044624402', 0, '1990-01-18', '서울 노원구 초안산로 12 인덕대학교 18'),
(19, '손영미', '01063021586', 1, '1990-01-19', '서울 노원구 초안산로 12 인덕대학교 19'),
(20, '서찬국', '01029725437', 0, '1990-01-20', '서울 노원구 초안산로 12 인덕대학교 20'),
(21, '최지호', '01095829293', 0, '1990-01-21', '서울 노원구 초안산로 12 인덕대학교 21'),
(22, '현오석', '01045725203', 0, '1990-01-22', '서울 노원구 초안산로 12 인덕대학교 22'),
(23, '고구진', '01039539565', 0, '1990-01-23', '서울 노원구 초안산로 12 인덕대학교 23'),
(24, '임양진', '01049431735', 0, '1990-01-24', '서울 노원구 초안산로 12 인덕대학교 24'),
(25, '박잔형', '01028732059', 0, '1990-01-25', '서울 노원구 초안산로 12 인덕대학교 25'),
(26, '고맹진', '01017331347', 1, '1990-01-26', '서울 노원구 초안산로 12 인덕대학교 26'),
(27, '이미진', '01032434656', 0, '1990-01-27', '서울 노원구 초안산로 12 인덕대학교 27'),
(28, '박신양', '01032633479', 0, '1990-01-28', '서울 노원구 초안산로 12 인덕대학교 28'),
(29, '이부성', '01022533028', 0, '1990-01-29', '서울 노원구 초안산로 12 인덕대학교 29'),
(30, '박조형', '01034634503', 0, '1990-01-30', '서울 노원구 초안산로 12 인덕대학교 30'),
(31, '김당진', '01022144844', 0, '1990-01-31', '서울 노원구 초안산로 12 인덕대학교 31'),
(32, '임조철', '01063146720', 0, '1990-02-01', '서울 노원구 초안산로 12 인덕대학교 32'),
(33, '최미선', '01023744540', 0, '1990-02-02', '서울 노원구 초안산로 12 인덕대학교 33'),
(34, '정해솔', '01057443220', 1, '1990-02-03', '서울 노원구 초안산로 12 인덕대학교 34'),
(35, '이양석', '01045946853', 0, '1990-02-04', '서울 노원구 초안산로 12 인덕대학교 35'),
(36, '조진현', '01074255035', 0, '1990-02-05', '서울 노원구 초안산로 12 인덕대학교 36'),
(37, '김호석', '01015645583', 0, '1990-02-06', '서울 노원구 초안산로 12 인덕대학교 37'),
(38, '김호식', '01014176818', 0, '1990-02-07', '서울 노원구 초안산로 12 인덕대학교 38'),
(39, '김국진', '01022785917', 0, '1990-02-08', '서울 노원구 초안산로 12 인덕대학교 39'),
(40, '박미희', '01078379430', 0, '1990-02-09', '서울 노원구 초안산로 12 인덕대학교 40'),
(41, '권해미', '010145 7190', 0, '1990-02-10', '서울 노원구 초안산로 12 인덕대학교 41'),
(42, '이성민', '01002544347', 0, '1990-02-11', '서울 노원구 초안산로 12 인덕대학교 42'),
(43, '정다슬', '01036347019', 1, '1990-02-12', '서울 노원구 초안산로 12 인덕대학교 43'),
(44, '육이호', '01092343917', 0, '1990-02-13', '서울 노원구 초안산로 12 인덕대학교 44'),
(45, '한재우', '01193247558', 0, '1990-02-14', '서울 노원구 초안산로 12 인덕대학교 45'),
(46, '정승국', '01023345788', 0, '1990-02-15', '서울 노원구 초안산로 12 인덕대학교 46'),
(47, '양호승', '01083945545', 0, '1990-02-16', '서울 노원구 초안산로 12 인덕대학교 47'),
(48, '윤상현', '01034655978', 0, '1990-02-17', '서울 노원구 초안산로 12 인덕대학교 48'),
(49, '최미문', '01024365634', 0, '1990-02-18', '서울 노원구 초안산로 12 인덕대학교 49'),
(50, '시국진', '01021243572', 0, '1990-02-19', '서울 노원구 초안산로 12 인덕대학교 50'),
(53, '가나나', '00011111111', 1, '1111-11-11', '11'),
(54, '가나나', '00011111111', 0, '2000-11-11', '11');

-- --------------------------------------------------------

--
-- 테이블 구조 `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) DEFAULT NULL,
  `pwd` varchar(20) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `tel` varchar(11) DEFAULT NULL,
  `zip` varchar(5) DEFAULT NULL,
  `juso` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gubun` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- 테이블의 덤프 데이터 `member`
--

INSERT INTO `member` (`id`, `uid`, `pwd`, `name`, `tel`, `zip`, `juso`, `email`, `birthday`, `gubun`) VALUES
(2, 'asd123', '1234', '테스트', '01056785678', '01668', '서울특별시노원구한글비석로24길27상계약국 11', 'yaho5253@gmail.com', '2020-11-20', 0),
(3, 'induk67', '1231', '아에1', '01078900987', '01878', '서울특별시노원구초안산로12인덕대학 123', 'qwer1234@gamil.com', '2004-09-01', 1),
(4, 'zxc123', '123', '테스트', '01048485858', '01878', '서울특별시노원구초안산로12인덕대학 1212', 'zxc123@gmail.co1', '2023-04-16', 0),
(6, 'asdnkj1230', '0918', '준상유', '01054632343', '06336', '서울특별시강남구개포로619서울강남우체국 11', 'sanss11@naver.com', '2004-09-18', 1),
(15, 'qwer1234', '1234', '루피', '01051515212', '03455', '서울특별시은평구응암로21가길30갈매기회수산 1134', 'einfkas1239@naver.com', '2004-09-09', 0);

-- --------------------------------------------------------

--
-- 테이블 구조 `opt`
--

CREATE TABLE `opt` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- 테이블의 덤프 데이터 `opt`
--

INSERT INTO `opt` (`id`, `name`) VALUES
(2, 'Platform'),
(3, 'Language'),
(4, 'Edition');

-- --------------------------------------------------------

--
-- 테이블 구조 `opts`
--

CREATE TABLE `opts` (
  `id` int(11) NOT NULL,
  `opt_id` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- 테이블의 덤프 데이터 `opts`
--

INSERT INTO `opts` (`id`, `opt_id`, `name`, `price`) VALUES
(1, 2, 'Nintendo Switch', 0),
(2, 2, 'Xbox', 0),
(4, 2, 'PC', 0),
(5, 3, 'English', 0),
(6, 3, '한국어', 0),
(10, 4, 'Deluxe Edition', 15000),
(11, 2, 'PlayStation', 0),
(12, 3, '日本語', 0),
(13, 3, '中文', 0),
(14, 3, 'Français', 0),
(15, 3, 'Deutsch', 0),
(16, 4, 'Ultimate Edition', 30000),
(17, 4, 'Standard Edition', 0);

-- --------------------------------------------------------

--
-- 테이블 구조 `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu` int(11) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `coname` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `opt1` int(11) DEFAULT NULL,
  `opt2` int(11) DEFAULT NULL,
  `contents` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `regday` date DEFAULT NULL,
  `icon_new` tinyint(4) DEFAULT NULL,
  `icon_hit` tinyint(4) DEFAULT NULL,
  `icon_sale` tinyint(4) DEFAULT NULL,
  `discount` tinyint(4) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- 테이블의 덤프 데이터 `product`
--

INSERT INTO `product` (`id`, `menu`, `code`, `name`, `coname`, `price`, `opt1`, `opt2`, `contents`, `status`, `regday`, `icon_new`, `icon_hit`, `icon_sale`, `discount`, `image1`, `image2`, `image3`) VALUES
(3, 4, '오버워치', '오버워치', '블리자드', 0, 2, 3, '오버워치™, 쟁취할 가치가 있는 미래! 오버워치™는 희망적인 미래를 배경으로 펼쳐지며, 언제든지 열려 있고 끊임없이 진화하는 팀 기반 액션 무료 플레이 게임입니다. 플레이어는 5대5 또는 6대6 전장에서 난투를 벌이게 됩니다.', 1, '2026-05-10', 0, 0, 0, 0, '오버워치 1.png', '오버워치 2.jpg', '옵치 3.jpeg'),
(6, 3, '붉은사막', '붉은사막', 'Pearl Abyss', 79800, 4, 3, '파이웰 대륙을 배경으로 펼쳐지는 오픈월드 액션 어드벤쳐 게임, 붉은사막. 여러분은 회색갈기 클리프가 되어, 잃어버린 모든 것을 되찾고 다가오는 위협으로부터 세상을 구하기 위한 여정을 떠나게 됩니다. 광활한 야생, 숨겨진 고대 유적, 신비로운 어비스의 영역을 누비며 싸우고, 탐험하고, 발견하며 자신만의 길을 만들어 가세요.', 1, '2026-05-14', 1, 1, 0, 0, '붉은사막 1.png', '불은사막 2.jpg', '붉사 3.jpeg'),
(7, 4, 'ARC', 'ARC Raiders', 'Embark Studios', 58900, 3, 0, 'ARC Raiders는 아크라 불리는 미지의 머신들에게 침공당한 위험천만한 미래 지구를 배경으로 하는 멀티플레이어 구출 어드벤처 게임입니다.', 1, '2026-05-14', 1, 1, 1, 37, '아크 레이더스 이미지.png', '아크 레이 상세화면.jpg', 'ARC 3.jpeg'),
(8, 3, 'ELDEN', 'ELDEN RING', 'FromSoftware Inc', 64800, 4, 3, '본 게임은 본격적인 다크 판타지 세계를 무대로 한 액션 RPG입니다. 드넓은 필드와 던전 탐험을 통해 미지의 것들을 발견해 보세요. 앞길을 막아서는 난관과 그것을 극복했을 때의 달성감, 그리고 등장인물들의 의도가 교착하는 군상극도 즐기실 수 있습니다.', 1, '2022-02-25', 0, 1, 0, 0, '엘든링 1.jpg', '엘둔링 2.jpg', '엘든링 3.jpeg'),
(9, 4, 'BATTLEGROUNDS', 'PUBG: BATTLEGROUNDS', ' KRAFTON, Inc.', 0, 3, 0, '배틀로얄 유행의 시작이자, 그 정수를 보여준 PUBG: 배틀그라운드를 지금 무료로 플레이하세요! 다양한 맵에 낙하하여 무기와 보급품을 확보하고, 점점 줄어드는 블루존 속에서 끝까지 살아남아 승리를 쟁취하세요.', 1, '2017-12-21', 0, 1, 0, 0, '배그 메인화면 이미지.webp', '배그 2.jpg', '배그 3.jpeg'),
(10, 3, 'Cyberpunk', 'Cyberpunk 2077', 'CD PROJEKT RED', 66000, 2, 3, '사이버펑크 2077은 권력과 돈, 끝없는 신체 개조에 집착하는 어두운 미래의 위험천만한 메갈로폴리스, \'나이트 시티\'를 배경으로 한 오픈 월드 액션 어드벤처 RPG입니다.', 1, '2020-12-10', 0, 0, 1, 20, '사펑 1.jpg', '사펑 2.jpg', '사펑 3.jpeg'),
(11, 3, 'PRAGMATA', 'PRAGMATA', 'CAPCOM Co., Ltd.', 69800, 3, 4, '캡콤이 선보이는 완전 신작 SF 액션 어드벤처 타이틀, 프래그마타. 달에서 조난당한 조사원 휴와 안드로이드 소녀 다이애나, 두 주인공과 함께 폭주한 AI가 지배하는 달 기지를 탐험하며 지구로 돌아갈 방법을 찾으세요.', 1, '2026-04-17', 1, 1, 0, 0, '프레그마타 1.png', '프레그마타 2.jpg', '프마타 3.jpeg'),
(12, 5, 'Forza', 'Forza Horizon 6', 'Playground Games', 78900, 2, 4, 'Forza Horizon이 역대 최대 규모의 오픈 월드 드라이빙 모험을 선사합니다. 550대 이상의 실제 차량을 타고 일본의 숨 막히게 아름다운 풍경을 만나고, Horizon 페스티벌에서 레이싱의 전설이 되어보세요', 1, '2026-05-19', 1, 1, 0, 0, '포르자 호라이즌 1.png', '포르자 호라이즌 2.png', '포르자 3.jpeg'),
(13, 3, 'Redemption 2', 'Red Dead Redemption 2', 'Rockstar Games', 73000, 2, 4, '아서 모건과 반 더 린드 갱단은 도주 중인 무법자입니다. 정부 요원과 현상금 사냥꾼들에게 추격당하는 그들은 살아남기 위해 강도질과 도둑질, 싸움을 거듭하며 미국의 험난한 심장부를 달려 나갑니다.', 1, '2019-12-06', 0, 0, 1, 30, '레데리 1.jpg', '레데리 2.jpg', '레데리 3.jpeg'),
(14, 4, 'Apex', 'Apex 레전드™', 'Respawn', 0, 2, 3, 'Apex 레전드는 Respawn Entertainment에서 제작한 다양한 수상 경력을 자랑하는 무료 플레이 히어로 슈팅 게임입니다. 게임에 계속해서 추가되는 레전드 캐릭터들의 강력한 능력을 마스터하고 깊이 있는 전술적 분대 플레이, 새롭게 진화하는 게임플레이를 지닌 히어로 슈팅과 배틀 로얄의 혁신을 경험하세요.', 1, '2020-11-05', 0, 1, 0, 0, '에펙 1.avif', '에펙 2.jpg', '에펙 3.jpeg'),
(15, 5, 'sims4', 'The Sims™ 4', 'Electronic Arts', 0, 2, 3, '아무런 제약 없는 가상 세계에서 심들을 창조하고 지배하는 전능한 힘을 즐기세요. 강력한 권력을 휘두르며 자유롭고 재미있게 인생을 플레이하세요!', 1, '2014-09-02', 0, 0, 0, 0, '심즈 1.png', '심즈 2.png', '심즈 3.jpeg'),
(16, 3, 'SUBNAUTICA2', '서브노티카 2', ' Unknown Worlds Entertainment', 33700, 3, 4, '서브노티카 2는 언노운 월즈(Unknown Worlds)의 서브노티카 시리즈의 신작으로, 새로운 외계 행성에서 펼쳐지는 수중 생존 어드벤처 게임입니다. 혼자서, 또는 최대 4인 협동 플레이로 기지를 건설하고 도구를 제작하면서 미지의 행성에서 살아남으세요. 바닷속을 탐험하며 그 비밀을 밝혀내세요.', 1, '2026-05-15', 1, 1, 0, 0, '서브노티카 2.png', '서브노티카 1.png', '서브노티카 3.jpeg'),
(17, 4, 'CS2', 'Counter-Strike 2', ' Valve', 0, 3, 4, 'Counter-Strike는 20년이 넘는 시간 동안 전 세계 수백만 명의 플레이어가 모여 수준 높은 경쟁을 펼칠 수 있는 플랫폼을 제공해 왔습니다. 그리고 이제 곧 Counter-Strike 2와 함께 새로운 CS 시대의 막이 열립니다.', 1, '2012-08-22', 0, 1, 0, 0, '카스 1.png', '카스 2.png', '카스 3.jpeg'),
(18, 6, 'Stardew', 'Stardew Valley', 'ConcernedApe', 16000, 2, 3, 'You\'ve inherited your grandfather\'s old farm plot in Stardew Valley. Armed with hand-me-down tools and a few coins, you set out to begin your new life. Can you learn to live off the land and turn these overgrown fields into a thriving home?', 1, '2016-02-27', 0, 1, 0, 0, '스타듀밸리 1.png', '스타듀밸리 2.png', '스타밸리 3.jpeg'),
(19, 4, 'RAINBOW', 'RAINBOW SIX SIEGE', 'Ubisoft', 0, 3, 4, '톰 클랜시의 레인보우식스 시즈는 탁월한 계획과 기술이 승부를 좌우하는 전술적인 정예 팀 기반 슈팅 게임입니다.', 1, '2015-12-02', 0, 0, 0, 0, '레식1.png', '레식2.png', '레식 3.jpeg'),
(20, 3, 'PEAK', 'PEAK', ' Team PEAK', 8400, 2, 3, 'PEAK는 작은 실수 하나가 치명적인 결과를 초래할 수 있는 협동 등반 게임입니다. 혼자서든, 길 잃은 자연 스카우트와 함께든, 신비한 섬에서 구조될 유일한 희망은 중앙에 우뚝 솟은 산을 오르는 것뿐입니다. 당신은 과연 정상에 오를 수 있을까요?', 1, '2025-06-17', 0, 0, 1, 40, '피크1.png', '피크 2.png', '피크 3.jpeg'),
(21, 1, 'Baldurs Gate', 'Baldurs Gate 3', 'Larian Studios', 66000, 3, 4, 'Baldur’s Gate 3 is a story-rich, party-based RPG set in the universe of Dungeons & Dragons, where your choices shape a tale of fellowship and betrayal, survival and sacrifice, and the lure of absolute power.', 1, '2023-08-04', 0, 0, 1, 50, '발게 1.png', '발게2.png', '발더게 3.jpeg'),
(22, 2, 'TEKKEN', 'TEKKEN 8', 'Bandai Namco Entertainment', 49800, 2, 4, '3D 대전 격투 게임의 최고봉 『철권』 시리즈 넘버링 최신작 『철권 8』. 32명 이상의 캐릭터가 격돌. 『철권』 사가가 새로운 막을 연다. 시리즈 사상 최고로 호쾌함이 넘치는 배틀이 여기서 극에 달한다.', 1, '2024-01-26', 0, 0, 1, 40, '철권 1.png', '철권 2.png', '철권 3.jpeg'),
(23, 3, 'GTA', 'Grand Theft Auto V', 'Rockstar Games', 36750, 2, 4, '엔터테인먼트 블록버스터인 Grand Theft Auto V와 Grand Theft Auto 온라인을 경험해 보십시오. 이제 환상적인 비주얼과 더욱 빠른 로딩, 3D 오디오 등과 함께 차세대 수준으로 업그레이드되었으며, GTA 온라인 플레이어를 위한 특별 콘텐츠 또한 마련되어 있습니다.', 1, '2015-04-14', 0, 1, 1, 50, 'gta 1.png', 'gta 2.png', '그타 3.jpeg'),
(24, 6, 'Core Keeper', 'Core Keeper', 'Fireshine Games', 21500, 3, 4, '이 1~8인 플레이어용 채굴 샌드박스 모험 게임에서 여러 생물과 유물, 자원이 가득한 끝없는 동굴을 탐험해 보세요. 채굴, 건축, 전투, 제작, 농사를 즐기며 고대 코어에 얽힌 수수께끼를 풀어보세요.', 1, '2024-08-27', 0, 0, 1, 40, '코어키퍼 1.png', '코어키퍼 2.png', '코어키퍼 3.jpeg'),
(25, 3, 'Once Human', 'Once Human', ' Starry Studio', 0, 2, 3, 'Once Human은 낯선 분위기의 포스트 아포칼립스를 배경으로 삼은 멀티플레이 오픈 월드 생존 게임입니다. 친구들과 힘을 모아 무서운 적을 상대하고, 비밀스러운 음모를 밝히고, 자원을 위해 싸우고, 자신만의 영역을 구축하세요. 한때, 인간에 불과했던 여러분은 이제 세상을 재건할 힘을 갖추게 됩니다.', 1, '2024-07-10', 0, 0, 0, 0, '원스휴먼 1.png', '원스휴먼 2.png', '원휴 3.jpeg'),
(26, 1, 'Limbus Company', 'Limbus Company', ' ProjectMoon', 0, 2, 3, '림버스 컴퍼니의 관리자가 되어 12명의 수감자를 이끌고, 폐쇄된 로보토미 코퍼레이션 지부로 들어가 황금가지를 탈환하세요.', 1, '2023-02-27', 0, 1, 0, 0, '림컴 1.png', '림컴 2.png', '림컴 3.jpeg'),
(27, 2, 'Dead by Daylight', 'Dead by Daylight', ' Behaviour Interactive Inc.', 21500, 3, 4, '10년의 호러. 10년간 돌발적으로 급습한 공포와 아슬아슬한 순간들. 10년의 잔혹한 희생과 짜릿한 탈출. 죽음조차도 피할 수 없는 섬뜩한 악의 영역에 영원히 갇힌 네 명의 생존자는 신경과 재치를 시험하는 잔혹한 게임에서 피에 굶주린 살인마에 맞서 싸워야 합니다. 어느 편에 설지 선택하고 공포 게임 최고의 비대칭 멀티플레이어에서 긴장감과 공포의 세계로 들어가보세요.', 1, '2016-06-14', 0, 0, 0, 0, '데바데 1.jpg', '데바데 2.jpg', '데바데 3.jpeg'),
(28, 2, 'ZZZ', '젠레스 존 제로', ' COGNOSPHERE PTE. LTD.', 0, 2, 3, '〈젠레스 존 제로〉는 HoYoverse의 신작 어반 판타지 ARPG입니다. 플레이어는 「로프꾼」이 되어 다양한 「에이전트」들과 함께 공동을 탐색하며 적을 쓰러트리고, 임무를 완수하며 뉴에리두 배후에 숨겨진 이야기를 파헤치게 됩니다.', 1, '2026-06-18', 0, 0, 0, 0, 'zzz 1.jpg', 'zzz 2.jpg', 'zzz 3.jpeg'),
(29, 2, 'Monster Hunter Wilds', 'Monster Hunter Wilds', 'CAPCOM Co., Ltd.', 84800, 0, 0, '거칠고 치열한 자연의 습격. 시시각각 역동적으로 그 모습을 바꾸는 필드. 양면성을 지닌 세계를 살아가는 몬스터와 사람들의 이야기. 더욱더 발전한 헌팅 액션과 끊임없는 몰입감을 추구하는 궁극의 사냥 체험이 당신을 기다리고 있다.', 1, '2025-02-28', 0, 0, 1, 40, '몬헌 1.jpg', '몬헌 2.jpg', '몬헌 3.jpeg'),
(30, 1, '데이브 더 다이버', '데이브 더 다이버', ' MINTROCKET', 12000, 3, 4, '데이브와 동료들의 모험은 정글로 이어집니다!\r\n\r\n데이브와 동료들은 블루홀을 떠나 우타라 마을에서 발생한 이상 현상을 조사하러 정글로 떠나게 됩니다. 호수 속의 새로운 생태계와 새로운 미션, 10시간 이상의 신규 스토리와 새로운 게임 플레이를 담은 데이브 더 다이버 - 인 더 정글 Contents Pack은 새로운 시스템, 새로운 지역에서 두근거리는 신선한 모험을 소개합니다.', 1, '2026-06-18', 1, 1, 0, 0, '데더다 1.jpg', '데더다 2.jpg', '데더다 3.jpeg'),
(31, 1, '디아블로', '디아블로® IV', ' Blizzard Entertainment, Inc.', 62400, 3, 4, '궁극의 액션 RPG 모험, 디아블로® IV에서 성역을 위한 전투에 참여하십시오. 높은 평가를 받은 캠페인과 신규 시즌 콘텐츠를 경험하십시오.', 1, '2023-10-18', 0, 0, 0, 0, '디아블로 1.jpg', '디아블 2.jpg', '디아블 3.jpeg'),
(32, 5, 'Palworld', 'Palworld / 팰월드', 'Pocketpair', 32000, 3, 4, '드넓은 세계에 서식하는 신비한 생물 \"팰\"을 수집하여 전투, 건축, 농업에 투입하거나 공장에서 일을 시키는 등, 전에 없던 새로운 체험을 선사하는 멀티 지원 오픈월드 서바이벌 크래프트 게임입니다.', 1, '2026-06-18', 0, 1, 0, 0, '팰월드 1.jpg', '팰월드 2.jpg', '팰월드 3.jpeg'),
(33, 4, 'RimWorld', 'RimWorld', ' Ludeon Studios', 37500, 3, 4, '지능형 AI 이야기꾼이 주도하는 공상과학 정착지 시뮬레이터입니다. 심리, 생태, 총격전과 근접전, 날씨, 기후, 외교, 사람 사이의 관계, 예술, 의학, 무역, 그 외 많은 것들을 시뮬레이션하여 이야기를 생성합니다', 1, '2018-10-17', 0, 1, 0, 0, '림월드 1.jpg', '림월드 2.jpg', '림월드 3.jpeg'),
(34, 5, '쥬라기', '쥬라기 월드 에볼루션 3', 'Frontier Developments', 63000, 2, 4, '완전히 새로운 여러분만의 쥬라기 월드를 만들어 보세요. 여러 아성체의 등장과 함께 경외심을 불러일으키는 공룡 세대를 길러내고, 전 세계에 뻗어나가는 고생물 공원을 만들고 관리하며, 강력한 신규 창작 옵션으로 상상력을 마음껏 발휘해 보세요.', 1, '2025-10-21', 0, 0, 1, 33, '쥬라 1.jpg', '쥬라 2.jpg', '쥬라 3.jpeg'),
(35, 5, 'inZOI', 'inZOI (인조이)', 'KRAFTON, Inc.', 45000, 3, 4, '\"Every life becomes a story\" 원하는 대로 \'조이\'들의 삶을 조작하고 지켜보며 자신만의 이야기를 만들어보세요. 자유롭고 손쉬운 커스터마이징으로 캐릭터와 건축 등 꿈꾸던 삶의 모습을 창조하고, 디테일한 시뮬레이션 속에서 발생하는 다양한 사건을 마주하며 삶의 희로애락을 경험할 수 있습니다.\r\n', 1, '2025-03-28', 0, 1, 0, 0, '인조이 1.jpg', '인조이 2.jpg', '인조이 3.jpeg'),
(36, 6, 'Slay the Spire 2', 'Slay the Spire 2', ' Mega Crit', 27000, 2, 3, '로그라이크 덱 빌딩 게임의 상징이 돌아왔습니다! 슬레이 더 스파이어 2에서 독창적인 덱을 만들고, 괴이한 생명체들과 조우하며, 엄청난 힘을 가진 유물을 발견하세요.', 1, '2026-03-06', 0, 1, 0, 0, '슬더스 1.jpg', '슬더스 2.jpg', '슬더스 3.jpeg');

-- --------------------------------------------------------

--
-- 테이블 구조 `sj`
--

CREATE TABLE `sj` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `kor` int(11) DEFAULT NULL,
  `eng` int(11) DEFAULT NULL,
  `mat` int(11) DEFAULT NULL,
  `hap` int(11) DEFAULT NULL,
  `avg` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- 테이블의 덤프 데이터 `sj`
--

INSERT INTO `sj` (`id`, `name`, `kor`, `eng`, `mat`, `hap`, `avg`) VALUES
(1, '홍길동', 90, 86, 92, 268, 89.3),
(2, '전미재', 80, 83, 95, 258, 86),
(3, '김양호', 86, 91, 86, 263, 87.7),
(4, '문성진', 90, 87, 69, 246, 82),
(5, '김자완', 95, 86, 93, 274, 91.3),
(6, '오당식', 95, 84, 95, 274, 91.3),
(7, '조성훈', 92, 86, 95, 273, 91),
(8, '박장우', 84, 83, 85, 252, 84),
(9, '지송범', 80, 83, 84, 247, 82.3),
(10, '최미도', 75, 80, 86, 241, 80.3),
(11, '송국영', 84, 84, 95, 263, 87.7),
(12, '염진범', 80, 84, 90, 254, 84.7),
(13, '정아아', 75, 80, 75, 230, 76.7),
(14, '이고석', 79, 82, 83, 244, 81.3),
(15, '심안혜', 83, 83, 89, 255, 85),
(16, '김상민', 85, 85, 91, 261, 87),
(17, '박명수', 93, 83, 95, 271, 90.3),
(18, '김유관', 90, 83, 93, 266, 88.7),
(19, '진수나', 90, 83, 95, 268, 89.3),
(20, '윤정경', 75, 80, 77, 232, 77.3),
(21, '안현철', 82, 82, 87, 251, 83.7),
(22, '민종조', 91, 88, 95, 274, 91.3),
(23, '원우철', 83, 81, 85, 249, 83),
(24, '박규수', 75, 80, 62, 217, 72.3),
(25, '이세철', 80, 83, 87, 250, 83.3),
(26, '곽참만', 82, 83, 89, 254, 84.7),
(27, '한양희', 79, 83, 80, 242, 80.7),
(28, '구박영', 93, 85, 95, 273, 91),
(29, '김사형 ', 19, 82, 74, 175, 58.3),
(30, '이상민', 82, 82, 91, 255, 85),
(31, '강안기', 90, 87, 95, 272, 90.7),
(32, '김장혜', 82, 81, 90, 253, 84.3),
(33, '김정철', 82, 83, 93, 258, 86),
(34, '유요림', 94, 86, 76, 256, 85.3),
(35, '박미기', 90, 84, 95, 269, 89.7),
(36, '김양두', 75, 80, 83, 238, 79.3),
(37, '박상진', 84, 83, 91, 258, 86),
(38, '현잔철', 80, 83, 76, 239, 79.7),
(39, '김진기', 75, 80, 66, 221, 73.7),
(40, '도하진', 93, 84, 95, 272, 90.7),
(41, '윤양국', 80, 82, 70, 232, 77.3),
(42, '김장섭', 80, 82, 91, 253, 84.3),
(43, '구기민', 82, 83, 95, 260, 86.7),
(44, '홍자원', 84, 84, 93, 261, 87),
(45, '오정혜', 92, 83, 87, 262, 87.3),
(46, '김다성', 90, 91, 93, 274, 91.3),
(47, '박정훈', 88, 90, 69, 247, 82.3),
(48, '김오정', 86, 83, 95, 264, 88),
(49, '박청진', 97, 89, 95, 281, 93.7),
(50, '양강현', 90, 85, 79, 254, 84.7),
(55, '가나다', 45, 67, 89, 201, 67);

-- --------------------------------------------------------

--
-- 테이블 구조 `wish`
--

CREATE TABLE `wish` (
  `id` int(11) NOT NULL,
  `member_id` varchar(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `writeday` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `jumun`
--
ALTER TABLE `jumun`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `jumuns`
--
ALTER TABLE `jumuns`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `juso`
--
ALTER TABLE `juso`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `opt`
--
ALTER TABLE `opt`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `opts`
--
ALTER TABLE `opts`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `sj`
--
ALTER TABLE `sj`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `wish`
--
ALTER TABLE `wish`
  ADD PRIMARY KEY (`id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `jumuns`
--
ALTER TABLE `jumuns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- 테이블의 AUTO_INCREMENT `juso`
--
ALTER TABLE `juso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- 테이블의 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 테이블의 AUTO_INCREMENT `opt`
--
ALTER TABLE `opt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `opts`
--
ALTER TABLE `opts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- 테이블의 AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- 테이블의 AUTO_INCREMENT `sj`
--
ALTER TABLE `sj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- 테이블의 AUTO_INCREMENT `wish`
--
ALTER TABLE `wish`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
